import { describe, beforeEach, vi, expect, it } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductsList from '@/components/ProductsList.vue'
import { createPinia } from 'pinia'
import { ProductsListMock, CategoriesMock } from '../setup'


describe('ProductsList.vue', () => {
  let wrapper

  beforeEach(() => {
    wrapper = mount(ProductsList, {
      global: {
        plugins: [createPinia()],
      },
    })
  })

  it('should render all categories including "All"', () => {
    const categoryElements = wrapper.findAll("li[role='presentation']")

    // Check if "All" category is present
    expect(categoryElements[0].text()).toContain('All')

    // Check if all unique categories are rendered
    CategoriesMock.forEach((category, index) => {
      expect(categoryElements[index + 1].text()).toContain(category)
    })
  })

  it('should show correct product count next to each category', () => {
    const categoryElements = wrapper.findAll("li[role='presentation']")

    // Check "All" category count
    expect(categoryElements[0].text()).toContain(`(${ProductsListMock.length})`)

    // Check each category count
    CategoriesMock.forEach((category, index) => {
      expect(categoryElements[index + 1].text()).toContain(
        `(${ProductsListMock.filter((product) => product.category === category).length})`,
      )
    })
  })

  it('should filter products when category is selected', async () => {
    // Click on All category (index 0)
    await wrapper.findAll("li[role='presentation']")[0].find('a').trigger('click')
    // Check if all products are shown
    expect(wrapper.findAll('.ws-works-item').length).toBe(ProductsListMock.length)

    // Click on each category after all (index 0 is all)
    for (let i = 1; i < CategoriesMock.length; i++) {
      await wrapper.findAll("li[role='presentation']")[i].find('a').trigger('click')
      // Check if only selected category products are shown
      const productCardsLength = wrapper.findAll('.ws-works-item').length
      const expectedLength = ProductsListMock.filter(
        //categories i - 1 because index 0 is all
        (product) => product.category === CategoriesMock[i-1],
      ).length

      expect(productCardsLength).toBe(expectedLength)
    }
  })
})
