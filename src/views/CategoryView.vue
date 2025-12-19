<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface Category {
  id: number
  name: string
}

const categories = ref<Category[]>([])
const loading = ref(true)
const error = ref('')
const selectedCategory = ref<Category | null>(null)


onMounted(async () => {
  try {
    const res = await fetch('http://localhost:3000/api/categories')
    if (!res.ok) throw new Error('Failed to fetch')
    categories.value = await res.json()
  } catch (err: any) {
    error.value = err.message
  } finally {
    loading.value = false
  }
})

defineProps<{
  categoryId: string | number
  categoryName: string
}>()
</script>

<template>
<div class="bg" v-if="category in categories" :key="category.name">
  <h1>Category: {{ category.name }}</h1>
  <p>Category ID: {{ category.id }}</p>
</div>
</template>

<style scoped>

.bg{
  width: 100%;
  color:black;
  height: 300px;
  background: #69cd9f;
  border-radius: 10px;
}

</style>
