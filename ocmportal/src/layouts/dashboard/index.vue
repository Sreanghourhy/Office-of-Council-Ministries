<template>
  <div class="dashboard-page min-h-screen absolute left-0 top-12 right-0 flex flex-wrap system-layout" oncontextmenu="return false;">
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>

    <div class="dashboard-page__backdrop" aria-hidden="true">
      <span class="dashboard-page__orb dashboard-page__orb--one"></span>
      <span class="dashboard-page__orb dashboard-page__orb--two"></span>
      <span class="dashboard-page__grid"></span>
    </div>

    <div class="relative w-full dashboard-page__content">
      <section class="dashboard-hero dashboard-reveal">
        <div class="dashboard-hero__copy">
          <div class="dashboard-hero__eyebrow">ផ្ទាំងវិភាគបុគ្គលិក</div>
          <h1 class="dashboard-hero__title font-moul" v-html="model.title"></h1>
          <p class="dashboard-hero__description">
            ទិដ្ឋភាពសរុបអំពីចំនួនបុគ្គលិក សមាមាត្រភេទ នាយកដ្ឋាន តួនាទី និងកម្រិតអប់រំ។
          </p>
          <div class="dashboard-chip-row">
            <span class="dashboard-chip">ឆ្នាំ {{ selectedYearDisplay }}</span>
            <span class="dashboard-chip">សរុប {{ totalStaffFormatted }}</span>
            <span class="dashboard-chip">ស្រី {{ femaleSharePercent }}%</span>
            <span class="dashboard-chip">នាយកដ្ឋាន {{ departmentCountFormatted }}</span>
          </div>
        </div>

        <div class="dashboard-hero__side dashboard-reveal dashboard-delay-1">
          <div class="dashboard-filter-card">
            <div class="dashboard-filter-card__top">
              <div>
                <div class="dashboard-filter-card__label">ឆ្នាំផ្តោត</div>
                <div class="dashboard-filter-card__hint">ជ្រើសឆ្នាំដើម្បីធ្វើបច្ចុប្បន្នភាពទិន្នន័យលើផ្ទាំងគ្រប់គ្រង។</div>
              </div>
              <div class="dashboard-filter-card__actions">
                <n-select
                  v-model:value="selectedYear"
                  :options="yearOptions"
                  size="small"
                  placeholder="ជ្រើសរើសឆ្នាំ"
                  clearable
                  class="dashboard-year-select"
                />
                <n-button
                  v-if="showClearYearButton"
                  type="default"
                  size="small"
                  @click="clearYearFilter"
                >
                  កំណត់ឡើងវិញ
                </n-button>
              </div>
            </div>
            <div class="dashboard-filter-card__quick-years">
              <button
                v-for="item in quickYearOptions"
                :key="item.value"
                class="dashboard-year-pill"
                :class="{ 'dashboard-year-pill--active': selectedYear === item.value }"
                @click="setSelectedYear(item.value)"
              >
                {{ item.label }}
              </button>
            </div>
          </div>

          <div class="dashboard-quick-grid">
            <article class="dashboard-quick-card">
              <span class="dashboard-quick-card__label">បុគ្គលិកសរុប</span>
              <strong class="dashboard-quick-card__value">{{ totalStaffFormatted }}</strong>
              <span class="dashboard-quick-card__meta" :class="trendMetaClass">{{ trendSummaryText }}</span>
            </article>
            <article class="dashboard-quick-card">
              <span class="dashboard-quick-card__label">នាយកដ្ឋាន</span>
              <strong class="dashboard-quick-card__value">{{ departmentCountFormatted }}</strong>
              <span class="dashboard-quick-card__meta">បានតាមដានលើផ្ទាំងគ្រប់គ្រង</span>
            </article>
            <article class="dashboard-quick-card">
              <span class="dashboard-quick-card__label">តួនាទី</span>
              <strong class="dashboard-quick-card__value">{{ positionCountFormatted }}</strong>
              <span class="dashboard-quick-card__meta">បង្ហាញក្នុងក្រាហ្វដូណាត់តួនាទី</span>
            </article>
            <article class="dashboard-quick-card">
              <span class="dashboard-quick-card__label">សមាមាត្រភេទ</span>
              <strong class="dashboard-quick-card__value">{{ femaleSharePercent }}%</strong>
              <span class="dashboard-quick-card__meta">ស្រី និង ប្រុស {{ maleSharePercent }}%</span>
            </article>
          </div>
        </div>
      </section>

      <DashboardStats
        :totals="filteredStaffTotals"
        :increase-by-type="staffIncreaseByType"
        :trend="filteredTrend"
        :gender-ratio="filteredGenderRatio"
      />

      <section class="dashboard-panel-shell">
        <div class="dashboard-panel-shell__header dashboard-reveal dashboard-delay-2">
          <div>
            <h2 class="dashboard-panel-shell__title">ទិដ្ឋភាពទូទៅតាមនាយកដ្ឋាន</h2>
            <p class="dashboard-panel-shell__description">
              បែងចែកចំនួនបុគ្គលិកតាមនាយកដ្ឋានជាមួយសមាមាត្រភេទបច្ចុប្បន្ន។
            </p>
          </div>
        </div>
        <DashboardDepartmentChart
          class="dashboard-card dashboard-card--wide dashboard-reveal dashboard-delay-3"
          :data="filteredEmployeesByDepartment"
        />
      </section>

      <section class="dashboard-panel-shell">
        <div class="dashboard-panel-shell__header dashboard-reveal dashboard-delay-4">
          <div>
            <h2 class="dashboard-panel-shell__title">កម្រិតអប់រំ និង តួនាទី</h2>
            <p class="dashboard-panel-shell__description">
              ប្រៀបធៀបកម្រិតអប់រំជាមួយការបែងចែកតួនាទីក្នុងទិដ្ឋភាពតែមួយ។
            </p>
          </div>
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 min-w-0">
          <DashboardBarChart
            class="dashboard-card dashboard-card--wide dashboard-reveal dashboard-delay-5"
            :data="filteredEducationDistribution"
          />
          <DashboardDonutChart
            class="dashboard-card dashboard-card--compact dashboard-reveal dashboard-delay-6"
            :employees-by-position="filteredEmployeesByPosition"
          />
        </div>
      </section>
    </div>

    <float-top-menu :title="title" />
    <sidebar />
  </div>
