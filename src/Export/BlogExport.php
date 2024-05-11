<?php

namespace Webbycrown\BlogBagisto\Export;

use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webkul\User\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\LaravelNovaExcel\Actions\ExportToExcel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use URL;

class BlogExport implements FromCollection, WithHeadings
{

    function __construct()
    {
        //
    }
    public function headings(): array
    {
        return [
            'name',
            'slug',
            'short_description',
            'description',
            'category_slugs',
            'tag_slugs',
            'author_email',
            'image_url',
            'status',
            'allow_comments',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'published_at',
        ];
    }
    public function collection()
    {
        return DB::table( 'blogs' )
        ->select( 
            'name',
            'slug',
            'short_description',
            'description',
            DB::raw( 'CONCAT(default_category, ",", IFNULL(categorys,"")) as category_slugs' ),
            'tags as tag_slugs',
            'author_id as author_email',
            'src as image_url',
            'status',
            'allow_comments',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'published_at' 
        )->get()->each(function ($item) {

            #categorys
            $category_slugs = ( isset( $item->category_slugs ) && !empty( $item->category_slugs ) && !is_null( $item->category_slugs ) ) ? explode( ',', $item->category_slugs) : array();
            $category_slugs_arr = array();
            $if_cat_exist = Category::whereIn( 'id', $category_slugs )->get();
            if ( $if_cat_exist && count( $if_cat_exist ) > 0 ) {
                $category_slugs_arr = $if_cat_exist->pluck( 'slug' )->unique()->toarray();
            }
            $item->category_slugs = ( is_array( $category_slugs_arr ) ) ? implode( ',', $category_slugs_arr ) : '';

            #tags
            $tag_slugs = ( isset( $item->tag_slugs ) && !empty( $item->tag_slugs ) && !is_null( $item->tag_slugs ) ) ? explode( ',', $item->tag_slugs) : array();
            $tag_slugs_arr = array();
            $if_tag_exist = Tag::whereIn( 'id', $tag_slugs )->get();
            if ( $if_tag_exist && count( $if_tag_exist ) > 0 ) {
                $tag_slugs_arr = $if_tag_exist->pluck( 'slug' )->unique()->toarray();
            }
            $item->tag_slugs = ( is_array( $tag_slugs_arr ) ) ? implode( ',', $tag_slugs_arr ) : '';

            #author
            $author_id = ( isset( $item->author_email ) && !empty( $item->author_email ) && !is_null( $item->author_email ) ) ? (int)$item->author_email : 0;
            $item->author_email = '';
            $if_author_exist = Admin::where( 'id', $author_id )->first();
            if ( $if_author_exist ) {
                $item->author_email = $if_author_exist->email;
            }

            #image
            $item->image_url = ( isset( $item->image_url ) && !empty( $item->image_url ) && !is_null( $item->image_url ) ) ? env( 'APP_URL' ) . '/storage/' . $item->image_url : '';
        });
    }
}
