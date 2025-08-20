<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseCrud
      title="employees"
      :items="employees"
      :columns="columns"
      :pending="pending"
      :error="error"
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

const { data: employees, pending, error, refresh } = await useAsyncData(
  'employees',
  () => api.employees.getAll()
);

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'organization', label: 'Organization', format: (organization) => organization.name },
  { key: 'position', label: 'Position', format: (position) => position.name },
  { key: 'subordinates', label: 'Subordinates', format: (subordinates) => subordinates.length },
  { key: 'created_at', label: 'Created', format: (date) => formatDate(date) },
];

const navigateToCreate = () => {
  router.push('/setup/employees/create');
};

const navigateToEdit = (organization) => {
  router.push(`/setup/employees/${organization.id}/edit`);
};

const confirmDelete = async (organization) => {
  try {
    await api.employees.delete(organization.id);
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