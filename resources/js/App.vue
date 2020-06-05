<template>
    <div id="app">
        <header-block v-if="this.isAuthenticated"></header-block>
        <router-view></router-view>
    </div>
</template>

<script>
    import Header from './components/layouts/Header';
    import {mapGetters} from 'vuex';

    export default {
        name: "app",
        components: {
            HeaderBlock: Header
        },
        computed: {
            ...mapGetters("user", {
                isAuthenticated: 'isAuthenticated'
            }),
        },
    }
</script>

<style scoped>

</style>
