<template>
  <div class="actions">
    <div class="panel">
      <button
        v-if="$hasPermission('portal_staff_background_information')"
        type="button"
        class="action action-blue"
        @click="showDetailModal(record)"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path
            d="M248 64C146.39 64 64 146.39 64 248s82.39 184 184 184s184-82.39 184-184S349.61 64 248 64z"
            fill="none"
            stroke="currentColor"
            stroke-miterlimit="10"
            stroke-width="32"
          ></path>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
            d="M220 220h32v116"
          ></path>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-miterlimit="10"
            stroke-width="32"
            d="M208 340h88"
          ></path>
          <path
            d="M248 130a26 26 0 1 0 26 26a26 26 0 0 0-26-26z"
            fill="currentColor"
          ></path>
        </svg>
        <span>មើល</span>
      </button>

      <button
        v-if="$hasPermission('portal_staff_updating')"
        type="button"
        class="action action-blue"
        @click="showEditModal(record)"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <g fill="none">
            <path
              d="M4 15h5.986c-.227.3-.4.639-.51 1H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5.232c-.326.14-.631.343-.897.609L15 9.944V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1zm8-9.5a.5.5 0 0 1 1 0v6.444l-.88.88A.498.498 0 0 1 12 12.5v-7zm-7 2a.5.5 0 0 1 1 0v5a.5.5 0 0 1-1 0v-5zM9 9a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-3A.5.5 0 0 0 9 9zm1.98 6.377l4.83-4.83a1.87 1.87 0 1 1 2.645 2.646l-4.83 4.829a2.197 2.197 0 0 1-1.02.578l-1.498.374a.89.89 0 0 1-1.079-1.078l.375-1.498c.096-.386.296-.74.578-1.02z"
              fill="currentColor"
            ></path>
          </g>
        </svg>
        <span>កែប្រែ</span>
      </button>

      <!-- <button
        v-if="$hasPermission('portal_staff_profile_photo_change')"
        type="button"
        class="action action-cyan"
        @click="showProfileModal(record)"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
          <path
            d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z"
            fill="currentColor"
          ></path>
          <path
            d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z"
            fill="currentColor"
          ></path>
        </svg>
        <span>Photo</span>
      </button> -->

      <button
        v-if="$hasPermission('portal_staff_print_preview_officer_card')"
        type="button"
        class="action action-gold"
        @click="showOfficialCardModal(record)"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
          <g fill="none">
            <path
              d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z"
              fill="currentColor"
            ></path>
          </g>
        </svg>
        <span>ប័ណ្ណ</span>
      </button>

      <button
        v-if="$hasPermission('portal_staff_delete')"
        type="button"
        class="action action-red"
        @click="deleteAccount(record)"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path
            d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
          ></path>
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-miterlimit="10"
            stroke-width="32"
            d="M80 112h352"
            fill="currentColor"
          ></path>
          <path
            d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
          ></path>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
            d="M256 176v224"
          ></path>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
            d="M184 176l8 224"
          ></path>
          <path
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="32"
            d="M328 176l-8 224"
          ></path>
        </svg>
        <span>លុប</span>
      </button>
    </div>

    <span
      v-if="record.card != undefined && record.card != null"
      class="action-status"
      >ប័ណ្ណរួចរាល់</span
    >

    <update-form
      v-if="editModal.show"
      v-bind:model="model"
      v-bind:record="record"
      v-bind:show="editModal.show"
      :onClose="closeUpdate"
    />
    <print-profile-form
      v-if="detailModal.show"
      v-bind:model="model"
      v-bind:record="record"
      v-bind:show="detailModal.show"
      :onClose="closeDetail"
    />
    <preview-card-form
      v-if="previewCardModal.show"
      v-bind:model="model"
      v-bind:record="record"
      v-bind:show="previewCardModal.show"
      :onClose="closePreviewCard"
    />
    <official-card-form
      v-if="officialCardModal.show"
      v-bind:model="model"
      v-bind:record="record"
      v-bind:show="officialCardModal.show"
      :onClose="closeOfficialCard"
    />
    <profile-form
      v-if="profileModal.show"
      v-bind:model="model"
      v-bind:record="record"
      v-bind:show="profileModal.show"
      :onClose="closeProfileModal"
    />
  </div>
</template>

<script>
import { reactive, defineAsyncComponent } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useDialog, useMessage, useNotification } from "naive-ui";

const UpdateForm = defineAsyncComponent(
  () => import("./../../widgets/update.vue"),
);
const PrintProfileForm = defineAsyncComponent(
  () => import("./../../widgets/printprofile-popup.vue"),
);
const PreviewCardForm = defineAsyncComponent(
  () => import("./../../widgets/card1.vue"),
);
const OfficialCardForm = defineAsyncComponent(
  () => import("./../../widgets/officialcard.vue"),
);
const ProfileForm = defineAsyncComponent(
  () => import("./../../widgets/profile.vue"),
);

