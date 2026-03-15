<template>
  <div class="profile-page min-h-screen w-full pb-10 pt-6 lg:pt-12">
    <div class="relative px-4 lg:ml-40 lg:px-6">
      <div class="mx-auto grid max-w-7xl gap-4 xl:grid-cols-12">
        <Transition name="profile-drop">
          <aside
            v-if="transitionHelper"
            class="profile-card xl:col-span-4 xl:sticky xl:top-6"
          >
            <input
              id="referenceDocument"
              type="file"
              class="hidden"
              @change="fileChange"
            />

            <div class="profile-card__top">
              <div class="profile-avatar-wrap">
                <div class="profile-avatar-ring">
                  <div class="profile-avatar" :style="avatarStyle"></div>
                </div>
                <button
                  type="button"
                  class="profile-fab"
                  @click="clickUpload"
                >
                  <svg viewBox="0 0 512 512" aria-hidden="true">
                    <path
                      d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z"
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="32"
                    />
                    <circle
                      cx="256"
                      cy="272"
                      r="80"
                      fill="none"
                      stroke="currentColor"
                      stroke-miterlimit="10"
                      stroke-width="32"
                    />
                    <path
                      d="M124 158v-22h-24v22"
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="32"
                    />
                  </svg>
                </button>
              </div>

              <p v-if="hasText(user?.countesy?.name)" class="profile-pill font-moul">
                {{ user.countesy.name }}
              </p>

              <h1 class="profile-name font-moul">
                {{ userDisplayName }}
              </h1>
              <p v-if="hasText(userEnglishName)" class="profile-subtitle">
                {{ userEnglishName }}
              </p>
              <p class="profile-summary">
                {{ profileTagline }}
              </p>

              <div class="profile-selected-file">
                <span>Photo</span>
                <strong>{{ selectedFileName }}</strong>
              </div>

              <div class="profile-action-list">
                <button
                  type="button"
                  class="profile-action profile-action--primary"
                  @click="clickUpload"
                >
                  Choose Photo
                </button>
                <button
                  type="button"
                  class="profile-action profile-action--secondary"
                  :class="{ 'profile-action--active': hasPendingAvatar }"
                  @click="uploadFiles"
                >
                  Upload Photo
                </button>
                <button
                  type="button"
                  class="profile-action profile-action--ghost"
                  @click="goToPasswordChange"
                >
                  Change Password
                </button>
              </div>
            </div>

            <div class="profile-stat-grid">
              <article
                v-for="item in quickStatItems"
                :key="item.label"
                class="profile-stat"
              >
                <span>{{ item.label }}</span>
                <strong>{{ item.value }}</strong>
              </article>
            </div>

            <div class="profile-mini-panel">
              <div class="profile-section-heading">
                <span>Account Snapshot</span>
                <p>Fast access to the most-used identity and login details.</p>
              </div>

              <div class="profile-mini-list">
                <article
                  v-for="item in accountSnapshotItems"
                  :key="item.label"
                  class="profile-mini-item"
                >
                  <span>{{ item.label }}</span>
                  <strong>{{ item.value }}</strong>
                </article>
              </div>
            </div>
          </aside>
        </Transition>

        <Transition name="profile-drop">
          <section
            v-if="transitionHelper"
            class="profile-card profile-card--main xl:col-span-8"
          >
            <n-tabs class="profile-tabs" type="line" animated>
              <n-tab-pane name="personal" tab="Personal">
                <div class="profile-sections">
                  <section class="profile-section">
                    <div class="profile-section__head">
                      <h3>Identity</h3>
                      <p>Core personal details.</p>
                    </div>

                    <div class="profile-info-grid">
                      <article
                        v-for="item in personalIdentityItems"
                        :key="item.label"
                        class="profile-info-card"
                      >
                        <span>{{ item.label }}</span>
                        <strong>{{ item.value }}</strong>
                      </article>
                    </div>
                  </section>

                  <section class="profile-section">
                    <div class="profile-section__head">
                      <h3>Contact and Civil Record</h3>
                      <p>Contact, address, and identification details.</p>
                    </div>

                    <div class="profile-info-grid">
                      <article
                        v-for="item in personalContactItems"
                        :key="item.label"
                        class="profile-info-card"
                        :class="{ 'profile-info-card--wide': item.wide }"
                      >
                        <span>{{ item.label }}</span>
                        <strong>{{ item.value }}</strong>
                      </article>
                    </div>
                  </section>
                </div>
              </n-tab-pane>

              <n-tab-pane name="work" tab="Organization">
                <div class="profile-sections">
                  <section class="profile-section">
                    <div class="profile-section__head">
                      <h3>Officer Record</h3>
                      <p>Officer information linked to this account.</p>
                    </div>

                    <div class="profile-info-grid">
                      <article
                        v-for="item in officerItems"
                        :key="item.label"
                        class="profile-info-card"
                      >
                        <span>{{ item.label }}</span>
                        <strong>{{ item.value }}</strong>
                      </article>
                    </div>
                  </section>

                  <section class="profile-section">
                    <div class="profile-section__head">
                      <h3>Assignment</h3>
                      <p>Current role and organization.</p>
                    </div>

                    <div class="profile-info-grid">
                      <article
                        v-for="item in assignmentItems"
                        :key="item.label"
                        class="profile-info-card"
                      >
                        <span>{{ item.label }}</span>
                        <strong>{{ item.value }}</strong>
                      </article>
                    </div>
                  </section>
                </div>
              </n-tab-pane>

              <n-tab-pane name="account" tab="Account">
                <div class="profile-sections">
                  <section class="profile-section">
                    <div class="profile-section__head">
                      <h3>Access Details</h3>
                      <p>Login and profile image status.</p>
                    </div>

                    <div class="profile-info-grid">
                      <article
                        v-for="item in accountItems"
                        :key="item.label"
                        class="profile-info-card"
                      >
                        <span>{{ item.label }}</span>
                        <strong>{{ item.value }}</strong>
                      </article>
                    </div>
                  </section>

                  <div class="profile-note-grid">
                    <section class="profile-note-card">
                      <h3>Profile Actions</h3>
                      <p>
                        Choose a new photo from the summary card, then upload it when
                        you are ready.
                      </p>
                    </section>

                    <section class="profile-note-card profile-note-card--light">
                      <h3>Security Reminder</h3>
                      <p>
                        Password changes stay on a separate screen for cleaner account
                        management.
                      </p>
                    </section>
                  </div>
                </div>
              </n-tab-pane>
            </n-tabs>
          </section>
        </Transition>
      </div>
    </div>

    <float-top-menu :title="title" />
    <sidebar />
  </div>
