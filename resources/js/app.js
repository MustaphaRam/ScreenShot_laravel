import './bootstrap';

/* import { createApp } from 'vue'
const app = createApp({})
import welcome from './components/welcome.vue'
app.component('welcome-component', welcome)
app.mount('#app') */

import { createApp } from 'vue'
import app from './layouts/app.vue'
createApp(app).mount('#app')
