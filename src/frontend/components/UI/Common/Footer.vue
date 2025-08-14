<template>
    <footer class="bg-gradient-to-r from-teal-600 to-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m0 0l-4-4m4 4l4-4m-4-16v16m0 0l-4-4m4 4l4-4" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Organogram</span>
                    </div>
                    <p class="text-teal-100 mb-6 max-w-md">
                        A comprehensive organogram management system designed to visualize organizational structures,
                        manage employee data, and streamline reporting relationships.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://github.com/muhammadsanwarulislam" target="_blank" rel="noopener noreferrer"
                            class="bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/sanwarul/" target="_blank" rel="noopener noreferrer"
                            class="bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="mailto:muhammad.sanwarul94@gmail.com"
                            class="bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <NuxtLink to="/" class="text-teal-100 hover:text-white transition-colors">Home</NuxtLink>
                        </li>
                        <li>
                            <NuxtLink to="/organizations" class="text-teal-100 hover:text-white transition-colors">
                                Organizations</NuxtLink>
                        </li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">API Reference</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Tutorials</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Support</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-teal-100 hover:text-white transition-colors">Community</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-teal-500 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-teal-100">© {{ new Date().getFullYear() }} Organogram Management System. All rights
                    reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-teal-100 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-teal-100 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-teal-100 hover:text-white transition-colors">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>
</template>