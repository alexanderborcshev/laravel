import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "main" */ '../views/Main.vue'),
    },
    {
        path: '/catalog/',
        name: 'catalog',
        component: () => import(/* webpackChunkName: "main" */ '../views/Main.vue'),
    },
    {
        path: '/catalog/:code/',
        name: 'catalog',
        component: () => import(/* webpackChunkName: "main" */ '../views/Main.vue'),
    },
    {
        path: '/catalog/:code/:id/',
        name: 'offer-detail',
        component: () => import(/* webpackChunkName: "main" */ '../views/OfferDetail.vue'),
    },
    {
        path: '/ui-board/',
        name: 'ui-board',
        component: () => import(/* webpackChunkName: "main" */ '../views/UiBoard.vue'),
    },
    {
        path: '/404page/',
        name: '404Page',
        component: () => import(/* webpackChunkName: "main" */ '../views/ErrorPage.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        component: () => import(/* webpackChunkName: "main" */ '../views/ErrorPage.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    scrollBehavior(to, from, savedPosition) {
        console.log(to, from, savedPosition);
        if (savedPosition) {
            return savedPosition;
        }
        if (to.name === 'catalog') {
            return false;
        }
        return { top: 0 };
    },
});

export default router;