</template>

<script>
import { ref, reactive, computed } from 'vue'
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
  name: 'DashboardPage',
  components: {
    FloatTopMenu,
    Sidebar,
    DashboardStats,
    DashboardDepartmentChart,
    DashboardBarChart,
    DashboardDonutChart,
    NSelect,
    NButton
  },
  setup() {
    const khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩']
    const toKhmerNumeral = (value) => String(value ?? '').replace(/\d/g, (digit) => khmerDigits[Number(digit)])

    const dashboardTitle = decodeURIComponent('%E1%9E%9F%E1%9E%84%E1%9F%92%E1%9E%81%E1%9F%81%E1%9E%94%E1%9E%96%E1%9F%90%E1%9E%8F%E1%9F%8C%E1%9E%98%E1%9E%B6%E1%9E%93')

    const model = reactive({
      name: 'DashboardWidgets',
      title: dashboardTitle
    })
    const title = ref(dashboardTitle)

    const staffIncreaseByType = reactive({ ...staffIncreaseByTypeMock })
    const totalEmployeeTrend = reactive(totalEmployeeTrendMock.map((item) => ({ ...item })))

    const yearOptions = computed(() =>
      totalEmployeeTrendMock
        .map((entry) => ({ label: toKhmerNumeral(entry.year), value: Number(entry.year) }))
        .sort((a, b) => b.value - a.value)
    )

    const quickYearOptions = computed(() => yearOptions.value.slice(0, 5))

    const latestYear = totalEmployeeTrendMock.length > 0
      ? Number(totalEmployeeTrendMock[totalEmployeeTrendMock.length - 1].year)
      : new Date().getFullYear()

    const latestTotal = totalEmployeeTrendMock.length > 0
      ? Number(totalEmployeeTrendMock[totalEmployeeTrendMock.length - 1].value) || 2949
      : 2949

    const selectedYear = ref(latestYear)

    const showClearYearButton = computed(() =>
      selectedYear.value != null && selectedYear.value !== latestYear
    )

    function clearYearFilter() {
      selectedYear.value = latestYear
    }

    function setSelectedYear(year) {
      selectedYear.value = year
    }

    const trendValueForSelectedYear = computed(() => {
      if (selectedYear.value == null) return latestTotal
      const entry = totalEmployeeTrendMock.find((item) => Number(item.year) === selectedYear.value)
      return entry ? Number(entry.value) || latestTotal : latestTotal
    })

    const scaleFactor = computed(() => {
      if (selectedYear.value == null) return 1
      return Math.min(1.2, Math.max(0.1, trendValueForSelectedYear.value / latestTotal))
    })

    const round = (n) => Math.round(Number(n)) || 0

    const filteredTrend = computed(() => {
      if (selectedYear.value == null) return totalEmployeeTrend
      return totalEmployeeTrend.filter((entry) => Number(entry.year) <= selectedYear.value)
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
      employeesByDepartmentMock.map((item) => ({
        ...item,
        total: round(item.total * scaleFactor.value)
      }))
    )

    const filteredEducationDistribution = computed(() =>
      educationDistributionMock.map((item) => ({
        label: item.label,
        value: round(item.value * scaleFactor.value)
      }))
    )

    const filteredEmployeesByPosition = computed(() =>
      employeesByPositionMock.map((item) => ({
        label: item.label,
        value: round(item.value * scaleFactor.value)
      }))
    )

    const totalStaffCount = computed(() =>
      Object.values(filteredStaffTotals.value).reduce((sum, value) => sum + (Number(value) || 0), 0)
    )

    const totalStaffFormatted = computed(() => toKhmerNumeral(totalStaffCount.value.toLocaleString('en-US')))
    const departmentCountFormatted = computed(() => toKhmerNumeral(filteredEmployeesByDepartment.value.length.toLocaleString('en-US')))
    const positionCountFormatted = computed(() => toKhmerNumeral(filteredEmployeesByPosition.value.length.toLocaleString('en-US')))

    const femaleSharePercent = computed(() => {
      const female = Number(filteredGenderRatio.value.female) || 0
      const total = (Number(filteredGenderRatio.value.male) || 0) + female
      if (total <= 0) return 0
      return Math.round((female / total) * 100)
    })

    const maleSharePercent = computed(() => {
      const male = Number(filteredGenderRatio.value.male) || 0
      const total = male + (Number(filteredGenderRatio.value.female) || 0)
      if (total <= 0) return 0
      return Math.round((male / total) * 100)
    })

    const selectedYearDisplay = computed(() =>
      selectedYear.value == null ? 'គ្រប់ឆ្នាំ' : toKhmerNumeral(selectedYear.value)
    )

    const trendPercentValue = computed(() => {
      const data = filteredTrend.value || []
      if (data.length < 2) return 0
      const prev = Number(data[data.length - 2]?.value) || 0
      const curr = Number(data[data.length - 1]?.value) || 0
      if (prev === 0) return curr > 0 ? 100 : 0
      return Math.round(((curr - prev) / prev) * 1000) / 10
    })

    const trendSummaryText = computed(() => {
      if (trendPercentValue.value > 0) return `+${toKhmerNumeral(trendPercentValue.value)}% ប្រៀបធៀបនឹងឆ្នាំមុន`
      if (trendPercentValue.value < 0) return `${toKhmerNumeral(trendPercentValue.value)}% ប្រៀបធៀបនឹងឆ្នាំមុន`
      return 'មានស្ថិរភាពប្រៀបធៀបនឹងឆ្នាំមុន'
    })

    const trendMetaClass = computed(() => {
      if (trendPercentValue.value > 0) return 'dashboard-quick-card__meta--up'
      if (trendPercentValue.value < 0) return 'dashboard-quick-card__meta--down'
      return 'dashboard-quick-card__meta--neutral'
    })

    return {
      model,
      title,
      staffIncreaseByType,
      filteredTrend,
      filteredStaffTotals,
      filteredGenderRatio,
      filteredEmployeesByDepartment,
      filteredEducationDistribution,
      filteredEmployeesByPosition,
      selectedYear,
      yearOptions,
      quickYearOptions,
      showClearYearButton,
      clearYearFilter,
      setSelectedYear,
      totalStaffFormatted,
      departmentCountFormatted,
      positionCountFormatted,
      femaleSharePercent,
      maleSharePercent,
      selectedYearDisplay,
      trendSummaryText,
      trendMetaClass
    }
  }
}
</script>

