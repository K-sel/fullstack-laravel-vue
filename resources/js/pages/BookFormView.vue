<script setup>
import { ref, onMounted, watchEffect, inject, computed } from "vue";
import { checkDarkMode, applyTheme, isDarkMode } from "../utils/store.js";
import { useFetchJson } from "../composables/useFetchJson.js";
import TheControls from "../components/TheControls.vue";
import TheAddBookTitle from "../components/TheAddBookTitle.vue";

// État pour suivre si le livre a été ajouté avec succès
const bookAdded = ref(false);
// État pour contrôler l'animation de fade-in du message de succès
const showSuccessMessage = ref(false);

// Setup des données et récupération du livre a afficher
const data = inject("booksData", ref({ books: [] }));

const typeOfForm =
    window.location.pathname.split("/")[1] === "update" ? "update" : "create";
const formTitle =
    typeOfForm === "update" ? "Modifier le livre" : "Ajouter un livre";
const submitTitle =
    typeOfForm === "update"
        ? "Enregistrer les modifications"
        : "Créer le livre";

const bookId = window.location.pathname.split("/").pop();

const actualBook = computed(() => {
    return data.value?.books.find((book) => book.id == bookId);
});

const bookNotFound = computed(() => {
    return data.value?.books.find((book) => book.id == bookId) === undefined;
});

// Form data with default values (échantillon pour Monte-Cristo)
const defaultValues = {
    title: "Le Comte de Monte-Cristo",
    sub_title: "Roman d'aventure",
    author: "Alexandre Dumas",
    reading_status: "to-read",
    resume: "Le Comte de Monte-Cristo est un roman d'Alexandre Dumas, écrit avec la collaboration d'Auguste Maquet et dont la publication commence pendant l'été 1844. Il est partiellement inspiré du récit d'un fait divers, « Le Diamant et la Vengeance » (voir Pierre Picaud), publié en 1838 dans les Mémoires tirés des archives de la police (tome V, chapitre LXXIV), mémoires apocryphes rédigés en large partie par l'écrivain Étienne-Léon de Lamothe-Langon à partir des notes de Jacques Peuchet, archiviste de la préfecture de police. Cet ouvrage est, avec Les Trois Mousquetaires, l'une des œuvres les plus connues de l'écrivain tant en France qu'à l'étranger. Il a d'abord été publié en feuilleton dans le Journal des débats du 28 août au 19 octobre 1844 (1re partie), du 31 octobre au 26 novembre 1844 (2e partie), puis finalement du 20 juin 1845 au 15 janvier 1846 (3e partie).",
    format: "Broché",
    number_of_pages: 1024,
    release_date: "1844-08-28",
    editor: "Gallimard",
    isbn: "978-2-07-040692-1",
    cover_image_path:
        "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg/1200px-Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg",
};

// Initialisation des refs
const title = ref(defaultValues.title);
const sub_title = ref(defaultValues.sub_title);
const author = ref(defaultValues.author);
const reading_status = ref(defaultValues.reading_status);
const resume = ref(defaultValues.resume);
const format = ref(defaultValues.format);
const number_of_pages = ref(defaultValues.number_of_pages);
const release_date = ref(defaultValues.release_date);
const editor = ref(defaultValues.editor);
const isbn = ref(defaultValues.isbn);
const cover_image = ref(defaultValues.cover_image_path);

// Si en mode édition et que le livre existe, remplacer les valeurs par défaut
watchEffect(() => {
    if (typeOfForm === "update" && !bookNotFound.value && actualBook.value) {
        console.log("Livre à modifier", actualBook.value);

        title.value = actualBook.value.title;
        sub_title.value = actualBook.value.sub_title;
        author.value = actualBook.value.author;
        reading_status.value = actualBook.value.reading_status;
        resume.value = actualBook.value.resume;
        format.value = actualBook.value.format;
        number_of_pages.value = actualBook.value.number_of_pages;
        release_date.value = actualBook.value.release_date?.split(" ")[0]; // Pour enlever la partie heure si présente
        editor.value = actualBook.value.editor;
        isbn.value = actualBook.value.isbn;
        cover_image.value = actualBook.value.cover_image_path;
    }
});

// Form errors
const responseData = ref(null);
const responseError = ref(null);
const isLoading = ref(false);
const formSubmitted = ref(false);
const errors = ref({});

