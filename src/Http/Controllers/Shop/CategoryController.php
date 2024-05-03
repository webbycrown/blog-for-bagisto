<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webkul\Core\Models\CoreConfig;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThemeCustomizationRepository $themeCustomizationRepository)
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($category_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();

        $category_id = ( $category && isset($category->id) ) ? $category->id : 0;

        $paginate = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_post_per_page');
        $paginate = ( isset($paginate) && !empty($paginate) && is_null($paginate) ) ? (int)$paginate : 9;

        $blogs = Blog::orderBy('id', 'desc')->where('status', 1)
        ->where(
            function ($query) use ($category_id) {
                $query->where('default_category', $category_id)
                ->orWhereRaw('FIND_IN_SET(?, categorys)', [$category_id]);
            })
        ->paginate($paginate);

        $categories = Category::where('status', 1)->get();

        $tags = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        $show_categories_count = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_post_show_categories_with_count');
        $show_tags_count = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_post_show_tags_with_count');
        $show_author_page = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_post_show_author_page');

        $blog_seo_meta_title = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_seo_meta_title');
        $blog_seo_meta_keywords = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_seo_meta_keywords');
        $blog_seo_meta_description = app('Webbycrown\BlogBagisto\Http\Controllers\Shop\BlogController')->getConfigByKey('blog_seo_meta_description');

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'category', 'tags', 'show_categories_count', 'show_tags_count', 'show_author_page', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description'));
    }
    
}
