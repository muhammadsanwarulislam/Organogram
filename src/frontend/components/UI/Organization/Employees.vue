<!-- components/OrganizationEmployees.vue -->
<template>
  <div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Employees</h2>
    <div class="mb-6 flex justify-between items-center">
      <input v-model="searchQuery" type="text" placeholder="Search employees..." class="w-full max-w-xs px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" />
    </div>
    <div v-if="filteredEmployees.length > 0" class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th v-for="column in columns" :key="column.key" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sortTable(column.key)">
              {{ column.label }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="emp in paginatedEmployees" :key="emp.id" class="hover:bg-teal-50 transition-colors">
            <td v-for="column in columns" :key="column.key" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              {{ column.format ? column.format(emp[column.key]) : emp[column.key] || 'N/A' }}
            </td>
          </tr>
        </tbody>
      </table>
      <!-- Pagination -->
      <div class="mt-6 flex justify-between items-center">
        <button @click="currentPage--" :disabled="currentPage === 1" class="px-4 py-2 bg-teal-600 text-white rounded-lg disabled:bg-gray-300">Previous</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="currentPage++" :disabled="currentPage === totalPages" class="px-4 py-2 bg-teal-600 text-white rounded-lg disabled:bg-gray-300">Next</button>
      </div>
    </div>
    <div v-else class="text-center py-12 text-gray-500">No employees found</div>
  </div>
</template>

<script setup>
const props = defineProps({
  organization: {
    type: Object,
    required: true
  }
});

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'employee_id', label: 'Employee ID' },
  { key: 'email', label: 'Email' },
  { key: 'phone', label: 'Phone' },
  { key: 'joining_date', label: 'Joining Date', format: (date) => formatDate(date) }
];

// Employee table search and sort
const searchQuery = ref('');
const sortKey = ref('name');
const sortOrder = ref('asc');
const currentPage = ref(1);
const itemsPerPage = 5;

const filteredEmployees = computed(() => {
  if (!props.organization?.employees) return [];
  const query = searchQuery.value.toLowerCase();
  return props.organization.employees.filter(emp =>
    emp.name.toLowerCase().includes(query) ||
    emp.employee_id.toLowerCase().includes(query) ||
    emp.email.toLowerCase().includes(query)
  ).sort((a, b) => {
    const aValue = a[sortKey.value] || '';
    const bValue = b[sortKey.value] || '';
    return sortOrder.value === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
  });
});

const totalPages = computed(() => Math.ceil(filteredEmployees.value.length / itemsPerPage));
const paginatedEmployees = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return filteredEmployees.value.slice(start, start + itemsPerPage);
});

const sortTable = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortKey.value = key;
    sortOrder.value = 'asc';
  }
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>