<template>
  <div class="relative w-full min-h-screen" >
    <div class="pt-10">
      <router-view v-slot="{ Component , route}">
        <Transition name="slide-fade" >
          <component :is="Component" />
        </Transition>
      </router-view>
    </div>
    <Dock />
    <Topmenu />
  </div>
</template>
<script >
import Topmenu from './../menu/topmenu.vue'
import Dock from '../widgets/Dock.vue'
export default {
    components: { 
      Topmenu ,
      Dock
    },
    setup() {
      return {}
    },
    name: "PeoplePage", 
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
