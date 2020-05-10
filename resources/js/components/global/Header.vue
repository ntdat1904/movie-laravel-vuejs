<template>
    <div>
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
                                     src="http://media.dongphim.net/media/image/id/5c921766acc399d72c8b456b_200x">
                            </a>
                        </div>
                        <div class="nav__search">
                            <!-- top search form -->
                            <form action="/content/search" class="top-search">
                                <input type="hidden" name="t" value="kw">
                                <div class="input">
                                    <input class="form-control" autocomplete="off" name="q" type="text"
                                           placeholder="Tìm kiếm phim, tv show hoặc người nổi tiếng">
                                    <i class="fa fa-search"></i>
                                    <div id="nav_search_result" style="display: none;"></div>
                                </div>
                                <a href="/content/search?t=ft">Tìm kiếm nâng cao</a>
                            </form>
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
                                    <li class="nav__sub-list-item" v-for="category in data.category">
                                        <a href="#" :title="category.name">
                                            {{category.name}} </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav__list-item nav__list-item__3">
                                <a href="#" title="Quốc gia">
                                    Quốc gia <i class="fa fa-caret-down"></i>

                                </a>
                                <ul class="nav__sub-list">
                                    <li class="nav__sub-list-item" v-for="country in data.country">
                                        <a href="#" :title="country.name">
                                           {{country.name}} </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav__list-item nav__list-item__3">
                                <a href="#" title="Phim bộ">
                                    Phim bộ <i class="fa fa-caret-down"></i>

                                </a>
                                <ul class="nav__sub-list">
                                    <li class="nav__sub-list-item">
                                        <a href="#" title="Hàn Quốc">
                                            Hàn Quốc </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav__list-item nav__list-item__0">
                                <a href="#" title="Phim chiếu rạp">
                                    Phim chiếu rạp
                                </a>
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
                            <li class="nav__list-item nav__list-item__0">
                                <a href="#" title="Hoạt hình - Anime">
                                    Hoạt hình - Anime
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
        </header>
    </div>
</template>

<script>
    export default {
        name: "Header",
        data() {
            return {
                data : []
            }
        },
        mounted() {
          this.index()
        },
        methods: {
            index() {
                axios.get('/header')
                    .then(res => {
                            this.data = res.data.data
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
        }
    }
</script>

<style>

</style>