<style scoped>
.dashboard-page {
  overflow-x: hidden;
  background: linear-gradient(180deg, #f7fbff 0%, #ffffff 48%, #f8fafc 100%);
}

.dashboard-page__backdrop {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
}

.dashboard-page__orb {
  position: absolute;
  border-radius: 999px;
  opacity: 0.5;
  filter: blur(10px);
  animation: dashboardFloat 16s ease-in-out infinite;
}

.dashboard-page__orb--one {
  top: -8rem;
  right: 8%;
  width: 22rem;
  height: 22rem;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.2), transparent 68%);
}

.dashboard-page__orb--two {
  left: -8rem;
  top: 20rem;
  width: 18rem;
  height: 18rem;
  background: radial-gradient(circle, rgba(16, 185, 129, 0.18), transparent 68%);
  animation-delay: -6s;
}

.dashboard-page__grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(148, 163, 184, 0.12) 1px, transparent 1px),
    linear-gradient(90deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px);
  background-size: 36px 36px;
  mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.14), transparent 78%);
}

.dashboard-page__content {
  z-index: 1;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.dashboard-hero {
  position: relative;
  display: grid;
  grid-template-columns: minmax(0, 1.55fr) minmax(320px, 0.95fr);
  gap: 1.25rem;
  padding: 1.6rem;
  border-radius: 1.75rem;
  border: 1px solid rgba(191, 219, 254, 0.95);
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.97), rgba(239, 246, 255, 0.95) 48%, rgba(236, 253, 245, 0.92));
  box-shadow: 0 24px 48px rgba(148, 163, 184, 0.18);
  overflow: hidden;
}

