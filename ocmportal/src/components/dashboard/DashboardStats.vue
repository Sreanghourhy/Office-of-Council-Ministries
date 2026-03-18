<template>
  <div class="dashboard-stats dashboard-stats-shell grid grid-cols-1 gap-4 lg:grid-cols-4 xl:grid-cols-5 min-w-0">
    <div class="lg:col-span-3 xl:col-span-4 min-w-0 h-full">
      <DashboardTotalEmployeeChart
        class="dashboard-card dashboard-card--hero dashboard-reveal dashboard-delay-1"
        :total-count="totalForChart"
        :trend="trend"
      />
    </div>
    <div class="lg:col-span-1 xl:col-span-1 min-w-0 h-full">
      <DashboardPieChart
        class="dashboard-card dashboard-card--compact dashboard-reveal dashboard-delay-2 w-full h-full"
        :gender-ratio="genderRatio"
      />
    </div>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:col-span-4 xl:col-span-5 min-w-0">
      <DashboardStatCard
        class="dashboard-card dashboard-card--stat dashboard-reveal dashboard-delay-3"
        :title="cardLabels.political"
        :value="totals.political"
        icon="people"
        icon-color="blue"
        :trend-percent="increaseByType.political"
        :trend-label="periodLabel"
      />
      <DashboardStatCard
        class="dashboard-card dashboard-card--stat dashboard-reveal dashboard-delay-4"
        :title="cardLabels.publicService"
        :value="totals.publicService"
        icon="people"
        icon-color="emerald"
        :trend-percent="increaseByType.publicService"
        :trend-label="periodLabel"
      />
      <DashboardStatCard
        class="dashboard-card dashboard-card--stat dashboard-reveal dashboard-delay-5"
        :title="cardLabels.contract"
        :value="totals.contract"
        icon="people"
        icon-color="amber"
        :trend-percent="increaseByType.contract"
        :trend-label="periodLabel"
      />
      <DashboardStatCard
        class="dashboard-card dashboard-card--stat dashboard-reveal dashboard-delay-6"
        :title="cardLabels.agreement"
        :value="totals.agreement"
        icon="people"
        icon-color="violet"
        :trend-percent="increaseByType.agreement"
        :trend-label="periodLabel"
      />
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'
import DashboardStatCard from './DashboardStatCard.vue'
import DashboardTotalEmployeeChart from './DashboardTotalEmployeeChart.vue'
import DashboardPieChart from './DashboardPieChart.vue'

export default {
  name: 'DashboardStats',
  components: {
    DashboardStatCard,
    DashboardTotalEmployeeChart,
    DashboardPieChart
  },
  props: {
    genderRatio: {
      type: Object,
      default: () => ({ male: 0, female: 0 })
    },
    totals: {
      type: Object,
      default: () => ({
        political: 0,
        publicService: 0,
        contract: 0,
        agreement: 0
      })
    },
    increaseByType: {
      type: Object,
      default: () => ({
        political: 0,
        publicService: 0,
        contract: 0,
        agreement: 0
      })
    },
    trend: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const periodLabel = 'ឆ្នាំមុន'

    const totalEmployees = computed(() => {
      const t = props.totals
      return (Number(t.political) || 0) + (Number(t.publicService) || 0) + (Number(t.contract) || 0) + (Number(t.agreement) || 0)
    })
    const totalForChart = computed(() => {
      const trend = props.trend || []
      if (trend.length) return Number(trend[trend.length - 1]?.value) || totalEmployees.value
      return totalEmployees.value
    })

    const cardLabels = {
      political: 'មន្ត្រីនយោបាយ',
      publicService: 'មន្ត្រីមុខងារសាធារណៈ',
      contract: 'មន្ត្រីជាប់កិច្ចសន្យា',
      agreement: 'មន្ត្រីផ្អែកលើកិច្ចព្រមព្រៀងការងារ'
    }

    return {
      periodLabel,
      totalEmployees,
      totalForChart,
      cardLabels
    }
  }
}
</script>
