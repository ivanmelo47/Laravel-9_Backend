<template>
    <div class="sidebar bg-dark text-white">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link class="nav-link" active-class="active" to="/">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" active-class="active" to="/posts">
                        <i class="bi bi-file-earmark-post me-2"></i> Publicaciones
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" active-class="active" to="/redes-sociales">
                        <i class="bi bi-globe2 me-2"></i> Redes sociales
                    </router-link>
                </li>
                <!-- <li class="nav-item">
                    <router-link class="nav-link" active-class="active" to="/users" v-if="isAdmin">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </router-link>
                </li> -->
            </ul>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue'

export default {
    setup() {
        const isAdmin = computed(() => localStorage.getItem('userRole') === 'admin')
        
        return { isAdmin }
    }
}
</script>

<style scoped>
.sidebar {
    width: 250px;
    min-height: calc(100vh - 56px);
}

.nav-link {
    color: rgba(255, 255, 255, 0.75);
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}

.nav-link:hover {
    color: white;
    background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
    color: white;
    background-color: rgba(255, 255, 255, 0.2);
}
</style>