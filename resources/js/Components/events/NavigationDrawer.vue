<template>
  <div
    :class="['nav-drawer', { open: isOpen || stickyOpen }]"
    @mouseenter="!stickyOpen && (isOpen = true)"
    @mouseleave="!stickyOpen && (isOpen = false)"
  >
    <nav>
      <ul>
        <li
          v-for="item in navItems"
          :key="item.label"
          :class="['nav-item', { hovered: hoveredItem === item.label }]"
          @mouseenter="hoveredItem = item.label"
          @mouseleave="hoveredItem = null"
          @click="navigate(item.route, item)"
        >
          <span class="icon" v-html="item.icon"></span>
          <span v-if="isOpen || stickyOpen" class="label">{{ item.label }}</span>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue'
const isOpen = ref(false)
const stickyOpen = ref(false)
const hoveredItem = ref(null)
function toggleStickyOpen() { stickyOpen.value = !stickyOpen.value; if (!stickyOpen.value) isOpen.value = false; }
const navItems = [
  {
    label: 'Menu',
    route: '#',
    icon: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12H21M3 17H21M3 7H21" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
  },
  {
    label: 'Events',
    route: '/events',
    icon: `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#ffffff"><defs><style>.cls-637b88e7f95e86b59c57a1ef-1{fill:none;stroke:currentColor;stroke-miterlimit:10;}</style></defs><line class="cls-637b88e7f95e86b59c57a1ef-1" x1="0.55" y1="22.5" x2="23.45" y2="22.5"></line><line class="cls-637b88e7f95e86b59c57a1ef-1" x1="9.14" y1="1.5" x2="21.55" y2="22.5"></line><line class="cls-637b88e7f95e86b59c57a1ef-1" x1="14.86" y1="1.5" x2="2.45" y2="22.5"></line><polygon class="cls-637b88e7f95e86b59c57a1ef-1" points="15.82 22.5 8.18 22.5 12 14.86 15.82 22.5"></polygon></svg>`
  },
  {
    label: 'Forums',
    route: '/forums',
    icon: `<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M3 5V20.7929C3 21.2383 3.53857 21.4614 3.85355 21.1464L7.70711 17.2929C7.89464 17.1054 8.149 17 8.41421 17H19C20.1046 17 21 16.1046 21 15V5C21 3.89543 20.1046 3 19 3H5C3.89543 3 3 3.89543 3 5Z\" stroke=\"#ffffff\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></path></svg>`
  },
  {
    label: 'Profile',
    route: '/profile',
    icon: `<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" width=\"24\" height=\"24\" color=\"#ffffff\"><circle fill=\"none\" stroke=\"#ffffff\" stroke-miterlimit=\"10\" cx=\"12\" cy=\"7.25\" r=\"5.73\"></circle><path fill=\"none\" stroke=\"#ffffff\" stroke-miterlimit=\"10\" d=\"M1.5,23.48l.37-2.05A10.3,10.3,0,0,1,12,13h0a10.3,10.3,0,0,1,10.13,8.45l.37,2.05\"></path></svg>`
  },
  {
    label: 'Settings',
    route: '/settings',
    icon: `<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" width=\"24\" height=\"24\" color=\"#ffffff\"><path fill=\"none\" stroke=\"#ffffff\" stroke-miterlimit=\"10\" d=\"M20.59,12a8.12,8.12,0,0,0-.15-1.57l2.09-1.2-2.87-5-2.08,1.2a8.65,8.65,0,0,0-2.72-1.56V1.5H9.14V3.91A8.65,8.65,0,0,0,6.42,5.47L4.34,4.27l-2.87,5,2.09,1.2a8.29,8.29,0,0,0,0,3.14l-2.09,1.2,2.87,5,2.08-1.2a8.65,8.65,0,0,0,2.72,1.56V22.5h5.72V20.09a8.65,8.65,0,0,0,2.72-1.56l2.08,1.2,2.87-5-2.09-1.2A8.12,8.12,0,0,0,20.59,12Z\"></path><circle fill=\"none\" stroke=\"#ffffff\" stroke-miterlimit=\"10\" cx=\"12\" cy=\"12\" r=\"3.82\"></circle></svg>`
  },
  {
    label: 'Log Out',
    route: '/logout',
    icon: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17V18C12 19.6569 10.6569 21 9 21H6C4.34315 21 3 19.6569 3 18V6C3 4.34315 4.34315 3 6 3H9C10.6569 3 12 4.34315 12 6V7M17 8L21 12L17 16M9 12H19" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
  },
]
function navigate(route, item) {
  if (item.label === 'Menu') {
    toggleStickyOpen();
    return;
  }
  // router push logic
}
</script>

<style scoped>
.nav-drawer {
  width: 80px;
  transition: width 0.3s;
  background: #222;
  color: #fff;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 10;
  overflow: hidden;
}
.nav-drawer.open {
  width: 220px;
}
.menu-btn {
  display: flex;
  align-items: center;
  height: 50px;
  padding: 0 16px;
  margin: 8px 8px;
}
nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.nav-item {
  display: flex;
  align-items: center;
  height: 50px;
  padding: 0 16px;
  cursor: pointer;
  transition: background 0.2s, border-radius 0.2s;
  border-radius: 10px;
  margin: 8px 8px;
}
.nav-item.hovered {
  background: #333;
  border-radius: 30px;
}
.icon {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 32px;
  min-height: 32px;
  margin-right: 16px;
}
.label {
  font-size: 1.1em;
  font-weight: 500;
}
</style>
