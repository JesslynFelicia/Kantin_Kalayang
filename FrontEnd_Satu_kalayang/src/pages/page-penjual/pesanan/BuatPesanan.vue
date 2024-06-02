<template>
  <div>
    <HeaderCreate
      title="Buat Menu"
      backAction="/beranda-penjual"
      :hideLogout="true"
      :hideProfile="true"
    />
    <q-page class="q-pa-xl" style="padding-top: 0%">
      <div class="text-center q-mb-xl" style="margin-bottom: 20px">
        <span class="text-h4 text-weight-bold">Buat Menu</span>
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
          <q-input outlined v-model="form.desc_menu">
            <template v-slot:prepend>
              <q-icon name="las la-info-circle" />
            </template>
          </q-input>
        </div>

        <div class="form-group">
          <label class="text-subtitle1">Harga</label>
          <q-input
            outlined
            v-model="form.harga_menu"
            type="number"
            lazy-rules
            :rules="formRules.harga"
          >
            <template v-slot:prepend>
              <q-icon name="las la-dollar-sign" />
            </template>
          </q-input>
        </div>

        <!-- <div class="form-group">
          <label class="text-subtitle1">Jenis</label>
          <q-input outlined v-model="form.jenis">
            <template v-slot:prepend>
              <q-icon name="las la-tag" />
            </template>
          </q-input>
        </div> -->

        <div class="form-group">
          <label class="text-subtitle1">Jenis</label>
          <q-select outlined v-model="form.jenis" :options="jenisOptions">
            <template v-slot:prepend>
              <q-icon name="las la-tag" />
            </template>
          </q-select>
        </div>

        <div class="form-group">
          <label class="text-subtitle1">Ekstra</label>
          <q-input outlined v-model="form.ekstra">
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
            label="Buat Menu"
            @click="buatMenu"
            style="padding: 10px"
            rounded
          />
        </div>
      </q-form>
    </q-page>
  </div>
</template>

<script setup>
import HeaderCreate from "components/HeaderCreate.vue";
import axios from "axios";
import { ref } from "vue";

import { useRouter } from "vue-router";

const router = useRouter();
const jenisOptions = ["Berat", "Ringan", "Minuman"]; // Pilihan jenis

const form = ref({
  nama_menu: "",
  desc_menu: "",
  harga_menu: "",
  jenis: "",
  ekstra: "",
  menu_tersedia: true,
});

const formRules = ref({
  nama_menu: [(val) => (val && val.length > 0) || "Nama menu harus diisi"],
  harga: [(val) => (val && val > 0) || "Harga harus diisi"],
});

const buatMenu = async () => {
  try {
    const response = await axios.post("http://127.0.0.1:8000/api/savemenu", {
      id_penjual: 1, // Ganti dengan id penjual yang sesuai
      jenis: form.value.jenis,
      nama_menu: form.value.nama_menu,
      harga_menu: form.value.harga_menu,
      ekstra: form.value.ekstra,
      status_menu: form.value.menu_tersedia ? "READY" : "NONE",
      desc_menu: form.value.desc_menu,
    });

    console.log(response.data); // Log response jika berhasil
    router.push({ path: "/beranda-penjual" }); // Redirect to seller dashboard after menu creation
  } catch (error) {
    console.error(error); // Log error jika terjadi kesalahan
  }
};
</script>

<style scoped>
.form-group {
  margin-bottom: 20px; /* Tambahkan margin antara setiap form group */
}

.q-btn {
  text-transform: none;
}
</style>
