<template>
    <div class="h-69 w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="(message, index) in messages" :key="index">
                <div>
                    <MessageItem 
                    :message="message"
                    :user="user"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MessageItem from '@/Pages/Chat/Component/messageItem.vue'

export default {
    name: "MessageContainer",
    props: [
        'messages',
        'user'
    ],
    components: {
        MessageItem
    }

}
</script>