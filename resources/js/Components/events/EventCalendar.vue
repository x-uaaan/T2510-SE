<template>
  <div class="calendar-fixed" @click="handleCalendarClick">
    <VDatePicker
      ref="calendarRef"
      is-dark
      :min-view="'month'"
      :max-view="'month'"
      :show-caps="false"
      :show-weeknumbers="false"
      :show-header="true"
      :show-nav="true"
      :show-title="true"
      :show-weekdays="true"
      :show-overlay="false"
      :show-edge-dates="true"
      :first-day-of-week="0"
      :attributes="attributes"
      :title-position="'left'"
      :select-attribute="null"
      :drag-attribute="null"
      v-model="displayedDate"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import 'v-calendar/style.css'

// Get today's date and set as default month
const today = new Date()
const defaultMonth = {
  month: today.getMonth() + 1,
  year: today.getFullYear()
}

const displayedDate = ref(defaultMonth)
const calendarRef = ref(null)

const attributes = [
  {
    key: 'today',
    highlight: {
      color: 'blue',
      fillMode: 'solid'
    },
    dates: today
  }
]

function goToDefaultMonth() {
  displayedDate.value = { ...defaultMonth }
}

function handleCalendarClick(event) {
  // Check if the clicked element is the title or inside the title
  if (event.target.closest('.vc-title')) {
    goToDefaultMonth()
  }
}

// Alternative: Try direct title click handler
onMounted(() => {
  setTimeout(() => {
    const titleElement = document.querySelector('.vc-title')
    if (titleElement) {
      titleElement.style.cursor = 'pointer'
      titleElement.addEventListener('click', (e) => {
        e.preventDefault()
        e.stopPropagation()
        goToDefaultMonth()
      })
    }
  }, 200)
})
</script>

<style scoped>
.calendar-fixed {
  position: fixed;
  top: 0px;
  right: 40px;
  z-index: 10;
  border-radius: 16px;
  width: 400px;
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}

:deep(.vc-container) {
  background: #18191a !important;
  color: #fff !important;
  border-radius: 18px !important;
  font-family: inherit;
  box-shadow: rgba(0, 0, 0, 0.15) 6px 6px 5px;
  padding: 10px;
  margin-bottom: 10px;
  width: 300px;
  height: 310px;
}

/* Title styling - clickable to go to today */
:deep(.vc-title) {
  color: #fff !important;
  font-size: 1em;
  background: none !important;
  border-radius: 30px;
  margin: 0 36px;
  text-align: center;
  padding: 0px 15px;
  letter-spacing: 0.02em;
  border: none !important;
  cursor: pointer !important;
  user-select: none; /* Prevent text selection */
}

:deep(.vc-title):hover {
  background: #23242a !important;
}

:deep(.vc-title):active {
  background: #1a1b20 !important;
  transform: scale(0.98);
}

/* Arrow styling */
:deep(.vc-arrows) {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  margin: 0;
  padding: 0 12px;
}

:deep(.vc-arrow) {
  background: none !important;
  border: none !important;
  color: #fff !important;
  font-size: 1.5em !important;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
  outline: none !important;
}

:deep(.vc-arrow:disabled) {
  color: #888 !important;
  background: none !important;
}

:deep(.vc-arrow:hover:not(:disabled)) {
  background: #23242a !important;
}

:deep(.vc-arrow:focus) {
  outline: none !important;
  box-shadow: none !important;
  border: none !important;
}

:deep(.vc-arrow:active) {
  outline: none !important;
  box-shadow: none !important;
  border: none !important;
}

/* Weekdays */
:deep(.vc-weekdays) {
  color: #b0b0b0 !important;
  font-size: 1em;
  background: none !important;
  margin-bottom: 2px;
  letter-spacing: 0.05em;
}

/* Date styling - hoverable but not selectable */
:deep(.vc-day) {
  cursor: default !important;
  pointer-events: auto !important;
}

:deep(.vc-day-content) {
  color: #fff !important;
  font-size: 1.1em;
  border-radius: 50% !important;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  transition: background 0.2s, color 0.2s;
  cursor: default !important;
  pointer-events: none !important;
}

:deep(.vc-day-content.vc-highlight-content) {
  background: #0066ff !important;
  color: #fff !important;
  border-radius: 50% !important;
}

:deep(.vc-day:hover .vc-day-content) {
  background: #23242a !important;
  color: #fff !important;
}

/* Disable selection styling */
:deep(.vc-day.is-selected) {
  background: none !important;
}

:deep(.vc-day.is-selected .vc-day-content) {
  background: none !important;
  color: #fff !important;
}

:deep(.vc-day.is-selected .vc-day-content.vc-highlight-content) {
  background: #0066ff !important;
  color: #fff !important;
}

/* Hide popover completely */
:deep(.vc-popover-content) {
  display: none !important;
  pointer-events: none !important;
  opacity: 0 !important;
  visibility: hidden !important;
}
</style>