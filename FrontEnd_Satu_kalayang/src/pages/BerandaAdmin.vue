<template>
  <q-page>
    <HeaderCreate title="Admin" backAction="/" :hideProfile="true" />

    <div class="admin-container">
      <div class="admin-btn">
        <q-btn
          class="admin-btn-2"
          outline
          style="
            color: black;
            margin-right: 10px;
            padding: 50px;
            font-size: 16px;
          "
          label="Daftar akun"
          @click="$router.replace('/register')"
        />
        <q-btn
          class="admin-btn-2"
          outline
          style="color: black; padding: 50px; font-size: 16px"
          label="Reset kata sandi"
          @click="$router.replace('/forgot-password')"
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
.admin-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: calc(100vh - 60px); /* Adjust this value based on the height of your header */
}

.q-btn {
  text-transform: none;
}

@media screen and (max-width: 600px) {
  .admin-btn-2 {
    height: 50px;
    padding: 20px;
    margin: 10px;
    justify-content: center;
  }

  .admin-btn {
    display: flex;
    flex-direction: column;
    margin: 20px;
  }
}
</style>
