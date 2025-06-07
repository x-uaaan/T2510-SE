<template>
  <div class="menu-popover-wrapper" ref="wrapper">
    <button class="menu-btn" @click="toggleMenu" aria-label="Open menu">
      <!-- Three dot SVG -->
      <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill=#aaa stroke-width="1" class="ai ai-MoreVerticalFill"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 10a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 18a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg>
    </button>
    <transition name="fade">
      <div v-if="open" class="menu-popover" @click.outside="closeMenu">
        <ul>
          <li @click="$emit('edit')">
            <span>Edit</span>
          </li>
          <li @click="$emit('delete')" class="danger">
            <span>Delete</span>
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const open = ref(false);
const wrapper = ref(null);

function toggleMenu() {
  open.value = !open.value;
}
function closeMenu() {
  open.value = false;
}

function handleClickOutside(event) {
  if (wrapper.value && !wrapper.value.contains(event.target)) {
    closeMenu();
  }
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
});
onBeforeUnmount(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});
</script>

<style scoped>
.menu-popover-wrapper {
  position: relative;
  display: inline-block;
}
.menu-btn {
  background: #23242a;
  padding: 0.6rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #3d3e46;
  border-radius: 10px;
  margin-top: 5px;
}
.menu-popover {
  position: absolute;
  right: 0;
  top: 110%;
  min-width: 100px;
  background: #18191c;
  color: #fff;
  border-radius: 10px;
  border: 1px solid #343434;
  box-shadow: 0 4px 24px rgba(0,0,0,0.25);
  z-index: 1000;
  margin-top: 0.25rem;
}
.menu-popover ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
.menu-popover li {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 1.25rem;
  cursor: pointer;
  font-size: 0.95rem;
  transition: background 0.15s;
}
.menu-popover li:not(:last-child) {
  border-bottom: 1px solid #232428;
}
.menu-popover li:hover {
  background: #232428;
}
.menu-popover li:first-child:hover {
    border-radius: 10px 10px 0 0;
}
.menu-popover li:last-child:hover {
    border-radius: 0 0 10px 10px;
}
.menu-popover li.danger {
  color: #ff5a5f;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.15s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style> 