<template>
  <div class="bg-white rounded-xl shadow-lg p-8 mx-auto border border-gray-100">
    <div class="flex items-center mb-8">
      <div class="bg-teal-100 p-3 rounded-lg mr-4">
        <Icon :name="formIcon" class="h-8 w-8 text-teal-600" />
      </div>
      <h2 class="text-2xl font-bold text-gray-900">{{ title }}</h2>
    </div>
    
    <form @submit.prevent="submitForm">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="field in fields" :key="field.key" class="space-y-1">
          <label :for="field.key" class="block text-sm font-medium text-gray-700 flex items-center">
            <Icon :name="getFieldIcon(field.type)" class="mr-2 h-4 w-4 text-gray-500" />
            {{ field.label }}
            <span v-if="field.required" class="text-red-500 ml-1">*</span>
          </label>

          <!-- Translation Input -->
          <div v-if="field.type === 'translation'" class="space-y-4">
            <div v-for="lang in availableLanguages" :key="lang.code" class="relative">
              <div class="flex items-center mb-1">
                <span class="text-xs font-medium text-gray-500">{{ lang.name }}</span>
                <Icon :name="lang.icon" class="ml-1 h-4 w-4 text-gray-400" />
              </div>
              <input
                :id="`${field.key}-${lang.code}`"
                v-model="formData[field.key][lang.code]"
                type="text"
                :placeholder="field.placeholder"
                :required="field.required"
                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
              />
              <Icon name="mdi:text" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
            </div>
          </div>
          
          <!-- Text Input -->
          <div v-if="field.type === 'text'" class="relative">
            <input
              :id="field.key"
              v-model="formData[field.key]"
              type="text"
              :placeholder="field.placeholder"
              :required="field.required"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
            />
            <Icon name="mdi:text" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
          </div>
          
          <!-- Email Input -->
          <div v-else-if="field.type === 'email'" class="relative">
            <input
              :id="field.key"
              v-model="formData[field.key]"
              type="email"
              :placeholder="field.placeholder"
              :required="field.required"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
            />
            <Icon name="mdi:email" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
          </div>
          
          <!-- Numeric Input  -->
          <div v-else-if="field.type === 'number'" class="relative">
            <input
              :id="field.key"
              v-model="formData[field.key]"
              type="number"
              :placeholder="field.placeholder"
              :required="field.required"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
            />
            <Icon name="mdi:numeric" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
          </div>
          
          <!-- Select Dropdown -->
          <div v-else-if="field.type === 'select'" class="relative">
            <select
              :id="field.key"
              v-model="formData[field.key]"
              :required="field.required"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 appearance-none bg-white"
            >
              <option value="">Select {{ field.label }}</option>
              <option v-for="option in field.options" :key="option.value" :value="option.value">
                {{ option.label }}
              </option>
            </select>
            <Icon name="mdi:menu-down" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400 pointer-events-none" />
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <Icon name="mdi:chevron-down" class="h-5 w-5 text-gray-400" />
            </div>
          </div>
          
          <!-- Textarea -->
          <div v-else-if="field.type === 'textarea'" class="relative">
            <textarea
              :id="field.key"
              v-model="formData[field.key]"
              :placeholder="field.placeholder"
              :required="field.required"
              rows="3"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
            />
            <Icon name="mdi:text" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
          </div>
          
          <!-- Date Input -->
          <div v-else-if="field.type === 'date'" class="relative">
            <input
              :id="field.key"
              v-model="formData[field.key]"
              type="date"
              :required="field.required"
              class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
            />
            <Icon name="mdi:calendar" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" />
          </div>
        </div>
      </div>
      
      <!-- Error Message Display -->
      <div v-if="errorMessage" class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <div class="flex items-center">
          <Icon name="mdi:alert-circle" class="h-5 w-5 text-red-500 mr-2" />
          <p class="text-red-700">{{ errorMessage }}</p>
        </div>
      </div>
      
      <div class="mt-10 flex justify-end space-x-4">
        <button
          type="button"
          @click="cancel"
          class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center"
        >
          <Icon name="mdi:close" class="mr-2 h-5 w-5" />
          Cancel
        </button>
        <button
          type="submit"
          :disabled="saving"
          class="px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg hover:from-teal-600 hover:to-teal-700 disabled:from-teal-300 disabled:to-teal-400 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center"
        >
          <Icon v-if="saving" name="mdi:loading" class="animate-spin mr-2 h-5 w-5" />
          <Icon v-else :name="isEdit ? 'mdi:update' : 'mdi:plus-circle'" class="mr-2 h-5 w-5" />
          {{ isEdit ? 'Update' : 'Create' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useLanguage } from '~/composables/useLanguage';

const { availableLanguages } = useLanguage();
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  formIcon: {
    type: String,
    default: 'mdi:form-select'
  },
  fields: {
    type: Array,
    required: true
  },
  initialData: {
    type: Object,
    default: () => ({})
  },
  isEdit: {
    type: Boolean,
    default: false
  },
  submitAction: {
    type: Function,
    required: true
  }
});

const emit = defineEmits(['cancel']);
const saving = ref(false);
const errorMessage = ref('');
const formData = reactive({});

// Initialize form data
const initializeFormData = () => {
  props.fields.forEach(field => {
    if (field.type === 'translation') {
      // Initialize translation fields with empty strings for each language
      if (!formData[field.key]) {
        formData[field.key] = {};
      }
      
      availableLanguages.forEach(lang => {
        if (!formData[field.key][lang.code]) {
          formData[field.key][lang.code] = props.initialData[field.key]?.[lang.code] || '';
        }
      });
    } else {
      // Initialize regular fields
      if (formData[field.key] === undefined) {
        formData[field.key] = props.initialData[field.key] || '';
      }
    }
  });
};

// Initialize immediately and also watch for changes
initializeFormData();

// Watch for field changes to reinitialize if needed
watch(() => props.fields, initializeFormData, { deep: true, immediate: true });

const getFieldIcon = (type) => {
  const iconMap = {
    'text': 'mdi:text',
    'email': 'mdi:email',
    'number': 'mdi:numeric',
    'select': 'mdi:menu-down',
    'textarea': 'mdi:text',
    'date': 'mdi:calendar',
    'translation': 'mdi:translate'
  };
  return iconMap[type] || 'mdi:text';
};

const submitForm = async () => {
  saving.value = true;
  errorMessage.value = '';
  
  try {
    await props.submitAction(formData);
  } catch (error) {
    console.error('Form submission error:', error);
    errorMessage.value = error.response?.data?.message || 'An error occurred while submitting the form';
  } finally {
    saving.value = false;
  }
};

const cancel = () => {
  emit('cancel');
};
</script>

<style scoped>
/* Custom animations */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Custom select styling */
select {
  background-image: none;
}
</style>