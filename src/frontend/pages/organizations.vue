<!-- pages/organizations.vue -->
<template>
  <div>
    <UIOrganizationList 
      :organizations="organizationsList"
      :pending="pending"
      :error="error"
      @showCreateModal="showCreateModal = true"
    />
    
    <UIOrganizationCreateModal 
      :show="showCreateModal"
      :isSubmitting="isSubmitting"
      :errors="formErrors"
      :apiError="apiErrorMessage"
      @close="closeModal"
      @submit="createOrganization"
    />
    
    <!-- Success Message -->
    <UICommonNotificationModal 
      v-if="showSuccessMessage" 
      :showSuccessMessage="showSuccessMessage" 
      :message="message"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const { $api } = useNuxtApp()
const { data: response, pending, error, refresh } = await useAsyncData(
  'organizations',
  () => $api('/organizations'),
  {
    server: false,
    transform: (res) => res.data
  }
)
const organizationsList = computed(() => response.value || [])

// Modal and form state
const showCreateModal = ref(false)
const isSubmitting = ref(false)
const showSuccessMessage = ref(false)
const formErrors = ref({})
const apiErrorMessage = ref('')

// Function to close modal and reset errors
const closeModal = () => {
  showCreateModal.value = false
  formErrors.value = {}
  apiErrorMessage.value = ''
}

// Function to create a new organization
const createOrganization = async (formData) => {
  isSubmitting.value = true
  formErrors.value = {}
  apiErrorMessage.value = ''
  
  try {
    const response = await $api('/organizations', {
      method: 'POST',
      body: formData
    })
    
    // Close modal
    closeModal()
    
    // Show success message
    showSuccessMessage.value = true
    setTimeout(() => {
      showSuccessMessage.value = false
    }, 3000)
    
    // Refresh the organizations list
    refresh()
  } catch (err) {
    // Handle different error response formats
    if (err.response) {
      const { status, data } = err.response
      // Handle validation errors (422)
      if (status === 422 && data.errors) {
        formErrors.value = data.errors
      }
      // Handle other API errors (like 404 for duplicate code)
      else if (err.message) {
        apiErrorMessage.value = err.message
        
        // If it's a code error, highlight the code field
        if (data.message.toLowerCase().includes('code')) {
          formErrors.value.code = data.message
        }
      }
    } else {
      apiErrorMessage.value = 'An unexpected error occurred. Please try again.'
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>