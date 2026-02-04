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
                <th  class="w-2/12 font-moul text-left p-2 font-normal">ម៉ោង</th>
                <!-- <th  class="w-2/12 font-moul text-center p-2 font-normal">សាល</th> -->
                <th colspan='2' class="font-moul text-left p-2 font-normal">ខ្លឹមសារ</th>
              </tr>
            </thead>
            <tbody >
              <tr v-for="(record,index) in records.length " :key="index" :class=" ' schedule-table-row ' 
              + ( index % 2 ? ' row-odd ' : ' row-even ' )  
              ">
                <td 
                v-if="records[index]!=undefined"
                style="vertical-align: top; " :class=" ' w-2/12 pt-4 pl-4 text-center '">
                  <div class="font-moul meeting-time ">{{ $toKhmer( records[index].start ) + " - " + $toKhmer( records[index].end ) }}</div>
                  <div class="font-moul meeting-date ">{{ $toKhmer( dateFormat( new Date( records[index].date ) , "dd-mm-yyyy" ) ) }}</div>
                </td>
                <!-- <td v-if="records[index]!=undefined" class="w-1/12 p-1 px-2 ">
                  <div  class="font-moul meeting-rooms">{{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}</div>
                </td> -->
                <td v-if="records[index]!=undefined" class="text-left relative ">
                  <table class="w-full h-full" >
                    <tbody>
                      <tr>
                        <td colspan="2" class="meeting-objective font-moul" style="vertical-align: top; " >{{ records[index].objective }}</td>
                      </tr>
                      <tr>
                        <td colspan="2" style="vertical-align: bottom; padding-bottom: 5px; " >
                          <table class="w-full">
                            <tbody>
                              <tr>
                                <td 
                                  colspan="2"
                                  class="flex" 
                                  >
                                    <div v-for="(listItem, index ) in records[index].listMembers" :key="index" class="meeting-leader font-moul" >{{ (
                                      listItem.member.officers != undefined && listItem.member.officers.length > 0 
                                        ? ( 
                                          ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) + 
                                          ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                                        ) 
                                        : ''
                                    )}} {{ listItem.member.lastname + ' ' +listItem.member.firstname  }}</div>
                                </td>
                              </tr>
                              <tr>
                                <!-- <td 
                                  class="flex" 
                                  >
                                    <div v-for="(listItem, index ) in records[index].listMembers" :key="index" class="meeting-leader font-moul" >{{ (
                                      listItem.member.officers != undefined && listItem.member.officers.length > 0 
                                        ? ( 
                                          ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) + 
                                          ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                                        ) 
                                        : ''
                                    )}} {{ listItem.member.lastname + ' ' +listItem.member.firstname  }}</div>
                                </td> -->
                                <td >
                                    <div class="meeting-room font-moul" >
                                      {{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}
                                    </div>
                                </td>
                                <td >
                                    <div class="meeting-type font-moul" >
                                      {{ records[index].type != undefined ? records[index].type.name : '' }}
                                    </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td v-if="records[index]!=undefined" class="w-2/12 p-1 px-2 ">
                  <div :class="' font-moul meeting-status ' + ( statuses.find( s => s.value == records[index].status ).color ) ">{{ 
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
          meeting-inprogress-panel font-moul font-normal text-gray-50 pr-16
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

/**
  Start
*/
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
  @apply bg-gray-50 ;
}
.schedule-table .row-even {
  @apply bg-gray-100;
}
.schedule-table .meeting-index {
  @apply text-3xl ;
}
.schedule-table .meeting-objective {
  @apply font-normal text-3xl pt-6;
  line-height: 2.2rem;
}
.schedule-table .meeting-leader {
  @apply text-lg mr-6 font-normal ;
  line-height: 2.1rem;
}
.schedule-table .meeting-room {
  @apply text-lg mr-6 font-normal w-full text-left;
  line-height: 2.1rem;
}
.schedule-table .meeting-type {
  @apply text-lg mr-6 font-normal w-full text-right ;
  line-height: 2.1rem;
}
.schedule-table .meeting-time {
  @apply text-3xl pt-2 mb-2 ;
  line-height: 2rem;
}
.schedule-table .meeting-date {
  @apply text-xl pt-2 mb-2;
  line-height: 2rem;
}
.schedule-table .meeting-status {
  @apply text-xl inline-block rounded-full text-center p-4 text-gray-50 ;
}
.schedule-footer-panel {
  
}
.schedule-footer-caption { 
  @apply text-3xl ;
}
.schedule-footer-panel .meeting-inprogress-panel {
  @apply text-3xl  mx-4 ;
}
/**
 End
*/
@media (min-width: 300px) {
  
}
@media (min-width: 500px) {
  
}
@media (min-width: 700px) {
  
}
@media (min-width: 1000px) {
    
}
@media (min-width: 1200px) {
    
}
@media (min-width: 1600px) {
  
}

@media (min-width: 1800px) {

}

@media (min-width: 2500px) {
  
}

@media (min-width: 3200px) {
  
}
@media (min-width: 3800px) {
  
}

</style>
