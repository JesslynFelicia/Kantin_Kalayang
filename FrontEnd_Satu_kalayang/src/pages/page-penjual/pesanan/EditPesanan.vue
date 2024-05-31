<template>
  <HeaderCreate
    title=""
    backAction="/beranda-penjual"
    :hideLogout="true"
    :hideProfile="true"
  />
  <q-page class="q-pa-xl" style="padding-top: 0%">
    <div class="text-center q-mb-xl">
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
        <q-input
          outlined
          v-model="form.desc_menu"
        >
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

      <div class="form-group">
        <label class="text-subtitle1">Jenis</label>
        <q-input outlined v-model="form.jenis" >
          <template v-slot:prepend>
            <q-icon name="las la-tag" />
          </template>
        </q-input>
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
          style="padding: 10px;"
          rounded
        />
      </div>
    </q-form>
  </q-page>
</template>

<script setup>
import HeaderLogin from "components/HeaderLogin.vue";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import HeaderCreate from "components/HeaderCreate.vue";
import useNotify from "src/composables/UseNotify";
import { api } from "src/boot/axios"


defineOptions({
  name: "EditPesanan",
});

const route = useRoute();
const router = useRouter();
const { notifyError, notifySuccess } = useNotify();

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
    const { data: response } = await api.post('/updatemenu', {
      ...form.value,
      status_menu: form.value.menu_tersedia ? 'READY' : 'NONE'
    })
    console.log(response.data)
    notifySuccess("Menu berhasil diedit!");
    router.push({ path: "/beranda-penjual" });
  } catch (error) {
    console.log(error)
  }
};

const getData = async () => {
  try {
    const { data: response } = await api.post('/viewonemenu', {
      id_menu: route.params.id
    })

    form.value = {
      id_menu: route.params.id,
      nama_menu: response.data.nama_menu,
      desc_menu: response.data.desc_menu,
      harga_menu: response.data.harga_menu,
      menu_tersedia: response.data.status_menu == 'READY' ? true : false,
      jenis: response.data.jenis,
      ekstra: response.data.ekstra,
    }
  } catch (error) {
    console.log(error)
  }
}

onMounted(() => {
  getData()
})
</script>

<style scoped>
.form-group {
  margin-bottom: 0;
}

.q-btn {
  text-transform: none;
}
</style>
