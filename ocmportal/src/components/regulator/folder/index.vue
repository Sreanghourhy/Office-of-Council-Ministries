<template>
  <div class="min-h-screen absolute left-40 top-12 right-0 flex flex-wrap" >
    <router-view v-if="$hasPermission('portal_regulator_folder')" v-slot="{ Component }">
      <transition :name="$route.meta.transition || 'slide-fade'">
        <component :is="Component" />
      </transition>
    </router-view>
    <float-top-menu title="ថតឯកសារ" />
    <sidebar />
  </div>
</template>
<script >
import ocmLogoUrl from '@assets/logo.svg'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import Footer from '@components/footer/copy-right.vue'
export default {
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