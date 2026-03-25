<template>
<section class="mb-10 bg-white border border-[#D8DEE8] rounded-sm">

<!-- HEADER -->
<div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">

   <div
        class="w-full pr-4 text-left text-[15px] font-semibold text-[#1E3A8A] leading-7"
      >
        ង. ភាសាបរទេស (សូមបំពេញនូវកម្រិតចំណេះដឹងភាសាបរទេស ពីល្អ មធ្យម ខ្សោយ)
    </div>

<button
class="inline-flex items-center gap-1 bg-[#1E3A8A] text-white rounded-md px-3 py-1.5 text-[13px] hover:bg-[#162E6B]"
@click="addLanguage"
>
បន្ថែម
</button>

</div>


<!-- TABLE -->
<div v-if="officer" class="overflow-x-auto">

<table class="w-full border-collapse min-w-[980px]">

<thead>
<tr>

<th class="th">ភាសាបរទេស</th>
<th
v-for="col in columns"
:key="col.key"
class="th"
>
{{ col.label }}
</th>

<th class="th w-16 text-center">សកម្មភាព</th>

</tr>
</thead>


<tbody>

<tr
v-for="(row,index) in rows"
:key="row._key"
:class="rowEdited(row) ? 'bg-[#FEE2E2]' : 'bg-white'"
>

<!-- Language name -->
<td class="td">
<input v-model="row.name" class="input"/>
</td>


<!-- Reading Speaking Writing -->
<td
v-for="col in columns"
:key="col.key"
class="td"
>

<select v-model="row[col.key]" class="input">

<option value="">ជ្រើសរើស</option>

<option
v-for="level in levels"
:key="level"
:value="level"
>
{{ level }}
</option>

</select>

</td>


<!-- DELETE -->
<td class="td text-center">

<delete-confirm-button-component @confirm="removeRow(index)" />

</td>

</tr>


<tr v-if="rows.length===0">

<td colspan="5" class="text-center text-gray-500 p-4">
មិនទាន់មានទិន្នន័យ
</td>

</tr>

</tbody>

</table>

</div>


<div v-else class="w-full p-8 text-center text-red-500">
សូមបញ្ជាក់ព័ត៌មានមន្ត្រីជាមុនសិន។
</div>

</section>
</template>



<script>
import { ref, watch } from "vue"
import { useStore } from "vuex"
import DeleteConfirmButtonComponent from "./delete-confirm-button.vue"

export default {

emits:["changed"],
components:{
DeleteConfirmButtonComponent
},

props:{
officer:Object
},

setup(props,{emit}){

const store = useStore()

/* --------------------------------
STATE
-------------------------------- */

const rows = ref([])
const savedSnapshot = ref("[]")
const savedRowsByKey = ref({})
const deletedIds = ref([])

let seed = 0


/* --------------------------------
CONFIG
-------------------------------- */

const columns = [
{ key:"reading" , label:"ការអាន" },
{ key:"speaking" , label:"ការសន្ទនា" },
{ key:"writing" , label:"ការសរសេរ" }
]

const levels = ["ល្អ","មធ្យម","ខ្សោយ"]


/* --------------------------------
UTIL
-------------------------------- */

const newKey = () => `language-${++seed}`

const newRow = () => ({
id:null,
people_id:parseInt(props.officer?.people?.id || props.officer?.people_id || 0) || null,
_key:newKey(),
name:"",
reading:"",
speaking:"",
writing:""
})

const normalizeRow = (row) => {
const { _key, ...item } = row
return item
}


/* --------------------------------
LOAD DATA
-------------------------------- */

function hydrateRows(){

const source = props.officer?.people?.languages || []

rows.value = source.map(l => ({
id:parseInt(l?.id || 0) || null,
people_id:parseInt(l?.people_id || props.officer?.people?.id || props.officer?.people_id || 0) || null,
_key:newKey(),
name:l.name || "",
reading:l.reading || "",
speaking:l.speaking || "",
writing:l.writing || ""
}))

markSaved()

}


/* --------------------------------
ROW ACTIONS
-------------------------------- */

function addLanguage(){
rows.value.push(newRow())
}

function removeRow(index){
const row = rows.value[index]
if (parseInt(row?.id || 0) > 0) {
deletedIds.value.push(parseInt(row.id))
}
rows.value.splice(index,1)
}


/* --------------------------------
PAYLOAD
-------------------------------- */

function toPayload(){
return rows.value.map(({_key,...item})=>({ ...item }))
}


/* --------------------------------
SNAPSHOT
-------------------------------- */

function markSaved(){
const payload = toPayload()
savedSnapshot.value = JSON.stringify(payload)
const mapped = {}
rows.value.forEach((row) => {
mapped[row._key] = JSON.stringify(normalizeRow(row))
})
savedRowsByKey.value = mapped
deletedIds.value = []
emit("changed",false)
}


/* --------------------------------
EDIT CHECK
-------------------------------- */

function rowEdited(row){
const snapshotRow = savedRowsByKey.value[row._key]
if (snapshotRow === undefined) return true
return JSON.stringify(normalizeRow(row)) !== snapshotRow
}


/* --------------------------------
DIRTY CHECK
-------------------------------- */

function notifyDirty(){
emit("changed", JSON.stringify(toPayload()) !== savedSnapshot.value)
}

function cancelChanges(){
hydrateRows()
}

async function persistChanges(){
const peopleId = parseInt(props.officer?.people?.id || props.officer?.people_id || 0)
if (peopleId <= 0) return false

for (const id of deletedIds.value) {
await store.dispatch('spokenlanguage/delete', { id })
}

for (const row of rows.value) {
const payload = {
people_id: peopleId,
name: row.name || "",
reading: row.reading || "",
speaking: row.speaking || "",
writing: row.writing || ""
}

if (parseInt(row.id || 0) > 0) {
await store.dispatch('spokenlanguage/update', {
id: parseInt(row.id),
...payload
})
} else {
const res = await store.dispatch('spokenlanguage/create', payload)
row.id = parseInt(res?.data?.record?.id || res?.data?.id || 0) || null
row.people_id = peopleId
}
}

markSaved()
return true
}


/* --------------------------------
WATCH
-------------------------------- */

watch(()=>props.officer?.people?.languages,hydrateRows,{immediate:true,deep:true})
watch(rows,notifyDirty,{deep:true})


return{
rows,
columns,
levels,
addLanguage,
removeRow,
rowEdited,
cancelChanges,
persistChanges,
markSaved
}

}

}
</script>



<style scoped>

.th{
background:#E5EAF2;
padding:8px;
font-size:13px;
font-weight:600;
border-bottom:1px solid #D8DEE8;
}

.td{
padding:8px;
border-bottom:1px solid #E5E7EB;
}

.input{
width:100%;
border:1px solid #D8DEE8;
padding:6px;
border-radius:4px;
font-size:13px;
background:white;
}

</style>

