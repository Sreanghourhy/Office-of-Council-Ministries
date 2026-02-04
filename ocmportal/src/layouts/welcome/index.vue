<template>
  
  <div class="relative h-screen justify-center " >
    <Transition name="slide-fade" >
      <div v-if="toggleLoginForm"  class="w-full h-40 font-moul text-4xl mt-10" >
        <div class="w-20 mx-auto mt-2">
          <img src="./../../assets/logo.svg" class="w-full" >
        </div>
        <div class="text-center mb-8" >
          <div class="my-2 h-8 font-moul text-yellow-500">ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
          <div class="my-2 h-6 text-5xl font-tacteing leading-8" >3</div>
          <div class="mt-4 mb-2 font-moul">សូមស្វាគមន៍មកកាន់ <br/>{{ $store.state.system.name }}</div>
        </div>
        <router-link to="/login" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >ចូលប្រើប្រព័ន្ធ</router-link>
        <!-- <router-link to="/tv" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >Normal Monitor</router-link> -->
        <router-link to="/tvtemplate1" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >កាលវិភាគប្រជុំ　ទី១</router-link>
        <router-link to="/tvtemplate2" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >កាលវិភាគប្រជុំ ទី២</router-link>
        <router-link to="/tvtemplate3" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >កាលវិភាគប្រជុំ ទី៣</router-link>
        <!-- <router-link to="/smartwhiteboard" class="font-moul mx-8 border border-gray-300 rounded p-4 hover:border-green-600 duration-300" >Smart Whiteboard</router-link> -->
      </div>
    </Transition>
  </div>
  <div class="fixed bottom-0 mx-auto w-full">
    <FooterComponent />
  </div>
  <FrameCorner4Component />
</template>
<script>

import { getUser } from '../../plugins/authentication'
import { getRoutes } from '../../plugins/route'
import FooterComponent from '../../components/footer/copy-right.vue'
import FrameCorner4Component from '../../components/widgets/frame/corner4.vue'
import { ref, reactive , onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { useNotification , useMessage } from 'naive-ui'

export default {
  name: 'LoginTemplate' ,
  components: {
    FooterComponent,
    FrameCorner4Component
  },
  setup(){
    /**
     * Components to use
     */
    const store = useStore()
    const router = useRouter()
    const notify = useNotification()
    const message = useMessage()
    const toggleLoginForm = ref(false)

    // if( getUser() !== undefined && getUser() !== null ){
    //   router.push('/welcome')  
    // }

    onMounted( () => {
      setTimeout( function(){
        toggleLoginForm.value = true
      } , 200 )
    })

    return {
      toggleLoginForm ,
      store      
    }
  },
  mounted(){
    // console.log( this.credentials )
  }
}
</script>
<style scoped >
</style>
