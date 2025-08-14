<template>
    <div v-if="showSuccessMessage" class="fixed bottom-4 right-4 bg-green-50 border-l-4 border-green-500 p-4 shadow-md rounded-md z-50">
      <div class="flex">
        <div class="flex-shrink-0">
          <Icon name="mdi:check-circle" class="h-5 w-5 text-green-400" />
        </div>
        <div class="ml-3">
          <p class="text-sm text-green-700">
            {{ message }}
          </p>
        </div>
      </div>
    </div>
</template>
<script setup>
defineProps({
  showSuccessMessage: {
    type: Boolean,
    default: false
  },
  message: {
    type: String,
    default: 'Operation successful!'
  }
})
</script>