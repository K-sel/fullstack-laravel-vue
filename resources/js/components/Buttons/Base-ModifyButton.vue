<script setup>
const props = defineProps({
    bookId: {
        type: [Number, String],
        required: true,
    },
});
</script>

<template>
    <div class="action-button">
        <RouterLink
            :to="'/edit/' + bookId"
            class="flex flex-col items-center w-full"
        >
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
                class="mb-1"
            >
                <path d="M12 20h9" />
                <path
                    d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"
                />
                <path d="m15 5 3 3" />
            </svg>
            <span class="text-sm">Modify</span>
        </RouterLink>
    </div>
</template>

<style scoped>
.action-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

.action-button a {
    color: var(--text-default);
    transition: color 0.3s ease;
}

.action-button a:hover {
    color: var(--blue-500);
}
</style>
