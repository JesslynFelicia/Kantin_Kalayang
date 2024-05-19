import { route } from 'quasar/wrappers';

<template>
  <div>
  <HeaderCreate title="Rekap" backAction="/beranda-penjual" />
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
</div>
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
      id : ''
      },
      result:{
        //ganti sesuai dibutuhin, ceknya di postman
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
      //ini lu harus kirim id penjual
      axios.post('http://127.0.0.1:8000/api/viewrekap', this.formData)
        .then(response => {
          // Handle the response
          //responsenya ganti sesuai yg dibutuhin, ganti juga di variabel result
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
