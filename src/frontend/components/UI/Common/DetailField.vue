<template>
  <div>
    <h4 class="text-sm font-medium text-gray-500">{{ label }}</h4>
    <p class="mt-1 text-lg text-gray-900">{{ value }}</p>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true
  },
  value: {
    type: String,
    required: true
  }
});
</script>