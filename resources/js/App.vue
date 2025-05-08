<script setup>
import { RouterView } from "vue-router";
import { useFetchJson } from "./composables/useFetchJson.js";
import { onMounted, ref, provide, watchEffect } from "vue";

const booksData = ref({ books: [] });
const booksErrors = ref(null);
const isBooksLoading = ref(false);

provide("booksData", booksData);
provide("booksErrors", booksErrors);
provide("isBooksLoading", isBooksLoading);

onMounted(() => {
    const { abort } = useFetchJson(booksData, booksErrors, isBooksLoading, {
        url: `/api/v1/user/books`,
        method: "GET",
    });
});

</script>

<template>
    <RouterView></RouterView>
</template>

<style>

:root {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
        Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
        sans-serif;
        background-color: var(--bg-default);
    }

    html,
    body {
        background-color: var(--bg-default);
        overflow-x: hidden;
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
