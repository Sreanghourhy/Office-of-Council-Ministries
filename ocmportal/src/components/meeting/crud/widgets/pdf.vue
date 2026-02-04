<template>
  <div class="vcb-pop-create font-ktr">
    <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" :no-after-leave="clearRecord" transform-origin="center">
      <n-card class="w-11/12 font-pvh text-xl p-0 " :bordered="false" size="small">
        <div class="card relative border border-gray-300 rounded p-4 -my-3 -mx-4" style="min-height: 240px; " >
          <div class="relative title-bar py-3 border-b" >
            <div class="title font-pvh" >សូមជ្រើសរើសឯកសារយោង</div>
            <n-tooltip trigger="hover" >
              <template #trigger >
                <div class="absolute bg-white top-0 right-0 border rounded-full border-gray-200 w-9 h-9 p-1" >
                  <input type="file" placeholder="ឯកសារយោង" @change="fileChange" class="hidden " id="referenceDocument" />
                  <svg 
                    @click="clickUpload"
                    class="text-red-500 w-6 h-6 mx-auto cursor-pointer" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
                </div>
              </template>ជ្រើសរើសឯកសារយោង
            </n-tooltip>
            <n-tooltip trigger="hover" >
              <template #trigger >
                <div class="absolute bg-white top-0 right-12 border rounded-full border-gray-200 w-9 h-9 p-1" >
                  <input type="file" placeholder="រូបភាព" @change="fileChange" class="hidden " id="referenceDocument" />
                  <svg 
                    @click="uploadFiles"
                    class="text-blue-600 w-6 h-6 mx-auto cursor-pointer" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M518.3 459a8 8 0 0 0-12.6 0l-112 141.7a7.98 7.98 0 0 0 6.3 12.9h73.9V856c0 4.4 3.6 8 8 8h60c4.4 0 8-3.6 8-8V613.7H624c6.7 0 10.4-7.7 6.3-12.9L518.3 459z" fill="currentColor"></path><path d="M811.4 366.7C765.6 245.9 648.9 160 512.2 160S258.8 245.8 213 366.6C127.3 389.1 64 467.2 64 560c0 110.5 89.5 200 199.9 200H304c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8h-40.1c-33.7 0-65.4-13.4-89-37.7c-23.5-24.2-36-56.8-34.9-90.6c.9-26.4 9.9-51.2 26.2-72.1c16.7-21.3 40.1-36.8 66.1-43.7l37.9-9.9l13.9-36.6c8.6-22.8 20.6-44.1 35.7-63.4a245.6 245.6 0 0 1 52.4-49.9c41.1-28.9 89.5-44.2 140-44.2s98.9 15.3 140 44.2c19.9 14 37.5 30.8 52.4 49.9c15.1 19.3 27.1 40.7 35.7 63.4l13.8 36.5l37.8 10C846.1 454.5 884 503.8 884 560c0 33.1-12.9 64.3-36.3 87.7a123.07 123.07 0 0 1-87.6 36.3H720c-4.4 0-8 3.6-8 8v60c0 4.4 3.6 8 8 8h40.1C870.5 760 960 670.5 960 560c0-92.7-63.1-170.7-148.6-193.3z" fill="currentColor"></path></svg>
                </div>
              </template>រក្សារទុក
            </n-tooltip>
          </div>
          <div v-if="pdfs.length" class="flex flex-initial justify-center items-center m-8" >
            <div v-for="(pdf, index) in pdfs" :key="index" class="image-stick-top-left w-full" >
              <vue-pdf-embed :source="pdf.dataUrl" class="w-full h-screen overflow-y-scroll" />
              <n-tooltip trigger="hover" >
                <template #trigger>
                  <svg 
                    @click="removePdf(index)"
                    class="delete-icon bg-white bg-opacity-90 rounded-full p-1 w-8 h-8 absolute -top-4 -right-4 text-red-400 cursor-pointer border border-gray-200"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>
                </template>
                ដករូបភាពចេញវិញ
              </n-tooltip>
            </div>
          </div>
        </div>
      </n-card>
    </n-modal>
  </div>
  <!-- End of edit account -->
</template>
<script>
import { reactive , ref } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import QrcodeVue from 'qrcode.vue'
import VuePdfEmbed from 'vue-pdf-embed'


