<template>
  <q-input outlined v-for="i in length" v-model="fieldValues[i - 1]" v-bind="$attrs" @keyup="onKeyUp($event, i - 1)"
    @update:model-value="onUpdate($event, i - 1)" :key="i" :ref="el => updateFieldRef(el, i - 1)" maxlength="1"
    input-class="text-center" style="width: 6ch">
  </q-input>
</template>

<script setup>
import { ref, computed, watch, onBeforeUpdate } from 'vue'

defineOptions({
  name: 'InputOtp'
})

const emit = defineEmits(['update:model-value'])

const props = defineProps({
  inputLength: {
    type: Number,
    default: 4
  }
})

const length = computed(() => props.inputLength)
const fields = ref([]);
const fieldValues = ref([]);

const composite = computed(() => {
  const nonNullFields = fieldValues.value.filter((value) => value);
  if (length.value !== nonNullFields.length) {
    return "";
  }
  return nonNullFields.join("");
});

watch(composite, (value) => {
  if (composite.value) {
    emit("update:model-value", composite.value);
  }
});

onBeforeUpdate(() => {
  fields.value = [];
})

const updateFieldRef = (element, index) => {
  if (element) {
    fields.value[index] = element;
  }
}

const focus = (index) => {
  if (index >= 0) {
    if (index < length.value) {
      fields.value[index].select();
    } else {
      if (composite.value) {
        fields.value[index - 1].blur();
      }
    }
  }
}

const onUpdate = (value, index) => {
  if (value) {
    focus(index + 1);
  }
}

const onKeyUp = (evnt, index) => {
  const key = evnt.key;

  if (["Tab", "Shift", "Meta", "Control", "Alt"].includes(key)) {
    return;
  }

  if (["Delete"].includes(key)) {
    return;
  }

  if (key === "ArrowLeft" || key === "Backspace") {
    focus(index - 1);
  } else if (key === "ArrowRight") {
    focus(index + 1);
  }
}
</script>
