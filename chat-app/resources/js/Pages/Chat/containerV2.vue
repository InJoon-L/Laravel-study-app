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
        <div class="py-12">
            <div class="flex flex-col justify-between flex-1 h-screen p:2 sm:p-6">
                <div v-if="messages" class="p-2 flex flex-col-reverse overflow-scroll">
                    <div v-for="msg in messages.data" :key="msg.id">
                        <StyledMessageItem :message="msg" />
                    </div>
                </div>
            </div>
        </div>
        <InputMessage :room="currentRoom" v-on:messagesent="getMessages"/>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputMessage from './inputMessage.vue';
import ChatRoomSelection from './chatRoomSelection.vue';
import StyledMessageItem from './styledMessageItem.vue';

export default {
    components: {
        AppLayout,
        InputMessage,
        ChatRoomSelection,
        StyledMessageItem
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: {},
            messages: null
        }
    },
    watch: {
        currentRoom(val, oldVal) {
            if (oldVal.id) {
                this.disconnect(oldVal)
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
                    console.log(JSON.stringify(e))
                    // vm.getMessages();
                    this.messages = [e.msg, ...this.messages.data];
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
            // this.connect();
        },
        async getMessages() {
            let res = await axios.get('/chat/room/' + this.currentRoom.id + '/messages');
            this.messages = res.data;
            console.log(res.data)
        },
        getMoreMessages() {
            if (this.messages == null) return;
            if (this.messages.current_page == this.messages.last_page) {
                alert('No more message')
                return;
            }

            axios.get(this.messages.next_page_url)
            .then(res => {
                this.messages = {...res.data, 'data': [...this.messages.data, ...res.data.data]};
            })
            .catch(err => {
                console.log(err);
            })
        }
    },
    mounted() {
        window.addEventListener('scroll', debounce((e) => {
            // console.log('scroll')
            // console.log("offsetHeight:" + document.documentElement.offsetHeight)
            // console.log("scrollTop:" + document.documentElement.scrollTop)
            // console.log("innerHeight:" + window.innerHeight)
            if (document.documentElement.scrollTop < 50) {
                this.getMoreMessages();
            }
        }, 100));
    },
    created() {
        this.getRooms();
    }
}
</script>
