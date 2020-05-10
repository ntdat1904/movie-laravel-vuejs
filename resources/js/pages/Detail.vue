<template>
    <div>
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
                                        {{member.name}}sss
                                    </h6>
                                    <p class="elipsis">
                                        {{member.name_in_movie}}
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!--<a href="#" v-for="(member,index) in data.members"-->
                        <!--v-bind:key="member.id">-->
                        <!--<div v-if="index > 4*(count-1)">-->
                        <!--<img class="carousel-cell-image" :style="'left:'+(1+((index+(4*(count-1)))*20))+'%'"-->
                        <!--:src="member.avatar_url"/>-->
                        <!--<div class="pl-carousel-content" :style="'left:'+(1+((index+(4*(count-1)))*20))+'%'">-->
                        <!--<h6 class="elipsis">-->

                        <!--</h6>-->
                        <!--<p class="elipsis">-->
                        <!--</p>-->
                        <!--</div>-->
                        <!--</div>-->

                        <!--</a>-->
                    </div>
                    <!--<div class="carousel-cell">-->
                    <!--<a href="#" v-for="(movie,index) in 5">-->
                    <!--<img class="carousel-cell-image" :style="'left:'+(1+(index*20))+'%'"-->
                    <!--src="http://image.phimmoi.net/film/8610/poster.medium.jpg"/>-->
                    <!--<div class="pl-carousel-content" :style="'left:'+(1+(index*20))+'%'">-->
                    <!--<h6 class="elipsis">-->
                    <!--{{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>-->
                    <!--<p class="elipsis">-->
                    <!--{{movie.native_name +' ('+ movie.realease_year +')'}} </p>-->
                    <!--</div>-->
                    <!--</a>-->
                    <!--</div>-->
                </flickity>
            </div>
        </b-col>
    </div>
</template>

<script>
    import Flickity from 'vue-flickity';

    export default {
        name: "Detail",
        prop: 'data',
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
                }
            }
        },
        method : {
            index () {
                this.data = this.$parent.data
            }
        },
        components: {
            Flickity
        },
    }
</script>


<style scoped lang="scss">
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
