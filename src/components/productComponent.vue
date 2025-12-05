<template>
    <div class="product-card">
      <div class="discount-badge">
        -{{ promotionAsPercentage }}%
      </div>
      <div class="product-image-container">
        <img class="image" :src="`http://localhost:3000/${extract_img(image)}`" alt="product_image"/>
      </div>
      <div class="product-details">
        <h3 class="product-name">{{ name }}</h3>
        <div class="rating">
          <span class="rating-text">Rating: ({{ rating }})</span>
        </div>
        <p class="product-size">Weight: {{ size }}</p>
        <div class="price-and-quantity">
          <div class="price">
            <span>${{ price }}</span>
          </div>
          <div class="quantity-selector">
            <button v-on:click="decrease_amount">-</button>
            <span>{{ amount }}</span>
            <button v-on:click="increase_amount">+</button>
          </div>
        </div>
      </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

 const amount = ref(0);

//  default {

//   props:{
//     name: String,
//     rating: Number,
//     size: String,
//     image: String,
//     price: Number,
//     promotionAsPercentage: Number,
//     categoryId: Number,
//     inStock: Number,
//     countSold: Number,
//     group: String
//   },
// }

defineProps<{
  name: string;
  rating: number;
  size: string;
  image: string;
  price: number;
  promotionAsPercentage: number;
  categoryId: number;
  inStock: number;
  countSold: number;
  group: string;
}>();

 function increase_amount(){

  amount.value += 1;
}

function decrease_amount(){
  if (amount.value == 0){
    return;
  }
  amount.value -= 1;
}

function extract_img(input: string): string {
  const parts = input.replace('["', "").replace('"]', "").split('","');
  return parts[0]!;
}

</script>


  
  <style scoped>

  .product-card {
    font-family: Arial, sans-serif;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    width: 280px;
    height: 460px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: block;
    flex-direction: column;
  }
  
  .discount-badge {
    width: 80px;
    position: static;
    top: 15px;
    left: 0;
    background-color: #4CAF50;
    color: white;
    padding: 5px 10px;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    font-size: 0.9em;
    font-weight: bold;
  }

  .product-image-container{
    display: flex;
    justify-content: center;
    padding-bottom: 20px;
  }

  
  .image {

    height: 200px;
    width: 200px;
    object-fit: contain;
  }
  
  .product-details {
    padding: 15px;
  }
  
  .brand-name {
    color: #666;
    font-size: 0.85em;
    margin-bottom: 5px;
  }
  
  .product-name {
    color: #000000;
    font-size: 1.1em;
    font-weight: bold;
    margin-bottom: 10px;
    line-height: 1.3;
    height: 50px;
  }
  
  .rating {
    color: #000000;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  
  .star {
    color: #ccc;
    font-size: 1.1em;
    margin-right: 2px;
  }
  
  .star.filled {
    color: #FFC107;
  }
  
  .rating-text {
    color: #666;
    font-size: 0.85em;
  }
  
  .product-size {
    color: #888;
    font-size: 0.85em;
    margin-bottom: 15px;
  }
  
  .price-and-quantity {
    color: #000000;
    display: flex;
    justify-content: space-between;
    align-items: center;
  
  }
  
  .price {
    display: flex;
    align-items: baseline;
  }
  
  .current-price {
    font-size: 1.4em;
    font-weight: bold;
    color: #4CAF50; /* Green */
    margin-right: 8px;
  }
  
  .original-price {
    font-size: 0.9em;
    color: #999;
    text-decoration: line-through;
  }
  
  .quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    
  }
  
  .quantity-selector button {
    background-color: #f0f0f0;
    border: none;
    padding: 8px 12px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.2s;
  }
  
  .quantity-selector button:hover {
    background-color: #e0e0e0;
  }
  
  .quantity-selector span {
    padding: 0 15px;
    font-size: 1em;
    min-width: 20px;
    text-align: center;
  }
  </style>