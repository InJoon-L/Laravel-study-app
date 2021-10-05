<template>
    <div>
        <div v-for="msg in messages" :key="msg.id">
            {{msg}}
        </div>
    </div>
</template>

<script>
export default {
    props:['messages'],
}
</script>

<style>

</style>
