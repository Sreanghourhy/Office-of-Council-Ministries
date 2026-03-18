<template>
  <div class="rounded-[7px] border border-gray-200 bg-white p-5 font-moul shadow-sm text-left lg:col-span-2 overflow-hidden flex flex-col min-h-0">
    <div class="mb-4 pb-4 border-b border-gray-100 flex-shrink-0">
      <span class="text-base font-semibold text-gray-800">ចំនួនកម្រិតអប់រំសរុបរបស់មន្ត្រី</span>
    </div>
    <div ref="chartEl" class="chart-bar-wrap w-full flex-1 min-h-[300px] overflow-hidden"></div>
  </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue'
import * as d3 from 'd3'

export default {
  name: 'DashboardBarChart',
  props: {
    data: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const chartEl = ref(null)
    const barColors = ['#3b82f6', '#1d4ed8']

    function draw() {
      if (!chartEl.value || !Array.isArray(props.data)) return
      const data = props.data
        .filter(d => d && (d.value > 0 || d.label))
        .filter(d => d.label !== 'បឋមសិក្សា')
      if (data.length === 0) {
        chartEl.value.innerHTML = ''
        return
      }
      d3.select(chartEl.value).selectAll('*').remove()

      d3.select(document.body).selectAll('.dashboard-bar-chart-tooltip').remove()

      const tooltip = d3
        .select(document.body)
        .append('div')
        .attr('class', 'dashboard-bar-chart-tooltip chart-tooltip')
        .style('position', 'fixed')
        .style('opacity', 0)
        .style('left', '0px')
        .style('top', '0px')
        .style('pointer-events', 'none')
        .style('z-index', '9999')

      const containerWidth = chartEl.value.getBoundingClientRect().width
      const containerHeight = Math.max(300, chartEl.value.getBoundingClientRect().height || 300)
      const width = Math.max(0, containerWidth)
      const height = Math.max(300, Math.min(containerHeight, data.length * 50))
      const margin = { top: 6, right: 42, bottom: 24, left: 114 }
      const innerWidth = Math.max(0, width - margin.left - margin.right)
      const innerHeight = Math.max(0, height - margin.top - margin.bottom)

      const total = data.reduce((sum, d) => sum + (Number(d.value) || 0), 0) || 1
      const toPercent = d => (Number(d.value) || 0) / total * 100

      function positionTooltipForDatum(event, d) {
        const ttNode = tooltip.node()
        if (!ttNode || !chartEl.value) return

        const ttWidth = ttNode.offsetWidth
        const ttHeight = ttNode.offsetHeight

        // position  above the mouse cursor
        let left = event.clientX - ttWidth / 2
        let top = event.clientY - ttHeight - 10

        left = Math.max(4, Math.min(left, window.innerWidth - ttWidth - 4))
        top = Math.max(4, Math.min(top, window.innerHeight - ttHeight - 4))

        tooltip.style('left', `${left}px`).style('top', `${top}px`)
      }

      const svg = d3.select(chartEl.value)
        .append('svg')
        .attr('width', '100%')
        .attr('height', height)
        .attr('viewBox', [0, 0, width, height])
        .attr('preserveAspectRatio', 'xMinYMid meet')
        .style('max-width', '100%')
        .style('overflow', 'hidden')

      const g = svg.append('g').attr('transform', `translate(${margin.left},${margin.top})`)
      const yScale = d3.scaleBand()
        .domain(data.map(d => d.label))
        .range([0, innerHeight])
        .padding(0.2)
      const maxVal = d3.max(data, d => toPercent(d)) || 1
      const xScale = d3.scaleLinear()
        .domain([0, Math.min(100, Math.ceil(maxVal * 1.1))])
        .range([0, innerWidth])
        .nice()

      const barHeight = yScale.bandwidth()
      const rx = 2

      const xAxis = d3.axisBottom(xScale)
        .ticks(6)
        .tickSize(-innerHeight)
        .tickFormat(d => `${d}%`)
      const xAxisG = svg.append('g')
        .attr('class', 'x-axis')
        .attr('transform', `translate(${margin.left},${margin.top + innerHeight})`)
        .call(xAxis)
      xAxisG.selectAll('.domain').attr('stroke', '#e5e7eb')
      xAxisG.selectAll('.tick line').attr('stroke', '#e5e7eb').attr('stroke-opacity', 0.8)
      xAxisG.selectAll('.tick text').attr('fill', '#6b7280').attr('font-size', '11px')
      xAxisG.select('.domain').attr('stroke-width', 1)

      const yAxisTicks = yScale.domain().map(label => ({
        y: yScale(label) + yScale.bandwidth() / 2
      }))
      g.selectAll('.grid-h')
        .data(yAxisTicks)
        .join('line')
        .attr('class', 'grid-h')
        .attr('x1', 0)
        .attr('x2', innerWidth)
        .attr('y1', d => d.y)
        .attr('y2', d => d.y)
        .attr('stroke', '#e5e7eb')
        .attr('stroke-opacity', 0.8)

      const bars = g.selectAll('.bar')
        .data(data)
        .join('rect')
        .attr('class', 'bar')
        .attr('y', d => yScale(d.label))
        .attr('height', barHeight)
        .attr('x', 0)
        .attr('width', 0)
        .attr('rx', rx)
        .attr('ry', rx)
        .attr('fill', (_, i) => barColors[i % barColors.length])
        .attr('opacity', 0.92)
        .style('cursor', 'pointer')
        .on('mouseenter', function (event, d) {
          tooltip
            .style('opacity', 1)
            .html(
              `ចំនួនមន្រ្តីសរុបដែលមាន ${d.label}: <span class="tt-amt">${Number(
                d.value || 0
              ).toLocaleString()}</span>`
            )
          positionTooltipForDatum(event, d)
        })
        .on('mousemove', function (event, d) {
          positionTooltipForDatum(event, d)
        })
        .on('mouseleave', function () {
          tooltip.style('opacity', 0)
        })

      bars
        .transition()
        .duration(760)
        .delay((_, i) => i * 70)
        .ease(d3.easeCubicOut)
        .attr('width', d => Math.max(0, xScale(toPercent(d))))

      g.selectAll('.bar-label')
        .data(data)
        .join('text')
        .attr('class', 'bar-label')
        .attr('y', d => yScale(d.label) + barHeight / 2)
        .attr('x', 8)
        .attr('dy', '0.35em')
        .attr('fill', '#9ca3af')
        .attr('text-anchor', 'start')
        .style('font-size', '12px')
        .style('font-weight', '500')
        .style('opacity', 0)
        .text(d => `${toPercent(d).toFixed(1)}%`)
        .transition()
        .duration(420)
        .delay((_, i) => 280 + (i * 70))
        .ease(d3.easeCubicOut)
        .attr('x', d => xScale(toPercent(d)) + 8)
        .style('opacity', 1)

      g.selectAll('.y-label')
        .data(data)
        .join('text')
        .attr('class', 'y-label')
        .attr('y', d => yScale(d.label) + barHeight / 2)
        .attr('x', -10)
        .attr('dy', '0.35em')
        .attr('text-anchor', 'end')
        .attr('fill', '#4b5563')
        .style('font-size', '13px')
        .style('font-weight', '500')
        .text(d => d.label)
        .style('opacity', 0)
        .transition()
        .duration(320)
        .delay((_, i) => 80 + (i * 40))
        .style('opacity', 1)
    }

    onMounted(draw)
    watch(() => props.data, draw, { deep: true })

    return { chartEl }
  }
}
</script>

<style scoped>
.chart-bar-wrap {
  min-width: 0;
  max-width: 100%;
  display: block;
}
.chart-bar-wrap svg {
  min-width: 0;
  max-width: 100%;
  display: block;
  margin-right: auto;
}
</style>

<style>
/* Body-mounted tooltip for bar chart (same look as other dashboard tooltips) */
.dashboard-bar-chart-tooltip.chart-tooltip {
  padding: 4px 8px;
  border-radius: 6px;
  background: rgba(17, 24, 39, 0.92);
  color: #fff;
  font-size: 12px;
  line-height: 16px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  white-space: nowrap;
}
.dashboard-bar-chart-tooltip.chart-tooltip .tt-amt {
  font-weight: 700;
}
</style>
