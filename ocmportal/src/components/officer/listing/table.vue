<template>
  <div class="staff-directory-page">
    <div class="table-hero">
      <div class="table-hero-copy">
        <div class="table-hero-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <path d="M17.254 11a2.25 2.25 0 0 1 2.25 2.25v6.249a5.501 5.501 0 0 1-11.002 0V13.25a2.25 2.25 0 0 1 2.25-2.25h6.502zm0 1.5h-6.502a.75.75 0 0 0-.75.75v6.249a4.001 4.001 0 0 0 8.002 0V13.25a.75.75 0 0 0-.75-.75zM4.25 11h4.156a3.243 3.243 0 0 0-.817 1.5H4.25a.75.75 0 0 0-.75.75v5.249a3.001 3.001 0 0 0 4.238 2.735c.133.49.324.956.564 1.392A4.501 4.501 0 0 1 2 18.499V13.25A2.25 2.25 0 0 1 4.25 11zm19.5 0A2.25 2.25 0 0 1 26 13.25v5.25a4.5 4.5 0 0 1-6.298 4.127l.056-.102c.214-.406.387-.837.511-1.289A3 3 0 0 0 24.5 18.5v-5.25a.75.75 0 0 0-.749-.75h-3.333A3.242 3.242 0 0 0 19.6 11h4.151zM14 3a3.5 3.5 0 1 1 0 7a3.5 3.5 0 0 1 0-7zm8.003 1a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM5.997 4a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM14 4.5a2 2 0 1 0 0 4a2 2 0 0 0 0-4zm8.003 1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm-16.006 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z" fill="currentColor"></path>
          </svg>
        </div>
        <div class="table-hero-heading">
          <span class="table-hero-mark"></span>
          <h1 class="table-hero-title">{{ model.title }}</h1>
        </div>
      </div>

      <div class="table-hero-actions">
        <button type="button" class="table-hero-button table-hero-button-secondary" @click="thumbnailView()">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path d="M8 30H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM18 30h-4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM28 30h-4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM8 20H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM18 20h-4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM28 20h-4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4v-4zM8 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zM4 4v4h4V4zM18 10h-4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4V4zM28 10h-4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2zm-4-6v4h4V4z" fill="currentColor"></path>
          </svg>
          Card View
        </button>

        <button
          v-if="$hasPermission('portal_staff_creating')"
          type="button"
          class="table-hero-button table-hero-button-primary"
          @click="showCreateModal()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <circle cx="12" cy="12" r="9"></circle>
              <path d="M9 12h6"></path>
              <path d="M12 9v6"></path>
            </g>
          </svg>
          Add Officer
        </button>

        <button
          v-if="$hasPermission('portal_staff_creating')"
          type="button"
          class="table-hero-button table-hero-button-ghost"
          @click="showCreateNonOfficerModal()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <circle cx="12" cy="12" r="9"></circle>
              <path d="M9 12h6"></path>
              <path d="M12 9v6"></path>
            </g>
          </svg>
          Add Non-Officer
        </button>
      </div>
    </div>

    <div class="table-stats">
      <div
        v-for="(tab, index) in summaryTabs"
        :key="tab.label"
        class="table-stat"
        :class="{ 'table-stat-active': index === 0 }"
      >
        <span class="table-stat-label">{{ tab.label }}</span>
        <strong class="table-stat-value">{{ $toKhmer(tab.value) }}</strong>
      </div>
    </div>

    <div class="vcb-table-panel relative staff-table-card">
      <div class="table-toolbar">
        <div class="table-search-shell">
          <svg class="table-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path>
          </svg>
          <input
            v-model="table.search"
            type="text"
            class="table-search-input"
            placeholder="Search for staff"
            @input="filterRecords(false)"
            @keyup.enter="filterRecords(false)"
          />
        </div>

        <div class="table-toolbar-actions">
          <n-popselect
            trigger="click"
            v-model:value="table.pagination.perPage"
            :options="perPageOptions"
            size="small"
            scrollable
            @update:value="goTo(1)"
          >
            <button type="button" class="table-toolbar-chip">
              <span>{{ $toKhmer(table.pagination.perPage) }}</span>
              <span>/ page</span>
            </button>
          </n-popselect>

          <button
            type="button"
            class="table-toolbar-chip"
            :class="{ 'table-toolbar-chip-active': filter || activeFilterCount > 0 }"
            @click="toggleFilter()"
          >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
              <path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path>
            </svg>
            <span>Filters</span>
            <span class="table-toolbar-chip-count">{{ $toKhmer(activeFilterCount) }}</span>
          </button>

          <n-popover trigger="click" placement="bottom-end">
            <template #trigger>
              <button
                type="button"
                class="table-toolbar-chip"
                :class="{ 'table-toolbar-chip-active': visibleColumnCount < columnOptions.length }"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path
                    d="M5 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3V5H5zm5 14h4V5h-4v14zm6 0h3a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-3v14z"
                    fill="currentColor"
                  ></path>
                </svg>
                <span>Table View</span>
                <span class="table-toolbar-chip-count">{{ $toKhmer(visibleColumnCount) }}</span>
              </button>
            </template>

            <div class="table-view-panel">
              <div class="table-view-header">
                <strong>Choose Columns</strong>
                <button type="button" class="table-view-reset" @click="resetColumnVisibility()">
                  Show All
                </button>
              </div>

              <div class="table-view-list">
                <label v-for="column in columnOptions" :key="column.key" class="table-view-option">
                  <n-checkbox
                    v-model:checked="columnVisibility[column.key]"
                    :disabled="visibleColumnCount === 1 && columnVisibility[column.key]"
                  >
                    {{ column.label }}
                  </n-checkbox>
                </label>
              </div>
            </div>
          </n-popover>
        </div>
      </div>

      <Transition name="slide-fade">
        <div v-if="filter" class="table-inline-filters">
          <div class="table-filter-item">
            <label class="table-filter-label">Positions</label>
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
          <div class="table-filter-item">
            <label class="table-filter-label">Organizations</label>
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
          <button type="button" class="table-filter-reset" @click="resetFilters()">
            Clear
          </button>
        </div>
      </Transition>

      <div class="table-toolbar-meta">
        <span>Showing {{ $toKhmer(Array.isArray(table.records.matched) ? table.records.matched.length : 0) }} of {{ $toKhmer(table.pagination.totalRecords || 0) }} records</span>
        <span>Page {{ $toKhmer(table.pagination.page || 1) }} / {{ $toKhmer(table.pagination.totalPages || 1) }}</span>
      </div>

      <Transition name="fade">
        <div v-if="hasRecords" class="table-scroll-shell">
          <table class="otc-table">
            <thead>
              <tr class="otc-header-row">
                <th v-if="columnVisibility.serial" class="w-16">No.</th>
                <th v-if="columnVisibility.staff" class="text-center">Staff</th>
                <th v-if="columnVisibility.nationalId" class="text-center">National ID</th>
                <th v-if="columnVisibility.birthDate" class="text-center">Birth Date</th>
                <th v-if="columnVisibility.startDate" class="text-center">Start Date</th>
                <th v-if="columnVisibility.officialDate" class="text-center">Official Date</th>
                <th v-if="columnVisibility.rank" class="text-center">Rank</th>
                <th v-if="columnVisibility.organization" class="text-center">Organization / Position</th>
                <th v-if="columnVisibility.email" class="text-center">Email</th>
                <th v-if="columnVisibility.actions" class="w-24 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(record, index) in table.records.matched" :key="record?.id ?? index" class="otc-body-row">
                <td v-if="columnVisibility.serial" class="serial-cell">
                  {{ $toKhmer(((table.pagination.page - 1) * table.pagination.perPage) + (index + 1)) }}
                </td>
                <td v-if="columnVisibility.staff" class="text-center">
                  <div class="person-cell">
                    <div class="person-avatar">
                      <img
                        :src="getAvatarUrl(record)"
                        :alt="getKhmerName(record)"
                        class="person-avatar-image"
                        :class="{ 'person-avatar-image-default': !hasAvatar(record) }"
                        @error="setFallbackAvatar"
                      />
                    </div>
                    <div class="person-copy">
                      <div class="person-name">{{ getKhmerName(record) }}</div>
                      <div class="person-meta">{{ getEnglishName(record) }}</div>
                      <div class="person-tags">
                        <span class="person-tag">Code {{ $toKhmer(getOfficerCode(record)) }}</span>
                      </div>
                    </div>
                  </div>
                </td>
                <td v-if="columnVisibility.nationalId" class="text-center cell-quiet">
                  {{ $toKhmer(getNationalId(record)) }}
                </td>
                <td v-if="columnVisibility.birthDate" class="text-center cell-quiet">
                  {{ $toKhmer(formatDateLabel(record?.people?.dob)) }}
                </td>
                <td v-if="columnVisibility.startDate" class="text-center cell-quiet">
                  {{ $toKhmer(formatDateLabel(record?.unofficial_date)) }}
                </td>
                <td v-if="columnVisibility.officialDate" class="text-center cell-quiet">
                  {{ $toKhmer(formatDateLabel(record?.official_date)) }}
                </td>
                <td v-if="columnVisibility.rank" class="text-center">
                  <span class="rank-pill">{{ getRankName(record) }}</span>
                </td>
                <td v-if="columnVisibility.organization" class="text-center">
                  <div class="job-cell">
                    <div class="job-primary">{{ getOrganizationName(record) }}</div>
                    <div class="job-secondary">{{ getPositionName(record) }}</div>
                  </div>
                </td>
                <td v-if="columnVisibility.email" class="text-center cell-quiet email-cell">{{ getEmail(record) }}</td>
                <td v-if="columnVisibility.actions" class="text-center action-cell">
                  <table-actions-form v-bind:model="model" v-bind:record="record" :onClose="closeActions" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Transition>

      <Transition name="fade">
        <div v-if="!table.loading && !hasRecords" class="table-empty-state">
          <div class="table-empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
              <path d="M17.254 11a2.25 2.25 0 0 1 2.25 2.25v6.249a5.501 5.501 0 0 1-11.002 0V13.25a2.25 2.25 0 0 1 2.25-2.25h6.502zm0 1.5h-6.502a.75.75 0 0 0-.75.75v6.249a4.001 4.001 0 0 0 8.002 0V13.25a.75.75 0 0 0-.75-.75zM4.25 11h4.156a3.243 3.243 0 0 0-.817 1.5H4.25a.75.75 0 0 0-.75.75v5.249a3.001 3.001 0 0 0 4.238 2.735c.133.49.324.956.564 1.392A4.501 4.501 0 0 1 2 18.499V13.25A2.25 2.25 0 0 1 4.25 11zm19.5 0A2.25 2.25 0 0 1 26 13.25v5.25a4.5 4.5 0 0 1-6.298 4.127l.056-.102c.214-.406.387-.837.511-1.289A3 3 0 0 0 24.5 18.5v-5.25a.75.75 0 0 0-.749-.75h-3.333A3.242 3.242 0 0 0 19.6 11h4.151zM14 3a3.5 3.5 0 1 1 0 7a3.5 3.5 0 0 1 0-7zm8.003 1a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM5.997 4a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM14 4.5a2 2 0 1 0 0 4a2 2 0 0 0 0-4zm8.003 1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm-16.006 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z" fill="currentColor"></path>
            </svg>
          </div>
          <h3>No staff records found</h3>
          <p>Try a different search term or adjust the active filters.</p>
        </div>
      </Transition>

      <Transition name="slide-fade">
        <div v-if="table.loading" class="table-loading">
          <div class="spinner">
            <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path>
            </svg>
            <p class="table-loading-text">Loading staff records...</p>
          </div>
          <button type="button" class="table-loading-close" @click="closeTableLoading">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path>
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path>
            </svg>
          </button>
        </div>
      </Transition>

      <div v-if="table.pagination.totalPages > 1" class="table-footer">
        <button
          type="button"
          class="table-footer-nav"
          :disabled="table.pagination.page <= 1"
          @click="previous()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M14.71 15.88L10.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L8.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.39.39 1.02.39 1.41 0c.38-.39.39-1.03 0-1.42z" fill="currentColor"></path>
          </svg>
          Previous
        </button>

        <div class="table-footer-center">
          <span class="table-footer-summary">{{ $toKhmer(table.pagination.totalRecords) }} records</span>
          <div class="table-page-list">
            <button
              v-for="(page, index) in table.pagination.buttons"
              :key="index"
              type="button"
              class="table-page-button"
              :class="{ 'table-page-button-active': table.pagination.page == page }"
              @click="table.pagination.page == page ? false : goTo(page)"
            >
              {{ $toKhmer(page) }}
            </button>
          </div>
        </div>

        <button
          type="button"
          class="table-footer-nav"
          :disabled="table.pagination.page >= table.pagination.totalPages"
          @click="next()"
        >
          Next
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M9.29 15.88L13.17 12L9.29 8.12a.996.996 0 1 1 1.41-1.41l4.59 4.59c.39.39.39 1.02 0 1.41L10.7 17.3a.996.996 0 0 1-1.41 0c-.38-.39-.39-1.03 0-1.42z" fill="currentColor"></path>
          </svg>
        </button>
      </div>
    </div>

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
import { reactive, ref, computed, watch, onMounted, onBeforeUnmount, defineAsyncComponent } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useNotification } from 'naive-ui'
import dateFormat from 'dateformat'

