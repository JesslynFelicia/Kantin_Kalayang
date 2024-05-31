<template>
  <HeaderCreate
    title=""
    backAction="/login"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Edit Profil</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="q-mb-lg">
        <label class="text-subtitle1">Nama Toko</label>
        <q-input outlined disable v-model="form.nama_toko">
          <template v-slot:prepend>
            <q-icon name="las la-store" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Email</label>
        <q-input outlined type="email" lazy-rules disable v-model="userEmail">
          <template v-slot:prepend>
            <q-icon name="las la-envelope" />
            <!-- <span>{{ userEmail }}</span> -->
            <!-- Display email here -->
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nomor Toko</label>
        <q-input
          outlined
          v-model="form.nomor_toko"
          lazy-rules
          :rules="formRules.nomor_toko"
        >
          <template v-slot:prepend>
            <q-icon name="las la-phone" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Password</label>
        <q-input
          outlined
          type="password"
          v-model="form.password"
          lazy-rules
          :rules="formRules.password"
        >
          <template v-slot:prepend>
            <q-icon name="las la-lock" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">New Password</label>
        <q-input
          outlined
          type="password"
          v-model="form.new_password"
          lazy-rules
          :rules="formRules.new_password"
        >
          <template v-slot:prepend>
            <q-icon name="las la-lock" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Foto Profil</label>
        <q-uploader
          @uploaded="onUploadSuccess('foto_profil')"
          @failed="onUploadFail"
          url=""
          label="Unggah Foto Profil"
          color="primary"
          square
          flat
          bordered
          accept=".png, .jpg, .jpeg"
          style="max-width: 300px"
        />
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">QRIS</label>
        <q-uploader
          @uploaded="onUploadSuccess('qris')"
          @failed="onUploadFail"
          url=""
          label="Unggah QRIS"
          color="primary"
          square
          flat
          bordered
          accept=".png, .jpg, .jpeg"
          style="max-width: 300px"
        />
      </div>

      <div class="q-mb-lg">
        <q-btn
          color="primary"
          class="full-width"
          label="Edit Profil"
          type="submit"
          rounded
          style="padding: 12px"
        />
      </div>
    </q-form>
  </q-page>
</template>

<script setup>
import HeaderLogin from "components/HeaderLogin.vue";
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import useNotify from "src/composables/UseNotify";

defineOptions({
  name: "EditProfilePage",
});

const router = useRouter();
const store = useStore();
const userEmail = ref(localStorage.getItem("userEmail") || "");
const { notifyError, notifySuccess } = useNotify();

const form = ref({
  nama_toko: "",
  email: "",
  nomor_toko: "",
  password: "",
  new_password: "",
  foto_profil: null,
  qris: null,
});

const formRules = ref({
  nomor_toko: [
    (val) => (val && val.length > 0) || "Nomor toko harus diisi",
    (val) => /^\d+$/.test(val) || "Nomor toko harus berupa angka",
  ],
  password: [(val) => (val && val.length > 0) || "Password harus diisi"],
  new_password: [
    (val) => (val && val.length > 0) || "New password harus diisi",
    (val) =>
      val !== form.value.password || "New password harus berbeda dari password",
  ],
  qris: [(val) => val !== null || "QRIS harus diunggah"],
});

const onSubmit = () => {
  // if (form.value.qris === null) {
  //   notifyError("Anda harus mengunggah QRIS.");
  //   return;
  // }

  if (form.value.new_password === form.value.password) {
    notifyError("New password harus berbeda dari password.");
    return;
  }

  notifySuccess("Akun berhasil diedit!");
  router.push({ path: "/beranda-penjual" });
};

const onUploadSuccess = (field) => (response) => {
  form.value[field] = response;
  notifySuccess("Upload berhasil!");

  if (field === "qris") {
    form.value.qris = response;
  }
};

const onUploadFail = (error) => {
  notifyError("Upload gagal!");
};
</script>

<script>
import axios from "axios";

export default {
  components: {
    HeaderCreate,
  },

  data() {
    return {
      result: {
        jenis: "",
      },
    };
  },

  mounted() {
    this.getdata();
  },
  methods: {
    getdata() {
      axios
        .post("http://127.0.0.1:8000/api/viewprofile")
        .then((response) => {
          this.result.jenis = response.jenis;
          console.log("jenis?", this.result.jenis);
          return response;
        })
        .catch((error) => {
          console.error(error);
        });
    },

     fetchSellerInfo(email) {
      // Panggil API untuk mendapatkan informasi penjual berdasarkan email
      fetch(`/viewpenjual?email=${email}`)
        .then(response => response.json())
        .then(data => {
          const sellerId = data.id_penjual;
          // Panggil API kedua untuk mendapatkan informasi detail penjual berdasarkan ID penjual
          return fetch(`/viewpenjual?id=${sellerId}`);
        })
        .then(response => response.json())
        .then(data => {
          // Simpan informasi penjual ke objek
          this.sellerInfo = data;
        })
        .catch(error => {
          console.error('Error fetching seller info:', error);
        });
    },
  },
};
</script>

<style>
.q-btn {
  text-transform: none;
}

.q-uploader__header {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background-color: #f5f5f5;
  border-radius: 10px;
}

.q-uploader__title {
  margin-left: 10px;
  font-size: 18px;
  font-weight: bold;
}
</style>
