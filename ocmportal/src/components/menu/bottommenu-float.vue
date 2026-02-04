<template>
  <div class="ocm-float-menu-bottom fixed bottom-0 left-0 right-0 p-0 h-12 flex bg-gray-100 border-t border-gray-200" >
    <div class="ocm-bottom-menu mx-auto rounded flex flex-wrap justify-center items-center " >
      <div 
        @click="subMenuHelper=!subMenuHelper"
        class="flex-none h-8 w-8 shadow p-1 bg-white rounded-md cursor-pointer  hover:text-yellow-700 hover:border-yellow-700 border border-gray-100 duration-500" >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M864 144H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16zm0 400H560c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16zM464 144H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16zm0 400H160c-8.8 0-16 7.2-16 16v304c0 8.8 7.2 16 16 16h304c8.8 0 16-7.2 16-16V560c0-8.8-7.2-16-16-16z" fill="currentColor"></path></svg>
      </div>
    </div>
    <Dock v-bind:show="subMenuHelper" :close="toggleAppFunc"/>
    <div class="absolute right-0 h-12 p-2 w-40 flex flex-row-reverse" 
      @click="$router.push('/profile')" >
      <div class="flex-none border border-gray-200 rounded-full overflow-hidden w-8 h-8 cursor-pointer bg-white" >
        <div v-if="profilePicture!=null" class="rounded-full border-gray-200 w-8 h-8 flex-none mx-auto overflow-hidden bg-center bg-no-repeat bg-cover" :style=" 'background-image: url(' + profilePicture +');' " ></div>
        <svg v-if="profilePicture==null" class="w-8 mx-auto" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-128 -128 768 768"><rect x="64" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="64" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="216" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="64" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="216" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect><rect x="368" y="368" width="80" height="80" rx="40" ry="40" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></rect></svg>
      </div>
      <div v-if="username!=''" class="flex-none h-8 leading-8 pt-1 font-moul text-right mr-2 text-gray-700 invisible sm:visible md:visible lg:visible xl:visible" style=" overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" >{{ username }}</div>
    </div>
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