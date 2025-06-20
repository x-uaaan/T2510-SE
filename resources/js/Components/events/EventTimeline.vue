<template>
  <div :class="['timeline-container', { 'drawer-open': drawerOpen }]">
    <div v-for="(group, date) in groupedEvents" :key="date" class="event-group-row">
      <div class="event-date-label">
        <span>{{ formatDate(date) }}</span>
      </div>
      <div class="event-group-box">
        <EventListItem
          v-for="event in group"
          :key="event.id"
          :event="event"
          @click="$emit('event-click', event)"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import EventListItem from './EventListItem.vue'

const props = defineProps(['events', 'drawerOpen'])

// Group events by eventDate
const groupedEvents = computed(() => {
  const groups = {}
  // Defensive: ensure props.events is an array
  const eventArray = Array.isArray(props.events)
    ? props.events
    : (typeof props.events === 'string'
        ? JSON.parse(props.events)
        : []);
  // Get today's date in YYYY-MM-DD
  const today = new Date()
  const yyyy = today.getFullYear()
  const mm = String(today.getMonth() + 1).padStart(2, '0')
  const dd = String(today.getDate()).padStart(2, '0')
  const todayStr = `${yyyy}-${mm}-${dd}`
  // Filter events: only today or after
  const filtered = eventArray.filter(ev => ev.startDate >= todayStr)
  // Sort by startDate and startTime ascending
  filtered.sort((a, b) => {
    const dateA = a.startDate + (a.startTime ? 'T' + a.startTime : 'T00:00');
    const dateB = b.startDate + (b.startTime ? 'T' + b.startTime : 'T00:00');
    return new Date(dateA) - new Date(dateB);
  });
  filtered.forEach(event => {
    const date = event.startDate
    if (!groups[date]) groups[date] = []
    groups[date].push(event)
  })
  return groups
})

function formatDate(date) {
  const d = new Date(date)
  return d.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' })
}
</script>

<style scoped>
.timeline-container {
  background: none;
  border-radius: 16px;
  padding: 32px 0px 0px;
  min-height: 300px;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: margin-right 0.3s, max-width 0.3s;
  z-index: 20;
  width: 100%;
}
.timeline-container.drawer-open {
  width: 800px;
}
.event-group-row {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 32px;
  width: 100%;
}
.event-group-row:last-child {
  margin-bottom: 0px;
}
.event-date-label {
  color: #fff;
  font-weight: bold;
  font-size: 1.2em;
  margin-bottom: 10px;
  padding-left: 8px;
  text-align: left;
}
.event-group-box {
  background: none;
  border-radius: 20px;
  padding: 5px 5px;
  width: 100%;
  max-width: 700px;
  margin: 10px auto;
  display: flex;
  flex-direction: column;
  gap: 18px;
  align-items: center;
}
</style> 