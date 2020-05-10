@extends('layouts.app')
@section('content')
    @php
        $currentUser = \Illuminate\Support\Facades\Auth::guard('user')->user() ?? null;
        if($currentUser){
            $like = $currentUser->like->where('movie_id',$movie->id)->first();
        }
    @endphp
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="col-md-12 watch-poster">
            <div class="col-md-4  watch-main">
                <img src="{{$movie->avatar_url}}" style="width: 100%;height: 250px;" alt=""/>
                <input type="hidden" value="{{$movie->id}}" id="movie_id">
                <div class="watch-more">
                    <a href="{{ route('detail', [$movie->id]) }}">xem them</a>
                </div>
            </div>
            <div class="col-md-8" style="background-color: #01060a">
                <div class="watch-introduce">
                    <span class="title-1">{{$movie->vietnamese_name}}</span>
                    <span class="title-2">{{$movie->native_name}}</span>
                    <div class="watch-content">
                        <span>{{$movie->introduce}}</span>
                    </div>
                </div>
            </div>
            @if(strpos($episode->video_url, 'youtube') > 0)
                <iframe width="100%" height="480" src="{{$episode->video_url}}"></iframe>
            @else
                <video class="afterglow" id="myvideo" width="1280" height="720">
                    @if(!filter_var($episode->video_url, FILTER_VALIDATE_URL))
                        @if($movie->resolution == 'CAM')
                            <source type="video/mp4"
                                    src="{{'/files/uploads/movie/episode/'.$episode->video_url}}"/>
                        @else
                            <source type="video/mp4"
                                    src="{{'/files/uploads/movie/episode/480/'.$episode->video_url}}"/>
                            <source type="video/mp4"
                                    src="{{'/files/uploads/movie/episode/720/'.$episode->video_url}}"
                                    data-quality="hd"/>
                        @endif
                    @else
                        <source type="video/mp4" src="{{$episode->video_url}}"/>
                    @endif
                </video>
            @endif
        </div>

        @if($movie->form == 'Set')
            <div class=" col-md-12 content-div list-episode">
                <h2>List Episode</h2>
                <div class="col-md-12">
                    @for($i = 0 ; $i < $episodes->count() ; $i++)
                        <div class="col-md-1 @if($i == 11) bot @endif">
                            <a href="{{ route('watch', [$episodes[$i]->movie_id,$episodes[$i]->episode]) }}"
                               class="btn btn-default border-global">
                                {{$episodes[$i]->episode}}
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        @endif
        <div class="col-md-12 content-div tags">
            <h2>Đánh Giá</h2>
            <div class="rating__group">
                @for($i=1; $i<=5; $i++)
                    <input class="rating__input" type="radio" name="health" id="health-{{$i}}" value="{{$i}}"
                           @if($currentUser != null && $like != null)
                           @if($like && $like->point == $i)
                           checked
                           @endif
                           @elseif((int)$movie->number_like == $i || $i == 1 ) checked @endif>
                    <label class="rating__star" for="health-{{$i}}" aria-label="Ужасно"></label>
                @endfor
                <div class="rating__focus"></div>
            </div>
        </div>
        <div class="col-md-12 content-div tags">
            <h2>Tags</h2>
            <div class="tags-content">
                @foreach($tags as $item)
                    <a href="{{route('search',['tag' => $item ?? ''])}}"><span>{{$item}}</span></a>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 memberlist-wrapper" style="margin-top: 15px">
            <div class="title-pw">
                <h2>Có thể bạn thích</h2>
            </div>
            <div class="carousel"
                 data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }'
                 style="height: 260px">
                @foreach($other as $item)
                    <a href="{{ route('detail', [$item->id]) }}" class="carousel-cell">
                        <img class="carousel-image" src="{{$item->avatar_url}}" alt="">
                        <div class="img-content">
                            <div class="pl-carousel-badget" style="left: 1%">
                                {{$item->resolution}} - {{$item->type_language}}
                            </div>
                        </div>
                        <div class="pl-carousel-content">
                            <h6 class="elipsis">
                                {{$item->native_name}}
                            </h6>
                            <p class="elipsis">
                                {{$item->vietnamese_name}}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <img style="width: 100%; height: -webkit-fill-available"
             src="https://www.socialmediaexaminer.com/wp-content/uploads/2015/06/vvr-linkedin-ads-pinterestimage.png"
             alt="">
    </div>
    <script !src="">
        $(document).ready(function () {
            let play = true;
            let id = {{$episode->id}};
            afterglow.on('myvideo', 'play', function () {
                if (play) {
                    $.ajax({
                        url: "/api/view/" + id, success: function (result) {
                        }
                    });
                }
                play = false;
            });
        })

    </script>
@endsection
