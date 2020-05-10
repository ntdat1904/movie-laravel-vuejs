<template>
    <b-col md="7" class="layout">
        <div style="padding-top: 15px">
            <ol class="breadcrumb">
                <li><a href="#" class="">1</a></li>
                <li><a href="#" class="">2</a></li>
                <li><a href="#" class="">3</a></li>
                <li><a href="#" class="active">4</a></li>
            </ol>
        </div>
        <b-col md="8" style='padding-left:0; padding-right: 0;'>
            <b-col md="12" class="">
                <b-col md="6" class="poster">
                    <div class="poster-main">
                        <img alt="Ký Sinh Trùng - Parasite" src="http://image.phimmoi.net/film/8610/poster.medium.jpg">
                        <div class="poster-btn">
                            <table>
                                <tr>
                                    <td>
                                        <router-link :to="{ name: 'movie.watch', params: { id: data.id}}" tag="a">
                                            <button class="watch">xem phim</button>
                                        </router-link>

                                    </td>
                                    <td>
                                        <button class="watch-trailer">xem Trailer</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </b-col>

                <b-col md="6" class="detail">
                    <span>{{data.vietnamese_name}}</span>
                    <span>{{data.native_name}}</span>
                    <div class="detail-content">
                        <ul>
                            <li>
                                <label>Trạng thái: <i v-if="data.has_movie"> Hoàn tất</i><i v-else> Chưa có</i>
                                </label>
                            </li>
                            <li>
                                <label>Điểm IMDb: {{data.IMDb_scores}}</label>
                            </li>
                            <li>
                                <label>Quốc gia: {{data.country_id}}</label>
                            </li>
                            <li>
                                <label>Năm: {{data.realease_year}}</label>
                            </li>
                            <li>
                                <label>Thời lượng: {{data.time}} phút</label>
                            </li>
                            <li>
                                <label>Chất lượng: {{data.quality}}</label>
                            </li>
                            <li>
                                <label>Độ phân giải: {{data.resolution}}</label>
                            </li>
                            <li>
                                <label>Ngôn ngữ: {{data.type_language}}</label>
                            </li>
                            <li>
                                <label>Thể loại: {{data.category}}</label>
                            </li>
                            <li>
                                <label>Công ty SX: {{data.production_company}}</label>
                            </li>
                        </ul>
                    </div>
                    <div class="detail-rate">
                        <fieldset class="rating">
                            <legend class='rating__caption'>
                                Đánh Giá Phim
                            </legend>
                            <div class="rating__group">
                                <input class="rating__input" type="radio" name="health" id="health-1" value="1" checked>
                                <label class="rating__star" for="health-1" aria-label="Ужасно"></label>
                                <input class="rating__input" type="radio" name="health" id="health-2" value="2">
                                <label class="rating__star" for="health-2" aria-label="Сносно"></label>
                                <input class="rating__input" type="radio" name="health" id="health-3" value="3">
                                <label class="rating__star" for="health-3" aria-label="Нормально"></label>
                                <input class="rating__input" type="radio" name="health" id="health-4" value="4">
                                <label class="rating__star" for="health-4" aria-label="Хорошо"></label>
                                <input class="rating__input" type="radio" name="health" id="health-5" value="5">
                                <label class="rating__star" for="health-5" aria-label="Отлично"></label>
                                <div class="rating__focus"></div>
                            </div>
                        </fieldset>
                    </div>
                </b-col>
            </b-col>

            <b-col md="12" style="padding-top: 15px">
                <div class=" content-div flickity">
                    <h2>Cast</h2>
                    <flickity ref="flickity" :options="flickityOptions" style="height: 200px;">
                        <div class="carousel-cell" v-for="(count,id) in parseInt(data.countMembers)" v-bind:key="count">
                            <a href="#" v-for="(member,index) in data.members"
                               v-bind:key="member.id">
                                <div v-if=" (5*id <= index) && (index < 5*(id+1))">
                                    <img class="carousel-cell-image" :style="'left:'+(2+((index-(5*id))*20))+'%'"
                                         :src="member.avatar_url"/>
                                    <div class="pl-carousel-content" :style="'left:'+(2+((index-(5*id))*20))+'%'">
                                        <h6 class="elipsis">
                                            {{member.name}}
                                        </h6>
                                        <p class="elipsis">
                                            {{member.name_in_movie}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </flickity>
                </div>
            </b-col>
            <b-col md="12" style="padding-top: 15px">
                <div class="content-div introduce">
                    <h2>Introduce</h2>
                    <p>{{data.introduce}}</p>
                </div>
            </b-col>
            <b-col md="12" style="padding-top: 15px">
                <div class="content-div tags">
                    <h2>Tags</h2>
                    <div class="tags-content" v-for="tag in data.tags">
                        <a href="#"><span>{{tag}}</span></a>
                    </div>
                </div>
            </b-col>
            <b-col md="12" style="padding-top: 15px">
                <div class="content-div other">
                    <h2>Other movie</h2>
                    <div class="other-content">
                        <b-col class="content">
                            <b-col md="12" class="layout2">
                                <b-col md="3" v-for="(movie,index) in data.other" v-bind:key="movie.id">
                                    <a href="" v-if="( index <= (3))">
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
                                <b-col md="3" v-for="(movie,index) in data.other" v-bind:key="movie.id">
                                    <a href="" v-if="( index > (3))">
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
                    </div>
                </div>
            </b-col>
        </b-col>
        <b-col md="4">
            <img style="width: 100%"
                 src="https://www.socialmediaexaminer.com/wp-content/uploads/2015/06/vvr-linkedin-ads-pinterestimage.png"
                 alt="">
        </b-col>


    </b-col>
</template>

<script>
    import Flickity from 'vue-flickity';

    export default {
        name: "Detail",
        data() {
            return {
                data: {},
                flickityOptions: {
                    initialIndex: 0,
                    prevNextButtons: true,
                    pageDots: false,
                    wrapAround: true,
                    fade: true,
                    imagesLoaded: true,
                    adaptiveHeight: 260,
                    selectedSlide: 260
                },
                id: this.$route.params.id,
            }
        },
        components: {
            Flickity
        },
        methods: {
            index() {
                axios.get('/' + this.$route.params.id)
                    .then(res => {
                            this.data = res.data.data.movie

                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
        },
        created() {
            this.index()
        },
        watch: {
            $route(to, from) {
                this.index()

            }
        }
    }
</script>


<style scoped lang="scss">
    .breadcrumb {
        list-style-type: none;
        display: flex;
        background-color: #01060a;
        color: white;

        a {
            color: white;
        }

        a.active {
            color: #b0b0b0;
        }
    }

    li {
        margin-left: 10px;
    }

    .content-div {
        background-color: #01060a;
        padding: 5px;

        h2 {
            font-size: 14px;
            font-weight: bold;
            color: #dacb46;
            text-transform: uppercase;
            margin-top: 5px;
        }
    }

    .content-div.flickity {

        .flickity-prev-next-button.previous {
            left: 0 !important;
        }
    }

    .content-div.introduce {

        p {
            color: #bbb;
            font-size: 13px;
            font-family: arial;
            line-height: 24px;
            margin: 10px !important;
        }
    }

    .content-div.tags {
        .tags-content {
            span {
                color: #bbb;
                font-size: 13px;
                font-family: arial;
                line-height: 24px;
            }

            margin: 10px !important;
        }
    }

    .content-div.other {
        display: flow-root;

        .pl-carousel-content {
            top: 100%;
            font-family: arial;

            h6.elipsis {
                font-size: 10px;
            }

            p.elipsis {
                font-size: 8px;
            }
        }
    }

    /* detail */
    .poster {
        position: relative;
        padding-left: 0;
        padding-right: 30px;

        .poster-main {
            position: relative;

            img {
                width: 100%;
                height: 430px;
            }
        }

        .poster-btn {
            position: absolute;
            bottom: 0px;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);

            table {
                width: inherit;

                tr {
                    list-style-type: none;
                    vertical-align: middle;
                    margin-bottom: 0;
                    left: 3%;
                    padding-inline-start: 0;
                    text-align: center;

                    td {
                        button {
                            width: 100px;
                            border-radius: 5px !important;
                            margin: 10px 0px;
                            border: 0;
                            height: 70%;
                            padding: 8px 12px;
                            color: white;
                        }

                        .watch-trailer {
                            background-color: #235a74;
                        }

                        .watch {
                            background-color: #d9534f;
                        }
                    }
                }
            }
        }
    }

    .detail {
        background-color: #01060a;
        height: 430px;

        span:first-child {
            text-transform: uppercase;
            font: 26px 'UTMCafetaRegular';
            color: #dacb46;
            line-height: 25px;
            display: flex;
            font-weight: 400;
            padding-top: 10px;

        }

        span {
            padding-bottom: 10px;
            color: white;
        }

        .detail-content {
            height: 265px;
            background-color: #222;
            border-radius: 5px !important;
            width: -webkit-fill-available;
            overflow-y: scroll;
            margin-top: 5px;
            margin-bottom: 9px;
            color: white;

            ul {
                list-style-type: none;
                padding-inline-start: 5px;
            }

            label {
                padding-top: 10px;
                margin-bottom: 0;
            }
        }

        .detail-content::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: rgb(51, 51, 51);
        }

        .detail-content::-webkit-scrollbar {
            border-radius: 10px;
            width: 8px;
            background-color: rgb(51, 51, 51)
        }

        .detail-content::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }
    }

    .detail-rate {
        /*height: 13.5vh;*/
    }

    //rating

    .rating {
        margin: 0;
        margin-bottom: 20px;
        padding: 0;
        border: none;
        color: white;
    }

    .rating__caption {
        margin-bottom: 4px;
        padding: 0;
    }

    .rating__group {
        position: relative;
        width: 10em;
        height: 2em;
        background-image: url("https://image.flaticon.com/icons/svg/149/149220.svg");
        background-position: 0 50%;
        background-repeat: repeat-x;
        background-size: 2em 2em;

        // &:focus-within {
        //   outline: 0.2em solid #4a90e2;
        //   outline-offset: 0.2em;
        // }
    }

    .rating__input {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0 0 0 0);
    }

    .rating__star {
        position: absolute;
        top: 0;
        left: 0;
        width: 2em;
        height: 2em;
        margin: 0;
        appearance: none;
        font-size: inherit;

        &:focus {
            outline: none;
        }

        .rating__input:checked + &,
        &:hover {
            background-image: url(https://image.flaticon.com/icons/svg/148/148839.svg);
            background-repeat: repeat-x;
            background-position: 0 50%;
            background-size: 2em 2em;
        }

        &:hover ~ & {
            background-image: url("https://image.flaticon.com/icons/svg/149/149220.svg");
        }

        &:nth-of-type(1) {
            z-index: 5;
            width: 2em;
        }

        &:nth-of-type(2) {
            z-index: 4;
            width: 4em;
        }

        &:nth-of-type(3) {
            z-index: 3;
            width: 6em;
        }

        &:nth-of-type(4) {
            z-index: 2;
            width: 8em;
        }

        &:nth-of-type(5) {
            z-index: 1;
            width: 10em;
        }
    }

    .rating__focus {
        position: absolute;
        left: -0.2em;
        top: -0.2em;
        right: -0.2em;
        bottom: -0.2em;

        .rating__input:focus ~ & {
            outline: 0.2em solid #4a90e2;
        }
    }

    * {
        box-sizing: border-box;
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
        max-height: 80%;
        top: 0;
        max-width: 200px;
    }

    /* fill-in selected dot */
    .flickity-page-dots .dot.is-selected {
        background: white;
    }

    .flickity-viewport {
        height: 200px !important;
    }

    .flickity-prev-next-button.previous {
        left: 6px;
    }

    img {
        height: fit-content;
    }

    .pl-carousel-content {
        top: 77%;
    }

    .content-div {
        background-color: #01060a;
        padding: 5px;

        h2 {
            font-size: 14px;
            font-weight: bold;
            color: #dacb46;
            text-transform: uppercase;
            margin-top: 5px;
        }
    }

    .content-div.flickity {

        .flickity-prev-next-button.previous {
            left: 0 !important;
        }

        .carousel-cell-image {
            max-width: 110px;
        }
    }


</style>
