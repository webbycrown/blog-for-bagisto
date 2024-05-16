<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop\API\Blogs;

use Illuminate\Routing\Controller;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webkul\User\Models\Admin;
use Carbon\Carbon;

class BlogController extends Controller
{

    /**
     * Retrieves a list of blogs.
     *
     * This function retrieves a list of blogs, presumably from a data source
     * such as a database, API, or other storage mechanism.
     *
     * @return array An array of blogs retrieved from the data source.
     */
    public function list()
    {
        try{
            
            $locale = config('app.locale');

            $req_data = request()->all();
            $blog_slug = ( array_key_exists( 'slug', $req_data ) ) ? $req_data[ 'slug' ] : '';
            $category_slug = ( array_key_exists( 'category', $req_data ) ) ? $req_data[ 'category' ] : '';
            $tag_slug = ( array_key_exists( 'tag', $req_data ) ) ? $req_data[ 'tag' ] : '';
            $search = ( array_key_exists( 's', $req_data ) ) ? $req_data[ 's' ] : '';

            if ( array_key_exists( 'slug', $req_data ) ) {
                if ( !isset( $blog_slug ) || empty( $blog_slug ) || is_null( $blog_slug ) ) {
                    return response()->json([
                        'status_code' => 500,
                        'status' => 'error',
                        'message' => 'blog slug required',
                        'data' => []
                    ],200);
                }
                $blogs = Blog::where( 'slug', $blog_slug )
                ->where('published_at', '<=', Carbon::now()->format('Y-m-d'))
                ->where('status', 1)
                ->where('locale', $locale)
                ->orderBy('id', 'DESC')
                ->first();
            } else {
                $blogs = Blog::where('published_at', '<=', Carbon::now()->format('Y-m-d'))->where('status', 1)->where('locale', $locale);

                if ( isset( $category_slug ) && !empty( $category_slug ) && !is_null( $category_slug ) ) {
                    $category_id = 0;
                    $category = Category::where( 'slug', $category_slug )->where('locale', $locale)->first();
                    if ( $category ) {
                        $category_id = $category->id;
                    }
                    $blogs = $blogs->where(function ($q) use ($category_id) {
                        $q->where( 'default_category', $category_id )->orWhereRaw( 'FIND_IN_SET( ?, categorys )', [ $category_id ] );
                    });
                }

                if ( isset( $tag_slug ) && !empty( $tag_slug ) && !is_null( $tag_slug ) ) {
                    $tag_id = 0;
                    $tag = Category::where( 'slug', $tag_slug )->where('locale', $locale)->first();
                    if ( $tag ) {
                        $tag_id = $tag->id;
                    }
                    $blogs = $blogs->whereRaw( 'FIND_IN_SET( ?, tags )', [ $tag_id ] );
                }

                if ( isset( $search ) && !empty( $search ) && !is_null( $search ) ) {
                    $blogs = $blogs->where(function ($q) use ($search) {
                        $q->where( 'name', 'like', '%' . $search . '%' );
                    });
                }

                $blogs = $blogs->orderBy('id', 'DESC');

                $page = 1;
                $perpage = 12;
                if( request()->get("page_no") ){
                    $page = request()->get("page_no");
                }
                if( request()->get("per_page") ){
                    $perpage = request()->get("per_page");
                }
                $offset = ( $page - 1 ) * $perpage;
                $blogs = $blogs->limit( $perpage )->offset( $offset )->get();

            }
            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'message' => 'get blog successfully',
                'data' => $blogs
            ],200);

        } catch(\Exception $e) {

            return response()->json([
                'status_code' => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ],200);

        }
    }

    /**
     * Retrieves a list of categories.
     *
     * @return array|null Returns an array of categories if found, or null if no categories are available.
     */
    public function category_list()
    {
        try{

            $result = false;
            
            $locale = config('app.locale');

            $blog_categorys = Category::where('status', 1)->where('locale', $locale)->orderBy('id', 'DESC')->get();

            if ( $blog_categorys && count( $blog_categorys ) > 0 ) {
                $result = true;
            }

            return response()->json([
                'message' => 'get blog category successfully',
                'result' => true,
                'data' => $blog_categorys
            ],200);

        } catch(\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'result' => false,
                'data' => null
            ],200);

        }
    }

    /**
     * Retrieve a list of tags associated with the object.
     *
     * @return array An array containing the tags.
     */
    public function tag_list()
    {
        try{

            $result = false;
            
            $locale = config('app.locale');

            $blog_tags = Tag::where('status', 1)->where('locale', $locale)->orderBy('id', 'DESC')->get();

            if ( $blog_tags && count( $blog_tags ) > 0 ) {
                $result = true;
            }

            return response()->json([
                'message' => 'get blog tag successfully',
                'result' => true,
                'data' => $blog_tags
            ],200);

        } catch(\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'result' => false,
                'data' => null
            ],200);

        }
    }

}
