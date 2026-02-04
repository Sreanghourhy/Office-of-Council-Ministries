<template>
  <div class="w-full pt-12" >
    <div class="grid grid-flow-row gap-2 ml-40 p-4 md:grid-flow-col md:grid-cols-10 lg:grid-cols-12 " >
      <div class="bg-white rounded-lg shadow p-4 md:col-span-3 lg:col-span-3 " >
        <Transition name="slide-fade" >
          <div v-if="transitionHelper"  class="w-full relative profileInformation">
            <div class="profileImage border-4 rounded-full border-gray-200 p-2 md:w-24 md:h-24 lg:w-32 lg:h-32 w-28 h-28 mx-auto bg-center bg-no-repeat bg-cover" :style=" 'background-image: url(' + localProfile +');' " ></div>
            <div v-if="user.countesy != null" class="font-moul text-center my-2" >{{ user.countesy.name }}</div>
            <div v-if="user.people != null" class="font-moul text-center my-1" >
              {{ user.people.lastname + " " + user.people.firstname }}<br/>
              {{ user.people.enlastname + " " + user.people.enfirstname }}
            </div>
            <div v-if="user.position != null" class=" my-2 " >តួនាទី ៖ {{ user.position.name }}</div>
            <div v-if="user.organization != null" class=" my-2 " >អង្គភាព ៖ {{ user.organization.name }}</div>
            <div v-if="user.officer != null" class=" my-2 " >អត្តលេខមន្ត្រី ៖ {{ $toKhmer( user.officer.code ) }}</div>
            <div v-if="user.card != null" class=" my-2 " >លេខកាតមន្ត្រី ៖ {{ $toKhmer( user.card.number ) }}</div>
            <div class="uploader absolute md:-right-12 lg:-right-8 -right-8 -top-4 w-14 flex" >
              <input type="file" placeholder="ឯកសារយោង" @change="fileChange" class="hidden " id="referenceDocument" />
              <div class="cursor-pointer hover:border-green-500 flex flex-wrap"  >
                <n-tooltip trigger="hover">
                  <template #trigger>
                    <div 
                      @click="clickUpload" 
                      class="changeProfile p-1 m-1 border bg-white rounded-full md:w-6 md:h-6 lg:w-8 lg:h-8 w-8 h-8 border-gray-300" >
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><circle cx="256" cy="272" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></circle><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M124 158v-22h-24v22"></path></svg>
                    </div>
                  </template>ប្ដូររូបភាពគណនី
                </n-tooltip>
                <n-tooltip trigger="hover">
                  <template #trigger>
                    <div
                      @click="uploadFiles" 
                      class="saveProfile p-1 m-1 border bg-white rounded-full md:w-6 md:h-6 lg:w-8 lg:h-8  w-8 h-8 border-gray-300" >
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg>
                    </div>
                  </template>រក្សារទុករូបភាពថ្មី
                </n-tooltip>
                <n-tooltip trigger="hover">
                  <template #trigger>
                    <div 
                      @click="$router.push('/password/change')"
                      class="changePassword p-1 m-1 border bg-white rounded-full md:w-6 md:h-6 lg:w-8 lg:h-8 w-8 h-8 border-gray-300" >
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M11 6a1 1 0 1 0 0-2a1 1 0 0 0 0 2z" fill="currentColor"></path><path d="M7.5 12v-.5h1A.5.5 0 0 0 9 11v-1h1a4 4 0 1 0-3.838-2.87L2.292 11a1 1 0 0 0-.292.707V13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.5h1a.5.5 0 0 0 .5-.5zM7 6a3 3 0 1 1 3 3H8.5a.5.5 0 0 0-.5.5v1H7a.5.5 0 0 0-.5.5v.5h-1a.5.5 0 0 0-.5.5v1H3v-1.293l4.089-4.089a.5.5 0 0 0 .113-.534C7.072 6.748 7 6.384 7 6z" fill="currentColor"></path></g></svg>
                    </div>
                  </template>ប្ដូរពាក្យសម្ងាត់
                </n-tooltip>
              </div>
            </div>
          </div>
        </Transition>
      </div>
      <Transition name="slide-fade" >
        <div v-if="transitionHelper" class="relative bg-white shadow rounded-lg p-4 md:col-span-7  lg:col-span-9" >
          <n-tabs type="line" animated>
            <n-tab-pane name="background" tab="ព័តមានផ្ទាល់ខ្លួន">
              <div class="my-4 relative">
                <n-form
                ref="formRef"
                label-placement="top"
                :model="user"
                label-width="120"
                class="grid grid-cols-2 gap-1 "
                >
                  <div class="">
                    <!-- <n-form-item label="ឈ្មោះគណនីប្រើប្រាស់" path="username" class="w-11/12" >
                      <n-input v-model:value="user.people.username" placeholder="ឈ្មោះគណនីប្រើប្រាស់" class="text-left" />
                    </n-form-item> -->
                    <n-form-item label="ត្រកូល" path="lastname" class="w-11/12" >
                      <!-- <n-input v-model:value="user.people.lastname" placeholder="នាមត្រកូល" class="text-left" /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.lastname }}</div>
                    </n-form-item>
                    <n-form-item label="ឈ្មោះ" path="firstname" class="w-11/12" >
                      <!-- <n-input v-model:value="user.people.firstname" placeholder="នាមខ្លួន" class="text-left"  /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.firstname }}</div>
                    </n-form-item>
                    <n-form-item label="ត្រកូល (អង់គ្លេស)" path="enlastname" class="w-11/12" >
                      <!-- <n-input v-model:value="user.people.enlastname" placeholder="នាមត្រកូល" class="text-left"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.enlastname }}</div>
                    </n-form-item>
                    <n-form-item label="ឈ្មោះ (អង់គ្លេស)" path="enfirstname" class="w-11/12" >
                      <!-- <n-input v-model:value="user.people.enfirstname" placeholder="នាមខ្លួន" class="text-left"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.enfirstname }}</div>
                    </n-form-item>
                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" path="dob" class="w-11/12" >
                      <!-- <n-date-picker v-model:value="peopleDob" type="date" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ dateFormat( new Date( peopleDob ) , 'dd-mm-yyyy' ) }}</div>
                    </n-form-item>
                    <n-form-item label="ភេទ" path="gender" class="w-11/12 " >
                      <n-radio-group v-model:value="user.people.gender" class="text-left" :disabled="true" >
                        <n-space>
                          <n-radio
                            v-for="gender in [{label:'ស្រី',value:0},{label:'ប្រុស',value:1}]"
                            :key="gender.value"
                            :value="gender.value"
                            :label="gender.label"
                          />
                        </n-space>
                      </n-radio-group>
                      <!-- <div class="p-2 border border-gray-200 rounded w-full text-left " >{{ user.people.gender == 0 ? 'ស្រី' : 'ប្រុស' }}</div> -->
                    </n-form-item>
                    <n-form-item label="នៅលីវ ឬ រៀបការរួច" path="marry" class="w-11/12 text-left" >
                      <n-radio-group v-model:value="user.people.marry_status" class="" :disabled="true" >
                        <n-space>
                          <n-radio
                          v-for="status in [{label:'នៅលីវ',value:'single'},{label:'រៀបការរួច',value:'married'},{label:'ពោះមាយ / មេមាយ',value:'divorced'}]"
                          :key="status.value"
                          :value="status.value"
                          :label="status.label"
                          />
                        </n-space>
                      </n-radio-group>
                      <!-- <div class="p-2 border border-gray-200 rounded w-full text-left " >{{ user.people.marry_status == 'single' ? 'នៅលីវ' : ( user.people.marry_status == 'married' ? 'រៀបការរួច' : ( user.people.marry_status == 'divorced' ? 'ពោះមាយ / មេមាយ' : '' ) ) }}</div> -->
                    </n-form-item>
                  </div>
                  <div class="">
                    <n-form-item-row label="ទូរស័ព្ទដៃ">
                      <!-- <n-input placeholder="ទូរស័ព្ទ" class="text-left w-11/12" v-model:value="user.people.mobile_phone"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.mobile_phone }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="ទូរស័ព្ទនៅផ្ទះ">
                      <!-- <n-input placeholder="ទូរស័ព្ទ" class="text-left w-11/12" v-model:value="user.people.office_phone"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.office_phone }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="អ៊ីមែល" >
                      <!-- <n-input placeholder="អ៊ីមែល" class="text-left w-11/12" v-model:value="user.people.email"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.email }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="អត្តសញ្ញាណបណ្ណ" >
                      <!-- <n-input placeholder="អត្តសញ្ញាណបណ្ណ" class="text-left w-11/12" v-model:value="user.people.nid"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.nid }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="លិខិតឆ្លងដែន" >
                      <!-- <n-input placeholder="លិខិតឆ្លងដែន" class="text-left w-11/12" v-model:value="user.people.passport"  /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.passport }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="អសយដ្ឋានបច្ចុប្បន្ន" >
                      <!-- <n-input 
                        placeholder="អសយដ្ឋានបច្ចុប្បន្ន" 
                        class="text-left" 
                        v-model:value="user.people.address" 
                        type="textarea" show-count maxlength="5000" /> -->
                        <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.address }}</div>
                    </n-form-item-row>
                    <n-form-item-row label="ទីកន្លែងកំណើត" >
                      <!-- <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                      v-model:value="user.people.pob" 
                      type="textarea" show-count maxlength="5000" /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.people.pob }}</div>
                    </n-form-item-row>
                  </div>
                </n-form>
                <div class="w-full py-2 text-left" >
                  <!-- <n-button class="" @click="saveProfile" type="primary" >រក្សារទុក</n-button> -->
                </div>
              </div>
            </n-tab-pane>
            <n-tab-pane name="organization" tab="ព័ត៌មានអង្គភាព">
              <div class="mt-4" >
                <n-form
                ref="formRef"
                label-placement="top"
                :model="user"
                label-width="120"
                class="grid grid-cols-2 gap-1"
                >
                  <div class="" >
                    <n-form-item label="ថ្ងៃខែឆ្នាំពេញសិទ្ធិ(តាំងស៊ុប)" path="officer_dob" class="w-11/12" >
                      <!-- <n-date-picker disabled v-model:value="officerDate" type="date" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" /> -->
                      <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ dateFormat( new Date( officerDate ) , 'dd-mm-yyyy' ) }}</div>
                    </n-form-item>
                    <n-form-item label="អត្តលេខ" path="code" class="w-11/12" >
                      <!-- <n-input disabled v-model:value="user.officer.code" placeholder="អត្តលេខ" /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.officer.code }}</div>
                    </n-form-item>
                    <n-form-item label="ទូរស័ព្ទ" path="phone" class="w-11/12" >
                      <!-- <n-input v-model:value="user.officer.phone" placeholder="ទូរស័ព្ទ" /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.officer.phone }}</div>
                    </n-form-item>
                    <n-form-item label="អ៊ីមែល" path="email" class="w-11/12" >
                      <!-- <n-input v-model:value="user.officer.email" placeholder="អ៊ីមែល" /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.officer.email }}</div>
                    </n-form-item>
                    <n-form-item label="លេខិតឆ្លងដែន" path="passport" class="w-11/12" >
                      <!-- <n-input v-model:value="user.officer.passport" placeholder="លេខិតឆ្លងដែន" /> -->
                       <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.officer.passport }}</div>
                    </n-form-item>
                  </div>
                  <div class="" >
                    <n-form-item label="ងារ" path="countesy" class="w-11/12" >
                      <n-select
                        :disabled="true"
                        v-model:value="selectedCountesies"
                        filterable
                        placeholder="សូមជ្រើសរើសងារ"
                        :options="countesies"
                        multiple
                      />
                    </n-form-item>
                    <n-form-item label="តួនាទី" path="position" class="w-11/12" >
                      <n-select
                      :disabled="true"
                        v-model:value="selectedPosition"
                        filterable
                        placeholder="សូមជ្រើសរើសតួនាទី"
                        :options="positions"
                      />
                    </n-form-item>
                    <n-form-item label="អង្គភាព" path="organization" class="w-11/12" >
                      <n-select
                      :disabled="true"
                        v-model:value="selectedOrganization"
                        filterable
                        placeholder="សូមជ្រើសរើសអង្គភាព"
                        :options="organizations"
                      />
                    </n-form-item>
                  </div>
                </n-form>
                <div class="w-full py-2 text-left" >
                  <!-- <n-button class="" @click="saveOfficer" type="primary" >រក្សារទុក</n-button> -->
                </div>
              </div>
            </n-tab-pane>
            <n-tab-pane name="profile" tab="ព័ត៌មានគណនី">
              <div class="my-4">
                <n-form
                ref="formRef"
                label-placement="top"
                :model="user"
                label-width="120"
                >
                  <n-form-item-row label="ឈ្មោះគណនី" >
                    <!-- <n-input placeholder="ឈ្មោះគណនី" class="text-left" v-model:value="user.username" /> -->
                     <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.username }}</div>
                  </n-form-item-row>
                  <n-form-item-row label="អ៊ីមែល" >
                    <!-- <n-input placeholder="អ៊ីមែល" class="text-left" disabled v-model:value="user.email" /> -->
                     <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.email }}</div>
                  </n-form-item-row>
                  <n-form-item-row label="ទូរស័ព្ទ">
                    <!-- <n-input placeholder="ទូរស័ព្ទ" class="text-left" v-model:value="user.phone" /> -->
                     <div class="p-2 border border-gray-200 rounded w-full text-left min-h-9 " >{{ user.phone }}</div>
                  </n-form-item-row>
                </n-form>
                <div class="w-full py-2 text-left" >
                  <!-- <n-button class="" @click="saveAccount" type="primary" >រក្សារទុក</n-button> -->
                </div>
              </div>
            </n-tab-pane>
          </n-tabs>
        </div>
      </Transition>
    </div>
    <float-top-menu v-bind:title="title" />
    <sidebar />
  </div>  
