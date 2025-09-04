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

  const handleTranslatableFields = (data) => {
    const translatableFields = ['name', 'code', 'description']; 
    const result = { ...data };
    
    translatableFields.forEach(field => {
      if (data[field] && typeof data[field] === 'object') {
        result[field] = data[field];
      } else if (data[field]) {
        result[field] = {
          en: data[field],
          bn: '' 
        };
      }
    });
    
    return result;
  };
  

  const setTranslation = async (resource, id, field, locale, value) => {
    try {
      const current = await getById(resource, id);

      if (!current[field]) {
        current[field] = {};
      }
      
      current[field][locale] = value;
      
      return await update(resource, id, { [field]: current[field] });
    } catch (error) {
      console.error(`Failed to set translation for ${field} in ${locale}:`, error);
      throw error;
    }
  };

  const organizations = {
    getAll: () => getAll('organizations'),
    getById: (id) => getById('organizations', id),
    create: (data) => create('organizations', data),
    update: (id, data) => update('organizations', id, data),
    delete: (id) => remove('organizations', id),
    getHierarchy: (id) => $api(`/organizations/${id}/hierarchy`),
    setTranslation: (id, field, locale, value) => setTranslation('organizations', id, field, locale, value)
  };

  const employees = {
    getAll: () => getAll('employees'),
    getById: (id) => getById('employees', id),
    create: (data) => create('employees', data),
    update: (id, data) => update('employees', id, data),
    delete: (id) => remove('employees', id),
    setTranslation: (id, field, locale, value) => setTranslation('employees', id, field, locale, value)
  };

  const departments = {
    getAll: () => getAll('departments'),
    getById: (id) => getById('departments', id),
    create: (data) => create('departments', data),
    update: (id, data) => update('departments', id, data),
    delete: (id) => remove('departments', id),
    setTranslation: (id, field, locale, value) => setTranslation('departments', id, field, locale, value)
  };

  const positions = {
    getAll: () => getAll('positions'),
    getById: (id) => getById('positions', id),
    create: (data) => create('positions', data),
    update: (id, data) => update('positions', id, data),
    delete: (id) => remove('positions', id),
    setTranslation: (id, field, locale, value) => setTranslation('positions', id, field, locale, value)
  };

  return {
    organizations,
    employees,
    departments,
    positions
  };
};