<template>
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <div class="flex flex-wrap w-11/12 font-pvh text-xl p-0 bg-gray-50 min-h-screen" >
          <!-- Member Form -->
          <div v-if="$hasPermission('portal_meeting_attendant')" class="flex-none w-96 min-h-full relative" >
            <!-- List members -->
            <div class="absolute left-0 top-12 right-0 bottom-0 overflow-y-auto p-4 " >
              <div v-for="(person,index) in people" :key="index" class="flex flex-wrap border-b border-gray-200 cursor-pointer hover:bg-gray-100 duration-300" @click="toggleMeetingMembers(person)" >
                <div class="member_name  text-gray-700 w-full h-6" >{{  (index + 1 ) + ". " + person.lastname + " " + person.firstname }}</div>
                <div v-if="person.organizations!=undefined&&person.organizations.length" class="member_organizations text-gray-500 text-vcb-xs mr-2" >{{ person.organizations.map( (p) => p.name ).join(' - ') }}</div>
                <div v-if="person.positions!=undefined&&person.positions.length" class="member_positions text-gray-500 text-vcb-xs mr-2 " > {{ person.positions.map( (p) => p.name ).join(' - ') }}</div>
                <div v-if="person.email != undefined && person.email.length > 0" class="member_email  text-gray-500 text-vcb-xs mr-2" >{{ person.email }}</div>
                <div v-if="person.mobile_phone != undefined && person.mobile_phone.length > 0" class="member_email  text-gray-500 text-vcb-xs " >{{ person.mobile_phone }}</div>
              </div>
            </div>
            <!-- Search box -->
            <div class="absolute left-0 top-0 right-0 h-12 p-2 bg-white border-b border-gray-200 " >
              <n-input type="text" v-model:value="peopleSearch" @keyup.enter="getPeople" class="w-full h-8" placeholder="ស្វែងរក..." />
            </div>
          </div>
          <!-- Selected Members -->
          <div class=" flex-grow border-gray-200 relative border-l " >
            <div class="absolute left-0 top-12 right-0 bttom-0 p-2 flex flex-wrap justify-center " >
              <div v-for="(meetingMember,index) in meetingMembers" :key="index" 
                class=" border relative w-64 m-4 p-2 rounded bg-white" >
                <div class="member_name absolute right-0 bg-white bottom-0 p-1 border border-b-0 border-r-0 text-xs rounded-tl" >
                  {{  $toKhmer(index + 1 ) }}
                </div>
                <div class="member_photo p-1 border border-gray-100 h-10 w-10 absolute left-2 -top-5 bg-white rounded-full" >
                  <img :src=" orgLogoUrl " />
                </div>
                <div class="member_name my-6 text-center" >
                  {{ meetingMember.member.lastname + " " + meetingMember.member.firstname }}
                </div>
                <div class="member_name text-center mb-2 " >
                  {{ ( meetingMember.member.mobile_phone != undefined && meetingMember.member.mobile_phone.length > 0 ? meetingMember.member.mobile_phone : '' ) }}
                  {{ ( meetingMember.member.email != undefined && meetingMember.member.email.length > 0 ? meetingMember.member.email : '' ) }}
                </div>
                <!-- Button remove member from meeting list -->
                <n-tooltip v-if="$hasPermission('portal_meeting_attendant')" trigger="hover">
                  <template #trigger>
                    <svg class="absolute top-2 right-2 w-5 cursor-pointer text-red-500 duration-300 "
                      @click="toggleMeetingMembers(meetingMember.member)" 
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"></path><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"></path></g></svg>
                  </template>
                  លុបសមាសភាព
                </n-tooltip>
                <!-- Button check attend -->
                <n-tooltip v-if="$hasPermission('portal_meeting_attendant')" trigger="hover">
                  <template #trigger>
                    <svg :class=" ' absolute top-2 right-10 w-5 cursor-pointer text-gray-400 hover:text-green-700 duration-300 ' + ( meetingMember.attendant != undefined ? ' text-green-700 ' : '' ) "
                      @click="toggleMeetingMemberAttendant(meetingMember)"
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M31 30h-2v-3a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3v3h-2v-3a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5z" fill="currentColor"></path><path d="M24 12a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5z" fill="currentColor"></path><path d="M15 22h-2v-3a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v3H1v-3a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5z" fill="currentColor"></path><path d="M8 4a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5z" fill="currentColor"></path></svg>
                  </template>
                  {{( 
                    meetingMember.attendant != undefined && meetingMember.attendant != null ? (
                      meetingMember.member != undefined && meetingMember.attendant.people_id != meetingMember.member.id
                        ? "ជំនួសដោយ ៖ " + meetingMember.attendant.member.lastname + " " + meetingMember.attendant.member.firstname
                        : 'មកផ្ទាល់' 
                    ) : 'អវត្តមានក្នុងកិច្ចប្រជុំ' 
                  )}}
                </n-tooltip>

                <n-popselect
                  v-if="$hasPermission('portal_meeting_attendant')"
                  v-model:value="meetingMember.role"
                  :options="meetingMemberRoles"
                  size="small"
                  scrollable
                  @update:value="updateMemberGroupAndRole(meetingMember)"
                >
                  <n-button class="mr-1 text-xs" >
                    {{ meetingMemberRoles.find( (r) => r.value == meetingMember.role ).label }}
                  </n-button>  
                </n-popselect>
                <n-popselect
                  v-if="$hasPermission('portal_meeting_attendant')"
                  v-model:value="meetingMember.group"
                  :options="meetingMemberGroups"
                  size="small"
                  scrollable
                  @update:value="updateMemberGroupAndRole(meetingMember)"
                >
                  <n-button class=" text-xs" >{{ meetingMemberGroups.find( (g) => g.value == meetingMember.group ).label }}</n-button>  
                </n-popselect>
                <div class="flex flex-wrap " >
                  <div class="mr-2" v-if="!$hasPermission('portal_meeting_attendant')" >ជា {{ meetingMemberRoles.find( (r) => r.value == meetingMember.role ).label }}</div>
                  <div class="mr-2" v-if="!$hasPermission('portal_meeting_attendant')" > , {{ meetingMemberGroups.find( (g) => g.value == meetingMember.group ).label }}</div>
                  <div class=" w-full" v-if="!$hasPermission('portal_meeting_attendant')" >
                    {{( 
                    meetingMember.attendant != undefined && meetingMember.attendant != null ? (
                      meetingMember.member != undefined && meetingMember.attendant.people_id != meetingMember.member.id
                        ? "ជំនួសដោយ ៖ " + meetingMember.attendant.member.lastname + " " + meetingMember.attendant.member.firstname
                        : 'មកផ្ទាល់' 
                    ) : 'អវត្តមានក្នុងកិច្ចប្រជុំ' 
                  )}}
                  </div>
                </div>
              </div>
            </div>
            <div class="absolute left-0 top-0 right-0 h-12 p-2 bg-gray-50 selected_members text-center font-moul border-b border-gray-200" >បញ្ជីសមាសភាពប្រជុំ
              <!-- <svg v-if="$hasPermission('portal_meeting_attendant')" @click="memberAddDrawer.show=!memberAddDrawer.show" class="absolute top-1 right-2 w-10 cursor-pointer text-blue-500  " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg> -->
            </div>
            <n-drawer v-model:show="memberAddDrawer.show" placement="right" :width="768" >
              <n-drawer-content >
                <template #header >
                  បន្ថែមសមាជិកប្រជុំថ្មី 
                  <svg @click="savePeopleFromMeeting" class="w-10 absolute right-0 top-0 cursor-pointer hover:text-blue-600 duration-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M4 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1V9.5A1.5 1.5 0 0 1 5.5 8h5A1.5 1.5 0 0 1 12 9.5V13a1 1 0 0 0 1-1V5.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 10.379 3H10v1.5A1.5 1.5 0 0 1 8.5 6h-2A1.5 1.5 0 0 1 5 4.5V3H4zm2 0v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V3H6zm5 10V9.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0-.5.5V13h6zM2 4a2 2 0 0 1 2-2h6.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 14 5.621V12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4z" fill="currentColor"></path></g></svg>
                </template>
                <div class="w-full text-sm text-center " >
                  <n-form 
                    class="w-full text-left font-omc text-lg flex flex-wrap" 
                    :label-width="80"
                    :model="memberAddDrawer.record"
                    size="large"
                    ref="formRef"
                  >
                    <n-form-item label="ងារ និង ឈ្មោះ" path="countesy" class="w-4/5 mr-8" >
                      <n-select
                        v-model:value="memberAddDrawer.record.countesy"
                        filterable
                        placeholder="សូមជ្រើសរើស ងារ"
                        :options="countesies.map( (c) => { return { label : c.name , value : c.id } })"
                      />
                    </n-form-item>
                    <n-form-item label="គោត្តនាម" path="lastname" class="w-4/5 mr-8 " >
                      <n-input type="text" name="lastname" v-model:value="memberAddDrawer.record.lastname" placeholder="គោត្តនាម" class="text-left font-bold mr-2" ></n-input>
                    </n-form-item>
                    <n-form-item label="នាមខ្លួន" path="firstname" class="w-4/5 mr-8" >
                      <n-input type="text" name="firstname" v-model:value="memberAddDrawer.record.firstname" placeholder="សូមបញ្ចូលនាមខ្លួន" class="text-left font-bold " ></n-input>
                    </n-form-item>
                    <n-form-item label="ភេទ" path="gender" class="w-4/5 mr-8" >
                      <n-select
                        v-model:value="memberAddDrawer.record.gender"
                        filterable
                        placeholder="សូមជ្រើសរើស ភេទ"
                        :options="[ { value : 0 , name: 'ស្រី់' } , { value : 1 , name : 'ប្រុស' }].map( (c) => { return { label : c.name , value : c.value } })"
                      />
                    </n-form-item>
                    <n-form-item label="ទូរស័ព្ទ" class="w-4/5 mr-8" >
                      <n-input type="text" name="phone" v-model:value="memberAddDrawer.record.phone" placeholder="សូមបញ្ចូលលេខទូរស័ព្ទ" class="text-left font-bold " ></n-input>
                    </n-form-item>
                    <n-form-item label="អ៊ីមែល" class="w-4/5 mr-8" >
                      <n-input type="text" name="email" v-model:value="memberAddDrawer.record.email" placeholder="សូមបញ្ចូលអ៊ីមែល" class="text-left font-bold " ></n-input>
                    </n-form-item>
                    <n-form-item label="តួនាទី" class="w-4/5 mr-8" >
                      <n-select
                        v-model:value="memberAddDrawer.record.position"
                        filterable
                        placeholder="សូមជ្រើសរើសតួនាទី"
                        :options="positions.map( (c) => { return { label : c.name , value : c.id } })"
                      />
                    </n-form-item>
                    <n-form-item label="ក្រសួង ស្ថាប័ន" class="w-4/5 mr-8" >
                      <n-select
                        v-model:value="memberAddDrawer.record.organization"
                        filterable
                        placeholder="សូមជ្រើសរើសក្រសួងស្ថាប័ន"
                        :options="organizations.map( (c) => { return { label : c.name , value : c.id } })"
                      />
                    </n-form-item>
                  </n-form>
                </div>
              </n-drawer-content>
            </n-drawer>
              <!-- Meeting member attendant -->
            <n-drawer v-model:show="memberAttendantDrawer.show" placement="right" :width="768" >
              <n-drawer-content >
                <template #header >
                  ចុះវត្តមាន 
                </template>
                <div class="w-full text-sm text-center " >
                  <!-- Member Form -->
                  <div class="min-h-full " >
                    <!-- Search box -->
                    <div class="w-full pb-2" >
                      <n-radio-group v-model:value="memberAttendantDrawer.selectedAttendantOption" name="attendantOptions" @update:value="attendantChange()" >
                        <n-radio-button
                          v-for="attendantOption in [
                            { label: 'អវត្តមាន' , value: 0 } ,
                            { label: 'មកផ្ទាល់' , value: 1 } ,
                            { label: 'មានគេជំនួស' , value: 2 }
                          ]"
                          :key="attendantOption.value"
                          :value="attendantOption.value"
                          :label="attendantOption.label"
                        />
                      </n-radio-group>
                    </div>
                    <Transition name="slide-fade" >
                      <div v-if="memberAttendantDrawer.showSearch" >
                        <!-- Search box -->
                        <div class="w-full pb-2" >
                          <n-input type="text" v-model:value="memberAttendantDrawer.peopleSearch" @keyup.enter="getPeopleForAttentant" class="w-full" placeholder="ស្វែងរក..." />
                        </div>
                        <!-- List members -->
                        <div class="w-full" >
                          <div v-for="(person,index) in memberAttendantDrawer.people" :key="index" class="p-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100 duration-300" @click="saveAttendantMeeting(person)" >
                            <div class="member_name" >
                              {{  (index + 1 ) + ". " + person.lastname + " " + person.firstname + ( person.mobile_phone != undefined && person.mobile_phone.length != undefined ? ' - ' + person.mobile_phone : '' )  }}
                            </div>
                            <div v-if="person.positions.length" class="member_positions" >{{ person.positions.map( (p) => p.name ).join(' - ') }}</div>
                            <div v-if="person.organizations.length" class="member_organizations" >{{ person.organizations.map( (p) => p.name ).join(' - ') }}</div>
                          </div>
                        </div>
                      </div>
                    </Transition>
                  </div>
                </div>
              </n-drawer-content>
            </n-drawer>
            <!-- End meeting member attendant -->
          </div>
        </div>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import QrcodeVue from 'qrcode.vue'
