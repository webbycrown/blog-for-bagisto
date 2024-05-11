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
use Maatwebsite\Excel\Facades\Excel;
use Webbycrown\BlogBagisto\Import\BlogImport;
use Webbycrown\BlogBagisto\Export\BlogExport;
use Session;

class ImportController extends Controller
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
        $errors_data = array();
        if ( Session::has( 'import_errors' ) ){
            if ( count( Session::get( 'import_errors' ) ) > 0 ) {
                $errors_data = Session::get( 'import_errors' );
                Session::put( 'import_errors', array() );
            }
        }

        return view($this->_config['view'], compact( 'errors_data' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        try{
            $files = request()->file('imoprt_file');
            $import_data_arr = Excel::toArray(new BlogImport(), $files);
            $total = count( $import_data_arr[0] );
            if ( (int)$total > 0 ) {
                $import_data = Excel::import(new BlogImport(), $files);
                return redirect()->back()->with('success', 'Import blog successfully.');
            }
            return redirect()->back()->with('error', 'Uploaded File is Empty.');
        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ['.$e->getMessage().']');
        }

    }

    public function export()
    {
        return Excel::download(new BlogExport(), 'blog.csv');
    }

}
