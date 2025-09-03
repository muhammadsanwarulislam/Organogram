import { useLanguage } from '@/composables/useLanguage';

export default defineNuxtPlugin(() => {
  const { initLanguage } = useLanguage();
  initLanguage();
});