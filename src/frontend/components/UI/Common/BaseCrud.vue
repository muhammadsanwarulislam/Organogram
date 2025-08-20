<template>
  <div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-900">{{ title }}</h2>
      <button 
        @click="$emit('create')" 
        class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors"
      >
        <Icon name="mdi:plus" class="mr-2 h-5 w-5" />
        Add New
      </button>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6 flex flex-wrap gap-4">
      <div class="flex-1 min-w-[200px]">
        <input 
          v-model="searchQuery" 
          type="text" 
          placeholder="Search..." 
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
        />
      </div>
      <div v-if="filters.length > 0" class="flex gap-2">
        <select 
          v-for="filter in filters" 
          :key="filter.key"
          v-model="filterValues[filter.key]"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
        >
          <option value="">{{ filter.label }}</option>
          <option v-for="option in filter.options" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="pending" class="flex justify-center items-center h-64">
      <Icon name="mdi:loading" class="animate-spin h-12 w-12 text-teal-500" />
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
      <div class="flex">
        <Icon name="mdi:alert-circle" class="h-5 w-5 text-red-500 mr-2" />
        <p class="text-red-700">{{ error.message }}</p>
      </div>
    </div>

    <!-- Data Table -->
    <div v-else class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th 
              v-for="column in columns" 
              :key="column.key"
              scope="col" 
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
              @click="sortBy(column.key)"
            >
              {{ column.label }}
              <Icon 
                v-if="sortKey === column.key" 
                :name="sortOrder === 'asc' ? 'mdi:arrow-up' : 'mdi:arrow-down'" 
                class="ml-1 h-4 w-4"
              />
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="item in paginatedItems" :key="item.id" class="hover:bg-gray-50">
            <td 
              v-for="column in columns" 
              :key="column.key" 
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
            >
              {{ column.format ? column.format(item[column.key]) : item[column.key] }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <button 
                @click="$emit('edit', item)" 
                class="text-teal-600 hover:text-teal-900 mr-4"
              >
                <Icon name="mdi:pencil" class="h-5 w-5" />
              </button>
              <button 
                @click="confirmDelete(item)" 
                class="text-red-600 hover:text-red-900"
              >
                <Icon name="mdi:delete" class="h-5 w-5" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-6 flex justify-between items-center">
        <button 
          @click="currentPage--" 
          :disabled="currentPage === 1" 
          class="px-4 py-2 bg-teal-600 text-white rounded-lg disabled:bg-gray-300"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button 
          @click="currentPage++" 
          :disabled="currentPage === totalPages" 
          class="px-4 py-2 bg-teal-600 text-white rounded-lg disabled:bg-gray-300"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!pending && !error && filteredItems.length === 0" class="text-center py-12 text-gray-500">
      <Icon name="mdi:inbox" class="mx-auto h-12 w-12 text-gray-400" />
      <p class="mt-4">No {{ title.toLowerCase() }} found</p>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Delete</h3>
        <p class="text-gray-600 mb-6">
          Are you sure you want to delete this {{ title.toLowerCase() }}? This action cannot be undone.
        </p>
        <div class="flex justify-end space-x-3">
          <button 
            @click="showDeleteModal = false" 
            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
          >
            Cancel
          </button>
          <button 
            @click="deleteItem" 
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  items: {
    type: Array,
    required: true
  },
  columns: {
    type: Array,
    required: true
  },
  pending: {
    type: Boolean,
    default: false
  },
  error: {
    type: Object,
    default: null
  },
  filters: {
    type: Array,
    default: () => []
  }
});

const emit = defineEmits(['create', 'edit', 'delete']);

// Search and sort
const searchQuery = ref('');
const sortKey = ref('');
const sortOrder = ref('asc');
const currentPage = ref(1);
const itemsPerPage = 10;
const filterValues = ref({});

// Delete modal
const showDeleteModal = ref(false);
const itemToDelete = ref(null);

// Computed properties
const filteredItems = computed(() => {
  let result = [...props.items];
  
  // Apply search
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(item => {
      return Object.values(item).some(val => 
        String(val).toLowerCase().includes(query)
      );
    });
  }
  
  // Apply filters
  props.filters.forEach(filter => {
    if (filterValues.value[filter.key]) {
      result = result.filter(item => 
        item[filter.key] === filterValues.value[filter.key]
      );
    }
  });
  
  // Apply sorting
  if (sortKey.value) {
    result.sort((a, b) => {
      const aValue = a[sortKey.value] || '';
      const bValue = b[sortKey.value] || '';
      const comparison = aValue.localeCompare(bValue);
      return sortOrder.value === 'asc' ? comparison : -comparison;
    });
  }
  
  return result;
});

const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage));
const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredItems.value.slice(start, start + itemsPerPage);
});

// Methods
const sortBy = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortKey.value = key;
    sortOrder.value = 'asc';
  }
};

const confirmDelete = (item) => {
  itemToDelete.value = item;
  showDeleteModal.value = true;
};

const deleteItem = async () => {
  if (itemToDelete.value) {
    emit('delete', itemToDelete.value);
    showDeleteModal.value = false;
    itemToDelete.value = null;
  }
};

// Reset pagination when filters change
watch([searchQuery, filterValues], () => {
  currentPage.value = 1;
});
</script>