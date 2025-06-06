<template>
  <div class="forum-list-bg">
    <NavBar />
    <NavigationDrawer />
    <SearchBar />
    <div class="forum-list-content">
      <div class="forum-list-grid">
        <ForumListItem
          v-for="forum in forums"
          :key="forum.forumID"
          :forum="forum"
          @click="goToForum(forum.forumID)"
        />
      </div>
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavBar from '@/Components/NavBar.vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import ForumListItem from './ForumListItem.vue'
import FooterSection from '@/Components/FooterSection.vue'
import SearchBar from '@/Components/SearchBar.vue'

const forums = ref([])

function goToForum(id) {
  window.location.href = `/forum/${id}`
}

onMounted(async () => {
  try {
    const res = await fetch('/api/forum')
    forums.value = await res.json()
  } catch (e) {
    forums.value = []
  }
})
</script>

<style scoped>
.search-bar {
  width: 250px;
  margin-right: 160px;
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
</style> 