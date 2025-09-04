import { ref, computed } from 'vue';

type LanguageCode = 'en' | 'bn';

interface Language {
  code: LanguageCode;
  name: string;
  icon: string;
}

const availableLanguages: Language[] = [
  { code: 'en', name: 'English', icon: 'mdi:flag-outline' },
  { code: 'bn', name: 'বাংলা', icon: 'mdi:flag' },
];

const currentLanguageCode = ref<LanguageCode>('en');

const translations = {
  en: {
    dashboard: "Dashboard",
    organizations: "Organizations",
    employees: "Employees",
    departments: "Departments",
    positions: "Positions",
    setup: "Setup",
    mainMenu: "Main Menu",
    admin: "Admin"
  },
  bn: {
    dashboard: "ড্যাশবোর্ড",
    organizations: "প্রতিষ্ঠান",
    employees: "কর্মচারী",
    departments: "বিভাগ",
    positions: "পদ",
    setup: "সেটআপ",
    mainMenu: "প্রধান মেনু",
    admin: "অ্যাডমিন"
  }
};

export const useLanguage = () => {
  const currentLanguage = computed(() => {
    return availableLanguages.find(lang => lang.code === currentLanguageCode.value) || availableLanguages[0];
  });
  
  const setLanguage = (langCode: LanguageCode) => {
    currentLanguageCode.value = langCode;
    localStorage.setItem('userLanguage', langCode);
  };
  
  const t = (key: string) => {
    return translations[currentLanguageCode.value]?.[key] || key;
  };
  
  const initLanguage = () => {
    if (typeof window !== 'undefined') {
      const savedLanguageCode = localStorage.getItem('userLanguage') as LanguageCode;
      if (savedLanguageCode && availableLanguages.some(lang => lang.code === savedLanguageCode)) {
        currentLanguageCode.value = savedLanguageCode;
      }
    }
  };
  
  return {
    availableLanguages,
    currentLanguage,
    currentLanguageCode, 
    translations,
    setLanguage,
    t, 
    initLanguage
  };
};