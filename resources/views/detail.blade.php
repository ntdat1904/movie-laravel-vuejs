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
        <div class="poster col-md-6">
            <div class="poster-main">
                <img alt="Ký Sinh Trùng - Parasite" src="{{$movie->avatar_url}}">
                <div class="poster-btn">
                    <table>
                        <tr>
                            @if ($movie->has_movie)
                                <td>
                                    <a href="{{ route('watch', [$movie->id,1]) }}">
                                        <button class="watch">xem phim</button>
                                    </a>
                                </td>
                            @endif
                            <td>
                                <button class="watch-trailer">xem Trailer</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="detail col-md-6">
            <input type="hidden" value="{{$movie->id}}" id="movie_id">
            <span>{{$movie->vietnamese_name}}</span>
            <span>{{$movie->native_name}}</span>
            <div class="detail-content">
                <ul>
                    <li>
                        <label>Trạng thái: <i> @if($movie->has_movie) Hoàn tất @else Chưa có @endif</i>
                        </label>
                    </li>
                    <li>
                        <label>Điểm IMDb: {{$movie->IMDb_scores}}</label>
                    </li>
                    <li>
                        <label>Quốc gia: {{$movie->country_id}}</label>
                    </li>
                    <li>
                        <label>Năm: {{$movie->realease_year}}</label>
                    </li>
                    <li>
                        <label>Thời lượng: {{$movie->time}} phút</label>
                    </li>
                    <li>
                        <label>Chất lượng: {{$movie->quality}}</label>
                    </li>
                    <li>
                        <label>Độ phân giải: {{$movie->resolution}}</label>
                    </li>
                    <li>
                        <label>Ngôn ngữ: {{$movie->type_language}}</label>
                    </li>
                    <li>
                        <label>Thể loại: {{$movie->category}}</label>
                    </li>
                    <li>
                        <label>Công ty SX: {{$movie->production_company}}</label>
                    </li>
                </ul>
            </div>
            <div class="detail-rate">
                <fieldset class="rating">
                    <legend class='rating__caption'>
                        Đánh Giá Phim
                    </legend>
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
                </fieldset>
            </div>
        </div>
        @if($movie->members->count() >0)
            <div class="col-md-12 memberlist-wrapper">
                <div class="title-pw">
                    <h2>Diễn Viên</h2>
                </div>
                <div class="carousel"
                     data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }'
                     style="height: 260px">
                    @foreach($movie->members as $item)
                        <a href="{{ route('cast', [$item->id]) }}" class="carousel-cell">
                            <img class="carousel-image" src="{{$item->avatar_url}}" alt="">
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{$item->name}}
                                </h6>
                                <p class="elipsis">
                                    {{$item->name_in_movie ?? '-'}}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class=" col-md-12 content-div introduce">
            <h2>nội dung</h2>
            <p>{{$movie->introduce}}</p>
        </div>
        <div class="col-md-12 content-div tags">
            <h2>Tags</h2>
            <div class="tags-content">
                @foreach($movie->tags as $item)
                    <a href="{{route('search',['tag' => $item ?? ''])}}"><span>{{$item}}</span></a>
                @endforeach
            </div>
        </div>
        @if($movie->trailers->count() >0)
            <div class="col-md-12 content-div trailers">
                <h2>Trailers</h2>
                @for( $i =1; $i <= $movie->trailers->count(); $i++)
                    <h4>#{{$i}}</h4>
                    @if(strpos($movie->trailers[$i-1]->video_url, 'youtube') > 0)
                        <iframe width="100%" height="480" src="{{$movie->trailers[$i-1]->video_url}}"></iframe>
                    @else
                        <video class="afterglow" id="myvideo_{{$movie->trailers[$i-1]->id}}" width="1280" height="720"
                               data-id="{{$movie->trailers[$i-1]->id}}">
                            @if(!filter_var($movie->trailers[$i-1]->video_url, FILTER_VALIDATE_URL))
                                <source type="video/mp4"
                                        src="{{'/files/uploads/movie/trailer/480/'.$movie->trailers[$i-1]->video_url}}"/>
                                <source type="video/mp4"
                                        src="{{'/files/uploads/movie/trailer/720/'.$movie->trailers[$i-1]->video_url}}"
                                        data-quality="hd"/>
                            @else
                                <source type="video/mp4" src="{{$movie->trailers[$i-1]->video_url}}"
                                        data-id="{{$movie->trailers[$i-1]->id}}"/>
                            @endif
                        </video>
                    @endif
                @endfor
            </div>
        @endif
        <div class="col-md-12 content-div comments">
            <h2>Comments</h2>
            <div class="comments-content">
                @include('layouts.comments')
            </div>
        </div>
        <div class="col-md-12 memberlist-wrapper">
            <div class="title-pw">
                <h2>Có thể bạn thích</h2>
            </div>
            <div class="carousel"
                 data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }'
                 style="height: 260px">
                @foreach($movie->other as $item)
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
            let video_id = 0;
            const id = [];
            $('.afterglow').click(function () {
                video_id = $(this).attr('data-id');
                if (id.indexOf(video_id) === (-1)) {
                    $.ajax({
                        url: "/api/view-trailer/" + video_id, success: function (result) {
                        }
                    });
                }
                id.push($(this).attr('data-id'));
            });
        })

    </script>
@endsection
