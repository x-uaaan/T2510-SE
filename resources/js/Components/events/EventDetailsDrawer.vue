<template>
  <transition name="drawer-slide">
    <div v-if="event" class="drawer-backdrop" @click.self="close">
      <div class="drawer">
        <div class="drawer-scroll">
          <!-- Close Button Top Left -->
          <div class="drawer-topbar">
            <button class="close-btn" @click="close" title="Close">
              <svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20">
                <path d="m13 17 5-5-5-5M6 17l5-5-5-5" />
              </svg>
            </button>
          </div>
          <!-- Event Image or Placeholder -->
          <div class="event-image-box">
            <img :src="event.image ? `/storage/${event.image}` : '/image/CampusPulseLogo.png'" alt="Event image" class="event-image" />
          </div>
          <!-- Event Title -->
          <div class="event-title">{{ event.eventName }}</div>
          <!-- Organiser Name as subtitle below event name -->
          <div class="event-organiser-subtitle">{{ event.organiserName }}</div>
          <!-- Meta Info Row: Calendar and Dates/Times -->
          <div class="event-meta-row-horizontal-fixed">
            <div class="event-meta-block">
              <span class="icon-svg calendar-center" v-html="calendarSvg"></span>
              <div class="event-date-time-block">
                <template v-if="isSameDay(event.startDate, event.endDate)">
                  <div class="event-date-row">
                    <span class="event-date-label">{{ formatDate(event.startDate) }}</span>
                    <span class="event-meta-time">{{ formatTime(event.startTime) }} - {{ formatTime(event.endTime) }}</span>
                  </div>
                </template>
                <template v-else>
                  <div class="event-date-row">
                    <span class="event-date-label">{{ formatDate(event.startDate) }}</span>
                    <span class="event-meta-time">{{ formatTime(event.startTime) }}</span>
                  </div>
                  <div class="event-date-row">
                    <span class="event-date-label">{{ formatDate(event.endDate) }}</span>
                    <span class="event-meta-time">{{ formatTime(event.endTime) }}</span>
                  </div>
                </template>
              </div>
            </div>
          </div>
          <!-- Location Row -->
          <div class="event-meta-row-horizontal-fixed">
            <div class="event-meta-block location-block">
              <span class="icon-svg location-align" v-html="locationSvg"></span>
              <span class="event-location-label">{{ event.eventVenue }}</span>
              <div v-if="event.isVirtual" class="event-meta-virtual">
                <span class="icon-svg" v-html="virtualSvg"></span>
                <span>Virtual</span>
              </div>
            </div>
          </div>
          <!-- About Event -->
          <div class="event-section-title">About Event</div>
          <div class="event-description">
            {{ event.eventDesc || 'No description provided.' }}
          </div>
        </div>
        <!-- Register Button -->
        <div class="register-btn-row relative">
          <div class="flex gap-4 items-center">
            <Button @click="handleRsvpClick">One-Click RSVP</Button>
          </div>
        </div>
        <!-- Footer always at bottom -->
        <div class="drawer-footer">
          <a :href="`mailto:support@campuspulse.com`" class="drawer-link">Contact host</a>
          <a :href="`mailto:support@campuspulse.com`" class="drawer-link">Report event</a>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const props = defineProps(['event'])
const emit = defineEmits(['close'])

const showPopover = ref(false)

const handleRsvpClick = () => {
  showPopover.value = true
  setTimeout(() => {
    showPopover.value = false
  }, 2000)
}

