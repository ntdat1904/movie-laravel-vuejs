@extends('layouts.app')

@section('content')
    <div class="playlist-wrapper">
        <div class="title-pw">
            <h2>Phim LỂ</h2>
            <a href="{{route('search',['form' => 'Set' ])}}" class="viewall">xem thêm</a>
        </div>
        <div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }' style="height: 260px">
            @foreach($gOddLastest as $item)
                <a href="{{ route('detail', $item->id) }}" class="carousel-cell">
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
    <div class="playlist-wrapper">
        <div class="title-pw">
            <h2>Phim Bộ</h2>
            <a href="{{route('search',['form' => 'Odd' ])}}" class="viewall">xem thêm</a>
        </div>
        <div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }' style="height: 260px">
            @foreach($gSetLastest as $item)
                <a href="{{ route('detail', $item->id) }}" class="carousel-cell">
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
    <div class="playlist-wrapper">
        <div class="title-pw">
            <h2>Phim sắp chiếu </h2>
            <a href="{{route('search',['sort' => 'created_at' ])}}" class="viewall">xem thêm</a>
        </div>
        <div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }' style="height: 260px">
            @foreach($gRealease as $item)
                <a href="{{ route('detail', $item->id) }}" class="carousel-cell">
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
    <div class="playlist-wrapper">
        <div class="title-pw">
            <h2>Phim nhiều người xem</h2>
            <a href="{{route('search',['sort' => 'number_view' ])}}" class="viewall">xem thêm</a>
        </div>
        <div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }' style="height: 260px">
            @foreach($gViewHighest as $item)
                <a href="{{ route('detail', $item->id) }}" class="carousel-cell">
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
    @if(count($history) > 0)
    <div class="playlist-wrapper">
        <div class="title-pw">
            <h2>Phim đã xem</h2>
            {{--<a href="{{route('search',['sort' => 'number_view' ])}}" class="viewall">xem thêm</a>--}}
        </div>
        <div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "lazyLoad": 2,"pageDots": false }' style="height: 260px">
            @foreach($history as $item)
                <a href="{{ route('detail', $item->id) }}" class="carousel-cell">
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
    @endif
@endsection
