<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick" :on-after-enter="initial" transform-origin="center">
        <n-card class="w-1/2 font-pvh text-xl" :title="'បន្ថែម ' + model.title" :bordered="false" size="small">
          <template #header-extra>
            <n-button type="success" :disabled="btnSavingLoadingRef" @click="create()" :loading="btnSavingLoadingRef" >
              <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
              </template>
              រក្សារទុក
            </n-button>
          </template>
          <!-- Form edit account -->
          <div class="crud-create-form w-full border-t">
            <div class=" mx-auto p-4 flex-wrap">
              <div class="crud-form-panel w-full flex flex-wrap ">
                <n-form 
                  class="w-full text-left font-omc text-lg flex flex-wrap" 
                  :label-width="80"
                  :model="record"
                  :rules="rules"
                  size="large"
                  ref="formRef"
                >
                  <n-form-item label="កាលបរិច្ឆែក" path="year" class="w-4/5 mr-8" >
                    <n-input-number name="year" v-model:value="meetingDateTime.year" :min="1990" :step="1" placeholder="សូមបញ្ចូលឆ្នាំ" class="text-center font-bold " >
                      <template #prefix class="text-gray-400" >ឆ្នាំ</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template
                    ></n-input-number>
                    <n-input-number name="month" v-model:value="meetingDateTime.month" :min="1" :max="12" :step="1" placeholder="សូមបញ្ចូលខែ" class="mx-2 text-center font-bold " >
                      <template #prefix>ខែ</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                    <n-input-number name="day" v-model:value="meetingDateTime.day" :min="1" :max="31" :step="1" placeholder="សូមបញ្ចូលថ្ងៃ" class="text-center font-bold " >
                      <template #prefix>ថ្ងៃ</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                  </n-form-item>
                  <n-form-item label="ម៉ោងចាប់ផ្ដើម" path="start" class="w-2/5" >
                    <n-input-number name="start_hour" v-model:value="meetingDateTime.start.hour" :min="0" :max="23" :step="1" placeholder="សូមបញ្ចូលម៉ោង" class="mr-2 text-center font-bold " >
                      <template #prefix>ម៉ោង</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                    <n-input-number name="start_minutes" v-model:value="meetingDateTime.start.minutes" :min="0" :max="59" :step="1" placeholder="សូមបញ្ចូលនាទី" class="mr-2 text-center font-bold " >
                      <template #prefix>នាទី</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                  </n-form-item>
                  <n-form-item label="ម៉ោងបញ្ចប់" path="end" class="w-2/5 mr-8" >
                    <n-input-number name="end_hour" v-model:value="meetingDateTime.end.hour" :min="1" :max="24" :step="1" placeholder="សូមបញ្ចូលម៉ោង" class="mr-2 text-center font-bold " >
                      <template #prefix>ម៉ោង</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                    <n-input-number name="end_minutes" v-model:value="meetingDateTime.end.minutes" :min="0" :max="59" :step="1" placeholder="សូមបញ្ចូលនាទី" class="hrometext-center font-bold " >
                      <template #prefix>នាទី</template>
                      <template #minus-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 262.62L256 342l80-79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 330.97V170"></path><path d="M256 64C150 64 64 150 64 256s86 192 192 192s192-86 192-192S362 64 256 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                      <template #add-icon>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 249.38L256 170l80 79.38"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 181.03V342"></path><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path></svg>
                      </template>
                    </n-input-number>
                  </n-form-item>
                  <n-form-item label="កម្មវត្ថុ" path="objective" class="w-4/5 mr-8" >
                    <n-input type="textarea" v-model:value="record.objective" placeholder="កម្មវត្ថុ" />
                  </n-form-item>
                  
                  <n-form-item label="សង្ខេបបឋមនៃកិច្ចប្រជុំ" path="summary" class="w-4/5 mr-8" >
                    <n-input type="textarea" v-model:value="record.summary" placeholder="សង្ខេបបឋមនៃកិច្ចប្រជុំ" />
                  </n-form-item>
                  <!-- <n-form-item label="ព័ទ៌មានទំនាក់ទំនង" path="contact_info" class="w-4/5 mr-8" >
                    <n-input type="textarea" v-model:value="record.contact_info" placeholder="ព័ទ៌មានទំនាក់ទំនង" />
                  </n-form-item> -->
                  <n-form-item label="ប្រភេទប្រជុំ" path="type" class="w-4/5 mr-8" >
                    <n-select
                      v-model:value="selectedType"
                      filterable
                      placeholder="សូមជ្រើសរើសប្រភេទប្រជុំ"
                      :options="types"
                    />
                  </n-form-item>
                  <n-form-item label="ប្រភព" path="organization" class="w-4/5 mr-8" >
                    <n-select
                      v-model:value="selectedOrganization"
                      filterable
                      multiple
                      placeholder="សូមជ្រើសរើសប្រភព​"
                      :options="organizations"
                    />
                  </n-form-item>
                </n-form>
                <div class="w-1/2 h-8"></div>  
              </div>
            </div>
          </div>
          <!-- End form edit account -->
          <template #footer></template>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import Crud from '@classes/Crud.js'
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import dateFormat from "dateformat";

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
          objective: '' ,
          contact_info: '' ,
          date: new Date() ,
          start: null ,
          summary: '' ,
          end : null ,
          type_id: null
        })
      }
    },
    show: {
      type: Boolean ,
      default: false
    },
    onClose: {
      type: Function
    }
  },
  setup(props){
    const store = useStore()
    const message = useMessage()
    const notify = useNotification()
    const crud = ref(null)
    const btnSavingLoadingRef = ref(false)

    const types = computed( () => {
      return store.getters['meetingType/records'].all.map( ( o ) => { 
        return { label: o.name , value: o.id } 
      })
    })
    const selectedType = ref(null)

    const organizations = computed( () => {
      return store.getters['meetingOrganization/records'].all.map( ( o ) => { 
        return { label: o.name , value: o.id } 
      })
    })
    const selectedOrganization = ref([])

    const today = ref( new Date() )

    const meetingDateTime = reactive({
      year: parseInt( dateFormat( today.value , 'yyyy') ) ,
      month: parseInt( dateFormat( today.value , 'mm') ) ,
      day: parseInt( dateFormat( today.value , 'dd') ) ,
      start: {
        hour : parseInt( dateFormat( today.value , 'H') ) ,
        minutes : parseInt( dateFormat( today.value , 'MM') )
      },
      end: {
        hour: parseInt( dateFormat( today.value , 'H') ) ,
        minutes: parseInt( dateFormat( today.value , 'MM') )
      }
    })

    function clearForm(){
      props.record.id = 0
      props.record.objective = '' 
      props.record.contact_info = '' 
      props.record.type = null

      meetingDateTime.year = parseInt( dateFormat( today.value , 'yyyy') )
      meetingDateTime.month = parseInt( dateFormat( today.value , 'mm') )
      meetingDateTime.day = parseInt( dateFormat( today.value , 'dd') )
      meetingDateTime.start = {
          hour : parseInt( dateFormat( today.value , 'H') ) ,
          minutes : parseInt( dateFormat( today.value , 'MM') )
      }
      meetingDateTime.end = {
        hour: parseInt( dateFormat( today.value , 'H') ) ,
        minutes: parseInt( dateFormat( today.value , 'MM') )
      }

      props.record.date = [meetingDateTime.year,meetingDateTime.month,meetingDateTime.day].join('-')
      props.record.start = [meetingDateTime.start.hour,meetingDateTime.start.minutes].join(':')
      props.record.end = [meetingDateTime.end.hour,meetingDateTime.end.minutes].join(':')

      if( props.show == true ){
        props.onClose()
      }
    }

    /**
     * Variables
     */    
    const rules = {
        name: {
          required: true,
          message: 'សូមបញ្ចូលឈ្មោះ' + props.model.title ,
          trigger: [ 'blur']
        }
    }
    /**
     * Functions
     */
    function clearRecord(){
      props.record.id = 0 
      props.record.name = '' 
    }

    function create(){
      if( props.record.objective == "" ){
        notify.warning({
          'title' : 'ពិនិត្យព័ត៌មាន' ,
          'description' : 'សូមបំពេញ កម្មវត្ថុ' ,
          duration : 3000
        })
        return false
      }

      props.record.date = [meetingDateTime.year,meetingDateTime.month,meetingDateTime.day].join('-')
      props.record.start = [meetingDateTime.start.hour,meetingDateTime.start.minutes].join(':')
      props.record.end = [meetingDateTime.end.hour,meetingDateTime.end.minutes].join(':')
      props.record.type_id = selectedType.value > 0 ? selectedType.value : 0
      props.record.organizations = Array.isArray( selectedOrganization.value ) && selectedOrganization.value.length > 0 ? selectedOrganization.value : []
      
      if( props.model === undefined || props.model.name == "" ){
        notify.warning({
          'title' : 'ពិនិត្យព័ត៌មាន' ,
          'description' : 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
          duration : 3000
        })
        return false
      }

      btnSavingLoadingRef.value = true
      crud.value.create( 
        {
          objective: props.record.objective ,
          date: props.record.date  ,
          start: props.record.start ,
          end: props.record.end ,
          type_id: props.record.type_id ,
          contact_info : props.record.contact_info ,
          summary : props.record.summary ,
          organizations: props.record.organizations
        },
        ( res ) => {
          switch( res.status ){
            case 200 : 
            notify.success({
              'title' : 'រក្សារទុកព័ត៌មាន' ,
              'description' : res.data.message ,
              duration : 3000
            })
            btnSavingLoadingRef.value = false
            clearRecord()
            props.onClose( 1 )
            break;
          }
        },
        ( error ) => {
          btnSavingLoadingRef.value = false
          console.log( error )
        }
      )
    }
    
    function maskOrEscClick(){
      props.onClose( 1 )
    }
    function initial(){
      store.commit( props.model.name+"/setColumns", [ 'id' , 'name' ] )
      store.commit( props.model.name+"/setModel", props.model )
      crud.value = new Crud()
      crud.value.setConfig( import.meta.env.VITE_API_SERVER , store.getters[props.model.name+'/model'] , store.getters[props.model.name+'/columns'].all )
    }

    return {
      /**
       * Variables
       */
      rules ,
      /**
       * Functions
       */
      create ,
      initial ,
      maskOrEscClick ,
      btnSavingLoadingRef ,
      meetingDateTime ,
      selectedType ,
      types ,
      organizations ,
      selectedOrganization
    }
  }
}
</script>