function close() { emit('close') }
function formatDate(date) {
  if (!date) return ''
  const d = new Date(date)
  return d.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' })
}
function formatTime(time) {
  if (!time) return ''
  const [h, m] = time.split(':')
  const dateObj = new Date()
  dateObj.setHours(h, m)
  return dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })
}
function isSameDay(start, end) {
  if (!start || !end) return false
  const s = new Date(start)
  const e = new Date(end)
  return s.getFullYear() === e.getFullYear() && s.getMonth() === e.getMonth() && s.getDate() === e.getDate()
}
// SVGs
const calendarSvg = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#ffffff"><defs><style>.cls-6374f8d9b67f094e4896c61a-1{fill:none;stroke:currentColor;stroke-miterlimit:10;}</style></defs><rect class="cls-6374f8d9b67f094e4896c61a-1" x="1.48" y="3.37" width="21.04" height="4.78"></rect><rect class="cls-6374f8d9b67f094e4896c61a-1" x="1.48" y="8.15" width="21.04" height="14.35"></rect><line class="cls-6374f8d9b67f094e4896c61a-1" x1="5.3" y1="12.93" x2="7.22" y2="12.93"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="9.13" y1="12.93" x2="11.04" y2="12.93"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="12.96" y1="12.93" x2="14.87" y2="12.93"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="16.78" y1="12.93" x2="18.7" y2="12.93"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="16.78" y1="17.72" x2="18.7" y2="17.72"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="5.3" y1="17.72" x2="7.22" y2="17.72"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="9.13" y1="17.72" x2="11.04" y2="17.72"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="12.96" y1="17.72" x2="14.87" y2="17.72"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="6.26" y1="0.5" x2="6.26" y2="5.28"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="12" y1="0.5" x2="12" y2="5.28"></line><line class="cls-6374f8d9b67f094e4896c61a-1" x1="17.74" y1="0.5" x2="17.74" y2="5.28"></line></svg>`
const locationSvg = `<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#ffffff"><defs><style>.cls-6374f8d9b67f094e4896c649-1{fill:none;stroke:currentColor;stroke-miterlimit:10;}</style></defs><path class="cls-6374f8d9b67f094e4896c649-1" d="M19.64,9.14C19.64,15.82,12,22.5,12,22.5S4.36,15.82,4.36,9.14a7.64,7.64,0,0,1,15.28,0Z"></path><circle class="cls-6374f8d9b67f094e4896c649-1" cx="12" cy="9.14" r="2.86"></circle></svg>`
const peopleSvg = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 21V17C2 15.8954 2.89543 15 4 15H14C15.1046 15 16 15.8954 16 17V21M16 3C16.8604 3.2203 17.623 3.7207 18.1676 4.42231C18.7122 5.12392 19.0078 5.98683 19.0078 6.875C19.0078 7.76317 18.7122 8.62608 18.1676 9.32769C17.623 10.0293 16.8604 10.5297 16 10.75M19 15H20C21.1046 15 22 15.8954 22 17V21M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
const virtualSvg = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.1176 12L22 7.33333V16.6667L16.1176 12ZM16.1176 12V7.33333C16.1176 6.04467 15.0642 5 13.7647 5H4.35294C3.05345 5 2 6.04467 2 7.33333V16.6667C2 17.9553 3.05345 19 4.35294 19H13.7647C15.0642 19 16.1176 17.9553 16.1176 16.6667V12Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>`
const clockSvg = `<svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><circle cx='12' cy='12' r='10' stroke='white' stroke-width='2'/><path d='M12 6V12L16 14' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>`

onMounted(() => {
  const scrollEl = document.querySelector('.drawer-scroll')
  if (scrollEl) {
    scrollEl.addEventListener('scroll', () => {
      // Logic for showFooter was here, can be removed if not needed elsewhere
    })
  }
})
</script>

<style scoped>
.drawer-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100vw;
  height: 100vh;
  background: linear-gradient(to right, rgba(0,0,0,0), rgba(0,0,0,1));
  z-index: 2000;
  display: flex;
  justify-content: flex-end;
}
.drawer {
  background: #181818;
  color: #fff;
  width: 430px;
  height: 100vh;
  display: flex;
  flex-direction: column;
  box-shadow: -2px 0 16px #000a;
  animation: slideIn 0.3s;
  padding-left: 10px;
  padding-right: 10px;
  z-index: 2010;
}
.drawer-scroll {
  flex: 1 1 auto;
  overflow-y: auto;
  padding: 0;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 10+ */
}
.drawer-scroll::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}
.drawer-topbar {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 12px 12px 0 12px;
}
.close-btn {
  background: none;
  border: none;
  color: #aaa;
  cursor: pointer;
  font-size: 1.5em;
}
.event-image-box {
  width: 375px;
  height: 220px;
  background: #222;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 18px;
  overflow: hidden;
  margin: 18px;
}
.event-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.event-title {
  font-size: 1.5em;
  font-weight: bold;
  text-align: left;
  padding: 0 24px;
  margin-bottom: 2px;
}
.event-organiser-subtitle {
  color: #3b82f6;
  font-weight: 500;
  font-size: 0.9em;
  text-align: left;
  padding: 0 24px;
  margin-bottom: 10px;
}
.event-meta-row-horizontal-fixed {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 0;
  padding: 0 24px;
  margin-bottom: 16px;
  font-size: 0.95em;
}
.event-meta-block {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 12px;
  min-width: 180px;
}
.location-block {
  justify-content: left;
  text-align: left;
}
.event-date-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 12px;
}
.event-date-time-block {
  display: flex;
  flex-direction: column;
  justify-content: left;
  gap: 5px;
}
.event-meta-time {
  color: #dbd7d7;
  font-size: 0.9em;
  margin-left: 0;
}
.event-location-label {
  display: flex;
  align-items: center;
  white-space: pre-line;
}
.event-meta-virtual {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #e0dbdb;
  font-size: 1em;
}
.event-section-title {
  margin-top: 16px;
  font-weight: bold;
  color: #ede9e9;
  font-size: 1.1em;
  border-top: 1px solid #333;
  padding-top: 16px;
  margin-bottom: 8px;
  padding-left: 24px;
}
.event-description {
  margin-top: 8px;
  color: #ccc;
  padding: 0 24px;
  white-space: pre-line;
  text-align: justify;
  width: 365px;
}
.relative {
  position: relative;
}
.register-btn-row {
  display: flex;
  justify-content: center;
  margin: 20px 0;
}
/*.register-btn-ui */
.register-btn-row button{
  width: 380px;
  height: 50px;
  display: block;
  margin: 0;
  padding: 10px auto;
  border: 1px solid #d2cfcf;
  border-radius: 1.5rem;
  background: transparent;
  color: #ede9e9;
  font-weight: bold;
  font-size: 1.1em;
  transition: color 0.2s, border-color 0.2s, background 0.2s;
}
.register-btn-row button:hover {
  border: 0.5px solid #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  transition: background 0.3s, color 0.3s, border-color 0.3s;
  color: #3b82f6 !important;
}
.rounded-lg {
  border-radius: 1.5rem;
}
.drawer-footer {
  padding: 16px 0px;
  padding-top: 0;
  bottom: 0;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: space-around;
  gap: 20px;
}
.drawer-link {
  color: #aaa;
  font-size: 0.95em;
  text-decoration: none;
  transition: color 0.2s;
}
.drawer-link:hover {
  color: #3b82f6;
}
.event-image-placeholder {
  width: 100%;
  height: 100%;
  background: #23242a;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 18px;
}
.drawer-slide-enter-active,
.drawer-slide-leave-active {
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.drawer-slide-enter-from,
.drawer-slide-leave-to {
  transform: translateX(100%);
  opacity: 0;
}
.drawer-slide-enter-to,
.drawer-slide-leave-from {
  transform: translateX(0);
  opacity: 1;
}
</style> 