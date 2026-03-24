<template>
  <div class="thumbnail-page">
    <section class="hero-shell">
      <div class="hero-copy">
        <span class="hero-mark"></span>
        <div>
          <p class="hero-kicker">Card Directory</p>
          <h1 class="hero-title">{{ model.title }}</h1>
        </div>
      </div>

      <div class="hero-actions">
        <button type="button" class="hero-button hero-button-secondary" @click="tableView()">Table View</button>
        <button
          v-if="$hasPermission('portal_staff_creating')"
          type="button"
          class="hero-button hero-button-primary"
          @click="showCreateModal()"
        >
          Add Officer
        </button>
        <button
          v-if="$hasPermission('portal_staff_creating')"
          type="button"
          class="hero-button hero-button-ghost"
          @click="showCreateNonOfficerModal()"
        >
          Add Non-Officer
        </button>
      </div>
    </section>

    <div class="stats-grid">
      <div
        v-for="(tab, index) in summaryTabs"
        :key="tab.label"
        class="stat-card"
        :class="{ 'stat-card-active': index === 0 }"
      >
        <span class="stat-label">{{ tab.label }}</span>
        <strong class="stat-value">{{ $toKhmer(tab.value) }}</strong>
      </div>
    </div>

    <section class="card-shell">
      <div class="toolbar">
        <div class="search-shell">
          <input
            v-model="table.search"
            type="text"
            class="search-input"
            placeholder="Search for staff"
            @keyup.enter="filterRecords(false)"
          />
        </div>

        <div class="toolbar-actions">
          <n-popselect
            trigger="click"
            v-model:value="table.pagination.perPage"
            :options="perPageOptions"
            size="small"
            scrollable
            @update:value="goTo(1)"
          >
            <button type="button" class="toolbar-chip">
              {{ $toKhmer(table.pagination.perPage) }} / page
            </button>
          </n-popselect>

          <button
            type="button"
            class="toolbar-chip"
            :class="{ 'toolbar-chip-active': filter || activeFilterCount > 0 }"
            @click="toggleFilter()"
          >
            Filters
            <span class="toolbar-chip-count">{{ $toKhmer(activeFilterCount) }}</span>
          </button>
        </div>
      </div>

      <Transition name="slide-fade">
        <div v-if="filter" class="filter-row">
          <div class="filter-item">
            <label class="filter-label">Positions</label>
            <n-select
              v-model:value="selectedPositions"
              filterable
              clearable
              multiple
              placeholder="Choose positions"
              :options="optionPositions"
              @update:value="filterRecords(false)"
            />
          </div>
          <div class="filter-item">
            <label class="filter-label">Organizations</label>
            <n-select
              v-model:value="selectedOrganizations"
              filterable
              clearable
              multiple
              placeholder="Choose organizations"
              :options="optionOrganizations"
              @update:value="filterRecords(false)"
            />
          </div>
          <button type="button" class="filter-reset" @click="resetFilters()">Clear</button>
        </div>
      </Transition>

      <div class="toolbar-meta">
        <span>Showing {{ $toKhmer(Array.isArray(table.records.matched) ? table.records.matched.length : 0) }} of {{ $toKhmer(table.pagination.totalRecords || 0) }} records</span>
        <span>Page {{ $toKhmer(table.pagination.page || 1) }} / {{ $toKhmer(table.pagination.totalPages || 1) }}</span>
      </div>

      <Transition name="fade">
        <div v-if="hasRecords" class="vcb-thumbnail thumbnail-grid">
          <article
            v-for="(record, index) in table.records.matched"
            :key="record != null && record.id != null ? record.id : index"
            class="thumb-card"
          >
            <div class="thumb-head">
              <span class="thumb-index">#{{ $toKhmer(((table.pagination.page - 1) * table.pagination.perPage) + (index + 1)) }}</span>
              <span class="thumb-badge" :class="{ 'thumb-badge-card': hasCard(record) }">
                {{ hasCard(record) ? $toKhmer(record.card.number) : `Code ${$toKhmer(getOfficerCode(record))}` }}
              </span>
            </div>

            <div class="thumb-identity">
              <div class="thumb-avatar-wrap">
                <div class="thumb-avatar">
                  <img
                    :src="getAvatarUrl(record)"
                    :alt="getKhmerName(record)"
                    class="thumb-avatar-image"
                    :class="{ 'thumb-avatar-image-default': !hasAvatar(record) }"
                    @error="setFallbackAvatar"
                  />
                </div>
                <span v-if="hasCurrentJob(record)" class="thumb-active-dot"></span>
              </div>

              <div class="thumb-main">
                <div class="thumb-name-block">
                  <div v-if="record?.countesy?.name" class="thumb-countesy">{{ record.countesy.name }}</div>
                  <h3 class="thumb-name">{{ getKhmerName(record) }}</h3>
                  <p class="thumb-subtitle">{{ getEnglishName(record) }}</p>
                </div>

                <div class="thumb-rank-row">
                  <span class="rank-pill">{{ getRankName(record) }}</span>
                </div>
              </div>
            </div>

            <div class="thumb-detail-grid">
              <div class="thumb-detail">
                <span class="thumb-detail-label">National ID</span>
                <strong class="thumb-detail-value">{{ $toKhmer(getNationalId(record)) }}</strong>
              </div>
              <div class="thumb-detail">
                <span class="thumb-detail-label">Official Date</span>
                <strong class="thumb-detail-value">{{ $toKhmer(formatDateLabel(record?.official_date)) }}</strong>
              </div>
              <div class="thumb-detail thumb-detail-wide">
                <span class="thumb-detail-label">Position</span>
                <strong class="thumb-detail-value">{{ getPositionName(record) }}</strong>
              </div>
              <div class="thumb-detail thumb-detail-wide">
                <span class="thumb-detail-label">Organization</span>
                <strong class="thumb-detail-value">{{ getOrganizationName(record) }}</strong>
              </div>
            </div>

            <thumbnail-actions-form v-bind:model="model" v-bind:record="record" :onClose="closeActions" />
          </article>
        </div>
      </Transition>

      <Transition name="fade">
        <div v-if="!table.loading && !hasRecords" class="empty-state">
          <h3>No staff cards found</h3>
          <p>Try a different search term or adjust the active filters.</p>
        </div>
      </Transition>

      <Transition name="slide-fade">
        <div v-if="table.loading" class="loading-shell">
          <div class="loading-card">
            <div class="loading-spinner"></div>
            <p>Loading staff cards...</p>
          </div>
          <button type="button" class="loading-close" @click="closeTableLoading">Close</button>
        </div>
      </Transition>

      <div v-if="table.pagination.totalPages > 1" class="footer-bar">
        <button type="button" class="footer-nav" :disabled="table.pagination.page <= 1" @click="previous()">Previous</button>

        <div class="footer-center">
          <span class="footer-summary">{{ $toKhmer(table.pagination.totalRecords) }} records</span>
          <div class="footer-pages">
            <button
              v-for="(page, index) in table.pagination.buttons"
              :key="index"
              type="button"
              class="footer-page"
              :class="{ 'footer-page-active': table.pagination.page == page }"
              @click="table.pagination.page == page ? false : goTo(page)"
            >
              {{ $toKhmer(page) }}
            </button>
          </div>
        </div>

        <button
          type="button"
          class="footer-nav"
          :disabled="table.pagination.page >= table.pagination.totalPages"
          @click="next()"
        >
          Next
        </button>
      </div>
    </section>

    <create-form v-if="createModal.show" v-bind:model="model" v-bind:show="createModal.show" :onClose="closeCreateModal" />
    <create-non-officer-form
      v-if="createNonOfficerModal.show"
      v-bind:model="model"
      v-bind:show="createNonOfficerModal.show"
      :onClose="closeCreateNonOfficerModal"
    />
  </div>
