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
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

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

const form = useForm({
  username: '',
  countryCode: countries[0].dial,
  phone: '',
  faculty: '',
  resume: null,
  resumeName: '',
})

const errors = ref({})

const currentPhonePlaceholder = computed(() => {
  const country = countries.find(c => c.dial === form.countryCode)
  return country ? country.placeholder : ''
})

const resumeSize = computed(() => {
  if (!form.resume) return ''
  const size = form.resume.size / (1024 * 1024)
  return `${size.toFixed(1)}MB`
})

function validate() {
  errors.value = {}
  
  // Username validation - only check length
  if (!form.username) {
    errors.value.username = 'Username is required'
  } else if (form.username.length < 5) {
    errors.value.username = 'Username must be at least 5 characters'
  }

  // Phone validation
  if (!form.phone) {
    errors.value.phone = 'Phone number is required'
  } else {
    const rule = phoneRules[form.countryCode]
    const digits = form.phone.replace(/\D/g, '').length
    if (digits < rule.min || digits > rule.max) {
      errors.value.phone = `Phone number must be ${rule.min}${rule.min !== rule.max ? '-' + rule.max : ''} digits for this country`
    }
  }

  // Faculty validation
  if (!form.faculty) {
    errors.value.faculty = 'Faculty is required'
  }

  // Resume validation (optional)
  if (form.resume) {
    if (form.resume.size > 2 * 1024 * 1024) {
      errors.value.resume = 'Resume must be 2MB or less'
    }
  }

  return Object.keys(errors.value).length === 0
}

const canSubmit = computed(() => {
  if (!form.username || !form.phone || !form.faculty) {
    return false
  }

  // Username check - only length
  if (form.username.length < 5) {
    return false
  }

  // Phone check
  const rule = phoneRules[form.countryCode]
  const digits = form.phone.replace(/\D/g, '').length
  if (digits < rule.min || digits > rule.max) {
    return false
  }

  return true
})

// Live username alert - only length
const usernameAlert = computed(() => {
  if (!form.username) return ''
  if (form.username.length < 5) {
    return 'Username must be at least 5 characters'
  }
  return ''
})

function onFileChange(e) {
  const file = e.target.files[0]
  if (file) {
    if (file.type !== 'application/pdf') {
      form.resume = null
      form.resumeName = ''
      errors.value.resume = 'Only PDF files are allowed'
      return
    }
    if (file.size > 2 * 1024 * 1024) {
      form.resume = null
      form.resumeName = ''
      errors.value.resume = 'File size must be 2MB or less'
      return
    }
    form.resume = file
    form.resumeName = file.name
    errors.value.resume = ''
  }
}

function onDrop(e) {
  const file = e.dataTransfer.files[0]
  if (file) {
    if (file.type !== 'application/pdf') {
      form.resume = null
      form.resumeName = ''
      errors.value.resume = 'Only PDF files are allowed'
      return
    }
    if (file.size > 2 * 1024 * 1024) {
      form.resume = null
      form.resumeName = ''
      errors.value.resume = 'File size must be 2MB or less'
      return
    }
    form.resume = file
    form.resumeName = file.name
    errors.value.resume = ''
  }
}

const fileInput = ref(null)
function removeResume() {
  form.resume = null
  form.resumeName = ''
}

function onPhoneInput(e) {
  // Remove all non-digits
  let digits = e.target.value.replace(/\D/g, '');
  // Get max digits for current country
  const rule = phoneRules[form.countryCode];
  if (digits.length > rule.max) {
    digits = digits.slice(0, rule.max);
  }
  form.phone = digits;
}

function onPhoneKeyPress(e) {
  // Only allow numbers
  if (!/[0-9]/.test(e.key)) {
    e.preventDefault();
  }
}

async function submit() {
  if (!validate()) {
    // Show validation errors
    Object.keys(errors.value).forEach(key => {
      toast.error(errors.value[key], {
        position: toast.POSITION.TOP_RIGHT,
        autoClose: 3000,
      })
    })
    return
  }

  const formData = new FormData()
  formData.append('username', form.username)
  formData.append('phone', form.countryCode + form.phone)
  formData.append('faculty', form.faculty)
  if (form.resume) {
    formData.append('resume', form.resume)
  }

  try {
    await router.post('/complete-profile', formData, {
      onSuccess: () => {
        toast.success('Profile completed successfully!', {
          position: toast.POSITION.TOP_RIGHT,
          autoClose: 3000,
        })
      },
      onError: (errors) => {
        Object.keys(errors).forEach(key => {
          toast.error(errors[key], {
            position: toast.POSITION.TOP_RIGHT,
            autoClose: 3000,
          })
        })
      }
    })
  } catch (error) {
    toast.error('An error occurred while saving your profile', {
      position: toast.POSITION.TOP_RIGHT,
      autoClose: 3000,
    })
  }
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
