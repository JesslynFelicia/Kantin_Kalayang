import { route } from 'quasar/wrappers';

<template>
  <HeaderCreate
    title="Profil"
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page style="display: flex; flex-direction: column; height: 100vh">
    <!-- <q-form @submit="register" action="/tes"> -->
    <div style="display: flex; flex-direction: column; padding: 5% 7%">
      <q-form>
        <q-input v-model="formData.nama_toko" label="Nama toko" />
        <q-input v-model="formData.email" label="Email" />
        <q-input v-model="formData.nomor_toko" label="Nomor toko" />
      </q-form>
      <q-btn
        outline
        type="submit"
        label="Edit Profil"
        style="margin-top: 10%"
      />
    </div>
  </q-page>
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

      axios.post('http://127.0.0.1:8000/api/viewprofile')
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
};
</script>
