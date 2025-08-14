<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Organizations</h1>
      <button 
        @click="$emit('showCreateModal')"
        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
      >
        <Icon name="mdi:plus" class="mr-2 -ml-1 h-5 w-5" />
        Add Organization
      </button>
    </div>
    
    <div v-if="pending" class="flex justify-center items-center h-64">
      <div class="text-center">
        <Icon name="mdi:loading" class="animate-spin h-12 w-12 text-blue-500 mx-auto" />
        <p class="mt-4 text-gray-600">Loading organizations...</p>
      </div>
    </div>
    
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
      <div class="flex">
        <div class="flex-shrink-0">
          <Icon name="mdi:alert-circle" class="h-5 w-5 text-red-400" />
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700">
            Error loading organizations: {{ error.message }}
          </p>
        </div>
      </div>
    </div>
    
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <UIOrganizationCard 
        v-for="org in organizations" 
        :key="org.id" 
        :organization="org" 
      />
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

defineProps({
  organizations: {
    type: Array,
    default: () => []
  },
  pending: {
    type: Boolean,
    default: false
  },
  error: {
    type: Object,
    default: null
  }
})

defineEmits(['showCreateModal'])
</script>