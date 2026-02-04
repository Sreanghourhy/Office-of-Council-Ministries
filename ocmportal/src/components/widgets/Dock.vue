<template>
  <div class="flex flex-wrap content-center z-50" >
    <!-- Start transaction of the apps -->
    <Transition  name="fade" >
        <!-- Apps -->
        <div v-if="toggleApps || show" class="fixed top-0 bottom-0 left-0 right-0 z-40 flex flex-wrap content-start w-full px-4 py-16 bg-gray-700 sm:px-4 md:px-4 lg:p-24 xl:p-24 bg-opacity-95 overflow-y-auto ">
            <!-- Search -->
            <div class='absolute top-0 left-0 right-0 flex flex-wrap content-center w-2/5 py-4 m-auto md:w-2/5 xl:w-1/5 lg:w-1/5 ' >
                <n-input 
                  suffix="ios-search" 
                  placeholder="ស្វែងរក ..." 
                  clearable 
                  v-model:value="search" 
                  class="text-left rounded-full" 
                  @keyup="filterApps()"  
                ></n-input>
                <svg class="absolute right-2 top-5 w-6 text-gray-400 " 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M9.309 10.016a4.5 4.5 0 1 1 .707-.707l3.838 3.837a.5.5 0 0 1-.708.708L9.31 10.016zM10 6.5a3.5 3.5 0 1 0-7 0a3.5 3.5 0 0 0 7 0z" fill="currentColor"></path></g></svg>
            </div>
            <!-- End search -->
            <!-- Apps -->
            <div class="flex flex-wrap justify-center w-full apps ">
                <div v-for="(app, index) in matchedApps" :key="index" class="py-4 px-8 duration-300 transform hover:scale-110 text-center p-2 m-4  cursor-pointer hover:bg-gray-50 hover:bg-opacity-10 rounded-lg">
                    <div @click="toggleAppFunc(app.url);$router.push(app.url)" class='w-full dashboard-widget-link' >
                      <div class="text-gray-100 w-12 mx-auto my-2 " v-html="app.svg" ></div>
                      <div class="font-pvh p-2 m-auto text-xs text-center text-gray-100" v-html="app.name" ></div>
                    </div>
                </div>
                <!-- <div class="py-4 px-8 duration-300 transform hover:scale-110 text-center p-2 m-4  cursor-pointer hover:bg-gray-50 hover:bg-opacity-10 rounded-lg">
                    <div @click="logout()" class='w-full dashboard-widget-link' >
                      <div class="text-gray-100 w-16 mx-auto my-2 " >
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
                      </div>
                      <div class="font-pvh p-2 m-auto text-xs text-center text-gray-100" >ចាកចេញ</div>
                    </div>
                </div> -->

            </div>
            <!-- End apps -->
            <!-- Apps launcher -->
            <div class='fixed h-12 bottom-0 left-0 right-0 z-50 flex flex-wrap justify-center w-full' >
              <!-- Apps icon -->
              <n-tooltip v-if="!showLuncher" trigger="hover" >
                <template #trigger>
                  <div @click="toggleAppFunc()" class="w-10 h-10 p-2 mx-4 my-1 text-center bg-white rounded-full shadow-md border border-gray-300 cursor-pointer " >
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z" fill="currentColor"></path></svg>
                  </div>
                </template>
                បិទផ្ទាំងព័ត៌មាន
              </n-tooltip>
              <n-tooltip v-if="!showLuncher" trigger="hover" >
                <template #trigger>
                  <div @click="logout()" class="w-10 h-10 p-2 mx-4 my-1 text-center bg-white rounded-full shadow-md border border-gray-300 cursor-pointer text-red-500 " >
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
                  </div>
                </template>
                ចេញពីប្រព័ន្ធ
              </n-tooltip>
            </div>
        </div>
    </Transition>
    <!-- End transaction of the apps -->
  </div>
</template>

