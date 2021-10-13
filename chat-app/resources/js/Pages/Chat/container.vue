<template>
    <app-layout>
        <template #header>
            <ChatRoomSelection
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                v-on:roomChanged="setRoom($event)"
            />
        </template>
        <!-- <MessageContainer :messages="messages"/> -->
        <styled-message-container :messages="messages" />
        <InputMessage :room="currentRoom" v-on:messagesent="getMessages"/>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './messageContainer.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';
import StyledMessageContainer from './styledMessageContainer.vue';

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
        StyledMessageContainer
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: {},
            messages: []
        }
    },
    watch: {
        currentRoom(val, oldVal) {
            if (oldVal.id) {
                this.disconnect()
            }
            this.connect()
        }
    },
    methods: {
        disconnect(room) {
            window.Echo.leave('chat.' + room.id);
        },
        connect() {
            // 방이 변경되었을 때, 이 메소드가 호출되니
            // 이 방의 메시지를 불러와 디스플레이 해준다.
            // 변경된 방은 currentRoom
            this.getMessages();
            const vm = this;
            window.Echo.private('chat.' + this.currentRoom.id)
                .listen('.message.new', e => {
                    vm.getMessages();
                })
        },
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
            // if (this.currentRoom != null && this.currentRoom.id != this.room.id) {
            //     this.disconnect(this.currentRoom);
            // }
            this.currentRoom = room;
            this.connect();
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
