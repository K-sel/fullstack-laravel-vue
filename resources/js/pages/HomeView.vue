<script setup>
import { ref, computed, onMounted, inject, watchEffect } from "vue";
import { useFetchJson } from "../composables/useFetchJson";
import BookCard from "../components/Elements/Base-BookCard.vue";
import TheControls from "../components/TheControls.vue";
import TheProfile from "../components/TheProfile.vue";

// Injection avec valeur par défaut pour éviter undefined
const data = inject("booksData");
const errors = inject("booksErrors");
const isLoading = inject("isBooksLoading");

const responseData = ref(null);
const responseError = ref(null);

// Props et état local
const profileImage = ref("/images/profile-image.png");
const bioText = ref(
    "Je suis un passionné de littérature française contemporaine, avec un penchant particulier pour les romans d'auteurs comme David Foenkinos et Anna Gavalda."
);

const activeTab = ref("all");

// Données
const tabs = [
    { id: "all", name: "All" },
    { id: "read", name: "Read" },
    { id: "to-read", name: "To-read" },
    { id: "pending", name: "Pending" },
];

// Computed pour filtrer les livres
const filteredBooks = computed(() => {
    if (!data.value?.books) return [];

    if (activeTab.value === "all") {
        return data.value.books.sort(
            (a, b) => new Date(b.created_at) - new Date(a.created_at)
        );
    } else {
        const statusMap = {
            read: "read",
            "to-read": "to-read",
            pending: "pending",
        };
        return data.value.books.filter(
            (book) => book.reading_status === statusMap[activeTab.value]
        );
    }
});

// Computed pour vérifier s'il y a des livres dans la bibliothèque
const hasBooks = computed(() => {
    return data.value?.books && data.value.books.length > 0;
});

// Chargement des données utilisateur
const loadUserData = () => {
    isLoading.value = true;

    try {
        // Envoyer les données au serveur
        useFetchJson(responseData, responseError, isLoading, {
            url: "/api/v1/user",
            method: "GET",
        });
    } catch (error) {
        console.error("Error loading user data:", error);
        showFeedback("Failed to load user data", "error");
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    loadUserData();
});

watchEffect(() => {
    if (responseData.value) {
        bioText.value = responseData.value.bio;
    }
});
</script>

<template>
    <div class="min-h-screen bg-bg-default">
        <!-- Le Header -->
        <header class="px-4 py-6 bg-bg-default">
            <TheControls />
            <TheProfile :profileImage="profileImage" :bioText="bioText" />
        </header>

        <!-- Navigation tabs -->
        <div class="px-4">
            <div
                class="flex space-x-6 mb-6 overflow-x-auto justify-center"
                style="scrollbar-width: none"
            >
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    class="font-medium py-1 whitespace-nowrap"
                    :class="
                        activeTab === tab.id
                            ? 'text-text-default border-b-1 border-white'
                            : 'text-sub-text-lighter'
                    "
                    @click="activeTab = tab.id"
                >
                    {{ tab.name }}
                </button>
            </div>

            <!-- Container pour centrer les cartes avec max-width -->
            <div class="flex justify-center w-full">
                <!-- Liste des livres avec largeur maximale -->
                <div class="space-y-4 pb-6 w-full max-w-3xl">
                    <!-- État vide : pas de livres dans la bibliothèque -->
                    <div
                        v-if="!hasBooks"
                        class="flex flex-col items-center justify-center py-12 px-4 text-center"
                    >
                        <svg
                            class="w-16 h-16 mb-4 text-sub-text-lighter"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                            />
                        </svg>
                        <h3 class="text-lg font-medium text-text-default mb-2">
                            Votre bibliothèque est vide
                        </h3>
                        <p class="text-sub-text-lighter mb-6">
                            Ajoutez des livres à votre bibliothèque pour
                            commencer à suivre vos lectures.
                        </p>
                        <RouterLink
                            to="/create"
                            class="px-6 py-3 bg-card-bg text-text-default rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center gap-2"
                        >
                            Ajouter un livre
                        </RouterLink>
                    </div>

                    <!-- État vide : des livres existent mais pas dans l'onglet actuel -->
                    <div
                        v-else-if="filteredBooks.length === 0"
                        class="flex flex-col items-center justify-center py-12 px-4 text-center"
                    >
                        <svg
                            class="w-16 h-16 mb-4 text-sub-text-lighter"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <h3 class="text-lg font-medium text-text-default mb-2">
                            Aucun livre dans cette catégorie
                        </h3>
                        <p class="text-sub-text-lighter">
                            Vous n'avez pas encore de livres dans la catégorie
                            "{{
                                tabs.find((tab) => tab.id === activeTab)?.name
                            }}".
                        </p>
                    </div>

                    <!-- Affichage normal des livres -->
                    <BookCard
                        v-else
                        v-for="book in filteredBooks"
                        :key="book.id"
                        :book="book"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-nav-button-bg {
    background-color: var(--nav-button-bg);
}

.text-text-default {
    color: var(--text-default);
}

.text-sub-text-lighter {
    color: var(--sub-text-lighter);
}
</style>
