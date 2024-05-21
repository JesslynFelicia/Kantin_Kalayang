<template>
  <q-footer class="q-px-xl bg-white text-black">
    <q-toolbar class="justify-center">
      <div class="">
        <span>{{ title }}</span>
      </div>
      <div class="">
        <span class="text-link" @click="$emit('link', true)">&nbsp;{{ buttonLink }}</span>
      </div>
    </q-toolbar>
  </q-footer>
</template>

<script setup>
defineOptions({
  name: 'FooterApp'
})

defineProps({
  title: {
    type: String,
    required: true
  },
  buttonLink: {
    type: String,
    required: true
  },
})

</script>


<style lang="scss" scoped>
.text-link {
  cursor: pointer;
  text-decoration: underline;
}

.text-link:hover {
  text-decoration: none;
  color: $blue-7;
}
</style>
