<template>
  <div class="app-layout">
    <NavigationDrawer />
    <div :class="['main-content', { 'drawer-open': selectedEvent }]">
      <EventTimeline
        :events="events"
        :drawer-open="!!selectedEvent"
        @event-click="openDrawer"
      />
      <EventDetailsDrawer
        :event="selectedEvent"
        @close="selectedEvent = null"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import EventTimeline from './Components/events/EventTimeline.vue'
import EventDetailsDrawer from './Components/events/EventDetailsDrawer.vue'
import NavigationDrawer from './Components/events/NavigationDrawer.vue'

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
.app-layout { display: flex; }
.main-content { flex: 1; margin-left: 220px; position: relative; }
.main-content.drawer-open { max-width: calc(100vw - 420px); margin-right: 0; margin-left: 220px; }
</style>
