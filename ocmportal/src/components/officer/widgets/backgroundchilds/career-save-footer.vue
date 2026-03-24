<template>
  <div
    v-if="visible"
    class="career-save-footer fixed inset-x-0 bottom-0 z-40 h-[60px] bg-white border-t border-[#D8DEE8] shadow-[0_-2px_10px_rgba(30,58,138,0.12)]"
  >
    <div class="h-full px-4 md:px-8 flex items-center justify-between gap-3">
      <div class="inline-flex items-center gap-2 text-[#1E3A8A] text-[13px] md:text-sm font-semibold whitespace-nowrap">
        <span class="w-2.5 h-2.5 rounded-full bg-[#1E3A8A]"></span>
        <span>{{ changedCount }}</span>
        <span class="hidden sm:inline">{{ changedCount === 1 ? 'ផ្នែកបានផ្លាស់ប្តូរ' : 'ផ្នែកបានផ្លាស់ប្តូរ' }}</span>
        <span class="sm:hidden">Changed</span>
      </div>
      <div class="flex items-center gap-2">
        <button
          v-if="showNavigation"
          type="button"
          :disabled="!canNavigate"
          @click="$emit('previous')"
          class="career-nav-btn"
        >
          <svg class="w-4 h-4 rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 4.25a.75.75 0 0 1 .75.75v8.19l2.72-2.72a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 1 1 1.06-1.06l2.72 2.72V5a.75.75 0 0 1 .75-.75z" clip-rule="evenodd" />
          </svg>
          <span class="hidden sm:inline">មុន</span>
        </button>
        <button
          v-if="showNavigation"
          type="button"
          :disabled="!canNavigate"
          @click="$emit('next')"
          class="career-nav-btn"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 4.25a.75.75 0 0 1 .75.75v8.19l2.72-2.72a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 1 1 1.06-1.06l2.72 2.72V5a.75.75 0 0 1 .75-.75z" clip-rule="evenodd" />
          </svg>
          <span class="hidden sm:inline">បន្ទាប់</span>
        </button>
        <!-- <button
          type="button"
          :disabled="!canNavigate"
          @click="$emit('cancel-section')"
          class="career-cancel-btn"
        >
          <span class="hidden sm:inline">បោះបង់ផ្នែកជ្រើសរើស</span>
          <span class="sm:hidden">Cancel</span>
        </button> -->
        <button
          type="button"
          :disabled="!canNavigate"
          @click="$emit('cancel-all')"
          class="career-cancel-all-btn"
        >
          <span class="hidden sm:inline">បោះបង់</span>
          <span class="sm:hidden">All</span>
        </button>
        <button
          type="button"
          :disabled="!canNavigate"
          @click="$emit('save-all')"
          class="career-save-btn"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M3 5a2 2 0 0 1 2-2h8.38a2 2 0 0 1 1.42.59l1.61 1.61A2 2 0 0 1 17 6.62V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.62a1 1 0 0 0-.29-.71l-1.61-1.61a1 1 0 0 0-.71-.3H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5z"/>
          </svg>
          <span class="hidden sm:inline">បញ្ចូលទិន្នន័យ</span>
          <span class="sm:hidden">Save</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CareerSaveFooterComponent',
  emits: ['previous', 'next', 'cancel-section', 'cancel-all', 'save-all'],
  props: {
    visible: {
      type: Boolean,
      default: false
    },
    changedCount: {
      type: Number,
      default: 0
    },
    canNavigate: {
      type: Boolean,
      default: false
    },
    showNavigation: {
      type: Boolean,
      default: true
    }
  }
}
</script>

<style scoped>
.career-nav-btn {
  height: 34px;
  min-width: 34px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 0 10px;
  border: 1px solid #d8dee8;
  border-radius: 6px;
  background: #fff;
  color: #1e3a8a;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.career-nav-btn:hover:not(:disabled) {
  border-color: #1e3a8a;
  background: #f8fbff;
}

.career-nav-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.career-save-btn {
  height: 38px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 0 14px;
  border: 1px solid #1e3a8a;
  border-radius: 6px;
  background: #1e3a8a;
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  box-shadow: 0 1px 4px rgba(30, 58, 138, 0.2);
  transition: background-color 0.2s ease, border-color 0.2s ease;
}

.career-save-btn:hover:not(:disabled) {
  background: #162e6b;
  border-color: #162e6b;
}

.career-save-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.career-cancel-btn {
  height: 34px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 10px;
  border: 1px solid #ef4444;
  border-radius: 6px;
  background: #fff5f5;
  color: #b42318;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.career-cancel-btn:hover:not(:disabled) {
  border-color: #dc2626;
  background: #fee2e2;
}

.career-cancel-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.career-cancel-all-btn {
  height: 34px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 10px;
  border: 1px solid #b42318;
  border-radius: 6px;
  background: #b42318;
  color: #fff;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.career-cancel-all-btn:hover:not(:disabled) {
  border-color: #8b1c13;
  background: #8b1c13;
}

.career-cancel-all-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}
</style>
