<template>
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-teal-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m0 0l-4-4m4 4l4-4m-4-16v16m0 0l-4-4m4 4l4-4" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-900">Organogram</span>
            </div>
            <nav class="flex space-x-6">
                <NuxtLink to="/"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors"
                    exact-active-class="bg-teal-50 text-teal-700">
                    Home
                </NuxtLink>
                <NuxtLink to="/organizations"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors"
                    exact-active-class="bg-teal-50 text-teal-700">
                    Organizations
                </NuxtLink>
            </nav>
        </div>
    </header>
</template>