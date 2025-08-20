<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm
      title="Create Organization"
      :fields="fields"
      :submit-action="createOrganization"
      @cancel="cancel"
    />
  </div>
</template>

<script setup>
import { useApiService } from '~/composables/useApiService';
definePageMeta({ layout: "setup" });

const api = useApiService();
const router = useRouter();

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
    { value: 'office', label: 'Office' }
  ]},
  { key: 'level', label: 'Level', type: 'text', required: true },
  { key: 'origin', label: 'Origin', type: 'select', required: true, options: [
    { value: 'central', label: 'Central' },
    { value: 'independent', label: 'Independent' }
  ]},
  { key: 'email', label: 'Email', type: 'email' },
  { key: 'phone', label: 'Phone', type: 'text' },
  { key: 'address', label: 'Address', type: 'textarea' },
];

const createOrganization = async (formData) => {
  // Extract contact info for metadata
  const { email, phone, address, ...orgData } = formData;
  
  // Create metadata object
  const metadata = { email, phone, address };
  
  // Add metadata to organization data as a JSON string
  orgData.metadata = JSON.stringify(metadata);
  try {
    await api.organizations.create(orgData);
    router.push('/setup/organizations/list');
  } catch (error) {
    console.error('Failed to create organization:', error);
  }
};

const cancel = () => {
  router.push('/setup/organizations/list');
};
</script>