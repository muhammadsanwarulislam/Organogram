<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar -->
        <UICommonSidebar :is-open="sidebarOpen" />

        <!-- Mobile menu button -->
        <button @click="toggleSidebar"
            class="md:hidden fixed top-4 left-4 z-20 bg-white p-2 rounded-md shadow-md text-gray-700 hover:bg-gray-100 focus:outline-none">
            <Icon :name="sidebarOpen ? 'mdi:close' : 'mdi:menu'" class="h-6 w-6" />
        </button>
        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <h2 class="text-xl font-semibold text-gray-800">{{  t('dashboard') }}</h2>
                    </div>
                    <!-- Language Switcher -->
                    <UICommonLanguageSwitcher />
                </div>
            </header>
            <main class="p-6">
                <slot />
            </main>
        </div>
        <!-- Overlay for mobile sidebar -->
        <div v-if="sidebarOpen && isMobile" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-0 md:hidden"></div>
    </div>
</template>
<script setup>
import { useLanguage } from '@/composables/useLanguage';

const { t } = useLanguage();
const route = useRoute();
const sidebarOpen = ref(true);
const userMenuOpen = ref(false);
const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
    if (!isMobile.value) {
        sidebarOpen.value = true;
    }
};
// Initialize and add resize listener
onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});
onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value;
};

const closeUserMenu = (event) => {
    if (!event.target.closest('.relative')) {
        userMenuOpen.value = false;
    }
};
onMounted(() => {
    document.addEventListener('click', closeUserMenu);
});
onUnmounted(() => {
    document.removeEventListener('click', closeUserMenu);
});
</script>