</template>
<script >
import { isAuth, getUser , authLogout } from './../../plugins/authentication.js'
import { reactive, ref , computed , onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import Dock from '@components/widgets/Dock.vue'
import { useMessage, useNotification } from 'naive-ui'
import dateFormat from "dateformat"
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'

  export default {
    name: 'Profile' ,
    components: {
      FloatTopMenu ,
      Sidebar
    },
    setup(){
      const router = useRouter()
      const store = useStore()
      const user = ref(null)
      const currentUserValue = ref(null)
      const message = useMessage()
      const notify = useNotification()
      const base64Avatar = ref(null)
      const selectedFileType = ref('')
      const transitionHelper = ref(false)
      const peopleDob = ref(null)
      const officerDate = ref(null)
      const title = ref("ប្រវត្តិរូបមន្ត្រី")

      if( isAuth() ){
        user.value = getUser()
        currentUserValue.value = user.value
        setTimeout( function(){
          transitionHelper.value = true
        } , 300 )
      }else{
        transitionHelper.value = false
        user.value = ref({
          lastname: '' ,
          firstname: '' ,
          phone: '' ,
          username: '' ,
          email: '' ,
          dob: null
        })
      }

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
      
      onMounted( () => {
        if( isAuth() ) {
          console.log( user.value )
          peopleDob.value = user.value.people != null 
            ? (
              user.value.people.dob != undefined && user.value.people.dob.length > 0
                ? ( new Date( user.value.people.dob ) ).getTime() 
                : ( new Date() ).getTime() 
            )
            : null
          officerDate.value = user.value.officer != null 
            ? (
              user.value.officer.date != undefined && user.value.officer.date.length > 0
                ? ( new Date( user.value.officer.date ) ).getTime() 
                : ( new Date() ).getTime() 
            )
            : null
          selectedPosition.value = user.value.position != null
            ? user.value.position.id
            : null
          selectedOrganization.value = user.value.organization != null
            ? user.value.organization.id
            : null
          selectedCountesies.value = user.value.countesy != null
            ? [user.value.countesy.id ]
            : null
        }
        getOrganizations()
        getPositions()
        getCountesies()
      })

      /**
       * Variables
       */    
      const model = reactive( {
        name: "UserProfile" ,
        title: "ព័ត៌មានមន្ត្រី"
      })
      

      const saveAccountEnable = computed( () => {
        return user.value.phone != currentUserValue.value.phone || user.value.username != currentUserValue.value.username
      })
      function saveAccount(){
        if( 
          user.value.username == ""
        ){
          notify.info({
            title: 'រក្សារទុកព័ត៌មាន' ,
            content: 'សូមបំពេញព័ត៌មានឈ្មោះគណនី',
            duration: 1000
          })
          return false
        }
        if( 
          user.value.phone == ""
        ){
          notify.info({
            title: 'រក្សារទុកព័ត៌មាន' ,
            content: 'សូមបំពេញព័ត៌មានលេខទូរសព្ទ',
            duration: 1000
          })
          return false
        }
        store.dispatch('user/update',{
          phone: user.value.phone ,
          username: user.value.username
        }).then( res => {
          notify.success({
            title: 'រក្សារទុករួចរាល់។' ,
            content: res.data.message ,
            duration: 1000
          })
          let tmpUser = getUser()
          tmpUser.phone = res.data.user.phone
          tmpUser.username = res.data.user.username
          localStorage.setItem( 'user' , JSON.stringify( tmpUser ) )
          user.value = getUser()
        }).catch( err => {
          console.log( err )
        })
      }

      function saveProfile(){

        if( user.value.people.lastname.length <=0 || user.value.people.firstname.length <=0 || user.value.people.enlastname.length <=0 || user.value.people.enfirstname.length <=0  ){
          notify.info({
            title: 'ព័ត៌មានអង្គភាព' ,
            content: 'សូមបំពេញឈ្មៅខ្មែរ និង អង់គ្លេស' ,
            duration: 1000
          })
          return false
        }
        if( peopleDob.value == null ){
          notify.info({
            title: 'ព័ត៌មានអង្គភាព' ,
            content: 'សូមបំពេញ ថ្ងៃ ខែ ឆ្នាំ កំណើត' ,
            duration: 1000
          })
          return false
        }

        store.dispatch('user/peopleUpdate',{
          user_id : user.value.id ,
          officer_id: user.value.officer.id , 
          people_id : user.value.people.id ,
          lastname: user.value.people.lastname ,
          firstname: user.value.people.firstname ,
          enlastname: user.value.people.enlastname ,
          enfirstname: user.value.people.enfirstname ,
          dob: peopleDob.value != null && parseInt( peopleDob.value ) > 0 ? dateFormat( new Date(peopleDob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          gender: user.value.people.gender ,
          marry_status: user.value.people.marry_status ,
          mobile_phone: user.value.people.mobile_phone ,
          office_phone: user.value.people.office_phone ,
          email: user.value.people.email ,
          nid: user.value.people.nid ,
          passport: user.value.people.passport ,
          address: user.value.people.address ,
          pob: user.value.people.pob
        }).then( res => {
          notify.success({
            title: 'រក្សារទុករួចរាល់។' ,
            content: res.data.message ,
            duration: 500
          })
          localStorage.setItem( 'user' , JSON.stringify( res.data.user ) )
          user.value = getUser()
        }).catch( err => {
          console.log( err )
        })
      }

      function saveOfficer(){
        if( parseInt( selectedPosition.value ) <= 0 ){
          notify.info({
            title: 'ព័ត៌មានអង្គភាព' ,
            content: 'សូមជ្រើសរើស តួនាទី របស់មន្ត្រី' ,
            duration: 1000
          })
          return false
        }
        if( parseInt( selectedOrganization.value ) <= 0 ){
          notify.info({
            title: 'ព័ត៌មានអង្គភាព' ,
            content: 'សូមជ្រើសរើស អង្គភាព របស់មន្ត្រី' ,
            duration: 1000
          })
          return false
        }
        if( Array.isArray( selectedCountesies.value ) && selectedCountesies.value.length > 0 && parseInt( selectedCountesies.value[0] ) <= 0 ){
          notify.info({
            title: 'ព័ត៌មានអង្គភាព' ,
            content: 'សូមជ្រើសរើស ងារ របស់មន្ត្រី' ,
            duration: 1000
          })
          return false
        }
        store.dispatch('user/officerUpdate',{
          user_id: user.value.id ,
          officer_id : user.value.officer.id ,
          officer_code : user.value.officer.code ,
          officer_phone: user.value.officer.phone ,
          officer_email: user.value.officer.email ,
          officer_date: officerDate.value != null && parseInt( officerDate.value ) > 0 ? dateFormat( new Date(officerDate.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          officer_passport: user.value.officer.passport ,
          officer_organization_id: selectedOrganization.value ,
          officer_position_id: selectedPosition.value ,
          officer_countesy_id: selectedCountesies.value[0]
        }).then( res => {
          notify.success({
            title: 'រក្សារទុករួចរាល់។' ,
            content: res.data.message ,
            duration: 1000
          })
          localStorage.setItem( 'user' , JSON.stringify( res.data.user ) )
          user.value = getUser()
        }).catch( err => {
          console.log( err )
        })
      }

      function logout(){
        if( isAuth() ){
          authLogout()
        }
        router.push('/welcome')
      }

      const files = ref([])
      /**
       * File upload
       */
      /**
       * On change
       */
      function fileChange(event){
        for(const file of event.target.files ){
          // if( index == 'item' || index == 'length' ) continue;

          // allowed types
          let allowed_mime_types = [ 
            /**
             * Image mime type
             */
            'image/jpeg', 'image/png' 
            /**
             * Application file mime type
             */
            // "application/pdf"
            ];
          
          // allowed max size in MB
          let allowed_size_mb = 5;

          // Validate file type
          if(allowed_mime_types.indexOf(file.type) == -1) {
            notify.error({
              title: "ដាក់រូបភាពអ្នកប្រើប្រាស់" ,
              description: "សូមបញ្ចូលឯកសារជាប្រភេទរូបភាព JPG និង PNG។" ,
              duration: 3000
            })
            return;
          }

          selectedFileType.value = file.type 

          // Validate file size
          if(file.size > allowed_size_mb*1024*1024) {
            notify.error({
              title: "ដាក់រូបភាពអ្នកប្រើប្រាស់" ,
              description: "ទំហំនៃរូបភាពគឺ៖ " + (file.size/1024/1024).toFixed(2) + " មេកាបៃ (MB) លើលទំហំដែលកំណត់គឺ ៥ មេកាបៃ។" ,
              duration: 3000
            })
            return;
          }


          let reader = new FileReader();
          reader.onerror = function(e) {
            console.log('On error');
          };
          reader.onprogress = function(e) {
            console.log('On progress');
          };
          reader.onabort = function(e) {
            console.log('On abort');
          };
          reader.onloadstart = function(e) {
            console.log( "On load start" )
          };
          reader.onload = function(e){
            // Ensure that the progress bar displays 100% at the end.
            console.log( 'On load' )
            /**
             * Read binary string from 'e.target.result' and convert to base64
             */
            base64Avatar.value = "data:"+file.type+";base64," + btoa( e.target.result )
            files.value.push( file )
          }
          // // // Read in the image file as base64 type
          // // reader.readAsDataURL(file);
          reader.readAsBinaryString(file)

          // files.value.push( file )
        }
      }
      /**
       * On click file upload
       */
      function clickUpload(){
        document.getElementById('referenceDocument').click()
      }
      function uploadFiles(){
        console.log( files.value )
        if( files.value.length < 0 ) {
          notify.info({
            title: "រក្សារទុករូបភាពគណនី" ,
            content: "សូមជ្រើសរើសរូបភាពជាមុនសិន។" ,
            duration: 3000
          })
          return false
        }
        notify.info({
          title: 'ដាក់រូបភាពអ្នកប្រើប្រាស់' ,
          description: 'កំពុងដាក់រូបភាព។' ,
          duration: 1000
        })

        console.log( files.value )
        let formData = new FormData()
        formData.append('id', user.value.id )
        formData.append('files',files.value[0],files.value[0].name)
        
        store.dispatch('user/upload', formData ).then( res => {
          notify.success({
            title: 'ដាក់រូបភាពអ្នកប្រើប្រាស់' ,
            description: 'កំពុងរក្សាទុករូបភាព។' ,
            duration: 1000
          })
          if( res.data.record != null && res.data.record != undefined ){
            let tmpUser = getUser()
            tmpUser.avatar_url = res.data.record.avatar_url
            localStorage.setItem( 'user' , JSON.stringify( tmpUser ) )
            user.value = getUser()
            base64Avatar.value = user.value.avatar_url
            formData = new FormData()
            files.value = []
          }
        }).catch( err => {
          console.log( err )
          notify.error({
            title: 'ដាក់រូបភាពអ្នកប្រើប្រាស់' ,
            description: 'មានបញ្ហាក្នុងការរក្សារទុករូបភាព។' ,
            duration: 3000
          })
        })
      }
      /**
       * Update local photo
       */
      const localProfile = computed( () => {
        return base64Avatar.value !== "" && base64Avatar.value !== null ? base64Avatar.value : ( user.value.avatar_url !== "" && user.value.avatar_url !== null ? user.value.avatar_url : "/src/assets/logo.png" )
      })

      function getOrganizations(){
        store.dispatch('organization/list',{
          page: 1 ,
          perPage: 1000 ,
          search: '' ,
          id: 0
        }).then(res=>{
          store.commit('organization/setRecords',res.data.records)
        }).catch(err =>{
          notify.error({
            title: 'អានអង្គភាព' ,
            description: 'មានបញ្ហាពេលអានអានអង្គភាព។'
          })
          console.log( err )
        })
      }
      function getCountesies(){
        store.dispatch('countesy/list',{
          page: 1 ,
          perPage: 1000 ,
          search: ''
        }).then(res=>{
          store.commit('countesy/setRecords',res.data.records)
        }).catch(err =>{
          notify.error({
            title: 'អានងារ' ,
            description: 'មានបញ្ហាពេលអានងារ។'
          })
          console.log( err )
        })
      }
      function getPositions(){
        store.dispatch('position/list',{
          page: 1 ,
          perPage: 1000 ,
          search: ''
        }).then(res=>{
          store.commit('position/setRecords',res.data.records)
        }).catch(err =>{
          notify.error({
            title: 'អានតំណែង' ,
            description: 'មានបញ្ហាពេលអានតំណែង។'
          })
          console.log( err )
        })
      }

      const visibleHelper = ref(false) 
      setTimeout( () => {
        visibleHelper.value = true
        clearTimeout()
      },500)
      
      return {
        visibleHelper ,
        user ,
        logout ,
        saveAccount ,
        saveProfile ,
        saveOfficer ,
        officerDate ,
        peopleDob ,
        fileChange ,
        uploadFiles,
        clickUpload ,
        localProfile ,
        model ,
        transitionHelper ,
        selectedPosition ,
        selectedOrganization ,
        selectedCountesies ,
        positions ,
        organizations ,
        countesies ,
        title ,
        dateFormat 
      }
    }

  }
</script>
<style lang="css" scoped >
  .profileInformation {
    @apply text-left ;
  }
</style>