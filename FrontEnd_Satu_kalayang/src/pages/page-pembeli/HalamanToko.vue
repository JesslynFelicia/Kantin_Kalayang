import { route } from 'quasar/wrappers';
<template>
  <!-- <q-btn flat @click="$router.replace('/')" icon="arrow_back" style="margin-top: 5px;"></q-btn> -->
  <HeaderCreate
    title=""
    backAction="/beranda-pembeli"
    :hideLogout="true"
    :hideProfile="true"
  />

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
      <div style="flex-direction: column; margin-top: 10px">
        <h6 style="font-weight: 800; margin: 2% 3.5%; margin-bottom: 0px">
          Toko 1
        </h6>
        <p style="margin: 2% 3.5%; margin-top: 0px; font-size: 15px">
          Deskripsi dari Toko 1
        </p>
        <div style="display: flex">
          <div style="text-align: center">
            <img
              src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
              alt="Deskripsi Foto"
              class="category"
            />
            <div style="display: flex; margin-left: 10%">
              <div style="text-align: left">
                <p style="margin: 0; font-weight: 700; font-size: 15px">
                  Menu 1
                </p>
                <p style="margin: 0">18.000</p>
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
          <div style="text-align: center">
            <img
              src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
              alt="Deskripsi Foto"
              class="category"
            />
            <div style="display: flex; margin-left: 10%">
              <div style="text-align: left">
                <p style="margin: 0; font-weight: 700; font-size: 15px">
                  Menu 1
                </p>
                <p style="margin: 0">18.000</p>
              </div>
              <q-btn
                unelevated
                size="14px"
                no-caps
                rounded
                class="text-weight-medium"
                icon="add_circle_outline"
                style="margin-left: auto; margin-bottom: auto; margin-right: 5%"
              />
            </div>
          </div>
          <div style="text-align: center">
            <img
              src="/src/assets/WhatsApp Image 2024-04-30 at 13.17.28_a0a48e8c.jpg"
              alt="Deskripsi Foto"
              class="category"
            />
            <div style="display: flex; margin-left: 10%">
              <div style="text-align: left">
                <p style="margin: 0; font-weight: 700; font-size: 15px">
                  Menu 1
                </p>
                <p style="margin: 0">18.000</p>
              </div>
              <q-btn
                unelevated
                size="14px"
                no-caps
                class="text-weight-medium"
                icon="add_circle_outline"
                style="margin-left: auto; margin-bottom: auto; margin-right: 5%"
              />
            </div>
          </div>
        </div>
      </div>
      <!--
      <div class="floating-bar">
        <div
          style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0px;
          "
        ></div>
        <q-btn
          @click="$router.replace('/ringkasan-pesanan')"
          outline
          style="margin-top: 3%; font-weight: 800"
        >
          <div style="display: flex; flex-direction: column; margin-top: 10px">
            <div
              style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 2% 3.5%;
                margin-bottom: 0px;
              "
            >
              <h6 style="font-weight: 800; margin: 0">Menu 1</h6>
              <h6 style="font-weight: 800; margin: 0">18.000</h6>
            </div>
          </div>
        </q-btn>
      </div> -->
    </q-page>
  </div>
</template>

<script>
import HeaderCreate from "components/HeaderCreate.vue";
import { ref } from "vue";

export default {
  components: {
    HeaderCreate,
  },
  setup() {
    const text = ref("");

    const autoplay1 = ref(true);
    const autoplay2 = ref(true);

    return {
      text,

      slide1: ref("first"),
      slide2: ref("first"),
      autoplay1,
      autoplay2,
    };
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

.category {
  max-width: 80%;
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
</style>
