import { describe, beforeEach, vi, expect, it } from 'vitest'
import { mount } from '@vue/test-utils'
import CartDetails from '@/components/CartDetails.vue'
import { useCartStore } from '@/stores/cartStore'
import { createPinia, setActivePinia } from 'pinia'
import { CategoriesMock, ProductsListMock } from '../setup'
import ProductsList from '@/components/ProductsList.vue'

describe('CartDetails.vue', () => {
  let wrapper
  let productsListWrapper

  beforeEach(() => {
    setActivePinia(createPinia())
    productsListWrapper = mount(ProductsList)

    wrapper = mount(CartDetails)

    // Clear localStorage before each test
    localStorage.clear()
    // Clear all mocks before each test
    vi.clearAllMocks()
  })

  it('should render cart details for all products', async () => {
    //add all products to cart from products list page
    for (let i = 0; i < ProductsListMock.length; i++) {
      await productsListWrapper.findAll('.ws-works-item')[i].find('button').trigger('click')
    }

    // Check if all items are rendered on cart details page
    const renderedCartItems = wrapper.findAll('.cart-item')
    expect(renderedCartItems.length).toBe(ProductsListMock.length)
  })

  it('should render one cart item for only one product', async () => {
    //add one product to cart from products list page
    await productsListWrapper.findAll('.ws-works-item')[0].find('button').trigger('click')

    // Check if one item is rendered on cart details page
    const renderedCartItems = wrapper.findAll('.cart-item')
    expect(renderedCartItems.length).toBe(1)
  })

  it('should render all products added from one category', async () => {
    //picking random category each time
    const randomCategoryIndex = Math.floor(Math.random() * CategoriesMock.length)
    //length of products in the category
    const categoryProductsLength = ProductsListMock.filter(
      (product) => product.category === CategoriesMock[randomCategoryIndex],
    ).length

    //add all products from one category to cart from products list page by switching category tab
    await productsListWrapper.findAll('li[role="presentation"]')[randomCategoryIndex + 1].find('a').trigger('click')

    //add all shown products
    const productsToAdd = productsListWrapper.findAll('.ws-works-item')
    for (let i = 0; i < productsToAdd.length; i++) {
      await productsToAdd[i].find('button').trigger('click')
    }

    // Check if all items are rendered on cart details page
    const renderedCartItems = wrapper.findAll('.cart-item')
    expect(renderedCartItems.length).toBe(categoryProductsLength)
  })

  it('should delete item from cart when delete button is clicked', async () => {
    //add all products to cart from products list page
    for (let i = 0; i < ProductsListMock.length; i++) {
      await productsListWrapper.findAll('.ws-works-item')[i].find('button').trigger('click')
    }

    //add one product to cart from products list page
    await wrapper.findAll('.cart-item-remove')[0].trigger('click')

    // Check if one item is removed from cart
    expect(wrapper.findAll('.cart-item').length).toBe(ProductsListMock.length - 1)
  })

  //check cart sum is correct
  it('should show the correct cart sum', async () => {
    //add all products to cart from products list page
    for (let i = 0; i < ProductsListMock.length; i++) {
      const randomQuantity = Math.floor(Math.random() * 2)
      for (let j = 0; j < randomQuantity; j++) {
        await productsListWrapper.findAll('.ws-works-item')[i].find('button').trigger('click')
      }
    }
    
    const cartStore = useCartStore()
    const cartSum = cartStore.getTotalPrice()

    // Check if cart sum is correct
    const cartSumElement = wrapper.find('.cart-subtotal').text()
    expect(cartSumElement).toContain(cartSum.toFixed(2))
  })
})
