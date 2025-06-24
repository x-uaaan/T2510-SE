<template>
  <div class="post-list-bg" min-h-screen>
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
      <MenuPopover v-if="canManageForum" :forum="forum" @updated="$emit('updated')" />
    </div>
    <div v-if="forum" class="forum-header">
      <div class="header-main">
        <div class="title-row">
          <h1 class="forum-title">{{ forum.forumTitle }}</h1>
          <span class="category-tag">{{ forum.Categories }}</span>
        </div>
        <div class="desc-row">
          <p class="forum-desc">{{ forum.forumDesc }}</p>
          <a :href="`/profile/${forum.organiserID}`" class="organiser-link">
            {{ forum.organiserName }}
          </a>
        </div>
      </div>
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
      :forum-id="forumId"
      @close="showCreateModal = false"
      @created="refreshPosts"
    />
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import PostListItem from './PostListItem.vue'
import FooterSection from '@/Components/FooterSection.vue'
import SearchBar from '@/Components/SearchBar.vue'
import NavBar from '@/Components/NavBar.vue'
import MenuPopover from '@/Components/MenuPopover.vue'
import CreatePostModal from './CreatePostModal.vue'

const posts = ref([])
const forum = ref(null)
const forumId = ref('')
const showNavBar = ref(true)
let lastScrollY = 0
const currentUser = ref(null);

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

const canManageForum = computed(() => {
  if (!currentUser.value || !forum.value) {
    return false;
  }
  return currentUser.value.userType === 'Admin' || currentUser.value.userID === forum.value.organiserID;
});

onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  forumId.value = urlParams.get('forum_id');
  fetchCurrentUser();
  fetchForumDetails();
  refreshPosts();
  showNavBar.value = true
  lastScrollY = window.scrollY
  window.addEventListener('scroll', handleScroll)
})

async function fetchCurrentUser() {
  try {
    const response = await fetch('/api/user', { credentials: 'include' });
    if (response.ok) {
      currentUser.value = await response.json();
    } else {
      currentUser.value = null;
    }
  } catch (error) {
    console.error('Failed to fetch current user:', error);
    currentUser.value = null;
  }
}

async function fetchForumDetails() {
  if (!forumId.value) return;
  try {
    const response = await fetch(`/api/forum/${forumId.value}`);
    forum.value = await response.json();
  } catch (error) {
    console.error('Failed to fetch forum details:', error);
  }
}

async function refreshPosts() {
  if (!forumId.value) return;
  try {
    const response = await fetch(`/api/posts?forum_id=${forumId.value}`);
    posts.value = await response.json();
  } catch (error) {
    console.error('Failed to refresh posts:', error);
  }
}

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
  margin: 20px auto 50px 210px;
  width: 100%;
  max-width: 1200px;
}
.post-list-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  width: 90%;
  gap: 20px;
}
@media (max-width: 1250px) {
  .forum-header {
    margin-left: 100px;
    margin-right: 100px;
  }
  .post-list-content {
      margin-left: 140px;
      align-items: center;
      max-width: 500px;
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
.forum-header {
  color: #fff;
  padding: 10px 0;
  padding-bottom: 0;
  margin-left: 260px;
  margin-right: 210px;
  max-width: 100%;
}
.header-main {
  width: 100%;
}
.title-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 16px;
}
.forum-title {
  font-size: 1.8em;
  font-weight: bold;
  margin: 0;
}
.desc-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
}
.forum-desc {
  font-size: 1em;
  color: #b0b0b0;
  margin-bottom: 0;
  margin-right: 20px;
}
.forum-meta {
  display: flex;
  align-items: center;
  gap: 16px;
  font-size: 0.95em;
  color: #888;
}
.category-tag {
  background-color: #333;
  color: #eee;
  padding: 2px 12px;
  height: 23px;
  border-radius: 20px;
  font-size: 0.8em;
}
.organiser-link:hover {
  color: #3b82f6 !important;
  text-shadow: 0 0 0 2px #3b82f688 !important;
  transition: color 0.3s;
}
</style> 