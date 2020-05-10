<template>
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                <!-- END SIDEBAR TOGGLER BUTTON -->
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <li class="nav-item open active">
                    <router-link :to="{name:'admin.dashboard'}" class="nav-link nav-toggle" tag="a">
                        <span class="title">Dashboard</span>
                    </router-link>
                </li>
                <li class="heading">
                    <h3 class="uppercase">Pages</h3>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle ">
                        <i class="icon-basket"></i>
                        <span class="title">Member</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.member.list'}" class="nav-link" tag="a">
                                <span class="title">List</span>
                            </router-link>
                        </li>
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.member.create'}" class="nav-link" tag="a">
                                <span class="title">New</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                        <span class="title">User</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.user.list'}" class="nav-link" tag="a">
                                <span class="title">List</span>
                            </router-link>
                        </li>
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.user.create'}" class="nav-link" tag="a">
                                <span class="title">New</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">Movie</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu  ">
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.movie.list'}" class="nav-link" tag="a">
                                <span class="title">List</span>
                            </router-link>
                        </li>
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.movie.create'}" class="nav-link" tag="a">
                                <span class="title">New</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item   ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-social-dribbble"></i>
                        <span class="title">Tags</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu  ">
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.tag.list'}" class="nav-link" tag="a">
                                <span class="title">List</span>
                            </router-link>
                        </li>
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.tag.create'}" class="nav-link" tag="a">
                                <span class="title">New</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Categories</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu  ">
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.category.list'}" class="nav-link" tag="a">
                                <span class="title">List</span>
                            </router-link>
                        </li>
                        <li class="nav-item  ">
                            <router-link :to="{name:'admin.category.create'}" class="nav-link" tag="a">
                                <span class="title">New</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
</template>

<script>
    function getCurrentSidebar() {
        var pathName = window.location.pathname.split("/")[2]
        if( pathName == '') {
        var currentSibar = $('.nav-item').has('.title:contains('+pathName.charAt(0).toUpperCase()+ pathName.slice(1)+')')
        currentSibar.addClass('open')
        currentSibar.children('.sub-menu').css('display','block')
        }
    }
    import $ from 'jquery'
    export default {
        name: "Sidebar",
        methods: {

        },
        watch: {
            '$route' (to, from){
                getCurrentSidebar()
            }
        },
        mounted() {
            $(document).ready(function () {
                getCurrentSidebar()
                $('.nav-item').click(function(e) {
                    let check = false;
                    if($(e.target).parent().hasClass('router-link-active')) {
                        check = true
                    } else if ($(e.target).hasClass('router-link-active')) {
                        check = true
                    }
                    if(!check) {
                        if($(this).hasClass('open')) {
                            $(this).removeClass('open')
                            $(this).children('.sub-menu').css('display','none')
                        } else {
                            $(this).addClass('open')
                            $(this).children('.sub-menu').css('display','block')
                        }
                    }


                })
            })
        }
    }
</script>

<style scoped>
    @import url('../../../../../public/assets/layouts/layout/css/layout.min.css');
</style>
