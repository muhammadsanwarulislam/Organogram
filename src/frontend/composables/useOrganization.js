export const useOrganization = () => {
  const route = useRoute();
  const organizationId = computed(() => route.params.id);
  const { getOrganization } = useOrganogram();
  
  const { data: response, pending, error } = useAsyncData(
    `organization-${organizationId.value}`,
    () => getOrganization(organizationId.value),
    {
      server: false,
      transform: (response) => response.data,
    }
  );
  
  const organization = computed(() => {
    const org = response.value;
    if (org && typeof org.metadata === 'string') {
      try {
        org.metadata = JSON.parse(org.metadata);
      } catch (e) {
        console.error('Failed to parse metadata:', e);
        org.metadata = {};
      }
    }
    return org;
  });
  
  return {
    organization,
    pending,
    error
  };
};