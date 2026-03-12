/**
 * Mock data for the dashboard (staff totals, charts).
 * Replace with API calls when backend is ready.
 */

export const staffTotalsMock = {
  political: 120,
  publicService: 2400,
  contract: 300,
  agreement: 129
}

export const staffIncreaseByTypeMock = {
  political: 5.2,
  publicService: 12.3,
  contract: -2.1,
  agreement: 8.0
}

export const educationDistributionMock = [
  { label: 'បឋមភូមិ', value: 200 },
  { label: 'ទុតិយភូមិ', value: 400 },
  { label: 'បរិញ្ញាបត្ររង', value: 600 },
  { label: 'បរិញ្ញាបត្រ', value: 1200 },
  { label: 'បរិញ្ញាបត្រជាន់ខ្ពស់', value: 500 },
  { label: 'បណ្ឌិត', value: 49 }
]

export const genderRatioMock = {
  male: 1700,
  female: 1249
}

/** Total employees by department: [{ department: string, total: number, malePercent: number, femalePercent: number }] */
export const employeesByDepartmentMock = [
  { department: 'ខុទ្ទកាល័យសម្តេចមហាបវរធិបតីនាយករដ្ឋមន្រ្តី', total: 900, malePercent: 55, femalePercent: 45 },
  { department: 'ខុទ្ទកាល័យសម្តេចនាយករដ្ឋមន្រ្តី', total: 700, malePercent: 56, femalePercent: 44 },
  { department: 'ទីស្ដីការគណៈរដ្ឋមន្ត្រី', total: 800, malePercent: 58, femalePercent: 42 },
  { department: 'ទីប្រឹក្សារាជរដ្ឋាភិបាល ទីប្រឹក្សានិងជំនួយការនាយករដ្ឋមន្ត្រី', total: 549, malePercent: 42, femalePercent: 58 }
]

/** Total employees per position for donut chart: [{ label: string, value: number }] */
export const employeesByPositionMock = [
  { label: 'អនុមន្ត្រី', value: 420 },
  { label: 'វរមន្ត្រី', value: 380 },
  { label: 'ឧត្តមន្ត្រី', value: 280 },
  { label: 'ក្រមការ', value: 750 },
  { label: 'ក្រមការដើមខ្សែ', value: 520 },
  { label: 'នាយក្រមការ', value: 310 },
  { label: 'មន្ត្រីលេខាធិការរដ្ឋបាល', value: 289 }
]

/** Total employee count by year for the trend line chart [{ year: number, value: number }] */
export const totalEmployeeTrendMock = [
  { year: 2019, value: 2300 },
  { year: 2020, value: 2200 },
  { year: 2021, value: 2600 },
  { year: 2022, value: 2450 },
  { year: 2023, value: 2949 },
  { year: 2024, value: 3020 },
  { year: 2025, value: 3080 },
  { year: 2026, value: 3150 }
]

/** Single object with all dashboard mock data */
export const dashboardMock = {
  staffTotals: staffTotalsMock,
  staffIncreaseByType: staffIncreaseByTypeMock,
  educationDistribution: educationDistributionMock,
  genderRatio: genderRatioMock
}

export default dashboardMock
