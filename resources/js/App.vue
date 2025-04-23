<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <h1>Hello App!</h1>
    <p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
    <nav>
        <RouterLink to="/">Go to Home</RouterLink>
        <a href="/login">Login</a>
        <a href="/register">Create an Account</a>
    </nav>
    <main>
        <RouterView />
    </main>
</template>

<style scoped></style>
