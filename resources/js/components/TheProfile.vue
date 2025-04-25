<script setup>
import { ref } from "vue";

const props = defineProps({
    profileImage: {
        type: String,
        required: true,
    },
    bioText: {
        type: String,
        required: true,
        default:
            "Je suis un passionné de littérature française contemporaine, avec un penchant particulier pour les romans d'auteurs comme David Foenkinos et Anna Gavalda.",
    },
});
</script>

<template>
    <div class="flex flex-col items-center mb-6">
        <!-- Profile picture -->
        <div class="w-24 h-24 rounded-full overflow-hidden mb-6 shadow-md">
            <img
                :src="profileImage"
                alt="Profile"
                class="w-full h-full object-cover"
            />
        </div>

        <!-- Bio text -->
        <p class="text-text-default text-center max-w-xs mb-4">
            {{ bioText }}
        </p>
    </div>
</template>

<style scoped>
.text-text-default {
    color: var(--text-default);
}
</style>