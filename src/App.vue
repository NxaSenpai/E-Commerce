<script lang="ts">
import axios from 'axios'
export default{
  data() {
      return {
        promotions: [],
        categories: [],
        products: [] // changed from product -> products
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

    async fetchProducts(){
      try {
        const response = await axios.get('http://localhost:3000/api/products');
        this.products = response.data; // fixed: assign to products
        console.log(response.data);
      } catch (error) {
        console.log(error)
      }
    },

  },

  mounted() {
    // call all fetches
    this.fetchPromotions();
    this.fetchCategories();
    this.fetchProducts();
  }
}
</script>

<template>
  <div class="container">

    <MenuComponent/>

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

    <!-- Products -->

    <MenuComponent/>

    
    <div class="product_wrapper">
      <div
        v-for="(prod, index) in products"
        :key="index"
        class="product_item"
      >
        <ProductComponent
          :name="prod.name"
          :rating="prod.rating ?? 0"
          :size="prod.size ?? prod.weight ?? ''"
          :image="prod.image"
          :price="prod.price"
          :promotionAsPercentage="prod.promotionAsPercentage ?? prod.discountPercentage ?? 0"
          :categoryId="prod.categoryId"
          :inStock="prod.inStock"
          :countSold="prod.countSold"
          :group="prod.group"
        />
      </div>
    </div>

  </div>
</template>

<style>
body{
  background: white;
}
.container{

  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.category_wrapper, .promotion_wrapper {
  display: flex;
  gap: 15px;
  flex-wrap: nowrap;
}

.product_wrapper{
  display: flex;
  gap: 20px 10px;
  flex-wrap: wrap;
  justify-content: space-around;
}

.category_item, .promotion_item, .product_item {
  width: auto;
}
</style>