.dashboard-hero::after {
  content: '';
  position: absolute;
  right: -5rem;
  bottom: -8rem;
  width: 20rem;
  height: 20rem;
  border-radius: 999px;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.18), transparent 70%);
  pointer-events: none;
}

.dashboard-hero__copy,
.dashboard-hero__side {
  position: relative;
  z-index: 1;
}

.dashboard-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.88);
  border: 1px solid rgba(191, 219, 254, 0.95);
  color: #0369a1;
  font-size: 0.74rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
}

.dashboard-hero__title {
  margin-top: 1rem;
  color: #0f172a;
  font-size: clamp(1.65rem, 2.6vw, 2.5rem);
  line-height: 1.18;
}

.dashboard-hero__description {
  margin-top: 0.95rem;
  max-width: 42rem;
  color: #475569;
  font-size: 0.98rem;
  line-height: 1.8;
}

.dashboard-chip-row {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-top: 1.3rem;
}

.dashboard-chip {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.62rem 0.95rem;
  border-radius: 999px;
  border: 1px solid rgba(191, 219, 254, 0.95);
  background: rgba(255, 255, 255, 0.94);
  color: #334155;
  font-size: 0.82rem;
  font-weight: 700;
  box-shadow: 0 10px 24px rgba(148, 163, 184, 0.1);
}

.dashboard-hero__side {
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
}

.dashboard-filter-card {
  padding: 1rem;
  border-radius: 1.4rem;
  border: 1px solid rgba(191, 219, 254, 0.95);
  background: rgba(255, 255, 255, 0.9);
  box-shadow: 0 18px 34px rgba(148, 163, 184, 0.12);
}

.dashboard-filter-card__top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.dashboard-filter-card__label {
  color: #0f172a;
  font-size: 0.88rem;
  font-weight: 700;
}

.dashboard-filter-card__hint {
  margin-top: 0.2rem;
  color: #64748b;
  font-size: 0.8rem;
}

.dashboard-filter-card__actions {
  display: flex;
  align-items: center;
  gap: 0.55rem;
}

.dashboard-filter-card__quick-years {
  margin-top: 0.8rem;
  display: flex;
  gap: 0.45rem;
  flex-wrap: wrap;
}

.dashboard-year-pill {
  border: 1px solid #dbeafe;
  background: #ffffff;
  color: #334155;
  border-radius: 999px;
  padding: 0.28rem 0.7rem;
  font-size: 0.76rem;
  line-height: 1.2;
  transition: all 0.2s ease;
}

.dashboard-year-pill:hover {
  border-color: #93c5fd;
  color: #0c4a6e;
}

.dashboard-year-pill--active {
  border-color: #2563eb;
  background: #2563eb;
  color: #ffffff;
}

.dashboard-quick-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0.9rem;
}

.dashboard-quick-card {
  min-height: 7rem;
  padding: 1rem;
  border-radius: 1.35rem;
  border: 1px solid rgba(226, 232, 240, 0.95);
  background: rgba(248, 250, 252, 0.86);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
}

.dashboard-quick-card:hover {
  transform: translateY(-4px);
  border-color: #bfdbfe;
  box-shadow: 0 18px 32px rgba(148, 163, 184, 0.16);
}

.dashboard-quick-card__label {
  color: #64748b;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.dashboard-quick-card__value {
  display: block;
  margin-top: 0.55rem;
  color: #0f172a;
  font-size: clamp(1.35rem, 2vw, 1.8rem);
  line-height: 1.1;
}

.dashboard-quick-card__meta {
  margin-top: 0.75rem;
  color: #64748b;
  font-size: 0.82rem;
  font-weight: 600;
}

