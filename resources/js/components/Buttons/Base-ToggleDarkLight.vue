<script setup>
import { ref, onMounted } from "vue";
import { checkDarkMode, applyTheme, isDarkMode } from "../../utils/store.js";

onMounted(() => {
    // Check if dark mode is already enabled (either by system preference or user choice)
    isDarkMode.value = checkDarkMode();

    // Initialize theme
    applyTheme();
});

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    applyTheme();

    // Save user preference
    localStorage.setItem("darkMode", isDarkMode.value ? "enabled" : "disabled");
};
</script>

<template>
    <div class="flex items-center gap-2">
        <span class="text-xs text-text-default">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="14"
                height="14"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line
                    x1="4.22"
                    y1="4.22"
                    x2="5.64"
                    y2="5.64"
                ></line>
                <line
                    x1="18.36"
                    y1="18.36"
                    x2="19.78"
                    y2="19.78"
                ></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line
                    x1="4.22"
                    y1="19.78"
                    x2="5.64"
                    y2="18.36"
                ></line>
                <line
                    x1="18.36"
                    y1="5.64"
                    x2="19.78"
                    y2="4.22"
                ></line>
            </svg>
        </span>
        <button
            @click="toggleDarkMode"
            class="w-10 h-5 rounded-full flex items-center px-0.5 transition-colors duration-200"
            :class="
                isDarkMode
                    ? 'bg-blue-600 justify-end'
                    : 'bg-gray-300 justify-start'
            "
            aria-label="Changer de thème"
        >
            <span
                class="w-4 h-4 rounded-full bg-white shadow-md block transition-transform duration-200"
            ></span>
        </button>
        <span class="text-xs text-text-default">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="14"
                height="14"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path
                    d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                ></path>
            </svg>
        </span>
    </div>
</template>

<style scoped>
.text-text-default {
    color: var(--text-default);
}
</style>