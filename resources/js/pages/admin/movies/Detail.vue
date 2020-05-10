<template>
    <div>
        <div class="row">
            <div class="portlet light bordered">
                <span class="caption-subject bold uppercase">Information of Movie</span>
            </div>
            <b-col md="12">
                <div style="font-size: 20px">
                    <div class="col-md-3 first">
                        <b-col md="12" id="image">
                            <b-img v-if="data.avatar_url != null && data.img"
                                   v-bind:src="data.avatar_url" fluid-grow alt="Fluid-grow image"
                                   style="width: 100%; height: auto"></b-img>
                        </b-col>
                        <b-col md="12" class="form-group border-global">
                            <b-col md="6" class="text-right">
                                <label>Quality</label>
                            </b-col>
                            <b-col md="6">
                                <span>{{data.quality}}</span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group border-global">
                            <b-col md="6" class="text-right">
                                <label>Type language</label>
                            </b-col>
                            <b-col md="6">
                                <span>{{data.type_language}}</span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group border-global">
                            <b-col md="6" class="text-right">
                                <label>Number share</label>
                            </b-col>
                            <b-col md="6">
                                <span>{{data.number_share}}</span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group border-global">
                            <b-col md="6" class="text-right">
                                <label>Number view</label>
                            </b-col>
                            <b-col md="6">
                                <span>{{data.number_view}}</span>
                            </b-col>
                        </b-col>
                    </div>
                    <b-col md="9" class="content-table secondary">
                        <div class="portlet light">
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>ID</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.id}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>VietNamese Name </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.vietnamese_name}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Native Name </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.native_name}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Has movie </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.native_name}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>IMDb scores </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.IMDb_scores}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Episode number </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.episode_number}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Year release </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.realease_year}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Time(per episode) </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.time}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Episode number current</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.episode_number_current}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Form</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.form}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Production company</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.production_company}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group border-global">
                                <b-col md="3" class="text-right">
                                    <label>Number like</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.number_like}}</span>
                                </b-col>
                            </b-col>

                        </div>
                    </b-col>
                </div>
                <b-col md="12">

                    <div v-for="(video,index) in data.trailers">
                        <h3>
                            Trailer #{{index+1}}
                        </h3>
                        <b-container class="p-4 bg-light ">
                            <Media :kind="'video'" :src="video.url" controls width="1024"/>
                        </b-container>

                    </div>


                </b-col>
                <b-col md="12" v-if="src !== ''">
                    <h3>
                        Episode {{currentEpisode}}
                    </h3>
                    <b-container class="p-4 bg-light ">
                        <Media :kind="'video'" :src="src" controls width="1024"/>
                    </b-container>

                </b-col>
                <b-col md="12">
                    <b-container class="p-4 bg-light ">
                        <b-col md="6" class="text-right">
                            <router-link
                                :to="{ name: 'admin.movie.edit', params: { id: id }}"
                                class="btn organge border-global"> Edit
                            </router-link>
                        </b-col>
                        <b-col md="6">
                            <button type="button" class="btn red  border-global" data-toggle="modal"
                                    href="#basic">Delete
                            </button>
                        </b-col>
                    </b-container>
                </b-col>
                <b-col md="12">
                    <h3>
                        List Episode
                    </h3>
                    <b-container class="p-4 bg-light ">
                        <div class="" v-for="(episode,index) in data.episodes" v-bind:key="episode.id">
                            <b-col md="1" :class="{ 'bot':(index+1)%12==0 }">
                                <button type="button" class="btn btn-default border-global"
                                        @click="startEpisode((index+1),episode.video_url)">{{index+1}}
                                </button>
                            </b-col>
                        </div>
                    </b-container>
                </b-col>
                <b-col md="12">
                    <h3>
                        Comment
                    </h3>
                    <div style="overflow-y: scroll;max-height: 445px">
                        <div class="row" v-for="comment in list.data">
                            <div class="col-md-1">
                                <div class="thumbnail img-circle">
                                    <img class="img-responsive user-photo img-circle"
                                         :src="comment.avatar_url">
                                </div><!-- /thumbnail -->
                            </div><!-- /col-sm-1 -->

                            <div class="col-md-11">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>{{comment.author}}</strong> <span class="text-muted">{{comment.created_at}}</span>
                                        <a href="javascript:;" @click="deleteMsg(comment.id)"><i class="fa fa-trash"></i></a>
                                    </div>
                                    <div class="panel-body">
                                        {{comment.content}}
                                    </div><!-- /panel-body -->
                                </div><!-- /panel panel-default -->
                                <div class="child">
                                    <div class="row" v-for="childComment in comment.child.data">
                                        <div class="col-md-1">
                                            <div class="thumbnail img-circle">
                                                <img class="img-responsive user-photo img-circle"
                                                     :src="childComment.avatar_url">
                                            </div><!-- /thumbnail -->
                                        </div><!-- /col-sm-1 -->

                                        <div class="col-md-11">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <strong>{{childComment.author}}</strong> <span class="text-muted">{{childComment.created_at}}</span>
                                                    <a href="javascript:;" @click="deleteMsg(childComment.id)"><i class="fa fa-trash"></i></a>
                                                </div>
                                                <div class="panel-body">
                                                    {{childComment.content}}
                                                </div><!-- /panel-body -->
                                            </div><!-- /panel panel-default -->
                                        </div><!-- /col-sm-5 -->

                                    </div><!-- /row -->
                                    <a href="javascript:;" style="text-align: center; display:block"
                                       v-if="comment.child.total > 5 && comment.child.total !== parseInt(comment.child.per_page)"
                                       @click="getListChildComment(comment.id,comment.child.total)"
                                    >More...</a>
                                </div>

                            </div><!-- /col-sm-5 -->
                        </div><!-- /container -->
                        <a href="javascript:;" style="text-align: center; display:block"
                           v-if="record !== list.total"
                           @click="record = list.total; getListComment()">More...</a>
                    </div>

                </b-col>
            </b-col>
        </div>
        <Modals
            v-bind:modal="{
                id: idModal,
                param: [],
                type: 'singel',
                name: 'movie'
                }"></Modals>
    </div>
