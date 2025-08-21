<template>
  <div class="container mx-auto px-3 sm:px-3 lg:px-3 py-3">
    <UICommonBaseCrud
      title="Departments"
      :items="departments"
      :columns="columns"
      :pending="pending"
      :error="error"
      :titleIcon="'mdi:category'"
      @create="navigateToCreate"
      @edit="navigateToEdit"
      @delete="confirmDelete"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useApiService } from '~/composables/useApiService';
definePageMeta({ layout: "setup" });

const api = useApiService();
const router = useRouter();

const { data: departments, pending, error, refresh } = await useAsyncData(
  'departments',
  () => api.departments.getAll()
);

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'code', label: 'Code' },
  { key: 'organization', label: 'Organization', format: (org) => org.name },
  { key: 'created_at', label: 'Created', format: (date) => formatDate(date) }
];

const navigateToCreate = () => {
  router.push('/setup/departments/create');
};

const navigateToEdit = (organization) => {
  router.push(`/setup/departments/${organization.id}/edit`);
};

const confirmDelete = async (organization) => {
  try {
    await api.departments.delete(organization.id);
    refresh();
  } catch (err) {
    console.error('Failed to delete organization:', err);
  }
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString();
};
</script>