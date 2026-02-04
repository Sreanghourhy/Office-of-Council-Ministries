<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="onClose" :on-mask-click="onClose" :on-after-enter="initial" transform-origin="center">
        <div class="table-loading fixed flex h-screen left-1 top-1 right-1 bottom-1 overflow-hidden bg-white z-40">
          <!-- <n-watermark
            content="ទីស្ដីការគណៈរដ្ឋមន្ត្រី"
            cross
            selectable
            :font-size="8"
            :line-height="16"
            :width="80"
            :height="50"
            :x-offset="12"
            :y-offset="28"
            :rotate="-10" 
            class="w-full"
          > -->
          <vue-pdf-embed 
            :source="pdf.url" 
            :page=" currentPage " 
            @password-requested="handlePasswordRequest"
            @loaded="handleDocumentLoad"
            @rendered="handleDocumentRender"
            class="w-full h-screen p-2 overflow-y-auto "
            />
          <!-- </n-watermark> -->
          <Transition name="slide-fade" >
            <div v-if="isLoading" class="fixed flex left-0 top-0 right-0 bottom-0 bg-white">
              <div class="flex mx-auto items-center">
                <div class="spinner">
                  <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
                  <br/><br/>កំពុងអាន...
                </div>
              </div>
            </div>
          </Transition>
          <div class="fixed left-0 right-0 bottom-1 flex flex-wrap" >
            <Transition name="slide-fade" >
              <!-- This pagination is for the media side with from Medium up -->
              <div v-if="totalPages > 1 && currentPage != null " class="vcb-table-pagination bg-blue-300 mx-auto">
                <!-- Information -->
                <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 " >{{ currentPage > 0 ? "ទំព័រទី " + $toKhmer( currentPage ) : "" }}</div>
                <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 " >{{ totalPages > 0 ? " នៃ " + $toKhmer( totalPages ) + " ទំព័រ" : "" }}</div>
                <!-- Pages (7) -->
                <!-- <div v-for="(page, index) in totalPages" :key="index" :class=" ( currentPage == page ? ' vcb-pagination-page-active ' : ' vcb-pagination-page ' )" @click=" currentPage == page ? false : goTo(page) " >{{ $toKhmer( page ) }}</div> -->
                <!-- First -->
                <div class="vcb-pagination-page p-1" @click="goTo(1)" >
                  <svg class="w-5 h-5 mx-auto" 
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M18.29 17.29a.996.996 0 0 0 0-1.41L14.42 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L12.3 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path><path d="M11.7 17.29a.996.996 0 0 0 0-1.41L7.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L5.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path></svg>
                </div>
                <!-- Previous -->
                <Transition name="slide-fade" >
                  <div class="vcb-pagination-page p-1" @click="goTo( currentPage - 1 )" >
                    <svg class="w-5 h-5 mx-auto" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M14.71 15.88L10.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L8.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.39.39 1.02.39 1.41 0c.38-.39.39-1.03 0-1.42z" fill="currentColor"></path></svg>
                  </div>
                </Transition>
                <!-- Next -->
                <Transition name="slide-fade" >
                  <div class="vcb-pagination-page p-1" @click="goTo( currentPage + 1 )" >
                    <svg class="w-5 h-5 mx-auto" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9.29 15.88L13.17 12L9.29 8.12a.996.996 0 1 1 1.41-1.41l4.59 4.59c.39.39.39 1.02 0 1.41L10.7 17.3a.996.996 0 0 1-1.41 0c-.38-.39-.39-1.03 0-1.42z" fill="currentColor"></path></svg>
                  </div>
                </Transition>
                <!-- Last -->
                <div class="vcb-pagination-page p-1" @click="goTo( totalPages )" >
                  <svg class="w-5 h-5 mx-auto" 
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M5.7 6.71a.996.996 0 0 0 0 1.41L9.58 12L5.7 15.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L7.12 6.71c-.39-.39-1.03-.39-1.42 0z" fill="currentColor"></path><path d="M12.29 6.71a.996.996 0 0 0 0 1.41L16.17 12l-3.88 3.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L13.7 6.7c-.38-.38-1.02-.38-1.41.01z" fill="currentColor"></path></svg>
                </div>
                <!-- Go to -->
                <!-- Total per page -->
              </div>
            </Transition>
          </div>
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="absolute text-red-500 top-2 right-6 p-2 cursor-pointer bg-opacity-50 hover:bg-opacity-100 duration-300 bg-white shadow-md rounded-full" @click="closePdf" >
                <svg class="w-8 h-8 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z" fill="currentColor"></path></svg>
              </div>
            </template>បិទឯកសារយោង
          </n-tooltip>
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="absolute text-blue-500 top-2 left-2 p-2 cursor-pointer bg-opacity-50 hover:bg-opacity-100 duration-300 bg-white shadow-md rounded-full" @click="viewPdfAsHorVer" >
                <!-- full width -->
                <svg v-if="viewMode==false" class="w-8 h-8 "
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6"></path><path d="M10 18H3"></path><path d="M21 18h-7"></path><path d="M6 15l-3 3l3 3"></path><path d="M18 15l3 3l-3 3"></path></g></svg>
                <!-- full height -->
                <svg v-if="viewMode==true" class="w-8 h-8 " 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6"></path><path d="M18 14v7"></path><path d="M18 3v7"></path><path d="M15 18l3 3l3-3"></path><path d="M15 6l3-3l3 3"></path></g></svg>
              </div>
            </template>
            {{ viewMode == true ? "បង្ហាញពេញជំហរ" : "បង្ហាញពេញផ្ដេក" }}
          </n-tooltip>
          <!-- <n-tooltip trigger="hover">
            <template #trigger>
            <div class="absolute top-2 p-2 right-20 cursor-pointer bg-opacity-50 hover:bg-opacity-100 duration-300 bg-white shadow-md rounded-full" @click="copyShareLink" >
              <svg class="w-8 h-8 mx-auto cursor-pointer text-blue-600" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><g fill="none"><path d="M12.475 6h12.05A6.475 6.475 0 0 1 31 12.475v.275a1.25 1.25 0 1 1-2.5 0v-.275A3.975 3.975 0 0 0 24.525 8.5h-12.05A3.975 3.975 0 0 0 8.5 12.475v12.05a3.975 3.975 0 0 0 3.975 3.975h11.616A5.502 5.502 0 0 1 35 29.5A5.5 5.5 0 0 1 24.207 31H12.475A6.475 6.475 0 0 1 6 24.525v-12.05A6.475 6.475 0 0 1 12.475 6zM26.5 29.5a3 3 0 1 0 6 0a3 3 0 0 0-6 0zM17 35.75v-.5a1.25 1.25 0 1 1 2.5 0v.5a3.75 3.75 0 0 0 3.75 3.75h12.5a3.75 3.75 0 0 0 3.75-3.75v-12.5a3.75 3.75 0 0 0-3.75-3.75H23.91a5.502 5.502 0 0 1-10.91-1A5.5 5.5 0 0 1 23.793 17H35.75A6.25 6.25 0 0 1 42 23.25v12.5A6.25 6.25 0 0 1 35.75 42h-12.5A6.25 6.25 0 0 1 17 35.75zm1.5-20.25a3 3 0 1 0 0 6a3 3 0 0 0 0-6z" fill="currentColor"></path></g></svg>
            </div>
            </template>ចែករំលែកឯកសារ
          </n-tooltip> -->
        </div>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive, computed, ref , watch } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'


