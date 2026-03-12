<template>
  <div class="rounded-[7px] border border-gray-200 bg-white p-4 font-moul shadow-sm text-left overflow-hidden">
    <div class="mb-3 pb-3 border-b border-gray-100 flex-shrink-0">
      <span class="text-base font-semibold text-gray-800">ចំនួនមន្ត្រីសរុបតាមនាយកដ្ឋាន</span>
    </div>
    <div class="overflow-x-auto min-w-0">
      <table class="w-full border-collapse text-xs">
        <thead>
          <tr class="border-b border-gray-200">
            <th class="text-left py-1.5 pr-2 font-semibold text-gray-500 w-[1%] whitespace-nowrap">នាយកដ្ឋាន</th>
            <th class="text-left py-1.5 pl-0 pr-3 font-semibold text-gray-700 w-[99%]"></th>
            <th class="text-left py-1.5 pr-3 font-semibold text-gray-700 whitespace-nowrap">សរុប</th>
            <th class="text-left py-1.5 pr-3 font-semibold text-blue-600 whitespace-nowrap">ប្រុស %</th>
            <th class="text-left py-1.5 font-semibold text-pink-600 whitespace-nowrap">ស្រី %</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(row, i) in data"
            :key="i"
            class="border-b border-gray-100 align-middle"
          >
            <td
              class="py-3 pr-2 align-middle text-gray-800 min-w-[16rem] max-w-[24rem] leading-4 break-words"
              :title="row.department"
            >
              {{ row.department }}
            </td>
            <td class="py-1.5 pl-0 pr-3 align-middle w-[99%]">
              <div class="h-5 rounded bg-gray-200 overflow-hidden min-w-0 max-w-full">
                <div
                  class="h-full rounded bg-blue-500 transition-all duration-300"
                  :style="{ width: barWidthPercent(row) + '%' }"
                />
              </div>
            </td>
            <td class="py-1.5 pr-3 align-middle text-gray-800 font-bold whitespace-nowrap">{{ formatNumber(row.total) }}</td>
            <td class="py-1.5 pr-3 align-middle text-blue-600 font-bold whitespace-nowrap">{{ row.malePercent }}%</td>
            <td class="py-1.5 align-middle text-pink-600 font-bold whitespace-nowrap">{{ row.femalePercent }}%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'

export default {
  name: 'DashboardDepartmentChart',
  props: {
    /** [{ department: string, total: number, malePercent: number, femalePercent: number }] */
    data: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const maxTotal = computed(() => {
      const list = props.data || []
      if (list.length === 0) return 1
      return Math.max(...list.map(d => Number(d.total) || 0), 1)
    })

    function barWidthPercent(row) {
      const t = Number(row.total) || 0
      return maxTotal.value > 0 ? Math.min(100, (t / maxTotal.value) * 100) : 0
    }

    function formatNumber(n) {
      const num = Number(n) || 0
      return num.toLocaleString()
    }

    return {
      barWidthPercent,
      formatNumber
    }
  }
}
</script>
