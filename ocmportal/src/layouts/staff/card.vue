<template>
  <div class="absolute left-0 top-0 right-0 bottom-0 overflow-y-auto overflow-x-hidden bg-repeat bg-yellow-50" :style="'background-image: url('+ocmCardBackgroundImage+'); '"  >
    <div class="relative p-2 mx-auto w-4/5 sm:w-3/5 md:w-2/5 lg:w-2/5 xl:w-2/5" >
      <Transition name="slide-fade" >
        <div v-if="officer!=null" class="mx-auto w-full p-0 flex flex-wrap " >
          <div class="w-full mb-0" >
            <div class=" mx-auto " ><img :src="ocmLogoUrl" class="mt-8 w-20 mx-auto" /></div>
            <div class=" mx-auto my-2 font-moul text-yellow-500" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
            <div class=" mx-auto font-ktr text-yellow-800 font-bold" >Office of the Council of Ministers</div>
          </div>
          <div class="w-full p-8" >
            <img :src="(officer.image!=''&&officer.image!=null? officer.image: ocmLogoUrl )" class="rounded-lg overflow-hidden w-32 mx-auto border border-gray-300 p-0 bg-white" />
          </div>
          <div class="font-moul text-left w-full text-gray-800" >
              <div class="font-btb font-bold pb-1 leading-6 text-center text-gray-700"  >{{ officer.card != undefined && officer.card != null && officer.card.id > 0 ? officer.card.number : 'OCM-ORG-' + officer.id }}</div>
              <div v-if="officer.countesy!=undefined&&officer.countesy!=null" class="font-moul pb-1 leading-6 text-center" >{{ officer.countesy.name }}</div>
              <div class="pb-1leading-7 text-center" >
                <div class="w-full font-moul mb-1 " >{{ officer.people.lastname + " " + officer.people.firstname }}</div>
                <div class="w-full" >{{ officer.people.enlastname + " " + officer.people.enfirstname }}</div>
              </div>
              <div class="py-4 w-full flex flex-wrap" >
                <div v-if="officer != null && officer.position != undefined && officer.position != null " class="w-1/2 pb-1 font-moul leading-7 text-right pr-8" >{{ officer.position.name }}</div>
                <div v-if="officer != null && officer.organization != undefined && officer.position != null " class="w-1/2 pb-1  font-moul leading-7 text-left pl-8" >{{ officer.organization.name }}</div>
              </div>
              <div v-if="officer != null && officer.organization_people != null && officer.organization_people != undefined && officer.organization_people.length > 0 " class="p-2" >
                <div v-for="(organizationPivot, index) in officer.organization_people" :key="index"
                style="vertical-align: top; text-align: left;" class="p-2 leading-7 text-sm font-bold"  >{{ organizationPivot.organization.code != "" && organizationPivot.organization.code != undefined && organizationPivot.organization.code.length > 0 ? organizationPivot.organization.code : 'OCM' }}{{ organizationPivot.code != "" && organizationPivot.code != undefined && organizationPivot.code.length > 0 ? "-" + organizationPivot.code : '-' + officer.id }}</div>
              </div>
          </div>
          <div class="w-full my-2" >
            <qrcode-vue :value="getPublicCardUrl(officer)" :size="100" level="H" class=" mx-auto p-1 border border-gray-300 rounded-md bg-white" :render-as="'svg'" />
          </div>
        </div>
      </Transition>
      <Transition name="slide-fade" >
        <div v-if="officer == null && officerNotFound == true" class="mx-auto w-full p-0 flex flex-wrap " >
          <div class="w-full mb-0" >
            <div class=" mx-auto " ><img :src="ocmLogoUrl" class="mt-8 w-20 mx-auto" /></div>
            <div class=" mx-auto my-2 font-moul text-yellow-500" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
            <div class=" mx-auto font-ktr text-yellow-800 font-bold" >Office of the Council of Ministers</div>
          </div>
          <div class="w-full p-8" >
            មិនមានព័ត៌មានបង្ហាញឡើយ។
          </div>
        </div>
      </Transition>
    </div>
    <div class="fixed bottom-0 left-0 right-0 ">
      <div class="w-full my-2 leading-8">
        <div class="text-center copy-right text-gray-700">ទីស្ដីការគណៈរដ្ឋមន្ត្រី &copy; រក្សារសិទ្ធិគ្រប់យ៉ាង ២០២៤</div>
      </div>
    </div>
  </div>

</template>
<script>
  import { reactive , ref , onMounted , computed , watch } from 'vue'
  import { useStore } from 'vuex'
  import { useMessage, useNotification } from 'naive-ui'
  import { useRouter, useRoute } from 'vue-router'
  import QrcodeVue from 'qrcode.vue'
  import ocmLogoUrl from '@assets/logo.svg'
  import ocmLogoEnUrl from '@assets/logo.png'
  import ocmCardBackgroundImage from '@assets/pkachan.png'

  export default {
    name: "CardComponent" ,
    components: {
      QrcodeVue ,
      ocmCardBackgroundImage
    },
    setup(props){
      const router = useRouter()
      const store = useStore()
      const route = useRoute()
      const message = useMessage()
      const notify = useNotification()
      const officer = ref(null)

      const userCountesies = computed( () => {
        return officer != undefined && Array.isArray( officer.value.countesies ) ? officer.value.countesies.map( ( c ) => c.name ).join(', ') : ''
      })
      
      watch( () => route.params.id, (newValue, oldValue) => {
        readOfficer( )
      })

      const officerNotFound = ref(false)
      function readOfficer(){
        if( route.params != undefined && route.params != null && parseInt( route.params.id ) > 0 ) {
          store.dispatch('officer/read',{id:parseInt( route.params.id )}).then( res => {
            if( res.data.ok == true ){
              // officer.value = res.data.record
              if( res.data.record != undefined && res.data.record.public_key != undefined && res.data.record.public_key.length > 0 ){
                window.location.replace( 'https://hr.ocm.gov.kh/#/officer/card/'+res.data.record.public_key )
              }else{
                officerNotFound.value = true
              }
            }else{
              console.log( res )
            }
          }).catch( err => {
            console.log( err )
          })
        }
      }

      onMounted(()=>{
        readOfficer()
      })

      function getPublicCardUrl(record){
        return window.location.origin+'/#/officer/card/'+record.id
      }

      return {
        userCountesies ,
        getPublicCardUrl ,
        officer ,
        ocmLogoUrl ,
        ocmCardBackgroundImage ,
        ocmLogoEnUrl ,
        officerNotFound
      } 
    }
  }
</script>
  
<style scoped>
  
</style>