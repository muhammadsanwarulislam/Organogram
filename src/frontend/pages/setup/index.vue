<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Organogram Setup</h1>
      <p class="mt-2 text-gray-600">Manage your organization structure, departments, positions, and employees.</p>
    </div>

    <!-- Setup Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Organizations Card -->
      <NuxtLink to="/setup/organizations/list" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center mb-4">
          <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
            <Icon name="mdi:office-building" class="h-6 w-6" />
          </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Organizations</h3>
        <p class="text-gray-600 text-sm">Create and manage organizations</p>
        <div class="mt-4 flex items-center text-blue-600 font-medium">
          <span>Manage</span>
          <Icon name="mdi:arrow-right" class="ml-1 h-4 w-4" />
        </div>
      </NuxtLink>

      <!-- Departments Card -->
      <NuxtLink to="/setup/departments/list" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center mb-4">
          <div class="p-3 rounded-lg bg-green-100 text-green-600">
            <Icon name="mdi:domain" class="h-6 w-6" />
          </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Departments</h3>
        <p class="text-gray-600 text-sm">Create and manage departments</p>
        <div class="mt-4 flex items-center text-green-600 font-medium">
          <span>Manage</span>
          <Icon name="mdi:arrow-right" class="ml-1 h-4 w-4" />
        </div>
      </NuxtLink>

      <!-- Positions Card -->
      <NuxtLink to="/setup/positions/list" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center mb-4">
          <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
            <Icon name="mdi:briefcase-account" class="h-6 w-6" />
          </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Positions</h3>
        <p class="text-gray-600 text-sm">Create and manage positions</p>
        <div class="mt-4 flex items-center text-purple-600 font-medium">
          <span>Manage</span>
          <Icon name="mdi:arrow-right" class="ml-1 h-4 w-4" />
        </div>
      </NuxtLink>

      <!-- Employees Card -->
      <NuxtLink to="/setup/employees/list" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center mb-4">
          <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
            <Icon name="mdi:account-group" class="h-6 w-6" />
          </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Employees</h3>
        <p class="text-gray-600 text-sm">Create and manage employees</p>
        <div class="mt-4 flex items-center text-yellow-600 font-medium">
          <span>Manage</span>
          <Icon name="mdi:arrow-right" class="ml-1 h-4 w-4" />
        </div>
      </NuxtLink>
    </div>

    <!-- Quick Stats -->
    <div class="mt-12 bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Stats</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-blue-50 p-4 rounded-lg">
          <div class="text-3xl font-bold text-blue-700">{{ organizationsCount }}</div>
          <div class="text-sm text-blue-600">Organizations</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
          <div class="text-3xl font-bold text-green-700">{{ departmentsCount }}</div>
          <div class="text-sm text-green-600">Departments</div>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
          <div class="text-3xl font-bold text-purple-700">{{ positionsCount }}</div>
          <div class="text-sm text-purple-600">Positions</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
          <div class="text-3xl font-bold text-yellow-700">{{ employeesCount }}</div>
          <div class="text-sm text-yellow-600">Employees</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useApiService } from '~/composables/useApiService';

definePageMeta({ layout: "setup" });

const api = useApiService();

// Fetch data for stats
const { data: organizations } = await useAsyncData(
  'organizations',
  () => api.organizations.getAll()
);

const { data: departments } = await useAsyncData(
  'departments',
  () => api.departments.getAll()
);

const { data: positions } = await useAsyncData(
  'positions',
  () => api.positions.getAll()
);

const { data: employees } = await useAsyncData(
  'employees',
  () => api.employees.getAll()
);

// Calculate counts
const organizationsCount = computed(() => organizations.value.length || 0);
const departmentsCount = computed(() => departments.value.length || 0);
const positionsCount = computed(() => positions.value.length || 0);
const employeesCount = computed(() => employees.value.length || 0);
</script>