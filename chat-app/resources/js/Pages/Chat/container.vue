<template>
    <app-layout>
        <MessageContainer :messages="messages"/>
        <InputMessage />
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: '',
            messages: []
        }
    },
    methods: {
        getRooms() {
            axios.get('/chat/rooms')
            .then(res => {
                this.chatRooms = res.data;
                this.setRoom(res.data[0]);
            })
            .catch(err => {
                console.log(err);
            });
        },
        setRoom(room) {
            this.currentRoom = room;
            this.getMessages();
        },
        getMessages() {
            axios.get('/chat/room/' + this.currentRoom.id + '/messages')
            .then(res => {
                console.log(res.data)
                this.messages = res.data;
            })
            .catch(err => {
                console.log(err);
            });
        }
    },
    created() {
        this.getRooms();
    }
}
</script>
