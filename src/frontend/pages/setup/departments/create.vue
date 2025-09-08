<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm 
      title="Create Department" 
      :fields="fields" 
      :submit-action="createDepartment" 
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

const showSuccessMessage = ref(false);
const message = ref('');

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
    type: 'translation',
    required: true,
    placeholder: 'Enter name'
  },
  {
    key: 'code',
    label: 'Code',
    type: 'translation',
    required: true,
    placeholder: 'Enter code'
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

const createDepartment = async (formData) => {
  try {
    const response = await api.departments.create(formData);

    showSuccessMessage.value = true
    message.value = response.message;
    refreshNuxtData();

    setTimeout(() => {
      showSuccessMessage.value = false
      router.push('/setup/departments/list');
    }, 1000)

  } catch (error) {
    console.error('Failed to create department:', error);
  } 
};

const cancel = () => {
  router.push('/setup/departments/list');
};
</script>