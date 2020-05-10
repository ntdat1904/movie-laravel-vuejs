@extends('layouts.app')
@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="poster col-md-6">
            <div class="poster-main">
                <img alt="Ký Sinh Trùng - Parasite" src="{{$member->avatar_url}}">
            </div>
        </div>

        <div class="detail col-md-6">
            <span>{{$member->name}}</span>
            <div class="detail-content">
                <ul>
                    <li>
                        <label>Nghề nghiệp: @if($member->type) Diễn viên @else Đạo diễn @endif</label>
                    </li>
                    <li>
                        <label>Quốc gia: {{$member->country->name}}</label>
                    </li>
                    <li>
                        <label>Chiều cao: {{$member->height}}</label>
                    </li>
                    <li>
                        <label>Cân nặng: {{$member->weight}}</label>
                    </li>
                </ul>
            </div>
        </div>
        @if($member->movies->count() >0)
            <div class="col-md-12 memberlist-wrapper">
                <div class="title-pw">
                    <h2>Phim</h2>
                </div>
                <div class="carousel"
                     data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }'
                     style="height: 260px">
                    @foreach($member->movies as $item)
                        <a href="#" class="carousel-cell">
                            <img class="carousel-image" src="{{$item->avatar_url}}" alt="">
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{$item->native_name}}
                                </h6>
                                <p class="elipsis">
                                    {{$item->vietnamese_name ?? '-'}}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class=" col-md-12 content-div introduce">
            <h2>nội dung</h2>
            <p>{{$member->introduce}}</p>
        </div>
        <div class="col-md-12 memberlist-wrapper">
            <div class="title-pw">
                <h2>Có thể bạn thích</h2>
            </div>
            <div class="carousel"
                 data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }'
                 style="height: 260px">
                @foreach($member->other as $item)
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

@endsection
