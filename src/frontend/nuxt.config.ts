// https://nuxt.com/docs/api/configuration/nuxt-config
import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  css: ['~/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss(),
    ],
  },
  ssr: false,
  devtools: { enabled: true },
  modules: ['@nuxt/icon'],
  plugins: [
    '~/plugins/api.js',
    '~/plugins/init-language.client.ts'
  ],
  compatibilityDate: '2025-08-13',
  runtimeConfig: {
    public: {
      apiBase: '/api'
    },
    apiBaseUrl: process.env.API_BASE_URL || 'http://localhost:8000'
  },
  nitro: {
    devProxy: {
      '/api': {
        target: process.env.API_BASE_URL || 'http://localhost:8000',
        changeOrigin: true,
        rewrite: path => path.replace(/^\/api/, '')
      }
    }
  },
  app: {
    head: {
      title: 'Organogram',
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { charset: 'utf-8' },
        { name: 'description', content: 'Organogram application' }
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
      ]
    }
  }
})