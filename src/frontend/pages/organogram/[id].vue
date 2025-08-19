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
              <span
                class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                <Icon name="mdi:domain" class="mr-2 h-5 w-5" />
                {{ organization?.type }}
              </span>
              <span
                class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
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
          <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id" :class="[
            'relative py-4 px-1 text-sm font-medium transition-colors duration-300',
            activeTab === tab.id
              ? 'text-teal-600 border-b-2 border-teal-600'
              : 'text-gray-500 hover:text-gray-700 hover:border-gray-300',
            'flex items-center'
          ]">
            <Icon :name="tab.icon" class="mr-2 h-5 w-5" />
            {{ tab.label }}
            <span v-if="activeTab === tab.id"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-teal-600 scale-x-0 animate-underline"></span>
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="animate-fade-in">
        <!-- Details Tab -->
        <UIOrganizationDetails v-if="activeTab === 'details'" :organization="organization" />

        <!-- Tree Tab -->
        <UIOrganizationTree v-if="activeTab === 'tree'" :organizationId="organization.id" />

        <!-- Departments Tab -->
        <UIOrganizationDepartments v-if="activeTab === 'departments'" :organization="organization" />

        <!-- Employees Tab -->
        <UIOrganizationEmployees v-if="activeTab === 'employees'" :organization="organization" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useOrganization } from '@/composables/useOrganization';

const activeTab = ref('details');
const { organization, pending, error } = useOrganization();

// Tabs configuration
const tabs = [
  { id: 'details', label: 'Details', icon: 'mdi:information' },
  { id: 'tree', label: 'Organogram Tree', icon: 'mdi:account-tree' },
  { id: 'departments', label: 'Departments', icon: 'mdi:domain' },
  { id: 'employees', label: 'Employees', icon: 'mdi:account-group' },
];
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
}

@keyframes underline {
  from {
    transform: scaleX(0);
  }

  to {
    transform: scaleX(1);
  }
}

.animate-underline {
  animation: underline 0.3s ease-out forwards;
}
</style>