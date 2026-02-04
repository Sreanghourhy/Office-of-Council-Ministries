<template>
  <div class="relative w-full min-h-screen bg-gray-50 bg-center bg-cover bg-background" >
    <div class="absolute p-4 top-16 right-0 bottom-0 left-0 ">
      <router-view v-slot="{ Component , route}">
        <Transition name="fade" mode="out-in" >
          <component :is="Component" />
        </Transition>
      </router-view>
    </div>
    <Dock />
    <Topmenu />
  </div>
</template>
<script >
import Topmenu from './../../menu/topmenu.vue'
import Dock from '../../widgets/Dock.vue'
export default {
    components: { 
      Topmenu ,
      Dock
    },
    setup() {
      return {}
    },
    name: "RolePage", 
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
