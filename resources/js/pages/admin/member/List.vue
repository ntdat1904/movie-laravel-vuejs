<template>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <span class="caption-subject bold uppercase">Member List</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <b-col md="12" class="">
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
                    <button class="btn bold yellow border-global" style="margin: 10px 15px 0 0" @click="getMembers">
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
                            @change="getMembers()"
                            class="form-control input-sm input-xsmall input-inline "/>
                    </b-form-group>
                </b-col>
                <b-col md="6" class="my-1  text-right">
                    <div class="btn-group">
                        <router-link :to="{name: 'admin.member.create'}" class="nav-link">
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
                :items="members"
                :fields="fields"
                striped hover
                @head-clicked="onFiltered"
                class="table table-striped table-bordered table-hover table-checkable order-column"
            >
                <template slot="thead-top" slot-scope="data">
                    <tr style="position: absolute">
                        <th style="border: none;">
                            <b-form-checkbox style="width: 100px" v-model="selectAll" @change="selectAllchange">
                            </b-form-checkbox>
                        </th>
                    </tr>
                </template>
                <template slot="checkbox" slot-scope="data">
                    <b-form-checkbox v-bind:value="data.item.id" v-model="arrId">
                    </b-form-checkbox>
                </template>
                <template slot="name" slot-scope="data">
                    <b-img v-if="data.item.avatar_url != null && data.item.img"
                           class="img-circle"
                           v-bind:src="data.item.avatar_url"
                           alt=""
                           style="width: 30px; height: 30px"
                    ></b-img>
                    <span>{{data.value}}</span>
                </template>
                <template slot="type" slot-scope="data">
                    <span v-if="data.value == 1"> Actor </span>
                    <span v-if="data.value == 2"> Director </span>
                </template>
                <template slot="height" slot-scope="data">
                    <span> {{data.value}} m </span>
                </template>
                <template slot="weight" slot-scope="data">
                    <span> {{data.value}} Kg </span>
                </template>
                <template slot="actions" slot-scope="data">
                    <div class="actions">
                        <router-link
                            :to="{ name: 'admin.member.detail', params: { id: data.item.id }}"
                            class="btn btn-circle btn-icon-only btn-default">
                            <i class="icon-eye"></i>
                        </router-link>
                        <router-link
                            :to="{ name: 'admin.member.edit', params: { id: data.item.id }}"
                            class="btn btn-circle btn-icon-only btn-default">
                            <i class="icon-wrench"></i>
                        </router-link>
                        <a class="btn btn-circle btn-icon-only btn-default" data-toggle="modal" href="#basic"
                           @click="singelModal(data.item.id)"
                        >
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
            <UserModals
                v-bind:modal="{
                id: idModal,
                param: arrId,
                type: typeModal,
                name: 'member'
                }"></UserModals>
        </div>
    </div>
</template>

<script>
    import UserModals from "../../../components/admin/global/Modals"
    import Paginate from 'vuejs-paginate'

    const dataSearch =
        {
            id: '',
            name: '',
            type: '',
            country: '',
            height: '',
            weight: '',
            from: '',
            to: '',
            sort: '',
            order: ''
        };
    export default {
        name: "user-list.vue",
        data() {
            return {
                has_error: false,
                msg: '',
                msgStatus: false,
                users: [],
                members: [],
                isFilter: false,
                oldUsers: [],
                oldMembers: [],
                status: '',
                arrId: [],
                totalRows: 0,
                idModal: 0,
                typeModal: "",
                options: ['ID', 'Name', 'Type', 'Country', 'Weight', 'Height'],
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
                        key: 'type',
                        label: 'Type',
                        isActiveFilter: false
                    },
                    {
                        key: 'name',
                        label: 'Name',
                        isActiveFilter: false
                    },
                    {
                        key: 'country_name',
                        label: 'Country',
                        isActiveFilter: false
                    },
                    {
                        key: 'weight',
                        label: 'Weight',
                        isActiveFilter: false
                    },
                    {
                        key: 'height',
                        label: 'Height',
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
                        key: 'Name',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_name" placeholder="Name" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Country',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_country" placeholder="Country" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Type',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<select id = "search_type" class = "form-control input-sm input-small input-inline" style = "width: 100% !important; border-radius: 5px !important" >\n' +
                            '  <option value="">All</option>\n' +
                            '  <option value="2">Director</option>\n' +
                            '  <option value="1">Actor</option>' +
                            '</div>'
                    },
                    {
                        key: 'Height',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_height" placeholder="Height" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
                            '</div>'
                    },
                    {
                        key: 'Weight',
                        status: false,
                        html: '<div role="group" class="input-group" style="width: 50vh">' +
                            '<input type="text" id="search_weight" placeholder="Weight" ' +
                            'class="form-control input-sm input-small input-inline" style="width: 100% !important; border-radius: 5px !important">' +
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
                    path: "http://movie.test/api/auth/member",
                    prev_page_url: null,
                    to: 1,
                    page: 1,
                }
            }
        },
        mounted() {
            this.getMembers()
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
                this.getMembers();
            },
            getMembers() {
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
                            case "name":
                                this.arrayField.filter(f => f.key === 'Name')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "type":
                                this.arrayField.filter(f => f.key === 'Type')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "height":
                                this.arrayField.filter(f => f.key === 'Height')[0].status = true;
                                document.getElementById('search_' + key).value = this.dataSearch[key];
                                break;
                            case "weight":
                                this.arrayField.filter(f => f.key === 'Weight')[0].status = true;
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

                this.axios.get('auth/member', {params: query})
                    .then((res) => {
                        let data = [];
                        data = res.data.members;
                        for (const key in  data) {
                            if (key !== 'data') {
                                this.paginate[key] = data[key];
                            } else {
                                this.members = res.data.members.data;
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
            getUser(id) {
                this.$router.push('/edit/' + id)
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
                    this.getMembers();
                }
            },
            singelModal(id) {
                this.idModal = id;
                this.typeModal = 'singel';
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
                    case "Name":
                        this.dataSearch['name'] = '';
                        break;
                    case "Type":
                        this.dataSearch['type'] = '';
                        break;
                    case "Weight":
                        this.dataSearch['weight'] = '';
                        break;
                    case "Height":
                        this.dataSearch['height'] = '';
                        break;
                    case "Create At":
                        this.dataSearch['to'] = '';
                        this.dataSearch['from'] = '';
                        break;
                }
            },
            search() {

                for (const key in dataSearch) {

                    if (document.getElementById('search_' + key) !== null) {
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
                this.getMembers();
            }
        },
        computed: {
            selectAll: {
                get: function () {
                    return this.members ? this.arrId.length === this.members.length : false;
                },
                set: function (value) {
                    var selected = [];

                    if (value) {
                        this.members.forEach(function (user) {
                            selected.push(user.id);
                        });
                        this.arrId = selected;
                    }
                }
            },
        },
        components: {
            UserModals,
            Paginate
        }

    }
</script>

<style scoped>

    .filter {
        border: 1px solid #e7ecf1;
        border-radius: 5px !important;
    }
</style>

