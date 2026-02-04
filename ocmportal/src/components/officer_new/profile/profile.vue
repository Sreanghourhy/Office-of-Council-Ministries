<template>
  <div class="w-full relative flex flex-wrap" >
    <Transition name="fade" >
      <div v-if="user!=null" class="w-full">
        <div class="flex w-full title-bar border-b border-gray-200 px-4 ">
          <!-- Title of crud -->
          <div class="flex w-64 h-10 py-1 title " >
            <svg class="w-8 h-8 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="leading-9 font-moul ml-2" v-html="model.title" ></div>
          </div>
          <!-- Actions button of the crud -->
          <div class="flex-grow action-buttons flex-row-reverse flex">
            <!-- New Button -->
            <div class="mt-1 ml-2">
              <!-- <n-button type="default" @click="$router.push('/welcome')" class="mx-2 "  >
                <template #icon>
                  <svg class="text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M6.5 11a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-.166h.333a1.167 1.167 0 0 0 0-2.334H6.5zm.833 1.334H7V12h.333a.167.167 0 0 1 0 .334zM12 11.499a.5.5 0 0 1 .5-.499h.999a.5.5 0 0 1 0 1h-.5v.335h.5a.5.5 0 1 1 0 1h-.5l.001.164a.5.5 0 0 1-1 .002L12 12.834L12 11.499zM9.498 11a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5H10a1.5 1.5 0 0 0 0-3h-.502zm.5 2v-1H10a.5.5 0 0 1 0 1h-.002zM4 4a2 2 0 0 1 2-2h4.585a1.5 1.5 0 0 1 1.061.44l3.914 3.914a1.5 1.5 0 0 1 .44 1.06v1.668a1.5 1.5 0 0 1 .998 1.414v4.003A1.5 1.5 0 0 1 16 15.913V16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-.087A1.5 1.5 0 0 1 3 14.5v-4.003A1.5 1.5 0 0 1 4 9.082V4zm11 4h-3.5A1.5 1.5 0 0 1 10 6.5V3H6a1 1 0 0 0-1 1v4.996h10V8zM5 15.999A1 1 0 0 0 6 17h8a1 1 0 0 0 1-1.001H5zm6-12.792V6.5a.5.5 0 0 0 .5.5h3.293L11 3.207zM4.5 9.996a.5.5 0 0 0-.5.5v4.003a.5.5 0 0 0 .5.5h10.997a.5.5 0 0 0 .5-.5v-4.003a.5.5 0 0 0-.5-.5H4.501z" fill="currentColor"></path></g></svg>
                </template>
                ស្វែងរកឯកសារ
              </n-button> -->
            </div>
            <div class="w-2/5 relative" ></div>
            <div class="mt-1 ml-2"></div>
          </div>
        </div>
        <!-- End Menu -->    
        <div class="profileInformation p-8 sm:w-2/3 md:w-3/5 lg:w-2/5 w-4/5 mx-auto border my-8 relative">
          <div class="profileImage border rounded-full border-gray-200 p-2 w-40 h-40 flex-none mx-auto overflow-hidden bg-center bg-no-repeat bg-80% bg-white bg-cover" :style=" 'background-image: url(' + localProfile +');' " ></div>
          <div class="uploader absolute right-0 top-0 w-24flex" >
            <input type="file" placeholder="ឯកសារយោង" @change="fileChange" class="hidden " id="referenceDocument" />
            <div class="cursor-pointer hover:border-green-500 flex flex-wrap"  >
              <n-tooltip trigger="hover">
                <template #trigger>
                  <div class="changeProfile p-2 m-1 border rounded-full w-10 h-10 border-gray-300" @click="clickUpload"  >
                    <n-icon size="22" class="text-gray-600" >
                      <CameraOutline />
                    </n-icon>
                  </div>
                </template>ប្ដូររូបភាពគណនី
              </n-tooltip>
              <n-tooltip trigger="hover">
                <template #trigger>
                  <div class="saveProfile p-2 m-1 border rounded-full w-10 h-10 border-gray-300" @click="uploadFiles" >
                    <n-icon size="22" class="text-gray-600" >
                      <CloudUploadOutline />
                    </n-icon>
                  </div>
                </template>រក្សារទុករូបភាពថ្មី
              </n-tooltip>
            </div>
          </div>
          <div class="my-12">
            <n-form
            ref="formRef"
            label-placement="left"
            :model="user"
            label-width="120"
            >
              <n-form-item-row label="ឈ្មោះគណនី" >
                <n-input placeholder="ឈ្មោះគណនី" class="text-left" v-model:value="user.username" />
              </n-form-item-row>
              <n-form-item-row label="គោត្តនាម" >
                <n-input placeholder="គោត្តនាម" class="text-left" v-model:value="user.lastname" />
              </n-form-item-row>
              <n-form-item-row label="នាម">
                <n-input placeholder="នាម" class="text-left" v-model:value="user.firstname" />
              </n-form-item-row>
              <n-form-item-row label="ទូរស័ព្ទ">
                <n-input placeholder="ទូរស័ព្ទ" class="text-left" v-model:value="user.phone" />
              </n-form-item-row>
              <n-form-item-row label="អ៊ីមែល" >
                <n-input placeholder="អ៊ីមែល" class="text-left" disabled v-model:value="user.email" />
              </n-form-item-row>
            </n-form>
            <!-- <n-button type="default" class="mx-8 w-32 my-1" @click="$router.push('/welcome')" >បកក្រោយ</n-button> -->
            <n-button type="primary" secondary class="mx-8 w-32 my-1" @click="save()" >រក្សារទុក</n-button>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>
