<template>
  <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-16">
      <h1 class="text-5xl font-extrabold text-gray-900 mb-4 tracking-tight animate-fade-in">Organogram Management</h1>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto animate-fade-in" style="animation-delay: 0.2s;">
        Seamlessly visualize and manage your organizational structure with our intuitive dashboard
      </p>
      <div class="mt-8 flex justify-center gap-4">
        <NuxtLink to="/organizations" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-full hover:bg-teal-700 transition-transform transform hover:scale-105">
          Explore Organizations
          <Icon name="mdi:arrow-right" class="ml-2 h-5 w-5" />
        </NuxtLink>
      </div>
    </div>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
      <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow animate-fade-in" style="animation-delay: 0.3s;">
        <div class="bg-teal-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4">
          <Icon name="mdi:domain" class="h-8 w-8 text-teal-600" />
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Organizations</h3>
        <p class="text-gray-600">Centralize management of all your organizations</p>
      </div>
      <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow animate-fade-in" style="animation-delay: 0.4s;">
        <div class="bg-coral-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4">
          <Icon name="mdi:account-tree" class="h-8 w-8 text-coral-600" />
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Organograms</h3>
        <p class="text-gray-600">Visualize hierarchies with interactive trees</p>
      </div>
      <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow animate-fade-in" style="animation-delay: 0.5s;">
        <div class="bg-blue-100 w-14 h-14 rounded-lg flex items-center justify-center mb-4">
          <Icon name="mdi:account-group" class="h-8 w-8 text-blue-600" />
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Employees</h3>
        <p class="text-gray-600">Track positions and relationships effortlessly</p>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-teal-600 to-blue-600 rounded-xl p-10 text-center text-white animate-fade-in" style="animation-delay: 0.6s;">
      <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
      <p class="mb-6 max-w-xl mx-auto">Discover the power of our organogram management system</p>
      <NuxtLink to="/organizations" class="inline-flex items-center px-8 py-4 bg-white text-teal-600 font-semibold rounded-full hover:bg-gray-100 transition-transform transform hover:scale-105">
        Start Exploring
        <Icon name="mdi:arrow-right" class="ml-2 h-5 w-5" />
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
}
</style>