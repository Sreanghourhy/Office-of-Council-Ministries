<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick" :on-after-enter="initial" transform-origin="center">
        <n-card class="w-10/12 sm:w-3/4 md:w-8/12 lg:w-3/5 xl:w-7/12" title="បន្ថែមមន្ត្រីមានអត្តលេខ" :bordered="false" size="small">
          <template #header-extra>
            <n-button type="success" @click="create()" >
              <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
              </template>
              រក្សារទុក
            </n-button>
          </template>
          <!-- Form edit account -->
          <div class="crud-create-form w-full border-t">
            <div class=" mx-auto p-4 flex-wrap">
              <div class="crud-form-panel w-full flex flex-wrap ">
                <n-form v-if="record!=null" 
                  class="w-full text-left font-btb text-lg flex flex-wrap" 
                  :label-width="80"
                  :model="record"
                  :rules="rules"
                  size="large"
                  ref="formRef"
                >
                  <n-form-item label="ត្រកូល" path="lastname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.lastname" placeholder="នាមត្រកូល" />
                  </n-form-item>
                  <n-form-item label="ឈ្មោះ" path="firstname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.firstname" placeholder="នាមខ្លួន" />
                  </n-form-item>
                  <n-form-item label="ត្រកូល (អង់គ្លេស)" path="enlastname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.enlastname" placeholder="នាមត្រកូល" />
                  </n-form-item>
                  <n-form-item label="ឈ្មោះ (អង់គ្លេស)" path="enfirstname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.enfirstname" placeholder="នាមខ្លួន" />
                  </n-form-item>
                  <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" path="dob" class="w-4/12 p-1" >
                    <n-date-picker v-model:value="dob" type="date" format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" />
                  </n-form-item>
                  <n-form-item label="" path="gender" class="w-3/12 p-1 " >
                    <n-radio-group v-model:value="record.people.gender" class="mx-auto" >
                      <n-space>
                        <n-radio
                          v-for="gender in [{label:'ស្រី',value:0},{label:'ប្រុស',value:1}]"
                          :key="gender.value"
                          :value="gender.value"
                          :label="gender.label"
                        />
                      </n-space>
                    </n-radio-group>
                  </n-form-item>
                  <n-form-item label="" path="marry" class="w-5/12 p-1" >
                    <n-radio-group v-model:value="record.people.marry_status" class="mx-auto" >
                      <n-space>
                        <n-radio
                        v-for="status in [{label:'នៅលីវ',value:'single'},{label:'រៀបការរួច',value:'married'},{label:'លះលែង',value:'divorced'}]"
                        :key="status.value"
                        :value="status.value"
                        :label="status.label"
                        />
                      </n-space>
                    </n-radio-group>
                  </n-form-item>
                  <n-form-item label="អ៊ីមែល" path="email" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.email" placeholder="អ៊ីមែល" />
                  </n-form-item>
                  <n-form-item label="ទូរស័ព្ទផ្ទាល់ខ្លួន" path="mobile_phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.mobile_phone" placeholder="ទូរស័ព្ទផ្ទាល់ខ្លួន" />
                  </n-form-item>
                  <n-form-item label="លេខអត្តសញ្ញាណបណ្ណ" path="nid" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.nid" placeholder="លេខអត្តសញ្ញាណបណ្ណ" />
                  </n-form-item>
                  <n-form-item label="ទូរស័ព្ទការិយាល័យ" path="phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.office_phone" placeholder="ទូរស័ព្ទការិយាល័យ" />
                  </n-form-item>
                  <n-form-item-row label="អសយដ្ឋានបច្ចុប្បន្ន" >
                    <n-input 
                      placeholder="អសយដ្ឋានបច្ចុប្បន្ន" 
                      class="text-left" 
                      v-model:value="record.people.address" 
                      type="textarea" show-count maxlength="5000" />
                  </n-form-item-row>
                  <n-form-item-row label="ទីកន្លែងកំណើត" >
                    <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                    v-model:value="record.people.pob" 
                    type="textarea" show-count maxlength="5000" />
                  </n-form-item-row>
                  <div class="w-full mt-2 mb-4 py-1 border-b border-gray-200 " >ព័ត៌មានពីក្រសួង ឬ ស្ថាប័នកំពុងនៅ៖</div>
                  <n-form-item label="អត្តលេខ" path="code" class="w-6/12 p-1" >
                    <n-input v-model:value="record.code" placeholder="អត្តលេខ" />
                  </n-form-item>
                  <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចូលពេញសិទ្ធិ (តាំងស៊ុប)" path="officer_dob" class="w-6/12 p-1" >
                    <n-date-picker v-model:value="officer_dob" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" />
                  </n-form-item>
                  <n-form-item label="ទូរស័ព្ទ" path="officer_phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.phone" placeholder="ទូរស័ព្ទ" />
                  </n-form-item>
                  <n-form-item label="លេខិតឆ្លងដែន" path="officer_passport" class="w-1/2 p-1" >
                    <n-input v-model:value="record.passport" placeholder="លេខិតឆ្លងដែន" />
                  </n-form-item>
                  <n-form-item label="អ៊ីមែល" path="officer_email" class="w-full p-1" >
                    <n-input v-model:value="record.email" placeholder="អ៊ីមែល" />
                  </n-form-item>
                  <n-form-item label="ងារ" path="officer_countesy" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedCountesies"
                      filterable
                      placeholder="សូមជ្រើសរើសងារ"
                      :options="countesies"
                      multiple
                    />
                  </n-form-item>
                  <n-form-item label="អង្គភាព" path="officer_organization" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedOrganization"
                      filterable
                      placeholder="សូមជ្រើសរើសអង្គភាព"
                      :options="organizations"
                    />
                  </n-form-item>
                  <n-form-item label="តួនាទី" path="officer_position" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedPosition"
                      filterable
                      placeholder="សូមជ្រើសរើសតួនាទី"
                      :options="positions"
                    />
                  </n-form-item>
                </n-form>
                <div class="w-1/2 h-8"></div>  
              </div>
            </div>
          </div>
          <!-- End form edit account -->
          <template #footer></template>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

