<template>
  <div class="relative" ref="languageDropdown">
    <button 
      @click="toggleMenu"
      class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 focus:outline-none"
    >
      <Icon :name="currentLanguage.icon" class="h-5 w-5" />
      <span>{{ currentLanguage.name }}</span>
      <Icon name="mdi:chevron-down" class="h-4 w-4" />
    </button>
    
    <div 
      v-if="isOpen"
      class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-200"
    >
      <button 
        v-for="language in availableLanguages" 
        :key="language.code" 
        @click="handleChangeLanguage(language.code)"
        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
        :class="{ 'bg-gray-100 font-medium': currentLanguage.code === language.code }"
      >
        <Icon :name="language.icon" class="mr-3 h-5 w-5" />
        <span>{{ language.name }}</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { useLanguage } from '@/composables/useLanguage';

const { 
  availableLanguages, 
  currentLanguage, 
  setLanguage 
} = useLanguage();

const isOpen = ref(false);
const languageDropdown = ref(null);

const toggleMenu = () => {
  isOpen.value = !isOpen.value;
};

const handleChangeLanguage = async(langCode) => {
  setLanguage(langCode);
  isOpen.value = false;

  try {
    // await refreshNuxtData();
    window.location.reload();
  } catch (error) {
    console.error('Error blurring dropdown:', error);
  }
};

const closeMenu = (event) => {
  if (!event.target.closest('.relative')) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', closeMenu);
});

onUnmounted(() => {
  document.removeEventListener('click', closeMenu);
});
</script>