import defaultOfficerAvatar from './../../../assets/logo copy.png'
import TableActionsForm from './actions/table-action.vue'

const CreateForm = defineAsyncComponent(() => import('./../widgets/create.vue'))
const CreateNonOfficerForm = defineAsyncComponent(() => import('./../widgets/createnonofficer.vue'))

export default {
  name: 'People',
  components: {
    CreateForm,
    CreateNonOfficerForm,
    TableActionsForm
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
      columns: {
        searchable: {
          username: '',
          firstname: '',
          lastname: '',
          email: '',
          phone: '',
          active: ''
        },
        format: {
          username: '',
          firstname: '',
          lastname: '',
          email: '',
          phone: '',
          active: ''
        }
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
    const columnStorageKey = 'officer-listing-table-columns'
    const columnOptions = [
      { key: 'serial', label: 'No.' },
      { key: 'staff', label: 'Staff' },
      { key: 'nationalId', label: 'National ID' },
      { key: 'birthDate', label: 'Birth Date' },
      { key: 'startDate', label: 'Start Date' },
      { key: 'officialDate', label: 'Official Date' },
      { key: 'rank', label: 'Rank' },
      { key: 'organization', label: 'Organization / Position' },
      { key: 'email', label: 'Email' },
      { key: 'actions', label: 'Actions' }
    ]
    const defaultColumnVisibility = {
      serial: true,
      staff: true,
      nationalId: true,
      birthDate: true,
      startDate: true,
      officialDate: true,
      rank: true,
      organization: true,
      email: true,
      actions: true
    }
    const columnVisibility = reactive({ ...defaultColumnVisibility })
    let filterTimeout = null

    function countSelectedEntries(values) {
      return Array.isArray(values)
        ? values.filter((value) => value !== null && value !== undefined && `${value}`.trim() !== '').length
        : 0
    }

    const hasRecords = computed(() => Array.isArray(table.records.matched) && table.records.matched.length > 0)
    const columnVisibilityState = computed(() =>
      columnOptions.reduce((state, column) => {
        state[column.key] = columnVisibility[column.key]
        return state
      }, {})
    )
    const visibleColumnCount = computed(() => {
      return columnOptions.filter((column) => columnVisibility[column.key]).length
    })

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

    function getEmail(record) {
      return normalizeText(record?.email)
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

    function getInitials(record) {
      const englishName = getEnglishName(record)
      const khmerName = [record?.people?.lastname, record?.people?.firstname]
        .filter((value) => typeof value === 'string' && value.trim().length > 0)
        .join(' ')

      const source = englishName !== '--' ? englishName : khmerName
      if (!source) {
        return 'OC'
      }

      const initials = source
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0))
        .join('')
        .toUpperCase()

      return initials || 'OC'
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
        event.target.classList.add('person-avatar-image-default')
      }
    }

    function resetColumnVisibility() {
      Object.assign(columnVisibility, defaultColumnVisibility)
    }

    function loadColumnVisibility() {
      if (typeof window === 'undefined') {
        return
      }

      try {
        const storedValue = window.localStorage.getItem(columnStorageKey)
        if (!storedValue) {
          return
        }

        const parsedValue = JSON.parse(storedValue)
        columnOptions.forEach((column) => {
          if (typeof parsedValue?.[column.key] === 'boolean') {
            columnVisibility[column.key] = parsedValue[column.key]
          }
        })

        if (!columnOptions.some((column) => columnVisibility[column.key])) {
          resetColumnVisibility()
        }
      } catch (error) {
        console.log(error)
        resetColumnVisibility()
      }
    }

    function filterRecords(helper = true) {
      if (helper) {
        if (table.search === '') {
          table.records.matched = table.records.all
          return
        }

        table.records.matched = []
        for (const index in table.records.all) {
          for (const field in table.records.all[index]) {
            if ((`${table.records.all[index][field]}`).includes(table.search) !== false) {
              table.records.matched.push(table.records.all[index])
              break
            }
          }
        }
        return
      }

      if (filterTimeout) {
        window.clearTimeout(filterTimeout)
      }

      filterTimeout = window.setTimeout(() => {
        table.pagination.page = 1
        getRecords()
      }, 350)
    }

    function buildPaginationButtons() {
      const visibleButtons = 7
      const halfWindow = Math.floor(visibleButtons / 2)
      const totalPages = table.pagination.totalPages || 0

      if (totalPages <= 0) {
        table.pagination.start = 0
        table.pagination.end = 0
        table.pagination.buttons = []
        return
      }

      let start = table.pagination.page - halfWindow
      let end = table.pagination.page + halfWindow

      if (start < 1) {
        start = 1
        end = Math.min(visibleButtons, totalPages)
      }

      if (end > totalPages) {
        end = totalPages
        start = Math.max(1, end - visibleButtons + 1)
      }

      table.pagination.start = start
      table.pagination.end = end
      table.pagination.buttons = []

      for (let page = start; page <= end; page += 1) {
        table.pagination.buttons.push(page)
      }
    }

    function getRecords() {
      if (filterTimeout) {
        window.clearTimeout(filterTimeout)
        filterTimeout = null
      }

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
          table.records.all = Array.isArray(res?.data?.records) ? res.data.records : []
          table.records.matched = table.records.all

          const pagination = res?.data?.pagination || {}
          table.pagination = {
            ...table.pagination,
            ...pagination,
            perPage: pagination.perPage ?? table.pagination.perPage,
            page: pagination.page ?? table.pagination.page,
            totalPages: pagination.totalPages ?? 0,
            totalRecords: pagination.totalRecords ?? 0,
            start: 0,
            end: 0,
            buttons: []
          }

          if (table.pagination.totalPages <= 0) {
            table.pagination.page = 1
          }

          buildPaginationButtons()
          closeTableLoading()
        })
        .catch((err) => {
          console.log(err)
          closeTableLoading()
        })
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

    function thumbnailView() {
      router.push('/hr/officer')
    }

    watch(
      columnVisibilityState,
      (value) => {
        if (typeof window === 'undefined') {
          return
        }

        window.localStorage.setItem(columnStorageKey, JSON.stringify(value))
      },
      { deep: true }
    )

    onMounted(() => {
      loadColumnVisibility()
      window.addEventListener('keydown', handleKeydown)
    })

    onBeforeUnmount(() => {
      window.removeEventListener('keydown', handleKeydown)
    })

    getRecords()

    return {
      model,
      table,
      perPageOptions,
      hasRecords,
      activeFilterCount,
      summaryTabs,
      columnOptions,
      columnVisibility,
      visibleColumnCount,
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
      closeFilter,
      resetFilters,
      toggleFilter,
      filter,
      optionPositions,
      selectedPositions,
      optionOrganizations,
      selectedOrganizations,
      thumbnailView,
      getKhmerName,
      getEnglishName,
      getOfficerCode,
      getNationalId,
      getRankName,
      getOrganizationName,
      getPositionName,
      getEmail,
      formatDateLabel,
      getInitials,
      hasAvatar,
      getAvatarUrl,
      setFallbackAvatar,
      resetColumnVisibility
    }
  }
}
</script>

