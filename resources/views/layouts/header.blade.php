@php
    $currentUser = \Illuminate\Support\Facades\Auth::guard('user')->user() ?? null;
@endphp
<header class="header">
    <div class="nav csroller">
        <div class="nav__header">
            <div class="container nav__wrapper">
                <div class="menu-icon">
                    <span class="menu-icon__line menu-icon__line-left"></span>
                    <span class="menu-icon__line"></span>
                    <span class="menu-icon__line menu-icon__line-right"></span>
                </div>
                <div class="nav__logo">
                    <a href="/">
                        <img class="img-responsive" title="Động Phim"
                             data-original="http://media.dongphim.net/media/image/id/5c921766acc399d72c8b456b_200x"
                             alt="" style="max-height: 48px;"
                             src="{{asset('images/moive.png')}}">
                    </a>
                </div>
                <div class="nav__search">
                    <!-- top search form -->
                    <form action="{{ route('search') }}" method="GET" class="top-search">
                        <div class="input">
                            <input class="form-control" autocomplete="off" name="q" type="text"
                                   value="{{$oldData['q'] ?? ''}}"
                                   placeholder="Tìm kiếm phim, tv show hoặc người nổi tiếng">
                            <input type="hidden" name="sort" value="{{$oldData['sort'] ?? ''}}">
                            <input type="hidden" name="form" value="{{$oldData['form'] ?? ''}}">
                            <input type="hidden" name="language" value="{{$oldData['language'] ?? ''}}">
                            <input type="hidden" name="category" value="{{$oldData['category'] ?? ''}}">
                            <input type="hidden" name="country" value="{{$oldData['country'] ?? ''}}">
                            <input type="hidden" name="year" value="{{$oldData['year'] ?? ''}}">
                            <i class="fa fa-search"></i>
                        </div>
                        <button type="submit">Tìm kiếm nâng cao</button>
                    </form>
                    @auth('user')
                        <div class="top-search">
                            <li class="dropdown dropdown-user" >
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <img alt="" class="img-circle" src="{{$currentUser->avatar_url}}" style="width: 29px; height: 29px" />
                                        <span class=" username-hide-on-mobile"> {{$currentUser->name}} </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default">
                                        <li>
                                            <a href="#">
                                                <i class="icon-user"></i> My Profile </a>
                                        </li>
                                        {{--<li>--}}
                                            {{--<a href="app_calendar.html">--}}
                                                {{--<i class="icon-calendar"></i> My Calendar </a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="app_inbox.html">--}}
                                                {{--<i class="icon-envelope-open"></i> My Inbox--}}
                                                {{--<span class="badge badge-danger"> 3 </span>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="app_todo.html">--}}
                                                {{--<i class="icon-rocket"></i> My Tasks--}}
                                                {{--<span class="badge badge-success"> 7 </span>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="divider"> </li>--}}
                                        {{--<li>--}}
                                            {{--<a href="page_user_lock_1.html">--}}
                                                {{--<i class="icon-lock"></i> Lock Screen </a>--}}
                                        {{--</li>--}}
                                        <li>
                                            <a href="{{route('logout')}}">
                                                <i class="icon-key"></i> Log Out </a>
                                        </li>
                                    </ul>
                            </li>
                        </div>
                    @else
                        <div class="top-search">
                            <button data-target="#login" data-toggle="modal">Đăng nhập</button>
                        </div>
                    @endauth
                    <div class="nav__search-icon">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav__content">
            <div class="container nav__wrapper">
                <ul class="nav__list">
                    <li class="nav__list-item nav__list-item__4">
                        <a href="#" title="Thể loại">
                            Thể loại <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav__sub-list">
                            @foreach( $gCategories as $item)
                                <li class="nav__sub-list-item">
                                    <a href="{{route('search',['category' => $item->name ?? ''])}}">
                                        {{$item->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav__list-item nav__list-item__3">
                        <a href="#" title="Quốc gia">
                            Quốc gia <i class="fa fa-caret-down"></i>

                        </a>
                        <ul class="nav__sub-list">
                            @foreach( $gCountries as $item)
                                <li class="nav__sub-list-item">
                                    <a href="{{route('search',['country' => $item->name ?? ''])}}">
                                        {{$item->name}}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="nav__list-item nav__list-item__0">
                        <a href="#" title="Phim sắp chiếu">
                            Phim sắp chiếu
                        </a>
                    </li>
                    <li class="nav__list-item nav__list-item__0">
                        <a href="#" title="TV Show">
                            TV Show
                        </a>
                    </li>
                    <li class="nav__list-item">
                        <div class="menu-icon">
                            <span class="menu-icon__line menu-icon__line-left"></span>
                            <span class="menu-icon__line"></span>
                            <span class="menu-icon__line menu-icon__line-right"></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('layouts.login-register')
</header>
