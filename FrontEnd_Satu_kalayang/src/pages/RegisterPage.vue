<template>
    <HeaderCreate
    title=""
    backAction="/"
    :hideLogout="true"
    :hideProfile="true"
  >
  </HeaderCreate>

  <q-page class="q-pa-xl" style="padding-top: 0%;" >
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Register</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="q-mb-lg">
        <label class="text-subtitle1">Email</label>
        <q-input
          outlined
          v-model="formData.email"
          type="email"
          lazy-rules
          :rules="formRules.email"
        >
          <template v-slot:prepend>
            <q-icon name="las la-envelope" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nama Toko</label>
        <q-input
          outlined
          v-model="formData.nama_toko"
          lazy-rules
          :rules="formRules.nama_toko"
        >
          <template v-slot:prepend>
            <q-icon name="las la-store" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nama Pemilik Toko</label>
        <q-input
          outlined
          v-model="formData.nama_pemilik_toko"
          lazy-rules
          :rules="formRules.nama_pemilik_toko"
        >
          <template v-slot:prepend>
            <q-icon name="las la-user" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nomor Telepon</label>
        <q-input
          outlined
          v-model="formData.nomor_telepon"
          type="tel"
          lazy-rules
          :rules="formRules.nomor_telepon"
        >
          <template v-slot:prepend>
            <q-icon name="las la-phone" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nomor Toko</label>
        <q-input
          outlined
          v-model="formData.nomor_toko"
          lazy-rules
          :rules="formRules.nomor_toko"
        >
          <template v-slot:prepend>
            <q-icon name="las la-store-alt" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <q-btn
          color="primary"
          class="full-width"
          label="Register"
          type="submit"
        />
      </div>
    </q-form>
  </q-page>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import useNotify from "src/composables/UseNotify";
import { useRouter } from "vue-router";
import HeaderLogin from "components/HeaderLogin.vue";

const { notifyError, notifySuccess } = useNotify();

const router = useRouter();

const formData = ref({
  email: "",
  nama_toko: "",
  nama_pemilik_toko: "",
  nomor_telepon: "",
  nomor_toko: "",
});

const formRules = ref({
  email: [(val) => (val && val.length > 0) || "Email harus diisi"],
  nama_toko: [(val) => (val && val.length > 0) || "Nama toko harus diisi"],
  nama_pemilik_toko: [
    (val) => (val && val.length > 0) || "Nama pemilik toko harus diisi",
  ],
  nomor_telepon: [
    (val) => (val && val.length > 0) || "Nomor telepon harus diisi",
  ],
  nomor_toko: [(val) => (val && val.length > 0) || "Nomor toko harus diisi"],
});

const onSubmit = async () => {
  try {
    await axios.post("http://127.0.0.1:8000/api/savedatanew", formData.value);
    formData.value = {
      email: "",
      nama_toko: "",
      nama_pemilik_toko: "",
      nomor_telepon: "",
      nomor_toko: "",
    };
    notifySuccess("Akun berhasil dibuat!");
    router.push({ path: "/beranda-admin" });
  } catch (error) {
    notifyError("Mohon isi semua form!");
  }
};

// const linkToLogin = () => {
//   router.push({ path: 'login' });
// };

defineOptions({
  name: "RegisterPage",
});
</script>

<script>
import HeaderCreate from "components/HeaderCreate.vue";

export default {
  components: {
    HeaderCreate,
  },
};
</script>

<style>
.q-btn{
  text-transform: none;
}
</style>
