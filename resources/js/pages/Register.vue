<script setup>
import { ref, watchEffect } from "vue";
import { useFetchJson } from "@/composables/useFetchJson";

// États pour stocker les valeurs du formulaire
const firstname = ref("");
const lastname = ref("");
const email = ref("");
const password = ref("");
const errors = ref([]);
const loading = ref(false);
const responseData = ref(null);


// Fonction pour gérer la soumission du formulaire
const submitForm = (e) => {
    e.preventDefault();
    errors.value = [];

    const form = {
        firstname: firstname.value,
        lastname: lastname.value,
        email: email.value,
        password: password.value,
    };

    const { data, error, isLoading } = useFetchJson({
        url: "/register",
        method: "POST",
        data: form,
    });

    watchEffect(() => 
    console.log(error.value))
};


</script>

<template>
    <div>
        <h1>Register</h1>

        <!-- Affichage des erreurs -->
        <div v-if="errors.length" class="errors">
            <ul>
                <li
                    v-for="(error, index) in errors"
                    :key="index"
                    style="color: red"
                >
                    {{ error }}
                </li>
            </ul>
        </div>

        <form @submit="submitForm">
            <div>
                <label for="firstname">Firstname:</label>
                <input
                    type="text"
                    id="firstname"
                    v-model="firstname"
                    required
                />
            </div>

            <div>
                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" v-model="lastname" required />
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required />
            </div>

            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    v-model="password"
                    required
                />
            </div>

            <button type="submit" :disabled="loading">
                {{ loading ? "Sending..." : "Register" }}
            </button>
        </form>
    </div>
</template>
