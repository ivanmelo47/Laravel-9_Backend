<template>
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="table-light">
          <tr>
            <th v-for="(column, index) in columns" :key="index">
              {{ column.label }}
            </th>
            <th v-if="actions.length > 0">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, rowIndex) in data" :key="rowIndex">
            <td v-for="(column, colIndex) in columns" :key="colIndex">
              <!-- Renderizado de contenido normal o personalizado -->
              <template v-if="column.slot">
                <slot :name="`column-${column.field}`" :row="item"></slot>
              </template>
              <template v-else>
                {{ getNestedProperty(item, column.field) }}
              </template>
            </td>
            
            <!-- Columna de acciones -->
            <td v-if="actions.length > 0">
              <div class="btn-group btn-group-sm">
                <button
                  v-for="(action, actionIndex) in actions"
                  :key="actionIndex"
                  class="btn"
                  :class="`btn-outline-${action.color || 'primary'}`"
                  @click="emitAction(action.event, item)"
                  :title="action.label"
                >
                  <i :class="`bi bi-${action.icon}`"></i>
                  <span v-if="action.showLabel" class="ms-1 d-none d-sm-inline">
                    {{ action.label }}
                  </span>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Paginación -->
      <nav v-if="pagination" aria-label="Table pagination" class="mt-3">
        <ul class="pagination justify-content-center">
          <li class="page-item" :class="{ disabled: pagination.currentPage === 1 }">
            <button class="page-link" @click="changePage(pagination.currentPage - 1)">
              &laquo; Anterior
            </button>
          </li>
          
          <li
            v-for="page in pagesToShow"
            :key="page"
            class="page-item"
            :class="{ active: page === pagination.currentPage }"
          >
            <button class="page-link" @click="changePage(page)">
              {{ page }}
            </button>
          </li>
          
          <li class="page-item" :class="{ disabled: pagination.currentPage === pagination.totalPages }">
            <button class="page-link" @click="changePage(pagination.currentPage + 1)">
              Siguiente &raquo;
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </template>
  
  <script>
  export default {
    name: 'TableComponent',
    props: {
      columns: {
        type: Array,
        required: true,
        validator: (value) => {
          return value.every(col => typeof col.label === 'string' && typeof col.field === 'string')
        }
      },
      data: {
        type: Array,
        required: true
      },
      actions: {
        type: Array,
        default: () => []
      },
      pagination: {
        type: Object,
        default: null
      }
    },
    computed: {
      pagesToShow() {
        if (!this.pagination) return []
        
        const pages = []
        const maxVisible = 5
        let start = 1
        let end = this.pagination.totalPages
        
        if (this.pagination.totalPages > maxVisible) {
          const half = Math.floor(maxVisible / 2)
          start = Math.max(1, this.pagination.currentPage - half)
          end = Math.min(this.pagination.totalPages, start + maxVisible - 1)
          
          if (end - start + 1 < maxVisible) {
            start = end - maxVisible + 1
          }
        }
        
        for (let i = start; i <= end; i++) {
          pages.push(i)
        }
        
        return pages
      }
    },
    methods: {
      getNestedProperty(obj, path) {
        return path.split('.').reduce((o, p) => (o || {})[p], obj)
      },
      emitAction(eventName, item) {
        this.$emit(eventName, item)
      },
      changePage(page) {
        if (page >= 1 && page <= this.pagination.totalPages) {
          this.$emit('page-changed', page)
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .table-responsive {
    margin-bottom: 1rem;
  }
  
  .btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
  }
  
  .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
  
  .page-link {
    color: #0155fe;
    cursor: pointer;
  }
  </style>