<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Loading State -->
    <div v-if="pending" class="flex justify-center items-center h-64">
      <div class="text-center">
        <Icon name="mdi:loading" class="animate-spin h-12 w-12 text-teal-500 mx-auto" />
        <p class="mt-4 text-gray-600">Loading organogram...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-8 animate-fade-in">
      <div class="flex items-center">
        <Icon name="mdi:alert-circle" class="h-6 w-6 text-red-500 mr-3" />
        <p class="text-base text-red-700">Error loading organogram: {{ error.message }}</p>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else>
      <!-- Header Section -->
      <div class="bg-white rounded-xl shadow-lg p-8 mb-8 animate-fade-in">
        <div class="flex justify-between items-start">
          <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ organization?.name }}</h1>
            <div class="mt-3 flex items-center space-x-4">
              <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                <Icon name="mdi:domain" class="mr-2 h-5 w-5" />
                {{ organization?.type }}
              </span>
              <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                {{ organization?.code }}
              </span>
            </div>
          </div>
          <div class="bg-teal-100 rounded-full p-4">
            <Icon name="mdi:office-building" class="h-10 w-10 text-teal-600" />
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <div class="border-b border-gray-200 mb-8">
        <nav class="flex space-x-8 -mb-px">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'relative py-4 px-1 text-sm font-medium transition-colors duration-300',
              activeTab === tab.id
                ? 'text-teal-600 border-b-2 border-teal-600'
                : 'text-gray-500 hover:text-gray-700 hover:border-gray-300',
              'flex items-center'
            ]"
          >
            <Icon :name="tab.icon" class="mr-2 h-5 w-5" />
            {{ tab.label }}
            <span v-if="activeTab === tab.id" class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-600 scale-x-0 animate-underline"></span>
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="animate-fade-in">
        <!-- Details Tab -->
        <div v-if="activeTab === 'details'" class="bg-white rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Organization Details</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
              <div>
                <h3 class="text-sm font-medium text-gray-500">Name</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.name }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Type</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.type }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Code</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.code }}</p>
              </div>
            </div>
            <div class="space-y-6">
              <div>
                <h3 class="text-sm font-medium text-gray-500">Address</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.address || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.phone || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <p class="mt-1 text-lg text-gray-900">{{ organization?.email || 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tree Tab -->
        <div v-if="activeTab === 'tree'" class="bg-white rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Organogram Structure</h2>
          <div class="overflow-x-auto">
            <UIOrganogramNode v-if="organization" :node="organization" />
          </div>
        </div>

        <!-- Departments Tab -->
        <div v-if="activeTab === 'departments'" class="bg-white rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Departments</h2>
          <div v-if="organization?.departments && organization.departments.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="dept in organization.departments" :key="dept.id" class="bg-gray-50 p-6 rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
              <h3 class="text-lg font-semibold text-gray-900">{{ dept.name }}</h3>
              <p class="text-sm text-gray-500 mt-1">{{ dept.code }}</p>
              <div v-if="dept.positions && dept.positions.length > 0" class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">Positions:</h4>
                <ul class="mt-2 space-y-2">
                  <li v-for="pos in dept.positions" :key="pos.id" class="text-sm text-gray-600">
                    {{ pos.name }} (Grade: {{ pos.grade || 'N/A' }})
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-12 text-gray-500">No departments found</div>
        </div>

        <!-- Employees Tab -->
        <div v-if="activeTab === 'employees'" class="bg-white rounded-xl shadow-lg p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Employees</h2>
          <div class="mb-6 flex justify-between items-center">
            <input v-model="searchQuery" type="text" placeholder="Search employees..." class="w-full max-w-xs px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" />
          </div>
          <div v-if="filteredEmployees.length > 0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sortTable('name')">Name</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sortTable('employee_id')">Employee ID</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" @click="sortTable('email')">Email</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joining Date</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="emp in paginatedEmployees" :key="emp.id" class="hover:bg-teal-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ emp.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ emp.employee_id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ emp.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ emp.phone || 'N/A' }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(emp.joining_date) }}</td>
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
      </div>
    </div>
  </div>
</template>

<script setup>
const route = useRoute();
const activeTab = ref('details');
const organizationId = route.params.id;
const { getOrganization } = useOrganogram();

const { data: response, pending, error } = await useAsyncData(
  `organization-${organizationId}`,
  () => getOrganization(organizationId),
  {
    server: false,
    transform: (response) => response.data,
  }
);

const organization = computed(() => response.value);

// Tabs configuration
const tabs = [
  { id: 'details', label: 'Details', icon: 'mdi:information' },
  { id: 'tree', label: 'Organogram Tree', icon: 'mdi:account-tree' },
  { id: 'departments', label: 'Departments', icon: 'mdi:domain' },
  { id: 'employees', label: 'Employees', icon: 'mdi:account-group' },
];

// Employee table search and sort
const searchQuery = ref('');
const sortKey = ref('name');
const sortOrder = ref('asc');

const filteredEmployees = computed(() => {
  if (!organization.value?.employees) return [];
  const query = searchQuery.value.toLowerCase();
  return organization.value.employees.filter(emp =>
    emp.name.toLowerCase().includes(query) ||
    emp.employee_id.toLowerCase().includes(query) ||
    emp.email.toLowerCase().includes(query)
  ).sort((a, b) => {
    const aValue = a[sortKey.value] || '';
    const bValue = b[sortKey.value] || '';
    return sortOrder.value === 'asc' ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
  });
});

// Pagination
const currentPage = ref(1);
const itemsPerPage = 5;
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

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
}
@keyframes underline {
  from { transform: scaleX(0); }
  to { transform: scaleX(1); }
}
.animate-underline {
  animation: underline 0.3s ease-out forwards;
}
</style>