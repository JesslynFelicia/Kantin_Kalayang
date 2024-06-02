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
          <q-item-section>
            <q-item-label>{{ menu.count }}x</q-item-label>
          </q-item-section>

          <q-item-section>
            <q-item-label>{{ menu.nama_menu }}</q-item-label>
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

      <div class="row q-gutter-md q-mb-lg" v-if="status_pesanan !== null">
        <!-- Pesanan dicek -->
        <div class="col text-center" v-if="status_pesanan !== 'TOLAK'">
          <div>
            <q-btn round color="secondary" size="md" icon="las la-check" />
          </div>
          <span class="text-caption">Pesanan dicek</span>
        </div>

        <!-- Pesanan diproses -->
        <div class="col text-center" v-if="status_pesanan !== 'TOLAK'">
          <div>
            <q-btn
              round
              :color="
                status_pesanan === 'PROSESS'
                  ? 'secondary'
                  : status_pesanan === 'SELESAI'
                  ? 'secondary'
                  : 'grey-5'
              "
              size="md"
              icon="las la-check"
            />
          </div>
          <span class="text-caption">Pesanan diproses</span>
        </div>

        <!-- Pesanan selesai -->
        <div class="col text-center" v-if="status_pesanan !== 'TOLAK'">
          <div>
            <q-btn
              round
              :color="status_pesanan === 'SELESAI' ? 'secondary' : 'grey-5'"
              size="md"
              icon="las la-check"
            />
          </div>
          <span class="text-caption">Pesanan selesai</span>
        </div>

        <div class="col text-center" v-if="status_pesanan === 'TOLAK'">
          <span class="text-caption"
            >Pesanan ditolak penjual, silahkan hubungi penjual.</span
          >
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

// const status = ref("CHECK");

const total = computed(() =>
  dataPesanan.value.reduce((a, b) => a + b.price, 0)
);

// const onSubmit = () => {
//   status.value = "selesai";
// };
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
      status_pesanan: "",
      totalPriceSum: "",

      ringkasanPesanan: [],
    };
  },

  formdata: {
    id_penjual: "",
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
        this.id_penjual = response.data.data[0].id_penjual;
        console.log(this.id_penjual);

        this.getData();
      } catch (error) {
        console.error("error nih", error);
      }
    },

    getData() {
      this.guestId = sessionStorage.getItem("guestId");
      axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guest_id: this.guestId,
          // id_order: this.id_order,
          // status_pesanan: "",
        })
        .then((response) => {
          this.status_pesanan = response.data.message[0].status_pesanan;
          console.log(this.status_pesanan);
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
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
