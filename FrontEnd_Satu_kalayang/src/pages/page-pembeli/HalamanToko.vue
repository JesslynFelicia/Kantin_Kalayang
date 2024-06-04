import { route } from 'quasar/wrappers';
<template>
  <!-- hrsnya title ttp sesuai sama nama toko yang lagi dibuka -->
  <HeaderCreate
    :title="getNamaToko()"
    backAction="/beranda-pembeli"
    :hideLogout="true"
    :hideProfile="true"
  >
  </HeaderCreate>

  <!-- eslint-disable-next-line -->
  <div style="display: flex; justify-content: center; height: 100vh">
    <q-page style="display: flex; flex-direction: column; height: 100vh">
      <div style="display: flex; flex-direction: column; align-items: center">
        <!-- <h6 style="font-weight: 800; margin: 0%">SATU KALAYANG</h6> -->

        <q-input
          outlined
          class="search-bar"
          v-model="text"
          placeholder="Cari makanan / toko"
          color="black"
          style="padding-top: 10px; width: 93%"
        >
          <!-- <q-icon name="event" color="orange" /> -->
          <q-btn
            unelevated
            size="13px"
            no-caps
            class="text-weight-medium"
            icon="search"
            style="padding: 0%"
          />
        </q-input>
      </div>

      <!-- <div style="flex-direction: column; margin-top: 10px">
        <div
          style="display: flex"
          v-for="(menu, index) in menus"
          :key="index"
          @click="$router.replace('/detail-pesanan')"
        >
          <div style="text-align: center">
            <img
              src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
              alt="Deskripsi Foto"
              class="category"
            />
            <div style="display: flex; margin-left: 10%">
              <div style="text-align: left">
                <p style="margin: 0; font-weight: 700; font-size: 15px">
                  {{ menu.nama_menu }}
                </p>
                <p style="margin: 0">Rp{{ menu.harga_menu }}</p>
              </div>
              <q-btn
                unelevated
                size="14px"
                no-caps
                rounded
                class="text-weight-medium"
                icon="add_circle_outline"
                @click="$router.replace('/detail-pesanan')"
                style="margin-left: auto; margin-bottom: auto; margin-right: 5%"
              />
            </div>
          </div>
        </div>
      </div> -->

      <!--
      <div class="menu-container">
        <div
          style="width: 40%; margin: 10px 5px"
          v-for="(menu, index) in menus"
          :key="index"
          @click="$router.replace('/detail-pesanan')"
        >
          <img
            style="margin: 10px"
            src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
            alt="Deskripsi Foto"
            class="category"
          />
          <div style="display: flex; margin-left: 10%">
            <div style="text-align: left">
              <p style="margin: 0; font-weight: 700; font-size: 15px">
                {{ menu.nama_menu }}
              </p>
              <p style="margin: 0">Rp{{ menu.harga_menu }}</p>
            </div>
            <q-btn
              unelevated
              size="14px"
              no-caps
              rounded
              style="margin-left: auto; margin-bottom: auto; margin-right: 5%"
              icon="add_circle_outline"
              @click="$router.replace('/detail-pesanan')"
            />
          </div>
        </div>
      </div> -->

      <div class="menu-container">
        <div
          v-for="(menu, index) in menus.filter(
            (menu) => menu.status_menu === 'READY'
          )"
          :key="menu.id"
          class="menu-item"
          @click="openDialogTambah(index, 'bottom')"
        >
          <img
            src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
            alt="Deskripsi Foto"
            class="category"
            style="margin: 10px; border-radius: 20px"
          />
          <q-card-section
            class="row items-start no-wrap"
            style="display: flex; flex-direction: column; padding-top: 0px"
          >
            <div>
              <div class="text-weight-bold" style="font-size: 15px">
                {{ menu.nama_menu }}
              </div>
              <div class="text-grey-7">Rp{{ menu.harga_menu }}</div>
            </div>

            <q-btn
              outline
              rounded
              color="primary"
              style="width: 100%; margin-top: 10px; border-width: 29px"
              @click="addMenu(menu)"
              >Tambah</q-btn
            >
          </q-card-section>
        </div>
      </div>

      <div v-if="totalPrice !== 0" class="floating-bar" style="padding: 15px">
        <q-btn
          color="primary"
          class="full-width"
          @click="addRingkasan() && $router.replace(`/ringkasan-pesanan`)"
          style="
            display: flex;
            border-radius: 35px;
            justify-content: space-between;
            padding: 10px 30px;
          "
        >
          <div
            style="
              text-align: left;
              display: flex;
              flex-direction: column;
              justify-content: center;
              flex-grow: 1;
            "
          >
            <p
              class="text-subtitle1"
              style="
                margin: 0;
                font-size: 19px;
                font-weight: 600;
                padding-bottom: 5px;
              "
            >
              {{ totalItem }} pesanan
            </p>
            <p
              class="text-subtitle2"
              style="margin: 0; font-size: 17px; font-weight: 400"
            >
              {{ namaTokos }}
            </p>
          </div>
          <p
            style="
              margin: 0;
              font-size: 23px;
              font-weight: 600;
              padding-right: 15px;
            "
          >
            {{ totalPrice }}
          </p>
          <q-icon name="las la-shopping-bag" size="35px" />
        </q-btn>
      </div>

      <!-- <div v-else>
        <p></p>
      </div> -->
    </q-page>
  </div>

  <q-dialog v-model="dialogSwitch">
    <q-card
      class="my-card"
      style="width: 569px; border-radius: 30px; padding: 10px"
    >
      <q-card-section class="row items-center q-pb-none">
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="q-pt-none">
        <div class="row full-width justify-center items-center text-center">
          <div class="col">
            <p class="text-subtitle1 text-bold q-mb-xs">
              Yakin ingin pesan dari toko lain?
            </p>
            <p class="text-subtitle3" style="color: #68737c">
              Keranjang sebelumnya akan dihapus.
            </p>
          </div>
        </div>
      </q-card-section>

      <q-card-actions align="center">
        <q-btn
          class="delete-btn"
          rounded
          outline
          label="Batal"
          style="text-transform: none; padding-left: 17px; padding-right: 17px"
          color="negative"
          v-close-popup
        />
        <q-btn
          rounded
          unelevated
          label="Ya"
          style="text-transform: none"
          color="negative"
          @click="confirmAddMenu"
          v-close-popup
        />
      </q-card-actions>
    </q-card>
  </q-dialog>

  <!-- <q-dialog v-model="dialogTambah" :position="position">
    <q-card
    v-if="menus"
      style="
        width: 100%;
        height: 67vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      "
    >
      <img
        src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
        alt="Deskripsi Foto"
        style="max-width: 90%; height: auto; margin: auto; margin-top: 20px"
      />
      <q-card-section
        class="row items-start no-wrap"
        style="
          display: flex;
          flex-direction: column;
          padding-top: 10px;
          flex-grow: 1;
        "
      >
        <div>
          <div class="text-weight-bold">{{ nama_menu }}</div>
          <div class="text-grey">{{ desc_menu }}</div>
          <div class="text-weight-bold" style="padding-top: 15px">
            Rp{{ harga_menu }}
          </div>
        </div>
        <q-btn
          outline
          rounded
          style="width: 100%; margin-top: auto"
          @click="addMenu(menus)"
          >Tambah</q-btn
        >
      </q-card-section>
    </q-card>
  </q-dialog> -->

  <!-- <q-dialog v-model="dialogTambah" :position="position">
    <q-card
    v-if="menus"
      style="
        width: 100%;
        height: 67vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      "
    >
      <img
        src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
        alt="Deskripsi Foto"
        style="max-width: 90%; height: auto; margin: auto; margin-top: 20px"
      />
      <q-card-section
        class="row items-start no-wrap"
        style="
          display: flex;
          flex-direction: column;
          padding-top: 10px;
          flex-grow: 1;
        "
      >
        <div>
          <div class="text-weight-bold">{{ nama_menu }}</div>
          <div class="text-grey">{{ desc_menu }}</div>
          <div class="text-weight-bold" style="padding-top: 15px">
            Rp{{ harga_menu }}
          </div>
        </div>
        <q-btn
          outline
          rounded
          style="width: 100%; margin-top: auto"
          @click="addMenu(menus)"
          >Tambah</q-btn
        >
      </q-card-section>
    </q-card>
  </q-dialog> -->
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
// import { EventBus } from "src/utils/EventBus.js";
import axios from "axios";
import { ref } from "vue";
import useToko from "src/composables/useToko";

