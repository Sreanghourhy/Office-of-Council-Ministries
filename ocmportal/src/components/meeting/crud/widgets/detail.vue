<template>
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <n-card class="w-11/12 xl:w-7/12 lg:w-7/12 md:w-8/12 sm:w-11/12 font-pvh text-xl p-0 " :bordered="false" size="small">
          <div class="card relative border border-gray-300 rounded p-8 -my-3 -mx-4">
            <div v-if="record.person != undefined " class="flex flex-initial" >
              <div class="flex-none p-4 " >
                <div class="w-full mb-2" >
                  <div class="w-14 h-14 mx-auto bg-center bg-no-repeat bg-white bg-contain border-gray-200 " :style=" 'background-image: url(' + $assets('logo.png') + ' )' " ></div>
                  <div class="w-full font-moul text-center text-yellow-500 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                </div>
                <div class="w-24 h-24 lg:w-40 lg:h-40 md:w-32 md:h-32  mx-auto bg-center bg-no-repeat bg-white bg-cover rounded border border-gray-200 " :style=" 'background-image: url(' + (record.avatar_url!=''? record.avatar_url:'/src/assets/logo.png') +');' " ></div>
                <div class="w-full h-6 text-center mx-auto my-2 font-bold " >OCM-ORG-{{ record.id }}</div>
                <qrcode-vue :value="'OCM-ORG-'+record.id" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" />
              </div>
              <div class="flex-grow p-4" >
                <n-tabs type="segment" animated>
                  <n-tab-pane name="account-detail" tab="ព័ត៌មានគណនី">
                    <div class="py-4" >
                      <!-- <div v-if="record.username != null && record.username.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ឈ្មោះប្រើប្រាស់ក្នុងប្រព័ន្ធ ៖ {{ record.username }}</div>
                      <div v-if="record.phone != null && record.phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ទូរស័ព្ទ ៖ {{ record.phone }}</div>
                      <div v-if="record.email != null && record.email.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អ៊ីមែល ៖ {{ record.email }}</div>
                      <div v-if="record.last_login != null && record.last_login.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ចូលចុងក្រោយ ៖ {{ record.last_login }}</div>
                      <div v-if="record.ip != null && record.ip.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខម៉ាស៊ីន ៖ {{ record.ip }}</div>
                      <div v-if="record.login_count != null && parseInt( record.login_count ) > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">បានចូលចំនួន ៖ {{ record.login_count }}</div> -->
                    </div>
                  </n-tab-pane>
                  <n-tab-pane name="backgroud-information" tab="ព័ត៌មានផ្ទាល់ខ្លួន">
                    <!-- <div class="py-4" >
                      <div class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex font-moul">{{ userCountesies }} {{ record.person.lastname + " " + record.person.firstname }}</div>
                      <div v-if="record.person != null && record.person.organizations != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អង្គភាព ៖ {{ record.person.organizations.map( (o) => o.name ).join( ', ' )}}</div>                      
                      <div v-if="record.person != null && record.person.positions != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">តួនាទី ៖ {{ record.person.positions.map( (o) => o.name ).join( ', ' )}}</div>
                      <div v-if="record.person != null && record.person.nid != null && record.person.nid.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខអត្តសញ្ញាណបណ្ណ ៖ {{ record.person.nid }}</div>
                      <div v-if="record.person != null && record.person.dob != null && record.person.dob.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ថ្ងៃ ខែ ឆ្នាំ កំណើត ៖ {{ record.person.dob }}</div>
                      <div v-if="record.person != null && record.person.mobile_phone != null && record.person.mobile_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទផ្ទាល់ខ្លួន ៖ {{ record.person.mobile_phone }}</div>
                      <div v-if="record.person != null && record.person.office_phone != null && record.person.office_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទការិយាល័យ ៖ {{ record.person.office_phone }}</div>
                      <div v-if="record.person != null && record.person.marry_status != null && record.person.marry_status == 'married' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                        រៀបការរួច
                        <svg class="w-4 h-4 text-pink-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M8 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M24 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M26 30h-4a2 2 0 0 1-2-2v-7h2v7h4v-9h2v-6a1 1 0 0 0-1-1h-6.42L16 20l-4.58-8H5a1 1 0 0 0-1 1v6h2v9h4v-7h2v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h7.58L16 16l3.42-6H27a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2z" fill="currentColor"></path></svg>
                      </div>
                      <div v-if="record.person != null && record.person.marry_status != null && record.person.marry_status == 'single' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                        នៅលីវ
                        <svg class="w-4 h-4 text-blue-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 30h-4a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2zm-5-18a.94.94 0 0 0-1 1v6h2v9h4v-9h2v-6a.94.94 0 0 0-1-1z" fill="currentColor"></path><path d="M16 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path></svg>
                      </div>
                    </div> -->
                  </n-tab-pane>
                </n-tabs>
                <!-- End Tab -->                
              </div>
            </div>
          </div>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import QrcodeVue from 'qrcode.vue'

export default {
  components: {
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
      props.onClose( actionStatus )
    }

    function update(){
      // if( props.record.phone == "" && props.record.email == "" ){
      //   notify.warning({
      //     title: 'ពិនិត្យព័ត៌មាន' ,
      //     description: 'សូមបំពេញ លេខទូរស័ព្ទ ឬ អ៊ីមែល' ,
      //     duration: 2000
      //   })
      //   return false
      // }
      // if( props.model === undefined || props.model.name == "" ){
      //   notify.warning({
      //     title: 'ពិនិត្យព័ត៌មាន' ,
      //     description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
      //     duration: 2000
      //   })
      //   return false
      // }
      
      // store.dispatch( props.model.name+'/update',{
      //   id: props.record.id ,
      //   username: props.record.username ,
      //   firstname: props.record.firstname ,
      //   lastname: props.record.lastname ,
      //   phone: props.record.phone ,
      //   email: props.record.email.toLowerCase() ,
      //   organizations: selectedOrganizations.value ,
      //   positions: selectedPositions.value ,
      // }).then( res => {
      //   if( res.data.ok ){
      //     notify.success({
      //       title: 'រក្សារទុកព័ត៌មាន' ,
      //       description: res.data.message ,
      //       duration: 2000
      //     })
      //     clearRecord( 1 )
      //   }else{
      //     notify.error({
      //       title: 'រក្សារទុកព័ត៌មាន' ,
      //       description: 'មានបញ្ហាក្នុងពេលរក្សារទុកព័ត៌មាន។' ,
      //       duration: 2000
      //     })
      //   }
      // }).catch( err => {
      //   message.error( err )
      // })
      clearRecord( 0 )
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
      /**
       * Functions
       */
      update  ,
      initial ,
      clearRecord ,
      maskOrEscClick
    }
  }
}
</script>