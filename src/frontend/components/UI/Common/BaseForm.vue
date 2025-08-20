<template>
  <div class="bg-white rounded-xl shadow-lg p-6 mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ title }}</h2>
    
    <form @submit.prevent="submitForm">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div v-for="field in fields" :key="field.key" class="space-y-1">
          <label :for="field.key" class="block text-sm font-medium text-gray-700">
            {{ field.label }}
          </label>

          <!-- Text Input -->
          <input
            v-if="field.type === 'text'"
            :id="field.key"
            v-model="formData[field.key]"
            type="text"
            :placeholder="field.placeholder"
            :required="field.required"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          />

          <!-- Email Input -->
          <input
            v-else-if="field.type === 'email'"
            :id="field.key"
            v-model="formData[field.key]"
            type="email"
            :placeholder="field.placeholder"
            :required="field.required"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          />

          <!-- Numeric Input  -->
          <input
            v-else-if="field.type === 'number'"
            :id="field.key"
            v-model="formData[field.key]"
            type="number"
            :placeholder="field.placeholder"
            :required="field.required"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          />
          
          <!-- Select Dropdown -->
          <select
            v-else-if="field.type === 'select'"
            :id="field.key"
            v-model="formData[field.key]"
            :required="field.required"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          >
            <option value="">Select {{ field.label }}</option>
            <option v-for="option in field.options" :key="option.value" :value="option.value">
              {{ option.label }}
            </option>
          </select>
          
          <!-- Textarea -->
          <textarea
            v-else-if="field.type === 'textarea'"
            :id="field.key"
            v-model="formData[field.key]"
            :placeholder="field.placeholder"
            :required="field.required"
            rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          />
          
          <!-- Date Input -->
          <input
            v-else-if="field.type === 'date'"
            :id="field.key"
            v-model="formData[field.key]"
            type="date"
            :required="field.required"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
          />
        </div>
      </div>
      
      <div class="mt-8 flex justify-end space-x-3">
        <button
          type="button"
          @click="cancel"
          class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
        >
          Cancel
        </button>
        <button
          type="submit"
          :disabled="saving"
          class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 disabled:bg-teal-300"
        >
          <Icon v-if="saving" name="mdi:loading" class="animate-spin mr-2 h-5 w-5" />
          {{ isEdit ? 'Update' : 'Create' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true
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
const formData = reactive({});

onMounted(() => {
  props.fields.forEach(field => {
    formData[field.key] = props.initialData[field.key] || '';
  });
});

const submitForm = async () => {
  saving.value = true;
  try {
    await props.submitAction(formData);
  } catch (error) {
    console.error('Form submission error:', error);
  } finally {
    saving.value = false;
  }
};

const cancel = () => {
  emit('cancel');
};
</script>