import dateFormat from "dateformat";

export default {
  components: {
    
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
          people: {
            firstname: '' ,
            lastname: '' ,
            email: '' ,
            gender: '' ,
            mobile_phone: '' ,
            office_phone: '' ,
            dob: null ,
            nid: '' ,
            marry_status: null ,
          },     
          code : '' ,
          orgainzation_id: null ,
          position_id: null ,
          countesy_id: null ,
          officer_dob: null ,
          phone: '' ,
          email: '' ,
          passport: ''
        })
      },
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

    const selectedOrganization = ref(null)
    const selectedPosition = ref(null)
    const selectedCountesies = ref([])

    const organizations = computed( () => 
      store.getters['organization/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 
    const countesies = computed( () => 
      store.getters['countesy/getRecords'].map( c => ( { label: c.name , value : c.id } ) )
    ) 
    
    const dob = ref( null )
    dob.value = props.record.people.dob != '' && props.record.people.dob != undefined
    ? (new Date( props.record.people.dob )).getTime()
    : (new Date()).getTime()

    const officer_dob = ref( null )
    officer_dob.value = props.record.dob != '' && props.record.dob != undefined
    ? (new Date( props.record.dob )).getTime()
    : (new Date()).getTime()

    /**
     * Variables
     */    
    var rules = {
        firstname: {
          required: true,
          message: 'សូមបញ្ចូល នាម ជាភាសារខ្មែរ',
          trigger: [ 'blur']
        },
        lastname: {
          required: true,
          message: 'សូមបញ្ចូល គោត្តនាម ជាភាសារខ្មែរ',
          trigger: [ 'blur']
        },
        enfirstname: {
          required: true,
          message: 'សូមបញ្ចូល នាម ជាភាសារអង់គ្លេស',
          trigger: [ 'blur']
        },
        enlastname: {
          required: true,
          message: 'សូមបញ្ចូល គោត្តនាម ជាភាសារអង់គ្លេស',
          trigger: [ 'blur']
        },
        dob: {
          required: true,
          message: 'សូមបញ្ចូល ថ្ងែខែឆ្នាំកំណើត',
          trigger: [ 'blur']
        },
        officer_organization: {
          required: true,
          message: 'សូមជ្រើសរើសអង្គភាព',
          trigger: [ 'blur']
        },
        officer_position: {
          required: true,
          message: 'សូមជ្រើសរើសតួនាទី',
          trigger: [ 'blur']
        },
    }
    /**
     * Functions
     */
     function clearRecord( actionStatus ){
      props.record.id = 0
      props.record.people = {
        firstname: '' ,
        lastname: '' ,
        email: '' ,
        gender: '' ,
        mobile_phone: '' ,
        office_phone: '' ,
        dob: null ,
        nid: '' ,
        marry_status: null ,
      }
      props.record.code = '' ,
      props.record.orgainzation_id = null ,
      props.record.position_id = null ,
      props.record.countesy_id = null ,
      props.record.officer_dob = null ,
      props.record.phone = '' ,
      props.record.email = '' ,
      props.record.passport = ''
      
      props.onClose( actionStatus )
    }

    function maskOrEscClick(){
      props.record.id = 0
      props.record.people = {
        firstname: '' ,
        lastname: '' ,
        email: '' ,
        gender: '' ,
        mobile_phone: '' ,
        office_phone: '' ,
        dob: null ,
        nid: '' ,
        marry_status: null ,
      }
      props.record.code = '' ,
      props.record.orgainzation_id = null ,
      props.record.position_id = null ,
      props.record.countesy_id = null ,
      props.record.officer_dob = null ,
      props.record.phone = '' ,
      props.record.email = '' ,
      props.record.passport = ''

      props.onClose( 0 )
    }

    function create(){
      if( 
        props.record.people.lastname == "" || 
        props.record.people.firstname == "" ||
        props.record.people.enlastname == "" || 
        props.record.people.enfirstname == "" 
      ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញឈ្មោះជា ភាសារខ្មែរ និង អង់គ្លេស ឲ្យបានពេញលេញ' ,
          duration: 2000
        })
        return false
      }
      if( 
        props.record.people.mobile_phone == "" && props.record.people.email == ""
      ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញលេខទូរស័ព្ទ ឬ អ៊ីមែលរបស់អ្នក' ,
          duration: 2000
        })
        return false
      }
      if( parseInt( selectedOrganization.value ) <= 0 ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមជ្រើសរើសអង្គភាព' ,
          duration: 2000
        })
      }
      if( parseInt( selectedPosition.value) <= 0 ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមជ្រើសរើសតួនាទី' ,
          duration: 2000
        })
      }
      if( props.record.people.mobile_phone == "" && props.record.people.email == "" ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញ លេខទូរស័ព្ទផ្ទាល់ខ្លួន ឬ អ៊ីមែល' ,
          duration: 2000
        })
        return false
      }
      if( props.model === undefined || props.model.name == "" ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
          duration: 2000
        })
        return false
      }
      
      props.record.people.dob = dob.value != null && parseInt( dob.value ) > 0 ? dateFormat( new Date(dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" )

      store.dispatch( props.model.name+'/create',
        {
          'id' : props.record.id ,
          'officer_dob' : officer_dob.value != null && parseInt( officer_dob.value ) > 0 ? dateFormat( new Date(officer_dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'organization_id' : selectedOrganization.value != null ? selectedOrganization.value : 0 ,
          'position_id' : selectedPosition.value != null ? selectedPosition.value : 0 ,
          'countesy_id' : selectedCountesies.value != null ? selectedCountesies.value[0] : 0 ,
          'officer_passport' : props.record.officer_passport ,
          'officer_email' : props.record.officer_email ,
          'officer_phone' : props.record.officer_phone ,
          'code' : props.record.code ,
          // People
          'firstname' : props.record.people.firstname ,
          'lastname' : props.record.people.lastname ,
          'enfirstname' : props.record.people.enfirstname ,
          'enlastname' : props.record.people.enlastname ,
          'gender' : props.record.people.gender ,
          'email' : props.record.people.email ,
          'mobile_phone' : props.record.people.mobile_phone ,
          'office_phone' : props.record.people.office_phone ,
          'dob' : props.record.people.dob ,
          'nid' : props.record.people.nid ,
          'passport' : props.record.people.passport ,
          'marry_status' : props.record.people.marry_status ,
          'address' : props.record.people.address ,
          'pob' : props.record.people.pob
        }
      // {
      //   firstname: props.record.firstname ,
      //   lastname: props.record.lastname ,
      //   gender: props.record.gender ,
      //   email: props.record.email.toLowerCase() ,
      //   mobile_phone: props.record.mobile_phone ,
      //   office_phone: props.record.office_phone ,
      //   dob: props.record.dob ,
      //   nid: props.record.nid ,
      //   marry_status: props.record.marry_status ,
      //   organizations: selectedOrganizations.value ,
      //   positions: selectedPositions.value ,
      //   countesies: selectedCountesies.value ,
      // }
      ).then( res => {
        if( res.data.ok ){
          notify.success({
            title: 'រក្សារទុកព័ត៌មាន' ,
            description: res.data.message ,
            duration: 2000
          })
          clearRecord( 1 )
        }else{
          notify.error({
            title: 'រក្សារទុកព័ត៌មាន' ,
            description: 'មានបញ្ហាក្នុងពេលរក្សារទុកព័ត៌មាន។' ,
            duration: 2000
          })
        }
      }).catch( err => {
        message.error( err )
      })
      clearRecord( 0 )
    }
  
    function initial(){
      // selectedOrganizations.value = [463]
      // selectedOrganizations.value = Array.isArray( props.record.organizations ) ? props.record.organizations.map( o => o.id ) : []
      // selectedPositions.value = Array.isArray( props.record.positions ) ? props.record.positions.map( o => o.id ) : []
      // selectedCountesies.value = Array.isArray( props.record.countesies ) ? props.record.countesies.map( c => c.id ) : []
    }

    return {
      /**
       * Variables
       */
      rules ,
      selectedOrganization ,
      organizations ,
      selectedPosition ,
      positions ,
      selectedCountesies ,
      countesies ,
      dob ,
      officer_dob ,
      /**
       * Functions
       */
      create  ,
      initial ,
      clearRecord ,
      maskOrEscClick
    }
  }
}
</script>
<style type="text/css" scoped >
  
</style>