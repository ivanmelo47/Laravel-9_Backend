<template>
    <div class="posts-index">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Redes sociales</h2>
            <button class="btn btn-primary" @click="showCreateModal">
                <i class="bi bi-plus-circle"></i> Nueva publicación
            </button>
        </div>

        <TableComponent :columns="columns" :data="posts" :actions="actions" :items-per-page="6"
            :show-actions-button="true" @edit-post="showEditPostModal" @delete-post="handleDelete">
            <template #column-status="{ row }">
                <span :class="`badge bg-${row.status === 'published' ? 'success' : 'warning'}`">
                    {{ row.status === 'published' ? 'Publicado' : 'Borrador' }}
                </span>
            </template>
        </TableComponent>

        <!-- Modales -->
        <DynamicModal ref="createPostModal" modalId="createPost" title="Crear Nueva Publicación" :fields="postFields"
            submitText="Crear Publicación" size="modal-lg" :loading="isCreatingPost" @submit="createPost" />
        <DynamicModal ref="editPostModal" modalId="editPost" title="Editar Publicación" :fields="postFields"
            submitText="Guardar Cambios" size="modal-lg" :loading="isEditingPost" @submit="updatePost" />
    </div>
</template>

<script>
import TableComponent from '@/components/TableComponent.vue'
import DynamicModal from '@/components/DynamicModal.vue'
import Swal from 'sweetalert2'
import apiService from '@/api/apiService'
import notifications from '@/services/notifications'

export default {
    components: { TableComponent, DynamicModal },
    data() {
        return {
            loading: false,
            error: null,
            isCreatingPost: false,
            isEditingPost: false,
            columns: [
                { label: 'ID', field: 'id' },
                { label: 'Nombre', field: 'nombre' },
                { label: 'Url', field: 'url_red' },
                { label: 'Logo', field: 'logo' },
                { label: 'Fecha Modificación', field: 'updated_at' }
            ],
            actions: [
                {
                    event: 'edit-post',
                    label: 'Editar',
                    icon: 'pencil',
                    color: 'primary'
                },
                {
                    event: 'delete-post',
                    label: 'Eliminar',
                    icon: 'trash',
                    color: 'danger'
                }
            ],
            posts: [],
            postFields: [
                {
                    name: 'nombre',
                    label: 'Nombre',
                    type: 'text',
                    required: true
                },
                {
                    name: 'url_red',
                    label: 'Url',
                    type: 'text',
                    required: true
                },
                {
                    name: 'logo',
                    label: 'Logo',
                    type: 'text',
                    required: true
                },
            ]
        }
    },
    methods: {
        showCreateModal() {
            this.$refs.createPostModal.show()
        },
        showEditPostModal(post) {
            const postData = {
                id: post.id,
                nombre: post.nombre,
                url_red: post.url_red,
                logo: post.logo
            };
            this.$refs.editPostModal.show(postData);
        },

        async createPost(formData) {
            this.isCreatingPost = true
            try {
                await new Promise(resolve => setTimeout(resolve, 1000))
                const newPost = {
                    id: Math.max(...this.posts.map(p => p.id)) + 1,
                    nombre: formData.nombre,
                    author: 'Usuario Actual',
                    url_red: formData.url_red,
                    logo: formData.logo,
                    date: new Date().toISOString().split('T')[0],
                    featured: formData.featured || false
                }

                this.posts.unshift(newPost)
                this.$refs.createPostModal.hide()

                notifications.success('¡Éxito!', 'La publicación se creó correctamente')

            } catch (error) {
                //console.error('Error al crear publicación:', error)
                notifications.error('Error', 'Ocurrió un error al crear la publicación')
            } finally {
                this.isCreatingPost = false
            }
        },

        async updatePost(formData) {
            this.isEditingPost = true;

            try {
                const postId = formData.id;
                if (!postId) {
                    throw new Error('No se pudo identificar el ID del post a editar');
                }

                // Simular llamada API (reemplazar con llamada real cuando sea necesario)
                const updatedPost = await this.simulateApiCall(formData);

                // Buscar y actualizar el post en el array local
                const postIndex = this.posts.findIndex(post => post.id === postId);
                if (postIndex === -1) {
                    throw new Error(`No se encontró el post con ID ${postId}`);
                }

                // Actualizar manteniendo la reactividad
                this.posts.splice(postIndex, 1, {
                    ...this.posts[postIndex], // Mantener datos existentes
                    ...updatedPost,           // Aplicar cambios nuevos
                    id: postId               // Preservar el ID original
                });

                // Cerrar modal y mostrar notificación
                this.closeEditModal();
                notifications.success('Publicación actualizada', 'Los cambios se guardaron correctamente');

            } catch (error) {
                console.error('Error al actualizar publicación:', error);

                // Mostrar error específico si está disponible, o mensaje genérico
                const errorMessage = error.response?.data?.message ||
                    error.message ||
                    'Ocurrió un error al actualizar la publicación';

                notifications.error('Error al guardar', errorMessage);

            } finally {
                this.isEditingPost = false;
            }
        },

        handleDelete(post) {
            notifications.confirm(
                '¿Estás seguro?',
                `¿Eliminar "${post.nombre}" permanentemente?`
            ).then((result) => {
                if (result.isConfirmed) {
                    this.posts = this.posts.filter(p => p.id !== post.id)
                    notifications.success('Eliminado!', 'El registro ha sido eliminado.')
                }
            })
        },


        simulateApiCall(formData) {
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve({
                        ...formData,
                        updatedAt: new Date().toISOString()
                    });
                }, 1000);
            });
        },

        closeEditModal() {
            if (this.$refs.editPostModal?.hide) {
                this.$refs.editPostModal.hide();
            } else {
                const modalEl = document.getElementById('dynamicModal-editPost');
                if (modalEl) {
                    const modal = window.bootstrap.Modal.getInstance(modalEl) ||
                        new window.bootstrap.Modal(modalEl);
                    modal.hide();
                }
            }
        },

        async fetchSocialNetworks() {
            this.loading = true;
            this.error = null;

            try {
                const payload = { user_uuid: '6b993b7d-065a-48b0-9a31-168d5ab9b03c' };
                const response = await apiService.getSocialNetworks(payload);

                // Actualizar datos
                this.posts = response.data;

                // Mostrar notificaciones si existen
                if (response.notifications) {
                    response.notifications.forEach(notification => {
                        notifications.toast(notification, 'success');
                    });
                }

            } catch (err) {
                console.error('Error fetching social networks:', err);
                this.error = err.message;

                // Mostrar error con manejo de posibles respuestas de API
                const errorMessage = err.response?.data?.message || err.message || 'Error al cargar redes sociales';
                notifications.error('Error', errorMessage);

            } finally {
                this.loading = false;
            }
        }
    },

    created() {
        this.fetchSocialNetworks();
    }
}
</script>