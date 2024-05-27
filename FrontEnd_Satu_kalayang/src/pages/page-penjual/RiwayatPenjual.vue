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
<<<<<<< HEAD
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
=======
import axios from "axios";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  data() {
    return {
      formData: {
        id_transaksi: "",
      },
      result: {
        //tar ceknya di postman aja pake url dibawah, butuh data apa aja
        id_menu: "",
        id_order: "",
        id_penjual: "",
        tanggal_pemesanan: "",
      },
    };
  },
  //ini gunanya biar pas ngeload langsung ngerun
  mounted() {
    this.getdata();
  },
  methods: {
    getdata() {
      axios
        .post("http://127.0.0.1:8000/api/viewtransaksi", this.formData)
        .then((response) => {
          // Handle the response
          //masukin data ke local variabel
          this.result.jenis = response.jenis;
          this.result.nama_menu = response.nama_menu;
          this.result.harga_menu = response.harga_menu;
          this.result = response.desc_menu;
          return response;
        })
        .catch((error) => {
          // Handle the error
        });
    },
>>>>>>> laras
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
