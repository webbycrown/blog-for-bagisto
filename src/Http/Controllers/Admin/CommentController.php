<?php

namespace Webbycrown\BlogBagisto\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webbycrown\BlogBagisto\Datagrids\CommentDataGrid;
use Webbycrown\BlogBagisto\Repositories\BlogCommentRepository;
use Webkul\User\Models\Admin;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Comment;

class CommentController extends Controller
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
    public function __construct(protected BlogCommentRepository $blogCommentRepository)
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
            return app(CommentDataGrid::class)->toJson();
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
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $comment = $this->blogCommentRepository->findOrFail($id);

        $loggedIn_user = auth()->guard('admin')->user()->toarray();
        $user_id = ( array_key_exists('id', $loggedIn_user) ) ? $loggedIn_user['id'] : 0;
        $role = ( array_key_exists('role', $loggedIn_user) ) ? ( array_key_exists('name', $loggedIn_user['role']) ? $loggedIn_user['role']['name'] : 'Administrator' ) : 'Administrator';
        if ( $role != 'Administrator' ) {
            $blogs = Blog::where('author_id', $user_id)->get();
            $post_ids = ( !empty($blogs) && count($blogs) > 0 ) ? $blogs->pluck('id')->toarray() : array();
            $check_comment = Comment::where('id', $id)->whereIn('post', $post_ids)->first();
            if (!$check_comment) {
                return redirect()->route('admin.blog.comment.index');
            }
        }

        $author_name = '';
        $author_id = $comment && isset($comment->author) ? $comment->author : 0;
        if ( (int)$author_id > 0 ) {
            $author_data = Admin::find($author_id);
            $author_name = $author_data && isset($author_data->name) ? $author_data->name : '';
        }

        $status_details = array(
            array( 'id' => 1, 'name' => 'blog::app.comment.status-pending' ),
            array( 'id' => 2, 'name' => 'blog::app.comment.status-approved' ),
            array( 'id' => 0, 'name' => 'blog::app.comment.status-rejected' ),
        );

        return view($this->_config['view'], compact('comment', 'author_name', 'status_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = request()->all();

        $result = $this->blogCommentRepository->updateItem($data, $id);

        if ($result) {
            session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Comment']));
        } else {
            session()->flash('error', trans('blog::app.comment.updated-fault'));
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
        $this->blogCommentRepository->findOrFail($id);

        try {
            $this->blogCommentRepository->delete($id);

            return response()->json(['message' => trans('admin::app.response.delete-success', ['name' => 'Comment'])]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json(['message' => trans('admin::app.response.delete-failed', ['name' => 'Comment'])], 500);
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
                    $this->blogCommentRepository->delete($value);
                } catch (\Exception $e) {
                    $suppressFlash = true;

                    continue;
                }
            }

            if (! $suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'Comment']));
            } else {
                session()->flash('info', trans('admin::app.datagrid.mass-ops.partial-action', ['resource' => 'Comment']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
