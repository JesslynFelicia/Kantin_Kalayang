import { route } from 'quasar/wrappers';
<template>
  <q-page
    style="
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    "
  >
    <HeaderCreate
      title="Admin"
      backAction="/"
      :hideProfile="true"
    />

    <div style="display: flex; flex-direction: column; align-items: center">
      <div style="margin-top: 20px">
        <h6 style="font-weight: 550; margin-bottom: 10px; margin-top: 0px">
          mau ngapain??
        </h6>
        <q-btn
          outline
          style="
            color: black;
            margin-right: 10px;
            padding: 50px;
            font-size: 16px;
          "
          label="Daftarkan akun"
          @click="$router.replace('/register')"
        />
        <q-btn
          outline
          style="
            color: black;
            margin-right: 10px;
            padding: 50px;
            font-size: 16px;
          "
          label="Daftar akun penjual"
          @click="$router.replace('/daftar-akun')"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  setup() {
    return {};
  },
};
</script>

<style>
.q-btn {
  text-transform: none;
}
</style>
