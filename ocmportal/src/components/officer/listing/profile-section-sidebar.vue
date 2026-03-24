<template>
  <nav class="profile-section-nav flex-shrink-0 w-52 h-full flex flex-col bg-white border-r border-gray-200 shadow-sm">
    <router-link to="/hr/officer" class="profile-section-nav-leave">
      <svg class="profile-section-nav-leave-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 21h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-4"/>
        <polyline points="8 7 3 12 8 17"/>
        <line x1="15" y1="12" x2="3" y2="12"/>
      </svg>
      <span>ចាកចេញ</span>
    </router-link>
    <div class="profile-section-nav-menu flex-1 min-h-0 overflow-y-auto flex flex-col">
      <div
        v-for="(item, index) in items"
        :key="index"
        :class="['profile-section-nav-item', activeIndex === index ? 'profile-section-nav-item-active' : '']"
        @click="$emit('select-section', item.id, index)"
      >
        {{ item.label }}
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'ProfileSectionSidebar',
  props: {
    items: {
      type: Array,
      default: () => []
    },
    activeIndex: {
      type: Number,
      default: 0
    }
  },
  emits: ['select-section']
}
</script>

<style scoped>
.profile-section-nav {
  min-height: 0;
  display: flex;
  flex-direction: column;
}

.profile-section-nav-leave {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-height: 56px;
  padding: 14px 18px;
  margin: 10px 10px 12px;
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  background-color: #F0F2F5;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
  transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
  text-decoration: none;
}

.profile-section-nav-leave:hover {
  background-color: #e5e7eb;
  border-color: #d1d5db;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
}

.profile-section-nav-leave-icon {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.profile-section-nav-menu {
  display: flex;
  flex-direction: column;
}

.profile-section-nav-item {
  flex: 0 0 auto;
  min-height: 52px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 12px 18px;
  font-size: 14px;
  text-align: left;
  cursor: pointer;
  border-bottom: 1px solid #e5e7eb;
  transition: background-color 0.2s, color 0.2s;
  color: #374151;
  line-height: 1.4;
}

.profile-section-nav-item:last-child {
  border-bottom: none;
}

.profile-section-nav-item:hover {
  background-color: #f3f4f6;
}

.profile-section-nav-item-active {
  font-weight: 600;
  background-color: #e5f0ff;
  color: #0f172a;
  border-left: 3px solid #1d4ed8;
}

.profile-section-nav-item-active:hover {
  background-color: #e5f0ff;
  color: #000;
}
</style>
