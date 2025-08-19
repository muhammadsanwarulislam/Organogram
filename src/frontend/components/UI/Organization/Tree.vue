<template>
  <div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Organogram Structure</h2>
    
    <!-- Loading state -->
    <div v-if="pending" class="flex justify-center items-center h-32">
      <Icon name="mdi:loading" class="animate-spin h-8 w-8 text-teal-500" />
    </div>
    
    <!-- Error state -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
      <div class="flex">
        <Icon name="mdi:alert-circle" class="h-5 w-5 text-red-500 mr-2" />
        <p class="text-red-700">Error loading hierarchy: {{ error.message }}</p>
      </div>
    </div>
    
    <!-- Tree content -->
    <div v-else-if="hierarchy" class="tree-container">
      <div class="tree-actions mb-6 flex justify-between items-center">
        <div class="text-sm text-gray-500">
          {{ totalNodes }} organizational units
        </div>
        <button 
          @click="expandAll" 
          class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md"
        >
          Expand All
        </button>
        <button 
          @click="collapseAll" 
          class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md"
        >
          Collapse All
        </button>
      </div>
      
      <UIOrganizationNode :node="hierarchy" :depth="0" ref="treeRoot" />
    </div>
    
    <!-- Empty state -->
    <div v-else class="text-center py-12 text-gray-500">
      No hierarchy data available
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
  organizationId: {
    type: Number,
    required: true
  }
});

const treeRoot = ref(null);

// Fetch hierarchy data
const { data: hierarchyResponse, pending, error } = await useAsyncData(
  `organization-hierarchy-${props.organizationId}`,
  () => $fetch(`/api/organizations/${props.organizationId}/hierarchy`),
  {
    server: false
  }
);

const hierarchy = computed(() => hierarchyResponse.value?.data);

// Calculate total nodes in hierarchy
const totalNodes = computed(() => {
  if (!hierarchy.value) return 0;
  
  function countNodes(node) {
    let count = 1;
    if (node.children) {
      node.children.forEach(child => {
        count += countNodes(child);
      });
    }
    return count;
  }
  
  return countNodes(hierarchy.value);
});

// Expand all nodes
const expandAll = () => {
  if (treeRoot.value) {
    expandNode(treeRoot.value);
  }
};

// Collapse all nodes
const collapseAll = () => {
  if (treeRoot.value) {
    collapseNode(treeRoot.value);
  }
};

// Helper function to recursively expand nodes
const expandNode = (component) => {
  if (component.isExpanded !== undefined) {
    component.isExpanded = true;
  }
  
  if (component.$children) {
    component.$children.forEach(child => {
      expandNode(child);
    });
  }
};

// Helper function to recursively collapse nodes
const collapseNode = (component) => {
  if (component.isExpanded !== undefined) {
    component.isExpanded = false;
  }
  
  if (component.$children) {
    component.$children.forEach(child => {
      collapseNode(child);
    });
  }
};
</script>

<style scoped>
.tree-container {
  max-width: 100%;
  overflow-x: auto;
}

.tree-actions {
  display: flex;
  gap: 8px;
}
</style>