</template>

<script>
import { isAuth, getUser } from "./../../plugins/authentication.js";
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useNotification } from "naive-ui";
import dateFormat from "dateformat";
import FloatTopMenu from "@components/menu/topmenu-float-items.vue";
import Sidebar from "@components/widgets/Sidebar.vue";

const EMPTY_VALUE = "-";

export default {
  name: "Profile",
  components: {
    FloatTopMenu,
    Sidebar,
  },
  setup() {
    const router = useRouter();
    const store = useStore();
    const notify = useNotification();

    const user = ref(isAuth() ? getUser() : {});
    const base64Avatar = ref(null);
    const selectedFileType = ref("");
    const transitionHelper = ref(false);
    const peopleDob = ref(null);
    const officerDate = ref(null);
    const files = ref([]);
    const title = ref("ប្រវត្តិរូបមន្ត្រី");

    function hasText(value) {
      return value !== null && value !== undefined && String(value).trim() !== "";
    }

    function fallbackValue(value) {
      return hasText(value) ? String(value).trim() : EMPTY_VALUE;
    }

    function formatDisplayDate(value) {
      if (!value) {
        return EMPTY_VALUE;
      }

      const date = new Date(value);

      return Number.isNaN(date.getTime())
        ? EMPTY_VALUE
        : dateFormat(date, "dd-mm-yyyy");
    }

    onMounted(() => {
      if (isAuth()) {
        peopleDob.value = hasText(user.value?.people?.dob)
          ? new Date(user.value.people.dob).getTime()
          : null;
        officerDate.value = hasText(user.value?.officer?.date)
          ? new Date(user.value.officer.date).getTime()
          : null;
      }

      setTimeout(() => {
        transitionHelper.value = true;
      }, 250);
    });

    const localProfile = computed(() => {
      if (hasText(base64Avatar.value)) {
        return base64Avatar.value;
      }

      return hasText(user.value?.avatar_url)
        ? user.value.avatar_url
        : "/src/assets/logo.png";
    });

    const avatarStyle = computed(() => ({
      backgroundImage: `url(${localProfile.value})`,
    }));

    const userDisplayName = computed(() => {
      const khmerName = [
        user.value?.people?.lastname,
        user.value?.people?.firstname,
      ]
        .filter(hasText)
        .join(" ")
        .trim();

      return khmerName || fallbackValue(user.value?.username);
    });

    const userEnglishName = computed(() => {
      const englishName = [
        user.value?.people?.enlastname,
        user.value?.people?.enfirstname,
      ]
        .filter(hasText)
        .join(" ")
        .trim();

      return englishName || "";
    });

    const profileTagline = computed(() => {
      const parts = [
        user.value?.position?.name,
        user.value?.organization?.name,
        user.value?.countesy?.name,
      ].filter(hasText);

      return parts.length > 0
        ? parts.join(" / ")
        : "Clean overview of your profile and account information.";
    });

    const selectedFileName = computed(() => {
      return files.value.length > 0 ? files.value[0].name : "No image selected";
    });

    const hasPendingAvatar = computed(() => files.value.length > 0);

    const headerBadges = computed(() => {
      const badges = [
        user.value?.countesy?.name,
        user.value?.position?.name,
        user.value?.organization?.name,
      ].filter(hasText);

      return badges.length > 0 ? badges : ["Profile Overview"];
    });

    const quickStatItems = computed(() => [
      {
        label: "Position",
        value: fallbackValue(user.value?.position?.name),
      },
      {
        label: "Organization",
        value: fallbackValue(user.value?.organization?.name),
      },
      {
        label: "Officer Code",
        value: fallbackValue(user.value?.officer?.code),
      },
      {
        label: "Card Number",
        value: fallbackValue(user.value?.card?.number),
      },
    ]);

    const accountSnapshotItems = computed(() => [
      {
        label: "Username",
        value: fallbackValue(user.value?.username),
      },
      {
        label: "Email",
        value: fallbackValue(user.value?.email),
      },
      {
        label: "Phone",
        value: fallbackValue(user.value?.phone),
      },
    ]);

    const genderLabel = computed(() => {
      if (user.value?.people?.gender === 0) {
        return "Female";
      }

      if (user.value?.people?.gender === 1) {
        return "Male";
      }

      return EMPTY_VALUE;
    });

    const maritalStatusLabel = computed(() => {
      switch (user.value?.people?.marry_status) {
        case "single":
          return "Single";
        case "married":
          return "Married";
        case "divorced":
          return "Divorced / Widowed";
        default:
          return EMPTY_VALUE;
      }
    });

    const personalIdentityItems = computed(() => [
      {
        label: "Khmer Last Name",
        value: fallbackValue(user.value?.people?.lastname),
      },
      {
        label: "Khmer First Name",
        value: fallbackValue(user.value?.people?.firstname),
      },
      {
        label: "English Last Name",
        value: fallbackValue(user.value?.people?.enlastname),
      },
      {
        label: "English First Name",
        value: fallbackValue(user.value?.people?.enfirstname),
      },
      {
        label: "Date of Birth",
        value: formatDisplayDate(peopleDob.value),
      },
      {
        label: "Gender",
        value: genderLabel.value,
      },
      {
        label: "Marital Status",
        value: maritalStatusLabel.value,
      },
    ]);

    const personalContactItems = computed(() => [
      {
        label: "Mobile Phone",
        value: fallbackValue(user.value?.people?.mobile_phone),
      },
      {
        label: "Office Phone",
        value: fallbackValue(user.value?.people?.office_phone),
      },
      {
        label: "Personal Email",
        value: fallbackValue(user.value?.people?.email),
      },
      {
        label: "National ID",
        value: fallbackValue(user.value?.people?.nid),
      },
      {
        label: "Passport",
        value: fallbackValue(user.value?.people?.passport),
      },
      {
        label: "Address",
        value: fallbackValue(user.value?.people?.address),
        wide: true,
      },
      {
        label: "Place of Birth",
        value: fallbackValue(user.value?.people?.pob),
        wide: true,
      },
    ]);

    const officerItems = computed(() => [
      {
        label: "Appointment Date",
        value: formatDisplayDate(officerDate.value),
      },
      {
        label: "Officer Code",
        value: fallbackValue(user.value?.officer?.code),
      },
      {
        label: "Officer Phone",
        value: fallbackValue(user.value?.officer?.phone),
      },
      {
        label: "Officer Email",
        value: fallbackValue(user.value?.officer?.email),
      },
      {
        label: "Officer Passport",
        value: fallbackValue(user.value?.officer?.passport),
      },
    ]);

    const assignmentItems = computed(() => [
      {
        label: "Countesy",
        value: fallbackValue(user.value?.countesy?.name),
      },
      {
        label: "Position",
        value: fallbackValue(user.value?.position?.name),
      },
      {
        label: "Organization",
        value: fallbackValue(user.value?.organization?.name),
      },
      {
        label: "Card Number",
        value: fallbackValue(user.value?.card?.number),
      },
    ]);

    const accountItems = computed(() => [
      {
        label: "Username",
        value: fallbackValue(user.value?.username),
      },
      {
        label: "Login Email",
        value: fallbackValue(user.value?.email),
      },
      {
        label: "Phone Number",
        value: fallbackValue(user.value?.phone),
      },
      {
        label: "Avatar Status",
        value: hasPendingAvatar.value
          ? "New image ready to upload"
          : hasText(user.value?.avatar_url)
            ? "Profile image configured"
            : "Using default image",
      },
      {
        label: "Selected File Type",
        value: hasText(selectedFileType.value)
          ? selectedFileType.value
          : "No file selected",
      },
    ]);

    function fileChange(event) {
      const [file] = Array.from(event.target.files || []);

      if (!file) {
        return;
      }

      const allowedMimeTypes = ["image/jpeg", "image/png"];
      const allowedSizeMb = 5;

      if (!allowedMimeTypes.includes(file.type)) {
        notify.error({
          title: "Avatar Upload",
          description: "Please choose a JPG or PNG image.",
          duration: 3000,
        });
        return;
      }

      if (file.size > allowedSizeMb * 1024 * 1024) {
        notify.error({
          title: "Avatar Upload",
          description: `The selected image is ${(file.size / 1024 / 1024).toFixed(2)} MB. Maximum size is 5 MB.`,
          duration: 3000,
        });
        return;
      }

      selectedFileType.value = file.type;

      const reader = new FileReader();
      reader.onload = (loadEvent) => {
        base64Avatar.value = loadEvent.target?.result || null;
        files.value = [file];
      };
      reader.onerror = () => {
        notify.error({
          title: "Avatar Upload",
          description: "Unable to read the selected image.",
          duration: 3000,
        });
      };
      reader.readAsDataURL(file);
    }

    function clickUpload() {
      document.getElementById("referenceDocument")?.click();
    }

    function uploadFiles() {
      if (!Array.isArray(files.value) || files.value.length === 0 || !files.value[0]) {
        notify.info({
          title: "Avatar Upload",
          content: "Choose an image before saving your profile photo.",
          duration: 3000,
        });
        return;
      }

      notify.info({
        title: "Avatar Upload",
        description: "Uploading profile image...",
        duration: 1000,
      });

      const formData = new FormData();
      const selectedFile = files.value[0];

      formData.append("id", user.value.id);
      formData.append("files", selectedFile, selectedFile.name);

      store
        .dispatch("user/upload", formData)
        .then((res) => {
          notify.success({
            title: "Avatar Upload",
            description: "Profile image updated.",
            duration: 1000,
          });

          if (res.data.record != null && res.data.record != undefined) {
            const tmpUser = getUser();
            tmpUser.avatar_url = res.data.record.avatar_url;
            localStorage.setItem("user", JSON.stringify(tmpUser));
            user.value = getUser();
            base64Avatar.value = user.value.avatar_url;
            selectedFileType.value = "";
            files.value = [];
          }
        })
        .catch((err) => {
          console.log(err);
          notify.error({
            title: "Avatar Upload",
            description: "There was a problem saving the selected image.",
            duration: 3000,
          });
        });
    }

    function goToPasswordChange() {
      router.push("/password/change");
    }

    return {
      accountItems,
      accountSnapshotItems,
      assignmentItems,
      avatarStyle,
      clickUpload,
      fileChange,
      goToPasswordChange,
      hasPendingAvatar,
      hasText,
      headerBadges,
      officerItems,
      personalContactItems,
      personalIdentityItems,
      profileTagline,
      quickStatItems,
      selectedFileName,
      title,
      transitionHelper,
      uploadFiles,
      user,
      userDisplayName,
      userEnglishName,
    };
  },
};
</script>

