<template>
    <div v-if="user.id === message.user.id" class="text-lg text-right text-lime-600 mr-1 font-bold">
        <span class="text-base">{{ message.message }}</span> :{{ message.user.name }}
    </div>
    
    <div v-else class="text-lg text-black ml-1 font-bold">
        {{ message.user.name }}: <span class="text-base">{{ message.message }}</span>
    </div>
</template>

<script>
export default {
    name: "MessageItem",
    props: [
        'message',
        'user'
    ]
}
</script>