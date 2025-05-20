import { ref } from 'vue'
import { defineStore } from 'pinia'
import type { Product } from './productsStore'
import { formatFloatNumber } from '@/helpers/misc'


export interface CartItem {
  product: Product
  quantity: number
}

export const useCartStore = defineStore('cartStore', () => {
  const cart = ref<CartItem[]>([])

  const loadCart = async () => {
    if( localStorage.getItem('store-cart') ) {
        const data = JSON.parse(localStorage.getItem('store-cart') || '[]')
        cart.value = data
    }
    else {
       cart.value = []
    }
  }
  
  const addToCart = (product: Product, quantity: number = 1) => {
    const item = cart.value.find(item => item.product.id === product.id)
    if(item) {
      item.quantity += quantity
    }
    else {
      cart.value.push({ product, quantity: quantity })
    }
    saveCart()
  }

  const removeFromCart = (product: Product) => {
    cart.value = cart.value.filter(item => item.product.id !== product.id)
    saveCart()
  }

  const clearCart = () => {
    cart.value = []
    saveCart()
  }

  const getTotalPrice = () => {
    return cart.value.reduce((total, item) => (total + item.product.price * item.quantity), 0)
  }

  const getTotalQuantity = () => {
    return cart.value.reduce((total, item) => total + item.quantity, 0)
  }
  
  const saveCart = () => {
    localStorage.setItem('store-cart', JSON.stringify(cart.value))
  }

  const getTotalPriceFormatted = () => {
    return formatFloatNumber(getTotalPrice())
  }

  return { cart, loadCart, saveCart, addToCart, removeFromCart, clearCart, getTotalPrice, getTotalQuantity, getTotalPriceFormatted }
})