<style scoped>
.profile-page {
  --profile-ink: #1f2937;
  --profile-muted: #6b7280;
  --profile-border: #e5e7eb;
  --profile-accent: #2563eb;
  --profile-accent-strong: #1d4ed8;
  --profile-accent-soft: #eff6ff;
  --profile-warm-soft: #fffbeb;
  --profile-warm-border: #fde68a;
  background: #f9fafb;
}

.profile-card {
  position: relative;
  overflow: hidden;
  border: 1px solid var(--profile-border);
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
}

.profile-card::before {
  content: "";
  position: absolute;
  inset: 0 0 auto 0;
  height: 3px;
  background: #1d4ed8;
}

.profile-card__top {
  position: relative;
  padding: 1.5rem;
  background: #ffffff;
  border-bottom: 1px solid var(--profile-border);
}

.profile-avatar-wrap {
  position: relative;
  width: fit-content;
  margin: 0 auto 1.25rem;
}

.profile-avatar-ring {
  padding: 6px;
  border-radius: 9999px;
  background: #f8fafc;
  border: 1px solid #dbeafe;
}

.profile-avatar {
  width: 8rem;
  height: 8rem;
  border: 3px solid #ffffff;
  border-radius: 9999px;
  background-color: #ffffff;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  box-shadow: 0 0 0 1px var(--profile-border);
}

