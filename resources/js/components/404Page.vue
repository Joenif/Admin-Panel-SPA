<style scoped>
.error {
    width: 100%;
    height: 500px;
    background-position: center;
    background-size: cover;
}
</style>

<template>
    <div class="container error mt-4" style="background-image: url('./img/404.png')">
        <!-- <div class="error" style="background-image: url('./img/404.png')"></div> -->
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
