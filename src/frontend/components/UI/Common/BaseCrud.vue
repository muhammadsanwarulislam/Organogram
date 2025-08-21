<template>
  <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-900 flex items-center">
        <Icon :name="titleIcon" class="mr-3 h-7 w-7 text-teal-600" />
        {{ title }}
      </h2>
      <button 
        @click="$emit('create')" 
        class="px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg hover:from-teal-600 hover:to-teal-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center"
      >
        <Icon name="mdi:plus" class="mr-2 h-5 w-5" />
        Add New
      </button>
    </div>
    
    <!-- Search and Filters -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px] relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <Icon name="mdi:magnify" class="h-5 w-5 text-gray-400" />
          </div>
          <input 
            v-model="searchQuery" 
            type="text" 
            placeholder="Search..." 
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors"
          />
        </div>
        <div v-if="filters.length > 0" class="flex gap-2">
          <select 
            v-for="filter in filters" 
            :key="filter.key"
            v-model="filterValues[filter.key]"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white transition-colors"
          >
            <option value="">{{ filter.label }}</option>
            <option v-for="option in filter.options" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
          </select>
        </div>
      </div>
    </div>
    
    <!-- Loading State -->
    <div v-if="pending" class="flex justify-center items-center h-64 bg-gray-50 rounded-lg border border-gray-200">
      <div class="text-center">
        <Icon name="mdi:loading" class="animate-spin h-12 w-12 text-teal-500 mx-auto" />
        <p class="mt-4 text-gray-600 font-medium">Loading data...</p>
      </div>
    </div>
    
    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
      <div class="flex items-center">
        <Icon name="mdi:alert-circle" class="h-6 w-6 text-red-500 mr-3" />
        <p class="text-red-700 font-medium">{{ error.message }}</p>
      </div>
    </div>
    
    <!-- Data Table -->
    <div v-else class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
          <tr>
            <th 
              v-for="column in columns" 
              :key="column.key"
              scope="col" 
              class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
              @click="sortBy(column.key)"
            >
              <div class="flex items-center">
                {{ column.label }}
                <Icon 
                  v-if="sortKey === column.key" 
                  :name="sortOrder === 'asc' ? 'mdi:arrow-up' : 'mdi:arrow-down'" 
                  class="ml-1 h-4 w-4 text-teal-600"
                />
              </div>
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(item, index) in paginatedItems" :key="item.id" 
              :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
              class="hover:bg-teal-50 transition-colors duration-150">
            <td 
              v-for="column in columns" 
              :key="column.key" 
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium"
            >
              {{ column.format ? column.format(item[column.key]) : item[column.key] }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <button 
                @click="$emit('edit', item)" 
                class="text-teal-600 hover:text-teal-800 mr-4 p-1 rounded-full hover:bg-teal-100 transition-colors"
                title="Edit"
              >
                <Icon name="mdi:pencil" class="h-5 w-5" />
              </button>
              <button 
                @click="confirmDelete(item)" 
                class="text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-100 transition-colors"
                title="Delete"
              >
                <Icon name="mdi:delete" class="h-5 w-5" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="mt-4 px-6 py-3 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-between items-center">
        <div class="text-sm text-gray-700">
          Showing <span class="font-medium">{{ (currentPage - 1) * itemsPerPage + 1 }}</span> to 
          <span class="font-medium">{{ Math.min(currentPage * itemsPerPage, filteredItems.length) }}</span> of 
          <span class="font-medium">{{ filteredItems.length }}</span> results
        </div>
        <div class="flex space-x-2">
          <button 
            @click="currentPage--" 
            :disabled="currentPage === 1" 
            class="px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center"
          >
            <Icon name="mdi:chevron-left" class="h-5 w-5" />
            Previous
          </button>
          <div class="flex items-center">
            <span class="text-sm text-gray-700">Page</span>
            <span class="mx-2 px-3 py-1 bg-teal-500 text-white rounded-md text-sm font-medium">{{ currentPage }}</span>
            <span class="text-sm text-gray-700">of {{ totalPages }}</span>
          </div>
          <button 
            @click="currentPage++" 
            :disabled="currentPage === totalPages" 
            class="px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center"
          >
            Next
            <Icon name="mdi:chevron-right" class="h-5 w-5" />
          </button>
        </div>
      </div>
    </div>
    
    <!-- Empty State -->
    <div v-if="!pending && !error && filteredItems.length === 0" class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
      <Icon name="mdi:inbox" class="mx-auto h-16 w-16 text-gray-400" />
      <p class="mt-4 text-lg font-medium">No {{ title.toLowerCase() }} found</p>
      <p class="mt-2 text-gray-600">Try adjusting your search or filter criteria</p>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
      <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full transform transition-all duration-300 scale-95 animate-scale-in">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
          <Icon name="mdi:alert-circle" class="h-6 w-6 text-red-600" />
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Confirm Delete</h3>
        <p class="text-gray-600 mb-6 text-center">
          Are you sure you want to delete this {{ title.toLowerCase() }}? This action cannot be undone.
        </p>
        <div class="flex justify-center space-x-3">
          <button 
            @click="showDeleteModal = false" 
            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium"
          >
            Cancel
          </button>
          <button 
            @click="deleteItem" 
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-md hover:shadow-lg"
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

// Add a prop for the title icon
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  titleIcon: {
    type: String,
    default: 'mdi:table'
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

<style scoped>
.animate-scale-in {
  animation: scaleIn 0.3s ease-out forwards;
}

@keyframes scaleIn {
  from {
    transform: scale(0.95);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}
</style>