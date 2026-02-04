<template>
  <div class="flex flex-wrap content-center" >
        <!-- Start transaction of the apps -->
        <transition  name="fade" mode="out-in">
            <!-- Apps -->
            <div v-if="toggleApps" class="fixed top-0 bottom-0 left-0 right-0 z-40 flex flex-wrap content-start w-full px-4 py-24 bg-gray-800 sm:px-4 md:px-4 lg:p-24 xl:p-24 bg-opacity-95">
                <!-- Search -->
                <!-- <div class='absolute top-0 left-0 right-0 flex flex-wrap content-center w-2/5 py-4 m-auto md:w-2/5 xl:w-1/5 lg:w-1/5' >
                    <n-input 
                      suffix="ios-search" 
                      placeholder="ស្វែងរក ..." 
                      clearable 
                      v-model:value="search" 
                      @keyup="filterApps()"  
                    >
                      <template #prefix>
                        <n-icon>
                          <IosSearch />
                        </n-icon>
                      </template>
                    </n-input>

                </div> -->
                <!-- End search -->
                <!-- Apps -->
                <div class="flex flex-wrap content-center apps">
                    <div v-for="(app, index) in matchedApps.value" :key="index" class="w-32 h-32 text-center p4 md-auto">
                        <div @click="toggleApps=false;$router.push(app.url)" class='w-full dashboard-widget-link cursor-pointer ' >
                            <div class="w-14 text-gray-200 m-auto mb-2" v-html="app.svg" ></div>
                            <div class="font-pvh p-2 m-auto text-sm text-center text-gray-100" v-html="app.name" ></div>
                        </div>
                    </div>
                </div>
                <!-- End apps -->
            </div>
        </transition>
        <!-- End transaction of the apps -->
        <!-- Apps launcher -->
        <div class='fixed -bottom-14 h-12 left-0 right-0 z-50 flex flex-wrap justify-center w-full py-4' >
            <!-- Apps icon -->
            <div @click="toggleApps = !toggleApps" class="w-12 h-12 p-2 -mt-20 mx-2 text-center bg-white rounded-full shadow-md border border-gray-300 cursor-pointer " >
              <svg class="text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><rect x="64" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect></svg>
            </div>
            <div @click="logout()" class="w-12 h-12 p-2 -mt-20 mx-2 text-center bg-white rounded-full shadow-md border border-gray-300 cursor-pointer " >
              <svg class="text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
            </div>
        </div>
        <!-- Profile launcher -->
        <div class='fixed top-0 right-0 flex flex-wrap content-center p-2' >

        </div>
        <!-- Logout -->
        <div v-if="toggleApps" class='fixed top-0 right-0 flex flex-wrap content-center p-2' >

        </div>
    </div>
</template>

