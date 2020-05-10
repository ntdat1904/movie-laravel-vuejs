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
                            <span class="caption-subject bold uppercase">Edit Category</span>
                        </div>
                    </div>
                    <form role="form" @submit.prevent="create" method="post">
                        <b-col md="12" class="form-group"
                               v-bind:class="{ 'has-error': has_error && errors.name }">
                            <b-col md="3" class="text-right">
                                <label>Name <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Category Name"
                                        v-model="data.name">
                                </div>
                                <span class="help-block" v-if="has_error && errors.name">{{ errors.name }}</span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.number_order.$error || (has_error && errors.number_order) }">
                            <b-col md="3" class="text-right">
                                <label>Number Order <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Number Order"
                                        v-model="data.number_order">
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.number_order" v-for="error in errors.number_order">
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
                            <router-link :to="{name:'admin.category.list'}">
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
    import {required, minLength, numeric} from "vuelidate/lib/validators";

    export default {

        name: "TagCreate",
        data() {
            return {
                data: {
                    name: "",
                    number_order: "",
                },
                has_error: false,
                error: "",
                msg: '',
                msgStatus: false,
                typeSubmit: true,
                id: this.$route.params.id,
                errors: {},
            };
        },
        validations: {
            data: {
                name: {required, min: minLength(3)},
                number_order: {required, numeric},
            }
        },
        components: {},
        mounted() {
            this.getCategory(this.id)
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
                axios.post('auth/category/edit/' + this.id,
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
                                        name: 'admin.category.list',
                                        params: {status: true, msg: 'Edit success!'}
                                    });
                                } else {
                                    this.getCategory(this.id)
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
            getCategory(id) {
                axios.get('auth/category/' + id)
                    .then(res => {
                        this.data = res.data.category
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
