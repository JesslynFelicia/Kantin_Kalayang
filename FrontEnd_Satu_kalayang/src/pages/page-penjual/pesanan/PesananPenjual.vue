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
<!--
<script setup>

import { onMounted, computed } from 'vue'

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
    const { data: response } = await api.post("http://127.0.0.1:8000/api/viewonepenjual", {
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




</script> -->

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
  showdaftarpesanan:{
    id_menu: "7",
id_order: "#M3105240001",
formatted_tanggal_pemesanan: "31/05/2024 09:56",
nomor_meja: "18",
status_pesanan: "CHECK",
catatan_pemesan: "",
created_at: "2024-05-31T14:34:56.000000Z",
updated_at: "2024-05-31T14:34:56.000000Z",
Jumlah_pesan: "x2",
id_penjual: "1",
harga_menu: "40000"

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
    axios.post("http://127.0.0.1:8000/api/viewtransaksi", {
        id_penjual : this.id_penjual
      })
      .then(response => {
        // Handle the response here
        console.log(response.data.data);

        id_menu = response.data.data.id_menu;
id_order = response.data.data.id_order;
formatted_tanggal_pemesanan = response.data.data.formatted_tanggal_pemesanan;
nomor_meja = response.data.data.nomor_meja;
status_pesanan = response.data.data.status_pesanan;
catatan_pemesan = response.data.data.catatan_pemesan;
created_at = response.data.data.created_at;
updated_at = response.data.data.updated_at;
Jumlah_pesan = response.data.data.Jumlah_pesan;
id_penjual = response.data.data.id_penjual;
harga_menu = response.data.data.harga_menu;



      })
      .catch(err => {
        // Handle errors here
        this.error = err;
        console.error(err);
      })
    },
  },};

</script>
