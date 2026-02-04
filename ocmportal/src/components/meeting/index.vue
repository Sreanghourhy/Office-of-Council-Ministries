<template>
  <div class="absolute left-40 top-12 right-0 flex flex-wrap" >
    <router-view v-if="$hasPermission('portal_meeting_listing')" v-slot="{ Component }">
      <transition :name="$route.meta.transition || 'slide-fade'">
        <component :is="Component" :model="model" />
      </transition>
    </router-view>
    <float-top-menu title="កិច្ចប្រជុំ" />
    <sidebar />
  </div>
</template>
<script >
import ocmLogoUrl from '@assets/logo.svg'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import Footer from '@components/footer/copy-right.vue'
import { reactive } from 'vue'
export default {
  components: {
    FloatTopMenu ,
    Sidebar ,
    Footer ,
    ocmLogoUrl
  } ,
  setup(){
    const model = reactive({
      name: 'meeting' ,
      module: 'meetings' ,
      title: 'កិច្ចប្រជុំ'
    })

    return {
      model
    }
  }
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