onMounted(() => {
    // Check if dark mode is already enabled (either by system preference or user choice)
    isDarkMode.value = checkDarkMode();

    // Initialize theme
    applyTheme();
});

const submitForm = (e) => {
    e.preventDefault();
    formSubmitted.value = true;
    errors.value = {};

    const url =
        typeOfForm === "update" ? `/api/v1/update/${bookId}` : "/api/v1/create";
    const method = typeOfForm === "update" ? "PATCH" : "POST";
    const body = {
        title: title.value,
        sub_title: sub_title.value,
        author: author.value,
        reading_status: reading_status.value,
        resume: resume.value,
        format: format.value,
        number_of_pages: number_of_pages.value,
        release_date: release_date.value,
        editor: editor.value,
        isbn: isbn.value,
        cover_image: cover_image.value,
    };

    try {
        const { abort } = useFetchJson(responseData, responseError, isLoading, {
            url: url,
            method: method,
            data: body,
        });
    } catch (err) {
        console.error("Error during form submission:", err);
    }
};

watchEffect(() => {
    console.log(responseError.value);
    if (responseData.value) {
        console.log(responseData.value);
        // Traitement en cas de succès
        bookAdded.value = true;

        // Déclencher l'animation du message de succès après une courte période
        setTimeout(() => {
            showSuccessMessage.value = true;
        }, 100);

        // Rediriger vers la page d'accueil après 3 secondes
        setTimeout(() => {
            window.location.href = "/";
        }, 2000);
    }

    if (
        responseError.value &&
        responseError.value.data &&
        responseError.value.data.errors
    ) {
        console.log(responseError.value);
        errors.value = extractSimpleObject(responseError.value.data.errors);
        console.log(errors.value);
    }
});

// Supposons que votre Proxy Object est stocké dans une variable appelée proxyObject
const extractSimpleObject = (proxyObject) => {
    const result = {};

    // Si c'est un Proxy avec des arrays comme valeurs
    if (proxyObject) {
        Object.keys(proxyObject).forEach((key) => {
            // Prendre le premier élément de chaque array
            result[key] = proxyObject[key][0];
        });
    }
    return result;
};
</script>

