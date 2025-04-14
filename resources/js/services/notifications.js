// src/services/notifications.js
import Swal from 'sweetalert2'

const defaultOptions = {
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  timer: 3000
}

export default {
  // Notificación básica
  showNotification(title, text, icon = 'success') {
    return Swal.fire({
      title,
      text,
      icon,
      ...defaultOptions
    })
  },

  // Notificación de éxito
  success(title, text = '') {
    return this.showNotification(title, text, 'success')
  },

  // Notificación de error
  error(title, text = '') {
    return this.showNotification(title, text, 'error')
  },

  // Notificación de advertencia
  warning(title, text = '') {
    return this.showNotification(title, text, 'warning')
  },

  // Notificación de información
  info(title, text = '') {
    return this.showNotification(title, text, 'info')
  },

  // Confirmación (para acciones críticas)
  confirm(title, text = '¿Estás seguro de realizar esta acción?') {
    return Swal.fire({
      title,
      text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, continuar',
      cancelButtonText: 'Cancelar',
      ...defaultOptions
    })
  },

  // Toast notification (notificación emergente)
  toast(title, icon = 'success', position = 'top-end') {
    return Swal.fire({
      title,
      icon,
      position,
      toast: true,
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
  }
}