<template>
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <div class="w-11/12 font-pvh text-xl bg-white p-4" >
          <!-- Selected Rooms -->
          <div class="border-b border-gray-200 py-2 font-moul" >ជ្រើសរើសបន្ទប់ប្រជុំ</div>
            <div v-if="rooms.length" class="flex justify-center p-8 " >
              <div v-for="(room,index) in rooms" :key="index" @click="toggleMeetingRooms(room)" class="relative p-4 rounded border w-40 h-40 font-moul flex items-center place-content-center text-center m-4 cursor-pointer hover:shadow duration-300 hover:border-blue-400" >
                បន្ទប់ ឬ សាល<br/>{{ room.name }}
                <svg v-if="selectedRooms.find( (selectedRoom) => selectedRoom.id == room.id)" class="absolute right-2 top-2 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2zm0 1.5a8.5 8.5 0 1 0 0 17a8.5 8.5 0 0 0 0-17zm-1.25 9.94l4.47-4.47a.75.75 0 0 1 1.133.976l-.073.084l-5 5a.75.75 0 0 1-.976.073l-.084-.073l-2.5-2.5a.75.75 0 0 1 .976-1.133l.084.073l1.97 1.97l4.47-4.47l-4.47 4.47z" fill="currentColor"></path></g></svg>
              </div>
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

    // Search Rooms
    const rooms = ref([])
    const roomSearch = ref('')
    const selectedRooms = ref( [] )

    function getRooms(){
      rooms.value = store.getters['meetingRoom/records'].all
      // store.dispatch( props.model.name+'/rooms',{
      //   search : roomSearch.value ,
      //   perPage : 500 ,
      //   page : 1
      // }).then( res => {
      //   if( res.data.records.length > 0 ){
      //     rooms.value = res.data.records
      //   }
      // }).catch( err => {
      //   console.log( err )
      //   notify.error({
      //     'title' : 'បន្ទប់ប្រជុំ' ,
      //     'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកបន្ទប់ប្រជុំ។' ,
      //     duration : 3000
      //   })
      // })
    }

    function toggleMeetingRooms(room){
      store.dispatch( props.model.name+'/toggleMeetingRoom',{ room : room , meeting : props.record })
      .then( res => {
        if( res.data.ok ){
          selectedRooms.value = res.data.record.rooms 
        }else{
          notify.warning({
            'title' : 'បន្ទប់ប្រជុំ' ,
            'description' : 'មិនមានបន្ទប់ប្រជុំឡើយ' ,
            duration : 3000
          })
        }
      }).catch( err => {
        console.log( err )
        notify.error({
          'title' : 'បន្ទប់ប្រជុំ' ,
          'description' : 'មានបញ្ហាក្នុងពេលស្វែងរកបន្ទប់ប្រជុំ។' ,
          duration : 3000
        })
      } )
    }

    function maskOrEscClick(){
      props.onClose( 1 )
    }

    function initial(){
      getRooms()
      selectedRooms.value = props.record.rooms != undefined && props.record.rooms.length > 0 ? props.record.rooms : []
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
      selectedRooms ,
      rooms ,
      toggleMeetingRooms
    }
  }
}
</script>