<script setup lang="ts">


class PosterItem {
  img: string;
  label: string;
  btt_label: string;
  btt_color: string;
  bg_color: string;

  constructor(img: string, label: string, btt_label: string, btt_color: string, bg_color: string) {
    this.img = img;
    this.label = label;
    this.btt_label = btt_label;
    this.btt_color = btt_color;
    this.bg_color = bg_color;
  }
}

const item_poster: PosterItem[] = [
  new PosterItem("image/promo_item_1.png", "Everyday Fresh & Clean with Our Products", "Button", "green", "white"),
  new PosterItem("image/promo_item_2.png", "Make your Breakfast Healthy and Easy", "Button", "yellow", "white"),
  new PosterItem("image/promo_item_3.png", "The Best Organic Products Online", "Button", "red", "white"),
]

</script>

<template>
  <div class="poster_list" role="list">
    <div v-for="item in item_poster" class="poster_item" role="listitem" :key="item.label">
      <div class="poster_bg" :style="{ 'background-color': item.bg_color }">`>
        <div class="poster_main">
        <span class="poster_label">{{ item.label }}</span>
        <ButtonComponent :style="{'background': item.btt_color}" />
      </div>
      <img class="poster_img" :src="item.img" alt="Poster image">
      </div>
    </div>
  </div>

</template>

<style scoped>
.poster_list{
  display        : flex;
  flex-direction : row;
  overflow-x     : scroll;
  scroll-behavior: smooth;
  scrollbar-width: none;
  gap            : 24px;
  margin-top     : 24px;
}
.poster_main {
  margin-left    : 24px;
  display        : flex;
  flex-direction : column;
  align-items    : flex-start;
  justify-content: center;
  height         : 100%;
  width          : 100%;
}

.poster_label{
  font-size: 16px;
  font-weight: bold;
  color: #181818;
  margin-bottom: 16px;
}

.poster_bg{
  display        : flex;
  flex-direction : row;
  align-items    : center;
  height         : 200px;
  width          : 380px;
  min-width      : 200px;
  max-height: 200px;
  border-radius: 10px;
}



.poster_item {
  display        : flex;
  flex-direction : row;
  align-items    : center;
  border-radius  : 8px;
}

.poster_img{
  max-width: 150px;
  max-height: 150px;
  margin-right: 10px ;
}

</style>
