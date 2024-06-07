<template>
  <!-- <HeaderCreate
    title="Pesanan Kamu"
    backAction="/pembayaran"
    :hideLogout="true"
    :hideProfile="true"
  /> -->

  <!-- <div> -->
  <q-card>
    <q-page class="q-pa-md">
      <div
        v-for="order in orders"
        :key="order.id_order"
        class="q-mb-md"
        style="margin-bottom: 10px"
      >
        <q-card-section>
          <div class="text-h6" style="margin-bottom: 10px; font-weight: 700">
            Pesanan Kamu
          </div>
          <q-table
            :rows="order.rows"
            hide-bottom
            :columns="columns"
            row-key="pesanan"
          />
        </q-card-section>

        <q-card-section>
          <div
            style="
              display: flex;
              justify-content: space-between;
              align-items: end;
              width: 100%;
            "
          >
            <div class="text-subtitle1" style="font-weight: 600">
              Total pembayaran
            </div>
            <div class="text-subtitle1" style="color: red; font-weight: 600">
              Rp{{ calculateTotal(order.rows) }}
            </div>
          </div>
        </q-card-section>

        <!-- STATUS -->
        <q-card class="my-card q-pa-md q-mb-lg">
          <div class="text-left q-mb-lg">
            <span class="text-subtitle1 text-weight-bold"
              >Status pesanan kamu</span
            >
          </div>

          <div
            class="row q-gutter-md q-mb-lg"
            v-if="this.localStatus !== null"
          >
            <!-- Pesanan dicek -->
            <div class="col text-center" v-if="this.localStatus !== 'TOLAK'">
              <div>
                <q-btn round color="secondary" size="md" icon="las la-check" />
              </div>
              <span class="text-caption">Pesanan dicek</span>
            </div>

            <!-- Pesanan diproses -->
            <div class="col text-center" v-if="this.localStatus !== 'TOLAK'">
              <div>
                <q-btn
                  round
                  :color="
                    this.localStatus === 'PROSESS'
                      ? 'secondary'
                      : this.localStatus === 'SELESAI'
                      ? 'secondary'
                      : 'grey-5'
                  "
                  :icon="
                    this.localStatus === 'PROSESS'
                      ? 'las la-check'
                      : this.localStatus === 'SELESAI'
                      ? 'las la-check'
                      : 'remove'
                  "
                  size="md"
                />
              </div>
              <span class="text-caption">Pesanan diproses</span>
            </div>

            <!-- Pesanan selesai -->
            <div class="col text-center" v-if="this.localStatus !== 'TOLAK'">
              <div>
                <q-btn
                  round
                  :color="
                    this.localStatus === 'SELESAI' ? 'secondary' : 'grey-5'
                  "
                  size="md"
                  :icon="
                    this.localStatus === 'SELESAI' ? 'las la-check' : 'remove'
                  "
                />
              </div>
              <span class="text-caption">Pesanan selesai</span>
            </div>

            <div class="col text-center" v-if="this.localStatus === 'TOLAK'">
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
      </div>
    </q-page>
  </q-card>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