import dateFormat from "dateformat"
import VuePdfEmbed from 'vue-pdf-embed'

export default {
  components: {
    
    
    VuePdfEmbed
  },
  props: {
    model: {
      type: Object ,
      required: true ,
      default: () => {
        return reactive({
          name: 'Undefined' ,
          title: 'No title'
        })
      },
      // validator: (val) => {}
    } , 
    record: {
      type: Object ,
      required: false ,
      default: () => {
        return reactive({
          id: 0 ,
          fid: '' ,
          title: '' ,
          objective: '' ,
          active: 1 ,
          year: null ,
          pdfs: [] ,
          publish: 0 ,
          types: [] ,
          signatures: [] ,
          organizations: []
        })
      },
      // validator: (val) => {
      //   for(var field in ['id','username','firstname','lastname','email','phone','password','active'] ){
      //     if( !val.hasOwnProperty(field) ) return false
      //   }
      //   return true 
      // }
    },
    show: {
      type: Boolean ,
      default: false
    },
    onClose: {
      type: Function
    } ,
    // onShow: {
    //   type: Function
    // }
  },
  setup(props){
    const store = useStore()
    const message = useMessage()
    const notify = useNotification()
    const btnSavingLoadingRef = ref(false)

    
    const pdf = reactive({
      viewer: false ,
      filename: '' ,
      url: ''
    })
    function pdfPreview(){
      
      if( props.record.pdf ){
        store.dispatch('regulator/pdf',{id:props.record.id})
          .then( res => {
            pdfShareLink.value = res.data.serial != "" ? window.origin+"/#/globalshare/"+res.data.serial : null
            pdf.filename = res.data.filename
            pdf.url = res.data.pdf
            pdf.viewer = true
            // notify.success({
            //   title: "បង្ហាញឯកសារយោង" ,
            //   content: res.data.message ,
            //   duration: 3000
            // })
          }).catch( err => {
            notify.error({
              title: "បង្ហាញឯកសារយោង" ,
              content: err.response.data.message ,
              duration: 3000
            })
          })
      }else{
        notify.info({
          title: 'ឯកសារយោង' ,
          description: "មិនមានឯកសារយោងសម្រាប់បង្ហាញ" ,
          duration: 3000
        })  
      }
    }
    function closePdf(){
      props.onClose()
      pdf.url = ""
      pdf.viewer = false

    }
    const pdfShareLink = ref(null)
    function copyShareLink(){
      if( pdfShareLink.value != "" && pdfShareLink.value != null && pdfShareLink.value != undefined ){
        if (window.isSecureContext) {
          navigator.clipboard.writeText( pdfShareLink.value )
          message.info("អសយដ្ឋាន សម្រាប់ចែករំលែកឯកសារនេះបាន ចម្លងទុកក្នុង Clipboart ។")
        } else {
          dialog.info({
            title: 'ចែករំលែកឯកសារ',
            content: () => 'អសយដ្ឋាននៃឯកសារ សម្រាប់ចែករំលែក ៖ ' + pdfShareLink.value
          })
        }
      }else{
        message.warning("មានបញ្ហាចែករំលែកពេលចម្លង អសយដ្ឋានឯកសារ ចូលក្នុង Clipboart ។")
      }
    }

    const isLoading = ref(true)
    const currentPage = ref( null )
    const totalPages = ref(null)
    const showAllPages = ref( false )
    const viewMode = ref( false ) // false -> height : 100% , true -> width : 100%
    function handleDocumentLoad({numPages}) {
      currentPage.value = parseInt( numPages ) > 5 ? 1 : null 
      totalPages.value = numPages  
    }

    function goTo( page ){
      if( isLoading.value == false ){
        isLoading.value = true
      }
      setTimeout( function(){
        currentPage.value = page
      } , 100 )
    }

    function handleDocumentRender() {
      setTimeout(function(){
        if( isLoading.value == true ){
          isLoading.value = false
        }
      },200)
      let pdfEmbededPage = document.getElementsByClassName('vue-pdf-embed__page')
      if( pdfEmbededPage.length > 0 ){
        let pdfEmbeded = pdfEmbededPage[0] 
        if( pdfEmbeded.children.length > 0 ){
          for( let i in pdfEmbeded.children ){
            if( pdfEmbeded.children[i].nodeName == 'CANVAS' ){
              pdfEmbeded.children[i].attributes.style.value = viewMode.value == false
                ? " display: block; width: auto; height: 98vh; margin: auto; border: 1px solid #CACACA; "
                : " display: block; width: 98%; height: auto; margin: auto; border: 1px solid #CACACA; "
            }
          }
        }
      }
    }
    function viewPdfAsHorVer(){
      isLoading.value = true 
      setTimeout( function(){
        viewMode.value = !viewMode.value
        handleDocumentRender()
      } , 200 )
    }

    function handlePasswordRequest({callback, isWrongPassword}) {
      callback(prompt(isWrongPassword ?
        'Enter password again' :
        'Enter password'
      ))
      console.log( "handlePasswordRequest" )
      console.log( document.getElementsByClassName('vue-pdf-embed__page') )
    }

    function initial(){
      pdfPreview()
    }

    return {
      /**
       * Computed
       */
      /**
       * Variables
       */
      initial ,
      pdf ,
      pdfPreview ,
      closePdf ,
      copyShareLink ,
      isLoading , 
      currentPage ,
      totalPages ,
      showAllPages ,
      viewMode ,
      /**
       * Functions
       */
      handleDocumentLoad ,
      handleDocumentRender ,
      handlePasswordRequest ,
      goTo ,
      viewPdfAsHorVer
    }
  }
}
</script>

<style scoped>
  div.vue-pdf-embed div.vue-pdf-embed__page canvas {
    @apply mx-auto ;
    width: auto !important;
    height: 100vh !important;
  }
</style>