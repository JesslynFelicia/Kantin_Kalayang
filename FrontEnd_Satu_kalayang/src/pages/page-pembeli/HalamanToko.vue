import { route } from 'quasar/wrappers';
<template>
  <HeaderCreate
    ::title="result.nama_toko"
    backAction="/beranda-pembeli"
    :hideLogout="true"
    :hideProfile="true"
  />

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
          v-for="(menu, index) in menus"
          :key="menu.id"
          class="menu-item"
          @click="openDialogTambah(index, 'bottom')"
        >
          <img
            src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
            alt="Deskripsi Foto"
            class="category"
            style="margin: 10px"
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
              style="width: 100%; margin-top: 10px"
              @click="addMenu(menu)"
              >Tambah</q-btn
            >
          </q-card-section>

          <!-- <div style="text-align: left; margin: 0px 15px">
            <p style="margin: 0; font-weight: 700; font-size: 15px">
              {{ menu.nama_menu }}
            </p>
            <p style="margin: 0">Rp{{ menu.harga_menu }}</p>
            <q-btn
              outline
              rounded
              style="width: 100%; margin-top: 7px"
              @click="$router.replace('/detail-pesanan')"
              >Tambah</q-btn
            >
            <q-btn
              label="Bottom"
              icon="keyboard_arrow_down"
              color="primary"
              @click="openDialogTambah('bottom')"
            />
          </div> -->
        </div>
      </div>

      <div v-if="keranjang" class="floating-bar">
        <div style=""></div>
        <q-btn
          @click="$router.replace('/ringkasan-pesanan')"
          outline
          style="margin-top: 3%; font-weight: 800"
        >
          <div style="">
            <div style="">
              <h6 style="font-weight: 800; margin: 0">
                {{ keranjang.qty }} item
              </h6>
              <h6 style="font-weight: 800; margin: 0">
                {{ keranjang.price }}
              </h6>
            </div>
          </div>
        </q-btn>
      </div>

      <div v-else>
        <p></p>
      </div>
    </q-page>
  </div>

  <q-dialog v-model="dialogTambah" :position="position">
    <q-card
      style="
        width: 350px;
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
          @click="addToCart()"
          >Tambah</q-btn
        >
      </q-card-section>
    </q-card>
  </q-dialog>

  <q-dialog v-model="dialogTambah" :position="position">
    <q-card
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
          @click="addToCart()"
          >Tambah</q-btn
        >
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import axios from "axios";
import { ref } from "vue";

export default {
  name: "DetailPesanan",
  name: "DetailPesanan",
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
      keranjang: null,
      id_penjual: this.id,
      id_menu: "",
    };
  },
  setup() {
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

      // openDialogTambah(bottom) {
      //   position.value = bottom;
      //   dialogTambah.value = true;
      // },
    };
  },

  mounted() {
    this.getMenu();
  },

  created() {},

  methods: {

    addMenu(menu) {
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

    // coba
    getMenu() {
      this.id = this.$route.params.id;
      axios
        .post("http://127.0.0.1:8000/api/viewmenupenjual", {
          id_penjual: this.id,
          id_menu: this.id_menu,
        })
        .then((response) => {
          this.menus = response.data.data;
          this.id_menu = response.data.data.id_menu;
          console.log("ID:", this.id);
          console.log("ID:", this.id_menu);
          console.log("Data Menu:", this.menus);
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
