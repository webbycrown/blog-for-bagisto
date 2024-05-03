<x-admin::layouts>
    <x-slot:title>
        {{ __('Blog Categories') }}
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            {{ __('Blog Categories') }}
        </p>

        <div class="flex gap-x-2.5 items-center">
            @if (bouncer()->hasPermission('blog.category.create'))
                <a href="{{ route('admin.blog.category.create') }}">
                    <div class="primary-button">
                        {{ __('Create Category') }}
                    </div>
                </a>
            @endif
        </div>        
    </div>

    {!! view_render_event('bagisto.admin.catalog.categories.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.blog.category.index') }}"></x-admin::datagrid>

    {!! view_render_event('bagisto.admin.catalog.categories.list.after') !!}

</x-admin::layouts>