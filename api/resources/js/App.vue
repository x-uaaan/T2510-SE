<template>
  <div class="app-layout app-bg-black">
    <NavigationDrawer />
    <div :class="['main-content', { 'drawer-open': drawerOpen }]">
      <EventTimeline
        :events="events"
        :drawer-open="drawerOpen"
        @event-click="openDrawer"
      />
      <EventCalendar />
      <EventDetailsDrawer
        :event="selectedEvent"
        @close="selectedEvent = null"
      />
      <div class="nav-bar-container">
        <NavBar />
      </div>
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import EventTimeline from './Components/events/EventTimeline.vue'
import EventDetailsDrawer from './Components/events/EventDetailsDrawer.vue'
import NavigationDrawer from './Components/NavigationDrawer.vue'
import EventCalendar from './Components/events/EventCalendar.vue'
import NavBar from './Components/NavBar.vue'
import FooterSection from './Components/FooterSection.vue'

const { events } = defineProps(['events'])
const selectedEvent = ref(null)

const drawerOpen = computed(() => !!selectedEvent.value)

function openDrawer(event) {
  selectedEvent.value = event
}

// onMounted(async () => {
//   const response = await axios.get('/api/events')
//   console.log(response.data.data)
//   events.value = response.data.data
// })
</script>

<style scoped>
.app-layout { display: flex;min-height: 100vh; }
.app-bg-black { background: #000; }
.nav-bar-container {
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  z-index: 30;
}
.main-content {
  flex: 1;
  margin-top: 56px;
  margin-left: 250px;
  margin-right: 530px;
  position: relative;
  padding-bottom: 50px; /* Add padding for fixed footer */
  z-index: 20;
}
.main-content.drawer-open {
  max-width: calc(100vw - 420px);
  margin-right: 0;
  margin-left: 250px;
}
@media (max-width: 1200px) {
  .nav-bar-container{
    width: 100%;
  }
  .main-content {
    margin-left: 90px;
    margin-right: 0px;
  }
  .main-content.drawer-open {
    margin-left: 90px;
  }
}
</style>
