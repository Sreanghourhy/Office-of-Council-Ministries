<template>
  <!-- Form edit account -->
    <div class="vcb-pdf-preview font-ktr relative">
      <n-modal v-bind:show="show" :on-after-leave="onClose" :on-after-enter="initial" transform-origin="center">
        <div class="table-loading fixed flex left-0 top-0 right-0 bottom-0 bg-white z-40">
          <!-- <n-watermark
            content="ទីស្ដីការគណៈរដ្ឋមន្ត្រី"
            cross
            selectable
            :font-size="16"
            :line-height="16"
            :width="192"
            :height="150"
            :x-offset="12"
            :y-offset="28"
            :rotate="-10" 
            class="w-full"
          > -->
            <vue-pdf-embed :source="pdf.url" class="w-full h-screen overflow-y-scroll" />
          <!-- </n-watermark> -->
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="absolute text-red-500 top-2 right-6 p-2 border border-gray-300 cursor-pointer bg-opacity-50 hover:bg-opacity-100 duration-300 bg-white shadow-md rounded-full" @click="closePdf" >
                <svg class="w-8 h-8 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z" fill="currentColor"></path></svg>
              </div>
            </template>បិទឯកសារយោង
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
import { reactive } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
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
          pdf: NumberSmall7
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

    
    const pdf = reactive({
      viewer: false ,
      filename: '' ,
      url: ''
    })
    function pdfPreview(){
      
      if( props.record.pdf ){
        store.dispatch(props.model.name+'/pdf',{id:props.record.id})
          .then( res => {
            pdf.filename = res.data.filename
            pdf.url = res.data.pdf
            pdf.viewer = true
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
      props.onClose( 1 )
      pdf.url = ""
      pdf.viewer = false

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
    }
  }
}
</script>