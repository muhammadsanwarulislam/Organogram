<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-xl font-bold text-gray-800">{{ organization.name }}</h2>
          <div class="mt-1 flex items-center space-x-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
              <Icon name="mdi:domain" class="mr-1 h-4 w-4" />
              {{ organization.type }}
            </span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
              {{ organization.code }}
            </span>
          </div>
        </div>
        <div class="bg-gray-100 rounded-full p-2">
          <Icon name="mdi:office-building" class="h-6 w-6 text-gray-600" />
        </div>
      </div>
      <div class="mt-4 space-y-2">
        <div v-if="parsedMeta.address" class="flex items-center text-sm text-gray-600">
          <Icon name="mdi:map-marker" class="h-4 w-4 mr-2" />
          {{ parsedMeta.address }}
        </div>
        <div v-if="parsedMeta.phone" class="flex items-center text-sm text-gray-600">
          <Icon name="mdi:phone" class="h-4 w-4 mr-2" />
          {{ parsedMeta.phone }}
        </div>
        <div v-if="parsedMeta.email" class="flex items-center text-sm text-gray-600">
          <Icon name="mdi:email" class="h-4 w-4 mr-2" />
          {{ parsedMeta.email }}
        </div>
      </div>
      
      <div class="mt-6">
        <NuxtLink 
          :to="`/organogram/${organization.id}`" 
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          View Organogram
          <Icon name="mdi:arrow-right" class="ml-2 -mr-1 h-4 w-4" />
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  organization: {
    type: Object,
    required: true
  }
})

const parsedMeta = computed(() => {
  try {
    if (typeof props.organization.metadata === 'object') {
      return props.organization.meta;
    }
    return props.organization.metadata ? JSON.parse(props.organization.metadata) : {};
  } catch (e) {
    console.error('Error parsing metadata:', e);
    return {};
  }
})
</script>