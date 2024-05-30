<template>
  <q-page>
    <HeaderCreate
      title="Admin"
      backAction="/"
      :hideProfile="true"
    />

    <div class="content-container">
      <h6>Mau ngapain?</h6>
      <div class="btn-container">
        <q-btn
          color="secondary"
          text-color="black"
          label="Daftarkan Akun"
          @click="$router.replace('/register')"
        />
        <q-btn
          color="secondary"
          text-color="black"
          label="Daftar Akun Penjual"
          @click="$router.replace('/daftar-akun')"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";

export default {
  components: {
    HeaderCreate,
  },
};
</script>

<style scoped>
.content-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: calc(100vh - 64px); /* Adjusted for the header height */
}

.btn-container {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.q-btn {
  margin: 5px;
  min-width: 200px; /* Adjust button width as needed */
}
</style>
