<template>
  <div class="rounded-[7px] border border-gray-200 bg-white p-5 font-moul shadow-sm text-left overflow-hidden flex flex-col min-h-0 h-full">
    <div class="mb-3 flex-shrink-0">
      <div class="text-base font-semibold text-gray-800">មន្ត្រីសរុប</div>
      <div class="flex flex-wrap items-baseline gap-x-2 gap-y-0.5 mt-0.5">
        <span class="text-2xl font-bold text-gray-900">{{ formattedTotal }}</span>
        <span v-if="trendPercent != null" class="inline-flex items-center gap-1.5 text-sm font-medium">
          <template v-if="trendPercent > 0">
            <svg class="w-4 h-4 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-600">+{{ trendPercent }}%</span>
          </template>
          <template v-else-if="trendPercent < 0">
            <svg class="w-4 h-4 flex-shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="text-red-600">{{ trendPercent }}%</span>
          </template>
          <template v-else>
            <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="text-gray-500">0%</span>
          </template>
          <span class="text-gray-400 font-normal">ឆ្នាំមុន</span>
        </span>
      </div>
      <!-- <div class="text-sm text-gray-500 mt-0.5">ចំនួនមន្ត្រីសរុប</div> -->
    </div>
    <div ref="chartEl" class="chart-trend-wrap w-full flex-1 min-h-[260px] overflow-hidden"></div>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted } from 'vue'
import * as d3 from 'd3'

