<template>
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <div class="flex flex-wrap w-11/12 font-pvh text-xl p-0 bg-gray-50 min-h-screen relative" >
          <!-- Member Form -->
          <div class=" flex-none min-h-screen absolute left-0 top-0 bottom-0 w-96" >
            <!-- List members -->
            <div v-if="regulators.length && $hasPermission('portal_meeting_link_regulator')" class="w-full absolute left-0 top-12 right-0 bottom-0 overflow-y-auto p-2" >
              <div  v-for="(regulator,index) in regulators" :key="index" class="relative p-1 border-b border-gray-200 cursor-pointer hover:bg-gray-100 duration-300" >
                <div class="member_name" @click=" $hasPermission('portal_meeting_link_regulator') ? toggleMeetingRegulators(regulator) : '' " >
                  <strong>{{(index + 1 )}}</strong>{{  ". " + ( regulator.type != undefined ? regulator.type.desp : '' ) + " - " + regulator.fid + " - " + regulator.year }}
                  <div class="py-1 line-clamp-2" v-html="regulator.objective" ></div>
                </div>
                <svg v-if="regulator.pdf==true" @click="previewRegulators(regulator)" class="absolute top-2 right-1 w-5 text-red-500 cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M30 18v-2h-6v10h2v-4h3v-2h-3v-2h4z" fill="currentColor"></path><path d="M19 26h-4V16h4a3.003 3.003 0 0 1 3 3v4a3.003 3.003 0 0 1-3 3zm-2-2h2a1.001 1.001 0 0 0 1-1v-4a1.001 1.001 0 0 0-1-1h-2z" fill="currentColor"></path><path d="M11 16H6v10h2v-3h3a2.003 2.003 0 0 0 2-2v-3a2.002 2.002 0 0 0-2-2zm-3 5v-3h3l.001 3z" fill="currentColor"></path><path d="M22 14v-4a.91.91 0 0 0-.3-.7l-7-7A.909.909 0 0 0 14 2H4a2.006 2.006 0 0 0-2 2v24a2 2 0 0 0 2 2h16v-2H4V4h8v6a2.006 2.006 0 0 0 2 2h6v2zm-8-4V4.4l5.6 5.6z" fill="currentColor"></path></svg>
                <!-- <div v-if="regulator.organizations.length" class="member_organizations" >{{ regulator.organizations.map( (p) => p.name ).join(' - ') }}</div> -->
              </div>
              <!-- Loading -->
              <Transition name="slide-fade" >
                <div v-if="!regulators.length" class="table-loading absolute flex h-screen left-0 top-0 right-0 bottom-0 bg-white bg-opacity-80 ">
                  <div class="flex mx-auto items-center text-gray-400">ស្វែងរក ឯកសារគតិយុត្ត</div>
                </div>
              </Transition>
            </div>
            <!-- Search box -->
            <div v-if="$hasPermission('portal_meeting_link_regulator')" class="absolute left-0 top-0 right-0 h-12 p-2 border-b border-gray-200 " >
              <n-input type="text" v-model:value="regulatorSearch" @keyup.enter="getRegulators" class="w-full" placeholder="ស្វែងរកឯកសារគតិយុត្តសម្រាប់កិច្ចប្រជុំ..." />
            </div>
          </div>
          <!-- Selected Members -->
          <div :class=" ' border-l border-gray-200 absolute top-0 right-0 bottom-0 ' + ( $hasPermission('portal_meeting_link_regulator') ? ' left-96 ' : ' left-0 ' ) " >
            <div class="absolute left-0 top-12 right-0 bottom-0 overflow-y-auto p-2" >
              <div v-for="(regulator,index) in selectedRegulators" :key="index" class="relative p-2 pr-8 border-b border-gray-200 cursor-pointer hover:bg-gray-100 duration-300" >
                <div class="member_name line-clamp-3" @click=" $hasPermission('portal_meeting_link_regulator') ? toggleMeetingRegulators(regulator) : '' " v-html=" '<strong>' + (index + 1 ) + '</strong>' + '. ' + ( regulator.type != undefined ? regulator.type.desp : '' ) + ' - ' + regulator.fid + ' - ' + regulator.year + ' , ' + regulator.objective" ></div>
                <svg v-if="regulator.pdf==true" @click="previewRegulators(regulator)"  class="absolute top-2 right-1 w-5 text-red-500 cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M30 18v-2h-6v10h2v-4h3v-2h-3v-2h4z" fill="currentColor"></path><path d="M19 26h-4V16h4a3.003 3.003 0 0 1 3 3v4a3.003 3.003 0 0 1-3 3zm-2-2h2a1.001 1.001 0 0 0 1-1v-4a1.001 1.001 0 0 0-1-1h-2z" fill="currentColor"></path><path d="M11 16H6v10h2v-3h3a2.003 2.003 0 0 0 2-2v-3a2.002 2.002 0 0 0-2-2zm-3 5v-3h3l.001 3z" fill="currentColor"></path><path d="M22 14v-4a.91.91 0 0 0-.3-.7l-7-7A.909.909 0 0 0 14 2H4a2.006 2.006 0 0 0-2 2v24a2 2 0 0 0 2 2h16v-2H4V4h8v6a2.006 2.006 0 0 0 2 2h6v2zm-8-4V4.4l5.6 5.6z" fill="currentColor"></path></svg>
              </div>
            </div>
            <div class="selected_members font-moul border-b border-gray-200 absolute left-0 top-0 right-0 h-12 p-2 text-center" >បញ្ជីឯកសារគតិយុត្ត</div>
            <n-drawer v-model:show="regulatorUploadVariables.pdf.show" placement="right" :width="768" >
              <!-- <svg @click="regulatorUploadVariables.pdf.show=!regulatorUploadVariables.pdf.show" class="w-10 absolute right-0 top-0 cursor-pointer hover:text-blue-600 duration-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg> -->
              <n-drawer-content >
                <div class="border rounded border-gray-200 w-full text-sm text-center " >
                  <vue-pdf-embed v-if="regulatorUploadVariables.pdf.show" :source="regulatorUploadVariables.pdf.base64" class="w-full h-screen overflow-y-scroll" />
                </div>
              </n-drawer-content>
            </n-drawer>
          </div>
        </div>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed} from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import QrcodeVue from 'qrcode.vue'
