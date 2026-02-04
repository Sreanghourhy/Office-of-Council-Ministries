<template>
  
  <div class="w-full pt-12 pl-40 " >
    <div class="top-8 p-4 w-full min-h-screen ">
      <Transition name="slide-fade" >
        <div  v-if="transitionHelper" class="bg-white passwordChange p-8 sm:w-2/3 md:w-3/5 lg:w-2/5 w-4/5 mx-auto shadow rounded-lg mb-8 relative">
          <div class="my-4">
            <n-form
            ref="formRef"
            label-placement="top"
            label-width="120"
            :model="model" 
            :rules="rules"
            >
              <div class="w-full mb-4  text-left text-md font-bold" >សូមបញ្ចូលពាក្យសម្ងាត់ថ្មីរបស់អ្នកក្នុងប្រអប់ខាងក្រោម ៖</div>
              <n-form-item-row  path="password"  label="ពាក្យសម្ងាត់" class="text-md" >
                <n-input type="password" placeholder="ពាក្យសម្ងាត់" class="text-left text-md" v-model:value="model.password" />
              </n-form-item-row>
              <n-form-item-row  path="confirmPassword"  label="បញ្ជាក់ពាក្យសម្ងាត់"  class="text-md">
                <n-input type="password" placeholder="បញ្ជាក់ពាក្យសម្ងាត់" class="text-left text-md" v-model:value="model.confirmPassword" />
              </n-form-item-row>
            </n-form>
            <n-button class="w-32 my-1 mx-1 text-md text-center" @click="$router.go(-1)" >បកក្រោយ</n-button>
            <n-button class="w-32 my-1 mx-1 text-md text-center" @click="changePassword()" >ប្ដូរពាក្យសម្ងាត់</n-button>
          </div>
        </div>
      </Transition>
    </div>
    <!-- Title of crud -->
    <float-top-menu v-bind:title="title" />
    <sidebar />
  </div>
</template>
<script >
import { isAuth ,getUser , authLogout } from '../../plugins/authentication'
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { useNotification } from 'naive-ui'
import TopMenu from './../menu/topmenu-floattop.vue'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'

  export default {
    name: 'Profile' ,
    components: {
      FloatTopMenu ,
      Sidebar ,
      TopMenu
    },
    setup(){
      const router = useRouter()
      const store = useStore()
      const notify = useNotification()
      const user = ref(null)
      const base64Avatar = ref(null)
      const transitionHelper = ref(false)
      const title = ref('ប្ដូរពាក្យសម្ងាត់គណនី')

      if( isAuth() ){
        user.value = getUser()
        setTimeout( function(){
          transitionHelper.value = true
        } , 300 )
      }else{
        transitionHelper.value = false
        user.value = ref({
          lastname: '' ,
          firstname: '' ,
          phone: '' ,
          username: '' ,
          email: ''
        })
      }

      setTimeout(function(){
        transitionHelper.value = true
      },300)

      const model = reactive({
          password: '' ,
          confirmPassword: '' ,
          title: 'ប្ដូរពាក្យសម្ងាត់'
      })

      const rules = {
          password: [
              { required: true, message: 'សូមបញ្ចូលពាក្យសម្ងាត់!', trigger: 'blur' }
          ],
          confirmPassword: [
              { required: true, message: 'សូមបញ្ចូលពាក្យសម្ងាត់ម្ដងទៀតដើម្បីបញ្ជាក់!', trigger: 'blur' }
          ]
      }

      /**
       * Update local photo
       */
      const localProfile = computed( () => {
        return base64Avatar.value !== "" && base64Avatar.value !== null ? base64Avatar.value : ( user.value.avatar_url !== "" && user.value.avatar_url !== null ? user.value.avatar_url : "/src/assets/logo.png" )
      })

      function changePassword(){
        if( model.password == '' || model.confirmPassword == '' ){
            notify.warning({  
                title: 'ពិនិត្យពាក្យសម្ងាត់' ,
                content: 'សូមបំពេញ ពាក្យសម្ងាត់ និង បញ្ជាក់ពាក្យសម្ងាត់។' ,
                duration: 1000
            })
          return false
        }
        if( model.password !== model.confirmPassword ) {
            notify.warning({
                title: 'ពិនិត្យពាក្យសម្ងាត់' ,
                content: 'សូមប្រាកដថា ពាក្យសម្ងាត់ និង បញ្ជាក់ពាក្យសម្ងាត់ គឺដូចគ្នា។' ,
                duration: 1000
            })
            return false
        }
        store.dispatch('user/passwordChange',{
            id: getUser().id ,
            email: getUser().email ,
            password: model.password
        }).then( res => {
            if( res.data.ok ){
                notify.success({
                    title: 'ប្ដូរពាក្យសម្ងាត់ថ្មី' ,
                    content: res.data.message ,
                    duration: 1000
                })
                // authLogout()
                router.push({
                    name: "Login" ,
                    params: {
                        email: getUser().email
                    }
                })
            }else{
                notify.warning({
                    title: 'ប្ដូរពាក្យសម្ងាត់ថ្មី' ,
                    content: res.data.message ,
                    duration: 1000
                })
            }
        }).catch( err => {
            notify.error({
                title: 'ប្ដូរពាក្យសម្ងាត់ថ្មី' ,
                content: err.response.data.message ,
                duration: 3000
            })
        })
      }

      return {
        model ,
        rules ,
        changePassword ,
        transitionHelper ,
        localProfile ,
        title
      }
    }

  }
</script>