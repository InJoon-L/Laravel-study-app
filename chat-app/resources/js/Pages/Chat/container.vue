<template>
    <app-layout>
        <template #header>
            <ChatRoomSelection
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomChanged="setRoom($event)"
            />
        </template>
        <MessageContainer :messages="messages"/>
        <InputMessage :room="currentRoom" v-on:messagesent="getMessages"/>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: {},
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
        async getMessages() {
            // axios.get('/chat/room/' + this.currentRoom.id + '/messages')
            // .then(res => {
            //     console.log(res.data)
            //     this.messages = res.data;
            // })
            // .catch(err => {
            //     console.log(err);
            // });
            let res = await axios.get('/chat/room/' + this.currentRoom.id + '/messages');
            this.messages = res.data;
        }
    },
    created() {
        this.getRooms();
    }
}
</script>
