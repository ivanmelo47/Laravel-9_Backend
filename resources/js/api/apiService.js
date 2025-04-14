import axios from 'axios';

const api = axios.create({
    baseURL: '/api/v1/',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// Interceptor para manejar la estructura de respuesta estándar
api.interceptors.response.use(
    response => {
        // Si la respuesta tiene la estructura esperada
        if (response.data && typeof response.data.status !== 'undefined') {
            if (!response.data.status || !response.data.validation) {
                const error = new Error(response.data.message || 'Request failed');
                error.response = response;
                return Promise.reject(error);
            }
            return response.data; // Devuelve la respuesta completa estructurada
        }
        return response;
    },
    error => {
        // Manejo de errores
        if (error.response) {
            const message = error.response.data?.message ||
                error.response.data?.error ||
                'Error en la solicitud';
            return Promise.reject(new Error(message));
        }
        return Promise.reject(error);
    }
);

export default {
    async getSocialNetworks(payload = {}) {
        try {
            const response = await api.post('admin-panel/redes-sociales', payload);
            return response;
        } catch (error) {
            console.error('Error fetching social networks:', error);
            throw error;
        }
    },
    async saveSocialNetworks(payload = {}) {
        try {
            const response = await api.post('admin-panel/redes-sociales-save', payload);
            return response;
        } catch (error) {
            console.error('Error save social networks:', error);
            throw error;
        }
    }
};