import { route } from 'quasar/wrappers';
<template>
  <div style="display: flex; justify-content: center">
    <q-page style="display: flex; flex-direction: column">
      <div style="display: flex; flex-direction: column; align-items: center">
        <HeaderCreate title="Nama Toko" backAction="/" />
        <q-input
          outlined
          class="search-bar"
          v-model="text"
          placeholder="Cari makanan / toko"
          color="black"
          style="padding-top: 5px; width: 93%"
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

      <div style="flex-direction: column; margin-top: 10px">
        <!-- <h6 style="font-weight: 800; margin: 2% 3.5%">Menu</h6> -->
        <q-page>
          <div class="menu-header">
            <p class="menu-title">Menu yang tersedia</p>

            <q-btn
              flat
              icon="add"
              size="20px"
              @click="$router.replace('/buat-pesanan')"
              class="add-button"
              rounded
            />
          </div>

          <div v-if="loading">
            <q-skeleton
              v-for="(_, index) in 5"
              :key="index"
              type="rect"
              style="margin-bottom: 16px"
            />
          </div>

          <div v-else class="menu-grid">
            <div v-for="(menu, index) in menus" :key="index" class="menu-item">
              <div style="position: relative; width: 100%">
                <img
                  v-if="menu.nama_menu"
                  src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
                  alt="Deskripsi Foto"
                  style="width: 100%; height: auto; border-radius: 8px"
                />
                <q-skeleton
                  v-else
                  type="rect"
                  style="width: 100%; height: auto; border-radius: 8px"
                />
              </div>

              <div style="flex: 1; margin-top: 8px; text-align: center">
                <div
                  style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                  "
                >
                  <p style="font-weight: bold; margin: 0; font-size: 18px">
                    {{ menu.nama_menu || "Loading..." }}
                  </p>
                  <q-btn
                    flat
                    icon="edit"
                    color="primary"
                    @click="editMenu(menu.id_menu)"
                    style="margin-left: 8px"
                  />
                </div>
              </div>
              <div
                style="
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  margin-top: 4px;
                "
              >
                <q-icon name="paid" size="30px" color="secondary" />
                <p
                  style="
                    margin: 0%;
                    padding-left: 5px;
                    font-size: 16px;
                    color: #555;
                  "
                >
                  {{ menu.harga_menu || "Loading..." }}
                </p>
              </div>
            </div>
          </div>
        </q-page>
      </div>
    </q-page>
  </div>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
  components: {
    HeaderCreate,
  },

  data() {
    return {
      id_penjual: "", // Pastikan ini diisi dengan nilai yang benar
      menus: [],
    };
  },

  setup() {
    const router = useRouter();
    const text = ref("");

    const slide1 = ref(1);
    const slide2 = ref("one");

    const autoplay1 = ref(true);
    const autoplay2 = ref(true);
    const loading = ref(false);

    return {
      text,
      slide1,
      slide2,
      autoplay1,
      autoplay2,
      loading,
      router,
    };
  },
  mounted() {
    this.getIdPenjual();
  },
  formdata: {
    id_penjual: "",
  },
  showdatamenu: {},
  methods: {
    async getIdPenjual() {
      this.loading = true;
      await axios
        .post("http://127.0.0.1:8000/api/viewonepenjual", {
          email: localStorage.getItem("userEmail"),
        })
        .then((response) => {
          this.id_penjual = response.data.data.id_penjual;
          this.getdatamenu();
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
      this.loading = false;
    },

    async getdatamenu() {
      this.loading = true;
      await axios
        .post("http://127.0.0.1:8000/api/viewmenupenjual", {
          id_penjual: this.id_penjual,
        })
        .then((response) => {
          this.menus = response.data.data;
        })
        .catch((err) => {
          // Handle errors here
          this.error = err;
          console.error(err);
        });
      this.loading = false;
    },

    editMenu(id) {
      this.router.push(`/edit-pesanan/${id}`);
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

.menu-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.menu-item {
  display: flex;
  flex-direction: column;
  align-items: start;
  padding: 16px;
}

.category {
  max-width: 80%;
  height: auto;
  margin: auto;
  margin-top: 5px;
  margin-bottom: 5px;
}

.text-category {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.carousel-slide {
  position: relative;
  width: 100%;
  height: auto;
  padding: 0%;
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
  height: 150px;
}

.menu-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.menu-title {
  font-weight: bold;
  font-size: 24px;
  margin: 0;
  padding: 22px 10px 0 17px;
}

.add-button {
  margin-right: 10px; /* Adjust margin as needed */
}
</style>