export default {
components: {
  QrcodeVue ,
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
    required: true ,
    default: () => {
      return reactive({
        id: 0
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
  var store = useStore()
  const message = useMessage()
  const notify = useNotification()

  /**
   * Variables
   */    
  var rules = {
      firstname: {
        required: true,
        message: 'សូមបញ្ចូលឈ្មោះ',
        trigger: [ 'blur']
      },
      lastname: {
        required: true,
        message: 'សូមបញ្ចូលត្រកូល',
        trigger: [ 'blur']
      }
  }
  /**
   * Functions
   */
  function clearRecord( actionStatus ){
    pdfs.value = []
  }

  /**
   * File upload
   */
  /**
   * On change
   */
  const pdfs = ref([])
  function fileChange(event){
    pdfs.value = []
    for(const file of event.target.files ){
      // if( index == 'item' || index == 'length' ) continue;
      // allowed types
      let allowed_mime_types = [ 
        /**
         * Image mime type
         */
        // 'image/jpeg', 'image/png' 
        /**
         * Application file mime type
         */
        "application/pdf"
        ];
      
      // allowed max size in MB
      let allowed_size_mb = 2;

      // Validate file type
      if(allowed_mime_types.indexOf(file.type) == -1) {
        notify.error({
          title: "រូបភាព" ,
          description: "ឯកសារនេះជាប្រភេទ៖ "+ file.type +"។ អនុញ្ញាតតែឯកសារដែលមានប្រភេទជា PDF" ,
          duration: 3000
        })
        return;
      }

      // Validate file size
      if(file.size > allowed_size_mb*1024*1024) {
        notify.error({
          title: "រូបភាព" ,
          description: "ទំហំនៃឯកសារគឺ៖ " + (file.size/1024/1024).toFixed(2) + " មេកាបៃ (MB) លើលទំហំដែលកំណត់គឺ " + allowed_size_mb + " មេកាបៃ។" ,
          duration: 3000
        })
        return;
      }

      let reader = new FileReader();
      reader.onerror = function(e) {
      };
      reader.onprogress = function(e) {
      };
      reader.onabort = function(e) {
      };
      reader.onloadstart = function(e) {
      };
      reader.onload = function(e) {
        pdfs.value.push( {
          dataUrl : e.target.result ,
          base64 : btoa( e.target.result ) ,
          file : file 
        } )
      }
      reader.readAsDataURL( file )
    }
  }
  /**
   * On click file upload
   */
  function clickUpload(){
    document.getElementById('referenceDocument').click()
  }
  function uploadFiles(){
    if( pdfs.value.length > 0 && pdfs.value[0].file != undefined && pdfs.value[0].file != null ){
      let formData = new FormData();
      formData.append('id', props.record.id )
      formData.append('files', pdfs.value[0].file )
      notify.info({
        title: 'រក្សារទុកព័ត៌មាន' ,
        description: 'កំពុងបញ្ចូលរូបភាព' ,
        duration: 3000
      })
      store.dispatch(props.model.name+'/uploadPdf', formData ).then( res => {
        notify.success({
          title: 'រក្សារទុកព័ត៌មាន' ,
          description: 'បានបញ្ចូលរួចរាល់។' ,
          duration: 3000
        })
        pdfs.value = []
        props.onClose( 1 )
      }).catch( err => {
        pdfs.value = []
        props.onClose( 0 )
        console.log( err )
        notify.error({
          title: 'រក្សារទុកព័ត៌មាន' ,
          description: 'មានបញ្ហាពេលបញ្ចូលឯកសារយោង។' ,
          duration: 3000
        })
      })
    }else{
      pdfs.value = []
      notify.warning({
        title: 'រក្សារទុកព័ត៌មាន' ,
        description: 'សូមជ្រើសរើសឯកសារយោងមុនពេលរក្សារទុក។' ,
        duration: 3000
      })
    }
  }

  function removePdf(index){
    pdfs.value.splice( index , 1 )
  }

  function maskOrEscClick(){
    props.onClose( 1 )
  }

  function initial(){
  }

  return {
    /**
     * Variables
     */
    rules ,
    
    pdfs ,
    /**
     * Functions
     */
    initial ,
    clearRecord ,
    maskOrEscClick ,
    fileChange ,
    clickUpload ,
    uploadFiles ,
    removePdf
  }
}
}
</script>
<style scoped>
.image-stick-top-left {
  @apply relative bg-white m-4 border border-gray-300 rounded-md p-1 ;
}
/* .image-stick-top-left:hover .delete-icon {
  display: block;
}
.delete-icon {
  display: none;
} */
</style>