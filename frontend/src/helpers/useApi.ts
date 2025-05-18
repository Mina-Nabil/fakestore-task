import axios, { type AxiosInstance } from 'axios'

let api: AxiosInstance

export async function createApi() {
  // Here we set the base URL for all requests made to the api
  api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,

  })

  // We are using Laravel SPA Authentication which uses a stronger authentication system
  // Using Cookies and Sessions

  // The following code would be used to authorize using tokens instead of sessions
  // We set an interceptor for each request to
  // include Bearer token to the request if user is logged in
  // api.interceptors.request.use((config) => {
  //   const userSession = useUserSession()

  //   if (userSession.isLoggedIn) {
  //     config.headers = {
  //       ...config.headers,
  //       Authorization: `Bearer ${userSession.token}`,
  //     }
  //   }

  //   return config
  // })
  return api
}

//singleton axios instance
export function useApi() {
  if (!api) {
    createApi()
  }
  api.interceptors.response.use((response) => response)
  return api
}
