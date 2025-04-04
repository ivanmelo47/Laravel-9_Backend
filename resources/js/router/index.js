import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    /* {
        path: '/home',
        name: 'home',
        component: () => import('../components/Home.vue')
    }, */
    {
        path: '/',
        name: 'dashboard',
        component: () => import('../views/Dashboard.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/posts',
        name: 'posts',
        component: () => import('../views/Posts/Index.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../components/About.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router