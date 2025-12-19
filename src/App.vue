<template>
  <div>
    <MenuitemComponent />
    <hr>
    <LowerCategoryComponent />
    <hr>
    <router-view />
  </div>
</template>
<script lang="ts">
import MenuitemComponent from '@/components/menuitemComponent.vue'
import LowerCategoryComponent from '@/components/lowerCategoryComponent.vue'

export default {
  name: 'App',
  components: { LowerCategoryComponent, MenuitemComponent },
}
</script>
<style scoped>
  hr{
    margin-top:20px;
    margin-bottom: 20px;
  }
</style>
