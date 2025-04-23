    import { createRouter, createWebHistory } from "vue-router";

    import Register from "../pages/Register.vue";
    import Login from "../pages/Login.vue";
    import Home from "../pages/Home.vue";

    const routes = [
        { path: "/register", component: Register },
        { path: "/login", component: Login },
        { path: "/", component: Home },
    ];


    export const router = createRouter({
        history: createWebHistory(),
        routes,
    });

