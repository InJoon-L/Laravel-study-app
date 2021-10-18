<template>
    <div class="p-2 flex flex-col-reverse overflow-scroll">
        <div v-for="msg in messages" :key="msg.id">
            <StyledMessageItem :message="msg" />
        </div>
        <infinite-loading @infinite="infiniteHandler" spinner="spiral">
            <div slot="no-more" style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px;">더 이상 목록이 없습니다.</div>
        </infinite-loading>
    </div>
</template>

<script>
import StyledMessageItem from './styledMessageItem.vue';

export default {
    props:['messages'],
    components: {
        StyledMessageItem,
    }
}
</script>

<style>

</style>
