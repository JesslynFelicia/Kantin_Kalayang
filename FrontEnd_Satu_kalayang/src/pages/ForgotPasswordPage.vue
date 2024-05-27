<template>
  <HeaderLogin :button-link="true" title-button-link="Butuh Bantuan ?" :isChildren="true" @back="() => $router.go(-1)" />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Lupa Kata Sandi</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="q-mb-lg">
        <label class="text-subtitle1">Email</label>
        <q-input outlined v-model="form.email" type="email" lazy-rules :rules="formRules.email">
          <template v-slot:prepend>
            <q-icon name="las la-envelope" />
          </template>
        </q-input>
      </div>

      <div class="q-mb-lg">
        <q-btn color="primary" class="full-width" label="Lanjutkan" type="submit" />
      </div>
    </q-form>
  </q-page>
  <FooterApp title="Sudah memiliki akun ?" button-link="Masuk" @link="() => $router.push({ path: '/login' })" />
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import HeaderLogin from 'src/components/HeaderLogin.vue'
import FooterApp from 'src/components/FooterApp.vue'

defineOptions({
  name: 'ForgotPasswordPage'
});

const router = useRouter()

const form = ref({
  email: '',
});

const formRules = ref({
  email: [val => (val && val.length > 0) || 'Email harus diisi'],
})

const onSubmit = () => {
  router.push({ path: 'verification' })
}

</script>
