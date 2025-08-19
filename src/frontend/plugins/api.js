export default defineNuxtPlugin(() => {
  const api = $fetch.create({
    baseURL: '/api', 
    credentials: 'include',
    async onRequest({ request, options }) {
    },
    async onResponseError({ response }) {
      console.error('API error:', response.status, response._data)
    }
  })
  
  return {
    provide: { api }
  }
})