import { defineStore } from 'pinia'
import { ref } from 'vue';

export const usePesananStore = defineStore('pesanan', () => {
  const statusPesanan = ref('CHECK')

  const setStatusPesanan = (value) => {
    statusPesanan.value = value
  }

  return { statusPesanan, setStatusPesanan }
});
