<template>
  <div
    class="min-h-screen bg-yellow-50 bg-repeat font-sr"
    :style="'background-image: url(' + ocmCardBackgroundImage + ');'"
  >
    <div class="mx-auto max-w-md px-4 py-6 sm:py-10">
      <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white/95 shadow-2xl backdrop-blur">
        <div class="bg-slate-900 px-6 py-7 text-center text-white">
          <img :src="ocmLogoUrl" class="mx-auto w-20" alt="OCM Logo" />
          <div class="mt-4 font-moul text-lg text-amber-300">ទីស្តីការគណៈរដ្ឋមន្ត្រី</div>
          <div class="mt-1 text-sm text-slate-200">Office of the Council of Ministers</div>
        </div>

        <div v-if="loading" class="px-6 py-16 text-center text-slate-600">
          <div class="mx-auto mb-4 h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-slate-700"></div>
          <div>កំពុងផ្ទុកព័ត៌មានមន្ត្រី...</div>
        </div>

        <div v-else-if="officer" class="px-6 pb-6">
          <div class="flex justify-center">
            <img
              :src="officer.image || ocmLogoUrl"
              class="-mt-14 h-28 w-28 rounded-3xl border-4 border-white bg-white object-cover shadow-lg"
              alt="Officer Photo"
              @error="setFallbackImage"
            />
          </div>

          <div class="mt-4 text-center text-slate-900">
            <div v-if="hasValue(officer.countesy_name)" class="font-moul text-base text-amber-700">
              {{ officer.countesy_name }}
            </div>
            <h1 class="mt-2 font-moul text-xl leading-8">
              {{ displayValue(officer.khmer_name) }}
            </h1>
            <p class="mt-1 text-sm text-slate-600">
              {{ displayValue(officer.english_name) }}
            </p>
          </div>

          <div class="mt-4 flex flex-wrap justify-center gap-2 text-sm">
            <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-slate-700">
              {{ displayValue(officer.card_number) }}
            </span>
            <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-slate-700">
              {{ displayValue(officer.code) }}
            </span>
            <span
              class="rounded-full border px-3 py-1"
              :class="getCardStatusClass(officer)"
            >
              {{ getCardStatusLabel(officer) }}
            </span>
          </div>

          <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">មុខតំណែង</div>
              <div class="mt-2 text-slate-900">{{ displayValue(officer.position_name) }}</div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">អង្គភាព</div>
              <div class="mt-2 text-slate-900">{{ displayValue(officer.organization_name) }}</div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">ថ្ងៃខែឆ្នាំកំណើត</div>
              <div class="mt-2 text-slate-900">{{ $toKhmer(formatDateLabel(officer.dob)) }}</div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">ភេទ</div>
              <div class="mt-2 text-slate-900">{{ getGenderLabel(officer.gender) }}</div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">ថ្ងៃចូលបម្រើការងារ</div>
              <div class="mt-2 text-slate-900">{{ $toKhmer(formatDateLabel(officer.unofficial_date)) }}</div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
              <div class="font-moul text-sm text-slate-700">ថ្ងៃក្របខ័ណ្ឌ</div>
              <div class="mt-2 text-slate-900">{{ $toKhmer(formatDateLabel(officer.official_date)) }}</div>
            </div>
          </div>

          <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            ព័ត៌មាននេះបង្ហាញសម្រាប់ផ្ទៀងផ្ទាត់អត្តសញ្ញាណមន្ត្រីតាម QR កាតមន្ត្រី។
          </div>
        </div>

        <div v-else class="px-6 py-16 text-center text-slate-700">
          <div class="font-moul text-lg text-slate-900">រកមិនឃើញព័ត៌មានមន្ត្រី</div>
          <div class="mt-2 text-sm text-slate-600">
            QR នេះមិនមានទិន្នន័យ ឬតំណមិនត្រឹមត្រូវទេ។
          </div>
        </div>
      </div>

      <div class="py-4 text-center text-xs text-slate-600">
        ទីស្តីការគណៈរដ្ឋមន្ត្រី
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import ocmLogoUrl from "@assets/logo.svg";
import ocmCardBackgroundImage from "@assets/pkachan.png";

export default {
  name: "CardComponent",
  setup() {
    const store = useStore();
    const route = useRoute();

    const officer = ref(null);
    const loading = ref(false);

    function hasValue(value) {
      return `${value ?? ""}`.trim().length > 0;
    }

    function displayValue(value) {
      return hasValue(value) ? value : "មិនមានទិន្នន័យ";
    }

    function formatDateLabel(value) {
      const normalized = `${value ?? ""}`.trim();
      return normalized.length > 0 ? normalized.slice(0, 10) : "មិនមានទិន្នន័យ";
    }

    function getGenderLabel(value) {
      if (`${value ?? ""}`.trim().length === 0) {
        return "មិនមានទិន្នន័យ";
      }

      return Number(value) === 1 ? "ប្រុស" : "ស្រី";
    }

    function isCardActive(record) {
      if (record == null) {
        return false;
      }

      if (Number(record.card_active) === 0) {
        return false;
      }

      const endDate = `${record.card_end ?? ""}`.trim();
      if (endDate.length === 0) {
        return true;
      }

      const parsedEndDate = new Date(`${endDate.slice(0, 10)}T23:59:59`);
      if (Number.isNaN(parsedEndDate.getTime())) {
        return true;
      }

      return parsedEndDate >= new Date();
    }

    function getCardStatusLabel(record) {
      return isCardActive(record) ? "កាតមានសុពលភាព" : "កាតមិនមានសុពលភាព";
    }

    function getCardStatusClass(record) {
      return isCardActive(record)
        ? "border-emerald-200 bg-emerald-50 text-emerald-700"
        : "border-rose-200 bg-rose-50 text-rose-700";
    }

    function setFallbackImage(event) {
      if (event?.target) {
        event.target.onerror = null;
        event.target.src = ocmLogoUrl;
      }
    }

    function readOfficer() {
      const key = `${route.params.id ?? ""}`.trim();

      if (key.length === 0) {
        officer.value = null;
        return;
      }

      loading.value = true;

      store
        .dispatch("officer/readCardPublic", { key })
        .then((res) => {
          officer.value = res?.data?.ok === true ? res.data.record : null;
        })
        .catch(() => {
          officer.value = null;
        })
        .finally(() => {
          loading.value = false;
        });
    }

    watch(
      () => route.params.id,
      () => {
        readOfficer();
      },
    );

    onMounted(() => {
      readOfficer();
    });

    return {
      officer,
      loading,
      hasValue,
      displayValue,
      formatDateLabel,
      getGenderLabel,
      getCardStatusLabel,
      getCardStatusClass,
      setFallbackImage,
      ocmLogoUrl,
      ocmCardBackgroundImage,
    };
  },
};
</script>

<style scoped></style>
