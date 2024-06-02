<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <HeaderCreate
    title="Pembayaran dengan QRIS"
    backAction="/ringkasan-pesanan"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-md">
    <div class="text-center q-mb-lg">
      <span class="text-subtitle1 text-weight-bold"
        >Rp {{ this.totalPriceSum }}</span
      >
    </div>

    <div class="text-left">
      <span class="text-subtitle1 text-weight-bold">QRIS</span>
    </div>

    <q-card-section class="flex flex-center">
      <div class="column">
        <div class="text-center">
          <span class="text-subtitle1 text-weight-bold">Toko 1</span>
        </div>
        <img
          v-if="imageBlobUrl"
          :src="imageBlobUrl"
          alt="QRIS Image"
          class="qris-image"
        />
        <p v-if="error">{{ error }}</p>
      </div>
    </q-card-section>

    <div class="q-mb-xl">
      <q-btn
        color="primary"
        class="full-width"
        label="Cek Status Pesanan"
        @click="onSubmit"
        :disable="disableButton"
      />
    </div>

    <div class="text-left q-mb-md">
      <span class="text-subtitle1 text-weight-bold"
        >Cara membayar dengan QRIS</span
      >
    </div>

    <div class="row q-gutter-md">
      <div class="col">
        <q-img class="rounded-borders" src="https://fakeimg.pl/100x100/" />
        <span class="text-caption">Step 1</span>
      </div>
      <div class="col">
        <q-img class="rounded-borders" src="https://fakeimg.pl/100x100/" />
        <span class="text-caption">Step 2</span>
      </div>
      <div class="col">
        <q-img class="rounded-borders" src="https://fakeimg.pl/100x100/" />
        <span class="text-caption">Step 3</span>
      </div>
    </div>
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
// import { usePesananStore } from 'src/stores/pesanan-store';

const router = useRouter();
//const pesananStore = usePesananStore()

const disableButton = ref(false);
// // const statusPesanan = computed(() => {
//   return pesananStore.statusPesanan
// })

const dataPesanan = ref([
  {
    id: 1,
    img: "https://cdn.quasar.dev/img/boy-avatar.png",
    pesanan: "Menu 1",
    quantity: 1,
    price: 10000,
  },
  {
    id: 2,
    img: "https://cdn.quasar.dev/img/boy-avatar.png",
    pesanan: "Menu 2",
    quantity: 1,
    price: 15000,
  },
]);

const total = computed(() =>
  dataPesanan.value.reduce((a, b) => a + b.price, 0)
);

// const onSubmit = () => {
//   router.push({ path: "/status-pesanan" });
// };

const onSubmit = async () => {
  const guestId = sessionStorage.getItem("guestId");
  try {
    const requestBody = {
      guest_id: guestId,
      status_pembayaran: "Sudah dibayar",
    };

    const response = await axios.post(
      "http://127.0.0.1:8000/api/savetransaksi",
      requestBody
    );

    router.push({ path: "/status-pesanan" });

    console.log("Transaksi berhasil disimpan:", response.data);
  } catch (error) {
    console.error("Terjadi kesalahan saat menyimpan transaksi:", error);
  }
};

const getData = async () => {
  try {
    /*
     * cek status pesanan dari be.
     * ini hanya contoh.
     */
    // if(statusPesanan.value == 'CHECK') {
    //   disableButton.value = true
    // } else {
    //   disableButton.value = false
    // }
  } catch (error) {
    console.log(error);
  }
};

onMounted(() => {
  getData();
});
</script>

<style>
.text:hover {
  cursor: pointer;
  color: blue;
  text-decoration: underline;
}
</style>

<script>
import axios from "axios";
export default {
  components: {
    HeaderCreate,
  },
  formdata: {
    id_penjual: "",
  },
  qris: {
    imageBlobUrl: "",
  },
  mounted() {
    this.addRingkasan();
    this.getdata();
  },

  data() {
    return {
      totalPriceSum: "",
      imageBlobUrl: null,
      error: null,
    };
  },

  methods: {
    getdata() {
      const email = ref(localStorage.getItem("userEmail")).value;

      axios
        .post("http://127.0.0.1:8000/api/viewonepenjual", {
          email: email,
        })
        .then((response) => {
          // Handle the response here
          console.log(response.data);
          // this.id_penjual = response.data.id_penjual;
          this.id_penjual = 1;
          console.log(this.id_penjual);
          this.getqris();
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
    },

    getqris() {
      console.log("getdatamenu");
      console.log(this.id_penjual);
      axios
        .post(
          "http://127.0.0.1:8000/api/showqris",
          {
            // id_penjual: this.id_penjual,
            id_penjual: 23,
            qris: "qris",
          },
          { responseType: "blob" }
        )
        .then((response) => {
          // Handle the response here
          //
          this.imageBlobUrl = URL.createObjectURL(response.data);
          console.log(response.data);
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
    },

    addRingkasan() {
      this.guestId = sessionStorage.getItem("guestId");

      axios
        .post("http://127.0.0.1:8000/api/ringkasanpesanan", {
          guestId: this.guestId,
        })
        .then((response) => {
          console.log("a", response);
          this.totalPriceSum = response.data.total_price_sum;

          console.log("totprice", this.totalPriceSum);
        })
        .catch((error) => {
          console.error(error);
        });

      // this.ringkasanPesanan = response.data.data;
      // this.id_penjual = response.data.data.id_penjual;

      // this.id_menu = response.data.data[0].id_menu;
      // this.status_pesanan = response.data.data[0].status_pesanan;
    },
  },
};
</script>

<style scoped>
.qris-image {
  width: 350px; /* Set the width */
  height: 350px; /* Set the height to the same value to make it a square */
  object-fit: cover; /* Ensures the image covers the container while maintaining aspect ratio */
}
</style>
