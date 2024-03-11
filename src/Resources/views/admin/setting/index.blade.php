<x-admin::layouts>
    <x-slot:title>
        {{ __('Blog Setting') }}
    </x-slot:title>

    @pushOnce('styles')

        <style type="text/css">
            
            .w-50 {
                width: calc(50% - 4px);
            }
            @media (max-width: 767px) {
              .w-50 {
                width: 100%;
            }  
            .flex-col-box {
                flex-direction: column;
            }
        }
        </style>

    @endPushOnce

    <!-- Blog Setting Form -->
    <x-admin::form
        :action="route('admin.blog.setting.store')"
        method="POST"
        enctype="multipart/form-data"
    >

        {!! view_render_event('admin.blogs.setting.before') !!}

        <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
            <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                {{ __('Blog Setting') }}
            </p>

            <div class="flex gap-x-[10px] items-center">

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >Save Setting</button>
            </div>

        </div>

        <!-- Full Pannel -->
        <div class="flex gap-[10px] mt-[14px] max-xl:flex-wrap">

            <div class="flex flex-wrap flex-col-box gap-[8px] flex-1 max-xl:flex-auto">
            
                <!-- Post Setting Section -->
                <div class="p-[16px] w-50 bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <p class="mb-[16px] text-[16px] text-gray-800 dark:text-white font-semibold">
                        {{ __('Post Setting') }}
                    </p>

                    <div class="mt-8">
                        
                        <!-- Post Per Page Records -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="">
                                {{ __('Per Page Records') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="number"
                                name="blog_post_per_page"
                                id="blog_post_per_page"
                                {{-- rules="required" --}}
                                :value="old('blog_post_per_page') ?? $settings['blog_post_per_page']"
                                label="Per Page Records"
                                placeholder="Per Page Records"
                                min="1"
                            >
                            </x-admin::form.control-group.control>

                            {{-- <x-admin::form.control-group.error control-name="blog_post_per_page"></x-admin::form.control-group.error> --}}

                        </x-admin::form.control-group>
                        
                        <!-- Post Maximum Related Posts Allowed -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="">
                                {{ __('Maximum Related Posts Allowed') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="number"
                                name="blog_post_maximum_related"
                                id="blog_post_maximum_related"
                                {{-- rules="required" --}}
                                :value="old('blog_post_maximum_related') ?? $settings['blog_post_maximum_related']"
                                label="Maximum Related Posts Allowed"
                                placeholder="Maximum Related Posts Allowed"
                                min="1"
                            >
                            </x-admin::form.control-group.control>

                            {{-- <x-admin::form.control-group.error control-name="blog_post_maximum_related"></x-admin::form.control-group.error> --}}

                        </x-admin::form.control-group>
                        
                        <!-- Recent Posts Order By -->
                        {{-- <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="">
                                {{ __('Recent Posts Order By') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="select"
                                name="blog_post_recent_order_by"
                                id="blog_post_recent_order_by"
                                :value="old('blog_post_recent_order_by') ?? $settings['blog_post_recent_order_by']"
                                label="Recent Posts Order By"
                                placeholder="Recent Posts Order By"
                                min="1"
                            >
                                @foreach($post_orders as $post_order_key => $post_order_val)
                                    <option value="{{$post_order_key}}">{{$post_order_val}}</option>
                                @endforeach
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="blog_post_recent_order_by"></x-admin::form.control-group.error>

                        </x-admin::form.control-group> --}}

                        <!-- Show Categories With Posts Count -->
                        <input type="hidden" name="blog_post_show_categories_with_count" id="blog_post_show_categories_with_count" value="@php echo $settings['blog_post_show_categories_with_count'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Show Categories With Posts Count') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_show_categories_with_count = old('blog_post_show_categories_with_count') ?: $settings['blog_post_show_categories_with_count'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="switch_blog_post_show_categories_with_count"
                                id="switch_blog_post_show_categories_with_count"
                                class="cursor-pointer"
                                value="1"
                                label="Show Categories With Posts Count"
                                :checked="(boolean) $blog_post_show_categories_with_count"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Show Tags With Posts Count -->
                        <input type="hidden" name="blog_post_show_tags_with_count" id="blog_post_show_tags_with_count" value="@php echo $settings['blog_post_show_tags_with_count'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Show Tags With Posts Count') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_show_tags_with_count = old('blog_post_show_tags_with_count') ?: $settings['blog_post_show_tags_with_count'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="switch_blog_post_show_tags_with_count"
                                id="switch_blog_post_show_tags_with_count"
                                class="cursor-pointer"
                                value="1"
                                label="Show Tags With Posts Count"
                                :checked="(boolean) $blog_post_show_tags_with_count"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Show Author Page -->
                        <input type="hidden" name="blog_post_show_author_page" id="blog_post_show_author_page" value="@php echo $settings['blog_post_show_author_page'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Show Author Page') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_show_author_page = old('blog_post_show_author_page') ?: $settings['blog_post_show_author_page'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                name="switch_blog_post_show_author_page"
                                id="switch_blog_post_show_author_page"
                                class="cursor-pointer"
                                value="1"
                                label="Show Author Page"
                                :checked="(boolean) $blog_post_show_author_page"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                    </div>

                </div>
                
                <!-- Comment Setting Section -->
                <div class="p-[16px] w-50 bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <p class="mb-[16px] text-[16px] text-gray-800 dark:text-white font-semibold">
                        {{ __('Comment Setting') }}
                    </p>

                    <div class="mt-8">
                        
                        <!-- Enable Post Comment -->
                        <input type="hidden" name="blog_post_enable_comment" id="blog_post_enable_comment" value="@php echo $settings['blog_post_enable_comment'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Enable Post Comment') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_enable_comment = old('blog_post_enable_comment') ?: $settings['blog_post_enable_comment'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                id="switch_blog_post_enable_comment"
                                name="switch_blog_post_enable_comment"
                                class="cursor-pointer"
                                value="1"
                                label="Enable Post Comment"
                                :checked="(boolean) $blog_post_enable_comment"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Allow Guest Comment -->
                        <input type="hidden" name="blog_post_allow_guest_comment" id="blog_post_allow_guest_comment" value="@php echo $settings['blog_post_allow_guest_comment'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Allow Guest Comment') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_allow_guest_comment = old('blog_post_allow_guest_comment') ?: $settings['blog_post_allow_guest_comment'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                id="switch_blog_post_allow_guest_comment"
                                name="switch_blog_post_allow_guest_comment"
                                class="cursor-pointer"
                                value="1"
                                label="Allow Guest Comment"
                                :checked="(boolean) $blog_post_allow_guest_comment"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        <!-- Enable Comment Moderation -->
                        {{-- <input type="hidden" name="blog_post_enable_comment_moderation" id="blog_post_enable_comment_moderation" value="@php echo $settings['blog_post_enable_comment_moderation'] @endphp">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                {{ __('Enable Comment Moderation') }}
                            </x-admin::form.control-group.label>

                            @php $blog_post_enable_comment_moderation = old('blog_post_enable_comment_moderation') ?: $settings['blog_post_enable_comment_moderation'] @endphp

                            <x-admin::form.control-group.control
                                type="switch"
                                id="switch_blog_post_enable_comment_moderation"
                                name="switch_blog_post_enable_comment_moderation"
                                class="cursor-pointer"
                                value="1"
                                label="Enable Comment Moderation"
                                :checked="(boolean) $blog_post_enable_comment_moderation"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group> --}}

                        <!-- Allowed maximum nested comment level -->
                        <x-admin::form.control-group class="mb-2.5">
                            <x-admin::form.control-group.label class="">
                                {{ __('Allowed maximum nested comment level') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="number"
                                name="blog_post_maximum_nested_comment"
                                id="blog_post_maximum_nested_comment"
                                {{-- rules="required" --}}
                                :value="old('blog_post_maximum_nested_comment') ?? $settings['blog_post_maximum_nested_comment']"
                                label="Allowed maximum nested comment level"
                                placeholder="Allowed maximum nested comment level"
                                min="2"
                                max="4"
                            >
                            </x-admin::form.control-group.control>

                            {{-- <x-admin::form.control-group.error control-name="blog_post_maximum_nested_comment"></x-admin::form.control-group.error> --}}

                        </x-admin::form.control-group>

                    </div>

                </div>

                <!-- Default Blog SEO Setting Section -->
                <div class="p-[16px] w-50 bg-white dark:bg-gray-900 rounded-[4px] box-shadow">
                    <p class="mb-[16px] text-[16px] text-gray-800 dark:text-white font-semibold">
                        {{ __('Default Blog SEO Setting') }}
                    </p>

                    <div class="mt-8">
                        
                        {{-- Meta Title --}}
                        <x-admin::form.control-group class="mb-[10px]">
                            <x-admin::form.control-group.label>
                                {{ __('Meta Title') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="blog_seo_meta_title"
                                id="blog_seo_meta_title"
                                :value="old('blog_seo_meta_title') ?? $settings['blog_seo_meta_title']"
                                label="Meta Title"
                                placeholder="Meta Title"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        {{-- Meta Keywords --}}
                        <x-admin::form.control-group class="mb-[10px]">
                            <x-admin::form.control-group.label>
                                {{ __('Meta Keywords') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="blog_seo_meta_keywords"
                                id="blog_seo_meta_keywords"
                                :value="old('blog_seo_meta_keywords') ?? $settings['blog_seo_meta_keywords']"
                                label="Meta Keywords"
                                placeholder="Meta Keywords"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                        {{-- Meta Description --}}
                        <x-admin::form.control-group class="mb-[10px]">
                            <x-admin::form.control-group.label>
                                {{ __('Meta Description') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                name="blog_seo_meta_description"
                                id="blog_seo_meta_description"
                                :value="old('blog_seo_meta_description') ?? $settings['blog_seo_meta_description']"
                                label="Meta Description"
                                placeholder="Meta Description"
                            >
                            </x-admin::form.control-group.control>
                        </x-admin::form.control-group>

                    </div>

                </div>

                <v-wc-custom-js></v-wc-custom-js>

            </div>

        </div>

        {!! view_render_event('admin.blogs.setting.after') !!}

    </x-admin::form>

@pushOnce('scripts')
    {{-- SEO Vue Component Template --}}
    <script type="text/x-template" id="v-wc-custom-js-template">
        
    </script>

    <script type="module">
        app.component('v-wc-custom-js', {
            template: '#v-wc-custom-js-template',

            data() {
                return {
                    
                }
            },

            mounted() {
                let self = this;
                
                document.getElementById('switch_blog_post_show_categories_with_count').addEventListener('change', function(e) {
                    document.getElementById('blog_post_show_categories_with_count').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });
                
                document.getElementById('switch_blog_post_show_tags_with_count').addEventListener('change', function(e) {
                    document.getElementById('blog_post_show_tags_with_count').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });
                
                document.getElementById('switch_blog_post_show_author_page').addEventListener('change', function(e) {
                    document.getElementById('blog_post_show_author_page').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });
                
                document.getElementById('switch_blog_post_enable_comment').addEventListener('change', function(e) {
                    document.getElementById('blog_post_enable_comment').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });
                
                document.getElementById('switch_blog_post_allow_guest_comment').addEventListener('change', function(e) {
                    document.getElementById('blog_post_allow_guest_comment').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });
                
                document.getElementById('switch_blog_post_enable_comment_moderation').addEventListener('change', function(e) {
                    document.getElementById('blog_post_enable_comment_moderation').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                });

            },
        });
    </script>
@endPushOnce

</x-admin::layouts>