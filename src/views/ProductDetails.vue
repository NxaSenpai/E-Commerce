<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

interface Product {
  id: number | string
  name?: string
  price?: number
  originalPrice?: number
  images?: string | string[]
  rating?: number
  countSold?: number
  inStock?: number
  description?: string
  vendor?: string
  sku?: string
}

const route = useRoute()
const router = useRouter()

const props = defineProps<{
  productId?: string | number
  productName?: string
}>()

const productId = props.productId ?? route.params.productId ?? null

const product = ref<Product | null>(null)
const images = ref<string[]>(['https://i.imgur.com/Lw7KZ4F.png'])
const activeImage = ref(images.value[0])
const quantity = ref(1)
const loading = ref(false)
const error = ref('')

function extract_img(input: unknown): string[] {
  if (!input) return []
  if (Array.isArray(input)) return input as string[]
  if (typeof input === 'string') {
    try {
      const parsed = JSON.parse(input)
      if (Array.isArray(parsed)) return parsed
    } catch {}
    return input.replace(/^\["|"\]$/g, '').split(/","|,/).map(s => s.replace(/^"|"$/g, '').trim())
  }
  return []
}

const currentPrice = computed(() => {
  if (!product.value) return '0.00'
  return (product.value.price ?? 0).toFixed(2)
})

const ratingStars = computed(() => {
  const r = Math.round(product.value?.rating ?? 5)
  return Array.from({ length: 5 }, (_, i) => i < r)
})

function increaseQty() { if ((product.value?.inStock ?? 99) > quantity.value) quantity.value++ }
function decreaseQty() { if (quantity.value > 1) quantity.value-- }

async function fetchProduct(id: string | number) {
  loading.value = true
  error.value = ''
  try {
    const res = await fetch(`http://localhost:3000/api/products/${id}`)
    if (!res.ok) {
      console.warn(`product fetch returned ${res.status}`)
      if (product.value) { loading.value = false; return }
      throw new Error(`Failed to fetch product ${id}`)
    }
    const data = await res.json()
    product.value = {
      id: data.id ?? id,
      name: data.name ?? data.title ?? props.productName ?? `Product ${id}`,
      price: data.price ?? data.currentPrice ?? data.salePrice ?? 0,
      originalPrice: data.originalPrice ?? undefined,
      images: data.image ?? data.images ?? data.imagesList ?? [],
      rating: data.rating ?? 0,
      countSold: data.countSold ?? data.sold ?? 0,
      inStock: data.inStock ?? data.stock ?? 0,
      description: data.description ?? ''
    }
    const imgs = extract_img(product.value.images)
    if (imgs.length) {
      images.value = imgs
      activeImage.value = imgs[0]
    } else {
      activeImage.value = images.value[0]
    }
  } catch (err: any) {
    if (!product.value) {
      error.value = err?.message ?? String(err)
      product.value = null
    } else {
      console.warn('Product fetch failed, using route-provided data', err)
    }
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  const q = route.query
  if (q.productName || q.price || q.image) {
    product.value = {
      id: productId ?? (q.productName ? `prefill-${String(q.productName)}` : '0'),
      name: String(q.productName ?? props.productName ?? ''),
      price: Number(q.price ?? 0),
      images: q.image ? String(q.image) : [],
    } as any
    const imgs = extract_img(product.value.images)
    if (imgs.length) {
      images.value = imgs
      activeImage.value = imgs[0]
    }
  }

  if (productId != null) {
    await fetchProduct(productId)
  } else {
    console.warn('no productId provided to ProductDetails')
    router.push({ name: 'HomePage' })
  }
})
</script>

