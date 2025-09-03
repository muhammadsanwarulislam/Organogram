export const useApiService = () => {
  const { $api } = useNuxtApp();
  
  const getAll = async (resource) => {
    const response = await $api(`/${resource}`);
    return response.data;
  };

  const getById = async (resource, id) => {
    const response = await $api(`/${resource}/${id}`);
    return response.data;
  };

  const create = async (resource, data) => {
    return await $api(`/${resource}`, {
      method: 'POST',
      body: data
    });
  };

  const update = async (resource, id, data) => {
    return await $api(`/${resource}/${id}`, {
      method: 'PUT',
      body: data
    });
  };

  const remove = async (resource, id) => {
    return await $api(`/${resource}/${id}`, {
      method: 'DELETE'
    });
  };

  const organizations = {
    getAll: () => getAll('organizations'),
    getById: (id) => getById('organizations', id),
    create: (data) => create('organizations', data),
    update: (id, data) => update('organizations', id, data),
    delete: (id) => remove('organizations', id),
    getHierarchy: (id) => $api(`/organizations/${id}/hierarchy`)
  };

  const employees = {
    getAll: () => getAll('employees'),
    getById: (id) => getById('employees', id),
    create: (data) => create('employees', data),
    update: (id, data) => update('employees', id, data),
    delete: (id) => remove('employees', id)
  };

  const departments = {
    getAll: () => getAll('departments'),
    getById: (id) => getById('departments', id),
    create: (data) => create('departments', data),
    update: (id, data) => update('departments', id, data),
    delete: (id) => remove('departments', id)
  };

  const positions = {
    getAll: () => getAll('positions'),
    getById: (id) => getById('positions', id),
    create: (data) => create('positions', data),
    update: (id, data) => update('positions', id, data),
    delete: (id) => remove('positions', id)
  };

  return {
    organizations,
    employees,
    departments,
    positions
  };
};