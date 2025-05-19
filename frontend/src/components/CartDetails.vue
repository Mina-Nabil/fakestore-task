<script setup lang="ts">
import { formatFloatNumber } from '@/helpers/misc'
import { useCartStore } from '@/stores/cartStore'
import { watch } from 'vue'

const cartStore = useCartStore()
watch(cartStore.cart, (newCart) => {
  newCart.forEach((item) => {
    item.quantity = Math.round(item.quantity)
  })
  cartStore.saveCart()
})
</script>

<template>
  <div class="container ws-page-container">
    <!-- Page Content -->
    <div class="row">
      <!-- Cart Content -->
      <div class="ws-cart-page">
        <div class="col-sm-8">
          <div class="ws-mycart-content">
            <table class="table">
              <thead>
                <tr>
                  <th class="cart-item-head">&nbsp;</th>
                  <th class="cart-item-head">Item</th>
                  <th class="cart-item-head">Price</th>
                  <th class="cart-item-head">Quantity</th>
                  <th class="cart-item-head">Total</th>
                  <th class="cart-item-head">&nbsp;</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="item in cartStore.cart" class="cart-item">
                  <td class="cart-item-cell cart-item-thumb">
                    <img :src="item.product.image" class="img-responsive" alt="Alternative Text" />
                  </td>
                  <td class="cart-item-cell cart-item-title">
                    <h3>{{ item.product.title }}</h3>
                  </td>
                  <td class="cart-item-cell cart-item-price">
                    <span class="amount">{{ formatFloatNumber(item.product.price) }}</span>
                  </td>
                  <td class="cart-item-cell cart-item-quantity">
                    <input type="number" v-model.number="item.quantity" step="1" min="0" />
                  </td>
                  <td class="cart-item-cell cart-item-subtotal">
                    <span class="amount">{{ formatFloatNumber(item.product.price * item.quantity) }} EUR</span>
                  </td>
                  <td
                    class="cart-item-cell cart-item-remove"
                    @click="cartStore.removeFromCart(item.product)"
                  >
                    <span><i class="far fa-times-circle"></i></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Cart Total -->
        <div class="col-sm-4">
          <div class="ws-mycart-total">
            <h2>Cart Totals</h2>
            <table>
              <tbody>
                <tr class="cart-subtotal">
                  <th>Subtotal</th>
                  <td>
                    <span class="amount">{{ cartStore.getTotalPriceFormatted() }} EUR</span>
                  </td>
                </tr>
                <tr class="cart-subtotal">
                  <th>Delivery</th>
                  <td>
                    <span class="amount">50 EUR</span>
                  </td>
                </tr>
                <tr class="order-total">
                  <th>Total</th>
                  <td>
                    <strong
                      ><span class="amount">{{ formatFloatNumber(cartStore.getTotalPrice() + 50) }} EUR</span></strong
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <a class="btn ws-btn-fullwidth" href="#">Check Out</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Content -->
  </div>
</template>
