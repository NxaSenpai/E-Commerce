import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from '@/router/index.ts'

console.log("Hello Vue 3 + Vite + TypeScript + Pinia + TailwindCSS!")

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
