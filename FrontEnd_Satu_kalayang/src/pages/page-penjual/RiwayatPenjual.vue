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
import { onMounted } from 'vue';

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

const getData = async () => {
  try {
    showLoading()
    const { data: response } = await api.post('/viewrekap', {
      id_penjual: sessionStorage.getItem('id_penjual')
    })

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

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import axios from 'axios';
export default
{
  components: {
    HeaderCreate,
  },
  formdata:{
    id_penjual : ""
  },
  showdatariwayat:{

  },
  mounted(){
this.getdata()
  },
  methods: {
    getdata() {
      const email = ref(localStorage.getItem("userEmail")).value;

      axios.post("http://127.0.0.1:8000/api/viewonepenjual", {
        email: email
      })
      .then(response => {
        // Handle the response here
        console.log(response.data);
        // this.id_penjual = response.data.id_penjual;
        this.id_penjual = 1;
        console.log(this.id_penjual);
        this.getdatariwayat();
      })
      .catch(err => {
        // Handle errors here
        this.error = err;
        console.error(err);
      })
    },

  getdatariwayat(){
    console.log("getdatamenu")
    console.log(this.id_penjual)
    axios.post("http://127.0.0.1:8000/api/viewrekap", {
        id_penjual : this.id_penjual
      })
      .then(response => {
        // Handle the response here
        console.log(response.data);

      })
      .catch(err => {
        // Handle errors here
        this.error = err;
        console.error(err);
      });
    }

  }
  }
</script>

