<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />

   <!-- eslint-disable-next-line --> <!-- eslint-disable-next-line -->
  <q-page>
    <div class="q-pa-md">
      <q-card flat bordered>
        <q-card-section>
          <div class="row items-center">
            <div class="col text-bold">
              Status
            </div>
            <div class="col text-right">
              <q-chip color="warning" text-color="white" icon="las la-hourglass-half" style="font-size: small;">
                Menunggu Konfirmasi
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
                <!-- <td>{{ row.pesanan }}</td>
                <td>{{ row.quantity }}</td>
                <td>Rp {{ toRupiah(row.price) }}</td>
                <td>Rp {{ toRupiah(row.total) }}</td> -->
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
              <!-- Rp {{ toRupiah(70000) }} -->
            </div>
          </div>
        </q-card-section>
        <q-card-section>
          <div class="row">
            <div class="col text-right">
              <q-btn flat color="negative" label="Tolak Pesanan" />
            </div>
            <div class="col text-right text-bold">
              <q-btn color="primary" label="Terima Pesanan" />
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
// import { onMounted} from 'vue'

// import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
// import { toRupiah } from 'src/libs/currency'

// defineOptions({
//   name: 'DetailRekap'
// });

// const resultData = ref({})
// const rows = ref([
//   { pesanan: 'Pesanan 1', quantity: 1, total: 10000, price: 10000 },
//   { pesanan: 'Pesanan 2', quantity: 2, total: 20000, price: 10000 },
//   { pesanan: 'Pesanan 3', quantity: 4, total: 40000, price: 15000 },
// ])

// const getData = async () => {
//   try {
//     showLoading()
//     setTimeout(() => hideLoading(), 2000)

//   } catch (error) {
//     console.log(error)
//   }
// }

// // onMounted(() => {
// //   getData()
// // })


</script>

<script>
// import axios from "src/boot/axios";
import axios from 'axios'
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  data () {
    return {
      formData: {
      id : ''
      },
      result:{
        jenis:'',
        nama_menu:'',
        harga_menu:'',
        desc_menu:''

      }
    }
  },
  mounted(){
    this.getdata()
  },
  methods: {
    getdata () {

      axios.post('http://127.0.0.1:8000/api/viewtransaksi', this.formData)
        .then(response => {
          // Handle the response
          //cek dulu data yg dilempar postman apa trus ambil data yg lu perlu
            this.result.jenis = response.jenis;
            this.result.nama_menu= response.nama_menu;
           this.result.harga_menu= response.harga_menu;
            this.result = response.desc_menu;
            return response
        })
        .catch(error => {
          // Handle the error
        })
    }
  },
};
</script>
