<!-- layouts/admin.vue -->
<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-md z-10">
      <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-900">Setup</h1>
      </div>
      <nav class="mt-6">
        <NuxtLink
          v-for="item in navigation"
          :key="item.name"
          :to="item.path"
          class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900"
          :class="{ 'bg-gray-100 text-gray-900 border-l-4 border-teal-500': isActive(item.path) }"
        >
          <Icon :name="item.icon" class="mr-3 h-5 w-5" />
          {{ item.name }}
        </NuxtLink>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
      <header class="bg-white shadow">
        <div class="px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-semibold text-gray-800">{{ pageTitle }}</h2>
          <div class="flex items-center space-x-4">
            <!-- <span class="text-gray-600">Admin User</span>
            <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
              A
            </div> -->
          </div>
        </div>
      </header>
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
const route = useRoute();

const navigation = [
  { name: 'Dashboard', path: '/admin', icon: 'mdi:view-dashboard' },
  { name: 'Organizations', path: '/admin/organizations/list', icon: 'mdi:office-building' },
  { name: 'Employees', path: '/admin/employees/list', icon: 'mdi:account-group' },
  { name: 'Departments', path: '/admin/departments/list', icon: 'mdi:domain' },
  { name: 'Positions', path: '/admin/positions/list', icon: 'mdi:briefcase-account' }
];

const pageTitle = computed(() => {
  const currentNav = navigation.find(item => route.path.startsWith(item.path));
  return currentNav ? currentNav.name : 'Admin';
});

const isActive = (path) => {
  return route.path === path || route.path.startsWith(`${path}/`);
};
</script>