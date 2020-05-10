<template>
    <div>
        <div class="row">
            <div class="portlet light bordered">
                <span class="caption-subject bold uppercase">Information of Member</span>
            </div>
            <b-col md="12">
                <div>
                    <div class="col-md-3">
                        <b-img v-if="data.avatar_url != null && data.img"
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
                                    <label>Role</label>
                                </b-col>
                                <b-col md="9">
                                    <span v-if="data.Role == 1">User</span>
                                    <span v-else>Admin</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Email </label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.email}}</span>

                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <label>Create At</label>
                                </b-col>
                                <b-col md="9">
                                    <span>{{data.created_at}}</span>
                                </b-col>
                            </b-col>
                            <b-col md="12" class="form-group">
                                <b-col md="3" class="text-right">
                                    <router-link
                                        :to="{ name: 'admin.user.edit', params: { id: id }}"
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
            </b-col>
        </div>
        <Modals
            v-bind:modal="{
                id: id,
                param: [],
                type: 'singel',
                name: 'user'
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
                    email: "",
                    role: 1,
                    avatar_url: "",
                    img: false,
                    created_at: "",
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
            this.getUser(this.id);
        },
        methods: {
            getUser(id) {
                this.$http({
                    url: `auth/users/` + id,
                    method: "GET"
                }).then(
                    res => {
                        this.data = res.data.user;
                    },
                    () => {
                        this.has_error = true;
                    }
                );
            },
        },
    };
</script>

<style scoped>
    @import "../../../../../public/assets/pages/css/profile-2.min.css";

    .pic-bordered {
        width: 240px !important;
    }

    .tab-content div {
        padding-top: 10px;
    }

    .organge {
        color: #FFF;
        background-color: #d27b53;
        border-color: #d27b53;
    }

    .btn {
        min-width: 70px;
    }

    .form-actions {
        padding-left: 50vh !important;
    }
</style>
