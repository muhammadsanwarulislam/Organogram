<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseCrud
      title="positions"
      :items="positions"
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
import { useApiService } from '~/composables/useApiService';
definePageMeta({ layout: "admin" });

const api = useApiService();
const router = useRouter();

const { data: positions, pending, error, refresh } = await useAsyncData(
  'positions',
  () => api.positions.getAll()
);

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'code', label: 'Code' },
  { key: 'department', label: 'Department', format: (department) => department.name },
  { key: 'created_at', label: 'Created', format: (date) => formatDate(date) }
];

const navigateToCreate = () => {
  router.push('/admin/positions/create');
};

const navigateToEdit = (organization) => {
  router.push(`/admin/positions/${organization.id}/edit`);
};

const confirmDelete = async (organization) => {
  try {
    await api.positions.delete(organization.id);
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