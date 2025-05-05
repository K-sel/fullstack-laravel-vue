<script setup>
import { ref, onMounted, watchEffect } from "vue";
import { useFetchJson } from "@/composables/useFetchJson"; // Assurez-vous que le chemin est correct
import TheControls from "@/components/TheControls.vue"; // Assurez-vous que le chemin est correct

// États réactifs
const profileImage = ref("/images/profile-image.png");
const firstName = ref("");
const lastName = ref("");
const email = ref("");
const bio = ref("Write something about yourself...");

const feedbackMessage = ref("");
const feedbackStatus = ref("");

const responseData = ref(null);
const responseError = ref(null);
const isLoading = ref(false);
const confirmDelete = ref(false);

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

const submitForm = (e) => {
    e.preventDefault();
    isLoading.value = true;

    try {
        // Créer un objet avec les données du formulaire
        const userData = {
            firstname: firstName.value,
            lastname: lastName.value,
            bio: bio.value,
        };

        // Envoyer les données au serveur
        useFetchJson(responseData, responseError, isLoading, {
            url: "/api/v1/user/update",
            method: "POST",
            data: userData,
        });

        // Le profil a été mis à jour avec succès
        showFeedback("Profile updated successfully", "success");
    } catch (error) {
        console.error("Error updating profile:", error);
        showFeedback("Failed to update profile", "error");
    } finally {
        isLoading.value = false;
    }
};

// Confirmer la suppression du compte
const deleteAccount = async () => {
    // Ajouter une confirmation avant de supprimer le compte
    if (
        confirm(
            "Are you sure you want to delete your account? This action cannot be undone."
        )
    ) {
        isLoading.value = true;

        try {
            confirmDelete.value = true;
            // Envoyer les données au serveur
            const response = useFetchJson(
                responseData,
                responseError,
                isLoading,
                {
                    url: "/api/v1/user/delete",
                    method: "DELETE",
                }
            );
        } catch (error) {
            console.error("Error deleting account:", error);
            showFeedback("Failed to delete account", "error");
            isLoading.value = false;
        }
    }
};

// Afficher un message de feedback
const showFeedback = (message, status) => {
    feedbackMessage.value = message;
    feedbackStatus.value = status;

    // Effacer le message après 3 secondes
    setTimeout(() => {
        feedbackMessage.value = "";
    }, 3000);
};

// Charger les données utilisateur au montage du composant
onMounted(() => {
    loadUserData();
});

watchEffect(() => {
    console.log("SERVER RESPONSE DATA", responseData.value);
    console.log("SERVER ERROR RESPONSE", responseError.value);

    if (responseData.value) {
        firstName.value = responseData.value.firstname;
        lastName.value = responseData.value.lastname;
        email.value = responseData.value.email;
        bio.value = responseData.value.bio;
    }

    if (confirmDelete.value === true) {
        alert("Account deleted successfully. You will be logged out.");
        confirmDelete.value = false;
        window.location.href = "/logout";
    }
});
</script>

<template>
    <div class="min-h-screen bg-bg-default text-text-default">
        <!-- Le Header -->
        <header class="px-4 py-6 bg-bg-default">
            <TheControls />
        </header>
        <div class="space-y-4 pb-6 w-full max-w-3xl mx-auto mb-12 px-6 py-8">
            <!-- Photo de profil centrée -->
            <div class="flex justify-center mb-6">
                <div
                    class="w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden"
                >
                    <img
                        v-if="profileImage"
                        :src="profileImage"
                        alt="Profile"
                        class="w-full h-full object-cover"
                    />
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="black"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                        ></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
            </div>

            <form @submit.prevent="submitForm">
                <!-- Bio centrée -->
                <div class="text-center">
                    <textarea
                        id="bio"
                        v-model="bio"
                        rows="4"
                        class="w-full bg-transparent text-center resize-none border-none focus:ring-0 focus:outline-none"
                        placeholder="Write something about yourself..."
                    ></textarea>
                </div>

                <h1 class="pt-4 pb-6 text-xl font-bold">
                    Informations de Profil
                </h1>
                <!-- Formulaire de profil -->
                <div class="space-y-6">
                    <!-- First name -->
                    <div>
                        <label
                            for="firstname"
                            class="block text-sm font-medium text-gray-300 mb-2"
                            >First name</label
                        >
                        <input
                            id="firstname"
                            v-model="firstName"
                            type="text"
                            class="w-full px-3 py-2 border border-zinc-800 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white"
                            placeholder="Your first name"
                        />
                    </div>

                    <!-- Last name -->
                    <div>
                        <label
                            for="lastname"
                            class="block text-sm font-medium text-gray-300 mb-2"
                            >Last name</label
                        >
                        <input
                            id="lastname"
                            v-model="lastName"
                            type="text"
                            class="w-full px-3 py-2 border border-zinc-800 rounded-md bg-zinc-900 placeholder-gray-500 text-white focus:outline-none focus:ring-1 focus:ring-white focus:border-white"
                            placeholder="Your last name"
                        />
                    </div>

                    <!-- Email address (readonly) -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-300 mb-2"
                            >Email address</label
                        >
                        <input
                            id="email"
                            v-model="email"
                            type="email"
                            readonly
                            class="w-full px-3 py-2 border border-zinc-800 rounded-md bg-zinc-900 text-gray-400 focus:outline-none"
                            placeholder="Your email address"
                        />
                    </div>

                    <!-- Feedback message -->
                    <div
                        v-if="feedbackMessage"
                        :class="[
                            'py-2 px-3 rounded',
                            feedbackStatus === 'success'
                                ? 'bg-green-800 text-green-100'
                                : 'bg-red-800 text-red-100',
                        ]"
                    >
                        {{ feedbackMessage }}
                    </div>

                    <!-- Save button -->
                    <div>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-white text-black rounded-md font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900"
                            :disabled="isLoading"
                        >
                            <span v-if="isLoading">Saving...</span>
                            <span v-else>Save changes</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Password section -->
            <div class="pt-6 mt-6 border-t border-zinc-800">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium">Password</h3>
                        <p class="text-sm text-gray-400">
                            Update your password
                        </p>
                    </div>
                    <a
                        href="/edit-password"
                        class="px-4 py-2 bg-zinc-800 text-white rounded-md font-medium hover:bg-zinc-700 inline-block focus:outline-none"
                    >
                        Edit password
                    </a>
                </div>
            </div>

            <!-- Delete account section -->
            <div class="pt-6 mt-6 border-t border-zinc-800">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-red-500">
                            Delete account
                        </h3>
                        <p class="text-sm text-gray-400">
                            Delete your account and all of its resources
                        </p>
                    </div>
                    <button
                        type="button"
                        @click="deleteAccount"
                        class="px-4 py-2 bg-red-600 text-white rounded-md font-medium hover:bg-red-700 focus:outline-none"
                    >
                        Delete account
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Style pour rendre le textarea auto-ajustable */
textarea {
    overflow: hidden;
    resize: none;
}
</style>
