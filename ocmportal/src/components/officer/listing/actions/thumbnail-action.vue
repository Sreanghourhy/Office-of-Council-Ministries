<template>
  <div ref="actionsRef" class="thumb-actions">
    <button
      type="button"
      class="thumb-action-toggle"
      :class="{ 'thumb-action-toggle-open': show }"
      @click="toggleActions"
    >
      <span>Actions</span>
      <svg v-if="!show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M8.12 9.29L12 13.17l3.88-3.88a.996.996 0 1 1 1.41 1.41l-4.59 4.59a.996.996 0 0 1-1.41 0L6.7 10.7a.996.996 0 0 1 0-1.41c.39-.38 1.03-.39 1.42 0z" fill="currentColor"></path>
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M8.12 14.71L12 10.83l3.88 3.88a.996.996 0 1 0 1.41-1.41L12.7 8.71a.996.996 0 0 0-1.41 0L6.7 13.3a.996.996 0 0 0 0 1.41c.39.38 1.03.39 1.42 0z" fill="currentColor"></path>
      </svg>
    </button>

    <Transition name="slide-fade">
      <div v-if="show" class="thumb-action-panel">
        <button
          v-if="$hasPermission('portal_staff_background_information')"
          type="button"
          class="thumb-action thumb-action-blue"
          @click="showDetailModal(record)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M248 64C146.39 64 64 146.39 64 248s82.39 184 184 184s184-82.39 184-184S349.61 64 248 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M220 220h32v116"></path>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M208 340h88"></path>
            <path d="M248 130a26 26 0 1 0 26 26a26 26 0 0 0-26-26z" fill="currentColor"></path>
          </svg>
          <span>View</span>
        </button>

        <button
          v-if="$hasPermission('portal_staff_updating')"
          type="button"
          class="thumb-action thumb-action-blue"
          @click="showEditModal(record)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <g fill="none">
              <path d="M4 15h5.986c-.227.3-.4.639-.51 1H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5.232c-.326.14-.631.343-.897.609L15 9.944V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1zm8-9.5a.5.5 0 0 1 1 0v6.444l-.88.88A.498.498 0 0 1 12 12.5v-7zm-7 2a.5.5 0 0 1 1 0v5a.5.5 0 0 1-1 0v-5zM9 9a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-3A.5.5 0 0 0 9 9zm1.98 6.377l4.83-4.83a1.87 1.87 0 1 1 2.645 2.646l-4.83 4.829a2.197 2.197 0 0 1-1.02.578l-1.498.374a.89.89 0 0 1-1.079-1.078l.375-1.498c.096-.386.296-.74.578-1.02z" fill="currentColor"></path>
            </g>
          </svg>
          <span>Edit</span>
        </button>

        <button
          v-if="$hasPermission('portal_staff_profile_photo_change')"
          type="button"
          class="thumb-action thumb-action-cyan"
          @click="showProfileModal(record)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path>
            <path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path>
          </svg>
          <span>Photo</span>
        </button>

        <button
          v-if="$hasPermission('portal_staff_print_preview_officer_card')"
          type="button"
          class="thumb-action thumb-action-gold"
          @click="showOfficialCardModal(record)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28">
            <g fill="none">
              <path d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z" fill="currentColor"></path>
            </g>
          </svg>
          <span>Card</span>
        </button>

        <button
          v-if="$hasPermission('portal_staff_delete')"
          type="button"
          class="thumb-action thumb-action-red"
          @click="deleteAccount(record)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
            <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path>
            <path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path>
          </svg>
          <span>Delete</span>
        </button>
      </div>
    </Transition>

    <update-form v-bind:model="model" v-bind:record="record" v-bind:show="editModal.show" :onClose="closeUpdate" />
    <detail-form v-bind:model="model" v-bind:record="record" v-bind:show="detailModal.show" :onClose="closeDetail" />
    <official-card-form v-bind:model="model" v-bind:record="record" v-bind:show="officialCardModal.show" :onClose="closeOfficialCard" />
    <profile-form v-bind:model="model" v-bind:record="record" v-bind:show="profileModal.show" :onClose="closeProfileModal" />
  </div>
</template>

<script>
import { reactive, ref, onMounted, onBeforeUnmount } from 'vue'
import { useStore } from 'vuex'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import UpdateForm from './../../widgets/update.vue'
import DetailForm from './../../widgets/detail.vue'
import OfficialCardForm from './../../widgets/officialcard.vue'
import ProfileForm from './../../widgets/profile.vue'