export default {
  name: "ThumbnailActions",
  components: {
    UpdateForm,
    PrintProfileForm,
    PreviewCardForm,
    OfficialCardForm,
    ProfileForm,
  },
  props: {
    model: {
      type: Object,
    },
    record: {
      type: Object,
    },
    onClose: {
      type: Function,
    },
  },
  setup(props) {
    const store = useStore();
    const router = useRouter();
    const dialog = useDialog();
    const message = useMessage();
    const notify = useNotification();

    const editModal = reactive({ show: false });
    const previewCardModal = reactive({ show: false });
    const profileModal = reactive({ show: false });
    const officialCardModal = reactive({ show: false });
    const detailModal = reactive({ show: false });

    function closeDetail(actionStatus) {
      detailModal.show = false;
      props.onClose(parseInt(actionStatus));
    }

    function closeUpdate(actionStatus) {
      editModal.show = false;
      props.onClose(parseInt(actionStatus));
    }

    function closePreviewCard(actionStatus) {
      previewCardModal.show = false;
      props.onClose(parseInt(actionStatus));
    }

    function closeProfileModal(actionStatus) {
      profileModal.show = false;
      props.onClose(parseInt(actionStatus));
    }

    function closeOfficialCard(actionStatus) {
      officialCardModal.show = false;
      props.onClose(parseInt(actionStatus));
    }

    function showEditModal() {
      router.push("/hr/officer/profile/" + props.record.id);
    }

    function showPreviewCardModal() {
      previewCardModal.show = true;
    }

    function showProfileModal() {
      profileModal.show = true;
    }

    function showOfficialCardModal() {
      officialCardModal.show = true;
    }

    function showDetailModal() {
      detailModal.show = true;
    }

    function deleteAccount(record) {
      dialog.warning({
        title: "លុបកំណត់ត្រា",
        content: "តើអ្នកពិតជាចង់លុបកំណត់ត្រាបុគ្គលិកនេះមែនទេ?",
        positiveText: "លុប",
        negativeText: "បោះបង់",
        onPositiveClick: async () => {
          try {
            const res = await store.dispatch(props.model.name + "/delete", {
              id: record.id,
            });

            if (res?.data?.ok) {
              notify.success({
                title: "លុបជោគជ័យ",
                description: "កំណត់ត្រាបុគ្គលិកត្រូវបានលុបដោយជោគជ័យ។",
                duration: 3000,
              });
              props.onClose(1);
              return;
            }

            notify.error({
              title: "លុបមិនបានជោគជ័យ",
              description:
                "មិនអាចលុបកំណត់ត្រាបុគ្គលិកនេះបានទេ។ សូមព្យាយាមម្តងទៀត។",
              duration: 3000,
            });
          } catch (err) {
            message.error(
              err?.response?.data?.message ||
                "មានបញ្ហាក្នុងការលុបកំណត់ត្រា។ សូមព្យាយាមម្តងទៀត។",
            );
          }
        },
      });
    }

    return {
      editModal,
      showEditModal,
      showDetailModal,
      detailModal,
      deleteAccount,
      closeUpdate,
      closeDetail,
      showPreviewCardModal,
      closePreviewCard,
      previewCardModal,
      showOfficialCardModal,
      closeOfficialCard,
      officialCardModal,
      showProfileModal,
      profileModal,
      closeProfileModal,
    };
  },
};
</script>

<style type="text/css" scoped>
.actions {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  min-width: 0;
}

.panel {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  flex-wrap: nowrap;
  white-space: nowrap;
  min-width: 0;
}

.action {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  min-height: 30px;
  padding: 0 9px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  font-size: 10px;
  font-weight: 700;
  line-height: 1;
  cursor: pointer;
  transition: 0.2s ease;
  font-family: "Segoe UI", Arial, sans-serif;
}

.action svg {
  width: 12px;
  height: 12px;
  flex: 0 0 auto;
}

.action:hover {
  border-color: #bfdbfe;
  transform: translateY(-1px);
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
}

.action-blue {
  color: #1d4ed8;
  background: #eff6ff;
  border-color: #bfdbfe;
}

.action-cyan {
  color: #0f766e;
  background: #ecfeff;
  border-color: #a5f3fc;
}

.action-gold {
  color: #a16207;
  background: #fffbeb;
  border-color: #fde68a;
}

.action-red {
  color: #b91c1c;
  background: #fef2f2;
  border-color: #fecaca;
}

.action-status {
  display: inline-flex;
  align-items: center;
  min-height: 30px;
  padding: 0 10px;
  border-radius: 12px;
  color: #0f766e;
  background: #f0fdfa;
  border: 1px solid #99f6e4;
  font-size: 10px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
  white-space: nowrap;
}
</style>
