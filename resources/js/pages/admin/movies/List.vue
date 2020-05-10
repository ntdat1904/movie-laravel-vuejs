<template>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <span class="caption-subject bold uppercase">Movie List</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <b-col md="12">
                    <div class="alert alert-success alert-dismissable" v-if="msgStatus">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{msg}}
                        <a href="" class="alert-link" @click="msgStatus = !msgStatus"> Please check this one as
                            well </a>
                    </div>
                    <b-col md="12" class="my-1" v-for="field in arrayField" v-bind:key="field.key">
                        <div v-if="field.status" class="row" style="display: inline-flex">
                            <b-form-group class="mb-0">
                                <b-form-select
                                    :class="field.key"
                                    :options="options"
                                    :value="field.key"
                                    class="form-control input-sm input-small input-inline mb-3 border-global"
                                    @input="chooseFilter"
                                    @change="choosen(field.key)"
                                ></b-form-select>
                            </b-form-group>
                            <b-form-group class="mb-0" :id="field.key" v-html="field.html"></b-form-group>
                            <a @click="removeFilter(field.key)" style="margin: 3px 0 0 5px"><i>remove</i></a>
                        </div>
                    </b-col>
                    <button @click="addFilter()" class="img-circle"
                            style="margin-bottom: 15px;background-color: inherit;border: solid 1px !important;"><i
                        class="fas fa-plus"></i></button>
                </b-col>
                <b-col md="12" class="text-right">
                    <button class="btn bold gray border-global" style="margin: 10px 15px 0 0" @click="reset">
                        Reset
                    </button>
                    <button class="btn bold yellow border-global" style="margin: 10px 15px 0 0" @click="getMovies">
                        Search
                    </button>
                </b-col>
            </div>
            <b-col md="12">
                <b-col md="6" class="my-1">
                    <b-form-group label-cols-sm="0" class="mb-0">
                        <label>number per page</label>
                        <b-form-select
                            style="width: 60px !important;"
                            :options="paginate.pageOptions"
                            v-model="paginate.per_page"
                            @change="getMovies()"
                            class="form-control input-sm input-xsmall input-inline "/>
                    </b-form-group>
                </b-col>
                <b-col md="6" class="my-1  text-right">
                    <div class="btn-group">
                        <router-link :to="{name: 'admin.movie.create'}" class="nav-link">
                            <button class="btn bold green border-global"> New
                                <i class="fa fa-plus"></i>
                            </button>
                        </router-link>
                        <a class="nav-link">
                            <button class="btn bold red border-global"
                                    data-toggle="modal" href="#basic"
                                    @click="typeModal='multi'"
                            > Delete
                                <i class="fa fa-trash"></i>
                            </button>
                        </a>
                    </div>
                </b-col>
            </b-col>
            <b-table
                id="myTable"
                :items="movies"
                :fields="fields"
                striped hover
                @head-clicked="onFiltered"
                class="table table-striped table-bordered table-hover table-checkable order-column">
                <template slot="thead-top" slot-scope="data">
                    <tr style="position: absolute">
                        <th style="border: none;">
                            <b-form-checkbox v-model="selectAll" @change="selectAllchange">
                            </b-form-checkbox>
                        </th>
                    </tr>
                </template>
                <template slot="checkbox" slot-scope="data">
                    <b-form-checkbox v-bind:value="data.item.id" v-model="arrId">
                    </b-form-checkbox>
                </template>
                <template slot="actions" slot-scope="data">
                    <div class="actions">
                        <router-link
                            :to="{ name: 'admin.movie.detail', params: { id: data.item.id }}"
                            class="btn btn-circle btn-icon-only btn-default">
                            <i class="icon-eye"></i>
                        </router-link>
                        <router-link
                            :to="{ name: 'admin.movie.edit', params: { id: data.item.id }}"
                            class="btn btn-circle btn-icon-only btn-default">
                            <i class="icon-wrench"></i>
                        </router-link>
                        <a class="btn btn-circle btn-icon-only btn-default" data-toggle="modal" href="#basic"
                           @click="singelModal(data.item.id)">
                            <i class="icon-trash"></i>
                        </a>
                    </div>
                </template>
            </b-table>
            <paginate
                v-if="paginate.last_page > 1"
                v-model="paginate.current_page"
                :page-count="paginate.last_page"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'">
            </paginate>
            <Modals
                v-bind:modal="{
                id: idModal,
                param: arrId,
                type: typeModal,
                name: 'movie'
                }"></Modals>
        </div>
    </div>
