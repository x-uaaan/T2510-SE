import { createApp } from 'vue'
import App from './App.vue'
import VCalendar from 'v-calendar'
import 'v-calendar/style.css'

const el = document.getElementById('event-app')
const events = JSON.parse(el.dataset.events)

const app = createApp(App, { events })
app.use(VCalendar, {})
app.mount('#event-app')

const elCreate = document.getElementById('event-create-app')
const organiser = elCreate.dataset.organiser
createApp(EventCreateForm, { organiser }).mount(elCreate)