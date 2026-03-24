<template>
  <n-tooltip trigger="hover">
    <template #trigger>
      <button
        type="button"
        class="inline-flex items-center justify-center text-blue-500"
        :class="disabled ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer hover:text-blue-600'"
        :disabled="disabled"
        @click="handleClick"
      >
        <svg
          class="w-5 h-5 mx-auto"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="1.8"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 3v11m0 0l4-4m-4 4l-4-4M4 17.5v.75A1.75 1.75 0 0 0 5.75 20h12.5A1.75 1.75 0 0 0 20 18.25v-.75"
          />
        </svg>
      </button>
    </template>
    {{ disabled ? disabledTooltip : tooltip }}
  </n-tooltip>
</template>

<script>
export default {
  name: 'PdfDownloadActionButton',
  emits: ['click'],
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    tooltip: {
      type: String,
      default: 'Download attachment'
    },
    disabledTooltip: {
      type: String,
      default: 'No attachment available'
    }
  },
  methods: {
    handleClick() {
      if (this.disabled) return
      this.$emit('click')
    }
  }
}
</script>
