<template>
  <div class="post-list-bg">
    <NavigationDrawer />
    <SearchBar />
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
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import PostListItem from './PostListItem.vue'
import FooterSection from '@/Components/FooterSection.vue'
import SearchBar from '@/Components/SearchBar.vue'

const posts = ref([])

function goToPost(id) {
  window.location.href = `/posts/${id}`
}

onMounted(async () => {
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
</script>

<style scoped>
.search-bar {
  width: 275px;
  margin-right: 160px;
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
</style> 