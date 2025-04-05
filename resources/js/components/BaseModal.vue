<template>
    <div class="modal fade" :id="modalId" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" :class="modalSize">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancelar
            </button>
            <button 
              type="button" 
              class="btn btn-primary" 
              @click="handleSubmit"
              :disabled="loading"
            >
              <span v-if="loading">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Procesando...
              </span>
              <span v-else>
                {{ submitText }}
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Modal } from 'bootstrap'
  
  export default {
    name: 'BaseModal',
    props: {
      modalId: {
        type: String,
        required: true
      },
      title: {
        type: String,
        default: 'Modal'
      },
      submitText: {
        type: String,
        default: 'Guardar'
      },
      size: {
        type: String,
        default: '', // 'modal-lg', 'modal-xl', 'modal-sm'
        validator: (value) => ['', 'modal-lg', 'modal-xl', 'modal-sm'].includes(value)
      },
      loading: {
        type: Boolean,
        default: false
      }
    },
    emits: ['submit'],
    data() {
      return {
        modalInstance: null
      }
    },
    computed: {
      modalSize() {
        return this.size ? this.size : ''
      }
    },
    methods: {
      show() {
        if (!this.modalInstance) {
          this.modalInstance = new Modal(document.getElementById(this.modalId))
        }
        this.modalInstance.show()
      },
      hide() {
        if (this.modalInstance) {
          this.modalInstance.hide()
        }
      },
      handleSubmit() {
        this.$emit('submit')
      }
    }
  }
  </script>