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
        <div class="row items-center justify-between">
          <q-checkbox
            v-model="form.remember"
            size="sm"
            label="Ingat saya"
            class=""
          />
          <q-btn
            flat
            color="primary"
            label="Hubungi admin"
            @click="contactAdmin"
          />
        </div>
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
</template>

<script setup>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import useNotify from "src/composables/UseNotify";
import { useStore } from "vuex";
import axios from "axios";
import { Cookies } from "quasar";

defineOptions({
  name: "LoginPage",
});

const router = useRouter();
const store = useStore();
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

// Check cookie on mounted
onMounted(async () => {
  const rememberedEmail = Cookies.get("rememberMeEmail");
  const rememberedPassword = Cookies.get("rememberMePassword");
  if (rememberedEmail && rememberedPassword) {
    form.value.email = rememberedEmail;
    form.value.password = rememberedPassword;
    form.value.remember = true;

    // Attempt auto login if "remember me" cookie exists
    await onSubmit();
  }
});

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
      if (form.value.remember) {
        Cookies.set("rememberMeEmail", form.value.email, { expires: 7 }); // Cookie will be stored for 7 days
        Cookies.set("rememberMePassword", form.value.password, { expires: 7 }); // Cookie will be stored for 7 days
      } else {
        Cookies.remove("rememberMeEmail");
        Cookies.remove("rememberMePassword");
      }

      if (form.value.email.includes("admin")) {
        sessionStorage.setItem("role", "admin");
        router.push({ path: "/register" });
      } else if (response.data.status_akun == "False") {
        sessionStorage.setItem("role", "penjual");
        router.push({
          path: "/profile",
          params: { email: ref(localStorage.getItem("userEmail") || "") },
        });
        notifySuccess("Login berhasil!");
        notifyWarning("Mohon ganti password Anda!");
      } else if (response.data.status_akun == "True") {
        sessionStorage.setItem("role", "penjual");
        router.push({
          path: "/beranda-penjual",
          params: { email: ref(localStorage.getItem("userEmail") || "") },
        });
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
</script>

<script>
export default {
  methods: {
    contactAdmin() {
      const email = "admin@puprkalayang";
      const subject = "Pertanyaan/Pesan untuk Admin";
      const body = "Tulis pesan Anda di sini.";

      const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(
        subject
      )}&body=${encodeURIComponent(body)}`;

      window.location.href = mailtoLink;
    },
  },
};
</script>

<style>
.q-btn {
  text-transform: none;
}
</style>
