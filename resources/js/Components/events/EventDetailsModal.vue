<template>
  <Modal :show="show" @close="closeModal" max-width="xl">
    <div class="p-8 pb-6 bg-[#2d2d2d] text-white rounded-2xl shadow-xl modal-content">
        <div class="mb-4" v-if="event.image_url">
            <img :src="event.image_url" :alt="event.eventName" class="w-full h-auto max-h-52 object-cover rounded-lg">
        </div>
        
        <div class="flex justify-between items-start mb-0">
          <h2 class="text-2xl font-bold mb-0 text-[#fff]">{{ event.eventName }}</h2>
        </div>

        <!-- Event Description -->
        <p class="text-gray-300 mb-4 whitespace-pre-wrap">{{ event.eventDesc }}</p>

        <!-- Event Tabs -->
        <div class="event-tabs">
          <span class="glider" :style="gliderStyle"></span>
          <button :ref="el => tabButtons.details = el" :class="{active: tab==='details'}" @click="tab='details'">Details</button>
          <button :ref="el => tabButtons.attendees = el" :class="{active: tab==='attendees'}" @click="tab='attendees'">Attendees</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content-container">
          <!-- Details Tab -->
          <div v-if="tab==='details'">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
              <div>
                <strong class="metadata-label text-gray-400 block mb-0">Start Date</strong>
                <span class="text-base">{{ formatDate(event.startDate) }}</span>
              </div>
              <div>
                <strong class="metadata-label text-gray-400 block mb-0">Start Time</strong>
                <span class="text-base">{{ formatTime(event.startTime) }}</span>
              </div>
              <div v-if="event.endDate">
                <strong class="metadata-label text-gray-400 block mb-0">End Date</strong>
                <span class="text-base">{{ formatDate(event.endDate) }}</span>
              </div>
              <div v-if="event.endTime">
                <strong class="metadata-label text-gray-400 block mb-0">End Time</strong>
                <span class="text-base">{{ formatTime(event.endTime) }}</span>
              </div>
              <div>
                <strong class="metadata-label text-gray-400 block mb-0">Venue</strong>
                <span class="text-base">{{ event.eventVenue }}</span>
              </div>
              <div>
                <strong class="metadata-label text-gray-400 block mb-0">Capacity</strong>
                <span class="text-base">{{ event.capacity > 0 ? event.capacity : 'Unlimited' }}</span>
              </div>
            </div>
          </div>

          <!-- Attendees Tab -->
          <div v-if="tab==='attendees'">
            <div v-if="event.attendees && event.attendees.length > 0">
              <h3 class="font-semibold mb-2 text-gray-400">Event Attendees</h3>
                <ul class="space-y-3">
                  <li v-for="attendee in event.attendees" :key="attendee.attendeesID" class="flex items-center space-x-3">
                    <div class="flex-1">
                      <a 
                        :href="`mailto:${attendee.user.email}`" 
                        class="attendee-name text-base"
                      >
                        {{ attendee.user.username }}
                      </a>
                    </div>
                  </li>
                </ul>
            </div>
            <div v-else class="text-center py-8">
              <p class="text-gray-500 text-l">No attendees registered yet</p>
            </div>
          </div>
        </div>

        <div class="mt-4 flex justify-end items-center gap-2">
          <button v-if="canEdit" @click="showDeleteModal = true" class="modal-btn delete-btn">
            Delete
          </button>
          <a v-if="canEdit" :href="`/events/${event.eventID}/edit`" class="modal-btn">
              Edit
          </a>
          <button @click="closeModal" class="modal-btn">
            Close
          </button>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <Modal :show="showDeleteModal" @close="closeDeleteModal" max-width="sm" class="delete-modal">
      <div class="p-6 bg-[#232323] rounded-2xl text-center">
        <h2 class="text-lg font-bold mb-2">Delete Event?</h2>
        <p class="mb-0 text-gray-300">Are you sure you want to delete this event?</p>
        <p class="mb-4 text-gray-300">This action cannot be undone.</p>
        <div class="flex justify-center gap-4 mt-4">
          <button @click="deleteEvent" class="delete-btn modal-btn px-6 py-2 font-semibold">Delete</button>
          <button @click="closeDeleteModal" class="modal-btn px-6 py-2 font-semibold">Cancel</button>
        </div>
      </div>
    </Modal>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'
