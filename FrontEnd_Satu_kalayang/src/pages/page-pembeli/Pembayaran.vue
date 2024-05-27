<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <HeaderCreate title="Pembayaran dengan QRIS" backAction="/ringkasan-pesanan" :hideLogout="true" :hideProfile="true"/>
  <q-page class="q-pa-md">
    <div class="text-center q-mb-lg">
      <span class="text-subtitle1 text-weight-bold">Rp {{ toRupiah(total) }}</span>
    </div>

    <q-card class="my-card q-pa-md q-mb-lg">
      <div class="text-left">
        <span class="text-subtitle1 text-weight-bold">QRIS</span>
      </div>

      <q-card-section class="flex flex-center">
        <div class="column">
          <div class="text-center">
            <span class="text-subtitle1 text-weight-bold">Toko 1</span>
          </div>
          <q-img
            class="rounded-borders"
            src="/src/assets/qris.png"
            style="width: 250px; height: 250px;"
          />
        </div>
      </q-card-section>
    </q-card>

    <div class="q-mb-xl">
      <q-btn color="primary" class="full-width" label="Cek Status Pesanan" @click="onSubmit" />
    </div>

    <div class="text-left q-mb-md">
      <span class="text-subtitle1 text-weight-bold">Cara membayar dengan QRIS</span>
    </div>

    <div class="row q-gutter-md">
      <div class="col">
        <q-img
            class="rounded-borders"
            src="https://fakeimg.pl/100x100/"
          />
        <span class="text-caption">Step 1</span>
      </div>
      <div class="col">
        <q-img
            class="rounded-borders"
            src="https://fakeimg.pl/100x100/"
          />
        <span class="text-caption">Step 2</span>
      </div>
      <div class="col">
        <q-img
            class="rounded-borders"
            src="https://fakeimg.pl/100x100/"
          />
        <span class="text-caption">Step 3</span>
      </div>
    </div>

  </q-page>

</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import HeaderCreate from "components/HeaderCreate.vue";
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { toRupiah } from 'src/libs/currency'

const router = useRouter()

const dataPesanan = ref([
  {
    id: 1,
    img: 'https://cdn.quasar.dev/img/boy-avatar.png',
    pesanan: 'Menu 1',
    quantity: 1,
    price: 10000,
  },
  {
    id: 2,
    img: 'https://cdn.quasar.dev/img/boy-avatar.png',
    pesanan: 'Menu 2',
    quantity: 1,
    price: 15000,
  }
])

const total = computed(() => dataPesanan.value.reduce((a, b) => a + b.price, 0))

const onSubmit = () => {
  router.push({ path: '/status-pesanan' })
}

</script>

<style>

.text:hover {
  cursor: pointer;
  color: blue;
  text-decoration: underline
}

</style>
