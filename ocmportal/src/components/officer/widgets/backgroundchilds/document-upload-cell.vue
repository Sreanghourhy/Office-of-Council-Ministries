<template>
  <div class="document-upload">
    <label :for="inputId" class="document-upload-trigger">
      {{ label }}
    </label>
    <input
      :id="inputId"
      type="file"
      :accept="accept"
      class="hidden"
      @change="handleChange"
    />
    <span class="document-file-slot">
      <template v-if="modelValue">
        <n-tooltip trigger="hover" placement="top">
          <template #trigger>
            <span class="document-file-name" :title="fileNameTitle">
              {{ displayFileName }}
            </span>
          </template>
          {{ fileNameTitle }}
        </n-tooltip>
        <span :class="['document-file-type', `document-file-type--${fileKind}`]">
          {{ fileTypeLabel }}
        </span>
      </template>
      <span v-else class="document-file-name document-file-name--empty">
        {{ placeholder }}
      </span>
    </span>
    <button
      v-if="showPreview"
      type="button"
      class="document-upload-preview"
      @click="$emit('preview')"
    >
      <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12 5c5.23 0 9.57 3.03 11.3 7.39a1.6 1.6 0 0 1 0 1.22C21.57 17.97 17.23 21 12 21S2.43 17.97.7 13.61a1.6 1.6 0 0 1 0-1.22C2.43 8.03 6.77 5 12 5zm0 2C7.75 7 4.17 9.39 2.73 13C4.17 16.61 7.75 19 12 19s7.83-2.39 9.27-6C19.83 9.39 16.25 7 12 7zm0 2.5a3.5 3.5 0 1 1 0 7a3.5 3.5 0 0 1 0-7zm0 2a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z" />
      </svg>
    </button>
    <button
      v-if="modelValue"
      type="button"
      class="document-upload-clear"
      @click="$emit('clear')"
    >
      <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M4.72 4.72a.75.75 0 0 1 1.06 0L10 8.94l4.22-4.22a.75.75 0 1 1 1.06 1.06L11.06 10l4.22 4.22a.75.75 0 1 1-1.06 1.06L10 11.06l-4.22 4.22a.75.75 0 1 1-1.06-1.06L8.94 10 4.72 5.78a.75.75 0 0 1 0-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>
</template>

<script>
import { computed } from 'vue'

export default {
  emits: ['select', 'clear', 'preview'],
  props: {
    inputId: {
      type: String,
      required: true
    },
    modelValue: {
      type: String,
      default: ''
    },
    typeLabel: {
      type: String,
      default: ''
    },
    accept: {
      type: String,
      default: '.pdf,application/pdf'
    },
    label: {
      type: String,
      default: 'ឯកសារ'
    },
    showPreview: {
      type: Boolean,
      default: false
    },
    placeholder: {
      type: String,
      default: 'មិនទាន់ជ្រើសរើសឯកសារ'
    },
    maxDisplayLength: {
      type: Number,
      default: 18
    }
  },
  setup(props, { emit }) {
    const fileNameTitle = computed(() => props.modelValue || props.placeholder)
    const displayFileName = computed(() => {
      const source = String(props.modelValue || props.placeholder || '').trim()
      const maxLength = Math.max(6, parseInt(props.maxDisplayLength || 18))
      if (source.length <= maxLength) return source
      return `${source.slice(0, maxLength - 3)}...`
    })
    const fileKind = computed(() => {
      const normalizedTypeLabel = String(props.typeLabel || '').trim().toUpperCase()
      if (normalizedTypeLabel === 'PDF') return 'pdf'
      if (normalizedTypeLabel === 'IMG' || normalizedTypeLabel === 'IMAGE') return 'img'

      const lowerName = String(props.modelValue || '').trim().toLowerCase()
      if (lowerName.endsWith('.pdf')) return 'pdf'
      if (/\.(png|jpe?g|gif|bmp|webp|svg|heic|heif|tiff?)$/i.test(lowerName)) return 'img'
      return 'file'
    })
    const fileTypeLabel = computed(() => {
      const normalizedTypeLabel = String(props.typeLabel || '').trim().toUpperCase()
      if (normalizedTypeLabel) return normalizedTypeLabel
      if (fileKind.value === 'pdf') return 'PDF'
      if (fileKind.value === 'img') return 'IMG'
      return 'FILE'
    })

    function handleChange(event) {
      const file = event?.target?.files?.[0]
      if (!file) return
      const normalizedType = String(file.type || '').trim().toLowerCase()
      const normalizedName = String(file.name || '').trim().toLowerCase()
      const isPdf = normalizedType === 'application/pdf' || normalizedName.endsWith('.pdf')
      if (!isPdf) {
        window.alert('សូមជ្រើសរើសឯកសារ PDF តែប៉ុណ្ណោះ។')
        event.target.value = ''
        return
      }
      emit('select', file)
      event.target.value = ''
    }

    return {
      fileNameTitle,
      displayFileName,
      fileKind,
      fileTypeLabel,
      handleChange
    }
  }
}
</script>

<style scoped>
.document-upload {
  width: 100%;
  min-width: 0;
  box-sizing: border-box;
  height: 32px;
  display: flex;
  align-items: center;
  gap: 4px;
  border: 1px solid #d8dee8;
  border-radius: 4px;
  background: #fff;
  padding: 0 4px 0 0;
  overflow: hidden;
}

.document-upload-trigger {
  height: 100%;
  display: inline-flex;
  align-items: center;
  border-right: 1px solid #d8dee8;
  background: #fff;
  color: #1e3a8a;
  font-size: 12px;
  padding: 0 10px;
  cursor: pointer;
  white-space: nowrap;
  box-sizing: border-box;
}

.document-upload-trigger:hover {
  background: #f8fafc;
}

.document-file-slot {
  flex: 1;
  min-width: 0;
  display: flex;
  align-items: center;
  gap: 6px;
  padding-left: 4px;
}

.document-file-name {
  flex: 1;
  min-width: 0;
  color: #2c3e50;
  font-size: 12px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.document-file-name--empty {
  color: #64748b;
}

.document-file-type {
  flex-shrink: 0;
  font-size: 10px;
  line-height: 1;
  border-radius: 9999px;
  padding: 3px 6px;
}

.document-file-type--pdf {
  color: #b91c1c;
  background: #fee2e2;
}

.document-file-type--img {
  color: #0369a1;
  background: #e0f2fe;
}

.document-file-type--file {
  color: #475569;
  background: #e2e8f0;
}

.document-upload-clear {
  color: #9ca3af;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.document-upload-preview {
  color: #9ca3af;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.document-upload-preview:hover {
  color: #2563eb;
}

.document-upload-clear:hover {
  color: #dc2626;
}
</style>
