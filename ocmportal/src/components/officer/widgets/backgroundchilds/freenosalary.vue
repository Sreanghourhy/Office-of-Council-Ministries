<template>
  <section class="mb-10 bg-white border border-[#D8DEE8] rounded-sm">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ច.៥.ស្ថានភាពផ្សេងៗ</h3>
      <button
        type="button"
        class="inline-flex items-center gap-1 bg-[#1E3A8A] text-white rounded-md px-3 py-1.5 text-[13px] hover:bg-[#162E6B] duration-200"
        @click="addRow"
      >
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v5.5h5.5a.75.75 0 0 1 0 1.5h-5.5v5.5a.75.75 0 0 1-1.5 0v-5.5h-5.5a.75.75 0 0 1 0-1.5h5.5v-5.5A.75.75 0 0 1 10 3z" clip-rule="evenodd" />
        </svg>
        <span>បន្ថែម</span>
      </button>
    </div>

    <div v-if="officer != undefined" class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[860px]">
        <thead>
          <tr>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃចាប់ផ្ដើម</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃបញ្ចប់</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ស្ថាប័ន</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ចំនួនខែ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឯកសារ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-24 text-center">សកម្មភាព</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="row._key" :class="rowEdited(row) ? 'bg-[#FEE2E2]' : 'bg-white'">
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.start" type="date" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.end" type="date" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.organization" type="text" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.total_months" type="number" min="0" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <DocumentUploadCell
                :input-id="`freenosalary-document-${row._key}`"
                :model-value="row.pdf"
                :accept="'.pdf,application/pdf'"
                :type-label="documentFileTypeLabel(row._key)"
                @select="(file) => onDocumentFileChange(row, file)"
                @clear="clearDocumentFile(row)"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB] text-center">
              <div class="flex items-center justify-center gap-2">
                <pdf-preview-action-button :disabled="!rowHasPreview(row)" @click="openPdfPreview(row)" />
                <pdf-download-action-button :disabled="!rowHasDownload(row)" @click="downloadRowDocument(row)" />
                <delete-confirm-button-component @confirm="removeRow(index)" />
              </div>
            </td>
          </tr>
          <tr v-if="rows.length <= 0">
            <td colspan="6" class="bg-white p-4 text-center text-gray-500 border-b border-[#E5E7EB]">មិនទាន់មានទិន្នន័យ</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="officer == undefined" class="w-full p-8 text-center text-red-500">សូមបញ្ជាកព័ត៌មានមន្ត្រីជាមុនសិន។</div>
    <pdf-preview :model="model" :record="selectedPdfRecord" :show="pdfToggle" :onClose="openPdfPreview" />
  </section>
</template>

<script>
import { reactive, ref, watch } from 'vue'
import { useStore } from 'vuex'
import DeleteConfirmButtonComponent from './delete-confirm-button.vue'
import DocumentUploadCell from './document-upload-cell.vue'
import PdfDownloadActionButton from './pdf-download-action-button.vue'
import PdfPreviewActionButton from './pdf-preview-action-button.vue'
import PdfPreview from './pdfpreview.vue'
import { useRowDocumentUpload } from './use-row-document-upload'

