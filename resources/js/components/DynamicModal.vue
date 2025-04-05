<template>
    <div class="modal fade" :id="'dynamicModal-' + modalId" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" :class="size">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div v-for="(field, index) in fields" :key="index" class="mb-3">
                            <label :for="'field-' + index" class="form-label">{{ field.label }}</label>

                            <!-- Input de texto -->
                            <input v-if="field.type === 'text' || field.type === 'email' || field.type === 'password'"
                                :type="field.type" class="form-control" :id="'field-' + index"
                                v-model="fieldValues[field.name]" :required="field.required" />

                            <!-- Textarea -->
                            <textarea v-else-if="field.type === 'textarea'" class="form-control" :id="'field-' + index"
                                v-model="fieldValues[field.name]" :rows="field.rows || 3"
                                :required="field.required"></textarea>

                            <!-- Select -->
                            <select v-else-if="field.type === 'select'" class="form-select" :id="'field-' + index"
                                v-model="fieldValues[field.name]" :required="field.required">
                                <option v-for="option in field.options" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>

                            <!-- Checkbox -->
                            <div v-else-if="field.type === 'checkbox'" class="form-check">
                                <input class="form-check-input" type="checkbox" :id="'field-' + index"
                                    v-model="fieldValues[field.name]" />
                                <label class="form-check-label" :for="'field-' + index">
                                    {{ field.label }}
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" @click="submitForm" :disabled="loading">
                        <span v-if="loading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ loadingText }}
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
    name: 'DynamicModal',
    props: {
        modalId: {
            type: String,
            required: true
        },
        title: {
            type: String,
            default: 'Modal'
        },
        fields: {
            type: Array,
            required: true,
            validator: (fields) => fields.every(f => f.name && f.label && f.type)
        },
        initialValues: {
            type: Object,
            default: () => ({})
        },
        submitText: {
            type: String,
            default: 'Guardar'
        },
        loadingText: {
            type: String,
            default: 'Procesando...'
        },
        size: {
            type: String,
            default: '',
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
            modalInstance: null,
            fieldValues: {},
            localInitialValues: {}
        }
    },
    created() {
        this.resetForm()
    },
    methods: {
        show(initialValues = {}) {
            // Actualiza los valores iniciales si se proporcionan
            if (Object.keys(initialValues).length > 0) {
                this.localInitialValues = {
                    ...JSON.parse(JSON.stringify(this.initialValues)),
                    ...JSON.parse(JSON.stringify(initialValues))
                }
                console.log('Valores iniciales:', JSON.parse(JSON.stringify(this.localInitialValues)))
            }

            this.resetForm()
            if (!this.modalInstance) {
                this.modalInstance = new Modal(document.getElementById('dynamicModal-' + this.modalId))
            }
            this.modalInstance.show()
        },

        hide() {
            if (this.modalInstance) {
                this.modalInstance.hide()
            }
        },

        resetForm() {
            this.fieldValues = {}
            const initialValues = { ...this.localInitialValues } // Desestructura el Proxy

            this.fields.forEach(field => {
                this.fieldValues[field.name] = initialValues[field.name] ||
                    field.defaultValue ||
                    (field.type === 'checkbox' ? false : '')
            })
        },

        submitForm() {
            this.$emit('submit', { ...this.fieldValues })
        }
    }
}
</script>