import { route } from 'quasar/wrappers';
<template>
  <!-- <q-btn flat @click="$router.replace('/')" icon="arrow_back" style="margin-top: 5px;"></q-btn> -->
  <HeaderCreate
    title="Pesanan kamu"
    backAction="/halaman-pembayaran"
    :hideLogout="true"
    :hideProfile="true"
  />

  <div style="display: flex; flex-direction: column; margin: 5% 5%">
    <div
      style="
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 5%;
      "
    >
      <q-badge outline color="primary" style="padding: 5px"> 1x </q-badge>
      <div
        style="
          display: flex;
          flex-direction: column;
          margin-right: auto;
          margin-left: 5%;
        "
      >
        <p style="font-weight: 800; margin: 0; margin-right: 5px">Menu 1</p>
      </div>
      <p style="font-size: 15px; font-weight: 400; margin-right: 3.5%">
        18.000
      </p>
    </div>
    <q-separator></q-separator>

    <div style="display: flex; flex-direction: column; margin: 3% 3%">
      <div
        style="
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
          padding-bottom: 0%;
        "
      >
        <p style="font-size: 15px; font-weight: 600">Total</p>
        <p style="font-size: 15px; font-weight: 600">Rp18.000</p>
      </div>
    </div>
  </div>

  <q-card bordered flat style="margin: 20px; padding: 20px; border-color: black;">
    <h6 style="font-weight: 800; margin: 0px">Status pemesanan kamu</h6>
    <div style="display: flex; flex-direction: column">
      <q-btn
        @click="$router.replace('/status-pesanan')"
        outline
        no-caps
        style="margin-top: 4%; font-weight: 800"
      >
        Pesanan diterima
      </q-btn>

      <q-btn
        @click="$router.replace('/status-pesanan')"
        outline
        no-caps
        style="margin-top: 4%; font-weight: 800; color: red;"
      >
        Hubungi Penjual
      </q-btn>
    </div>
  </q-card>
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
