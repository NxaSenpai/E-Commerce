import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/views/HomePage.vue'
import CategoryView from '@/views/CategoryView.vue'
import ProductDetails from '@/views/ProductDetails.vue'

const routes = [
  {
    path: '/',
    name: 'HomePage',
    component: HomePage,
  },
  {
    path: '/category/:categoryId',
    name: 'CategoryView',
    component: CategoryView,
    props: route => ({
      categoryId: route.params.categoryId,
      categoryName: route.params.categoryName || '',
    }),
  },

  {
    path: '/productdetails/:productId',
    name: 'ProductDetails',
    component: ProductDetails,
    props: route => ({
      productId: route.params.productId,
      productName: route.params.productName || '',
    }),
  },

]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
