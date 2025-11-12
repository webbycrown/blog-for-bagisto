<x-admin::layouts>
    <x-slot:title>
        @lang('blog::app.tag.edit-title')
    </x-slot:title>

    @php
        $currentLocale = core()->getRequestedLocale();
    @endphp
    
    <!-- Blog Edit Form -->
    <x-admin::form
        :action="route('admin.blog.tag.update', $tag->id)"
        method="POST"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.blog.tags.edit.before') !!}

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                @lang('blog::app.tag.edit-title')
            </p>

            <div class="flex gap-x-2.5 items-center">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.blog.tag.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                >
                    @lang('admin::app.catalog.categories.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('blog::app.tag.edit-btn-title')
                </button>
            </div>
        </div>

        <!-- Full Pannel -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">

            <!-- Left Section -->
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">

                <!-- General -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                        @lang('admin::app.catalog.categories.create.general')
                    </p>

                    <!-- Locales -->
                    <x-admin::form.control-group.control
                        type="hidden"
                        name="locale"
                        value="en"
                    >
                    </x-admin::form.control-group.control>

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.tag.name')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="name"
                            value="{{ old('name') ?? $tag->name }}"
                            label="{{ trans('blog::app.tag.name') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-bind="field"
                                :class="[errors['{{ 'name' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('blog::app.tag.name') }}"
                                v-slugify-target:slug="setValues"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="name"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Slug -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            @lang('blog::app.tag.slug')
                        </x-admin::form.control-group.label>

                        <v-field
                            type="text"
                            name="slug"
                            value="{{ old('slug') ?? $tag->slug }}"
                            label="{{ trans('blog::app.tag.slug') }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="text"
                                name="slug"
                                id="slug"
                                v-bind="field"
                                :class="[errors['{{ 'slug' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ trans('blog::app.tag.slug') }}"
                                v-slugify-target:slug
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="slug"
                        >
                        </x-admin::form.control-group.error>
                    </x-admin::form.control-group>

                    <!-- Description -->
                    <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                        <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                            @lang('blog::app.blog.description-and-images')
                        </p>
                        <v-description>
                            <x-admin::form.control-group class="mb-2.5">
                                <x-admin::form.control-group.label class="required">
                                    @lang('blog::app.tag.description')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    name="description"
                                    id="description"
                                    class="description"
                                    rules="required"
                                    :value="old('description') ?? $tag->description"
                                    :label="trans('blog::app.tag.description')"
                                    :tinymce="true"
                                    :prompt="core()->getConfigData('general.magic_ai.content_generation.category_description_prompt')"
                                    >
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.error
                                control-name="description"
                                >
                            </x-admin::form.control-group.error>
                        </x-admin::form.control-group>
                    </v-description>

                    <div class="flex gap-12">
                        <!-- Add Logo -->
                        <div class="flex flex-col gap-2 w-2/5 mt-5">
                            <p class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.tag.image')
                            </p>

                            <x-admin::media.images 
                            name="image" 
                            :uploaded-images="$tag->image ? [['id' => 'image', 'url' => $tag->image_url]] : []"
                            >

                        </x-admin::media.images>

                    </div>

                </div>

            </div>
        </div>

                <!-- SEO Deatils -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                        @lang('blog::app.tag.search_engine_optimization')
                    </p>

                    <!-- SEO Title & Description Blade Componnet -->
                    {{-- <x-admin::seo/> --}}
                    <v-seo-helper-custom></v-seo-helper-custom>

                    <div class="mt-8">
                        <!-- Meta Title -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_title"
                                id="meta_title"
                                rules="required"
                                :value="old('meta_title') ?? $tag->meta_title"
                                :label="trans('blog::app.blog.meta_title')"
                                :placeholder="trans('blog::app.blog.meta_title')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_title"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>

                        <!-- Meta Keywords -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_keywords')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="meta_keywords"
                                rules="required"
                                :value="old('meta_keywords') ?? $tag->meta_keywords"
                                :label="trans('blog::app.blog.meta_keywords')"
                                :placeholder="trans('blog::app.blog.meta_keywords')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_keywords"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>

                        <!-- Meta Description -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="required">
                                @lang('blog::app.blog.meta_description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="meta_description"
                                id="meta_description"
                                rules="required"
                                :value="old('meta_description') ?? $tag->meta_description"
                                :label="trans('blog::app.blog.meta_description')"
                                :placeholder="trans('blog::app.blog.meta_description')"
                            >
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="meta_description"></x-admin::form.control-group.error>

                        </x-admin::form.control-group>
                    </div>
                </div>

            </div>

            <!-- Right Section -->
            <div class="flex flex-col gap-2 w-[360px] max-w-full">
                <!-- Settings -->

                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-gray-600 dark:text-gray-300 text-base font-semibold">
                            @lang('admin::app.catalog.categories.create.settings')
                        </p>
                    </x-slot:header>

                    <x-slot:content>

                        <!-- Status -->
                        <v-setting-custom></v-setting-custom>
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                @lang('blog::app.tag.status')
                            </x-admin::form.control-group.label>

                            @php $selectedValue_status = old('status') ?: $tag->status @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status_switch"
                                name="status_switch"
                                class="cursor-pointer"
                                value="1"
                                :label="trans('blog::app.tag.status')"
                                :checked="(boolean) $selectedValue_status"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                    </x-slot:content>
                </x-admin::accordion>

                {!! view_render_event('admin.blog.tags.edit.before', ['tag' => $tag]) !!}

            </div>
        </div>

    </x-admin::form>

@pushOnce('scripts')
    {{-- SEO Vue Component Template --}}
    <script type="text/x-template" id="v-setting-custom-template">
        <input type="hidden" name="status" id="status" value="@php echo $tag->status @endphp">
    </script>

    <script type="module">
        app.component('v-setting-custom', {
            template: '#v-setting-custom-template',

            data() {
                return {
                    
                }
            },

            mounted() {
                let self = this;

                document.getElementById('status_switch').addEventListener('change', function(e) {
                    document.getElementById('status').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });

            },
        });
    </script>

@endPushOnce

@pushOnce('scripts')
    {{-- SEO Vue Component Template --}}
    <script type="text/x-template" id="v-seo-helper-custom-template">
        <div class="flex flex-col gap-[3px] mb-[30px]">
            <p 
                class="text-[#161B9D] dark:text-white"
                v-text="metaTitle"
            >
            </p>

            <p 
                class="text-[#161B9D] dark:text-white"
                style="display: none;"
                v-text="metaSlug"
            >
            </p>

            <!-- SEO Meta Title -->
            <p 
                class="text-[#135F29]"
                v-text="'{{ URL::to('/') }}/blog/tag/' + (metaSlug ? metaSlug.toLowerCase().replace(/\s+/g, '-') : '')"
            >
            </p>

            <!-- SEP Meta Description -->
            <p 
                class="text-gray-600 dark:text-gray-300"
                v-text="metaDescription"
            >
            </p>
        </div>
    </script>

    <script type="module">
        app.component('v-seo-helper-custom', {
            template: '#v-seo-helper-custom-template',

            data() {
                return {
                    metaTitle: this.$parent.getValues()['meta_title'],

                    metaDescription: this.$parent.getValues()['meta_description'],

                    metaSlug: this.$parent.getValues()['slug'],
                }
            },

            mounted() {
                let self = this;

                self.metaTitle = document.getElementById('meta_title').value;

                self.metaDescription = document.getElementById('meta_description').value;

                self.metaSlug = document.getElementById('slug').value;

                document.getElementById('meta_title').addEventListener('input', function(e) {
                    self.metaTitle = e.target.value;
                });

                document.getElementById('meta_description').addEventListener('input', function(e) {
                    self.metaDescription = e.target.value;
                });

                document.getElementById('name').addEventListener('input', function(e) {
                    setTimeout(function(){
                        var slug = document.getElementById('slug').value;
                        self.metaSlug = ( slug != '' && slug != null && slug != undefined ) ? slug : '';
                    }, 1000);
                });

                document.getElementById('slug').addEventListener('input', function(e) {
                    var slug = e.target.value;
                    self.metaSlug = ( slug != '' && slug != null && slug != undefined ) ? slug : '';
                });

            },
        });
    </script>

@endPushOnce

</x-admin::layouts>