<template>
  <section class="mb-10 bg-white border rounded-sm">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ច.៤.ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម / ទំនេរពីមុខងារ</h3>
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
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">មុខតំណែង</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឯកសារ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-24 text-center">សកម្មភាព</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="row._key" :class="rowEdited(row) ? 'pending-row' : 'bg-white'">
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.start" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.end" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.organization"
                filterable
                clearable
                size="small"
                :consistent-menu-width="false"
                :menu-props="wideSelectMenuProps"
                :options="organizationSelectOptions(row.organization)"
                placeholder="ជ្រើសរើសស្ថាប័ន"
                class="w-full uniform-select"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.position"
                filterable
                clearable
                size="small"
                :consistent-menu-width="false"
                :menu-props="wideSelectMenuProps"
                :options="positionSelectOptions(row.position)"
                placeholder="ជ្រើសរើសមុខតំណែង"
                class="w-full uniform-select"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <DocumentUploadCell
                :input-id="`outkrobkhan-document-${row._key}`"
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
import { computed, onMounted, reactive, ref, watch } from 'vue'
import { useStore } from 'vuex'
import DeleteConfirmButtonComponent from './delete-confirm-button.vue'
import DocumentUploadCell from './document-upload-cell.vue'
import PdfDownloadActionButton from './pdf-download-action-button.vue'
import PdfPreviewActionButton from './pdf-preview-action-button.vue'
import PdfPreview from './pdfpreview.vue'
import { useRowDocumentUpload } from './use-row-document-upload'
import {
  buildRowsSnapshot,
  buildTrackedRowsPayload,
  findIncompleteRows,
  rowHasAnyInput
} from './row-save-helpers'

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
    const positionOptions = computed(() => {
      const records = store.getters['position/getRecords']
      if (!Array.isArray(records)) return []
      return [...new Set(records.map((position) => String(position?.name || '').trim()).filter(Boolean))]
    })
    const organizationOptions = computed(() => {
      const records = store.getters['organization/getRecords']
      if (!Array.isArray(records)) return []
      return [...new Set(records.map((organization) => String(organization?.name || '').trim()).filter(Boolean))]
    })
    const wideSelectMenuProps = {
      style: {
        minWidth: '340px',
        maxWidth: '80vw'
      }
    }
    const trackedFields = ['start', 'end', 'organization', 'position', 'pdf']
    const requiredFields = [
      { key: 'start', label: 'ថ្ងៃចាប់ផ្តើម' },
      { key: 'end', label: 'ថ្ងៃបញ្ចប់' },
      { key: 'organization', label: 'ស្ថាប័ន' },
      { key: 'position', label: 'មុខតំណែង' },
      { key: 'total_months', label: 'ចំនួនខែ' }
    ]
    const model = reactive({
      name: 'officerpendingwork',
      module: 'officerpendingwork',
      title: 'ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម / ទំនេរពីមុខងារ'
    })
    const selectedPdfRecord = ref(null)
    const pdfToggle = ref(false)
    let seed = 0

    function nextKey() {
      seed += 1
      return `out-krobkhan-${seed}`
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
        .filter((work) => parseInt(work?.type || 0) === 0)
        .map((work) => ({
          id: parseInt(work?.id || 0) || null,
          _key: nextKey(),
          start: toInputDate(work?.start),
          end: toInputDate(work?.end),
          organization: work?.organization || '',
          position: work?.position || '',
          total_months: Number(work?.total_months || 0),
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
        position: '',
        total_months: 0,
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
      return buildTrackedRowsPayload(
        rows.value,
        ({ _key, _storedPdf, ...item }) => ({ ...item }),
        trackedFields
      )
    }

    function normalizeRow(row) {
      const { _key, _storedPdf, ...item } = row
      return item
    }

    function markSaved() {
      savedSnapshot.value = buildRowsSnapshot(rows.value, normalizeRow)
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
      emit('changed', buildRowsSnapshot(rows.value, normalizeRow) !== savedSnapshot.value)
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
        console.error('Out krobkhan download error:', error)
        window.alert('Unable to download attachment.')
      }
    }

    async function persistChanges() {
      const officerId = parseInt(props.officer?.id || 0)
      if (officerId <= 0) return false

      const incompleteRows = findIncompleteRows(rows.value, {
        activityFields: trackedFields,
        requiredFields: requiredFields.filter((field) => field.key !== 'total_months'),
        includeBlankRows: true,
        shouldValidateRow: (row) => rowEdited(row)
      })

      if (incompleteRows.length > 0) {
        return false
      }

      for (const id of deletedIds.value) {
        await store.dispatch('officerpendingwork/delete', { id })
      }

      for (const row of rows.value) {
        if (!rowEdited(row) || !rowHasAnyInput(row, trackedFields)) {
          continue
        }

        const payload = {
          officer_id: officerId,
          start: row.start || '',
          end: row.end || '',
          organization: row.organization || '',
          position: row.position || '',
          pdf: row.pdf || '',
          clear_pdf: shouldClearStoredPdf(row._key) ? 1 : 0,
          type: 0
        }
        if (parseInt(row.id || 0) > 0) {
          await store.dispatch('officerpendingwork/update', {
            id: parseInt(row.id),
            ...payload
          })
        } else {
          const res = await store.dispatch('officerpendingwork/create', payload)
          row.id = parseInt(res?.data?.record?.id || res?.data?.id || 0) || null
        }
        await uploadDocumentIfNeeded(row.id, row)
        row._storedPdf = row.pdf || ''
      }

      markSaved()
      return true
    }

    function positionSelectOptions(currentValue) {
      const options = Array.isArray(positionOptions.value) ? [...positionOptions.value] : []
      if (currentValue && !options.includes(currentValue)) options.unshift(currentValue)
      return options.map((value) => ({
        label: value,
        value
      }))
    }

    function organizationSelectOptions(currentValue) {
      const options = Array.isArray(organizationOptions.value) ? [...organizationOptions.value] : []
      if (currentValue && !options.includes(currentValue)) options.unshift(currentValue)
      return options.map((value) => ({
        label: value,
        value
      }))
    }

    async function loadPositionOptions() {
      const current = store.getters['position/getRecords']
      if (Array.isArray(current) && current.length > 0) return
      try {
        const res = await store.dispatch('position/structurePosition', {
          search: '',
          page: 1,
          perPage: 1000
        })
        store.commit('position/setRecords', Array.isArray(res?.data?.records) ? res.data.records : [])
      } catch (err) {
        console.log(err)
      }
    }

    async function loadOrganizationOptions() {
      const current = store.getters['organization/getRecords']
      if (Array.isArray(current) && current.length > 0) return
      try {
        const res = await store.dispatch('organization/organizationStructure', {
          search: '',
          page: 1,
          perPage: 1000,
          id: 0
        })
        store.commit('organization/setRecords', Array.isArray(res?.data?.records) ? res.data.records : [])
      } catch (err) {
        console.log(err)
      }
    }

    onMounted(() => {
      loadPositionOptions()
      loadOrganizationOptions()
    })

    watch(() => props.officer?.pending_works, hydrateRows, { immediate: true, deep: true })
    watch(rows, notifyDirty, { deep: true })

    return {
      rows,
      positionOptions,
      organizationOptions,
      wideSelectMenuProps,
      model,
      selectedPdfRecord,
      pdfToggle,
      positionSelectOptions,
      organizationSelectOptions,
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

<style scoped>
.field-input {
  height: 32px;
  box-sizing: border-box;
}

:deep(.uniform-select .n-base-selection) {
  min-height: 32px !important;
  height: 32px !important;
  box-sizing: border-box;
  background-color: #fff !important;
}

:deep(.uniform-select .n-base-selection-label) {
  height: 100%;
  background-color: #fff !important;
}

.pending-row > td {
  background-color: #fee2e2;
}

.pending-row > td:first-child {
  box-shadow: inset 4px 0 0 #dc2626;
}
</style>