<style type="text/css" scoped>
.staff-directory-page {
  width: 100%;
  padding: 24px;
}

.table-hero {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 24px;
  padding: 28px 32px;
  border: 1px solid #dbe4f0;
  border-radius: 32px;
  background: linear-gradient(135deg, #ffffff 0%, #f5f9ff 55%, #eef6ff 100%);
  box-shadow: 0 26px 56px rgba(15, 23, 42, 0.08);
}

.table-hero-copy {
  display: flex;
  align-items: center;
  gap: 18px;
  min-width: 0;
}

.table-hero-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 58px;
  height: 58px;
  border-radius: 20px;
  color: #1d4ed8;
  background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
  flex: 0 0 auto;
}

.table-hero-icon svg {
  width: 28px;
  height: 28px;
}

.table-hero-heading {
  display: flex;
  align-items: center;
  gap: 16px;
  min-width: 0;
}

.table-hero-mark {
  width: 6px;
  height: 52px;
  border-radius: 999px;
  background: linear-gradient(180deg, #2563eb 0%, #38bdf8 100%);
  box-shadow: 0 8px 22px rgba(37, 99, 235, 0.24);
  flex: 0 0 auto;
}

.table-hero-title {
  margin: 0;
  color: #0f172a;
  font-size: 34px;
  line-height: 1.35;
  font-weight: 650;
  letter-spacing: 0.01em;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.table-hero-actions {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-end;
  gap: 12px;
}

.table-hero-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-height: 44px;
  padding: 0 18px;
  border-radius: 16px;
  border: 1px solid transparent;
  font-size: 13px;
  font-weight: 700;
  transition: 0.2s ease;
  cursor: pointer;
}

.table-hero-button svg {
  width: 18px;
  height: 18px;
}

.table-hero-button-secondary {
  color: #0f172a;
  background: rgba(255, 255, 255, 0.92);
  border-color: #d7e1ef;
}

.table-hero-button-secondary:hover {
  border-color: #94a3b8;
  transform: translateY(-1px);
}

.table-hero-button-primary {
  color: #ffffff;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  box-shadow: 0 16px 28px rgba(37, 99, 235, 0.24);
}

.table-hero-button-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 18px 32px rgba(37, 99, 235, 0.28);
}

