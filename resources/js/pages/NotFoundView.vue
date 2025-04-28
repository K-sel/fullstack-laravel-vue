<script setup>
import TheControls from "../components/TheControls.vue";
import The404 from "../components/Elements/404.vue";
</script>

<template>
    <div class="min-h-screen bg-bg-default">
        <!-- Le Header -->
        <header class="px-4 py-6 bg-bg-default">
            <TheControls />
        </header>

        <div class="flex flex-col items-center justify-center min-h-[70vh] px-4">
            <The404></The404>
        </div>
    </div>
</template>

<style scoped></style>
