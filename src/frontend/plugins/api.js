import { useLanguage } from '@/composables/useLanguage';
import { computed } from 'vue';

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig();
  const { currentLanguageCode } = useLanguage();
  
  const acceptLanguageHeader = computed(() => ({
    'Accept-Language': currentLanguageCode.value || localStorage.getItem('userLanguage')
  }));
  
  const api = $fetch.create({
    baseURL: config.public.apiBase, 
    credentials: 'include', 
    async onRequest({ request, options }) {
      // const token = useCookie('access_token');
      // if (token.value) {
      //   options.headers = options.headers || {};
      //   options.headers.Authorization = `Bearer ${token.value}`;
      // }
      options.headers = {
        ...options.headers,
        ...acceptLanguageHeader.value
      };
    },
    async onResponseError({ response }) {
      console.error('API error:', response.status, response._data);
    }
  });
  
  return {
    provide: { 
      api: api 
    }
  }
});