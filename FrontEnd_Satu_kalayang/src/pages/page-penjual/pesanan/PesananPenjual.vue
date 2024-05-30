<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <q-page>
    <div class="q-pa-md">
      <q-card flat bordered>
        <q-card-section>
          <div class="row items-center">
            <div class="col text-bold">
              Status
            </div>
            <div class="col text-right">
              <q-chip v-if="statusPesanan == 'CHECK'" color="warning" text-color="white" icon="las la-hourglass-half" style="font-size: small;">
                Menunggu Konfirmasi
              </q-chip>
              <q-chip v-else-if="statusPesanan == 'PROSESS'" color="info" text-color="white" icon="las la-hourglass-half" style="font-size: small;">
                Pesanan di proses
              </q-chip>
              <q-chip v-else-if="statusPesanan == 'ditolak'" color="negative" text-color="white" icon="las la-times" style="font-size: small;">
                Pesanan di ditolak
              </q-chip>
              <q-chip v-else color="positive" text-color="white" icon="las la-check" style="font-size: small;">
                Pesanan Selesai
              </q-chip>
            </div>
          </div>
        </q-card-section>

        <q-card-section>
          <q-markup-table flat>
            <thead>
              <tr>
                <th class="text-left">Pesanan</th>
                <th class="text-left">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in rows" v-bind:key="row.pesanan">
                <td>{{ row.pesanan }}</td>
                <td>{{ row.quantity }}</td>
                <td>Rp {{ toRupiah(row.price) }}</td>
                <td>Rp {{ toRupiah(row.total) }}</td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>

        <q-card-section>
          <div class="row">
            <div class="col text-bold">
              Total yang harus dibayar
            </div>
            <div class="col text-right text-bold">
              Rp {{ toRupiah(total) }}
            </div>
          </div>
        </q-card-section>
        <q-card-section>
          <div class="row">
            <div class="col text-right">
              <q-btn flat color="negative" label="Tolak Pesanan" @click="onCancel" />
            </div>
            <div class="col text-right text-bold">
              <q-btn
                color="primary"
                :label="statusPesanan == 'CHECK' ? 'Terima Pesanan' : 'Pesanan diantar'"
                @click="onProses"
              />
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import HeaderCreate from "components/HeaderCreate.vue"
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { toRupiah } from 'src/libs/currency'
import { usePesananStore } from 'src/stores/pesanan-store';

defineOptions({
  name: 'DetailRekap'
});

const pesananStore = usePesananStore()
const resultData = ref({})
const rows = ref([
  { pesanan: 'Pesanan 1', quantity: 1, total: 10000, price: 10000 },
  { pesanan: 'Pesanan 2', quantity: 2, total: 20000, price: 10000 },
  { pesanan: 'Pesanan 3', quantity: 4, total: 40000, price: 15000 },
])

const total = computed(() => rows.value.reduce((a, b) => a + b.price, 0))

const statusPesanan = computed(() => {
  return pesananStore.statusPesanan
})

const getData = async () => {
  try {
    showLoading()
    setTimeout(() => hideLoading(), 2000)

  } catch (error) {
    console.log(error)
  }
}

const onProses = async () => {
  try {
    /*
    * set status pesanan.
    * update status transaksi ke be.
    * ini hanya contoh.
    */
    pesananStore.setStatusPesanan('PROSESS')
  } catch (error) {
    console.log(error)
  }
}

const onCancel = async () => {
  try {
    rows.value = []
    statusPesanan.value = 'ditolak'
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})


</script>
