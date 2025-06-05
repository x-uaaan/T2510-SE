<template>
  <div class="timepicker-group">
    <div class="timepicker-input-wrapper">
      <div class="timepicker-input" @click="togglePicker">
        <span v-if="!displayValue" class="timepicker-placeholder">{{ placeholder }}</span>
        <span v-else class="timepicker-value">{{ displayValue }}</span>
        <div class="timepicker-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="22" height="22" color="#bdbdbd">
            <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="12" cy="12" r="10.5"/>
            <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="12" cy="12" r="0.95"/>
            <polyline fill="none" stroke="currentColor" stroke-miterlimit="10" points="12 4.36 12 12 16.77 16.77"/>
          </svg>
        </div>
      </div>

      <!-- Custom Time Picker Popup -->
      <div v-if="isOpen" class="time-picker-popup" @click.stop>
        <div class="time-picker-content">
          <!-- Hour Selection -->
          <div class="time-column">
            <div class="time-options">
              <div
                v-for="hour in hours"
                :key="hour"
                :class="['time-option', { 'selected': selectedHour === hour }]"
                @click="selectHour(hour)"
              >
                {{ hour.toString().padStart(2, '0') }}
              </div>
            </div>
          </div>

          <!-- Minute Selection -->
          <div class="time-column">
            <div class="time-options">
              <div
                v-for="minute in minutes"
                :key="minute"
                :class="['time-option', { 'selected': selectedMinute === minute }]"
                @click="selectMinute(minute)"
              >
                {{ minute.toString().padStart(2, '0') }}
              </div>
            </div>
          </div>

          <!-- AM/PM Selection -->
          <div class="time-column">
            <div class="time-options">
              <div
                :class="['time-option', { 'selected': selectedPeriod === 'AM' }]"
                @click="selectPeriod('AM')"
              >
                AM
              </div>
              <div
                :class="['time-option', { 'selected': selectedPeriod === 'PM' }]"
                @click="selectPeriod('PM')"
              >
                PM
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Overlay to close picker when clicking outside -->
    <div v-if="isOpen" class="time-picker-overlay" @click="closePicker"></div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: '--:--'
  }
})

const emit = defineEmits(['update:modelValue'])

// Reactive data
const isOpen = ref(false)
const selectedHour = ref(6)
const selectedMinute = ref(0)
const selectedPeriod = ref('AM')

// Available options
const hours = Array.from({ length: 12 }, (_, i) => i + 1)
const minutes = [0, 15, 30, 45] // Only 00, 15, 30, 45

// Computed display value
const displayValue = computed(() => {
  if (!props.modelValue) return ''
  
  const [time, period] = props.modelValue.split(' ')
  if (!time || !period) return props.modelValue
  
  return `${time} ${period}`
})

// Parse initial value
const parseTimeValue = (value) => {
  if (!value) return
  
  const [time, period] = value.split(' ')
  if (!time || !period) return
  
  const [hour, minute] = time.split(':').map(Number)
  if (hour && minute !== undefined && period) {
    selectedHour.value = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour
    selectedMinute.value = minute
    selectedPeriod.value = period
  }
}

// Watch for external changes
watch(() => props.modelValue, (newValue) => {
  parseTimeValue(newValue)
}, { immediate: true })

// Methods
const togglePicker = () => {
  isOpen.value = !isOpen.value
}

const closePicker = () => {
  isOpen.value = false
}

const selectHour = (hour) => {
  selectedHour.value = hour
  updateValue()
}

const selectMinute = (minute) => {
  selectedMinute.value = minute
  updateValue()
}

const selectPeriod = (period) => {
  selectedPeriod.value = period
  updateValue()
}

const updateValue = () => {
  const formattedHour = selectedHour.value.toString().padStart(2, '0')
  const formattedMinute = selectedMinute.value.toString().padStart(2, '0')
  const timeString = `${formattedHour}:${formattedMinute} ${selectedPeriod.value}`
  emit('update:modelValue', timeString)
}

// Close picker when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.timepicker-group')) {
    closePicker()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.timepicker-group {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  width: 50%;
  position: relative;
}

.timepicker-input-wrapper {
  position: relative;
  width: 100%;
}

.timepicker-input {
  display: flex;
  align-items: center;
  background: #18191A;
  border-radius: 14px;
  padding: 0.7rem 1rem;
  border: 1px solid #353535 !important;
  color: #fff;
  font-size: 1.1rem;
  cursor: pointer;
  min-width: 180px;
  width: 100%;
  box-shadow: 0 2px 8px #0002;
  transition: box-shadow 0.2s;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}

.timepicker-input:hover{
  box-shadow: 0 0 0 1px #3b82f6 !important;
}

.timepicker-placeholder {
  color: #bdbdbd;
  font-size: 1.1rem;
}

.timepicker-value {
  color: #fff;
  font-size: 1.1rem;
}

.timepicker-icon {
  margin-left: auto;
  color: #bdbdbd;
  display: flex;
  align-items: center;
}

/* Custom Time Picker Popup */
.time-picker-popup {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  right: 0;
  background: #23242a;
  border-radius: 14px;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6), 0 6px 12px rgba(0, 0, 0, 0.4);
  z-index: 99999;
  overflow: hidden;
  padding: 5px;
  width: 50%;
  justify-content: center;
}

.time-picker-content {
  display: flex;
  width: 100%;
}

.time-column {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.time-header {
  background: #2a2b32;
  color: #bdbdbd;
  text-align: center;
  padding: 8px 4px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.time-options {
  max-height: 150px;
  overflow-y: auto;
  background: #23242a;
}

.time-option {
  padding: 3px 3px;
  margin: 2px;
  text-align: center;
  color: #fff;
  cursor: pointer;
  transition: all 0.15s ease;
  font-size: 0.95rem;
  font-weight: 500;
}

.time-option:hover {
  background: rgba(59, 130, 246, 0.2);
  border-radius: 15px;
  color: #3b82f6;
}

.time-option.selected {
  background: #3b82f6;
  color: #fff;
  font-weight: 600;
  border-radius: 15px;
}

.time-option.selected:hover {
  background: #2563eb;
}

/* Custom scrollbar for time options */
.time-options::-webkit-scrollbar {
  width: 4px;
}

.time-options::-webkit-scrollbar-track {
  background: #2a2b32;
}

.time-options::-webkit-scrollbar-thumb {
  background: #3b82f6;
  border-radius: 2px;
}

.time-options::-webkit-scrollbar-thumb:hover {
  background: #2563eb;
}

/* Overlay */
.time-picker-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 99998;
  background: transparent;
}

/* Remove any borders or outlines */
* {
  border: none !important;
  outline: none !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .time-picker-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    right: auto;
    width: 300px;
    max-width: 90vw;
  }
  
  .time-option {
    padding: 16px 8px;
    font-size: 1rem;
  }
}
</style> 