</template>

<script>
import { reactive, ref, computed, onMounted, onBeforeUnmount, defineAsyncComponent } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useNotification } from 'naive-ui'
import dateFormat from 'dateformat'

import defaultOfficerAvatar from './../../../assets/logo copy.png'
import ThumbnailActionsForm from './actions/thumbnail-action.vue'

const CreateForm = defineAsyncComponent(() => import('./../widgets/create.vue'))
const CreateNonOfficerForm = defineAsyncComponent(() => import('./../widgets/createnonofficer.vue'))

export default {
  name: 'People',
  components: {
    CreateForm,
    CreateNonOfficerForm,
    ThumbnailActionsForm
  },
  setup() {
    const store = useStore()
    const route = useRoute()
    const notify = useNotification()
    const router = useRouter()

    const peopleIds = ref(
      typeof route.params.ids === 'string' && route.params.ids.trim().length > 0
        ? route.params.ids.split(',')
        : null
    )

    const model = reactive({
      name: 'officer',
      module: 'officers',
      title: 'មន្ត្រីរាជការមុខងារសាធារណៈ'
    })

    const table = reactive({
      loading: false,
      search: '',
      records: {
        all: [],
        matched: []
      },
      pagination: {
        perPage: 20,
        page: 1,
        totalPages: 0,
        totalRecords: 0,
        start: 0,
        end: 0,
        buttons: []
      }
    })

    const perPageOptions = [5, 10, 20, 30, 40, 50, 100, 200, 500].map((value) => ({
      label: value,
      value
    }))

    const avatarRefreshKey = ref(Date.now())
    const selectedPositions = ref([])
    const selectedOrganizations = ref([])
    const filter = ref(false)
    let filterTimeout = null

    function countSelectedEntries(values) {
      return Array.isArray(values)
        ? values.filter((value) => value !== null && value !== undefined && `${value}`.trim() !== '').length
        : 0
    }

    const hasRecords = computed(() => Array.isArray(table.records.matched) && table.records.matched.length > 0)

    const activeFilterCount = computed(() => {
      return countSelectedEntries(selectedPositions.value) + countSelectedEntries(selectedOrganizations.value)
    })

    const summaryTabs = computed(() => {
      return [
        { label: 'All Staff', value: table.pagination.totalRecords || 0 },
        { label: 'Showing', value: Array.isArray(table.records.matched) ? table.records.matched.length : 0 },
        { label: 'Positions', value: countSelectedEntries(selectedPositions.value) },
        { label: 'Organizations', value: countSelectedEntries(selectedOrganizations.value) }
      ]
    })

    const optionPositions = computed(() => {
      let positions =
        Array.isArray(store.getters['position/getRecords']) && store.getters['position/getRecords'].length > 0
          ? store.getters['position/getRecords']
          : []
      positions = positions.map((position) => {
        return { label: position.name, value: position.id }
      })
      return positions
    })

    const optionOrganizations = computed(() => {
      let organizations =
        Array.isArray(store.getters['organization/getRecords']) && store.getters['organization/getRecords'].length > 0
          ? store.getters['organization/getRecords']
          : []
      organizations = organizations.map((organization) => {
        return { label: organization.name, value: organization.id }
      })
      return organizations
    })

    function normalizeText(value, fallback = '--') {
      if (value === null || value === undefined) {
        return fallback
      }

      const text = `${value}`.trim()
      return text.length > 0 ? text : fallback
    }

    function getKhmerName(record) {
      const parts = [record?.countesy?.name, record?.people?.lastname, record?.people?.firstname].filter(
        (value) => typeof value === 'string' && value.trim().length > 0
      )
      return parts.length > 0 ? parts.join(' ') : '--'
    }

    function getEnglishName(record) {
      const parts = [record?.people?.enlastname, record?.people?.enfirstname].filter(
        (value) => typeof value === 'string' && value.trim().length > 0
      )
      return parts.length > 0 ? parts.join(' ') : '--'
    }

    function getOfficerCode(record) {
      return normalizeText(record?.code)
    }

    function getNationalId(record) {
      return normalizeText(record?.people?.nid)
    }

    function getRankName(record) {
      return normalizeText(record?.rank?.name)
    }

    function getOrganizationName(record) {
      return normalizeText(record?.current_job?.organization_structure_position?.organization_structure?.organization?.name)
    }

    function getPositionName(record) {
      return normalizeText(record?.current_job?.organization_structure_position?.position?.name)
    }

    function formatDateLabel(value) {
      if (!value) {
        return '--'
      }

      const parsedDate = new Date(value)
      if (Number.isNaN(parsedDate.getTime())) {
        return '--'
      }

      return dateFormat(parsedDate, 'dd-mm-yyyy')
    }

    function resolveAvatarUrl(record) {
      const candidates = [record?.image, record?.avatar_url, record?.people?.avatar_url, record?.user?.avatar_url]
      return candidates.find((value) => typeof value === 'string' && value.trim().length > 0) || null
    }

    function withAvatarVersion(url, record) {
      if (typeof url !== 'string' || url.trim().length <= 0 || url.startsWith('data:')) {
        return url
      }
      const version =
        record?.updated_at || record?.user?.updated_at || record?.people?.updated_at || avatarRefreshKey.value
      const separator = url.includes('?') ? '&' : '?'
      return `${url}${separator}v=${encodeURIComponent(version)}`
    }

    function hasAvatar(record) {
      const avatarUrl = resolveAvatarUrl(record)
      return typeof avatarUrl === 'string' && avatarUrl.trim().length > 0
    }

    function getAvatarUrl(record) {
      return hasAvatar(record)
        ? withAvatarVersion(resolveAvatarUrl(record).trim(), record)
        : defaultOfficerAvatar
    }

    function setFallbackAvatar(event) {
      if (event?.target) {
        event.target.onerror = null
        event.target.src = defaultOfficerAvatar
        event.target.classList.add('thumb-avatar-image-default')
      }
    }

    function hasCurrentJob(record) {
      return record?.current_job !== null && record?.current_job !== undefined
    }

    function hasCard(record) {
      return record?.card !== null && record?.card !== undefined && record?.card?.id > 0
    }

    function buildPaginationButtons() {
      const paginationNumberList = 10
      if ((table.pagination.page - (parseInt(paginationNumberList / 2, 10) + 1)) < 1) {
        table.pagination.start = 1
        table.pagination.end =
          table.pagination.totalPages > paginationNumberList ? paginationNumberList : table.pagination.totalPages
      } else {
        table.pagination.start = table.pagination.page - parseInt(paginationNumberList / 2, 10)
        table.pagination.end =
          table.pagination.page >= table.pagination.totalPages
            ? table.pagination.totalPages
            : table.pagination.page + parseInt(paginationNumberList / 2, 10)
      }

      table.pagination.buttons = []
      for (let i = table.pagination.start; i <= table.pagination.end; i += 1) {
        if (i <= table.pagination.totalPages) {
          table.pagination.buttons.push(i)
        }
      }
    }

    function getRecords() {
      table.loading = true
      store
        .dispatch(model.name + '/list', {
          search: table.search,
          perPage: table.pagination.perPage,
          page: table.pagination.page,
          positions: selectedPositions.value,
          organizations: selectedOrganizations.value,
          ids: peopleIds.value
        })
        .then((res) => {
          table.records.all = table.records.matched = res.data.records
          table.pagination = { ...table.pagination, ...res.data.pagination }
          buildPaginationButtons()
          closeTableLoading()
        })
        .catch((err) => {
          notify.error({
            title: 'Load Staff',
            description: 'There was a problem while loading staff cards.'
          })
          table.loading = false
          console.log(err)
        })
    }

    function filterRecords(helper = true) {
      if (helper) {
        table.records.matched = []
        if (table.search !== '') {
          for (const index in table.records.all) {
            for (const field in table.records.all[index]) {
              if ((`${table.records.all[index][field]}`).includes(table.search) !== false) {
                table.records.matched.push(table.records.all[index])
                break
              }
            }
          }
        }

        if (table.records.matched.length <= 0) {
          table.records.matched = table.records.all
        }
        return
      }

      if (filterTimeout) {
        window.clearTimeout(filterTimeout)
      }

      filterTimeout = window.setTimeout(() => {
        table.pagination.page = 1
        getRecords()
      }, 300)
    }

    function closeTableLoading() {
      table.loading = false
    }

    function maxPage() {
      return table.pagination.totalPages > 0 ? table.pagination.totalPages : 1
    }

    function previous() {
      goTo(table.pagination.page <= 1 ? 1 : table.pagination.page - 1)
    }

    function next() {
      goTo(table.pagination.page >= maxPage() ? maxPage() : table.pagination.page + 1)
    }

    function goTo(page) {
      table.pagination.page = page > maxPage() ? maxPage() : page < 1 ? 1 : page
      getRecords()
    }

    const createModal = reactive({ show: false })

    function showCreateModal() {
      ensureCreateLookups()
      createModal.show = true
    }

    function closeCreateModal(actionStatus) {
      createModal.show = false
      if (parseInt(actionStatus, 10) > 0) {
        getRecords()
      }
    }

    const createNonOfficerModal = reactive({ show: false })

    function showCreateNonOfficerModal() {
      ensureCreateLookups()
      createNonOfficerModal.show = true
    }

    function closeCreateNonOfficerModal(actionStatus) {
      createNonOfficerModal.show = false
      if (parseInt(actionStatus, 10) > 0) {
        getRecords()
      }
    }

    function closeActions(actionStatus) {
      if (parseInt(actionStatus, 10) > 0) {
        avatarRefreshKey.value = Date.now()
        getRecords()
      }
    }

    function ensureFilterLookups() {
      if (!Array.isArray(store.getters['position/getRecords']) || store.getters['position/getRecords'].length <= 0) {
        getPositions()
      }

      if (
        !Array.isArray(store.getters['organization/getRecords']) ||
        store.getters['organization/getRecords'].length <= 0
      ) {
        getOrganizations()
      }
    }

    function ensureCreateLookups() {
      ensureFilterLookups()
      if (!Array.isArray(store.getters['countesy/getRecords']) || store.getters['countesy/getRecords'].length <= 0) {
        getCountesies()
      }
      getRankStructure()
      getPdcv()
    }

    function getPositions() {
      store
        .dispatch('position/structurePosition', {
          page: 1,
          perPage: 1000,
          search: ''
        })
        .then((res) => {
          store.commit('position/setRecords', res.data.records)
        })
        .catch((err) => {
          notify.error({
            title: 'Load Positions',
            description: 'There was a problem while loading positions.'
          })
          console.log(err)
        })
    }

    function getOrganizations() {
      store
        .dispatch('organization/organizationStructure', {
          page: 1,
          perPage: 1000,
          search: '',
          id: 0
        })
        .then((res) => {
          store.commit('organization/setRecords', res.data.records)
        })
        .catch((err) => {
          notify.error({
            title: 'Load Organizations',
            description: 'There was a problem while loading organizations.'
          })
          console.log(err)
        })
    }

    function getCountesies() {
      store
        .dispatch('countesy/list', {
          page: 1,
          perPage: 1000,
          search: ''
        })
        .then((res) => {
          store.commit('countesy/setRecords', res.data.records)
        })
        .catch((err) => {
          notify.error({
            title: 'Load Courtesy Titles',
            description: 'There was a problem while loading courtesy titles.'
          })
          console.log(err)
        })
    }

    function closeFilter() {
      filter.value = false
    }

    function openFilter() {
      filter.value = true
      ensureFilterLookups()
    }

    function toggleFilter() {
      filter.value ? closeFilter() : openFilter()
    }

    function resetFilters() {
      selectedPositions.value = []
      selectedOrganizations.value = []
      table.pagination.page = 1
      getRecords()
    }

    function handleKeydown(event) {
      if (event.key === 'Escape') {
        closeFilter()
      }
    }

    function getRankStructure() {
      if (store.getters['rank/records'].all.length <= 0) {
        store
          .dispatch('rank/structure')
          .then((res) => {
            if (res.data.ok) {
              store.commit('rank/setAllRecords', res.data.records)
            } else {
              notify.info({
                title: 'Load Ranks',
                description: res.data.message
              })
            }
          })
          .catch((err) => {
            console.log(err)
          })
      }
    }

    function getPdcv() {
      if (store.getters['province/records'].all.length <= 0) {
        store
          .dispatch('province/pdcv')
          .then((res) => {
            store.commit('province/setAllRecords', res.data.provinces)
            store.commit('district/setAllRecords', res.data.districts)
            store.commit('commune/setAllRecords', res.data.communes)
            store.commit('village/setAllRecords', res.data.villages)
          })
          .catch((err) => {
            console.log(err)
          })
      }
    }

    function tableView() {
      router.push('/hr/officer/table')
    }

    onMounted(() => {
      window.addEventListener('keydown', handleKeydown)
    })

    onBeforeUnmount(() => {
      window.removeEventListener('keydown', handleKeydown)
      if (filterTimeout) {
        window.clearTimeout(filterTimeout)
      }
    })

    getRecords()

    return {
      model,
      table,
      perPageOptions,
      hasRecords,
      activeFilterCount,
      summaryTabs,
      filterRecords,
      goTo,
      previous,
      next,
      closeTableLoading,
      createModal,
      showCreateModal,
      closeCreateModal,
      createNonOfficerModal,
      showCreateNonOfficerModal,
      closeCreateNonOfficerModal,
      closeActions,
      resetFilters,
      toggleFilter,
      filter,
      optionPositions,
      selectedPositions,
      optionOrganizations,
      selectedOrganizations,
      tableView,
      getKhmerName,
      getEnglishName,
      getOfficerCode,
      getNationalId,
      getRankName,
      getOrganizationName,
      getPositionName,
      formatDateLabel,
      hasAvatar,
      getAvatarUrl,
      setFallbackAvatar,
      hasCurrentJob,
      hasCard
    }
  }
}
</script>

