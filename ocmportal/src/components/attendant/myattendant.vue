<template>
  <div class=" mb-24 w-full " >
  <!-- Top action panel of crud -->
    <div class="flex title-bar border-b border-gray-200 p-2 bg-gray-50 ">
      <!-- Title of crud -->
      <div class="flex w-64 h-12 py-1 title " >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>
        <div class="font-moul ml-2 h-12 leading-10" v-html="model.title" ></div>
      </div>
      <!-- Actions button of the crud -->
      <div class="flex-grow action-buttons flex-row-reverse flex">
        <!-- New Button -->
        <!-- <div class="mt-1 ml-2">
          <n-button type="success" @click="showCreateModal()" >
            <template #icon>
              <n-icon>
                <Add20Regular />
              </n-icon>
            </template>
            បន្ថែម
          </n-button>
        </div> -->
        <div class="w-1/5 relative hidden" >
          <input type="text" @keypress.enter="filterRecords(false)" v-model="table.search" class="bg-gray-100 px-2 h-9 my-1 w-full rounded border border-gray-200 focus:border-blue-600 hover:border-blue-600 " placeholder="ស្វែងរក" />
          <svg class="absolute right-1 top-2 text-gray-400 hover:text-blue-700 cursor-pointer" @click="filterRecords(false)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
        </div>
        <div class="mt-1 mr-2">
          <n-date-picker v-model:value="attendantDate" type="month" @update:value="filterRecords(false)"/>
        </div>
        <div class="mt-1 mr-2">
        </div>
      </div>
      <!-- Filter panel of crud -->
      <div class="filters-bar"></div>
    </div>
    <!-- Table of crud -->
    <div class="mt-4 relative">
      <Transition name="fade" >
        <div v-if="user != null && Array.isArray( table.records.matched ) && table.records.matched.length > 0 " class="w-full flex flex-wrap justify-between " >
          <div class="w-full flex flex-wrap m-4 py-16 shadow-sm border border-gray-300" >
            <div class="report-title font-moul text-center w-full mt-4 text-xl" >របាយការណ៍វត្តមានប្រចាំខែ</div>
            <div class="report-title font-tacteing text-center w-full h-10 leading-10 my-4" style="font-size: 5rem; " >6</div>
            <div v-if="user!=null" class="report-title font-moul text-left w-1/2 pl-2" >មន្ត្រីឈ្មោះ ៖ &ensp;&ensp;{{ user.lastname }}&ensp;{{ user.firstname }}</div>
            <div v-if="attendantDate!=null" class="report-title font-moul text-right w-1/2 pr-2" >កាលបរិច្ឆែទ ៖ &ensp;&ensp;{{ dateFormat( new Date( attendantDate ) , 'mm - yyyy' ) }}</div>
            <div class="attendant-list w-full my-8 mt-12" >
              <div class="attendant-header flex bg-gray-100 h-14 leading-10 py-2" >
                <div class="attendant-header-row w-40 font-moul" >ថ្ងៃ</div>
                <div class="attendant-header-row flex-grow font-moul" >វេនធ្វើការ</div>
                <div class="attendant-header-row w-60 font-moul" >សរុបរយះពេលបំពេញការងារ</div>
                <!-- <div class="attendant-header-row w-60 font-moul" >រយះពេលដែល លើស / ខ្វះ</div> -->
              </div>
              <div v-for="(attendant, index) in table.records.matched" :key='index' :class="'flex attendant-row py-4w-full ' + ( index % 2 ? ' bg-gray-100 ' : ' bg-white ' ) " >
                <div class="day-number w-40 p-4 font-kantumruy" :style="'color: ' + ( getDayOfWeek(attendant.day_of_week).color.hexa ) + '; '" >
                  <div class="font-bold text-xl">{{ dateFormat( new Date( attendant.date ) , 'dd' ) }}</div>
                  <div class="font-bold text-xl">{{ getDayOfWeek(attendant.day_of_week).name.kh }}</div>
                </div>
                <div class="flex-grow p-4" >
                  <table class="w-full" >
                    <thead>
                      <tr class="" >
                        <td class="font-kantumruy py-1 text-left font-bold">វេន</td>
                        <td class="font-kantumruy py-1 text-left font-bold">ចូល</td>
                        <td class="font-kantumruy py-1 text-left font-bold">ចេញ</td>
                        <td class="font-kantumruy py-1 text-right font-bold">សរុប</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(ct , ctIndex) in attendant.calculateTime.checktimes" :key="ctIndex">
                        <td class=" py-1 text-left " >{{ ct.timeslot != undefined ? ct.timeslot.title + ' ' + ct.timeslot.start +'-'+ct.timeslot.end : $toKhmer(ctIndex + 1 ) }}</td>
                        <td class=" py-1 text-left " >
                          {{ $toKhmer( ct.in.organization != null ? ct.in.organization.name + ' - ' : '' ) }}
                          {{ $toKhmer( ct.in.checktime ) }}
                          <svg 
                            v-if="parseFloat( ct.in.lat ) && parseFloat( ct.in.lng ) " 
                            @click="openGoogleMap( ct.in.lat , ct.in.lng )"
                            class="w-4 h-4 text-blue-500 ml-2 cursor-pointer inline-flex mb-1 " 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="11" r="3"></circle><path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"></path></g></svg>
                          <svg 
                            v-if="ct.in.photo == true " 
                            @click="viewPhoto(ct.in.id)"
                            class="w-4 h-4 text-blue-500 ml-2 cursor-pointer inline-flex mb-1 " 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0zm-1 0a2 2 0 1 0-4 0a2 2 0 0 0 4 0zM6.618 2a1.5 1.5 0 0 0-1.342.83L4.691 4H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-.691l-.585-1.17A1.5 1.5 0 0 0 9.382 2H6.618zm-.447 1.276A.5.5 0 0 1 6.618 3h2.764a.5.5 0 0 1 .447.276l.724 1.448A.5.5 0 0 0 11 5h1a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1a.5.5 0 0 0 .447-.276l.724-1.448z" fill="currentColor"></path></g></svg>
                        </td>
                        <td class=" py-1 text-left" >
                          {{ ct.out != null ? ( $toKhmer( ct.out.organization != null ? ct.out.organization.name + ' - ' : ' ' ) ) : ' ' }}
                          {{ ct.out != null ? $toKhmer( ct.out.checktime ) : ' ' }}
                          <svg 
                            v-if=" ct.out != null && ct.out.lat != null && ct.out.lng != null " 
                            @click="openGoogleMap( ct.out.lat , ct.out.lng )"
                            class="w-4 h-4 text-blue-500 ml-2 cursor-pointer inline-flex mb-1 " 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="11" r="3"></circle><path d="M17.657 16.657L13.414 20.9a2 2 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z"></path></g></svg>
                          <svg 
                            v-if="ct.out != null && ct.out.photo == true " 
                            @click="viewPhoto(ct.out.id)"
                            class="w-4 h-4 text-blue-500 ml-2 cursor-pointer inline-flex mb-1 " 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M11 8a3 3 0 1 1-6 0a3 3 0 0 1 6 0zm-1 0a2 2 0 1 0-4 0a2 2 0 0 0 4 0zM6.618 2a1.5 1.5 0 0 0-1.342.83L4.691 4H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-.691l-.585-1.17A1.5 1.5 0 0 0 9.382 2H6.618zm-.447 1.276A.5.5 0 0 1 6.618 3h2.764a.5.5 0 0 1 .447.276l.724 1.448A.5.5 0 0 0 11 5h1a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1a.5.5 0 0 0 .447-.276l.724-1.448z" fill="currentColor"></path></g></svg>
                        </td>
                        <td class=" py-1 text-right font-bold" >{{ $toKhmer( ct.spenttime ) }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class=" w-60 p-4 font-bold text-xl " >{{ $toKhmer( attendant.calculateTime.total ) }}</div>
                <!-- <div :class="'w-60 p-4 font-bold  text-xl ' + ( attendant.calculateTime.total ? ' text-green-600 ' : ' text-red-600 ' )" >{{ attendant.calculateTime.total }}</div> -->
              </div>
            </div>
          </div>
        </div>
      </Transition>
      <div v-if="!Array.isArray( table.records.matched ) || table.records.matched.length <= 0 " class="w-full flex flex-wrap justify-between " >មិនមានព័ត៌មានដែលអ្នកកំពុងស្វែងរកឡើយ។</div>
      <!-- Loading -->
      <Transition name="slide-fade" >
        <div v-if="table.loading" class="table-loading fixed flex h-screen left-0 top-0 right-0 bottom-0 bg-white bg-opacity-80 ">
          <div class="flex mx-auto items-center">
            <div class="spinner">
              <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
              <br/><br/>កំពុងអាន...
            </div>
          </div>
          <div class="absolute top-1 right-1 cursor-pointer bg-white rounded-full " @click="closeTableLoading" >
            <svg class="w-14 mx-auto text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
          </div>
        </div>
      </Transition>
      <n-modal v-model:show="showCheckAttendantPhoto">
        <n-card
          style="width: 600px"
          title="រូបថតចុះវត្តមាន"
          :bordered="false"
          size="huge"
          role="dialog"
          aria-modal="true"
        >
          <!-- <template #header-extra>
            Oops!
          </template> -->
          <img :src="checkAttendantPhoto" class="w-full" />
          <!-- <template #footer>
            Footer
          </template> -->
        </n-card>
      </n-modal>
    </div>
  </div>
</template>
<script>
import { reactive ,ref } from 'vue'
import { useStore } from 'vuex'
import { getUser } from '@plugins/authentication'
import { useRouter, useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import dateFormat from "dateformat";
/**
 * CRUD component form
 */
export default {
  name: "User" ,
  components: {
    QrcodeVue ,
    Vue3Barcode
  },
  setup(){
    var store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const route = useRoute()
    const router = useRouter()
    const notify = useNotification()
    const user = ref(null)
    const attendantDate = ref( null )
    attendantDate.value = route.params.date != '' && route.params.date != undefined
    ? (new Date( route.params.date )).getTime()
    : (new Date()).getTime()

    const daysOfWeek = reactive([
      {
        name: {
          kh: 'អាទិត្យ' ,
          en: 'Sunday' 
        },
        symbol: 'Bravery / Courage' ,
        color: {
          kh: 'ក្រហម' ,
          en: 'red' ,
          hexa: '#D80032' 
        } ,
        number: 0
      },
      {
        name: {
          kh: 'ច័ន្ទ' ,
          en: 'Monday' 
        },
        symbol: 'Equality' ,
        color: {
          kh: 'ទឹកក្រូច' ,
          en: 'orange' ,
          hexa: '#EC8F5E' 
        } ,
        number: 1
      },
      {
        name: {
          kh: 'អង្គារ៍' ,
          en: 'Tuesday' 
        },
        symbol: 'Honesty / Loyalty' ,
        color: {
          kh: 'ស្វាយ' ,
          en: 'Purple' ,
          hexa: '#B15EFF' 
        } ,
        number: 2
      },
      {
        name: {
          kh: 'ពុធ' ,
          en: 'Wednesday' 
        },
        symbol: 'Embodying justice' ,
        color: {
          kh: 'ត្រួយចេក' ,
          en: 'Mustard Green' ,
          hexa: '#79AC78' 
        } ,
        number: 3
      },
      {
        name: {
          kh: 'ព្រហស្បត៍' ,
          en: 'Thursday' 
        },
        symbol: 'Signifying hope' ,
        color: {
          kh: 'បៃតង' ,
          en: 'Green' ,
          hexa: '#004225' 
        } ,
        number: 4
      },
      {
        name: {
          kh: 'សុក្រ' ,
          en: 'Thursday' 
        },
        symbol: 'Forgiveness' ,
        color: {
          kh: 'ខៀវ' ,
          en: 'Blue' ,
          hexa: '#39A7FF' 
        } ,
        number: 5
      },
      {
        name: {
          kh: 'សៅរ៍' ,
          en: 'Thursday' 
        },
        symbol: 'Signifying sadness' ,
        color: {
          kh: 'ឈាមជ្រូក' ,
          en: 'Burgundy' ,
          hexa: '#952323' 
        } ,
        number: 6
      }
    ])
    /**
     * Variables
     */    
    var model = reactive( {
      name: "attendant" ,
      title: "វត្តមានប្រចាំខែ"
    })
    var table = reactive( {
      loading: false ,
      search: '' ,
      records: {
        all: [] ,
        matched: []
      },
      columns: {
        searchable: {
          date: '' ,
          attendant_type : ''
        },
        format: {
          date: '' ,
          attendant_type: 'A' ,
          ot_hours: 0 ,
          ot_minutes: 0 ,
          worked_hours: 0 ,
          worked_minutes: 0 
        }
      } ,
      pagination: {
        perPage: 50 ,
        page: 1 ,
        totalPages: 0 ,
        totalRecords: 0 ,
        start: 0 ,
        end: 0 ,
        buttons: []
      }
    })

    function filterRecords(helper=true){
      if( helper ){
        table.records.matched = []
        if( table.search != "" ) {
          for(var index in table.records.all ){
            for(var field in table.records.all[index] ){
              if( (""+table.records.all[index][field]).includes( table.search ) !== false ) {
                table.records.matched.push( table.records.all[index] )
                break;
              }
            }
          }
        }
        if( table.records.matched.length <= 0 ) {
          table.records.matched = table.records.all
        }
      }else{
        setTimeout( goTo(1) , 500 )
      }
    }

    /**
     * Functions
     */
    function getRecords(){
      console.log( dateFormat( new Date(attendantDate.value) , "yyyy-mm-dd" ) )
      user.value = getUser()
      if( user == undefined || user == null ){
        notify.warning({
          title: 'អានវត្តមាន' ,
          content : 'សូមបញ្ជាក់អត្តសញ្ញាណម្ចាស់វត្តមាន។'
        })
        return false
      }
      /**
       * Clear time interval after calling
       */
      window.clearTimeout()
      table.loading = true
      store.dispatch(model.name+'/userAttendants',{
        userId: user.value.id ,
        date: attendantDate.value != null && parseInt( attendantDate.value ) > 0 ? dateFormat( new Date(attendantDate.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
      }).then(res => {
        table.records.all = table.records.matched = res.data.records
        user.value = res.data.user
        closeTableLoading()
      }).catch( err => {
        console.log( err )
      })
    }
    function closeTableLoading(){
      table.loading = false
    }
    /**
     * Pagination functions
     */
    function previous(){
      goTo( table.pagination.page <= 1 ? 1 : table.pagination.page - 1 )
    }
    function next(){
      goTo( table.pagination.page >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + 1 )
    }
    function goTo(page){
      table.pagination.page = page > table.pagination.totalPages ? table.pagination.totalPages : ( page < 1 ? 1 : page)
      getRecords()
    }
    function updatePerpage(perPage){
      table.pagination.perPage = perPage < 5 ? 5 : ( perPage > 100 ? 100 : perPgae )
      table.pagination.page = 1
      getRecords()
    }

    /**
     * Load organization
     */
    function getOrganizations(){
      store.dispatch('organizations/list',{
        page: 1 ,
        perPage: 1000 ,
        search: '' ,
        id: 164
      }).then(res=>{
        store.commit('organizations/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានអង្គភាព' ,
          description: 'មានបញ្ហាពេលអានអានអង្គភាព។'
        })
        console.log( err )
      })
    }

    function getEffectiveDayName(effectiveDayNumbers){
      let days = ["អាទិត្យ","ចន្ទ័","អង្គារ៍","ពុធ","ព្រសហ្បត៍","សុក្រ","សៅរ៍"]
      return effectiveDayNumbers.map( ( dayNumber )=> days[ dayNumber ] )
    }

    function minutesToStringTime(minutes){
      let time = {
        hours: 0 ,
        minutes: 0 
      }
      if( minutes > 60 ){
        time.minutes = minutes % 60
        time.hours = ( minutes - time.minutes ) / 60
      }else{
        time.minutes = minutes
      }
      return time
    }
    function getDayOfWeek(number){
      return daysOfWeek.find( day => day.number == number )
    }

    function openGoogleMap(lat,lng){
      window.open( 'https://maps.google.com/?q=' + lat + ',' + lng , '_blank' )
    }

    const checkAttendantPhoto = ref('')
    const showCheckAttendantPhoto = ref(false)
    function viewPhoto(checkTimeId){
      showCheckAttendantPhoto.value = false
      store.dispatch( 'attendant/readPhoto' , { id : checkTimeId } )
        .then( res => {
          if( res.data.ok ){
            checkAttendantPhoto.value = res.data.base64
            showCheckAttendantPhoto.value = true 
          }
        }).catch( err => {
          console.log( err )
        })
    }
    /**
     * Initial the data
     */
    getRecords()


    return {
      /**
       * Variables
       */
      model ,
      table ,
      user ,
      attendantDate ,
      /**
       * Table
       */
      filterRecords ,
      /**
       * Pagination functions
       */
      updatePerpage ,
      goTo ,
      previous ,
      next ,
      /**
       * Loading overlay
       */
      closeTableLoading ,
      /**
       * Functions
       */
      getEffectiveDayName ,
      minutesToStringTime ,
      getDayOfWeek ,
      dateFormat ,
      openGoogleMap ,
      viewPhoto ,
      showCheckAttendantPhoto ,
      checkAttendantPhoto ,
      user
    }
  }
}

</script>

<style scoped >
  .vcb-table-cell {
    @apply p-2 ;
  }
</style>