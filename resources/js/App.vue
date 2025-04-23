<script>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <RouterView></RouterView>
</template>

<style>
/* Use your CSS variables from root to support dark and light mode */
:root {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
        Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
        sans-serif;
}

/* Hide scrollbar for Chrome, Safari and Opera */
::-webkit-scrollbar {
    display: none;
}

.bg-bg-default {
    background-color: var(--bg-default);
}

/* Hide scrollbar for IE, Edge and Firefox */
* {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
