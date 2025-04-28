<template>
    <div class="min-h-screen bg-bg-default text-text-default">
        <!-- Le Header -->
        <header class="px-4 py-6 bg-bg-default">
            <TheControls />
        </header>

        <!-- Contenu principal centré avec max-width -->
        <div class="space-y-4 pb-6 w-full max-w-3xl mx-auto mb-12 px-6 py-8">   

            <!-- Photo de profil centrée -->
            <div class="flex justify-center mb-6">
                <div
                    class="w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden"
                >
                    <img
                        v-if="profilePic"
                        :src="profilePic"
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

            <!-- Bio centrée -->
            <div class="text-center">
                <textarea
                    v-model="bio"
                    rows="4"
                    class="w-full bg-transparent text-center resize-none border-none focus:ring-0 focus:outline-none"
                    placeholder="Write something about yourself..."
                ></textarea>
            </div>

            <h1 class="pt-4 pb-6 text-xl font-bold">Informations de Profil</h1>
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

                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2"
                        >Profile Picture</label
                    >
                    <div class="flex items-center">
                        <label
                            for="profile-pic-upload"
                            class="px-3 py-2 bg-zinc-800 rounded-md text-sm font-medium hover:bg-zinc-700 cursor-pointer"
                        >
                            Change profile picture
                        </label>
                        <input
                            id="profile-pic-upload"
                            type="file"
                            accept="image/*"
                            class="hidden"
                            @change="handleProfilePicUpload"
                        />
                    </div>
                </div>

                <!-- Save button -->
                <div>
                    <button
                        type="button"
                        @click="saveProfile"
                        class="px-4 py-2 bg-white text-black rounded-md font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-offset-zinc-900"
                        :disabled="isLoading"
                    >
                        <span v-if="isLoading">Saving...</span>
                        <span v-else>Save changes</span>
                    </button>
                </div>

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
                            @click="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white rounded-md font-medium hover:bg-red-700 focus:outline-none"
                        >
                            Delete account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import TheControls from "@/components/TheControls.vue"; // Assurez-vous que le chemin est correct

// États réactifs
const profilePic = ref(null);
const firstName = ref("");
const lastName = ref("");
const email = ref("");
const bio = ref(
    "Je suis un passionné de littérature française contemporaine, avec un penchant particulier pour les romans d'auteurs comme David Foenkinos et Anna Gavalda."
);
const isLoading = ref(false);

// Chargement des données utilisateur
const loadUserData = () => {
    isLoading.value = true;

    // Simuler un appel API avec un délai (à remplacer par un vrai appel API)
    setTimeout(() => {
        // Ces données seraient normalement récupérées du backend
        firstName.value = "John";
        lastName.value = "Doe";
        email.value = "john.doe@example.com";
        isLoading.value = false;
    }, 500);
};

// Gestion du téléchargement de photo de profil
const handleProfilePicUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    // Vérifier que le fichier est bien une image
    if (!file.type.match("image.*")) {
        alert("Please select an image file");
        return;
    }

    // Créer une URL pour prévisualiser l'image
    profilePic.value = URL.createObjectURL(file);

    // Dans une application réelle, vous l'enverriez au serveur ici
};

// Sauvegarder le profil
const saveProfile = () => {
    isLoading.value = true;

    // Dans une application réelle, vous feriez un appel API ici pour enregistrer les modifications
    setTimeout(() => {
        // Simuler une réponse réussie
        alert("Profile saved successfully!");
        isLoading.value = false;
    }, 800);
};

// Confirmer la suppression du compte
const confirmDelete = () => {
    // Ajouter une confirmation avant de supprimer le compte
    if (
        confirm(
            "Are you sure you want to delete your account? This action cannot be undone."
        )
    ) {
        // Dans une application réelle, vous feriez un appel API ici pour supprimer le compte
        alert("Account deletion would be processed here.");
    }
};

// Charger les données utilisateur au montage du composant
onMounted(() => {
    loadUserData();
});
</script>

<style scoped>
/* Style pour rendre le textarea auto-ajustable */
textarea {
    overflow: hidden;
    resize: none;
}
</style>