import { computed, ref, watch, onMounted, nextTick } from 'vue'
import axios from 'axios'

const props = defineProps({
  show: Boolean,
  event: {
    type: Object,
    default: () => ({}),
  },
  authUser: Object,
})

const emit = defineEmits(['close', 'deleted'])

const tab = ref('details')
const tabButtons = ref({
  details: null,
  attendees: null,
})
const gliderStyle = ref({})
const showDeleteModal = ref(false)
const showToast = ref(false)

const canEdit = computed(() => {
    return props.authUser && props.authUser.userID === props.event.organiserID;
});

const updateGlider = () => {
  const activeButton = tabButtons.value[tab.value]
  if (activeButton) {
    gliderStyle.value = {
      left: `${activeButton.offsetLeft}px`,
      width: `${activeButton.offsetWidth}px`,
    }
  }
}

watch(tab, () => {
  nextTick(updateGlider);
});

onMounted(() => {
  setTimeout(updateGlider, 100);
});

const closeModal = () => {
  emit('close')
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
}

const deleteEvent = async () => {
  try {
    await axios.delete(`/events/${props.event.eventID}`, { baseURL: '/api' })
    showToast.value = true
    setTimeout(() => {
      window.location.href = '/profile'
    }, 1800)
  } catch (e) {
    alert('Failed to delete event. Please try again.')
  }
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

const getInitials = (name) => {
  if (!name) return ''
  return name.split(' ').map(word => word.charAt(0).toUpperCase()).join('').slice(0, 2)
}
</script>

<style scoped>
.modal-content {
  background: #232323;
  backdrop-filter: blur(10px);
}
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
.metadata-label, h3 {
    font-size: 0.8em;
}
/* Event Tabs Styles */
.event-tabs {
  position: relative;
  display: inline-flex;
  background-color: #18191a;
  border-radius: 10px;
  padding: 4px;
  gap: 6px;
  margin-bottom: 18px;
}
.glider {
  position: absolute;
  height: calc(100% - 12px);
  top: 4px;
  padding: 2px;
  margin: 2px;
  margin-left: 0px;
  background-color: #232323;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.event-tabs button {
  position: relative;
  z-index: 1;
  background: transparent;
  border: none;
  color: #a0a0a0;
  font-size: 0.9em;
  font-weight: 600;
  padding: 6px 16px;
  margin: 2px;
  border-radius: 10px;
  cursor: pointer;
  outline: none;
}
.event-tabs button:hover {
  background-color: rgb(45, 46, 49);
}
.event-tabs button.active {
  background-color: #3A3B3C;
  color: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.tab-content-container {
  border: 1px solid #3A3B3C;
  border-radius: 8px;
  padding: 10px;
  padding-left: 20px;
  min-height: 200px;
}
.tab-content-container ul {
  font-size: 0.9em;
}
.attendee-name {
  transition: color 0.2s ease;
}
.attendee-name:hover {
  color: #3b82f6;
}
.delete-btn {
  color: #fff;
  border: 1px solid #e6004d6e;
  background: #e6004d1c;
  transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
}
.delete-btn:hover {
  background: #e6004c44;
  border-color: #ff1a5b;
  box-shadow: 0 0 0 3px #ff1a5b55;
}
.delete-modal {
  position: fixed !important;
  top: 0; left: 0;
  width: 100vw; height: 100vh;
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  z-index: 9999 !important;
  pointer-events: auto !important;
  background: none !important; /* Let the Modal's overlay show */
}
</style> 