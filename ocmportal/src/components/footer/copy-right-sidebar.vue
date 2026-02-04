<template>
  <div class="w-full py-1 text-gray-500 mx-auto break-words bg-white print:hidden">
    <div class="text-center copy-rightleading-9 flex cursor-pointer justify-center flex-wrap text-gray-400" @click="toggleAbout=true" >
      <div class="mx-2 p-1 h-5 text-xxxs" >
        &copy; រក្សារសិទ្ធិគ្រប់យ៉ាង {{ $toKhmer( dateFormat( new Date() , 'yyyy' ) ) }}
      </div>
      <!-- <div class="mx-2 p-1 h-5 text-xs " >អគ្គនាយកដ្ឋានបរិវត្តកម្មឌីជីថល</div> -->
      <div class="mx-2 p-1 h-5 text-xxxs " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
    </div>
  </div>
  <n-modal v-model:show="toggleAbout" class="bg-white rounded" :block-scroll="false" >
    <div v-if="toggleAbout" class="relative about-us p-16 pb-20" >
      <div class="w-20 mx-auto my-4">
        <img src="./../../assets/logo.svg" alt="SASTRA Logo" class="w-full" >
      </div>
      <div class="w-full font-moul text-center leading-9 text-xs" >ក្រោមការណែនាំដ៏ខ្ពង់ខ្ពស់របស់<br/>ឧបនាយករដ្ឋមន្ត្រី រដ្ឋមន្ត្រីទទួលបន្ទុកទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
      <div class="font-tacteing w-full text-center h-4 leading-4 text-4xl" >6</div>
      <div class="w-full text-center font-moul leading-9 text-xs" >{{ systemName }}<br/>អភិវឌ្ឍន៍ដោយ<br/>អគ្គនាយកដ្ឋានបរិវត្តកម្មឌីជីថល<br/>កំណែប្រែ ១.០</div>        
      <FrameCorner4Component />
    </div>
  </n-modal>
</template>
<script >
import { reactive, computed, ref, onMounted } from 'vue'
import FrameCorner4Component from '../widgets/frame/corner4.vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import dateFormat from 'dateformat'
/**
 * CRUD component form
 */
export default {
  components: {
    FrameCorner4Component
  },
  name: "Footer" ,
  setup(){
    const store = useStore();
    const toggleAbout = ref(false)

    const systemName = computed( () => {
      return store.state.system.name != "" ? store.state.system.name : 'ប្រព័ន្ធបណ្ដុំឯកសារ'
    })

    return {
      toggleAbout ,
      systemName ,
      dateFormat
    }
  }
}
</script>
<style scoped>
</style>