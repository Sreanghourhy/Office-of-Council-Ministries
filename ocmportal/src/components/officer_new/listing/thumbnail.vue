<template>
  <div class="relative" >
  <!-- Top action panel of crud -->
    <div class="flex title-bar border-b border-gray-200 p-2 bg-gray-50 ">
      <!-- Title of crud -->
      <div class="flex w-64 h-10 py-1 title " >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12.5 10c0-1.65-1.35-3-3-3s-3 1.35-3 3s1.35 3 3 3s3-1.35 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1zm6.5 2c1.11 0 2-.89 2-2c0-1.11-.89-2-2-2c-1.11 0-2.01.89-2 2c0 1.11.89 2 2 2zM11.99 2.01c-5.52 0-10 4.48-10 10s4.48 10 10 10s10-4.48 10-10s-4.48-10-10-10zM5.84 17.12c.68-.54 2.27-1.11 3.66-1.11c.07 0 .15.01.23.01c.24-.64.67-1.29 1.3-1.86A9.05 9.05 0 0 0 9.5 14c-1.3 0-3.39.45-4.73 1.43c-.5-1.04-.78-2.2-.78-3.43c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.2-.27 2.34-.75 3.37c-1-.59-2.36-.87-3.24-.87c-1.52 0-4.5.81-4.5 2.7v2.78a7.935 7.935 0 0 1-5.66-2.86z" fill="currentColor"></path></svg>
        <div class="font-moul ml-2 leading-9" v-html="model.title" ></div>
      </div>
      <!-- Actions button of the crud -->
      <div class="flex-grow action-buttons flex-row-reverse flex">
        <!-- New Button -->
        <div class="mt-1 ml-2 flex flex-wrap">
          <n-tooltip trigger="hover">
            <template #trigger>
              <svg class="ml-1 w-7 h-7 p-1 mt-1 bg-white rounded-full border border-gray-300 cursor-pointer hover:text-green-500 duration-300" @click="toggleFilter()" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path></svg>
            </template>
            សម្រង់ទិន្នន័យ
          </n-tooltip>
        </div>
        <div class="w-3/5 md:w-2/5 relative" >
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="w-full relative" >
                <input type="text" @keypress.enter="filterRecords(false)" v-model="table.search" class="bg-gray-100 px-2 h-8 my-1 w-full rounded border border-gray-200 focus:border-blue-600 hover:border-blue-600 duration-300" placeholder="ស្វែងរក" />
                <svg class="absolute right-1 top-2 w-6 h-6 text-gray-400  cursor-pointer" @click="filterRecords(false)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
              </div>
            </template>
            សូមបញ្ចូលពាក្យគន្លឹះដើម្បីស្វែងរក
          </n-tooltip>
        </div>
        <div class="mt-1 mr-2 flex flex-wrap">
          <n-tooltip trigger="hover">
            <template #trigger>
              <div @click="showCreateModal()" class="flex cursor-pointer hover:text-green-500 duration-300 ml-2 leading-8" >
                <svg class="w-8 h-8 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg>
                មន្ត្រីមានអត្តលេខ
              </div>
            </template>
            បញ្ចូលព័ត៌មានមន្ត្រី
          </n-tooltip>
          <n-tooltip trigger="hover">
            <template #trigger>
              <div @click="showCreateNonOfficerModal()" class="flex cursor-pointer hover:text-green-500 duration-300 ml-2 leading-8" >
                <svg class="w-8 h-8 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg>
                មន្ត្រីគ្មានអត្តលេខ
              </div>
            </template>
            បញ្ចូលព័ត៌មានមិនមែនមន្ត្រី
          </n-tooltip>
          <!-- <n-tooltip trigger="hover">
            <template #trigger>
              <svg class="mx-1 w-7 h-7 p-1 bg-white rounded-full border border-gray-300 cursor-pointer hover:text-green-500 duration-300" @click="$router.push('/people/export')" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494zM514.1 580.1l-61.8-102.4c-2.2-3.6-6.1-5.8-10.3-5.8h-38.4c-2.3 0-4.5.6-6.4 1.9c-5.6 3.5-7.3 10.9-3.7 16.6l82.3 130.4l-83.4 132.8a12.04 12.04 0 0 0 10.2 18.4h34.5c4.2 0 8-2.2 10.2-5.7L510 664.8l62.3 101.4c2.2 3.6 6.1 5.7 10.2 5.7H620c2.3 0 4.5-.7 6.5-1.9c5.6-3.6 7.2-11 3.6-16.6l-84-130.4l85.3-132.5a12.04 12.04 0 0 0-10.1-18.5h-35.7c-4.2 0-8.1 2.2-10.3 5.8l-61.2 102.3z" fill="currentColor"></path></svg>
            </template>
            នាំចេញទិន្នន័យ
          </n-tooltip> -->
        </div>
      </div>
    </div>
    <!-- Table of crud -->
    <div class="vcb-table-panel relative ">
      <Transition name="fade" >
        <div v-if="Array.isArray( table.records.matched ) && table.records.matched.length > 0 " class="vcb-thumbnail mb-12" >
          <div v-for="(record, index) in table.records.matched" :key='index' class="item" >
            <div class="content" >
              <div v-if="record.image != false && record.image != null && record.image != undefined " class="image bg-cover bg-no-repeat " :style=" 'background-image: url(' + record.image +');' " ></div>
              <div v-if="record.image == false || record.image == null || record.image == undefined " class="image bg-contain bg-center bg-no-repeat " :style=" 'background-image: url('+ocmLogoUrl+');' " ></div>
              <div class="flex flex-wrap " >
                <div class="w-full py-2" >
                  <div v-if="record.countesy != undefined && record.countesy != null " class="w-full text-center font-moul mr-2" >{{  record.countesy.name }}</div>
                  <div v-if="record.people != undefined && record.people != null " class="w-full text-center font-moul leading-6 tracking-wider" >{{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                </div>
                <div class="w-full flex flex-wrap justify-between text-gray-600" >
                  <div v-if=" ( record.position != undefined && record.position != null ) || ( record.dob != undefined && record.dob != null ) " class="w-1/2 text-left text-vcb-xs my-1 leading-5 tracking-wider" >
                    {{ $toKhmer( dateFormat( new Date( record.people.dob ) , 'dd-mm-yyyy' ) ) }}<br/>
                    {{ record.position.name }}
                  </div>
                  <div v-if="record.organization != undefined && record.organization != null " class="w-1/2 text-right text-vcb-xs my-1  leading-5 tracking-wide" v-html=" record.organization.name " ></div>
                </div>
                <div v-if="record.card != null && record.card != undefined && record.card.id > 0" class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider" >{{ $toKhmer( record.card.number ) }}</div>
                <div v-if="record.organization != undefined && record.organization != null " class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider" v-html=" $toKhmer( ( record.organization.prefix != null && record.organization.prefix != '' ? record.organization.prefix + '-' : 'OCM-' ) + ( record.id + '' ).padStart( 4 , '0' ) )" ></div>
                <!-- <div v-if="record.code != null && record.code != undefined " class="absolute left-1 top-5 text-vcb-xs text-left font-bold leading-6 tracking-wider" v-html=" $toKhmer( record.code )" ></div> -->
              </div>
              <thumbnail-actions-form v-bind:model="model" v-bind:record="record" :onClose="closeActions" />
            </div>
          </div>
        </div>
      </Transition>
      <!-- Loading -->
      <Transition name="slide-fade" >
        <div v-if="table.loading" class="table-loading fixed flex h-screen left-0 top-10 right-0 bottom-0 bg-white bg-opacity-90 ">
          <div class="flex mx-auto items-center">
            <div class="spinner">
              <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
              <br/><br/>កំពុងអាន...
            </div>
          </div>
          <div class="absolute top-2 right-2 cursor-pointer bg-white rounded-full " @click="closeTableLoading" >
            <svg class="w-10 mx-auto text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
          </div>
        </div>
      </Transition>
      <!-- Pagination of crud -->
      <Transition name="slide-fade" >
        <div v-if="table.pagination.totalPages > 1 " class="fixed left-0 right-0 bottom-1 flex flex-wrap" >
          <div class="vcb-table-pagination bg-blue-300 mx-auto">
            <n-tooltip trigger="hover">
              <template #trigger>
                <n-popselect 
                  trigger="click"
                  v-model:value="table.pagination.perPage"
                  :options="[
                    { label: 5 , value: 5 } ,
                    { label: 10 , value: 10 } ,
                    { label: 20 , value: 20 } ,
                    { label: 30 , value: 30 } ,
                    { label: 40 , value: 40 } ,
                    { label: 50 , value: 50 } ,
                    { label: 100 , value: 100 } ,
                    { label: 200 , value: 200 } ,
                    { label: 500 , value: 500 } ,
                  ]"
                  size="small"
                  scrollable
                  @update:value="goTo(1)"
                >
                  <div class="cursor-pointer font-pvh rounded-full p-2 px-4 border border-gray-200 text-blue-600" >{{ $toKhmer( table.pagination.perPage ) }}</div>
                </n-popselect>
              </template>
              ចំនួនព័ត៌មានបង្ហាញម្ដង
            </n-tooltip>
            <!-- <n-tooltip trigger="hover">
              <template #trigger>
                <div class="vcb-table-pagination-info font-pvh " >{{ table.pagination.totalRecords > 0 ? $toKhmer( table.pagination.totalRecords ) + " ព័ត៌មាន" : "" }}</div>
              </template>
              ចំនួនព័ត៌មានសរុប
            </n-tooltip> -->
            <n-tooltip trigger="hover">
              <template #trigger>
                <div class="vcb-table-pagination-info font-pvh " >{{ table.pagination.totalPages > 0 ? $toKhmer( table.pagination.totalPages ) + " ទំព័រ" : "" }}</div>
              </template>
              ចំនួនទំព័រសរុប
            </n-tooltip>
            <div v-for="(page, index) in table.pagination.buttons" :key="index" :class=" (table.pagination.page == page ? ' vcb-pagination-page-active ' : ' vcb-pagination-page ' )" @click="table.pagination.page == page ? false : goTo(page) " >
              <n-tooltip trigger="hover">
                <template #trigger>
                  <div class="leading-8 text-md font-pvh " >{{ $toKhmer( page ) }} </div>
                </template>
                ទំព័រទី {{ $toKhmer( page ) }}
              </n-tooltip>
            </div>
            <Transition name="slide-fade" >
              <div v-if="table.pagination.page > 1 " class="vcb-pagination-page " v-html='"<"' @click="previous()" ></div>
            </Transition>
            <Transition name="slide-fade" >
              <div v-if="table.pagination.page < table.pagination.totalPages " class="vcb-pagination-page " v-html='">"' @click="next()" ></div>
            </Transition>
          </div>
        </div>
      </Transition>
    </div>
    <!-- Form create account -->
    <create-form v-bind:model="model" v-bind:show="createModal.show" :onClose="closeCreateModal"/>
    <create-non-officer-form v-bind:model="model" v-bind:show="createNonOfficerModal.show" :onClose="closeCreateNonOfficerModal"/>
    <!-- Filter panel of crud -->
    <Transition name="slide-fade" >
      <div v-if="filter" class="vcb-filters-panel">
        <svg @click="toggleFilter()" class="absolute bg-white rounded-full shadow p-2 right-2 top-2 w-10 h-10 border border-gray-200 cursor-pointer hover:text-green-500 duration-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path></svg>
        <div class="filter-title font-moul" >សូមជ្រើសរើសលក្ខណ សម្រង់ទិន្នន័យ៖</div>
        <div class="filter-actions" >
          <div class="filter-action" >
            <!-- Positions -->
            <n-select v-model:value="selectedPositions" filterable clearable multiple @update:value="filterRecords(false)" placeholder="សូមជ្រើសរើស មុខតំណែង" :options="optionPositions" />
          </div>
          <div class="filter-action" >
            <!-- Organizations -->
            <n-select v-model:value="selectedOrganizations" filterable clearable multiple @update:value="filterRecords(false)" placeholder="សូមជ្រើសើស ស្ថាប័ន / អង្គភាព" :options="optionOrganizations" />
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>
<script>
import { reactive ,ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import ocmLogoUrl from './../../../assets/logo.svg'
import dateFormat from 'dateformat'
/**
 * CRUD component form
 */
import CreateForm from './../widgets/create.vue'
import CreateNonOfficerForm from './../widgets/createnonofficer.vue'
import ThumbnailActionsForm from './actions/thumbnail-action.vue'
export default {
  name: "People" ,
  components: {
    QrcodeVue ,
    Vue3Barcode,
    /**
     * Forms
     */
    CreateForm ,
    CreateNonOfficerForm ,
    ThumbnailActionsForm
  },
  setup(){
    const store = useStore()
    const route = useRoute()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()

    const peopleIds = ref( 
      route.params.ids != undefined && route.params.ids.trim().length > 0 ? route.params.ids.split(',') : null
    )

    /**
     * Variables
     */    
    const model = reactive( {
      name: "officer" ,
      module: "officers" ,
      title: "មន្ត្រី"
    })
    const table = reactive( {
      loading: false ,
      search: '' ,
      records: {
        all: [] ,
        matched: []
      },
      columns: {
        searchable: {
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          email: '' ,
          phone: '' ,
          active: ''
        },
        format: {
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          email: '' ,
          phone: '' ,
          active: ''
        }
      } ,
      pagination: {
        perPage: 20 ,
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
        setTimeout( function(){
          table.pagination.page = 1
          getRecords()
        } , 500 )
      }
    }

    /**
     * Functions
     */
    function getRecords(){
      /**
       * Clear time interval after calling
       */
      window.clearTimeout()
      table.loading = true
      store.dispatch(model.name+'/list',{
        search: table.search ,
        perPage: table.pagination.perPage ,
        page: table.pagination.page ,
        positions: selectedPositions.value ,
        organizations: selectedOrganizations.value ,
        ids: peopleIds.value
      }).then(res => {
        table.records.all = table.records.matched = res.data.records
        table.pagination = res.data.pagination
        
        var paginationNumberList = 10
        if( ( table.pagination.page - ( parseInt( paginationNumberList / 2 ) + 1 ) ) < 1 ){
          table.pagination.start = 1
          table.pagination.end = table.pagination.totalPages > paginationNumberList ? paginationNumberList : table.pagination.totalPages
        }
        else{
          table.pagination.start = table.pagination.page - parseInt( paginationNumberList / 2 )
          table.pagination.end = table.pagination.page >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + parseInt( paginationNumberList / 2 )
        }
        /**
         * Create pagination buttons
         */
        table.pagination.buttons = []
        for(var i=table.pagination.start;i<=table.pagination.end;i++){
          i <= table.pagination.totalPages ? table.pagination.buttons.push(i) : false
        }

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
     * Create modal handling
     */
    var createModal = reactive({show:false})
    function showCreateModal(){
      createModal.show = true
    }

    function closeCreateModal( actionStatus ){
      createModal.show = false
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }

    /**
     * Create non officer modal handling
     */
     var createNonOfficerModal = reactive({show:false})
    function showCreateNonOfficerModal(){
      createNonOfficerModal.show = true
    }

    function closeCreateNonOfficerModal( actionStatus ){
      createNonOfficerModal.show = false
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }

    function closeActions( actionStatus ){
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }
    
    /**
     * Load positions
     */
    const selectedPositions = ref(null)
    const optionPositions = computed( () => {
      let positions = Array.isArray( store.getters['position/getRecords'] ) && store.getters['position/getRecords'].length > 0 ? store.getters['position/getRecords'] : []
      positions = positions.map( ( p ) => { return { label : p.name , value : p.id } })
      positions.unshift({ label: 'សូមជ្រើសរើស មុនតំណែង' , value: null })
      return positions
    })
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

    /**
     * Load positions
     */
    const selectedOrganizations = ref(null)
    const optionOrganizations = computed( () => {
      let organizations = Array.isArray( store.getters['organization/getRecords'] ) && store.getters['organization/getRecords'].length > 0 ? store.getters['organization/getRecords'] : []
      organizations = organizations.map( ( p ) => { return { label : p.name , value : p.id } })
      organizations.unshift({ label: 'សូមជ្រើសរើស ស្ថាប័ន / អង្គភាព' , value: null })
      return organizations
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

    /**
     * Load positions
     */
     const selectedCountesies = ref(null)
    const optionCountesies = computed( () => {
      let countesies = Array.isArray( store.getters['countesy/getRecords'] ) && store.getters['countesy/getRecords'].length > 0 ? store.getters['countesy/getRecords'] : []
      countesies = countesies.map( ( p ) => { return { label : p.name , value : p.id } })
      countesies.unshift({ label: 'សូមជ្រើសរើស ងារ' , value: null })
      return countesies
    })
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

    const filter = ref(false)    
    function toggleFilter(){
      filter.value = !filter.value
    }
    /**
     * Initial the data
     */
    getRecords()
    getPositions()
    getOrganizations()
    getCountesies()


    return {
      /**
       * Variables
       */
      model ,
      table ,
      ocmLogoUrl ,
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
       * Creating
       */
      createModal ,
      showCreateModal ,
      closeCreateModal ,
      /**
       * Creating non officer
       */
      createNonOfficerModal ,
      showCreateNonOfficerModal ,
      closeCreateNonOfficerModal ,
      closeActions ,
      /**
       * Functions
       */
      toggleFilter ,
      filterRecords ,
      filter ,
      /**
      * Filters
      */
      optionPositions ,
      selectedPositions ,
      selectedCountesies ,
      optionOrganizations ,
      selectedOrganizations ,
      dateFormat
    }
  }
}

</script>
<style type="text/css" scoped >
.vcb-thumbnail {
  @apply flex flex-wrap justify-center;
}
.vcb-thumbnail .item {
  @apply xl:w-1/5 lg:w-1/4 md:w-1/3 sm:w-1/3 w-1/2 p-2 ;
}
.vcb-thumbnail .item .content {
  @apply border rounded-lg hover:shadow duration-500 p-4 pt-8 relative hover:scale-105 transform-gpu bg-white hover:bg-yellow-100;
}
.vcb-thumbnail .item .content .image {
  @apply border rounded-full border-gray-200 p-2 w-20 h-20 flex-none mx-auto overflow-hidden bg-white ;
}
.vcb-filters-panel {
  @apply fixed left-0 top-10 right-0 bottom-0 bg-opacity-60 bg-white ;
}
.vcb-filters-panel .filter-title {
  @apply w-full text-left p-4 bg-white rounded-lg ;
}
.vcb-filters-panel .filter-actions {
  @apply w-full text-left p-4 flex flex-wrap justify-center;
}
.vcb-filters-panel .filter-actions .filter-action {
  @apply p-2 m-2 bg-white rounded-lg shadow border border-gray-300 w-4/6 sm:w-2/5 md:w-1/3 lg:w-1/4 xl:w-2/6 ;
}
</style>