<script lang="ts">
import { defineComponent } from 'vue'
import router from '@/router'

export default defineComponent({
  props: {
    title: { type: String, required: true },
    bgColor: { type: String, default: 'var(--bg)' },
    itemCounts: { type: [Number, String], default: 0 },
    image_src: { type: String, required: true },
    cate_id: { type: [Number, String], required: true },
  },

  methods: {
    async onCategoryClick() {
      if (!this.cate_id || !this.title) {
        console.warn('category id or name is missing; navigation aborted')
        return
      }
      await router.push({
        name: 'CategoryView',
        params: { categoryId: String(this.cate_id), categoryName: this.title },
      })
    },
  },
})
</script>

<template>
  <div class="category_list" role="list">
    <button
      :style="{ backgroundColor: bgColor }"
      class="category_btt"
      type="button"
      @click="onCategoryClick"
    >
      <img class="category_img" :src="`http://localhost:3000/${image_src}`" alt="Category image" />
      <span class="category_name">{{ title }}</span>
      <span class="category_count">{{ itemCounts }} items </span>
    </button>
  </div>
</template>

<style scoped>
.category_list {
  display: flex;
  flex-direction: row;
  overflow-x: auto;
  scrollbar-width: none;
  gap: 10px;
  margin-bottom: 50px;
}

.category_btt {
  padding: 5px;
  width: 100px;
  height: 130px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background: var(--bg);
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 8px;
  transition: background 0.3s;
}

.category_btt:hover {
  background: var(--hover);
}

.category_img {
  width: 65%;
  margin-bottom: 10px;
}

.category_name {
  font-size: 11px;
  font-weight: bold;
  margin-bottom: 5px;
}

.category_count {
  font-size: 10px;
  color: lightslategray;
}
</style>
