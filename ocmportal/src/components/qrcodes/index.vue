<template>
  <div class="min-h-screen absolute left-40 top-12 right-0 flex flex-wrap" >
    <!-- <router-view ></router-view> -->
    <router-view v-if="$hasPermission('portal_attendant_qrcodes')" v-slot="{ Component }">
      <transition :name="$route.meta.transition || 'slide-fade'">
        <component :is="Component" />
      </transition>
    </router-view>
    <float-top-menu title="QRCode វត្តមាន" />
    <sidebar />
  </div>
</template>
<script >
import ocmLogoUrl from '@assets/logo.svg'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import Footer from '@components/footer/copy-right.vue'
export default {
  watch: {
  },
  components: {
    FloatTopMenu ,
    Sidebar ,
    Footer ,
    ocmLogoUrl
  } ,
  setup(){

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
