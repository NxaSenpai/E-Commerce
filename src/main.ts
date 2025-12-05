import './assets/main.css'

import { createApp } from 'vue'

import App from './App.vue'
import ButtonComponent from "@/components/ButtonComponent.vue"
import CategoryComponent from "@/components/categoryComponent.vue"
import PromotionComponent from "@/components/promotionComponent.vue"
import ProductComponent from "@/components/productComponent.vue"
import MenuComponent from './components/MenuComponent.vue'

console.log("Hello Vue 3 + Vite + TypeScript + Pinia + TailwindCSS!")

createApp(App)
.component("ButtonComponent", ButtonComponent)
.component("CategoryComponent", CategoryComponent)
.component("PromotionComponent", PromotionComponent)
.component("ProductComponent", ProductComponent)
.component("MenuComponent", MenuComponent)
.mount('#app')

