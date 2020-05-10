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
                            <span class="caption-subject bold uppercase">Edit Tag</span>
                        </div>
                    </div>
                    <form role="form" @submit.prevent="create" method="post">
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.name.$error || (has_error && errors.name) }">
                            <b-col md="3" class="text-right">
                                <label>Name <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Tag Name"
                                        v-model="data.name">
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.name"
                                      v-for="error in errors.name">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <div class="form-actions text-center">
                            <button type="submit" class="btn blue border-global fix-btn" @click="typeSubmit = true">Save</button>
                            <button type="submit" class="btn yellow border-global fix-btn"
                                    @click="typeSubmit = false">Save and edit
                            </button>
                            <router-link :to="{name:'admin.tag.list'}">
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
    import {required, minLength} from "vuelidate/lib/validators";

    export default {

        name: "TagCreate",
        data() {
            return {
                data: {
                    name: "",
                },
                has_error: false,
                error: "",
                msg: '',
                msgStatus :false,
                typeSubmit: true,
                id: this.$route.params.id,
                errors: {},
            };
        },
        validations: {
            data: {
                name: {required, min: minLength(3)},
            }
        },
        components: {
        },
        mounted() {
            this.getTag(this.id)
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
                axios.post('auth/tag/edit/' + this.id,
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
                                    this.$router.push({name: 'admin.tag.list', params: {status: true, msg: 'Edit success!'}});
                                } else {
                                    this.getTag(this.id);
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
            getTag(id) {
                axios.get('auth/tag/' + id)
                    .then(res => {
                        this.data = res.data.tag
                    })
                    .catch(res => {
                        this.has_error = true;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            }

        },
    };
</script>
<style scoped>

    label span {
        color: red;
    }

    label {
        margin-top: 7.5px;
    }

    .multiselect__tags {
        border-radius: 5px !important;
    }

</style>
