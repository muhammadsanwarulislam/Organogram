<!-- components/OrganizationDepartments.vue -->
<template>
  <div class="bg-white rounded-xl shadow-lg p-8">
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
</template>

<script setup>
defineProps({
  organization: {
    type: Object,
    required: true
  }
});
</script>