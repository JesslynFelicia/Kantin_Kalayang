import { route } from 'quasar/wrappers';
<template>
  <!-- <q-btn flat @click="$router.replace('/')" icon="arrow_back" style="margin-top: 5px;"></q-btn> -->
  <HeaderCreate
    :title="toko.toString()"
    backAction="/detail-pesanan"
    :hideLogout="true"
    :hideProfile="true"
  />

  <div style="display: flex; flex-direction: column; margin-top: 10px">
    <h6 style="font-weight: 800; margin: 2% 3.5%; margin-bottom: 0px">
      Pilih tipe pemesanan
    </h6>
  </div>

  <q-list>
    <q-item tag="label" v-ripple>
      <q-item-section avatar>
        <q-radio v-model="type" val="line" color="orange" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Makan di tempat</q-item-label>
        <q-item-label v-if="type === 'line'" caption
          >Pilih tipe pengantaran
        </q-item-label>
      </q-item-section>
    </q-item>

    <div style="margin: 0px 7%">
      <q-item v-if="type === 'line'" tag="label" v-ripple>
        <q-item-section avatar>
          <q-radio v-model="type1" val="a" color="orange" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Ambil pesanan</q-item-label>
        </q-item-section>
      </q-item>

      <q-item v-if="type === 'line'" tag="label" v-ripple>
        <q-item-section avatar>
          <q-radio v-model="type1" val="b" color="orange" />
        </q-item-section>
        <q-item-section>
          <q-item-label>Antar ke meja nomor:</q-item-label>
        </q-item-section>
      </q-item>
    </div>

    <q-item tag="label" v-ripple>
      <q-item-section avatar>
        <q-radio v-model="type" val="orange" color="orange" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Bawa pulang</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>

  <div
    style="
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      margin-top: 10px;
      align-items: center;
    "
  >
    <h6 style="font-weight: 800; margin: 2% 3.5%; margin-bottom: 0px">
      Ringkasan Pesanan
    </h6>
    <p
      style="color: grey; font-weight: 800; margin: 2% 3.5%; margin-bottom: 0px"
    >
      Tambah Pesanan
    </p>
  </div>

  <div style="display: flex; flex-direction: column; margin: 3% 3%">
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
        <p
          @click="$router.replace('/detail-pesanan')"
          flat
          no-caps
          style="font-weight: 800; margin: 0%; padding: 0%"
        >
          Edit
        </p>
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

  <div class="floating-bar">
    <q-separator color="grey"></q-separator>

    <div
      style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0%;
        margin-top: 4%;
        font-size: 15px;
        font-weight: 900;
      "
    >
      <p>Total harga</p>
      <p>Rp18.000</p>
    </div>

    <q-btn
      @click="$router.replace('/halaman-pembayaran')"
      outline
      style="margin-top: 0%; font-weight: 800"
    >
      Bayar
    </q-btn>
  </div>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },

  setup() {
    const toko = ref("Toko 1");

    return {
      toko,
      type: ref(""),
      type1: ref(""),
    };
  },
};
</script>

<style>
.floating-bar {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: white;
  display: flex;
  flex-direction: column;
  padding: 5% 7%;
}
</style>
