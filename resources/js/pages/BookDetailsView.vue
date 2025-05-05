<script setup>
import { ref, computed, inject, watchEffect } from "vue";
import TheControls from "../components/TheControls.vue";
import Badge from "../components/Base-Badge.vue";
import BaseModifyButton from "../components/Buttons/Base-ModifyButton.vue";
import BaseDeleteButton from "../components/Buttons/Base-DeleteButton.vue";
import The404 from "../components/Elements/404.vue";
import { useRouter } from "vue-router";

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
const router = useRouter();

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
        return new Intl.DateTimeFormat("fr-FR", {
            day: "numeric",
            month: "long",
            year: "numeric",
        }).format(date);
    } catch (e) {
        return actualBook.value.release_date || "Date non spécifiée";
    }
});

watchEffect(() => {
    console.log(actualBook.value);
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
            <The404></The404>
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
                            :src="`/api/v1/picture/book/${actualBook?.id}`"
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

                    <div class="bg-card-bg rounded-lg py-4 px-6">
                        <div class="flex justify-between py-4">
                            <div
                                class="flex flex-row gap-2 items-center justify-center"
                            >
                                <svg
                                    class="text-sub-text-lighter"
                                    width="22"
                                    height="20"
                                    viewBox="0 0 22 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M11 5V19M11 5C11 3.93913 10.5786 2.92172 9.82843 2.17157C9.07828 1.42143 8.06087 1 7 1H2C1.73478 1 1.48043 1.10536 1.29289 1.29289C1.10536 1.48043 1 1.73478 1 2V15C1 15.2652 1.10536 15.5196 1.29289 15.7071C1.48043 15.8946 1.73478 16 2 16H8C8.79565 16 9.55871 16.3161 10.1213 16.8787C10.6839 17.4413 11 18.2044 11 19M11 5C11 3.93913 11.4214 2.92172 12.1716 2.17157C12.9217 1.42143 13.9391 1 15 1H20C20.2652 1 20.5196 1.10536 20.7071 1.29289C20.8946 1.48043 21 1.73478 21 2V15C21 15.2652 20.8946 15.5196 20.7071 15.7071C20.5196 15.8946 20.2652 16 20 16H14C13.2044 16 12.4413 16.3161 11.8787 16.8787C11.3161 17.4413 11 18.2044 11 19"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <span class="text-sub-text-lighter"
                                    >Format</span
                                >
                            </div>
                            <span class="text-text-default">{{
                                actualBook?.format || "Broché"
                            }}</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <div
                                class="flex flex-row gap-2 items-center justify-center"
                            >
                                <svg
                                    class="text-sub-text-lighter"
                                    width="22"
                                    height="20"
                                    viewBox="0 0 22 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M18 15V3C18 2.46957 17.7893 1.96086 17.4142 1.58579C17.0391 1.21071 16.5304 1 16 1H3M3 1C3.53043 1 4.03914 1.21071 4.41421 1.58579C4.78929 1.96086 5 2.46957 5 3V17C5 17.5304 5.21071 18.0391 5.58579 18.4142C5.96086 18.7893 6.46957 19 7 19M3 1C2.46957 1 1.96086 1.21071 1.58579 1.58579C1.21071 1.96086 1 2.46957 1 3V5C1 5.26522 1.10536 5.51957 1.29289 5.70711C1.48043 5.89464 1.73478 6 2 6H5M7 19H19C19.5304 19 20.0391 18.7893 20.4142 18.4142C20.7893 18.0391 21 17.5304 21 17V16C21 15.7348 20.8946 15.4804 20.7071 15.2929C20.5196 15.1054 20.2652 15 20 15H10C9.73478 15 9.48043 15.1054 9.29289 15.2929C9.10536 15.4804 9 15.7348 9 16V17C9 17.5304 8.78929 18.0391 8.41421 18.4142C8.03914 18.7893 7.53043 19 7 19Z"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <span class="text-sub-text-lighter">Pages</span>
                            </div>
                            <span class="text-text-default">{{
                                actualBook?.number_of_pages || "423"
                            }}</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <div
                                class="flex flex-row gap-2 items-center justify-center"
                            >
                                <svg
                                    class="text-sub-text-lighter"
                                    width="20"
                                    height="19"
                                    viewBox="0 0 20 19"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M10 18H19M13 2.99998L16 5.99998M14.376 1.62198C14.7741 1.22389 15.314 1.00024 15.877 1.00024C16.44 1.00024 16.9799 1.22389 17.378 1.62198C17.7761 2.02007 17.9997 2.55999 17.9997 3.12298C17.9997 3.68596 17.7761 4.22589 17.378 4.62398L5.368 16.635C5.1301 16.8729 4.83602 17.0469 4.513 17.141L1.641 17.979C1.55495 18.0041 1.46374 18.0056 1.37691 17.9833C1.29008 17.9611 1.21083 17.9159 1.14745 17.8525C1.08407 17.7892 1.03889 17.7099 1.01664 17.6231C0.994397 17.5362 0.995902 17.445 1.021 17.359L1.859 14.487C1.95322 14.1643 2.12725 13.8706 2.365 13.633L14.376 1.62198Z"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                                <span class="text-sub-text-lighter"
                                    >Date de sortie</span
                                >
                            </div>
                            <span class="text-text-default">{{
                                formattedReleaseDate
                            }}</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <div
                                class="flex flex-row gap-2 items-center justify-center"
                            >
                                <svg
                                    class="text-sub-text-lighter"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 22 22"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M21 11C21 16.5228 16.5228 21 11 21M21 11C21 5.47715 16.5228 1 11 1M21 11H1M11 21C5.47715 21 1 16.5228 1 11M11 21C8.43223 18.3038 7 14.7233 7 11C7 7.27674 8.43223 3.69615 11 1M11 21C13.5678 18.3038 15 14.7233 15 11C15 7.27674 13.5678 3.69615 11 1M1 11C1 5.47715 5.47715 1 11 1"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                                <span class="text-sub-text-lighter"
                                    >Maison d'édition</span
                                >
                            </div>
                            <span class="text-text-default">{{
                                actualBook?.editor || "Random House"
                            }}</span>
                        </div>
                        <div class="flex justify-between py-4">
                            <div
                                class="flex flex-row gap-2 items-center justify-center"
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
                                    class="text-sub-text-lighter lucide lucide-scan-barcode-icon lucide-scan-barcode"
                                >
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                    <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                    <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                    <path d="M8 7v10" />
                                    <path d="M12 7v10" />
                                    <path d="M17 7v10" />
                                </svg>
                                <span class="text-sub-text-lighter">ISBN</span>
                            </div>
                            <span class="text-text-default">{{
                                actualBook?.isbn || "7123298731832"
                            }}</span>
                        </div>
                    </div>
                </section>

                <!-- Notes section -->
                <!-- <section class="mb-6">
                    <h2 class="text-lg font-semibold text-text-default mb-3">
                        Notes
                    </h2>
                    <div class="bg-card-bg rounded-lg p-4 h-32">
                        <textarea
                            class="w-full h-full bg-transparent text-text-default resize-none outline-none"
                            placeholder="Commencer à écrire..."
                        ></textarea>
                    </div>
                </section> -->
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
