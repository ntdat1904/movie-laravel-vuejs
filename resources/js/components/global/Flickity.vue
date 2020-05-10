<template>
    <div>
        <flickity ref="flickity" :options="flickityOptions">
            <div class="carousel-cell">
                <a href="#" v-for="(movie,index) in slides" v-if="index<=4">
                    <img class="carousel-cell-image" :style="'left:'+(1+(index*20))+'%'"
                         :src="movie.avatar_url"/>
                    <div class="pl-carousel-badget" :style="'left:'+(1+(index*20))+'%'" v-if="movie.form == 'Set'">
                        {{movie.type_language + ' - '+ movie.resolution}}
                    </div>
                    <div class="pl-carousel-badget" :style="'left:'+(1+(index*20))+'%'" v-else>
                        {{movie.type_language + ' - '+ movie.resolution + ' | Episode: '+ movie.episode_number +"/"+
                        movie.episode_number_current}}
                    </div>

                    <div class="pl-carousel-content" :style="'left:'+(1+(index*20))+'%'">
                        <h6 class="elipsis">
                            {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                        <p class="elipsis">
                            {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                    </div>
                </a>
            </div>
            <div class="carousel-cell">
                <a href="#" v-for="(movie,index) in slides" v-if="index > 4">
                    <img class="carousel-cell-image" :style="'left:'+(1+((index-5)*20))+'%'"
                         :src="movie.avatar_url"/>
                    <div class="pl-carousel-badget" :style="'left:'+(1+((index-5)*20))+'%'" v-if="movie.form == 'Set'">
                        {{movie.type_language + ' - '+ movie.resolution}}
                    </div>
                    <div class="pl-carousel-badget" :style="'left:'+(1+((index-5)*20))+'%'" v-else>
                        {{movie.type_language + ' - '+ movie.resolution + ' | Episode: '+ movie.episode_number +"/"+
                        movie.episode_number_current}}
                    </div>
                    <div class="pl-carousel-content" :style="'left:'+(1+((index-5)*20))+'%'">
                        <h6 class="elipsis">
                            {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                        <p class="elipsis">
                            {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                    </div>
                </a>
            </div>
        </flickity>
    </div>
</template>
<script>
    import Flickity from 'vue-flickity';

    export default {
        name: "Header",
        data() {
            return {
                slides: [],
                flickityOptions: {
                    initialIndex: 0,
                    prevNextButtons: true,
                    pageDots: true,
                    wrapAround: true,
                    fade: true,
                    imagesLoaded: true,
                    adaptiveHeight: 260,
                    selectedSlide: 260
                }
            }
        },
        mounted() {
            this.index()
        },
        methods: {
            index() {
                axios.get('/slides')
                    .then(res => {
                            this.slides = res.data.data.slides
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
        },
        components: {
            Flickity
        },
    }
</script>

<style scoped>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: sans-serif;
    }

    .carousel {
        background: #EEE;
    }

    .carousel-cell {
        width: 100%;
        height: 200px;
        margin-right: 10px;
        border-radius: 5px;
    }

    /* cell number */
    .carousel-cell:before {
        display: block;
        text-align: center;
        line-height: 200px;
        font-size: 80px;
        color: white;
    }

    /* position dots in gallery */
    .flickity-page-dots {
        bottom: 0px;
    }

    /* white circles */
    .flickity-page-dots .dot {
        width: 12px;
        height: 12px;
        opacity: 1;
        background: transparent;
        border: 2px solid white;
    }

    .carousel.is-fullscreen .carousel-cell {
        height: 100%;
    }

    .carousel-cell-image {
        position: absolute;
        display: block;
        max-height: 100%;
        top: 0;
        max-width: 200px;
    }

    /* fill-in selected dot */
    .flickity-page-dots .dot.is-selected {
        background: white;
    }

    .flickity-viewport {
        height: 260px !important;
    }

    img {
        height: fit-content;
    }


</style>
