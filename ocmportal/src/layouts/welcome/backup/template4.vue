<template>
  <div class="screen-background">
    <div  class="schedule-panel">
      <div  class="schedule-header-panel bg-blue-500 flex w-full" :style=" ' height: '+headerHeight+'px; ' " >
        <div  class="schedule-logo-caption flex-grow flex " :style=" ' height: '+( headerHeight - 6 )+'px; padding: 3px; ' " >
          <div  class="schedule-logo-panel" >
            <img  src="@assets/logo.png" class="w-full schedule-logo" :style=" ' height: '+ ( headerHeight -  6 ) +'px; width: auto;' " />
          </div>
          <div  class="schedule-caption font-btb-black "
            :style="  'line-height: '+( headerHeight - 6 )+'px;' "
            >កាលវិភាគកិច្ចប្រជុំសំខាន់ៗ</div>
          <digital-clock dgClass="digital-clock font-btb-black " :suffix="full_date"
            :style="  'line-height: '+( headerHeight - 6 )+'px;' " />
        </div>
        <!-- <div  class="digital-clock-panel flex-none" :style=" ' height: '+headerHeight+'px; ' " >
          <digital-clock dgClass="digital-clock font-btb-black " />
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
                  records.length == 2 ? 1.5 : 1 
                ) 
              )
            ) +'px; ' " >
            <thead >
              <tr  class="border-b border-gray-200 ">
                <th class="font-btb-black text-center">ល.រ</th>
                <th style="padding-left: 1%;" class="font-btb-black text-left">ខ្លឹមសារ</th>
                <th class="font-btb-black text-center">ទីកន្លែង</th>
                <th class="font-btb-black text-center">ស្ថានភាព</th>
              </tr>
            </thead>
            <tbody >
              <tr v-for="(record,index) in records.length " :key="index" :class=" ' schedule-table-row ' 
              + ( index % 2 ? ' row-odd ' : ' row-even ' )  
              ">
                <td v-if="records[index]!=undefined" class="meeting-index font-btb-black w-1/12 ">{{
                  $toKhmer( ( recordsPerSchedulePage * activePage ) + ( index + 1 ) ) 
                }}</td>
                <!-- <td v-if="records[index]!=undefined" class="w-1/12 p-1 px-2 ">
                  <div  class="font-btb-black meeting-rooms">{{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}</div>
                </td> -->
                <td v-if="records[index]!=undefined" class="text-left relative" style="padding: 1%;" >
                  <table class="w-full h-full" >
                    <tbody>
                      <tr>
                        <td colspan="2" class="" style="vertical-align: super; padding-top: 1%;" ><pre class="meeting-objective font-btb-black w-full text-wrap">{{ records[index].objective }}</pre></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="" style=" padding-bottom: 5px; " >
                          <table class="w-full">
                            <tbody>
                              <tr >
                                <td >
                                    <div v-for="(listItem, index ) in records[index].listMembers" :key="index" class="meeting-leader font-btb-black" >{{ index > 0 ? ' , ' : '' }}{{ ( 
                                      listItem.member.officers != undefined && listItem.member.officers.length > 0 
                                        ? ( 
                                          ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) 
                                          // + ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                                        ) 
                                        : ''
                                    )}} {{ listItem.member.lastname + ' ' +listItem.member.firstname  }}</div>
                                </td>
                                <td class="meeting-type-panel" >
                                    <div class="meeting-type font-btb-black" >
                                      {{ records[index].type != undefined ? records[index].type.name : '' }}
                                    </div>
                                </td>
                              </tr>
                              <!-- <tr>
                                <td 
                                  colspan="2"
                                  class="flex flex-wrap" 
                                  >
                                    <div v-for="(listItem, index ) in records[index].listMembers" :key="index" class="meeting-leader font-btb-black w-full " >{{ (
                                      listItem.member.officers != undefined && listItem.member.officers.length > 0 
                                        ? ( 
                                          ( listItem.member.officers[0].countesy != undefined ? listItem.member.officers[0].countesy.name : ''  ) + 
                                          ( listItem.member.officers[0].position != undefined ? listItem.member.officers[0].position.name : ''  ) 
                                        ) 
                                        : ''
                                    )}} {{ listItem.member.lastname + ' ' +listItem.member.firstname  }}</div>
                                </td>
                              </tr> -->
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
                <td 
                v-if="records[index]!=undefined" class="meeting-dtr font-btb-black">
                  <!-- <div class="font-btb-black meeting-date ">{{ $toKhmer( dateFormat( new Date( records[index].date ) , "dd-mm-yyyy" ) ) }}</div>
                  <div class="font-btb-black meeting-time ">{{ $toKhmer( records[index].start ) }}</div>                  
                  <div class="font-btb-black meeting-room" >{{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}</div> -->
                  {{ $toKhmer( dateFormat( new Date( records[index].date ) , "dd-mm-yyyy" ) ) }}<br/>
                  {{ $toKhmer( records[index].start ) }}<br/>
                  {{ records[index].rooms != undefined && records[index].rooms.length > 0 ? records[index].rooms.map( r => $toKhmer( r.name ) ).join( ' ' ) : '' }}
                </td>
                <td v-if="records[index]!=undefined" class="meeting-status-panel">
                  <div :class="' font-btb-black meeting-status ' + ( statuses.find( s => s.value == records[index].status ).color ) ">{{ 
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
          meeting-inprogress-panel font-btb-black  
          " 
          :style="  'line-height: '+ headerHeight +'px; ' "
          >
          <img :src="pkachanwhite" 
          :style=" ' height: '+( footerHeight / 2 )+'px; ' "
          class="inline-block mr-2 " />{{ meeting.objective }}</div>
        </Vue3Marquee>
      </div>
      <div 
        v-if="meetingRecords != undefined && meetingRecords.length" 
        class="schedule-footer-caption font-btb-black " 
        :style=" ' height: '+footerHeight+'px; ' + 'line-height: '+ headerHeight +'px;' "
      >កំពុងប្រជុំ</div>
    </div>
    <div class="fixed bottom-0 right-0 left-0 text-xxxxs z-50 mx-auto bg-white text-gray-600 rounded text-left pl-4" >
      <div v-if="errorGetScheduleMeeting" class="absolute left-0 bottom-0 w-2 h-2 bg-red-500" ></div>
      <div v-if="!errorGetScheduleMeeting" class="absolute left-0 bottom-0 w-2 h-2 bg-green-500" ></div>{{ 
    windowWidth + "x" + windowHeight + ' - PP' + recordsPerSchedulePage + ' - CY' + fetchingMeetingCounter + ' - ' + ( activePage + 1) + '/' + schedulePages.length 
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
import pkachanwhite from '@assets/pkachanbulletwhite.png'
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
      windowWidth.value = window.innerWidth
      // Limit the height with width
      if( window.innerWidth >= 300 && window.innerWidth <= 399 && window.innerHeight >= 200 && window.innerHeight <= 550 ){
        windowHeight.value = window.innerHeight > 350 ? 350 : window.innerHeight
      }
      else if( window.innerWidth >= 400 && window.innerWidth <= 499 ){
        windowHeight.value = window.innerHeight > 400 ? 400 : window.innerHeight
      }
      else if( window.innerWidth >= 500 && window.innerWidth <= 599 && window.innerHeight <= 799 ){
        windowHeight.value = window.innerHeight > 500 ? 500 : window.innerHeight
      }
      else if( window.innerWidth >= 600 && window.innerWidth <= 699 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 700 && window.innerWidth <= 799 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 800 && window.innerWidth <= 899 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 900 && window.innerWidth <= 999 ){
        windowHeight.value = window.innerHeight > 700 ? 700 : window.innerHeight
      }
      else if( window.innerWidth >= 1000 && window.innerWidth <= 1099 ){
        windowHeight.value = window.innerHeight > 800 ? 800 : window.innerHeight
      }
      else if( window.innerWidth >= 1100 && window.innerWidth <= 1199 ){
        windowHeight.value = window.innerHeight > 900 ? 900 : window.innerHeight
      }
      else if( window.innerWidth >= 1200 && window.innerWidth <= 1399 ){
        windowHeight.value = window.innerHeight > 999 ? 999 : window.innerHeight
      }
      else if( window.innerWidth >= 1400 && window.innerWidth <= 1499 ){
        windowHeight.value = window.innerHeight > 1099 ? 1099 : window.innerHeight
      }
      else if( window.innerWidth >= 1500 && window.innerWidth <= 1999 ){
        windowHeight.value = window.innerHeight > 1099 ? 1099 : window.innerHeight
      }
      else if( window.innerWidth >= 2000 && window.innerWidth <= 2299 ){
        windowHeight.value = window.innerHeight > 1299 ? 1299 : window.innerHeight
      }
      else if( window.innerWidth >= 2400 && window.innerWidth <= 2799 ){
        windowHeight.value = window.innerHeight > 1499 ? 1499 : window.innerHeight
      }
      else if( window.innerWidth >= 2800 && window.innerWidth <= 3800 ){
        windowHeight.value = window.innerHeight > 2199 ? 2199 : window.innerHeight
      }
      else{
        windowHeight.value = window.innerHeight
      }
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

    onMounted( () => {
      reportWindowSize()
    })

    const recordsPerSchedulePage = ref( 
      4
      // Math.ceil( windowHeight.value / 100 ) > 5 ? 5 : Math.ceil( windowHeight.value / 100 )
    )
    const errorGetScheduleMeeting = ref(false)
    const schedulePages = ref([])
    const activePage = ref(0)
    const records = ref([])
    const meetingRecords = ref([])
    const fetchingMeetingCounter = ref(0)
    function getScheduleMeeting(){
      store.dispatch( model.name+"/scheduleOnTv" , {
        page: 1 ,
        perPage: 100 ,
        search : "" 
      }).
      then( res => {
        errorGetScheduleMeeting.value = false
        fetchingMeetingCounter.value++
        chunkRecords( res.data.records )
      }).catch( err => {
        errorGetScheduleMeeting.value = true
        console.log( err )
      })
    }

    function chunkRecords( responseRecords ){
      if( errorGetScheduleMeeting.value == false ){
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

              if( activePage.value == 0 ){
                getScheduleMeeting()
              }

            console.log( "Active page : " + activePage.value )
            records.value = schedulePages.value[ activePage.value ]
            clearTimeout( timeout )
            console.log( "Clear timeout : " + timeout )
          },500)
        },15000)
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
      pkachanwhite ,
      dateFormat ,
      // Functions 
      isSameDate ,
      fetchingMeetingCounter
    }
  }
}
</script>
<style scoped >

@import url(./min-w-300.css);
@import url(./min-w-400.css);
@import url(./min-w-500.css);
@import url(./min-w-600.css);
@import url(./min-w-700.css);
@import url(./min-w-800.css);
@import url(./min-w-900.css);
@import url(./min-w-1000.css);
@import url(./min-w-1100.css);
@import url(./min-w-1200.css);
@import url(./min-w-1400.css);
@import url(./min-w-1500.css);
@import url(./min-w-2000.css);
@import url(./min-w-2400.css);
@import url(./min-w-2800.css);
</style>