<style type="text/css" scoped>
.thumbnail-page {
  width: 100%;
  padding: 24px;
}

.hero-shell,
.card-shell {
  border: 1px solid #dbe4f0;
  border-radius: 32px;
  background: #ffffff;
  box-shadow: 0 24px 54px rgba(15, 23, 42, 0.07);
}

.hero-shell {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 24px;
  padding: 28px 32px;
  background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 55%, #eef6ff 100%);
}

.hero-copy {
  display: flex;
  align-items: center;
  gap: 16px;
}

.hero-mark {
  width: 6px;
  height: 52px;
  border-radius: 999px;
  background: linear-gradient(180deg, #2563eb 0%, #38bdf8 100%);
}

.hero-kicker {
  margin: 0 0 6px;
  color: #2563eb;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
}

.hero-title {
  margin: 0;
  color: #0f172a;
  font-size: 34px;
  line-height: 1.35;
  font-weight: 650;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.hero-actions,
.toolbar-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.hero-button,
.toolbar-chip,
.filter-reset,
.footer-nav,
.footer-page,
.loading-close {
  border: 1px solid #dbe4f0;
  cursor: pointer;
  transition: 0.2s ease;
  font-family: "Segoe UI", Arial, sans-serif;
}

.hero-button {
  min-height: 44px;
  padding: 0 18px;
  border-radius: 16px;
  font-size: 13px;
  font-weight: 700;
  background: #ffffff;
}

.hero-button-secondary:hover,
.toolbar-chip:hover,
.filter-reset:hover,
.footer-nav:hover:not(:disabled),
.footer-page:hover {
  border-color: #93c5fd;
  color: #1d4ed8;
}

.hero-button-primary {
  color: #ffffff;
  border-color: transparent;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
}

.hero-button-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 18px 32px rgba(37, 99, 235, 0.28);
}

.hero-button-ghost {
  color: #0f766e;
  border-color: #99f6e4;
  background: #f0fdfa;
}

.hero-button-ghost:hover {
  border-color: #5eead4;
}

.stats-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin: 22px 0 18px;
}

