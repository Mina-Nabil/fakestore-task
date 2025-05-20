import { describe, it, expect, beforeEach, vi } from 'vitest'

import { useProductsStore } from '@/stores/productsStore'
import { setActivePinia, createPinia } from 'pinia'
import { ProductsListMock } from '../setup'


describe('ProductsStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('should fetch products', async () => {
    const productsStore = useProductsStore()
    await productsStore.fetchProducts()
    expect(productsStore.products.length).toBe(ProductsListMock.length)
  })

  it('should fetch products with loading state', async () => {
    const productsStore = useProductsStore()
    await productsStore.fetchProducts()
    expect(productsStore.loadingProducts).toBe(false)
  })



})
