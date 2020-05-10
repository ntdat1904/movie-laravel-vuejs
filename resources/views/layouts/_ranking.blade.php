<div class="col-md-12">
    <h2 class="title-rank-h2">BẢNG XẾP HẠNG</h2>
    <div class="tabbable-line">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_14_1" data-toggle="tab"> Phim lẻ</a>
            </li>
            <li>
                <a href="#tab_14_2" data-toggle="tab"> Phim Bộ </a>
            </li>
            <li>
                <a href="#tab_14_3" data-toggle="tab"> Xem nhiều </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_14_1">
                <div class="rank-content">
                    @foreach($gOddLastest as $item)
                    <div class="col-md-12">
                        <a href="{{ route('detail', $item->id) }}" class="link-rank">
                            <div class="rank-left">
                                <img class="carousel-cell-image" src="{{$item->avatar_url}}"/>
                            </div>
                            <div class="rank-right">
                                <h6 class="elipsis">
                                    {{$item->native_name}}  </h6>
                                <p class="elipsis">
                                    {{$item->vietnamese_name}} </p>
                                <span>View: {{$item->number_view}}</span>
                            </div>
                        </a>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane " id="tab_14_2">
                <div class="rank-content">
                    @foreach($gSetLastest as $item)
                        <div class="col-md-12">
                            <a href="{{ route('detail', $item->id) }}" class="link-rank">
                                <div class="rank-left">
                                    <img class="carousel-cell-image" src="{{$item->avatar_url}}"/>
                                </div>
                                <div class="rank-right">
                                    <h6 class="elipsis">
                                        {{$item->native_name}}  </h6>
                                    <p class="elipsis">
                                        {{$item->vietnamese_name}} </p>
                                    <span>View: {{$item->number_view}}</span>
                                </div>
                            </a>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane " id="tab_14_3">
                <div class="rank-content">
                    @foreach($gViewHighest as $item)
                        <div class="col-md-12">
                            <a href="{{ route('detail', $item->id) }}" class="link-rank">
                                <div class="rank-left">
                                    <img class="carousel-cell-image" src="{{$item->avatar_url}}"/>
                                </div>
                                <div class="rank-right">
                                    <h6 class="elipsis">
                                        {{$item->native_name}}  </h6>
                                    <p class="elipsis">
                                        {{$item->vietnamese_name}} </p>
                                    <span>View: {{$item->number_view}}</span>
                                </div>
                            </a>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <h2 class="title-rank-h2">Phim sắp chiếu</h2>
    <div class="tabbable-line">
        <div class="tab-content">
            <div class="rank-content">
                @foreach($gRealease as $item)
                    <div class="col-md-12">
                        <a href="{{ route('detail', $item->id) }}" class="link-rank">
                            <div class="rank-left">
                                <img class="carousel-cell-image" src="{{$item->avatar_url}}"/>
                            </div>
                            <div class="rank-right">
                                <h6 class="elipsis">
                                    {{$item->native_name}}  </h6>
                                <p class="elipsis">
                                    {{$item->vietnamese_name}} </p>
                                <span>View: {{$item->number_view}}</span>
                            </div>
                        </a>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>

    </div>
</div>
