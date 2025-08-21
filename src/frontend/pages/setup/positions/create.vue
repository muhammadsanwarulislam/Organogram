<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm 
      title="Create Position" 
      :fields="fields" 
      :submit-action="createPosition" 
      @cancel="cancel" />
  </div>

  <!-- Message Showing Modal-->
  <UICommonNotificationModal 
    v-if="showSuccessMessage" 
    :showSuccessMessage="showSuccessMessage" 
    :message="message"
  />
</template>

<script setup>
import { computed, ref } from 'vue';
import { useApiService } from '~/composables/useApiService';

definePageMeta({ layout: "setup" });
const api = useApiService();
const router = useRouter();

const showSuccessMessage = ref(false);
const message = ref('');

const { data: departments } = await useAsyncData(
  'departments',
  () => api.departments.getAll()
);

const departmentOptions = computed(() => {
  if (!departments.value?.length) return [];
  return departments.value.map(dep => ({
    value: dep.id,
    label: dep.name
  }));
})

const fields = computed(() => [
  {
    key: 'name',
    label: 'Name',
    type: 'text',
    required: true,
    placeholder: 'Enter name'
  },
  {
    key: 'code',
    label: 'Code',
    type: 'text',
    required: true,
    placeholder: 'Enter code'
  },
  {
    key: 'department_id',
    label: 'Department',
    type: 'select',
    options: departmentOptions.value
  },
  {
    key: 'grade',
    label: 'Grade',
    type: 'number',
    placeholder: 'Enter grade',
    required: true
  },
  {
    key: 'responsibilities',
    label: 'Responsibilities',
    type: 'textarea',
    placeholder: 'Enter responsibilities'
  }
]);

const createPosition = async (formData) => {
  try {
    const response = await api.positions.create(formData);
    refreshNuxtData();

    showSuccessMessage.value = true
    message.value = response.message;

    setTimeout(() => {
      showSuccessMessage.value = false
      router.push('/setup/positions/list');
    }, 1000)

  } catch (error) {
    console.error('Failed to create position:', error);
  }
};

const cancel = () => {
  router.push('/setup/positions/list');
};
</script>