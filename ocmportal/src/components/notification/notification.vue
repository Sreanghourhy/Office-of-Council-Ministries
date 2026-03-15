<template>
  <div class="min-h-screen w-full bg-gray-50 pb-10 pt-6 lg:pt-12">
    <div class="relative px-4 lg:ml-40 lg:px-6">
      <Transition name="slide-fade">
        <section
          v-if="transitionHelper"
          class="mx-auto max-w-4xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm"
        >
          <h1 class="text-xl font-semibold text-gray-900">Hello</h1>
          <p class="mt-2 text-sm text-gray-600">Notification screen page.</p>
        </section>
      </Transition>
    </div>

    <float-top-menu :title="title" />
    <sidebar />
  </div>
</template>

<script>
import { onMounted, ref } from "vue";
import FloatTopMenu from "@components/menu/topmenu-float-items.vue";
import Sidebar from "@components/widgets/Sidebar.vue";

export default {
  name: "UserNotification",
  components: {
    FloatTopMenu,
    Sidebar,
  },
  setup() {
    const title = ref("ជូនដំណឹង");
    const transitionHelper = ref(false);

    onMounted(() => {
      setTimeout(() => {
        transitionHelper.value = true;
      }, 150);
    });

    return {
      title,
      transitionHelper,
    };
  },
};
</script>
