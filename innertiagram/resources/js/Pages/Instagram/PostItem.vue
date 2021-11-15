<template>
    <div>
        <div class="mt-5 overflow-hidden rounded shadow-lg">
            <a @click="imgClicked()"> <img class="w-full" :src="'/storage/' + post.image" alt="post.image" > </a>

            <div class="flex flex-row px-6 py-4">
                <button class="pr-4">
                    <svg aria-label="좋아요" class="_8-yf5" color="#262626" fill="#262626" height="24" role="img"
                        width="24"
                    ><path d="M34.6 6."></path></svg>
                </button>
                <button class="pr-4">
                    <svg aria-label="댓글 달기" class="_8-yf5" color="#262626" fill="#262626" height="24" role="img"
                        width="24"
                    ><path d="M34.6 6."></path></svg>
                </button>
            </div>

            <div class="max-w-sm rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                <p class="text-gray-700 text-base">
                    {{ post.caption }}
                </p>
                </div>

                <div class="px-6 pt-4 pb-2">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'post'
    ],
}
</script>

<style>

</style>
