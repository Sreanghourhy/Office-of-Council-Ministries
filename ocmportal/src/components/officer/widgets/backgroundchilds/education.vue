<template>
  <section class="mb-10 bg-white border rounded-sm">
    <!-- HEADER -->
    <div
      class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]"
    >
      <div
        class="w-full pr-4 text-left text-[15px] font-semibold text-[#1E3A8A] leading-7"
      >
        ឃ. កំរិតវប្បធម៌ទូទៅ ការបណ្ដុះបណ្ដាលមុខវិជ្ជាជីវៈ និងការបណ្ដុះបណ្ដាលបន្ត
      </div>

      <div class="flex items-center gap-2">
        <select
          v-model="selectedSectionIndex"
          class="border border-[#D8DEE8] rounded px-3 py-1.5 pr-9 text-[13px] bg-white appearance-none education-select"
        >
          <option
            v-for="(section, index) in sections"
            :key="section.id"
            :value="index"
          >
            {{ section.title || `ផ្នែកទី ${index + 1}` }}
          </option>
        </select>

        <button
          class="bg-[#1E3A8A] text-white px-3 py-1.5 text-[13px] rounded"
          @click="addRow"
        >
          បន្ថែម
        </button>
      </div>
    </div>

    <!-- TABLE -->
    <div v-if="officer" class="overflow-x-auto">
      <table class="w-full border-collapse min-w-[980px]">
        <thead>
          <tr>
            <th class="th">វគ្គឬកម្រិតសិក្សា</th>
            <th class="th">គ្រឹះស្ថានសិក្សា</th>
            <th class="th">ទីតាំង</th>
            <th class="th">សញ្ញាបត្រ</th>
            <th class="th">ជំនាញ</th>
            <th class="th">ថ្ងៃចូល</th>
            <th class="th">ថ្ងៃបញ្ចប់</th>
            <th v-if="hasRows" class="th w-40 text-center">សកម្មភាព</th>
          </tr>
        </thead>

        <tbody>
          <template
            v-for="(section, sectionIndex) in sections"
            :key="section.id"
          >
            <tr>
              <td colspan="7" class="bg-white p-2 border-b border-[#E5E7EB]">
                <input
                  :value="section.title"
                  class="w-full bg-transparent border-none outline-none text-[13px] font-semibold text-[#1E3A8A]"
                  readonly
                />
              </td>
              <td></td>
            </tr>

            <tr
              v-for="(row, rowIndex) in section.rows"
              :key="row._key"
              :class="
                isRowChangedFromBaseline(sectionIndex, row)
                  ? 'pending-row'
                  : 'bg-white'
              "
            >
              <td class="td">
                <input
                  :value="educationLevelForSection(sectionIndex)"
                  class="input bg-[#F8FAFC] text-[#334155]"
                  readonly
                />
              </td>

              <td class="td">
                <input v-model="row.place_name" class="input" />
              </td>

              <td class="td">
                <input v-model="row.location" class="input" />
              </td>

              <td class="td">
                <select v-model="row.certificate" class="input education-select">
                  <option value="">ជ្រើសរើស</option>
                  <option
                    v-for="cert in certificateOptions(sectionIndex)"
                    :key="cert.id"
                    :value="cert.id"
                  >
                    {{ cert.label }}
                  </option>
                </select>
              </td>

              <td class="td">
                <input v-model="row.field_name" class="input" />
              </td>

              <td class="td">
                <input v-model="row.start" type="date" class="input" />
              </td>

              <td class="td">
                <input v-model="row.end" type="date" class="input" />
              </td>

              <td v-if="hasRows" class="td text-center">
                <div class="action-toolbar">
                  <n-tooltip trigger="hover" placement="top">
                    <template #trigger>
                      <span class="action-trigger">
                        <button
                          type="button"
                          :class="[
                            'action-button',
                            row.pendingPdfFile
                              ? 'action-upload-pending'
                              : 'action-upload',
                          ]"
                          @click="openUploadDialog(row)"
                        >
                          <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                          >
                            <path
                              d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z"
                            />
                          </svg>
                        </button>
                      </span>
                    </template>
                    {{
                      row.pendingPdfFile
                        ? 'បានជ្រើស PDF រួចហើយ។ សូមរក្សាទុកព័ត៌មាន។'
                        : 'បញ្ជូលឯកសារ'
                    }}
                  </n-tooltip>
                  <n-tooltip trigger="hover">
                    <template #trigger>
                      <svg
                        @click="rowHasPreview(row) ? togglePdfModal(row) : false"
                        :class="[
                          'pdf-previewer',
                          'w-5',
                          'h-5',
                          rowHasPreview(row)
                            ? 'text-[#4F46E5] cursor-pointer'
                            : 'text-[#D1D5DB] cursor-not-allowed',
                        ]"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 1024 1024"
                      >
                        <path
                          d="M509.2 490.8c-.7-1.3-1.4-1.9-2.2-2c-2.9 3.3-2.2 31.5 2.7 51.4c4-13.6 4.7-40.5-.5-49.4zm-1.6 120.5c-7.7 20-18.8 47.3-32.1 71.4c4-1.6 8.1-3.3 12.3-5c17.6-7.2 37.3-15.3 58.9-20.2c-14.9-11.8-28.4-27.7-39.1-46.2z"
                          fill-opacity=".15"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M534 352V136H232v752h560V394H576a42 42 0 0 1-42-42zm55 287.6c16.1-1.9 30.6-2.8 44.3-2.3c12.8.4 23.6 2 32 5.1c.2.1.3.1.5.2c.4.2.8.3 1.2.5c.5.2 1.1.4 1.6.7c.1.1.3.1.4.2c4.1 1.8 7.5 4 10.1 6.6c9.1 9.1 11.8 26.1 6.2 39.6c-3.2 7.7-11.7 20.5-33.3 20.5c-21.8 0-53.9-9.7-82.1-24.8c-25.5 4.3-53.7 13.9-80.9 23.1c-5.8 2-11.8 4-17.6 5.9c-38 65.2-66.5 79.4-84.1 79.4c-4.2 0-7.8-.9-10.8-2c-6.9-2.6-12.8-8-16.5-15c-.9-1.7-1.6-3.4-2.2-5.2c-1.6-4.8-2.1-9.6-1.3-13.6l.6-2.7c.1-.2.1-.4.2-.6c.2-.7.4-1.4.7-2.1c0-.1.1-.2.1-.3c4.1-11.9 13.6-23.4 27.7-34.6c12.3-9.8 27.1-18.7 45.9-28.4c15.9-28 37.6-75.1 51.2-107.4c-10.8-41.8-16.7-74.6-10.1-98.6c.9-3.3 2.5-6.4 4.6-9.1c.2-.2.3-.4.5-.6c.1-.1.1-.2.2-.2c6.3-7.5 16.9-11.9 28.1-11.5c16.6.7 29.7 11.5 33 30.1c1.7 8 2.2 16.5 1.9 25.7v.7c0 .5 0 1-.1 1.5c-.7 13.3-3 26.6-7.3 44.7c-.4 1.6-.8 3.2-1.2 5.2l-1 4.1l-.1.3c.1.2.1.3.2.5l1.8 4.5c.1.3.3.7.4 1c.7 1.6 1.4 3.3 2.1 4.8v.1c8.7 18.8 19.7 33.4 33.9 45.1c4.3 3.5 8.9 6.7 13.9 9.8c1.8-.5 3.5-.7 5.3-.9z"
                          fill-opacity=".15"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M391.5 761c5.7-4.4 16.2-14.5 30.1-34.7c-10.3 9.4-23.4 22.4-30.1 34.7zm270.9-83l.2-.3h.2c.6-.4.5-.7.4-.9c-.1-.1-4.5-9.3-45.1-7.4c35.3 13.9 43.5 9.1 44.3 8.6z"
                          fill-opacity=".15"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM602 137.8L790.2 326H602V137.8zM792 888H232V136h302v216a42 42 0 0 0 42 42h216v494z"
                          fill="currentColor"
                        ></path>
                        <path
                          d="M535.9 585.3c-.8-1.7-1.5-3.3-2.2-4.9c-.1-.3-.3-.7-.4-1l-1.8-4.5c-.1-.2-.1-.3-.2-.5l.1-.3l.2-1.1c4-16.3 8.6-35.3 9.4-54.4v-.7c.3-8.6-.2-17.2-2-25.6c-3.8-21.3-19.5-29.6-32.9-30.2c-11.3-.5-21.8 4-28.1 11.4c-.1.1-.1.2-.2.2c-.2.2-.4.4-.5.6c-2.1 2.7-3.7 5.8-4.6 9.1c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.4-51.2 107.4v.1c-27.7 14.3-64.1 35.8-73.6 62.9c0 .1-.1.2-.1.3c-.2.7-.5 1.4-.7 2.1c-.1.2-.1.4-.2.6c-.2.9-.5 1.8-.6 2.7c-.9 4-.4 8.8 1.3 13.6c.6 1.8 1.3 3.5 2.2 5.2c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-2.6-2.6-6-4.8-10.1-6.6c-.1-.1-.3-.1-.4-.2c-.5-.2-1.1-.4-1.6-.7c-.4-.2-.8-.3-1.2-.5c-.2-.1-.3-.1-.5-.2c-16.2-5.8-41.7-6.7-76.3-2.8l-5.3.6c-5-3-9.6-6.3-13.9-9.8c-14.2-11.3-25.1-25.8-33.8-44.7zM391.5 761c6.7-12.3 19.8-25.3 30.1-34.7c-13.9 20.2-24.4 30.3-30.1 34.7zM507 488.8c.8.1 1.5.7 2.2 2c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4zm-19.2 188.9c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2zm175.4-.9c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4z"
                          fill="currentColor"
                        ></path>
                      </svg>
                    </template>
                    មើលឯកសារយោង។
                  </n-tooltip>
                  <n-tooltip trigger="hover" placement="top">
                    <template #trigger>
                      <span class="action-trigger">
                        <button
                          type="button"
                          :class="[
                            'action-button',
                            'action-download',
                            !rowHasDownload(row) ? 'action-button-disabled' : '',
                          ]"
                          @click="rowHasDownload(row) ? downloadPdf(row) : false"
                        >
                          <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3v11m0 0l4-4m-4 4l-4-4M4 17.5v.75A1.75 1.75 0 0 0 5.75 20h12.5A1.75 1.75 0 0 0 20 18.25v-.75"
                            />
                          </svg>
                        </button>
                      </span>
                    </template>
                    ទាញយកឯកសារ
                  </n-tooltip>
                  <span class="action-divider" aria-hidden="true"></span>
                  <delete-confirm-button-component
                    @confirm="removeRow(sectionIndex, rowIndex)"
                  />
                </div>
              </td>
            </tr>
          </template>

          <tr v-if="sections.length === 0">
            <td colspan="8" class="text-center text-gray-500 p-4">
              មិនទាន់មានទិន្នន័យ
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-else class="text-center text-red-500 p-8">
      សូមបញ្ជាកព័ត៌មានមន្ត្រីជាមុនសិន។
    </div>

    <career-save-footer-component
      :visible="hasSectionChanges"
      :changed-count="changedSectionCount"
      :can-navigate="canNavigateChanges"
      :show-navigation="false"
      @previous="goToPreviousChangedSection"
      @next="goToNextChangedSection"
      @cancel-section="cancelCurrentSection"
      @cancel-all="cancelAllSections"
      @save-all="saveEducation"
    />

    <input
      ref="referenceDocumentInput"
      type="file"
      class="hidden"
      accept=".pdf,application/pdf"
      @change="fileChange"
    />

    <pdf-preview
      v-model:model="model"
      v-model:record="selectedCertificate"
      v-bind:show="pdfToggle"
      :onClose="togglePdfModal"
    />
  </section>
