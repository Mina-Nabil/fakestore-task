import axios, { type AxiosInstance } from 'axios'

let api: AxiosInstance

//helper function to create a new axios instance for api calls
export async function createApi() {
  // Here we set the base URL for all requests made to the api
  api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,

    // Uncomment this to use cookies for SPA Authentication
    // withCredentials: true,
  })
  return api
}

//singleton axios instance
export function useApi() {
  if (!api) {
    createApi()
  }
  // Uncomment this to use interceptors for api calls
  // api.interceptors.response.use((response) => response)
  return api
}
