<template>
  <HeaderLogin :button-link="true" title-button-link="Kirim Ulang" :isChildren="true" @back="() => $router.go(-1)"
    @link="() => { }" />
  <q-page class="q-pa-xl">
    <div class="text-center q-mb-xl">
      <span class="text-h4 text-weight-bold">Verifikasi Email</span>
    </div>
    <div class="row q-gutter-x-lg justify-center">
      <InputOtp :input-length="4" v-on:update:model-value="(value) => otp = value" />
    </div>
    <div class="q-mt-xl">
      <q-btn color="primary" class="full-width" label="Kirim Kode" type="submit" @click="onSubmit" />
    </div>
  </q-page>
  <FooterApp title="Sudah memiliki akun ?" button-link="Masuk" @link="() => $router.push({ path: '/' })" />
</template>

<script setup>
import { ref } from 'vue'
import HeaderLogin from 'src/components/HeaderLogin.vue'
import FooterApp from 'src/components/FooterApp.vue'
import InputOtp from 'src/components/InputOtp.vue';

const otp = ref('')

const onSubmit = () => {
  console.log(otp.value)
}
</script>
