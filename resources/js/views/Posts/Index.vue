<template>
    <div class="posts-index">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Publicaciones</h2>
            <router-link to="/posts/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva publicación
            </router-link>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts" :key="post.id">
                                <td>{{ post.id }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.author }}</td>
                                <td>
                                    <span :class="`badge bg-${post.status === 'published' ? 'success' : 'warning'}`">
                                        {{ post.status === 'published' ? 'Publicado' : 'Borrador' }}
                                    </span>
                                </td>
                                <td>{{ post.date }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <router-link :to="`/posts/${post.id}/edit`" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>
                                        <button class="btn btn-outline-danger" @click="confirmDelete(post.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: [
                { id: 1, title: 'Introducción a Vue 3', author: 'Admin', status: 'published', date: '2023-10-01' },
                { id: 2, title: 'Configuración de Laravel', author: 'Editor', status: 'published', date: '2023-10-05' },
                { id: 3, title: 'Bootstrap 5 Tips', author: 'Admin', status: 'draft', date: '2023-10-10' }
            ]
        }
    },
    methods: {
        confirmDelete(id) {
            if (confirm('¿Estás seguro de eliminar esta publicación?')) {
                this.posts = this.posts.filter(post => post.id !== id)
            }
        }
    }
}
</script>