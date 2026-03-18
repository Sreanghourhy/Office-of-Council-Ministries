<template>
  <div class="w-full h-full rounded-[7px] border border-gray-200 bg-white p-5 font-moul shadow-sm text-left overflow-hidden">
    <div class="mb-4 pb-4 border-b border-gray-100">
      <span class="text-base font-semibold text-gray-800">សមាមាត្រប្រុស/ស្រី</span>
    </div>
    <div ref="chartEl" class="chart-pie-wrap w-full min-h-[220px] max-w-full flex items-center justify-center overflow-hidden"></div>
    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
      <div class="flex items-center gap-2 px-1 py-1">
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-[5px] bg-blue-100 text-blue-600">
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z"/>
            <path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z"/>
          </svg>
        </span>
        <div class="leading-tight">
          <div class="text-[12px] text-blue-600">ចំនួនប្រុស</div>
          <div class="text-sm font-semibold text-blue-600">{{ maleCount }}</div>
        </div>
      </div>
      <div class="flex items-center gap-2 px-1 py-1">
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-[5px] bg-pink-100 text-pink-600">
          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z"/>
            <path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z"/>
          </svg>
        </span>
        <div class="leading-tight">
          <div class="text-[12px] text-pink-600">ចំនួនស្រី</div>
          <div class="text-sm font-semibold text-pink-600">{{ femaleCount }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch, onMounted, computed } from 'vue'
import * as d3 from 'd3'

export default {
  name: 'DashboardPieChart',
  props: {
    genderRatio: {
      type: Object,
      default: () => ({ male: 0, female: 0 })
    }
  },
  setup(props) {
    const chartEl = ref(null)
    const maleCount = computed(() => (Number(props.genderRatio?.male) || 0).toLocaleString('en-US'))
    const femaleCount = computed(() => (Number(props.genderRatio?.female) || 0).toLocaleString('en-US'))

    function draw() {
      if (!chartEl.value) return
      const male = Number(props.genderRatio.male) || 0
      const female = Number(props.genderRatio.female) || 0
      const total = male + female
      const data = [
        { label: 'ប្រុស', value: male, fill: '#2563eb' },
        { label: 'ស្រី', value: female, fill: '#ec4899' }
      ].filter(d => d.value > 0)
      if (data.length === 0) {
        chartEl.value.innerHTML = '<p class="text-sm text-gray-500">មិនមានទិន្នន័យ</p>'
        return
      }
      d3.select(chartEl.value).selectAll('*').remove()
      const containerWidth = chartEl.value.getBoundingClientRect().width
      const size = Math.min(containerWidth, 220)
      const radius = size / 2 - 8
      const svg = d3.select(chartEl.value)
        .append('svg')
        .attr('width', size)
        .attr('height', size)
        .attr('viewBox', [0, 0, size, size])
      const g = svg.append('g').attr('transform', `translate(${size/2},${size/2})`)
      const pie = d3.pie().value(d => d.value)
      const arc = d3.arc().innerRadius(0).outerRadius(radius)
      const pieData = pie(data)
      g.selectAll('path')
        .data(pieData)
        .join('path')
        .attr('fill', d => d.data.fill)
        .attr('stroke', '#fff')
        .attr('stroke-width', 2)
        .transition()
        .duration(850)
        .ease(d3.easeCubicOut)
        .attrTween('d', function (d) {
          const interpolate = d3.interpolate(
            { startAngle: d.startAngle, endAngle: d.startAngle },
            d
          )
          return function (t) {
            return arc(interpolate(t))
          }
        })
      const labelRadius = radius * 0.65
      const labelArc = d3.arc().innerRadius(labelRadius).outerRadius(labelRadius)
      g.selectAll('.pie-label')
        .data(pieData)
        .join('text')
        .attr('class', 'pie-label')
        .attr('transform', d => `translate(${labelArc.centroid(d)})`)
        .attr('text-anchor', 'middle')
        .attr('fill', '#fff')
        .style('font-size', '11px')
        .style('font-weight', '600')
        .style('opacity', 0)
        .text(d => {
          const pct = total > 0 ? ((d.data.value / total) * 100).toFixed(1) : 0
          return `${d.data.label} ${pct}%`
        })
        .transition()
        .delay(360)
        .duration(260)
        .style('opacity', 1)
    }

    onMounted(draw)
    watch(() => props.genderRatio, draw, { deep: true })

    return { chartEl, maleCount, femaleCount }
  }
}
</script>