</template>
<script>
    import Modals from "../../../components/admin/global/Modals"
    import $ from 'jquery'
    import Media from '@dongido/vue-viaudio'

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    native_name: '',
                    vietnamese_name: '',
                    has_movie: 1,
                    introduce: '',
                    avatar_url: {},
                    IMDb_scores: 0,
                    time: 0,
                    number_like: 0,
                    number_share: 0,
                    number_view: 0,
                    episode_number_current: '',
                    episode_number: '',
                    realease_year: '',
                    form: 'Odd',
                    production_company: '',
                    resolution: 'CAM',
                    quality: 'Normal',
                    type_language: 'EN',
                    countries: [],
                    tags: [],
                    categories: [],
                    trailers: [],
                    videos: [],

                },
                has_error: false,
                error: "",
                errors: {},
                success: false,
                id: this.$route.params.id,
                idModal: this.$route.params.id,
                episode: [],
                currentEpisode: '',
                src: '',
                list: {
                    data: [],
                },
                record: 5,
            };
        },
        components: {
            Modals,
            Media
        },
        created() {
            this.getMovie(this.id);
            this.getListComment();
            window.Echo.channel('laravel_database_comments')
                .listen('MessagePosted', (data) => {
                    data.comment['author'] = data.user.name;
                    data.comment['avatar_url'] = data.user.avatar_url;
                    data.comment['child'] = [];
                    if (data.comment.created_at.valueOf() !== data.comment.updated_at.valueOf()) {

                        this.list.data.forEach(function (item) {
                            if (item.id === data.comment.id) {
                                item.content = data.comment.content;
                                item.status = data.comment.status;
                            } else {
                                item.child.data.forEach(function (itemChild) {
                                    if (itemChild.id === data.comment.id) {
                                        itemChild.content = data.comment.content;
                                        itemChild.status = data.comment.status;
                                    }
                                })
                            }
                        })
                    } else {
                        if (data.comment.comment_id !== 0) {
                            this.list.data.forEach(function (item) {
                                if (item.id === data.comment.comment_id) {
                                    item.child.data.push(data.comment)
                                }
                            })
                        } else {
                            this.list.data.push(data.comment)
                        }
                    }
                });
        },
        mounted() {
            $(document).ready(function () {
                let min = $('.secondary').height() - $('.first').height()
                $('#image').css('min-height', $('#image').height() + min)
            })
        },
        methods: {
            getMovie(id) {
                this.$http({
                    url: `auth/movie/` + id,
                    method: "GET"
                }).then(
                    res => {
                        this.data = res.data.movie
                        this.data.trailers = res.data.trailers
                        this.data.episodes = res.data.episodes
                    },
                    () => {
                        this.has_error = true;
                    }
                );
            },
            startEpisode(index, url) {
                this.currentEpisode = index;
                this.src = url
            },
            getListComment() {
                this.axios.get('listcomment/' + this.id + '/' + this.record)
                    .then(res => {
                        this.list = res.data.data;
                    })
                    .catch(res => {
                    });
            },
            getListChildComment(comment_id, record) {
                (record === undefined) ? record = 5 : "";
                this.axios.get('listchildcomment/' + comment_id + '/' + record)
                    .then(res => {
                        const child = res.data.data;
                        this.list.data.forEach(function (comment) {
                            if (comment.id === comment_id) {
                                comment.child = child;
                            }
                        });

                    })
                    .catch(res => {
                    });
            },
            deleteMsg(id) {
                this.data.action = 'delete';
                this.data.id = id;
                this.data.status = 2;
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key]);
                    }
                }
                this.$swal.fire({
                    title: 'Bạn có chắc muốn gỡ tin nhắn này?',
                    text: "Tin nhắn này sẽ được gỡ!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.value) {
                        this.axios.post('comment',
                            formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(res => {
                                this.list.data.forEach(function (item) {
                                    if (item.id === id) {
                                        item.content = 'Tin nhắn đã bị ẩn do không phù hợp!';
                                        item.status = 2;
                                    } else {
                                        item.child.data.forEach(function (itemChild) {
                                            if (itemChild.id === id) {
                                                itemChild.content = 'Tin nhắn đã bị ẩn do không phù hợp!';
                                                itemChild.status = 2;
                                            }
                                        })
                                    }
                                });
                                this.$swal.fire(
                                    'Thành công!',
                                    'Tin nhắn đã được gỡ.',
                                    'success'
                                )
                            })
                            .catch(res => {
                            });
                    }
                });

            },

        },
    };
