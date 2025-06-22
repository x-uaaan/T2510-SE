<template>
  <div class="datepicker-group">
    <div class="datepicker-input-wrapper">
      <v-date-picker
        v-model="dateValue"
        :attributes="attributes"
        :popover="{ 
          visibility: 'focus', 
          placement: 'bottom',
          offset: [0, 4]
        }"
        :first-day-of-week="1"
        is-dark
        :input-props="{
          placeholder,
          class: 'datepicker-input',
          readonly: false,
        }"
        :masks="{ input: 'DD/MM/YYYY' }"
        class="custom-calendar"
        :min-date="today"
        :max-date="null"
        :select-mode="'date'"
        :show-months="1"
        :show-year-picker="false"
        :show-month-picker="false"
        :show-day-picker="true"
      >
        <template #default="{ inputValue, togglePopover }">
          <div
            class="datepicker-input-inner"
            :class="{ active: isPopoverOpen }"
            @click="togglePopover"
          >
            <span class="datepicker-placeholder" v-if="!inputValue">{{ placeholder }}</span>
            <span v-else>{{ inputValue }}</span>
            <span class="datepicker-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"><path fill="currentColor" d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1.25A2.75 2.75 0 0 1 22 6.75v12.5A2.75 2.75 0 0 1 19.25 22H4.75A2.75 2.75 0 0 1 2 19.25V6.75A2.75 2.75 0 0 1 4.75 4.5H6V3a1 1 0 0 1 1-1Zm10 5H7a.75.75 0 0 0-.75.75v.75h11.5v-.75A.75.75 0 0 0 17 7ZM4.75 6A.75.75 0 0 0 4 6.75v12.5c0 .414.336.75.75.75h14.5a.75.75 0 0 0 .75-.75V6.75A.75.75 0 0 0 19.25 6H18v1a1 1 0 1 1-2 0V6H8v1a1 1 0 1 1-2 0V6H4.75Z"/></svg>
            </span>
          </div>
        </template>
      </v-date-picker>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { DatePicker as VDatePicker } from 'v-calendar'
import 'v-calendar/style.css'

const props = defineProps({
  modelValue: {
    type: [Date, String],
    default: null
  },
  placeholder: {
    type: String,
    default: 'dd / mm / yyyy'
  }
})
const emit = defineEmits(['update:modelValue'])
const dateValue = ref(props.modelValue ?? null)

watch(() => props.modelValue, (val) => {
  dateValue.value = val ?? null
})
watch(dateValue, (val) => {
  console.log('DatePicker value:', val)
  emit('update:modelValue', val)
})

const today = new Date()
const attributes = ref([
  {
    key: 'today',
    highlight: {
      fillMode: 'solid',
      color: '#3b82f6',
    },
    dates: today,
  },
])
</script>

<style scoped>
.datepicker-group {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  width: 50%;
}
.datepicker-input-wrapper {
  position: relative;
  width: 115%;
}
.datepicker-input-inner,
.timepicker-input {
  border: 1px solid #353535;
  border-radius: 15px !important;
  background: #18191A !important;
  color: #fff !important;
  font-size: 1.1rem;
  padding: 0.7rem 1rem;
  min-height: 48px;
  min-width: 180px;
  width: 100%;
  box-sizing: border-box;
  transition: border-color 0.2s;
  display: flex;
  align-items: center;
}
.datepicker-input-inner:hover{
  border: 1px solid #3b82f6 !important;
  border-radius: 15px !important;
  box-shadow: 0 0 0 1px #3b82f688 !important;
  outline: none !important;
}
.datepicker-placeholder {
  color: #bdbdbd;
  font-size: 1.1rem;
}
.datepicker-icon {
  margin-left: auto;
  color: #bdbdbd;
  display: flex;
  align-items: center;
}
.datepicker-input {
  display: none;
}