export default {
  name: 'DashboardTotalEmployeeChart',
  props: {
    // Current total employee count 
    totalCount: {
      type: [Number, String],
      default: 0
    },
    trend: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const chartEl = ref(null)
    const formattedTotal = computed(() => Number(props.totalCount || 0).toLocaleString())
    const trendPercent = computed(() => {
      const data = (props.trend || []).filter(d => d && typeof d.year !== 'undefined' && typeof d.value !== 'undefined')
      if (data.length < 2) return null
      const prev = Number(data[data.length - 2].value) || 0
      const curr = Number(data[data.length - 1].value) || 0
      if (prev === 0) return curr > 0 ? 100 : 0
      return Math.round(((curr - prev) / prev) * 1000) / 10
    })
    // const lineColor = '#f97316' // orange
    const lineColor = '#3b82f6' // blue
    const areaFill = 'url(#total-employee-area-gradient)'

    function draw() {
      if (!chartEl.value) return
      const data = (props.trend || []).filter(d => d && typeof d.year !== 'undefined' && typeof d.value !== 'undefined')
      if (data.length === 0) {
        chartEl.value.innerHTML = '<p class="text-sm text-gray-500 p-2">មិនមានទិន្នន័យ</p>'
        return
      }
      d3.select(chartEl.value).selectAll('*').remove()
      d3.select(document.body).selectAll('.dashboard-total-employee-chart-tooltip').remove()

      const tooltip = d3
        .select(document.body)
        .append('div')
        .attr('class', 'dashboard-total-employee-chart-tooltip chart-tooltip')
        .style('position', 'fixed')
        .style('opacity', 0)
        .style('left', '0px')
        .style('top', '0px')
        .style('pointer-events', 'none')
        .style('z-index', '9999')

      const containerWidth = chartEl.value.getBoundingClientRect().width
      const containerHeight = Math.max(260, chartEl.value.getBoundingClientRect().height || 260)
      const width = Math.max(0, containerWidth)
      const height = Math.max(260, containerHeight)
      const margin = { top: 12, right: 12, bottom: 34, left: 40 }
      const innerWidth = Math.max(0, width - margin.left - margin.right)
      const innerHeight = Math.max(0, height - margin.top - margin.bottom)

      const svg = d3.select(chartEl.value)
        .append('svg')
        .attr('width', '100%')
        .attr('height', height)
        .attr('viewBox', [0, 0, width, height])
        .attr('preserveAspectRatio', 'none')

      const defs = svg.append('defs')
      const gradient = defs.append('linearGradient')
        .attr('id', 'total-employee-area-gradient')
        .attr('x1', 0)
        .attr('x2', 0)
        .attr('y1', 0)
        .attr('y2', 1)
      gradient.append('stop').attr('offset', '0%').attr('stop-color', lineColor).attr('stop-opacity', 0.35)
      gradient.append('stop').attr('offset', '100%').attr('stop-color', lineColor).attr('stop-opacity', 0.02)

      const g = svg.append('g').attr('transform', `translate(${margin.left},${margin.top})`)

      const xScale = d3.scaleLinear()
        .domain(d3.extent(data, d => d.year))
        .range([0, innerWidth])
      const maxVal = d3.max(data, d => Number(d.value) || 0) || 1
      const yScale = d3.scaleLinear()
        .domain([0, Math.ceil(maxVal * 1.1 / 1000) * 1000])
        .range([innerHeight, 0])
        .nice()

      function positionTooltipForDatum(d) {
        const ttNode = tooltip.node()
        if (!ttNode || !chartEl.value) return

        const rect = chartEl.value.getBoundingClientRect()
        const ttWidth = ttNode.offsetWidth
        const ttHeight = ttNode.offsetHeight

        // Dot position in chart container coordinates
        const dotX = margin.left + xScale(d.year)
        const dotY = margin.top + yScale(Number(d.value) || 0)

        let left = rect.left + dotX - ttWidth / 2
        let top = rect.top + dotY - ttHeight - 10

        // tooltip is never cut off edge of card
        left = Math.max(4, Math.min(left, window.innerWidth - ttWidth - 4))
        top = Math.max(4, Math.min(top, window.innerHeight - ttHeight - 4))

        tooltip.style('left', `${left}px`).style('top', `${top}px`)
      }

      const line = d3.line()
        .x(d => xScale(d.year))
        .y(d => yScale(Number(d.value) || 0))
        .curve(d3.curveMonotoneX)

      const area = d3.area()
        .x(d => xScale(d.year))
        .y0(innerHeight)
        .y1(d => yScale(Number(d.value) || 0))
        .curve(d3.curveMonotoneX)

      g.append('path')
        .datum(data)
        .attr('fill', areaFill)
        .attr('d', area)

      g.append('path')
        .datum(data)
        .attr('fill', 'none')
        .attr('stroke', lineColor)
        .attr('stroke-width', 2)
        .attr('stroke-linecap', 'round')
        .attr('stroke-linejoin', 'round')
        .attr('d', line)

      const dots = g
        .selectAll('.dot-visual')
        .data(data)
        .join('circle')
        .attr('class', 'dot-visual')
        .attr('cx', d => xScale(d.year))
        .attr('cy', d => yScale(Number(d.value) || 0))
        .attr('r', 4)
        .attr('fill', lineColor)
        .attr('stroke', '#fff')
        .attr('stroke-width', 1.5)
        .style('pointer-events', 'none')

      function getTooltipHtml(d, dataArr) {
        const currVal = Number(d.value) || 0
        const idx = dataArr.findIndex((x) => x.year === d.year)
        const prevDatum = idx > 0 ? dataArr[idx - 1] : null
        const prevVal = prevDatum != null ? Number(prevDatum.value) || 0 : null
        const diff = prevVal != null ? currVal - prevVal : null
        const pct = prevVal != null && prevVal !== 0 ? Math.round(((currVal - prevVal) / prevVal) * 1000) / 10 : null
        let line1 = `ចំនួនមន្ត្រីសរុបក្នុងឆ្នាំ ${d.year}: <span class="tt-amt">${currVal.toLocaleString()}</span>`
        if (diff !== null) {
          const sign = diff > 0 ? '+' : ''
          const diffClass = diff > 0 ? 'tt-up' : diff < 0 ? 'tt-down' : 'tt-same'
          const diffStr = `${sign}${diff.toLocaleString()}`
          const pctStr = pct != null ? ` (${sign}${pct}%)` : ''
          line1 += `<br><span class="tt-change ${diffClass}">ប្រៀបធៀបឆ្នាំមុន: ${diffStr}${pctStr}</span>`
        }
        return line1
      }

      // invisible hover area so mouse enter easier and not point on the dot exactly on it
      g.selectAll('.dot-hit')
        .data(data)
        .join('circle')
        .attr('class', 'dot-hit')
        .attr('cx', d => xScale(d.year))
        .attr('cy', d => yScale(Number(d.value) || 0))
        .attr('r', 16)
        .attr('fill', 'transparent')
        .style('cursor', 'pointer')
        .on('mouseenter', function (event, d) {
          dots.filter(dd => dd.year === d.year).attr('r', 7)
          tooltip
            .style('opacity', 1)
            .html(getTooltipHtml(d, data))
          positionTooltipForDatum(d)
        })
        .on('mousemove', function (event, d) {
          positionTooltipForDatum(d)
        })
        .on('mouseleave', function (event, d) {
          dots.filter(dd => dd.year === d.year).attr('r', 4)
          tooltip.style('opacity', 0)
        })

      const xAxis = d3.axisBottom(xScale)
        .tickFormat(d3.format('d'))
        .tickSize(0)
        .tickPadding(10)
      const xAxisG = g.append('g')
        .attr('transform', `translate(0,${innerHeight})`)
        .call(xAxis)
      xAxisG.selectAll('.tick text').attr('fill', '#6b7280').attr('font-size', '11px')
      xAxisG.select('.domain').attr('stroke', '#e5e7eb')

      const yAxis = d3.axisLeft(yScale)
        .ticks(5)
        .tickFormat(d3.format(','))
        .tickSize(-innerWidth)
      const yAxisG = g.append('g').call(yAxis)
      yAxisG.selectAll('.tick line').attr('stroke', '#e5e7eb').attr('stroke-opacity', 0.8)
      yAxisG.selectAll('.tick text').attr('fill', '#6b7280').attr('font-size', '11px')
      yAxisG.select('.domain').attr('stroke', '#e5e7eb')
      yAxisG
        .selectAll('.tick')
        .filter(d => Number(d) === 0)
        .select('text')
        .attr('dy', '-0.25em')
    }

    onMounted(draw)
    watch([() => props.totalCount, () => props.trend], draw, { deep: true })

    return { chartEl, formattedTotal, trendPercent }
  }
}
</script>

