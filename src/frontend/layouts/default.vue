<template>
  <BaseLayout>
    <template #header>
      <UICommonHeader name="default-header" />
    </template>

    <slot />

    <template #footer>
      <UICommonFooter name="default-footer" />
    </template>
  </BaseLayout>
</template>

<script setup>
import BaseLayout from './base'
</script>