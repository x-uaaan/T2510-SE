<template>
  <BaseLayout>
    <div class="min-h-screen flex items-center justify-center bg-[#18191A]">
      <form @submit.prevent="submit" class="bg-[#232323] p-6 rounded-2xl shadow-xl w-full max-w-md border border-[#292929] flex flex-col justify-between h-auto min-h-[400px]">
        <div>
          <h2 class="text-base font-bold mb-4 text-center text-white">Update Your Profile</h2>
        </div>
        <div class="flex-1 flex flex-col justify-center">
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
                class="hidden"
              />
              <label for="resume-upload" class="group flex items-center w-full h-[42px] px-3 rounded-xl bg-[#18191A] text-white border border-[#353535] focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/30 transition outline-none cursor-pointer pr-20">
                  <span class="inline-block py-1 px-3 rounded-lg border-0 text-sm font-semibold text-nowrap text-gray-200 transition-colors bg-[#3A3B3C] group-hover:bg-indigo-900 group-hover:text-white">Choose file</span>
                  <span class="ml-4 text-sm text-gray-200 truncate">{{ form.resumeName || 'No file chosen' }}</span>
              </label>
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
          <button type="submit" :disabled="!canSubmit || form.processing" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl shadow transition disabled:opacity-50 text-base">
            Update
          </button>
        </div>
      </form>
    </div>
    <div v-if="showToast" class="toast">Profile updated successfully!</div>
  </BaseLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
const showToast = ref(false)
//import { toast } from 'vue3-toastify'
//import 'vue3-toastify/dist/index.css'
import BaseLayout from '@/Layouts/BaseLayout.vue'

const props = defineProps({
  user: Object,
})

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
  { code: 'MY', dial: '+60', placeholder: '19 123 4567' },
  { code: 'SG', dial: '+65', placeholder: '1234 5678' },
  { code: 'ID', dial: '+62', placeholder: '21 1234 5678' },
  { code: 'PH', dial: '+63', placeholder: '912 345 6789' },
  { code: 'CH', dial: '+86', placeholder: '135 1234 5678' }
]

const phoneRules = {
  '+65': { min: 8, max: 8 },
  '+60': { min: 9, max: 10 },
  '+62': { min: 10, max: 12 },
  '+63': { min: 10, max: 10 },
  '+86': { min: 11, max: 11 },
}

const form = useForm({
  _method: 'patch',
  countryCode: '',
  phone: '',
  faculty: props.user.faculty,
  resume: null,
  resumeName: props.user.resume ? props.user.resume.split('/').pop() : '',
  remove_resume: false,
})

const errors = ref({})
const fileInput = ref(null)

onMounted(() => {
  const userPhone = props.user.phone || '';
  const sortedCountries = [...countries].sort((a, b) => b.dial.length - a.dial.length);

  let countryCodeFound = false;
  for (const country of sortedCountries) {
    if (userPhone.startsWith(country.dial)) {
      form.countryCode = country.dial;
      form.phone = userPhone.substring(country.dial.length);
      countryCodeFound = true;
      break;
    }
  }
  if (!countryCodeFound) {
    form.countryCode = countries[0].dial;
    form.phone = userPhone.replace(/\D/g, '');
  }
})

const currentPhonePlaceholder = computed(() => {
  const country = countries.find(c => c.dial === form.countryCode)
  return country ? country.placeholder : ''
})

const phoneAlert = computed(() => {
  if (!form.phone) return ''
  const rule = phoneRules[form.countryCode]
  const digits = form.phone.replace(/\D/g, '').length
  if (digits < rule.min) return `Phone number must be at least ${rule.min} digits for this country`
  if (digits > rule.max) return `Phone number must be at most ${rule.max} digits for this country`
  return ''
})

const canSubmit = computed(() => {
  if (!form.phone || !form.faculty) return false
  const rule = phoneRules[form.countryCode]
  const digits = form.phone.replace(/\D/g, '').length
  return digits >= rule.min && digits <= rule.max
})

function validate() {
  errors.value = {}
  if (!form.phone) {
    errors.value.phone = 'Phone number is required'
  } else {
    const rule = phoneRules[form.countryCode]
    const digits = form.phone.replace(/\D/g, '').length
    if (digits < rule.min || digits > rule.max) {
      errors.value.phone = `Phone number must be ${rule.min}${rule.min !== rule.max ? '-' + rule.max : ''} digits for this country`
    }
  }
  if (!form.faculty) {
    errors.value.faculty = 'Faculty is required'
  }
  if (form.resume && form.resume.size > 2 * 1024 * 1024) {
    errors.value.resume = 'Resume must be 2MB or less'
  }
  return Object.keys(errors.value).length === 0
}

function onFileChange(e) {
  const file = e.target.files[0];
  if (!file) return;

  if (file.type !== 'application/pdf') {
    form.resume = null;
    form.resumeName = props.user.resume ? props.user.resume.split('/').pop() : '';
    errors.value.resume = 'Only PDF files are allowed';
    e.target.value = '';
    return;
  }
  if (file.size > 2 * 1024 * 1024) {
    form.resume = null;
    form.resumeName = props.user.resume ? props.user.resume.split('/').pop() : '';
    errors.value.resume = 'Resume must be 2MB or less';
    e.target.value = '';
    return;
  }
  
  form.resume = file;
  form.resumeName = file.name;
  form.remove_resume = false;
  errors.value.resume = '';
}

function removeResume() {
  form.resume = null;
  form.resumeName = '';
  form.remove_resume = true;
  if (fileInput.value) {
    fileInput.value.value = '';
  }
}

function onPhoneInput(e) {
  let digits = e.target.value.replace(/\D/g, '');
  const rule = phoneRules[form.countryCode];
  if (digits.length > rule.max) {
    digits = digits.slice(0, rule.max);
  }
  form.phone = digits;
}

function onPhoneKeyPress(e) {
  if (!/[0-9]/.test(e.key)) {
    e.preventDefault();
  }
}

function submit() {
  if (!validate()) {
    return
  }

  form.transform(data => ({
    ...data,
    phone: data.countryCode + data.phone
  })).post(route('profile.update'), {
    onSuccess: () => {
      showToast.value = true
      setTimeout(() => showToast.value = false, 2500)
    },
    onError: (pageErrors) => {
      Object.values(pageErrors).forEach(error => {
        // toast.error(error, {
        //   position: toast.POSITION.TOP_RIGHT,
        //   autoClose: 3000,
        // })
      })
    }
  });
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
.toast {
  position: fixed;
  top: 30px;
  left: 50%;
  transform: translateX(-50%);
  background: #333;
  color: #fff;
  padding: 12px 32px;
  border-radius: 16px;
  font-size: 1em;
  z-index: 9999;
  box-shadow: 0 2px 8px #0005;
  animation: fadeInOut 2.5s;
}
@keyframes fadeInOut {
  0% { opacity: 0; }
  10% { opacity: 1; }
  90% { opacity: 1; }
  100% { opacity: 0; }
}
</style> 