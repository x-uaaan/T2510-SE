<template>
  <div class="event-create-container flex flex-col md:flex-row gap-10 items-start justify-center py-12">
    <!-- Event Image Preview & Upload -->
    <div class="flex flex-col md:w-1/3 w-full">
      <div class="relative w-80 h-80 rounded-3xl overflow-hidden bg-gradient-to-tr from-purple-400 to-pink-400 flex items-center justify-center mb-6 shadow-2xl border-2 border-[#232323]">
        <img :src="imagePreview || 'https://placehold.co/300x300?text=Event+Image'" alt="Event Image" class="object-cover w-full h-full"/>
        <label for="image" class="absolute bottom-4 right-4 bg-white/90 rounded-full p-3 cursor-pointer shadow-lg hover:bg-purple-100 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828M7 7h.01" /></svg>
        </label>
        <input type="file" id="image" accept="image/*" class="hidden" @change="onImageChange" />
      </div>
    </div>
    <!-- Event Form -->
    <form @submit.prevent="submit" class="event-form flex-1 flex flex-col gap-3 bg-[#232323] rounded-3xl shadow-2xl p-6 max-w-lg w-full border border-[#292929]">
      <input v-model="form.eventName" type="text" placeholder="Event Name" required class="w-full text-3xl font-extrabold bg-transparent text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 rounded-xl px-4 py-3 mb-2" />
      <div class="flex flex-col gap-4">
        <div>
          <label class="block text-white/70 text-sm mb-1">Start</label>
          <div class="flex" style="display: flex; justify-content: space-between;">
            <DatePicker v-model="form.startDate" class="w-1/2"/>
            <TimePicker v-model="form.startTime" class="w-1/2"/>
          </div>
          <div v-if="startDateError" class="text-yellow-400 text-sm mt-1">{{ startDateError }}</div>
        </div>
        <div>
          <label class="block text-white/70 text-sm mb-1">End</label>
          <div class="flex" style="display: flex; justify-content: space-between;">
            <DatePicker v-model="form.endDate" class="w-1/2"/>
            <TimePicker v-model="form.endTime" class="w-1/2"/>
          </div>
          <div v-if="endDateError" class="text-yellow-400 text-sm mt-1">{{ endDateError }}</div>
          <div v-if="endTimeError" class="text-yellow-400 text-sm mt-1">{{ endTimeError }}</div>
        </div>
      </div>
      <input v-model="form.eventVenue" type="text" placeholder="Add Event Location" required class="w-full px-4 py-3 rounded-xl bg-[#18191A] text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 border border-[#353535]" />
      <textarea v-model="form.eventDesc" placeholder="Add Description" required class="w-full px-4 py-3 rounded-xl bg-[#18191A] text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 border border-[#353535] min-h-[100px] resize-none" rows="3"></textarea>
      <div class="bg-[#18191A] rounded-xl p-4 flex flex-col gap-3 border border-[#353535]">
        <div class="flex items-center gap-3">
          <span class="text-white/80 font-semibold">Capacity</span>
          <select v-model="form.capacity" class="ml-auto w-40 px-4 py-2 rounded-lg bg-[#232323] text-white focus:outline-none focus:ring-2 focus:ring-purple-400 border border-[#353535] appearance-none font-semibold">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="Unlimited">Unlimited</option>
          </select>
        </div>
      </div>
      <button type="submit" :disabled="hasValidationError || submitting" class="mt-2 w-full py-4 rounded-2xl bg-gradient-to-r from-purple-500 to-blue-500 text-white font-extrabold text-xl shadow-lg hover:from-purple-600 hover:to-blue-600 transition disabled:opacity-60 disabled:cursor-not-allowed">Create Event</button>
      <div v-if="errorMsg" class="text-red-400 text-center font-semibold mt-2">{{ errorMsg }}</div>
    </form>
  </div>
  <FooterSection />
</template>

<script setup>
import { ref, computed } from 'vue'
import DatePicker from '@/Components/DatePicker.vue'
import TimePicker from '@/Components/TimePicker.vue'

const props = defineProps(['organiserId', 'organiserName'])

const form = ref({
  eventName: '',
  startDate: null,
  startTime: null,
  endDate: null,
  endTime: null,
  eventVenue: '',
  eventDesc: '',
  capacity: '',
  organiserId: props.organiserId || '',
  organiserName: props.organiserName || '',
  image: null,
})
const imagePreview = ref('')
const submitting = ref(false)
const errorMsg = ref('')

