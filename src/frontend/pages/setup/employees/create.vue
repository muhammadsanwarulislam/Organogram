<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <UICommonBaseForm
      title="Create Employee"
      :fields="fields"
      :submit-action="createEmployee"
      @cancel="cancel"
    />

    <!-- Message Showing Modal-->
    <UICommonNotificationModal
      v-if="showSuccessMessage"
      :showSuccessMessage="showSuccessMessage"
      :message="message"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useApiService } from '~/composables/useApiService';
definePageMeta({ layout: "setup" });

const api = useApiService();
const router = useRouter();

const showSuccessMessage = ref(false);
const message = ref('');

const { data: organizations } = await useAsyncData(
  'organizations',
  () => api.organizations.getAll()
);

const organizationOptions = computed(() => {
  if (!organizations.value?.length) return [];
  return organizations.value.map(org => ({
    value: org.id,
    label: org.name
  }));
});

const { data: positions } = await useAsyncData(
  'positions',
  () => api.positions.getAll()
);

const positionOptions = computed(() => {
  if (!positions.value?.length) return [];
  return positions.value.map(dep => ({
    value: dep.id,
    label: dep.name
  }));
})

const { data: employees } = await useAsyncData(
  'employees',
  () => api.employees.getAll()
);

const employeeOptions = computed(() => {
  if (!employees.value?.length) return [];
  return employees.value.map(emp => ({
    value: emp.id,
    label: emp.name
  }));
})

const fields = [
  { 
    key: 'name', 
    label: 'Name', 
    type: 'text', 
    required: true 
  },
  { 
    key: 'email', 
    label: 'Email', 
    type: 'email', 
    required: true 
  },
  { 
    key: 'phone', 
    label: 'Phone', 
    type: 'text', 
    required: true 
  },
  { 
    key: 'organization_id', 
    label: 'Organization', 
    type: 'select', 
    required: true, 
    options: organizationOptions.value
  },
  { 
    key: 'position_id', 
    label: 'Position', 
    type: 'select', 
    required: true, 
    options: positionOptions.value
  },
  { 
    key: 'reporting_to', 
    label: 'Supervisor', 
    type: 'select', 
    options: employeeOptions.value
  },
  {
    key: 'employee_id',
    label: 'Employee unique ID like (MOA-0001)',
    type: 'text',
    required: true
  },
  {
    key: 'joining_date',
    label: 'Joining Date',
    type: 'date',
    required: true
  }
];

const createEmployee = async (formData) => {
  try {
    const response = await api.employees.create(formData);
    refreshNuxtData();

    showSuccessMessage.value = true;
    message.value = response.message;
    
    setTimeout(() => {
      showSuccessMessage.value = false
      router.push('/setup/employees/list');
    }, 1000)

  } catch (error) {
    console.error('Failed to create employee:', error);
  }
};

const cancel = () => {
  router.push('/setup/employees/list');
};
</script>