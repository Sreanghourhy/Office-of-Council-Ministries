<template>
  <div class="relative w-full" >
  <!-- Top action panel of crud -->
    <div class="flex title-bar border-b border-gray-200 bg-white ">
      <!-- Title of crud -->
      <div class="flex w-70 h-10 py-1 title px-4" >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><g fill="none"><path d="M16 2a5 5 0 0 0-1.001 9.9v3.099H9.733A2.733 2.733 0 0 0 7 17.732V20.1A5.002 5.002 0 0 0 8 30a5 5 0 0 0 1-9.9v-2.368c0-.405.329-.733.733-.733h12.534c.405 0 .733.328.733.733V20.1a5.002 5.002 0 0 0 1 9.9a5 5 0 0 0 1-9.9v-2.368a2.733 2.733 0 0 0-2.733-2.733H17V11.9A5.002 5.002 0 0 0 16 2zm-3 5a3 3 0 1 1 6 0a3 3 0 0 1-6 0zM5 25a3 3 0 1 1 6 0a3 3 0 0 1-6 0zm19-3a3 3 0 1 1 0 6a3 3 0 0 1 0-6z" fill="currentColor"></path></g></svg>
        <div class="font-moul ml-2 leading-9" v-html="title" ></div>
      </div>
      <!-- Actions button of the crud -->
      <div class="flex-grow action-buttons flex-row-reverse flex px-4">
        <!-- New Button -->
        <div class="mt-1 ml-2 flex flex-wrap">
          
        </div>
        <div class="w-3/5 md:w-2/5 relative" >
          
        </div>
        <div class="mt-1 mr-2 flex flex-wrap">
        </div>
      </div>
    </div>
    <!-- Table of crud -->
    <div class="vcb-table-panel relative ">
      <img src="./../../assets/ocm_org_chart_2024.png" class=""/>
    </div>
  </div>
</template>
<script>
import { reactive ,ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import ocmLogoUrl from './../../assets/logo.svg'
import dateFormat from 'dateformat'
/**
 * CRUD component form
 */
export default {
  name: "People" ,
  components: {
    /**
     * Forms
     */
  },
  setup(){
    const store = useStore()
    const route = useRoute()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()

    const title = ref('អង្គការលេខទីស្ដីការគណៈរដ្ឋមន្ត្រី')
    /**
     * Variables
     */    
    return {
      dateFormat ,
      title
    }
  }
}

</script>
<style type="text/css" scoped >
.vcb-table-pagination-info {
    @apply leading-7; 
  }
.vcb-thumbnail {
  @apply flex flex-wrap justify-center;
}
.vcb-thumbnail .item {
  @apply xl:w-1/5 lg:w-1/4 md:w-1/3 sm:w-1/3 w-1/2 p-2 ;
}
.vcb-thumbnail .item .content {
  @apply border rounded-lg hover:shadow duration-500 p-4 pt-8 relative hover:scale-105 transform-gpu bg-white hover:bg-yellow-100;
}
.vcb-thumbnail .item .content .image {
  @apply border rounded-full border-gray-200 p-2 w-20 h-20 flex-none mx-auto overflow-hidden bg-white ;
}
.vcb-filters-panel {
  @apply fixed left-0 top-10 right-0 bottom-0 bg-opacity-60 bg-white ;
}
.vcb-filters-panel .filter-title {
  @apply w-full text-left p-4 bg-white rounded-lg ;
}
.vcb-filters-panel .filter-actions {
  @apply w-full text-left p-4 flex flex-wrap justify-center;
}
.vcb-filters-panel .filter-actions .filter-action {
  @apply p-2 m-2 bg-white rounded-lg shadow border border-gray-300 w-4/6 sm:w-2/5 md:w-1/3 lg:w-1/4 xl:w-2/6 ;
}
</style>