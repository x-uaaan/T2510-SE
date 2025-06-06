<template>
  <div class="search-bar">
    <span class="search-icon">
      <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="20" height="20" color="#aaa">
        <circle cx="9.14" cy="9.14" r="7.64" fill="none" stroke="currentColor" stroke-miterlimit="10"/>
        <line x1="22.5" y1="22.5" x2="14.39" y2="14.39" fill="none" stroke="currentColor" stroke-miterlimit="10"/>
      </svg>
    </span>
    <input
      type="search"
      class="search-input"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    default: 'Type to search...'
  }
});

defineEmits(['update:modelValue']);
</script>

<style scoped>
.search-bar {
  display: flex;
  align-items: center;
  background: #23242a;
  border-radius: 10px;
  padding: 5px 12px;
  box-shadow: 0 2px 8px #0002;
  border: 1px solid #3d3e46 !important;
  margin-left: auto;
  position: sticky;
  top: 10px;
  z-index: 10;
}

.search-icon {
  display: flex;
  align-items: center;
  margin-right: 8px;
}

.search-input {
  background: transparent;
  border: none;
  outline: none;
  color: #fff;
  font-size: 1em;
  width: 100%;
  padding: 6px 0;
}

.search-input::placeholder {
  color: #727171;
  opacity: 1;
}

.search-bar:focus-within{
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 2px #3b82f688 !important;
  border: 0.5px solid #3b82f6 !important;
  border-radius: 10px !important;
  transition: border-color 0.2s;
  background: #18191A !important;
  color: #fff !important;
  outline: none !important;
}
</style> 