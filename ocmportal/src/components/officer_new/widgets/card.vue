<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr ">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center" class=" bg-white p-8" >
        <!-- Form edit account -->
        <div class="card relative border border-gray-300 rounded mx-auto w-96 bg-center bg-cover bg-no-repeat " style="background-image: url('/src/assets/logo.svg'); background-size: 70% 70%;" >
          <div class="absolute left-0 top-0 right-0 bottom-0 bg-white bg-opacity-90" ></div>
          <div v-if="record != undefined " class="flex relative" >
            <!-- Column 1 -->
            <div class="mx-auto p-4 w-full flex flex-wrap" >
              <div class="w-full mb-2" >
                <div class="w-12 h-12 mx-auto bg-center bg-no-repeat bg-white bg-contain border-gray-200 " :style="'background-image: url('+ocmLogoUrl+')'" ></div>
                <div class="w-full font-moul text-xs text-center text-yellow-500 my-2 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                <div class="w-full text-xs text-center text-yellow-500 " >Office of the Council of Ministers</div>
              </div>
              <!-- Picture -->
              <div class="w-full" >
                <img :src="(record.image!=''? record.image:ocmLogoUrl)" class="w-24 mx-auto rounded-md border border-gray-100 p-1 bg-white" />
              </div>
              <!-- Officer ID -->
              <div class="w-full h-6 text-center mx-auto my-2 font-bold " >OCM-ORG-{{ record.id }}</div>
              <div class="font-moul text-left " >
                <table>
                  <tbody>
                  <tr v-if="record.countesy != undefined && record.countesy != null" >
                    <td class="w-24 p-1  font-moul leading-6" style="vertical-align: top; text-align: left;" >ងារ</td>
                    <td class="font-moul p-1 text-md leading-6" style="vertical-align: top; text-align: left;"  >{{ record.countesy.name }}</td>
                  </tr>
                  <tr>
                    <td class="w-24 p-1 font-moul leading-6" style="vertical-align: top; text-align: left;" >ឈ្មោះ</td>
                    <td class="font-moul p-1 text-xl leading-6" style="vertical-align: top; text-align: left;"  >{{ record.lastname + " " + record.firstname }}</td>
                  </tr>
                  <tr v-if="record != null && record.organizations != null " >
                    <td class="w-24 p-1 font-moul leading-6" style="vertical-align: top; text-align: left;"  >អង្គភាព</td>
                    <td class="font-moul p-1 leading-6" style="vertical-align: top; text-align: left;"  >{{ record.organizations.map( (o) => o.name ).join( ', ' )}}</td>
                  </tr>
                  <tr v-if="record != null && record.positions != null ">
                    <td class="w-24 p-1 font-moul leading-6" style="vertical-align: top; text-align: left;"  >តួនាទី</td>
                    <td class="font-moul p-1 leading-6" style="vertical-align: top; text-align: left;"  >{{ record.positions.map( (o) => o.name ).join( ', ' )}}</td>
                  </tr>
                </tbody>
                </table>
              </div>
              <!-- QR CODE -->                
              <div class="w-full my-2" >
                <!-- <qrcode-vue :value="'OCM-ORG-'+record.id" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" /> -->
                <a :href="getPublicCardUrl(record)" target="_blank_" >
                  <qrcode-vue :value="getPublicCardUrl(record)" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" />
                </a>
              </div>
            </div>
          </div>
          <Frame4Corner />
        </div>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useMessage, useNotification } from 'naive-ui'
import Frame4Corner from './../../widgets/frame/corner4.vue'
import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from './../../../assets/logo.svg'

export default {
  components: {
    Frame4Corner ,
    QrcodeVue
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
      required: true ,
      default: () => {
        return reactive({
          id: 0 ,
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          nid: '' ,
          dob: '' ,
          marry_status: '' ,
          email: '' ,
          phone: '' ,
          person: null ,
          orgainzations: [] ,
          positions: [] ,
          countesies: []
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
    const router = useRouter()
    const route = useRoute()
    const message = useMessage()
    const notify = useNotification()

    const selectedOrganizations = ref([])
    const selectedPositions = ref([])

    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 
    

    /**
     * Variables
     */    
    var rules = {
        firstname: {
          required: true,
          message: 'សូមបញ្ចូលឈ្មោះ',
          trigger: [ 'blur']
        },
        lastname: {
          required: true,
          message: 'សូមបញ្ចូលត្រកូល',
          trigger: [ 'blur']
        }
    }
    /**
     * Functions
     */
    function clearRecord( actionStatus ){
      props.onClose( actionStatus )
    }
  
    function maskOrEscClick(){
      props.onClose( 0 )
    }
    
    function getPublicCardUrl(record){
      // return window.location.origin+'/#/officer/card/'+record.id
      return 'https://hr.ocm.gov.kh/#/officer/card/'+record.public_key
    }

    function initial(){
      // selectedOrganizations.value = [463]
    }

    return {
      /**
       * Variables
       */
      rules ,
      organizations ,
      positions , 
      getPublicCardUrl ,
      /**
       * Functions
       */
      initial ,
      clearRecord ,
      maskOrEscClick ,
      ocmLogoUrl
    }
  }
}
</script>