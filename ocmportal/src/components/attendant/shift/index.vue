<template>
  <div class="w-full relative flex flex-wrap" >
    <top-menu />
    <!-- <router-view ></router-view> -->
    <router-view v-slot="{ Component }">
      <transition :name="$route.meta.transition || 'fade'">
        <component :is="Component" />
      </transition>
    </router-view>
    <div class="flex flex-wrap bottom-0 mx-auto w-full fixed z-40">
      <FooterComponent />
    </div>
  </div>
</template>
<script >
import TopMenu from './../../menu/topmenu-floattop.vue'
import FooterComponent from './../../footer/copy-right.vue'
export default {
  components: {
    TopMenu ,
    FooterComponent
  } ,
  setup(){

  }
}
</script>