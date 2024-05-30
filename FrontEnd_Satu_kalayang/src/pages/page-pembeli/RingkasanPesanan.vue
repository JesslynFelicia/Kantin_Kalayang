<template>
  <HeaderCreate
    title="Toko 1"
    backAction="halaman-toko/2"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-md">
    <div class="text-h6">Pilih tipe pemesanan</div>
    <q-item>
      <q-item-section avatar top>
        <q-radio val="dinein" v-model="selected" />
      </q-item-section>
      <q-item-section>
        <q-item-label>Makan ditempat</q-item-label>
        <q-item-label caption>Pilih tipe pengantaran</q-item-label>
        <q-item-label caption v-show="selected === 'dinein'">
          <div class="column">
            <div class="col">
              <q-radio
                val="ambil"
                v-model="subSelected"
                label="Ambil Pesanan"
              />
            </div>
            <div class="col">
              <div class="row">
                <div class="col-7">
                  <q-radio
                    val="antar"
                    v-model="subSelected"
                    label="Antar ke meja nomor"
                  />
                </div>
                <div class="col">
                  <q-input
                    outlined
                    v-model="table"
                    dense
                    style="width: 6ch"
                    :disable="subSelected !== 'antar'"
                  />
                </div>
              </div>
            </div>
          </div>
        </q-item-label>
      </q-item-section>
    </q-item>

    <q-item>
      <q-item-section avatar top>
        <q-radio val="takeaway" v-model="selected" />
      </q-item-section>
      <q-item-section> Bawa pulang </q-item-section>
    </q-item>

    <div class="row items-center justify-between">
      <div class="col-8">
        <div class="text-h6">Ringkasan Pesanan</div>
      </div>
      <div class="col text-right">
        <div class="text-caption text" @click="() => {}">Tambah Pesanan</div>
      </div>
    </div>

    <div style="max-width: 350px">
      <q-list padding>
        <q-item v-for="menu in ringkasanPesanan" :key="menu.id_menu">
          <q-item-section top avatar>
            <q-avatar rounded>
              <img  />
            </q-avatar>
          </q-item-section>

          <q-item-section>
            <q-item-label>{{ menu.nama_menu }}</q-item-label>
            <q-item-label caption>
              <span class="text" @click="() => {}">Edit</span>
            </q-item-label>
          </q-item-section>

          <q-item-section side>
            <q-item-label caption>{{ menu.harga_menu * menu.count}}</q-item-label>
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

    <q-footer class="bg-white">
      <div class="q-pa-md">
        <q-item>
          <q-item-section>
            <q-item-label class="text-weight-bold text-black"
              >Total Harga</q-item-label
            >
          </q-item-section>

          <q-item-section side>
            <q-item-label caption class="text-weight-bold">
              <div class="row items-center">
                <span class="q-mr-sm">Rp{{ totalPriceSum }}</span>
                <q-icon name="las la-shopping-bag" size="20px" />
              </div>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-btn
          color="primary"
          class="full-width"
          label="Bayar"
          @click="onSubmit"
        rounded
        />
      </div>
    </q-footer>
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
const table = ref("");

const onSubmit = () => {
  router.push({ path: "/pembayaran" });
};
</script>

<script>
import axios from "axios";

const selected = ref(null);
const subSelected = ref(null);

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