/* Dark Calendar Popover - Same Width as Input */
:deep(.vc-popover-content-wrapper) {
  background: #23242a !important;
  color: #fff !important;
  border-radius: 15px !important;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6), 0 6px 12px rgba(0, 0, 0, 0.4) !important;
  border: none !important;
  z-index: 99999 !important;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif !important;
  margin-top: 0 !important;
  width: 100% !important;
  min-width: 180px !important;
}

:deep(.vc-popover-content) {
  padding: 12px !important;
  margin: 0 !important;
  background: #23242a !important;
  border: none !important;
  width: 100% !important;
}

:deep(.vc-container) {
  background: #23242a !important;
  border: none !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;
}

:deep(.vc-header) {
  padding: 8px 12px !important;
  margin: 0 0 8px 0 !important;
  border: none !important;
}

:deep(.vc-title) {
  color: #fff !important;
  font-weight: 600 !important;
  font-size: 1rem !important;
  margin: 0 !important;
}

:deep(.vc-weekdays) {
  padding: 0 4px !important;
  margin: 0 0 4px 0 !important;
  background: #23242a !important;
  border: none !important;
}

:deep(.vc-weekday) {
  color: #bdbdbd !important;
  font-weight: 500 !important;
  font-size: 0.8rem !important;
  padding: 6px 2px !important;
  text-align: center !important;
  background: #23242a !important;
  border: none !important;
}

:deep(.vc-weeks) {
  padding: 0 4px !important;
  margin: 0 !important;
  background: #23242a !important;
  border: none !important;
}

:deep(.vc-week) {
  margin: 2px 0 !important;
  border: none !important;
}

:deep(.vc-day) {
  margin: 1px !important;
  padding: 0 !important;
  border: none !important;
}

:deep(.vc-day-content) {
  border-radius: 15px !important;
  transition: all 0.15s ease !important;
  color: #fff !important;
  font-weight: 500 !important;
  width: 32px !important;
  height: 32px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 0.9rem !important;
  margin: 0 !important;
  background: transparent !important;
  border: none !important;
}

:deep(.vc-day-content:hover) {
  background: #3b82f6 !important;
  color: #fff !important;
  transform: scale(1.05) !important;
  border-radius: 15px !important;
}

:deep(.vc-day-content.is-disabled) {
  color: #555 !important;
  opacity: 0.5 !important;
}

:deep(.vc-day-content.is-not-in-month) {
  color: #666 !important;
  opacity: 0.6 !important;
}

:deep(.vc-highlight) {
  background: #3b82f6 !important;
  color: #fff !important;
  border-radius: 15px !important;
}

:deep(.vc-nav-item) {
  color: #fff !important;
  border-radius: 15px !important;
  transition: all 0.15s ease !important;
  font-size: 0.9rem !important;
  background: transparent !important;
  border: none !important;
}

:deep(.vc-nav-item:hover) {
  background: #3b82f6 !important;
  color: #fff !important;
  border-radius: 15px !important;
}

:deep(.vc-arrows-container) {
  padding: 0 4px !important;
}

:deep(.vc-arrow) {
  color: #fff !important;
  border-radius: 15px !important;
  transition: all 0.15s ease !important;
  width: 28px !important;
  height: 28px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  background: transparent !important;
  border: none !important;
}

:deep(.vc-arrow:hover) {
  background: #3b82f6 !important;
  color: #fff !important;
}

/* Remove all borders and lines */
:deep(.vc-popover) {
  z-index: 99999 !important;
  position: fixed !important;
  margin: 0 !important;
  border: none !important;
}

:deep(.vc-popover-caret) {
  display: none !important;
}

:deep(.vc-pane) {
  margin: 0 !important;
  padding: 0 !important;
  background: #23242a !important;
  border: none !important;
}

/* Remove any separator lines */
:deep(.vc-day-box-center-center) {
  border: none !important;
}

:deep(.vc-day-layer) {
  border: none !important;
}

/* Ensure popover matches input width */
:deep(.vc-popover-content-wrapper) {
  max-width: none !important;
}
</style> 