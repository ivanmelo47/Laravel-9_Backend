<template>
  <div class="table-responsive">

    <table class="table table-hover table-striped">
      <thead class="table-light">
        <tr>
          <th v-if="showActionsButton" style="width: 40px;"></th>
          <th v-for="(column, index) in columns" :key="index">
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, rowIndex) in paginatedData" :key="rowIndex">
          <td v-if="showActionsButton" class="text-center">
            <div class="dropdown" @click.stop>
              <button class="btn btn-sm btn-link text-secondary" type="button" @click="toggleDropdown(rowIndex)"
                :ref="`dropdownButton-${rowIndex}`">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu" :class="{ show: activeDropdown === rowIndex }"
                :style="getDropdownStyle(rowIndex)">
                <li v-for="(action, actionIndex) in actions" :key="actionIndex">
                  <a class="dropdown-item" href="#" @click.prevent="handleAction(action.event, item, rowIndex)">
                    <i :class="`bi bi-${action.icon} text-${action.color || 'primary'} me-2`"></i>
                    {{ action.label }}
                  </a>
                </li>
              </ul>
            </div>
          </td>
          <td v-for="(column, colIndex) in columns" :key="colIndex">
            <template v-if="column.slot">
              <slot :name="`column-${column.field}`" :row="item"></slot>
            </template>
            <template v-else>
              {{ getNestedProperty(item, column.field) }}
            </template>
          </td>
        </tr>
      </tbody>
    </table>

    <nav v-if="shouldPaginate" aria-label="Table pagination" class="mt-3">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="changePage(currentPage - 1)">
            &laquo; Anterior
          </button>
        </li>

        <li v-for="page in pagesToShow" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <button class="page-link" @click="changePage(page)">
            {{ page }}
          </button>
        </li>

        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="changePage(currentPage + 1)">
            Siguiente &raquo;
          </button>
        </li>
      </ul>

      <div class="text-center text-muted mt-2">
        Mostrando {{ startItem }}-{{ endItem }} de {{ totalItems }} elementos
      </div>
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
    itemsPerPage: {
      type: Number,
      default: 10
    },
    showActionsButton: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      currentPage: 1,
      activeDropdown: null
    }
  },
  computed: {
    shouldPaginate() {
      return this.totalItems > this.itemsPerPage
    },
    totalItems() {
      return this.data.length
    },
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage)
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.itemsPerPage
      const end = start + this.itemsPerPage
      return this.data.slice(start, end)
    },
    startItem() {
      return (this.currentPage - 1) * this.itemsPerPage + 1
    },
    endItem() {
      const end = this.currentPage * this.itemsPerPage
      return end > this.totalItems ? this.totalItems : end
    },
    pagesToShow() {
      if (!this.shouldPaginate) return []

      const pages = []
      const maxVisible = 5
      let start = 1
      let end = this.totalPages

      if (this.totalPages > maxVisible) {
        const half = Math.floor(maxVisible / 2)
        start = Math.max(1, this.currentPage - half)
        end = Math.min(this.totalPages, start + maxVisible - 1)

        if (end - start + 1 < maxVisible) {
          start = end - maxVisible + 1
        }
      }

      for (let i = start; i <= end; i++) {
        pages.push(i)
      }

      return pages
    },
    dropdownStyle() {
      return {
        position: 'absolute',
        inset: '0px auto auto 0px',
        margin: '0px',
        transform: 'translate(0px, 26px)',
        zIndex: '1000',
        display: this.activeDropdown !== null ? 'block' : 'none'
      }
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
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page
        this.activeDropdown = null // Cerrar dropdown al cambiar de página
      }
    },

    toggleDropdown(rowIndex) {
      if (this.activeDropdown === rowIndex) {
        this.activeDropdown = null;
      } else {
        this.activeDropdown = rowIndex;
      }
    },

    handleAction(eventName, item, rowIndex) {
      this.activeDropdown = null;
      this.emitAction(eventName, item);
    },

    getDropdownStyle(rowIndex) {
      if (this.activeDropdown !== rowIndex) {
        return { display: 'none' };
      }

      // Posicionamiento relativo al botón
      const button = this.$refs[`dropdownButton-${rowIndex}`]?.[0];
      if (!button) {
        return {
          position: 'absolute',
          inset: '0px auto auto 0px',
          margin: '0px',
          transform: 'translate(0px, 26px)',
          zIndex: '1000'
        };
      }

      const rect = button.getBoundingClientRect();
      return {
        position: 'fixed',
        top: `${rect.bottom + window.scrollY}px`,
        left: `${rect.left + window.scrollX}px`,
        zIndex: '1000'
      };
    },

    closeAllDropdowns(event) {
      if (!event.target.closest('.dropdown')) {
        this.activeDropdown = null;
      }
    }
  },

  mounted() {
    document.addEventListener('click', this.closeAllDropdowns);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeAllDropdowns);
  },

  watch: {
    data() {
      this.currentPage = 1
      this.activeDropdown = null
    }
  }
}
</script>

<style scoped>
.table-responsive {
  margin-bottom: 1rem;
}

.btn-link {
  text-decoration: none;
  padding: 0.25rem 0.5rem;
}

.dropdown-menu {
  font-size: 0.875rem;
}

.dropdown-item {
  cursor: pointer;
  padding: 0.25rem 1rem;
  transition: background-color 0.2s;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}

.page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.page-link {
  color: #0155fe;
  cursor: pointer;
}

/* Estilo para el icono de tres puntos */
.bi-three-dots-vertical {
  font-size: 1.2rem;
}
</style>