<script setup lang="ts">

const color_set = [
  {bg: '#F2FCE4', hover: '#c8f1dc'},
  {bg: '#FFFCEB', hover: '#ffd8c2'},
  {bg: '#ECFFEC', hover: '#d4f8da'},
  {bg: '#FEEFEA', hover: '#ffd6dc'},
  {bg: '#FFF3EB', hover: '#ffefc8'},
  {bg: '#FFF3FF', hover: '#e2d9ff'},
  {bg: '#F2FCE4', hover: '#d5f4dc'},
  {bg: '#EAF6FF', hover: '#d2ecff'},
  {bg: '#FFF3E0', hover: '#ffe3b8'}
]

class CategoryItem {
  img: string;
  name: string;
  count: number;
  prefix: string;
  color: string;
  hover_color: string;

  constructor(img: string, name: string, count: number, prefix: string = "item(s)", color: string | null = null, hover_color: string | null = null) {
    const random_color = color_set[Math.floor(Math.random() * color_set.length)]!;
    this.img = img;
    this.name = name;
    this.count = count;
    this.prefix = prefix;
    this.color = color ?? random_color.bg;
    this.hover_color = hover_color ?? random_color.hover;
  }

}

const item_category: CategoryItem[] = [
  new CategoryItem("image/cate_item_1.png", "Category 1", 14, "items"),
  new CategoryItem("image/cate_item_2.png", "Category 2", 17, "items"),
  new CategoryItem("image/cate_item_3.png", "Category 3", 21, "items"),
  new CategoryItem("image/cate_item_4.png", "Category 4", 68, "items"),
  new CategoryItem("image/cate_item_5.png", "Category 5", 34, "items"),
  new CategoryItem("image/cate_item_6.png", "Category 6", 25, "items"),
  new CategoryItem("image/cate_item_7.png", "Category 7", 65, "items"),
  new CategoryItem("image/cate_item_8.png", "Category 8", 33, "items"),
  new CategoryItem("image/cate_item_9.png", "Category 9", 54, "items"),
  new CategoryItem("image/cate_item_10.png", "Category 10", 63, "items"),
]


</script>

<template>
  <div class="category_list" role="list">
    <button
      v-for="item in item_category"
      :key="item.name"
      role="menuitem"
      type="button"
      class="category_btt"
      :style="{ '--bg': item.color, '--hover': item.hover_color }"
    >
      <img class="category_img" :src="item.img" alt="Category image">
      <span class="category_name">{{ item.name }}</span>
      <span class="category_count">{{ item.count }} {{ item.prefix }}</span>


    </button>

  </div>

</template>

<style scoped>

.category_list {
  display        : flex;
  flex-direction : row;
  overflow-x: scroll;
  scrollbar-width: none;
  margin-bottom: 50px;

}

.category_btt {
  padding         : 5px;
  min-width       : 100px;
  width           : 100px;
  height          : 130px;
  margin          : 10px;
  display         : flex;
  flex-direction  : column;
  justify-content : center;
  align-items     : center;
  background      : var(--bg);
  border          : 1px solid rgba(0, 0, 0, 0.06);
  border-radius   : 8px;

}

.category_btt:hover {
  background : var(--hover);
}

.category_img {
  width         : 65%;
  margin-bottom : 10px;
}

.category_name {
  font-size     : 11px;
  font-weight   : bold;
  margin-bottom : 5px;
}

.category_count {
  font-size : 10px;
  color     : lightslategray;
}


</style>
