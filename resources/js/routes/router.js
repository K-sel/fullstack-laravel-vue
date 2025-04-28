import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../pages/HomeView.vue";
import BookFormView from "../pages/BookFormView.vue";
import BookDetailsView from "../pages/BookDetailsView.vue";
//import MenuView from "../pages/MenuView.vue";
//import BookView from "../pages/BookView.vue";

const routes = [
    { path: "/", component: HomeView },
    { path: "/new", component: BookFormView },
    { path: "/book/:id", component: BookDetailsView },
    //{ path: "/settings", component: MenuView },
    //{ path: `/book`, component: BookView },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
