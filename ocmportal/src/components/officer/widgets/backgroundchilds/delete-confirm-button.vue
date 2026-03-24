<template>
  <n-popconfirm
    :positive-text="positiveText"
    :negative-text="negativeText"
    :positive-button-props="{ type: 'error', size: 'small' }"
    :negative-button-props="{ size: 'small' }"
    @positive-click="$emit('confirm')"
  >
    <template #trigger>
      <n-tooltip trigger="hover">
        <template #trigger>
          <button type="button" class="text-red-500 hover:text-red-600 cursor-pointer">
            <svg
              class="w-5 h-5 mx-auto"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
              fill="currentColor"
              aria-hidden="true"
            >
              <path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
              <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path>
              <path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path>
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path>
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path>
            </svg>
          </button>
        </template>
        លុបព័ត៌មាននេះ។
      </n-tooltip>
    </template>
    {{ message }}
  </n-popconfirm>
</template>

<script>
export default {
  name: 'DeleteConfirmButtonComponent',
  emits: ['confirm'],
  props: {
    message: {
      type: String,
      default: 'តើអ្នកចង់លុបទិន្នន័យនេះមែនឬទេ?'
    },
    positiveText: {
      type: String,
      default: 'លុប'
    },
    negativeText: {
      type: String,
      default: 'បោះបង់'
    }
  }
}
</script>
