<template>
  <q-layout>
      <HeaderCreate
        title="Custom pesanan"
        backAction="/halaman-toko"
        :hideLogout="true"
        :hideProfile="true"
      />

    <q-page-container>
      <q-page>
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
          <p style="margin: 2% 3.5%; margin-top: 0px; font-size: 15px">
            Deskripsi dari Menu 1
          </p>
        </div>

        <div style="display: flex; flex-direction: column; margin-top: 10px">
          <div style="margin: 2% 3.5%; margin-bottom: 0px">
            <h6 style="font-weight: 800; margin: 0">Catatan untuk penjual</h6>
            <p style="margin: 2% 0%; margin-top: 0px; font-size: 15px">
              *Opsional
            </p>
            <q-input
              outlined
              v-model="text"
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
            <!-- <q-badge outline rounded color="primary" style="font-size: 20px">{{
        nilai
      }}</q-badge> -->

            <q-btn
              rounded
              outline
              @click="kurangi"
              color="black"
              icon="remove"
              size="sm"
              style="width: 30px; height: 30px"
            />

            <!-- <q-chip outline color="primary" style="width: 40px; height: 40px">{{
        nilai
      }}</q-chip> -->

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
            @click="$router.replace('/ringkasan-pesanan')"
            outline
            style="margin-top: 3%; font-weight: 800"
          >
            Tambah pesanan -
          </q-btn>
        </div>
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
      },
    };
  },
  mounted() {
    this.getdata();
  },
  methods: {
    getdata() {
      axios
        .post("http://127.0.0.1:8000/api/viewonemenu", this.formData)
        .then((response) => {
          // Handle the response
          this.result.jenis = response.jenis;
          this.result.nama_menu = response.nama_menu;
          this.result.harga_menu = response.harga_menu;
          this.result = response.desc_menu;
          return response;
        })
        .catch((error) => {
          // Handle the error
        });
    },
  },

  setup() {
    const nilai = ref(1);

    const tambah = () => {
      nilai.value++;
    };

    const kurangi = () => {
      if (nilai.value > 0) {
        nilai.value--;
      }
    };

    return {
      text: ref(""),
      nilai,
      tambah,
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
</style>