<template>
  <div class="pd-container">
    <div v-if="loading" class="pd-loading">Loading product...</div>
    <div v-else-if="error" class="pd-error">{{ error }}</div>

    <div v-else-if="product" class="pd-grid">
      <div class="pd-left">
        <div class="pd-image-card">
          <img :src="activeImage" :alt="product.name" class="pd-main-img" />
          <div class="pd-thumbs">
            <img
              v-for="(img, i) in images"
              :key="img + i"
              :src="img"
              :class="{ active: img === activeImage }"
              @click="activeImage = img"
              class="pd-thumb"
              alt="thumb"
            />
          </div>
        </div>
      </div>

      <div class="pd-right">
        <div class="pd-badge-row">
          <span class="pd-stock" :class="{ out: (product.inStock ?? 0) === 1 }">
            {{ (product.inStock ?? 1) > 0 ? 'In stock' : 'Out of stock' }}
          </span>
          <span v-if="product.countSold" class="pd-sold">{{ product.countSold }} sold</span>
        </div>

        <h1 class="pd-title">{{ product.name }}</h1>

        <div class="pd-rating">
          <span v-for="(f, i) in ratingStars" :key="i" class="pd-star" :class="{ filled: f }">★</span>
          <span class="pd-rating-num">{{ product.rating ?? 5 }}</span>
        </div>

        <div class="pd-price-row">
          <div class="pd-price">${{ currentPrice }}</div>
          <div v-if="product.originalPrice" class="pd-original">${{ product.originalPrice.toFixed(2) }}</div>
        </div>

        <p class="pd-desc">{{ product.description || 'No description available.' }}</p>

        <div class="pd-actions">
          <div class="pd-qty">
            <button @click="decreaseQty" aria-label="Decrease">−</button>
            <div class="pd-qty-val">{{ quantity }}</div>
            <button @click="increaseQty" aria-label="Increase">+</button>
          </div>

          <button class="pd-add" :disabled="(product.inStock ?? 23512) === 0" @click.prevent="$emit?.('add-to-cart', { id: product.id, qty: quantity })">
            Add to cart
          </button>
        </div>

        <div class="pd-meta">
          <div><strong>SKU:</strong> {{ product.id }}</div>
          <p>Vender: NestMart</p>
        </div>
      </div>
    </div>

    <div v-else class="pd-empty">Product not found</div>
  </div>
</template>

<style scoped>
.pd-container { max-width: 1100px; margin: 28px auto; padding: 20px; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color: #0f172a; }
.pd-loading, .pd-error, .pd-empty { text-align:center; padding:40px 0; color:#6b7280 }

.pd-grid { display: grid; grid-template-columns: 1fr 430px; gap: 28px; align-items: start; }

.pd-image-card { background: #fff; border: 1px solid #e6e9ee; border-radius: 12px; padding: 18px; display:flex; flex-direction:column; gap:12px; justify-content:center; align-items:center; }
.pd-main-img { width:100%; height:420px; object-fit:contain; border-radius:8px; background: linear-gradient(180deg,#fafafa,#fff) }
.pd-thumbs { display:flex; gap:10px; margin-top:8px; flex-wrap:wrap; width:100%; justify-content:flex-start }
.pd-thumb { width:72px; height:72px; object-fit:cover; border-radius:8px; cursor:pointer; border:2px solid transparent; transition:transform .12s, border-color .12s; }
.pd-thumb.active { border-color:#10b981; transform:translateY(-3px) }

.pd-right { display:flex; flex-direction:column; gap:12px; padding:10px 6px; }
.pd-badge-row { display:flex; gap:10px; align-items:center; margin-bottom: 20px;}
.pd-stock { padding:6px 10px; border-radius:999px; background:#e8f7f0; color:#10b981; font-weight:600; font-size:13px }
.pd-stock.out { background:#fff0f0; color:#ef4444 }

.pd-title { margin:0; font-size:26px; line-height:1.15; color:#0b1220 }
.pd-rating { display:flex; align-items:center; gap:8px; color:#fbbf24; font-size:14px }
.pd-star { color:#e6e7eb; font-size:18px }
.pd-star.filled { color:#fbbf24; text-shadow:0 1px 0 rgba(0,0,0,0.06) }
.pd-rating-num { color:#6b7280; font-size:13px }

.pd-price-row { display:flex; align-items:baseline; gap:12px; margin-top:6px }
.pd-price { font-size:28px; color:#10b981; font-weight:800 }
.pd-original { color:#94a3b8; text-decoration:line-through; font-size:14px }

.pd-desc { color:#4b5563; margin-top:10px; line-height:1.5 }

.pd-actions { display:flex; gap:12px; align-items:center; margin-top:12px }
.pd-qty { display:flex; align-items:center; border:1px solid #e6eef1; border-radius:8px; overflow:hidden }
.pd-qty button { background:#fff; border:none; width:40px; height:40px; cursor:pointer; font-size:18px }
.pd-qty-val { width:48px; text-align:center; font-weight:700 }

.pd-add { background:#18a832; color:#fff; border:none; padding:10px 16px; border-radius:8px; font-weight:700; cursor:pointer; transition:background .12s }
.pd-add:hover { background:#10b981 }
.pd-add:disabled { opacity:.55; cursor:not-allowed }

.pd-meta { margin-top:18px; color:#6b7280; font-size:13px; gap:18px; flex-wrap:wrap;}
.pd-meta p { margin:10px 0 0 0; }

@media (max-width: 900px) {
  .pd-grid { grid-template-columns: 1fr; }
  .pd-main-img { height: 320px }
}
</style>
