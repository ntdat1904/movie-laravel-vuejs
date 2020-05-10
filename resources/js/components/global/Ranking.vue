<template>
    <b-col md="2">
        <b-col md="12">
            <h2 class="title-rank-h2">BẢNG XẾP HẠNG</h2>
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_15_1" data-toggle="tab"> Phim lẻ</a>
                    </li>
                    <li>
                        <a href="#tab_15_2" data-toggle="tab"> Phim Bộ </a>
                    </li>
                    <li>
                        <a href="#tab_15_3" data-toggle="tab"> Xem nhiều </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_15_1">
                        <div class="rank-content">
                            <b-col md="12" v-for="movie in data.odd" :key="movie.id">
                                <router-link :to="{ name: 'movie', params: { id: movie.id}}" class="link-rank"
                                             tag="a">
                                    <div class="rank-left">
                                        <img class="carousel-cell-image" :src="movie.avatar_url"/>
                                    </div>
                                    <div class="rank-right">
                                        <h6 class="elipsis">
                                            {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                        <p class="elipsis">
                                            {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                                        <span>View: {{movie.number_view}}</span>
                                    </div>
                                </router-link>
                            </b-col>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_15_2">
                        <div class="rank-content">
                            <b-col md="12" v-for="movie in data.set" :key="movie.id">
                                <router-link :to="{ name: 'movie', params: { id: movie.id}}" class="link-rank"
                                             tag="a">
                                    <div class="rank-left">
                                        <img class="carousel-cell-image" :src="movie.avatar_url"/>
                                    </div>
                                    <div class="rank-right">
                                        <h6 class="elipsis">
                                            {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                        <p class="elipsis">
                                            {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                                        <span>View: {{movie.number_view}}</span>
                                    </div>
                                </router-link>
                            </b-col>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_15_3">
                        <div class="rank-content">
                            <b-col md="12" v-for="movie in data.view" :key="movie.id">
                                <router-link :to="{ name: 'movie', params: { id: movie.id}}" class="link-rank"
                                             tag="a">
                                    <div class="rank-left">
                                        <img class="carousel-cell-image" :src="movie.avatar_url"/>
                                    </div>
                                    <div class="rank-right">
                                        <h6 class="elipsis">
                                            {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                        <p class="elipsis">
                                            {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                                        <span>View: {{movie.number_view}}</span>
                                    </div>
                                </router-link>
                            </b-col>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </b-col>
        <b-col md="12">
            <h2 class="title-rank-h2">Phim sắp chiếu</h2>
            <div class="list-fim">
                <div class="rank-content">
                    <b-col md="12" v-for="movie in data.has" :key="movie.id">
                        <router-link :to="{ name: 'movie', params: { id: movie.id}}" class="link-rank" tag="a">
                            <div class="rank-left">
                                <img class="carousel-cell-image" :src="movie.avatar_url"/>
                            </div>
                            <div class="rank-right">
                                <h6 class="elipsis">
                                    {{movie.vietnamese_name +' ('+ movie.realease_year +')'}} </h6>
                                <p class="elipsis">
                                    {{movie.native_name +' ('+ movie.realease_year +')'}} </p>
                                <span>View: {{movie.number_view}}</span>
                            </div>
                        </router-link>
                    </b-col>
                </div>
            </div>
        </b-col>
        <b-col md="12">
            <h2 class="title-rank-h2">Tag</h2>
            <div class="list-fim">
                <ul class="tags">
                    <li v-for="tag in data.tags"><a href="#" class="tag">{{tag.name}}</a></li>
                </ul>
            </div>
        </b-col>
    </b-col>
</template>

<script>
    export default {
        name: "Ranking",
        data() {
            return {
                data: []
            }
        },
        mounted() {
            this.index()
        },
        methods: {
            index() {
                axios.get('/ranking')
                    .then(res => {
                            this.data = res.data.data
                        },
                        () => {
                            this.has_error = true;
                        }
                    );
            },
        },
    }

</script>

<style scoped>
</style>
