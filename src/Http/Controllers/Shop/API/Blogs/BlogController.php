<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Shop\API\Blogs;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webbycrown\BlogBagisto\Datagrids\BlogDataGrid;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Repositories\BlogRepository;
use Webkul\User\Models\Admin;
use Webbycrown\BlogBagisto\Http\Requests\BlogRequest;

class BlogController extends Controller
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
    public function __construct(protected BlogRepository $blogRepository)
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
        if (request()->ajax()) {
            return app(BlogDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    public function list()
    {
        // return 'Blog API with Swagger!';
        return $this->blogRepository->getActiveBlogs();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $locale = core()->getRequestedLocaleCode();

        $categories = Category::all();

        $tags = Tag::all();

        $users = Admin::all();

        return view($this->_config['view'], compact('categories', 'tags', 'users'))->with('locale', $locale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $blogRequest)
    {
        /*$this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'channels'              => 'required',
            'image.*'               => 'required|mimes:bmp,jpeg,jpg,png,webp',
            'default_category'      => 'required',
        ]);*/

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }

        if (is_array($data['tags'])) {
            $data['tags'] = implode(',', $data['tags']);
        }

        $result = $this->blogRepository->save($data);

        if ($result) {
            session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Blog']));
        } else {
            session()->flash('success', trans('blog::app.blog.created-fault'));
        }

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
        $blog = $this->blogRepository->findOrFail($id);

        $categories = Category::all();

        $tags = Tag::all();

        $users = Admin::all();

        return view($this->_config['view'], compact('blog', 'categories', 'tags', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $blogRequest, $id)
    {
        /*$this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'channels'              => 'required',
            'image'                 => 'required',
            'default_category'      => 'required',
        ]);*/

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }
        
        if (is_array($data['tags'])) {
            $data['tags'] = implode(',', $data['tags']);
        }

        if (is_null(request()->src)) {
            session()->flash('error', trans('blog::app.blog.updated-fault'));

            return redirect()->back();
        }

        $result = $this->blogRepository->updateItem($data, $id);

        if ($result) {
            session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Blog']));
        } else {
            session()->flash('error', trans('blog::app.blog.updated-fault'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blogRepository->findOrFail($id);

        try {
            $this->blogRepository->delete($id);

            return response()->json(['message' => trans('admin::app.response.delete-success', ['name' => 'Blog'])]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json(['message' => trans('admin::app.response.delete-failed', ['name' => 'Blog'])], 500);
    }

    /**
     * Remove the specified resources from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            // $indexes = explode(',', request()->input('indexes'));
            $indexes = (array)request()->input('indices');

            foreach ($indexes as $key => $value) {
                try {
                    $this->blogRepository->delete($value);
                } catch (\Exception $e) {
                    $suppressFlash = true;

                    continue;
                }
            }

            if (! $suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'Blog']));
            } else {
                session()->flash('info', trans('admin::app.datagrid.mass-ops.partial-action', ['resource' => 'Blog']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
