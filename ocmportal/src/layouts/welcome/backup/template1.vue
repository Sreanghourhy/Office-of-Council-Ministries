<template>
  <div class="screen-background">
    <div  class="schedule-panel">
      <div  class="schedule-header-panel bg-blue-500 flex w-full" :style=" ' height: '+headerHeight+'px; ' " >
        <div  class="schedule-logo-caption flex-grow flex flex-nowrap" :style=" ' height: '+( headerHeight - 6 )+'px; padding: 3px; ' " >
          <div  class="schedule-logo-panel" >
            <img  src="@assets/logo.png" class="w-full schedule-logo" :style=" ' height: '+ ( headerHeight -  6 ) +'px; width: auto;' " />
          </div>
          <div  class="schedule-caption font-moul font-normal w-full text-left text-gray-50 pl-4
            "
            :style="  'line-height: '+( headerHeight - 6 )+'px;' "
            >កាលវិភាគកិច្ចប្រជុំប្រចាំ {{ full_date }}</div>
          <digital-clock dgClass="digital-clock font-moul font-normal text-left text-gray-50 px-2
            "
            :style="  'line-height: '+( headerHeight - 6 )+'px;' " />
        </div>
        <!-- <div  class="digital-clock-panel flex-none" :style=" ' height: '+headerHeight+'px; ' " >
          <digital-clock dgClass="digital-clock font-ktr " />
        </div> -->
      </div>
      <div 
        class="schedule-table-panel bg-fixed " 
        :style=" ' height: '+ (
          bodyHeight + ( meetingRecords != undefined && meetingRecords.length ? 0 : footerHeight )
        ) +'px; background-image: url( ' + pkachan + ' ); ' " >
        <Transition name="slide-fade" >
          <table 
            v-if="records.length" 
            class=" schedule-table  w-full bg-gray-50/25" 
            :style=" ' height: '+ (
              ( bodyHeight + ( meetingRecords != undefined && meetingRecords.length ? 0 : footerHeight ) ) / ( 
                records.length == 1 ? 2 : (
                  records.length == 2 ? 3 : 1 
                ) 
              )
            ) +'px; ' " >
            <thead >
              <tr  class="border-b border-gray-200 ">
                <th  class="w-1/12 font-moul text-center p-2 font-normal
                ">ល.រ</th>
                <th  class="font-moul text-left p-2 font-normal
                ">ខ្លឹមសារ 
                <!-- {{ windowWidth + " - " + windowHeight + " / " + ( windowWidth - windowHeight )}} -->
              </th>
                <th  class="w-2/12 text-center font-moul p-2 font-normal
                ">ទីកន្លែង</th>
                <th  class="w-2/12 text-center font-moul p-2 font-normal
                ">ស្ថានភាព</th>
              </tr>
            </thead>
            <tbody >
              <!-- Template I -->
              <tr v-for="(record,index) in records.length " :key="index" :class=" ' schedule-table-row ' 
              + ( index % 2 ? ' row-odd ' : ' row-even ' )  
              ">
                <td v-if="records[index]==undefined" colspan="5" style="height: 100px; " ></td>
                <td v-if="records[index]!=undefined" class="w-1/12 text-center font-moul meeting-index ">{{ 
                  $toKhmer( ( recordsPerSchedulePage * activePage ) + ( index + 1 ) ) 
                }}</td>
                <td v-if="records[index]!=undefined" class="text-left relative">
                  <div  class="meeting-objective font-moul font-normal absolute left-0 top-2 right-0 ">{{ records[index].objective }}</div>
                  <div  class="flex absolute left-0 bottom-2 w-full" >
                    <div  class="meeting-leaders flex absolute left-0 bottom-0 ">
                      <div v-for="(listItem, index ) in records[index].listMembers" :key="index" class="font-moul meeting-leader mr-4" >{{ (
                        listItem.member.officers != undefined && listItem.member.officers.length > 0 
                          ? ( 
                            ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) + 
                            ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                          ) 
                          : ''
                      )}} {{ listItem.member.lastname + " " +listItem.member.firstname  }}</div>
                    </div>
                    <div  class="font-moul meeting-type absolute right-0 bottom-0 ">{{ records[index].type != undefined ? records[index].type.name : '' }}</div>
                  </div>
                </td>
                <td v-if="records[index]!=undefined" class="w-2/12">
                  <div  class="font-moul meeting-date">{{ $toKhmer( dateFormat( new Date( records[index].date ) , "dd-mm-yyyy" ) ) }}</div>
                  <div  class="font-moul meeting-time">{{ $toKhmer( records[index].start ) }}</div>
                  <div  class="font-moul meeting-rooms">{{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}</div>
                </td>
                <td v-if="records[index]!=undefined" class="w-2/12" >
                  <div 
                    :class=" ( parseInt( records[index].status ) > 0 ? statuses.find( s => s.value == records[index].status ).color : ' bg-gray-400 ' ) + 
                    ' font-moul meeting-status rounded-full p-1 text-gray-100 '
                    ">{{ 
                    statuses.find( s => s.value == records[index].status ).label
                  }}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </Transition>
      </div>
      <div 
        v-if="meetingRecords != undefined && meetingRecords.length" 
        class="schedule-footer-panel absolute left-0 bottom-0 right-0  bg-blue-500 z-30"
        :style=" ' height: '+footerHeight+'px; ' "
        >
        <Vue3Marquee >
          <div v-for="(meeting, index) in meetingRecords" :key="index" class="
          meeting-inprogress-panel font-moul font-normal text-gray-50
          " 
          :style="  'line-height: '+ headerHeight +'px;' "
          >{{ $toKhmer( index + 1 ) + ". " + meeting.objective }}</div>
        </Vue3Marquee>
      </div>
      <div 
        v-if="meetingRecords != undefined && meetingRecords.length" 
        class="schedule-footer-caption font-moul font-normal absolute left-0 bottom-0 bg-blue-500 text-gray-50 z-40 px-2 border-r border-gray-50
          " 
        :style=" ' height: '+footerHeight+'px; ' + 'line-height: '+ headerHeight +'px;' "
      >កំពុងប្រជុំ</div>
    </div>
    <div class="fixed bottom-0 right-0 left-0 text-xxxs font-bold z-50 mx-auto text-white text-left pl-10" >{{ 
    windowWidth + " - " + windowHeight + ' - ' + recordsPerSchedulePage
    }}</div>
  </div>
