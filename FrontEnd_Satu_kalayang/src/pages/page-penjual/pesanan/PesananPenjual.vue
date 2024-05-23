import { route } from 'quasar/wrappers';

<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import axios from "axios";

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