// import HeaderCreate from "components/HeaderCreate.vue";
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
  name: "StatusPesanan",

  components: {
    // HeaderCreate,
  },

  data() {
    return {
      harga_menu: "",
      status_pesanan: "",
      totalPriceSum: "",

      orders: [],
      columns: [
        {
          name: "pesanan",
          label: "Pesanan",
          align: "left",
          field: (row) => row.pesanan,
        },
        {
          name: "note",
          label: "Note",
          align: "left",
          field: (row) => row.note,
        },
        { name: "jumlah", label: "Jumlah", align: "right", field: "jumlah" },
        {
          name: "harga",
          label: "Harga Satuan",
          align: "right",
          field: "harga",
          format: (val) => `Rp${val}`,
        },
        {
          name: "total",
          label: "Total",
          align: "right",
          field: "total",
          format: (val) => `Rp${val}`,
        },
      ],
    };
  },

  formdata: {
    id_penjual: "",
  },

  mounted() {
    this.statusPesanan();
  },

  // created() {
  //   this.statusPesanan();
  //   setInterval(() => {
  //     this.statusPesanan();
  //   }, 10000);
  // },

  methods: {
    // async statusPesanan() {
    //   this.guestId = sessionStorage.getItem("guestId");

    //   return axios
    //     .post("http://127.0.0.1:8000/api/status_pesanan", {
    //       guestId: this.guestId,
    //       status: "",
    //       id_order: "",
    //     })
    //     .then((response) => {
    //       console.log("Response:", response);
    //       const messages = response.data.message;
    //       this.id_penjual = response.data.message[0].id_penjual;
    //       this.id_order = response.data.message[0].id_order;

    //       if (Array.isArray(messages)) {
    //         messages.forEach((message, index) => {
    //           console.log(`id_menu at index ${index}:`, message.id_menu);
    //         });
    //       } else {
    //         console.log("Unexpected response format:", messages);
    //       }

    //       this.viewTransaksi();
    //     })
    //     .catch((error) => {
    //       console.error(error);
    //       throw error;
    //     });
    // },

    // viewTransaksi() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/viewtransaksi", {
    //       id_penjual: this.id_penjual,
    //     })
    //     .then((response) => {
    //       // kelompokin data dr id_order yang unik
    //       const groupedOrders = response.data.data.reduce((acc, order) => {
    //         if (!acc[order.id_order]) {
    //           acc[order.id_order] = {
    //             id_order: order.id_order,
    //             no_meja: order.nomor_meja,
    //             localStatus: order.status_pesanan, // Ubah status lokal berdasarkan status pesanan dari response
    //             rows: [],
    //           };
    //         }

    //         acc[order.id_order].rows.push({
    //           pesanan: order.nama_menu,
    //           jumlah: order.Jumlah_pesan,
    //           harga: order.harga_menu,
    //           total: order.Jumlah_pesan * order.harga_menu,
    //         });

    //         return acc;
    //       }, {});

    //       // ubah objek hasil pengelompokan jd array
    //       this.orders = Object.values(groupedOrders);

    //       console.log("Grouped Orders", this.orders);
    //       console.log("woi id order", this.id_order);
    //     })
    //     .catch((err) => {
    //       console.error(err);
    //     });
    // },

    async statusPesanan() {
      this.guestId = sessionStorage.getItem("guestId");

      return axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guestId: this.guestId,
          status: "",
          id_order: "",
        })
        .then((response) => {
          console.log("Response:", response);
          const messages = response.data.message;
          this.id_penjual = messages[0].id_penjual;
          this.id_order = messages[0].id_order;

          this.status_pesanan = messages[0].status_pesanan;
          this.localStatus = this.status_pesanan; 

          console.log("yayay", this.status_pesanan);

          if (Array.isArray(messages)) {
            messages.forEach((message, index) => {
              console.log(`id_menu at index ${index}:`, message.id_menu);
            });
          } else {
            console.log("Unexpected response format:", messages);
          }

          this.viewTransaksi();
        })
        .catch((error) => {
          console.error(error);
          throw error;
        });
    },

    viewTransaksi() {
      axios
        .post("http://127.0.0.1:8000/api/viewtransaksi", {
          id_penjual: this.id_penjual,
        })
        .then((response) => {
          // Filter data berdasarkan id_order yang sesuai
          const filteredData = response.data.data.filter(
            (order) => order.id_order === this.id_order
          );

          // Kelompokin data dari id_order yang unik
          const groupedOrders = filteredData.reduce((acc, order) => {
            if (!acc[order.id_order]) {
              acc[order.id_order] = {
                id_order: order.id_order,
                catatan_pemesan: order.catatan_pemesan,
                no_meja: order.nomor_meja,
                // localStatus: order.status_pesanan,
                rows: [],
              };
            }

            acc[order.id_order].rows.push({
              pesanan: order.nama_menu,
              note: order.catatan_pemesan,
              jumlah: order.Jumlah_pesan,
              harga: order.harga_menu,
              total: order.Jumlah_pesan * order.harga_menu,
            });

            return acc;
          }, {});

          // Ubah objek hasil pengelompokan jadi array
          this.orders = Object.values(groupedOrders);

          console.log("Grouped Orders", this.orders);
          console.log("woi id order", this.id_order);
          // console.log("status_pesanan:", this.orders[0].localStatus);
        })
        .catch((err) => {
          console.error(err);
        });
    },

    calculateTotal(rows) {
      return rows.reduce((total, row) => total + row.total, 0);
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
          console.log("yayay", this.status_pesanan);
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
