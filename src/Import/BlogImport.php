<?php

namespace Webbycrown\BlogBagisto\Import;

use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webkul\User\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogImport implements ToModel, WithHeadingRow
{
    use RemembersRowNumber;

    function __construct()
    {
        //
    }
    
    public function model(array $row)
    {
        $import_flag = $this->validation_import_blogs( $row );
        if ( $import_flag == true ) {

            $category_slugs = array_key_exists( 'category_slugs', $row ) 
                                ? array_values( array_filter( array_map( function( $val ) { return str_replace( ' ', '_', trim( $val ) ); }, array_values( array_unique( array_filter( explode( ',', $row[ 'category_slugs' ] ) ) ) ) ) ) )
                                : array();
            $cat_ids = [];
            if ( $category_slugs ) {
                $if_cat_exist = Category::whereIn( 'slug', $category_slugs )->get();
                if ( $if_cat_exist && count( $if_cat_exist ) > 0 ) {
                    $cat_ids = $if_cat_exist->pluck( 'id' )->unique()->toarray();
                }
            }

            $tag_slugs = array_key_exists( 'tag_slugs', $row ) 
                                ? array_values( array_filter( array_map( function( $val ) { return str_replace( ' ', '_', trim( $val ) ); }, array_values( array_unique( array_filter( explode( ',', $row[ 'tag_slugs' ] ) ) ) ) ) ) )
                                : array();
            $tag_ids = [];
            if ( $category_slugs ) {
                $if_tag_exist = Tag::whereIn( 'slug', $tag_slugs )->get();
                if ( $if_tag_exist && count( $if_tag_exist ) > 0 ) {
                    $tag_ids = $if_tag_exist->pluck( 'id' )->unique()->toarray();
                }
            }

            $author = null;
            $author_id = 0;
            if ( is_array( $row ) && array_key_exists( 'author_email', $row ) && isset( $row[ 'author_email' ] ) && !empty( $row[ 'author_email' ] ) && !is_null( $row[ 'author_email' ] ) ) {
                $if_author_exist = Admin::where( 'email', $row[ 'author_email' ] )->first();
                if ( $if_author_exist ) {
                    $author = $if_author_exist->name;
                    $author_id = $if_author_exist->id;
                }
            }

            $import_data = array(
                'name' => isset($row['name']) && $row['name'] != '' ? $row['name'] : '',
                'slug' => isset($row['slug']) && $row['slug'] != '' ? $row['slug'] : '',
                'short_description' => isset($row['short_description']) && $row['short_description'] != '' ? $row['short_description'] : '',
                'description' => isset($row['description']) && $row['description'] != '' ? $row['description'] : '',
                'channels' => 1,
                'default_category' => ( is_array( $cat_ids ) && count( $cat_ids ) > 0 ) ? $cat_ids[0] : 0,
                'categorys' => ( is_array( $cat_ids ) && count( $cat_ids ) > 0 ) ? implode( ',', $cat_ids ) : '',
                'tags' => ( is_array( $tag_ids ) && count( $tag_ids ) > 0 ) ? implode( ',', $tag_ids ) : '',
                'author' => $author,
                'author_id' => $author_id,
                'src' => '',
                'status' => isset($row['status']) && $row['status'] != '' && $row['status'] == 1 ? 1 : 0,
                'locale' => 'en',
                'allow_comments' => isset($row['allow_comments']) && $row['allow_comments'] != '' && $row['allow_comments'] == 1 ? 1 : 0,
                'meta_title' => isset($row['meta_title']) && $row['meta_title'] != '' ? $row['meta_title'] : '',
                'meta_description' => isset($row['meta_description']) && $row['meta_description'] != '' ? $row['meta_description'] : '',
                'meta_keywords' => isset($row['meta_keywords']) && $row['meta_keywords'] != '' ? $row['meta_keywords'] : '',
                'published_at' => isset($row['published_at']) && $row['published_at'] != '' ? $row['published_at'] : '',
            );

            $if_exist = Blog::where('slug', $row['slug'])->first();
            if ($if_exist) {
                unset( $import_data[ 'slug' ] );
                $import_data[ 'src' ] = $this->check_and_upload_file( $row, $if_exist->id );
                Blog::where('slug', $row['slug'])->update( $import_data );
            } else {
                $store_blog = Blog::create( $import_data );
                if ( $store_blog ) {
                    $blog_src = $this->check_and_upload_file( $row, $store_blog->id );
                    Blog::where('id', $store_blog->id )->update([ 'src' => $blog_src ]);
                }
            }

        }
    }

    public function validation_import_blogs( $row = [] )
    {
        $check_data_flag = true;
        if ( !empty( $row ) && count( $row ) > 0 ) {
            $err_data = $messages = [];
            $check_data_flag = true;
            $validation_arr = array(
                'name' => 'required',
                'slug' => 'required',
                'short_description' => 'required',
                'description' => 'required',
                'category_slugs' => 'required',
                'tag_slugs' => 'required',
                'author_email' => 'required|email:rfc,dns',
                // 'image_url' => 'required',
                'status' => 'required|numeric',
                'allow_comments' => 'required|numeric',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
                'published_at' => 'required|date',
            );
            
            $row_number = $this->getRowNumber();

            $validator = Validator::make($row, $validation_arr);
            if ($validator->fails()){
                $message = $validator->errors()->all();
                $messages = $message;
                $check_data_flag = false;
            }

            if ( is_array( $row ) && array_key_exists( 'category_slugs', $row ) && isset( $row[ 'category_slugs' ] ) && !empty( $row[ 'category_slugs' ] ) && !is_null( $row[ 'category_slugs' ] ) ) {
                $check_blog_category_slugs = $this->check_blog_category_slugs( $row );
                if ( is_array( $check_blog_category_slugs ) ) {
                    if ( array_key_exists( 'check_data_flag', $check_blog_category_slugs ) ) {
                        $check_data_flag = $check_blog_category_slugs[ 'check_data_flag' ];
                    }
                    if ( array_key_exists( 'messages', $check_blog_category_slugs ) ) {
                        $messages[] = $check_blog_category_slugs[ 'messages' ];
                    }
                }
            }

            if ( is_array( $row ) && array_key_exists( 'tag_slugs', $row ) && isset( $row[ 'tag_slugs' ] ) && !empty( $row[ 'tag_slugs' ] ) && !is_null( $row[ 'tag_slugs' ] ) ) {
                $check_blog_tag_slugs = $this->check_blog_tag_slugs( $row );
                if ( is_array( $check_blog_tag_slugs ) ) {
                    if ( array_key_exists( 'check_data_flag', $check_blog_tag_slugs ) ) {
                        $check_data_flag = $check_blog_tag_slugs[ 'check_data_flag' ];
                    }
                    if ( array_key_exists( 'messages', $check_blog_tag_slugs ) ) {
                        $messages[] = $check_blog_tag_slugs[ 'messages' ];
                    }
                }
            }

            if ( is_array( $row ) && array_key_exists( 'author_email', $row ) && isset( $row[ 'author_email' ] ) && !empty( $row[ 'author_email' ] ) && !is_null( $row[ 'author_email' ] ) ) {
                $check_author_email = $this->check_author_email( $row );
                if ( is_array( $check_author_email ) ) {
                    if ( array_key_exists( 'check_data_flag', $check_author_email ) ) {
                        $check_data_flag = $check_author_email[ 'check_data_flag' ];
                    }
                    if ( array_key_exists( 'messages', $check_author_email ) ) {
                        $messages[] = $check_author_email[ 'messages' ];
                    }
                }
            }

            $check_image_url = $this->check_and_upload_file( $row, 0, 'check' );
            if ( isset( $check_image_url ) && !empty( $check_image_url ) && !is_null( $check_image_url ) ) {
                $check_data_flag = false;
                $messages[] = $check_image_url;
            }

            $blog_name = array_key_exists( 'name', $row ) ? $row["name"] : null;
            $blog_name = trim( $blog_name );
            $line_no = $row_number . ( ( isset( $blog_name ) && !empty( $blog_name ) ) ? ' [ ' . $blog_name . ' ]' : null );

            if ( $check_data_flag == false ) {
                if ( Session::has( 'import_errors' ) ) {
                    $err_data = Session::get( 'import_errors' );
                }
                if ( $check_data_flag == false ) {
                    $err_data[] = array( 'line_no' => $line_no, 'errors' => $messages );
                    // null row data is not error
                    if( array_filter( $row ) ) {
                        Session::put( 'import_errors', $err_data );
                    } 
                }
            }

        }
        return $check_data_flag;
    }

    public function check_blog_category_slugs( $row = [] )
    {
        $category_ids = array();
        $check_data_flag = false;
        $messages = 'invalid category slugs data';
        if ( is_array( $row ) && count( $row ) > 0 ) {
            $category_slugs = array_key_exists( 'category_slugs', $row ) ? array_values( array_unique( array_filter( explode( ',', $row[ 'category_slugs' ] ) ) ) ) : array();
            if ( is_array( $category_slugs ) && count( $category_slugs ) > 0 ) {
                foreach ( $category_slugs as $category ) {
                    $category_slug = str_replace( ' ', '_', trim( $category ) );
                    if ( isset( $category_slug ) && !empty( $category_slug ) && !is_null( $category_slug ) ) {
                        $if_exist = Category::where( 'slug', $category_slug )->first();
                        if ( $if_exist ) {
                            $category_ids[] = $if_exist->id;
                        } else {
                            $cat_store = Category::create([
                                'name' => ucwords( strtolower( str_replace( "_", " ", $category_slug ) ) ),
                                'slug' => $category_slug,
                                'description' => strtolower( str_replace( "_", " ", $category_slug ) ),
                                'image' => '',
                                'status' => 1,
                                'parent_id' => null,
                                'locale' => 'en',
                                'meta_title' => ucwords( strtolower( str_replace( "_", " ", $category_slug ) ) ),
                                'meta_description' => strtolower( str_replace( "_", " ", $category_slug ) ),
                                'meta_keywords' => strtolower( str_replace( "_", " ", $category_slug ) ),
                            ]);
                            if ( $cat_store ) {
                                $category_ids[] = $cat_store->id;
                            }
                        }
                    }
                }
            }
        }
        if ( is_array( $category_ids ) && count( $category_ids ) > 0 ) {
            $check_data_flag = true;
            $messages = '';
        }
        return array( 'check_data_flag' => $check_data_flag, 'messages' => $messages );
    }

    public function check_blog_tag_slugs( $row = [] )
    {
        $tag_ids = array();
        $check_data_flag = false;
        $messages = 'invalid tag slugs data';
        if ( is_array( $row ) && count( $row ) > 0 ) {
            $tag_slugs = array_key_exists( 'tag_slugs', $row ) ? array_values( array_unique( array_filter( explode( ',', $row[ 'tag_slugs' ] ) ) ) ) : array();
            if ( is_array( $tag_slugs ) && count( $tag_slugs ) > 0 ) {
                foreach ( $tag_slugs as $tag_slug ) {
                    $tag_slug = str_replace( ' ', '_', trim( $tag_slug ) );
                    if ( isset( $tag_slug ) && !empty( $tag_slug ) && !is_null( $tag_slug ) ) {
                        $if_exist = Tag::where( 'slug', $tag_slug )->first();
                        if ( $if_exist ) {
                            $tag_ids[] = $if_exist->id;
                        } else {
                            $tag_store = Tag::create([
                                'name' => ucwords( strtolower( str_replace( "_", " ", $tag_slug ) ) ),
                                'slug' => $tag_slug,
                                'description' => strtolower( str_replace( "_", " ", $tag_slug ) ),
                                'status' => 1,
                                'locale' => 'en',
                                'meta_title' => ucwords( strtolower( str_replace( "_", " ", $tag_slug ) ) ),
                                'meta_description' => strtolower( str_replace( "_", " ", $tag_slug ) ),
                                'meta_keywords' => strtolower( str_replace( "_", " ", $tag_slug ) ),
                            ]);
                            if ( $tag_store ) {
                                $tag_ids[] = $tag_store->id;
                            }
                        }
                    }
                }
            }
        }
        if ( is_array( $tag_ids ) && count( $tag_ids ) > 0 ) {
            $check_data_flag = true;
            $messages = '';
        }
        return array( 'check_data_flag' => $check_data_flag, 'messages' => $messages );
    }

    public function check_author_email( $row = [] )
    {
        $check_data_flag = false;
        $messages = 'invalid author email';
        if ( is_array( $row ) && array_key_exists( 'author_email', $row ) && isset( $row[ 'author_email' ] ) && !empty( $row[ 'author_email' ] ) && !is_null( $row[ 'author_email' ] ) ) {
            $if_author_exist = Admin::where( 'email', $row[ 'author_email' ] )->first();
            if ( $if_author_exist ) {
                $check_data_flag = true;
                $messages = '';
            }
        }
        return array( 'check_data_flag' => $check_data_flag, 'messages' => $messages );
    }

    public function check_and_upload_file( $row = [], $blog_id = 0, $operation = 'upload', $type = 'image_url' )
    {
        $file_path = '';
        $file_flag = false;
        if ( isset( $type ) && !empty( $type ) && !is_null( $type ) && is_array( $row ) && array_key_exists( $type, $row ) && isset( $row[ $type ] ) && !empty( $row[ $type ] ) && !is_null( $row[ $type ] ) ) {

            $file_url = $row[ $type ];
            $file_name = basename( $file_url );
            $file_contents = file_get_contents($file_url);
            if ( strlen($file_contents) > 0 ) {
                if ( $operation == 'upload' ) {
                    $file_path = 'blog-images/' . (int)$blog_id . '/' . $file_name;
                    Storage::put( $file_path, $file_contents );
                }
                $file_flag = true;
            }
            
            if ( $file_flag == false ) {
                $file_path = ( $operation == 'upload' ) ? '' : 'invalid image url';
            }
        }
        return $file_path;
    }

}
