import { vi } from 'vitest'

export const ProductsListMock = [
  { id: 1, title: 'Product 1', price: 120, category: 'Category 1', image: 'Image 1' },
  { id: 2, title: 'Product 2', price: 15, category: 'Category 2', image: 'Image 2' },
  { id: 3, title: 'Product 3', price: 10, category: 'Category 1', image: 'Image 3' },
  { id: 4, title: 'Product 4', price: 12.5, category: 'Category 1', image: 'Image 4' },
  { id: 5, title: 'Product 5', price: 64.5, category: 'Category 2', image: 'Image 5' },
  { id: 6, title: 'Product 6', price: 66.3, category: 'Category 3', image: 'Image 6' },
  { id: 7, title: 'Product 7', price: 98, category: 'Category 2', image: 'Image 7' },
  { id: 8, title: 'Product 8', price: 120.8, category: 'Category 3', image: 'Image 8' },
  { id: 9, title: 'Product 9', price: 808.6, category: 'Category 1', image: 'Image 9' },
  { id: 10, title: 'Product 10', price: 120.5, category: 'Category 1', image: 'Image 10' },
  { id: 11, title: 'Product 11', price: 90, category: 'Category 2', image: 'Image 11' },
  { id: 12, title: 'Product 12', price: 100, category: 'Category 3', image: 'Image 12' },
]

export const CategoriesMock = [...new Set(ProductsListMock.map((product) => product.category))]

// Mock the products api fetch
vi.mock('@/helpers/useApi', () => ({
  useApi: () => ({
    get: vi.fn().mockResolvedValue({
      data: {
        data: ProductsListMock,
      },
    }),
  }),
}))


