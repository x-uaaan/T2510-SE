import { createApp } from 'vue'
import EventCreateForm from './Pages/EventCreateForm.vue'

const el = document.getElementById('event-create-app')
if (el) {
  const organiserId = el.getAttribute('data-organiser-id')
  const organiserName = el.getAttribute('data-organiser-name')
  createApp(EventCreateForm, { organiserId, organiserName }).mount(el)
}