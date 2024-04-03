<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class ArticleController extends Controller
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
        $blogs = Blog::where('status', 1)->paginate(9);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        return view($this->_config['view'], compact('blogs', 'categories', 'customizations'));
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

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        return view($this->_config['view'], compact('blog', 'categories'));
    }
}
