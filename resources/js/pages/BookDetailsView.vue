<script setup>
import { ref, computed, inject } from "vue";
import TheControls from "../components/TheControls.vue";
import Badge from "../components/Base-Badge.vue";
import BaseModifyButton from "../components/Buttons/Base-ModifyButton.vue";
import BaseDeleteButton from "../components/Buttons/Base-DeleteButton.vue";

// Setup des données et récupération du livre a afficher
const data = inject("booksData", ref({ books: [] }));
const errors = inject("booksErrors");
const isLoading = inject("isBooksLoading");

const bookId = window.location.pathname.split("/").pop();
const actualBook = computed(() => {
    return data.value?.books.find((book) => book.id == bookId);
});

const bookNotFound = computed(() => {
    return data.value?.books.find((book) => book.id == bookId) === undefined;
});


// Action et animation de suppression
const bookDeleted = ref(false);
const showSuccessMessage = ref(false);

const bookHasBeenDeleted = (HasBeenDeleted) => {
    if (HasBeenDeleted) {
        bookDeleted.value = true;
        // Déclencher l'animation du message de succès après une courte période
        setTimeout(() => {
            showSuccessMessage.value = true;
        }, 100);

        // Rediriger vers la page d'accueil après 3 secondes
        setTimeout(() => {
            window.location.href = "/";
        }, 2000);
    }
};

// Affichage de la date de sortie
const formattedReleaseDate = computed(() => {
  if (!actualBook.value?.release_date) return "";
  
  try {
    const date = new Date(actualBook.value.release_date);
    return new Intl.DateTimeFormat('fr-FR', {
      day: 'numeric',
      month: 'long', 
      year: 'numeric'
    }).format(date);
  } catch (e) {
    return actualBook.value.release_date || "Date non spécifiée";
  }
});
</script>   

