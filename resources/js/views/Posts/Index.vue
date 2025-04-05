<template>
    <div class="posts-index">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Publicaciones</h2>
            <button class="btn btn-primary" @click="showCreateModal">
                <i class="bi bi-plus-circle"></i> Nueva publicación
            </button>
        </div>

        <TableComponent 
            :columns="columns" 
            :data="posts" 
            :actions="actions" 
            :pagination="pagination"
            @edit-post="showEditPostModal" 
            @delete-post="handleDelete" 
            @page-changed="changePage">
            <template #column-status="{ row }">
                <span :class="`badge bg-${row.status === 'published' ? 'success' : 'warning'}`">
                    {{ row.status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
            </template>
        </TableComponent>

        <!-- Modal para crear posts -->
        <DynamicModal 
            ref="createPostModal" 
            modalId="createPost" 
            title="Crear Nueva Publicación" 
            :fields="postFields"
            submitText="Crear Publicación"
            size="modal-lg"
            :loading="isCreatingPost" 
            @submit="createPost" 
        />
        <!-- Modal para editar posts -->
        <DynamicModal
            ref="editPostModal"
            modalId="editPost"
            title="Editar Publicación"
            :fields="postFields"
            submitText="Guardar Cambios"
            :loading="isEditingPost"
            @submit="updatePost"
        />
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
                { id: 2, title: 'Configuración de Laravel', author: 'Editor', status: 'published', date: '2023-10-05' },
                { id: 3, title: 'Bootstrap 5 Tips', author: 'Admin', status: 'draft', date: '2023-10-10' }
            ],
            pagination: {
                currentPage: 1,
                totalPages: 5,
                totalItems: 25,
                itemsPerPage: 5
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
        showCreateModal() {
            this.$refs.createPostModal.show()
        },
        showEditPostModal(post) {
            // Convierte el post a objeto plano si es necesario
            const postData = JSON.parse(JSON.stringify(post))
            this.$refs.editPostModal.show(postData)
        },

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

        async updateUser(formData) {
            this.isEditingUser = true
            try {
                await new Promise(resolve => setTimeout(resolve, 1000))
                this.$refs.editUserModal.hide()

                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Usuario actualizado correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    timer: 3000
                })
            } catch (error) {
                console.error('Error al actualizar usuario:', error)
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar el usuario',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            } finally {
                this.isEditingUser = false
            }
        },

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
            console.log('Cambiando a página:', page)
        }
    }
}
</script>