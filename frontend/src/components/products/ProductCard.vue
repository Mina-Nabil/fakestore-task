<script setup lang="ts">
import type { Product } from '@/stores/productsStore'
import type { PropType } from 'vue'
import { useCartStore } from '@/stores/cartStore'
import { ref } from 'vue'

const props = defineProps({
  product: { type: Object as PropType<Product>, required: true },
})

const cartStore = useCartStore()
const buttonText = ref('Add to Cart')

const addToCart = () => {
  cartStore.addToCart(props.product)
  buttonText.value = 'Added!'
  setTimeout(() => {
    buttonText.value = 'Add One More?'
  }, 2000)
}
</script>

<template>
  <div>
    <div class="ws-item-offer">
      <!-- Image -->
      <figure>
        <img :src="product.image" alt="Alternative Text" class="img-responsive" />
      </figure>
    </div>

    <div class="ws-works-caption text-center">
      <!-- Item Category -->
      <div class="ws-item-category">{{ product.category }}</div>

      <!-- Title -->
      <h3 class="ws-item-title">{{ product.title }}</h3>

      <div class="ws-item-separator"></div>

      <!-- Price -->
      <div class="ws-item-price">
        <ins>{{ product.price }} EUR</ins>
      </div>

      <!-- Add to Cart Button -->
      <button @click.prevent="addToCart" class="btn btn-sm add-to-cart-btn">
        {{ buttonText }}
      </button>
    </div>
  </div>
</template>

<style scoped>
.add-to-cart-btn {
  background-color: #c2a476;
  color: white;
  border: none;
  padding: 8px 20px;
  margin-top: 10px;
  transition: background-color 0.3s ease;
}

.add-to-cart-btn:hover {
  background-color: #ccb48e;
  color: white;
}
</style>
