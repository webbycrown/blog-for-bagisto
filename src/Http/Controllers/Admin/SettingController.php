<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\User\Models\Admin;
use Webkul\Core\Models\CoreConfig;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Comment;

class SettingController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $post_orders = array(
            'recent' => 'Recent',
            'popularity' => 'Popularity',
            'random' => 'Random',
        );

        $config_data_keys = array( 'blog_post_per_page', 'blog_post_maximum_related', 'blog_post_recent_order_by', 'blog_post_show_categories_with_count', 'blog_post_show_tags_with_count', 'blog_post_show_author_page', 'blog_post_enable_comment', 'blog_post_allow_guest_comment', 'blog_post_enable_comment_moderation', 'blog_post_maximum_nested_comment', 'blog_seo_meta_title', 'blog_seo_meta_keywords', 'blog_seo_meta_description' );

        $setting_deatils = $settings = array();
        $setting_datas = CoreConfig::whereIn('code', $config_data_keys)->get();
        if ( !empty($setting_datas) && count($setting_datas) > 0 ) {
            $setting_datas = $setting_datas->toarray();
            foreach ($setting_datas as $setting_data) {
                $setting_deatils[ $setting_data['code'] ] = $setting_data['value'];
            }
        }

        foreach ($config_data_keys as $config_data_key) {
            $settings[ $config_data_key ] = ( array_key_exists($config_data_key, $setting_deatils) ) ? $setting_deatils[ $config_data_key ] : '';
        }

        return view($this->_config['view'], compact('post_orders', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->all();
    
        $config_except_keys = array( 'switch_blog_post_show_categories_with_count', 'switch_blog_post_show_tags_with_count', 'switch_blog_post_show_author_page', 'switch_blog_post_enable_comment', 'switch_blog_post_allow_guest_comment', 'switch_blog_post_enable_comment_moderation' );

        if ( !empty($data) && count($data) > 0 ) {
            foreach ( $data as $data_key => $data_value ) {
                if ( !in_array($data_key, $config_except_keys) ) {
                    $CoreConfig = CoreConfig::where('code', $data_key)->first();
                    if ( $CoreConfig ) {
                        $CoreConfig->value = $data_value;
                    } else {
                        $CoreConfig = new CoreConfig();
                        $CoreConfig->code = $data_key;
                        $CoreConfig->value = $data_value;
                    }
                    $CoreConfig->save();
                }
            }
        }
        session()->flash('success', 'Save Blog Setting Successfully');
        return redirect()->route($this->_config['redirect']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resources from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        //
    }

}
