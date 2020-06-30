@extends('User.Elements.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <div class="ticker-news">
                    <span>Bài Viết Mới</span>
                </div>

                <div class="row">
                    <div class="col-xs-5">
                        @php($firstNewPost = $newPosts->first())
                        @if($firstNewPost->image_thumb)
                            <img src="{{ asset('images/post/' . $firstNewPost->image_thumb) }}" class="w-100">
                        @endif
                        <a href="{{ route('detail_post', $firstNewPost->id) }}" class="color-dark font-weight-bold">
                            {!! $firstNewPost->title !!}
                        </a>
                        <p>{!! $firstNewPost->description_short !!}</p>
                    </div>
                    <div class="col-xs-7">
                        @foreach($newPosts as $key => $newPost)
                            @if($key > 0)
                                <div class="d-flex post-title">
                                    @if($newPost->image_thumb)
                                        <img src="{{ asset('images/post/' . $newPost->image_thumb) }}" class="w-25">
                                    @endif
                                    <a href="{{ route('detail_post', $newPost->id) }}" class="color-dark font-weight-bold">
                                        {!! $newPost->title !!}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="section-title-container">
                    <h3 class="section-title section-title-normal">
                        <span class="section-title-main">Dịch vụ doanh nghiệp</span>
                    </h3>
                    @foreach($posts as $post)
                        <div class="d-flex post-title">
                            @if($post->image_thumb)
                                <img src="{{ asset('images/post/' . $post->image_thumb) }}" class="w-25">
                            @endif
                            <a href="{{ route('detail_post', $post->id) }}" class="color-dark font-weight-bold">
                                {!! $post->title !!}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @foreach($parentCategories as $k => $parentCategory)
            @foreach($parentCategory->childs as $kc => $category)
                @php($firstNewPost = $category->posts->first())
                @isset($firstNewPost)
                <div class="row">
                    <div class="col-xs-9">
                        <div class="ticker-news">
                            <span>{{ $category->name }}</span>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                    @if($firstNewPost->image_thumb)
                                        <img src="{{ asset('images/post/' . $firstNewPost->image_thumb) }}" class="w-100">
                                    @endif
                                    <a href="{{ route('detail_post', $firstNewPost->id) }}" class="color-dark font-weight-bold">
                                        {!! $firstNewPost->title !!}
                                    </a>
                                    <p>{!! $firstNewPost->description_short !!}</p>

                            </div>
                            <div class="col-xs-7">
                                @foreach($category->posts as $key => $newPost)
                                    @if($key > 0)
                                        <div class="d-flex post-title">
                                            @if($newPost->image_thumb)
                                                <img src="{{ asset('images/post/' . $newPost->image_thumb) }}" class="w-25">
                                            @endif
                                            <a href="{{ route('detail_post', $newPost->id) }}" class="color-dark font-weight-bold">
                                                {!! $newPost->title !!}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($k === 0 &&  $kc === 0)
                        <div class="col-xs-3">
                            <div class="section-title-container">
                                <h3 class="section-title section-title-normal">
                                    <span class="section-title-main">Các bài viết mới</span>
                                </h3>
                            </div>
                        </div>
                    @elseif($k === 1 &&  $kc === 0)
                        <div class="col-xs-3">
                            @include('layout.sidebar_right', ['newPosts' => $newPosts])
                        </div>
                    @endif
                </div>
                @endisset
            @endforeach
        @endforeach
    </div>
    <!-- Phonering -->
    <div id="phonering-alo-phoneicon" class="phonering-alo-phone phonering-alo-green phonering-alo-show" >
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <a href="tel:0389710456" class="pps-btn-img" title="Liên hệ">
            <div class="phonering-alo-ph-img-circle gtm_e_callhotline"></div>
        </a>
    </div>
    <a id="phonering-alo-phonenum" href="tel:0389710456" class="gtm_e_callhotline">
        0389.710.456</a>

    <div id="phonering-alo-phoneicon" class="phonering-alo-phone phonering-alo-green phonering-alo-show" >
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <a href="tel:0389710456" class="pps-btn-img" title="Liên hệ">
            <div class="phonering-alo-ph-img-circle gtm_e_callhotline"></div>
        </a>
    </div>
    <!-- Chat zalo -->
{{--    <a id="chat-zalo-fixed" title="chat zalo"  class="gtm_e_callhotline"   href="http://zalo.me/0389710456" >Chat Zalo</a>--}}
    <a id="go-home-fixed" title="Quay về trang chủ" href="{{ route('home') }}" ><i class="fa fa-home"></i></a>

    <!-- Preloader -->
    <div style="display: none;" id="tt-preloader">
        <div style="display: none;" id="pre-status">
            <div class="preload-placeholder"></div>
        </div>
    </div>

    <!-- Scroll-up -->
    <div style="display: none;" class="scroll-up">
        <a href="#banner-section" title="Quay về đầu trang"><i class="fa fa-angle-up"></i></a>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".reply").click(function() {
                if ($(this).closest(".comment-parent").find("form").length == 0) {
                    let comment_id = $(this).data("comment-id");
                    let reply =`<form action="{{ route('reply') }}?comment_id=${comment_id}" method="POST" class="ml-4">@csrf<textarea class="form-control mb-2" name="description" id="" cols="30" rows="2" placeholder="Viết phản hồi..."></textarea><button type="submit" class="btn btn-primary">Trả lời</button><button type="button" class="ml-3 btn btn-secondary btn-close-comment" onclick="removeReply($(this))">Đóng</button></form>`;
                    $(this).closest(".comment-parent").append(reply);
                }
            });
        });
        function removeReply(obj) {
            obj.closest("form").remove();
        }
    </script>
@endsection
