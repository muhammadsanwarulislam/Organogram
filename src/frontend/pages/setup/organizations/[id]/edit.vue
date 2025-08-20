<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm
      title="Edit Organization"
      :fields="fields"
      :initial-data="formData"
      :is-edit="true"
      :submit-action="updateOrganization"
      @cancel="cancel"
    />
  </div>
</template>

<script setup>
import { useApiService } from '~/composables/useApiService';
import { parseMetadata } from '~/utils/helpers';

definePageMeta({ layout: "setup" });
const api = useApiService();
const router = useRouter();
const route = useRoute();

const { data: organization } = await useAsyncData(
  `organization-${route.params.id}`,
  () => api.organizations.getById(route.params.id)
);

// Transform organization data for the form
const formData = computed(() => {
  if (!organization.value) return {};

  const metadata = parseMetadata(organization.value.metadata);

  return {
    ...organization.value,
    email: metadata.email || '',
    phone: metadata.phone || '',
    address: metadata.address || ''
  };
});

const fields = [
  { key: 'name', label: 'Name', type: 'text', required: true },
  { key: 'code', label: 'Code', type: 'text', required: true },
  { key: 'type', label: 'Type', type: 'select', required: true, options: [
    { value: 'ministry', label: 'Ministry' },
    { value: 'division', label: 'Division' },
    { value: 'office', label: 'Office' }
  ]},
  { key: 'layer', label: 'Layer', type: 'select', required: true, options: [
    { value: 'ministry', label: 'Ministry' },
    { value: 'division', label: 'Division' },
    { value: 'office', label: 'Office' },
    { value: 'commission', label: 'Commission' }, 
  ]},
  { key: 'level', label: 'Level', type: 'number', required: true },
  { key: 'origin', label: 'Origin', type: 'select', required: true, options: [
    { value: 'central', label: 'Central' },
    { value: 'independent', label: 'Independent' }
  ]},
  { key: 'email', label: 'Email', type: 'email' },
  { key: 'phone', label: 'Phone', type: 'text' },
  { key: 'address', label: 'Address', type: 'textarea' },
  { key: 'status', label: 'Status', type: 'select', required: true, options: [
    { value: 'active', label: 'Active' },
    { value: 'inactive', label: 'Inactive' }
  ]}
];

const updateOrganization = async (formData) => {
  // Extract contact info for metadata
  const { email, phone, address, ...orgData } = formData;
  
  // Create metadata object
  const metadata = { email, phone, address };
  
  // Add metadata to organization data as a JSON string
  orgData.metadata = JSON.stringify(metadata);
  
  try {
    await api.organizations.update(route.params.id, orgData);
    router.push('/setup/organizations/list');
  } catch (error) {
    console.error('Failed to update organization:', error);
  }
};

const cancel = () => {
  router.push('/setup/organizations/list');
};
</script>