.profile-fab {
  position: absolute;
  right: 0;
  bottom: 0.35rem;
  width: 2.5rem;
  height: 2.5rem;
  border: 2px solid #ffffff;
  border-radius: 9999px;
  background: var(--profile-accent-strong);
  color: #ffffff;
  display: grid;
  place-items: center;
  box-shadow: 0 1px 3px rgba(37, 99, 235, 0.24);
  transition: background 0.18s ease;
}

.profile-fab:hover {
  background: #1e40af;
}

.profile-fab svg {
  width: 1rem;
  height: 1rem;
}

.profile-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.4rem 0.75rem;
  border: 1px solid var(--profile-warm-border);
  border-radius: 9999px;
  background: var(--profile-warm-soft);
  color: #b45309;
  font-size: 0.78rem;
  line-height: 1;
}

.profile-name {
  margin-top: 0.9rem;
  color: var(--profile-ink);
  font-size: 1.25rem;
  line-height: 1.4;
}

.profile-subtitle {
  margin-top: 0.35rem;
  color: var(--profile-muted);
  font-size: 0.88rem;
}

.profile-summary {
  margin-top: 0.65rem;
  color: #4b5563;
  font-size: 0.9rem;
  line-height: 1.65;
}

.profile-selected-file {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  margin-top: 1rem;
  padding: 0.85rem 1rem;
  border: 1px solid var(--profile-border);
  border-radius: 8px;
  background: #f9fafb;
}

