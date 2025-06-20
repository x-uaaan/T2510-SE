<template>
  <div class="forum-list-bg">
    <NavBar />
    <NavigationDrawer />
    <div class="search-menu-row">
      <SearchBar />
      <button class="menu-btn create-btn" @click="showCreateModal = true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 4V20M4 12H20" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
        <span>Create</span>
      </button>
    </div>
    <div class="forum-list-content">
      <div class="forum-list-grid">
        <ForumListItem
          v-for="forum in forums"
          :key="forum.forumID"
          :forum="forum"
          @click="goToForum(forum.forumID)"
          @updated="refreshForums"
        />
      </div>
    </div>
    <CreateForumModal 
      :show="showCreateModal" 
      @close="showCreateModal = false"
      @created="refreshForums"
      :userId="userId"
      :userName="userName"
    />
    <FooterSection />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import ForumListItem from './ForumListItem.vue'
import SearchBar from '@/Components/SearchBar.vue'
import FooterSection from '@/Components/FooterSection.vue'
import NavBar from '@/Components/NavBar.vue'
import CreateForumModal from './CreateForumModal.vue'
import axios from 'axios'

const forums = ref([])
const showCreateModal = ref(false)
const userId = ref(null)
const userName = ref('')

function goToForum(id) {
  window.location.href = `/posts?forum_id=${id}`
}

async function refreshForums() {
  try {
    const res = await axios.get('/api/forum')
    forums.value = res.data
  } catch (e) {
    forums.value = []
  }
}

onMounted(async () => {
  await refreshForums()
  try {
    const res = await axios.get('/api/user')
    userId.value = res.data.id
    userName.value = res.data.name
  } catch (e) {
    userId.value = null
    userName.value = ''
  }
})
</script>

<style scoped>
.search-bar {
  width: 250px;
  margin-right: 10px;
  margin-top: 5px;
}
.forum-list-bg {
  min-height: 100vh;
  background: #000;
  display: flex;
  flex-direction: column;
}
.forum-list-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
  margin-left: 180px;
  margin-bottom: 50px;
}
.forum-list-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  width: 100%;
  max-width: 1200px;
}
@media (max-width: 1250px) {
    .forum-list-content {
        margin-left: 70px;
        align-items: center;
    }   
    .forum-list-grid {
        grid-template-columns: 1fr;
        align-items: center;
        gap: 5px;
        max-width: 500px;
    }
}
.no-forums {
  color: #fff;
  margin-top: 40px;
  font-size: 1.2em;
}
.search-menu-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0rem;
  margin: 0px 170px 0 0;
}
.create-btn-margin {
  margin-left: 0.5rem;
}
.create-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.68rem 1rem;
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