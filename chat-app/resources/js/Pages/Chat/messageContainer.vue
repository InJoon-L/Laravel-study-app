<template>
    <div class="h-96 w-full">
        <div class="p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="msg in messages" :key="msg.id">
                <MessageItem :message="msg" />
            </div>
        </div>
    </div>
</template>

<script>
import MessageItem from './messageItem.vue';

export default {
    props:['messages'],
    components: {
        MessageItem,
    }
}
</script>

<style>

</style>