.stat-card {
  min-width: 150px;
  padding: 14px 18px;
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.88);
  box-shadow: 0 14px 30px rgba(15, 23, 42, 0.05);
}

.stat-card-active {
  border-color: #bfdbfe;
  background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.stat-label {
  display: block;
  color: #64748b;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
}

.stat-value {
  display: block;
  margin-top: 8px;
  color: #0f172a;
  font-size: 24px;
  line-height: 1;
  font-weight: 700;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.card-shell {
  position: relative;
  padding: 24px;
}

.toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.search-shell {
  flex: 1 1 420px;
}

.search-input {
  width: 100%;
  height: 48px;
  padding: 0 18px;
  border: 1px solid #dbe4f0;
  border-radius: 16px;
  background: #f8fafc;
  color: #0f172a;
  font-size: 13px;
  font-family: "Segoe UI", Arial, sans-serif;
}

.search-input:focus {
  outline: none;
  border-color: #93c5fd;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
}

.toolbar-chip,
.filter-reset,
.footer-nav {
  min-height: 44px;
  padding: 0 16px;
  border-radius: 16px;
  background: #ffffff;
  color: #334155;
  font-size: 13px;
  font-weight: 700;
}

.toolbar-chip-active {
  color: #1d4ed8;
  border-color: #93c5fd;
  background: #eff6ff;
}

.toolbar-chip-count {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 22px;
  height: 22px;
  margin-left: 8px;
  padding: 0 6px;
  border-radius: 999px;
  background: #dbeafe;
  color: #1d4ed8;
  font-size: 11px;
}

.filter-row {
  display: flex;
  align-items: flex-end;
  gap: 14px;
  margin: 16px 0 20px;
  padding: 16px;
  border: 1px solid #dbe4f0;
  border-radius: 20px;
  background: #f8fbff;
}

.filter-item {
  flex: 1 1 0;
  min-width: 0;
}

.filter-label,
.thumb-detail-label {
  display: block;
  margin-bottom: 8px;
  color: #64748b;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
}

.filter-row :deep(.n-base-selection) {
  min-height: 46px;
  border-radius: 14px;
  background: #ffffff;
}

.toolbar-meta {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 10px;
  margin: 14px 0 18px;
  color: #64748b;
  font-size: 12px;
  font-family: "Segoe UI", Arial, sans-serif;
}

.thumbnail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(360px, 420px));
  justify-content: center;
  gap: 22px;
}

