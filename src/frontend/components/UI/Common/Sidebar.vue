<template>
    <aside :class="[
        'fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-10 transform transition-transform duration-300 ease-in-out',
        { '-translate-x-full md:translate-x-0': !isOpen }
        ]">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="bg-teal-600 p-2 rounded-lg mr-3">
                    <Icon name="mdi:cog" class="h-6 w-6 text-white" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900">{{ t('setup') }}</h1>
            </div>
        </div>

        <nav class="mt-6">
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ t('mainMenu') }}</p>
            </div>
            <NuxtLink v-for="item in navigation" :key="item.name" :to="item.path"
                class="flex items-center px-6 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors duration-200 group"
                :class="{
                    'bg-teal-50 text-teal-700 border-l-4 border-teal-500 font-medium': isActive(item.path)
                }">
                <Icon :name="item.icon"
                    class="mr-3 h-5 w-5 text-gray-500 group-hover:text-teal-600 transition-colors duration-200"
                    :class="{ 'text-teal-600': isActive(item.path) }" />
                <span>{{ item.name }}</span>
            </NuxtLink>
        </nav>
    </aside>
</template>

<script setup>
import { useLanguage } from '@/composables/useLanguage';

const route = useRoute();
const { t, currentLanguageCode } = useLanguage();

defineProps({
    isOpen: {
        type: Boolean,
        default: true
    }
});

const navigation = ref([]);

const updateNavigation = () => {
    navigation.value = [
        { name: t('dashboard'), path: '/setup', icon: 'mdi:view-dashboard' },
        { name: t('organizations'), path: '/setup/organizations/list', icon: 'mdi:office-building' },
        { name: t('employees'), path: '/setup/employees/list', icon: 'mdi:account-group' },
        { name: t('departments'), path: '/setup/departments/list', icon: 'mdi:domain' },
        { name: t('positions'), path: '/setup/positions/list', icon: 'mdi:briefcase-account' }
    ];
};

watch(currentLanguageCode, () => {
    updateNavigation();
}, { immediate: true });

const isActive = (path) => {
    return route.path === path || route.path.startsWith(`${path}/`);
};
</script>