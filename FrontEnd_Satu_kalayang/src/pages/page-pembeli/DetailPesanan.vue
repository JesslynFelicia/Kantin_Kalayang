<template>
  <q-layout v-if="menus && menus.id_penjual">
    <HeaderCreate
      title="Custom pesanan"
      :backAction="`/halaman-toko/${menus.id_penjual}`"
      :hideLogout="true"
      :hideProfile="true"
    />
    <!-- :backAction="`/halaman-toko/${menus.id_penjual}`" -->

    <q-page-container>
      <q-page>
        <div
          v-if="menus"
          style="display: flex; flex-direction: column; margin-top: 10px"
        >
          <div
            style="
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin: 2% 3.5%;
              margin-bottom: 0px;
            "
          >
            <h6 style="font-weight: 800; margin: 0">{{ menus.nama_menu }}</h6>
            <h6 style="font-weight: 800; margin: 0">
              Rp{{ menus.harga_menu }}
            </h6>
          </div>

          <p style="margin: 2% 3.5%; margin-top: 0px; font-size: 15px">
            {{ menus.desc_menu }}
          </p>
        </div>
        <div
          v-else
          style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2% 3.5%;
            margin-bottom: 0px;
          "
        >
          <q-skeleton height="70px" width="100%" wave />
        </div>

        <div style="display: flex; flex-direction: column; margin-top: 10px">
          <div style="margin: 2% 3.5%; margin-bottom: 0px">
            <h6 style="font-weight: 800; margin: 0">Catatan untuk penjual</h6>
            <p style="margin: 2% 0%; margin-top: 0px; font-size: 15px">
              *Opsional
            </p>
            <q-input
              outlined
              v-model="note"
              placeholder="Catatan untuk penjual"
              clearable
            >
              <template v-slot:prepend>
                <q-icon name="description" />
              </template>
            </q-input>
          </div>
        </div>

        <div class="floating-bar">
          <div
            style="
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-bottom: 0px;
            "
          >
            <h6 style="font-weight: 800; margin: 2% 0%; margin-bottom: 0px">
              Jumlah pesanan
            </h6>

            <q-btn
              rounded
              outline
              @click="kurangi"
              color="black"
              icon="remove"
              size="sm"
              style="width: 30px; height: 30px"
              :disable="nilai === 1"
            />

            <p style="margin: 0%; font-size: 20px; font-weight: 800">
              {{ nilai }}
            </p>

            <q-btn
              rounded
              outline
              @click="tambah"
              color="black"
              icon="add"
              size="sm"
              style="width: 30px; height: 30px"
            />
          </div>
          <q-btn
            color="primary"
            class="full-width"
            @click="addToCart(menus)"
            style="margin-top: 3%; font-weight: 700; font-size: 17px;"
          >
            Tambah pesanan - Rp{{ totalPrice }}
          </q-btn>
        </div>
      </q-page>
    </q-page-container>

    <q-page-container>
      <q-page>
        <p>
          {{ totalPrice }}
        </p>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import axios from "axios";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },

  data() {
    return {
      formData: {
        id: "",
      },
      result: {
        jenis: "",
        nama_menu: "",
        harga_menu: "",
        desc_menu: "",
        id_menu: "",
        id_penjual: "",
        id_: "",
      },
      menus: null,
      // nama_menu: "",
    };
  },
  mounted() {
    this.getMenu();
  },
  created() {},

  methods: {
    async addToCart(menu) {
      this.guestId = sessionStorage.getItem("guestId");
      const id_menu_array = Array(this.nilai).fill(menu.id_menu);
      try {
        const response = await axios.post("http://127.0.0.1:8000/api/guests", {
          guestId: this.guestId,
          id_menu: id_menu_array,
          id_penjual: menu.id_penjual,
          harga_menu: menu.harga_menu,
          note: this.note,
        });

        this.$router.replace(`/halaman-toko/${this.menus.id_penjual}`);

        console.log("response.data nya:", response.data);
      } catch (error) {
        console.error("error nih", error);
      }
    },

    getMenu() {
      const url = window.location.href;
      const regex = /\/(\d+)(\/|$)/;
      const match = url.match(regex);
      const id = match ? match[1] : null;

      axios
        .post("http://127.0.0.1:8000/api/viewonemenu", {
          id_menu: id,
        })
        .then((response) => {
          this.menus = response.data.data;
          this.tambah();
          this.nilai--;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    async tambah() {
      this.nilai++;
      // try {
      //   const response = await axios.post("http://127.0.0.1:8000/api/tambah", {
      //     id_menu: this.menus.id_menu,
      //   });

      //   console.log("response tambah: ", response.data);
      //   console.log("tambah: ", this.menus.id_menu);
      // } catch (error) {
      //   console.error("error nih", error);
      // }
    },
  },

  computed: {
    totalPrice() {
      return this.menus ? this.menus.harga_menu * this.nilai : 0;
    },
  },

  setup() {
    const nilai = ref(1);

    const kurangi = () => {
      if (nilai.value > 1) {
        nilai.value--;
      }
    };

    return {
      note: ref(""),
      nilai,
      // tambah,
      kurangi,
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

.q-btn{
  text-transform: none;
}
</style>
