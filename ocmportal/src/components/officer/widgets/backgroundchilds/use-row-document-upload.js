import { ref } from 'vue'

export function useRowDocumentUpload(store, uploadAction) {
  const documentFileMap = ref({})
  const clearStoredPdfMap = ref({})

  function triggerBrowserDownload(url, filename) {
    const anchor = document.createElement('a')
    anchor.href = url
    anchor.download = filename
    anchor.style.display = 'none'
    document.body.appendChild(anchor)
    anchor.click()
    document.body.removeChild(anchor)
  }

  function isPdfFile(file) {
    if (!file) return false
    const normalizedType = String(file.type || '').trim().toLowerCase()
    const normalizedName = String(file.name || '').trim().toLowerCase()
    return normalizedType === 'application/pdf' || normalizedName.endsWith('.pdf')
  }

  function storedFileLabel(value) {
    const raw = typeof value === 'string' ? value.trim() : ''
    if (!raw) return ''
    const normalized = raw.split('?')[0]
    const parts = normalized.split('/').filter(Boolean)
    const filename = parts[parts.length - 1] || raw
    const decodedFilename = (() => {
      try {
        return decodeURIComponent(filename)
      } catch (err) {
        return filename
      }
    })()
    const markerIndex = decodedFilename.indexOf('__')
    if (markerIndex > -1 && markerIndex + 2 < decodedFilename.length) {
      return decodedFilename.slice(markerIndex + 2)
    }
    return decodedFilename
  }

  function onDocumentFileChange(row, file) {
    if (!row || !file) return
    if (!isPdfFile(file)) {
      window.alert('សូមជ្រើសរើសឯកសារ PDF តែប៉ុណ្ណោះ។')
      return
    }
    documentFileMap.value[row._key] = file
    delete clearStoredPdfMap.value[row._key]
    row.pdf = file.name
  }

  function clearDocumentFile(row) {
    if (!row) return
    const hasPendingLocalFile = Boolean(documentFileMap.value[row._key])
    delete documentFileMap.value[row._key]

    if (hasPendingLocalFile) {
      // If user just picked a new file, `x` should only cancel that pick.
      row.pdf = row._storedPdf || ''
      return
    }

    // No pending local file means user wants to remove the currently stored file.
    row.pdf = ''
    row._storedPdf = ''
    clearStoredPdfMap.value[row._key] = true
  }

  function documentFileTypeLabel(rowKey) {
    const file = documentFileMap.value[rowKey]
    if (!file) return ''
    return 'PDF'
  }

  function resetDocumentFiles() {
    documentFileMap.value = {}
    clearStoredPdfMap.value = {}
  }

  function rowHasPreview(row) {
    if (!row) return false
    const hasStoredPdf =
      typeof row._storedPdf === 'string'
        ? row._storedPdf.trim() !== ''
        : row._storedPdf !== undefined
          ? Boolean(row._storedPdf)
          : Boolean(row.pdf)
    return parseInt(row.id || 0) > 0 && hasStoredPdf
  }

  function rowHasDownload(row) {
    if (!row) return false
    return Boolean(documentFileMap.value[row._key]) || rowHasPreview(row)
  }

  function shouldClearStoredPdf(rowKey) {
    return Boolean(clearStoredPdfMap.value[rowKey])
  }

  async function uploadDocumentIfNeeded(recordId, row) {
    const file = documentFileMap.value[row?._key]
    if (!file || parseInt(recordId || 0) <= 0) return

    const formData = new FormData()
    formData.append('id', String(recordId))
    formData.append('file', file)
    await store.dispatch(uploadAction, formData)
    delete documentFileMap.value[row._key]
    delete clearStoredPdfMap.value[row._key]
  }

  async function downloadDocument(row, pdfAction) {
    if (!row) return false

    const localFile = documentFileMap.value[row._key]
    if (localFile instanceof File) {
      const objectUrl = window.URL.createObjectURL(localFile)
      triggerBrowserDownload(objectUrl, localFile.name || 'attachment.pdf')
      window.setTimeout(() => window.URL.revokeObjectURL(objectUrl), 1000)
      return true
    }

    const rowId = parseInt(row.id || 0)
    if (rowId <= 0 || !rowHasPreview(row) || !pdfAction) {
      return false
    }

    const res = await store.dispatch(pdfAction, { id: rowId })
    const fileUrl = res?.data?.pdf
    if (!fileUrl) {
      throw new Error('Attachment file URL is missing')
    }

    triggerBrowserDownload(
      fileUrl,
      res?.data?.filename || row.pdf || `attachment-${rowId}.pdf`
    )
    return true
  }

  return {
    documentFileMap,
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
  }
}
