<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Models\Comment;
use Webkul\Core\Models\CoreConfig;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
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
    public function index()
    {
        $paginate = $this->getConfigByKey('blog_post_per_page');
        $paginate = ( isset($paginate) && !empty($paginate) && is_null($paginate) ) ? (int)$paginate : 9;

        $blogs = Blog::where('status', 1)->orderBy('id', 'desc')->paginate($paginate);

        $categories = Category::where('status', 1)->get();

        $tags = $this->getTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        $show_categories_count = $this->getConfigByKey('blog_post_show_categories_with_count');
        $show_tags_count = $this->getConfigByKey('blog_post_show_tags_with_count');
        $show_author_page = $this->getConfigByKey('blog_post_show_author_page');

        $blog_seo_meta_title = $this->getConfigByKey('blog_seo_meta_title');
        $blog_seo_meta_keywords = $this->getConfigByKey('blog_seo_meta_keywords');
        $blog_seo_meta_description = $this->getConfigByKey('blog_seo_meta_description');

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'tags', 'show_categories_count', 'show_tags_count', 'show_author_page', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description'));
    }

    public function authorPage($author_id)
    {
        $show_author_page = $this->getConfigByKey('blog_post_show_author_page');
        if ( (int)$show_author_page != 1 ) {
            abort(404);
        }

        $author_data = Blog::where('author_id', $author_id)->firstOrFail();

        $paginate = $this->getConfigByKey('blog_post_per_page');
        $paginate = ( isset($paginate) && !empty($paginate) && is_null($paginate) ) ? (int)$paginate : 9;

        $blogs = Blog::where('author_id', $author_id)->where('status', 1)->orderBy('id', 'desc')->paginate($paginate);

        $categories = Category::where('status', 1)->get();

        $tags = $this->getTagsWithCount();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        $show_categories_count = $this->getConfigByKey('blog_post_show_categories_with_count');
        $show_tags_count = $this->getConfigByKey('blog_post_show_tags_with_count');
        $show_author_page = $this->getConfigByKey('blog_post_show_author_page');

        $blog_seo_meta_title = $this->getConfigByKey('blog_seo_meta_title');
        $blog_seo_meta_keywords = $this->getConfigByKey('blog_seo_meta_keywords');
        $blog_seo_meta_description = $this->getConfigByKey('blog_seo_meta_description');

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations', 'tags', 'author_data', 'show_categories_count', 'show_tags_count', 'show_author_page', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function view($blog_slug, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $blog_id = ( $blog && !empty($blog) && !is_null($blog) ) ? (int)$blog->id : 0;

        $blog_tags = Tag::whereIn('id', explode(',',$blog->tags))->get();

        $paginate = $this->getConfigByKey('blog_post_maximum_related');
        $paginate = ( isset($paginate) && !empty($paginate) && is_null($paginate) ) ? (int)$paginate : 4;

        $blog_category_ids = array_merge( explode(',', $blog->default_category), explode(',', $blog->categorys) );

        $related_blogs = Blog::orderBy('id', 'desc')->where('status', 1)->whereNotIn('id', [$blog_id]);
        if ( is_array($blog_category_ids) && !empty($blog_category_ids) && count($blog_category_ids) > 0 ) {
            $related_blogs = $related_blogs->whereIn('default_category', $blog_category_ids)->where(
            function ($query) use ($blog_category_ids) {
                foreach ($blog_category_ids as $key => $blog_category_id) {
                    if ( $key == 0 ) {
                        $query->whereRaw('FIND_IN_SET(?, categorys)', [$blog_category_id]);
                    } else {
                        $query->orWhereRaw('FIND_IN_SET(?, categorys)', [$blog_category_id]);
                    }
                }
            });
        }
        $related_blogs = $related_blogs->paginate($paginate);

        $categories = Category::where('status', 1)->get();

        $tags = $this->getTagsWithCount();
        
        $comments = $this->getCommentsRecursive($blog_id);

        $total_comments = Comment::where('post', $blog_id)->where('status', 2)->get();

        $total_comments_cnt = ( !empty( $total_comments ) && count( $total_comments ) > 0 ) ? $total_comments->count() : 0;

        $loggedIn_user_name = $loggedIn_user_email = null;
        $loggedIn_user = auth()->guard('customer')->user();
        if ( $loggedIn_user && isset($loggedIn_user) && !empty($loggedIn_user) && !is_null($loggedIn_user) ) {
            $loggedIn_user_email = ( isset($loggedIn_user->email) && !empty($loggedIn_user->email) && !is_null($loggedIn_user->email) ) ? $loggedIn_user->email : null;
            $loggedIn_user_first_name = ( isset($loggedIn_user->first_name) && !empty($loggedIn_user->first_name) && !is_null($loggedIn_user->first_name) ) ? $loggedIn_user->first_name : null;
            $loggedIn_user_last_name = ( isset($loggedIn_user->last_name) && !empty($loggedIn_user->last_name) && !is_null($loggedIn_user->last_name) ) ? $loggedIn_user->last_name : null;
            $loggedIn_user_name = $loggedIn_user_first_name;
            $loggedIn_user_name = ( isset($loggedIn_user_name) && !empty($loggedIn_user_name) && !is_null($loggedIn_user_name) ) ? ( $loggedIn_user_name . ' ' . $loggedIn_user_last_name ) : $loggedIn_user_last_name;
        }

        $show_categories_count = $this->getConfigByKey('blog_post_show_categories_with_count');
        $show_tags_count = $this->getConfigByKey('blog_post_show_tags_with_count');
        $show_author_page = $this->getConfigByKey('blog_post_show_author_page');
        $enable_comment = $this->getConfigByKey('blog_post_enable_comment');
        $allow_guest_comment = $this->getConfigByKey('blog_post_allow_guest_comment');
        $maximum_nested_comment = $this->getConfigByKey('blog_post_maximum_nested_comment');

        $blog_seo_meta_title = $this->getConfigByKey('blog_seo_meta_title');
        $blog_seo_meta_keywords = $this->getConfigByKey('blog_seo_meta_keywords');
        $blog_seo_meta_description = $this->getConfigByKey('blog_seo_meta_description');

        return view($this->_config['view'], compact('blog', 'categories', 'tags', 'comments', 'total_comments', 'total_comments_cnt', 'related_blogs', 'blog_tags', 'show_categories_count', 'show_tags_count', 'show_author_page', 'enable_comment', 'allow_guest_comment', 'maximum_nested_comment', 'loggedIn_user', 'loggedIn_user_name', 'loggedIn_user_email', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description'));
    }

    public function getTagsWithCount()
    {
        $blogTags = Blog::select('*')->get()->pluck('tags')->toarray();
        $allBlogTags_arr = explode(',', implode(',', $blogTags));
        $allBlogTags_arr = ( !empty($allBlogTags_arr) && count($allBlogTags_arr) > 0 ) ? $allBlogTags_arr : array();
        $allBlogTags_arr_el_count = array_count_values($allBlogTags_arr);
        $tags = Tag::where('status', 1)->get()->each(function ($item) use ($allBlogTags_arr, $allBlogTags_arr_el_count) {
            $item->count = 0;
            $tag_id = ( $item && isset($item->id) && !empty($item->id) && !is_null($item->id) ) ? (int)$item->id : 0;
            if (count($allBlogTags_arr_el_count) > 0 && (int)$tag_id > 0) {
                $item->count = ( array_key_exists($tag_id, $allBlogTags_arr_el_count) ) ? (int)$allBlogTags_arr_el_count[$tag_id] : 0;
            }
        });

        return $tags;
    }

    public function getCommentsRecursive($blog_id = 0, $parent_id = 0)
    {
        $comments_datas = array();

        $comments_details = Comment::where('post', $blog_id)->where('parent_id', $parent_id)->where('status', 2)->get();
        if ( !empty($comments_details) && count($comments_details) > 0 ) {
            $comments_datas = $comments_details->toarray();
            if ( !empty($comments_datas) && count($comments_datas) > 0 ) {
                foreach ($comments_datas as $key => $comments_data) {
                    $comments_datas[$key]['replay'] = $this->getCommentsRecursive($blog_id, $comments_data['id']);
                }
            }
        }

        return $comments_datas;
    }

    public function getConfigByKey($code = '')
    {
        $config_val = null;
        if ( isset($code) && !empty($code) && !is_null($code) ) {
            $config = CoreConfig::where('code', $code)->first();
            if ( $config ) {
                $config_val = $config->value;
            }
        }
        return $config_val;
    }
    
}
