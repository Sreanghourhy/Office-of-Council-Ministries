<template>
  <div class="vcb-pop-create font-ktr">
    <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" :no-after-leave="clearRecord" transform-origin="center">
      <div class="w-11/12 min-h-screen relative border border-gray-300 bg-gray-50" >
        <div class="w-96 min-h-screen absolute left-0 top-0 bottom-0" >
          <!-- List prengs -->
          <div class="absolute left-0 top-12 bottom-0 right-0" >
            <div v-for="(report,index) in selectedReports" :key="index" class="relative p-1 border-b border-gray-200 cursor-pointer hover:bg-gray-100 duration-300" >
              <div class="meetingSeichdeyPreeng p-1 pr-8 w-full" @click="previewReports(report)" >
                <strong>{{ ( index + 1 )}}</strong> . {{ report.name }}
              </div>
              <svg @click="removeReport(report)" class="w-6 absolute top-2 right-0 text-red-500  cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"></path><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"></path></g></svg>
            </div>
          </div>
          <!-- Search box -->
          <div class="absolute left-0 top-0 right-0 h-10 p-2 font-moul border-b border-gray-200 leading-7 " >
            លទ្ធផលកិច្ចប្រជុំ
            <svg @click="reportUploadVariables.show=!reportUploadVariables.show" class="w-10 absolute right-0 top-0 cursor-pointer hover:text-blue-600 duration-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg>
            <n-drawer v-model:show="reportUploadVariables.show" placement="right" :width="500" :onAfterLeave="clearReportUpload" >
              <n-drawer-content >
                <template #header >
                  បញ្ចូល លទ្ធផលកិច្ចប្រជុំ
                  <div @click="uploadReports" class="w-24 h-8 p-2 absolute right-2 top-2 text-center border border-green-600 rounded text-green-700 cursor-pointer " >រក្សារទុក</div>
                </template>
                <input type="file" multiple @change="fileChangeReports" class="hidden" id="reports" />
                <div class="border rounded border-gray-200 w-full text-sm text-center " >
                  <div class="no-files-upload h-full w-full p-2 cursor-pointer hover:text-green-500 duration-500" @click="clickUploadReports" >
                    <svg  class="w-12 mx-auto" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg>
                    <div class="w-full my-2 " >សូមបញ្ចូលរបាយការណ៍ សម្រាប់កិច្ចប្រជុំ</div>
                  </div>
                  <div v-if="reportUploadVariables.files.length" class="list-files-upload w-full p-4" >
                    <div class="selectedFiles w-full text-left border-b border-gray-100 py-2" v-for="(pdf,index) in reportUploadVariables.files" :key="index" v-html="(index+1) + '. ' + pdf.name + ' , ទំហំ៖ ' + (pdf.size/1024/1024).toFixed(2) + ' មេកាបៃ (MB)' " ></div>
                  </div>
                </div>
              </n-drawer-content>
            </n-drawer>
          </div>
        </div>
        <!-- Selected Members -->
        <div class="absolute left-96 top-0 right-0 bottom-0 border-l border-gray-200" >
          <div class="w-full flex items-center" >
            <div v-if="!reportUploadVariables.pdf.show" class="w-full text-center text-2xl text-gray-400 p-16" >
              <svg class="mt-20 mx-auto w-60 text-gray-300 mb-8" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 384 512"><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5c-17.2-10.5-28.7-25-36.8-46.3c3.9-16.1 10.1-40.6 5.4-56c-4.2-26.2-37.8-23.6-42.6-5.9c-4.4 16.1-.4 38.5 7 67.1c-10 23.9-24.9 56-35.4 74.4c-20 10.3-47 26.2-51 46.2c-3.3 15.8 26 55.2 76.1-31.2c22.4-7.4 46.8-16.5 68.4-20.1c18.9 10.2 41 17 55.8 17c25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35c-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8c-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7c8.3 15.1 18.9 27.2 30.1 35.5c-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z" fill="currentColor"></path></svg>
            </div>
            <vue-pdf-embed v-if="reportUploadVariables.pdf.show" :source="reportUploadVariables.pdf.url" class="w-full h-screen overflow-y-scroll" />
          </div>
          <svg @click="clearReportPdf" class="w-10 absolute right-6 top-4 text-red-500 cursor-pointer bg-white bg-opacity-85 rounded-full p-1 shadow-md border border-gray-200 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M26 20h-6v-2h6z" fill="currentColor"></path><path d="M30 28h-6v-2h6z" fill="currentColor"></path><path d="M28 24h-6v-2h6z" fill="currentColor"></path><path d="M17.003 20a4.895 4.895 0 0 0-2.404-4.173L22 3l-1.73-1l-7.577 13.126a5.699 5.699 0 0 0-5.243 1.503C3.706 20.24 3.996 28.682 4.01 29.04a1 1 0 0 0 1 .96h14.991a1 1 0 0 0 .6-1.8c-3.54-2.656-3.598-8.146-3.598-8.2zm-5.073-3.003A3.11 3.11 0 0 1 15.004 20c0 .038.002.208.017.469l-5.9-2.624a3.8 3.8 0 0 1 2.809-.848zM15.45 28A5.2 5.2 0 0 1 14 25h-2a6.5 6.5 0 0 0 .968 3h-2.223A16.617 16.617 0 0 1 10 24H8a17.342 17.342 0 0 0 .665 4H6c.031-1.836.29-5.892 1.803-8.553l7.533 3.35A13.025 13.025 0 0 0 17.596 28z" fill="currentColor"></path></svg>
        </div>
      </div>
    </n-modal>
  </div>
  <!-- End of edit account -->
