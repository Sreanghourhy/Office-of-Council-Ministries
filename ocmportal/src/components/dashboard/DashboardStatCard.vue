<template>
  <div class="rounded-[7px] border border-gray-200 bg-white p-4 font-moul shadow-sm text-left">
    <div class="flex items-center gap-2 mb-3">
      <div class="flex-shrink-0 w-9 h-9 rounded-[5px] flex items-center justify-center" :class="iconBgClass">
        <slot name="icon">
          <svg v-if="icon === 'people'" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor">
            <path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z"/>
            <path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z"/>
          </svg>
          <svg v-else-if="icon === 'building'" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5H4.5ZM6 10.5a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5H6.75A.75.75 0 0 1 6 10.5Zm4.5 0a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75Zm4.5 0a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75Zm-9 3.75a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5H6.75a.75.75 0 0 1-.75-.75Zm4.5 0a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75Zm4.5 0a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
          </svg>
          <svg v-else-if="icon === 'document'" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="currentColor">
            <path d="M6.25 4.75A2.25 2.25 0 0 0 4 7v14a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 22 21V9.376a2.25 2.25 0 0 0-.659-1.591L17.215 2.66A2.25 2.25 0 0 0 15.624 2H6.25zM18.5 9.25V20.25a.75.75 0 0 1-.75.75H6.25a.75.75 0 0 1-.75-.75V7c0-.414.336-.75.75-.75h7.5v-2.5h.69l3.81 3.75z"/>
          </svg>
          <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M2.25 6a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V6Zm3.97 4.72a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1 0 1.06l-2.25 2.25a.75.75 0 0 1-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 0 1 0-1.06Zm4.28 0a.75.75 0 0 0 0 1.06l1.72 1.72-1.72 1.72a.75.75 0 1 0 1.06 1.06l2.25-2.25a.75.75 0 0 0 0-1.06l-2.25-2.25a.75.75 0 0 0-1.06 0Z" clip-rule="evenodd"/>
          </svg>
        </slot>
      </div>
      <span class="text-base font-medium text-gray-700">{{ title }}</span>
    </div>
    <div class="flex flex-col gap-1">
      <span class="text-2xl font-bold text-gray-800">{{ value }}</span>
      <span v-if="trendLabel" class="inline-flex items-center gap-1.5 text-sm font-medium">
        <template v-if="trendPercent != null && trendPercent > 0">
          <svg class="w-4 h-4 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
          </svg>
          <span class="text-green-600">+{{ trendPercent }}%</span>
        </template>
        <template v-else-if="trendPercent != null && trendPercent < 0">
          <svg class="w-4 h-4 flex-shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
          </svg>
          <span class="text-red-600">{{ trendPercent }}%</span>
        </template>
        <template v-else>
          <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
          </svg>
          <span class="text-gray-500">{{ trendPercent != null ? trendPercent + '%' : '0%' }}</span>
        </template>
        <span class="text-gray-400 font-normal">{{ trendLabel }}</span>
      </span>
    </div>
  </div>
</template>

<script>
const iconColorMap = {
  blue: 'bg-blue-100 text-blue-600',
  emerald: 'bg-emerald-100 text-emerald-600',
  amber: 'bg-amber-100 text-amber-600',
  violet: 'bg-violet-100 text-violet-600'
}

export default {
  name: 'DashboardStatCard',
  props: {
    title: {
      type: String,
      default: ''
    },
    value: {
      type: [Number, String],
      default: 0
    },
    icon: {
      type: String,
      default: 'people'
    },
    iconColor: {
      type: String,
      default: 'blue',
      validator: (v) => Object.keys(iconColorMap).includes(v)
    },
    trendPercent: {
      type: Number,
      default: null
    },
    trendLabel: {
      type: String,
      default: ''
    }
  },
  computed: {
    iconBgClass() {
      return iconColorMap[this.iconColor] || iconColorMap.blue
    }
  }
}
</script>
