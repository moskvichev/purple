<div class="ui-block" id="post_{{ $feed->feedable['id'] }}">
    <!-- Пост -->
    {{-- @dd(count($feed->feedable->likes)) --}}
    <article class="hentry post">
        <div class="post__author author vcard inline-items">
            <img  src="{{ Str::startsWith($feed->feedable->postable['avatar'], 'http') ? $feed->feedable->postable['avatar'] : asset($feed->feedable->postable['avatar'])}}" alt="author">
            <div class="author-date">
            <a class="h6 post__author-name fn" href="{{ route(Str::lower(class_basename($feed->feedable->postable)).'.show', $feed->feedable->postable['id']) }}">{{ $feed->feedable->postable['full_name'] }}</a>
                <div class="post__date">
                    <time class="published" datetime="{{ $feed->feedable['created_at'] }}">
                        {{ $feed->feedable['created_at'] }}
                    </time>
                </div>
            </div>
            @can('update', $feed->feedable)
            <div class="more">
                <svg class="olymp-three-dots-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-three-dots-icon') }}"></use>
                </svg>
                <ul class="more-dropdown">
                    <li>
                        <a href="#" class="edit" onclick="event.preventDefault(); editPost({{ $feed->feedable['id'] }});">Редактировать пост</a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); deletePost({{ $feed->feedable['id'] }});">Удалить пост</a>
                    </li>
                </ul>
            </div>
            @endcan
        </div>
        <div id="post_text_{{ $feed->feedable['id'] }}" class="can_edit">
            {!! $feed->feedable['text'] !!}
        </div>
        <div class="post-additional-info inline-items">
        <a href="#" id="like_post_{{ $feed->feedable['id'] }}" data-like_id="{{ $feed->feedable->likes->where('authorable_id', auth()->user()->id)->where('authorable_type', 'App\Models\User')->isNotEmpty() ? $feed->feedable->likes->where('authorable_id', auth()->user()->id)->where('authorable_type', 'App\Models\User')->first()->id : 0 }}" class="post-add-icon inline-items can_like {{ $feed->feedable->likes->where('authorable_id', auth()->user()->id)->where('authorable_type', 'App\Models\User')->isNotEmpty() ? 'like_it' : ''}}" onclick="event.preventDefault(); likeIt({{ $feed->feedable['id'] }}, 'post');">
                <svg class="olymp-heart-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-heart-icon') }}"></use>
                </svg>
                <span>{{ count($feed->feedable->likes) }}</span>
            </a>
            <form  method="POST" id="form_like_post_{{ $feed->feedable['id'] }}">
                @csrf
                <input type="hidden" name="likeable_type" value="App\Models\Post">
                <input type="hidden" name="likeable_id" value="{{ $feed->feedable['id'] }}">
                <input type="hidden" name="authorable_type" value="App\Models\User">
                <input type="hidden" name="authorable_id" value="{{ $comment_author->id }}">
            </form>
            <ul class="friends-harmonic" id="avatars_post_{{ $feed->feedable['id'] }}">
                @foreach ($feed->feedable->likes->slice(-2) as $item)
                <li>
                    <a href="{{ route('user.show', ['user' => $item->authorable['id']]) }}">
                        <img src="{{ asset($item->authorable['avatar']) }}" alt="{{ $item->authorable['full_name'] }}">
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="names-people-likes" id="names_post_{{ $feed->feedable['id'] }}">
                @foreach ($feed->feedable->likes->slice(-2) as $item)
                    <a href="{{ route('user.show', ['user' => $item->authorable['id']]) }}">{{ $item->authorable['name'] }}</a>
                @endforeach
                @if (count($feed->feedable->likes) > 2)
                    и еще
                    <br>{{ count($feed->feedable->likes) - 2 }} человк(а)
                @endif
            </div>
            <div class="comments-shared">
                <a href="#" class="post-add-icon inline-items" onclick="event.preventDefault(); showComments({{ $feed->feedable['id'] }}, 'post');">
                    <svg class="olymp-speech-balloon-icon">
                        <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-speech-balloon-icon') }}"></use>
                    </svg>
                    <span id="comments_count_post_{{ $feed->feedable['id'] }}">{{ count($feed->feedable->comments) }}</span>
                </a>
                <a href="#" class="post-add-icon inline-items">
                    <svg class="olymp-share-icon">
                        <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-share-icon') }}"></use>
                    </svg>
                    <span>4</span>
                </a>
            </div>
        </div>

        <div class="control-block-button post-control-button">

            <a href="#" class="btn btn-control featured-post">
                <svg class="olymp-trophy-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-trophy-icon') }}"></use>
                </svg>
            </a>

            <a href="#" class="btn btn-control">
                <svg class="olymp-like-post-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-like-post-icon') }}"></use>
                </svg>
            </a>

            <a href="#" class="btn btn-control">
                <svg class="olymp-comments-post-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-comments-post-icon') }}"></use>
                </svg>
            </a>

            <a href="#" class="btn btn-control">
                <svg class="olymp-share-icon">
                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-share-icon') }}"></use>
                </svg>
            </a>

        </div>
        <a href="#" id="comments_post_{{ $feed->feedable['id'] }}" class="more-comments" onclick="event.preventDefault(); showComments({{ $feed->feedable['id'] }}, 'post');">Показать комментарии <span>+</span></a>
        @component('user.components.feed.comments',['comments' => $feed->feedable->comments, 'comment_author' => $comment_author, 'feed' => 'post_'.$feed->feedable['id']])@endcomponent
        @component('user.components.feed.write_comment',['comment_author' => $comment_author,'feed' => 'post_'.$feed->feedable['id']])
        @slot('commentable_id')
         {{ $feed->feedable['id'] }}
        @endslot
        @slot('commentable_type')
         App\Models\Post
        @endslot
        @endcomponent



    </article>
