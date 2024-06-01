<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <q-page class="q-pa-md">
    <div v-for="order in orders" :key="order.id_order" class="q-mb-md">
      <q-card>
        <q-card-section>
          <div :class="statusClass(status)">
            {{ status }}
          </div>
        </q-card-section>

        <q-separator />

        <q-card-section>
          <q-table :rows="order.rows" :columns="columns" row-key="pesanan" />
        </q-card-section>

        <q-card-section>
          <div class="text-right text-subtitle1">
            Total yang harus dibayar: Rp
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn
            color="negative"
            label="Tolak Pesanan"
            v-if="!orderCompleted[order.id_order]"
            :disabled="orderAccepted[order.id_order]"
            @click="rejectOrder(order.id_order)"
          />
          <q-btn
            v-if="!orderAccepted[order.id_order]"
            color="positive"
            label="Terima Pesanan"
            @click="acceptOrder(order.id_order)"
          />
          <q-btn
            v-else
            color="positive"
            label="Pesanan Selesai"
            :disabled="orderCompleted[order.id_order]"
            @click="completeOrder(order.id_order)"
          />
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import axios from "axios";
export default {
  components: {
    HeaderCreate,
  },

  formdata: {
    id_penjual: "",
  },
  // showdaftarpesanan: {
  //   id_menu: "7",
  //   id_order: "#M3105240001",
  //   formatted_tanggal_pemesanan: "31/05/2024 09:56",
  //   nomor_meja: "18",
  //   status_pesanan: "CHECK",
  //   catatan_pemesan: "",
  //   created_at: "2024-05-31T14:34:56.000000Z",
  //   updated_at: "2024-05-31T14:34:56.000000Z",
  //   Jumlah_pesan: "x2",
  //   id_penjual: "1",
  //   harga_menu: "40000",
  // },
  mounted() {
    this.getData();
  },

  data() {
    return {
      id_order: "",
      // orderAccepted: false,
      // orderCompleted: false,
      orderAccepted: {},
      orderCompleted: {},
      resultData: [],
      orders: [],
      status: "Menunggu Konfirmasi", // atau 'Pesanan di Proses'
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
      // rows: [
      //   {
      //     pesanan: this.nama_menu1,
      //     // jumlah: this.order.Jumlah_pesan,
      //     // harga: this.order.harga_menu,
      //     // total: this.order.Jumlah_pesan * order.harga_menu,
      //   },
      // ],
    };
  },

  computed: {
    ordersByOrderId() {
      const ordersByOrderId = {};
      this.orders.forEach((order) => {
        if (!ordersByOrderId[order.id_order]) {
          ordersByOrderId[order.id_order] = {
            id_order: order.id_order,
            status_pesanan: order.status_pesanan,
            rows: [],
          };
        }
        ordersByOrderId[order.id_order].rows.push({
          nama_menu: order.nama_menu,
          jumlah_pesan: order.Jumlah_pesan,
          harga_menu: order.harga_menu,
        });
      });
      return Object.values(ordersByOrderId);
    },
  },

  methods: {
    // getDataRiwayat() {
    //   console.log("getdatamenu");
    //   console.log(this.id_penjual);
    //   axios
    //     .post("http://127.0.0.1:8000/api/viewtransaksi", {
    //       id_penjual: this.id_penjual,
    //     })
    //     .then((response) => {
    //       console.log("response", response.data.data);
    //       this.id_menu = response.data.data[0].id_menu;
    //       this.id_order = response.data.data[0].id_order;
    //       this.formatted_tanggal_pemesanan =
    //         response.data.data[0].formatted_tanggal_pemesanan;
    //       this.nomor_meja = response.data.data[0].nomor_meja;
    //       this.status_pesanan = response.data.data[0].status_pesanan;
    //       this.catatan_pemesan = response.data.data[0].catatan_pemesan;
    //       this.created_at = response.data.data[0].created_at;
    //       this.updated_at = response.data.data[0].updated_at;
    //       this.Jumlah_pesan = response.data.data[0].Jumlah_pesan;
    //       this.id_penjual = response.data.data[0].id_penjual;
    //       this.harga_menu = response.data.data[0].harga_menu;
    //     })
    //     .catch((err) => {
    //       // Handle errors here
    //       this.error = err;
    //       console.error(err);
    //     });
    // },
    getData() {
      const email = ref(localStorage.getItem("userEmail")).value;

      axios
        .post("http://127.0.0.1:8000/api/viewonepenjual", {
          email: email,
        })
        .then((response) => {
          console.log(response.data);
          this.id_penjual = response.data.data.id_penjual;
          // this.id_penjual = 1;
          console.log(this.id_penjual);
          console.log("response11", response.data.data);
          this.getDataRiwayat();
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
    },

    getDataRiwayat() {
      axios
        .post("http://127.0.0.1:8000/api/viewtransaksi", {
          id_penjual: this.id_penjual,
        })
        .then((response) => {
          console.log("response", response.data.data);
          response.data.data.forEach((item) => {
            console.log("id_order:", item.id_order);
          });
          this.orders = response.data.data.map((order) => {
            // const nama_menu = this.getMenu(order.id_menu);
            // const id_order = this.acceptOrder(order.id_order);
            const id_order = order.id_order;
            return {
              id_order: id_order,
              // status_pesanan: order.status_pesanan,
              rows: [
                {
                  pesanan: order.nama_menu,
                  jumlah: order.Jumlah_pesan,
                  harga: order.harga_menu,
                  total: order.Jumlah_pesan * order.harga_menu,
                },
              ],
            };
          });
        })
        .catch((err) => {
          console.error(err);
        });
    },

    completeOrder() {
      axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          id_order: this.id_order,
          status: this.status,
          guestId: "",
        })
        .then((response) => {
          this.status = "Pesanan Selesai";
          this.orderCompleted = true;
          console.log(response);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    statusClass(status) {
      return {
        "status-circle": true,
        "status-waiting": status === "Menunggu Konfirmasi",
        "status-processing": status === "Pesanan di Proses",
        "status-rejected": status === "Pesanan Ditolak",
      };
    },

    rejectOrder() {
      this.status = "Pesanan Ditolak";
    },

    acceptOrder() {
      this.status = "Pesanan di Proses";

      this.orderAccepted = true;
    },
  },
};
</script>
