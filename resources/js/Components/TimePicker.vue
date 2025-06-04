<template>
  <div class="relative">
    <input
      type="time"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :placeholder="placeholder"
      class="w-full bg-[#18191A] text-white rounded-xl border border-[#353535] p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 transition outline-none placeholder-gray-400"
      step="60"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: '--:--'
  }
})
</script>

<style scoped>
input[type="time"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
}
</style> 