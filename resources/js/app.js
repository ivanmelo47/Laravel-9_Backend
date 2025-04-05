//require('./bootstrap');
//import 'bootstrap/dist/css/bootstrap.min.css'
//import 'bootstrap'
//import 'bootstrap-icons/font/bootstrap-icons.css'
//
//import { createApp } from 'vue'
//import router from './router'
//import App from './App.vue'
//
//createApp(App)
//    .use(router)
//    .mount('#app')

// Importaciones CSS
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.css'

// Importaciones de Vue
import { createApp } from 'vue'
import router from './router'
import App from './App.vue'

// Importación de Bootstrap JS (asegúrate que esté después de crear la app Vue)
import 'bootstrap'

// Crea y monta la aplicación
const app = createApp(App)
app.use(router)
app.mount('#app')