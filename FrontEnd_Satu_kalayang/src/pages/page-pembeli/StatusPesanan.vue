<template>
  <HeaderCreate title="Pesanan Kamu" backAction="/pembayaran" :hideLogout="true" :hideProfile="true"/>
  <q-page class="q-pa-md">
      <div style="max-height: 500px; min-height: 300px;">
        <q-list padding>
          <q-item v-for="row in dataPesanan" v-bind:key="row.id">
            <q-item-section top avatar>
              <q-avatar rounded>
                <img :src="row.img">
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label>{{ row.pesanan }}</q-item-label>
              <q-item-label caption>
                <span class="text" @click="() => {}">Edit</span>
              </q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-item-label caption>{{ toRupiah(row.price) }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator spaced />

          <q-item>
            <q-item-section>
              <q-item-label>Total</q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-item-label caption>Rp {{ toRupiah(total) }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </div>

      <q-card class="my-card q-pa-md q-mb-lg">
        <div class="text-left q-mb-lg">
          <span class="text-subtitle1 text-weight-bold">Status pesanan kamu</span>
        </div>

        <div class="row q-gutter-md q-mb-lg">
          <div class="col text-center">
            <div>
              <q-btn round color="secondary" size="md" icon="las la-check" />
            </div>
            <span class="text-caption">Pesanan dicek</span>
          </div>
          <div class="col text-center">
            <div>
              <q-btn
                round
                :color="status === 'ditolak' ? 'negative' : 'secondary'"
                size="md"
                :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
              />
            </div>
            <span class="text-caption">Pesanan diproses</span>
          </div>
          <div class="col text-center">
            <div>
              <q-btn
                round
                :color="status === 'ditolak' ? 'negative' : status === 'diterima' || status === 'selesai' ? 'secondary' : 'grey-5'"
                size="md"
                :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
              />
            </div>
            <span class="text-caption">Pesanan diantar</span>
          </div>
          <div class="col text-center">
            <div>
              <q-btn
                round
                :color="status === 'ditolak' ? 'negative' : status === 'selesai' ? 'secondary' : 'grey-5'"
                size="md"
                :icon="status === 'ditolak' ? 'las la-times' : 'las la-check'"
              />
            </div>
            <span class="text-caption">Pesanan selesai</span>
          </div>
        </div>

        <div class="q-mb-md">
          <q-btn color="primary" class="full-width" label="Pesanan diterima" @click="onSubmit" />
        </div>
        <div class="q-mb-md">
          <q-btn color="negative" class="full-width" outline  label="Hubungi Penjual" @click="() => {}" />
        </div>
      </q-card>
  </q-page>

</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import HeaderCreate from "components/HeaderCreate.vue";
import { showLoading, hideLoading } from 'src/composables/useLoadingComposables'
import { toRupiah } from 'src/libs/currency'

const router = useRouter()

const status = ref('diterima')

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
  status.value = 'selesai'
}

</script>

<style>

.text:hover {
  cursor: pointer;
  color: blue;
  text-decoration: underline
}

</style>
