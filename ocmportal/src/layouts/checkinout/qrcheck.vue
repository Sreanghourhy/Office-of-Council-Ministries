<template>
  <div>
    <div class="mt-2 mb-24 relative">
      <Transition name="fade" >
        <div class="w-full flex flex-wrap justify-between" >
          <div class="w-full p-1 mx-auto" >
            <div v-if="organization != null && organization != undefined" class="p-2 w-full leading-5 flex flex-wrap relative cursor-pointer" >
              <div class="w-full text-center m-2 relative" >
                <div class="w-20 h-20 mx-auto bg-contain bg-no-repeat bg-center" style="background-image: url('/src/assets/logo.png')" ></div>
                <div class="w-full font-moul mb-0 text-yellow-600 leading-8 text-xs" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                <div class="w-full font-moul mb-4 leading-6 text-xs " >{{ organization.name }}</div>
                <div class="w-full font-moul mb-4 leading-6 text-xs " >ពិនិត្យវត្តមានមន្ត្រី</div>
                <div class="w-1/3 mx-auto text-left text-xs " >
                  <!-- <qrcode-stream 
                    :paused="paused"
                    @decode="onDecode"
                    @detect="onDetect"
                    @camera-on="onCameraOn"
                    @camera-off="onCameraOff"
                    @error="onError"
                  >
                    <div
                      v-show="showScanConfirmation"
                      class="scan-confirmation"
                    >OK</div>
                  </qrcode-stream> -->
                  <qrcode-stream 
                    :paused="paused"
                    @detect="onDetect"
                    @camera-on="onCameraOn"
                    @camera-off="onCameraOff"
                    @error="onError"
                  >
                    <div
                      v-show="showScanConfirmation"
                      class="scan-confirmation"
                    >OK</div>
                  </qrcode-stream>
                  <div v-if="result!=''&&result!=null" class="w-full p-2 text-green-500 border border-green-500 break-words mt-4" v-html="result"></div>
                </div>
                <div class="p-2 w-full flex " >
                  <div class="p-2 border border-gray-500 hover:border-green-500 mt-4 hover:bg-white duration-300 rounded-md mx-auto" @click="$router.push('/officer/checkinout/463')" >ពិនិត្យវត្តមានតាមវិធីផ្សេងទៀត</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Transition>
      
    </div>
    <Frame4Corner />
  </div>
</template>
<script>
import { reactive ,ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter , useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'qrcode-reader-vue3'
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
    Frame4Corner ,
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture
  },
  setup(){
    const store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const router = useRouter()
    const route = useRoute()
    const notify = useNotification()
    const organization = ref(null)
    const paused = ref(false)
    const result = ref('')
    const showScanConfirmation = ref(false)
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

    function onCameraOn() {
      showScanConfirmation.value = false
    }

    function onCameraOff() {
      showScanConfirmation.value = true
    }

    function onError(error){
      console.error
    }

    function onDecode (decodedString) {
      result.value = decodedString
    }

    async function onDetect (detectedCodes) {
      console.log( detectedCodes )
      result.value = JSON.stringify(detectedCodes.content)

      paused.value = true
      await timeout(500)
      paused.value = false
    }

    function timeout(ms) {
      return new Promise((resolve) => {
        window.setTimeout(resolve, ms)
      })
    }

    getOrganization()

    return {
      /**
       * Variables
       */
      store ,
      model ,
      organization ,
      result ,
      paused ,
      showScanConfirmation ,
      /**
       * Functions
       */
      onlyAllowNumberAndNoSideSpace: (value) => !value || ( /^\d+$/.test(value) && !/ /g.test(value) ),
      onDecode ,
      onError , 
      onCameraOn ,
      onCameraOff ,
      onDetect
    }
  }
}

</script>

<style scoped >
  .scan-confirmation {
    position: absolute;
    width: 100%;
    height: 100%;

    background-color: rgba(255, 255, 255, 0.8);

    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
  }
</style>