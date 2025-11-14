<script lang="ts">
export default{
  props: {
    bg: String,
  }
}
</script>

<template>
  <button class="poster_btt" :style="{ '--bg': bg || 'green'}">
    <span class="poster_btt_label">{{ 'Shop Now' }}</span>
  </button>
</template>

<style scoped>
.poster_btt {
  min-width: 100px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--bg);
  color: white;
  font-weight: bold;
  cursor: pointer;
  border: none;
  border-radius: 8px;
  padding: 8px 12px;
  font-size: 13px;
  transition: background-color 0.3s;
}

.poster_btt:hover {
  background-color: var(--hover);
}
</style>
