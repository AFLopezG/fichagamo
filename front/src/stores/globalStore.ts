import { defineStore } from 'pinia'

export const globalStore = defineStore('global', {
  state: () => ({
    counter: 0,
    user: {},
    isLoggedIn: !!localStorage.getItem('tokenTicket'),
    booluser: false,
    boolcaja: false,
    boolSocket: false,
    }),
  getters: {
    doubleCount: (state) => state.counter * 2
  },
  actions: {
    increment () {
      this.counter++
    }
  }
})
