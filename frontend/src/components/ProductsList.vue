<script setup lang="ts">
import { useProductsStore } from '@/stores/productsStore'
import { computed, onMounted, ref } from 'vue'
import ProductCard from './products/ProductCard.vue'

const productsStore = useProductsStore()

onMounted(async () => {
  await productsStore.fetchProducts()
})

///categories controls
const categories = computed(
  () => new Set(productsStore.products.map((product) => product.category)),
)
const selectedCategory = ref('all')

///products controls
const filteredProducts = computed(() => {
  if (selectedCategory.value == 'all') {
    return productsStore.products
  }
  return productsStore.products.filter((product) => product.category === selectedCategory.value)
})

const productsCategoryFilter = (category: string) => {
  if (category == 'all') {
    return productsStore.products
  }
  return productsStore.products.filter((product) => product.category === category)
}
</script>

<template>
  <div>
    <!-- Categories Nav -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation">
        <a @click="selectedCategory = 'all'"> All ({{ productsStore.products.length }})</a>
      </li>
      <li
        role="presentation"
        v-for="category in categories"
        :key="category"
        :class="{ active: category === selectedCategory }"
      >
        <a @click="selectedCategory = category">
          {{ category }} ({{ productsCategoryFilter(category).length }})
        </a>
      </li>
    </ul>

    <!-- Categories Content -->
    <div class="tab-content">
        <div class="row">
          <ProductCard
            v-for="product in filteredProducts"
            :key="product.id"
            class="col-sm-6 col-md-4 ws-works-item"
            :product="product"
          />
      </div>
    </div>
  </div>
</template>
