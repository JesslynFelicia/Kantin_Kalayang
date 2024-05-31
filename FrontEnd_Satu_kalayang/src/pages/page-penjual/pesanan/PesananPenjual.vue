<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <q-page>
    <div class="q-pa-md">
      <!-- <q-card flat bordered v-for="[key, value] of Object.entries(resultData)" v-bind:key="key" class="q-mb-md"> -->
      <q-card flat bordered v-for="result in resultData" v-bind:key="result.id_transaksi" class="q-mb-md">
        <q-card-section>
          <div class="row items-center">
            <div class="col text-bold">
              Status
            </div>
            <div class="col text-right">
              <q-chip v-if="result.status_pesanan == 'CHECK'" color="warning" text-color="white" icon="las la-hourglass-half" style="font-size: small;">
                Menunggu Konfirmasi
              </q-chip>
              <q-chip v-else-if="result.status_pesanan == 'PROSESS'" color="info" text-color="white" icon="las la-hourglass-half" style="font-size: small;">
                Pesanan di proses
              </q-chip>
              <q-chip v-else-if="result.status_pesanan == 'ditolak'" color="negative" text-color="white" icon="las la-times" style="font-size: small;">
                Pesanan di ditolak
              </q-chip>
              <q-chip v-else-if="result.status_pesanan == 'SELESAI'" color="positive" text-color="white" icon="las la-check" style="font-size: small;">
                Pesanan Selesai
              </q-chip>
            </div>
          </div>
          <div class="row items-center">
            <div class="col text-bold">
              No Meja
            </div>
            <div class="col text-right">
              {{ result.nomor_meja }}
            </div>
          </div>
        </q-card-section>
        <q-card-section>

        </q-card-section>

        <!-- <q-card-section>
          <q-markup-table flat>
            <thead>
              <tr>
                <th class="text-left">Pesanan</th>
                <th class="text-left">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in value" v-bind:key="row.id_transaksi">
                <td>{{ row.id_order }}</td>
                <td>{{ row.quantity || 0 }}</td>
                <td class="text-right">Rp {{ toRupiah(row.price || 0) }}</td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section> -->

        <!-- <q-card-section>
          <div class="row">
            <div class="col text-bold">
              Total yang harus dibayar
            </div>
            <div class="col text-right text-bold">
              Rp {{ toRupiah(total || 0) }}
            </div>
          </div>
        </q-card-section> -->
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
import { groupBy } from 'src/libs/dateTime'
import { api } from 'src/boot/axios';

defineOptions({
  name: 'DetailRekap'
});

const resultData = ref({})

// const total = computed(() => rows.value.reduce((a, b) => a + b.price, 0))

const statusPesanan = computed(() => {
  // return pesananStore.statusPesanan
  return true
})

const getData = async () => {
  try {
    showLoading()
    const { data: response } = await api.post('/viewpesanan', {
      id_penjual: sessionStorage.getItem('id_penjual')
    })

    resultData.value = response.data
    // console.log(resultData.value)

    hideLoading()
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
    // pesananStore.setStatusPesanan('PROSESS')
  } catch (error) {
    console.log(error)
  }
}

const onCancel = async () => {
  try {
    // rows.value = []
    statusPesanan.value = 'ditolak'
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})


</script>
