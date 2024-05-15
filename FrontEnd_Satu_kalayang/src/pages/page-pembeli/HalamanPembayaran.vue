import { route } from 'quasar/wrappers';
<template>
  <!-- <q-btn flat @click="$router.replace('/')" icon="arrow_back" style="margin-top: 5px;"></q-btn> -->
  <HeaderCreate
    title="sabar yaahhhhhh"
    backAction="/ringkasan-pesanan"
    :hideLogout="true"
    :hideProfile="true"
  />
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  setup() {},
};
</script>
