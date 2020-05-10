@extends('layouts.app')
@section('content')
    <?php

    ?>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="list-movie-filter" style="margin-bottom: 10px;">
            <div class="list-movie-filter-main">
                <form id="form-filter" class="form-inline" method="GET" action="{{ route('search') }}">
                    <input type="hidden" name="q" value="{{$oldData['q'] ?? ''}}">
                    <div class="list-movie-filter-item">
                        <label for="filter-sort">Sắp xếp</label>
                        <select class="form-control" id="filter-sort" name="sort">
                            <option value="" selected>Tất cả</option>
                            @foreach( \App\Models\Movie::optionSort as $key=>$item)
                                <option
                                    value="{{$key}}"
                                    @if(!empty($oldData['sort']) && $oldData['sort'] == $key) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-movie-filter-item">
                        <label for="filter-eptype">Hình thức</label>
                        <select class="form-control" id="filter-eptype" name="form">
                            <option value="" selected>Tất cả</option>
                            @foreach( \App\Models\Movie::optionForm as $key=>$item)
                                <option
                                    value="{{$key}}"
                                    @if(!empty($oldData['form']) && $oldData['form'] == $key) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-movie-filter-item">
                        <label for="filter-language">Ngôn ngữ</label>
                        <select class="form-control" id="filter-language" name="language">
                            <option value="">Tất cả</option>
                            @foreach( \App\Models\Movie::optionLanguage as $key=>$item)
                                <option
                                    value="{{$key}}"
                                    @if(!empty($oldData['language']) && $oldData['language'] == $key) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-movie-filter-item">
                        <label for="filter-category">Thể loại</label>
                        <select id="filter-category" name="category" class="form-control">
                            <option value="">Tất cả</option>
                            @foreach( $categories as $category)
                                <option value="{{$category->name}}"
                                        @if(!empty($oldData['category']) && $oldData['category'] == $category->id) selected @endif>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-movie-filter-item">
                        <label for="filter-country">Quốc gia</label>
                        <select class="form-control" id="filter-country" name="country">
                            <option value="">Tất cả</option>
                            @foreach( $countries as $country)
                                <option value="{{$country->name}}"
                                        @if(!empty($oldData['country']) && $oldData['country'] == $country->name) selected @endif>{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-movie-filter-item">
                        <label for="filter-year">Năm</label>
                        <select id="filter-year" name="year" class="form-control">
                            <option value="">Tất cả</option>
                            @foreach( \App\Models\Movie::optionYear as $key=>$item)
                                <option
                                    value="{{$key}}"
                                    @if(!empty($oldData['year']) && $oldData['year'] == $key) selected @endif>{{$item}}</option>
                            @endforeach

                        </select>
                    </div>
                    <button type="submit" id="btn-movie-filter" class="btn btn-red btn-filter-movie">
                        <span>Duyệt phim</span></button>
                    <div class="clear"></div>
                </form>
            </div>
        </div>
        <h1 class="header-title">
            <span class="title-result">Kết Quả tìm kiếm</span>
        </h1>
        <div class="col-md-12 list-main">
            @foreach( $movies as $item)
                <div class="col-md-3 list-item" style="min-height: 250px">
                    <a href="{{route('detail',$item->id)}}">
                        <img src="{{$item->avatar_url}}" alt="" style="width: inherit; height: 85%">
                        <div class="img-content">
                            <div class="pl-carousel-badget" style="left: 1%">
                                {{$item->resolution}} - {{$item->type_language}}
                            </div>
                        </div>
                        <div class="item-content" style="position: absolute; top: 87%;">
                            <span class="elipsis" style="font-size: 10px">{{$item->vietnamese_name}}</span>
                            <span class="elipsis" style="font-size: 9px">{{$item->native_name}}</span>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
        {{ $movies->appends(\Illuminate\Support\Facades\Input::except('page'))->links() }}

    </div>
    <div class="col-md-2">
        <img style="width: 100%; height: -webkit-fill-available"
             src="https://www.socialmediaexaminer.com/wp-content/uploads/2015/06/vvr-linkedin-ads-pinterestimage.png"
             alt="">
    </div>
@endsection
