<template>
    <div>
        <Header></Header>
        <div class="page-container">
            <Sidebar></Sidebar>
            <router-view></router-view>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper" v-if="this.$route.name === 'admin.dashboard'">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <router-link :to="{name:'admin.dashboard'}" tag="a">Home</router-link>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- END PAGE HEADER-->
                    <b-container class=" widget-row">
                        <b-col md="4" class="container">
                            <router-link :to="{name:'admin.member.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/actor.jpeg"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.member.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">Member</p>
                                </b-card>
                            </router-link>
                        </b-col>
                        <b-col md="4">
                            <router-link :to="{name:'admin.user.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/user.png"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.user.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">User</p>
                                </b-card>
                            </router-link>
                        </b-col>
                        <b-col md="4">
                            <router-link :to="{name:'admin.tag.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/tag.png"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.tag.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">Tag</p>
                                </b-card>
                            </router-link>
                        </b-col>
                    </b-container>
                    <b-container class=" widget-row">
                        <b-col md="4">
                            <router-link :to="{name:'admin.movie.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/moive.png"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.movie.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">Movie</p>
                                </b-card>
                            </router-link>
                        </b-col>
                        <b-col md="4">
                            <router-link :to="{name:'admin.country.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/country.png"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.country.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">Country</p>
                                </b-card>
                            </router-link>
                        </b-col>
                        <b-col md="4">
                            <router-link :to="{name:'admin.category.list'}" tag="a">
                                <b-card
                                    img-src="/images/global/category.jpeg"
                                    img-alt="Card Image"
                                >
                                    <b-card-text>
                                        <router-link :to="{name:'admin.category.create'}" tag="button">New</router-link>
                                    </b-card-text>
                                    <p class="centered">Category</p>
                                </b-card>
                            </router-link>
                        </b-col>

                    </b-container>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</template>

<script>
    import Header from '../../components/admin/global/Header';
    import Sidebar from '../../components/admin/global/Sidebar';

    export default {
        name: "Index",
        components: {
            Header,
            Sidebar
        },
        mounted() {
        }
    }
</script>


<style scoped>
    .widget-row {
        width: inherit;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .widget-row .col-md-4 {
        /*border: 1px solid red;*/
        min-height: 50px;
    }

    .widget-row .col-md-4 a {
        /*background-color: #36c6d3;*/
        min-height: 45px;
        color: black;
        /*border: 1px solid blue;*/
    }

    .widget-row .col-md-4 a img {
        width: 100%;
        padding: 10% 20%;
    }

    .widget-row .col-md-4 a button {
        width: 100%;
        height: 50px;
        background-color: #36c6d3;
        border: 0;
        font-size: 20px;
    }

    .card-text {
        margin: 0;
    }

    .centered {
        margin: 0;
        position: absolute;
        bottom: 8%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 35px;
    }
</style>
