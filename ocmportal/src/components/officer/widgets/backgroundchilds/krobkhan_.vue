<template>
  <section class="mb-10 bg-white border border-[#D8DEE8] rounded-sm">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ប្រវត្តិក្របខ័ណ្ឌ</h3>
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
      <table class="w-full border-collapse min-w-[900px]">
        <thead>
          <tr>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃខែឆ្នាំចូលបម្រើការរដ្ឋ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្ងៃខែឆ្នាំតាំងស៊ប់ក្នុងក្របខ័ណ្ឌរដ្ឋ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឈ្មោះក្របខ័ណ្ឌ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ក្របខ័ណ្ឌ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ឋានន្តរស័ក្តិ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ថ្នាក់</th>
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
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.selectedAnk"
                filterable
                clearable
                :options="ankOptions"
                placeholder="ឋានៈ"
                @update:value="setKrobKhan"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.selectedKrobKhan"
                filterable
                clearable
                :options="krobKhanOptions"
                placeholder="ក្របខ័ណ្ឌ"
                @update:value="setRank"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.selectedRank"
                filterable
                clearable
                :options="rankOptions"
                placeholder="ឋានន្តរស័ក្តិ"
                @update:value="setThnak"
              />
            </td>
            <td class="p-2 border-b border-[#E5E7EB]">
              <n-select
                v-model:value="row.selectedThnak"
                filterable
                clearable
                :options="thnakOptions"
                placeholder="ថ្នាក់"
              />
            </td>
          </tr>

          <tr v-if="rows.length <= 0">
            <td colspan="6" class="bg-white p-4 text-center text-gray-500 border-b border-[#E5E7EB]">
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
import { ref, computed, watch, onMounted , reactive } from 'vue'
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
    let seed = 0

    function nextKey() {
      seed += 1
      return `krobkhan-${seed}`
    }

    function emptyRow() {
      return {
        id: null,
        _key: nextKey(),
        start: '',
        end: '',
        selectedAnk: '',
        selectedKrobKhan: '',
        selectedRank: '',
        selectedThnak: '',
        krobkhans: [],
        ranks: [],
        thnaks: []
      }
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      if (Number.isNaN(d.getTime())) return String(value).slice(0, 10)
      return d.toISOString().slice(0, 10)
    }

    const anks = ref([])
    const selectedAnk = ref(null)
    function getRankStructure(){
      anks.value = store.getters['rank/records'].all
      if( props.record.rank != undefined && props.record.rank != null ){
        selectedAnk.value = props.record.rank.ank
        selectedKrobKhan.value = props.record.rank.krobkhan
        selectedRank.value = props.record.rank.rank
        selectedThnak.value = props.record.rank.thnak
        updateKrobKhan()
      }
    }    
    const ankOptions = computed(()=>{
      return anks.value != undefined && Array.isArray( anks.value ) && anks.value.length > 0
        ? (
          anks.value.map( ( v ) => { return { label: v.ank , value : v.ank } } )
        )
        : [ { label: 'មិនមានវិស័យ' , value : 0 } ]
    })
    const krobkhans = ref([])
    const selectedKrobKhan = ref(null)
    const selectedRank = ref(null)
    const ranks = ref([])
    function setKrobKhan(){
      krobkhanHandleUpdateCounter.value++
      selectedRank.value = null
      selectedThnak.value = null 
      updateKrobKhan()
    }
    function updateKrobKhan(){
      krobkhans.value = []
      let v = anks.value.find( ( val ) => val.ank == selectedAnk.value )
      if( v != undefined ){
        krobkhans.value = v.krobkhans
        if( krobkhanHandleUpdateCounter.value <= 1 ) {
          selectedKrobKhan.value = props.record.rank != null && props.record.rank != undefined ? props.record.rank.krobkhan : null 
        }
        if( v.krobkhans.find( k => k.krobkhan == selectedKrobKhan.value ) == undefined ){
          selectedKrobKhan.value = null
        }
        updateRank()
      }else{
        notify.info({
          title: 'ព័ត៌មានក្របខ័ណ្ឌ' ,
          content : 'មិនមានព័ត៌មានពីអង្គនេះឡើយ'  ,
          duration: 2000
        })
      }
    }
    const krobKhanOptions = computed( () => {
      if( krobkhans.value != undefined && Array.isArray( krobkhans.value ) && krobkhans.value.length > 0 ){
        let uniqueKrobKhans = new Array()
        for( let i in krobkhans.value ){
          if ( uniqueKrobKhans.indexOf( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name ) == -1 ){
            // uniqueKrobKhans.push( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name )
            uniqueKrobKhans.push( {
              label: krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name ,
              value : krobkhans.value[i].krobkhan
            } )
          }
        }
        return uniqueKrobKhans.map( ( k ) => { return { label: k.label , value : k.value } } )
      }else{
        return [ { label: 'មិនមានក្របខ័ណ្ឌ' , value : 0 } ]
      }
    })
    const rankOptions = computed( () => {
      if( Array.isArray( ranks.value ) && ranks.value.length > 0 ){
        return ranks.value
      }else{
        return [ { label: 'មិនមានឋានន្តរស័ក្តិ' , value : 0 } ]
      }
    })
    function setRank(){
      selectedThnak.value = null 
      updateRank()
    }
    function updateRank(){
      ranks.value = []
      selectedRank.value = null
      selectedThnak.value = null 
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan == selectedKrobKhan.value ){
            for( let j in krobkhans.value[i].ranks ){
              ranks.value.push( {
                label: krobkhans.value[i].ranks[j].krobkhan+'.'+krobkhans.value[i].ranks[j].rank+'. ' + krobkhans.value[i].ranks[j].name ,
                value: krobkhans.value[i].ranks[j].rank
              })
            }
            if( krobkhanHandleUpdateCounter.value <= 1 ) {
              selectedRank.value = props.record.rank.rank
            }
            if( krobkhans.value[i].ranks.find( r => r.rank == selectedRank.value ) == undefined ){
              selectedRank.value = null
            }
            updateThnaks()
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានឋានន្តរស័ក្តិ' ,
          content : 'មិនមានព័ត៌មានឋានន្តរស័ក្តិ' ,
          duration: 2000
        })
      }
    }
    const selectedThnak = ref(null)
    const thnaks = reactive({
      key: '' ,
      options: []
    })
    function setThnak(){
      updateThnaks()
    }
    function updateThnaks(){
      thnaks.key = '' 
      thnaks.options = []
      selectedThnak.value = null 
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan == selectedKrobKhan.value ){
            for( let j in krobkhans.value[i].ranks ){
              if( krobkhans.value[i].ranks[j].rank == selectedRank.value ){
                thnaks.key = krobkhans.value[i].ranks[j].rank
                thnaks.options = krobkhans.value[i].ranks[j].thnaks.map( t => { 
                  return { 
                    label: krobkhans.value[i].ranks[j].krobkhan+'.'+krobkhans.value[i].ranks[j].rank+'.'+t.thnak ,
                    value : t.thnak
                  }
                })

              }
            }
            if( krobkhanHandleUpdateCounter.value <= 1 ) {
              selectedThnak.value = props.record.rank.thnak
            }
            console.log( thnaks.options )
            if( Array.isArray( thnaks.options ) && thnaks.options.length > 0 ){
              thnaks.options.find( t => t.value == selectedThnak.value ) == undefined
            }else{
              selectedThnak.value = null
            }
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានឋានន្តរស័ក្តិ' ,
          content : 'មិនមានព័ត៌មានឋានន្តរស័ក្តិ' ,
          duration: 2000
        })
      }
    }
    const thnakOptions = computed( () => {
      if( thnaks.options != undefined && Array.isArray( thnaks.options ) && thnaks.options.length > 0 ){
        return thnaks.options
      }else{
        return [ { label: 'មិនមានថ្នាក់' , value : 0 } ]
      }
    })

    // const anks = computed(() => {
    //   const records = store.getters['rank/records']
    //   return Array.isArray(records?.all) ? records.all : []
    // })

    // async function loadRankOptions() {
    //   const records = store.getters['rank/records']
    //   if (Array.isArray(records?.all) && records.all.length > 0) return

    //   store.dispatch('rank/structure').then(res => { 
    //     store.commit('rank/setAllRecords', Array.isArray(res.data.records) ? res.data.records : [])
    //   }).catch(err => { console.log( err ) })
    // }

    // const ankOptions = computed(() => {
    //   const unique = []
    //   const seen = new Set()

    //   anks.value.forEach((item) => {
    //     if (item?.ank && !seen.has(item.ank)) {
    //       seen.add(item.ank)
    //       unique.push({ label: item.ank, value: item.ank })
    //     }
    //   })
    //   console.log( unique )
    //   return unique
    // })

    // function getKrobKhanOptions(row) {
    //   console.log('getKrobKhanOptions')
    //   console.log( row )
    //   if (!Array.isArray(row.krobkhans)) return []
    //   const seen = new Set()
    //   return row.krobkhans
    //     .filter((item) => item?.krobkhan && !seen.has(item.krobkhan) && seen.add(item.krobkhan))
    //     .map((item) => ({
    //       label: `${item.krobkhan}.${item.krobkhan_name || ''}`,
    //       value: item.krobkhan
    //     }))
    // }

    // function getRankOptions(row) {
    //   if (!Array.isArray(row.ranks)) return []
    //   return row.ranks.map((item) => ({
    //     label: `${item.krobkhan}.${item.rank}. ${item.name || ''}`,
    //     value: item.rank
    //   }))
    // }

    // function getThnakOptions(row) {
    //   if (!Array.isArray(row.thnaks)) return []
    //   return row.thnaks.map((item) => ({
    //     label: `${row.selectedKrobKhan || ''}.${row.selectedRank || ''}.${item.thnak}`,
    //     value: item.thnak
    //   }))
    // }

    function hydrateCascadingOptions(row) {
      row.krobkhans = []
      row.ranks = []
      row.thnaks = []

      if (!row.selectedAnk) return row

      const foundAnk = anks.value.find((item) => item.ank === row.selectedAnk)
      if (!foundAnk?.krobkhans) return row
      row.krobkhans = foundAnk.krobkhans

      if (!row.selectedKrobKhan) return row

      const foundKrobKhan = row.krobkhans.find((item) => item.krobkhan === row.selectedKrobKhan)
      if (!foundKrobKhan?.ranks) return row
      row.ranks = foundKrobKhan.ranks

      if (!row.selectedRank) return row

      const foundRank = row.ranks.find((item) => item.rank === row.selectedRank)
      if (!foundRank?.thnaks) return row
      row.thnaks = foundRank.thnaks

      return row
    }

    // function setKrobKhan(value, row) {
    //   row.selectedAnk = value || ''
    //   row.selectedKrobKhan = ''
    //   row.selectedRank = ''
    //   row.selectedThnak = ''
    //   hydrateCascadingOptions(row)
    // }

    // function setRank(value, row) {
    //   row.selectedKrobKhan = value || ''
    //   row.selectedRank = ''
    //   row.selectedThnak = ''
    //   hydrateCascadingOptions(row)
    // }

    // function setThnak(value, row) {
    //   row.selectedRank = value || ''
    //   row.selectedThnak = ''
    //   hydrateCascadingOptions(row)
    // }

    function buildFallbackRowFromOfficer() {
      const rank = props.officer?.rank || {}
      const salaryRankParts = String(props.officer?.salary_rank || '').split('.')

      const row = {
        id: parseInt(rank?.id || 0) || null,
        _key: nextKey(),
        start: toInputDate(props.officer?.unofficial_date),
        end: toInputDate(props.officer?.official_date),
        selectedAnk: rank?.ank || '',
        selectedKrobKhan: rank?.krobkhan || props.officer?.officer_type || '',
        selectedRank: rank?.rank || salaryRankParts[1] || '',
        selectedThnak: rank?.thnak || salaryRankParts[2] || '',
        krobkhans: [],
        ranks: [],
        thnaks: []
      }

      return hydrateCascadingOptions(row)
    }

    function hydrateRows() {
      if (!props.officer) {
        rows.value = [emptyRow()]
        markSaved()
        return
      }

      rows.value = [buildFallbackRowFromOfficer()]
      markSaved()
    }

    function addRow() {
      rows.value.push(emptyRow())
    }

    function normalizeRow(row) {
      const { _key, krobkhans, ranks, thnaks, ...item } = row
      return item
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
      emit('changed', JSON.stringify(toPayload()) !== savedSnapshot.value)
    }

    function cancelChanges() {
      hydrateRows()
    }

    function rowHasValues(row) {
      return [
        row.start,
        row.end,
        row.selectedAnk,
        row.selectedKrobKhan,
        row.selectedRank,
        row.selectedThnak
      ].some((value) => String(value || '').trim().length > 0)
    }

    function buildSavePayload() {
      const validRows = rows.value.filter(rowHasValues)
      if (validRows.length <= 0) return null

      for (const row of validRows) {
        if (!row.selectedAnk || !row.selectedKrobKhan || !row.selectedRank || !row.selectedThnak) {
          throw new Error('krobkhan-row-incomplete')
        }
      }

      const currentRow = validRows[validRows.length - 1]

      return {
        id: parseInt(props.officer?.rank?.id || currentRow.id || 0) || undefined,
        officer_id: parseInt(props.officer?.id || 0),
        unofficial_date: currentRow.start || null,
        official_date: currentRow.end || null,
        ank: currentRow.selectedAnk,
        krobkhan: currentRow.selectedKrobKhan,
        rank: currentRow.selectedRank,
        thnak: currentRow.selectedThnak
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

        const existingId = parseInt(payload.id || 0) || 0
        const res = existingId > 0
          ? await store.dispatch('rank/update', payload)
          : await store.dispatch('rank/create', payload)

        if (!(res?.data?.ok === true || res?.status === 200)) {
          throw new Error(existingId > 0 ? 'krobkhan-update-failed' : 'krobkhan-create-failed')
        }

        const record = res?.data?.record || {}
        props.officer.unofficial_date = record.unofficial_date || payload.unofficial_date
        props.officer.official_date = record.official_date || payload.official_date
        props.officer.officer_type = record.officer_type || record.krobkhan || payload.krobkhan
        props.officer.salary_rank = record.salary_rank || [payload.krobkhan, payload.rank, payload.thnak].filter(Boolean).join('.')

        if (!props.officer.rank || typeof props.officer.rank !== 'object') {
          props.officer.rank = {}
        }

        props.officer.rank.id = parseInt(record.id || payload.id || 0) || null
        props.officer.rank.ank = record.ank || payload.ank
        props.officer.rank.krobkhan = record.krobkhan || payload.krobkhan
        props.officer.rank.rank = record.rank || payload.rank
        props.officer.rank.thnak = record.thnak || payload.thnak

        hydrateRows()
        markSaved()
        return true
      } catch (err) {
        console.log('krobkhan persist error:', err)
        return false
      }
    }

    onMounted(() => {
      krobkhanHandleUpdateCounter.value = 0
      getRankStructure()
    })
    watch(() => props.officer, hydrateRows, { immediate: true, deep: true })
    watch(() => anks.value, () => rows.value.forEach(hydrateCascadingOptions), { deep: true })
    watch(rows, notifyDirty, { deep: true })

    expose({ persistChanges, cancelChanges, markSaved })

    return {
      rows,
      ankOptions,
      krobKhanOptions,
      thnakOptions,
      rankOptions ,
      
      // getKrobKhanOptions,
      // getRankOptions,
      // getThnakOptions,
      
      addRow,
      rowEdited,
      setKrobKhan,
      setRank,
      setThnak,
      persistChanges,
      cancelChanges,
      markSaved
    }
  }
}
</script>
