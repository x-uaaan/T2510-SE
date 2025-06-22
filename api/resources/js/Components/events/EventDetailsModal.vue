<template>
  <Modal :show="show" @close="closeModal" max-width="xl">
    <div class="p-8 bg-[#2d2d2d] text-white rounded-2xl shadow-xl">
        <div class="mb-4" v-if="event.image_url">
            <img :src="event.image_url" :alt="event.eventName" class="w-full h-auto max-h-64 object-cover rounded-lg">
        </div>
        
        <div class="flex justify-between items-start">
          <h2 class="text-2xl font-bold mb-0 text-[#fff]">{{ event.eventName }}</h2>
        </div>

      <p class="text-gray-300 mb-4 whitespace-pre-wrap">{{ event.eventDesc }}</p>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 border-t border-gray-600 pt-4">
        <div>
          <strong class="metadata-label text-gray-400 block mb-0">Start Date:</strong>
          <span class="text-base">{{ formatDate(event.startDate) }}</span>
        </div>
        <div>
          <strong class="metadata-label text-gray-400 block mb-0">Start Time:</strong>
          <span class="text-base">{{ formatTime(event.startTime) }}</span>
        </div>
        <div v-if="event.endDate">
          <strong class="metadata-label text-gray-400 block mb-0">End Date:</strong>
          <span class="text-base">{{ formatDate(event.endDate) }}</span>
        </div>
        <div v-if="event.endTime">
          <strong class="metadata-label text-gray-400 block mb-0">End Time:</strong>
          <span class="text-base">{{ formatTime(event.endTime) }}</span>
        </div>
        <div>
          <strong class="metadata-label text-gray-400 block mb-0">Venue:</strong>
          <span class="text-base">{{ event.eventVenue }}</span>
        </div>
        <div>
          <strong class="metadata-label text-gray-400 block mb-0">Capacity:</strong>
          <span class="text-base">{{ event.capacity > 0 ? event.capacity : 'Unlimited' }}</span>
        </div>
      </div>

      <div class="mt-8 flex justify-end items-center gap-4">
        <a v-if="canEdit" :href="`/events/${event.eventID}/edit`" class="modal-btn">
            Edit
        </a>
        <button @click="closeModal" class="modal-btn">
          Close
        </button>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'
import { computed } from 'vue'

const props = defineProps({
  show: Boolean,
  event: {
    type: Object,
    default: () => ({}),
  },
  authUser: Object,
})

const emit = defineEmits(['close'])

const canEdit = computed(() => {
    return props.authUser && props.authUser.userID === props.event.organiserID;
});

const closeModal = () => {
  emit('close')
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateString).toLocaleDateString(undefined, options)
}

const formatTime = (timeString) => {
    if (!timeString) return '';
    const [hours, minutes] = timeString.split(':');
    const date = new Date();
    date.setHours(Number(hours), Number(minutes));
    const options = { hour: 'numeric', minute: '2-digit', hour12: true };
    return date.toLocaleTimeString('en-US', options);
}
</script>

<style scoped>
.modal-btn {
  display: inline-block;
  width: 70px;
  border-radius: 25px;
  padding: 5px 10px;
  font-size: 0.9em;
  cursor: pointer;
  outline: none;
  border: 1px solid #3d3e46;
  color: #fff;
  background: #18191a;
  transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
  text-decoration: none;
  text-align: center;
}
.modal-btn:hover{
  background: #23242a;
  border: 1px solid #3b82f6;
  box-shadow: 0 0 0 2px #3b82f688;
}
.metadata-label {
    font-size: 0.8em;
}
</style> 