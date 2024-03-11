<x-admin::layouts>
    <x-slot:title>
        {{ __('Blog Tags') }}
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            {{ __('Blog Tags') }}
        </p>

        <div class="flex gap-x-[10px] items-center">
            @if (bouncer()->hasPermission('blog.tag.create'))
                <a href="{{ route('admin.blog.tag.create') }}">
                    <div class="primary-button">
                        {{ __('Create Tag') }}
                    </div>
                </a>
            @endif
        </div>        
    </div>

    {!! view_render_event('bagisto.admin.catalog.categories.list.before') !!}

    <x-admin::datagrid src="{{ route('admin.blog.tag.index') }}"></x-admin::datagrid>

    {!! view_render_event('bagisto.admin.catalog.categories.list.after') !!}

</x-admin::layouts>