</script>

<style scoped lang="scss">
    @import "../../../../../public/assets/pages/css/profile-2.min.css";

    .row {
        margin: 0 !important;
    }

    .bg-light .row {
        width: 100%;
        text-align: center;
    }

    .pic-bordered {
        width: 240px !important;
    }

    .tab-content div {
        padding-top: 10px;
    }

    .textarea {
        width: 98.5%;
    }

    .organge {
        color: #FFF;
        background-color: #d27b53;
        border-color: #d27b53;
    }

    .btn {
        min-width: 70px;
    }

    .container-fluid .row {
        display: inline-flex;
    }

    .img-thumbnail {
        /*width: 25%;*/
        /*margin: 0 55px;*/
    }

    .form-actions {
        padding-left: 50vh !important;
    }

    .thumbnail {
        padding: 0px;
    }

    .panel {
        position: relative;
    }

    .panel > .panel-heading:after, .panel > .panel-heading:before {
        position: absolute;
        top: 11px;
        left: -16px;
        right: 100%;
        width: 0;
        height: 0;
        display: block;
        content: " ";
        border-color: transparent;
        border-style: solid solid outset;
        pointer-events: none;
    }

    .panel > .panel-heading:after {
        border-width: 7px;
        border-right-color: #f7f7f7;
        margin-top: 1px;
        margin-left: 2px;
    }

    .panel > .panel-heading:before {
        border-right-color: #ddd;
        border-width: 8px;
    }

    .bot {
        margin-bottom: 10px;
    }

    .panel-heading {
        .fa-trash {
            float: right;
            color: black;
        }
    }

    .child {
        .col-md-11 {
            padding-right: 0;
        }
    }
</style>
