<template>
  <HeaderCreate
    title=""
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl" style="padding-top: 0%">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Edit Menu</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="form-group">
        <label class="text-subtitle1">Nama Menu</label>
        <q-input
          outlined
          v-model="form.nama_menu"
          lazy-rules
          :rules="formRules.nama_menu"
        >
          <template v-slot:prepend>
            <q-icon name="las la-utensils" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Deskripsi Menu</label>
        <q-input
          outlined
          v-model="form.desc_menu"
        >
          <template v-slot:prepend>
            <q-icon name="las la-info-circle" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Harga</label>
        <q-input
          outlined
          v-model="form.harga"
          type="number"
          lazy-rules
          :rules="formRules.harga"
        >
          <template v-slot:prepend>
            <q-icon name="las la-dollar-sign" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Harga Diskon</label>
        <q-input outlined v-model="form.harga_diskon" type="number">
          <template v-slot:prepend>
            <q-icon name="las la-tag" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Keterangan Diskon</label>
        <q-input outlined v-model="form.ket_diskon">
          <template v-slot:prepend>
            <q-icon name="las la-info-circle" />
          </template>
        </q-input>
      </div>

      <div class="form-group" style="padding-bottom: 20px">
        <q-toggle
          v-model="form.menu_tersedia"
          size="lg"
          color="green"
          label="Menu tersedia"
        />
      </div>

      <div class="form-group">
        <q-btn
          color="primary"
          class="full-width"
          label="Edit Menu"
          type="submit"
          style="padding: 10px;"
          rounded
        />
      </div>
    </q-form>
  </q-page>
</template>

<script>



import axios from 'axios';

export default {
  data() {
formdata:{
      $id_menu = "",
        $jenis = "",
        $nama_menu = "",
        $harga_menu = "",
        $ekstra = "",
        $status_menu = "",
        $desc_menu = ""
}

  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    async submitForm() {
      const formData = new FormData();
      formData.append('firstName', this.firstName);
      formData.append('lastName', this.lastName);
      formData.append('file', this.file);

      try {
        const response = await axios.post('https://example.com/api/data', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Authorization': 'Bearer your-token' // if needed
          }
        });
        console.log('Data posted successfully:', response.data);
      } catch (error) {
        console.error('Error posting data:', error);
      }
    }
  }
};
</script>

<script setup>
import HeaderLogin from "components/HeaderLogin.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";
import HeaderCreate from "components/HeaderCreate.vue";
import useNotify from "src/composables/UseNotify";

defineOptions({
  name: "EditPesananPage",
});

const router = useRouter();
const { notifyError, notifySuccess } = useNotify();

const form = ref({
  nama_menu: "",
  desc_menu: "",
  harga: "",
  harga_diskon: "",
  ket_diskon: "",
  menu_tersedia: true,
});

const formRules = ref({
  nama_menu: [(val) => (val && val.length > 0) || "Nama menu harus diisi"],
  harga: [(val) => (val && val > 0) || "Harga harus diisi"],
});

const onSubmit = () => {
  console.log(form.value);

  notifySuccess("Menu berhasil diedit!");
  router.push({ path: "/beranda-penjual" });
};
</script>

<style scoped>
.form-group {
  margin-bottom: 0;
}

.q-btn {
  text-transform: none;
}
</style>
