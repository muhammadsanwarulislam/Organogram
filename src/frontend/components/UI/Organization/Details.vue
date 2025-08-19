<!-- components/OrganizationDetails.vue -->
<template>
  <div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Organization Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Basic Information -->
      <div class="space-y-6">
        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>
        <UICommonDetailField label="Name" :value="organization?.name" />
        <UICommonDetailField label="Type" :value="organization?.type" />
        <UICommonDetailField label="Code" :value="organization?.code" />
      </div>

      <!-- Contact Information -->
      <div class="space-y-6">
        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Contact Information</h3>
        <UICommonDetailField label="Address" :value="organization?.metadata?.address || 'N/A'" />
        <UICommonDetailField label="Phone" :value="organization?.metadata?.phone || 'N/A'" />
        <UICommonDetailField label="Email" :value="organization?.metadata?.email || 'N/A'" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  organization: {
    type: Object,
    required: true
  }
});
</script>