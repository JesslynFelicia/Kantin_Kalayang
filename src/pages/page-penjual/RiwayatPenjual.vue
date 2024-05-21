<template>
  <HeaderCreate title="Riwayat" backAction="/beranda-penjual" />
  <q-page class="">
    <div class="q-pa-md">
      <div class="text-bold q-mb-sm">{{ today() }}</div>
      <q-table title="" :rows="rows" :columns="columns" row-key="name" />
    </div>
  </q-page>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import HeaderCreate from "components/HeaderCreate.vue";
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { getHistory } from 'src/composables/useHistoryComposables'
import { toRupiah } from 'src/libs/currency'
import { formatToDatetime, today } from 'src/libs/dateTime'

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
    format: val => `${formatToDatetime(val)}`
  },
  {
    name: 'totalOrder',
    label: 'Total Order',
    align: 'right',
    field: 'totalOrder',
    format: val => `Rp ${toRupiah(val)}`
  },
]

const getData = async () => {
  try {
    showLoading()
    const data = await getHistory()
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
