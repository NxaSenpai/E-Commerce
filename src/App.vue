<script lang="ts">
import axios from 'axios'
import PromotionComponent from './components/promotionComponent.vue';
export default{
  data() {
      return {
        promotions: [],
        categories: []
      }
  },

  methods: {
    async fetchPromotions() {
      try {
        const response = await axios.get('http://localhost:3000/api/promotions');
        this.promotions = response.data;
        console.log(this.promotions);
      } catch (error) {
        console.error(error);
      }
    },


    async fetchCategories(){
      try {
        const response = await axios.get('http://localhost:3000/api/categories');
        this.categories = response.data;
        console.log(response.data);
      } catch (error) {
        console.log(error)
      }
    },
  },

  mounted() {
    // eslint-disable-next-line @typescript-eslint/no-unused-expressions
    this.fetchPromotions(),
    this.fetchCategories()
  }
}

</script>

<template>
  <div class="container">

    <!-- Categories -->
    <div class="category_wrapper">
      <div 
        v-for="(category, index) in categories" 
        :key="index" 
        class="category_item"
      >
        <CategoryComponent 
          :title="category.name"
          :bgColor="category.color"
          :itemCounts="category.productCount"
          :image_src="category.image"
        />
      </div>
    </div>

    <!-- Promotions -->
    <div class="promotion_wrapper">
      <div 
        v-for="(promotion, index) in promotions" 
        :key="index" 
        class="promotion_item"
      >
        <PromotionComponent
          :title="promotion.title"
          :bgColor="promotion.color"
          :btn_color="promotion.buttonColor"
          :image_src="promotion.image"
        />
      </div>
    </div>

  </div>
</template>

<style scoped>
.container{
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.category_wrapper, .promotion_wrapper {
  display: flex;
  gap: 15px;
}

.category_item, .promotion_item {
  width: auto;
}
</style>
