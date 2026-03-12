<template>
  <div class="min-h-screen absolute left-0 top-12 right-0 flex flex-wrap system-layout" oncontextmenu="return false;">
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
    <div class="relative w-full">
      <div class="flex title-bar border-b border-gray-200 bg-white items-center">
        <div class="flex w-64 h-10 py-1 title px-4 items-center">
          <svg class="text-blue-500 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M326.1 231.9l-47.5 75.5a31 31 0 0 1-7 7a30.11 30.11 0 0 1-35-49l75.5-47.5a10.23 10.23 0 0 1 11.7 0a10.06 10.06 0 0 1 2.3 14z" fill="currentColor"></path><path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0 0 56.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0 0 37.1-.1a173.13 173.13 0 0 1 254.8 0a25.19 25.19 0 0 0 37.1.1l3.2-3.5A223.18 223.18 0 0 0 480 287.9C480 164.2 379.7 64 256 64z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 128v32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M416 288h-32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M128 288H96"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M165.49 197.49l-22.63-22.63"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M346.51 197.49l22.63-22.63"></path></svg>
          <div class="font-moul ml-2 leading-9" v-html="model.title"></div>
        </div>
        <div class="dashboard-year-wrap">
          <span class="dashboard-year-label">ផ្ទាំងគ្រប់គ្រងតាមឆ្នាំ</span>
          <n-select
            v-model:value="selectedYear"
            :options="yearOptions"
            size="small"
            placeholder="ឆ្នាំ"
            clearable
            class="dashboard-year-select"
          />
          <n-button
            v-if="showClearYearButton"
            type="tertiary"
            size="small"
            quaternary
            @click="clearYearFilter"
          >
            សម្អាត
          </n-button>
        </div>
      </div>
      <!-- Content area -->
      <div class="p-4 space-y-4">
      <DashboardStats
        :totals="filteredStaffTotals"
        :increase-by-type="staffIncreaseByType"
        :trend="filteredTrend"
        :gender-ratio="filteredGenderRatio"
      />
      <div class="grid grid-cols-1 gap-4 min-w-0">
        <DashboardDepartmentChart :data="filteredEmployeesByDepartment" />
      </div>
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 min-w-0">
        <DashboardBarChart :data="filteredEducationDistribution" />
        <DashboardDonutChart :employees-by-position="filteredEmployeesByPosition" />
      </div>
      </div>
    </div>
    <float-top-menu v-bind:title="title" />
    <sidebar />
  </div>
</template>

<script>
import { ref , reactive , computed } from 'vue'
import { NSelect, NButton } from 'naive-ui'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import DashboardStats from '@components/dashboard/DashboardStats.vue'
import DashboardDepartmentChart from '@components/dashboard/DashboardDepartmentChart.vue'
import DashboardBarChart from '@components/dashboard/DashboardBarChart.vue'
import DashboardDonutChart from '@components/dashboard/DashboardDonutChart.vue'
import {
  staffTotalsMock,
  staffIncreaseByTypeMock,
  totalEmployeeTrendMock,
  employeesByDepartmentMock,
  employeesByPositionMock,
  educationDistributionMock,
  genderRatioMock
} from '@/data/dashboardMock'