</template>
<script>
    import Modals from "../../../components/admin/global/Modals"
    import Paginate from 'vuejs-paginate'

    const dataSearch =
        {
            id: '',
            free_word: '',
            IMDb_scores: '',
            resolution: '',
            quality: '',
            from: '',
            to: '',
            sort: '',
            order: ''
        };
    export default {
        name: "user-list.vue",
        props: ["arrIdParent"],
        data() {
            return {
                has_error: false,
                movies: [],
                msg: '',
                msgStatus: false,
                isFilter: false,
                oldMovies: [],
                status: '',
                arrId: [],
                idModal: 0,
                typeModal: "",
                options: ['ID', 'Quality', 'Resolution', 'IMDB', 'Free Word', 'Create At'],
                fields: [
                    {
                        key: 'checkbox',
                        label: '',
                    },
                    {
                        key: 'id',
                        label: '#',
                        isActiveFilter: true
                    },
                    {
                        key: 'native_name',
                        label: 'Native Name',
                        isActiveFilter: false
                    },
                    {
                        key: 'vietnamese_name',
                        label: 'VietNamese Name',
                        isActiveFilter: false
                    },
                    {
                        key: 'countries_name',
                        label: 'Country',
                        isActiveFilter: false
                    },
                    {
                        key: 'realease_year',
                        label: 'Year',
                        isActiveFilter: false
                    },
                    {
                        key: 'resolution',
                        label: 'Resolution',
                        isActiveFilter: false
                    },
                    {
                        key: 'quality',
                        label: 'Quality',
                        isActiveFilter: false
                    },
                    {
                        key: 'IMDb_scores',
                        label: 'IMDB',
                        isActiveFilter: false
                    },
                    {
                        key: 'production_company',
                        label: 'INC',
                        isActiveFilter: false
                    },
                    {
                        key: 'actions',
                        label: 'Actions',
                    },
                ],
                Fields: [],
                arrayField: [
                    {
                        key: 'ID',
                        status: true,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_id" placeholder="Number to ID" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Resolution',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<select id = "search_resolution" class = "form-control input-sm input-small input-inline" style = "width: 100% !important; border-radius: 5px !important" >\n' +
                            '  <option value="">All</option>\n' +
                            '  <option value="HD">HD</option>\n' +
                            '  <option value="FHD">FHD</option>\n' +
                            '  <option value="CAM">CAM</option>' +
                            '</div>'
                    },
                    {
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<select id = "search_quality" class = "form-control input-sm input-small input-inline" style = "width: 100% !important; border-radius: 5px !important" >\n' +
                            '  <option value="">All</option>\n' +
                            '  <option value="Good">Good</option>\n' +
                            '  <option value="Normal">Normal</option>\n' +
                            '</div>',
                        key: 'Quality',
                        status: false
                    },
                    {
                        key: 'IMDB',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_IMDb_scores" placeholder="IMDB scores" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Free Word',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_free_word" placeholder="Free Word" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Create At',
                        status: false,
                        html:
                            '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="date" id="search_from" placeholder="From" ' +
                            'class="form-control input-sm input-small input-inline border-global" style="width: 48% !important; border-radius: 5px !important">' +
                            '<input type="date" id="search_to" placeholder="To" ' +
                            'class="form-control input-sm input-small input-inline border-global" style="width: 48% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                ],
                dataSearch: dataSearch,
                oldDataSearch: [],
                paginate: {
                    total: 0,
                    current_page: 1,
                    per_page: 5,
                    pageOptions: [5, 10, 15],
                    from: 1,
                    last_page: 3,
                    path: "http://movie.test/api/auth/movie",
                    prev_page_url: null,
                    to: 1,
                    page: 1,
                }
            };
        },
        mounted() {
            this.getMovies();
        },
        created() {
            if (this.$route.params.status) {
                this.msgStatus = true;
                this.msg = this.$route.params.msg;
            }
            for (const key in this.$route.query) {
                if (key === 'page' || key === 'per_page') {
                    this.paginate[key] = this.$route.query[key];
                } else {
                    this.dataSearch[key] = this.$route.query[key];
                    this.oldDataSearch[key] = this.$route.query[key];
                }
            }
            if (Object.values(this.oldDataSearch).length > 0) {
                this.arrayField.forEach(function (item) {
                    item.status = true;
                })
            }
        },
        methods: {
            clickCallback(pageNum) {
                this.paginate.query = true;
                this.paginate.current_page = this.paginate.page = pageNum;
                this.paginate.current_page = pageNum;
                this.getMovies();
            },
            getMovies() {
                this.search();

                if (Object.values(this.oldDataSearch).length > 0) {
                    this.arrayField.forEach(function (item) {
                        item.status = false;
                    });
                    this.dataSearch = this.oldDataSearch;
                    this.oldDataSearch = [];
                    for (const key in this.dataSearch) {
                        switch (key) {
                            case "id":
                                this.arrayField.filter(f => f.key === 'ID')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "free_word":
                                this.arrayField.filter(f => f.key === 'Free Word')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "quality":
                                this.arrayField.filter(f => f.key === 'Quality')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "resolution":
                                this.arrayField.filter(f => f.key === 'Resolution')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "from":
                                this.arrayField.filter(f => f.key === 'Create At')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "to":
                                this.arrayField.filter(f => f.key === 'Create At')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                        }
                    }
                }
                const query = {};
                for (const key in this.paginate) {
                    if (key === 'page' || key === 'per_page') {
                        query[key] = this.paginate[key];
                    }
                }
                for (const key in this.dataSearch) {
                    if (this.dataSearch[key] !== '') {
                        query[key] = this.dataSearch[key];
                    }
                }
                this.$router.push({query: query});
                this.axios.get('auth/movie', {params: query})
                    .then((res) => {
                        let data = [];
                        data = res.data.movies;
                        for (const key in  data) {
                            if (key !== 'data') {
                                this.paginate[key] = data[key];
                            } else {
                                this.movies = res.data.movies.data;
                            }
                        }
                        if (this.$route.query.page > this.paginate.last_page) {
                            query.page = this.paginate.last_page;
                            this.$router.push({query: query});
                        }
                    }, () => {
                        this.has_error = true;
                    });
            },
            selectAllchange() {
                if (this.arrId.length === this.members.length) {
                    this.arrId = [];
                }
            },
            onFiltered(filteredItems) {
                let sort = this.dataSearch['sort'];
                if (filteredItems !== 'actions') {
                    dataSearch['order'] = filteredItems;
                    dataSearch['sort'] = (sort === 'DESC') ? 'ASC' : 'DESC';
                    this.dataSearch = dataSearch;
                    this.getMovies();
                }
            },
            singelModal(id) {
                this.idModal = id
                this.typeModal = 'singel'
            },
            addFilter() {
                for (let i = 0; i < this.arrayField.length; i++) {
                    if (!this.arrayField[i].status) {
                        this.arrayField[i].status = true;
                        break;
                    }
                }
            },
            chooseFilter(field) {
                this.text = field
            },
            choosen(key) {
                if (key !== this.text) {
                    document.getElementById(key).setAttribute('id', this.text);
                    document.getElementById(this.text).innerHTML = this.arrayField.filter(f => f.key === key)[0].html;
                    this.arrayField.filter(f => f.key === this.text)[0].status = true;
                    this.arrayField.filter(f => f.key === key)[0].status = false;
                    document.getElementsByClassName(key).value = this.text;
                    this.removeFilter(key);
                }
            },
            removeFilter(field) {
                this.arrayField.filter(f => f.key === field)[0].status = false;
                switch (field) {
                    case "ID":
                        this.dataSearch['id'] = '';
                        break;
                    case "Quality":
                        this.dataSearch['quality'] = '';
                        break;
                    case "Resolution":
                        this.dataSearch['resolution'] = '';
                        break;
                    case "IMDB":
                        this.dataSearch['IMDb_scores'] = '';
                        break;
                    case "Free Word":
                        this.dataSearch['free_word'] = '';
                        break;
                    case "Create At":
                        this.dataSearch['to'] = '';
                        this.dataSearch['from'] = '';
                        break;
                }
            },
            search() {
                for (const key in dataSearch) {
                    if (document.getElementById('search_' + key) != null) {
                        dataSearch[key] = document.getElementById('search_' + key).value;
                    }
                }
                this.dataSearch = dataSearch;
            },
            reset() {
                this.arrayField.forEach(function (item) {
                    item.status = false;
                });
                this.arrayField.filter(f => f.key === 'ID')[0].status = true;
                for (const key in dataSearch) {
                    if (document.getElementById('search_' + key) != null) {
                        document.getElementById('search_' + key).value = '';
                    }
                    dataSearch[key] = '';
                }
                this.dataSearch = dataSearch;
                this.getMovies();
            }
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.movies ? this.arrId.length === this.movies.length : false;
                },
                set: function (value) {
                    var selected = [];

                    if (value) {
                        this.movies.forEach(function (user) {
                            selected.push(user.id);
                        });
                        this.arrId = selected;
                    }
                }
            },
        },
        components: {
            Modals,
            Paginate
        }
    };
</script>

<style scoped>
</style>
