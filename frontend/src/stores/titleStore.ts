import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useTitleStore = defineStore('pageTitle', () => {
  const title = ref("Proxify Store")

  function setTitle(newTitle: string) {
    title.value = newTitle
  }

  return { title, setTitle }
})
