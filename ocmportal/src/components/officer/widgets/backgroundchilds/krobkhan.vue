<template>
  <section class="mb-10 bg-white border rounded-sm">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ប្រវត្តិក្របខ័ណ្ឌ</h3>
    </div>

    <div v-if="officer != undefined" class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[900px]">
        <thead>
          <tr>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃខែឆ្នាំចូលបម្រើការរដ្ឋ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃខែឆ្នាំតាំងស៊ប់ក្នុងក្របខ័ណ្ឌរដ្ឋ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឈ្មោះក្របខណ្ឌ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ក្របខណ្ឌ ឋានន្តរស័ក្ត និងថ្នាក់បច្ចុប្បន្ន</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="row in rows"
            :key="row._key"
            :class="rowEdited(row) ? 'bg-[#FEE2E2]' : 'bg-white'"
          >
            <td class="p-2 border-b border-[#E5E7EB]">
              <input
                v-model="row.start"
                type="date"
                class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <input
                v-model="row.end"
                type="date"
                class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB] text-[13px] text-[#1F2937]">
              {{ row.displayAnk || '-' }}
            </td>
            <td class="p-2 border-b border-[#E5E7EB] text-[13px] text-[#1F2937]">
              {{ row.displayCurrentRank || '-' }}
            </td>
          </tr>

          <tr v-if="rows.length <= 0">
            <td colspan="4" class="bg-white p-4 text-center text-gray-500 border-b border-[#E5E7EB]">
              មិនទាន់មានទិន្នន័យ
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="officer == undefined" class="w-full p-8 text-center text-red-500">
      សូមបញ្ជាក់ព័ត៌មានមន្ត្រីជាមុនសិន
    </div>
  </section>
</template>

<script>
import { computed, onMounted, ref, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  emits: ['changed'],
  props: {
    officer: {
      type: Object,
      default: undefined
    }
  },
  setup(props, { emit, expose }) {
    const store = useStore()
    const rows = ref([])
    const savedSnapshot = ref('[]')
    const savedRowsByKey = ref({})
    const isHydrating = ref(false)
    let seed = 0

    const rankRecords = computed(() => {
      const records = store.getters['rank/records']
      return Array.isArray(records?.all) ? records.all : []
    })

    function nextKey() {
      seed += 1
      return `krobkhan-${seed}`
    }

    function normalizeSelection(value) {
      return String(value || '').trim()
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      if (Number.isNaN(d.getTime())) return String(value).slice(0, 10)
      return d.toISOString().slice(0, 10)
    }

    function getRankRecordById(rankId) {
      const normalizedId = parseInt(rankId || 0) || 0
      if (normalizedId <= 0) return null
      return rankRecords.value.find((item) => (parseInt(item?.id || 0) || 0) === normalizedId) || null
    }

    function resolveCurrentRankDataFromDb() {
      const rankObject =
        props.officer?.rank && typeof props.officer.rank === 'object'
          ? props.officer.rank
          : {}

      const rankId = parseInt(rankObject?.id || props.officer?.rank_id || 0) || 0
      const rankById = getRankRecordById(rankId)

      return {
        id: rankId,
        ank: normalizeSelection(rankById?.ank || rankObject?.ank),
        prefix: normalizeSelection(rankById?.prefix || rankObject?.prefix),
        krobkhan: normalizeSelection(rankById?.krobkhan || rankObject?.krobkhan),
        rank: normalizeSelection(rankById?.rank || rankObject?.rank),
        thnak: normalizeSelection(rankById?.thnak || rankObject?.thnak)
      }
    }

    function emptyRow() {
      return {
        id: null,
        _key: nextKey(),
        start: '',
        end: '',
        displayAnk: '',
        displayCurrentRank: ''
      }
    }

    function buildRowFromOfficer() {
      const currentRank = resolveCurrentRankDataFromDb()

      return {
        id: currentRank.id || null,
        _key: nextKey(),
        start: toInputDate(props.officer?.unofficial_date),
        end: toInputDate(props.officer?.official_date),
        displayAnk: currentRank.ank,
        displayCurrentRank: currentRank.prefix
      }
    }

    function hydrateRows() {
      isHydrating.value = true
      if (!props.officer) {
        rows.value = [emptyRow()]
        markSaved()
        isHydrating.value = false
        return
      }

      rows.value = [buildRowFromOfficer()]
      markSaved()
      isHydrating.value = false
    }

    function normalizeRow(row) {
      return {
        id: row.id,
        start: normalizeSelection(row.start),
        end: normalizeSelection(row.end)
      }
    }

    function toPayload() {
      return rows.value.map((row) => normalizeRow(row))
    }

    function markSaved() {
      savedSnapshot.value = JSON.stringify(toPayload())
      const mapped = {}
      rows.value.forEach((row) => {
        mapped[row._key] = JSON.stringify(normalizeRow(row))
      })
      savedRowsByKey.value = mapped
      emit('changed', false)
    }

    function rowEdited(row) {
      const snapshotRow = savedRowsByKey.value[row._key]
      if (snapshotRow === undefined) return true
      return JSON.stringify(normalizeRow(row)) !== snapshotRow
    }

    function notifyDirty() {
      if (isHydrating.value) return
      emit('changed', JSON.stringify(toPayload()) !== savedSnapshot.value)
    }

    function cancelChanges() {
      hydrateRows()
    }

    function buildSavePayload() {
      const officerId = parseInt(props.officer?.id || 0)
      if (officerId <= 0) return null

      const row = rows.value[0] || emptyRow()

      return {
        id: officerId,
        unofficial_date: row.start || null,
        official_date: row.end || null
      }
    }

    async function persistChanges() {
      const officerId = parseInt(props.officer?.id || 0)
      if (officerId <= 0) return false

      try {
        const payload = buildSavePayload()
        if (!payload) {
          markSaved()
          return true
        }

        const res = await store.dispatch('officer/update', payload)
        if (!(res?.data?.ok === true || res?.status === 200)) {
          throw new Error('krobkhan-update-failed')
        }

        const record = res?.data?.record || {}
        props.officer.unofficial_date = record.unofficial_date ?? payload.unofficial_date
        props.officer.official_date = record.official_date ?? payload.official_date
        if (record.officer_type !== undefined) {
          props.officer.officer_type = record.officer_type
        }
        if (record.salary_rank !== undefined) {
          props.officer.salary_rank = record.salary_rank
        }
        if (record.current_salary_rank !== undefined) {
          props.officer.current_salary_rank = record.current_salary_rank
        }
        if (record.current_rank_ank !== undefined) {
          props.officer.current_rank_ank = record.current_rank_ank
        }
        if (record.rank_id !== undefined) {
          props.officer.rank_id = parseInt(record.rank_id || 0) || null
        }
        if (record.rank && typeof record.rank === 'object') {
          props.officer.rank = record.rank
        }

        hydrateRows()
        markSaved()
        return true
      } catch (err) {
        console.log('krobkhan persist error:', err)
        return false
      }
    }

    async function loadRankRecords() {
      if (rankRecords.value.length > 0) return
      try {
        const res = await store.dispatch('rank/list', {
          search: '',
          page: 1,
          perPage: 2000
        })
        store.commit('rank/setAllRecords', Array.isArray(res?.data?.records) ? res.data.records : [])
        hydrateRows()
      } catch (err) {
        console.log('krobkhan load rank records error:', err)
      }
    }

    onMounted(loadRankRecords)
    watch(() => props.officer, hydrateRows, { immediate: true, deep: true })
    watch(rows, notifyDirty, { deep: true })

    expose({ persistChanges, cancelChanges, markSaved })

    return {
      rows,
      rowEdited,
      persistChanges,
      cancelChanges,
      markSaved
    }
  }
}
</script>
