<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm 
      title="Edit Department" 
      :fields="fields" 
      :initial-data="formData" 
      :is-edit="true"
      :submit-action="updatePosition" 
      @cancel="cancel" 
    />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useApiService } from '~/composables/useApiService';

definePageMeta({ layout: "admin" });
const api = useApiService();
const router = useRouter();
const route = useRoute();

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
    key: 'organization_id', 
    label: 'Organization', 
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
    await api.positions.update(route.params.id, formData);
    router.push('/admin/positions/list');
  } catch (error) {
    console.error('Failed to update position:', error);
  }
};

const cancel = () => {
  router.push('/admin/positions/list');
};
</script>