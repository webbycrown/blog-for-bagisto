<?php

namespace Webbycrown\BlogBagisto\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\DataGrid\DataGrid;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;

class BlogDataGrid extends DataGrid
{
    /**
     * Set index columns, ex: id.
     *
     * @var int
     */
    protected $index = 'id';

    /**
     * Default sort order of datagrid.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Locale.
     *
     * @var string
     */
    protected $locale = 'all';

    /**
     * Channel.
     *
     * @var string
     */
    protected $channel = 'all';

    /**
     * Contains the keys for which extra filters to render.
     *
     * @var string[]
     */
    protected $extraFilters = [
        'channels',
        'locales',
    ];

    public function prepareQueryBuilder()
    {
        // $queryBuilder = DB::table('blogs')
        //     ->select('blogs.id','blogs.name', 'blogs.slug', 'blogs.short_description', 'blogs.description', 'blogs.channels',
        //         'blogs.default_category', 'blogs.categorys', 'blogs.published_at',
        //         'category.name as category_name', 'blogs.author',
        //         'blogs.tags', 'blogs.src', 'blogs.status', 'blogs.allow_comments', 'blogs.published_at',
        //         'blogs.meta_title', 'blogs.meta_description', 'blogs.meta_keywords')
        //     ->leftJoin('blog_categories as category', 'blogs.default_category', '=', 'category.id');

        // return $queryBuilder;

        $loggedIn_user = auth()->guard('admin')->user()->toarray();
        $user_id = ( array_key_exists('id', $loggedIn_user) ) ? $loggedIn_user['id'] : 0;
        $role = ( array_key_exists('role', $loggedIn_user) ) ? ( array_key_exists('name', $loggedIn_user['role']) ? $loggedIn_user['role']['name'] : 'Administrator' ) : 'Administrator';

        $queryBuilder = DB::table('blogs');

            if ( $role != 'Administrator' ) {
                $queryBuilder->where('blogs.author_id', $user_id);
            }
            
            $queryBuilder->select('blogs.id','blogs.name', 'blogs.slug', 'blogs.short_description', 'blogs.description', 'blogs.channels',
                'blogs.default_category', 'blogs.categorys', 'blogs.published_at','blogs.author',
                'blogs.tags', 'blogs.src', 'blogs.status', 'blogs.allow_comments', 'blogs.published_at',
                'blogs.meta_title', 'blogs.meta_description', 'blogs.meta_keywords');

        return $queryBuilder;

    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('blog::app.datagrid.id'),
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('blog::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'default_category',
            'label' => trans('blog::app.datagrid.category'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                $categorys = '-';
                $categories_ids = array_values( array_unique( array_merge( explode( ',', $value->default_category ), explode( ',', $value->categorys ) ) ) );
                if ( is_array($categories_ids) && !empty($categories_ids) && count($categories_ids) > 0 ) {
                    $categories = Category::whereIn('id', $categories_ids)->get();
                    $categories_names = ( !empty($categories) && count($categories) > 0 ) ? $categories->pluck('name')->toarray() : array();
                    $categorys = ( !empty($categories_names) && count($categories_names) ) ? implode(', ', $categories_names) : '-';
                }
                return $categorys;
            },
        ]);

        $this->addColumn([
            'index' => 'tags',
            'label' => 'Tags',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                $tags = '-';
                $tags_ids = array_values( array_unique( explode( ',', $value->tags ) ) );
                if ( is_array($tags_ids) && !empty($tags_ids) && count($tags_ids) > 0 ) {
                    $tag_deatils = Tag::whereIn('id', $tags_ids)->get();
                    $tags_names = ( !empty($tag_deatils) && count($tag_deatils) > 0 ) ? $tag_deatils->pluck('name')->toarray() : array();
                    $tags = ( !empty($tags_names) && count($tags_names) ) ? implode(', ', $tags_names) : '-';
                }
                return $tags;
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('blog::app.datagrid.status'),
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-success label-active">' . trans('blog::app.blog.status-true') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger label-info">' . trans('blog::app.blog.status-false') . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index' => 'allow_comments',
            'label' => trans('blog::app.datagrid.allow_comments'),
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                if ($value->allow_comments == 1) {
                    return '<span class="badge badge-md badge-success label-active">' . trans('blog::app.blog.yes') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger label-info">' . trans('blog::app.blog.no') . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index' => 'published_at',
            'label' => 'Published At',
            'type' => 'datetime',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                if ( $value->published_at != '' && $value->published_at != null ) {
                    return date_format( date_create($value->published_at), 'j F, Y' );
                } else {
                    return '-';
                }
            },
        ]);

        $this->addColumn([
            'index' => 'author',
            'label' => 'Author',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

    }

    public function prepareActions()
    {
        if (bouncer()->hasPermission('blog.blogs.edit')) {
            $this->addAction([
                'title' => 'edit',
                'method' => 'GET',
                'icon' => 'icon-edit',
                'route' => 'admin.blog.edit',
                'url'    => function ($row) {
                    return route('admin.blog.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('blog.blogs.delete')) {
            $this->addAction([
                'title' => 'delete',
                'method' => 'POST',
                'icon' => 'icon-delete',
                'route' => 'admin.blog.delete',
                'url'    => function ($row) {
                    return route('admin.blog.delete', $row->id);
                },
            ]);
        }
    }

    public function prepareMassActions()
    {
        if (bouncer()->hasPermission('blog.blogs.delete')) {
            $this->addMassAction([
                'type'   => 'delete',
                'label'  => trans('admin::app.datagrid.delete'),
                'title'  => 'Delete',
                'action' => route('admin.blog.massdelete'),
                'url' => route('admin.blog.massdelete'),
                'method' => 'POST',
            ]);
        }
    }
}