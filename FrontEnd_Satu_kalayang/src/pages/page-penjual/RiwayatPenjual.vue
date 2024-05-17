import { route } from 'quasar/wrappers';

<template>
  <HeaderCreate title="Riwayat" backAction="/beranda-penjual" />
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>

  <!-- cara looping  -->
  <!-- <div v-for="(item, index) in result" :key="index">
    <p>jenis: {{ item.jenis }}</p>
    <p>nama_menu: {{ item.nama_menu }}</p>
    <p>harga_menu: {{ item.harga_menu }}</p>
    <p>desc_menu: {{ item.desc_menu }}</p>
  </div> -->
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  data () {
    return {
      formData: {
      id_transaksi : ''
      },
      result:{
        //tar ceknya di postman aja pake url dibawah, butuh data apa aja
        id_menu:'',
        id_order:'',
        id_penjual:'',
        tanggal_pemesanan:''

      }
    }
  },
  //ini gunanya biar pas ngeload langsung ngerun
  mounted(){
    this.getdata()
  },
  methods: {
    getdata () {

      axios.post('http://127.0.0.1:8000/api/viewtransaksi', this.formData)
        .then(response => {
          // Handle the response
          //masukin data ke local variabel
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
