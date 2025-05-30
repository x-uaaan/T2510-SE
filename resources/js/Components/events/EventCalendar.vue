<template>
  <div class="calendar-fixed">
    <VDatePicker
      is-dark
      readonly
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
      @title-click="resetToToday"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import 'v-calendar/style.css'

// Always highlight today
const today = new Date()
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

// For navigation: store the displayed month/year
const displayedDate = ref(today)
function resetToToday() {
  // Optionally, you can force the calendar to show today's month by using a key or ref
}
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
  box-shadow: 0 4px 24px #000a;
  padding: 10px;
  margin-bottom: 10px;
  width: 300px;
  height: 300px;
}
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
}
:deep(.vc-title):hover {
  background: #23242a !important;
}
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
}
:deep(.vc-arrow:disabled) {
  color: #888 !important;
  background: none !important;
}
:deep(.vc-arrow:hover) {
  background: #23242a !important;
}
:deep(.vc-weekdays) {
  color: #b0b0b0 !important;
  font-size: 1em;
  background: none !important;
  margin-bottom: 2px;
  letter-spacing: 0.05em;
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
}
:deep(.vc-day-content.vc-highlight-content) {
  background: #0066ff !important;
  color: #fff !important;
  border-radius: 50% !important;
}
:deep(.vc-day-content:hover) {
  background: #23242a !important;
  color: #fff !important;
}
:deep(.vc-popover-content) {
  display: none !important;
  pointer-events: none !important;
  opacity: 0 !important;
  visibility: hidden !important;
}
</style>