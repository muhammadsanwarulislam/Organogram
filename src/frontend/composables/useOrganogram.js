export const useOrganogram = () => {
  const { $api } = useNuxtApp()
  
  const getOrganization = async (id) => {
    return await $api(`/organogram/${id}`) 
  }
  
  const getOrganizationTree = async (id) => {
    return await $api(`/organogram/${id}/tree`)
  }
  
  return {
    getOrganization,
    getOrganizationTree
  }
}