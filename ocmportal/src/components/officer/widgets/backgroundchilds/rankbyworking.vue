<template>
  <section class="mb-10 bg-white border rounded-sm">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ច.២.ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមវេនជ្រើសរើស</h3>
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
      <table class="w-full border-collapse min-w-[1180px]">
        <thead>
          <tr>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">សុពលភាព</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ស្ថាប័ន</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">អង្គភាព</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ការិយាល័យ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្នាក់ចាស់</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្នាក់ថ្មី</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ប្រភេទ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឯកសារ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-24 text-center">សកម្មភាព</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="row._key" :class="rowEdited(row) ? 'bg-[#FEE2E2]' : 'bg-white'">
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.date" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
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
                v-model:value="row.sub_organization"
                filterable
                clearable
                size="small"
                :consistent-menu-width="false"
                :menu-props="wideSelectMenuProps"
                :options="organizationSelectOptions(row.sub_organization)"
                placeholder="ជ្រើសរើសអង្គភាព"
                class="w-full uniform-select"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.sub_sub_organization" type="text" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.previous_rank_id"
                filterable
                clearable
                size="small"
                :consistent-menu-width="false"
                :menu-props="wideSelectMenuProps"
                :options="previousRankSelectOptions(row)"
                placeholder="ជ្រើសរើសថ្នាក់ចាស់"
                class="w-full uniform-select"
                @update:value="(value) => onPreviousRankChange(value, row)"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.rank_id"
                filterable
                clearable
                size="small"
                :consistent-menu-width="false"
                :menu-props="wideSelectMenuProps"
                :options="rankSelectOptions(row)"
                placeholder="ជ្រើសរើសថ្នាក់ថ្មី"
                class="w-full uniform-select"
                @update:value="(value) => onRankChange(value, row)"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input v-model="row.changing_type" type="text" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <DocumentUploadCell
                :input-id="`rankbyworking-document-${row._key}`"
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
            <td colspan="9" class="bg-white p-4 text-center text-gray-500 border-b border-[#E5E7EB]">មិនទាន់មានទិន្នន័យ</td>
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
    } = useRowDocumentUpload(store, 'officerrankbyworking/upload')
    const rankRecords = computed(() => {
      const rankState = store.getters['rank/records']
      return Array.isArray(rankState?.all) ? rankState.all : []
    })
    const rankOptions = computed(() => mapRankOptions(rankRecords.value))
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
    const trackedFields = ['date', 'organization', 'sub_organization', 'sub_sub_organization', 'previous_rank_id', 'rank_id', 'changing_type', 'pdf']
    const requiredFields = [
      { key: 'date', label: 'សុពលភាព' },
      { key: 'organization', label: 'ស្ថាប័ន' },
      { key: 'sub_organization', label: 'អង្គភាព' },
      { key: 'sub_sub_organization', label: 'ការិយាល័យ' },
      { key: 'previous_rank_id', label: 'ថ្នាក់ចាស់' },
      { key: 'rank_id', label: 'ថ្នាក់ថ្មី' },
      { key: 'changing_type', label: 'ប្រភេទ' }
    ]
    const model = reactive({
      name: 'officerrankbyworking',
      module: 'officerrankbyworkings',
      title: 'ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមវេនជ្រើសរើស'
    })
    const selectedPdfRecord = ref(null)
    const pdfToggle = ref(false)
    let seed = 0

    function nextKey() {
      seed += 1
      return `rank-work-${seed}`
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      if (Number.isNaN(d.getTime())) return String(value).slice(0, 10)
      return d.toISOString().slice(0, 10)
    }

    function normalizeId(value) {
      const parsed = parseInt(value || 0)
      return parsed > 0 ? parsed : null
    }

    function normalizeLabel(value) {
      return String(value || '').trim()
    }

    function normalizeOptionLabel(value) {
      return normalizeLabel(value).replace(/\s+/g, ' ')
    }

    const KHMER_DIGIT_MAP = {
      '០': '0',
      '១': '1',
      '២': '2',
      '៣': '3',
      '៤': '4',
      '៥': '5',
      '៦': '6',
      '៧': '7',
      '៨': '8',
      '៩': '9'
    }

    function toLatinDigits(value) {
      return String(value || '').replace(/[០-៩]/g, (digit) => KHMER_DIGIT_MAP[digit] || digit)
    }

    function parseSortNumber(value) {
      const normalized = toLatinDigits(value).replace(/[^0-9]/g, '')
      if (!normalized) return Number.NaN
      return parseInt(normalized, 10)
    }

    function compareRankPart(left, right) {
      const leftLabel = normalizeLabel(left)
      const rightLabel = normalizeLabel(right)

      const leftNumber = parseSortNumber(leftLabel)
      const rightNumber = parseSortNumber(rightLabel)
      const leftHasNumber = Number.isFinite(leftNumber)
      const rightHasNumber = Number.isFinite(rightNumber)

      if (leftHasNumber && rightHasNumber && leftNumber !== rightNumber) {
        return leftNumber - rightNumber
      }

      if (leftHasNumber !== rightHasNumber) {
        return leftHasNumber ? -1 : 1
      }

      return leftLabel.localeCompare(rightLabel, 'km')
    }

    function compareRankRecord(left, right) {
      const byKrobkhan = compareRankPart(left?.krobkhan, right?.krobkhan)
      if (byKrobkhan !== 0) return byKrobkhan

      const byRank = compareRankPart(left?.rank, right?.rank)
      if (byRank !== 0) return byRank

      const byThnak = compareRankPart(left?.thnak, right?.thnak)
      if (byThnak !== 0) return byThnak

      return compareRankPart(left?.name, right?.name)
    }

    function formatRankLabel(rank) {
      const ank = normalizeLabel(rank?.ank)
      const krobkhan = normalizeLabel(rank?.krobkhan)
      const rankValue = normalizeLabel(rank?.rank)
      const thnak = normalizeLabel(rank?.thnak)
      const code = [krobkhan, rankValue, thnak]
        .filter((part) => part !== '')
        .join('.')

      if (ank && code) return `${ank}-${code}`
      return ank || code || normalizeLabel(rank?.name || rank?.desp || rank?.krobkhan_name)
    }

    function mapRankOptions(records) {
      if (!Array.isArray(records)) return []
      const sortedRecords = [...records].sort(compareRankRecord)
      const seen = new Set()
      const seenLabels = new Set()
      const options = []
      sortedRecords.forEach((item) => {
        const id = normalizeId(item?.id)
        const display = formatRankLabel(item)
        const label = normalizeOptionLabel(display || `#${id}`)
        if (!id || seen.has(id)) return
        if (label && seenLabels.has(label)) return
        seen.add(id)
        if (label) seenLabels.add(label)
        options.push({
          label,
          value: id
        })
      })
      return options
    }

    function findOptionByLabel(options, label) {
      const target = normalizeOptionLabel(label)
      if (!target) return null
      return options.find((option) => normalizeOptionLabel(option?.label) === target) || null
    }

    function syncRowRankIdsToOptions() {
      const options = Array.isArray(rankOptions.value) ? rankOptions.value : []
      if (rows.value.length <= 0 || options.length <= 0) return false

      let changed = false
      rows.value.forEach((row) => {
        const hasCurrentRank = options.some((option) => option.value === normalizeId(row?.rank_id))
        if (!hasCurrentRank) {
          const matchedRank = findOptionByLabel(options, row?.rank)
          if (matchedRank && matchedRank.value !== row.rank_id) {
            row.rank_id = matchedRank.value
            row.rank = matchedRank.label
            changed = true
          }
        }

        const hasCurrentPreviousRank = options.some((option) => option.value === normalizeId(row?.previous_rank_id))
        if (!hasCurrentPreviousRank) {
          const matchedPreviousRank = findOptionByLabel(options, row?.previous_rank)
          if (matchedPreviousRank && matchedPreviousRank.value !== row.previous_rank_id) {
            row.previous_rank_id = matchedPreviousRank.value
            row.previous_rank = matchedPreviousRank.label
            changed = true
          }
        }
      })

      return changed
    }

    function hydrateRows() {
      const source = props.officer?.ranking_by_workings || []
      rows.value = source.map((rank) => ({
        id: parseInt(rank?.id || 0) || null,
        _key: nextKey(),
        date: toInputDate(rank?.date),
        organization: rank?.organization || '',
        sub_organization: rank?.sub_organization || '',
        sub_sub_organization: rank?.sub_sub_organization || '',
        previous_rank_id: parseInt(rank?.previous_rank_id || rank?.previous_rank?.id || 0) || null,
        previous_rank: formatRankLabel(rank?.previous_rank) || rank?.previous_rank?.thnak || rank?.previous_rank?.name || '',
        rank_id: parseInt(rank?.rank_id || rank?.rank?.id || 0) || null,
        rank: formatRankLabel(rank?.rank) || rank?.rank?.thnak || rank?.rank?.name || '',
        changing_type: String(rank?.changing_type || '').trim(),
        pdf: storedFileLabel(rank?.pdf),
        _storedPdf: storedFileLabel(rank?.pdf)
      }))
      syncRowRankIdsToOptions()
      markSaved()
    }

    function addRow() {
      rows.value.push({
        id: null,
        _key: nextKey(),
        date: '',
        organization: '',
        sub_organization: '',
        sub_sub_organization: '',
        previous_rank_id: null,
        previous_rank: '',
        rank_id: null,
        rank: '',
        changing_type: '',
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
        console.error('Rank by working download error:', error)
        window.alert('Unable to download attachment.')
      }
    }

    function resolveRankId(name, fallbackId = null) {
      const numeric = parseInt(name || 0)
      if (numeric > 0) return numeric
      const target = String(name || '').trim()
      if (!target) return parseInt(fallbackId || 0) || 0
      const matched = rankRecords.value.find((rank) => {
        const formatted = formatRankLabel(rank)
        const thnak = String(rank?.thnak || '').trim()
        const label = String(rank?.name || '').trim()
        return formatted === target || thnak === target || label === target
      })
      if (matched) return parseInt(matched.id || 0) || 0
      return parseInt(fallbackId || 0) || 0
    }

    async function persistChanges() {
      const officerId = parseInt(props.officer?.id || 0)
      if (officerId <= 0) return false

      const incompleteRows = findIncompleteRows(rows.value, {
        activityFields: trackedFields,
        requiredFields,
        includeBlankRows: true,
        shouldValidateRow: (row) => rowEdited(row)
      })

      if (incompleteRows.length > 0) {
        return false
      }

      for (const id of deletedIds.value) {
        await store.dispatch('officerrankbyworking/delete', { id })
      }

      for (const row of rows.value) {
        if (!rowEdited(row) || !rowHasAnyInput(row, trackedFields)) {
          continue
        }

        const payload = {
          officer_id: officerId,
          organization: row.organization || '',
          sub_organization: row.sub_organization || '',
          sub_sub_organization: row.sub_sub_organization || '',
          date: row.date || '',
          rank_id: normalizeId(row.rank_id) || resolveRankId(row.rank, row.rank_id),
          previous_rank_id: normalizeId(row.previous_rank_id) || resolveRankId(row.previous_rank, row.previous_rank_id),
          changing_type: String(row.changing_type || '').trim(),
          pdf: row.pdf || '',
          clear_pdf: shouldClearStoredPdf(row._key) ? 1 : 0
        }
        if (parseInt(row.id || 0) > 0) {
          await store.dispatch('officerrankbyworking/update', {
            id: parseInt(row.id),
            ...payload
          })
        } else {
          const res = await store.dispatch('officerrankbyworking/create', payload)
          row.id = parseInt(res?.data?.record?.id || 0) || null
        }
        row.rank_id = payload.rank_id
        row.previous_rank_id = payload.previous_rank_id
        await uploadDocumentIfNeeded(row.id, row)
        row._storedPdf = row.pdf || ''
      }

      markSaved()
      return true
    }

    function previousRankSelectOptions(row) {
      const options = Array.isArray(rankOptions.value) ? [...rankOptions.value] : []
      const currentId = normalizeId(row?.previous_rank_id)
      const currentLabel = normalizeOptionLabel(row?.previous_rank)
      const hasSameLabel = currentLabel && options.some((option) => normalizeOptionLabel(option.label) === currentLabel)
      if (currentId && !options.some((option) => option.value === currentId) && !hasSameLabel) {
        options.unshift({
          label: currentLabel || `#${currentId}`,
          value: currentId
        })
      }
      return options
    }

    function rankSelectOptions(row) {
      const options = Array.isArray(rankOptions.value) ? [...rankOptions.value] : []
      const currentId = normalizeId(row?.rank_id)
      const currentLabel = normalizeOptionLabel(row?.rank)
      const hasSameLabel = currentLabel && options.some((option) => normalizeOptionLabel(option.label) === currentLabel)
      if (currentId && !options.some((option) => option.value === currentId) && !hasSameLabel) {
        options.unshift({
          label: currentLabel || `#${currentId}`,
          value: currentId
        })
      }
      return options
    }

    function onPreviousRankChange(value, row) {
      const rankId = normalizeId(value)
      row.previous_rank_id = rankId
      if (!rankId) {
        row.previous_rank = ''
        return
      }
      const matched = rankOptions.value.find((option) => option.value === rankId)
      row.previous_rank = matched?.label || row.previous_rank || ''
    }

    function onRankChange(value, row) {
      const rankId = normalizeId(value)
      row.rank_id = rankId
      if (!rankId) {
        row.rank = ''
        return
      }
      const matched = rankOptions.value.find((option) => option.value === rankId)
      row.rank = matched?.label || row.rank || ''
    }

    function organizationSelectOptions(currentValue) {
      const options = Array.isArray(organizationOptions.value) ? [...organizationOptions.value] : []
      if (currentValue && !options.includes(currentValue)) options.unshift(currentValue)
      return options.map((value) => ({
        label: value,
        value
      }))
    }

    async function loadRankOptions() {
      const current = store.getters['rank/records']
      if (Array.isArray(current?.all) && current.all.length > 0) return
      try {
        const res = await store.dispatch('rank/list', {
          search: '',
          page: 1,
          perPage: 1000
        })
        store.commit('rank/setAllRecords', Array.isArray(res?.data?.records) ? res.data.records : [])
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
      loadRankOptions()
      loadOrganizationOptions()
    })

    watch(() => props.officer?.ranking_by_workings, hydrateRows, { immediate: true, deep: true })
    watch(rankOptions, () => {
      if (syncRowRankIdsToOptions()) {
        markSaved()
      }
    }, { deep: true })
    watch(rows, notifyDirty, { deep: true })

    return {
      rows,
      rankOptions,
      organizationOptions,
      wideSelectMenuProps,
      model,
      selectedPdfRecord,
      pdfToggle,
      rankSelectOptions,
      previousRankSelectOptions,
      onPreviousRankChange,
      onRankChange,
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
</style>
