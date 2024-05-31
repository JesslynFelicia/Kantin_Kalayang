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
        <q-input outlined v-model="namaToko">
          <template v-slot:prepend>
            <q-icon name="las la-store" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Nomor Toko</label>
        <q-input outlined disable v-model="nomorToko" lazy-rules>
          <template v-slot:prepend>
            <q-icon name="las la-phone" />
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
        <label class="text-subtitle1">Kata Sandi</label>
        <q-input
          outlined
          v-model="form.password"
          :type="seePassword ? 'password' : 'text'"
          lazy-rules
          :rules="formRules.password"
        >
          <template v-slot:prepend>
            <q-icon name="las la-lock" />
          </template>
          <template v-slot:append>
            <q-icon
              :name="seePassword ? 'las la-eye' : 'las la-eye-slash'"
              @click="seePassword = !seePassword"
              class="cursor-pointer"
            />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">New Password</label>
        <q-input
          outlined
          :type="seeNewPassword ? 'password' : 'text'"
          v-model="form.new_password"
          lazy-rules
          :rules="formRules.new_password"
        >
          <template v-slot:prepend>
            <q-icon name="las la-lock" />
          </template>
          <template v-slot:append>
            <q-icon
              :name="seeNewPassword ? 'las la-eye' : 'las la-eye-slash'"
              @click="seeNewPassword = !seeNewPassword"
              class="cursor-pointer"
            />
          </template>
        </q-input>
      </div>

      <!-- <q-uploader
          v-model="form.gambar_profile"
          url=""
          label="Unggah Foto Profil"
          color="primary"
          square
          flat
          bordered
          accept=".png, .jpg, .jpeg"
          style="max-width: 300px"
          @change="handleProfile"
        /> -->

      <div class="q-mb-lg">
        <label class="text-subtitle1">Foto Profil</label>
        <q-uploader
          v-model="form.gambar_profile"
          label="Unggah Foto Profil"
          color="primary"
          square
          flat
          bordered
          accept=".png, .jpg, .jpeg"
          style="max-width: 300px"
          @input="handleProfile"
        />
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">QRIS</label>
        <q-uploader
          v-model="form.qris"
          url=""
          label="Unggah QRIS"
          color="primary"
          square
          flat
          bordered
          accept=".png, .jpg, .jpeg"
          style="max-width: 300px"
          @input="handleQris"
        />
      </div>

      <div class="q-mb-lg">
        <q-btn
          color="primary"
          class="full-width"
          label="Edit Profil"
          @click="updateProfile"
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
  gambar_profile: null,
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

// const onSubmit = () => {
//   // if (form.value.qris === null) {
//   //   notifyError("Anda harus mengunggah QRIS.");
//   //   return;
//   // }

//   if (form.value.new_password === form.value.password) {
//     notifyError("New password harus berbeda dari password.");
//     return;
//   }

//   notifySuccess("Akun berhasil diedit!");
//   router.push({ path: "/beranda-penjual" });
// };

const updateProfile = async () => {
  try {
    const payload = {
      email: userEmail.value,
      kata_sandi: form.value.new_password,
      gambar_profile: form.value.gambar_profile,
      qris: form.value.qris,
    };

    const formData = new FormData();
    Object.keys(payload).forEach((key) => {
      formData.append(key, payload[key]);
    });

    const response = await axios.post(
      "http://127.0.0.1:8000/api/updatedatapenjual",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    );

    if (response.status === 200) {
      console.log(response.data.message);
      notifySuccess("Akun berhasil diedit!");
      router.push({ path: "/beranda-penjual" });
    } else {
      console.error("Update failed:", response.data.error);
    }
  } catch (error) {
    console.error("Error updating profile:", error);
    notifyError("Gagal mengedit akun");
  }
};

const handleProfile = (event) => {
  const file = event.target.files[0];
  form.value.gambar_profile = file;
  if (form.value.gambar_profile !== null) {
    console.log("gambar profile masuk", form.value.gambar_profile);
  }
};

const handleQris = (event) => {
  const file = event.target.files[0];
  form.value.qris = file;
  if (form.value.qris !== null) {
    console.log("gambar qris masuk", form.value.qris);
  }
};
</script>

<script>
import axios from "axios";

const seePassword = ref(true);
const seeNewPassword = ref(true);

export default {
  components: {
    HeaderCreate,
  },

  data() {
    return {
      namaToko: "",
      nomorToko: "",
      result: {
        jenis: "",
      },
      model: ref(null),
    };
  },

  mounted() {
    this.getdata();
  },
  methods: {
    // getdata() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/viewprofile")
    //     .then((response) => {
    //       this.result.jenis = response.jenis;
    //       console.log("jenis?", this.result.jenis);
    //       return response;
    //     })
    //     .catch((error) => {
    //       console.error(error);
    //     });
    // },

    async getdata() {
      const loggedInUserEmail = localStorage.getItem("loggedInUserEmail");
      if (loggedInUserEmail) {
        try {
          const response = await axios.post(
            "http://127.0.0.1:8000/api/viewonepenjual",
            { email: loggedInUserEmail }
          );
          // const penjualData = response.data.data;
          this.namaToko = response.data.data.nama_toko;
          this.nomorToko = response.data.data.nomor_toko;

          // console.log("a", this.namaToko);
        } catch (error) {
          console.error("Error fetching penjual data:", error);
        }
      } else {
        console.error("No logged in user email found.");
      }
    },

    fetchSellerInfo(email) {
      // Panggil API untuk mendapatkan informasi penjual berdasarkan email
      fetch(`/viewpenjual?email=${email}`)
        .then((response) => response.json())
        .then((data) => {
          const sellerId = data.id_penjual;
          // Panggil API kedua untuk mendapatkan informasi detail penjual berdasarkan ID penjual
          return fetch(`/viewpenjual?id=${sellerId}`);
        })
        .then((response) => response.json())
        .then((data) => {
          // Simpan informasi penjual ke objek
          this.sellerInfo = data;
        })
        .catch((error) => {
          console.error("Error fetching seller info:", error);
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
