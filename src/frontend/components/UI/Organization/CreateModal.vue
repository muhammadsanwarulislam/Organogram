<template>
  <Transition name="modal">
    <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <!-- Modal Header with Gradient -->
        <div class="bg-gradient-to-r from-teal-600 to-blue-600 px-6 py-5 rounded-t-xl">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                <Icon name="mdi:domain-plus" class="h-6 w-6 text-white" />
              </div>
              <h3 class="text-xl font-bold text-white">Create New Organization</h3>
            </div>
            <button 
              @click="$emit('close')" 
              class="text-white hover:text-gray-200 transition-colors"
            >
              <Icon name="mdi:close" class="h-6 w-6" />
            </button>
          </div>
        </div>
        
        <!-- Error Alert -->
        <div v-if="apiError" class="mx-6 mt-6">
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex">
              <div class="flex-shrink-0">
                <Icon name="mdi:alert-circle" class="h-5 w-5 text-red-400" />
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">
                  {{ apiError }}
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <form @submit.prevent="handleSubmit">
          <div class="px-6 py-5 space-y-5">
            <!-- Organization Name Field -->
            <div class="space-y-1">
              <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                <Icon name="mdi:domain" class="h-4 w-4 mr-1.5 text-teal-600" />
                Organization Name
              </label>
              <div class="relative">
                <input
                  type="text"
                  id="name"
                  v-model="formData.name"
                  required
                  :class="[
                    'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition',
                    errors.name ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                  ]"
                  placeholder="Enter organization name"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Icon name="mdi:domain" class="h-5 w-5 text-gray-400" />
                </div>
              </div>
              <p v-if="errors.name" class="mt-1 text-sm text-red-600 flex items-center">
                <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                {{ errors.name }}
              </p>
            </div>
            
            <!-- Two Column Layout for Code and Type -->
            <div class="grid grid-cols-2 gap-4">
              <!-- Code Field -->
              <div class="space-y-1">
                <label for="code" class="block text-sm font-medium text-gray-700 flex items-center">
                  <Icon name="mdi:identifier" class="h-4 w-4 mr-1.5 text-teal-600" />
                  Code
                </label>
                <div class="relative">
                  <input
                    type="text"
                    id="code"
                    v-model="formData.code"
                    required
                    :class="[
                      'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition',
                      errors.code ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                    ]"
                    placeholder="Code"
                  />
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Icon name="mdi:identifier" class="h-5 w-5 text-gray-400" />
                  </div>
                </div>
                <p v-if="errors.code" class="mt-1 text-sm text-red-600 flex items-center">
                  <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                  {{ errors.code }}
                </p>
              </div>
              
              <!-- Type Field -->
              <div class="space-y-1">
                <label for="type" class="block text-sm font-medium text-gray-700 flex items-center">
                  <Icon name="mdi:shape" class="h-4 w-4 mr-1.5 text-teal-600" />
                  Type
                </label>
                <div class="relative">
                  <select
                    id="type"
                    v-model="formData.type"
                    required
                    :class="[
                      'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition appearance-none',
                      errors.type ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                    ]"
                  >
                    <option value="">Select type</option>
                    <option value="ministry">Ministry</option>
                    <option value="division">Division</option>
                    <option value="department">Department</option>
                    <option value="office">Office</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Icon name="mdi:shape" class="h-5 w-5 text-gray-400" />
                  </div>
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <Icon name="mdi:chevron-down" class="h-5 w-5 text-gray-400" />
                  </div>
                </div>
                <p v-if="errors.type" class="mt-1 text-sm text-red-600 flex items-center">
                  <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                  {{ errors.type }}
                </p>
              </div>
            </div>
            
            <!-- metadata Fields Section -->
            <div class="space-y-1">
              <div class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <Icon name="mdi:format-list-bulleted" class="h-4 w-4 mr-1.5 text-teal-600" />
                Additional Information
              </div>
              
              <!-- Address Field -->
              <div class="space-y-1">
                <label for="address" class="block text-sm font-medium text-gray-700 flex items-center">
                  <Icon name="mdi:map-marker" class="h-4 w-4 mr-1.5 text-teal-600" />
                  Address
                </label>
                <div class="relative">
                  <textarea
                    id="address"
                    v-model="formData.metadata.address"
                    rows="2"
                    :class="[
                      'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition resize-none',
                      errors['metadata.address'] ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                    ]"
                    placeholder="Enter address"
                  ></textarea>
                  <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                    <Icon name="mdi:map-marker" class="h-5 w-5 text-gray-400" />
                  </div>
                </div>
                <p v-if="errors['metadata.address']" class="mt-1 text-sm text-red-600 flex items-center">
                  <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                  {{ errors['metadata.address'] }}
                </p>
              </div>
              
              <!-- Two Column Layout for Phone and Email -->
              <div class="grid grid-cols-2 gap-4">
                <!-- Phone Field -->
                <div class="space-y-1">
                  <label for="phone" class="block text-sm font-medium text-gray-700 flex items-center">
                    <Icon name="mdi:phone" class="h-4 w-4 mr-1.5 text-teal-600" />
                    Phone
                  </label>
                  <div class="relative">
                    <input
                      type="text"
                      id="phone"
                      v-model="formData.metadata.phone"
                      :class="[
                        'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition',
                        errors['metadata.phone'] ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                      ]"
                      placeholder="Phone number"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <Icon name="mdi:phone" class="h-5 w-5 text-gray-400" />
                    </div>
                  </div>
                  <p v-if="errors['metadata.phone']" class="mt-1 text-sm text-red-600 flex items-center">
                    <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                    {{ errors['metadata.phone'] }}
                  </p>
                </div>
                
                <!-- Email Field -->
                <div class="space-y-1">
                  <label for="email" class="block text-sm font-medium text-gray-700 flex items-center">
                    <Icon name="mdi:email" class="h-4 w-4 mr-1.5 text-teal-600" />
                    Email
                  </label>
                  <div class="relative">
                    <input
                      type="email"
                      id="email"
                      v-model="formData.metadata.email"
                      :class="[
                        'mt-1 block w-full border rounded-lg shadow-sm py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 sm:text-sm transition',
                        errors['metadata.email'] ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-teal-500'
                      ]"
                      placeholder="Email address"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <Icon name="mdi:email" class="h-5 w-5 text-gray-400" />
                    </div>
                  </div>
                  <p v-if="errors['metadata.email']" class="mt-1 text-sm text-red-600 flex items-center">
                    <Icon name="mdi:alert-circle" class="h-4 w-4 mr-1" />
                    {{ errors['metadata.email'] }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end space-x-3">
            <button
              type="button"
              @click="$emit('close')"
              class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 transition"
            >
              <Icon v-if="isSubmitting" name="mdi:loading" class="animate-spin -ml-1 mr-2 h-4 w-4" />
              <Icon v-else name="mdi:plus-circle" class="-ml-1 mr-2 h-4 w-4" />
              {{ isSubmitting ? 'Creating...' : 'Create Organization' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </Transition>
</template>

<script setup>
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  isSubmitting: {
    type: Boolean,
    default: false
  },
  errors: {
    type: Object,
    default: () => ({})
  },
  apiError: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['close', 'submit'])

const formData = ref({
  name: '',
  code: '',
  type: '',
  metadata: {
    address: '',
    phone: '',
    email: ''
  }
})

const handleSubmit = () => {
  // Create a copy of the form data
  const payload = {
    name: formData.value.name,
    code: formData.value.code,
    type: formData.value.type,
    metadata: JSON.stringify(formData.value.metadata)
  }
  
  emit('submit', payload)
}

// Reset form when modal is opened
watch(() => props.show, (newVal) => {
  if (newVal) {
    formData.value = {
      name: '',
      code: '',
      type: '',
      metadata: {
        address: '',
        phone: '',
        email: ''
      }
    }
  }
})
</script>

<style scoped>
/* Modal transition animations */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .bg-white,
.modal-leave-active .bg-white {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-enter-from .bg-white,
.modal-leave-to .bg-white {
  transform: scale(0.95);
  opacity: 0;
}

/* Custom select arrow */
select {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}
</style>