.thumb-card {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 18px;
  min-height: 100%;
  padding: 22px;
  border: 1px solid #e2e8f0;
  border-radius: 30px;
  background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
  box-shadow: 0 22px 42px rgba(15, 23, 42, 0.07);
  transition: 0.25s ease;
}

.thumb-card:hover {
  transform: translateY(-4px);
  border-color: #bfdbfe;
  box-shadow: 0 28px 50px rgba(37, 99, 235, 0.14);
}

.thumb-head,
.thumb-rank-row {
  display: flex;
  align-items: center;
  gap: 12px;
}

.thumb-head {
  flex-wrap: wrap;
  justify-content: flex-start;
  padding-right: 110px;
}

.thumb-index,
.thumb-badge,
.rank-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 28px;
  padding: 0 10px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
}

.thumb-index {
  background: #eff6ff;
  color: #1d4ed8;
  font-family: "Segoe UI", Arial, sans-serif;
}

.thumb-badge {
  border: 1px solid #dbe4f0;
  background: #ffffff;
  color: #475569;
  text-align: center;
  font-family: "Segoe UI", Arial, sans-serif;
}

.thumb-badge-card {
  border-color: #fde68a;
  background: #fffbeb;
  color: #a16207;
}

.thumb-avatar-wrap {
  position: relative;
  display: flex;
  justify-content: center;
  flex: 0 0 auto;
}

