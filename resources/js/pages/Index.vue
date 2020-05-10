<template>
    <b-col md="7" class="layout">
        <div class="banner-wrapper">
            <Flickity></Flickity>
        </div>
        <b-col md="12" class="layout-content layout2">
            <div class="title-main">
                <h2 class="title-h2">Phim Lẻ</h2>
                <a href="#">Xem thêm
                    <i class="fa fa-chevron-right"></i></a>
            </div>
            <b-col class="content">
                <b-col md="12" class="layout2">
                    <b-col md="3" v-for="(movie,index) in data.odd" v-bind:key="movie.id">
                        <a href="" v-if="index <=3">
                            <div class="img-content"
                                 :style="{ 'background-image': 'url('+movie.avatar_url+')' }"
                            >
                                <div class="pl-carousel-badget" style="left: 1%">
                                    {{movie.type_language + ' - '+ movie.resolution}}
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                <p class="elipsis">
                                    {{movie.native_name +' ('+ movie.realease_year +')'}}</p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
                <b-col md="12" class="layout2">
                    <b-col md="3" v-for="(movie,index) in data.odd" v-bind:key="movie.id">
                        <a href="" v-if="index >3">
                            <div class="img-content"
                                 :style="{ 'background-image': 'url('+movie.avatar_url+')' }"
                            >
                                <div class="pl-carousel-badget" style="left: 1%">
                                    {{movie.type_language + ' - '+ movie.resolution}}
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                <p class="elipsis">
                                    {{movie.native_name +' ('+ movie.realease_year +')'}}</p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
            </b-col>
        </b-col>
        <b-col md="12"  class="layout2">
            <div class="title-main">
                <h2 class="title-h2">Phim bộ</h2>
                <a href="#">Xem thêm
                    <i class="fa fa-chevron-right"></i></a>
            </div>
            <b-col class="content">
                <b-col md="12" class="layout2">
                    <b-col md="3" v-for="(movie,index) in data.set" v-bind:key="movie.id">
                        <a href="" v-if="index <=3">
                            <div class="img-content"
                                 :style="{ 'background-image': 'url('+movie.avatar_url+')' }"
                            >
                                <div class="pl-carousel-badget" style="left: 1%">
                                    {{movie.type_language + ' - '+ movie.resolution}}
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                <p class="elipsis">
                                    {{movie.native_name +' ('+ movie.realease_year +')'}}</p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
                <b-col md="12" class="layout2">
                    <b-col md="3" v-for="(movie,index) in data.set" v-bind:key="movie.id">
                        <a href="" v-if="index > 3">
                            <div class="img-content"
                                 :style="{ 'background-image': 'url('+movie.avatar_url+')' }"
                            >
                                <div class="pl-carousel-badget" style="left: 1%">
                                    {{movie.type_language + ' - '+ movie.resolution}}
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                <p class="elipsis">
                                    {{movie.native_name +' ('+ movie.realease_year +')'}}</p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
            </b-col>
        </b-col>
        <b-col md="12" class="layout-content">
            <div class="title-main">
                <h2 class="title-h2">sssssssssssssssssssssssssss</h2>
                <a href="#">xxxxxxx
                    <i class="fa fa-chevron-right"></i></a>
            </div>
            <b-col class="content">
                <b-col md="12"  class="layout2">
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
                <b-col md="12" class="layout2">
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                    <b-col md="3">
                        <a href="">
                            <div class="img-content"
                                 style='background-image: url("https://picsum.photos/720/540/?image=517")'>
                                <div class="pl-carousel-badget" style="left: 1%">
                                    Full Thuyết Minh
                                </div>
                            </div>
                            <div class="pl-carousel-content">
                                <h6 class="elipsis">
                                    Quá Nhanh Quá Nguy Hiểm 9 </h6>
                                <p class="elipsis">
                                    Fast &amp; Furious Presents: Hobbs &amp; Shaw </p>
                            </div>
                        </a>
                    </b-col>
                </b-col>
            </b-col>
        </b-col>
    </b-col>
</template>

<script>
    import Flickity from '../components/global/Flickity'

    export default {
        name: "Index",
        data() {
          return {
              data :[]
          }
        },
        mounted() {
            this.index()
        },
        methods: {
            index() {
                axios.get('/')
                    .then(res => {
                            this.data = res.data.data
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
        },
        components: {
            Flickity,
        }
    }
</script>

<style scoped>

</style>