.dashboard-quick-card__meta--up {
  color: #0f766e;
}

.dashboard-quick-card__meta--down {
  color: #dc2626;
}

.dashboard-quick-card__meta--neutral {
  color: #64748b;
}

.dashboard-panel-shell {
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
}

.dashboard-panel-shell__header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
}

.dashboard-panel-shell__title {
  color: #0f172a;
  font-size: clamp(1.22rem, 2vw, 1.55rem);
  font-weight: 400;
  text-align: left;
  line-height: 1.2;
}

.dashboard-panel-shell__description {
  margin-top: 0.32rem;
  color: #64748b;
  font-size: 0.9rem;
  line-height: 1.6;
}

.dashboard-filter-card :deep(.dashboard-year-select) {
  width: 132px !important;
  min-width: 132px !important;
}

.dashboard-filter-card :deep(.dashboard-year-select .n-base-selection) {
  min-height: 40px;
  border-radius: 14px;
  border: 1px solid #dbeafe;
  background: #ffffff;
  box-shadow: none;
}

.dashboard-filter-card :deep(.dashboard-year-select .n-base-selection:hover) {
  border-color: #93c5fd;
}

.dashboard-filter-card :deep(.n-button) {
  border-radius: 14px;
  padding-inline: 0.85rem;
  height: 40px;
  font-weight: 600;
}

:deep(.dashboard-card) {
  border-radius: 1.5rem !important;
  border: 1px solid #dbe7f3 !important;
  background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%) !important;
  box-shadow: 0 18px 34px rgba(148, 163, 184, 0.12) !important;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  overflow: hidden;
}

:deep(.dashboard-card:hover) {
  transform: translateY(-4px);
  border-color: #bfdbfe !important;
  box-shadow: 0 22px 40px rgba(148, 163, 184, 0.16) !important;
}

:deep(.dashboard-card--hero) {
  background: linear-gradient(180deg, #ffffff 0%, #f3f8ff 100%) !important;
}

:deep(.dashboard-card--compact) {
  background: linear-gradient(180deg, #ffffff 0%, #f3fffb 100%) !important;
}

:deep(.dashboard-card--stat),
:deep(.dashboard-card--wide) {
  background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%) !important;
}

:deep(.dashboard-card .border-b) {
  border-color: #eef2ff !important;
}

:deep(.dashboard-card .text-gray-800) {
  color: #0f172a !important;
}

:deep(.dashboard-card .text-gray-700) {
  color: #334155 !important;
}

:deep(.dashboard-card .text-gray-500),
:deep(.dashboard-card .text-gray-400) {
  color: #64748b !important;
}

.dashboard-reveal {
  opacity: 0;
  transform: translateY(22px) scale(0.985);
  animation: dashboardReveal 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
  will-change: transform, opacity;
}

.dashboard-delay-1 { animation-delay: 0.08s; }
.dashboard-delay-2 { animation-delay: 0.14s; }
.dashboard-delay-3 { animation-delay: 0.2s; }
.dashboard-delay-4 { animation-delay: 0.26s; }
.dashboard-delay-5 { animation-delay: 0.32s; }
.dashboard-delay-6 { animation-delay: 0.38s; }

.system-layout {
  margin-left: 60px;
}

.app_snav_open .system-layout {
  margin-left: 230px;
}

@media (max-width: 1023px) {
  .dashboard-page__content {
    padding: 1rem;
  }

  .dashboard-hero {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 767px) {
  .dashboard-page__content {
    gap: 1rem;
  }

  .dashboard-hero {
    padding: 1.15rem;
    border-radius: 1.45rem;
  }

  .dashboard-filter-card__top {
    flex-direction: column;
    align-items: flex-start;
  }

  .dashboard-filter-card__actions {
    width: 100%;
    flex-wrap: wrap;
  }

  .dashboard-filter-card :deep(.dashboard-year-select) {
    width: 100% !important;
    min-width: 0 !important;
  }

  .dashboard-quick-grid {
    grid-template-columns: 1fr;
  }

  .dashboard-chip {
    width: 100%;
    justify-content: flex-start;
  }

  .system-layout,
  .app_snav_open .system-layout {
    margin-left: 0;
  }
}

@keyframes dashboardReveal {
  from {
    opacity: 0;
    transform: translateY(22px) scale(0.985);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes dashboardFloat {
  0%, 100% {
    transform: translate3d(0, 0, 0) scale(1);
  }
  50% {
    transform: translate3d(0, 18px, 0) scale(1.03);
  }
}
</style>
