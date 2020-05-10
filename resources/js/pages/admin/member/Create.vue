<template>
    <div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <span class="caption-subject bold uppercase">New Member</span>
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
                                        placeholder="Member Name"
                                        v-model="data.name">
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.name" v-for="error in errors.name">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group">
                            <b-col md="3" class="text-right">
                                <label>Avatar <span>*</span></label>
                            </b-col>
                            <b-col md="9" class="form-group"
                                   :class="{ 'has-error': $v.data.avatar_url.$error || (has_error && errors.avatar_url) }">
                                <vue-dropzone id="upload"
                                              :options="config"
                                              v-on:vdropzone-complete="afterComplete"
                                ></vue-dropzone>
                                <span class="help-block"
                                      v-if="has_error && errors.avatar_url" v-for="error in errors.avatar_url">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group">
                            <b-col md="3" class="text-right">
                                <label>Type <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <select class="form-control border-global" v-model="data.type">
                                        <option value="1">Actor</option>
                                        <option value="2">Director</option>
                                    </select>
                                </div>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.country.$error || (has_error && errors.country_id) }">
                            <b-col md="3" class="text-right">
                                <label>Country <span>*</span></label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <multiselect
                                        v-model="data.country"
                                        tag-placeholder="Add this as new country"
                                        placeholder="Search or add a country"
                                        label="name" track-by="id"
                                        :options="countries"
                                        :close-on-select="true"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        :taggable="true"
                                    >
                                        <template slot="option" slot-scope="{ option }">
                                            <strong>{{ option.name }}</strong>
                                        </template>
                                    </multiselect>
                                    <span class="help-block"
                                          v-if="has_error && errors.countries"
                                          v-for="error in errors.countries">
                                    {{error}}
                                    </span>
                                </div>
                            </b-col>
                        </b-col>

                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.movies.$error || (has_error && errors.movies) }">
                            <b-col md="3" class="text-right">
                                <label>Movies</label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <multiselect
                                        v-model="data.movies"
                                        tag-placeholder="Add this as new movie"
                                        placeholder="Search or add a movie"
                                        label="name" track-by="id"
                                        :options="movies"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        :multiple="true"
                                        :taggable="true"
                                    >
                                        <template slot="option" slot-scope="{ option }">
                                            <strong>{{ option.name }}</strong>
                                        </template>
                                    </multiselect>
                                    <div class="list-name-movies">
                                        <div v-for="movie in data.movies"
                                             :class="{ 'has-error': errorNameInMovie }">
                                            <label>Name in movie {{movie.name}}<span>*</span> :</label>
                                            <input type="text" :id="movie.name"
                                                   class="form-control border-global"
                                                   @change="addNameInMovie"
                                            >
                                        </div>
                                    </div>
                                    <span class="help-block"
                                          v-if="has_error && errors.movies"
                                          v-for="error in errors.movies">
                                    {{error}}
                                    </span>
                                </div>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group border-global"
                               :class="{ 'has-error': $v.data.introduce.$error || (has_error && errors.introduce)  }">
                            <b-col md="3" class="text-right">
                                <label>Introduce <span>*</span></label>
                            </b-col>
                            <b-col md="9" class="form-group" :class="{ 'has-error': $v.data.introduce.$error }">
                                <ckeditor :editor="editor" v-model="data.introduce" :config="editorConfig"></ckeditor>
                                <span class="help-block"
                                      v-if="has_error && errors.introduce" v-for="error in errors.introduce">
                                    {{error}}
                                </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.weight.$error || (has_error && errors.weight)}">
                            <b-col md="3" class="text-right">
                                <label>Weight</label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Weight"
                                        v-model="data.weight"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.weight"
                                      v-for="error in errors.weight">
                                    {{error}}
                                    </span>
                            </b-col>
                        </b-col>
                        <b-col md="12" class="form-group"
                               :class="{ 'has-error': $v.data.height.$error || (has_error && errors.height) }">
                            <b-col md="3" class="text-right">
                                <label>Height</label>
                            </b-col>
                            <b-col md="9">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control border-global"
                                        placeholder="Height"
                                        v-model="data.height"
                                    >
                                </div>
                                <span class="help-block"
                                      v-if="has_error && errors.height"
                                      v-for="error in errors.height">
                                    {{error}}
                                    </span>
                            </b-col>
                        </b-col>
                        <div class="form-actions text-center">
                            <button type="submit" class="btn blue border-global fix-btn">Save</button>
                            <router-link :to="{name: 'admin.member.list'}">
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
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
    import Multiselect from 'vue-multiselect'
    import {required, minLength} from "vuelidate/lib/validators";
    import $ from 'jquery';

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    name: "",
                    type: 1,
                    country_id: [],
                    introduce: "",
                    height: "",
                    weight: "",
                    avatar_url: {},
                    movies: [],
                    actors: [],
                    country: []
                },
                editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the editor.
                },
                movies: [],
                countries: [],
                errorNameInMovie: false,
                has_error: false,
                error: "",
                errors: {},
                success: false,
                config: {
                    url: "http://movie.test/api/image",
                    maxFiles: 1,
                    addRemoveLinks: true
                }
            };
        },
        components: {
            vueDropzone,
            Multiselect,
        },
        validations: {
            data: {
                name: {required, min: minLength(6)},
                introduce: {required},
                avatar_url: {required},
                height: {required},
                weight: {required},
                country: {required},
                movies: {},
            }
        },
        mounted() {
            this.getCountry();
            this.getMovies();
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
                var array_movie = [];
                var error = false;
                this.data.movies.forEach(function (element) {
                    let nameInMovie = document.getElementById(element.name).value;
                    if (nameInMovie === '') {
                        error = true;
                    }
                    var arr = {
                        'id': element.id,
                        'name': nameInMovie,
                    };
                    array_movie.unshift(arr)
                });
                this.errorNameInMovie = error;
                if (this.errorNameInMovie) return;
                this.data.actors = JSON.stringify(array_movie);
                this.data.country_id = this.data.country.id;

                let formData = new FormData();
                for (const key in this.data) {
                    if (this.data.hasOwnProperty(key)) {
                        formData.append(key, this.data[key]);
                    }
                }
                axios.post('auth/member/create',
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
                                    name: 'admin.member.list',
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
            getCountry() {
                this.$http({
                    url: `auth/country`,
                    method: 'GET'
                })
                    .then((res) => {
                        let arr = [];
                        res.data.data.forEach(function (key) {
                            arr.push({id: key.id, name: key.name})
                        });
                        this.countries = arr;
                    }, () => {
                        this.has_error = true;
                    })
            },
            getMovies() {
                this.$http({
                    url: `auth/movie/data`,
                    method: 'GET'
                })
                    .then((res) => {
                        let arr = [];
                        res.data.movie.forEach(function (key) {
                            arr.push({id: key.id, name: key.native_name});
                        });
                        this.movies = arr;
                    }, () => {
                        this.has_error = true;
                    })
            },
            afterComplete(file) {
                this.data.avatar_url = file;
            },
            addNameInMovie(e) {
                if (e.target.value !== '') {
                    if ($(e.target).parent('div').hasClass('has-error')) {
                        $(e.target).parent('div').attr('class', '');
                    }
                }
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
    .list-name-movies {
        overflow-y: scroll;
        max-height: 196.5px;
    }
</style>
