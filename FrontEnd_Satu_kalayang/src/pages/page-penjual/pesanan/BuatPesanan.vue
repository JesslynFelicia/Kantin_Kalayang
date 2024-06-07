<template>
  <div>
    <HeaderCreate
      title=""
      backAction="/beranda-penjual"
      :hideLogout="true"
      :hideProfile="true"
    />
    <q-page class="q-pa-xl" style="padding-top: 0%">
      <div class="text-center q-mb-xl" style="margin-bottom: 20px">
        <span class="text-h4 text-weight-bold">Buat Menu</span>
      </div>
      <q-form @submit="onSubmit" ref="menuForm">
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
            :rules="formRules.harga_menu"
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
          <q-select
            outlined
            v-model="form.jenis"
            :options="jenisOptions"
            lazy-rules
            :rules="formRules.jenis"
          >
            <template v-slot:prepend>
              <q-icon name="las la-tag" />
            </template>
          </q-select>
        </div>

        <!-- <div class="form-group">
          <label class="text-subtitle1">Ekstra</label>
          <q-input outlined v-model="form.ekstra">
            <template v-slot:prepend>
              <q-icon name="las la-info-circle" />
            </template>
          </q-input>
        </div> -->

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
            @click="submitForm()"
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
const jenisOptions = ["Berat", "Ringan", "Minuman"];
const id_penjual = ref(null);
const menuForm = ref(null);

const form = ref({
  nama_menu: "",
  desc_menu: "",
  harga_menu: "",
  jenis: "",
  // ekstra: "",
  menu_tersedia: true,
});

const formRules = {
  nama_menu: [(val) => !!val || "Mohon isi nama menu"],
  harga_menu: [
    (val) => !!val || "Mohon isi harga menu",
    (val) => val > 0 || "Mohon isi harga menu dengan angka",
  ],
  jenis: [(val) => !!val || "Mohon pilih jenis menu"],
};

const getIdPenjual = async () => {
  await axios
    .post("http://127.0.0.1:8000/api/viewonepenjual", {
      email: localStorage.getItem("userEmail"),
    })
    .then((response) => {
      id_penjual.value = response.data.data.id_penjual;
    })
    .catch((error) => {
      console.error(error);
    });
};

const buatMenu = async () => {
  try {
    await getIdPenjual();
    const response = await axios.post("http://127.0.0.1:8000/api/savemenu", {
      id_penjual: id_penjual.value,
      jenis: form.value.jenis,
      nama_menu: form.value.nama_menu,
      harga_menu: form.value.harga_menu,
      // ekstra: form.value.ekstra,
      status_menu: form.value.menu_tersedia ? "READY" : "NONE",
      desc_menu: form.value.desc_menu,
    });

    console.log(response.data);
    router.push({ path: "/beranda-penjual" });
  } catch (error) {
    console.error(error);
  }
};

const submitForm = async () => {
  const valid = await menuForm.value.validate();
  if (valid) {
    await buatMenu();
  } else {
    console.log("Form is invalid");
  }
};
</script>

<style scoped>
.form-group {
  margin-bottom: 20px;
}

.q-btn {
  text-transform: none;
}
</style>
