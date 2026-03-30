<template>
  <n-modal
    :show="show"
    :on-mask-click="maskOrEscClick"
    :on-esc="maskOrEscClick"
    transform-origin="center"
  >
    <n-card
      class="print-profile-modal"
      :bordered="false"
      size="small"
      role="dialog"
      aria-modal="true"
    >
      <div class="print-profile-header font-sr">
        <strong class="font-moul">បោះពុម្ពជីវប្រវត្តិមន្ត្រី</strong>
        <button
          type="button"
          class="print-profile-close"
          @click="maskOrEscClick"
        >
          បិទ
        </button>
      </div>

      <iframe
        v-if="printProfileUrl"
        :src="printProfileUrl"
        class="print-profile-frame"
        title="Officer Print Profile"
      ></iframe>

      <div v-else class="print-profile-empty font-sr">
        មិនអាចបង្ហាញប្រវត្តិរូបសម្រាប់បោះពុម្ពបានទេ។
      </div>
    </n-card>
  </n-modal>
</template>

<script>
import { computed } from "vue";

export default {
  name: "PrintProfilePopup",
  props: {
    record: {
      type: Object,
      default: () => ({}),
    },
    show: {
      type: Boolean,
      default: false,
    },
    onClose: {
      type: Function,
      default: () => {},
    },
  },
  setup(props) {
    const printProfileUrl = computed(() => {
      const officerId = props?.record?.id;
      if (!officerId) {
        return "";
      }
      return window.location.origin + "/#/officer/print/profile/" + officerId;
    });

    function maskOrEscClick() {
      props.onClose(0);
    }

    return {
      printProfileUrl,
      maskOrEscClick,
    };
  },
};
</script>

<style scoped>
.print-profile-modal {
  width: 96vw;
  max-width: 1500px;
  height: 92vh;
  padding: 10px;
}

.print-profile-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
  font-size: 15px;
  font-family: "ktr", "btb", Arial, sans-serif;
}

.print-profile-close {
  border: 1px solid #d1d5db;
  border-radius: 8px;
  background: #ffffff;
  color: #334155;
  font-size: 13px;
  line-height: 1;
  padding: 8px 12px;
  cursor: pointer;
  font-family: "sr", Arial, sans-serif;
}

.print-profile-close:hover {
  background: #f8fafc;
}

.print-profile-frame {
  width: 100%;
  height: calc(92vh - 72px);
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  background: #ffffff;
}

.print-profile-empty {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 300px;
  color: #64748b;
  text-align: center;
  font-family: "ktr", "btb", Arial, sans-serif;
}
</style>
