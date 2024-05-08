<template>
  <HeaderCreate
    title="Daftar Akun"
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page style="display: flex; flex-direction: column; height: 100vh">
    <div style="display: flex; flex-direction: column; padding: 5% 7%">
      <q-form @submit="register" action="/tes">
        <q-input v-model="formData.email" label="Email" />
        <q-input v-model="formData.nama_toko" label="Nama Toko" />
        <q-input
          v-model="formData.nama_pemilik_toko"
          label="Nama Pemilik Toko"
        />
        <q-input v-model="formData.nomor_telepon" label="Nomor Telepon" />
        <q-input v-model="formData.nomor_toko" label="Nomor Toko" />
      </q-form>
      <q-btn outline type="submit" label="Daftar Akun" style="margin-top: 10%" />
    </div>
  </q-page>
</template>

<script>
import axios from "axios";
import { defineOptions } from "vue";
import HeaderCreate from "components/HeaderCreate.vue";

// import { $api } from 'boot/axios';
defineOptions({
  name: "RegisterPage",
});

export default {
  components: {
    HeaderCreate,
  },

  data() {
    return {
      formData: {
        email: "",
        nama_toko: "",
        nama_pemilik_toko: "",
        nomor_telepon: "",
        nomor_toko: "",
      },
    };
  },
  methods: {
    register() {
      axios
        .post("http://127.0.0.1:8000/api/savedatanew", this.formData)
        .then((response) => {
          // Handle the response
        })
        .catch((error) => {
          // Handle the error
        });
    },
  },
};
</script>
