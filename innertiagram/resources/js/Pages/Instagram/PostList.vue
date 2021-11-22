<template>
    <div>
        <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
            <post-item v-for="post in posts" :key="post" :post="post" :viewed_user="viewed_user" />
        </div>
    </div>
</template>

<script>
import PostItem from './PostItem.vue'

export default {
    props: [
        'posts',
        'viewed_user'
    ],
    components: {
        PostItem,
    },
    data() {
        return {
        }
    }
}
</script>

<style>

</style>