.profile-selected-file span {
  color: var(--profile-muted);
  font-size: 0.76rem;
}

.profile-selected-file strong {
  color: var(--profile-ink);
  font-size: 0.85rem;
  line-height: 1.4;
  text-align: right;
  word-break: break-word;
}

.profile-action-list {
  display: grid;
  gap: 0.75rem;
  margin-top: 1rem;
}

.profile-action {
  min-height: 2.75rem;
  border: 1px solid transparent;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 600;
  transition: border-color 0.18s ease, background 0.18s ease, color 0.18s ease;
}

.profile-action--primary {
  background: var(--profile-accent-strong);
  border-color: var(--profile-accent-strong);
  color: #ffffff;
}

.profile-action--secondary {
  background: var(--profile-accent-soft);
  color: var(--profile-accent-strong);
  border-color: #bfdbfe;
}

.profile-action--active {
  background: var(--profile-accent);
  border-color: var(--profile-accent);
  color: #ffffff;
}

.profile-action--ghost {
  background: #ffffff;
  color: var(--profile-ink);
  border-color: #d1d5db;
}

.profile-stat-grid {
  display: grid;
  gap: 0.75rem;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  padding: 1rem 1rem 0;
}

.profile-stat {
  padding: 0.9rem;
  border: 1px solid var(--profile-border);
  border-radius: 8px;
  background: #f8fafc;
}

