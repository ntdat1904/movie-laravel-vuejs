<template>
    <ul id="comments-list" class="comments-list" v-if="list.data.length > 0">
        <li v-for="comment in list.data">
            <div class="comment-main-level">
                <!-- Avatar -->
                <div class="comment-avatar"><img
                    :src="comment.avatar_url" alt=""></div>
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                    <div class="comment-head">
                        <h6 class="comment-name"><a href="http://creaticode.com/blog">{{ comment.author }}</a></h6>
                        <span>{{comment.created_at}}</span>
                        <div v-if="user_id != 0">
                            <i class="fa fa-trash-alt"
                               @click="deleteMsg(comment.id)"

                               v-if="user_id == comment.user_id"
                            ></i>
                            <i class="fa fa-reply"
                               @click="reply(comment.author,comment.id)"></i>
                            <i class="fa fa-pen"
                               v-if="user_id == comment.user_id"
                               @click="edit(comment.id,comment.content)"></i>
                        </div>

                    </div>
                    <div class="comment-content">
                        <span v-bind:class="{'cmt-not-active': comment.status !== 0}">
                                {{comment.content}}
                        </span>
                    </div>
                </div>
            </div>
            <!-- Respuestas de los comentarios -->
            <ul class="comments-list reply-list">
                <li v-for="childComment in comment.child.data">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img
                        :src="childComment.avatar_url" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name"><a href="http://creaticode.com/blog">{{childComment.author}}</a>
                            </h6>
                            <span>{{childComment.created_at}}</span>
                            <div v-if="user_id != 0">
                                <i class="fa fa-trash-alt"
                                   @click="deleteMsg(childComment.id)"
                                   v-if="user_id == childComment.user_id"
                                ></i>
                                <i class="fa fa-reply"
                                   @click="reply(childComment.author,comment.id)"></i>
                                <i class="fa fa-pen"
                                   v-if="user_id == childComment.user_id"
                                   @click="edit(childComment.id,childComment.content)"></i>
                            </div>
                        </div>
                        <div class="comment-content">
                            <span v-bind:class="{'cmt-not-active': childComment.status !== 0}">
                                {{childComment.content}}
                            </span>
                        </div>
                    </div>
                </li>
                <div class="more-cmt">
                    <a href="javascript:;"
                       @click="getListChildComment(comment.id,comment.child.total)"
                       v-if="comment.child.total > 5 && comment.child.total !== parseInt(comment.child.per_page)"
                    >Xem thêm bình luận</a>
                </div>
            </ul>
        </li>
        <div class="more-cmt">
            <a href="javascript:;"
               @click="record = list.total; getListComment()"
               v-if="list.total > record"
            >Xem thêm bình luận</a>
        </div>
    </ul>
</template>

<script>


    export default {
        name: "ListComments",
        props: ['id_movie', 'user_id'],
        data() {
            return {
                data: {
                    id: 0,
                    action: ''
                },
                list: {
                    data: [],
                },
                record: 5,
            }
        },
        created() {
            this.getListComment();
            window.Echo.channel('laravel_database_comments')
                .listen('MessagePosted', (data) => {
                    data.comment['author'] = data.user.name;
                    data.comment['avatar_url'] = data.user.avatar_url;
                    data.comment['child'] = [];
                    if (data.comment.created_at.valueOf() !== data.comment.updated_at.valueOf()) {
                        this.list.data.forEach(function (item) {
                            if (item.id === data.comment.id) {
                                item.content = data.comment.content;
                                item.status = data.comment.status;
                            } else {
                                item.child.data.forEach(function (itemChild) {
                                    if (itemChild.id === data.comment.id) {
                                        itemChild.content = data.comment.content;
                                        itemChild.status = data.comment.status;
                                    }
                                })
                            }
                        })
                    } else {
                        if (data.comment.comment_id !== 0) {
                            this.list.data.forEach(function (item) {
                                if (item.id === data.comment.comment_id) {
                                    item.child.data.push(data.comment)
                                }
                            })
                        } else {
                            this.list.data.push(data.comment)
                        }
                    }
                });
        },
        methods: {
            reply(author, id) {
                let data = {
                    author: author,
                    id: id
                };
                this.$root.$emit("replyTo", data);
                data = {};
            },
            edit(id, content) {
                let data = {
                    id: id,
                    content: content
                };
                this.$root.$emit("editTo", data);
                data = {};
            },
            getListComment() {
                this.axios.get('listcomment/' + this.id_movie + '/' + this.record)
                    .then(res => {
                        this.list = res.data.data
                    })
                    .catch(res => {
                    });
            },
            getListChildComment(comment_id, record) {
                (record === undefined) ? record = 5 : "";
                this.axios.get('listchildcomment/' + comment_id + '/' + record)
                    .then(res => {
                        const child = res.data.data;
                        this.list.data.forEach(function (comment) {
                            if (comment.id === comment_id) {
                                comment.child = child;
                            }
                        });

                    })
                    .catch(res => {
                    });
            },
            deleteMsg(id) {
                this.data.action = 'delete';
                this.data.id = id;
                this.data.status = 1;
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key]);
                    }
                }
                this.$swal.fire({
                    title: 'Bạn có chắc muốn gỡ tin nhắn này?',
                    text: "Tin nhắn này sẽ được gỡ!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.value) {
                        this.axios.post('comment',
                            formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(res => {
                                this.$swal.fire(
                                    'Thành công!',
                                    'Tin nhắn đã được gỡ.',
                                    'success'
                                )
                            })
                            .catch(res => {
                            });
                    }
                });

            },
        },

        mounted() {
        }
    }
</script>

<style scoped>


</style>
