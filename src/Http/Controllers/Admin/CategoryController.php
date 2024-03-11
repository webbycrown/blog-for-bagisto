<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use Webbycrown\BlogBagisto\Datagrids\CategoryDataGrid;
use Webbycrown\BlogBagisto\Repositories\BlogCategoryRepository;
use Webbycrown\BlogBagisto\Http\Requests\BlogCategoryRequest;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Models\Comment;

class CategoryController extends Controller
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
    public function __construct(protected BlogCategoryRepository $blogCategoryRepository)
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
            return app(CategoryDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $locale = core()->getRequestedLocaleCode();

        $categories = Category::whereNull('parent_id')->where('status', 1)->get();

        return view($this->_config['view'], compact('categories'))->with('locale', $locale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $blogCategoryRequest)
    {
        /*$this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'image.*'               => 'required|mimes:bmp,jpeg,jpg,png,webp',
            'description'           => 'required',
        ]);*/

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }

        $result = $this->blogCategoryRepository->save($data);

        if ($result) {
            session()->flash('success', trans('admin::app.catalog.categories.create-success', ['name' => 'Category']));
        } else {
            session()->flash('success', trans('blog::app.category.created-fault'));
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
        $categories = $this->blogCategoryRepository->findOrFail($id);

        Session::put('bCatEditId', $id);

        $categories_data = Category::whereNull('parent_id')->where('status', 1)->where('id', '!=', $id)->get();
        
        Session::remove('bCatEditId');

        return view($this->_config['view'], compact('categories', 'categories_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryRequest $blogCategoryRequest, $id)
    {
        /*$this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'image'                 => 'required',
            'description'           => 'required',
        ]);*/

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }

        if (is_array($data) && array_key_exists('image', $data) && is_null(request()->image)) {
            session()->flash('error', trans('blog::app.category.updated-fault'));

            return redirect()->back();
        }

        $result = $this->blogCategoryRepository->updateItem($data, $id);

        if ($result) {
            session()->flash('success', trans('admin::app.catalog.categories.update-success', ['name' => 'Category']));
        } else {
            session()->flash('error', trans('blog::app.category.updated-fault'));
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
        $this->blogCategoryRepository->findOrFail($id);

        try {
            $this->blogCategoryRepository->delete($id);

            return response()->json(['message' => trans('admin::app.catalog.categories.delete-success', ['name' => 'Category'])]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json(['message' => trans('admin::app.catalog.categories.delete-failed', ['name' => 'Category'])], 500);
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
            // $indexes = explode(',', request()->input('indices'));
            $indexes = (array)request()->input('indices');

            foreach ($indexes as $key => $value) {
                try {
                    $this->blogCategoryRepository->delete($value);
                } catch (\Exception $e) {
                    $suppressFlash = true;

                    continue;
                }
            }

            if (! $suppressFlash) {
                session()->flash('success', trans('admin::app.catalog.categories.delete-success', ['resource' => 'Category']));
            } else {
                session()->flash('info', trans('admin::app.catalog.categories.delete-failed', ['resource' => 'Category']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.catalog.categories.delete-failed'));

            return redirect()->back();
        }
    }
}
