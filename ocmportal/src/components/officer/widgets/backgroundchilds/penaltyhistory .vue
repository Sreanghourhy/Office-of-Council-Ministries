<template>
        <section class="mb-10 bg-white border border-[#D8DEE8] rounded-sm overflow-hidden">
            <div class="flex items-start justify-between gap-3 px-4 py-3 border-b border-[#D8DEE8] bg-[#FCFDFE]">
                <h3 class="text-[15px] font-semibold text-[#1E3A8A] text-left leading-6">ឆ.២-ការដាក់វិន័យ</h3>
                <button
                    type="button"
                    class="inline-flex shrink-0 items-center gap-1 bg-[#1E3A8A] text-white rounded-md px-3 py-1.5 text-[13px] hover:bg-[#162E6B] duration-200"
                    @click="addRow"
                >
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v5.5h5.5a.75.75 0 0 1 0 1.5h-5.5v5.5a.75.75 0 0 1-1.5 0v-5.5h-5.5a.75.75 0 0 1 0-1.5h5.5v-5.5A.75.75 0 0 1 10 3z" clip-rule="evenodd" />
                    </svg>
                    <span>បន្ថែម</span>
                </button>
            </div>

            <div v-if="rows.length > 0" class="overflow-x-auto bg-white">
                <table class="w-full border-collapse min-w-[980px]">
                    <thead>
                        <tr>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">លេខលិខិត</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">កាលបរិច្ឆេទ</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ក្រសួង/ស្ថាប័ន/រាជធានី/ខេត្ត (ស្នើសុំ)</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">បរិយាយ</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8]">ប្រភេទ</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-32 text-center">ឯកសារ</th>
                            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-16 text-center">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, idx) in rows" :key="row._key" :class="rowEdited(row) ? 'bg-[#FEE2E2]' : 'bg-white'">
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <input v-model="row.fid" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
                            </td>
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <input v-model="row.date" type="date" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
                            </td>
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <input v-model="row.organization" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
                            </td>
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <input v-model="row.desp" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
                            </td>
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <input v-model="row.type" class="w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white" />
                            </td>
                            <!-- File upload cell -->
                            <td class="p-2 border-b border-[#E5E7EB]">
                                <div class="certificate-upload">
                                    <label :for="`penalty-file-${row._key}`" class="certificate-upload-trigger">ឯកសារ</label>
                                    <input
                                        :id="`penalty-file-${row._key}`"
                                        type="file"
                                        class="hidden"
                                        accept=".pdf,image/*"
                                        @change="onFileChange(row, $event)"
                                    />
                                    <span class="certificate-file-name" :title="row.fileName || 'មិនទាន់ជ្រើសរើសឯកសារ'">
                                        {{ shortenFileName(row.fileName) }}
                                    </span>
                                    <button
                                        v-if="row.file || row.fileName"
                                        type="button"
                                        @click="clearFile(row)"
                                        class="certificate-upload-clear px-1"
                                    >
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.72 4.72a.75.75 0 0 1 1.06 0L10 8.94l4.22-4.22a.75.75 0 1 1 1.06 1.06L11.06 10l4.22 4.22a.75.75 0 1 1-1.06 1.06L10 11.06l-4.22 4.22a.75.75 0 1 1-1.06-1.06L8.94 10 4.72 5.78a.75.75 0 0 1 0-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <!-- Actions: PDF + delete -->
                            <td class="p-2 border-b border-[#E5E7EB] text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <n-tooltip trigger="hover">
                                        <template #trigger>
                                            <svg
                                                @click="togglePdfModal(row)"
                                                class="pdf-previewer text-red-500 w-5 h-5 cursor-pointer"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 1024 1024"
                                            >
                                                <path d="M509.2 490.8c-.7-1.3-1.4-1.9-2.2-2c-2.9 3.3-2.2 31.5 2.7 51.4c4-13.6 4.7-40.5-.5-49.4zm-1.6 120.5c-7.7 20-18.8 47.3-32.1 71.4c4-1.6 8.1-3.3 12.3-5c17.6-7.2 37.3-15.3 58.9-20.2c-14.9-11.8-28.4-27.7-39.1-46.2z" fill-opacity=".15" fill="currentColor"></path><path d="M534 352V136H232v752h560V394H576a42 42 0 0 1-42-42zm55 287.6c16.1-1.9 30.6-2.8 44.3-2.3c12.8.4 23.6 2 32 5.1c.2.1.3.1.5.2c.4.2.8.3 1.2.5c.5.2 1.1.4 1.6.7c.1.1.3.1.4.2c4.1 1.8 7.5 4 10.1 6.6c9.1 9.1 11.8 26.1 6.2 39.6c-3.2 7.7-11.7 20.5-33.3 20.5c-21.8 0-53.9-9.7-82.1-24.8c-25.5 4.3-53.7 13.9-80.9 23.1c-14.9-11.8-28.4-27.7-33.9-46.2z" fill-opacity=".15" fill="currentColor"></path><path d="M391.5 761c5.7-4.4 16.2-14.5 30.1-34.7c-10.3 9.4-23.4 22.4-30.1 34.7zm270.9-83l.2-.3h.2c.6-.4.5-.7.4-.9c-.1-.1-4.5-9.3-45.1-7.4c35.3 13.9 43.5 9.1 44.3 8.6z" fill-opacity=".15" fill="currentColor"></path><path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM602 137.8L790.2 326H602V137.8zM792 888H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path><path d="M535.9 585.3c-.8-1.7-1.5-3.3-2.2-4.9c-.1-.3-.3-.7-.4-1l-1.8-4.5c-.1-.2-.1-.3-.2-.5l.1-.3l.2-1.1c4-16.3 8.6-35.3 9.4-54.4v-.7c.3-8.6-.2-17.2-2-25.6c-3.8-21.3-19.5-29.6-32.9-30.2c-11.3-.5-21.8 4-28.1 11.4c-.1.1-.1.2-.2.2c-.2.2-.4.4-.5.6c-2.1 2.7-3.7 5.8-4.6 9.1c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.4-51.2 107.4v.1c-27.7 14.3-64.1 35.8-73.6 62.9c0 .1-.1.2-.1.3c-.2.7-.5 1.4-.7 2.1c-.1.2-.1.4-.2.6c-.2.9-.5 1.8-.6 2.7c-.9 4-.4 8.8 1.3 13.6c.6 1.8 1.3 3.5 2.2 5.2c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-2.6-2.6-6-4.8-10.1-6.6c-.1-.1-.3-.1-.4-.2c-.5-.2-1.1-.4-1.6-.7c-.4-.2-.8-.3-1.2-.5c-.2-.1-.3-.1-.5-.2c-16.2-5.8-41.7-6.7-76.3-2.8l-5.3.6c-5-3-9.6-6.3-13.9-9.8c-14.2-11.3-25.1-25.8-33.8-44.7zM391.5 761c6.7-12.3 19.8-25.3 30.1-34.7c-13.9 20.2-24.4 30.3-30.1 34.7zM507 488.8c.8.1 1.5.7 2.2 2c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4zm-19.2 188.9c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2zm175.4-.9c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4z" fill="currentColor"></path>
                                            </svg>
                                        </template>
                                        មើលឯកសារយោង។
                                    </n-tooltip>
                                    <pdf-download-action-button :disabled="!rowHasDownload(row)" @click="downloadDocument(row)" />
                                    <delete-confirm-button-component @confirm="removeRow(idx)" />
                                </div>
                            </td>
                        </tr>
                        <tr v-if="rows.length <= 0">
                            <td colspan="7" class="bg-white p-4 text-center text-gray-500 border-b border-[#E5E7EB]">មិនទាន់មានទិន្នន័យ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="w-full p-8 text-center text-gray-400">មិនទាន់មានទិន្នន័យ</div>
            <pdf-preview
                :model="pdfModel"
                :record="selectedRecord"
                v-bind:show="pdfToggle"
                :onClose="togglePdfModal"
            />
        </section>
