<template>
    <div class="p-2 flex flex-col-reverse overflow-scroll">
        <div v-for="msg in messages" :key="msg.id">
            <StyledMessageItem :message="msg" />
        </div>
    </div>
</template>

<script>
import StyledMessageItem from './styledMessageItem.vue';

export default {
    props:['messages'],
    components: {
        StyledMessageItem,
    },
    data: {
        page: 0,
    },
    methods: {

    }
}
</script>

<style>

</style>
