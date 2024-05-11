<x-admin::layouts>
    <x-slot:title>
        {{ __('Blog Import/Export') }}
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

            .main-card .card .card-header {
                background: #c8c1b645;
                color: #fff;
                padding: 14px 20px !important;
            }

            .main-card .card .card-header h4{
                color: #000;
            }

            .main-card .card {
                border-color: #c8c1b645;
            }

            .main-card .card .card-body span {
                color: #000;
            }

            .main-card .card-header h4 {
                color: red;
            }

            .sub-card .card-body span:hover {
                background-color: #fd625e;
                cursor: auto;
            }

            .error-text {
                display: flex;
                cursor: pointer;
                align-items: center;
                -moz-column-gap: .25rem;
                column-gap: .25rem;
                border-radius: .375rem;
                border-width: 1px;
                border-color: #fd625e;
                background-color: #ffffff;
                padding: .375rem .75rem;
                color: #fd625e !important;
                transition-property: all;
                transition-timing-function: cubic-bezier(.4,0,.2,1);
                transition-duration: .15s;
                font-weight: 400;
                font-size: smaller;
            }
            .error-text:hover {
                display: flex;
                cursor: pointer;
                align-items: center;
                -moz-column-gap: .25rem;
                column-gap: .25rem;
                border-radius: .375rem;
                border-width: 1px;
                border-color: #fd625e;
                background-color: #ffffff;
                padding: .375rem .75rem;
                color: #fff !important;
                transition-property: all;
                transition-timing-function: cubic-bezier(.4,0,.2,1);
                transition-duration: .15s;
                font-weight: 400;
                font-size: smaller;
            }

            @media (max-width: 1366px) {
                .wc-grid-responsive {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            @media (max-width: 768px) {
                .wc-grid-responsive {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 575px) {
                .wc-grid-responsive {
                    grid-template-columns: repeat(1, 1fr);
                }
            }

        </style>

    @endPushOnce

    <!-- Blog Import/Export Form -->
    <x-admin::form
        :action="route('admin.blog.import.store')"
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                {{ __('Blog Import/Export') }}
            </p>

            <div class="flex gap-x-2.5 items-center">

                <a 
                    href="{{ route( 'admin.blog.export.download' ) }}" 
                    target="_blank" 
                    class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white"
                ><span class="icon-export text-xl text-gray-600"></span> Export </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                ><span class="icon-import text-xl text-white"></span>Import</button>
            </div>

        </div>

        <!-- Full Pannel -->
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">

            <!-- Import Section -->
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
            
                <!-- Import Section -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="mb-4 text-base text-gray-800 dark:text-white font-semibold">
                        {{ __( 'Import' ) }}
                    </p>

                    <!-- Name -->
                    <x-admin::form.control-group class="mb-2.5">
                        <x-admin::form.control-group.label class="required">
                            {{ __( 'Import File' ) }}
                        </x-admin::form.control-group.label>

                        <v-field
                            type="file"
                            name="imoprt_file"
                            value="{{ old('imoprt_file') }}"
                            label="{{ __( 'Import File' ) }}"
                            rules="required"
                            v-slot="{ field }"
                        >
                            <input
                                type="file"
                                name="imoprt_file"
                                id="imoprt_file"
                                v-bind="field"
                                :class="[errors['{{ 'imoprt_file' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                class="flex w-full min-h-[39px] py-2 px-3 border rounded-md text-sm text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 focus:border-gray-400 dark:focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                placeholder="{{ __( 'Import File' ) }}"
                                accept=".csv"
                            >
                        </v-field>

                        <x-admin::form.control-group.error
                            control-name="imoprt_file"
                        >
                        </x-admin::form.control-group.error>
                        <span class="text-xs">You can upload only csv file and download sample csv file here. <a href="{{ env('APP_URL') . '/storage/blog-sample/sample.csv' }}" target="_blank" class="text-blue-600">Click Here</a></span>
                    </x-admin::form.control-group>

                    @if( count( $errors_data ) > 0 )
                        <div class="card main-card bg-white rounded box-shadow">
                            <div class="card-header p-4 font-semibold" style="background-color: antiquewhite;">
                                <h4 class="card-title mb-0">Import Errors</h4>
                            </div>
                            <div class="card-body p-4 mb-4 w-full" style="height: auto; overflow-y: auto; max-height: 550px;">
                                <div class="grid grid-cols-4 gap-2 wc-grid-responsive">
                                    @foreach( $errors_data as $error_data )
                                        <div class="col-lg-4 bg-white rounded box-shadow">
                                            <div class="card sub-card">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0">{{ $error_data[ 'line_no' ] }}</h4>
                                                </div>
                                                <div class="card-body p-4" style="height: auto; overflow-y: auto; max-height: 200px;">
                                                    @foreach( $error_data[ 'errors' ] as $error )
                                                        @if( isset( $error ) && !empty( $error ) && !is_null( $error ) )
                                                            <span class="error-text mb-2">{{ $error }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>  
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>


        </div>

        <v-wc-custom-js></v-wc-custom-js>

    </x-admin::form>

@pushOnce('scripts')
    
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
                
                // document.getElementById('switch_blog_post_show_categories_with_count').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_show_categories_with_count').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });
                
                // document.getElementById('switch_blog_post_show_tags_with_count').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_show_tags_with_count').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });
                
                // document.getElementById('switch_blog_post_show_author_page').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_show_author_page').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });
                
                // document.getElementById('switch_blog_post_enable_comment').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_enable_comment').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });
                
                // document.getElementById('switch_blog_post_allow_guest_comment').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_allow_guest_comment').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });
                
                // document.getElementById('switch_blog_post_enable_comment_moderation').addEventListener('change', function(e) {
                //     document.getElementById('blog_post_enable_comment_moderation').value = ( e.target.checked == true || e.target.checked == 'true' ) ? 1 : 0;
                // });

            },
        });
    </script>
@endPushOnce

</x-admin::layouts>