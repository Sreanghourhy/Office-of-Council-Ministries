<template>
  <div class="absolute left-0 top-0 right-0 bottom-0 " >
    <div class="w-11/12 sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-6/12 2xl:w-6/12 m-4 p-8 mx-auto mt-2 mb-24 relative z-40">
      <Transition name="fade" >
        <div class="w-full flex flex-wrap justify-between" >
          <div class="w-full p-1 mx-auto" >
            <div v-if="organization != null && organization != undefined && checkAttendantStatus == false " class="p-2 w-full leading-5 flex flex-wrap relative cursor-pointer" >
              <div class="identification-checking-panel mx-auto w-full mb-4" >
                <div class="w-full text-center m-2 relative" >
                  <div class="w-20 h-20 mx-auto bg-contain bg-no-repeat bg-center" :style="' background-image: url(' + ocmLogoUrl + '); '" ></div>
                  <div class="w-full font-moul mb-0 text-yellow-600 leading-8 text-xs" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                  <div class="w-full font-moul mb-8 leading-6 text-xs " >{{ organization.name }}</div>
                  <div class="camera rounded w-80 relative  my-4 mx-auto ">
                    <camera ref="refCamera" :getSnapshot="onSnap" />
                  </div>
                  <div class="w-full text-left text-xs " >
                    <n-tabs type="line" animated class="" v-model:value="tabValueChange" @update:value="tabChange" >
                      <!-- <n-tab-pane name="id" tab="លេខសម្គាល់ខ្លួន">
                        សូមបញ្ចូលលេខកូដសម្គាល់ខ្លួន
                        <n-tooltip trigger="hover">
                          <template #trigger>
                            <n-input 
                              v-model:value="staffId"
                              :allow-input="onlyAllowNumberAndNoSideSpace"
                              placeholder="លេខសម្គាល់"
                              class="m-2 mx-auto "
                              >
                              <template #prefix>
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M10 9h2v2h-2z" fill="currentColor"></path><path d="M18 23h-4V9h4a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4zm-2-2h2a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-2z" fill="currentColor"></path><path d="M10 13h2v10h-2z" fill="currentColor"></path></svg>
                              </template>
                            </n-input>
                          </template> 
                          សូមបញ្ចូលលេខសម្កាល់ខ្លួនរបស់អ្នក។ 
                        </n-tooltip>
                      </n-tab-pane> -->
                      <n-tab-pane name="phone" tab="លេខទូរសព្ទ័">
                        <n-tooltip trigger="hover">
                          <template #trigger>
                            <n-input 
                              v-model:value="staffPhone"
                              :allow-input="onlyAllowNumberAndNoSideSpace"
                              placeholder="លេខទូរស័ព្ទ"
                              class="m-2 mx-auto "
                              @keyup.enter="checkIdentity"
                              >
                              <template #prefix>
                                <svg class="w-4 h-4"  version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g><path d="M335.7,32H177.1C158.8,32,144,46.6,144,64.9v381c0,18.4,14.8,34.1,33.1,34.1h158.5c18.3,0,32.3-15.7,32.3-34.1v-381
                                  C368,46.6,354,32,335.7,32z M241,55h30c2.2,0,4,1.8,4,4c0,2.2-1.8,4-4,4h-30c-2.2,0-4-1.8-4-4C237,56.8,238.8,55,241,55z
                                  M256.5,465c-9.6,0-17.4-7.8-17.4-17.4c0-9.6,7.8-17.4,17.4-17.4c9.6,0,17.4,7.8,17.4,17.4C273.9,457.2,266.1,465,256.5,465z
                                  M350,416H162c-1.1,0-2-0.9-2-2V85c0-1.1,0.9-2,2-2h188c1.1,0,2,0.9,2,2v329C352,415.1,351.1,416,350,416z"></path></g></svg>
                              </template>
                            </n-input>
                          </template> 
                          សូមបញូលលេខទូរស័ព្ទដែលអ្នកប្រើក្នុងប្រព័ន្ធ 
                        </n-tooltip>
                      </n-tab-pane>
                      <n-tab-pane name="email" tab="អ៊ីមែល">
                        <n-tooltip trigger="hover">
                          <template #trigger>
                            <n-input 
                              v-model:value="staffEmail"
                              placeholder="អសយដ្ឋានអេឡិចត្រូនិក (អ៊ីមែល)"
                              class="m-2 mx-auto "
                              @keyup.enter="checkIdentity"
                              >
                              <template #prefix>
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28 6H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-2.2 2L16 14.78L6.2 8zM4 24V8.91l11.43 7.91a1 1 0 0 0 1.14 0L28 8.91V24z" fill="currentColor"></path></svg>
                              </template>
                            </n-input>
                          </template>
                          សូមបញូលអសយដ្ឋានអេឡិចត្រូនិច (អ៉ីមែល) ដែលអ្នកប្រើក្នុងប្រព័ន្ធ  
                        </n-tooltip>
                      </n-tab-pane>
                    </n-tabs>
                    <div class="text-yellow-800 w-full py-2 leading-5 text-xs hidden " >* អ៉ីមែល និង លេខទូរសព្ទ អាចបញ្ចូលមួយណាក៏បាន ឬ ទាំង ២។</div>
                  </div>
                  <div class="w-full flex flex-wrap " >
                    <div class="w-48 mx-auto leading-8 border border-green-400 bg-green-50 rounded mt-6 text-center cursor-pointer hover:border-green-600 duration-300 hover:bg-green-200" @click="checkIdentity" >បញ្ជាក់អត្តសញ្ញាណ</div>
                    <!-- <div class="w-48 mx-auto flex flex-wrap leading-8 border border-gray-300 rounded mt-6 text-center cursor-pointer hover:border-blue-500 duration-300 hover:bg-blue-100" @click="$router.push('/officer/checkinout/'+organization.id+'/camera')">
                      <svg class="w-8 h-8 mr-2 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M15 21h-2v-2h2v2zm-2-7h-2v5h2v-5zm8-2h-2v4h2v-4zm-2-2h-2v2h2v-2zM7 12H5v2h2v-2zm-2-2H3v2h2v-2zm7-5h2V3h-2v2zm-7.5-.5v3h3v-3h-3zM8 9H4c-.55 0-1-.45-1-1V4c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v4c0 .55-.45 1-1 1zm-3.5 7.5v3h3v-3h-3zM8 21H4c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v4c0 .55-.45 1-1 1zm8.5-16.5v3h3v-3h-3zM20 9h-4c-.55 0-1-.45-1-1V4c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v4c0 .55-.45 1-1 1zm-1 10v-3h-4v2h2v3h4v-2h-2zm-2-7h-4v2h4v-2zm-4-2H7v2h2v2h2v-2h2v-2zm1-1V7h-2V5h-2v4h4zM6.75 5.25h-1.5v1.5h1.5v-1.5zm0 12h-1.5v1.5h1.5v-1.5zm12-12h-1.5v1.5h1.5v-1.5z" fill="currentColor"></path></svg>
                      ពិនិត្យវត្តមានតាម QR កូត
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- User current location in the map -->
              <!-- <Transition name="slide-fade" >
                <div class="hidden w-full p-1 my-4 mx-auto" 
                  v-if="currentGeolocation.lat != null && currentGeolocation.lat != undefined && currentGeolocation.lng != null && currentGeolocation.lng != undefined "
                  >
                  <div 
                    class="google-map border border-gray-200 p-1" >
                    <GoogleMap
                      api-key="AIzaSyDObCQ64io6LBvly6qFPP2dHlOKjBXz5tw"
                      style="width: 100%; height: 200px"
                      :center="currentGeolocation"
                      :zoom="15"
                      >
                      <Marker :options="{ position: currentGeolocation }" />
                    </GoogleMap>
                  </div>
                </div>
              </Transition> -->
            </div>
          </div>
        </div>
      </Transition>
    </div>
    <Transition name="slide-fade" >
      <div v-if="identification!=null" class="z-50 fixed left-0 top-0 right-0 bottom-0 bg-white flex flex-wrap overflow-y-auto" >
        <div class="relative w-11/12 sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-6/12 2xl:w-6/12 m-4 p-8 mx-auto" >
          <div class="font-moul w-full mb-0" ><img :src="ocmLogoUrl" class="w-16 mx-auto" /></div>
          <div class="w-full font-moul mb-0 text-yellow-600 leading-8 text-xs" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
          <div class="w-full font-moul mb-6 leading-6 text-xs " >{{ organization.name }}</div>
          <div class="font-moul w-full mb-4" >ការពិនិត្យវត្តមានមន្ត្រី និងថ្នាក់ដឹកនាំ</div>
          <div class=" w-full mb-4" >
            <div class="welcome_message leading-7 hidden" >គោរពជំរាបសួរ និង សួស្ដីបាទ</div>
            <div class="countesies leading-7 font-pvh" >{{ identification.officer.countesy != null && identification.officer.countesy != undefined ? identification.officer.countesy.name : '' }}</div>
            <div class="name leading-7 font-moul" >{{ identification.officer.people.lastname + ' ' + identification.officer.people.firstname }}</div>
            <div class="countesies leading-7" >
              {{ identification.officer.position != null && identification.position != undefined ? identification.officer.position.name : '' }}
              {{ identification.officer.organization != null && identification.organization != undefined ? identification.officer.organization.name : '' }}
            </div>
          </div>
          <div class="w-full mb-4 mx-auto bg-contain bg-no-repeat bg-center" >
            <img class="w-24 mx-auto rounded p-1 border border-gray-300 " :src="identification.avatar_url" @error="ocmLogoUrl" />
          </div>
          <div class="w-full p-4" >
            <digital-clock type="time" dgClass=" w-full my-2 p-2 rounded-md text-gray-800 shadow:md font-moul text-lg" />
            <!-- Check whether the attenant has been checked -->
            <div v-if="attendant==null || ( attendant != null && checkStatus == -1 )" >
              <div @click="checkAttendant" class="cursor-pointer w-1/2 mx-auto" ><div class="border border-green-300 bg-white rounded-md p-4 w-full mx-auto" >ចុះវត្តមាន ចូល</div></div>
            </div>
            <Transition name="slide-fade" >
              <div v-if="attendant!=null && ( checkStatus == 0 || checkStatus == 1 ) " >
                <div @click="checkAttendant" class="cursor-pointer w-1/2 mx-auto" ><div class="border border-green-300 bg-white rounded-md p-4 w-full mx-auto" >
                  {{ checkStatus == 0 ? "ចុះវត្តមានចេញ" : "ចុះវត្តមាន ចូល" }}
                </div></div>
                <div class="mt-8" v-if="checktimes!=null&&checktimes.length>0" >
                  <table class="w-full border border-gray-200 " >
                    <thead>
                    <tr>
                      <td colspan="3" class="p-1 leading-6 text-center bg-gray-200 align-text-top" >តារាងពិនិត្យវត្តមាន</td>
                    </tr>
                    <tr>
                      <td class="p-1 leading-6 text-left align-text-top border-b border-gray-200 " >ល.រ</td>
                      <td class="p-1 leading-6 text-left align-text-top border-b border-gray-200 " >អង្គភាព</td>
                      <td class="p-1 leading-6 text-center align-text-top border-b border-gray-200 " >ម៉ោង</td>
                      <td class="p-1 leading-6 text-center align-text-top border-b border-gray-200 " >ប្រភេទ</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(checktime,index) in checktimes" :key='index' >
                      <td class="p-1 leading-6 text-center align-text-top" >{{  $toKhmer( index + 1 ) }}</td>
                      <td class="p-1 leading-6 text-left align-text-top" >{{ checktime.organization != undefined && checktime.organization != null ? checktime.organization.name : "ក្នុងប្រព័ន្ធ" }}</td>
                      <td class="p-1 leading-6 text-center align-text-top" >{{  $toKhmer( checktime.checktime ) }}</td>
                      <td class="p-1 leading-6 text-center align-text-top" >{{ parseInt( checktime.check_status ) == 0 ? "ចេញ" : "ចូល" }}</td>
                    </tr>
                  </tbody>
                  </table>
                </div>
              </div>
            </Transition>
          </div>
        </div>
        <n-tooltip trigger="hover">
          <template #trigger>
            <svg @click="identification = null" class="fixed right-2 top-2 w-12 h-12 text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
          </template> 
          បិទផ្ទាំងពិនិតវត្តមាន
        </n-tooltip>
      </div>
    </Transition>
    <div class="w-full fixed left-0 bottom-0 right-0 " >
      <Footer />
    </div>
  </div>
