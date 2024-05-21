<template>
  <HeaderLogin :button-link="true" title-button-link="Lupa Kata Sandi ?" @link="link" />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Login</span>
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
        <label class="text-subtitle1">Kata Sandi</label>
        <q-input outlined v-model="form.password" :type="seePassword ? 'password' : 'text'" lazy-rules
          :rules="formRules.password">
          <template v-slot:prepend>
            <q-icon name="las la-lock" />
          </template>
          <template v-slot:append>
            <q-icon :name="seePassword ? 'las la-eye' : 'las la-eye-slash'" @click="seePassword = !seePassword"
              class="cursor-pointer" />
          </template>
        </q-input>
        <q-checkbox v-model="form.remember" size="sm" label="Ingat saya" class="" />
      </div>

      <div class="q-mb-lg">
        <q-btn color="primary" class="full-width" label="Masuk" type="submit" />
      </div>
    </q-form>
  </q-page>
  <FooterApp title="Belum Punya Akun ?" button-link="Daftar sekarang" />
</template>

<script setup>
import HeaderLogin from 'components/HeaderLogin.vue'
import FooterApp from 'components/FooterApp.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

defineOptions({
  name: 'LoginPage'
});

const router = useRouter()

const seePassword = ref(true)
const form = ref({
  email: '',
  password: '',
  remember: false
})

const formRules = ref({
  email: [val => (val && val.length > 0) || 'Email harus diisi'],
  password: [val => (val && val.length > 0) || 'Kata sandi harus diisi']
})

const onSubmit = () => {
  console.log(form.value)
  router.push({ path: '/beranda-penjual' })

}

const link = () => {
  router.push({ path: 'forgot-password' })
}
</script>