<style scoped>
.chart-trend-wrap {
  min-width: 0;
  max-width: 100%;
  display: block;
  position: relative;
}
.chart-trend-wrap svg {
  min-width: 0;
  max-width: 100%;
  display: block;
}

.chart-trend-wrap :deep(.chart-tooltip) {
  position: absolute;
  z-index: 10;
  pointer-events: none;
  padding: 4px 8px;
  border-radius: 6px;
  background: rgba(17, 24, 39, 0.92);
  color: #fff;
  font-size: 12px;
  line-height: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  transform: translateZ(0);
  white-space: nowrap;
}

.chart-trend-wrap :deep(.chart-tooltip .tt-amt) {
  font-weight: 700;
}
.chart-trend-wrap :deep(.chart-tooltip .tt-change) {
  font-weight: 600;
  display: block;
  margin-top: 6px;
}
.chart-trend-wrap :deep(.chart-tooltip .tt-up) {
  color: #22c55e;
}
.chart-trend-wrap :deep(.chart-tooltip .tt-down) {
  color: #ef4444;
}
.chart-trend-wrap :deep(.chart-tooltip .tt-same) {
  color: #9ca3af;
}
</style>

<style>
.dashboard-total-employee-chart-tooltip.chart-tooltip {
  padding: 4px 8px;
  border-radius: 6px;
  background: rgba(17, 24, 39, 0.92);
  color: #fff;
  font-size: 12px;
  line-height: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  white-space: nowrap;
}
.dashboard-total-employee-chart-tooltip.chart-tooltip .tt-amt {
  font-weight: 700;
}
.dashboard-total-employee-chart-tooltip.chart-tooltip .tt-change {
  font-weight: 600;
  display: block;
  margin-top: 6px;
}
.dashboard-total-employee-chart-tooltip.chart-tooltip .tt-up {
  color: #22c55e;
}
.dashboard-total-employee-chart-tooltip.chart-tooltip .tt-down {
  color: #ef4444;
}
.dashboard-total-employee-chart-tooltip.chart-tooltip .tt-same {
  color: #9ca3af;
}
</style>
