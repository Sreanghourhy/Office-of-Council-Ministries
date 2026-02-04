<template>
  <div class="ocm-float-menu-bottom fixed bottom-0 left-0 right-0 p-0 h-12 flex bg-gray-100 border-t border-gray-200" >
    <div class="absolute right-0 h-12 p-2 w-12 sm:visible md:w-28 lg:w-28 xl:w-28 " >
      <digital-clock dgClass=" w-28 text-xxs pt-1" />
    </div>
    <!-- <div class="absolute right-28 h-12 p-2 w-12 sm:visible md:w-40 lg:w-40 xl:w-40 flex flex-row-reverse cursor-pointer" @click="$router.push('/profile')" >
      <div class="flex-none border border-gray-200 rounded-full overflow-hidden w-8 h-8  bg-white" >
        <div v-if="profilePicture!=null" class="rounded-full bord er-gray-200 w-8 h-8 flex-none mx-auto overflow-hidden bg-center bg-no-repeat bg-cover" :style=" 'background-image: url(' + profilePicture +');' " ></div>
        <svg v-if="profilePicture==null" class="w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-128 -128 768 768"><rect x="64" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect></svg>
      </div>
      <div v-if="username!=''" class="flex-none h-8 leading-8 pt-1 font-moul text-right mr-2 text-xs text-gray-700 invisible sm:visible md:visible lg:visible xl:visible" style=" overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >{{ username }}</div>
    </div> -->
    <div class="absolute left-0 h-12 p-2 w-14 sm:visible md:w-40 lg:w-40 xl:w-40 flex cursor-pointer " @click="$router.push('/welcome')" >
      <div class="flex-none overflow-hidden -mt-1 w-10 h-10 " >
        <img :src="ocmLogoPng" class="h-10 mx-auto"/>
      </div>
      <div class="flex-none h-8 leading-8 pt-1 font-moul text-right ml-1 text-gray-700 invisible sm:visible md:visible lg:visible xl:visible" style=" overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >
        <div class="h-4 text-left text-xxs -mt-3 font-moul" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
        <div class="h-4 text-left text-xxs font-moul " >{{ $store.state.system.name }}</div>
      </div>
    </div>
    <div class="ocm-bottom-menu mx-auto rounded flex flex-wrap justify-center items-center " >
      <div 
        @click="subMenuHelper=!subMenuHelper"
        class="flex-none mx-2 h-8 w-8 shadow p-1 bg-white rounded-md cursor-pointer  hover:text-yellow-700 hover:border-yellow-700 border border-gray-100 duration-500" >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M864 144H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16zm0 400H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16zM464 144H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16zm0 400H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16z" fill="currentColor"></path></svg>
      </div>
      <!-- <n-tooltip trigger="hover" >
        <template #trigger>
          <div 
            @click="$router.push('/cards')"
            class="flex-none mx-2 h-8 w-8 p-1 text-blue-500 bg-white rounded-md cursor-pointer border border-gray-300 duration-300 transform-gpu hover:scale-125" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z" fill="currentColor"></path></g></svg>
          </div>
        </template>
        កាតមន្ត្រី
      </n-tooltip>
      <n-tooltip trigger="hover" >
        <template #trigger>
          <div 
            @click="$router.push('/attendants')"
            class="flex-none mx-2 h-8 w-8 p-1 text-blue-500 bg-white rounded-md cursor-pointer border border-gray-300 duration-300 transform-gpu hover:scale-125" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8h14v2H16z" fill="currentColor"></path><path d="M6 10.59L3.41 8L2 9.41l4 4l8-8L12.59 4L6 10.59z" fill="currentColor"></path><path d="M16 22h14v2H16z" fill="currentColor"></path><path d="M6 24.59L3.41 22L2 23.41l4 4l8-8L12.59 18L6 24.59z" fill="currentColor"></path></svg>
          </div>
        </template>
        វត្តមាន
      </n-tooltip>
      <n-tooltip trigger="hover" >
        <template #trigger>
          <div 
            @click="$router.push('/profile')"
            class="flex-none mx-2 h-8 w-8 p-1 text-blue-500 bg-white rounded-md cursor-pointer border border-gray-300 duration-300 transform-gpu hover:scale-125" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" data-v-73966616=""><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor" data-v-73966616=""></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor" data-v-73966616=""></path></svg>
          </div>
        </template>
        ព័ត៌មានមន្ត្រី
      </n-tooltip>
      <n-tooltip trigger="hover" >
        <template #trigger>
          <div 
            @click="logout"
            class="flex-none mx-2 h-8 w-8 p-1 text-red-500 bg-white rounded-md cursor-pointer border border-gray-300 duration-300 transform-gpu hover:scale-125" >
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
          </div>
        </template>
        ចេញពីប្រព័ន្ធ
      </n-tooltip> -->
    </div>
    <Dock v-bind:show="subMenuHelper" :close="toggleAppFunc"/>
  </div>
</template>

<script >
import { computed, ref  } from 'vue'
import { useStore } from 'vuex'
import { useRoute , useRouter } from 'vue-router'
import { isAuth , getUser , authLogout } from '../../plugins/authentication'
import { getRoutes } from '../../plugins/route'
import { useDialog, useNotification, useMessage, messageDark } from 'naive-ui'
import Dock from '../widgets/Dock.vue'
import ocmLogoPng from '@assets/logo.png'
import DigitalClock from '@components/widgets/DigitalClock.vue'

export default {
  name: 'Topmenu'  ,
  components: {
    Dock ,
    DigitalClock
  },
  setup(){
    const store = useStore()
    const dialog = useDialog()
    const router = useRouter()
    const route = useRoute()
    const message = useMessage()

    const subMenuHelper = ref(false)

    const systemName = computed( () => {
      return store.state.system.name != "" ? store.state.system.name : 'ប្រព័ន្ធបណ្ដុំឯកសារ'
    })
    const username = computed(() => {
      let user = getUser()
      return user !== null && user.people != null ? user.people.lastname + ' ' + user.people.firstname : "" 
    })

    const profilePicture = computed(() => {
      let user = getUser()
      return user !== null && user.avatar_url !== null ? user.avatar_url : null 
    })
    
    /**
     * Check the authentication of the user
     */
     const isLoggedIn = computed(()=>{
      return isAuth()
    })

    function logout(){
      if( isAuth() ){
        dialog.warning({
          title : 'ចាកចេញ' ,
          content: () => 'តើអ្នកចង់ចាកចេញពីប្រព័ន្ធមែនទេ?' ,
          positiveText: 'បាទ / ចាស',
          negativeText: 'ទេ',
          onPositiveClick: () => {
            store.dispatch('auth/logout').then( res => {
              message.success('អ្នកបានចេញពីប្រព័ន្ធ។')
            }).catch( err => {
              console.log( err )
            })
            authLogout()
            let routes = router.getRoutes()
            for(let i in routes ){
              router.hasRoute( routes[i].name ) ? router.removeRoute( routes[i].name ) : false
            }
            routes = getRoutes()
            for(let i in routes ){
              router.addRoute( routes[i] )
            }
            router.push('/login')
          },
          onNegativeClick: () => {}
        })
      }
    }

    function toggleAppFunc(){
      subMenuHelper.value = !subMenuHelper.value
    }

    return {
      username ,
      profilePicture ,
      isLoggedIn ,
      subMenuHelper ,
      systemName ,
      logout ,
      toggleAppFunc ,
      ocmLogoPng
    }
  }
}
</script>

<style scoped >
/**
Transition
*/

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>