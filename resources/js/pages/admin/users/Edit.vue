<template>
    <div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissable" v-if="msgStatus">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {{msg}}
                    <a href="" class="alert-link" @click="msgStatus = !msgStatus"> Please check this one as well </a>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <span class="caption-subject bold uppercase">New User</span>
                        </div>
                    </div>
                    <form role="form" @submit.prevent="create" method="post">
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.name.$error || (has_error && errors.name)}">
                            <b-col md="3" class="text-right">
                                <label>Name <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="User Name"
                                        v-model="data.name">
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.name" v-for="error in errors.name">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.email.$error || (has_error && errors.email)}"
                        >
                            <b-col md="3" class="text-right">
                                <label>Email Address <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Email Address"
                                        v-model="data.email"
                                        autocomplete="off"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.email" v-for="error in errors.email">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                        >
                            <b-col md="3" class="text-right">
                                <label>Role <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <select class="form-control border-global" v-model="data.role">
                                        <option value="1">User</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.avatar_url.$error || (has_error && errors.avatar_url )}"
                        >
                            <b-col md="3" class="text-right">
                                <label>Avatar </label>
                            </b-col>
                            <b-col md="9" class="form-group">
                                <vue-dropzone id="upload"
                                              v-if="!data.img"
                                              :options="config"
                                              v-on:vdropzone-complete="afterComplete"
                                ></vue-dropzone>
                                <b-img v-else
                                       :src="data.avatar_url"
                                       alt=""
                                       style="width: 20vh; height: 20vh"
                                       @click="editimg()"
                                ></b-img>
                                <span class="help-block"
                                      v-if="has_error && errors.avatar_url" v-for="error in errors.avatar_url">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <div class="form-actions text-center">
                            <button type="submit" class="btn blue border-global fix-btn" @click="typeSubmit = true">
                                Save
                            </button>
                            <button type="submit" class="btn yellow border-global fix-btn"
                                    @click="typeSubmit = false">Save and edit
                            </button>
                            <router-link :to="{name: 'admin.user.list'}">
                                <button type="button" class="btn default border-global fix-btn">Cancel</button>
                            </router-link>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</template>
<script>
    import vueDropzone from "vue2-dropzone";
    import {required, minLength, sameAs, email} from "vuelidate/lib/validators";

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    name: "",
                    email: "",
                    role: 1,
                    avatar_url: {},
                    img: false
                },
                has_error: false,
                error: "",
                errors: {},
                success: false,
                msg: '',
                msgStatus: false,
                typeSubmit: true,
                id: this.$route.params.id,
                config: {
                    url: "http://movie.test/api/image",
                    maxFiles: 1,
                    addRemoveLinks: true
                }
            };
        },
        validations: {
            data: {
                name: {required, min: minLength(4)},
                email: {required},
                avatar_url: {required},
            }
        },
        components: {
            vueDropzone
        },
        mounted() {
            this.getUser(this.id)
        },
        methods: {
            create() {
                this.$v.data.$touch();
                if (this.$v.data.$error) return;
                this.$swal.fire({
                    title: 'Saving...',
                    position: 'center',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 10000,
                    onBeforeOpen: () => {
                        this.$swal.showLoading()
                    }
                });
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key])
                    }
                }
                axios.post('auth/users/edit/' + this.id,
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                if (this.typeSubmit) {
                                    this.$router.push({
                                        name: 'admin.user.list',
                                        params: {status: true, msg: 'Edit success!'}
                                    });
                                } else {
                                    this.getUser(this.id);
                                    this.has_error = false;
                                    this.msgStatus = true;
                                    this.msg = 'Edit success!';
                                }
                            }
                        });

                    })
                    .catch(res => {
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                        this.has_error = true;
                        this.msgStatus = false;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            },
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
            afterComplete(file) {
                this.data.avatar_url = file;
            },
            editimg() {
                this.data.img = !this.data.img
            }
        },
    };
</script>

<style scoped>
    @import "../../../../../public/assets/global/css/vue2Dropzone.min.css";

    label span {
        color: red;
    }

    label {
        margin-top: 7.5px;
    }

    .vue-dropzone {
        border-radius: 5px !important;
        border-style: dashed;
    }

    @media only screen and (min-width: 992px) {
        .fix-btn {
            /*width: 50vh;*/
        }
    }
</style>
