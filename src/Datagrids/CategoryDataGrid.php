<?php

namespace Webbycrown\BlogBagisto\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\DataGrid\DataGrid;
use Webbycrown\BlogBagisto\Models\Category;
use Webbycrown\BlogBagisto\Models\Tag;

class CategoryDataGrid extends DataGrid
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
        $queryBuilder = DB::table('blog_categories')
            ->select('id')
            ->addSelect('id', 'name', 'slug', 'status', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'parent_id');

        return $queryBuilder;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('blog::app.datagrid.id'),
            'type'       => 'integer',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('blog::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'parent_id',
            'label'      => 'Parent',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($value) {
                $parent_data = Category::where('id', (int)$value->parent_id)->first();
                $parent_category_name = ( $parent_data && isset($parent_data->name) && !empty($parent_data->name) && !is_null($parent_data->name) ) ? $parent_data->name : '-';
                return $parent_category_name;
            },
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('blog::app.datagrid.status'),
            'type'       => 'boolean',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-success label-active">' . trans('blog::app.category.status-true') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger label-info">' . trans('blog::app.category.status-false') . '</span>';
                }
            },
        ]);
    }

    public function prepareActions()
    {
        if (bouncer()->hasPermission('blog.category.edit')) {
            $this->addAction([
                'title' => 'edit',
                'method' => 'GET',
                'route' => 'admin.blog.category.edit',
                'icon' => 'icon-edit',
                'url'    => function ($row) {
                    return route('admin.blog.category.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('blog.category.delete')) {
            $this->addAction([
                'title' => 'delete',
                'method' => 'POST',
                'route' => 'admin.blog.category.delete',
                'icon' => 'icon-delete',
                'url'    => function ($row) {
                    return route('admin.blog.category.delete', $row->id);
                },
            ]);
        }
    }

    public function prepareMassActions()
    {
        if (bouncer()->hasPermission('blog.category.delete')) {
            $this->addMassAction([
                'type'   => 'delete',
                'label'  => trans('admin::app.datagrid.delete'),
                'title'  => 'Delete',
                'action' => route('admin.blog.category.massdelete'),
                'url' => route('admin.blog.category.massdelete'),
                'method' => 'POST',
            ]);
        }
    }
}