</template>

<script>
import { computed, reactive, ref, watch } from "vue";
import { useNotification } from "naive-ui";
import { useStore } from "vuex";
import crud from "../../../../api/crud";
import CareerSaveFooterComponent from "./career-save-footer.vue";
import DeleteConfirmButtonComponent from "./delete-confirm-button.vue";
import PdfPreview from "./pdfpreview.vue";

export default {
  name: "EducationBackground",

  components: {
    CareerSaveFooterComponent,
    DeleteConfirmButtonComponent,
    PdfPreview,
  },

  props: {
    officer: Object,
  },

  setup(props) {
    const store = useStore();
    const notify = useNotification();

    /* ---------------- CONSTANTS ---------------- */

    const EDUCATION_LEVEL_GROUPS = [
      {
        level: "កម្រិតវប្បធម៌ទូទៅ",
        certificateOptions: ["បឋមភូមិ", "ទុតិយភូមិ", "ផ្សេងៗ"],
      },
      {
        level: "កម្រិតបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ",
        certificateOptions: [
          "បរិញ្ញាបត្ររង",
          "បរិញ្ញាបត្រ",
          "បរិញ្ញាបត្រជាន់ខ្ពស់",
          "បណ្ឌិត",
          "ផ្សេងៗ",
        ],
      },
      {
        level: "វគ្គបណ្ដុះបណ្ដាលបន្ត",
        certificateOptions: ["វិញ្ញាប័ណ្ណបត្រ"],
      },
    ];

    const EDUCATION_LEVEL_OPTIONS = EDUCATION_LEVEL_GROUPS.map(
      (group) => group.level,
    );

    const CERTIFICATE_GROUP_IDS_BY_SECTION = {
      1: [1, 2, 3],
      2: [4, 5, 6, 7, 8],
      3: [9],
    };

    const REQUIRED_EDUCATION_FIELDS = [
      "education_level",
      "place_name",
      "location",
      "certificate",
      "field_name",
      "start",
      "end",
    ];

    const EDITABLE_ROW_FIELDS = [
      "education_level",
      "place_name",
      "location",
      "certificate",
      "field_name",
      "start",
      "end",
    ];

    const FIELD_LABELS = {
      education_level: "វគ្គឬកម្រិតសិក្សា",
      place_name: "គ្រឹះស្ថានសិក្សា",
      location: "ទីតាំង",
      certificate: "សញ្ញាបត្រ",
      field_name: "ជំនាញ",
      start: "ថ្ងៃចូល",
      end: "ថ្ងៃបញ្ចប់",
    };

    /* ---------------- STATE ---------------- */

    const sections = ref([
      { id: 1, title: "១. កម្រិតវប្បធម៌", rows: [] },
      { id: 2, title: "២. បណ្ដុះបណ្ដាលវិជ្ជាជីវៈ", rows: [] },
      { id: 3, title: "៣. វគ្គបណ្ដុះបណ្ដាល", rows: [] },
    ]);

    const selectedSectionIndex = ref(0);
    let rowSeed = 0;

    const baselineSections = ref(cloneSections(sections.value));

    const hasRows = computed(() =>
      sections.value.some((section) => section.rows.length > 0),
    );

    const changedSectionIndexes = computed(() => {
      return sections.value.reduce((indexes, section, index) => {
        if (
          sectionSignature(section) !==
          sectionSignature(baselineSections.value[index])
        ) {
          indexes.push(index);
        }
        return indexes;
      }, []);
    });

    const changedSectionCount = computed(
      () => changedSectionIndexes.value.length,
    );
    const hasSectionChanges = computed(() => changedSectionCount.value > 0);
    const canNavigateChanges = computed(() => changedSectionCount.value > 0);

    const model = reactive({
      name: "certificate",
      module: "certificates",
      title: "កម្រិតអប់រំ",
    });

    const selectedCertificate = ref(null);
    const pdfToggle = ref(false);
    const referenceDocumentInput = ref(null);

    /* ---------------- UTIL ---------------- */

    const certificatesUrl = `${import.meta.env.VITE_API_SERVER}/certificates`;

    const khmerDigits = ["០", "១", "២", "៣", "៤", "៥", "៦", "៧", "៨", "៩"];

    const khmerNumber = (numberValue) => {
      return String(numberValue)
        .split("")
        .map((digit) => khmerDigits[digit])
        .join("");
    };

    function educationLevelForSection(sectionIndex) {
      return EDUCATION_LEVEL_OPTIONS[sectionIndex] || "";
    }

    const newRow = () => ({
      _key: `row-${++rowSeed}`,
      id: null,
      _draftPending: true,
      education_level: "",
      place_name: "",
      location: "",
      certificate: null,
      field_name: "",
      start: "",
      end: "",
      pdf: false,
      pendingPdfFile: null,
    });

    function cloneRows(rows = []) {
      return rows.map((row) => ({ ...row }));
    }

    function cloneSections(value = []) {
      return value.map((section) => ({
        ...section,
        rows: cloneRows(section.rows),
      }));
    }

    function sectionComparable(section) {
      if (!section) {
        return {
          title: "",
          rows: [],
        };
      }

      return {
        title: section.title || "",
        rows: (section.rows || [])
          .filter((row) => {
            const rowId = Number(row?.id || 0) > 0 ? Number(row.id) : null;
            return (
              rowId != null ||
              row?._draftPending === true ||
              !isEmptyEducationRow(normalizeEducationBackgroundRow(row))
            );
          })
          .map((row) => normalizeComparableRow(row)),
      };
    }

    function sectionSignature(section) {
      return JSON.stringify(sectionComparable(section));
    }

    function normalizeComparableRow(row) {
      return {
        id: Number(row?.id || 0) > 0 ? Number(row.id) : null,
        education_level: toText(row?.education_level),
        place_name: toText(row?.place_name),
        location: toText(row?.location),
        certificate: toText(row?.certificate),
        field_name: toText(row?.field_name),
        start: toDateString(row?.start),
        end: toDateString(row?.end),
        pdf_state: rowDocumentSignature(row),
      };
    }

    function rowSignature(row) {
      return JSON.stringify(normalizeComparableRow(row));
    }

    function rowDocumentSignature(row) {
      if (row?.pendingPdfFile instanceof File) {
        return `pending:${row.pendingPdfFile.name}:${row.pendingPdfFile.size}`;
      }

      return row?.pdf ? "stored" : "";
    }

    function isRowChangedFromBaseline(sectionIndex, row) {
      if (row?._draftPending === true) return true;

      const baselineSection = baselineSections.value[sectionIndex];
      if (!baselineSection) return true;

      const rowId = Number(row?.id || 0) > 0 ? Number(row.id) : null;
      if (rowId != null) {
        const baselineRow = (baselineSection.rows || []).find(
          (item) => Number(item?.id || 0) === rowId,
        );
        if (!baselineRow) return true;
        return rowSignature(row) !== rowSignature(baselineRow);
      }

      return !isEmptyEducationRow(normalizeEducationBackgroundRow(row));
    }

    function snapshotSectionsState() {
      baselineSections.value = cloneSections(sections.value);
    }

    function restoreSectionFromBaseline(sectionIndex) {
      const baselineSection = baselineSections.value[sectionIndex];
      if (!baselineSection) return;

      sections.value[sectionIndex] = {
        ...sections.value[sectionIndex],
        title: baselineSection.title,
        rows: cloneRows(baselineSection.rows),
      };
    }

    function cancelCurrentSection() {
      const changed = changedSectionIndexes.value;
      if (changed.length <= 0) return;

      const targetSectionIndex = changed.includes(selectedSectionIndex.value)
        ? selectedSectionIndex.value
        : changed[0];

      restoreSectionFromBaseline(targetSectionIndex);
      selectedSectionIndex.value = targetSectionIndex;
    }

    function cancelAllSections() {
      sections.value = cloneSections(baselineSections.value);
    }

    function currentChangedSectionPosition() {
      if (changedSectionIndexes.value.length <= 0) return -1;
      const position = changedSectionIndexes.value.indexOf(
        selectedSectionIndex.value,
      );
      return position >= 0 ? position : 0;
    }

    function goToNextChangedSection() {
      const changed = changedSectionIndexes.value;
      if (changed.length <= 0) return;

      const currentPosition = currentChangedSectionPosition();
      const nextPosition = (currentPosition + 1) % changed.length;
      selectedSectionIndex.value = changed[nextPosition];
    }

    function goToPreviousChangedSection() {
      const changed = changedSectionIndexes.value;
      if (changed.length <= 0) return;

      const currentPosition = currentChangedSectionPosition();
      const previousPosition =
        (currentPosition - 1 + changed.length) % changed.length;
      selectedSectionIndex.value = changed[previousPosition];
    }

    /* ---------------- ROW ---------------- */

    function addRow() {
      const row = newRow();
      row.education_level = educationLevelForSection(
        selectedSectionIndex.value,
      );
      sections.value[selectedSectionIndex.value].rows.push(row);
    }

    function removeRow(sectionIndex, rowIndex) {
      sections.value[sectionIndex].rows.splice(rowIndex, 1);
    }

    /* ---------------- CERTIFICATE ---------------- */

    function certificateOptions(sectionIndex) {
      const labels =
        EDUCATION_LEVEL_GROUPS[sectionIndex]?.certificateOptions || [];
      const ids = CERTIFICATE_GROUP_IDS_BY_SECTION[sectionIndex + 1] || [];

      return labels.map((label, index) => ({
        id: ids[index] ?? null,
        label,
      }));
    }

    /* ---------------- BUILD PAYLOAD ---------------- */

    function resolveSectionIndex(certificateGroupId) {
      const id = Number(certificateGroupId);
      if ([1, 2, 3].includes(id)) return 0;
      if ([4, 5, 6, 7, 8].includes(id)) return 1;
      if ([9].includes(id)) return 2;
      return -1;
    }

    function resolveCertificateGroupId(section, row) {
      const asNumber = Number(row?.certificate);
      if (Number.isInteger(asNumber) && asNumber > 0) {
        return asNumber;
      }

      const options =
        EDUCATION_LEVEL_GROUPS[section.id - 1]?.certificateOptions || [];
      const optionIndex = options.findIndex(
        (option) => option === row?.certificate,
      );
      const ids = CERTIFICATE_GROUP_IDS_BY_SECTION[section.id] || [];
      if (optionIndex >= 0) {
        return ids[optionIndex] ?? null;
      }

      // Keep new rows inside the selected section when no certificate is chosen yet.
      return ids[0] ?? null;
    }

    function toDateString(value) {
      return typeof value === "string" ? value.trim() : "";
    }

    function toText(value) {
      return String(value ?? "").trim();
    }

    function normalizeEducationBackgroundRow(row) {
      return {
        education_level: toText(row?.education_level),
        place_name: toText(row?.place_name),
        location: toText(row?.location),
        certificate: toText(row?.certificate),
        field_name: toText(row?.field_name),
        start: toDateString(row?.start),
        end: toDateString(row?.end),
      };
    }

    function isMissingField(field, value) {
      const text = toText(value);
      if (text === "") return true;
      if (field === "certificate") return text === "0";
      return false;
    }

    function hasEditableRowValues(row) {
      if (row?.pendingPdfFile instanceof File || Boolean(row?.pdf)) {
        return true;
      }

      return EDITABLE_ROW_FIELDS.some(
        (field) => !isMissingField(field, row?.[field]),
      );
    }

    function isEmptyEducationRow(row) {
      return !hasEditableRowValues(row);
    }

    function toDateInputString(value) {
      const text = toText(value);
      if (text === "") return "";

      if (/^\d{4}-\d{2}-\d{2}$/.test(text)) return text;
      if (/^\d{4}$/.test(text)) return `${text}-01-01`;

      const dayMonthYearMatch = text.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
      if (dayMonthYearMatch) {
        const [, day, month, year] = dayMonthYearMatch;
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
      }

      const yearMonthDaySlashMatch = text.match(
        /^(\d{4})\/(\d{1,2})\/(\d{1,2})$/,
      );
      if (yearMonthDaySlashMatch) {
        const [, year, month, day] = yearMonthDaySlashMatch;
        return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
      }

      const parsedDate = new Date(text);
      if (Number.isNaN(parsedDate.getTime())) return "";

      return [
        parsedDate.getFullYear(),
        String(parsedDate.getMonth() + 1).padStart(2, "0"),
        String(parsedDate.getDate()).padStart(2, "0"),
      ].join("-");
    }

    function toTargetSectionSet(sectionIndexes) {
      if (Array.isArray(sectionIndexes) && sectionIndexes.length > 0) {
        return new Set(sectionIndexes);
      }
      return null;
    }

    function shouldProcessSection(sectionIndex, targetSectionSet) {
      return targetSectionSet == null || targetSectionSet.has(sectionIndex);
    }

    function buildEducationBackgroundPayload(sectionIndexes) {
      const peopleId = Number(props?.officer?.people?.id || 0);
      const records = [];
      const errors = [];
      const targetSectionSet = toTargetSectionSet(sectionIndexes);

      if (peopleId <= 0) {
        return {
          records,
          errors: [
            {
              sectionIndex: -1,
              rowIndex: -1,
              missingFields: ["people_id"],
            },
          ],
          valid: false,
        };
      }

      sections.value.forEach((section, sectionIndex) => {
        if (!shouldProcessSection(sectionIndex, targetSectionSet)) return;

        section.rows.forEach((row, rowIndex) => {
          if (!isRowChangedFromBaseline(sectionIndex, row)) return;

          const normalized = normalizeEducationBackgroundRow(row);

          const missingFields = REQUIRED_EDUCATION_FIELDS.filter((field) =>
            isMissingField(field, normalized[field]),
          );

          if (missingFields.length > 0) {
            errors.push({
              sectionIndex,
              rowIndex,
              missingFields,
            });
            return;
          }

          records.push({
            id: Number(row?.id || 0) > 0 ? Number(row.id) : null,
            people_id: peopleId,
            education_level: normalized.education_level,
            place_name: normalized.place_name,
            location: normalized.location,
            certificate: normalized.certificate,
            field_name: normalized.field_name,
            start: normalized.start,
            end: normalized.end,
          });
        });
      });

      return {
        records,
        errors,
        valid: errors.length === 0,
      };
    }

    function buildEducationPayload(sectionIndexes) {
      const peopleId = Number(props?.officer?.people?.id || 0);
      const records = [];
      const targetSectionSet = toTargetSectionSet(sectionIndexes);

      sections.value.forEach((section, sectionIndex) => {
        if (!shouldProcessSection(sectionIndex, targetSectionSet)) return;

        section.rows
          .filter(
            (row) => !isEmptyEducationRow(normalizeEducationBackgroundRow(row)),
          )
          .forEach((row) => {
            if (!isRowChangedFromBaseline(sectionIndex, row)) return;

            const normalized = normalizeEducationBackgroundRow(row);

            records.push({
              rowRef: row,
              id: Number(row?.id || 0) > 0 ? Number(row.id) : null,
              people_id: peopleId > 0 ? peopleId : null,
              education_level: normalized.education_level,
              place_name: normalized.place_name,
              location: normalized.location,
              certificate_group_id: resolveCertificateGroupId(section, row),
              field_name: normalized.field_name,
              start_date: normalized.start,
              end_date: normalized.end,
            });
          });
      });

      return { records };
    }

    function collectDeletedRecordIds(sectionIndexes) {
      const targetSectionSet = toTargetSectionSet(sectionIndexes);
      const deletedIds = [];

      baselineSections.value.forEach((baselineSection, sectionIndex) => {
        if (!shouldProcessSection(sectionIndex, targetSectionSet)) return;

        const currentSection = sections.value[sectionIndex];
        const currentIds = new Set(
          (currentSection?.rows || [])
            .map((row) => Number(row?.id || 0))
            .filter((id) => id > 0),
        );

        (baselineSection?.rows || []).forEach((row) => {
          const rowId = Number(row?.id || 0);
          if (rowId > 0 && !currentIds.has(rowId)) {
            deletedIds.push(rowId);
          }
        });
      });

      return [...new Set(deletedIds)];
    }

    /* ---------------- LOAD DATA ---------------- */

    function mapRecords(records) {
      sections.value.forEach((section) => {
        section.rows = [];
      });

      records.forEach((record) => {
        const sectionIndex = resolveSectionIndex(record.certificate_group_id);
        if (sectionIndex === -1) return;

        sections.value[sectionIndex].rows.push({
          id: record.id,
          _key: `row-${++rowSeed}`,
          _draftPending: false,
          education_level: educationLevelForSection(sectionIndex),
          place_name: record.place_name || "",
          location: record.location || "",
          certificate: record.certificate_group_id ?? null,
          field_name: record.field_name || "",
          start: toDateInputString(record.start ?? record.start_date ?? ""),
          end: toDateInputString(record.end ?? record.end_date ?? ""),
          pdf: Boolean(record.pdf),
          pendingPdfFile: null,
        });
      });
    }

    /* ---------------- PDF ---------------- */

    function togglePdfModal(record) {
      selectedCertificate.value =
        record == null || record == undefined ? null : record;
      pdfToggle.value = !pdfToggle.value;
    }

    function openUploadDialog(record) {
      selectedCertificate.value = record;
      clickUpload();
    }

    function clickUpload() {
      const activeElement = document.activeElement;
      if (activeElement instanceof HTMLElement) {
        activeElement.blur();
      }

      window.setTimeout(() => {
        referenceDocumentInput.value?.click();
      }, 0);
    }

    function isPdfFile(file) {
      const allowedMimeTypes = [
        "application/pdf",
        "application/x-pdf",
        "application/acrobat",
      ];
      const mimeType = String(file?.type || "").trim().toLowerCase();
      const filename = String(file?.name || "").trim().toLowerCase();

      return allowedMimeTypes.includes(mimeType) || filename.endsWith(".pdf");
    }

    function validatePdfFile(file) {
      const allowedSizeMb = 25;

      if (!isPdfFile(file)) {
        notify.error({
          title: "ឯកសារយោង",
          description: `អនុញ្ញាតតែឯកសារ PDF ប៉ុណ្ណោះ។ ឯកសារដែលបានជ្រើសគឺ ${file?.name || "មិនស្គាល់ឈ្មោះ"}.`,
          duration: 3000,
        });
        return false;
      }

      if (file.size > allowedSizeMb * 1024 * 1024) {
        notify.error({
          title: "ឯកសារយោង",
          description: `ទំហំនៃឯកសារគឺ៖ ${(file.size / 1024 / 1024).toFixed(2)} មេកាបៃ (MB) លើសទំហំដែលកំណត់គឺ 25 មេកាបៃ។`,
          duration: 3000,
        });
        return false;
      }

      return true;
    }

    function fileChange(event) {
      const file = event.target.files?.[0];
      event.target.value = "";
      if (event.target instanceof HTMLElement) {
        event.target.blur();
      }

      if (!file || !selectedCertificate.value) {
        return;
      }

      if (!validatePdfFile(file)) {
        return;
      }

      selectedCertificate.value.pendingPdfFile = file;
      notify.info({
        title: "ឯកសារយោង",
        description:
          "បានជ្រើស PDF រួចហើយ។ សូមរក្សាទុកព័ត៌មានជាមុនសិន ដើម្បីបញ្ចូលឯកសារនេះ។",
        duration: 3000,
      });
    }

    async function uploadPendingPdf(row) {
      if (!row?.id || !row?.pendingPdfFile) {
        return false;
      }

      const formData = new FormData();
      formData.append("id", row.id);
      formData.append("file", row.pendingPdfFile, row.pendingPdfFile.name);

      await store.dispatch(`${model.name}/upload`, formData);
      row.pdf = true;
      row.pendingPdfFile = null;
      return true;
    }

    function rowHasPreview(row) {
      return Number(row?.id || 0) > 0 && Boolean(row?.pdf);
    }

    function rowHasDownload(row) {
      return Boolean(row?.pendingPdfFile || row?.pdf);
    }

    function triggerBrowserDownload(url, filename) {
      const anchor = document.createElement("a");
      anchor.href = url;
      anchor.download = filename;
      anchor.style.display = "none";
      document.body.appendChild(anchor);
      anchor.click();
      document.body.removeChild(anchor);
    }

    async function downloadPdf(row) {
      try {
        if (row?.pendingPdfFile instanceof File) {
          const downloadUrl = URL.createObjectURL(row.pendingPdfFile);
          try {
            triggerBrowserDownload(
              downloadUrl,
              row.pendingPdfFile.name || "education-certificate.pdf",
            );
          } finally {
            URL.revokeObjectURL(downloadUrl);
          }
          return;
        }

        if (!rowHasPreview(row)) {
          return;
        }

        const res = await store.dispatch(`${model.name}/pdf`, { id: row.id });
        triggerBrowserDownload(
          res?.data?.pdf,
          res?.data?.filename || `certificate-${row.id}.pdf`,
        );
      } catch (error) {
        console.error(error);
        notify.error({
          title: "ទាញយកឯកសារយោង",
          description: "មានបញ្ហាពេលទាញយកឯកសារយោង។",
          duration: 3000,
        });
      }
    }

    /* ---------------- API ---------------- */

    async function saveEducation() {
      const peopleId = Number(props?.officer?.people?.id || 0);
      if (peopleId <= 0) {
        console.error("Save error", "people_id is missing");
        return;
      }

      const targetSectionIndexes = [...changedSectionIndexes.value];
      if (targetSectionIndexes.length <= 0) {
        console.warn("No changed sections to save");
        return;
      }

      const validation = buildEducationBackgroundPayload(targetSectionIndexes);
      if (!validation.valid) {
        const firstError = validation.errors[0];
        if (firstError?.sectionIndex >= 0) {
          selectedSectionIndex.value = firstError.sectionIndex;
        }

        const details = validation.errors
          .map((error) => {
            const fieldLabels = error.missingFields
              .map((field) => FIELD_LABELS[field] || field)
              .join(", ");
            return `ជួរទី ${khmerNumber(error.rowIndex + 1)}: ${fieldLabels}`;
          })
          .join(" | ");

        notify.warning({
          title: "សូមបំពេញព័ត៌មានឲ្យគ្រប់",
          description: details || "សូមបំពេញព័ត៌មានឲ្យគ្រប់មុនរក្សាទុក។",
          duration: 4000,
        });
        return false;
      }

      const { records } = buildEducationPayload(targetSectionIndexes);
      const deletedIds = collectDeletedRecordIds(targetSectionIndexes);

      if (records.length <= 0 && deletedIds.length <= 0) {
        console.warn("No records to save");
        return;
      }

      try {
        for (const id of deletedIds) {
          await crud.delete(certificatesUrl, { id });
        }

        for (const { id, rowRef, ...record } of records) {
          const response = await (id != null
            ? crud.update(certificatesUrl, { id, ...record })
            : crud.create(certificatesUrl, record));

          const savedId =
            id != null
              ? id
              : Number(response?.data?.record?.id || response?.data?.id || 0);

          if (savedId > 0 && rowRef) {
            rowRef.id = savedId;
          }

          if (rowRef?.pendingPdfFile) {
            await uploadPendingPdf(rowRef);
          }
        }

        await fetchCertificates();
        console.log("Saved successfully", records.length + deletedIds.length);
      } catch (error) {
        console.error("Save error", error?.response?.data || error);
      }
    }

    async function fetchCertificates() {
      if (!props.officer?.people?.id) return;

      const query = new URLSearchParams({
        people_id: props.officer.people.id,
      }).toString();

      const url = `${certificatesUrl}?${query}`;

      try {
        const res = await crud.list(url);

        mapRecords(res.data.records);
        snapshotSectionsState();
      } catch (error) {
        console.error(error);
      }
    }

    /* ---------------- WATCH ---------------- */

    watch(
      () => props.officer?.people?.id,
      (id) => {
        if (id) fetchCertificates();
      },
      { immediate: true },
    );

    return {
      sections,
      selectedSectionIndex,
      educationLevelForSection,
      addRow,
      removeRow,
      certificateOptions,
      isRowChangedFromBaseline,
      khmerNumber,
      saveEducation,
      hasRows,
      hasSectionChanges,
      changedSectionCount,
      canNavigateChanges,
      goToPreviousChangedSection,
      goToNextChangedSection,
      cancelCurrentSection,
      cancelAllSections,
      model,
      selectedCertificate,
      pdfToggle,
      togglePdfModal,
      openUploadDialog,
      referenceDocumentInput,
      fileChange,
      rowHasPreview,
      rowHasDownload,
      downloadPdf,
    };
  },
};
</script>

