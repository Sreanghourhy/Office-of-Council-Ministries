<template>
  <div class="donut-chart-card">
    <div class="donut-chart-card__header">
      <span class="donut-chart-card__title">ចំនួនមន្ត្រីតាមមុខតំណែង</span>
    </div>
    <div class="donut-chart-card__chart-wrap">
      <div ref="chartEl" class="donut-chart-card__chart"></div>
      <div v-if="totalCount > 0" class="donut-chart-card__center-label">
        <span class="donut-chart-card__total">{{ totalCountFormatted }}</span>
        <span class="donut-chart-card__total-caption">នាក់</span>
      </div>
    </div>
    <div v-if="legendItems.length > 0" class="donut-chart-card__legend">
      <div
        v-for="(item, i) in legendItems"
        :key="i"
        class="donut-chart-card__legend-item"
      >
        <span class="donut-chart-card__legend-dot" :style="{ background: item.fill }"></span>
        <span class="donut-chart-card__legend-label" :title="item.label">{{ item.label }}</span>
        <span class="donut-chart-card__legend-value">{{ item.valueFormatted }}</span>
        <span class="donut-chart-card__legend-pct">({{ item.percent }}%)</span>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch, onMounted, computed } from 'vue'
import * as d3 from 'd3'

const COLORS = [
  '#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#ec4899', '#6366f1',
  '#14b8a6', '#f97316', '#a855f7', '#84cc16'
]

export default {
  name: 'DashboardDonutChart',
  props: {
    employeesByPosition: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const chartEl = ref(null)

    const dataFiltered = computed(() => {
      const list = Array.isArray(props.employeesByPosition) ? props.employeesByPosition : []
      return list
        .map(d => ({ label: String(d.label || '').trim() || '—', value: Number(d.value) || 0 }))
        .filter(d => d.value > 0)
    })

    const totalCount = computed(() =>
      dataFiltered.value.reduce((sum, d) => sum + d.value, 0)
    )
    const totalCountFormatted = computed(() =>
      totalCount.value.toLocaleString('en-US')
    )

    const colorScale = computed(() =>
      d3.scaleOrdinal(COLORS).domain(dataFiltered.value.map(d => d.label))
    )

    const legendItems = computed(() => {
      const data = dataFiltered.value
      const total = totalCount.value
      const scale = colorScale.value
      return data.map(d => ({
        label: d.label,
        value: d.value,
        valueFormatted: d.value.toLocaleString('en-US'),
        percent: total > 0 ? ((d.value / total) * 100).toFixed(1) : '0',
        fill: scale(d.label)
      }))
    })

    function draw() {
      if (!chartEl.value) return
      const data = dataFiltered.value
      if (data.length === 0) {
        chartEl.value.innerHTML = '<p class="donut-chart-card__empty">មិនមានទិន្នន័យ</p>'
        return
      }
      d3.select(chartEl.value).selectAll('*').remove()
      d3.select(document.body).selectAll('.dashboard-donut-chart-tooltip').remove()

      const tooltip = d3
        .select(document.body)
        .append('div')
        .attr('class', 'dashboard-donut-chart-tooltip chart-tooltip')
        .style('position', 'fixed')
        .style('opacity', 0)
        .style('left', '0px')
        .style('top', '0px')
        .style('pointer-events', 'none')
        .style('z-index', '9999')

      function positionTooltip(event) {
        const ttNode = tooltip.node()
        if (!ttNode) return
        const ttWidth = ttNode.offsetWidth
        const ttHeight = ttNode.offsetHeight
        let left = event.clientX - ttWidth / 2
        let top = event.clientY - ttHeight - 10
        left = Math.max(4, Math.min(left, window.innerWidth - ttWidth - 4))
        top = Math.max(4, Math.min(top, window.innerHeight - ttHeight - 4))
        tooltip.style('left', `${left}px`).style('top', `${top}px`)
      }

      const scale = colorScale.value
      const dataWithFill = data.map(d => ({ ...d, fill: scale(d.label) }))

      const containerWidth = chartEl.value.getBoundingClientRect().width || 220
      const size = Math.max(180, Math.min(containerWidth, 220))
      const radius = size / 2 - 12
      const innerRadius = radius * 0.58
      const padAngle = 0.012

      const svg = d3.select(chartEl.value)
        .append('svg')
        .attr('width', size)
        .attr('height', size)
        .attr('viewBox', [0, 0, size, size])
        .attr('class', 'donut-chart-svg')
      const g = svg.append('g').attr('transform', `translate(${size / 2},${size / 2})`)

      const pie = d3.pie().value(d => d.value).sort(null).padAngle(padAngle)
      const arc = d3.arc()
        .innerRadius(innerRadius)
        .outerRadius(radius)
        .cornerRadius(3)

      const arcs = g.selectAll('path')
        .data(pie(dataWithFill))
        .join('path')
        .attr('d', arc)
        .attr('fill', d => d.data.fill)
        .attr('stroke', '#fff')
        .attr('stroke-width', 2.5)
        .attr('class', 'donut-chart-arc')
        .style('cursor', 'pointer')
        .on('mouseenter', function (event, d) {
          const label = d.data.label
          const amount = (d.data.value || 0).toLocaleString('en-US')
          tooltip
            .style('opacity', 1)
            .html(`<span class="tt-label">${label}</span>: <span class="tt-amt">${amount}</span>`)
          positionTooltip(event)
        })
        .on('mousemove', positionTooltip)
        .on('mouseleave', function () {
          tooltip.style('opacity', 0)
        })

      const total = dataWithFill.reduce((s, d) => s + d.value, 0)
      const labelRadius = (innerRadius + radius) * 0.52
      const labelArc = d3.arc().innerRadius(labelRadius).outerRadius(labelRadius)
      g.selectAll('.donut-label')
        .data(pie(dataWithFill))
        .join('text')
        .attr('class', 'donut-label')
        .attr('transform', d => `translate(${labelArc.centroid(d)})`)
        .attr('text-anchor', 'middle')
        .attr('fill', '#fff')
        .attr('stroke', 'rgba(0,0,0,0.15)')
        .attr('stroke-width', 1)
        .attr('paint-order', 'stroke fill')
        .style('font-size', '15px')
        .style('font-weight', '700')
        .text(d => {
          const pct = total > 0 ? ((d.data.value / total) * 100).toFixed(0) : 0
          return `${pct}%`
        })
    }

    onMounted(draw)
    watch(dataFiltered, draw, { deep: true })

    return { chartEl, totalCount, totalCountFormatted, legendItems }
  }
}
</script>

