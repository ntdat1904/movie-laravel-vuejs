<template>
    <!-- BEGIN CONTENT -->
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <span class="caption-subject bold uppercase">New Movie</span>
                    </div>
                </div>
                <form role="form" @submit.prevent="create" method="post">
                    <!-- native name -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.native_name.$error || (has_error && errors.native_name) }">
                        <b-col md="3" class="text-right">
                            <label>Native Name <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Native Name"
                                    v-model="data.native_name">
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.native_name" v-for="error in errors.native_name">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- vietnamese name -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.vietnamese_name.$error || (has_error && errors.vietnamese_name) }">
                        <b-col md="3" class="text-right">
                            <label>Vietnamese Name <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Vietnamese Name"
                                    v-model="data.vietnamese_name">
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.vietnamese_name"
                                  v-for="error in errors.vietnamese_name">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- poster -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.avatar_url.$error || (has_error && errors.avatar_url) }">
                        <b-col md="3" class="text-right">
                            <label>Poster <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <vue-dropzone id="upload"
                                              :options="config"
                                              v-on:vdropzone-complete="afterComplete"
                                ></vue-dropzone>
                                <span class="help-block"
                                      v-if="has_error && errors.avatar_url"
                                      v-for="error in errors.avatar_url">
                                    {{error}}
                                </span>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- trailer -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Trailer </label>
                        </b-col>
                        <b-col md="9">
                            <div id="trailer" v-for="(trailer, index) in trailers">
                                <label style="display: inline-flex;">
                                    <strong style="margin-right: 10px"># {{index+1}}</strong>
                                    <div :id="'trailer-input-url-'+(index+1)">
                                        <div @click="changeTrailerInput((index+1),'url')" class="btn"
                                             style="padding: 0px 3px  !important;border: 0; background-color: inherit;">
                                            <i class="fas fa-exchange-alt"></i> Url
                                        </div>
                                    </div>
                                    <br>
                                    <div :id="'trailer-input-file-'+(index+1)" class="hidden">
                                        <div @click="changeTrailerInput((index+1),'file')" class="btn"
                                             style="padding: 0px 3px  !important;border: 0; background-color: inherit;">
                                            <i class="fas fa-exchange-alt"></i> File
                                        </div>
                                    </div>
                                </label>
                                <div class="form-group"
                                     :class="{ 'has-error': has_error && errors['trailer_'+(index+1)]}">
                                    <vue-dropzone :id="'trailer_'+(index+1)"
                                                  :options="configVideo"
                                                  :class="'border-global file-'+(index+1)"
                                                  v-on:vdropzone-file-added="addVideo(index,true)"
                                                  v-on:vdropzone-sending="sendingEventTrailer"
                                                  v-on:vdropzone-removed-file="removedEvent('trailer_'+(index))"
                                                  v-on:vdropzone-success="afterCompleteVideo"
                                    ></vue-dropzone>
                                    <input
                                        disabled
                                        type="url"
                                        :class="'form-control border-global hidden url-'+(index+1)"
                                        placeholder="Url"
                                        :id="'trailer_'+(index+1)"
                                        v-model="trailer.value"
                                    >
                                    <a @click="removeTrailer(index)"><i>remove </i></a>
                                    <span class="help-block"
                                          v-if="has_error && errors['trailer_'+(index+1)]"
                                          v-for="error in errors['trailer_'+(index+1)]">
                                                    {{error}}
                                        </span>
                                </div>
                                <div @click="addTrailer" class="img-circle btn"
                                     style="padding: 3px 6px  !important;margin-top: 5px;background-color: inherit;border: solid 1px !important;">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- introduce -->
                    <b-col md="12" class="form-group border-global"
                           :class="{ 'has-error': $v.data.introduce.$error || (has_error && errors.introduce) }">
                        <b-col md="3" class="text-right">
                            <label>Introduce <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                    <textarea v-model="data.introduce" cols="30" rows="5"
                                              class="form-control"></textarea>
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.introduce"
                                  v-for="error in errors.introduce">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- has movie -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Has Movie <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <b-form-checkbox
                                id="checkbox-1"
                                v-model="data.has_movie"
                                name="checkbox-1"
                                value="1"
                                class="form-group"
                                unchecked-value="0"
                            >
                            </b-form-checkbox>
                        </b-col>
                    </b-col>
                    <!-- imdb -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.IMDb_scores.$error || (has_error && errors.IMDb_scores) }">
                        <b-col md="3" class="text-right">
                            <label>IMDb scores <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="IMDb scores"
                                    v-model="data.IMDb_scores"
                                >
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.IMDb_scores"
                                  v-for="error in errors.IMDb_scores">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- country -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.countries.$error || (has_error && errors.countries) }">
                        <b-col md="3" class="text-right">
                            <label>Countries <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <multiselect
                                    v-model="valueCountry"
                                    placeholder="Search a country"
                                    label="name" track-by="id"
                                    :options="countries"
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
                                <span class="help-block"
                                      v-if="has_error && errors.countries"
                                      v-for="error in errors.countries">
                                        {{error}}
                                    </span>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- tags -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.tags.$error || (has_error && errors.tags) }">
                        <b-col md="3" class="text-right">
                            <label>Tags <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <multiselect
                                    v-model="valueTag"
                                    tag-placeholder="Add this as new tag"
                                    placeholder="Search or add a tag"
                                    label="name" track-by="id"
                                    :options="tags"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    :multiple="true"
                                    :taggable="true"
                                    @tag="addTag"
                                >
                                    <template slot="option" slot-scope="{ option }">
                                        <strong>{{ option.name }}</strong>
                                    </template>
                                </multiselect>
                                <span class="help-block"
                                      v-if="has_error && errors.tags"
                                      v-for="error in errors.tags">
                                        {{error}}
                                    </span>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- category -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.categories.$error || (has_error && errors.categories) }">
                        <b-col md="3" class="text-right">
                            <label>Categories <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <multiselect
                                    v-model="valueCategory"
                                    placeholder="Search a category"
                                    label="name" track-by="id"
                                    :options="categories"
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
                                <span class="help-block"
                                      v-if="has_error && errors.categories"
                                      v-for="error in errors.categories">
                                        {{error}}
                                    </span>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- episode number -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.episode_number.$error || (has_error && errors.episode_number) }">
                        <b-col md="3" class="text-right">
                            <label>Episode number <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Episode number "
                                    v-model="data.episode_number"
                                >
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.episode_number"
                                  v-for="error in errors.episode_number">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- episode number current -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.episode_number_current.$error || (has_error && errors.episode_number_current) }">
                        <b-col md="3" class="text-right">
                            <label>Episode number current <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Episode number current "
                                    v-model="data.episode_number_current"
                                >
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.episode_number_current"
                                  v-for="error in errors.episode_number_current">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- reaelease year -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.realease_year.$error || (has_error && errors.realease_year) }">
                        <b-col md="3" class="text-right">
                            <label>Realease Year <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="number"
                                    class="form-control border-global"
                                    placeholder="Realease Year"
                                    v-model="data.realease_year"
                                >
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.realease_year"
                                  v-for="error in errors.realease_year">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- time -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.time.$error || (has_error && errors.time) }">
                        <b-col md="3" class="text-right">
                            <label>Time <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Time"
                                    v-model="data.time"
                                > minutes
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.time"
                                  v-for="error in errors.time">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- resolution -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Resolution <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <b-form-select
                                    v-model="data.resolution"
                                    :options="optionsResolution"
                                    class="form-control"
                                />
                            </div>
                        </b-col>
                    </b-col>
                    <!-- quality -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Quality <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <b-form-select
                                    v-model="data.quality"
                                    :options="optionsQuality"
                                    class="form-control"
                                />
                            </div>
                        </b-col>
                    </b-col>
                    <!-- form -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Form <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <b-form-select
                                    v-model="data.form"
                                    :options="optionsForm"
                                    class="form-control"
                                    @change="changeForm"
                                />
                            </div>
                        </b-col>
                    </b-col>
                    <!-- language -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>Type language <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <b-form-select
                                    v-model="data.type_language"
                                    :options="optionsLang"
                                    class="form-control"
                                />
                            </div>
                        </b-col>
                    </b-col>
                    <!-- production -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': $v.data.production_company.$error || (has_error && errors.production_company) }">
                        <b-col md="3" class="text-right">
                            <label>Production company <span>*</span></label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control border-global"
                                    placeholder="Production company"
                                    v-model="data.production_company"
                                >
                            </div>
                            <span class="help-block"
                                  v-if="has_error && errors.production_company"
                                  v-for="error in errors.production_company">
                                    {{error}}
                                </span>
                        </b-col>
                    </b-col>
                    <!-- list episode -->
                    <b-col md="12" class="form-group">
                        <b-col md="3" class="text-right">
                            <label>List Episode</label>
                        </b-col>
                        <b-col md="9">
                            <div id="episode" v-for="(episode, index) in episodes">

                                <label style="display: inline-flex;">
                                    <strong style="margin-right: 10px"># {{index+1}}</strong>
                                    <div :id="'episode-input-url-'+(index+1)">
                                        <div @click="changeEpisodeInput((index+1),'url')" class="btn"
                                             style="padding: 0px 3px  !important;border: 0; background-color: inherit;">
                                            <i class="fas fa-exchange-alt"></i> Url
                                        </div>
                                    </div>
                                    <br>
                                    <div :id="'episode-input-file-'+(index+1)" class="hidden">
                                        <div @click="changeEpisodeInput((index+1),'file')" class="btn"
                                             style="padding: 0px 3px  !important;border: 0; background-color: inherit;">
                                            <i class="fas fa-exchange-alt"></i> File
                                        </div>
                                    </div>
                                </label>
                                <div class="form-group"
                                     :class="{ 'has-error': has_error && errors['episode_'+(index+1)]}">
                                    <vue-dropzone :id="'episode_'+(index+1)"
                                                  :options="configVideo"
                                                  :class="'border-global episode-file-'+(index+1)"
                                                  v-on:vdropzone-file-added="addVideo(index,false)"
                                                  v-on:vdropzone-sending="sendingEventEpisode"
                                                  v-on:vdropzone-removed-file="removedEvent('episode_'+(index))"
                                                  v-on:vdropzone-success="afterCompleteVideo"
                                    ></vue-dropzone>
                                    <input
                                        disabled
                                        type="url"
                                        :class="'form-control border-global hidden episode-url-'+(index+1)"
                                        placeholder="Url"
                                        :id="'episode_'+(index+1)"
                                        v-model="episode.value"
                                    >
                                    <a @click="removeEpisode(index)"><i>remove </i></a>
                                    <span class="help-block"
                                          v-if="has_error && errors['episode_'+(index+1)]"
                                          v-for="error in errors['episode_'+(index+1)]">
                                                    {{error}}
                                        </span>
                                </div>
                                <div @click="addEpisode" class="img-circle btn"
                                     style="padding: 3px 6px  !important;margin-top: 5px;background-color: inherit;border: solid 1px !important;">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                        </b-col>
                    </b-col>
                    <!-- member -->
                    <b-col md="12" class="form-group"
                           :class="{ 'has-error': (has_error && errors.movies) }">
                        <b-col md="3" class="text-right">
                            <label>Members</label>
                        </b-col>
                        <b-col md="9">
                            <div class="form-group">
                                <multiselect
                                    v-model="data.members"
                                    placeholder="Search a member"
                                    label="name" track-by="id"
                                    :options="members"
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
                                <div class="list-name-movies"
                                     v-if="data.members.length >0"
                                >
                                    <div v-for="member in data.members"
                                         :class="{ 'has-error': errorNameInMovie }">
                                        <label>Name of {{member.name}} in movie <span>*</span> :</label>
                                        <input type="text" :id="member.name"
                                               class="form-control border-global"
                                               @change="addNameInMovie"
                                        >
                                    </div>
                                    <span class="help-block"
                                          v-if="has_error && errors.members"
                                          v-for="error in errors.members">
                                    {{error}}
                                    </span>
                                </div>
                            </div>
                        </b-col>
                    </b-col>
                    <div class="form-actions text-center">
                        <button type="submit" class="btn blue border-global fix-btn">Save</button>
                        <router-link :to="{name: 'admin.movie.list'}">
                            <button type="button" class="btn default border-global fix-btn">Cancel</button>
                        </router-link>
                    </div>
                </form>
            </div>

            <!-- END SAMPLE FORM PORTLET-->
        </div>
        <div class="col-md-3"></div>
    </div>
    <!-- END CONTENT -->
