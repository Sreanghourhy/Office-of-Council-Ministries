<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-after-leave="onClose" :on-before-leave="beforeLeaveModal" transform-origin="center" :on-after-enter="afterEnterModal" >
        <n-card class="w-4/5 text-md relative" :bordered="false" size="small">
          <div class="font-moul text-md my-4 pb-4 border-b" >វិសាលភាពនៃការប្រើប្រាស់ឯកសារ</div>
          <div class="accessibility-paletter" >
            <div class="cursor-pointer leading-7 w-full p-4 border-b border-gray-100 relative hover:bg-gray-100 duration-300 " @click="updateRegulatorAccessibility(0)" >១. បិទការប្រើប្រាស់
              <svg v-if="parseInt( record.accessibility ) == 0 " class="absolute right-5 top-5 w-12 h-12 text-green-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41L9 16.17z" fill="currentColor"></path></svg>
            </div>
            <div class="cursor-pointer leading-7 w-full p-4 border-b border-gray-100 relative hover:bg-gray-100 duration-300 " @click="updateRegulatorAccessibility(1)" >២. ប្រើប្រាស់ផ្ទាល់ខ្លួន និង អ្នកដែលបានចែករំលែកទៅ
              <svg v-if="parseInt( record.accessibility ) == 1 " class="absolute right-5 top-5 w-12 h-12 text-green-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41L9 16.17z" fill="currentColor"></path></svg>
            </div>
            <div class="cursor-pointer leading-7 w-full p-4 border-b border-gray-100 relative hover:bg-gray-100 duration-300 " @click="updateRegulatorAccessibility(2)" >៣. ប្រើប្រាស់ទូទៅក្នុងប្រព័ន្ធ
              <svg v-if="parseInt( record.accessibility ) == 2 " class="absolute right-5 top-5 w-12 h-12 text-green-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41L9 16.17z" fill="currentColor"></path></svg>
            </div>
            <div class="cursor-pointer leading-7 w-full p-4 border-b border-gray-100 relative hover:bg-gray-100 duration-300 " @click="updateRegulatorAccessibility(4)" >៤. ប្រើប្រាស់ជាសកល
              <svg v-if="parseInt( record.accessibility ) == 4 " class="absolute right-5 top-5 w-12 h-12 text-green-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9 16.17L5.53 12.7a.996.996 0 1 0-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 1 0-1.41-1.41L9 16.17z" fill="currentColor"></path></svg>
            </div>
          </div>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive, computed, ref } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

export default {
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
      required: false ,
      default: () => {
        return reactive({
          id: 0 ,
          number: '' ,
          title: '' ,
          objective: '' ,
          active: 1 ,
          year: null ,
          type_id: null ,
          pdfs: [] ,
          publish: 0 ,
          accessibility: 0
        })
      },
      // validator: (val) => {
      //   for(var field in ['id','username','firstname','lastname','email','phone','password','active'] ){
      //     if( !val.hasOwnProperty(field) ) return false
      //   }
      //   return true 
      // }
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
    const store = useStore()
    const message = useMessage()
    const notify = useNotification()

    function updateRegulatorAccessibility(mode){
      store.dispatch('folder/updateAccessibility',{ id: props.record.id , mode : mode } ).then( res => {
        if( res.data.ok ){
          props.record.accessibility = res.data.record.accessibility 
          // Successfully updated
          props.onClose(props.record)
        }
      }).catch( err => {
        console.log( err )
      })
    }

    function afterEnterModal(){
      
    }

    function beforeLeaveModal(){
      
    }

    return {
      /**
       * Variables
       */
      /**
       * Functions
       */
      afterEnterModal ,
      beforeLeaveModal ,
      updateRegulatorAccessibility
    }
  }
}
</script>

<style scoped>
.card-tabs .n-tabs-nav--bar-type {
  padding-left: 4px;
}

</style>