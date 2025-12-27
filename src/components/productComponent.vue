<template>
  <button class="product-card" type="button" @click="onProductClick">
    <div v-if="promotionAsPercentage > 0" class="discount-badge">-{{ promotionAsPercentage }}%</div>
    <div v-if="inStock === 0" class="stock-badge out">Out of stock</div>
    <div v-else class="stock-badge in">In stock: {{ inStock }}</div>

    <div class="product-image-container">
      <img class="image" :src="`http://localhost:3000/${extract_img(image)}`" alt="product_image" />
    </div>

    <div class="product-details">
      <h3 class="product-name">{{ name }}</h3>

      <div class="rating">
        <div class="stars">
          <span
            v-for="(filled, i) in stars"
            :key="i"
            class="star"
            :class="{ filled }"
            aria-hidden="true"
          >★</span>
        </div>
        <span class="rating-text">{{ rating }} • {{ countSoldText }}</span>
      </div>

      <p class="product-size">Weight: {{ size || '—' }}</p>

      <div class="price-and-quantity">
        <div class="price">
          <span class="current-price">${{ currentPrice }}</span>
          <span v-if="promotionAsPercentage > 0" class="original-price">${{ price }}</span>
        </div>

        <div class="quantity-and-add">
          <div class="quantity-selector">
            <button v-on:click.stop="decrease_amount" aria-label="Decrease">−</button>
            <span>{{ amount }}</span>
            <button v-on:click.stop="increase_amount" aria-label="Increase">+</button>
          </div>
          <button class="add-to-cart" type="button" @click.stop="addToCart" :disabled="inStock === 0">
            Add
          </button>
        </div>
      </div>
    </div>
  </button>
</template>

<script setup lang="ts">
import { ref, toRefs, computed } from 'vue'
import { useRouter } from 'vue-router'

const amount = ref(0)

const props = defineProps<{
  name: string
  rating: number
  size: string
  image: string
  price: number
  promotionAsPercentage: number
  categoryId: number
  inStock: number
  countSold: number
  group: string
  prod_id: number | string
}>()

const { name, rating, size, image, price, promotionAsPercentage, prod_id, inStock, countSold } = toRefs(props)

const router = useRouter()

async function onProductClick() {
  if (prod_id.value === undefined || prod_id.value === null) {
    console.warn('product id is missing; navigation aborted')
    return
  }

  await router.push({
    name: 'ProductDetails',
    params: { productId: String(prod_id.value) },
    query: {
      productName: String(name?.value ?? ''),
      price: String(currentPrice.value ?? ''),
      image: `http://localhost:3000/${extract_img(String(image?.value ?? ''))}`,
    },
  })
}

function increase_amount() {
  const max = Number(inStock?.value ?? 99)
  if (amount.value < max) amount.value += 1
}

function decrease_amount() {
  if (amount.value === 0) return
  amount.value -= 1
}

function extract_img(input: string): string {
  const parts = input?.replace('["', '').replace('"]', '').split('","') ?? []
  return parts[0] ?? ''
}

const currentPrice = computed(() => {
  const p = Number(price?.value ?? 0)
  const disc = Number(promotionAsPercentage?.value ?? 0)
  return (p * (1 - disc / 100)).toFixed(2)
})

const stars = computed(() => {
  const val = Math.round(Number(rating?.value ?? 0))
  return Array.from({ length: 5 }, (_, i) => i < val)
})

const countSoldText = computed(() => {
  const cs = Number(countSold?.value ?? 0)
  return cs > 0 ? `${cs} sold` : 'New'
})

function addToCart() {
  if (inStock?.value === 0) {
    console.warn('Cannot add out of stock product')
    return
  }

  console.log(`Added ${amount.value || 1} of ${prod_id.value} to cart`)
  if (amount.value === 0) amount.value = 1
}
</script>

<style scoped>
.product-card {
  font-family: Inter, Arial, sans-serif;
  border: 1px solid #ececec;
  border-radius: 12px;
  width: 270px;
  background-color: #ffffff;
  box-shadow: 0 6px 18px rgba(20, 20, 20, 0.06);
  display: flex;
  flex-direction: column;
  position: relative;
  padding: 12px;
  transition: transform 0.18s ease, box-shadow 0.18s ease;
  overflow: hidden;
  height: 350px;
}

.product-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 12px 30px rgba(20, 20, 20, 0.12);
  cursor: pointer;
}

.discount-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background-color: #e53935;
  color: #fff;
  padding: 6px 8px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 0.85em;
  z-index: 3;
}

.stock-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 6px 8px;
  border-radius: 8px;
  font-size: 0.8em;
  font-weight: 600;
  z-index: 3;
}

.stock-badge.in {
  background: #e6f4ea;
  color: #2d7a36;
}

.stock-badge.out {
  background: #fff0f0;
  color: #9b1c1c;
}

.product-image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 12px 0;
  background: linear-gradient(180deg, #fafafa 0%, #fff 100%);
  border-radius: 8px;
  min-height: 180px;
}

.image {
  max-height: 170px;
  max-width: 170px;
  object-fit: contain;
}

.product-details {
  padding-top: 10px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.product-name {
  text-align: left;
  color: #111827;
  font-size: 1.05em;
  font-weight: 700;
  margin: 0;
  line-height: 1.25;
  max-height: 2.5em;
  overflow: hidden;
  text-overflow: ellipsis;
}

.rating {
  margin-top: 10px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.stars {
  display: flex;
  gap: 3px;
  align-items: center;
}

.star {
  color: #d1d5db;
  font-size: 0.95em;
  line-height: 1;
}

.star.filled {
  color: #fbbf24;
  text-shadow: 0 1px 0 rgba(0,0,0,0.08);
}

.rating-text {
  color: #6b7280;
  font-size: 0.85em;
}

.product-size {
  color: #6b7280;
  font-size: 0.85em;
  margin-right: 155px;
}

.price-and-quantity {
  color: #000000;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 6px;
}

.price {
  display: flex;
  align-items: baseline;
  gap: 8px;
}

.current-price {
  font-size: 1.25em;
  font-weight: 800;
  color: #10b981;
}

.original-price {
  font-size: 0.9em;
  color: #9ca3af;
  text-decoration: line-through;
}

.quantity-and-add {
  display: flex;
  gap: 8px;
  align-items: center;
}

.quantity-selector {
  display: flex;
  align-items: center;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  overflow: hidden;
  background: #fff;
}

.quantity-selector button {
  background-color: #f8fafc;
  border: none;
  padding: 6px 10px;
  font-size: 1em;
  cursor: pointer;
}

.quantity-selector button:hover {
  background-color: #f1f5f9;
}

.quantity-selector span {
  padding: 0 10px;
  font-size: 0.95em;
  min-width: 22px;
  text-align: center;
}

.add-to-cart {
  background: #17ab23;
  color: #fff;
  border: none;
  padding: 8px 10px;
  border-radius: 6px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.12s ease;
}

.add-to-cart:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.add-to-cart:hover{
  background: #10b981;
}

</style>
