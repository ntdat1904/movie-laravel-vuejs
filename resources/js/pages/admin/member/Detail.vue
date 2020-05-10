<template>
    <div>
        <div class="row">
            <div class="portlet light bordered">
                <span class="caption-subject bold uppercase">Information of Member</span>
            </div>
            <b-col md="12">
                <div>
                    <div class="col-md-3">
                        <b-img v-if="data.avatar_url != null"
                               v-bind:src="data.avatar_url" fluid-grow alt="Fluid-grow image"
                               style="width: 100%; height: auto"></b-img>
                    </div>
                    <b-col md="9" class="content-table">
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
                                    <label>Name </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.name}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Type</label>
                                </b-col>
                                <b-col md="9">
                                    <span v-if="data.type == 1">Actor</span>
                                    <span v-else>Director</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Country </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.country_name}}</span>

                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Weight</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.weight}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Height</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.height}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <router-link
                                        :to="{ name: 'admin.member.edit', params: { id: id }}"
                                        class="btn organge border-global"> Edit
                                    </router-link>
                                </b-col>
                                <b-col md="9">
                                    <button type="button" class="btn red  border-global" data-toggle="modal"
                                            href="#basic">Delete
                                    </button>
                                </b-col>
                            </b-col>
                        </div>
                    </b-col>
                </div>
                <b-col md="12">
                    <p v-html="data.introduce"></p>
                </b-col>
                <b-col md="12">
                    <h3>
                        Movie has join
                    </h3>
                    <b-container fluid class="p-4 bg-light ">
                        <b-row>
                            <b-col md="3" v-for="movie in data.movie.data" :key="movie.id">
                                <b-img thumbnail fluid :src="movie.avatar_url"
                                       alt="Image 1"></b-img>
                                <p class="text-center">{{movie.native_name}}</p>
                            </b-col>
                        </b-row>
                    </b-container>
                    <paginate
                        v-if="data.movie.last_page > 1"
                        :page-count="data.movie.last_page"
                        :page-range="3"
                        :margin-pages="2"
                        :click-handler="clickCallback"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination'"
                        :page-class="'page-item'">
                    </paginate>
                </b-col>
                <b-col md="12">
                    <h3>
                        Comment
                    </h3>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="thumbnail img-circle">
                                <img class="img-responsive user-photo img-circle"
                                     src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-md-11">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong>myusername</strong> <span class="text-muted">commented 5 days ago</span>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div><!-- /container -->
                    <div class="row">
                        <div class="col-md-1">
                            <div class="thumbnail img-circle">
                                <img class="img-responsive user-photo img-circle"
                                     src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-md-11">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong>myusername</strong> <span class="text-muted">commented 5 days ago</span>
                                </div>
                                <div class="panel-body">
                                    Panel content
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div><!-- /row -->
                </b-col>
                <b-col md="12" style="margin: 0 15px">
                    <b-form-textarea
                        class="textarea"
                        placeholder="Enter something..."
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                    <br/>
                    <b-button variant="primary" class="border-global">Send</b-button>
                </b-col>
            </b-col>
        </div>
        <Modals
            v-bind:modal="{
                id: idModal,
                param: [],
                type: 'singel',
                name: 'member'
                }"></Modals>
    </div>
</template>
<script>
    import Modals from "../../../components/admin/global/Modals"
    import Paginate from 'vuejs-paginate'

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    name: "",
                    type: 1,
                    country_name: '',
                    introduce: "",
                    height: "",
                    weight: "",
                    avatar_url: '',
                    movie: {
                        total: 0,
                        current_page: 1,
                        per_page: 5,
                        from: 1,
                        last_page: 3,
                        prev_page_url: null,
                        to: 1,
                        page: 1,
                        data: []
                    }
                },
                movies: [],
                page: '',
                has_error: false,
                error: "",
                errors: {},
                totalPage: 1,
                success: false,
                id: this.$route.params.id,
                idModal: this.$route.params.id,

            };
        },
        components: {
            Modals,
            Paginate
        },
        mounted() {
            this.getMember(this.id);
        },
        methods: {
            getMember(id) {
                for (const key in this.$route.query) {
                    if (key === 'page') {
                        this.page = this.$route.query[key];
                    }
                }
                var query = {}
                if (this.page !== '') {
                    query = {'page': this.page};
                }
                this.axios.get('auth/member/detail/' + id, {params: query})
                    .then(res => {
                            this.data = res.data.member;
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
            clickCallback(pageNum) {
                this.$router.push({query: {'page': pageNum}});
                this.page = pageNum;
                this.getMember(this.id);
            }

        },
    }
    ;
</script>

<style scoped>
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

    .pagination {
        margin: 0 40% !important;
    }
</style>
