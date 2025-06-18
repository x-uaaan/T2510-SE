import { createApp } from 'vue'
import EventCreateForm from './Pages/EventCreateForm.vue'

const el = document.getElementById('event-create-app')
if (el) {
  const organiser = el.getAttribute('data-organiser')
  createApp(EventCreateForm, { organiser }).mount(el)
}