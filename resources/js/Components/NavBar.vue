<template>
  <transition name="fade-slide-navbar">
    <nav v-if="showNavBar" class="navbar-blank">
      <div class="navbar-logo-container">
        <a href="/">
          <img src="/image/CampusPulse.png" class="navbar-logo-img" alt="Campus Pulse Logo" />
        </a>
      </div>
    </nav>
  </transition>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue'
export default {
  name: 'NavBar',
  setup() {
    const showNavBar = ref(true)
    let lastScrollY = window.scrollY
    function handleScroll() {
      const currentY = window.scrollY
      if (currentY < 100) {
        showNavBar.value = true
      } else if (currentY > lastScrollY) {
        showNavBar.value = false
      } else {
        showNavBar.value = true
      }
      lastScrollY = currentY
    }
    onMounted(() => {
      window.addEventListener('scroll', handleScroll)
    })
    onBeforeUnmount(() => {
      window.removeEventListener('scroll', handleScroll)
    })
    return { showNavBar }
  }
}
</script>

<style scoped>
.navbar-blank {
  width: 100%;
  height: 80px;
  background: black;
  position: relative;
  z-index: 10;
  display: block;
  padding: 0;
  margin: 0;
}
.navbar-logo-container {
  width: calc(100% - 220px);
  height: 70px;
  display: flex;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 0;
  margin: 0;
  margin-left: 220px;
}
@media (max-width: 1200px) {
  .navbar-logo-container {
    margin-left: 90px;
  }
}
.navbar-logo-img {
  height: 80px;
  width: 300px;
  object-fit: contain;
  transition: opacity 0.3s, transform 0.3s;
  display: block;
  padding: 0;
  margin: 0;
}
.fade-slide-navbar-enter-active, .fade-slide-navbar-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}
.fade-slide-navbar-enter-from, .fade-slide-navbar-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
.fade-slide-navbar-enter-to, .fade-slide-navbar-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style> 