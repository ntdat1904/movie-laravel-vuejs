@php
    $currentUser = \Illuminate\Support\Facades\Auth::guard('user')->user() ?? null;
@endphp
<div class="comments-container">
    <div id="comments">
        <listcomments  id_movie="{{$movie->id ?? 0}}" user_id="{{$currentUser->id ?? 0}}"></listcomments>
        @auth('user')
            <comments id_movie="{{$movie->id ?? 0}}" user_id="{{$currentUser->id ?? 0}}" author="{{$currentUser->name ?? ''}}" avatar_url="{{$currentUser->avatar_url}}"></comments>
        @else
            <div class="cmt-not-auth">Bạn cần
                <a href="javascript:;" data-target="#login" data-toggle="modal">đăng nhập</a>
                để bình luận!!!
            </div>
        @endauth
    </div>

</div>
<style>
    /**
 * Oscuro: #283035
 * Azul: #03658c
 * Detalle: #c7cacb
 * Fondo: #dee1e3
 ----------------------------------*/
    * {
        margin: 0;
        padding: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    a {
        color: #03658c;
        text-decoration: none;
    }

    ul {
        list-style-type: none;
    }
</style>
<script !src="">

</script>