<template>
    <header class="px-4 py-6 bg-bg-default">
        <TheControls></TheControls>
        <TheAddBookTitle v-if="!bookAdded">{{ formTitle }}</TheAddBookTitle>
    </header>

    <!-- Message de succès animé -->
    <div
        v-if="bookAdded"
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
            <div>
                <h2 v-if="typeOfForm === 'update'">
                    Livre modifié avec succès!
                </h2>
                <h2 v-if="typeOfForm === 'create'">
                    Livre ajouté avec succès!
                </h2>
                <p>Vous allez être redirigé sur l'écran d'accueil...</p>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div
        v-if="!bookAdded"
        class="max-w-2xl mx-auto px-4 pb-12 fade-out"
        :class="{ hide: bookAdded }"
    >
        <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Title -->
            <div class="form-group">
                <label
                    for="title"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Titre *</label
                >
                <input
                    type="text"
                    v-model="title"
                    name="title"
                    id="title"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="255"
                    placeholder="Titre du livre"
                />
            </div>
            <p v-if="errors?.title" class="text-red-400 text-xs mt-1">
                {{ errors?.title }}
            </p>

            <!-- Subtitle -->
            <div class="form-group">
                <label
                    for="sub_title"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Sous-titre *</label
                >
                <input
                    type="text"
                    v-model="sub_title"
                    name="sub_title"
                    id="sub_title"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="255"
                    placeholder="Sous-titre du livre"
                />
            </div>
            <p v-if="errors?.sub_title" class="text-red-400 text-xs mt-1">
                {{ errors?.sub_title }}
            </p>

            <!-- Author -->
            <div class="form-group">
                <label
                    for="author"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Auteur *</label
                >
                <input
                    type="text"
                    v-model="author"
                    name="author"
                    id="author"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    required
                    maxlength="255"
                    placeholder="Nom de l'auteur"
                />
            </div>
            <p v-if="errors?.author" class="text-red-400 text-xs mt-1">
                {{ errors?.author }}
            </p>

            <!-- Reading Status -->
            <div class="form-group">
                <label
                    for="reading_status"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Statut de lecture *</label
                >
                <select
                    v-model="reading_status"
                    name="reading_status"
                    id="reading_status"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    required
                >
                    <option value="to-read">À lire</option>
                    <option value="read">Lu</option>
                    <option value="pending">En cours</option>
                </select>
            </div>
            <p v-if="errors?.reading_status" class="text-red-400 text-xs mt-1">
                {{ errors?.reading_status }}
            </p>

            <!-- Resume -->
            <div class="form-group">
                <label
                    for="resume"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Résumé</label
                >
                <textarea
                    v-model="resume"
                    name="resume"
                    id="resume"
                    rows="4"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="2000"
                    placeholder="Résumé du livre"
                ></textarea>
            </div>
            <p v-if="errors?.resume" class="text-red-400 text-xs mt-1">
                {{ errors?.resume }}
            </p>

            <!-- Format -->
            <div class="form-group">
                <label
                    for="format"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Format</label
                >
                <input
                    type="text"
                    v-model="format"
                    name="format"
                    id="format"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="100"
                    placeholder="Poche, Broché, etc."
                />
            </div>
            <p v-if="errors?.format" class="text-red-400 text-xs mt-1">
                {{ errors?.format }}
            </p>

            <!-- Number of Pages -->
            <div class="form-group">
                <label
                    for="number_of_pages"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Nombre de pages *</label
                >
                <input
                    type="number"
                    v-model="number_of_pages"
                    name="number_of_pages"
                    id="number_of_pages"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    required
                    min="0"
                    placeholder="250"
                />
            </div>
            <p v-if="errors?.number_of_pages" class="text-red-400 text-xs mt-1">
                {{ errors?.number_of_pages }}
            </p>

            <!-- Release Date -->
            <div class="form-group">
                <label
                    for="release_date"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Date de publication *</label
                >
                <input
                    type="date"
                    v-model="release_date"
                    name="release_date"
                    id="release_date"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    required
                />
            </div>
            <p v-if="errors?.release_date" class="text-red-400 text-xs mt-1">
                {{ errors?.release_date }}
            </p>

            <!-- Editor -->
            <div class="form-group">
                <label
                    for="editor"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >Éditeur *</label
                >
                <input
                    type="text"
                    v-model="editor"
                    name="editor"
                    id="editor"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="255"
                    placeholder="Nom de l'éditeur"
                />
            </div>
            <p v-if="errors?.editor" class="text-red-400 text-xs mt-1">
                {{ errors?.editor }}
            </p>

            <!-- ISBN -->
            <div class="form-group">
                <label
                    for="isbn"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >ISBN *</label
                >
                <input
                    type="text"
                    v-model="isbn"
                    name="isbn"
                    id="isbn"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    maxlength="20"
                    placeholder="978-2-1234-5680-3"
                />
            </div>
            <p v-if="errors?.isbn" class="text-red-400 text-xs mt-1">
                {{ errors?.isbn }}
            </p>

            <!-- Cover Image URL -->
            <div class="form-group">
                <label
                    for="cover_image"
                    class="block text-sm font-medium text-sub-text-lighter"
                    >URL de couverture</label
                >
                <input
                    type="url"
                    v-model="cover_image"
                    name="cover_image"
                    id="cover_image"
                    class="mt-1 appearance-none block w-full px-3 py-2 border border-zinc-700 rounded-md bg-card-bg placeholder-gray-500 text-text-default focus:outline-none focus:ring-1 focus:ring-white focus:border-white sm:text-sm"
                    placeholder="https://example.com/book-cover.jpg"
                />
            </div>
            <p v-if="errors?.cover_image" class="text-red-400 text-xs mt-1">
                {{ errors?.cover_image }}
            </p>

            <!-- Submit button -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-text-default text-sm font-medium rounded-md bg-bg-default text-text-default hover:bg-text-default hover:text-bg-default transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-text-default focus:ring-offset-bg-card-bg"
                    :disabled="isLoading"
                >
                    <span v-if="!isLoading">{{ submitTitle }}</span>
                    <span v-else>Enregistrement en cours...</span>
                </button>
            </div>
        </form>
    </div>
</template>

<style>
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
    background-color: rgba(0, 0, 0, 0.5);
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
