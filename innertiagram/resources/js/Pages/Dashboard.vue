<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex-shrink-0 mr-3 px-40"
                v-if="$page.props.jetstream.managesProfilePhotos">
                <img :src="$page.props.user.profile_photo_url"
                    :alt="$page.props.user.name" class="rounded-full h-40 w-40 object-cover">
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ username }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <post-list />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from '@/Pages/Instagram/PostList.vue'

    export default defineComponent({
        props:[
            'username'
        ],
        components: {
            AppLayout,
            PostList
        },
    })
</script>