<style scoped>
.donut-chart-card {
  width: 100%;
  height: 100%;
  min-height: 0;
  display: flex;
  flex-direction: column;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  background: #fff;
  padding: 1rem 1.25rem;
  font-family: 'Moul', sans-serif;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
}

.donut-chart-card__header {
  margin-bottom: 0.75rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #f3f4f6;
}

.donut-chart-card__title {
  font-size: 0.9375rem;
  font-weight: 600;
  color: #1f2937;
}

.donut-chart-card__chart-wrap {
  position: relative;
  width: 100%;
  min-height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.donut-chart-card__chart {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-width: 180px;
  min-height: 180px;
  overflow: hidden;
}

.donut-chart-card__center-label {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  pointer-events: none;
}

.donut-chart-card__total {
  display: block;
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  line-height: 1.2;
}

.donut-chart-card__total-caption {
  font-size: 0.75rem;
  color: #6b7280;
  font-weight: 500;
}

.donut-chart-card__legend {
  margin-top: 0.75rem;
  padding-top: 0.75rem;
  border-top: 1px solid #f3f4f6;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.35rem 0.75rem;
  max-height: 140px;
  overflow-y: auto;
}

.donut-chart-card__legend-item {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  min-width: 0;
  font-size: 0.75rem;
}

.donut-chart-card__legend-dot {
  flex-shrink: 0;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.8);
}

.donut-chart-card__legend-label {
  flex: 1;
  min-width: 0;
  color: #374151;
  font-weight: 500;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.donut-chart-card__legend-value {
  flex-shrink: 0;
  font-weight: 600;
  color: #111827;
}

.donut-chart-card__legend-pct {
  flex-shrink: 0;
  color: #9ca3af;
  font-size: 0.6875rem;
}

.donut-chart-card__empty {
  margin: 0;
  font-size: 0.875rem;
  color: #6b7280;
  text-align: center;
  padding: 2rem 1rem;
}

:deep(.donut-chart-arc) {
  filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.08));
}
</style>

<style>
/* hover */
.dashboard-donut-chart-tooltip.chart-tooltip {
  padding: 6px 10px;
  border-radius: 6px;
  background: rgba(17, 24, 39, 0.92);
  color: #fff;
  font-size: 12px;
  line-height: 18px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  white-space: nowrap;
}
.dashboard-donut-chart-tooltip.chart-tooltip .tt-label {
  font-weight: 500;
}
.dashboard-donut-chart-tooltip.chart-tooltip .tt-amt {
  font-weight: 700;
}
</style>
