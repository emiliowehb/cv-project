import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("../pages/HomePage.vue"),
    },
    {
        path: "/test",
        component: () => import("../pages/TestRoute.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});