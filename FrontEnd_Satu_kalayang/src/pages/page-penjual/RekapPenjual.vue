<template>
  <HeaderCreate title="Rekap" backAction="/beranda-penjual" />
  <q-page>
    <div class="q-pa-md">
      <q-table title="" :rows="rows" :columns="columns">
        <template v-slot:body="props">
          <q-tr :props="props" @click="() => $router.push(`rekap-penjual/${stringToDate(props.row.date)}/detail`)">
            <q-td key="date" :props="props">
              {{ props.row.date }}
            </q-td>
            <q-td key="quantity" :props="props">
              {{ props.row.quantity }}
            </q-td>
            <q-td key="total" :props="props">
              {{ toRupiah(props.row.total) }}
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>

  </q-page>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import HeaderCreate from "components/HeaderCreate.vue";
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { getRekap } from 'src/composables/useRekapComposables'
import { toRupiah } from 'src/libs/currency'
import { stringToDate } from 'src/libs/dateTime'
import { api } from 'src/boot/axios'

const rows = ref([])

const columns = [
  { name: 'date', label: 'Waktu', align: 'left', field: 'date' },
  { name: 'quantity', label: 'Jumlah Pesanan', align: 'left', field: 'quantity' },
  { name: 'total', label: 'Total Pendapatan', align: 'right', field: 'total' },
  // { name: 'action', label: 'Action', align: 'center', field: 'action' },
]

const getData = async () => {
  try {
    showLoading()
    const { data: response } = await api.post('/viewrekap', {
      id_penjual: sessionStorage.getItem('id_penjual')
    })
    const data = response.data.map((e) => {
      return {
        date: e.formatted_tanggal_pemesanan,
        quantity: e.Jumlah_pesan,
        total: e.harga_menu
      }
    })
    rows.value = data
    hideLoading()
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})

</script>
