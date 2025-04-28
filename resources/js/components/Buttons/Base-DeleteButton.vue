<script setup>
import { ref, watchEffect } from "vue";
import { useFetchJson } from "@/composables/useFetchJson.js";

const props = defineProps({
    bookId: {
        type: [Number, String],
        required: true,
    },
});

const emit = defineEmits(["bookDeleted"]);

const data = ref(null);
const error = ref(null);
const isLoading = ref(false);
const showConfirmation = ref(false);

const openConfirmation = () => {
    showConfirmation.value = true;
};

const cancelDelete = () => {
    showConfirmation.value = false;
};

const confirmDelete = () => {
    useFetchJson(data, error, isLoading, {
        url: `api/v1/user/book/${props.bookId}`,
        method: "DELETE",
    });

    watchEffect(() => {
        if (error.value?.status === 204) {
            console.log("Book deleted successfully");
            emit("bookDeleted", true);
        } else if (error.value) {
            console.error("Error deleting book:", error.value);
        }
    });
};
</script>

<template>
    <div class="action-button">
        <button
            @click="openConfirmation"
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
                <path d="M3 6h18" />
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                <line x1="10" x2="10" y1="11" y2="17" />
                <line x1="14" x2="14" y1="11" y2="17" />
            </svg>
            <span class="text-sm">Delete</span>
        </button>

        <!-- Confirmation Dialog -->
        <div v-if="showConfirmation" class="confirmation-overlay">
            <div class="confirmation-dialog">
                <p>Êtes-vous sûr de vouloir supprimer ce livre ?</p>
                <div class="confirmation-actions">
                    <button
                        @click="cancelDelete"
                        class="cancel-button"
                        :disabled="isLoading"
                    >
                        Annuler
                    </button>
                    <button
                        @click="confirmDelete"
                        class="confirm-button"
                        :disabled="isLoading"
                    >
                        <span v-if="!isLoading">Confirmer</span>
                        <span v-else>Suppression...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.action-button {
    display: inline-flex;
    justify-content: center;
    position: relative;
}

.action-button button {
    background: transparent;
    border: none;
    color: var(--text-default);
    cursor: pointer;
    padding: 0;
    transition: color 0.3s ease;
}

.action-button button:hover {
    color: var(--red-500);
}

/* Styles for confirmation dialog */
.confirmation-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
}

.confirmation-dialog {
    background-color: var(--card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    max-width: 300px;
    width: 90%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    color: var(--text-default);
}

.confirmation-dialog p {
    margin-bottom: 1.25rem;
    text-align: center;
    font-size: 0.9rem;
}

.confirmation-actions {
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
}

.confirmation-actions button {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 0.875rem;
    width: 100%;
    transition: background-color 0.2s;
}

.cancel-button {
    background-color: transparent !important;
    border: 1px solid var(--text-default) !important;
    color: var(--text-default) !important;
    border-radius: 8px !important;

}

.confirm-button {
    background-color: var(--red-500, #ef4444) !important;
    border: 1px solid var(--red-500, #ef4444) !important;
    color: white !important;
    border-radius: 8px !important;
}

button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
