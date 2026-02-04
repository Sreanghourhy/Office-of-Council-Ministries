<template>
  <div class="absolute left-0 top-0 right-0 bottom-0 overflow-y-auto overflow-x-hidden" :style="'background-image: url('+ocmCardBackgroundImage+'); background-size: 100% 100%; background-repeat: repeat-y; '"  >
    <div class="relative p-2 mx-auto w-4/5 sm:w-3/5 md:w-2/5 lg:w-2/5 xl:w-2/5" >
      <Transition name="slide-fade" >
        <div v-if="officer!=null" class="mx-auto w-full p-0 flex flex-wrap " >
          <div class="w-full mb-0" >
            <div class=" mx-auto w-48 " >
              <img :src="ocmLogoEnUrl" class="w-full" />
            </div>
          </div>
          <div class="w-full -mt-6 mb-4" >
            <img :src="(officer.image!=''&&officer.image!=null? officer.image:ocmLogoUrl)" class="mx-auto rounded-md border border-gray-300 p-0 bg-white" style="max-width: 140px; max-height: 140px; " />
          </div>
          <!-- <div class="w-full h-6 text-center mx-auto my-2 font-bold text-white" style=" font-size: 1rem;" >OCM-ORG-{{ officer.id }}</div> -->
          <div class="font-moul text-left w-full text-white" >
            <table>
                <tr v-if="userCountesies!=''" >
                    <td class="w-24 p-2  font-moul leading-6" style="vertical-align: top; text-align: left;" >ងារ</td>
                    <td class="font-moul p-1 text-md leading-6" style="vertical-align: top; text-align: left;"  >{{ userCountesies }}</td>
                  </tr>
                <tr>
                  <td class="w-24 p-2 font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;" >ឈ្មោះ</td>
                  <td class="p-2  font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >{{ officer.lastname + " " + officer.firstname }}</td>
                </tr>
                <tr v-if="officer != null && officer.organizations != null " >
                  <td class="w-24 p-2 font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >អង្គភាព</td>
                  <td class="p-2  font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >{{ officer.organizations.map( (o) => o.name ).join( ', ' )}}</td>
                </tr>
                <tr v-if="officer != null && officer.positions != null ">
                  <td class="w-24 p-2 font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >តួនាទី</td>
                  <td class="p-2 font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >{{ officer.positions.map( (o) => o.name ).join( ', ' )}}</td>
                </tr>
                <tr v-if="officer != null && officer.organization_people != null && officer.organization_people != undefined && officer.organization_people.length > 0 ">
                  <td class="w-24 p-2 font-moul leading-7 text-sm" style="vertical-align: top; text-align: left;"  >លេខសម្គាល់</td>
                  <td class="p-2 " style="vertical-align: top; text-align: left;"  >
                      <div class="leading-7 text-sm font-bold" v-for="(organizationPivot, index) in officer.organization_people" >{{ organizationPivot.organization.code != "" && organizationPivot.organization.code != undefined && organizationPivot.organization.code.length > 0 ? organizationPivot.organization.code : 'OCM' }}{{ organizationPivot.code != "" && organizationPivot.code != undefined && organizationPivot.code.length > 0 ? "-" + organizationPivot.code : '-' + officer.id }}</div>
                  </td>
                </tr>
              </table>
          </div>
          <div class="w-full my-2" >
            <qrcode-vue :value="getPublicCardUrl(officer)" :size="100" level="H" class=" mx-auto w-20" :render-as="'svg'" />
          </div>
        </div>
      </Transition>
    </div>
    <div class="fixed bottom-0 left-0 right-0 ">
      <div class="w-full my-2 leading-8">
        <div class="text-center copy-right text-white">ទីស្ដីការគណៈរដ្ឋមន្ត្រី &copy; រក្សារសិទ្ធិគ្រប់យ៉ាង ២០២៤</div>
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
  import ocmLogoUrl from './../../assets/logo.svg'
  import ocmLogoEnUrl from './../../assets/logowe.png'
  import ocmCardBackgroundImage from './../../assets/cardbg.jpg'

  export default {
    name: "CardComponent" ,
    components: {
      QrcodeVue
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

      function readOfficer(){
        if( route.params != undefined && route.params != null && parseInt( route.params.id ) > 0 ) {
          store.dispatch('people/read',{id:parseInt( route.params.id )}).then( res => {
            if( res.data.ok == true ){
              officer.value = res.data.record
              officer.value.countesies
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
        ocmLogoEnUrl
      }
    }
  }
</script>
  
<style scoped>
  
</style>