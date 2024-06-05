<template>
  <HeaderCreate
    title=""
    backAction="/beranda-admin"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h5 text-weight-bold">Reset Kata Sandi</span>
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
        <q-btn
          color="primary"
          class="full-width"
          label="Lanjutkan"
          type="submit"
        />
      </div>
    </q-form>
  </q-page>
  <FooterApp
    title="Sudah memiliki akun ?"
    button-link="Masuk"
    @link="() => $router.push({ path: '/login' })"
  />
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios"; // Import axios
import HeaderLogin from "src/components/HeaderLogin.vue";
import FooterApp from "src/components/FooterApp.vue";
import HeaderCreate from "src/components/HeaderCreate.vue";

defineOptions({
  name: "ForgotPasswordPage",
});

const router = useRouter();

const form = ref({
  email: "",
});

const formRules = ref({
  email: [(val) => (val && val.length > 0) || "Email harus diisi"],
});

const onSubmit = async () => {
  try {
    const response = await axios.post(
      "http://127.0.0.1:8000/api/forgot_password",
      {
        email: form.value.email,
      }
    );

    console.log("API response:", response.data);

    router.push({ path: "verification" });
  } catch (error) {
    // Handle errors
    console.error("API error:", error);
  }
};
</script>
