<template>
  <div class="relative min-h-screen w-full overflow-hidden bg-white">
    <div class="relative flex min-h-screen items-center justify-center px-3 py-3 lg:ml-40 lg:px-6">
      <Transition name="slide-fade">
        <img
          v-if="transitionHelper"
          :src="cleanedDocumentImage"
          alt="Cleaned document"
          class="block h-[92vh] max-h-[92vh] w-auto max-w-full object-contain object-center"
        />
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
import cleanedDocumentImage from "./../../assets/cleaned_document.jpg";

export default {
  name: "UserPrivacy",
  components: {
    FloatTopMenu,
    Sidebar,
  },
  setup() {
    const title = ref("ភាពឯកជន");
    const transitionHelper = ref(false);

    onMounted(() => {
      setTimeout(() => {
        transitionHelper.value = true;
      }, 150);
    });

    return {
      cleanedDocumentImage,
      title,
      transitionHelper,
    };
  },
};
</script>
