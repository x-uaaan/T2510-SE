<template>
  <div class="menu-popover-wrapper" ref="wrapper">
    <button class="menu-btn" @click="toggleMenu" aria-label="Open menu">
      <!-- Three dot SVG -->
      <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill=#aaa stroke-width="1" class="ai ai-MoreVerticalFill"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 10a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 18a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/></svg>
    </button>
    <transition name="fade">
      <div v-if="open" class="menu-popover" @click.outside="closeMenu">
        <ul>
          <li @click="handleEdit">
            <span>Edit Post</span>
          </li>
          <li @click="showDeleteConfirm = true; closeMenu();" class="danger">
            <span>Delete</span>
          </li>
        </ul>
      </div>
    </transition>
  </div>
  <EditPostModal 
    v-if="showEditModal"
    :show="showEditModal"
    :post="post"
    @close="showEditModal = false"
    @updated="handleUpdated"
  />
  <div v-if="showDeleteConfirm" class="delete-confirm-overlay">
    <div class="delete-confirm-modal">
      <div class="delete-confirm-title">Delete Post?</div>
      <div class="delete-confirm-message">
        Posts cannot be restored if deleted. 
      </div>
      <div class="delete-confirm-actions">
        <button class="cancel-btn" @click="showDeleteConfirm = false">Cancel</button>
        <button class="delete-btn" @click="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import EditPostModal from '@/Components/posts/EditPostModal.vue';

const props = defineProps({
  post: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['delete', 'updated']);

const open = ref(false);
const wrapper = ref(null);
const showEditModal = ref(false);
const showDeleteConfirm = ref(false);

function toggleMenu() {
  open.value = !open.value;
}

function closeMenu() {
  open.value = false;
}

function handleEdit() {
  showEditModal.value = true;
  closeMenu();
}

function handleUpdated() {
  emit('updated');
  showEditModal.value = false;
}

function confirmDelete() {
  showDeleteConfirm.value = false;
  emit('delete');
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
  min-width: 120px;
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
.delete-confirm-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.75);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.delete-confirm-modal {
  background: #18191c;
  border-radius: 1rem;
  padding: 2rem 1.5rem;
  width: 25%;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  align-items: center;
}
.delete-confirm-title {
  font-size: 1.3rem;
  font-weight: bold;
  color: #fff;
  margin-bottom: 0.5rem;
  text-align: center;
}
.delete-confirm-message {
  color: #ccc;
  font-size: 1rem;
  margin-bottom: 1.5rem;
  text-align: center;
}
.delete-confirm-actions {
  display: flex;
  gap: 1.5rem;
  width: 100%;
  justify-content: center;
}
.cancel-btn, .delete-btn {
  width: 120px;
  padding: 0.5rem 0;
  border-radius: 25px;
  font-size: 1em;
  font-family: 'Times New Roman', Times, serif;
  cursor: pointer;
  border: 1px solid #3d3e46;
  color: #fff;
  box-shadow: 0 2px 8px #0002;
  background: #18191a;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.cancel-btn:hover {
  background: #23242a;
  border: 0.5px solid #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.delete-btn {
  color: #fff;
  border: 1px solid #e6004d6e;
  background: #e6004d1c;
  transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
}
.delete-btn:hover {
  background: #e6004c44;
  border-color: #ff1a5b;
  box-shadow: 0 0 0 3px #ff1a5b55;
}
</style> 