<style scoped>
.th {
  background: #e5eaf2;
  padding: 8px;
  font-size: 13px;
  font-weight: 600;
  border-bottom: 1px solid #d8dee8;
}

.td {
  padding: 8px;
  border-bottom: 1px solid #e5e7eb;
}

.input {
  width: 100%;
  border: 1px solid #d8dee8;
  padding: 6px;
  border-radius: 4px;
  font-size: 13px;
  background: white;
  min-height: 34px;
}

.education-select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding-right: 32px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M6 8l4 4l4-4' stroke='%2364758B' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 16px 16px;
}

.pending-row > td {
  background: #fee2e2;
}

.pending-row > td:first-child {
  box-shadow: inset 4px 0 0 #dc2626;
}

.action-toolbar {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.action-trigger {
  display: inline-flex;
}

.action-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 32px;
  min-height: 32px;
  padding: 4px;
  border-radius: 9999px;
  color: #9ca3af;
  transition:
    color 0.2s ease,
    opacity 0.2s ease,
    background-color 0.2s ease;
}

.action-button:hover {
  background: #f8fafc;
}

.action-toolbar :deep(button) {
  min-width: 32px;
  min-height: 32px;
  padding: 4px;
  border-radius: 9999px;
}

.action-toolbar :deep(button svg) {
  width: 1.25rem;
  height: 1.25rem;
}

