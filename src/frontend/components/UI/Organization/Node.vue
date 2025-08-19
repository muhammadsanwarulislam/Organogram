<template>
  <div class="tree-node">
    <div class="node-content" :class="{'has-children': hasChildren}">
      <div class="node-header">
        <div class="node-icon">
          <Icon :name="iconName" class="h-5 w-5" />
        </div>
        <div class="node-info">
          <div class="node-name">{{ node.name }}</div>
          <div class="node-code">{{ node.code }}</div>
        </div>
        <div class="node-type" :class="node.type">
          {{ node.type }}
        </div>
      </div>
      
      <button 
        v-if="hasChildren" 
        @click="toggleChildren" 
        class="toggle-btn"
      >
        <Icon :name="isExpanded ? 'mdi:chevron-down' : 'mdi:chevron-right'" class="h-5 w-5" />
      </button>
    </div>
    
    <div v-if="hasChildren && isExpanded" class="children">
      <Node 
        v-for="child in node.children" 
        :key="child.id" 
        :node="child" 
        :depth="depth + 1"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  node: {
    type: Object,
    required: true
  },
  depth: {
    type: Number,
    default: 0
  }
});

const isExpanded = ref(props.depth < 2); // Expand first two levels by default

const hasChildren = computed(() => {
  return props.node.children && props.node.children.length > 0;
});

const iconName = computed(() => {
  switch (props.node.type) {
    case 'ministry':
      return 'mdi:office-building';
    case 'division':
      return 'mdi:domain';
    case 'office':
      return 'mdi:office-building-marker';
    default:
      return 'mdi:account-group';
  }
});

const toggleChildren = () => {
  isExpanded.value = !isExpanded.value;
};
</script>

<style scoped>
.tree-node {
  margin-bottom: 8px;
}

.node-content {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  background-color: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  position: relative;
}

.node-content.has-children {
  cursor: pointer;
}

.node-content:hover {
  background-color: #f3f4f6;
}

.node-header {
  display: flex;
  align-items: center;
  flex-grow: 1;
}

.node-icon {
  margin-right: 12px;
  color: #6b7280;
}

.node-info {
  flex-grow: 1;
}

.node-name {
  font-weight: 600;
  font-size: 1rem;
  color: #1f2937;
}

.node-code {
  font-size: 0.875rem;
  color: #6b7280;
}

.node-type {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 500;
  text-transform: uppercase;
}

.node-type.ministry {
  background-color: #dbeafe;
  color: #1e40af;
}

.node-type.division {
  background-color: #dcfce7;
  color: #166534;
}

.node-type.office {
  background-color: #fef3c7;
  color: #92400e;
}

.toggle-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  border-radius: 4px;
  color: #6b7280;
}

.toggle-btn:hover {
  background-color: #e5e7eb;
}

.children {
  margin-left: 24px;
  margin-top: 8px;
  border-left: 1px dashed #d1d5db;
  padding-left: 16px;
}
</style>