<template>
    <div class="min-h-screen bg-bg-default">
        <!-- Le Header -->
        <header class="p-4 bg-bg-default">
            <TheControls />
        </header>

        <!-- Message de livre non trouvé (404) -->
        <div
            v-if="bookNotFound && !isLoading"
            class="flex flex-col items-center justify-center min-h-[70vh] px-4"
        >
            <div class="text-center mb-8">
                <div class="text-6xl font-bold text-text-default mb-4">404</div>
                <h2 class="text-2xl font-semibold text-text-default mb-2">
                    Livre introuvable
                </h2>
                <p class="text-text-default mb-8">
                    Le livre que vous recherchez n'existe pas ou a été supprimé
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <RouterLink
                        to="/"
                        class="px-6 py-3 bg-card-bg text-text-default rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                            ></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Retour à l'accueil
                    </RouterLink>

                    <RouterLink
                        to="/new"
                        class="px-6 py-3 bg-card-bg text-text-default rounded-lg hover:opacity-80 transition-opacity flex items-center justify-center gap-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 12h8" />
                            <path d="M12 8v8" />
                        </svg>
                        Ajouter un livre
                    </RouterLink>
                </div>
            </div>
        </div>

        <!-- Message de succès animé -->
        <div
            v-if="bookDeleted"
            class="success-container"
            :class="{ show: showSuccessMessage }"
        >
            <div class="success-message">
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
                    class="success-icon lucide lucide-check-icon lucide-check"
                >
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                <h2>Livre supprimé avec succès!</h2>
                <p>Vous allez être redirigé sur l'écran d'accueil...</p>
            </div>
        </div>

        <!-- Book details -->
        <!-- Container pour centrer les cartes avec max-width -->
        <div
            v-if="!bookDeleted && !bookNotFound"
            class="flex justify-center w-full fade-out"
            :class="{ hide: bookDeleted }"
        >
            <!-- Liste des livres avec largeur maximale -->
            <div class="space-y-4 w-full max-w-3xl p-4">
                <!-- Book card -->
                <div class="rounded-lg">
                    <div class="flex justify-center mb-6">
                        <img
                            :src="actualBook?.cover_image"
                            :alt="actualBook?.title"
                            class="h-64 rounded-lg shadow-lg"
                        />
                    </div>

                    <div class="text-center mb-6">
                        <Badge
                            :status="actualBook?.reading_status"
                            class="mb-4"
                        />
                        <h1 class="text-2xl font-bold mb-2 text-text-default">
                            {{ actualBook?.title }}
                        </h1>
                        <h4 class="text-sm text-sub-text-lighter mb-3">
                            {{ actualBook?.sub_title }}
                        </h4>
                        <h2 class="text-lg text-text-default">
                            {{ actualBook?.author }}
                        </h2>
                    </div>

                    <div class="flex justify-center mb-4 gap-10">
                        <BaseModifyButton :bookId="bookId" />
                        <BaseDeleteButton
                            :bookId="bookId"
                            @bookDeleted="bookHasBeenDeleted"
                        />
                    </div>
                </div>

                <!-- À propos section -->
                <section class="mb-6">
                    <h2 class="text-lg font-semibold text-text-default mb-4">
                        À Propos
                    </h2>
                    <div class="bg-card-bg rounded-lg p-6">
                        <p class="text-text-default">
                            {{ actualBook?.resume }}
                        </p>
                    </div>
                </section>

                <!-- Book metadata -->
                <section class="mb-6">
                    <h2 class="text-lg font-semibold text-text-default mb-3">
                        Détails
                    </h2>

                    <div class="bg-card-bg rounded-lg p-4">
                        <div
                            class="flex justify-between py-2 border-b border-slate-300 dark:border-slate-700"
                        >
                            <span class="text-sub-text-lighter">Format</span>
                            <span class="text-text-default">{{
                                actualBook?.format || "Broché"
                            }}</span>
                        </div>
                        <div
                            class="flex justify-between py-2 border-b border-slate-300 dark:border-slate-700"
                        >
                            <span class="text-sub-text-lighter">Pages</span>
                            <span class="text-text-default">{{
                                actualBook?.number_of_pages || "423"
                            }}</span>
                        </div>
                        <div
                            class="flex justify-between py-2 border-b border-slate-300 dark:border-slate-700"
                        >
                            <span class="text-sub-text-lighter"
                                >Release date</span
                            >
                            <span class="text-text-default">{{
                                formattedReleaseDate
                            }}</span>
                        </div>
                        <div
                            class="flex justify-between py-2 border-b border-slate-300 dark:border-slate-700"
                        >
                            <span class="text-sub-text-lighter">Editor</span>
                            <span class="text-text-default">{{
                                actualBook?.editor || "Random House"
                            }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sub-text-lighter">ISBN</span>
                            <span class="text-text-default">{{
                                actualBook?.isbn || "7123298731832"
                            }}</span>
                        </div>
                    </div>
                </section>

                <!-- Notes section -->
                <section class="mb-6">
                    <h2 class="text-lg font-semibold text-text-default mb-3">
                        Notes
                    </h2>
                    <div class="bg-card-bg rounded-lg p-4 h-32">
                        <textarea
                            class="w-full h-full bg-transparent text-text-default resize-none outline-none"
                            placeholder="Commencer à écrire..."
                        ></textarea>
                    </div>
                </section>
            </div>
        </div>

        <!-- Indicateur de chargement -->
        <div
            v-if="isLoading"
            class="flex justify-center items-center min-h-[70vh]"
        >
            <div class="text-text-default">Chargement...</div>
        </div>
    </div>
</template>

<style scoped>
/* Using CSS variables from the root to support dark and light mode */
.bg-bg-default {
    background-color: var(--bg-default, #121212);
}

.bg-card-bg {
    background-color: var(--card-bg);
}

.bg-nav-button-bg {
    background-color: var(--nav-button-bg);
}

.text-text-default {
    color: var(--text-default, #ffffff);
}

.text-sub-text-lighter {
    color: var(--sub-text-lighter);
}

/* Status badge styles */
.bg-badge-bg {
    background-color: var(--badge-bg);
}

.text-badge-text {
    color: var(--badge-text);
}

/* Disable button styles */
button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Animation pour la disparition du contenu */
.fade-out {
    opacity: 1;
    transition: opacity 0.5s ease-out;
}

.fade-out.hide {
    opacity: 0;
}

/* Styles pour le message de succès */
.success-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
    opacity: 0;
    transition: opacity 0.5s ease-in;
}

.success-container.show {
    opacity: 1;
}

.success-message {
    padding: 2rem;
    border-radius: 0.5rem;
    text-align: center;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05);
    transform: translateY(20px);
    transition: transform 0.5s ease-out;
    max-width: 90%;
    color: var(--text-default);
}

.success-container.show .success-message {
    transform: translateY(0);
}

.success-icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1rem;
    color: #10b981; /* Couleur verte */
}

.success-message h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.success-message p {
    font-size: 1rem;
    opacity: 0.8;
}
</style>