</template>
<script>
import { ref, reactive, watch } from 'vue'
import { useStore } from 'vuex'
import DeleteConfirmButtonComponent from './delete-confirm-button.vue'
import PdfDownloadActionButton from './pdf-download-action-button.vue'
import PdfPreview from './pdfpreview.vue'
export default {
    name: 'PenaltyHistoryComponent',
    emits: ['changed'],
    props: {
        officer: {
            type: Object,
            default: undefined
        }
    },
    components: {
        DeleteConfirmButtonComponent,
        PdfDownloadActionButton,
        PdfPreview
    },
    setup(props, { emit }) {
        const store = useStore()
        const rows = ref([])
        const savedSnapshot = ref('[]')
        const savedRowsByKey = ref({})
        const deletedIds = ref([])
        let seed = 0

        const pdfModel = reactive({
            name: 'officerpenaltyhistory',
            module: 'officerpenaltyhistories',
            title: 'ប្រវត្តិការដាក់វិន័យ'
        })
        const selectedRecord = ref(null)
        const pdfToggle = ref(false)


        const nextKey = () => {
            seed += 1
            return `penalty-${seed}`
        }


        const normalizeRow = (row) => {
            const { _key, file, fileName, ...item } = row
            return item
        }


        const toPayload = () => rows.value.map(normalizeRow)


        const toInputDate = (value) => {
            if (!value) return ''
            const d = new Date(value)
            if (Number.isNaN(d.getTime())) return String(value).slice(0, 10)
            return d.toISOString().slice(0, 10)
        }


        const extractFileName = (path) => {
            if (!path) return ''
            const p = typeof path === 'string' ? path : ''
            const parts = p.split(/[/\\]/)
            return parts[parts.length - 1] || ''
        }

        const shortenFileName = (name) => {
            const value = name || 'មិនទាន់ជ្រើសរើសឯកសារ'
            const max = 24
            if (value.length <= max) return value
            const head = value.slice(0, 12)
            const tail = value.slice(-8)
            return `${head}…${tail}`
        }

        const hydrateRows = () => {
            const source = props.officer?.panelty_histories || []
            rows.value = source.map((row) => ({
                id: parseInt(row?.id || 0) || null,
                _key: nextKey(),
                fid: row?.fid || '',
                date: toInputDate(row?.date),
                organization: row?.organization || '',
                desp: row?.desp || '',
                type: row?.type || '',
                pdf: row?.pdf || null,
                file: null,
                fileName: extractFileName(row?.pdf)
            }))
            markSaved()
        }


        const markSaved = () => {
            const payload = toPayload()
            savedSnapshot.value = JSON.stringify(payload)
            const mapped = {}
            rows.value.forEach((row) => {
                mapped[row._key] = JSON.stringify(normalizeRow(row))
            })
            savedRowsByKey.value = mapped
            deletedIds.value = []
            emit('changed', false)
        }


        const rowEdited = (row) => {
            const snapshotRow = savedRowsByKey.value[row._key]
            if (snapshotRow === undefined) return true
            return JSON.stringify(normalizeRow(row)) !== snapshotRow
        }


        const notifyDirty = () => {
            emit('changed', JSON.stringify(toPayload()) !== savedSnapshot.value)
        }


        const addRow = () => {
            rows.value.push({
                id: null,
                _key: nextKey(),
                fid: '',
                date: '',
                organization: '',
                desp: '',
                type: '',
                pdf: null,
                file: null,
                fileName: ''
            })
        }


        const removeRow = (idx) => {
            const row = rows.value[idx]
            if (parseInt(row?.id || 0) > 0) {
                deletedIds.value.push(parseInt(row.id))
            }
            rows.value.splice(idx, 1)
        }


        const cancelChanges = () => {
            hydrateRows()
        }


        const onFileChange = (row, event) => {
            const file = event.target?.files?.[0]
            if (file) {
                row.file = file
                row.fileName = file.name
            }
        }

        const clearFile = (row) => {
            row.file = null
            row.fileName = extractFileName(row.pdf) || ''
        }

        const rowHasDownload = (row) => {
            if (!row) return false
            return Boolean(row.file) || (parseInt(row.id || 0) > 0 && Boolean(row.pdf))
        }

        const triggerBrowserDownload = (url, filename) => {
            const anchor = document.createElement('a')
            anchor.href = url
            anchor.download = filename
            anchor.style.display = 'none'
            document.body.appendChild(anchor)
            anchor.click()
            document.body.removeChild(anchor)
        }

        const togglePdfModal = (row) => {
            selectedRecord.value = row && row.id ? row : null
            pdfToggle.value = !pdfToggle.value
        }

        const downloadDocument = async (row) => {
            try {
                if (row?.file instanceof File) {
                    const objectUrl = window.URL.createObjectURL(row.file)
                    triggerBrowserDownload(objectUrl, row.file.name || 'attachment')
                    window.setTimeout(() => window.URL.revokeObjectURL(objectUrl), 1000)
                    return
                }

                if (!rowHasDownload(row) || parseInt(row?.id || 0) <= 0) {
                    return
                }

                const res = await store.dispatch(`${pdfModel.name}/pdf`, { id: parseInt(row.id || 0) })
                const fileUrl = res?.data?.pdf
                if (!fileUrl) {
                    throw new Error('Penalty file URL is missing')
                }

                triggerBrowserDownload(
                    fileUrl,
                    res?.data?.filename || row.fileName || `penalty-${row.id}.pdf`
                )
            } catch (error) {
                console.error('Penalty history download error:', error)
                window.alert('Unable to download attachment.')
            }
        }


        const persistChanges = async () => {
            const officerId = parseInt(props.officer?.id || 0)
            if (officerId <= 0) return false


            for (const id of deletedIds.value) {
                await store.dispatch('officerpenaltyhistory/delete', { id })
            }


            for (const row of rows.value) {
                const payload = {
                    officer_id: officerId,
                    fid: row.fid || '',
                    date: row.date || '',
                    organization: row.organization || '',
                    desp: row.desp || '',
                    type: row.type || ''
                }
                if (parseInt(row.id || 0) > 0) {
                    await store.dispatch('officerpenaltyhistory/update', {
                        id: parseInt(row.id),
                        ...payload
                    })
                } else {
                    const res = await store.dispatch('officerpenaltyhistory/create', payload)
                    row.id = parseInt(res?.data?.record?.id || 0) || null
                }

                if (row.file && row.id) {
                    const formData = new FormData()
                    formData.append('id', row.id)
                    formData.append('file', row.file)
                    await store.dispatch('officerpenaltyhistory/upload', formData)
                }
            }


            markSaved()
            return true
        }


        watch(() => props.officer?.panelty_histories, hydrateRows, { immediate: true, deep: true })
        watch(rows, notifyDirty, { deep: true })


        return {
            rows,
            cancelChanges,
            persistChanges,
            markSaved,
            rowEdited,
            addRow,
            removeRow,
            onFileChange,
            clearFile,
            rowHasDownload,
            pdfModel,
            pdfToggle,
            selectedRecord,
            togglePdfModal,
            downloadDocument,
            shortenFileName
        }
    }


}
</script>
<style scoped>
.certificate-upload {
  width: 100%;
  height: 33px;
  display: flex;
  align-items: center;
  border: 1px solid #d8dee8;
  border-radius: 4px;
  background: #fff;
  overflow: hidden;
}

.certificate-upload:hover {
  border-color: #22C55E;
}

.certificate-upload-trigger {
  height: 100%;
  display: inline-flex;
  align-items: center;
  border-right: 1px solid #d8dee8;
  background: #f8fafc;
  color: #1e3a8a;
  font-size: 11px;
  padding: 0 8px;
  cursor: pointer;
  white-space: nowrap;
}

.certificate-file-name {
  flex: 1;
  min-width: 0;
  color: #2c3e50;
  font-size: 11px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 0 6px;
  text-align: center;
}

.certificate-upload-clear {
  color: #9ca3af;
  cursor: pointer;
}

.certificate-upload-clear:hover {
  color: #dc2626;
}
</style>