</template>

<script>

    import vueDropzone from "vue2-dropzone";
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import Multiselect from 'vue-multiselect'
    import {required, minLength, numeric} from "vuelidate/lib/validators";
    import $ from 'jquery';

    const type_language = ['Sub', 'EN'];
    const resolution = ['CAM', 'HD', 'FHD'];
    const quality = ['Good', 'Normal'];
    const form = ['Odd', 'Set'];

    export default {
        name: "ContentMain",
        data() {
            return {
                data: {
                    native_name: '',
                    vietnamese_name: '',
                    has_movie: 1,
                    introduce: '',
                    avatar_url: {},
                    IMDb_scores: 0,
                    time: 0,
                    episode_number_current: '',
                    episode_number: '',
                    realease_year: '',
                    form: 'Odd',
                    production_company: '',
                    resolution: 'CAM',
                    quality: 'Normal',
                    type_language: 'EN',
                    countries: [],
                    tags: [],
                    categories: [],
                    countEpisode: 1,
                    episode_1: '',
                    members: [],
                    actors: [],
                    trailers: [],
                    episodes: [],
                },
                editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the editor.
                },
                config: {
                    url: "/api/image",
                    maxFiles: 1,
                    addRemoveLinks: true
                },
                configVideo: {
                    url: "/api/uploads",
                    maxFiles: 1,
                    addRemoveLinks: true
                },
                countries: [],
                valueCountry: [],
                categories: [],
                valueCategory: [],
                tags: [],
                valueTag: [],
                members: [],
                valueMember: [],
                password: '',
                has_error: false,
                error: '',
                errors: {},
                optionsResolution: resolution,
                optionsLang: type_language,
                optionsQuality: quality,
                optionsForm: form,
                success: false,
                trailers: [{'value': ''}],
                episodes: [{'value': ''},],
                errorNameInMovie: false,
                uploads: [],
                afterUploads: [],
                onLoading: true,
            }
        },
        ready: function () {
        },
        components: {
            vueDropzone,
            Multiselect,
        },
        validations: {
            data: {
                native_name: {required, min: minLength(2)},
                vietnamese_name: {required, min: minLength(2)},
                introduce: {required},
                time: {required, numeric},
                episode_number_current: {required},
                episode_number: {required},
                realease_year: {required},
                avatar_url: {required},
                production_company: {required},
                IMDb_scores: {required},
                countries: {required},
                tags: {required},
                categories: {required},
            },
        },
        mounted() {
            this.getCountry();
            this.getCategories();
            this.getTags();
            this.getMembers();
        },
        methods: {
            addTrailer: function () {
                this.trailers.push({value: ''});
            },
            removeTrailer(index) {
                this.trailers.splice(index, 1);
            },
            addEpisode: function () {
                this.episodes.push({value: ''});
            },
            removeEpisode(index) {
                this.episodes.splice(index, 1);
            },
            create() {
                const trailers = [];
                this.trailers.forEach(function (item) {
                    for (const key in item) {
                        trailers.push(item[key])
                    }

                });
                this.data.trailers = trailers;

                const episodes = [];
                this.episodes.forEach(function (item) {
                    for (const key in item) {
                        episodes.push(item[key])
                    }

                });
                this.data.episodes = episodes;
                const array_country = [];
                const array_tag = [];
                const array_category = [];
                const array_member = [];

                this.valueCountry.forEach(function (element) {
                    array_country.unshift(element.id)
                });
                this.data.countries = array_country;

                this.valueTag.forEach(function (element) {
                    array_tag.unshift(element.id)
                });
                this.data.tags = array_tag;

                this.valueCategory.forEach(function (element) {
                    array_category.unshift(element.id)
                });
                this.data.categories = array_category;

                let error = false;
                this.data.members.forEach(function (element) {
                    let nameInMovie = document.getElementById(element.name).value;
                    if (nameInMovie === '') {
                        error = true;
                    }
                    var arr = {
                        'id': element.id,
                        'name': nameInMovie,
                    };
                    array_member.unshift(arr)
                });
                this.errorNameInMovie = error;
                if (this.errorNameInMovie) return;
                this.data.actors = JSON.stringify(array_member);

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
                axios.post('auth/movie/create',
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
                                    name: 'admin.movie.list',
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
                        this.countries = arr
                    }, () => {
                        this.has_error = true
                    })
            },
            getCategories() {
                this.$http({
                    url: `auth/category/data`,
                    method: 'GET'
                })
                    .then((res) => {
                        let arr = [];
                        res.data.categories.forEach(function (key) {
                            arr.push({id: key.id, name: key.name})
                        });
                        this.categories = arr
                    }, () => {
                        this.has_error = true
                    })
            },
            getTags() {
                this.$http({
                    url: `auth/tag/data`,
                    method: 'GET'
                })
                    .then((res) => {
                        let arr = [];
                        res.data.tags.forEach(function (key) {
                            arr.push({id: key.id, name: key.name})
                        });
                        this.tags = arr
                    }, () => {
                        this.has_error = true
                    })
            },
            getMembers() {
                this.$http({
                    url: `auth/member/data`,
                    method: 'GET'
                })
                    .then((res) => {
                        let arr = [];
                        res.data.members.forEach(function (key) {
                            arr.push({id: key.id, name: key.name});
                        });
                        this.members = arr;
                    }, () => {
                        this.has_error = true;
                    })
            },
            afterComplete(file) {
                this.data.avatar_url = file;
            },
            addVideo(id, type) {
                this.uploads['index'] = id;
                if (type) {
                    this.uploads['name'] = 'trailer_' + id;
                } else {
                    this.uploads['name'] = 'episode_' + id;
                }
            },
            sendingEventTrailer(file, xhr, formData) {
                formData.append('use_id', this.$auth.user().id);
                formData.append('name', this.uploads['name']);
                formData.append('index', this.uploads['index']);
                formData.append('type', true);
                this.uploads = [];
            },
            sendingEventEpisode(file, xhr, formData) {
                formData.append('use_id', this.$auth.user().id);
                formData.append('name', this.uploads['name']);
                formData.append('index', this.uploads['index']);
                formData.append('type', false);
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
                } else {
                    this.episodes[res.index].value = res.path;
                }
            },
            changeTrailerInput(index, type) {
                this.data['trailer_' + index] = '';
                if (type === 'url') {
                    this.removedEvent('trailer_' + index);
                    let nameClass = 'trailer-input-' + type + '-' + index;
                    if (!document.getElementById(nameClass).classList.contains('hidden')) {
                        document.getElementById(nameClass).classList.add('hidden');
                        document.getElementById('trailer-input-file-' + index).classList.remove('hidden');
                        document.querySelector('.file-' + index).classList.add('hidden');
                        document.querySelector('.file-' + index).disabled = true;
                        document.querySelector('.url-' + index).classList.remove('hidden');
                        document.querySelector('.url-' + index).disabled = false

                    }
                } else {
                    let nameClass = 'trailer-input-' + type + '-' + index;
                    if (!document.getElementById(nameClass).classList.contains('hidden')) {
                        document.getElementById(nameClass).classList.add('hidden');
                        document.getElementById('trailer-input-url-' + index).classList.remove('hidden');
                        document.querySelector('.url-' + index).classList.add('hidden');
                        document.querySelector('.url-' + index).disabled = true;
                        document.querySelector('.file-' + index).classList.remove('hidden');
                        document.querySelector('.file-' + index).disabled = false;
                    }
                }
            },
            changeEpisodeInput(index, type) {
                this.data['episode_' + index] = '';
                if (type === 'url') {
                    let nameClass = 'episode-input-' + type + '-' + index;
                    if (!document.getElementById(nameClass).classList.contains('hidden')) {
                        document.getElementById(nameClass).classList.add('hidden');
                        document.getElementById('episode-input-file-' + index).classList.remove('hidden');
                        document.querySelector('.episode-file-' + index).classList.add('hidden');
                        document.querySelector('.episode-file-' + index).disabled = true;
                        document.querySelector('.episode-url-' + index).classList.remove('hidden');
                        document.querySelector('.episode-url-' + index).disabled = false;

                    }
                } else {
                    let nameClass = 'episode-input-' + type + '-' + index;
                    if (!document.getElementById(nameClass).classList.contains('hidden')) {
                        document.getElementById(nameClass).classList.add('hidden');
                        document.getElementById('episode-input-url-' + index).classList.remove('hidden');
                        document.querySelector('.episode-url-' + index).classList.add('hidden');
                        document.querySelector('.episode-url-' + index).disabled = true;
                        document.querySelector('.episode-file-' + index).classList.remove('hidden');
                        document.querySelector('.episode-file-' + index).disabled = false;
                    }
                }
            },
            changeForm(event) {
                this.data.countEpisode = 1;
                this.episodes = [0];
            },
            addNameInMovie(e) {
                if (e.target.value !== '') {
                    if ($(e.target).parent('div').hasClass('has-error')) {
                        $(e.target).parent('div').attr('class', '');
                    }
                }
            },
            addTag(newTag) {
                let formData = new FormData();
                formData.append('name', newTag);
                this.axios.post('auth/tag/create',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(res => {
                        this.getTags();
                        this.valueTag.push({id: res.data.tag.id, name: res.data.tag.name})
                    })
                    .catch(res => {
                        this.has_error = true;
                        this.error = res.response.data.error;
                        this.errors = res.response.data.errors || {};
                    })
            }
        },
        beforeCreate() {
            axios.post('uploads/destroys');
        }
    }
</script>

<style scoped>
    @import "../../../../../public/assets/global/css/vue2Dropzone.min.css";

    label span {
        color: red;
    }

    label {
        margin-top: 7.5px;
    }

    .list-name-movies {
        overflow-y: scroll;
        max-height: 196.5px;
        padding-bottom: 10px;
    }

    .vue-dropzone {
        border-style: dashed;
        border-radius: 5px !important;
    }
</style>
