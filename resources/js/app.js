import { createApp } from 'vue';
import EventComponent from './component/EventComponent.vue';

const app = createApp({});
app.component('event-component', EventComponent);
app.mount('#app');