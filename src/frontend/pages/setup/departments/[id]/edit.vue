<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm 
      title="Edit Department" 
      :fields="fields" 
      :initial-data="formData" 
      :is-edit="true"
      :submit-action="updateDepartment" 
      @cancel="cancel" 
    />

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

const { data: department } = await useAsyncData(
  `department-${route.params.id}`,
  () => api.departments.getById(route.params.id)
);

const formData = computed(() => {
  if (!department.value) return {};

  return {
    name: department.value.name || '',
    code: department.value.code || '',
    organization_id: department.value.organization_id || '',
    parent_id: department.value.parent_id || ''
  };
});

const { data: organizations } = await useAsyncData(
  'organizations',
  () => api.organizations.getAll()
);

const organizationOptions = computed(() => {
  if (!organizations.value?.length) return [];
  return organizations.value.map(org => ({
    value: org.id,
    label: org.name
  }));
});

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
    options: organizationOptions.value
  },
  { 
    key: 'parent_id', 
    label: 'Parent Department', 
    type: 'select', 
    options: departmentOptions.value
  }
]);

const updateDepartment = async (formData) => {
  try {
    const response = await api.departments.update(route.params.id, formData);
    refreshNuxtData();

    showSuccessMessage.value = true
    message.value = response.message;
    setTimeout(() => {
      showSuccessMessage.value = false
      router.push('/setup/departments/list');
    }, 1000)

  } catch (error) {
    console.error('Failed to update department:', error);
  }
};

const cancel = () => {
  router.push('/setup/departments/list');
};
</script>