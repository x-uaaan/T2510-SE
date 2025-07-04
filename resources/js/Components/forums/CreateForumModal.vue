<template>
  <div v-if="show" class="modal-overlay">
    <div class="modal-content">
    <form @submit.prevent="submit" class="forum-form">
        <input 
          v-model="form.forumTitle" 
          type="text" 
          placeholder="Forum Title" 
          required 
          class="form-input"
        />
        <textarea 
          v-model="form.forumDesc" 
          placeholder="Forum Description" 
          required 
          class="form-input"
          rows="4"
        ></textarea>
        <input 
          v-model="form.Categories" 
          type="text" 
          placeholder="Categories (comma separated)" 
          class="form-input"
        />
        <div v-if="errorMsg" class="error-message">{{ errorMsg }}</div>
        <div class="modal-button">
            <button @click="$emit('close')" class="close-btn">
                Cancel
            </button>

            <button 
            type="submit" 
            :disabled="submitting" 
            class="submit-btn"
            >Create
            </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(['close', 'created'])

const form = ref({
  forumTitle: '',
  forumDesc: '',
  Categories: '',
  organiserID: '',
  organiserName: ''
})

const submitting = ref(false)
const errorMsg = ref('')

onMounted(async () => {
  try {
    const res = await fetch('/api/user', { credentials: 'include' });
    if (res.ok) {
      const data = await res.json();
      form.value.organiserID = data.userID || data.id || '';
      form.value.organiserName = data.username || data.name || '';
    } else {
      form.value.organiserID = '';
      form.value.organiserName = '';
    }
  } catch (e) {
    form.value.organiserID = '';
    form.value.organiserName = '';
  }
})

async function submit() {
  submitting.value = true
  errorMsg.value = ''
  try {
    const formData = new FormData()
    formData.append('forumTitle', form.value.forumTitle)
    formData.append('forumDesc', form.value.forumDesc)
    formData.append('Categories', form.value.Categories)
    formData.append('organiserID', form.value.organiserID)
    formData.append('organiserName', form.value.organiserName)
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const response = await fetch('/api/forum', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
      },
      body: formData
    })
    if (!response.ok) {
      const data = await response.json()
      errorMsg.value = data.message || 'Failed to create forum.'
      submitting.value = false
      return
    }
    emit('created')
    emit('close')
    form.value = {
      forumTitle: '',
      forumDesc: '',
      Categories: '',
      organiserID: form.value.organiserID,
      organiserName: form.value.organiserName,
    }
  } catch (err) {
    errorMsg.value = 'An error occurred while creating the forum.'
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.75);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: #232323;
  border-radius: 1rem;
  padding: 1.5rem;
  width: 400px;
  height: 280px;
  max-width: 400px;
  border: 1px solid #353535;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  margin-top: -50px;
  justify-content: center;
  align-items: center;
}

.forum-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 0;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  background: #18191A;
  border: 1px solid #353535;
  color: #fff;
  font-size: 1rem;
  transition: border-color 0.2s;
  font-family: 'Times New Roman', Times, serif;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 1px #3b82f688;
}

.form-input::placeholder{
  color: #727171;
  font-family: 'Times New Roman', Times, serif;
}

.modal-button{
  display: flex;
  justify-content: space-around;
  align-items: center;
}

button{
  width: 150px;
  border: 1px solid #3b82f6;
  border-radius: 25px;
  padding: 13px 18px;
  font-size: 1em;
  cursor: pointer;
  outline: none;
  border: 1px solid #3d3e46;
  color: #fff;
  box-shadow: 0 2px 8px #0002;
  background: #18191a;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
button:hover{
  background: #23242a;
  border: 0.5px solid #3b82f6 !important;
  box-shadow: 0 0 0 1px #3b82f688 !important;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}

.error-message {
  color: #ef4444;
  text-align: center;
  font-size: 0.875rem;
}
</style> 