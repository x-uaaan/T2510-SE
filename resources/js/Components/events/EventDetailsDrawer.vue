<template>
  <transition name="slide">
    <div v-if="event" class="drawer-backdrop" @click.self="close">
      <div class="drawer">
        <div class="drawer-header">
          <button class="close-btn" @click="close" title="Close">
            <svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20">
              <path d="m13 17 5-5-5-5M6 17l5-5-5-5" />
            </svg>
          </button>
          <div class="drawer-title">{{ event.title }}</div>
        </div>
        <div class="drawer-body">
          <div class="event-organiser">
            {{ typeof event.organiser === 'object' ? event.organiser.name : event.organiser }}
          </div>
          <div class="event-meta">
            <span>{{ formatDate(event.date) }}</span>
            <span>{{ event.time }}</span>
            <span>{{ event.location }}</span>
            <span>{{ event.capacity ? event.capacity : 'No Limit' }}</span>
          </div>
          <div class="event-description">
            {{ event.eventDesc || event.description }}
          </div>
        </div>
        <div class="drawer-footer">
          <a :href="`mailto:support@campuspulse.com`" class="drawer-link">Contact the host</a>
          <a :href="`mailto:support@campuspulse.com`" class="drawer-link">Report event</a>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps(['event'])
const emit = defineEmits(['close'])
function close() { emit('close') }
function formatDate(date) {
  const d = new Date(date)
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}
</script>

<style scoped>
.drawer-backdrop {
  position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1000; display: flex; justify-content: flex-end;
}
.drawer {
  background: #181818;
  color: #fff;
  width: 400px;
  height: 100vh;
  display: flex;
  flex-direction: column;
  box-shadow: -2px 0 16px #000a;
  animation: slideIn 0.3s;
}
@keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
.drawer-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 24px; border-bottom: 1px solid #222;
  background: rgba(24,24,24,0.95);
}
.close-btn {
  background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.5em;
}
.drawer-title {
  font-size: 1.2em; font-weight: bold; flex: 1; text-align: left; margin-left: 16px;
}
.drawer-body {
  padding: 24px;
  flex: 1;
  overflow-y: auto;
}
.event-organiser {
  font-size: 1em;
  color: #7ecfff;
  font-weight: 500;
  margin-bottom: 8px;
}
.event-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  font-size: 0.98em;
  color: #b0b0b0;
  margin-bottom: 16px;
}
.event-description { margin-top: 16px; color: #ccc; }
.drawer-footer {
  padding: 16px 24px; border-top: 1px solid #222; background: #181818;
  display: flex; flex-direction: column; gap: 8px;
}
.drawer-link { color: #aaa; font-size: 0.95em; text-decoration: underline; }
</style> 