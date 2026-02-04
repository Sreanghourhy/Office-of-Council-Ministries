<template>
  <div class="font-pvh flex w-full h-16 p-2 border-b border-gray-300 " >
    <div class="flex-none w-10 rounded-full mr-1" >
      <img src="./../../assets/logo.png" alt="គ្រប់គ្រងបណ្ដុំឯកសារ" title="គ្រប់គ្រងបណ្ដុំឯកសារ" class="w-full mx-auto" >
    </div>
    <div class="flex-grow h-12 leading-10 pt-1 text-md font-moul ml-2 text-left">{{ systemName }}</div>
    <div v-if="profilePicture!=null" class="flex-none h-12 leading-10 pt-1 font-moul text-right mr-4 invisible sm:visible md:visible lg:visible xl:visible" style=" overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >{{ username }}</div>
    <div class="flex-none ">
      <!-- User profile -->
      <div v-if="isLoggedIn" class="relative "  >
        <div class="w-12 h-12 rounded-full " @click="subMenuHelper=!subMenuHelper" >
          <!-- <svg v-if="profilePicture==null" xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg> -->
          <svg v-if="profilePicture==null" xmlns="http://www.w3.org/2000/svg" class="border border-gray-200 rounded-full overflow-hidden w-12 h-12 mx-auto cursor-pointer" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-128 -128 768 768"><rect x="64" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect></svg>
          <div v-if="profilePicture!=null" class="w-12 h-12 shadow rounded-full overflow-hidden  cursor-pointer bg-center bg-no-repeat bg-cover bg-origin-content " :style=" 'background-image: url(' + profilePicture +');' " ></div>
        </div>
        <Transition name="fade" >
          <div v-if="subMenuHelper" class="submenu fixed bg-white shadow-md left-0 right-0 top-0 bottom-0 p-12 flex flex-wrap text-left z-50 justify-center ">
            <router-link to="/profile" class="myProfile w-32 h-32 m-2 p-4 rounded border border-gray-200 cursor-pointer hover:border-gray-300 hover:shadow duration-300 " >
              <div class="submenu-icon h-24 flex flex-wrap justify-center text-center">
                <svg class="flex-none mx-auto h-16 text-blue-500 " xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="#0066FF">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="submenu-icon-title h-8 w-full leading-9 font-bold" >ព៌ត័មានខ្ញុំ</div>
              </div>
            </router-link>
            <router-link to="/password/change"  class="changePassword w-32 h-32 m-2 p-4 rounded border border-gray-200 cursor-pointer hover:border-gray-300 hover:shadow duration-300 " >
              <div class="submenu-icon h-24 flex flex-wrap justify-center text-center">
                <svg class="flex-none mx-auto h-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M21 2a8.998 8.998 0 0 0-8.612 11.612L2 24v6h6l10.388-10.388A9 9 0 1 0 21 2zm0 16a7.013 7.013 0 0 1-2.032-.302l-1.147-.348l-.847.847l-3.181 3.181L12.414 20L11 21.414l1.379 1.379l-1.586 1.586L9.414 23L8 24.414l1.379 1.379L7.172 28H4v-3.172l9.802-9.802l.848-.847l-.348-1.147A7 7 0 1 1 21 18z" fill="currentColor"></path><circle cx="22" cy="10" r="2" fill="currentColor"></circle></svg>
                <div class="submenu-icon-title h-8 w-full leading-9 font-bold" >ប្ដូរពាក្យសម្ងាត់</div>
              </div>
            </router-link>
            <div class="logout w-32 h-32 m-2 p-4 rounded border border-gray-200 text-center cursor-pointer hover:border-gray-300 hover:shadow duration-300 " @click="logout()" >
              <svg class="flex-none mx-auto h-16 text-red-500" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20">
                <g fill="none" ><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g>
              </svg>
              <div class="submenu-icon-title h-8 w-full leading-9 font-bold" >ចាកចេញ</div>
            </div>
            <div class="fixed w-12 h-12 bottom-5" >
              <svg @click="subMenuHelper=!subMenuHelper" class=" border-gray-200 duration-300 rounded h-12 text-red-500 p-1 mx-auto cursor-pointer" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2zm5.4 21L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4l-1.6 1.6z" fill="currentColor"></path></svg>
            </div>
          </div>
        </Transition>
      </div>
      <!-- End of user profile-->
      <!-- User profile -->
      <div v-if="!isLoggedIn" class="w-12 h-12 cursor-pointer " @click="$router.push('/')" >
        <div class=" leading-10 p-1 my-2 mr-2 w-12 h-12 rounded-full bg-blue-500 text-white" >
          ចូល
        </div>
      </div>
      <!-- End of user profile-->
    </div>
  </div>
</template>

<script >
import { computed, ref  } from 'vue'
import { useStore } from 'vuex'
import { useRoute , useRouter } from 'vue-router'
import { isAuth , getUser , authLogout } from './../../plugins/authentication'
import { getRoutes } from './../../plugins/route'
import { useDialog, useNotification, useMessage } from 'naive-ui'
export default {
  name: 'Topmenu'  ,
  setup(){
    const store = useStore()
    const dialog = useDialog()
    const router = useRouter()
    const route = useRoute()

    const subMenuHelper = ref(false)

    const systemName = computed( () => {
      return store.state.system.name != "" ? store.state.system.name : 'ប្រព័ន្ធបណ្ដុំឯកសារ'
    })
    const username = computed(() => {
      let user = getUser()
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

    return {
      username ,
      profilePicture ,
      isLoggedIn ,
      subMenuHelper ,
      systemName ,
      logout
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