.action-upload {
  color: #16a34a;
}

.action-upload:hover {
  color: #15803d;
}

.action-upload-pending {
  color: #d97706;
}

.action-upload-pending:hover {
  color: #b45309;
}

.action-preview {
  color: #2563eb;
}

.action-preview:hover {
  color: #1d4ed8;
}

.action-download {
  color: #6b7280;
} 

.action-download:hover {
  color: #475569;
}

.action-button-disabled {
  opacity: 0.35;
  cursor: not-allowed;
}

.action-button-disabled:hover {
  color: #9ca3af;
}

.action-divider {
  width: 1px;
  height: 16px;
  background: #d8dee8;
}

.education-pdf-shell {
  position: fixed;
  inset: 8px;
  display: flex;
  flex-direction: column;
  background: white;
  border-radius: 16px;
  box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
  overflow: hidden;
}

.education-pdf-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 14px 16px;
  border-bottom: 1px solid #d8dee8;
  background: #f8fafc;
  flex: 0 0 auto;
}

.education-pdf-close {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  min-width: 92px;
  min-height: 44px;
  padding: 0 14px;
  border-radius: 9999px;
  color: #dc2626;
  background: #fef2f2;
  font-size: 14px;
  font-weight: 600;
}

.education-pdf-close:hover {
  background: #fee2e2;
}

