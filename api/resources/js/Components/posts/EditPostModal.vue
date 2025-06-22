<template>
  <div v-if="show" class="modal-overlay">
    <div class="modal-content">
    <form @submit.prevent="submit" class="post-form">
        <input 
          v-model="form.postTitle" 
          type="text" 
          placeholder="Post Title" 
          required 
          class="form-input"
        />
        <textarea 
          v-model="form.postDesc" 
          placeholder="Post Description" 
          required 
          class="form-input"
          rows="4"
        ></textarea>
        <div v-if="errorMsg" class="error-message">{{ errorMsg }}</div>
        <div class="modal-button">
            <button @click="$emit('close')" class="close-btn">
                Cancel
            </button>

            <button 
            type="submit" 
            :disabled="submitting" 
            class="submit-btn"
            >Update
            </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  show: Boolean,
  post: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['close', 'updated'])

const form = ref({
  postTitle: '',
  postDesc: ''
})

const submitting = ref(false)
const errorMsg = ref('')

// Watch for changes in the post prop and update the form
watch(() => props.post, (newPost) => {
  if (newPost) {
    form.value = {
      postTitle: newPost.postTitle,
      postDesc: newPost.postDesc
    }
  }
}, { immediate: true })

async function submit() {
  submitting.value = true
  errorMsg.value = ''
  
  try {
    const response = await fetch(`/api/posts/${props.post.postID}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(form.value)
    })

    if (!response.ok) {
      const data = await response.json()
      errorMsg.value = data.message || 'Failed to update post.'
      submitting.value = false
      return
    }

    emit('updated')
    emit('close')
    window.location.reload();
  } catch (err) {
    errorMsg.value = 'An error occurred while updating the post.'
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
  height: auto;
  max-width: 400px;
  border: 1px solid #353535;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  margin-top: -50px;
  justify-content: center;
  align-items: center;
}

.post-form {
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
  width: 120px;
  background: #18191a;
  color: #fff;
  box-shadow: 0 2px 8px #0002 !important;
  border: 1px solid #3d3e46;
  border-radius: 25px;
  padding: 0.5rem 0;
  font-size: 1em;
  cursor: pointer;
  outline: none;
}
button:hover{
  border: 0.5px solid #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  background: #23242a !important;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}

.error-message {
  color: #ef4444;
  text-align: center;
  font-size: 0.875rem;
}
</style> 