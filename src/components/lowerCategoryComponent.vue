<script setup lang="ts">
</script>

<template>
  <div class="wrapper">
    <select name="categoryChoose" id="categoryChoose" class ="option-category">
      <option value="all-category">Browse All Categories</option>
      <option value="cake-milk">Cake & Milk</option>
      <option value="peach">Peach</option>
      <option value="kiwi">Organic Kiwi</option>
      <option value="red-apple">Red Apple</option>
      <option value="snack">Snack</option>
      <option value="black-plum">Black Plum</option>
      <option value="vegetables">Vegetables</option>
      <option value="headphone">Headphone</option>
      <option value="orange">Orange</option>
    </select>

    <button class="button" type="button"><img class="hoticon" src="/image/hotdeals.png">Hot Deals</button>
    <button class="button" type="button">Home</button>
    <button class="button" type="button">Food</button>
    <button class="button" type="button">Vegetable</button>
    <button class="button" type="button">Drink</button>
    <button class="button" type="button">Cookies</button>
    <button class="button" type="button">Meat & Seafood</button>
    <button class="button" type="button">Bakery</button>

    <img class="hotlineicon" src="/image/hotline.png" alt="">
  </div>
</template>

<style scoped>
.wrapper {
  display: flex;
  width: 100%;
  gap: 20px;
}
.option-category {
  height: 40px;
  color: white;
  background: #21ba53;
  border: none;
  border-radius: 5px;
  padding: 5px 10px;
  font-size: 16px;
}

.button{
  display: flex;
  align-items: center;
  background: none;
  color: black;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  font-size: 16px;
  cursor: pointer;
}

.button:hover{
  background-color: #f0f0f0;
}

.hoticon{
  width: 15px;
  margin-right: 10px;
}

.hotlineicon{
  margin-left: auto;
  width: 170px;
}

</style>
