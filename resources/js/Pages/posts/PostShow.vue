<template>
  <div class="post-show-bg">
    <NavBar />
    <NavigationDrawer />
    <div class="post-show-content">
      <PostShowCard :post="filteredPost" />
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import { defineProps, ref, computed, onMounted, onBeforeUnmount } from 'vue';
import NavigationDrawer from '@/Components/NavigationDrawer.vue';
import PostShowCard from '@/Components/posts/PostShowCard.vue';
import FooterSection from '@/Components/FooterSection.vue';
import NavBar from '@/Components/NavBar.vue';

const props = defineProps({
  post: Object
});
const search = ref('');
const filteredPost = computed(() => {
  if (!search.value) return props.post;
  return {
    ...props.post,
    comments: props.post.comments.filter(c => c.toLowerCase().includes(search.value.toLowerCase())),
  };
});

const showNavBar = ref(true)
let lastScrollY = 0
function handleScroll() {
  const currentY = window.scrollY
  if (currentY > lastScrollY) {
    showNavBar.value = false
  } else if (currentY < lastScrollY) {
    showNavBar.value = true
  }
  lastScrollY = currentY
}
onMounted(() => {
  showNavBar.value = true
  lastScrollY = window.scrollY
  window.addEventListener('scroll', handleScroll)
})
onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.post-show-bg {
  min-height: 100vh;
  background: #000;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.post-show-content {
  margin-top: 10px;
  margin-bottom: 75px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.search-bar-row {
  width: 600px;
  display: flex;
  justify-content: flex-end;
  flex-direction: row;
  margin-bottom: 35px;
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