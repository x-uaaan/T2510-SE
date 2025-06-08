<template>
  <div class="post-list-bg">
    <transition name="fade-slide-navbar">
      <NavBar v-if="showNavBar" />
    </transition>
    <NavigationDrawer />
    <div class="search-menu-row">
      <SearchBar />
      <button class="menu-btn create-btn" @click="showCreateModal = true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 4V20M4 12H20" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <span>Create</span>
      </button>
      <MenuPopover :forum="forum" @updated="$emit('updated')" />
    </div>
    <div class="post-list-content">
      <div class="post-list-grid">
        <PostListItem
          v-for="post in posts"
          :key="post.postID"
          :post="post"
          @click="goToPost(post.postID)"
        />
      </div>
    </div>
    <CreatePostModal 
      :show="showCreateModal" 
      @close="showCreateModal = false"
      @created="refreshPosts"
    />
    <FooterSection />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import PostListItem from './PostListItem.vue'
import FooterSection from '@/Components/FooterSection.vue'
import SearchBar from '@/Components/SearchBar.vue'
import NavBar from '@/Components/NavBar.vue'
import MenuPopover from '@/Components/MenuPopover.vue'
import CreatePostModal from './CreatePostModal.vue'

const posts = ref([])
const showNavBar = ref(true)
let lastScrollY = 0

function goToPost(id) {
  window.location.href = `/posts/${id}`
}

function handleScroll() {
  const currentY = window.scrollY
  if (currentY > lastScrollY) {
    showNavBar.value = false
  } else if (currentY < lastScrollY) {
    showNavBar.value = true
  }
  lastScrollY = currentY
}

const showCreateModal = ref(false)

async function refreshPosts() {
  try {
    const res = await fetch('/api/posts')
    posts.value = await res.json()
  } catch (e) {
    posts.value = []
  }
}

onMounted(async () => {
  showNavBar.value = true
  lastScrollY = window.scrollY
  window.addEventListener('scroll', handleScroll)
  try {
    const urlParams = new URLSearchParams(window.location.search);
    const forumId = urlParams.get('forum_id');
    const url = forumId ? `/api/posts?forum_id=${forumId}` : '/api/posts';
    const res = await fetch(url);
    posts.value = await res.json();
  } catch (e) {
    posts.value = [];
  }
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.search-bar {
  width: 275px;
  margin-top: 5px;
  padding: 3px 12px;
}
.post-list-bg {
  min-height: 100vh;
  background: #000;
  display: flex;
  flex-direction: column;
}
.post-list-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
  margin-left: 180px;
  margin-bottom: 50px;
  padding-left: 80px;
}
.post-list-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  width: 100%;
}
@media (max-width: 1250px) {
    .post-list-content {
        margin-left: 70px;
        align-items: center;
    }   
    .post-list-grid {
        grid-template-columns: 1fr;
        align-items: center;
        gap: 5px;
        max-width: 500px;
    }
}
.no-posts {
  color: #fff;
  margin-top: 40px;
  font-size: 1.2em;
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
.search-menu-row {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 0.5rem;
  margin: 20px 180px 0 0;
}
.menu-popover-margin {
  margin-left: 0.5rem;
}
.create-btn-margin {
  margin-left: 0.5rem;
}
.create-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  padding-bottom: 0.56rem;
  margin-top: 5.5px;
  background: #23242a;
  border: 1px solid #3d3e46;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background 0.2s;
}
.create-btn:hover {
  background: #2d2e35;
}
.create-btn svg {
  width: 20px;
  height: 20px;
}
span {
  font-size: 1.1rem;
  color: #727171;
}
</style> 