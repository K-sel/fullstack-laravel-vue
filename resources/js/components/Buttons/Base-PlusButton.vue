<template>
    <RouterLink to="/create">
        <button
            class="new w-8 h-8 flex items-center justify-center rounded-full bg-nav-button-bg"
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
                class="text-text-default"
            >
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
    </RouterLink>
</template>

<style scoped>
.bg-nav-button-bg {
    background-color: var(--nav-button-bg);
}

.text-text-default {
    color: var(--text-default);
}

button.new:hover {
    background-color: var(--text-default);
    color: var(--nav-button-bg);
    transition: 0.3s ease;
}

button.new:hover svg {
    color: var(--nav-button-bg);
}
</style>