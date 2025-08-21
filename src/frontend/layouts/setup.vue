<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <div 
      :class="['fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-10 transform transition-transform duration-300 ease-in-out', 
               { '-translate-x-full md:translate-x-0': !sidebarOpen }]"
    >
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center">
          <div class="bg-teal-600 p-2 rounded-lg mr-3">
            <Icon name="mdi:cog" class="h-6 w-6 text-white" />
          </div>
          <h1 class="text-2xl font-bold text-gray-900">Setup</h1>
        </div>
      </div>
      
      <nav class="mt-6">
        <div class="px-4 mb-2">
          <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</p>
        </div>
        <NuxtLink
          v-for="item in navigation"
          :key="item.name"
          :to="item.path"
          class="flex items-center px-6 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors duration-200 group"
          :class="{ 'bg-teal-50 text-teal-700 border-l-4 border-teal-500 font-medium': isActive(item.path) }"
        >
          <Icon 
            :name="item.icon" 
            class="mr-3 h-5 w-5 text-gray-500 group-hover:text-teal-600 transition-colors duration-200"
            :class="{ 'text-teal-600': isActive(item.path) }" 
          />
          <span>{{ item.name }}</span>
        </NuxtLink>
      </nav>
    </div>
    
    <!-- Mobile menu button -->
    <button 
      @click="toggleSidebar" 
      class="md:hidden fixed top-4 left-4 z-20 bg-white p-2 rounded-md shadow-md text-gray-700 hover:bg-gray-100 focus:outline-none"
    >
      <Icon :name="sidebarOpen ? 'mdi:close' : 'mdi:menu'" class="h-6 w-6" />
    </button>
    
    <!-- Main Content -->
    <div class="flex-1 md:ml-64">
      <header class="bg-white shadow-sm">
        <div class="px-6 py-4 flex justify-between items-center">
          <div class="flex items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ pageTitle }}</h2>
          </div>
        </div>
      </header>
      
      <main class="p-6">
        <slot />
      </main>
    </div>
    
    <!-- Overlay for mobile sidebar -->
    <div 
      v-if="sidebarOpen && isMobile" 
      @click="toggleSidebar" 
      class="fixed inset-0 bg-black bg-opacity-50 z-0 md:hidden"
    ></div>
  </div>
</template>

<script setup>
const route = useRoute();
const sidebarOpen = ref(true);
const userMenuOpen = ref(false);
const isMobile = ref(false);

// Check if we're on mobile
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

const navigation = [
  { name: 'Dashboard', path: '/setup', icon: 'mdi:view-dashboard' },
  { name: 'Organizations', path: '/setup/organizations/list', icon: 'mdi:office-building' },
  { name: 'Employees', path: '/setup/employees/list', icon: 'mdi:account-group' },
  { name: 'Departments', path: '/setup/departments/list', icon: 'mdi:domain' },
  { name: 'Positions', path: '/setup/positions/list', icon: 'mdi:briefcase-account' }
];

const pageTitle = computed(() => {
  const currentNav = navigation.find(item => route.path.startsWith(item.path));
  return currentNav ? currentNav.name : 'Admin';
});

const isActive = (path) => {
  return route.path === path || route.path.startsWith(`${path}/`);
};

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const toggleUserMenu = () => {
  userMenuOpen.value = !userMenuOpen.value;
};

// Close user menu when clicking outside
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