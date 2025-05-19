<script setup lang="ts">
import CartDetails from '@/components/CartDetails.vue'
import ProductsList from '../components/ProductsList.vue'
import { useTitleStore } from '@/stores/titleStore'

const titleStore = useTitleStore()

titleStore.setTitle("Checkout")
</script>

<template>
  <CartDetails />
</template>
