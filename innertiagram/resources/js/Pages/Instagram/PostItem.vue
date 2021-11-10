<template>
    <div>
        <div class="mt-5 overflow-hidden rounded shadow-lg">
            <a @click="imgClicked()"> <img class="w-full" src="/storage/mountain.png" alt="Mountain" /> </a>

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
                <div class="font-bold text-xl mb-2">Mountain</div>
                <p class="text-gray-700 text-base">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
        </div>

        <jet-confirmation-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
            <template #title>
                Delete Account
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingUserDeletion = false">
                    Nevermind
                </jet-secondary-button>
<!--
                <jet-danger-button class="ml-2" @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Account
                </jet-danger-button> -->
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
