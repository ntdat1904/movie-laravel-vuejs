<template>
    <div class="modal fade" ref="trailer" id="trailer" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label>Episode {{this.modal.episode.episode}}</label>
                    <i class="fas f fa-edit" @click='form = !form'></i>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" style="padding: 0; font-size: 14px; text-align: center">
                    <Media :kind="'video'" :src="this.modal.episode.video_url" controls width="512" v-if="!form"/>
                    <form role="form" method="post" v-if="form">
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.video_url.$error || (has_error && errors.video_url) }">
                            <b-col md="3" style="margin-top: 20px; font-size:20px">
                                <label>Url <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div>
                                    <div class="btn"
                                         @click="input =!input; (text === 'Url') ? text = 'File': text= 'Url'; data.video_url =''"
                                         style="display:table; border: 0; background-color: inherit;">
                                        <i class="fas fa-exchange-alt"></i> {{text}}
                                    </div>
                                    <vue-dropzone id="videoTrailer"
                                                  v-if='input'
                                                  :options="configVideo"
                                                  :class="'border-global'"
                                                  v-on:vdropzone-file-added="addVideo"
                                                  v-on:vdropzone-sending="sendingEventTrailer"
                                                  v-on:vdropzone-removed-file="removedEvent"
                                                  v-on:vdropzone-success="afterCompleteVideo"
                                    ></vue-dropzone>
                                    <input
                                        type="url"
                                        v-else
                                        v-model="data.video_url"
                                        :class="'form-control border-global episode-url'"
                                        placeholder="Url"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.video_url"
                                      v-for="error in errors.video_url">
                                    {{error}}
                                    </span>
                            </b-col>

                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error':  (has_error && errors.episode) }">
                            <b-col md="3" style="margin-top: 20px; font-size:20px"><label>Episode <span>*</span></label>
                            </b-col>
                            <b-col md="9" style="margin-top: 20px; font-size:20px">
                                <input type="number"
                                       v-model="modal.episode.episode"
                                       style="margin-bottom: 5px"
                                       :class="'form-control border-global'"
                                >
                            </b-col>
                            <span class="help-block"
                                  v-if="has_error && errors.episode"
                                  v-for="error in errors.episode">
                                {{error}}
                            </span>
                        </b-col>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" v-if="form" @click="create">Save</button>
                    <button class="btn btn-danger" @click="deleteEpisode">Delete</button>
                    <button type="button" id="close" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import vueDropzone from "vue2-dropzone";
    import {required, minLength, numeric} from "vuelidate/lib/validators";
    import $ from "jquery"
    import Media from '@dongido/vue-viaudio'

    export default {
        name: "TrailerModals",
        props: ['modal'],
        data() {
            return {
                data: {
                    video_url: '',
                    episode: this.modal.episode.episode,
                    movie_id: '',
                    id: ''
                },
                form: false,
                input: true,
                text: 'Url',
                id: this.modal.episode.id,
                has_error: false,
                error: '',
                errors: {},
                trailers: [{'value': ''}],
                configVideo: {
                    url: "/api/uploads",
                    maxFiles: 1,
                    addRemoveLinks: true
                },
                uploads: [],
                afterUploads: [],
            }
        },
        mounted() {
        },
        validations: {
            data: {
                video_url: {},
            },
        },
        methods: {
            create() {
                this.$v.data.$touch();
                if (this.$v.data.$error) return;
                this.data.episode = this.modal.episode.episode;
                this.data.movie_id = this.modal.episode.movie_id;
                this.data.id = this.modal.episode.id;
                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key])
                    }
                }
                axios.post('auth/episode/edit/' + this.modal.episode.id,
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        this.data.video_url = this.modal.episode.video_url = res.data.episode.video_url;
                        this.form = false;
                        this.$parent.getMovie();
                        this.has_error = false;
                    })
                    .catch(res => {
                        this.has_error = true;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            },
            deleteEpisode() {
                axios.post('auth/episode/destroy/' + this.modal.episode.id)
                    .then(res => {
                        $("#trailer").removeClass("in");
                        $(".modal-backdrop").remove();
                        $("#trailer").hide();
                        this.$parent.getMovie()
                    })
                    .catch(res => {
                        this.has_error = true;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            },
            addVideo() {
                this.uploads['index'] = 0;
                this.uploads['name'] = 'trailer_'+0;
            },
            sendingEventTrailer(file, xhr, formData) {
                formData.append('use_id', this.$auth.user().id);
                formData.append('name', this.uploads['name']);
                formData.append('index', this.uploads['index']);
                formData.append('type', true);
                this.uploads = [];

            },
            removedEvent(trailer) {
                let id = this.afterUploads[trailer];
                if (id !== undefined) {
                    axios.post('/uploads/destroy/' + id)
                }
            },
            afterCompleteVideo(file, res) {
                this.afterUploads[res.name] = res.id;
                if (res.type === 'true') {
                    this.trailers[res.index].value = res.path;
                    this.data.video_url= res.path;
                }
            },
        },
        components: {
            Media,
            vueDropzone
        },
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
        border-radius: 10px !important;
    }

    .btn {
        border-radius: 10px !important;
    }

    .modal-content {
        border-radius: 15px !important;
    }

    .modal-footer {
        text-align: center;
        font-size: 25px;
    }
    .vue-dropzone {
        border-style: dashed;
        border-radius: 5px !important;
    }
    .has-error .vue-dropzone {
        border-color: red;
    }
</style>
