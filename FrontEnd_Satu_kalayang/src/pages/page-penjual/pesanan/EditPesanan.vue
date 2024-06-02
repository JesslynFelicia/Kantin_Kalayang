<template>
  <HeaderCreate
    title=""
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl" style="padding-top: 0%">
    <div class="text-center q-mb-xl" style="margin-bottom: 20px">
      <span class="text-h4 text-weight-bold">Edit Menu</span>
    </div>
    <q-form @submit="onSubmit">
      <div class="form-group">
        <label class="text-subtitle1">Nama Menu</label>
        <q-input
          outlined
          v-model="form.nama_menu"
          lazy-rules
          :rules="formRules.nama_menu"
        >
          <template v-slot:prepend>
            <q-icon name="las la-utensils" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Deskripsi Menu</label>
        <q-input outlined v-model="form.desc_menu">
          <template v-slot:prepend>
            <q-icon name="las la-info-circle" />
          </template>
        </q-input>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Harga</label>
        <q-input
          outlined
          v-model="form.harga_menu"
          type="number"
          lazy-rules
          :rules="formRules.harga"
        >
          <template v-slot:prepend>
            <q-icon name="las la-dollar-sign" />
          </template>
        </q-input>
      </div>

      <!-- <div class="form-group">
        <label class="text-subtitle1">Jenis</label>
        <q-input outlined v-model="form.jenis">
          <template v-slot:prepend>
            <q-icon name="las la-tag" />
          </template>
        </q-input>
      </div> -->

      <div class="form-group">
        <label class="text-subtitle1">Jenis</label>
        <q-select outlined v-model="form.jenis" :options="jenisOptions">
          <template v-slot:prepend>
            <q-icon name="las la-tag" />
          </template>
        </q-select>
      </div>

      <div class="form-group">
        <label class="text-subtitle1">Ekstra</label>
        <q-input outlined v-model="form.ekstra">
          <template v-slot:prepend>
            <q-icon name="las la-info-circle" />
          </template>
        </q-input>
      </div>

      <div class="form-group" style="padding-bottom: 20px">
        <q-toggle
          v-model="form.menu_tersedia"
          size="lg"
          color="green"
          label="Menu tersedia"
        />
      </div>

      <div class="form-group">
        <q-btn
          color="primary"
          class="full-width"
          label="Edit Menu"
          type="submit"
          style="padding: 10px"
          rounded
        />
      </div>

      <div class="form-group">
        <q-btn
          color="negative"
          class="full-width"
          label="Hapus Menu"
          @click="openDialogDelete"
          style="padding: 10px; margin: 20px"
          rounded
        />
      </div>
    </q-form>

    <q-dialog v-model="dialogDelete">
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
                Yakin ingin hapus menu ini?
              </p>
              <p class="text-subtitle3" style="color: #68737c">
                {{ form.nama_menu }} akan dihapus dari daftar toko Anda.
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
            style="
              text-transform: none;
              padding-left: 17px;
              padding-right: 17px;
            "
            color="negative"
            v-close-popup
          />
          <q-btn
            rounded
            unelevated
            label="Ya"
            @click="deletemenu"
            style="text-transform: none"
            color="negative"
            v-close-popup
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup>
import HeaderLogin from "components/HeaderLogin.vue";
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref } from "vue";
import HeaderCreate from "components/HeaderCreate.vue";
import useNotify from "src/composables/UseNotify";
import { api } from "src/boot/axios";
import axios from "axios";

defineOptions({
  name: "EditPesanan",
});

const route = useRoute();
const router = useRouter();
const { notifyError, notifySuccess } = useNotify();

const jenisOptions = ["Berat", "Ringan", "Minuman"]; // Pilihan jenis

const form = ref({
  nama_menu: "",
  desc_menu: "",
  harga_menu: "",
  jenis: "",
  ekstra: "",
  menu_tersedia: true,
});

const formRules = ref({
  nama_menu: [(val) => (val && val.length > 0) || "Nama menu harus diisi"],
  harga: [(val) => (val && val > 0) || "Harga harus diisi"],
});

const onSubmit = async () => {
  try {
    const { data: response } = await api.post("/updatemenu", {
      ...form.value,
      status_menu: form.value.menu_tersedia ? "READY" : "NONE",
    });
    console.log(response.data);
    notifySuccess("Menu berhasil diedit!");
    router.push({ path: "/beranda-penjual" });
  } catch (error) {
    console.log(error);
  }
};

const dialogDelete = ref(false);

const openDialogDelete = () => {
  dialogDelete.value = true;
};

const getData = async () => {
  try {
    const { data: response } = await api.post("/viewonemenu", {
      id_menu: route.params.id,
    });

    form.value = {
      id_menu: route.params.id,
      nama_menu: response.data.nama_menu,
      desc_menu: response.data.desc_menu,
      harga_menu: response.data.harga_menu,
      menu_tersedia: response.data.status_menu == "READY" ? true : false,
      jenis: response.data.jenis,
      ekstra: response.data.ekstra,
    };
  } catch (error) {
    console.log(error);
  }
};

const deletemenu = () => {
  axios
    .post("http://127.0.0.1:8000/api/deletemenu", {
      id_menu: route.params.id,
    })
    .then((response) => {
      router.push({ path: "/beranda-penjual" });

      notifySuccess("Menu berhasil dihapus!");
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() => {
  getData();
});
</script>

<style scoped>
.form-group {
  margin-bottom: 0;
}

.q-btn {
  text-transform: none;
}
</style>
