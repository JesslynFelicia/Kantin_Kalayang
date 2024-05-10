<template>
  <q-page class="flex flex-center">
    <!-- Loop through the data -->
    <div v-for="penjual in info" :key="penjual.id_penjual">
      <p>Nama Pemilik: {{ penjual.nama_pemilik }}</p>
      <p>Nomor Telepon: {{ penjual.nomor_telepon }}</p>

      <!-- Move buttons inside the loop -->
      <q-btn name="accept" @click="accepted(penjual.id_penjual)">Accept</q-btn>
      <q-btn name="reject" @click="rejected(penjual.id_penjual)">Reject</q-btn>
    </div>
  </q-page>
</template>

<script setup>
defineOptions({
  name: "AdminPage",
});
</script>

<script>
import axios from "axios";

export default {
  data() {
    return {
      info: [],
    };
  },
  mounted() {
    this.viewPenjual();
    // console.log('Data:', this.info);
  },

  methods: {
    viewPenjual() {
      axios
        .post("http://127.0.0.1:8000/api/viewpenjual")
        .then((response) => {
          // console.log('API Response:', response.data); // Log response data
          this.info = response.data.data; // Update data with response
        })
        .catch((error) => {
          // Handle the error
          console.error(error);
        });
    },
    accepted(id_penjual) {
      console.log("Accepted ID:", id_penjual);
      // Implement accept logic here
    },
    rejected(id_penjual) {
      console.log("Rejected ID:", id_penjual);
      // Implement reject logic here
    },
  },
};
</script>