.table-hero-button-ghost {
  color: #0f766e;
  background: #f0fdfa;
  border-color: #99f6e4;
}

.table-hero-button-ghost:hover {
  border-color: #5eead4;
  transform: translateY(-1px);
}

.table-stats {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin: 22px 0 18px;
}

.table-stat {
  min-width: 150px;
  padding: 14px 18px;
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.88);
  box-shadow: 0 14px 30px rgba(15, 23, 42, 0.05);
}

.table-stat-active {
  border-color: #bfdbfe;
  background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.table-stat-label {
  display: block;
  color: #64748b;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-stat-value {
  display: block;
  margin-top: 8px;
  color: #0f172a;
  font-size: 24px;
  line-height: 1;
  font-weight: 700;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.staff-table-card {
  padding: 24px 24px 20px;
  margin-bottom: 0;
  overflow: hidden;
  border: 1px solid #dbe4f0;
  border-radius: 18px;
  background: #ffffff;
  box-shadow: 0 26px 56px rgba(15, 23, 42, 0.07);
}

.table-toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.table-search-shell {
  position: relative;
  flex: 1 1 420px;
}

.table-search-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  width: 18px;
  height: 18px;
  color: #94a3b8;
  transform: translateY(-50%);
}

.table-search-input {
  width: 100%;
  height: 48px;
  padding: 0 18px 0 46px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #f8fafc;
  color: #0f172a;
  font-size: 13px;
  font-family: "Segoe UI", Arial, sans-serif;
  transition: 0.2s ease;
}

.table-search-input:focus {
  outline: none;
  border-color: #93c5fd;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
}

.table-toolbar-actions {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-end;
  gap: 12px;
}

.table-toolbar-chip {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  min-height: 44px;
  padding: 0 16px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  color: #334155;
  font-size: 13px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
  cursor: pointer;
  transition: 0.2s ease;
}

.table-toolbar-chip svg {
  width: 16px;
  height: 16px;
}

.table-toolbar-chip:hover {
  border-color: #93c5fd;
  color: #1d4ed8;
}

.table-toolbar-chip-active {
  color: #1d4ed8;
  border-color: #93c5fd;
  background: #eff6ff;
}

.table-toolbar-chip-count {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 22px;
  height: 22px;
  padding: 0 6px;
  border-radius: 999px;
  background: #dbeafe;
  color: #1d4ed8;
  font-size: 11px;
}

.table-toolbar-meta {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 10px;
  margin: 14px 0 18px;
  color: #64748b;
  font-size: 12px;
}

.table-scroll-shell {
  overflow: auto;
  border: 1px solid #edf2f7;
  border-radius: 14px;
}

.otc-table {
  width: 100%;
  min-width: 1180px;
  border-collapse: separate;
  border-spacing: 0;
  background: #ffffff;
}

.otc-header-row th {
  position: sticky;
  top: 0;
  z-index: 2;
  padding: 15px 18px;
  color: #64748b;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
}

.otc-body-row td {
  padding: 18px;
  vertical-align: middle;
  border-bottom: 1px solid #eef2f7;
  transition: background-color 0.2s ease;
}

.otc-body-row:hover td {
  background: #f8fbff;
}

.otc-body-row:last-child td {
  border-bottom: 0;
}

.serial-cell {
  color: #2563eb;
  font-weight: 700;
  text-align: center;
}

.person-cell {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 14px;
}

.person-avatar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  padding: 2px;
  overflow: hidden;
  border: 1px solid #bfdbfe;
  background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
  flex: 0 0 auto;
}

