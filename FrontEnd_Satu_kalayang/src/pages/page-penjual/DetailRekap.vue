<template>
  <HeaderCreate title="Rekap Detail" backAction="/rekap-penjual" />
  <q-page>
    <div class="q-pa-md">
      <q-card flat bordered>
        <q-card-section>
          <div class="text-subtitle2">{{ stringToDate(resultData.date) }}</div>
          <q-markup-table flat dense>
            <thead>
              <tr>
                <th class="text-left">Total Pendapatan</th>
                <th class="text-right">Rp {{ toRupiah(resultData.total) }}</th>
              </tr>
              <tr>
                <th class="text-left">Jumlah Pesanan</th>
                <th class="text-right">{{ resultData.quantity }}</th>
              </tr>
            </thead>
          </q-markup-table>
        </q-card-section>

        <q-card-section>
          <q-markup-table flat bordered>
            <thead>
              <tr>
                <th class="text-left">Pesanan</th>
                <th class="text-left">Jumlah</th>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in rows" v-bind:key="row.pesanan">
                <td>{{ row.nama_menu }}</td>
                <td>{{ row.Jumlah }}</td>
                <td class="text-right">Rp {{ toRupiah(row.harga_menu) }}</td>
              </tr>
            </tbody>
          </q-markup-table>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import HeaderCreate from "components/HeaderCreate.vue";
import { getRekapSingle } from 'src/composables/useRekapComposables'
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { stringToDate } from 'src/libs/dateTime'
import { toRupiah } from 'src/libs/currency'
import { api } from 'src/boot/axios'

defineOptions({
  name: 'DetailRekap'
});

const router = useRoute()
const { id: date } = router.params

const resultData = ref({})
const rows = ref([])

const getData = async () => {
  try {
    showLoading()
    const { data: response } = await api.post('/detailrekap', {
      id_penjual: sessionStorage.getItem('id_penjual'),
      date: date
    })

    resultData.value = {
      date: response.data[0].formatted_tanggal_pemesanan,
      total: response.data[0].harga_menu,
      quantity: response.data[0].Jumlah_pesan,
    }

    rows.value = response.detail
    hideLoading()
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})


</script>
