<template>
  <div class="min-h-screen flex items-center justify-center bg-[#18191A]">
    <form @submit.prevent="submit" class="bg-[#232323] p-6 rounded-2xl shadow-xl w-full max-w-md border border-[#292929] flex flex-col justify-between h-[650px]">
      <div>
        <img src="/image/CampusPulse.png" alt="Campus Pulse Logo" class="mx-auto mb-2 h-12" />
        <h2 class="text-base font-bold mb-4 text-center text-white">Complete Your Profile</h2>
      </div>
      <div class="flex-1 flex flex-col justify-center">
        <!-- Username -->
        <div class="mb-4">
          <label class="block text-gray-300 mb-1 text-sm"><span class="text-red-500">*</span> Username</label>
          <input v-model="form.username" type="text" class="w-full px-3 py-2 rounded-xl bg-[#18191A] text-white border border-[#353535] focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none text-sm" />
          <div v-if="errors.username" class="text-red-400 text-xs mt-1">{{ errors.username }}</div>
          <div v-if="usernameAlert" class="text-yellow-400 text-xs mt-1">{{ usernameAlert }}</div>
        </div>
        <!-- Phone Number -->
        <div class="mb-4">
          <label class="block text-gray-300 mb-1 text-sm"><span class="text-red-500">*</span> Phone Number</label>
          <div class="flex">
            <select
              v-model="form.countryCode"
              class="rounded-l-xl px-3 py-2 bg-[#18191A] text-white border border-[#353535] focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none custom-no-arrow text-sm"
            >
              <option v-for="c in countries" :key="c.code" :value="c.dial">
                ({{ c.dial }})
              </option>
            </select>
            <input
              v-model="form.phone"
              :placeholder="currentPhonePlaceholder"
              type="text"
              class="w-full px-3 py-2 rounded-r-xl bg-[#18191A] text-white border-t border-b border-r border-[#353535] focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none text-sm"
              @input="onPhoneInput"
              @keypress="onPhoneKeyPress"
            />
          </div>
          <div v-if="errors.phone" class="text-red-400 text-xs mt-1">{{ errors.phone }}</div>
        </div>
        <!-- Faculty -->
        <div class="mb-4">
          <label class="block text-gray-300 mb-1 text-sm"><span class="text-red-500">*</span> Faculty</label>
          <select v-model="form.faculty" class="w-full px-3 py-2 rounded-xl bg-[#18191A] text-white border border-[#353535] focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none text-sm">
            <option value="" disabled>Select faculty</option>
            <option v-for="faculty in faculties" :key="faculty" :value="faculty">{{ faculty }}</option>
          </select>
          <div v-if="errors.faculty" class="text-red-400 text-xs mt-1">{{ errors.faculty }}</div>
        </div>
        <!-- Resume -->
        <div class="mb-5">
          <label class="block text-gray-300 mb-1 text-sm">Resume</label>
          <div v-if="!form.resume">
            <div
              class="border-2 border-dashed border-[#bdbdbd33] rounded-xl p-4 text-center cursor-pointer bg-[#23232b] hover:bg-[#23233b] transition"
              @dragover.prevent
              @drop.prevent="onDrop"
              @click="fileInput.click()"
            >
              <input
                type="file"
                ref="fileInput"
                class="hidden"
                accept=".pdf"
                @change="onFileChange"
              />
              <div>
                <svg class="mx-auto mb-2" width="32" height="32" fill="none" stroke="currentColor"><path d="M20 30V10M10 20h20" /></svg>
                <span class="block font-semibold text-[#6c5ce7] text-sm">Click to upload</span>
                <span class="block text-xs text-gray-500">or drag and drop<br>PDF only (max 2MB)</span>
              </div>
            </div>
          </div>
          <div v-else class="flex items-center justify-between bg-[#e9e6f7] rounded-xl px-3 py-2 mt-1">
            <div class="flex items-center gap-2">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="4" fill="#e0e7ff"/>
                <text x="12" y="17" text-anchor="middle" font-size="10" fill="#6366f1" font-family="Arial">PDF</text>
              </svg>
              <div>
                <div class="font-semibold text-[#6366f1] text-xs">{{ form.resumeName }}</div>
                <div class="text-xs text-gray-500">{{ resumeSize }}</div>
              </div>
            </div>
            <button type="button" @click="removeResume" class="ml-2 text-red-500 hover:text-red-700">
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <div v-if="errors.resume" class="text-red-400 text-xs mt-1">{{ errors.resume }}</div>
        </div>
      </div>
      <div>
        <button type="submit" :disabled="!canSubmit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl shadow transition disabled:opacity-50 text-base">
          Register
        </button>
        <div class="text-center mt-2 text-sm text-gray-400">
          Already have an account?
          <a href="/login" class="text-blue-400 hover:underline ml-1">Log in!</a>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage, router } from '@inertiajs/vue3'

const faculties = [
  'Faculty of Engineering', 'Faculty of Engineering & Technology', 
  'Faculty of Artificial Intelligence & Engineering', 
  'Faculty of Business', 'Faculty of Management', 
  'Faculty of Computing & Infomatics', 'Faculty of Information Science & Technology',
  'Faculty of Creative Multimedia', 'Faculty of Cinematic Arts', 
  'Faculty of Applied Communication', 
  'Faculty of Law'
]

