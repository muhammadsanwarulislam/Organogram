<template>
  <div class="organogram-node">
    <div class="node-content" :class="{ 'bg-teal-50': isExpanded }" @click="toggleExpand">
      <div class="node-header">
        <div class="node-title">
          <h3 class="text-lg font-semibold text-gray-900">{{ node.name }}</h3>
          <span class="node-type">{{ node.type }}</span>
        </div>
        <div class="node-code">{{ node.code }}</div>
        <Icon :name="isExpanded ? 'mdi:chevron-up' : 'mdi:chevron-down'" class="h-6 w-6 text-gray-500 cursor-pointer" />
      </div>
      <div v-if="node.departments && node.departments.length > 0" class="departments">
        <h4 class="text-sm font-medium text-gray-700">Departments</h4>
        <div class="department-list">
          <div v-for="dept in node.departments" :key="dept.id" class="department">
            <div class="department-name">{{ dept.name }}</div>
            <div v-if="dept.positions && dept.positions.length > 0" class="positions">
              <div v-for="pos in dept.positions" :key="pos.id" class="position">
                <div class="position-name">{{ pos.name }}</div>
                <div v-if="pos.employee" class="employee">{{ pos.employee.name }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <transition-group name="node" tag="div" class="children" v-if="isExpanded && node.children && node.children.length > 0">
      <div v-for="child in node.children" :key="child.id" class="child">
        <OrganogramNode :node="child" />
      </div>
    </transition-group>
  </div>
</template>

<script setup>
defineProps({
  node: {
    type: Object,
    required: true,
  },
});

const isExpanded = ref(true);

const toggleExpand = () => {
  isExpanded.value = !isExpanded.value;
};
</script>

<style scoped>
.organogram-node {
  position: relative;
  padding-left: 30px;
  margin-bottom: 20px;
}

.organogram-node::before {
  content: '';
  position: absolute;
  top: 0;
  left: 15px;
  height: 100%;
  width: 2px;
  background-color: #e5e7eb;
}

.node-content {
  position: relative;
  padding: 20px;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  cursor: pointer;
}

.node-content:hover {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.node-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.node-title {
  display: flex;
  align-items: center;
  gap: 12px;
}

.node-title h3 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
}

.node-type {
  padding: 4px 12px;
  background-color: #d1fae5;
  color: #047857;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 500;
}

.node-code {
  padding: 4px 12px;
  background-color: #e5e7eb;
  color: #4b5563;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 500;
}

.departments {
  margin-top: 16px;
}

.departments h4 {
  margin: 0 0 12px 0;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
}

.department-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 12px;
}

.department {
  padding: 12px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  transition: transform 0.2s ease;
}

.department:hover {
  transform: translateY(-2px);
}

.department-name {
  font-weight: 500;
  color: #1f2937;
  margin-bottom: 8px;
}

.positions {
  margin-top: 10px;
}

.position {
  margin-bottom: 6px;
  padding: 8px;
  background-color: #f3f4f6;
  border-radius: 6px;
}

.position-name {
  font-size: 0.875rem;
  font-weight: 500;
  color: #4b5563;
}

.employee{ 
  font-size: 0.75rem;
  color: #6b7280;
}

.children {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.child {
  position: relative;
}

.child::before {
  content: '';
  position: absolute;
  top: -20px;
  left: 15px;
  width: 2px;
  height: 20px;
  background-color: #e5e7eb;
}

/* Transition animations */
.node-enter-active,
.node-leave-active {
  transition: all 0.3s ease;
}
.node-enter-from,
.node-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>