export default {
  emits: ['changed'],
  props: {
    officer: {
      type: Object,
      default: undefined
    }
  },
  components: {
    DeleteConfirmButtonComponent,
    DocumentUploadCell,
    PdfDownloadActionButton,
    PdfPreviewActionButton,
    PdfPreview
  },
  setup(props, { emit }) {
    const store = useStore()
    const rows = ref([])
    const savedSnapshot = ref('[]')
    const savedRowsByKey = ref({})
    const deletedIds = ref([])
    const {
      storedFileLabel,
      onDocumentFileChange,
      clearDocumentFile,
      documentFileTypeLabel,
      resetDocumentFiles,
      rowHasPreview,
      rowHasDownload,
      shouldClearStoredPdf,
      uploadDocumentIfNeeded,
      downloadDocument
    } = useRowDocumentUpload(store, 'officerpendingwork/upload')
    const model = reactive({
      name: 'officerpendingwork',
      module: 'officerpendingwork',
      title: 'ស្ថានភាពផ្សេងៗ'
    })
    const selectedPdfRecord = ref(null)
    const pdfToggle = ref(false)
    let seed = 0

    function nextKey() {
      seed += 1
      return `other-status-${seed}`
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      if (Number.isNaN(d.getTime())) return String(value).slice(0, 10)
      return d.toISOString().slice(0, 10)
    }

    function hydrateRows() {
      const source = props.officer?.pending_works || []
      rows.value = source
        .filter((work) => parseInt(work?.type || 0) === 1)
        .map((work) => ({
          id: parseInt(work?.id || 0) || null,
          _key: nextKey(),
          start: toInputDate(work?.start),
          end: toInputDate(work?.end),
          organization: work?.organization || '',
          total_months: work?.total_months || '',
          position: work?.position || '',
          pdf: storedFileLabel(work?.pdf),
          _storedPdf: storedFileLabel(work?.pdf)
        }))
      markSaved()
    }

    function addRow() {
      rows.value.push({
        id: null,
        _key: nextKey(),
        start: '',
        end: '',
        organization: '',
        total_months: '',
        position: '',
        pdf: '',
        _storedPdf: ''
      })
    }

    function removeRow(index) {
      const row = rows.value[index]
      if (parseInt(row?.id || 0) > 0) {
        deletedIds.value.push(parseInt(row.id))
      }
      if (row) clearDocumentFile(row)
      rows.value.splice(index, 1)
    }

    function toPayload() {
      return rows.value.map(({ _key, _storedPdf, ...item }) => ({ ...item }))
    }

    function normalizeRow(row) {
      const { _key, _storedPdf, ...item } = row
      return item
    }

    function markSaved() {
      const payload = toPayload()
      savedSnapshot.value = JSON.stringify(payload)
      const mapped = {}
      rows.value.forEach((row) => {
        mapped[row._key] = JSON.stringify(normalizeRow(row))
      })
      savedRowsByKey.value = mapped
      deletedIds.value = []
      resetDocumentFiles()
      emit('changed', false)
    }

    function rowEdited(row) {
      const snapshotRow = savedRowsByKey.value[row._key]
      if (snapshotRow === undefined) return true
      return JSON.stringify(normalizeRow(row)) !== snapshotRow
    }

    function notifyDirty() {
      emit('changed', JSON.stringify(toPayload()) !== savedSnapshot.value)
    }

    function cancelChanges() {
      hydrateRows()
    }

    function openPdfPreview(record) {
      selectedPdfRecord.value = record == null ? null : record
      pdfToggle.value = !pdfToggle.value
    }

    async function downloadRowDocument(row) {
      try {
        await downloadDocument(row, `${model.name}/pdf`)
      } catch (error) {
        console.error('Free no salary download error:', error)
        window.alert('Unable to download attachment.')
      }
    }

    async function persistChanges() {
      const officerId = parseInt(props.officer?.id || 0)
      if (officerId <= 0) return false

      for (const id of deletedIds.value) {
        await store.dispatch('officerpendingwork/delete', { id })
      }

      for (const row of rows.value) {
        const payload = {
          officer_id: officerId,
          start: row.start || '',
          end: row.end || '',
          organization: row.organization || '',
          position: row.position || '',
          total_months: Number(row.total_months || 0),
          pdf: row.pdf || '',
          clear_pdf: shouldClearStoredPdf(row._key) ? 1 : 0,
          type: 1
        }
        if (parseInt(row.id || 0) > 0) {
          await store.dispatch('officerpendingwork/update', {
            id: parseInt(row.id),
            ...payload
          })
        } else {
          const res = await store.dispatch('officerpendingwork/create', payload)
          row.id = parseInt(res?.data?.record?.id || 0) || null
        }
        await uploadDocumentIfNeeded(row.id, row)
        row._storedPdf = row.pdf || ''
      }

      markSaved()
      return true
    }

    watch(() => props.officer?.pending_works, hydrateRows, { immediate: true, deep: true })
    watch(rows, notifyDirty, { deep: true })

    return {
      rows,
      model,
      selectedPdfRecord,
      pdfToggle,
      onDocumentFileChange,
      clearDocumentFile,
      documentFileTypeLabel,
      rowHasPreview,
      rowHasDownload,
      openPdfPreview,
      downloadRowDocument,
      addRow,
      removeRow,
      cancelChanges,
      persistChanges,
      markSaved,
      rowEdited
    }
  }
}
</script>
