import { route } from 'quasar/wrappers';

<template>
  <div>
  <HeaderCreate title="Rekap" backAction="/beranda-penjual" />
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
  <p>rekap</p>
</div>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
};
</script>
