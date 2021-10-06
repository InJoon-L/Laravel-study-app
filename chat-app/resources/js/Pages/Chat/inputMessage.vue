<template>
    <div>
        <input @keyup.enter="sendMessage" type="text" v-model="message">
        <button @click="sendMessage">Send</button>
    </div>
</template>

<script>
export default {
    props: ['room'],
    data() {
        return {
            message: ''
        }
    },
    methods: {
        sendMessage() {
            if (this.message == '') return ;

            axios.post('/chat/' + this.room.id + '/message', {
                message: this.message
            })
            .then(res => {
                console.log(res.data);
                this.message = '';
                this.$emit('messagesent');
            })
            .catch(err => {
                console.log(err);
            })
        }
    }
}
</script>

<style>

</style>
