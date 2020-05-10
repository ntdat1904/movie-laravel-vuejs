<template>
    <div class="modal fade" id="basic" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <!--Modal Member-->
                <div v-if="modal.name === 'member'">
                    <div class="modal-body" v-if="modal.type === 'singel'"> Do you sure want to delete member
                        #{{modal.id}}?
                    </div>
                    <div class="modal-body" v-else> Do you sure want to delete this member?</div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn red"
                                @click="deleteMember(modal.id)"
                                data-dismiss="modal"
                                v-if="modal.type === 'singel'"
                        >Delete
                        </button>
                        <button type="button"
                                class="btn red"
                                @click="destroyMultipleMember"
                                data-dismiss="modal"
                                v-else
                        >Delete
                        </button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!--Modal User-->
                <div v-if="modal.name === 'user'">
                    <div class="modal-body" v-if="modal.type === 'singel'"> Do you sure want to delete user
                        #{{modal.id}}?
                    </div>
                    <div class="modal-body" v-else> Do you sure want to delete this users?</div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn red"
                                @click="deleteUser(modal.id)"
                                data-dismiss="modal"
                                v-if="modal.type === 'singel'"
                        >Delete
                        </button>
                        <button type="button"
                                class="btn red"
                                @click="destroyMultipleUser"
                                data-dismiss="modal"
                                v-else
                        >Delete
                        </button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    </div>

                </div>
                <!--Modal Tag-->
                <div v-if="modal.name === 'tag'">
                    <div class="modal-body" v-if="modal.type === 'singel'"> Do you sure want to delete tag
                        #{{modal.id}}?
                    </div>
                    <div class="modal-body" v-else> Do you sure want to delete this tag?</div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn red"
                                @click="deleteTag(modal.id)"
                                data-dismiss="modal"
                                v-if="modal.type === 'singel'"
                        >Delete
                        </button>
                        <button type="button"
                                class="btn red"
                                @click="destroyMultipleTag"
                                data-dismiss="modal"
                                v-else
                        >Delete
                        </button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!--Modal Category-->
                <div v-if="modal.name === 'category'">
                    <div class="modal-body" v-if="modal.type === 'singel'"> Do you sure want to delete category
                        #{{modal.id}}?
                    </div>
                    <div class="modal-body" v-else> Do you sure want to delete this category?</div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn red"
                                @click="deleteCategory(modal.id)"
                                data-dismiss="modal"
                                v-if="modal.type === 'singel'"
                        >Delete
                        </button>
                        <button type="button"
                                class="btn red"
                                @click="destroyMultipleCategory"
                                data-dismiss="modal"
                                v-else
                        >Delete
                        </button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!--Modal Movie-->
                <div v-if="modal.name === 'movie'">
                    <div class="modal-body" v-if="modal.type === 'singel'"> Do you sure want to delete movie
                        #{{modal.id}}?
                    </div>
                    <div class="modal-body" v-else> Do you sure want to delete this movie?</div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn red"
                                @click="deleteMovie(modal.id)"
                                data-dismiss="modal"
                                v-if="modal.type === 'singel'"
                        >Delete
                        </button>
                        <button type="button"
                                class="btn red"
                                @click="destroyMultipleMovie"
                                data-dismiss="modal"
                                v-else
                        >Delete
                        </button>
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    export default {
        name: "UserModals",
        props: ['modal'],
        data() {
            return {
                params: {status: true, msg: 'Deleted success!'}
            }
        },
        methods: {
            deleteUser(id) {
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
                if (id === this.$auth.user().id) {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: "You can't remove your account!",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 1100,
                    });
                    return
                }
                this.$http({
                    url: `auth/users/destroy/` + id,
                    method: 'POST'
                })
                    .then(() => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                if (this.$route.name === 'admin.user.detail') {
                                    this.$router.push({name: 'admin.user.list', params: this.params})
                                } else {
                                    this.$parent.getUsers();
                                    this.$parent.msgStatus = true;
                                    this.$parent.msg = 'Deleted success!';
                                }
                            }
                        });

                    }, () => {
                        this.has_error = true
                    })
            },
            destroyMultipleUser: function () {
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
                let auth = this.$auth.user();
                let authCheck = this.modal.param.find(function (item) {
                    return item ? item === auth.id : null;
                });
                if (authCheck >= 0) {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: "You can't remove your account!",
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 1100,
                    });
                    return
                }

                this.$http({
                    url: `auth/users/destroymultiple`,
                    method: 'POST',
                    data: {
                        params: this.modal.param
                    }
                })
                    .then((res) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.status = res.data.status;
                                this.$parent.getUsers();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });
                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            deleteMember(id) {
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
                this.$http({
                    url: `auth/member/destroy/` + id,
                    method: 'POST'
                })
                    .then(() => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                if (this.$route.name === 'admin.member.detail') {
                                    this.$router.push({name: 'admin.member.list', params: this.params})
                                } else {
                                    this.$parent.getMembers();
                                    this.$parent.msgStatus = true;
                                    this.$parent.msg = 'Deleted success!';
                                }
                            }
                        });

                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            destroyMultipleMember: function () {
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
                this.$http({
                    url: `auth/member/destroymultiple`,
                    method: 'POST',
                    data: {
                        params: this.modal.param
                    }
                })
                    .then((res) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.status = res.data.status;
                                this.$parent.getMembers();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });

                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            deleteTag(id) {
                this.$http({
                    url: `auth/tag/destroy/` + id,
                    method: 'POST'
                })
                    .then(() => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.$parent.getTags();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });
                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            destroyMultipleTag: function () {
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
                this.$http({
                    url: `auth/tag/destroymultiple`,
                    method: 'POST',
                    data: {
                        params: this.modal.param
                    }
                })
                    .then((res) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.status = res.data.status;
                                this.$parent.getTags();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });
                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            deleteCategory(id) {
                this.$http({
                    url: `auth/category/destroy/` + id,
                    method: 'POST'
                })
                    .then(() => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.$parent.getCategories();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });
                    }, () => {
                        this.has_error = true
                    })
            },
            destroyMultipleCategory: function () {
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
                this.$http({
                    url: `auth/category/destroymultiple`,
                    method: 'POST',
                    data: {
                        params: this.modal.param
                    }
                })
                    .then((res) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.status = res.data.status;
                                this.$parent.getCategories();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });

                    }, () => {
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                        this.has_error = true
                    })
            },
            deleteMovie(id) {
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
                this.$http({
                    url: `auth/movie/destroy/` + id,
                    method: 'POST'
                })
                    .then(() => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                if (this.$route.name === 'admin.movie.detail') {
                                    this.$router.push({name: 'admin.movie.list', params: this.params})
                                } else {
                                    this.$parent.getMovies();
                                    this.$parent.msgStatus = true;
                                    this.$parent.msg = 'Deleted success!';
                                }
                            }
                        });
                    }, () => {
                        this.has_error = true;
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                    })
            },
            destroyMultipleMovie: function () {
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
                this.$http({
                    url: `auth/movie/destroymultiple`,
                    method: 'POST',
                    data: {
                        params: this.modal.param
                    }
                })
                    .then((res) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Completed',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                            onClose: () => {
                                this.status = res.data.status;
                                this.$parent.getMovies();
                                this.$parent.msgStatus = true;
                                this.$parent.msg = 'Deleted success!';
                            }
                        });
                    }, () => {
                        this.$swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1100,
                        });
                        this.has_error = true;
                    })
            },
        }
    }
</script>

<style scoped>
    .modal-footer {
        text-align: center;
    }

    .red {
        margin-right: 50px;
        border-radius: 10px !important;
    }

    .dark {
        margin-left: 50px;
        border-radius: 10px !important;
    }

    .modal-content {
        border-radius: 15px !important;
    }

    .modal-body {
        text-align: center;
        font-size: 25px;
    }
</style>