</template>
<script>
import { reactive , ref } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification , useDialog} from 'naive-ui'
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
  const dialog = useDialog()

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

  /**
   * Report upload
   */
  const reports = ref([])
  const selectedReports = ref( [] )
  const reportUploadVariables = reactive({
    show : false ,
    files : [] ,
    base64: [] ,
    pdf: {
      show: false ,
      url: ''
    }
  })

  function clickUploadReports(){
    document.getElementById('reports').click()
  }

  function uploadReports(){
    let formData = new FormData()
    formData.append('id', props.record.id )
    for( var i in reportUploadVariables.files ){
      formData.append('files[]', reportUploadVariables.files[i] )  
    }
    notify.info({
      title: 'រក្សារទុកព័ត៌មាន' ,
      description: 'កំពុងបញ្ចូល សេចក្ដីព្រាង។' ,
      duration: 3000
    })
    store.dispatch('meeting/uploadReports', formData )
    .then( res => {
      notify.success({
        title: 'រក្សារទុកព័ត៌មាន' ,
        description: 'បានបញ្ចូល សេចក្ដីព្រាង រួចរាល់។' ,
        duration: 3000
      })

      reportUploadVariables.show = false
      props.record.reports = res.data.record.reports
      selectedReports.value = props.record.reports
      document.getElementById('reports').value = []

    }).catch( err => {
      notify.error({
        title: 'រក្សារទុកព័ត៌មាន' ,
        description: 'មានបញ្ហាពេលបញ្ចូលឯកសារយោង។' ,
        duration: 3000
      })
    })
  }

  function fileChangeReports(event){
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
      let allowed_size_mb = 25 ;

      // Validate file type
      if(allowed_mime_types.indexOf(file.type) == -1) {
        notify.error({
          title: "ឯកសារយោង" ,
          description: "ឯកសារនេះជាប្រភេទ ៖ "+ file.type +"។ អនុញ្ញាតតែឯកសារដែលមានប្រភេទជា PDF។" ,
          duration: 3000
        })
        return;
      }

      // Validate file size
      if(file.size > allowed_size_mb*1024*1024) {
        notify.error({
          title: "ឯកសារយោង" ,
          description: "ទំហំនៃឯកសារគឺ ៖ " + (file.size/1024/1024).toFixed(2) + " មេកាបៃ (MB) លើលទំហំដែលកំណត់គឺ ៥ មេកាបៃ។" ,
          duration: 3000
        })
        return;
      }

      if( file.size <= 0 ){
        notify.error({
          title: "ឯកសារយោង" ,
          description: "ទំហំនៃឯកសារគឺ ៖ 0។" ,
          duration: 3000
        })
        return;
      }

      let reader = new FileReader();
      reader.onerror = function(e) {
        // console.log('On error');
      };
      reader.onprogress = function(e) {
        // console.log('On progress');
      };
      reader.onabort = function(e) {
        // console.log('On abort');
      };
      reader.onloadstart = function(e) {
        // console.log( "On load start" )
      };
      reader.onload = function(e) {
        // Ensure that the progress bar displays 100% at the end.
        console.log( 'On load' )
        /**
         * Read binary string from 'e.target.result' and convert to base64
         */
        //  preengUploadVariables.files.push( btoa( e.target.result ) );
        // formData.append('files', btoa( e.target.result ) )
      }
      // // // Read in the image file as base64 type
      // // reader.readAsDataURL(file);
      reader.readAsBinaryString(file);

      // // Read in the image file as base64 type
      // props.record.pdfs.push( window.URL.createObjectURL( file ) )
      reportUploadVariables.files.push( file )
    }
  }

  function previewReports(report){
    store.dispatch('meeting/readReport',{
      id: props.record.id ,
      serial: report.serial
    })
    .then( res => {
      reportUploadVariables.pdf.url = res.data.pdf
      reportUploadVariables.pdf.show = true
    }).catch( err => {
      console.log( err )
      notify.error({
        title: 'អានរបាយកាណ៍' ,
        description: 'មានបញ្ហាពេលអានរបាយការណ៍។' ,
        duration: 3000
      })
    })
  }
  
  function removeReport(report){
    dialog.warning({
      title: 'លុបរបាយណ៍',
      content: 'តើអ្នកចង់លុបរបាយការណ៍ '+ report.name +' មែនទេ?',
      positiveText: 'បាទ / ចាស',
      negativeText: 'ទេ',
      onPositiveClick: () => {
        store.dispatch('meeting/removeReport',{
          id: props.record.id ,
          serial: report.serial
        })
        .then( res => {
          props.record.reports = res.data.record.reports
          selectedReports.value = res.data.record.reports
        }).catch( err => {
          console.log( err )
          notify.error({
            title: 'លុបរបាយណ៍' ,
            description: 'មានបញ្ហាពេលលុបរបាយណ៍។' ,
            duration: 3000
          })
        })
      },
      onNegativeClick: () => {
        
      }
    })
  }

  function clearReportUpload(){
    document.getElementById('reports').value = []
    reportUploadVariables.files = [] 
    reportUploadVariables.base64 = [] 
  }

  function clearReportPdf(){
    reportUploadVariables.pdf.url = ''
    reportUploadVariables.pdf.show = false
  }

  function removePdf(index){
    pdfs.value.splice( index , 1 )
  }

  function maskOrEscClick(){
    props.onClose( 1 )
  }

  function initial(){
    selectedReports.value = props.record.reports != undefined && props.record.reports.length > 0 ? props.record.reports : []
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
    removePdf , 
    reports ,
    selectedReports ,
    reportUploadVariables ,
    clickUploadReports ,
    uploadReports ,
    fileChangeReports ,
    previewReports ,
    removeReport ,
    clearReportUpload ,
    clearReportPdf
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