<template>
    <div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
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
                                        type="email"
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
                               :class="{ 'has-error': $v.data.password.$error || (has_error && errors.password)}"
                        >
                            <b-col md="3" class="text-right">
                                <label>Passwords <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="password"
                                        class="form-control border-global"
                                        placeholder="Password"
                                        v-model="data.password"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.password" v-for="error in errors.password">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group border-global"
                               :class="{ 'has-error': $v.data.password_confirmation.$error || (has_error && errors.password_confirmation)}"
                        >
                            <b-col md="3" class="text-right">
                                <label>Passwords Confirm <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="password"
                                        class="form-control border-global"
                                        placeholder="Password Confirm"
                                        v-model="data.password_confirmation"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.password_confirmation"
                                      v-for="error in errors.password_confirmation">
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
                            <b-col md="9">
                                <div class="form-group">
                                    <vue-dropzone id="upload"
                                                  :options="config"
                                                  v-on:vdropzone-complete="afterComplete"
                                    ></vue-dropzone>
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.avatar_url" v-for="error in errors.avatar_url">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <div class="form-actions text-center">
                            <button type="submit" class="btn blue border-global fix-btn">Save</button>
                            <router-link :to="{name: 'admin.user.list'}"
                            >
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
                    password: "",
                    password_confirmation: "",
                    avatar_url: {}
                },
                has_error: false,
                error: "",
                errors: {},
                success: false,
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
                name: {required, min: minLength(6)},
                email: {required},
                avatar_url: {required},
                password: {required, min: minLength(6)},
                password_confirmation: {
                    sameAsPassword: sameAs('password')
                },
            }
        },
        components: {
            vueDropzone
        },
        mounted() {
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
                axios.post('auth/users/create',
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
                                this.$router.push({
                                    name: 'admin.user.list',
                                    params: {status: true, msg: 'Created success!'}
                                })
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
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            },
            afterComplete(file) {
                this.data.avatar_url = file;
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
        border-style: dashed;
        border-radius: 5px !important;
    }
</style>
