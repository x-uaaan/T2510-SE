<template>
  <div class="search-page-bg">
    <NavBar />
    <NavigationDrawer />
    <div class="search-page-content">
      <div class="top-bar">
        <SearchBar v-model="searchQuery" />
      </div>
      <div class="search-tabs">
        <span class="glider" :style="gliderStyle"></span>
        <button :ref="el => tabButtons.forum = el" :class="{ active: tab === 'forum' }" @click="tab = 'forum'">Forum</button>
        <button :ref="el => tabButtons.post = el" :class="{ active: tab === 'post' }" @click="tab = 'post'">Post</button>
        <button :ref="el => tabButtons.event = el" :class="{ active: tab === 'event' }" @click="tab = 'event'">Event</button>
        <button :ref="el => tabButtons.user = el" :class="{ active: tab === 'user' }" @click="tab = 'user'">User</button>
      </div>
      <div class="search-results">
        <div v-if="tab === 'forum'">
          <ul v-if="forums.length">
            <li v-for="forum in forums" :key="forum.forumID">
              <a :href="`/posts?forum_id=${forum.forumID}`">{{ forum.forumTitle }}</a>
            </li>
          </ul>
          <p v-else class="no-results">No forums found.</p>
        </div>
        <div v-if="tab === 'post'">
          <ul v-if="posts.length">
            <li v-for="post in posts" :key="post.postID">
              <a :href="`/posts/${post.postID}`">{{ post.postTitle }}</a>
            </li>
          </ul>
          <p v-else class="no-results">No posts found.</p>
        </div>
        <div v-if="tab === 'event'">
          <ul v-if="events.length">
            <li v-for="event in events" :key="event.eventID">
              {{ event.eventName }}
            </li>
          </ul>
          <p v-else class="no-results">No events found.</p>
        </div>
        <div v-if="tab === 'user'">
          <ul v-if="users.length">
            <li v-for="user in users" :key="user.userID">
              <a :href="`/profile/${user.userID}`">{{ user.username }}</a>
            </li>
          </ul>
          <p v-else class="no-results">No users found.</p>
        </div>
      </div>
    </div>
    <FooterSection />
  </div>
</template>

<script setup>
import { ref, watch, onMounted, nextTick } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import NavigationDrawer from '@/Components/NavigationDrawer.vue';
import FooterSection from '@/Components/FooterSection.vue';
import SearchBar from '@/Components/SearchBar.vue';

const props = defineProps({
  keyword: String,
  forums: Array,
  posts: Array,
  events: Array,
  users: Array,
});

const searchQuery = ref(props.keyword || '');
const tab = ref('forum');
const tabButtons = ref({
  forum: null,
  post: null,
  event: null,
  user: null,
});
const gliderStyle = ref({});

const updateGlider = () => {
  const activeButton = tabButtons.value[tab.value];
  if (activeButton) {
    gliderStyle.value = {
      left: `${activeButton.offsetLeft}px`,
      width: `${activeButton.offsetWidth}px`,
    };
  }
};

watch(tab, () => {
  nextTick(updateGlider);
});

onMounted(() => {
  setTimeout(updateGlider, 100);
});
</script>

<style scoped>
.search-page-bg {
  min-height: 100vh;
  background: #000;
  color: #fff;
  display: flex;
  flex-direction: column;
}
.search-page-content {
  flex: 1;
  margin-left: 210px;
  margin-right: 210px;
  padding: 2rem;
  padding-top: 0;
}
.search-header h1 {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 2rem;
}
.top-bar {
  display: flex;
  justify-content: flex-end;
}
.search-bar {
  height: 40px;
}
.search-tabs {
  position: relative;
  display: inline-flex;
  background-color: #1f2022;
  border-radius: 10px;
  padding: 4px;
  gap: 6px;
  margin-bottom: 18px;
}
.glider {
  position: absolute;
  height: calc(100% - 8px);
  top: 4px;
  background-color: #3A3B3C;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.search-tabs button {
  position: relative;
  z-index: 1;
  background: transparent;
  border: none;
  color: #a0a0a0;
  font-size: 0.9em;
  font-weight: 600;
  padding: 6px 16px;
  border-radius: 10px;
  cursor: pointer;
  outline: none;
  transition: color 0.2s;
}
.search-tabs button.active {
  color: #fff;
}
.search-results ul {
  list-style: none;
  border: 1px solid #333;
  padding: 0.8rem;
  padding-left: 1rem;
  border-radius: 8px;
}
.search-results li {
  margin-bottom: 0.5rem;
}
.search-results li:last-child {
  margin-bottom: 0;
}
.search-results a {
  color: #fff;
  text-decoration: none;
  font-size: 1rem;
  transition: color 0.2s;
}
.search-results a:hover {
  color: #3b82f6;
}
.search-results p {
  color: #aaa;
}
.no-results {
  border: 1px solid #333;
  padding: 0.8rem 1rem;
  border-radius: 8px;
  color: #aaa;
  text-align: left;
}
</style> 