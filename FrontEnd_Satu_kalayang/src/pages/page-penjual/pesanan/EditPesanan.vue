import { route } from 'quasar/wrappers';

<template>
  <HeaderCreate
    title="Edit Pesanan"
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page style="display: flex; flex-direction: column; height: 100vh">
    <!-- <q-form @submit="register" action="/tes"> -->
    <div style="display: flex; flex-direction: column; padding: 5% 7%">
      <q-form>
        <q-input v-model="formData.nama_menu" label="Nama menu" />
        <q-input v-model="formData.des_menu" label="Deskripsi menu" />
        <q-input v-model="formData.harga" label="Harga" />
        <q-input v-model="formData.harga_diskon" label="Harga diskon" />
        <q-input v-model="formData.ket_diskon" label="Keterangan diskon" />
        <q-toggle
          size="50px"
          v-model="value"
          checked-icon="check"
          color="green"
          unchecked-icon="clear"
          style="font-size: 17px"
        >
          Menu tersedia
        </q-toggle>
      </q-form>
      <q-btn outline type="submit" label="Edit Menu" style="margin-top: 10%" />
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

  data() {
    return {
      formData: {
        nama_menu: "",
        des_menu: "",
        harga: "",
        harga_diskon: "",
        ket_diskon: "",
      },
      value: ref(true),
    };
  },

  methods: {
    // register() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/savedatanew", this.formData)
    //     .then((response) => {
    //       // Handle the response
    //     })
    //     .catch((error) => {
    //       // Handle the error
    //     });
    // },
  },
};
</script>
