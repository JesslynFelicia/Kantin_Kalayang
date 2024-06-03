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
                :color="colorClass(order.localStatus)"
              >
                {{ order.localStatus }}
              </q-badge>
            </div>
            <div style="display: flex; justify-content: space-between">
              <div class="text-right" style="padding-right:5px ;">No. Meja: </div>
              <div class="col text-right" style="font-weight: 700;"> {{ order.no_meja }}</div>
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
            class="button-status"
            v-if="
              order.localStatus !== 'Pesanan di Proses' &&
              order.localStatus !== 'Pesanan Selesai'
            "
            style="padding: 7px 23px"
            color="negative"
            rounded
            :disabled="order.localStatus === 'Pesanan Ditolak'"
            @click="rejectOrder(order.id_order)"
          >
            Tolak Pesanan
          </q-btn>
          <q-btn
            class="button-status"
            v-if="order.localStatus === 'Menunggu Konfirmasi'"
            color="positive"
            rounded
            style="padding: 7px 22px"
            label="Terima Pesanan"
            @click="acceptOrder(order.id_order)"
          >
          </q-btn>
          <q-btn
            class="button-status"
            v-if="order.localStatus === 'Pesanan di Proses'"
            color="positive"
            rounded
            style="padding: 7px 23px"
            label="Pesanan Selesai"
            :disabled="order.localStatus === 'Pesanan Selesai'"
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
    this.statusPesanan();
  },

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
                no_meja: order.nomor_meja,
                localStatus: "Menunggu Konfirmasi",
                rows: [],
              };
            }

            acc[order.id_order].rows.push({
              pesanan: order.nama_menu,
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

    // statusPesanan() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/status_pesanan", {
    //       // id_order: id_order,
    //       // status: "Pesanan Selesai",
    //       // guest_id: guestId,
    //       id_order: "#M3105240002",
    //       status: "",
    //       guest_id: "guest-7",
    //     })
    //     .then((response) => {
    //       console.log(response);
    //       console.log("aaa", response.data.message[1].status_pesanan);
    //     })
    //     .catch((error) => {
    //       console.error(error);
    //     });
    // },

    async statusPesanan(id_order) {
      return axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          id_order: "#M3105240002",
          status: "PROSESS",
          guest_id: "guest-7",
        })
        .then((response) => {
          console.log(response);
          const pesananSelesai = response.data.message.find(
            (message) => message.status_pesanan === "SELESAI"
          );
          return pesananSelesai ? "SELESAI" : null;
        })
        .catch((error) => {
          console.error(error);
          throw error;
        });
    },

    completeOrder(id_order) {
      this.statusPesanan(id_order)
        .then((status_pesanan) => {
          if (status_pesanan === "SELESAI") {
            this.updateLocalStatus(id_order, "Pesanan Selesai");
          }
        })
        .catch((error) => {
          console.error("Error completing order:", error);
        });
    },

    updateLocalStatus(id_order, status) {
      const order = this.orders.find((order) => order.id_order === id_order);
      if (order) {
        order.localStatus = status;
      }
    },

    rejectOrder(id_order) {
      this.updateLocalStatus(id_order, "Pesanan Ditolak");
      console.log("Rejected order id:", id_order);
    },

    acceptOrder(id_order) {
      this.updateLocalStatus(id_order, "Pesanan di Proses");
      console.log("Accepted order id:", id_order);
    },

    // completeOrder(id_order) {
    //   this.statusPesanan();
    //   this.updateLocalStatus(id_order, "Pesanan Selesai");
    // },

    // updateLocalStatus(id_order, status) {
    //   const order = this.orders.find((o) => o.id_order === id_order);
    //   if (order) {
    //     order.localStatus = status;
    //   }
    // },

    calculateTotal(rows) {
      return rows.reduce((total, row) => total + row.total, 0);
    },
    statusClass(status) {
      return {
        "status-circle": true,
        "status-waiting": status === "Menunggu Konfirmasi",
        "status-processing": status === "Pesanan di Proses",
        "status-rejected": status === "Pesanan Ditolak",
        "status-completed": status === "Pesanan Selesai",
      };
    },

    colorClass(status) {
      const localStatus = {
        "Menunggu Konfirmasi": "amber-7",
        "Pesanan di Proses": "blue-7",
        "Pesanan Ditolak": "red-7",
        "Pesanan Selesai": "green-7",
      };
      return localStatus[status];
    },

    // viewTransaksi() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/viewtransaksi", {
    //       // id_penjual: 1,
    //       id_penjual: this.id_penjual,
    //     })
    //     .then((response) => {
    //       console.log("response", response.data.data);
    //       console.log("response kak", response.data.data[0].id_order);
    //       response.data.data.forEach((item) => {
    //         console.log("id_order:", item.id_order);
    //         console.log("id penjual:", this.id_penjual);
    //       });
    //       this.orders = response.data.data.map((order) => {
    //         // const nama_menu = this.getMenu(order.id_menu);
    //         // const id_order = this.acceptOrder(order.id_order);

    //         // const id_order = order.id_order;
    //         // console.log("id Order", this.id_order);

    //         return {
    //           id_order: id_order,
    //           no_meja: order.nomor_meja,
    //           localStatus: "Menunggu Konfirmasi",
    //           // status_pesanan: order.status_pesanan,
    //           rows: [
    //             {
    //               pesanan: order.nama_menu,
    //               jumlah: order.Jumlah_pesan,
    //               harga: order.harga_menu,
    //               total: order.Jumlah_pesan * order.harga_menu,
    //             },
    //           ],
    //         };
    //       });
    //       console.log("Order", this.orders);
    //       console.log("id   Order", this.orders.id_order);
    //     })
    //     .catch((err) => {
    //       console.error(err);
    //     });
    // },
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
