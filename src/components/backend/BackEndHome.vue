<template>
    <section >
        <router-link to="/newImage">Ajouter une image</router-link>
    </section>

</template>

<script>
    export default {
        name: 'App',
        data() {
            return {
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>

<style scoped>
    body {
        background-color: #F0F0F0;
    }
    a{
        padding: 20px;
        border-radius: 5px;
        background-color: cornflowerblue;
        color: white;
        text-decoration: none
    }
</style>