import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../pages/HomeView.vue";
import BookFormView from "../pages/BookFormView.vue";
import BookDetailsView from "../pages/BookDetailsView.vue";
import NotFoundView from "../pages/NotFoundView.vue";
import SettingsView from "../pages/SettingsView.vue";

const routes = [
    { path: "/", component: HomeView },
    { path: "/create", name:'create',component: BookFormView },
    { path: "/settings", component: SettingsView },
    { path: "/update/:id",  component: BookFormView },
    { path: "/book/:id", component: BookDetailsView },
    { path: "/:pathMatch(.*)*", component: NotFoundView },];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