</template>
<script>

import { ref, reactive , onMounted , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import DigitalClock from '@components/widgets/DigitalClock.vue'
import { useNotification , useMessage } from 'naive-ui'
import { Vue3Marquee } from 'vue3-marquee'
import pkachan from '@assets/pkachan.png'
import dateFormat from 'dateformat'
import Crud from '@classes/Crud.js'

export default {
  methods: {
  },
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
        color: ' bg-yellow-600 ' 
      } ,
      {
        label: 'កំពុងប្រជុំ' ,
        value : 2 ,
        color: ' bg-green-600 ' 
      } ,
      {
        label: 'នៅបន្ត' ,
        value : 4 ,
        color: ' bg-blue-600 ' 
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

    // onMounted( () => {
    //   // console.log( window.innerHeight )
    // })

    window.addEventListener("resize", reportWindowSize);
    const windowHeight = ref( window.innerHeight )
    const windowWidth = ref( window.innerWidth )
    function reportWindowSize(){
      windowHeight.value = window.innerHeight
      windowWidth.value = window.innerWidth
    }

    const headerHeight = computed(() => {
      return windowHeight.value * 0.08
    })
    const footerHeight = computed(() => {
      return windowHeight.value * 0.08
    })
    const bodyHeight = computed(() => {
      return windowHeight.value * 0.84
    })

    const recordsPerSchedulePage = ref( 
      5
      // Math.ceil( windowHeight.value / 100 ) > 5 ? 5 : Math.ceil( windowHeight.value / 100 )
    )
    console.log( recordsPerSchedulePage.value )
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
      activateSlide()
    }

    let interval = false
    let timeout = false
    function activateSlide(){
      if( !interval ) clearInterval( interval )
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
        },9000)
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

    function isSameDate( date ){
      return dateFormat( new Date( date ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    function isSameDatetime( datetime ){
      return dateFormat( new Date( datetime ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    getScheduleMeeting()

    return {
      toggleLoginForm ,
      records ,
      schedulePages ,
      activePage ,
      recordsPerSchedulePage ,
      full_date ,
      statuses ,
      meetingRecords ,
      windowHeight ,
      windowWidth ,
      headerHeight ,
      footerHeight ,
      bodyHeight ,
      pkachan ,
      dateFormat ,
      // Functions 
      isSameDate
    }
  }
}
</script>
<style scoped >
@media (min-width: 300px) {
  .screen-background {
    
  }
  .schedule-panel{
    
  }
  .schedule-header-panel {
    
  }
  .schedule-header-panel .schedule-logo-caption {
    
  }
  .schedule-header-panel .digital-clock-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel .schedule-logo {
    
  }
  .schedule-header-panel .schedule-logo-caption .schedule-caption {
    @apply text-xxxs;
  }
  .digital-clock-panel {
    
  }
  .digital-clock {
    @apply text-xxxs;
  }
  .schedule-table-panel {
    
  }
  .schedule-table {
    
  }
  .schedule-table thead tr th {
    @apply  p-1 text-xxxs;
  }
  .schedule-table .schedule-table-row {
    
  }
  .schedule-table .row-odd {
    @apply bg-gray-50/25 ;
  }
  .schedule-table .row-even {
    @apply bg-gray-100/25;
  }
  .schedule-table .meeting-index {
    @apply text-xxxs ;
  }
  .schedule-table .meeting-objective {
    @apply absolute text-xxxs top-2;
    line-height: 0.8rem;
  }
  .schedule-table .meeting-leaders {
    @apply absolute bottom-0;
  }
  .schedule-table .meeting-leaders .meeting-leader {
    @apply text-xxxxxs;
  }
  .schedule-table .meeting-type {
    @apply absolute bottom-0 text-xxxxxs;
  }
  .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
    @apply text-xxxxs;
    line-height: 0.6rem;
  }
  .schedule-table .meeting-status {
    @apply text-xxxxxs ;
  }
  .schedule-footer-panel {
    
  }
  .schedule-footer-caption { 
    @apply text-4xl ;
  }
  .schedule-footer-panel .meeting-inprogress-panel {
    @apply text-4xl mx-4;
  }
}
@media (min-width: 500px) {
  .screen-background {
    
  }
  .schedule-panel{
    
  }
  .schedule-header-panel {
    
  }
  .schedule-header-panel .schedule-logo-caption {
    
  }
  .schedule-header-panel .digital-clock-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel .schedule-logo {
    
  }
  .schedule-header-panel .schedule-logo-caption .schedule-caption {
    @apply text-xs;
  }
  .digital-clock-panel {
    
  }
  .digital-clock {
    @apply text-xs;
  }
  .schedule-table-panel {
    
  }
  .schedule-table {
    
  }
  .schedule-table thead tr th {
    @apply  p-2 text-xxs;
  }
  .schedule-table .schedule-table-row {
    
  }
  .schedule-table .row-odd {
    @apply bg-gray-50;
  }
  .schedule-table .row-even {
    @apply bg-gray-100;
  }
  .schedule-table .meeting-index {
    @apply text-xxs ;
  }
  .schedule-table .meeting-objective {
    @apply absolute text-xxs top-2;
    
    line-height: 1.4rem;
  }
  .schedule-table .meeting-leaders {
    @apply absolute bottom-0;
  }
  .schedule-table .meeting-leaders .meeting-leader {
    @apply text-xxxxs;
  }
  .schedule-table .meeting-type {
    @apply absolute bottom-0 text-xxxxs;
  }
  .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
    @apply text-xxxs;
    line-height: 1rem;
  }
  .schedule-table .meeting-status {
    @apply text-xxxs p-1 ;
  }
  .schedule-footer-panel {
    
  }
  .schedule-footer-caption { 
    @apply text-4xl ;
  }
  .schedule-footer-panel .meeting-inprogress-panel {
    @apply text-4xl mx-4 ;
  }
}
@media (min-width: 700px) {
  .screen-background {
    
  }
  .schedule-panel{
    
  }
  .schedule-header-panel {
    
  }
  .schedule-header-panel .schedule-logo-caption {
    
  }
  .schedule-header-panel .digital-clock-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel {
    
  }
  .schedule-header-panel .schedule-logo-panel .schedule-logo {
    
  }
  .schedule-header-panel .schedule-logo-caption .schedule-caption {
    @apply text-sm;
  }
  .digital-clock-panel {
    
  }
  .digital-clock {
    @apply text-sm;
  }
  .schedule-table-panel {
    
  }
  .schedule-table {
    
  }
  .schedule-table thead tr th {
    @apply  p-2 text-xxs;
  }
  .schedule-table .schedule-table-row {
    
  }
  .schedule-table .row-odd {
    @apply bg-gray-50/25 ;
  }
  .schedule-table .row-even {
    @apply bg-gray-100/25;
  }
  .schedule-table .meeting-index {
    @apply text-xs ;
  }
  .schedule-table .meeting-objective {
    @apply absolute text-xs top-2;
    
    line-height: 1.4rem;
  }
  .schedule-table .meeting-leaders {
    @apply absolute bottom-0;
  }
  .schedule-table .meeting-leaders .meeting-leader {
    @apply text-xxxs;
  }
  .schedule-table .meeting-type {
    @apply absolute bottom-0 text-xxxs;
  }
  .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
    @apply text-xxs;
    line-height: 1rem;
  }
  .schedule-table .meeting-status {
    @apply text-xxs p-2 ;
  }
  .schedule-footer-panel {
    
  }
  .schedule-footer-caption { 
    @apply text-4xl ;
  }
  .schedule-footer-panel .meeting-inprogress-panel {
    @apply text-4xl  mx-4 ;
  }
}
@media (min-width: 1000px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-lg p-3 ;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-lg absolute top-4;
      line-height: 2rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-0;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-xs;
      line-height: 1.2rem;
    }
    .schedule-table .meeting-type {
      @apply absolute bottom-0 text-xs;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-sm;
      line-height: 1.5rem;
    }
    .schedule-table .meeting-status {
      @apply text-sm p-2 ;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-4xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-4xl  mx-4 ;
    }
  }