.person-avatar-image {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
  background: #ffffff;
}

.person-avatar-image-default {
  padding: 5px;
  object-fit: contain;
}

.person-copy {
  min-width: 0;
  text-align: center;
}

.person-name {
  color: #0f172a;
  font-size: 15px;
  line-height: 1.6;
  font-weight: 650;
  letter-spacing: 0.01em;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.person-meta {
  margin-top: 4px;
  color: #64748b;
  font-size: 12px;
  line-height: 1.5;
  font-family: "Segoe UI", Arial, sans-serif;
}

.person-tags {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
  margin-top: 10px;
}

.person-tag {
  display: inline-flex;
  align-items: center;
  padding: 5px 10px;
  border-radius: 999px;
  color: #1d4ed8;
  font-size: 11px;
  font-weight: 700;
  background: #eff6ff;
  font-family: "Segoe UI", Arial, sans-serif;
}

.cell-quiet {
  color: #334155;
}

.rank-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 7px 12px;
  border-radius: 999px;
  color: #854d0e;
  font-size: 12px;
  font-weight: 650;
  background: #fef3c7;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.job-cell {
  display: grid;
  gap: 6px;
  justify-items: center;
  text-align: center;
}

.job-primary {
  color: #0f172a;
  font-size: 13px;
  font-weight: 650;
  line-height: 1.6;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.job-secondary {
  color: #64748b;
  font-size: 12px;
  line-height: 1.5;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.email-cell {
  max-width: 200px;
  word-break: break-word;
  text-align: center;
}

.action-cell {
  min-width: 420px;
  position: relative;
  overflow: visible;
  text-align: center;
}

.table-empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 300px;
  text-align: center;
  color: #64748b;
}

.table-empty-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 72px;
  height: 72px;
  margin-bottom: 18px;
  border-radius: 22px;
  color: #1d4ed8;
  background: #eff6ff;
}

