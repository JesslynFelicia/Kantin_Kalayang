<template>
  <HeaderCreate
    title=""
    backAction="/"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Login</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="q-mb-lg">
        <label class="text-subtitle1">Email</label>
        <q-input
          outlined
          v-model="form.email"
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
        <q-checkbox
          v-model="form.remember"
          size="sm"
          label="Ingat saya"
          class=""
        />
      </div>

      <div class="q-mb-lg">
        <q-btn
          rounded
          color="primary"
          class="full-width"
          style="padding: 10px"
          label="Masuk"
          type="submit"
        />
      </div>
    </q-form>
  </q-page>
  <!-- <FooterApp title="Belum Punya Akun ?" button-link="Daftar sekarang" @link="() => $router.push({ path: '/register' })" /> -->
</template>

<script setup>
import HeaderLogin from "components/HeaderLogin.vue";
import HeaderCreate from "components/HeaderCreate.vue";
import FooterApp from "components/FooterApp.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";
import useNotify from "src/composables/UseNotify";
import { computed } from "vue";
import { useStore } from "vuex";
import axios from "axios";

defineOptions({
  name: "LoginPage",
});

const router = useRouter();
const store = useStore();
// const userEmail = computed(() => store.getters.getUserEmail);
const { notifyError, notifySuccess, notifyWarning } = useNotify();

const seePassword = ref(true);
const form = ref({
  email: "",
  password: "",
  remember: false,
});

const formRules = ref({
  email: [(val) => (val && val.length > 0) || "Email harus diisi"],
  password: [(val) => (val && val.length > 0) || "Kata sandi harus diisi"],
});

const onSubmait = () => {
  console.log(form.value);

  localStorage.setItem("userEmail", form.value.email);

  if (form.value.email.includes("admin")) {
    sessionStorage.setItem("role", "admin");
    router.push({ path: "/beranda-admin" });
  } else {
    sessionStorage.setItem("role", "penjual");
    router.push({ path: "/profile" });
    // notifySuccess("Login berhasil!");
  }
};

const onSusbmit = async () => {
  try {
    const payload = {
      email: form.value.email,
      kata_sandi: form.value.password,
    };

    localStorage.setItem("userEmail", form.value.email);

    const response = await axios.post(
      "http://127.0.0.1:8000/api/newlogin",
      payload
    );

    if (response.data.status) {
      // Kirim email ke API viewonepenjual
      const emailPayload = {
        email: form.value.email,
      };
      await axios.post(
        "http://127.0.0.1:8000/api/viewonepenjual",
        emailPayload
      );

      notifySuccess(response.data.message);
      if (form.value.email.includes("admin")) {
        sessionStorage.setItem("role", "admin");
        router.push({ path: "/beranda-admin" });
      } else {
        sessionStorage.setItem("role", "penjual");
        router.push({ path: "/profile" });
      }
    } else {
      notifyError(response.data.message);
    }
  } catch (error) {
    notifyError("Terjadi kesalahan saat melakukan login.");
    console.error("Error:", error);
  }
};

const onSubmit = async () => {
  try {
    const payload = {
      email: form.value.email,
      kata_sandi: form.value.password,
    };

    localStorage.setItem("userEmail", form.value.email);

    const response = await axios.post(
      "http://127.0.0.1:8000/api/newlogin",
      payload
    );

    if (response.data.status) {
      if (form.value.email.includes("admin")) {
        sessionStorage.setItem("role", "admin");
        router.push({ path: "/register" });
      } else {
        sessionStorage.setItem("role", "penjual");
        router.push({ path: "/profile" });
        notifySuccess("Login berhasil!");
        notifyWarning("Mohon ganti password Anda!");
      }
    } else {
      notifyError(response.data.message);
    }
  } catch (error) {
    notifyError("Terjadi kesalahan saat melakukan login.");
    console.error("Error:", error);
  }
};

const link = () => {
  router.push({ path: "forgot-password" });
};
</script>
