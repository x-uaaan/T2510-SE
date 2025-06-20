<template>
  <BaseLayout>
    <div class="min-h-screen flex items-center justify-center bg-[#18191A]">
      <form @submit.prevent="submit" class="bg-[#232323] p-6 rounded-2xl shadow-xl w-full max-w-md border border-[#292929] flex flex-col justify-between h-[600px]">
        <div>
          <img src="/image/CampusPulse.png" alt="Campus Pulse Logo" class="mx-auto mb-2 h-12" />
          <h2 class="text-base font-bold mb-4 text-center text-white">Complete Your Profile</h2>
        </div>
        <div class="flex-1 flex flex-col justify-center">
          <!-- Role -->
          <div class="mb-4 flex items-center justify-center gap-8">
            <label class="flex items-center cursor-pointer">
              <input type="radio" v-model="form.userType" value="Alumni" class="hidden" />
              <span :class="['w-5 h-5 rounded-full border-2 flex items-center justify-center mr-2', form.userType === 'Alumni' ? 'border-blue-500' : 'border-gray-500']">
                <span v-if="form.userType === 'Alumni'" class="w-3 h-3 bg-blue-500 rounded-full block"></span>
              </span>
              <span class="text-white text-base">Alumni</span>
            </label>
            <label class="flex items-center cursor-pointer">
              <input type="radio" v-model="form.userType" value="Lecturer" class="hidden" />
              <span :class="['w-5 h-5 rounded-full border-2 flex items-center justify-center mr-2', form.userType === 'Lecturer' ? 'border-blue-500' : 'border-gray-500']">
                <span v-if="form.userType === 'Lecturer'" class="w-3 h-3 bg-blue-500 rounded-full block"></span>
              </span>
              <span class="text-white text-base">Lecturer</span>
            </label>
          </div>
          <!-- Username -->
           <!--
          <div class="mb-4">
            <label class="block text-gray-300 mb-1 text-sm"><span class="text-red-500">*</span> Username</label>
            <input v-model="form.username" type="text" class="w-full px-3 py-2 rounded-xl bg-[#18191A] text-white border border-[#353535] focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none text-sm" />
            <div v-if="errors.username" class="text-red-400 text-xs mt-1">{{ errors.username }}</div>
            <div v-if="usernameAlert" class="text-yellow-400 text-xs mt-1">{{ usernameAlert }}</div>
          </div>
          -->
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
            <div v-if="phoneAlert" class="text-yellow-400 text-xs mt-1">{{ phoneAlert }}</div>
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
            <label for="resume-upload" class="block text-gray-300 mb-1 text-sm">Resume</label>
            <div class="relative">
              <input
                id="resume-upload"
                type="file"
                accept=".pdf"
                @change="onFileChange"
                ref="fileInput"
                class="block w-full text-sm text-gray-200
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-xl file:border-0
                       file:text-sm file:font-semibold
                       file:bg-[#18191A] file:text-white
                       hover:file:bg-[#23233b]
                       bg-[#18191A] border border-[#353535] rounded-xl pr-20"
              />
              <button
                v-if="form.resumeName"
                type="button"
                @click="removeResume"
                class="absolute top-1/2 right-3 -translate-y-1/2 text-red-500 hover:text-red-700 text-xs font-semibold"
                style="z-index:2;"
              >
                Remove
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
            <a href="/auth/microsoft" class="text-blue-400 hover:underline ml-1">Log in!</a>
          </div>
        </div>
      </form>
    </div>
  </BaseLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import BaseLayout from '@/Layouts/BaseLayout.vue'

const props = defineProps(['email', 'name'])

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
  userType: '',
  email: '',
  name: '',
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

  // Role validation
  if (!form.userType) {
    errors.value.userType = 'Please select a role'
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
  if (!form.userType || !form.phone || !form.faculty) {
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

const phoneAlert = computed(() => {
  if (!form.phone) return ''
  const rule = phoneRules[form.countryCode]
  const digits = form.phone.replace(/\D/g, '').length
  if (digits < rule.min) {
    return `Phone number must be at least ${rule.min} digits for this country`
  }
  if (digits > rule.max) {
    return `Phone number must be at most ${rule.max} digits for this country`
  }
  return ''
})

function onFileChange(e) {
  const file = e.target.files[0];
  if (!file) return;

  // Only PDF
  if (file.type !== 'application/pdf') {
    form.resume = null;
    form.resumeName = '';
    errors.value.resume = 'Only PDF files are allowed';
    e.target.value = ''; // Reset input
    return;
  }
  // Max 2MB
  if (file.size > 2 * 1024 * 1024) {
    form.resume = null;
    form.resumeName = '';
    errors.value.resume = 'File size must be 2MB or less';
    e.target.value = ''; // Reset input
    return;
  }
  // Valid file
  form.resume = file;
  form.resumeName = file.name;
  errors.value.resume = '';
}

const fileInput = ref(null)
function removeResume() {
  form.resume = null;
  form.resumeName = '';
  if (fileInput.value) {
    fileInput.value.value = ''; // Reset the input so it shows "No file chosen"
  }
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

onMounted(() => {
  if (props.email) form.email = props.email
  if (props.name) form.name = props.name
})

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
  formData.append('email', form.email)
  formData.append('name', form.name)
  formData.append('phone', form.countryCode + form.phone)
  formData.append('faculty', form.faculty)
  formData.append('userType', form.userType)
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
        // Use router.visit instead of window.location for proper Inertia handling
        router.visit('/events')
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
input[type="file"]::file-selector-button {
  background: #18191A;
  color: #fff;
  border: none;
  border-radius: 0.5rem;
  padding: 0.2rem 0.7rem;
  margin: 0.3rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}
input[type="file"]::file-selector-button:hover {
  background: #23233b;
}
</style>
