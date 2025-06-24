<template>
  <div class="profile-layout">
    <NavBar />
    <NavigationDrawer />
    <main class="content-area">
      <div class="profile-header">
        <div class="profile-info">
          <h2 class="profile-username">{{ user.username }}</h2>
          <a :href="`mailto:${user.email}`" class="profile-email">{{ user.email }}</a>
          <div class="profile-faculty">{{ user.faculty }}</div>
          <div v-if="user.resume_url" class="profile-resume">
            <a :href="user.resume_url" target="_blank" rel="noopener noreferrer">Resume</a>
          </div>
        </div>
        <Link v-if="isMyProfile" :href="route('profile.edit')" class="edit-btn">Edit</Link>
      </div>
      <div class="profile-tabs">
        <span class="glider" :style="gliderStyle"></span>
        <button :ref="el => tabButtons.forum = el" :class="{active: tab==='forum'}" @click="tab='forum'">Forum</button>
        <button :ref="el => tabButtons.post = el" :class="{active: tab==='post'}" @click="tab='post'">Post</button>
        <button :ref="el => tabButtons.event = el" :class="{active: tab==='event'}" @click="tab='event'">Event</button>
      </div>
      <div class="tab-content-container">
        <div v-if="tab==='forum'">
          <ul v-if="user.forums && user.forums.length > 0">
            <li v-for="forum in user.forums" :key="forum.forumID">
              <Link :href="`/posts?forum_id=${forum.forumID}`">{{ forum.forumTitle }}</Link>
            </li>
          </ul>
          <p v-else>No forums created yet.</p>
        </div>
        <div v-if="tab==='post'">
          <ul v-if="user.posts && user.posts.length > 0">
            <li v-for="post in user.posts" :key="post.postID">
              <Link :href="`/posts/${post.postID}`">{{ post.postTitle }}</Link>
            </li>
          </ul>
          <p v-else>No posts created yet.</p>
        </div>
        <div v-if="tab==='event'">
          <ul v-if="user.events && user.events.length > 0">
            <li v-for="event in user.events" :key="event.eventID">
              <button @click="openEventModal(event)" class="event-title-btn">{{ event.eventName }}</button>
            </li>
          </ul>
          <p v-else>No events created yet.</p>
        </div>
      </div>
    </main>
    <EventDetailsModal
      v-if="selectedEvent"
      :show="showEventModal"
      :event="selectedEvent"
      :auth-user="authUser"
      @close="closeEventModal"
    />
  </div>
</template>

<script setup>
import { computed, ref, watch, onMounted, nextTick } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import NavBar from '@/Components/NavBar.vue'
import NavigationDrawer from '@/Components/NavigationDrawer.vue'
import EventDetailsModal from '@/Components/events/EventDetailsModal.vue'
import { route } from 'ziggy-js'

const props = defineProps({
  user: Object,
})

const page = usePage()
const authUser = computed(() => page.props.auth.user)
const isMyProfile = computed(() => authUser.value && authUser.value.userID === props.user.userID)

const tab = ref('forum')
const tabButtons = ref({
  forum: null,
  post: null,
  event: null,
})
const gliderStyle = ref({})
const showEventModal = ref(false)
const selectedEvent = ref(null)

const updateGlider = () => {
  const activeButton = tabButtons.value[tab.value]
  if (activeButton) {
    gliderStyle.value = {
      left: `${activeButton.offsetLeft}px`,
      width: `${activeButton.offsetWidth}px`,
    }
  }
}

watch(tab, () => {
  nextTick(updateGlider);
});

onMounted(() => {
  setTimeout(updateGlider, 100);
});

const openEventModal = (event) => {
  selectedEvent.value = event
  showEventModal.value = true
}

const closeEventModal = () => {
  showEventModal.value = false
  setTimeout(() => {
    selectedEvent.value = null
  }, 300) // Delay to allow modal to transition out
}

// NOTE: If you need to fetch /api/user in this file in the future, always use:
// fetch('/api/user', { credentials: 'include' })
</script>

<style scoped>
.profile-layout {
  min-height: 100vh;
  background: #000;
  color: #fff;
}
.content-area {
  margin-left: 300px;
  margin-right: 300px;
  padding: 20px;
}
.profile-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 16px;
  padding: 0 20px;
}
.profile-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.profile-username {
  font-size: 1.4rem;
  font-weight: 600;
}
.profile-email,
.profile-faculty,
.profile-resume a {
  font-size: 1rem;
  color: #bbb;
  text-decoration: none;
}
.profile-email:hover,
.profile-resume a:hover {
  color: #29aafc;
}
.edit-btn {
  background: #18191a;
  color: #fff;
  border: 1px solid #3d3e46;
  border-radius: 10px;
  padding: 6px 20px;
  cursor: pointer;
  margin-bottom: 8px;
  transition: background 0.2s;
  text-decoration: none;
  font-size: 0.9em;
  display: inline-block;
  text-align: center;
}
.edit-btn:hover {
  background: #23242a;
  border: 1px solid #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.profile-tabs {
  position: relative;
  display: inline-flex;
  background-color: #1f2022;
  border-radius: 10px;
  padding: 4px;
  gap: 6px;
  margin-bottom: 18px;
  margin-left: 20px;
}
.glider {
  position: absolute;
  height: calc(100% - 8px);
  top: 4px;
  background-color: #3A3B3C;
  border-radius: 9999px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.profile-tabs button {
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
}
.profile-tabs button:hover {
  background-color: rgb(45, 46, 49);
}
.profile-tabs button.active {
  background-color: #3A3B3C;
  color: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.tab-content-container {
  border: 1px solid #333;
  border-radius: 8px;
  padding: 10px 20px;
  margin: 0 20px;
}
.tab-content-container ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.tab-content-container li {
  margin-bottom: 12px;
}
.tab-content-container li:last-child {
  margin-bottom: 0;
}
.tab-content-container a {
  color: #fff;
  text-decoration: none;
  font-size: 1rem;
  transition: color 0.2s;
}
.tab-content-container a:hover {
  color: #29aafc;
}
.tab-content-container p {
  color: #888;
}
.event-title-btn {
  background: none;
  border: none;
  color: #fff;
  cursor: pointer;
  padding: 0;
  text-align: left;
  font-size: 1rem;
  transition: color 0.2s;
}
.event-title-btn:hover {
  color: #29aafc;
}
</style>