.education-pdf-body {
  position: relative;
  flex: 1 1 auto;
  min-height: 0;
  background: #eef2f7;
}

.education-pdf-scroll {
  height: 100%;
  overflow-y: auto;
  overflow-x: auto;
  padding: 12px;
}

.education-pdf-loading {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 12px;
  background: rgba(255, 255, 255, 0.92);
  color: #1e3a8a;
  font-size: 15px;
  font-weight: 600;
}

.education-pdf-spinner {
  width: 52px;
  height: 52px;
  color: #2563eb;
  animation: education-pdf-spin 1s linear infinite;
}

.education-pdf-viewer {
  width: 100%;
}

.education-pdf-viewer :deep(.vue-pdf-embed__page) {
  margin-bottom: 12px;
}

.education-pdf-viewer :deep(.vue-pdf-embed__page canvas) {
  display: block;
  width: min(100%, 920px) !important;
  height: auto !important;
  margin: 0 auto;
  border: 1px solid #d8dee8;
  border-radius: 8px;
  background: white;
}

@media (min-width: 768px) {
  .education-pdf-shell {
    inset: 24px;
  }

  .education-pdf-scroll {
    padding: 16px;
  }
}

@keyframes education-pdf-spin {
  from {
    transform: rotate(0deg);
  }

  to {
    transform: rotate(360deg);
  }
}
</style>
