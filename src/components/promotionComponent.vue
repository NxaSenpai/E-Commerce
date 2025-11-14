<script lang="ts">
import ButtonComponent from './ButtonComponent.vue'
export default{
  components: {
    ButtonComponent
  },

  props: {
    title: String,
    bgColor: String,
    btn_color: String,
    image_src: String
  }
}


</script>

<template>
  <div class="poster_list" role="list">
    <div class="poster_item" role="listitem" :style="{backgroundColor: bgColor}">
      <div class="poster_main">
        <span class="poster_label">{{ title }}</span>
        <ButtonComponent :bg="btn_color" />
      </div>
      <img class="poster_img" :src="`http://localhost:3000/${image_src}`" alt="Poster image" />
    </div>
  </div>
</template>

<style scoped>
.poster_list {
  display: flex;
  flex-direction: row;
  overflow-x: auto;
  scroll-behavior: smooth;
  scrollbar-width: none;
  gap: 24px;
  margin-top: 24px;
}

.poster_item {
  display: flex;
  flex-direction: row;
  align-items: center;
  height: 200px;
  width: 380px;
  min-width: 300px;
  background: white;
  border-radius: 8px;
  padding: 16px;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}

.poster_main {
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex: 1;
  margin-left: 24px;
}


.poster_img {
  max-width: 200px;
  max-height: 200px;
}

.poster_label {
  font-size: 16px;
  font-weight: bold;
  color: #181818;
  margin-bottom: 16px;
}
</style>
