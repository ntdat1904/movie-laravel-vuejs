<template>
    <div>
        <div class="row">
            <div class="portlet light bordered">
                <span class="caption-subject bold uppercase">Information of Category</span>
            </div>
            <b-col md="12">
                <b-col md="12" class="content-table">
                    <div class="portlet light">
                        <b-col md="12" class="form-group">
                            <b-col md="2">
                                <label>Name</label>
                            </b-col>
                            <b-col md="10">
                                <span>{{data.name}}</span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group">
                            <b-col md="1" class="text-right">
                                <router-link
                                    :to="{ name: 'admin.category.edit', params: { id: id }}"
                                    class="btn organge border-global"> Edit
                                </router-link>
                            </b-col>
                            <b-col md="1">
                                <button type="button" class="btn red  border-global" data-toggle="modal"
                                        href="#basic">Delete
                                </button>
                            </b-col>
                        </b-col>
                    </div>
                </b-col>
            </b-col>
        </div>
        <Modals
            v-bind:modal="{
                id: id,
                param: [],
                type: 'singel',
                name: 'category'
                }"></Modals>
    </div>
</template>
<script>
    import Modals from "../../../components/admin/global/Modals"

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    name: "",
                    number_order: "",
                },
                has_error: false,
                error: "",
                errors: {},
                success: false,
                id: this.$route.params.id,
            };
        },
        components: {
            Modals,
        },
        mounted() {
            this.getCategory(this.id);
        },
        methods: {
            getCategory(id) {
                axios.get('auth/category/' + id)
                    .then(res => {
                        this.data.name = res.data.category.name
                        this.data.number_order = res.data.category.number_order
                    })
                    .catch(res => {
                        this.has_error = true;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            },
        },
    };
</script>

<style scoped>

    .img-thumbnail {
        width: 260px;
    }

    @media only screen and (min-width: 992px) {
        .fix-btn {
            /*width: 50vh;*/
        }
    }

    @media (min-width: 992px) {
        .col-md-3 {
            width: 25%;
            text-align: center;
        }
    }

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
</style>
