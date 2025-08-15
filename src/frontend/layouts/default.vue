<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <UICommonHeader />

    <main class="flex-grow">
      <slot />
    </main>

    <UICommonFooter />
  </div>
</template>

<script setup>
</script>