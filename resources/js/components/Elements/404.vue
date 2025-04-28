<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
    <div class="text-center mb-8">
        <div class="text-6xl font-bold text-text-default mb-4">404</div>
        <h2 class="text-2xl font-semibold text-text-default mb-2">
            Page introuvable
        </h2>
        <p class="text-text-default mb-8">
            Oups on dirait que quelqu'un s'est perdu...
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <RouterLink
                to="/"
                class="px-6 py-3 bg-card-bg text-text-default rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center gap-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path
                        d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                    ></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Retour à l'accueil
            </RouterLink>

            <RouterLink
                to="/new"
                class="px-6 py-3 bg-card-bg text-text-default rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center gap-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12h8" />
                    <path d="M12 8v8" />
                </svg>
                Ajouter un livre
            </RouterLink>
        </div>
    </div>
</template>

<style scoped></style>
