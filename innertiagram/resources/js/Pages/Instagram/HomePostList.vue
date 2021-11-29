<template>
    <div class="grid grid-cols-1 gap-5 p-10 justify-items-center sm:frid-cols-1">
        <home-post-item v-for="post in posts" :key="post" :post="post" />
    </div>
</template>

<script>
import HomePostItem from '@/Pages/Instagram/HomePostItem.vue';

export default {
    props: ['posts'],
    components: {
        HomePostItem
    },
    data() {
        return {

        }
    }
}
</script>

<style>

</style>