const countries = [
  { code: 'MY', dial: '+60', placeholder: '19 123 4567' },     // Malaysia
  { code: 'SG', dial: '+65', placeholder: '1234 5678' },       // Singapore
  { code: 'ID', dial: '+62', placeholder: '21 1234 5678' },    // Indonesia
  { code: 'PH', dial: '+63', placeholder: '912 345 6789' },    // Philippines
  { code: 'CH', dial: '+86', placeholder: '135 1234 5678' }    // China
]

/** Add this mapping for phone number min/max digits per country */
const phoneRules = {
  '+65': { min: 8, max: 8 },    // Singapore
  '+60': { min: 9, max: 10 },  // Malaysia
  '+62': { min: 10, max: 12 }, // Indonesia
  '+63': { min: 10, max: 10 }, // Philippines
  '+86': { min: 11, max: 11 }, // China
}

const form = ref({
  username: '',
  countryCode: countries[0].dial,
  phone: '',
  faculty: '',
  resume: null,
  resumeName: '',
})

const errors = ref({})

const currentPhonePlaceholder = computed(() => {
  const country = countries.find(c => c.dial === form.value.countryCode)
  return country ? country.placeholder : ''
})

const resumeSize = computed(() => {
  if (!form.value.resume) return ''
  const size = form.value.resume.size / (1024 * 1024)
  return `${size.toFixed(1)}MB`
})

function validate() {
  errors.value = {}
  if (!form.value.username) {
    errors.value.username = 'Username is required'
  } else if (!/^(?=.*[A-Za-z]).{5,}$/.test(form.value.username)) {
    errors.value.username = 'Must be at least 5 characters and include a letter'
  }
  if (!form.value.phone) {
    errors.value.phone = 'Phone number is required'
  } else {
    const rule = phoneRules[form.value.countryCode]
    const digits = form.value.phone.replace(/\D/g, '').length
    if (digits < rule.min || digits > rule.max) {
      errors.value.phone = `Phone number must be ${rule.min}${rule.min !== rule.max ? '-' + rule.max : ''} digits for this country`
    }
  }
  if (!form.value.faculty) {
    errors.value.faculty = 'Faculty is required'
  }
  // Resume is optional
  return Object.keys(errors.value).length === 0
}

const canSubmit = computed(() => {
  const rule = phoneRules[form.value.countryCode]
  const digits = form.value.phone.replace(/\D/g, '').length
  return (
    form.value.username &&
    /^(?=.*[A-Za-z])(?=.*\d).{5,}$/.test(form.value.username) &&
    form.value.phone &&
    digits >= rule.min && digits <= rule.max &&
    form.value.faculty &&
    Object.keys(errors.value).length === 0
  )
})

// Live username alert
const usernameAlert = computed(() => {
  if (!form.value.username) return ''
  if (!/^(?=.*[A-Za-z]).{5,}$/.test(form.value.username)) {
    return 'Must be at least 5 characters, include a letter'
  }
  return ''
})

function onFileChange(e) {
  const file = e.target.files[0]
  if (file) {
    if (file.type !== 'application/pdf') {
      form.value.resume = null
      form.value.resumeName = ''
      errors.value.resume = 'Only PDF files are allowed'
      return
    }
    if (file.size > 2 * 1024 * 1024) {
      form.value.resume = null
      form.value.resumeName = ''
      errors.value.resume = 'File size must be 2MB or less'
      return
    }
    form.value.resume = file
    form.value.resumeName = file.name
    errors.value.resume = ''
  }
}

function onDrop(e) {
  const file = e.dataTransfer.files[0]
  if (file) {
    if (file.type !== 'application/pdf') {
      form.value.resume = null
      form.value.resumeName = ''
      errors.value.resume = 'Only PDF files are allowed'
      return
    }
    if (file.size > 2 * 1024 * 1024) {
      form.value.resume = null
      form.value.resumeName = ''
      errors.value.resume = 'File size must be 2MB or less'
      return
    }
    form.value.resume = file
    form.value.resumeName = file.name
    errors.value.resume = ''
  }
}

const fileInput = ref(null)
function removeResume() {
  form.value.resume = null
  form.value.resumeName = ''
}

function onPhoneInput(e) {
  // Remove all non-digits
  let digits = e.target.value.replace(/\D/g, '');
  // Get max digits for current country
  const rule = phoneRules[form.value.countryCode];
  if (digits.length > rule.max) {
    digits = digits.slice(0, rule.max);
  }
  form.value.phone = digits;
}

function onPhoneKeyPress(e) {
  // Only allow numbers
  if (!/[0-9]/.test(e.key)) {
    e.preventDefault();
  }
}

function submit() {
  if (!validate()) return
  const data = new FormData()
  data.append('username', form.value.username)
  data.append('countryCode', form.value.countryCode)
  data.append('phone', form.value.phone)
  data.append('faculty', form.value.faculty)
  if (form.value.resume) data.append('resume', form.value.resume)
  router.post('/complete-profile', data)
}
</script>

<style scoped>
.custom-no-arrow {
  background-image: none !important;
}
select::-ms-expand {
  display: none;
}
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: none !important;
}
</style>
