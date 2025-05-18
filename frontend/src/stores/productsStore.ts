import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useApi } from '@/helpers/useApi'

export interface Product {
  id: number
  title: string
  price: number
  image: string
  description: string
  category: string
  created_at: string
  updated_at: string
}

export const useProductsStore = defineStore('productsStore', () => {
  const products = ref<Product[]>([])
  const loadingProducts = ref(false)

  const fetchProducts = async () => {
    loadingProducts.value = true
    const response = await useApi().get('/products')
    loadingProducts.value = false
    products.value = response.data
  }

  return { products, fetchProducts, loadingProducts }
})
