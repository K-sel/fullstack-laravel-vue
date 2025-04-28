<script setup>
import { ref, watchEffect } from "vue";
import { useFetchJson } from "../../composables/useFetchJson.js";

const data = ref(null);
const error = ref(null);
const isLoading = ref(false);

const logout = () => {
    useFetchJson(data, error, isLoading, {
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
            class="logout flex items-center justify-center rounded-md text-text-default transition-colors duration-200"
            aria-label="Se déconnecter"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span class="ml-2 text-sm font-medium hidden md:inline"
                >Déconnexion</span
            >
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

/* Style pour mobile (icône seulement) */
button.logout {
    width: 2rem;
    height: 2rem;
    padding: 0;
    background-color: var(--nav-button-bg);
}

/* Style pour desktop (avec texte) */
@media (min-width: 768px) {
    button.logout {
        width: auto;
        height: auto;
        padding: 0.375rem 1rem;
        gap: 0.5rem;
    }
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
