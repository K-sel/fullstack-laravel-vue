<script setup>
import { ref, onMounted, watchEffect } from "vue";
import { checkDarkMode, applyTheme, isDarkMode } from "../utils/store.js";
import { useFetchJson } from "../composables/useFetchJson.js";
import TheControls from "../components/TheControls.vue";
import TheAddBookTitle from "../components/TheAddBookTitle.vue";

// Form data
const title = ref("");
const sub_title = ref("");
const author = ref("");
const reading_status = ref("to-read");
const resume = ref("");
const format = ref("");
const number_of_pages = ref(0);
const release_date = ref("");
const editor = ref("");
const isbn = ref("");
const cover_image = ref("");

// Form errors
const errors = ref({});
const formSubmitted = ref(false);
const isSubmitting = ref(false);

onMounted(() => {
    // Check if dark mode is already enabled (either by system preference or user choice)
    isDarkMode.value = checkDarkMode();

    // Initialize theme
    applyTheme();
});

const submitForm = async (e) => {
    e.preventDefault();
    formSubmitted.value = true;
    isSubmitting.value = true;
    errors.value = {};

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
        const { data, error, isLoading } = await useFetchJson({
            url: "/api/v1/new",
            method: "POST",
            data: body,
        });

        watchEffect(() => {
            if (data.value) {
                // Handle success
                console.log(data.value);
                // Redirect or show success message
            }

            if (error.value) {
                // Handle validation errors
                if (
                    error.value.response &&
                    error.value.response.data &&
                    error.value.response.data.errors
                ) {
                    errors.value = error.value.response.data.errors;
                } else {
                    // Handle other errors
                    console.error("Error submitting form:", error.value);
                }
            }

            isSubmitting.value = false;
        });
    } catch (err) {
        console.error("Error during form submission:", err);
        isSubmitting.value = false;
    }
};

// Helper function to check if a field has errors
const hasError = (field) => {
    return errors.value && errors.value[field];
};

// Helper function to get error message
const getErrorMessage = (field) => {
    return hasError(field) ? errors.value[field][0] : "";
};
</script>

<template>
    <header class="px-4 py-6 bg-bg-default">
        <TheControls></TheControls>
        <TheAddBookTitle></TheAddBookTitle>
    </header>

    <!-- Main content -->
    <div class="max-w-2xl mx-auto px-4 pb-12">
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
                <p v-if="hasError('title')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("title") }}
                </p>
            </div>

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
                <p
                    v-if="hasError('sub_title')"
                    class="text-red-400 text-xs mt-1"
                >
                    {{ getErrorMessage("sub_title") }}
                </p>
            </div>

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
                <p v-if="hasError('author')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("author") }}
                </p>
            </div>

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
                <p
                    v-if="hasError('reading_status')"
                    class="text-red-400 text-xs mt-1"
                >
                    {{ getErrorMessage("reading_status") }}
                </p>
            </div>

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
                <p v-if="hasError('resume')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("resume") }}
                </p>
            </div>

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
                <p v-if="hasError('format')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("format") }}
                </p>
            </div>

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
                    placeholder="250"
                />
                <p
                    v-if="hasError('number_of_pages')"
                    class="text-red-400 text-xs mt-1"
                >
                    {{ getErrorMessage("number_of_pages") }}
                </p>
            </div>

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
                <p
                    v-if="hasError('release_date')"
                    class="text-red-400 text-xs mt-1"
                >
                    {{ getErrorMessage("release_date") }}
                </p>
            </div>

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
                    required
                    maxlength="255"
                    placeholder="Nom de l'éditeur"
                />
                <p v-if="hasError('editor')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("editor") }}
                </p>
            </div>

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
                    required
                    maxlength="20"
                    placeholder="978-2-1234-5680-3"
                    pattern="[0-9-]+"
                />
                <p v-if="hasError('isbn')" class="text-red-400 text-xs mt-1">
                    {{ getErrorMessage("isbn") }}
                </p>
            </div>

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
                <p
                    v-if="hasError('cover_image')"
                    class="text-red-400 text-xs mt-1"
                >
                    {{ getErrorMessage("cover_image") }}
                </p>
            </div>

            <!-- Submit button -->
            <!-- Submit button -->
            <div class="pt-4">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="w-full flex justify-center py-2 px-4 border border-text-default text-sm font-medium rounded-md bg-bg-default text-text-default hover:bg-text-default hover:text-bg-default transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-text-default focus:ring-offset-bg-card-bg"
                >
                    <span v-if="isSubmitting">Traitement en cours...</span>
                    <span v-else>Enregistrer le livre</span>
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
</style>