import dateFormat from "dateformat";
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
     * Search Regulator
     */
    const regulators = ref([])
    const regulatorSearch = ref('')
    const selectedRegulators = ref( [] )
    const regulatorUploadVariables = reactive({
      pdf: {
        show: false ,
        base64: ''
      }
    })

    function getRegulators(){
      store.dispatch( props.model.name+'/regulators',{
        search : regulatorSearch.value ,
        perPage : 50 ,
        page : 1
      }).then( res => {
        if( res.data.records.length > 0 ){
          regulators.value = res.data.records
        }else{
          notify.warning({
            'title' : 'ឯកសារគតិយុត្ត' ,
            'description' : 'មិនមានឯកសារគតិយុត្ត។' ,
            duration : 3000
          })
        }
        
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'ឯកសារគតិយុត្ត' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកឯកសារគតិយុត្ត។' ,
          duration : 3000
        })
      })
    }

    function toggleMeetingRegulators(regulator){
      // helper == true -> add member to the meeting, helper == false remove the member from the meeting
      store.dispatch(props.model.name + '/toggleMeetingRegulator',{ regulator : regulator , meeting : props.record })
      .then( res => {
        if( res.data.ok ){
          selectedRegulators.value = res.data.record.regulators 
        }else{
          notify.error({
            'title' : 'ឯកសារគតិយុត្ត' ,
            'description' : res.data.message ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'ឯកសារគតិយុត្ត' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកឯកសារគតិយុត្ត។' ,
          duration : 3000
        })
      } )
    }

    function previewRegulators(regulator){
      store.dispatch('meeting/readRegulator',{
        id: regulator.id ,
      })
      .then( res => {
        regulatorUploadVariables.pdf.base64 = res.data.pdf
        regulatorUploadVariables.pdf.show = true
      }).catch( err => {
        console.log( err )
        notify.error({
          title: 'អានសេចក្ដីព្រាង' ,
          description: 'មានបញ្ហាពេលអានសេចក្ដីព្រាង។' ,
          duration: 3000
        })
      })
    }

    function maskOrEscClick(){
      props.onClose( 1 )
    }

    function initial(){
      getRegulators()
      selectedRegulators.value = props.record.regulators != undefined && props.record.regulators.length > 0 ? props.record.regulators : []
    }

    return {
      /**
       * Variables
       */
      /**
       * Functions
       */
      initial ,
      maskOrEscClick ,
      regulatorSearch ,
      getRegulators ,
      regulators ,
      selectedRegulators ,
      regulatorUploadVariables ,
      toggleMeetingRegulators ,
      previewRegulators
    }
  }
}
</script>