export default {
  components: {
    FloatTopMenu ,
    Sidebar ,
    DashboardStats ,
    DashboardDepartmentChart,
    DashboardBarChart,
    DashboardDonutChart,
    NSelect,
    NButton
  },
  setup() {
    const model = reactive({
      name: 'DashboardWidgets' ,
      title: 'សង្ខេបព័ត៌មាន'
    })
    const title = ref("សង្ខេបព័ត៌មាន")
    const staffTotals = reactive({ ...staffTotalsMock })
    /** Percent change vs last month per staff type. */
    const staffIncreaseByType = reactive({ ...staffIncreaseByTypeMock })
    /** Employees by department for department chart */
    const employeesByDepartment = reactive(
      employeesByDepartmentMock.map(d => ({ ...d }))
    )
    /** Education level distribution: [{ label: string, value: number }] */
    const educationDistribution = reactive(
      educationDistributionMock.map(d => ({ ...d }))
    )
    /** Male / female counts */
    const genderRatio = reactive({ ...genderRatioMock })
    /** Employees per position for donut chart: [{ label: string, value: number }] */
    const employeesByPosition = reactive(
      employeesByPositionMock.map(d => ({ ...d }))
    )
    /** Total employee trend by year for line chart (raw data) */
    const totalEmployeeTrend = reactive(totalEmployeeTrendMock.map(d => ({ ...d })))

    /** Years from trend data, for dropdown (newest first). */
    const yearOptions = computed(() =>
      totalEmployeeTrendMock
        .map(e => ({ label: String(e.year), value: Number(e.year) }))
        .sort((a, b) => b.value - a.value)
    )

    /** Latest year in trend data  */
    const latestYear = totalEmployeeTrendMock.length > 0
      ? Number(totalEmployeeTrendMock[totalEmployeeTrendMock.length - 1].year)
      : new Date().getFullYear()

    const selectedYear = ref(latestYear)

    // back to current year (Clear)
    const showClearYearButton = computed(() =>
      selectedYear.value != null && selectedYear.value !== latestYear
    )

    function clearYearFilter() {
      selectedYear.value = latestYear
    }

    const latestTotal = totalEmployeeTrendMock.length > 0
      ? Number(totalEmployeeTrendMock[totalEmployeeTrendMock.length - 1].value) || 2949
      : 2949

    const trendValueForSelectedYear = computed(() => {
      if (selectedYear.value == null) return latestTotal
      const entry = totalEmployeeTrendMock.find(e => Number(e.year) === selectedYear.value)
      return entry ? Number(entry.value) : latestTotal
    })

    const scaleFactor = computed(() => {
      if (selectedYear.value == null) return 1
      return Math.min(1.2, Math.max(0.1, trendValueForSelectedYear.value / latestTotal))
    })

    const round = (n) => Math.round(Number(n)) || 0

    const filteredTrend = computed(() => {
      if (selectedYear.value == null) return totalEmployeeTrend
      return totalEmployeeTrend.filter(entry => Number(entry.year) <= selectedYear.value)
    })

    const filteredStaffTotals = computed(() => ({
      political: round(staffTotalsMock.political * scaleFactor.value),
      publicService: round(staffTotalsMock.publicService * scaleFactor.value),
      contract: round(staffTotalsMock.contract * scaleFactor.value),
      agreement: round(staffTotalsMock.agreement * scaleFactor.value)
    }))

    const filteredGenderRatio = computed(() => ({
      male: round(genderRatioMock.male * scaleFactor.value),
      female: round(genderRatioMock.female * scaleFactor.value)
    }))

    const filteredEmployeesByDepartment = computed(() =>
      employeesByDepartmentMock.map(d => ({
        ...d,
        total: round(d.total * scaleFactor.value)
      }))
    )

    const filteredEducationDistribution = computed(() =>
      educationDistributionMock.map(d => ({
        label: d.label,
        value: round(d.value * scaleFactor.value)
      }))
    )

    const filteredEmployeesByPosition = computed(() =>
      employeesByPositionMock.map(d => ({
        label: d.label,
        value: round(d.value * scaleFactor.value)
      }))
    )

    return {
      model ,
      title ,
      staffTotals ,
      staffIncreaseByType ,
      totalEmployeeTrend: filteredTrend ,
      filteredTrend ,
      filteredStaffTotals ,
      filteredGenderRatio ,
      filteredEmployeesByDepartment ,
      filteredEducationDistribution ,
      filteredEmployeesByPosition ,
      selectedYear,
      yearOptions,
      showClearYearButton,
      clearYearFilter
    }
  },
  name: "DashboardPage",
  data() {
    return {}
  },
  computed: {},
  mounted() {},
  methods: {}
}
</script>

<style scoped>
.dashboard-year-wrap {
  flex: 1;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 0.5rem;
  padding-right: 1rem;
}
.dashboard-year-label {
  font-family: btb, 'Battambang', sans-serif;
  font-size: 0.8125rem;
  font-weight: 500;
  color: #6b7280;
  white-space: nowrap;
}
.dashboard-year-select {
  width: 88px !important;
  min-width: 88px !important;
  max-width: 88px !important;
}
.dashboard-year-wrap :deep(.n-base-selection) {
  min-width: 0;
}
.dashboard-year-wrap :deep(.n-base-selection .n-base-selection-label) {
  min-width: 0;
}
.system-layout {
  margin-left: 60px;
}
.app_snav_open .system-layout {
  margin-left: 230px;
}
</style>