export default {
  name: "HalamanToko",

  components: {
    HeaderCreate,
  },

  data() {
    return {
      result: {
        nama_menu: "",
        harga_menu: "",
        desc_menu: "",
        nama_toko: "",
      },

      menus: [],
      keranjang: "",
      totalPrice: "",
      totalItem: "",
      namaTokos: "",
      id_penjual: this.id,
      id_menu: "",
      namaToko: "",
      orderData: null,
    };
  },

  // created() {
  //   EventBus.$on("namaTokoSelected", (namaToko) => {
  //     this.namaToko = namaToko;
  //   });
  // },

  setup() {
    const { getNamaToko } = useToko();
    const text = ref("");

    const autoplay1 = ref(true);
    const autoplay2 = ref(true);
    const dialogTambah = ref(false);
    const position = ref("top");
    return {
      text,

      slide1: ref("first"),
      slide2: ref("first"),
      autoplay1,
      autoplay2,
      dialogTambah,
      position,
      dialogSwitch: ref(false),
      getNamaToko,

      // openDialogTambah(bottom) {
      //   position.value = bottom;
      //   dialogTambah.value = true;
      // },
    };
  },

  mounted() {
    this.getMenu();
    this.addRingkasan();
  },

  created() {
    this.namaToko = this.$route.query.nama_toko;
    this.idToko = this.$route.query.id_toko;
  },

  methods: {
    async addMenu(menu) {
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/viewonemenu",
          {
            id_menu: menu.id_menu,
          }
        );

        console.log("Data Menu:", response.data.data);

        this.id_menu = response.data.data.id_menu;
        console.log("idmenu", this.id_menu);

        this.$router.replace(`/detail-pesanan/${menu.id_menu}`);

        this.cekPesanan();
      } catch (error) {
        console.error(error);
      }
    },

    // async cekPesanan() {
    //   const guestId = sessionStorage.getItem("guestId");
    //   await axios
    //     .post("http://127.0.0.1:8000/api/cekpesanan", {
    //       guest_id: guestId,
    //       id_menu: this.id_menu,
    //     })
    //     .then((response) => {
    //       console.log(response);
    //       this.$router.replace(`/detail-pesanan/${menu.id_menu}`);
    //     })
    //     .catch((error) => {
    //       console.error(error);
    //     });
    // },

    confirmAddMenu() {
      if (this.selectedMenu) {
        this.addMenu1(this.selectedMenu);
      }
    },

    addMenu1(menu) {
      axios
        .post("http://127.0.0.1:8000/api/viewonemenu", {
          id_menu: menu.id_menu,
        })
        .then((response) => {
          console.log("Data Menu:", response.data.data);
          this.$router.replace(`/detail-pesanan/${menu.id_menu}`);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    async addRingkasan() {
      this.guestId = sessionStorage.getItem("guestId");
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/ringkasanpesanan",
          {
            guestId: this.guestId,
          }
        );
        // const keranjang = response.data;
        this.totalPrice = response.data.total_price_sum;
        this.totalItem = response.data.total_id_menu;
        this.namaTokos = response.data.nama_tokos;

        this.idPenjual = this.$route.params.id;
        // this.idPenjual = response.data.data[0].id_penjual;

        console.log("response.data nya:", response.data);
        console.log("lalalallalalalla", this.idPenjual);
        console.log("response.data nya:", this.totalPrice);
      } catch (error) {
        console.error("error nih", error);
      }
    },

    getMenu() {
      this.id = this.$route.params.id;
      axios
        .post("http://127.0.0.1:8000/api/viewmenupenjual", {
          id_penjual: this.id,
          // id_menu: this.id_menu,
        })
        .then((response) => {
          // this.menus = response.data.data;
          this.menus = response.data.data.filter(
            (menu) => menu.status_menu === "READY"
          );
          const statusMenus = this.menus.map((menu) => menu.status_menu);
          console.log("ahahaha", statusMenus);
          // this.menus = response.data.data;
          // this.status = response.data.data.filter(
          //   (menu) => menu.status_menu === "READY"
          // );
          // console.log("ID:", this.id);
          // console.log("Menu:", this.status);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    openDialogTambah(index, bottom) {
      this.position = bottom;
      this.dialogTambah = true;

      this.nama_menu = this.menus[index].nama_menu;
      this.harga_menu = this.menus[index].harga_menu;
      this.desc_menu = this.menus[index].desc_menu;
    },
  },
};
</script>

<style>
@media screen and (max-width: 40vh) {
  .categories {
    display: flex;
    flex-direction: column;
  }
}

/* .menu-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
} */

.menu-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.menu-item {
  width: 50%;
  padding: 5px;
  align-items: center;
}

.menu-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.menu-item {
  width: 50%;
  padding: 5px;
  align-items: center;
}

.category {
  max-width: 85%;
  height: auto;
  margin: auto;
  margin-top: 20px;
  margin-bottom: 5px;
}

.text-category {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.carousel {
  height: 50%;
}

.carousel-slide {
  position: relative;
  width: 100%;
  height: 50%;
  padding: 0%;
  overflow: hidden;
}

.text-container {
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  text-align: center;
}

.pesan-img {
  object-fit: cover;
  width: 100%;
  /* height: 40%; */
  height: 150px;
}

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

.q-btn {
  text-transform: none;
}
</style>
