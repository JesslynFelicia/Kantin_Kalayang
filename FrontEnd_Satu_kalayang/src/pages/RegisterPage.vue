<template>
  <q-page class="">
    <q-form @submit="register" action="/tes">
      <q-input v-model="formData.email" label="Email" />
      <q-input v-model="formData.nama_toko" label="Nama Toko" />
      <q-input v-model="formData.nama_pemilik_toko" label="Nama Pemilik Toko" />
      <q-input v-model="formData.nomor_telepon" label="Nomor Telepon" />
      <q-input v-model="formData.nomor_toko" label="Nomor toko" />
      <q-btn type="submit" label="Register" color="primary" />
    </q-form>
  </q-page>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import useNotify from 'src/composables/UseNotify';
import useDialog from 'src/composables/UseDialog';

const { notifyError, notifySuccess } = useNotify();
// const { dialogShow } = useDialog();

const formData = ref({
  email: '',
  nama_toko: '',
  nama_pemilik_toko: '',
  nomor_telepon: '',
  nomor_toko: '',
});

const register = async () => {
  try {
    // dialogShow({
    //   title: 'Logout Confirmation',
    //   message: 'Do you really want to exit the application?',
    // });
    await axios.post('http://127.0.0.1:8000/api/savedatanew', formData.value);
    // Reset form after successful submission
    formData.value = {
      email: '',
      nama_toko: '',
      nama_pemilik_toko: '',
      nomor_telepon: '',
      nomor_toko: '',
    };
    notifySuccess('Akun berhasil dibuat!');

  } catch (error) {
    notifyError('Mohon isi semua form!');
  }
};

defineOptions({
  name: "RegisterPage",
});
</script>