<script>
import { reactive, ref , computed, onMounted } from 'vue'
import { isAuth, authLogout , isAdmin , getUser } from './../../plugins/authentication'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useDialog , useMessage } from 'naive-ui'
export default {  
  components: {
  } ,
  name: 'dock' ,
  props: {
    show : false ,
    showLuncher: false ,
    close: {
      type: Function
    } ,
  },
  setup(props){
    
    let search = ref(null)
    let apps = ref([
    {
          url: '/welcome' ,
          icon: 'Pagelines' ,
          svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 384 512"><path d="M384 312.7c-55.1 136.7-187.1 54-187.1 54c-40.5 81.8-107.4 134.4-184.6 134.7c-16.1 0-16.6-24.4 0-24.4c64.4-.3 120.5-42.7 157.2-110.1c-41.1 15.9-118.6 27.9-161.6-82.2c109-44.9 159.1 11.2 178.3 45.5c9.9-24.4 17-50.9 21.6-79.7c0 0-139.7 21.9-149.5-98.1c119.1-47.9 152.6 76.7 152.6 76.7c1.6-16.7 3.3-52.6 3.3-53.4c0 0-106.3-73.7-38.1-165.2c124.6 43 61.4 162.4 61.4 162.4c.5 1.6.5 23.8 0 33.4c0 0 45.2-89 136.4-57.5c-4.2 134-141.9 106.4-141.9 106.4c-4.4 27.4-11.2 53.4-20 77.5c0 0 83-91.8 172-20z" fill="currentColor"></path></svg>' ,
          name: 'សេវារួម',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ]
      },
      // {
      //     url: '/dashboard' ,
      //     icon: 'SpeedometerOutline' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M326.1 231.9l-47.5 75.5a31 31 0 0 1-7 7a30.11 30.11 0 0 1-35-49l75.5-47.5a10.23 10.23 0 0 1 11.7 0a10.06 10.06 0 0 1 2.3 14z" fill="currentColor"></path><path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0 0 56.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0 0 37.1-.1a173.13 173.13 0 0 1 254.8 0a25.19 25.19 0 0 0 37.1.1l3.2-3.5A223.18 223.18 0 0 0 480 287.9C480 164.2 379.7 64 256 64z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 128v32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M416 288h-32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M128 288H96"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M165.49 197.49l-22.63-22.63"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M346.51 197.49l22.63-22.63"></path></svg>' ,
      //     name: 'សង្ខេបព័ត៌មាន',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      // {
      //     url: '/folders' ,
      //     icon: 'FolderOpen20Regular' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M16.996 7.073V7a2.5 2.5 0 0 0-2.5-2.5H9.664l-1.6-1.2a1.5 1.5 0 0 0-.9-.3H4.5A2.5 2.5 0 0 0 2 5.5l.001 8.998a2.5 2.5 0 0 0 2.201 2.482c.085.014.172.022.26.022H15.18a1.5 1.5 0 0 0 1.472-1.214l1.358-7a1.501 1.501 0 0 0-1.014-1.715zM4.5 4h2.664a.5.5 0 0 1 .3.1l1.734 1.3a.5.5 0 0 0 .3.1h4.998a1.5 1.5 0 0 1 1.5 1.5v.002H5.824a1.5 1.5 0 0 0-1.472 1.214l-1.298 6.676A1.502 1.502 0 0 1 3 14.498L3 5.5A1.5 1.5 0 0 1 4.5 4zm.833 4.407a.5.5 0 0 1 .491-.405h10.713a.5.5 0 0 1 .491.595l-1.357 7a.5.5 0 0 1-.491.405H4.463a.5.5 0 0 1-.49-.595l1.36-7z" fill="currentColor"></path></g></svg>' ,
      //     name: 'ថតឯកសារ',
      //     roles: [
      //       // 1, // Admin
      //       // 2, // Administrator
      //       3, // backend
      //     ]
      // },
      // {
      //     url: '/regulators' ,
      //     icon: 'DocumentPdf24Regular' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>' ,
      //     name: 'ឯកសារ',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      // {
      //     url: '/organization' ,
      //     icon: 'Organization20Regular' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10 2a3 3 0 0 0-.5 5.96V9.5h-3A1.5 1.5 0 0 0 5 11v1.042a3.001 3.001 0 1 0 1 0V11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1.042a3.001 3.001 0 1 0 1 0V11a1.5 1.5 0 0 0-1.5-1.5h-3V7.96A3.001 3.001 0 0 0 10 2zM8 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0zM3.5 15a2 2 0 1 1 4.001 0A2 2 0 0 1 3.5 15zm11-2a2 2 0 1 1 0 4.001a2 2 0 0 1 0-4.001z" fill="currentColor"></path></g></svg>' ,
      //     name: 'រចនាសម្ព័ន្ធ',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       // 3, // backend
      //     ]
      // },
      // {
      //     url: '/attendants' ,
      //     icon: 'ListChecked' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8h14v2H16z" fill="currentColor"></path><path d="M6 10.59L3.41 8L2 9.41l4 4l8-8L12.59 4L6 10.59z" fill="currentColor"></path><path d="M16 22h14v2H16z" fill="currentColor"></path><path d="M6 24.59L3.41 22L2 23.41l4 4l8-8L12.59 18L6 24.59z" fill="currentColor"></path></svg>' ,
      //     name: 'វត្តមាន',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      // {
      //     url: '/meetings' ,
      //     icon: '' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><g fill="none"><path d="M14.708 6a5.938 5.938 0 0 0-5.736 4.403l-1.773 6.623c.181-.017.365-.026.55-.026h2.045l1.593-5.951a3.438 3.438 0 0 1 3.32-2.549h18.587a3.438 3.438 0 0 1 3.32 2.549l4.756 17.77a3.72 3.72 0 0 1-3.594 4.681H21V36h16.776c4.09 0 7.066-3.878 6.01-7.828l-4.756-17.77A5.938 5.938 0 0 0 33.294 6H14.708zM34.75 40.5H20.995c.003-.083.005-.166.005-.25V38h13.751a1.25 1.25 0 0 1 0 2.5zM11.501 29a2.5 2.5 0 1 0 0-5a2.5 2.5 0 0 0 0 5zM4 22.75A3.75 3.75 0 0 1 7.75 19h7.5A3.75 3.75 0 0 1 19 22.75v17.5A3.75 3.75 0 0 1 15.25 44h-7.5A3.75 3.75 0 0 1 4 40.25v-17.5zm3.75-1.25c-.69 0-1.25.56-1.25 1.25v17.5c0 .69.56 1.25 1.25 1.25h7.5c.69 0 1.25-.56 1.25-1.25v-17.5c0-.69-.56-1.25-1.25-1.25h-7.5z" fill="currentColor"></path></g></svg>' ,
      //     name: 'កិច្ចប្រជុំ',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      // {
      //     url: '/tasks' ,
      //     icon: 'TasksApp20Regular' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M4 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9.883l-1 1.01V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h4.085c.071.2.185.389.344.55l.441.45H6a2 2 0 0 1-2-2V4zm4 1.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0zM9.5 5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm0 4a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zM9 13.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm-2-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2zm10.855.352a.5.5 0 0 0-.71-.704l-3.643 3.68l-1.645-1.678a.5.5 0 1 0-.714.7l1.929 1.968a.6.6 0 0 0 .855.002l3.928-3.968z" fill="currentColor"></path></g></svg>' ,
      //     name: 'កិច្ចការ',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      {
          url: '/profile' ,
          icon: 'UserAvatar' ,
          svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path></svg>' ,
          name: 'ព័ត៌មានផ្ទាល់ខ្លួន',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ]
      },
      // {
      //     url: '/cards' ,
      //     icon: 'TasksApp20Regular' ,
      //     svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z" fill="currentColor"></path></g></svg>' ,
      //     name: 'កាតមន្ត្រី',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
    ])
    /** End app metadata */
    let toggleApps = ref(false)
    let user = reactive({})

    let matchedApps = ref([])
    function filterApps(){
      matchedApps.value = []
      /**
       * Filter the apps base on the search string
       */
      matchedApps.value = ( search.value != null && search.value.trim() != '' ) 
      ? apps.value.filter( app => app.name.indexOf( search.value ) != -1 )
      : apps.value
      /**
       * Filter the apps base on the user role
       */
      let userRoleIds = ( getUser() != null && getUser().roles != undefined && Array.isArray( getUser().roles ) ) ? getUser().roles.map(r=>r.id) : false
      
      /**
       * Error getting user role
       */
      matchedApps.value = matchedApps.value.filter( 
        app => app.roles.find( 
          role => userRoleIds.includes(role)
        ) 
      )
    }
    
    function toggleAppFunc(url){
      // if( url == route.path ) props.close()
      toggleApps.value = !toggleApps
      props.close()
    }
    function logoutConfirmation(){
        console.log( "confirm before logout" )
    }

    const dialog = useDialog();
    const message = useMessage();
    const store = useStore();
    const router = useRouter()
    const route = useRoute()

    async function logout(){
      const d = dialog.warning({
        title: 'ចាកចេញ',
        content: 'តើអ្នកចង់ចាកចេញមែនទេ?',
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          /**
           * Check whether the user has logged out already
           */
          if( isAuth() ) {
            /**
             * Show confirm dialog
             */
            d.loading = true
            store.dispatch('auth/logout').then( res => {
              message.success("អ្នកបានចាកចេញដោយជោគជ័យ។")
              d.loading = false
            }).catch( err => {
              console.log( err )
            })
            authLogout()
            window.location.href = '/'
          }else{
            window.location.href = '/login'
          }
        },
        // onNegativeClick: () => {
        //   message.error('Not Sure')
        // }
      })
    }
    function isAdminAccount(){
      return isAdmin()
    }

    filterApps()

    return {
      logout ,
      search ,
      matchedApps ,
      apps ,
      toggleApps ,
      user ,
      filterApps ,
      toggleAppFunc ,
      logoutConfirmation ,
      isAdminAccount 
    }
  }
}
</script>
<style scoped>
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>