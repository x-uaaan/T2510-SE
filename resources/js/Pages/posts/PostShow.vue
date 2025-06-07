<template>
  <div class="post-show-bg">
    <NavigationDrawer />
    <SearchBar v-model="search" placeholder="Type to search..." />
    <div class="post-show-content">
      <div class="search-bar-row">
      </div>
      <PostShowCard :post="filteredPost" />
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import { defineProps, ref, computed } from 'vue';
import NavigationDrawer from '@/Components/NavigationDrawer.vue';
import PostShowCard from '@/Components/posts/PostShowCard.vue';
import SearchBar from '@/Components/SearchBar.vue';
import FooterSection from '@/Components/FooterSection.vue';
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
</script>

<style scoped>
.post-show-bg {
  min-height: 100vh;
  background: #000;
  display: flex;
}
.post-show-content {
  margin-left: 120px;
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
  margin-bottom: 35px;
}

.search-bar {
  position: fixed;
  right: 0px;
  width: 275px;
  height: auto;
  margin-right: 160px;
  padding: 3px 12px;
  font-size: 1em;
}

.search-input::placeholder {
  font-size: 0.9em;
  padding: 0px 12px;
}
</style> 