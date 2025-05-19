<script setup lang="ts">
import CartDetails from '@/components/CartDetails.vue'
import { useTitleStore } from '@/stores/titleStore'

const titleStore = useTitleStore()

titleStore.setTitle("Cart")
</script>

<template>
  <CartDetails />
</template>
