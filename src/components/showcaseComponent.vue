<script setup lang="ts">
import { useRouter } from 'vue-router'
const router = useRouter()

function goToCategory(){
  router.push('/category')
}

</script>

<template>
  <div class="showcase-wrapper">
    <div class="text-wrapper">
      <h1 class="label1">Don't miss amazing <br> grocery deals</h1>
      <h1 class="lower-text">Sign up for the daily newsletter</h1>
      <div class="sign-background">
        <img class="sendicon" src="/image/send.png" alt="">
        <input type="text" class="sign-input" placeholder="Your email address">
          <button class="sign-button" type="button" @click="goToCategory">Subscribe</button>
      </div>
    </div>
    <img class="showcaseimage" src="/image/showcase1.png" alt="">
  </div>
</template>

<style scoped>

.showcase-wrapper {
  display: flex;
  background-color: #fff7d2;
  width: 100%;
  height: 450px;
  border-radius: 10px;
  align-items: center;
}

.text-wrapper{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  height: 100%;
  margin-left: 70px;
}

.label1{
  color:black;
  font-weight: bold;
  font-size: 40px;
  margin-bottom: 30px;
}

.lower-text{
  font-size: 20px;
  color: #656565;
}

.showcaseimage{
  margin-left: auto;
  width: 54%;
}

.sendicon{
  width: 15px;
  margin-right: 10px;
}

.sign-background{
  padding-left: 10px;
  height: 40px;
  width: 350px;
  display: flex;
  align-items: center;
  margin-top: 40px;
  background-color: #ffffff;
  border-radius: 20px;
}

.sign-input {
  width: 200px;
  border: none;
}

.sign-button{
  margin-left: auto;
  font-weight: bold;
  color: white;
  background-color: #13c86e;
  width: 100px;
  height: 40px;
  border-radius: 20px;
  border: none;
  cursor: pointer;
}

.sign-button:hover{
  background-color: #0fa859;
}


</style>
