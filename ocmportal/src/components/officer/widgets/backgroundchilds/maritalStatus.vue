<template>
  <div class="family-status-selector">
    <div class="family-status-copy">
      <div class="family-status-title">ខ.១. ស្ថានភាពគ្រួសារ</div>
      <div class="family-status-description">
        ជ្រើសរើសស្ថានភាពគ្រួសារ មុនបំពេញព័ត៌មានប្តី ឬប្រពន្ធ និងព័ត៌មានកូន។
      </div>
    </div>

    <div class="family-status-grid">
      <label
        v-for="option in statusOptions"
        :key="option.value"
        :class="[
          'family-status-option',
          formData.marry_status === option.value ? 'family-status-option-active' : '',
          isDirty && formData.marry_status === option.value ? 'changed-cell' : ''
        ]"
      >
        <input
          v-model="formData.marry_status"
          :value="option.value"
          type="radio"
          class="family-status-input"
        />
        <div class="family-status-option-top">
          <span class="family-status-chip">{{ option.shortLabel }}</span>
          <svg
            v-if="formData.marry_status === option.value"
            class="family-status-check"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.24 7.3a1 1 0 0 1-1.42.004l-3.76-3.76a1 1 0 1 1 1.414-1.414l3.05 3.05l6.533-6.584a1 1 0 0 1 1.417-.01z"
              clip-rule="evenodd"
            />
          </svg>
        </div>
        <div class="family-status-option-title">{{ option.label }}</div>
        <div class="family-status-option-text">{{ option.description }}</div>
      </label>
    </div>
  </div>
</template>

<script>
import { computed, ref, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  emits: ['changed'],
  props: {
    officer: { type: Object, default: undefined }
  },
  setup(props, { emit }) {
    const store = useStore()

    const formData = ref({
      marry_status: 'single'
    })

    const originalValue = ref(props.officer?.people?.marry_status || 'single')

    const statusOptions = [
      {
        value: 'single',
        shortLabel: 'នៅលីវ',
        label: 'នៅលីវ',
        description: 'មិនទាន់មានប្តី ឬប្រពន្ធ។'
      },
      {
        value: 'married',
        shortLabel: 'រៀបការ',
        label: 'រៀបការហើយ',
        description: 'អាចបំពេញព័ត៌មានប្តី ឬប្រពន្ធ និងព័ត៌មានកូនបាន។'
      },
      {
        value: 'divorced',
        shortLabel: 'បែកបាក់',
        label: 'ពោះម៉ាយ / មេម៉ាយ',
        description: 'ប្រើសម្រាប់មន្ត្រីដែលបានប្តូរស្ថានភាពគ្រួសារ។'
      }
    ]

    const hydrateData = () => {
      const status = props.officer?.people?.marry_status || 'single'
      formData.value.marry_status = status
      originalValue.value = status
    }

    const persistChanges = async () => {
      try {
        const payload = {
          id: props.officer?.id,
          people: {
            marry_status: formData.value.marry_status
          }
        }

        const res = await store.dispatch('officer/update', payload)

        if (res?.status === 200) {
          if (props.officer?.people) {
            props.officer.people.marry_status = formData.value.marry_status
          }
          originalValue.value = formData.value.marry_status
          emit('changed', false)
          return true
        }

        return false
      } catch (err) {
        console.error(err)
        return false
      }
    }

    watch(() => props.officer?.people?.marry_status, hydrateData, { immediate: true })

    const isDirty = computed(() => formData.value.marry_status !== originalValue.value)

    watch(() => formData.value.marry_status, (newVal) => {
      emit('changed', newVal !== originalValue.value, newVal)
    })

    return {
      formData,
      persistChanges,
      statusOptions,
      isDirty
    }
  }
}
</script>

<style scoped>
.family-status-selector {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.family-status-copy {
  display: flex;
  flex-direction: column;
  gap: 6px;
  align-items: flex-start;
  text-align: left;
}

.family-status-title {
  color: #1e3a8a;
  font-size: 15px;
  font-weight: 600;
  line-height: 1.8;
}

.family-status-description {
  color: #64748b;
  font-size: 12px;
  line-height: 1.7;
  max-width: 720px;
}

.family-status-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 14px;
}

.family-status-option {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 10px;
  min-height: 148px;
  padding: 16px;
  border: 1px solid #d8dee8;
  border-radius: 18px;
  background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
  cursor: pointer;
  transition:
    border-color 0.2s ease,
    box-shadow 0.2s ease,
    transform 0.2s ease,
    background-color 0.2s ease;
}

.family-status-option:hover {
  border-color: #3158c6;
  box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
  transform: translateY(-1px);
}

.family-status-option-active {
  border-color: rgba(49, 88, 198, 0.4);
  background: linear-gradient(180deg, #ffffff 0%, #edf3ff 100%);
  box-shadow: 0 16px 28px rgba(30, 58, 138, 0.12);
}

.family-status-option.changed-cell {
  background: linear-gradient(180deg, #fff7ed 0%, #ffffff 100%);
  box-shadow: inset 3px 0 0 #d97706, 0 16px 28px rgba(30, 58, 138, 0.12);
}

.family-status-input {
  position: absolute;
  opacity: 0;
  pointer-events: none;
}

.family-status-option-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

.family-status-chip {
  display: inline-flex;
  align-items: center;
  padding: 5px 10px;
  border-radius: 9999px;
  background: #e8efff;
  color: #1e3a8a;
  font-size: 11px;
  font-weight: 700;
}

.family-status-check {
  width: 20px;
  height: 20px;
  color: #16a34a;
  flex-shrink: 0;
}

.family-status-option-title {
  color: #0f172a;
  font-size: 15px;
  font-weight: 700;
}

.family-status-option-text {
  color: #64748b;
  font-size: 12px;
  line-height: 1.7;
}
</style>
