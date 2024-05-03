<x-admin::layouts>
    <x-slot:title>
        {{ __('Blogs') }}
    </x-slot:title>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            {{ __('Blogs') }}
        </p>

        <div class="flex gap-x-2.5 items-center">
            @if (bouncer()->hasPermission('blog.blogs.create'))
                <a href="{{ route('admin.blog.create') }}">
                    <div class="primary-button">
                        {{ __('Create Blog') }}
                    </div>
                </a>
            @endif
        </div>        
    </div>

    {!! view_render_event('bagisto.admin.catalog.categories.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.blog.index') }}"></x-admin::datagrid>

    {!! view_render_event('bagisto.admin.catalog.categories.list.after') !!}

</x-admin::layouts>