<template>
  <HeaderCreate title="Pesanan" backAction="/beranda-penjual" />
  <q-page class="q-pa-md">
    <div v-for="order in orders" :key="order.id_order" class="q-mb-md">
      <q-card>
        <q-card-section>
          <!-- <div :class="statusClass(order.status_pesanan)">
            {{ order.status_pesanan }}
          </div> -->
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
            @click="rejectOrder(order)"
          />
          <q-btn
            color="positive"
            label="Terima Pesanan"
            @click="acceptOrder(order)"
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

  data() {
    return {
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
          format: (val) => `Rp ${val}`,
        },
        {
          name: "total",
          label: "Total",
          align: "right",
          field: "total",
          format: (val) => `Rp ${val}`,
        },
      ],

      order: {
        rows: [],
      },
    };
  },
  // formdata: {
  //   id_penjual: "",
  // },

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
  //   nama_menu: "",
  // },

  mounted() {
    this.getdata();
  },

  setup() {
    return {};
  },

  methods: {
    formdata: {
      nama_menu: "",
    },

    getStatus() {
      axios
        .post("http://127.0.0.1:8000/api/status_pesanan", {
          guest_id: "",
          order_id: this.id_order,
          //check
          //prosess
          //siap
          //selesai
          //tolak
          status_pesanan: this.status_pesanan,
          // id_menu: this.id_menu,
        })
        .then((response) => {
          this.menus = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },

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
          this.getdatariwayat();
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
    },

    getdatariwayat() {
      axios
        .post("http://127.0.0.1:8000/api/viewtransaksi", {
          id_penjual: this.id_penjual,
        })
        .then((response) => {
          console.log("response", response.data.data);
          const orders = response.data.data;

          // Use Promise.all to wait for all menu name fetches to complete
          Promise.all(
            orders.map((order) => {
              return axios
                .post("http://127.0.0.1:8000/api/viewonemenu", {
                  id_menu: order.id_menu,
                })
                .then((menuResponse) => {
                  const nama_menu = menuResponse.data.data.nama_menu;
                  return {
                    id_order: order.id_order,
                    status_pesanan: order.status_pesanan,
                    order: {
                      rows: [
                        {
                          pesanan: nama_menu,
                          jumlah: order.Jumlah_pesan,
                          harga: order.harga_menu,
                          total: order.Jumlah_pesan * order.harga_menu,
                        },
                      ],
                    },
                  };
                })
                .catch((menuErr) => {
                  console.error(menuErr);
                  return null; // Handle the error case appropriately
                });
            })
          )
            .then((ordersWithMenu) => {
              // Filter out any null entries in case of errors
              this.orders = ordersWithMenu.filter((order) => order !== null);
              console.log("a", this.orders); // Check the final orders with menu names
            })
            .catch((err) => {
              console.error("Error fetching menu names:", err);
            });
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>
