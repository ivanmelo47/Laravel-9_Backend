<template>
    <div class="posts-index">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Publicaciones</h2>
            <button class="btn btn-primary" @click="showCreateModal">
                <i class="bi bi-plus-circle"></i> Nueva publicación
            </button>
        </div>

        <TableComponent :columns="columns" :data="paginatedPosts" :actions="actions" 
            :pagination="{
                currentPage: pagination.currentPage,
                totalPages: totalPages,
                totalItems: totalItems,
                itemsPerPage: pagination.itemsPerPage
            }"
            @edit-post="showEditPostModal" @delete-post="handleDelete" @page-changed="changePage">
            <template #column-status="{ row }">
                <span :class="`badge bg-${row.status === 'published' ? 'success' : 'warning'}`">
                    {{ row.status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
            </template>
        </TableComponent>

        <!-- Modal para crear posts -->
        <DynamicModal ref="createPostModal" modalId="createPost" title="Crear Nueva Publicación" :fields="postFields"
            submitText="Crear Publicación" size="modal-lg" :loading="isCreatingPost" @submit="createPost" />
        <!-- Modal para editar posts -->
        <DynamicModal ref="editPostModal" modalId="editPost" title="Editar Publicación" :fields="postFields"
            submitText="Guardar Cambios" :loading="isEditingPost" @submit="updatePost" />
    </div>
</template>

<script>
import TableComponent from '@/components/TableComponent.vue'
import DynamicModal from '@/components/DynamicModal.vue'
import Swal from 'sweetalert2' // Importa SweetAlert2

export default {
    components: { TableComponent, DynamicModal },
    data() {
        return {
            isCreatingPost: false,
            isEditingPost: false,
            columns: [
                { label: 'ID', field: 'id' },
                { label: 'Título', field: 'title' },
                { label: 'Autor', field: 'author' },
                { label: 'Estado', field: 'status', slot: true },
                { label: 'Fecha', field: 'date' }
            ],
            actions: [
                {
                    event: 'edit-post',
                    label: 'Editar',
                    icon: 'pencil',
                    color: 'primary',
                    showLabel: false
                },
                {
                    event: 'delete-post',
                    label: 'Eliminar',
                    icon: 'trash',
                    color: 'danger',
                    showLabel: false
                }
            ],
            posts: [
                { id: 1, title: 'Introducción a Vue 3', author: 'Admin', status: 'published', date: '2023-10-01' },
            ],
            pagination: {
                currentPage: 1,
                itemsPerPage: 6, // Items por página (puedes hacerlo configurable)
                // totalPages y totalItems se calcularán dinámicamente
            },
            postFields: [
                {
                    name: 'title',
                    label: 'Título',
                    type: 'text',
                    required: true
                },
                {
                    name: 'content',
                    label: 'Contenido',
                    type: 'textarea',
                    rows: 5,
                    required: true
                },
                {
                    name: 'status',
                    label: 'Estado',
                    type: 'select',
                    options: [
                        { value: 'draft', label: 'Borrador' },
                        { value: 'published', label: 'Publicado' }
                    ],
                    defaultValue: 'draft'
                },
                {
                    name: 'featured',
                    label: 'Destacado',
                    type: 'checkbox'
                }
            ]
        }
    },
    methods: {
        // Visualizar modales
        showCreateModal() {
            this.$refs.createPostModal.show()
        },
        showEditPostModal(post) {
            // Convierte el post a objeto plano si es necesario
            const postData = {
                id: post.id, // <-- Esto es crucial
                title: post.title,
                author: post.author,
                status: post.status,
                date: post.date
            };

            //console.log('Valores Show:', postData)

            this.$refs.editPostModal.show(postData);
        },

        //Metodos CRUD
        async createPost(formData) {
            this.isCreatingPost = true

            try {
                await new Promise(resolve => setTimeout(resolve, 1000))

                const newPost = {
                    id: Math.max(...this.posts.map(p => p.id)) + 1,
                    title: formData.title,
                    author: 'Usuario Actual',
                    status: formData.status,
                    date: new Date().toISOString().split('T')[0],
                    featured: formData.featured || false
                }

                this.posts.unshift(newPost)
                this.$refs.createPostModal.hide()

                // Notificación de éxito con SweetAlert2
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'La publicación se creó correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    timer: 3000
                })
            } catch (error) {
                console.error('Error al crear publicación:', error)
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al crear la publicación',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            } finally {
                this.isCreatingPost = false
            }
        },

        async updatePost(formData) {
            //if (!formData || typeof formData !== 'object') {
            //    console.error('Datos del formulario inválidos');
            //    return;
            //}

            this.isEditingPost = true;

            try {
                // 1. Validación básica
                //if (!formData.title || !formData.author) {
                //    throw new Error('Título y autor son campos requeridos');
                //}

                // 2. Obtener el ID del post que estamos editando
                const postId = formData.id;
                if (!postId) {
                    throw new Error('No se pudo identificar el ID del post a editar');
                }

                // 3. Simular llamada API
                const updatedPost = await this.simulateApiCall(formData);

                // 4. Actualizar en el array local
                const postIndex = this.posts.findIndex(post => post.id === postId);
                if (postIndex === -1) {
                    throw new Error(`No se encontró el post con ID ${postId}`);
                }

                // Actualización segura manteniendo referencia
                this.posts.splice(postIndex, 1, {
                    ...this.posts[postIndex], // Mantener datos no editados
                    ...updatedPost,           // Nuevos datos
                    id: postId                // Preservar el ID original
                });

                // 5. Cerrar modal
                this.closeEditModal();

                // 6. Notificación
                this.showSuccessNotification('Publicación actualizada correctamente');

            } catch (error) {
                this.handleUpdateError(error);
            } finally {
                this.isEditingPost = false;
            }
        },

        // Acciones
        handleEdit(post) {
            this.$router.push(`/posts/${post.id}/edit`)
        },

        handleDelete(post) {
            if (confirm(`¿Estás seguro de eliminar "${post.title}"?`)) {
                this.posts = this.posts.filter(p => p.id !== post.id)
            }
        },

        changePage(page) {
            this.pagination.currentPage = page
            //console.log('Cambiando a página:', page)
        },

        // Métodos auxiliares
        simulateApiCall(formData) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    // Devuelve los datos del formulario más metadata si es necesario
                    resolve({
                        ...formData,
                        updatedAt: new Date().toISOString()
                    });
                }, 1000);
            });
        },

        updatePostInList(updatedPost) {
            const index = this.posts.findIndex(p => p.id === updatedPost.id);
            if (index === -1) {
                throw new Error(`Post con ID ${updatedPost.id} no encontrado`);
            }

            // Actualización inmutable para mantener reactividad
            this.posts = [
                ...this.posts.slice(0, index),
                updatedPost,
                ...this.posts.slice(index + 1)
            ];
        },

        closeEditModal() {
            if (this.$refs.editPostModal?.hide) {
                this.$refs.editPostModal.hide();
            } else {
                // Fallback manual
                const modalEl = document.getElementById('dynamicModal-editPost');
                if (modalEl) {
                    const modal = window.bootstrap.Modal.getInstance(modalEl) ||
                        new window.bootstrap.Modal(modalEl);
                    modal.hide();
                }
            }
        },

        showSuccessNotification(message) {
            Swal.fire({
                title: '¡Éxito!',
                text: message,
                icon: 'success',
                confirmButtonText: 'Aceptar',
                timer: 3000
            });
        },

        handleUpdateError(error) {
            console.error('Error en updatePost:', error);
            Swal.fire({
                title: 'Error',
                text: error.message || 'Error al actualizar la publicación',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    },

    computed: {
        totalItems() {
            return this.posts.length; // Calcula el total basado en tus datos
        },
        totalPages() {
            return Math.ceil(this.totalItems / this.pagination.itemsPerPage);
        },
        paginatedPosts() {
            const start = (this.pagination.currentPage - 1) * this.pagination.itemsPerPage;
            const end = start + this.pagination.itemsPerPage;
            return this.posts.slice(start, end);
        },
        visiblePageNumbers() {
            const visiblePages = 5; // Número máximo de páginas a mostrar en el control
            const half = Math.floor(visiblePages / 2);
            let start = Math.max(1, this.pagination.currentPage - half);
            let end = Math.min(this.totalPages, start + visiblePages - 1);

            // Ajustar si estamos cerca del final
            if (end - start + 1 < visiblePages) {
                start = Math.max(1, end - visiblePages + 1);
            }

            return Array.from({ length: end - start + 1 }, (_, i) => start + i);
        }
    }
}
</script>