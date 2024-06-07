<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <q-page class="q-pa-sm flex-center bg-grey-3">
    <!-- <div> -->
    <div
      v-for="order in orders"
      :key="order.id_order"
      class="q-mb-md"
      style="margin-bottom: 10px"
    >
      <q-card>
        <!-- <q-card v-for="order in orders" :key="order.id_order"> -->
        <q-card-section>
          <div class="row">
            <div :class="statusClass(order.localStatus)" class="col">
              <q-badge
                rounded
                style="padding: 8px 15px"
                :color="getStatusInfo(order.localStatus).color"
              >
                {{ getStatusText(order.localStatus) }}
              </q-badge>
            </div>
            <div class="col" style="display: flex; justify-content: flex-end">
              <div
                v-if="order.no_meja"
                style="padding-right: 5px"
                class="text-right"
              >
                No. Meja:
              </div>
              <div style="font-weight: 700" class="text-right">
                {{ order.no_meja }}
              </div>
            </div>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-section>
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

        <q-separator />
        <q-card-actions align="right">
          <q-btn
            v-if="order.localStatus !== 'PROSESS'"
            class="button-status"
            style="padding: 7px 23px"
            color="negative"
            rounded
            :disabled="order.localStatus === 'TOLAK'"
            @click="rejectOrder(order.id_order)"
          >
            Tolak Pesanan
          </q-btn>

          <q-btn
            v-if="order.localStatus === 'CHECK'"
            class="button-status"
            color="positive"
            rounded
            style="padding: 7px 22px"
            label="Terima Pesanan"
            @click="acceptOrder(order.id_order)"
          >
          </q-btn>

          <q-btn
            v-if="order.localStatus === 'PROSESS'"
            class="button-status"
            color="positive"
            rounded
            style="padding: 7px 23px"
            label="Pesanan Selesai"
            :disabled="order.localStatus === 'Pesanan selesai'"
            @click="completeOrder(order.id_order)"
          >
          </q-btn>
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import axios from "axios";
import {
  showLoading,
  hideLoading,
} from "src/composables/useLoadingComposables";

export default {
  components: {
    HeaderCreate,
  },

  formdata: {
    id_penjual: "",
  },

  mounted() {
    this.getData();
  },

  // created() {
  //   this.getData();
  //   setInterval(() => {
  //     this.getData();
  //   }, 10000);
  // },

  data() {
    return {
      id_order: "",
      orderAccepted: false,
      orderCompleted: false,
      tolak: false,
      // orderAccepted: {},
      // orderCompleted: {},
      resultData: [],
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

  methods: {
    getData() {
      const email = ref(localStorage.getItem("userEmail")).value;
      showLoading();
      axios
        .post("http://127.0.0.1:8000/api/viewonepenjual", {
          email: email,
        })
        .then((response) => {
          console.log(response.data);
          this.id_penjual = response.data.data.id_penjual;
          this.viewTransaksi();
          hideLoading();
        })
        .catch((error) => {
          console.error(error);
          hideLoading();
        });
    },

    viewTransaksi() {
      axios
        .post("http://127.0.0.1:8000/api/viewtransaksi", {
          id_penjual: this.id_penjual,
        })
        .then((response) => {
          // kelompokin data dr id_order yang unik
          const groupedOrders = response.data.data.reduce((acc, order) => {
            if (!acc[order.id_order]) {
              acc[order.id_order] = {
                id_order: order.id_order,
                catatan_pemesan: order.catatan_pemesan,
                no_meja: order.nomor_meja,
                localStatus: order.status_pesanan, // Ubah status lokal berdasarkan status pesanan dari response
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

          // ubah objek hasil pengelompokan jd array
          this.orders = Object.values(groupedOrders);

          console.log("Grouped Orders", this.orders);
        })
        .catch((err) => {
          console.error(err);
        });
    },

    async acceptOrder(id_order) {
      return axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guest_id: "",
          status: "PROSESS",
          id_order: id_order, // gunakan id_order dari parameter
        })
        .then(() => {
          this.viewTransaksi();
        })
        .catch((error) => {
          console.error(error);
          throw error;
        });
    },

    async completeOrder(id_order) {
      return axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guest_id: "",
          status: "SELESAI",
          id_order: id_order,
        })
        .then(() => {
          this.viewTransaksi();
        })
        .catch((error) => {
          console.error(error);
          throw error;
        });
    },

    async rejectOrder(id_order) {
      return axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guest_id: "",
          status: "TOLAK",
          id_order: id_order,
        })
        .then(() => {
          this.viewTransaksi();
        })
        .catch((error) => {
          console.error(error);
          throw error;
        });
    },

    statusClass(status) {
      return {
        "status-circle": true,
        "status-waiting": status === "CHECK",
        "status-processing": status === "PROSESS",
        "status-rejected": status === "TOLAK",
        "status-completed": status === "SELESAI",
      };
    },

    getStatusText(status) {
      const statusText = {
        CHECK: "Menunggu Konfirmasi",
        PROSESS: "Pesanan di Proses",
        SELESAI: "Pesanan Selesai",
        TOLAK: "Pesanan ditolak",
      };
      return statusText[status] || "Unknown Status";
    },

    getStatusInfo(status) {
      const statusInfo = {
        CHECK: { text: "Menunggu Konfirmasi", color: "secondary" },
        PROSESS: { text: "Pesanan di Proses", color: "blue-7" },
        SELESAI: { text: "Pesanan Selesai", color: "green-7" },
        TOLAK: { text: "Pesanan ditolak", color: "negative" },
      };
      return statusInfo[status] || { text: "Unknown Status", color: "grey" };
    },

    calculateTotal(rows) {
      return rows.reduce((total, row) => total + row.total, 0);
    },
  },
};
</script>

<style>
.button-status {
  margin: 10px;
}

.q-card {
  border-radius: 10px;
}
</style>
