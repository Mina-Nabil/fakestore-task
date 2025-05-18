<script setup lang="ts">
import ProductsList from '../components/ProductsList.vue'
import { useTitleStore } from '@/stores/titleStore'

const titleStore = useTitleStore()

titleStore.setTitle("Our Products")
</script>

<template>
  <ProductsList />
</template>
