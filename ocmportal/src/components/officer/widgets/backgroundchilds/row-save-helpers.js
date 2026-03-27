function normalizeField(field) {
  if (typeof field === 'string') {
    return {
      key: field,
      label: field,
      hasValue: defaultHasValue
    }
  }

  return {
    key: field?.key || '',
    label: field?.label || field?.key || '',
    hasValue: typeof field?.hasValue === 'function' ? field.hasValue : defaultHasValue
  }
}

function defaultHasValue(value) {
  if (value instanceof File) return true
  if (Array.isArray(value)) return value.length > 0
  if (typeof value === 'number') return Number.isFinite(value) && value > 0
  if (typeof value === 'boolean') return value === true
  return String(value ?? '').trim() !== ''
}

export function rowFieldHasValue(row, field) {
  const descriptor = normalizeField(field)
  if (!descriptor.key) return false
  return descriptor.hasValue(row?.[descriptor.key], row)
}

export function rowHasAnyInput(row, fields = []) {
  return fields.some((field) => rowFieldHasValue(row, field))
}

export function shouldTrackRow(row, activityFields = []) {
  return parseInt(row?.id || 0, 10) > 0 || rowHasAnyInput(row, activityFields)
}

export function buildTrackedRowsPayload(rows = [], normalizeRow, activityFields = []) {
  return rows
    .filter((row) => shouldTrackRow(row, activityFields))
    .map((row) => normalizeRow(row))
}

export function buildRowsSnapshot(rows = [], normalizeRow) {
  return JSON.stringify(rows.map((row) => normalizeRow(row)))
}

export function findIncompleteRows(
  rows = [],
  {
    activityFields = [],
    requiredFields = [],
    includeBlankRows = false,
    shouldValidateRow
  } = {}
) {
  const normalizedRequiredFields = requiredFields.map(normalizeField)

  return rows.reduce((items, row, index) => {
    const shouldValidate = typeof shouldValidateRow === 'function'
      ? shouldValidateRow(row, index) === true
      : true

    if (!shouldValidate) {
      return items
    }

    const hasActivity = rowHasAnyInput(row, activityFields)
    if (!hasActivity && includeBlankRows !== true) {
      return items
    }

    const missingFields = normalizedRequiredFields
      .filter((field) => !rowFieldHasValue(row, field))
      .map((field) => field.label)

    if (missingFields.length > 0) {
      items.push({
        index,
        row,
        missingFields
      })
    }

    return items
  }, [])
}
