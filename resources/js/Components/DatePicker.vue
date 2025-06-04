<template>
  <div class="datepicker-group">
    <div class="datepicker-input-wrapper">
      <v-date-picker
        v-model="dateValue"
        :attributes="attributes"
        :popover="{ visibility: 'click', placement: 'bottom-start' }"
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
        <template #default="{ inputValue, inputEvents }">
          <div class="datepicker-input-inner" @click="inputEvents.onClick">
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
  modelValue: String,
  placeholder: {
    type: String,
    default: 'dd / mm / yyyy'
  }
})
const emit = defineEmits(['update:modelValue'])
const dateValue = ref(props.modelValue)

watch(() => props.modelValue, (val) => {
  dateValue.value = val
})
watch(dateValue, (val) => {
  emit('update:modelValue', val)
})

const today = new Date()
const attributes = ref([
  {
    key: 'today',
    highlight: {
      fillMode: 'solid',
      color: '#8b5cf6',
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
  width: 100%;
}
.datepicker-input-wrapper {
  position: relative;
  width: 100%;
}
.datepicker-input-inner {
  display: flex;
  align-items: center;
  background: #353535;
  border-radius: 14px;
  padding: 0.7rem 1rem 0.7rem 1rem;
  border: none;
  color: #fff;
  font-size: 1.1rem;
  cursor: pointer;
  min-width: 180px;
  width: 100%;
  box-shadow: 0 2px 8px #0002;
  transition: box-shadow 0.2s;
}
.datepicker-input-inner:focus-within, .datepicker-input-inner:hover {
  box-shadow: 0 0 0 2px #8b5cf6;
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
.custom-calendar .vc-popover-content-wrapper {
  background: #18191A !important;
  color: #fff !important;
  border-radius: 18px !important;
  box-shadow: 0 8px 32px 0 #0003, 0 1.5px 4px #0002;
  border: 1px solid #353535;
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}
.custom-calendar .vc-title, .custom-calendar .vc-weekday {
  color: #fff !important;
}
.custom-calendar .vc-day-content {
  border-radius: 50% !important;
  transition: background 0.2s;
}
.custom-calendar .vc-day-content:hover {
  background: #8b5cf6 !important;
  color: #fff !important;
}
.custom-calendar .vc-highlight {
  background: #8b5cf6 !important;
  color: #fff !important;
}
</style> 