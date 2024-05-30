<template>
  <HeaderCreate
    title=""
    backAction="/beranda-penjual"
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
        <q-input outlined disable>
          <template v-slot:prepend>
            <q-icon name="las la-store" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <label class="text-subtitle1">Email</label>
        <q-input outlined type="email" lazy-rules disable>
          <template v-slot:prepend>
            <q-icon name="las la-envelope" />
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
        <q-btn
          color="primary"
          class="full-width"
          label="Edit Profil"
          type="submit"
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
import useNotify from "src/composables/UseNotify";

defineOptions({
  name: "EditProfilePage",
});

const router = useRouter();
const { notifyError, notifySuccess } = useNotify();

const form = ref({
  nama_toko: "",
  email: "",
  nomor_toko: "",
});

const formRules = ref({
  nomor_toko: [(val) => (val && val.length > 0) || "Nomor toko harus diisi"],
});

const onSubmit = () => {
  console.log(form.value);

  notifySuccess("Akun berhasil diedit!");
  router.push({ path: "/beranda-penjual" });
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
      // formData: {
      //   id: "",
      // },
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
  },
};
</script>

<style>
.q-btn {
  text-transform: none;
}
</style>
