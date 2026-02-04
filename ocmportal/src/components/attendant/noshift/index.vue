<template>
  <div class="relative w-full min-h-screen bg-gray-50 bg-center bg-cover bg-background" >
    <div class="absolute p-0 top-0 right-0 bottom-0 left-0 ">
      <router-view v-slot="{ Component , route}">
        <Transition name="fade" mode="out-in" >
          <component :is="Component" :model="model"/>
        </Transition>
      </router-view>
    </div>
    <!-- <Dock />
    <BottomMenuFloat /> -->
    <window-bar :title="model.title" :icon="3" />
    <BottomMenuFloatItems />
  </div>
</template>
<script >
// import BottomMenuFloat from '@components/menu/bottommenu-float.vue'
// import Dock from '@components/widgets/Dock.vue'
import BottomMenuFloatItems from '@components/menu/bottommenu-float-items.vue'
import WindowBar from '@components/widgets/WindowBar.vue'
import { reactive } from 'vue'
export default {
  watch: {
  },
  components: { 
    // BottomMenuFloat ,
    // Dock
    BottomMenuFloatItems ,
    WindowBar
  },
  setup() {
    const model = reactive({
      name: 'attendant' ,
      module: 'attendants' ,
      title: 'វត្តមាន'
    })
    return {
      model
    }
  },
  name: "AttendantPage", 
  data() {
      return {};
  },
  computed: {},
  mounted() {
  },
  methods: {}
}
</script>
<style scoped>
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
