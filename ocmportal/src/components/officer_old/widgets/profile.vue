<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center">
        <n-card class="w-11/12 xl:w-7/12 lg:w-7/12 md:w-8/12 sm:w-11/12 font-pvh text-xl p-0 " :bordered="false" size="small">
          <!-- Form edit account -->
          <div class="relative w-full ">
            <div class="profileInformation relative ">
              <div class="profileImage border rounded-full border-gray-200 p-2 w-40 h-40 flex-none mx-auto overflow-hidden bg-center bg-no-repeat bg-80% bg-white bg-cover" :style=" 'background-image: url(' + localProfile +');' " ></div>
              <div class="flex flex-wrap " >
                <div class="w-full py-2" >
                  <div v-if="record.countesy != undefined && record.countesy != null " class="w-full text-center font-moul mr-2" >{{  record.countesy.name }}</div>
                  <div v-if="record.people != undefined && record.people != null " class="w-full text-center font-moul leading-6 tracking-wider" >{{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                </div>
                <div class="w-full flex flex-wrap justify-between text-gray-600" >
                  <div v-if=" ( record.position != undefined && record.position != null ) || ( record.dob != undefined && record.dob != null ) " class="w-1/2 text-left text-vcb-xs my-1 leading-5 tracking-wider" >
                    {{ $toKhmer( record.people.dob ) }}<br/>
                    {{ record.position.name }}
                  </div>
                  <div v-if="record.organization != undefined && record.organization != null " class="w-1/2 text-right text-vcb-xs my-1  leading-5 tracking-wide" v-html=" record.organization.name " ></div>
                </div>
                <div v-if="record.card != null && record.card != undefined && record.card.id > 0" class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider" >{{ $toKhmer( record.card.number ) }}</div>
                <div v-if="(record.card == null || record.card == undefined) && ( record.organization != undefined && record.organization != null ) " class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider" v-html=" $toKhmer( record.organization.prefix + '-' + ( record.id + '' ).padStart( 4 , '0' ) )" ></div>
                <div v-if="record.code != null && record.code != undefined " class="absolute left-1 top-5 text-vcb-xs text-left font-bold leading-6 tracking-wider" v-html=" $toKhmer( record.code )" ></div>
              </div>
              <div class="uploader absolute right-0 top-0 w-24flex" >
                <input type="file" placeholder="ឯកសារយោង" @change="fileChange" class="hidden " id="referenceDocument" />
                <div class="cursor-pointer hover:border-green-500 flex flex-wrap"  >
                  <n-tooltip trigger="hover">
                    <template #trigger>
                      <svg class="changeProfile p-2 m-1 border rounded-full w-10 h-10 border-gray-300" @click="clickUpload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><circle cx="256" cy="272" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></circle><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M124 158v-22h-24v22"></path></svg>    
                    </template>ប្ដូររូបភាពគណនី
                  </n-tooltip>
                  <n-tooltip trigger="hover">
                    <template #trigger>
                      <svg class="saveProfile p-2 m-1 border rounded-full w-10 h-10 border-gray-300" @click="uploadFiles" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg>
                    </template>រក្សារទុករូបភាពថ្មី
                  </n-tooltip>
                </div>
              </div>
            </div>
          </div>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { isAuth, getUser , authLogout } from './../../../plugins/authentication.js'
import { reactive, ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useMessage, useNotification } from 'naive-ui'
import ocmLogoUrl from './../../../assets/logo.svg'

export default {
  name: 'Profile' ,
  components: {
   
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
      required: true
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
    const router = useRouter()
    const route = useRoute()
    const store = useStore()
    const user = ref(null)
    const message = useMessage()
    const notify = useNotification()
    const base64Avatar = ref(null)
    const selectedFileType = ref('')

    /**
     * Variables
     */    
    const model = reactive( {
      name: "UserProfile" ,
      title: "ព័ត៌មានអំពីគណនី"
    })

    function readUser(){
      store.dispatch( 'user/read' , { id : props.record.user_id } ).then(
        res => {
          if( res.data.ok == true ){
            user.value = res.data.record
          }
          else{
              notify.error( {
                title: 'អានព័ត៌មានមន្ត្រី' ,
                content: res.data.message
              })
          }
        }
      ).catch( 
        err => {
          console.log( err )
        }
      )
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
      // console.log( files.value )
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

      // console.log( files.value )
      let formData = new FormData()
      formData.append('id', user.value.id )
      formData.append('files',files.value[0],files.value[0].name)
      
      store.dispatch('user/uploadProfilePicture', formData ).then( res => {
        notify.success({
          title: 'ដាក់រូបភាពអ្នកប្រើប្រាស់' ,
          description: 'កំពុងរក្សាទុករូបភាព។' ,
          duration: 1000
        })
        if( res.data.record != null && res.data.record != undefined ){
          // let tmpUser = getUser()
          // tmpUser.avatar_url = res.data.props.record.avatar_url
          // localStorage.setItem( 'user' , JSON.stringify( tmpUser ) )
          // user.value = getUser()
          // base64Avatar.value = props.record.avatar_url
          formData = new FormData()
          files.value = []
          base64Avatar.value = null
          clearRecord( 1 )
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
      return base64Avatar.value !== "" && base64Avatar.value !== null ? base64Avatar.value : ( props.record.avatar_url !== "" && props.record.avatar_url !== null ? props.record.avatar_url : "/src/assets/logo.png" )
    })

    /**
     * Functions
     */
     function clearRecord( actionStatus ){
      props.onClose( actionStatus )
    }
  
    function maskOrEscClick(){
      props.onClose( 0 )
    }

    function initial(){
      readUser()
    }

    return {
      user ,
      fileChange ,
      uploadFiles,
      clickUpload ,
      localProfile ,
      model ,
      /**
       * Functions
       */
      clearRecord ,
      maskOrEscClick ,
      initial ,
      ocmLogoUrl
    }
  }
}
</script>
<style scoped >
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>