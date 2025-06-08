<template>
  <div class="app-layout app-bg-black">
    <div class="nav-bar-container">
      <NavBar />
    </div>
    <NavigationDrawer />
    <div :class="['main-content', { 'drawer-open': selectedEvent }]">
      <EventTimeline
        :events="events"
        :drawer-open="!!selectedEvent"
        @event-click="openDrawer"
      />
      <EventCalendar />
      <EventDetailsDrawer
      :event="selectedEvent"
      @close="selectedEvent = null"
      />
    </div>
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import EventTimeline from './Components/events/EventTimeline.vue'
import EventDetailsDrawer from './Components/events/EventDetailsDrawer.vue'
import NavigationDrawer from './Components/NavigationDrawer.vue'
import EventCalendar from './Components/events/EventCalendar.vue'
import NavBar from './Components/NavBar.vue'
import FooterSection from './Components/FooterSection.vue'

const events = ref([])
const selectedEvent = ref(null)

function openDrawer(event) {
  selectedEvent.value = event

  console.log("Updated Selected Event:", selectedEvent.value);
  console.log("Drawer Open:", drawerOpen.value);
}


onMounted(async () => {
  const response = await axios.get('/api/events')
  console.log(response.data.data)
  events.value = response.data.data
})
</script>

<style scoped>
.app-layout { display: flex; background: #000; min-height: 100vh; }
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
  margin-left: 220px;
  position: relative;
  margin-top: 56px;
  padding-bottom: 50px; /* Add padding for fixed footer */
  z-index: 20;
}
.main-content.drawer-open {
  max-width: calc(100vw - 420px);
  margin-right: 0;
  margin-left: 220px;
}
</style>
