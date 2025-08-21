<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm title="Edit Position" 
      :fields="fields" 
      :initial-data="formData" 
      :is-edit="true"
      :submit-action="updatePosition" 
      @cancel="cancel" />

    <!-- Message Showing Modal-->
    <UICommonNotificationModal 
      v-if="showSuccessMessage" 
      :showSuccessMessage="showSuccessMessage" 
      :message="message" />
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useApiService } from '~/composables/useApiService';

definePageMeta({ layout: "setup" });
const api = useApiService();
const router = useRouter();
const route = useRoute();

const showSuccessMessage = ref(false);
const message = ref('');

const { data: position } = await useAsyncData(
  `position-${route.params.id}`,
  () => api.positions.getById(route.params.id)
);

const formData = computed(() => {
  if (!position.value) return {};

  return {
    name: position.value.name || '',
    code: position.value.code || '',
    department_id: position.value.department_id || '',
    grade: position.value.grade || '',
    responsibilities: position.value.responsibilities || ''
  };
});

const { data: departments } = await useAsyncData(
  'departments',
  () => api.departments.getAll()
);

const departmentOptions = computed(() => {
  if (!departments.value) return [];
  return departments.value.map(org => ({
    value: org.id,
    label: org.name
  }));
});

const fields = computed(() => [
  {
    key: 'name',
    label: 'Name',
    type: 'text',
    required: true,
    placeholder: 'Enter department name'
  },
  {
    key: 'code',
    label: 'Code',
    type: 'text',
    required: true,
    placeholder: 'Enter department code'
  },
  {
    key: 'department_id',
    label: 'Department',
    type: 'select',
    required: true,
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

const updatePosition = async (formData) => {
  try {
    const response = await api.positions.update(route.params.id, formData);
    refreshNuxtData();

    showSuccessMessage.value = true
    message.value = response.message;

    setTimeout(() => {
      showSuccessMessage.value = false
      router.push('/setup/positions/list');
    }, 1000)

  } catch (error) {
    console.error('Failed to update position:', error);
  }
};

const cancel = () => {
  router.push('/setup/positions/list');
};
</script>