<template>
    <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-1/2">
        <div class="flex flex-row mt-2">
            <div class="flex-shrink-0 mr-3">
                <Link :href="'/profiles/' + post.user.name">
                    <img class="object-cover w-10 h-10 rounded-full" :src="post.user.profile_photo_url" :alt="post.user.name" />
                </Link>
            </div>
            <Link :href="'/profiles/' + post.user.name">
                <span class="mr-1 font-black">{{ post.user.name }}</span>
            </Link>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
