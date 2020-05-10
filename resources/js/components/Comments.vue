<template>
    <div class="comment-container-post">
        <div class="meta">
            <img
                :src="avatar_url"
                alt="" class="avatar">
            <span class="name">{{author}}</span>
            <span class="reply" v-if="reply.active">Trả lời: {{reply.author}}</span>
        </div>
        <textarea class="form-control" v-model="data.content" @keyup.enter="submit"></textarea>
        <span class="placeholder">Comments</span>

        <div class="btns">
            <button class="btn btn-default" @click="submit"
                    v-if="!edit.active"
            >Bình luận
            </button>
        </div>

        <div class="btns">
            <button class="btn btn-default" @click="update"
                    v-if="edit.active"
            >Chỉnh sửa
            </button>
        </div>

        <div class="btns-cancel">
            <a
                v-if="edit.active"
                @click="cancelEdit"
                href="javascript:;"
                class="btn btn-default">Hủy</a>
        </div>
    </div>
</template>

<script>


    $(document).ready(function () {
        $('.comment-container-post').click(function (e) {
            $('.comment-container-post').addClass('toggled');
            e.stopPropagation();
        });
        $(document).click(function (event) {
            let re_update = $(event.target).attr('class');
            if (re_update !== 'fa fa-reply' && re_update !== 'fa fa-pen') {
                $('.comment-container-post').removeClass('toggled');
            }
        });
    });
    export default {
        props: ['id_movie', 'author', 'user_id', 'avatar_url'],
        name: "comments",
        data() {
            return {
                data: {
                    movie_id: this.id_movie,
                    user_id: this.user_id,
                    comment_id: 0,
                    content: '',
                    id: 0,
                    action: ''
                },
                reply: {
                    author: '',
                    id: 0,
                    active: false
                },
                edit: {
                    id: 0,
                    content: '',
                    active: false
                },

            }
        },
        methods: {

            submit() {
                this.data.action = 'create';
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key]);
                    }
                }
                this.axios.post('comment',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        this.hiddenCommentbox();
                    })
                    .catch(res => {
                    });
            },
            update() {
                this.data.action = 'update';
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key]);
                    }
                }
                this.axios.post('comment',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        this.hiddenCommentbox();
                    })
                    .catch(res => {
                    });
            },
            showCommentbox(e) {
                $('.comment-container-post').addClass('toggled');
                e.stopPropagation();
                $(document).click(function (event) {
                    if (!$(event.target).hasClass('fa-reply')) {
                        $('.comment-container-post').removeClass('toggled');
                    }
                    if (!$(event.target).hasClass('fa-pen')) {
                        $('.comment-container-post').removeClass('toggled');
                    }
                });
            },
            hiddenCommentbox() {
                $('.comment-container-post').removeClass('toggled');
                this.data.content = '';
                this.resetEdit();
                this.resetReply()
            },
            cancelEdit() {
                this.data.content = '';
                this.edit = {
                    content: '',
                    id: 0,
                    active: false
                };
            },
            resetReply() {
                this.reply = {
                    author: '',
                    id: 0,
                    active: false
                };
            },
            resetEdit() {
                this.edit = {
                    content: '',
                    id: 0,
                    active: false
                };
            }
        },
        mounted() {
            this.$root.$on('replyTo', (reply) => { // here you need to use the arrow function
                this.resetEdit();
                reply['active'] = true;
                this.reply = reply;
                this.data.comment_id = this.reply.id;
                this.data.content = '';
                $('.comment-container-post').addClass('toggled');
            });

            this.$root.$on('editTo', (edit) => { // here you need to use the arrow function
                this.resetReply();
                edit['active'] = true;
                this.edit = edit;
                this.data.content = edit.content;
                this.data.id = edit.id;
                $('.comment-container-post').addClass('toggled');
            })
        }
    }
</script>

<style scoped>

</style>
