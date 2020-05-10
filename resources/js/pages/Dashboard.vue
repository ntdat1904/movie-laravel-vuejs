<template>
    <div >
        <Header></Header>
        <b-col class="">
            <b-col md="2" style="height: 20px; background-color: transparent">
                <img style="width: 100%; height: fit-content; padding-top: 70px" src="https://www.socialmediaexaminer.com/wp-content/uploads/2015/06/vvr-linkedin-ads-pinterestimage.png" alt="">
            </b-col>
            <router-view></router-view>
            <Ranking></Ranking>
        </b-col>
    </div>
</template>
<script>
    import Header from '../components/global/Header'
    import Ranking from '../components/global/Ranking'

    export default {
        data() {
            return {
                show_first: true,
                data: []
                //
            }
        },
        components: {
            Header,
            Ranking
        },

    }
</script>
<style scoped>
    @import "../../../public/css/frontend.css";

</style>
