<template>
  <div class="profile-page dark-theme">
    <NavBar />
    <NavigationDrawer />
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-info">
          <h2 class="profile-username">{{ user.username }}</h2>
          <div class="profile-tag">{{ userTag }}</div>
          <div class="profile-email">{{ user.email }}</div>
          <div class="profile-faculty">{{ user.faculty }}</div>
          <div v-if="user.resume_path" class="profile-resume">
            <a :href="user.resume_path" target="_blank">Download Resume</a>
          </div>
        </div>
        <button class="edit-btn" @click="goToEdit">EDIT</button>
      </div>
      <div class="profile-tabs">
        <button :class="{active: tab==='forum'}" @click="tab='forum'">Forum</button>
        <button :class="{active: tab==='post'}" @click="tab='post'">Post</button>
        <button :class="{active: tab==='event'}" @click="tab='event'">Event</button>
      </div>
      <div class="profile-content">
        <div v-if="tab==='forum'">
          <ul>
            <li v-for="forum in forums" :key="forum.forumID">
              <a :href="`/forums/${forum.forumID}`">{{ forum.forumTitle }}</a>
            </li>
          </ul>
        </div>
        <div v-if="tab==='post'">
          <ul>
            <li v-for="post in posts" :key="post.postID">
              <a :href="`/posts/${post.postID}`">{{ post.postTitle }}</a>
            </li>
          </ul>
        </div>
        <div v-if="tab==='event'">
          <ul>
            <li v-for="event in events" :key="event.id">
              <a :href="`/events/${event.id}`">{{ event.eventName }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <FooterSection />
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import NavBar from '@/Components/NavBar.vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import FooterSection from '@/Components/FooterSection.vue'

const page = usePage()
const user = ref(page.props.user)
const forums = ref(page.props.forums)
const posts = ref(page.props.posts)
const events = ref(page.props.events)
const tab = ref('forum')
const userTag = computed(() => user.value.is_lecturer ? 'Lecturer' : (user.value.is_alumni ? 'Alumni' : 'User'))
function goToEdit() {
  window.location.href = '/profile/edit'
}
</script>

<style scoped>
.profile-page {
  min-height: 100vh;
  background: #111;
  color: #fff;
  display: flex;
  flex-direction: column;
}
.profile-container {
  max-width: 800px;
  margin: 40px auto 0 auto;
  background: #181818;
  border-radius: 12px;
  padding: 32px 40px 40px 40px;
  box-shadow: 0 2px 16px #0008;
}
.profile-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 24px;
}
.profile-info {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.profile-username {
  font-size: 1.6rem;
  font-weight: 700;
  margin-bottom: 2px;
}
.profile-tag {
  font-size: 1rem;
  color: #4fc3f7;
  font-weight: 600;
  margin-bottom: 2px;
}
.profile-email, .profile-faculty, .profile-resume {
  font-size: 1rem;
  color: #bbb;
}
.edit-btn {
  background: #29aafc;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 8px 32px;
  font-weight: 600;
  cursor: pointer;
  margin-top: 8px;
  transition: background 0.2s;
}
.edit-btn:hover {
  background: #0077c2;
}
.profile-tabs {
  display: flex;
  gap: 32px;
  border-bottom: 1px solid #333;
  margin-bottom: 18px;
}
.profile-tabs button {
  background: none;
  border: none;
  color: #bbb;
  font-size: 1.1rem;
  font-weight: 600;
  padding: 8px 0;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  transition: color 0.2s, border-bottom 0.2s;
}
.profile-tabs button.active {
  color: #29aafc;
  border-bottom: 2px solid #29aafc;
}
.profile-content ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.profile-content li {
  margin-bottom: 12px;
}
.profile-content a {
  color: #fff;
  text-decoration: underline;
  font-size: 1.1rem;
  transition: color 0.2s;
}
.profile-content a:hover {
  color: #29aafc;
}
</style> 