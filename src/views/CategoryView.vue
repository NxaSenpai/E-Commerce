<script setup lang="ts">
import { ref, onMounted } from 'vue'

interface Category {
  id: number
  name: string
  color?: string
  image?: string
}

const props = defineProps<{
  categoryId?: string | number
  categoryName?: string
}>()

const categories = ref<Category[]>([])
const loading = ref(true)
const error = ref('')
const selectedCategory = ref<Category | null>(null)

onMounted(async () => {
  try {
    const res = await fetch('http://localhost:3000/api/categories')
    if (!res.ok) throw new Error('Failed to fetch')
    categories.value = await res.json()

    if (props.categoryId != null) {
      selectedCategory.value =
        categories.value.find((c) => String(c.id) === String(props.categoryId)) ?? null
    } else if (props.categoryName) {
      selectedCategory.value = categories.value.find((c) => c.name === props.categoryName) ?? null
    }
  } catch (err: any) {
    error.value = err?.message ?? String(err)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="bg">
    <div v-if="loading">Loading...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else-if="selectedCategory" :key="selectedCategory.id">
      <h1>Category: {{ selectedCategory.name }}</h1>
      <p>Home > Categories > {{ selectedCategory.name }}</p>
    </div>
    <div v-else>
      <p>Category not found</p>
    </div>
  </div>
</template>

<style scoped>
.bg{
  padding-left: 70px;
  padding-top: 70px;
  width: 100%;
  color:rgb(34, 49, 44);
  height: 300px;
  background: #a7ffd6;
  border-radius: 10px;
}

.bg h1{
  font-size: 35px;
  font-weight: bold;
  margin-bottom: 30px;
}

.bg p{
  font-size: 15px;
  color: #474747;
}
</style>
