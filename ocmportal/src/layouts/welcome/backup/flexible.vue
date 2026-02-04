<template>
  <div class="screen-background">
    <div  class="relative flex flex-wrap min-h-screen">
      <div  class="schedule-header-panel flex w-full bg-blue-500 absolute left-0 top-0 right-0">
        <div  class="text-left flex flex-grow">
          <div  class="mx-1 schedule-logo-panel">
            <img  src="./../..//assets/logo.png" class="w-full" />
          </div>
          <div  class="schedule-caption font-ktr ">កាលវិភាគកិច្ចប្រជុំប្រចាំ {{ full_date }}</div>
        </div>
        <div  class="flex-none text-right p-4 digital-clock-panel">
          <digital-clock dgClass="digital-clock font-ktr " />
        </div>
      </div>
      <div :class=" ( meetingRecords != null && meetingRecords.length ? ' schedule-table-panel bottom-14 ' : ' schedule-table-panel bottom-0 ' ) ">
        <Transition name="slide-fade" >
          <table v-if="records.length" class="schedule-table">
            <thead >
              <tr  class="border-b border-gray-200 h-10">
                <th  class="w-1/12 font-moul text-center p-2">ល.រ</th>
                <th  class="font-moul text-left py-2">ខ្លឹមសារ</th>
                <th  class="w-2/12 text-center font-moul p-2">ទីកន្លែង</th>
                <th  class="w-2/12 text-center font-moul p-2">ស្ថានភាព</th>
              </tr>
            </thead>
            <tbody >
              <tr v-for="(record,index) in records" :key="index" class="bg-gray-50">
                <td  class="w-1/12 text-center font-moul meeting-index ">{{ $toKhmer( ( recordsPerSchedulePage * activePage ) + ( index + 1 ) ) }}</td>
                <td  class="text-left relative">
                  <div  class="meeting-objective font-moul ">{{ record.objective }}</div>
                  <div class="grid grid-cols-2" >
                    <div  class="meeting-leaders flex flex-wrap">
                      <div v-for="(listItem, index ) in record.listMembers" :key="index" class="font-moul meeting-leader " >{{ (
                        listItem.member.officers != undefined && listItem.member.officers.length > 0 
                          ? ( 
                            ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) + 
                            ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                          ) 
                          : ''
                      ) + ' ' + listItem.member.lastname + listItem.member.firstname }}</div>
                    </div>
                    <div  class="font-moul meeting-type">{{ record.type != undefined ? record.type.name : '' }}</div>
                  </div>
                </td>
                <td  class="w-2/12">
                  <div  class="font-moul meeting-date">{{ $toKhmer( record.date ) }}</div>
                  <div  class="font-moul meeting-time">{{ $toKhmer( record.start ) }}</div>
                  <div  class="font-moul meeting-rooms">{{ record.rooms != undefined && record.rooms.length > 0 ? record.rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}</div>
                </td>
                <td  class="w-2/12" >
                  <div :class=" ( parseInt( record.status ) > 0 ? statuses.find( s => s.value == record.status ).color : ' text-gray-400 ' ) + ' font-moul meeting-status ' ">{{ 
                    statuses.find( s => s.value == record.status ).label
                  }}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </Transition>
      </div>
      <div v-if="meetingRecords != undefined && meetingRecords.length" class="schedule-footer-panel">
        <Vue3Marquee >
          <div v-for="(meeting, index) in meetingRecords" :key="index" class="meeting-inprogress-panel font-ktr" >{{ $toKhmer( index + 1 ) + ". " + meeting.objective }}</div>
        </Vue3Marquee>
      </div>
      <div v-if="meetingRecords != undefined && meetingRecords.length" class="schedule-footer-caption font-moul" >កំពុងប្រជុំ</div>
    </div>
  </div>
</template>
<script>

import { ref, reactive , onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import DigitalClock from '@components/widgets/DigitalClock.vue'
import { useNotification , useMessage } from 'naive-ui'
import { Vue3Marquee } from 'vue3-marquee'
import Crud from '@classes/Crud.js'

export default {
  name: 'TVSony43' ,
  components: {
    DigitalClock ,
    Vue3Marquee
  },
  setup(){
    /**
     * Components to use
     */
    const store = useStore()
    const router = useRouter()
    const notify = useNotification()
    const message = useMessage()

    const model = reactive({
      name: 'meeting' ,
      module: 'meetings' ,
      title: 'កិច្ចប្រជុំ'
    })

    const full_date = ref(null)

    const toggleLoginForm = ref(false)
    onMounted( () => {
      setTimeout( function(){
        toggleLoginForm.value = true
      } , 200 )
    })

    const statuses = reactive([
      {
        label: 'ទាំងអស់' ,
        value : null ,
        color: ' bg-gray-200 '
      },
      {
        label: 'មិនទាន់ប្រជុំ' ,
        value : 1 ,
        color: ' bg-blue-600 ' 
      } ,
      {
        label: 'កំពុងប្រជុំ' ,
        value : 2 ,
        color: ' bg-green-600 ' 
      } ,
      {
        label: 'នៅបន្ត' ,
        value : 4 ,
        color: ' bg-yellow-600 ' 
      } ,
      {
        label: 'ប្ដូរ' ,
        value : 8 ,
        color: ' bg-pink-600 ' 
      } ,
      {
        label: 'ពន្យាពេល' ,
        value : 16 ,
        color: ' bg-brown-600 ' 
      } ,
      {
        label: 'ចប់' ,
        value : 32 ,
        color: ' bg-gray-600 ' 
      }
    ])

    const recordsPerSchedulePage = ref(4)
    const schedulePages = ref([])
    const activePage = ref(0)
    const records = ref([])
    const meetingRecords = ref([])
    function getScheduleMeeting(){
      store.dispatch( model.name+"/scheduleOnTv" , {
        page: 1 ,
        perPage: 100 ,
        search : "" 
      }).
      then( res => {
        chunkRecords( res.data.records )
      }).catch( err => {
        console.log( err )
      })
    }

    function chunkRecords( responseRecords ){
      schedulePages.value = []
      meetingRecords.value = []
      for( let i = 0 ; i < responseRecords.length; i++ ){
        responseRecords[i].status == 2 ? meetingRecords.value.push( responseRecords[i] ) : false
      }
      full_date.value = responseRecords[0].full_date
      for (let i = 0; i < responseRecords.length; i += recordsPerSchedulePage.value ) {
        schedulePages.value.push( responseRecords.slice(i, recordsPerSchedulePage.value + i) )
      }
      activePage.value = 0
      records.value = schedulePages.value[ activePage.value ]
      // activateSlide()
    }

    let interval = false
    let timeout = false
    function activateSlide(){
      // if( !interval ) clearInterval( interval )
      if( !interval ){
        interval = setInterval(() =>{
          records.value = [] 
          timeout = setTimeout( ()=>{
            console.log( "Timeout : " + timeout )
            activePage.value = activePage.value < ( schedulePages.value.length - 1 ) 
              ? activePage.value + 1
              : 0
            console.log( "Active page : " + activePage.value )
            records.value = schedulePages.value[ activePage.value ]
            clearTimeout( timeout )
            console.log( "Clear timeout : " + timeout )
          },500)
        },6000)
      }
    }
    // const crud = ref(null)
    // function getScheduleMeeting(){
    //   crud.value.list( 
    //     {
    //       // page: parseInt( pagination.value.page ) > 0 ? parseInt( pagination.value.page ) : 1 ,
    //       // perPage: parseInt( pagination.value.perPage ) > 0 ? parseInt( pagination.value.perPage ) : 10 ,
    //       // search : pagination.value.search != null && pagination.value.search != undefined && pagination.value.search != "" ? pagination.value.search : "" 
    //     },
    //     ( res ) => {
    //       window.clearTimeout()
    //     },
    //     ( error ) => {
    //       console.log( error )
    //     }
    //   )
    // }
    // store.commit( model.name+"/setColumns", [ 'id' , 'name' , 'desp' , 'active' , 'image' , 'pdf' , 'pid' , 'tpid' ] )
    // store.commit( model.name+"/setModel", {
    //   name: 'meeting' ,
    //   module: 'meetings' ,
    //   title: 'កិច្ចប្រជុំ'
    // })

    // crud.value = new Crud()
    // crud.value.setConfig( import.meta.env.VITE_API_SERVER , store.getters[model.name+'/model'] , store.getters[model.name+'/columns'].all )

    getScheduleMeeting()

    return {
      toggleLoginForm ,
      records ,
      schedulePages ,
      activePage ,
      recordsPerSchedulePage ,
      full_date ,
      statuses ,
      meetingRecords
    }
  }
}
</script>
<style scoped >
  @media screen and (max-width: 1024px ) {
    .schedule-header-panel {
      @apply h-16 text-gray-100 p-1 ;
    }
    .schedule-logo-panel {
      @apply w-12 p-1 ;
    }
    .schedule-caption {
      @apply h-12 p-4 text-2xl ;
    }
    .digital-clock-panel {
      @apply w-60;
    }
    .digital-clock {
      @apply text-xl text-white  ;
    }
    .schedule-table-panel {
      @apply absolute right-0 left-0 top-16 ;
    }
    .schedule-table {
      @apply w-full min-h-full bg-gray-100 border border-gray-200;
    }
    .schedule-table thead tr th {
      @apply text-lg font-normal text-gray-600 ;
    }
    .schedule-table .meeting-index {
      @apply text-lg;
    }
    .schedule-table .meeting-objective {
      @apply absolute left-0 top-4 font-normal text-gray-700 ;
    }
    .schedule-table .meeting-leaders {
      @apply absolute left-0 bottom-1 w-1/2;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-xxs text-gray-600 leading-5 ;
    }
    .schedule-table .meeting-type {
      @apply absolute right-2 bottom-1 w-1/2 text-xxs leading-5 text-gray-600   text-right;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-gray-600 text-xs ;
    }
    .schedule-table .meeting-status {
      @apply text-xs p-2 rounded-full text-white mx-auto w-28 shadow shadow-gray-700/70 ;
    }
    .schedule-footer-panel {
      @apply fixed left-0 right-0 bottom-0 bg-blue-500 flex h-14 ;
    }
    .schedule-footer-caption { 
      @apply fixed left-0 bottom-0 w-24 h-14 bg-blue-500 text-white text-sm py-5 border-r border-blue-300;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-white text-xl p-4;
    }
  }
  /* @media screen and (max-width: 3840px ) {
    @apply bg-red-500;
  } */
</style>
