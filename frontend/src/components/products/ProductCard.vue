<script setup lang="ts">
import type { Product } from '@/stores/productsStore';
import type { PropType } from 'vue';

defineProps({
  product: { type: Object as PropType<Product>, required: true },
})
</script>

<template>
  <div>
    <a :href="`/product/${product.id}`">
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
          <ins>{{ product.price }}</ins>
        </div>
      </div>
    </a>
  </div>
</template>
