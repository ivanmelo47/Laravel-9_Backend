<template>
    <div class="app-container">
        <Navbar v-if="showNavbar" />
        <div class="main-content">
            <Sidebar v-if="showNavbar" />
            <div class="content-wrapper">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
import Sidebar from './components/Sidebar.vue'
import { computed } from 'vue'
import { useRoute } from 'vue-router'

export default {
    components: { Navbar, Sidebar },
    setup() {
        const route = useRoute()
        const showNavbar = computed(() => route.name !== 'login')

        return { showNavbar }
    }
}
</script>

<style scoped>
.app-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.main-content {
    display: flex;
    flex: 1;
}

.content-wrapper {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
}
</style>