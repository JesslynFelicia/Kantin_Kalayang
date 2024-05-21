<template>
  <HeaderCreate title="Rekap Detail" backAction="/rekap-penjual" />
  <q-page>
    <div class="q-pa-md">
      <q-card flat bordered>
        <q-card-section>
          <div class="text-subtitle2">{{ formatToDate(resultData.date) }}</div>
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
import { formatToDate } from 'src/libs/dateTime'
import { toRupiah } from 'src/libs/currency'

defineOptions({
  name: 'DetailRekap'
});

const router = useRoute()
const { id } = router.params

const resultData = ref({})
const rows = ref([
  { pesanan: 'Pesanan 1', quantity: 1, total: 10000, price: 10000 },
  { pesanan: 'Pesanan 2', quantity: 2, total: 20000, price: 10000 },
  { pesanan: 'Pesanan 3', quantity: 4, total: 40000, price: 15000 },
])

const getData = async () => {
  try {
    showLoading()
    const data = await getRekapSingle(id)
    resultData.value = data
    hideLoading()
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})


</script>
