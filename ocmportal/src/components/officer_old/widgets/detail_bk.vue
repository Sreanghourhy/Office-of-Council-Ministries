<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <n-card class="w-11/12 xl:w-7/12 lg:w-7/12 md:w-8/12 sm:w-11/12 font-pvh text-xl p-0 " :bordered="false" size="small">
          <!-- Form edit account -->
          <div class="card relative border border-gray-300 rounded p-8 -my-3 -mx-4">
            <div v-if="record != undefined " class="flex flex-initial" >
              <!-- Column 1 -->
              <div class="flex-none p-4 " >
                <div class="w-full mb-2" >
                  <div class="w-14 h-14 mx-auto bg-center bg-no-repeat bg-white bg-contain border-gray-200 " :style=" 'background-image: url(' + ocmLogoUrl + ');' " ></div>
                  <div class="w-full font-moul text-center text-yellow-500 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                </div>
                <!-- Picture -->
                <div class="w-24 overflow-hidden lg:w-40 md:w-32 mx-auto bg-center bg-no-repeat bg-white bg-cover rounded border border-gray-200 " >
                  <img 
                  class="w-full mx-auto"
                  :src="record.image!=''? record.image : ocmLogoUrl "  />
                </div>
                <!-- Officer ID -->
                <div class="w-full h-6 text-center mx-auto my-2 font-bold " >OCM-ORG-{{ record.id }}</div>
                <!-- QR CODE -->                
                <qrcode-vue :value="'OCM-ORG-'+record.id" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" />
              </div>
              <!-- Column 2 -->
              <div class="flex-grow p-4" >
                <!-- Tab -->
                <n-tabs type="segment" animated>
                  <n-tab-pane name="officer-detail" tab="ព័ត៌មានក្នុងស្ថាប័ន">
                    <div class="py-4" >
                      <div v-if="record.people != null && record.people != undefined" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex font-moul">{{ record.countesy != undefined && record.countesy != null ? record.countesy.name : "" }} {{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                      <div v-if="record.code != null && record.code.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អត្តលេខ ៖ {{ $toKhmer( record.code ) }}</div>
                      <div v-if="record != null && record.position != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">តួនាទី ៖ {{ record.position.name }}</div>
                      <div v-if="record != null && record.organization != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អង្គភាព ៖ {{ record.organization.name }}</div>
                    </div>
                  </n-tab-pane>
                  <n-tab-pane name="account-detail" tab="ព័ត៌មានគណនី">
                    <div class="py-4" >
                      <!-- username -->
                      <div v-if="record.user.username != null && record.user.username.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ឈ្មោះប្រើប្រាស់ក្នុងប្រព័ន្ធ ៖ {{ record.user.username }}</div>
                      <!-- phone -->
                      <div v-if="record.user.phone != null && record.user.phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ទូរស័ព្ទ ៖ {{ $toKhmer( record.user.phone ) }}</div>
                      <!-- email -->
                      <div v-if="record.user.email != null && record.user.email.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អ៊ីមែល ៖ {{ record.user.email }}</div>
                      <!-- last login -->
                      <div v-if="record.user.last_login != null && record.user.last_login.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ចូលចុងក្រោយ ៖ {{ $toKhmer( dateFormat( new Date( record.user.last_login ) , 'dd-mm-yyyy' ) ) }}</div>
                      <!-- ip -->
                      <div v-if="record.user.ip != null && record.user.ip.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខម៉ាស៊ីន ៖ {{ $toKhmer( record.user.ip ) }}</div>
                      <!-- login_count -->
                      <div v-if="record.user.login_count != null && parseInt( record.user.login_count ) > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">បានចូលចំនួន ៖ {{ $toKhmer( record.user.login_count ) }}</div>
                    </div>
                  </n-tab-pane>
                  <n-tab-pane name="backgroud-information" tab="ព័ត៌មានផ្ទាល់ខ្លួន">
                    <div class="py-4" >
                      <!-- Countesies , Name -->
                      <div v-if="record.people != null && record.people != undefined" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex font-moul">{{ record.countesy != undefined && record.countesy != null ? record.countesy.name : "" }} {{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                      <!-- Officer Date of birth -->
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.nid != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខអត្តសញ្ញាណបណ្ណ ៖ {{ $toKhmer( record.people.nid ) }}</div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.dob != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ថ្ងៃ ខែ ឆ្នាំ កំណើត ៖ {{ $toKhmer( dateFormat( new Date(record.people.dob) , 'dd-mm-yyyy' ) ) }}</div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.mobile_phone != null && record.people.mobile_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទផ្ទាល់ខ្លួន ៖ {{ $toKhmer( record.people.mobile_phone ) }}</div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.office_phone != null && record.people.office_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទការិយាល័យ ៖ {{ $toKhmer( record.people.office_phone ) }}</div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.people.marry_status == 'married' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                        រៀបការរួច
                        <svg class="w-4 h-4 text-pink-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M8 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M24 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M26 30h-4a2 2 0 0 1-2-2v-7h2v7h4v-9h2v-6a1 1 0 0 0-1-1h-6.42L16 20l-4.58-8H5a1 1 0 0 0-1 1v6h2v9h4v-7h2v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h7.58L16 16l3.42-6H27a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2z" fill="currentColor"></path></svg>
                      </div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.marry_status == 'single' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                        នៅលីវ
                        <svg class="w-4 h-4 text-blue-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 30h-4a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2zm-5-18a.94.94 0 0 0-1 1v6h2v9h4v-9h2v-6a.94.94 0 0 0-1-1z" fill="currentColor"></path><path d="M16 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path></svg>
                      </div>
                      <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.marry_status == 'devorced' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                        ពោះមាយ / មេមាយ
                        <svg class="w-4 h-4 text-blue-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M13 12a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v1.5C2 15.554 4.088 17 7.5 17c.459 0 .893-.026 1.302-.076l-.363-.363a1.494 1.494 0 0 1-.359-.576c-.187.01-.38.015-.58.015C4.579 16 3 14.907 3 13.5V12a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v.085a1.496 1.496 0 0 1 1 1.414V12zm5 .5c0 .425-.065.822-.193 1.185l-.829-.828c.015-.115.022-.234.022-.357V12a1 1 0 0 0-1-1h-2.171a3 3 0 0 0-.594-1H16a2 2 0 0 1 2 2v.5zm-7-7a3.5 3.5 0 1 0-7 0a3.5 3.5 0 0 0 7 0zm-6 0a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0zm12 1a2.5 2.5 0 1 0-5 0a2.5 2.5 0 0 0 5 0zm-4 0a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm-1.854 11.354a.5.5 0 0 0 .708-.708L10.707 16h5.586l-1.147 1.146a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708.708L16.293 15h-5.586l1.147-1.146a.5.5 0 0 0-.708-.708l-2 2a.5.5 0 0 0 0 .708l2 2zM11.243 15h1.325h-1.325z" fill="currentColor"></path></g></svg>
                      </div>
                    </div>
                  </n-tab-pane>
                </n-tabs>
                <!-- End Tab -->                
              </div>
            </div>
            <Frame4Corner />
          </div>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

import Frame4Corner from './../../widgets/frame/corner4.vue'
import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from './../../../assets/logo.svg'
import dateFormat from 'dateformat'

export default {
  components: {
    
    Frame4Corner ,
    QrcodeVue
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
          id: 0 ,
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          nid: '' ,
          dob: '' ,
          marry_status: '' ,
          email: '' ,
          phone: '' ,
          person: null ,
          orgainzations: [] ,
          positions: [] ,
          countesies: []
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

    const selectedOrganizations = ref([])
    const selectedPositions = ref([])

    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 
    

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
      props.onClose( actionStatus )
    }
  
    function maskOrEscClick(){
      props.onClose( 0 )
    }

    function initial(){
      // selectedOrganizations.value = [463]
    }

    return {
      /**
       * Variables
       */
      rules ,
      organizations ,
      positions ,
      /**
       * Functions
       */
      initial ,
      clearRecord ,
      maskOrEscClick  ,
      ocmLogoUrl ,
      dateFormat
    }
  }
}
</script>