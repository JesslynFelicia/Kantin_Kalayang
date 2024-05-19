import { route } from 'quasar/wrappers';
<template>
  <!-- <q-btn flat @click="$router.replace('/')" icon="arrow_back" style="margin-top: 5px;"></q-btn> -->
  <HeaderCreate
    title="Pembayaran dengan QRIS"
    backAction="/ringkasan-pesanan"
    :hideLogout="true"
    :hideProfile="true"
  />

  <div style="display: flex; flex-direction: column; align-items: center">
    <img
      src="/src/assets/qris.png"
      alt="Deskripsi Foto"
      class="category"
      style="width: auto; height: 350px"
    />
    <q-btn
      @click="$router.replace('/status-pesanan')"
      outline
      no-caps
      style="margin-top: 4%; font-weight: 800"
    >
      Cek Status Pesanan
    </q-btn>
  </div>

  <h6 style="font-weight: 800; margin: 6% 3.5%; margin-bottom: 0px">
    Cara membayar dengan QRIS
  </h6>


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
        id:''

      },
      result:{

        jenis :''
      }
    }
  },
  mounted(){
 this.getdata();
  },
  methods: {
    getdata () {

      axios.post('http://127.0.0.1:8000/api/showqris')
        .then(response => {
          // Handle the response
          //ambil datanya masukin ke local variabel (result)
          //contoh
          this.result.jenis = response.jenis;
          return response;
        })
        .catch(error => {
          // Handle the error
        })
    }
  },
  setup() {},
};
</script>