.profile-stat span {
  display: block;
  color: var(--profile-muted);
  font-size: 0.74rem;
  font-weight: 600;
}

.profile-stat strong {
  display: block;
  margin-top: 0.35rem;
  color: var(--profile-ink);
  font-size: 0.92rem;
  line-height: 1.45;
  word-break: break-word;
}

.profile-mini-panel {
  margin: 1rem;
  padding: 1rem;
  border: 1px solid var(--profile-border);
  border-radius: 8px;
  background: #ffffff;
}

.profile-section-heading span {
  color: var(--profile-ink);
  font-size: 0.95rem;
  font-weight: 700;
}

.profile-section-heading p {
  margin-top: 0.35rem;
  color: var(--profile-muted);
  line-height: 1.6;
}

.profile-mini-list {
  display: grid;
  gap: 0.75rem;
  margin-top: 0.9rem;
}

.profile-mini-item {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #f3f4f6;
}

.profile-mini-item:last-child {
  border-bottom: 0;
  padding-bottom: 0;
}

.profile-mini-item span {
  color: var(--profile-muted);
}

.profile-mini-item strong {
  color: var(--profile-ink);
  text-align: right;
  word-break: break-word;
}

.profile-banner {
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
  padding: 1.5rem;
  background: #ffffff;
  color: var(--profile-ink);
  border-bottom: 1px solid var(--profile-border);
}

.profile-banner__eyebrow {
  display: inline-flex;
  width: fit-content;
  padding: 0.35rem 0.7rem;
  border: 1px solid #bfdbfe;
  border-radius: 9999px;
  background: var(--profile-accent-soft);
  color: var(--profile-accent-strong);
  font-size: 0.74rem;
  font-weight: 600;
}

.profile-banner__title {
  margin-top: 0.75rem;
  font-size: 1.35rem;
  line-height: 1.3;
  font-weight: 700;
  color: #111827;
}

.profile-banner__text {
  margin-top: 0.5rem;
  max-width: 48rem;
  color: var(--profile-muted);
  line-height: 1.6;
}