.thumb-identity {
  display: grid;
  grid-template-columns: 104px minmax(0, 1fr);
  align-items: center;
  gap: 18px;
}

.thumb-main {
  display: grid;
  gap: 10px;
  min-width: 0;
}

.thumb-avatar {
  width: 104px;
  height: 104px;
  padding: 5px;
  border-radius: 50%;
  background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
  box-shadow: 0 20px 32px rgba(59, 130, 246, 0.18);
}

.thumb-avatar-image {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
  background: #ffffff;
}

.thumb-avatar-image-default {
  padding: 12px;
  object-fit: contain;
}

.thumb-active-dot {
  position: absolute;
  right: 6px;
  bottom: 6px;
  width: 16px;
  height: 16px;
  border: 3px solid #ffffff;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 8px 18px rgba(34, 197, 94, 0.28);
}

.thumb-name-block {
  text-align: left;
  min-width: 0;
}

.thumb-countesy {
  color: #2563eb;
  font-size: 12px;
  font-weight: 700;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.thumb-name {
  margin: 4px 0 0;
  color: #0f172a;
  font-size: 19px;
  line-height: 1.45;
  font-weight: 650;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.thumb-subtitle {
  margin: 4px 0 0;
  color: #64748b;
  font-size: 12px;
  line-height: 1.6;
  font-family: "Segoe UI", Arial, sans-serif;
}

.rank-pill {
  background: #fef3c7;
  color: #854d0e;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.thumb-rank-row {
  justify-content: flex-start;
}

.thumb-detail-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
}

.thumb-detail {
  padding: 14px;
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  background: #f8fbff;
  text-align: left;
}

.thumb-detail-wide {
  grid-column: 1 / -1;
}

.thumb-detail-value {
  display: block;
  margin-top: 8px;
  color: #0f172a;
  font-size: 13px;
  line-height: 1.6;
  font-weight: 650;
  word-break: break-word;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.empty-state,
.loading-shell {
  display: flex;
  align-items: center;
  justify-content: center;
}

.empty-state {
  min-height: 300px;
  flex-direction: column;
  text-align: center;
  color: #64748b;
}

.empty-state h3 {
  margin: 0;
  color: #0f172a;
  font-size: 20px;
  font-weight: 700;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.empty-state p {
  margin: 10px 0 0;
  max-width: 360px;
  line-height: 1.7;
  font-family: "Segoe UI", Arial, sans-serif;
}

.loading-shell {
  position: absolute;
  inset: 0;
  z-index: 4;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(6px);
}

.loading-card {
  text-align: center;
  color: #1e3a8a;
  font-size: 13px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
}

.loading-spinner {
  width: 52px;
  height: 52px;
  margin: 0 auto 16px;
  border: 4px solid #dbeafe;
  border-top-color: #2563eb;
  border-radius: 50%;
  animation: spin 0.9s linear infinite;
}

.loading-close {
  position: absolute;
  top: 18px;
  right: 18px;
  padding: 0 14px;
  border-radius: 999px;
  background: #ffffff;
  color: #ef4444;
  font-size: 12px;
  font-weight: 700;
}

.footer-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  margin-top: 18px;
}

.footer-nav:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.footer-center {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  flex: 1 1 auto;
}

.footer-summary {
  color: #64748b;
  font-size: 12px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
}

.footer-pages {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
}

.footer-page {
  min-width: 40px;
  height: 40px;
  padding: 0 12px;
  border-radius: 14px;
  background: #ffffff;
  color: #475569;
  font-size: 13px;
  font-weight: 700;
}

.footer-page-active {
  color: #1d4ed8;
  border-color: #bfdbfe;
  background: #eff6ff;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

@media (max-width: 1100px) {
  .hero-shell,
  .toolbar {
    flex-direction: column;
    align-items: stretch;
  }
}

@media (max-width: 768px) {
  .thumbnail-page {
    padding: 16px;
  }

  .hero-shell,
  .card-shell {
    padding: 20px;
    border-radius: 24px;
  }

  .hero-copy {
    align-items: flex-start;
  }

  .hero-title {
    font-size: 28px;
  }

  .stats-grid {
    gap: 12px;
  }

  .stat-card {
    flex: 1 1 calc(50% - 6px);
    min-width: 0;
  }

  .toolbar-actions {
    justify-content: stretch;
  }

  .toolbar-actions > * {
    flex: 1 1 0;
  }

  .filter-row,
  .footer-bar {
    flex-direction: column;
    align-items: stretch;
  }

  .filter-reset,
  .footer-nav {
    width: 100%;
  }

  .thumbnail-grid,
  .thumb-detail-grid {
    grid-template-columns: 1fr;
  }

  .thumb-detail-wide {
    grid-column: auto;
  }

  .thumb-identity {
    grid-template-columns: 1fr;
    justify-items: center;
    text-align: center;
  }

  .thumb-main,
  .thumb-name-block {
    text-align: center;
  }

  .thumb-rank-row {
    justify-content: center;
  }
}
</style>
