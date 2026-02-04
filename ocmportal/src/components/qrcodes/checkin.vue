<template>
  <div>
    <div class="mt-4 mb-24 relative">
      <Transition name="fade" >
        <div class="w-full flex flex-wrap justify-between" >
          <div class="w-1/3 p-1" >
            <div v-if="organization != null && organization != undefined" class="p-8 w-full leading-5 flex flex-wrap relative cursor-pointer hover:shadow border border-gray-200" >
              <div class="w-full text-center m-8 relative" >
                <a :href="getPublicCardUrl(organization)" >
                <!-- <qrcode-vue :value="'OCM-ORG-'+organization.id+','+organization.name" :size="150" level="H" class="mx-auto" :render-as="'svg'" /> -->
                  <qrcode-vue :value="getPublicCardUrl(organization)" :size="150" level="H" class="mx-auto" :render-as="'svg'" />
                </a>
                <div class="w-full font-moul mt-4 leading-8" >OCM-ORG-{{ $toKhmer( organization.id ) }}</div>
              </div>
              <div class="w-full font-moul mb-8 leading-8" >{{ organization.name }}</div>
              <Frame4Corner />
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </div>
</template>
<script>
import { reactive ,ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter , useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import dateFormat from "dateformat";
import Frame4Corner from './../../components/widgets/frame/corner4.vue'
/**
 * CRUD component form
 */
export default {
  name: "QRCode" ,
  components: {
    QrcodeVue ,
    Vue3Barcode ,
    Frame4Corner
  },
  setup(){
    const store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const router = useRouter()
    const route = useRoute()
    const notify = useNotification()
    const organization = ref(null)
    const staffId = ref(null)
    const staffEmail = ref(null)
    const staffPhone = ref(null)
    /**
     * Variables
     */    
    var model = reactive( {
      name: "organization" ,
      title: "QR វត្តមាន នៃក្រសួងស្ថាប័ន"
    })

    function getOrganization(){
      store.dispatch( model.name + '/read' , { id: route.params.id } ).then(
        res => {
          organization.value = res.data.record
        }
      ).catch( 
        err => {
          console.log( err )
        }
      )
    }

    function getPublicCardUrl(record){
      return window.location.origin+'/#/officer/checkinout/'+record.id
    }

    getOrganization()

    return {
      /**
       * Variables
       */
      store ,
      model ,
      organization ,
      staffId ,
      getPublicCardUrl , 
      $toKhmer ,
      staffEmail ,
      staffPhone ,
      /**
       * Functions
       */
      onlyAllowNumberAndNoSideSpace: (value) => !value || ( /^\d+$/.test(value) && !/ /g.test(value) ),
    }
  }
}

</script>

<style scoped >
  .vcb-table-cell {
    @apply p-2 ;
  }
</style>