export default {
  name: 'ThumbnailActions',
  components: {
    UpdateForm,
    DetailForm,
    OfficialCardForm,
    ProfileForm
  },
  props: {
    model: {
      type: Object
    },
    record: {
      type: Object
    },
    onClose: {
      type: Function
    }
  },
  setup(props) {
    const store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()

    const actionsRef = ref(null)
    const show = ref(false)
    const editModal = reactive({ show: false })
    const profileModal = reactive({ show: false })
    const officialCardModal = reactive({ show: false })
    const detailModal = reactive({ show: false })

    function closeMenu() {
      show.value = false
    }

    function toggleActions() {
      if (show.value === false) {
        window.dispatchEvent(new CustomEvent('officer-thumb-action-opened', { detail: { recordId: props.record != null ? props.record.id : null } }))
      }
      show.value = !show.value
    }

    function handlePointerDown(event) {
      if (show.value !== true || actionsRef.value == null) return
      if (!actionsRef.value.contains(event.target)) {
        closeMenu()
      }
    }

    function handleKeydown(event) {
      if (event.key === 'Escape') {
        closeMenu()
      }
    }

    function handleActionOpened(event) {
      if (show.value !== true) return
      const incomingRecordId = event != null && event.detail != null ? event.detail.recordId : null
      if (incomingRecordId !== (props.record != null ? props.record.id : null)) {
        closeMenu()
      }
    }

    function closeDetail(actionStatus) {
      detailModal.show = false
      props.onClose(parseInt(actionStatus, 10))
    }

    function closeUpdate(actionStatus) {
      editModal.show = false
      props.onClose(parseInt(actionStatus, 10))
    }

    function closeProfileModal(actionStatus) {
      profileModal.show = false
      props.onClose(parseInt(actionStatus, 10))
    }

    function closeOfficialCard(actionStatus) {
      officialCardModal.show = false
      props.onClose(parseInt(actionStatus, 10))
    }

    function showEditModal() {
      closeMenu()
      editModal.show = true
    }

    function showProfileModal() {
      closeMenu()
      profileModal.show = true
    }

    function showOfficialCardModal() {
      closeMenu()
      officialCardModal.show = true
    }

    function showDetailModal() {
      closeMenu()
      detailModal.show = true
    }

    function deleteAccount(record) {
      closeMenu()
      dialog.warning({
        title: 'Delete Record',
        content: 'Do you want to delete this staff record?',
        positiveText: 'Delete',
        negativeText: 'Cancel',
        onPositiveClick: () => {
          store
            .dispatch(props.model.name + '/delete', { id: record.id })
            .then((res) => {
              if (res.data.ok) {
                notify.success({
                  title: 'Record Deleted',
                  description: 'The staff record was deleted successfully.',
                  duration: 3000
                })
                props.onClose(1)
              } else {
                notify.error({
                  title: 'Delete Failed',
                  description: 'The staff record could not be deleted.',
                  duration: 3000
                })
              }
            })
            .catch((err) => {
              message.error(err)
            })
        }
      })
    }

    onMounted(() => {
      window.addEventListener('pointerdown', handlePointerDown)
      window.addEventListener('keydown', handleKeydown)
      window.addEventListener('officer-thumb-action-opened', handleActionOpened)
    })

    onBeforeUnmount(() => {
      window.removeEventListener('pointerdown', handlePointerDown)
      window.removeEventListener('keydown', handleKeydown)
      window.removeEventListener('officer-thumb-action-opened', handleActionOpened)
    })

    return {
      actionsRef,
      show,
      toggleActions,
      editModal,
      detailModal,
      profileModal,
      officialCardModal,
      showEditModal,
      showDetailModal,
      showProfileModal,
      showOfficialCardModal,
      closeUpdate,
      closeDetail,
      closeProfileModal,
      closeOfficialCard,
      deleteAccount
    }
  }
}
</script>

<style type="text/css" scoped>
.thumb-actions {
  position: absolute;
  top: 18px;
  right: 18px;
  z-index: 4;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.thumb-action-toggle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  min-height: 34px;
  padding: 0 12px;
  border: 1px solid #dbe4f0;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.98);
  color: #475569;
  font-size: 11px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
  cursor: pointer;
  box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
  transition: 0.2s ease;
}

.thumb-action-toggle:hover,
.thumb-action-toggle-open {
  color: #1d4ed8;
  border-color: #93c5fd;
  background: #eff6ff;
}

.thumb-action-toggle svg {
  width: 16px;
  height: 16px;
}

.thumb-action-panel {
  position: absolute;
  top: 42px;
  right: 0;
  display: grid;
  gap: 6px;
  min-width: 170px;
  padding: 8px;
  border: 1px solid #dbe4f0;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.98);
  box-shadow: 0 18px 34px rgba(15, 23, 42, 0.14);
  backdrop-filter: blur(8px);
}

.thumb-action {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  min-height: 38px;
  padding: 0 12px;
  border: 1px solid #dbe4f0;
  border-radius: 12px;
  background: #ffffff;
  color: #0f172a;
  font-size: 12px;
  font-weight: 700;
  font-family: "Segoe UI", Arial, sans-serif;
  cursor: pointer;
  transition: 0.2s ease;
  text-align: left;
}

.thumb-action svg {
  width: 15px;
  height: 15px;
  flex: 0 0 auto;
}

.thumb-action:hover {
  transform: translateY(-1px);
  box-shadow: 0 10px 18px rgba(15, 23, 42, 0.08);
}

.thumb-action-blue {
  color: #1d4ed8;
  background: #eff6ff;
  border-color: #bfdbfe;
}

.thumb-action-cyan {
  color: #0f766e;
  background: #ecfeff;
  border-color: #a5f3fc;
}

.thumb-action-gold {
  color: #a16207;
  background: #fffbeb;
  border-color: #fde68a;
}

.thumb-action-red {
  color: #b91c1c;
  background: #fef2f2;
  border-color: #fecaca;
}
</style>
