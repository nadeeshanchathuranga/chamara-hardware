<template>
    <div class="inline-block">
      <input
        ref="inputRef"
        type="text"
        :value="inputValue"
        @focus="onFocus"
        @blur="onBlur"
        @input="onInput"
        class="w-40 text-right text-black px-6   text-lg placeholder-gray-500 border border-gray-300 rounded-full"
      />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { useCurrencyInput } from 'vue-currency-input'

  const props = defineProps({
    modelValue: Number,
    options: Object
  })

  // State to hold input value
  const inputValue = ref(props.modelValue ?? '')

  // Handle focus event to clear the input if the value is 0
  const onFocus = () => {
    if (inputValue.value === 0 || inputValue.value === '0.00') {
      inputValue.value = ''
    }
  }

  // Handle blur event to reset input to 0 if empty
  const onBlur = () => {
    if (inputValue.value === '' || inputValue.value === null) {
      inputValue.value = 0
    }
  }

  // Update the value on input
  const onInput = (event) => {
    inputValue.value = event.target.value
  }

  // Use the currency input hook
  const { inputRef } = useCurrencyInput({
    currency: 'LKR',
    hideCurrencySymbolOnFocus: true,
    currencyDisplay: 'hidden',
    autoDecimalMode: true,
    precision: 2,
    valueRange: { min: 0 },
    locale: 'en'
  })
  </script>
