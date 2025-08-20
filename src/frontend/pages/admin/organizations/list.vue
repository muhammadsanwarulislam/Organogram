<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseCrud
      title="Organizations"
      :items="organizations"
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

const { data: organizations, pending, error, refresh } = await useAsyncData(
  'organizations',
  () => api.organizations.getAll()
);

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'code', label: 'Code' },
  { key: 'type', label: 'Type' },
  { key: 'created_at', label: 'Created', format: (date) => formatDate(date) }
];

const navigateToCreate = () => {
  router.push('/admin/organizations/create');
};

const navigateToEdit = (organization) => {
  router.push(`/admin/organizations/${organization.id}/edit`);
};

const confirmDelete = async (organization) => {
  try {
    await api.organizations.delete(organization.id);
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