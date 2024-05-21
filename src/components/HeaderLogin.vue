<template>
  <q-header class="bg-white text-black">
    <q-toolbar>
      <q-btn v-if="isChildren" flat round dense icon="las la-arrow-left" @click="$emit('back', true)" />
      <q-space />
      <div class="">
        <span class="text-link" @click="$emit('link', true)">{{ titleButtonLink }}</span>
      </div>
    </q-toolbar>
  </q-header>
</template>

<script setup>

defineOptions({
  name: 'HeaderLogin'
})

defineProps({
  titleButtonLink: {
    type: String,
    required: true
  },
  buttonLink: {
    type: Boolean,
    required: true
  },
  isChildren: {
    type: Boolean,
    default: false
  }
})
</script>

<style lang="scss" scoped>
.text-link {
  cursor: pointer;
  text-decoration: underline;
}

.text-link:hover {
  text-decoration: none;
}
</style>
