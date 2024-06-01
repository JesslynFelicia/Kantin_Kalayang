<template>
  <HeaderCreate title="Riwayat" backAction="/beranda-penjual" />
  <q-page class="">
    <div class="q-pa-md">
      <div class="text-bold q-mb-sm">{{ today() }}</div>
      <q-table
        flat bordered
        title=""
        :rows="rows"
        :columns="columns"
        row-key="name"
        v-model:pagination="pagination"
        @request="onRequest"
      >
      <template v-slot:pagination="scope">
          <q-btn
            icon="chevron_left"
            color="grey-8"
            round
            dense
            flat
            :disable="scope.isFirstPage"
            @click="scope.prevPage"
          />

          <q-btn
            icon="chevron_right"
            color="grey-8"
            round
            dense
            flat
            :disable="scope.isLastPage"
            @click="scope.nextPage"
          />
        </template>
      </q-table>
    </div>
  </q-page>
</template>

<script setup>
import { onMounted, ref, computed, watch } from 'vue';
import HeaderCreate from 'src/components/HeaderCreate.vue';
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { getHistory } from 'src/composables/useHistoryComposables'
import { toRupiah } from 'src/libs/currency'
import { stringToDate, today } from 'src/libs/dateTime'
import { api } from 'src/boot/axios';

defineOptions({
  name: 'IndexPage'
});

const rows = ref([])


const columns = [
  { name: 'id', label: 'ID Order', align: 'left', field: 'id' },
  { name: 'name', label: 'Nama Menu', align: 'left', field: 'name' },
  {
    name: 'date',
    label: 'Waktu',
    align: 'left',
    field: 'date',
    format: val => `${stringToDate(val)}`
  },
  {
    name: 'totalOrder',
    label: 'Total Order',
    align: 'right',
    field: 'totalOrder',
    format: val => `Rp ${toRupiah(val)}`
  },
]

const pagination = ref({
  sortBy: 'desc',
  descending: false,
  page: 1,
  rowsPerPage: 10,
  // rowsNumber: 0
})

const onRequest = async (props) => {
  pagination.value.page = props.pagination.page
  pagination.value.rowsPerPage = props.pagination.rowsPerPage
  await getData()
}

const getData = async () => {
  try {
    showLoading()
    const { data: response } = await api.post(`/riwayatpenjual?page=${pagination.value.page}`, {
      id_penjual: sessionStorage.getItem('id_penjual'),
      perPage: pagination.value.rowsPerPage
    })
    console.log(response.data)
    pagination.value.rowsNumber = response.total
    rows.value = response.data.map(e => {
      return {
        id: e.id_order,
        totalOrder: e.harga_menu,
        date: e.formatted_tanggal_pemesanan,
        name: e.nama_menu
      }
    })
    hideLoading()
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})
</script>

