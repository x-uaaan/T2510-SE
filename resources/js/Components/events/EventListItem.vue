<template>
  <div class="event-card" @click="$emit('click')">
    <img class="event-avatar" :src="event.avatar || '/images/default-organiser.png'" alt="organiser avatar" />
    <div class="event-content">
      <div class="event-organiser">
        {{ typeof event.organiser === 'object' ? event.organiser.name : event.organiser }}
      </div>
      <div class="event-title">{{ event.eventName }}</div>
      <div class="event-icons-row">
        <span class="event-icon-label">
          <span class="icon-svg" v-html="calendarSvg"></span>
          <span>{{ formatTime(event.eventTime) }}</span>
        </span>
        <span class="event-icon-label">
          <span class="icon-svg" v-html="peopleSvg"></span>
          <span>{{ event.capacity ? event.capacity : 'No Limit' }}</span>
        </span>
        <span class="event-icon-label">
          <span class="icon-svg" v-html="locationSvg"></span>
          <span>{{ event.eventVenue }}</span>
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['event'])
const calendarSvg = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#ffffff"><defs><style>.cls-637b7068f95e86b59c579e08-1{fill:none;stroke:currentColor;stroke-miterlimit:10;}</style></defs><circle class="cls-637b7068f95e86b59c579e08-1" cx="12" cy="12" r="10.5"></circle><circle class="cls-637b7068f95e86b59c579e08-1" cx="12" cy="12" r="10.5"></circle><circle class="cls-637b7068f95e86b59c579e08-1" cx="12" cy="12" r="0.95"></circle><line class="cls-637b7068f95e86b59c579e08-1" x1="12" y1="4.36" x2="12" y2="11.05"></line><line class="cls-637b7068f95e86b59c579e08-1" x1="16.77" y1="16.77" x2="12.95" y2="12.95"></line></svg>`
const locationSvg = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#ffffff"><defs><style>.cls-6374f8d9b67f094e4896c649-1{fill:none;stroke:currentColor;stroke-miterlimit:10;}</style></defs><path class="cls-6374f8d9b67f094e4896c649-1" d="M19.64,9.14C19.64,15.82,12,22.5,12,22.5S4.36,15.82,4.36,9.14a7.64,7.64,0,0,1,15.28,0Z"></path><circle class="cls-6374f8d9b67f094e4896c649-1" cx="12" cy="9.14" r="2.86"></circle></svg>`
const peopleSvg = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 21V17C2 15.8954 2.89543 15 4 15H14C15.1046 15 16 15.8954 16 17V21M16 3C16.8604 3.2203 17.623 3.7207 18.1676 4.42231C18.7122 5.12392 19.0078 5.98683 19.0078 6.875C19.0078 7.76317 18.7122 8.62608 18.1676 9.32769C17.623 10.0293 16.8604 10.5297 16 10.75M19 15H20C21.1046 15 22 15.8954 22 17V21M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
function formatTime(time) {
  if (!time) return ''
  const [h, m] = time.split(':')
  const dateObj = new Date()
  dateObj.setHours(h, m)
  return dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })
}
</script>

<style scoped>
.event-card {
  background: #18191a;
  color: #fff;
  border-radius: 24px;
  padding: 20px 28px;
  margin: 10px;
  margin-top: 0px;
  min-width: 500px;
  display: flex;
  align-items: center;
  box-shadow: rgba(0, 0, 0, 0.15) 5px 5px 2.6px;
  cursor: pointer;
  transition: box-shadow 0.2s, background 0.2s;
  gap: 24px;
  height: 130px;
}
.event-card:hover {
  background: #23242a;
  box-shadow: 0 4px 16px #0004;
}
.event-avatar {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #23242a;
  background: #fff;
}
.event-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
  justify-content: center;
  height: 100%;
}
.event-organiser {
  font-size: 1em;
  color: #b0b0b0;
  font-weight: 500;
  margin-bottom: 0px;
}
.event-title {
  font-size: 1.1em;
  font-weight: bold;
  margin-bottom: 2px;
  color: #fff;
}
.event-icons-row {
  display: flex;
  align-items: center;
  gap: 18px;
  margin-top: 2px;
}
.event-icon-label {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #fff;
  font-size: 1em;
}
.icon-svg {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
}
</style> 