</template>
<script>
import { reactive ,ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter , useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import dateFormat from "dateformat";
import Frame4Corner from '@components/widgets/frame/corner4.vue'
import Footer from '@components/footer/copy-right.vue'
import ocmLogoUrl from '@assets/logo.svg'
import DigitalClock from '@components/widgets/DigitalClock.vue'
import { GoogleMap, Marker } from 'vue3-google-map'
import Camera from '@components/widgets/Camera.vue'

/**
 * CRUD component form
 */
export default {
  name: "QRCode" ,
  components: {
    QrcodeVue ,
    Vue3Barcode ,
    Frame4Corner ,
    Footer ,
    DigitalClock ,
    GoogleMap ,
    Marker ,
    Camera
  },
  setup(){
    const store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const router = useRouter()
    const route = useRoute()
    const notify = useNotification()
    const organization = ref(null)
    const staffId = ref(null)
    const staffPhone = ref(null)
    const staffEmail = ref(null)
    const identification = ref(null)
    const identificationType = ref('phone')
    const attendant = ref(null)
    const checkStatus = ref(-1)
    const checkAttendantStatus = ref(false)
    const checktimes = ref([])
    /**
     * Variables
     */    
    var model = reactive( {
      name: "organization" ,
      title: "QR វត្តមាន នៃក្រសួងស្ថាប័ន"
    })

    function getOrganization(){
      store.dispatch( model.name + '/read' , { id: route.params.id } ).then(
        res => {
          organization.value = res.data.record
        }
      ).catch( 
        err => {
          console.log( err )
        }
      )
    }

    function checkIdentity(){
      var term = ref(false)
      var type = ref('id')
      term.value = parseInt( staffId.value ) > 0 ? parseInt( staffId.value ) : false 
      if( term.value == false ){
        term.value = staffPhone.value != null && staffPhone.value.trim().length > 0 ? staffPhone.value.trim() : false 
        type.value = "phone"
      }
      if( term.value == false ){
        term.value = staffEmail.value != null && staffEmail.value.trim().length > 0 ? staffEmail.value.trim() : false 
        type.value = "email"
      }
      if( term.value != false ){
        store.dispatch('user/checkIdentification',{term:term.value,type:type.value}).then(res => {
          if( res.data.ok ){
            identification.value = res.data.record
            getAttendant()
            notify.success({
              title: 'ពិនិត្យអត្តសញ្ញាណមន្ត្រី' ,
              content: res.data.message ,
              duration: 3000
            })
          }else{
            notify.warning({
              title: 'ពិនិត្យអត្តសញ្ញាណមន្ត្រី' ,
              content: res.data.message ,
              duration: 3000
            })    
          }
        }).catch( err => {
          notify.warning({
            title: 'ពិនិត្យអត្តសញ្ញាណមន្ត្រី' ,
            content: err.response != undefined && err.response.data != undefined ? err.response.data.message : 'មានបញ្ហាក្នុងការពិនិត្យអត្តសញ្ញាណមន្ត្រី។' ,
            duration: 3000
          })    
          console.log( err )
        })
      }else{
        notify.warning({
          title: 'ពិនិត្យអត្តសញ្ញាណមន្ត្រី' ,
          content: 'សូមបំពេញព័ត៌មានខាងលើណាមួយជាមុនសិន។' ,
          duration: 3000
        })
      }
    }

    function getAttendant(){
      var termAndType = {
        term: '' ,
        type: 'phone'
      }
      if( tabValueChange.value == 'email' ){
        termAndType.term = identification.value.email ,
        termAndType.type = 'email'
      }
      else if( tabValueChange.value == 'phone' ){
        termAndType.term = identification.value.phone ,
        termAndType.type = 'phone'
      }else{
        notify.warning({
          title: "ពិនិត្យវត្តមានមន្ត្រី" ,
          content: "សូមជ្រើសរើសប្រភេទនៃការពិនិត្យវត្តមាន។" ,
          duration: 3000
        })
        return false
      }
      if( identification.value != null && identification.value != undefined ){
        store.dispatch( 'attendant/getAttendant',termAndType).then( res => {
          if( res.data.ok ){
            // Attendant has been checked at less once
            attendant.value = res.data.attendant
            checktimes.value = res.data.checktimes
            checkStatus.value = res.data.check_status
          }else{
            // Attehdant has not been checked
            attendant.value = null
          }
        }).catch( err => {
          console.log( err )
        })
      }
    }
    function checkAttendant(){
      refCamera.value.takePhoto()
      if( identification.value != null && identification.value != undefined ){
        store.dispatch('attendant/checkAttendant',{
          organization_id: organization.value.id ,
          email: identification.value.email ,
          phone: identification.value.phone ,
          lat : currentGeolocation.lat ,
          lng : currentGeolocation.lng ,
          photo: snapshot.value // data_url
        }).then( res => {
          if( res.data.ok ){
            message.success(res.data.message)
          }else{
            notify.error({
            title: 'ពិនិត្យវត្តមាន ចូល និង ចេញ' ,
            content: res.data.message ,
            duration: 3000
          })  
          }
        }).catch( err => {
          notify.error({
            title: 'ពិនិត្យវត្តមាន ចូល និង ចេញ' ,
            content: err.response != undefined && err.response.data != undefined ? err.response.data.message : "មានបញ្ហាពិនិត្យវត្តមាន។" ,
            duration: 3000
          })
          console.log( err )
        })
      }
      identification.value = null
      staffId.value = null
      staffPhone.value = null
      staffEmail.value = null
    }

    const tabValueChange = ref('phone')
    function tabChange(){
      switch( tabValueChange.value ){
        case 'id' :
          staffPhone.value =  staffEmail.value = ''
          break;
        case 'phone' :
          staffId.value =  staffEmail.value = ''
          break;
        case 'email' :
          staffPhone.value =  staffId.value = ''
          break;
      }
    }

    const currentGeolocation = reactive({ lat: null , lng: null })
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            notify.error( {
              title : 'មានកំហុស' ,
              content: "មិនមានការទ្រទ្រង់សម្រាប់ការស្នើរសុំទីតាំងអ្នកប្រើប្រាស់។" ,
              duration: 3000
            } )
        }
    }

    function showPosition(position) {
      currentGeolocation.lat = position.coords.latitude
      currentGeolocation.lng = position.coords.longitude
    }

    function showError(error) {
      switch(error.code) {
          case error.PERMISSION_DENIED:
              notify.error( {
                title: 'ចាប់ទីតាំង' ,
                content: "ការស្នើរសុំទីតាំង ត្រូវបានបដិសេធ៏ដោយអ្នកប្រើប្រាស់។" ,
                duration: 2000                 
              } )
              break;
          case error.POSITION_UNAVAILABLE:
              notify.error( {
                title: 'ចាប់ទីតាំង' ,
                content: "ព័ត៌មានពីទីតាំអ្នកប្រើប្រាស់មិនមានឡើយ។" ,
                duration: 2000 
              } )
              break;
          case error.TIMEOUT:
              notify.error( {
                title: 'ចាប់ទីតាំង' ,
                content: "អស់ពេលស្នើរសុំព័ត៌មានទីតាំងរបស់អ្នកប្រើប្រាស់។" ,
                duration: 2000 
              } )
              break;
          case error.UNKNOWN_ERROR:
          notify.error( {
                title: 'ចាប់ទីតាំង' ,
                content: "មានកំហុសដែលមិនបានរំពឹងទុកកើតឡើង។" ,
                duration: 2000 
              } )
              break;
      }
    }

    /**
     * Camera module
     */
    const refCamera = ref(null)
    const snapshot = ref(null)
    function onSnap(photoDataUrl){
      snapshot.value = photoDataUrl
    }

    getLocation()
    getOrganization()

    return {
      /**
       * Variables
       */
      store ,
      model ,
      organization ,
      staffId ,
      staffPhone ,
      staffEmail , 
      identification ,
      attendant ,
      ocmLogoUrl ,
      /**
       * Functions
       */
      onlyAllowNumberAndNoSideSpace: (value) => !value || ( /^\d+$/.test(value) && !/ /g.test(value) ),
      checkIdentity ,
      checkAttendant ,
      tabChange ,
      tabValueChange ,
      currentGeolocation ,
      /**
       * Camera Moduls
       */
      onSnap ,
      refCamera ,
      checkAttendantStatus ,
      checkStatus ,
      checktimes
    }
  }
}

</script>

<style scoped >
  .vcb-table-cell {
    @apply p-2 ;
  }
</style>