</div>
@section('script')

@endsection



<!-- .. окончание Поста -->
                {{-- <li class="comment-item has-children">
                    <div class="post__author author vcard inline-items">
                        <img src="{{ asset('img/spiegel.jpg') }}" alt="author">

                        <div class="author-date">
                            <a class="h6 post__author-name fn" href="#">spiegel</a>
                            <div class="post__date">
                                <time class="published" datetime="2017-03-24T18:18">
                                    1 час назад
                                </time>
                            </div>
                        </div>

                        <a href="#" class="more">
                            <svg class="olymp-three-dots-icon">
                                <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-three-dots-icon') }}"></use>
                            </svg>
                        </a>

                    </div>

                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugiten, sed quia
                        consequuntur magni dolores eos qui ratione voluptatem sequi en lod nesciunt. Neque porro
                        quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur adipisci velit en lorem ipsum der.
                    </p>

                    <a href="#" class="post-add-icon inline-items">
                        <svg class="olymp-heart-icon">
                            <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-heart-icon') }}"></use>
                        </svg>
                        <span>5</span>
                    </a>
                    <a href="#" class="reply">Ответить</a>

                    <ul class="children">
                        <li class="comment-item">
                            <div class="post__author author vcard inline-items">
                                <img src="{{ asset('img/spiegel.jpg') }}" alt="author">

                                <div class="author-date">
                                    <a class="h6 post__author-name fn" href="#">spiegel</a>
                                    <div class="post__date">
                                        <time class="published" datetime="2017-03-24T18:18">
                                            39 минут назад
                                        </time>
                                    </div>
                                </div>

                                <a href="#" class="more">
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-three-dots-icon') }}"></use>
                                    </svg>
                                </a>

                            </div>

                            <p>spiegel spiegel spiegel spiegel spiegel spiegel spiegel</p>

                            <a href="#" class="post-add-icon inline-items">
                                <svg class="olymp-heart-icon">
                                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-heart-icon') }}"></use>
                                </svg>
                                <span>2</span>
                            </a>
                            <a href="#" class="reply">Ответить</a>
                        </li>
                        <li class="comment-item">
                            <div class="post__author author vcard inline-items">
                                <img src="{{ asset('img/spiegel.jpg') }}" alt="author">

                                <div class="author-date">
                                    <a class="h6 post__author-name fn" href="#">spiegel</a>
                                    <div class="post__date">
                                        <time class="published" datetime="2017-03-24T18:18">
                                            24 минут назад
                                        </time>
                                    </div>
                                </div>

                                <a href="#" class="more">
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-three-dots-icon') }}"></use>
                                    </svg>
                                </a>

                            </div>

                            <p>spiegel spiegel spiegel spiegel spiegel</p>

                            <a href="#" class="post-add-icon inline-items">
                                <svg class="olymp-heart-icon">
                                    <use xlink:href="{{ asset('svg-icons/sprites/icons.svg#olymp-heart-icon') }}"></use>
                                </svg>
                                <span>0</span>
                            </a>
                            <a href="#" class="reply">Ответить</a>

                        </li>
                    </ul>

                </li> --}}



