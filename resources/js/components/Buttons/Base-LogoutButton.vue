<script setup>
import { watchEffect } from "vue";
import { useFetchJson } from "../../composables/useFetchJson.js";

// Fonction logout
const logout = () => {
    const { error, data, isLoading } = useFetchJson({
        url: "/logout",
        method: "DELETE",
    });

    watchEffect(() => {
        if (!error.value) {
            console.log(error.value);
            window.location.href = "/login";
        }
    });
};
</script>

<template>
    <form @submit.prevent="logout">
        <button
            class="logout px-4 py-1.5 text-sm font-medium rounded-md text-text-default bg-nav-button-bg transition-colors duration-200 flex items-center gap-2"
            aria-label="Se déconnecter"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path
                    d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                ></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Déconnexion
        </button>
    </form>
</template>

<style scoped>
.bg-nav-button-bg {
    background-color: var(--nav-button-bg);
}

.text-text-default {
    color: var(--text-default);
}

button.logout:hover {
    background-color: var(--text-default);
    color: var(--nav-button-bg);
    transition: 0.3s ease;
}

button.logout:hover svg {
    color: var(--nav-button-bg);
}
</style>