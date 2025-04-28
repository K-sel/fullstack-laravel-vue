<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import PlusButton from "./Buttons/Base-PlusButton.vue";
import ReturnButton from "./Buttons/Base-ReturnButton.vue";
import ToggleDarkLight from "./Buttons/Base-ToggleDarkLight.vue";
import LogoutButton from "./Buttons/Base-LogoutButton.vue";
import SettingsButton from "./Buttons/Base-SettingsButton.vue";

const route = useRoute();
const currentPath = computed(() => route.path);
</script>

<template>
    <div class="flex justify-between items-center mb-6">
        <!-- Affichage conditionnel: bouton "+" sur la page d'accueil, bouton "Retour" sur d'autres pages -->
        <div class="flex items-center gap-3">
            <PlusButton v-if="currentPath === '/'" />
            <ReturnButton v-else />
            <!-- Dark Mode Toggle -->
            <ToggleDarkLight />
        </div>

        <div class="flex items-center gap-3">
            <!-- Logout Button -->
            <LogoutButton />
            <!-- Settings Button -->
            <SettingsButton />
        </div>
    </div>
</template>

<style scoped>
/* Styles minimes car les styles spécifiques sont dans chaque composant de bouton */
</style>
