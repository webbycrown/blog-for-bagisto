@foreach( $comment_data as $comment )

    <div id="comment-{{ $comment['id'] }}" class="media">
        <img src="https://demo.thewebtech.co.in/vendor/blog/images/user.png" width="50" height="50" class="mr-3 rounded-circle" style="background-color: rgb(223, 223, 223);">
        <div class="media-body">
            <span class="comment_name">{{ $comment['name'] }}</span>
            <span class="comment_created">{{ date_format(date_create($comment['created_at']), "F j, Y g:i a") }}</span>
            <div class="comment d-inline-block w-100">{!! $comment['comment'] !!}</div>

            @if( $nested_comment_index < $maximum_nested_comment )

                @if( $guest_comment_flag )

                    <button class="btn btn-primary btn-lg btn-reply">Reply</button> 
                    <button class="btn btn-danger btn-lg btn-cancel-reply d-none" style="display: none;">Cancel Reply</button>
                    <div class="row justify-content-center mt-3 d-none comment-form-holder" style="display: none;">
                        <div class="col-md-12">
                            <h3>Leave a comment</h3>
                            <form method="POST" action="{{route('shop.blog.comment.store')}}" class="frmComment comment-form">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment['id'] }}">
                                <input type="hidden" name="post" value="{{ $blog->id }}">
                                <div class="form-row">
                                    <div class="form-group column-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
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

                @endif

                @if( array_key_exists('replay', $comment) && count($comment['replay']) > 0 )
                    @php $nested_comment_index++;  @endphp
                    @include ('blog::shop.comment.list', ['comment_data' => $comment['replay']])
                @endif

            @endif

        </div>
    </div>

@endforeach