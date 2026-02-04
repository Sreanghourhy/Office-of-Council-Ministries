<template>
  <div class="font-pvh flex w-full h-10 p-1 border-b print:hidden" >
    <div class="flex-none w-6 rounded-full mr-1" >
      <img src="./../../assets/logo.png" alt="គ្រប់គ្រងបណ្ដុំឯកសារ" title="គ្រប់គ្រងបណ្ដុំឯកសារ" class="w-full mx-auto" >
    </div>
    <div class="flex-grow h-8 leading-10 pt-1 text-md font-moul text-left"> </div>
    <div class="flex-none ">
      <!-- User profile -->
      <div v-if="isLoggedIn" class="relative "  >
        <div class="h-8 w-40 flex flex-row-reverse" @click="subMenuHelper=!subMenuHelper" >
          <!-- <svg v-if="profilePicture==null" xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg> -->
          <div class="flex-none border border-gray-200 rounded-full overflow-hidden w-8 h-8 cursor-pointer bg-white" >
            <div v-if="profilePicture!=null" class="rounded-full border-gray-200 w-8 h-8 flex-none mx-auto overflow-hidden bg-center bg-no-repeat bg-cover" :style=" 'background-image: url(' + profilePicture +');' " ></div>
            <svg v-if="profilePicture==null" class="w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-128 -128 768 768"><rect x="64" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect></svg>
          </div>
          <div v-if="username!=''" class="flex-none h-8 leading-8 pt-1 font-moul text-right mr-4 invisible sm:visible md:visible lg:visible xl:visible" style=" overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >{{ username }}</div>
        </div>
      </div>
      <!-- End of user profile-->
      <!-- User profile -->
      <div v-if="!isLoggedIn" class="w-8 h-8 cursor-pointer " @click="$router.push('/')" >
        <div class=" leading-10 p-1 mr-2 w-8 h-8 rounded-full bg-blue-500 text-white" >
          ចូល
        </div>
      </div>
      <!-- End of user profile-->
    </div>
    <Dock v-bind:show="subMenuHelper" :close="toggleAppFunc"/>
  </div>
</template>

<script >
import { computed, ref  } from 'vue'
import { useStore } from 'vuex'
import { useRoute , useRouter } from 'vue-router'
import { isAuth , getUser , authLogout } from './../../plugins/authentication'
import { getRoutes } from './../../plugins/route'
import { useDialog, useNotification, useMessage, messageDark } from 'naive-ui'
import Dock from './../widgets/Dock.vue'

export default {
  name: 'Topmenu'  ,
  components: {
    Dock
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
      console.log( user )
      return user !== null ? user.lastname + ' ' + user.firstname : "" 
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
      toggleAppFunc
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