<script >
import { isAuth, getUser , authLogout } from './../../../plugins/authentication.js'
import { reactive, ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import FooterComponent from './../../../components/footer/copyright.vue'
import { useMessage, useNotification } from 'naive-ui'

  export default {
    name: 'Profile' ,
    components: {
      FooterComponent
    },
    setup(){
      const router = useRouter()
      const store = useStore()
      const user = ref(null)
      const message = useMessage()
      const notify = useNotification()
      const base64Avatar = ref(null)
      const selectedFileType = ref('')

      if( isAuth() ){
        user.value = getUser()
      }else{
        user.value = ref({
          lastname: '' ,
          firstname: '' ,
          phone: '' ,
          username: '' ,
          email: ''
        })
      }

      /**
       * Variables
       */    
      const model = reactive( {
        name: "UserProfile" ,
        title: "ព័ត៌មានអំពីគណនី"
      })
      
      function save(){
        console.log( user.value )
        store.dispatch('user/updateAuth',{
          lastname: user.value.lastname ,
          firstname: user.value.firstname ,
          phone: user.value.phone ,
          username: user.value.username
        }).then( res => {
          notify.success({
            title: 'រក្សារទុករួចរាល់។' ,
            content: res.data.message ,
            duration: 1000
          })
          let tmpUser = getUser()
          tmpUser.lastname = res.data.user.lastname
          tmpUser.firstname = res.data.user.firstname
          tmpUser.phone = res.data.user.phone
          tmpUser.username = res.data.user.username
          localStorage.setItem( 'user' , JSON.stringify( tmpUser ) )
          user.value = getUser()
        }).catch( err => {
          console.log( err )
        })
      }

      function logout(){
        if( isAuth() ){
          authLogout()
        }
        router.push('/welcome')
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
        console.log( files.value )
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

        console.log( files.value )
        let formData = new FormData()
        formData.append('id', user.value.id )
        formData.append('files',files.value[0],files.value[0].name)
        
        store.dispatch('user/upload', formData ).then( res => {
          notify.success({
            title: 'ដាក់រូបភាពអ្នកប្រើប្រាស់' ,
            description: 'កំពុងរក្សាទុករូបភាព។' ,
            duration: 1000
          })
          if( res.data.record != null && res.data.record != undefined ){
            let tmpUser = getUser()
            tmpUser.avatar_url = res.data.record.avatar_url
            localStorage.setItem( 'user' , JSON.stringify( tmpUser ) )
            user.value = getUser()
            base64Avatar.value = user.value.avatar_url
            formData = new FormData()
            files.value = []
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
        return base64Avatar.value !== "" && base64Avatar.value !== null ? base64Avatar.value : ( user.value.avatar_url !== "" && user.value.avatar_url !== null ? user.value.avatar_url : "/src/assets/logo.png" )
      })

      return {
        user ,
        logout ,
        save ,
        fileChange ,
        uploadFiles,
        clickUpload ,
        localProfile ,
        model
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