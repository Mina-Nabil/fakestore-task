<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import { useTitleStore } from '@/stores/titleStore'

const titleStore = useTitleStore()
</script>

<template>
  <!-- Top Bar Start -->
  <div class="ws-topbar">
    <div class="pull-left">
      <div class="ws-topbar-message hidden-xs"></div>
    </div>

    <div class="pull-right">
      <!-- Shop Menu -->
      <ul class="ws-shop-menu">
        <!-- Cart -->
        <li class="ws-shop-cart">
          <a href="/cart" class="btn btn-sm cart-count">Cart (2)</a>

          <!-- Cart Popover -->
          <div class="ws-shop-minicart">
            <div class="minicart-content">
              <!-- Added Items -->
              <ul class="minicart-content-items clearfix"></ul>

              <!-- Subtotal -->
              <div class="minicart-content-total">
                <h3>Subtotal: 0</h3>
              </div>

              <!-- Checkout -->
              <div class="ws-shop-menu-checkout">
                <div class="ws-shop-viewcart pull-left">
                  <a href="/cart" class="btn btn-sm">View Cart</a>
                </div>
                <div class="ws-shop-checkout pull-right">
                  <a href="/checkout" class="btn btn-sm">Checkout</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Cart Popover -->
        </li>
      </ul>
    </div>
  </div>
  <!-- Top Bar End -->

  <header class="ws-header-static">
    <!-- Navbar -->
    <nav class="navbar ws-navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button
            type="button"
            class="navbar-toggle collapsed"
            data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1"
            aria-expanded="false"
          >
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Logo -->
        <div class="ws-logo ws-center">
          <img alt="Proxify Store" class="main-logo img-responsive" src="@/assets/images/logo.png" />
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-left">
            <li><RouterLink to="/">Shop</RouterLink></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><RouterLink to="/cart">Cart</RouterLink></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->
  </header>

  <div>
    <div
      class="ws-parallax-header parallax-window"
      data-parallax="scroll"
      data-image-src="https://picsum.photos/200/300"
    >
      <div class="ws-overlay">
        <div class="ws-parallax-caption">
          <div class="ws-parallax-holder">
            <h1>{{ titleStore.title }}</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container ws-page-container">
      <div class="row">
        <div class="ws-shop-page">
          <RouterView />
        </div>
      </div>
    </div>
  </div>
  <!-- Footer Bar Start -->
  <div class="ws-footer-bar">
    <div class="container">
      <!-- Copyright -->

        <p>Handcrafted with love &copy; 2025 All rights reserved.</p>


      <!-- Payments -->
    </div>
  </div>
  <!-- Footer Bar End -->
</template>
