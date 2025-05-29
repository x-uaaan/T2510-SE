<template>
  <div class="timeline-container">
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

const props = defineProps(['events'])

// Group events by eventDate
const groupedEvents = computed(() => {
  const groups = {}
  if (!props.events) return groups
  props.events.forEach(event => {
    const date = event.eventDate
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
  background: #000;
  border-radius: 16px;
  padding: 32px 20px;
  max-width: 800px;
  margin: 32px auto;
  min-height: 300px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.event-group-row {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 32px;
  width: 100%;
}
.event-date-label {
  color: #fff;
  font-weight: bold;
  font-size: 1.2em;
  margin-bottom: 10px;
  padding-left: 8px;
}
.event-group-box {
  background: #18191a;
  border-radius: 20px;
  padding: 18px 10px 8px 10px;
  width: 90%;
  margin: 10px 20px;
  display: flex;
  flex-direction: column;
  gap: 18px;
  align-items: left;
}
</style> 