<template>
    <RouterLink to="/">
        <button
            class="text-text-default text-base flex items-center bg-transparent border-0 p-0"
        >
            <span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-chevron-left-icon lucide-chevron-left"
                >
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            <span class="ml-1">Retour</span>
        </button>
    </RouterLink>
</template>

<style scoped>
.text-text-default {
    color: var(--text-default);
}
</style>
