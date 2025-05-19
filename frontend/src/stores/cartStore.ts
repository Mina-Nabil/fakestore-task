import { ref } from 'vue'
import { defineStore } from 'pinia'
import type { Product } from './productsStore'


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
  
  const setQuantity = (product: Product, quantity: number) => {
    const item = cart.value.find(item => item.product.id === product.id)
    if(item) {
      item.quantity = quantity
    } else {
      cart.value.push({ product, quantity: quantity })
    }
    saveCart()
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
    return cart.value.reduce((total, item) => total + item.product.price * item.quantity, 0).toFixed(2)
  }

  const getTotalQuantity = () => {
    return cart.value.reduce((total, item) => total + item.quantity, 0)
  }
  
  const saveCart = () => {
    localStorage.setItem('store-cart', JSON.stringify(cart.value))
    console.log('Cart saved')
    console.log(cart.value)
    console.log(localStorage.getItem('store-cart'))
  }

  return { cart, loadCart, setQuantity, addToCart, removeFromCart, clearCart, getTotalPrice, getTotalQuantity }
})