import orgLogoUrl from '@assets/logo.png'

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

    const meeting = ref( null )
    const meetingMemberGroups = ref([
      {
        label: 'អ្នកដឹកនាំប្រជុំ' ,
        value: 'lead_meeting'
      },
      {
        label: 'អ្នកការពារ' ,
        value: 'defender'
      },
      {
        label: 'អ្នកចូលរួម' ,
        value: 'audient'
      }
    ])
    const meetingMemberRoles = ref([
      {
        label: 'ប្រធាន' ,
        value: 'leader'
      },
      {
        label: 'អនុប្រធាន' ,
        value: 'deputy_leader'
      },
      {
        label: 'សមាជិក' ,
        value: 'member'
      }
    ])

    /**
     * Search member
     */
    const people = ref([])
    const peopleSearch = ref('')
    const meetingMembers = ref( [] )
    const memberAddDrawer = reactive({
      show : false ,
      record: {
        countesy: null ,
        lastname : '' ,
        firstname : '' ,
        gender: 1 ,
        phone : '' ,
        email: '' ,
        position: null ,
        organization: null
      }
    })

    function getPeople(){
      // people.value = store.getters['meetingPeople/records'].all
      store.dispatch( props.model.name+'People'+'/list',{
        search : peopleSearch.value ,
        perPage : 50 ,
        page : 1
      }).then( res => {
        if( res.data.records.length > 0 ){
          people.value = res.data.records
        }else{
          notify.warning({
            'title' : 'សមាជិកប្រជុំ' ,
            'description' : 'មិនមានសមាជិកប្រជុំ។' ,
            duration : 3000
          })
        }
        
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'សមាជិកប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
          duration : 3000
        })
      })
    }

    function getPeopleForAttentant(){
      memberAttendantDrawer.people = store.getters['meetingPeople/records'].all
      store.dispatch( props.model.name+'/people',{
        search : memberAttendantDrawer.peopleSearch ,
        perPage : 50 ,
        page : 1
      }).then( res => {
        if( res.data.records.length > 0 ){
          memberAttendantDrawer.people = res.data.records
        }else{
          notify.warning({
            'title' : 'សមាជិកប្រជុំ' ,
            'description' : 'មិនមានសមាជិកប្រជុំ។' ,
            duration : 3000
          })
        }
        
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'សមាជិកប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
          duration : 3000
        })
      })
    }

    /**
     * Save people for meeting 
     */
    function savePeopleFromMeeting(){
      store.dispatch( props.model.name+'/peopleSave',{
        countesy: memberAddDrawer.record.countesy ,
        lastname : memberAddDrawer.record.lastname ,
        firstname : memberAddDrawer.record.firstname ,
        gender: memberAddDrawer.record.gender ,
        phone : memberAddDrawer.record.phone ,
        email: memberAddDrawer.record.email ,
        position: memberAddDrawer.record.position ,
        organization: memberAddDrawer.record.organization
      }).then( res => {
        if( res.data.ok ){
          getPeople()
          memberAddDrawer.show = false
          // memberAddDrawer.record = {
          //   countesy: null ,
          //   lastname : '' ,
          //   firstname : '' ,
          //   gender: 1 ,
          //   phone : '' ,
          //   email: '' ,
          //   position: null ,
          //   organization: null
          // }
        }else{
          notify.warning({
            'title' : 'បញ្ចូលសមាជិក' ,
            'description' : res.data.message ,
            duration : 3000
          })
        }
        
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'បញ្ចូលសមាជិក' ,
          'description' : err.response.data.message ,
          duration : 3000
        })
      })
    }

    /**
     * Search member for attendant
     */
    const memberAttendantDrawer = reactive({
      show : false ,
      showSearch : false ,
      member: null ,
      meetingMember: null ,
      people : [] ,
      peopleSearch : '' ,
      meetingMembers : [] ,
      selectedAttendantOption : 0 ,
      record: {
        memberId : 0
      }
    })

    /**
     * Update the member attendant when the attendant option change
     */
    function attendantChange(){
      console.log( memberAttendantDrawer.selectedAttendantOption )
      // 0 => absent , 1 => come by him/her self , 2 => there is someone come on behave
      if( memberAttendantDrawer.selectedAttendantOption === 0 ){
        memberAttendantDrawer.showSearch = false
        if( memberAttendantDrawer.meetingMember.attendant != undefined ){
          saveAttendantMeeting( memberAttendantDrawer.meetingMember.member )
        }
      }
      else if( memberAttendantDrawer.selectedAttendantOption === 1 ){
        memberAttendantDrawer.showSearch = false
        saveAttendantMeeting( memberAttendantDrawer.meetingMember.member )
      }else{
        memberAttendantDrawer.showSearch = true
      }

    }
    /**
     * Save people for meeting 
     */
    function saveAttendantMeeting( member ){ 
      memberAttendantDrawer.member = member
      store.dispatch(props.model.name + '/toggleMeetingMemberAttendant',{ 
        member_id : memberAttendantDrawer.member.id , 
        meeting_member_id : memberAttendantDrawer.meetingMember.id
      })
      .then( res => {
        if( res.data.ok ){
          memberAttendantDrawer.peopleSearch = '' 
          memberAttendantDrawer.people = []
          memberAttendantDrawer.show = false
          meetingMembers.value = res.data.record.list_members 
          memberAttendantDrawer.meetingMembers = res.data.record.list_members 
          if( memberAttendantDrawer.selectedAttendantOption === 0 ){
            message.info( "បាន កំណត់ថាសមាជិកនេះ អវត្តមានក្នុងកិច្ចប្រជុំ។" )
          }
          else if( memberAttendantDrawer.selectedAttendantOption === 1 ){
            message.success( "បាន កំណត់ថាសមាជិកនេះ វត្តមានក្នុងកិច្ចប្រជុំ។" )
          }
          else if( memberAttendantDrawer.selectedAttendantOption === 2 ){
            message.success( "បាន កំណត់ថាសមាជិកនេះ មានអ្នកដំណាង។" )
          }
        }else{
          notify.error({
            'title' : 'សមាជិកប្រជុំ' ,
            'description' : res.data.message ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'សមាជិកប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
          duration : 3000
        })
      } )
    }

    function toggleMeetingMembers(member){
      // helper == true -> add member to the meeting, helper == false remove the member from the meeting
      store.dispatch(props.model.name + '/toggleMeetingMember',{ 
        member : member , 
        meeting : props.record 
      })
      .then( res => {
        if( res.data.ok ){
          meetingMembers.value = res.data.record.list_members 
        }else{
          notify.error({
            'title' : 'សមាជិកប្រជុំ' ,
            'description' : res.data.message ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'សមាជិកប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
          duration : 3000
        })
      } )
    }

    function toggleMeetingMemberAttendant(meetingMember){
      memberAttendantDrawer.show = true
      memberAttendantDrawer.meetingMember = meetingMember
      memberAttendantDrawer.member = meetingMember.member
      memberAttendantDrawer.selectedAttendantOption = memberAttendantDrawer.meetingMember.attendant == null
        ? 0
        : ( memberAttendantDrawer.meetingMember.member != null && ( memberAttendantDrawer.meetingMember.attendant.people_id == memberAttendantDrawer.meetingMember.member.id ) ? 1 : 2 )
    }

    function updateMemberGroupAndRole(meetingMember){
      // helper == true -> add member to the meeting, helper == false remove the member from the meeting
      store.dispatch(props.model.name + '/updateMemberGroupAndRole',{ 
        id : meetingMember.id ,
        role : meetingMember.role ,
        group : meetingMember.group ,
        meeting_id : props.record.id ,
        people_id : meetingMember.people_id ,
        remark : meetingMember.remark
      })
      .then( res => {
        if( res.data.ok ){
          meetingMembers.value = res.data.record.list_members 
        }else{
          notify.error({
            'title' : 'សមាជិកប្រជុំ' ,
            'description' : res.data.message ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'សមាជិកប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
          duration : 3000
        })
      } )
    }

    // Search Positions
    const positions = ref([])
    function getPositions(){
      positions.value = store.getters['meetingPosition/records'].all
      // store.dispatch( props.model.name+'/positions',{
      //   search : '' ,
      //   perPage : 100 ,
      //   page : 1
      // }).then( res => {
      //   if( res.data.records.length > 0 ){
      //     positions.value = res.data.records
      //   }else{
      //     notify.error({
      //       'title' : 'តួនាទី' ,
      //       'description' : res.data.message ,
      //       duration : 3000
      //     })
      //   }
        
      // }).catch( err => {
      //   console.log( err )
      //   notify.error({
      //     'title' : 'តួនាទី' ,
      //     'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកតួនាទី។' ,
      //     duration : 3000
      //   })
      // })
    }

    // Search Countesies
    const countesies = ref([])
    function getCountesies(){
      countesies.value = store.getters['meetingCountesy/records'].all
      // store.dispatch( props.model.name+'/countesies',{
      //   search : '' ,
      //   perPage : 100 ,
      //   page : 1
      // }).then( res => {
      //   if( res.data.records.length > 0 ){
      //     countesies.value = res.data.records
      //   }else{
      //     notify.error({
      //       'title' : 'ងារ' ,
      //       'description' : res.data.message ,
      //       duration : 3000
      //     })
      //   }
        
      // }).catch( err => {
      //   console.log( err )
      //   notify.error({
      //     'title' : 'ងារ' ,
      //     'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកងារ។' ,
      //     duration : 3000
      //   })
      // })
    }

    // Search Organization
    const organizations = ref([])
    const organizationSearch = ref('')
    const meetingOrganizations = ref( [] )

    function getOrganizations(){
      organizations.value = store.getters['meetingOrganization/records'].all
      // store.dispatch( props.model.name+'/organizations',{
      //   search : organizationSearch.value ,
      //   perPage : 500 ,
      //   page : 1
      // }).then( res => {
      //   if( res.data.records.length > 0 ){
      //     organizations.value = res.data.records
      //   }else{
      //     notify.error({
      //       'title' : 'សមាជិកប្រជុំ' ,
      //       'description' : res.data.message ,
      //       duration : 3000
      //     })
      //   }
        
      // }).catch( err => {
      //   console.log( err )
      //   notify.error({
      //     'title' : 'សមាជិកប្រជុំ' ,
      //     'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកសមាជិកប្រជុំ។' ,
      //     duration : 3000
      //   })
      // })
    }

    function toggleMeetingOrganizations(organization){
      store.dispatch( props.model.name+'/toggleMeetingOrganization',{ organization : organization , meeting : props.record })
      .then( res => {
        if( res.data.ok ){
          meetingOrganizations.value = res.data.record.organizations 
        }else{
          notify.warning({
            'title' : 'ក្រសួងសាមី' ,
            'description' : 'មិនមានក្រសួងសាមីឡើយ' ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'ក្រសួងសាមី' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកក្រសួងសាមី។' ,
          duration : 3000
        })
      } )
    }

    function maskOrEscClick(){
      props.onClose( 1 )
    }

    function initial(){
      getPeople()
      getPositions()
      getCountesies()
      getOrganizations()
      meetingMembers.value = props.record.listMembers != undefined && props.record.listMembers.length > 0 ? props.record.listMembers : []
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
      updateMemberGroupAndRole ,
      toggleMeetingMemberAttendant ,
      toggleMeetingMembers ,
      saveAttendantMeeting ,
      attendantChange ,
      savePeopleFromMeeting ,
      getPeopleForAttentant ,
      getPeople ,
      meetingMemberRoles ,
      memberAttendantDrawer ,
      people ,
      peopleSearch ,
      meetingMembers ,
      memberAddDrawer ,
      meetingMemberGroups ,
      meetingMemberRoles ,
      meeting ,
      countesies ,
      positions ,
      organizations ,
      organizationSearch ,
      meetingOrganizations ,
      orgLogoUrl
    }
  }
}
</script>