@media (min-width: 1200px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-2xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-2xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-lg p-2 ;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-lg absolute top-3;
      line-height: 1.9rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-0;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-xs;
      line-height: 1.2rem;
    }
    .schedule-table .meeting-type {
      @apply absolute bottom-0 text-xs;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-sm;
      line-height: 1.5rem;
    }
    .schedule-table .meeting-status {
      @apply text-xl p-2 ;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-2xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-2xl  mx-4 ;
    }
  }
  @media (min-width: 1600px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-2xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-2xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-2xl p-2 ;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-2xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-2xl absolute top-2;
      line-height: 2.4rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-0;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-lg;
      line-height: 2rem;
    }
    .schedule-table .meeting-type {
      @apply absolute bottom-0 text-lg;
      line-height: 2rem;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-xl;
      line-height: 2rem;
    }
    .schedule-table .meeting-status {
      @apply text-xl p-2 ;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-2xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-2xl  mx-4 ;
    }
  }

  @media (min-width: 1800px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-3xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-3xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-2xl p-4;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-3xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-2xl absolute top-4;
      line-height: 2.2rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-0;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-lg;
      line-height: 2.1rem;
    }
    .schedule-table .meeting-type {
      @apply text-lg absolute bottom-0;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-2xl;
      line-height: 2rem;
    }
    .schedule-table .meeting-status {
      @apply text-2xl p-4 ;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-3xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-3xl  mx-4 ;
    }
  }

  @media (min-width: 2500px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-5xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-5xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-4xl p-6;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-4xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-4xl absolute top-10;
      line-height: 4rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-0;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-2xl;
      line-height: 2rem;
    }
    .schedule-table .meeting-type {
      @apply text-2xl absolute bottom-0;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-4xl;
      line-height: 4rem;
    }
    .schedule-table .meeting-status {
      @apply text-4xl p-6 ;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-5xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-5xl  mx-4 ;
    }
  }

  @media (min-width: 3200px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-5xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-5xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-5xl p-6;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-5xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-5xl absolute top-12;
      line-height: 5rem;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-4;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-3xl;
      line-height: 3rem;
    }
    .schedule-table .meeting-type {
      @apply text-3xl absolute bottom-4;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-4xl ;
      line-height: 4rem;
    }
    .schedule-table .meeting-status {
      @apply text-4xl p-6;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-5xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-5xl  mx-4 ;
    }
  }
  @media (min-width: 3800px) {
    .screen-background {
      
    }
    .schedule-panel{
      
    }
    .schedule-header-panel {
      
    }
    .schedule-header-panel .schedule-logo-caption {
      
    }
    .schedule-header-panel .digital-clock-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel {
      
    }
    .schedule-header-panel .schedule-logo-panel .schedule-logo {
      
    }
    .schedule-header-panel .schedule-logo-caption .schedule-caption {
      @apply text-6xl;
    }
    .digital-clock-panel {
      
    }
    .digital-clock {
      @apply text-6xl;
    }
    .schedule-table-panel {
      
    }
    .schedule-table {
      
    }
    .schedule-table thead tr th {
      @apply text-5xl p-8;
    }
    .schedule-table .schedule-table-row {
      
    }
    .schedule-table .row-odd {
      @apply bg-gray-50/25 ;
    }
    .schedule-table .row-even {
      @apply bg-gray-100/25;
    }
    .schedule-table .meeting-index {
      @apply text-5xl ;
    }
    .schedule-table .meeting-objective {
      @apply text-5xl absolute top-12;
    }
    .schedule-table .meeting-leaders {
      @apply absolute bottom-4;
    }
    .schedule-table .meeting-leaders .meeting-leader {
      @apply text-4xl;
      line-height: 4rem;
    }
    .schedule-table .meeting-type {
      @apply text-4xl absolute bottom-4;
    }
    .schedule-table .meeting-date , .schedule-table .meeting-time , .schedule-table .meeting-rooms {
      @apply text-4xl;
      line-height: 4rem;
    }
    .schedule-table .meeting-status {
      @apply text-4xl p-8;
    }
    .schedule-footer-panel {
     
    }
    .schedule-footer-caption { 
      @apply text-5xl ;
    }
    .schedule-footer-panel .meeting-inprogress-panel {
      @apply text-5xl  mx-4 ;
    }
  }

</style>