.table-empty-icon svg {
  width: 32px;
  height: 32px;
}

.table-empty-state h3 {
  margin: 0;
  color: #0f172a;
  font-size: 20px;
  font-weight: 700;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.table-empty-state p {
  margin: 10px 0 0;
  max-width: 360px;
  line-height: 1.7;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-loading {
  position: absolute;
  inset: 0;
  z-index: 4;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(6px);
}

.table-loading-text {
  margin: 18px 0 0;
  color: #1e3a8a;
  font-size: 13px;
  font-weight: 700;
  text-align: center;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-loading-close {
  position: absolute;
  top: 18px;
  right: 18px;
  width: 40px;
  height: 40px;
  padding: 8px;
  border: 0;
  border-radius: 999px;
  background: #ffffff;
  color: #ef4444;
  cursor: pointer;
  box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
}

.table-loading-close svg {
  width: 100%;
  height: 100%;
}

.table-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  margin-top: 18px;
}

.table-footer-nav {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  min-height: 44px;
  padding: 0 16px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  color: #0f172a;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.2s ease;
}

.table-footer-nav svg {
  width: 16px;
  height: 16px;
}

.table-footer-nav:hover:not(:disabled) {
  border-color: #93c5fd;
  color: #1d4ed8;
}

.table-footer-nav:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

.table-footer-center {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  flex: 1 1 auto;
}

.table-footer-summary {
  color: #64748b;
  font-size: 12px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-page-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
}

.table-page-button {
  min-width: 40px;
  height: 40px;
  padding: 0 12px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  color: #475569;
  font-size: 13px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
  cursor: pointer;
  transition: 0.2s ease;
}

.table-page-button:hover {
  border-color: #93c5fd;
  color: #1d4ed8;
}

.table-page-button-active {
  color: #1d4ed8;
  border-color: #bfdbfe;
  background: #eff6ff;
}

.table-inline-filters {
  display: flex;
  align-items: flex-end;
  gap: 14px;
  margin: 16px 0 20px;
  padding: 16px;
  border: 1px solid #dbe4f0;
  border-radius: 14px;
  background: #f8fbff;
}

.table-filter-item {
  flex: 1 1 0;
  min-width: 0;
}

.table-filter-label {
  display: block;
  margin-bottom: 8px;
  color: #0f172a;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-filter-reset {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 88px;
  min-height: 46px;
  padding: 0 16px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  color: #334155;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.2s ease;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-filter-reset:hover {
  border-color: #93c5fd;
  color: #1d4ed8;
}

.table-inline-filters :deep(.n-base-selection) {
  min-height: 46px;
  border-radius: 12px;
  background: #ffffff;
}

.table-inline-filters :deep(.n-base-selection__border),
.table-inline-filters :deep(.n-base-selection__state-border) {
  border-radius: 12px;
}

.table-view-panel {
  width: min(280px, 75vw);
}

.table-view-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  margin-bottom: 12px;
}

.table-view-header strong {
  color: #0f172a;
  font-size: 13px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-view-reset {
  padding: 0;
  border: 0;
  background: transparent;
  color: #2563eb;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  font-family: "Segoe UI", Arial, sans-serif;
}

.table-view-list {
  display: grid;
  gap: 10px;
}

.table-view-option {
  display: flex;
  align-items: center;
  min-height: 34px;
  padding: 0 2px;
}

.table-view-panel :deep(.n-checkbox) {
  width: 100%;
}

.table-view-panel :deep(.n-checkbox__label) {
  color: #334155;
  font-size: 13px;
  font-family: "Segoe UI", Arial, sans-serif;
}

@media (max-width: 1100px) {
  .table-hero {
    flex-direction: column;
  }

  .table-hero-actions {
    justify-content: flex-start;
  }
}

@media (max-width: 768px) {
  .staff-directory-page {
    padding: 16px;
  }

  .table-hero,
  .staff-table-card {
    padding: 20px;
    border-radius: 16px;
  }

  .table-hero-copy {
    flex-direction: column;
    align-items: flex-start;
  }

  .table-hero-heading {
    gap: 12px;
  }

  .table-hero-mark {
    width: 5px;
    height: 42px;
  }

  .table-hero-title {
    font-size: 28px;
  }

  .table-stats {
    gap: 12px;
  }

  .table-stat {
    flex: 1 1 calc(50% - 6px);
    min-width: 0;
  }

  .table-toolbar {
    flex-direction: column;
    align-items: stretch;
  }

  .table-toolbar-actions {
    justify-content: stretch;
  }

  .table-toolbar-actions > * {
    flex: 1 1 0;
  }

  .table-footer {
    flex-direction: column;
  }

  .table-footer-nav,
  .table-footer-center {
    width: 100%;
  }

  .table-footer-nav {
    justify-content: center;
  }

  .table-inline-filters {
    flex-direction: column;
    align-items: stretch;
  }

  .table-filter-reset {
    width: 100%;
  }
}
</style>
