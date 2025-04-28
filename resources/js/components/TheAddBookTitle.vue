<script setup></script>

<template>
    <div class="flex flex-col items-center text-center mb-8">
        <div class="mb-4">
            <svg
                width="50"
                height="50"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="text-text-default"
            >
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path
                    d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"
                ></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-text-default"><slot></slot></h2>
        <p class="mt-2 text-sm text-sub-text-lighter">
            Build your own Bookshelf
        </p>
    </div>
</template>

<style scoped>
.text-sub-text-lighter {
    color: var(--sub-text-lighter);
}

.text-text-default {
    color: var(--text-default, #ffffff);
}
</style>
