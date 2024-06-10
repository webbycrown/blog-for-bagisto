@php
    $channel = core()->getCurrentChannel();
@endphp


{{-- SEO Meta Content --}}
@push ('meta')
    <meta name="title" content="{{ $blog->meta_title ?? ( $blog_seo_meta_title ?? ( $channel->home_seo['meta_title'] ?? '' ) ) }}" />

    <meta name="description" content="{{ $blog->meta_description ?? ( $blog_seo_meta_keywords ?? ( $channel->home_seo['meta_description'] ?? '' ) ) }}" />

    <meta name="keywords" content="{{ $blog->meta_keywords ?? ( $blog_seo_meta_description ?? ( $channel->home_seo['meta_keywords'] ?? '' ) ) }}" />
@endPush

<x-shop::layouts>
    {{-- Page Title --}}
    <x-slot:title>
        {{ $blog->meta_title ?? ( $blog_seo_meta_title ?? ( $channel->home_seo['meta_title'] ?? '' ) ) }}
    </x-slot>

    @push ('styles')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @include ('blog::custom-css.custom-css')

    @endpush

    <div class="main">
        <div>
            <div class="row col-12 remove-padding-margin">
                <div id="home-right-bar-container" class="col-12 no-padding content">
                    <div class="container-right row no-margin col-12 no-padding">
                        <section class="blog-hero-wrapper">
                            <div class="blog-hero-image">
                                <h1 class="hero-main-title">{{ $blog->name }}</h1>
                                <img
                                    src="{{ '/storage/' . ( ( isset($blog->src) && !empty($blog->src) && !is_null($blog->src) ) ? $blog->src : 'placeholder-banner.jpg' ) }}"
                                    alt="Blanditiis soluta et iste consectetur sapiente nobis ut perferendis fugiat veritatis incidunt dolore."
                                    class="card-img img-fluid img-thumbnail bg-fill">
                            </div>
                        </section>
                        <div id="blog" class="container mt-5">

                            <div class="full-content-wrapper">
                                <div class="flex flex-wrap grid-wrap">
                                    <div class="column-9">
                                        <section class="blog-content">
                                            <div class="text-justify mb-3 blog-post-content">
                                                <h3 class="page-title">{{ $blog->name }}</h3>
                                                <div class="post-tags mb-3">
                                                    <strong>Tags:</strong>
                                                    <div class="post-tag-lists">
                                                        @if( !empty($blog_tags) && count($blog_tags) > 0 )
                                                            @foreach( $blog_tags as $blog_tag )
                                                                <a href="{{route('shop.blog.tag.index',[$blog_tag->slug])}}" class="cat-link">{{$blog_tag->name}}</a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                {!! $blog->description !!}
                                            </div>
                                        </section>
                                    </div>

                                    <sidebar class="column-3 blog-sidebar">
                                        <div class="row">
                                            <div class="col-lg-12 mb-4 categories"><h3>Categories</h3>
                                                <ul class="list-group">
                                                    @foreach($categories as $category)
                                                        <li><a href="{{route('shop.blog.category.index',[$category->slug])}}" class="list-group-item list-group-item-action">
                                                                <span>{{ $category->name }}</span> 
                                                                @if( (int)$show_categories_count == 1 )
                                                                    <span class="badge badge-pill badge-primary">{{ $category->assign_blogs }}</span>
                                                                @endif
                                                        </a></li>
                                                    @endforeach
                                                </ul>

                                                <div class="tags-part">
                                                    <h3>Tags</h3> 
                                                    <div class="tag-list">
                                                        @foreach($tags as $tag)
                                                            <a href="{{route('shop.blog.tag.index',[$tag->slug])}}" role="button" class="btn btn-primary btn-lg">{{ $tag->name }} 
                                                                @if( (int)$show_tags_count == 1 )
                                                                    <span class="badge badge-light">{{ $tag->count }}</span>
                                                                @endif
                                                            </a> 
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </sidebar>
                                </div>
                            </div>

                            <div id="comment-list" class="column-12 comment-part related-bolg-part">
                                <div class="col-lg-12"><h1 class="mb-3 page-title">Related Blog</h1></div>
                                <div class="flex flex-wrap blog-grid-list">

                                    @foreach($related_blogs as $related_blog)
                                        <div class="related-blog-post-item">
                                            <div class="blog-post-box">
                                                <div class="card mb-5">
                                                    <div class="blog-grid-img"><img
                                                        src="{{ '/storage/' . ( ( isset($related_blog->src) && !empty($related_blog->src) && !is_null($related_blog->src) ) ? $related_blog->src : 'placeholder-thumb.jpg' ) }}"
                                                        alt="{{ $related_blog->name }}"
                                                        class="card-img-top">
                                                    </div>
                                                    <div class="card-body">
                                                        <h2 class="card-title"><a href="{{route('shop.article.view',[$related_blog->category->slug . '/' . $related_blog->slug])}}">{{ $related_blog->name }}</a></h2>
                                                        <div class="post-meta">
                                                            <p>
                                                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $related_blog->created_at)->format('M j, Y') }} by
                                                                @if( (int)$show_author_page == 1 )
                                                                    <a href="{{route('shop.blog.author.index',[$related_blog->author_id])}}">{{ $related_blog->author }}</a>
                                                                @else
                                                                    <a>{{ $blog->author }}</a>
                                                                @endif
                                                            </p>
                                                        </div>

                                                        @if( !empty($related_blog->assign_categorys) && count($related_blog->assign_categorys) > 0 )
                                                            <div class="post-categories">
                                                                <p>
                                                                    @foreach($related_blog->assign_categorys as $assign_category)
                                                                        <a href="{{route('shop.blog.category.index',[$assign_category->slug])}}" class="cat-link">{{$assign_category->name}}</a>
                                                                    @endforeach
                                                                </p>
                                                            </div>
                                                        @endif

                                                        <div class="card-text text-justify">
                                                            {!! $related_blog->short_description !!}
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <a href="{{route('shop.article.view',[$related_blog->category->slug . '/' . $related_blog->slug])}}" class="text-uppercase btn-text-link">Read more ></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                
                            </div>

                            @if( (int)$enable_comment == 1 )

                                <div id="comment-list" class="column-12 comment-part">
                                    <div class="row flex flex-wrap grid-wrap">
                                        <div class="column-12">
                                            @if( (int)$blog->allow_comments == 1 )
                                                <h2>Comments ({{ $total_comments_cnt }})</h2> 
                                                <div class="row flex flex-wrap grid-wrap">

                                                    @php

                                                        $guest_comment_flag = false;
                                                        if ( $loggedIn_user ) {
                                                            $guest_comment_flag = true;
                                                        } else {
                                                            if ( (int)$allow_guest_comment == 1 ) {
                                                                $guest_comment_flag = true;
                                                            }
                                                        }

                                                    @endphp

                                                    @if( $guest_comment_flag )

                                                        <div class="column-12">
                                                            <div class="row justify-content-center mt-3 comment-form-holder flex flex-wrap grid-wrap">
                                                                <div class="column-12">
                                                                    <h3>Leave a comment</h3> 
                                                                    <form method="POST" action="{{route('shop.blog.comment.store')}}" class="frmComment comment-form">
                                                                        @csrf
                                                                        <input type="hidden" name="parent_id" value="0">
                                                                        <input type="hidden" name="post" value="{{ $blog->id }}">
                                                                        <div class="form-row">
                                                                            <div class="form-group column-6">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i class="fa fa-user"> </i></span>
                                                                                    </div> 
                                                                                    <input type="text" name="name" placeholder="Your Name" required="required" class="form-control" value="{{ ( isset($loggedIn_user_name) && !empty($loggedIn_user_name) && !is_null($loggedIn_user_name) ) ? $loggedIn_user_name : ''; }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group column-6">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                                                    </div>
                                                                                    <input type="email" name="email" placeholder="Your Email" required="required" class="form-control" value="{{ ( isset($loggedIn_user_email) && !empty($loggedIn_user_email) && !is_null($loggedIn_user_email) ) ? $loggedIn_user_email : ''; }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <textarea name="comment" placeholder="Your Comment" required="required" rows="5" class="form-control"></textarea>
                                                                        </div>
                                                                        <div class="form-group text-right">
                                                                            <button type="submit" class="btn btn-primary btn-lg">Comment</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @else

                                                        <div class="column-12">
                                                            <div class="comment-not-allow-guest">
                                                                You must be logged in to comment. Clik <a href="{{ URL::to('/') }}/customer/login" target="_blank"> here</a> to login.
                                                            </div>
                                                        </div>

                                                    @endif

                                                    @if( !empty( $comments ) && count( $comments ) > 0 )

                                                        @php $nested_comment_index = 0;  @endphp

                                                        <div class="column-12">

                                                            @include ('blog::shop.comment.list', ['comment_data' => $comments])

                                                        </div>
                                                        
                                                    @endif

                                                </div>
                                            @else
                                                <div class="comment-not-allow">Comments are turned off.</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script type="text/javascript">
            
            jQuery(document).on('click', '.btn-reply', function(event) {
                var element = jQuery(this);
                element.parent().find('.comment-form-holder:eq(0)').show();
                element.hide();
                element.next().show();
            });

            jQuery(document).on('click', '.btn-cancel-reply', function(event) {
                var element = jQuery(this);
                element.parent().find('.comment-form-holder:eq(0)').hide();
                element.hide();
                element.prev().show();
            });

        </script>

    @endpush

</x-shop::layouts>
