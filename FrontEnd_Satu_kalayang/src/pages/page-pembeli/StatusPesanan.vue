<template>
  <HeaderCreate
    title="Pesanan Kamu"
    backAction="/pembayaran"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-md">
    <div style="max-width: 350px">
      <q-list padding>
        <q-item v-for="menu in ringkasanPesanan" :key="menu.id_menu">
          <q-item-section top avatar>
            <q-avatar rounded>
              <img />
            </q-avatar>
          </q-item-section>

          <q-item-section>
            <q-item-label>{{ menu.nama_menu }}</q-item-label>
            <q-item-label caption>
              <span class="text" @click="() => {}">Edit</span>
            </q-item-label>
          </q-item-section>

          <q-item-section side>
            <q-item-label caption>{{
              menu.harga_menu * menu.count
            }}</q-item-label>
          </q-item-section>
        </q-item>
        <q-separator spaced />

        <q-item>
          <q-item-section>
            <q-item-label>Total</q-item-label>
          </q-item-section>

          <q-item-section side>
            <q-item-label caption>Rp{{ totalPriceSum }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </div>

    <q-card class="my-card q-pa-md q-mb-lg">
      <div class="text-left q-mb-lg">
        <span class="text-subtitle1 text-weight-bold">Status pesanan kamu</span>
      </div>

      <div class="row q-gutter-md q-mb-lg">
        <div class="col text-center">
          <div>
            <q-btn round color="secondary" size="md" icon="las la-check" />
          </div>
          <span class="text-caption">Pesanan dicek</span>
        </div>
        <div class="col text-center">
          <div>
            <q-btn
              round
              :color="status === 'ditolak' ? 'negative' : 'secondary'"
              size="md"
              :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
            />
          </div>
          <span class="text-caption">Pesanan diproses</span>
        </div>
        <div class="col text-center">
          <div>
            <q-btn
              round
              :color="
                status === 'ditolak'
                  ? 'negative'
                  : status === 'diterima' || status === 'selesai'
                  ? 'secondary'
                  : 'grey-5'
              "
              size="md"
              :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
            />
          </div>
          <span class="text-caption">Pesanan diantar</span>
        </div>
        <div class="col text-center">
          <div>
            <q-btn
              round
              :color="
                status === 'ditolak'
                  ? 'negative'
                  : status === 'selesai'
                  ? 'secondary'
                  : 'grey-5'
              "
              size="md"
              :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
            />
          </div>
          <span class="text-caption">Pesanan selesai</span>
        </div>
      </div>
      <div class="q-mb-md">
        <q-btn
          color="negative"
          class="full-width"
          outline
          label="Hubungi Penjual"
          @click="() => {}"
        />
      </div>
    </q-card>
  </q-page>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import HeaderCreate from "components/HeaderCreate.vue";
import {
  showLoading,
  hideLoading,
} from "src/composables/useLoadingComposables";
import { toRupiah } from "src/libs/currency";

const router = useRouter();

const status = ref("diterima");

const total = computed(() =>
  dataPesanan.value.reduce((a, b) => a + b.price, 0)
);

const onSubmit = () => {
  status.value = "selesai";
};
</script>

<script>
import axios from "axios";

export default {
  name: "HalamanToko",

  components: {
    HeaderCreate,
  },

  data() {
    return {
      harga_menu: "",
      totalPriceSum: "",

      ringkasanPesanan: [],
    };
  },

  mounted() {
    this.addRingkasan();
  },

  methods: {
    async addRingkasan() {
      this.guestId = sessionStorage.getItem("guestId");

      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/ringkasanpesanan",
          {
            guestId: this.guestId,
          }
        );
        this.ringkasanPesanan = response.data.data;

        this.totalPriceSum = response.data.total_price_sum;
      } catch (error) {
        console.error("error nih", error);
      }
    },
  },
};
</script>

<style>
.text:hover {
  cursor: pointer;
  color: blue;
  text-decoration: underline;
}
</style>