.profile-badge-list {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
}

.profile-badge {
  padding: 0.45rem 0.8rem;
  border: 1px solid var(--profile-border);
  border-radius: 9999px;
  background: #f9fafb;
  color: #4b5563;
  font-size: 0.82rem;
}

.profile-tabs {
  padding: 1.25rem;
}

.profile-sections {
  display: grid;
  gap: 1rem;
}

.profile-section {
  border: 1px solid var(--profile-border);
  border-radius: 8px;
  padding: 1rem;
  background: #ffffff;
}

.profile-section__head {
  margin-bottom: 0.9rem;
}

.profile-section__head h3 {
  color: var(--profile-ink);
  font-size: 0.98rem;
  font-weight: 700;
}

.profile-section__head p {
  margin-top: 0.25rem;
  color: var(--profile-muted);
  font-size: 0.84rem;
  line-height: 1.55;
}

.profile-info-grid {
  display: grid;
  gap: 0.85rem;
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.profile-info-card {
  min-height: 5.25rem;
  padding: 0.95rem 1rem;
  border: 1px solid var(--profile-border);
  border-radius: 8px;
  background: #ffffff;
  transition: border-color 0.18s ease, box-shadow 0.18s ease;
}

.profile-info-card:hover {
  border-color: #bfdbfe;
  box-shadow: 0 1px 3px rgba(37, 99, 235, 0.08);
}

.profile-info-card--wide {
  grid-column: span 2;
}

.profile-info-card span {
  display: block;
  color: var(--profile-muted);
  font-size: 0.75rem;
  font-weight: 600;
}

.profile-info-card strong {
  display: block;
  margin-top: 0.4rem;
  color: var(--profile-ink);
  font-size: 0.92rem;
  line-height: 1.5;
  word-break: break-word;
}

.profile-note-grid {
  display: grid;
  gap: 0.85rem;
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.profile-note-card {
  padding: 1rem;
  border: 1px solid #dbeafe;
  border-radius: 8px;
  background: var(--profile-accent-soft);
  color: var(--profile-ink);
}

.profile-note-card h3 {
  font-size: 0.95rem;
  font-weight: 700;
}

.profile-note-card p {
  margin-top: 0.45rem;
  line-height: 1.6;
  color: #4b5563;
}

.profile-note-card--light {
  border-color: var(--profile-border);
  background: #f9fafb;
  color: var(--profile-ink);
}

:deep(.n-tabs-nav-scroll-content) {
  gap: 0.5rem;
}

:deep(.n-tabs-tab) {
  padding: 0.4rem 1rem;
  border-radius: 9999px;
  transition: background 0.18s ease, color 0.18s ease;
}

:deep(.n-tabs-tab.n-tabs-tab--active) {
  background: var(--profile-accent-soft);
  color: var(--profile-accent-strong);
}

:deep(.n-tabs-bar) {
  background: var(--profile-accent-strong);
}

.profile-drop-enter-active,
.profile-drop-leave-active {
  transition: opacity 0.22s ease, transform 0.22s ease;
}

.profile-drop-enter-from,
.profile-drop-leave-to {
  opacity: 0;
  transform: translateY(12px);
}

@media (min-width: 768px) {
  .profile-card__top {
    padding: 1.75rem;
  }

  .profile-banner {
    padding: 1.5rem 1.75rem;
  }

  .profile-tabs {
    padding: 1.5rem 1.75rem;
  }
}

@media (min-width: 1280px) {
  .profile-card--main {
    margin-top: 1.4rem;
  }
}

@media (max-width: 767px) {
  .profile-stat-grid,
  .profile-info-grid,
  .profile-note-grid {
    grid-template-columns: 1fr;
  }

  .profile-info-card--wide {
    grid-column: span 1;
  }

  .profile-selected-file,
  .profile-mini-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .profile-mini-item strong,
  .profile-selected-file strong {
    text-align: left;
  }
}
</style>
