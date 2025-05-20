import { describe, it, expect, beforeEach, vi } from 'vitest'
import { useCartStore } from '@/stores/cartStore'
import { setActivePinia, createPinia } from 'pinia'


describe('CartStore', () => {

  

  beforeEach(() => {
    setActivePinia(createPinia())
    // Clear localStorage before each test
    localStorage.clear()
    // Clear all mocks before each test
    vi.clearAllMocks()
  })

  it('should add an item to the cart', () => {
    const cartStore = useCartStore()
    cartStore.addToCart({ id: 1, name: 'Test Product', price: 10 })
    expect(cartStore.cart.length).toBe(1)
  })

  it('should remove an item from the cart', () => {
    const cartStore = useCartStore()
    cartStore.addToCart({ id: 1, name: 'Test Product', price: 10 })
    cartStore.removeFromCart({ id: 1 })
    expect(cartStore.cart.length).toBe(0)
  })

  it('should get the total price of the cart', () => {
    const cartStore = useCartStore()
    var totalPrice = 0
    for(let i = 0; i < 10; i++) {
      const tempPrice = Math.random() * 100
      cartStore.addToCart({ id: i, name: `Test Product ${i}`, price: tempPrice })
      totalPrice += tempPrice
    }
    expect(cartStore.getTotalPrice()).toBe(totalPrice)
  })
  
  it('should get the total price of the cart formatted', () => {
    const cartStore = useCartStore()
    var totalPrice = 0
    for(let i = 0; i < 10; i++) {
      const tempPrice = Math.random() * 100
      cartStore.addToCart({ id: i, name: `Test Product ${i}`, price: tempPrice })
      totalPrice += tempPrice
    }
    expect(cartStore.getTotalPriceFormatted()).toBe(totalPrice.toFixed(2))
  })

  it('should persist cart data after page reload', () => {
    // First store instance (before reload)
    const cartStore = useCartStore()
    
    // Add items to cart
    for(let i = 0; i < 10; i++) {
      cartStore.addToCart({ id: i, name: `Test Product ${i}`, price: 10 })
    }

    // Create a new store instance to simulate page reload
    const newCartStore = useCartStore()
    newCartStore.loadCart()

    expect(newCartStore.getTotalQuantity()).toBe(10)
  })

  it('should add an item to the cart', () => {
    const cartStore = useCartStore()
    cartStore.addToCart({ id: 1, name: 'Test Product', price: 10 })
    expect(cartStore.cart.length).toBe(1)
  })

  it('should clear the cart', () => {
    const cartStore = useCartStore()
    cartStore.addToCart({ id: 1, name: 'Test Product', price: 10 })
    cartStore.clearCart()
    expect(cartStore.cart.length).toBe(0)
  })
})
