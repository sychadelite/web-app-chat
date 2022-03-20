<template>
    <app-layout>
        <template #header>
            <h1>{{ user.name }}</h1>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection
                v-if="currentRoom.id" 
                :rooms="chatRooms" 
                :currentRoom="currentRoom" 
                v-on:roomchanged="setRoom($event)"
                />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <MessageContainer
                    :messages="messages"
                    :user="user"
                    />
                    
                    <InputMessage 
                    :room="currentRoom" 
                    v-on:messagesent="getMessages()"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

import MessageContainer from '@/Pages/Chat/Component/messageContainer.vue'
import InputMessage from '@/Pages/Chat/Component/inputMessage.vue'
import ChatRoomSelection from '@/Pages/Chat/Component/chatRoomSelection.vue'

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection
    },
    data() {
        return {
            chatRooms: [],
            currentRoom: [],
            messages: [],

            user: {}
        }
    },
    watch: {
        currentRoom(val, oldVal) {
            if(oldVal.id) {
                this.disconnect(oldVal);
            }
            this.connect();
        } 
    },
    mounted() {
        this.getAuthUser();
    },
    methods: {
        connect() {
            if(this.currentRoom.id) {
                let vm = this;

                this.getMessages();

                window.Echo.private("chat." + this.currentRoom.id)
                .listen('.message.new', e => {
                    vm.getMessages();
                });

                // window.Echo.private("chat."+this.currentRoom.id)
                // .listen('NewChatMessage', e => {
                //     vm.getMessages();
                // });
            }
        },
        disconnect(room) {
            window.Echo.leave("chat." + room.id);
        },
        getRooms() {
            axios.get('/chat/rooms').then( response => {
                this.chatRooms = response.data
                this.setRoom(response.data[0])
            })
            .catch(error => {
                console.log(error)
            })
        },
        setRoom(room) {
            this.currentRoom = room
            // this.getMessages()
        },
        getMessages() {
            axios.get('/chat/room/' + this.currentRoom.id + '/messages').then(response => {
                this.messages = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        getAuthUser() {
            axios.get('/auth/user').then(response => {
                this.user = response.data
            })
            .catch(error => {
                console.log(error)
            })
        }
    },
    created() {
        this.getRooms();
    }
}
</script>