<script>
import { reactive, ref , computed } from 'vue'
import { IosSearch } from '@vicons/ionicons4'
import { SupervisedUserCircleOutlined , SupervisedUserCircleSharp } from "@vicons/material"
import { Apps, SpeedometerOutline } from '@vicons/ionicons5'
import { isAuth, authLogout , isAdmin , getUser } from './../../plugins/authentication'
import { Receipt2 } from '@vicons/tabler'
import { Receipt20Regular , Power20Regular, DocumentPdf24Regular} from '@vicons/fluent'
import { UserMultiple } from '@vicons/carbon'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { useDialog , useMessage } from 'naive-ui'
export default {  
  components: {
    IosSearch,
    SupervisedUserCircleOutlined ,
    SupervisedUserCircleSharp ,
    Apps ,
    UserMultiple ,
    Receipt20Regular ,
    Receipt2 ,
    SpeedometerOutline ,
    Power20Regular ,
    DocumentPdf24Regular
  } ,
  name: 'dock' ,
  props: [
      'active'
  ],
  setup(){
    let search = ref(null)
    let matchedApps = computed( () => {
        let matched = ref([])
        // if( search.value != '' && search.value != null && search.value.trim() != '' ){
        //   matched.value = apps.value.filter( app => app.name.indexOf( search.value ) != -1 && app.roles.includes( parseInt(getUser().role )) )
        // }else{
        //   matched.value = apps.value.filter( app => app.roles.includes( parseInt(getUser().role) ) )
        // }
        matched .value= apps.value
        // console.log( "Role : " + getUser().role )
        // console.log( matched.value.length )
        return matched
        // search.value != '' || search.value != null ? apps :
        // ( search.value.trim() != '' ?
        //   apps.value.filter( app => app.name.indexOf( search.value ) != -1 ) :
        //   apps
        // )
      }
    )
    let apps = ref([
      {
          url: '/dashboard' ,
          icon: 'SpeedometerOutline' ,
          svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M326.1 231.9l-47.5 75.5a31 31 0 0 1-7 7a30.11 30.11 0 0 1-35-49l75.5-47.5a10.23 10.23 0 0 1 11.7 0a10.06 10.06 0 0 1 2.3 14z" fill="currentColor"></path><path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0 0 56.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0 0 37.1-.1a173.13 173.13 0 0 1 254.8 0a25.19 25.19 0 0 0 37.1.1l3.2-3.5A223.18 223.18 0 0 0 480 287.9C480 164.2 379.7 64 256 64z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 128v32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M416 288h-32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M128 288H96"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M165.49 197.49l-22.63-22.63"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M346.51 197.49l22.63-22.63"></path></svg>' ,
          name: 'ផ្ទាំងព័ត៌មាន',
          roles: [
              1, // Admin
              // 2, // Super
              // 3, // Auditor
              // 4, // Member
              // 5 // Customer
          ]
      },
      {
          url: '/user' ,
          icon: 'SupervisedUserCircleOutlined' ,
          svg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12.5 10c0-1.65-1.35-3-3-3s-3 1.35-3 3s1.35 3 3 3s3-1.35 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1zm6.5 2c1.11 0 2-.89 2-2c0-1.11-.89-2-2-2c-1.11 0-2.01.89-2 2c0 1.11.89 2 2 2zM11.99 2.01c-5.52 0-10 4.48-10 10s4.48 10 10 10s10-4.48 10-10s-4.48-10-10-10zM5.84 17.12c.68-.54 2.27-1.11 3.66-1.11c.07 0 .15.01.23.01c.24-.64.67-1.29 1.3-1.86A9.05 9.05 0 0 0 9.5 14c-1.3 0-3.39.45-4.73 1.43c-.5-1.04-.78-2.2-.78-3.43c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.2-.27 2.34-.75 3.37c-1-.59-2.36-.87-3.24-.87c-1.52 0-4.5.81-4.5 2.7v2.78a7.935 7.935 0 0 1-5.66-2.86z" fill="currentColor"></path></svg>' ,
          name: 'គណនី',
          roles: [
              1, // Admin
              // 2, // Super
              // 3, // Auditor
              // 4, // Member
              // 5 // Customer
          ]
      },
      // {
      //     url: '/regulator' ,
      //     icon: 'DocumentPdf24Regular' ,
      //     name: 'លិខិតបទដ្ឋានគតិយុត្ត',
      //     roles: [
      //         1, // Admin
      //         // 2, // Super
      //         // 3, // Auditor
      //         // 4, // Member
      //         // 5 // Customer
      //     ]
      // },
      // {
      //     url: '/client' ,
      //     icon: 'UserMultiple' ,
      //     name: 'អតិថិជន' ,
      //     roles: [
      //         1, // Admin
      //         2, // Super
      //         // 3, // Auditor
      //         // 4, // Member
      //         // 5 // Customer
      //     ]
      // },
      // {
      //     url: '/receive' ,
      //     icon: 'Receipt20Regular' ,
      //     name: 'បញ្ញើ',
      //     roles: [
      //         // 1, // Admin
      //         2, // Super
      //         // 3, // Auditor
      //         // 4, // Member
      //         // 5 // Customer
      //     ]
      // },
      // {
      //     url: '/staff' ,
      //     icon: 'SupervisedUserCircleSharp' ,
      //     name: 'បុគ្គលិក' ,
      //     roles: [
      //         1, // Admin
      //         // 2, // Super
      //         // 3, // Auditor
      //         // 4, // Member
      //         // 5 // Customer
      //     ]
      // },
      // {
      //     url: '/incomeoutcome' ,
      //     icon: 'Receipt2' ,
      //     name: 'ចំណូលចំណាយ'
      // }
    ])
    /** End app metadata */
    let toggleApps = ref(false)
    let user = reactive({})

    function filterApps(){
      if( search.value != '' && search.value != null && search.value.trim() != '' ){
        matchedApps = apps.value.filter( app => app.name.indexOf( search.value ) != -1 && app.roles.includes( parseInt(getUser().role) ) )
      }else{
        matchedApps = apps.value.filter( app => app.roles.includes( parseInt(getUser().role) ) )
      }
    }
    function toggleAppFunc(){
        toggleApps = !toggleApps
    }
    function logoutConfirmation(){
        console.log( "confirm before logout" )
    }

    const dialog = useDialog();
    const message = useMessage();
    const store = useStore();
    const router = useRouter()
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
              authLogout()
              message.success("អ្នកបានចាកចេញដោយជោគជ័យ។")
              d.loading = false
              router.push('/login')
            }).catch( err => {
              console.log( err )
            })
          }else{
            router.push('/login')
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
  },
  mounted() {
      // this.user = localStorage.getItem( 'user' ) ? JSON.parse( localStorage.getItem( 'user' ) ) : null
      // this.search= ""
      // if( this.user !== null && this.user.roles !== null && this.user.roles.length > 0 ){
      //     this.matchedApps = []
      //     for(var i in this.apps ){
      //         for(var j in this.apps[i].roles ){
      //             let app = this.user.roles.find( role => role == this.apps[i].roles[j] )
      //             app !== undefined ? this.matchedApps.push( this.apps[i] ) : false
      //         }
      //     }
      //     return true
      // }else{
      //     console.log( "ព័ត៌មានសម្រាប់ការចូលប្រើប្រាស់ មិនគ្រប់គ្រាន់។ សូមចូលប្រើម្ដងទៀត ។ សូមអរគុណ !" )
      // }
  }
}
</script>