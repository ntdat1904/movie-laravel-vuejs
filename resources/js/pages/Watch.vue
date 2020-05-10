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
            <b-col md=12>
                <b-col md="12" class="watch-poster">
                    <b-col md="4">
                        <img :src="data.avatar_url"/>
                        <div class="watch-more">
                            <a href="#">xem them</a>
                        </div>
                    </b-col>
                    <b-col md="8">
                        <div class="watch-introduce">
                            <span class="title-1">{{data.vietnamese_name}}</span>
                            <span class="title-2">{{data.native_name}}</span>
                            <div class="watch-content">
                                <span>{{data.introduce}}</span>
                            </div>
                        </div>
                    </b-col>

                </b-col>

                <Media :kind="'video'"
                       :src="currentEpisode"
                       controls width="100%"/>
            </b-col>
            <b-col md="12" style="padding-top: 15px; ">
                <div class="content-div list-episode">
                    <h2>List Episode</h2>
                    <b-col md="1" :class="{ 'bot':(index+1)%12==0 }" v-for="(episode,index) in data.episodes"
                           v-bind:key="episode.id">
                        <button type="button" class="btn btn-default border-global"
                                @click="startEpisode(episode.video_url)">{{index+1}}
                        </button>
                    </b-col>
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
                <div class="content-div orther">
                    <h2>Other movie</h2>
                    <div class="orher-content">
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
    import Media from '@dongido/vue-viaudio'

    export default {
        name: "Watch",
        data() {
            return {
                data: [],
                id: this.$route.params.id,
                currentEpisode: ""
            }
        },
        methods: {
            index() {
                axios.get('/' + this.id)
                    .then(res => {
                            this.data = res.data.data.movie
                            if (this.data.episodes.length > 0) {
                                this.currentEpisode = this.data.episodes.slice(0, 1)[0].video_url
                            }
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
            startEpisode(url) {
                this.currentEpisode = url
            }
        },
        created() {
            this.index()
        },
        components: {
            Media
        },
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

    .content-div.orther {
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
    .watch-poster {
        padding-left: 0;
        padding-right: 0;

        .col-md-4 {
            padding: 0 0 15px 0;
        }

        img {
            width: 100%;
            height: 250px;

        }
        watch-main {
            position: relative;
            padding: 0;
            img {
                width: 100%;
                height: 250px;
            }
            .watch-more {
                position: absolute;
                top: 85%;
                width: 100%;
                background: rgba(0, 0, 0, 0.8);
                height: 15%;

                a {
                    text-align: center;
                    display: block;
                    margin-top: 10px;
                }
        }

        /*.watch-more {*/
            /*position: absolute;*/
            /*bottom: 15px;*/
            /*height: 15%;*/
            /*background: rgba(0, 0, 0, 0.8);*/
            /*text-align: center;*/
            /*width: -webkit-fill-available;*/

            /*a {*/
                /*position: absolute;*/
                /*top: 24%;*/
                /*left: 25%;*/
                /*font-size: 20px;*/
                /*text-transform: uppercase;*/
                /*text-decoration: none;*/
                /*color: #46E1FF;*/
            /*}*/
        }

        .col-md-8 {
            background-color: #01060a;
        }

        .watch-introduce {
            height: 250px;

            .title-1 {
                text-transform: uppercase;
                font: 26px 'UTMCafetaRegular';
                color: #dacb46;
                display: block;
                padding-bottom: 5px;
            }

            .title-2 {
                color: #999;
                font-size: 12px;
                padding-bottom: 5px;
            }

            .watch-content {
                color: #999;
                font-size: 12px;
            }

            div {
                background-color: #333;
                border-radius: 5px !important;
                padding: 10px;
                margin-top: 15px;

                span {
                    color: #999;
                    font-size: 12px;
                    margin: 0;
                    line-height: 18px;
                }

            }

        }
    }

    .bot {
        margin-bottom: 10px;
    }

    .list-episode {
        display: flow-root;

        .col-md-1 {
            padding-left: 5px;
        }
    }

</style>
