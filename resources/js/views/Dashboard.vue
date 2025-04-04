<template>
    <div class="dashboard">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-people"></i> Usuarios</h5>
                        <h2 class="card-text">1,024</h2>
                        <router-link to="/users" class="text-white">Ver más <i class="bi bi-arrow-right"></i></router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-file-earmark-post"></i> Publicaciones</h5>
                        <h2 class="card-text">245</h2>
                        <router-link to="/posts" class="text-white">Ver más <i class="bi bi-arrow-right"></i></router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-eye"></i> Visitas</h5>
                        <h2 class="card-text">12,456</h2>
                        <a href="#" class="text-white">Ver más <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Actividad reciente</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in activities" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.user }}</td>
                            <td>{{ item.action }}</td>
                            <td>{{ item.date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activities: [
                { id: 1, user: 'admin', action: 'Creó una nueva publicación', date: '2023-10-15 14:30' },
                { id: 2, user: 'editor', action: 'Actualizó una publicación', date: '2023-10-15 13:45' },
                { id: 3, user: 'admin', action: 'Eliminó un usuario', date: '2023-10-15 12:20' }
            ]
        }
    }
}
</script>