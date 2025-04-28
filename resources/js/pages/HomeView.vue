<script setup>
import { ref, computed, inject } from "vue";
import BookCard from "../components/Elements/Base-BookCard.vue";
import TheControls from "../components/TheControls.vue";
import TheProfile from "../components/TheProfile.vue";

// Injection avec valeur par défaut pour éviter undefined
const data = inject('booksData');
const errors = inject('booksErrors');
const isLoading = inject('isBooksLoading');

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
        return data.value.books;
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
                    <BookCard
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