const today = new Date().toISOString().slice(0, 10)

const startDateError = computed(() => {
  if (!form.value.startDate) return ''
  return form.value.startDate < today
    ? 'Start date must be today or later'
    : ''
})

const endDateError = computed(() => {
  if (!form.value.endDate || !form.value.startDate) return ''
  return form.value.endDate < form.value.startDate
    ? 'End date must be after or same as start date'
    : ''
})

function timeToMinutes(t) {
  if (!t) return 0
  const [h, m] = t.split(':')
  return parseInt(h, 10) * 60 + parseInt(m, 10)
}

const endTimeError = computed(() => {
  if (!form.value.endTime) return ''
  if (
    form.value.startDate &&
    form.value.endDate &&
    form.value.startDate === form.value.endDate &&
    form.value.startTime &&
    form.value.endTime
  ) {
    if (form.value.endTime === form.value.startTime) {
      return 'End time cannot be the same as start time if on the same day'
    }
    if (timeToMinutes(form.value.endTime) <= timeToMinutes(form.value.startTime)) {
      return 'End time must be later than start time if on the same day'
    }
  }
  return ''
})

const hasEmptyRequiredField = computed(() =>
  !form.value.eventName ||
  !form.value.startDate ||
  !form.value.startTime ||
  !form.value.endDate ||
  !form.value.endTime ||
  !form.value.eventVenue ||
  !form.value.eventDesc ||
  !form.value.capacity ||
  !form.value.organiserId ||
  !form.value.organiserName
)

const hasValidationError = computed(() =>
  startDateError.value ||
  endDateError.value ||
  endTimeError.value ||
  hasEmptyRequiredField.value
)

function onImageChange(e) {
  const file = e.target.files[0]
  if (file) {
    form.value.image = file
    const reader = new FileReader()
    reader.onload = (ev) => {
      imagePreview.value = ev.target.result
    }
    reader.readAsDataURL(file)
  }
}

async function submit() {
  errorMsg.value = ''
  submitting.value = true
  try {
    const formData = new FormData()
    formData.append('eventName', form.value.eventName)
    if (form.value.image) {
      formData.append('eventImage', form.value.image)
    }
    formData.append('startDate', form.value.startDate)
    formData.append('startTime', form.value.startTime)
    formData.append('endDate', form.value.endDate)
    formData.append('endTime', form.value.endTime)
    formData.append('eventVenue', form.value.eventVenue)
    formData.append('eventDesc', form.value.eventDesc)
    formData.append('capacity', form.value.capacity)
    formData.append('organiserId', form.value.organiserId)
    formData.append('organiserName', form.value.organiserName)
    const response = await fetch('/events', {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData,
    })
    if (!response.ok) {
      const data = await response.json()
      errorMsg.value = data.message || 'Failed to create event.'
      submitting.value = false
      return
    }
    // Redirect or show success
    window.location.href = '/events'
  } catch (err) {
    errorMsg.value = 'An error occurred while creating the event.'
    submitting.value = false
  }
}
</script>

<style scoped>
.event-create-container {
  min-height: 100vh;
  background-color: #000;
}
.event-form {
  box-shadow: 0 8px 32px 0 #0003, 0 1.5px 4px #0002;
}
input,
textarea,
select {
  background: #18191A !important;
  color: #fff !important;
  box-shadow: none !important;
  outline: none !important;
  border: 1px solid #353535 !important;
}
select{
  border-radius: 30px !important;
}

input:focus,
textarea:focus,
select:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 1px #3b82f688 !important;
  border: 0.5px solid #3b82f6 !important;
  border-radius: 15px !important;
  transition: border-color 0.2s;
  background: #18191A !important;
  color: #fff !important;
  outline: none !important;
}

input::placeholder,
textarea::placeholder {
  color: #bbb !important;
}
button{
  width: auto;
  background: #18191a;
  color: #fff;
  box-shadow: 0 0 0 1px #3b82f688 !important;
  border: 1px solid #3b82f6;
  border-radius: 25px;
  padding: 10px 18px;
  font-size: 1em;
  cursor: pointer;
  outline: none;
}
button:hover{
  background: #232323;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
</style> 