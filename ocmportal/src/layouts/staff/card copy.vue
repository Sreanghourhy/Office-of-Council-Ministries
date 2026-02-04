<template>
  <div class="relative min-h-screen bg-center bg-cover bg-no-repeat " :style="'background-image: url('+ocmLogoUrl+'); background-size: 50% 50%;'"  >
    <div class="absolute left-0 top-0 right-0 bottom-0 bg-opacity-90 bg-white flex flex-wrap justify-center items-center " >
      <!-- First card -->
      <!-- <div class="hidden relative rounded-md shadow-md p-8 mx-auto border border-gray-300 " >
        <div class="w-full flex flex-wrap" >
          <img src="/src/assets/logo.png" class="w-auto h-20 mx-auto" />
        </div>
        <div class="w-full mx-auto font-moul pb-2 text-yellow-600 text-xs" >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
        <div class="w-full mx-auto font-moul text-yellow-600 text-xs" >Office of the Council of Ministers</div>
        <div class="w-full flex flex-wrap  justify-center p-2" >
          <img src="/src/assets/profile/5.jpeg" class="w-28 mx-auto rounded-xl border border-gray-300" />
        </div>
        <div class="w-full flex flex-wrap  justify-center mb-4" >
          <div class="font-moul mx-auto text-lg" >889223</div>
        </div>
        <div class="font-moul text-left " >
          <table>
            <tr>
              <td class="p-1 pr-4 font-moul" >ឈ្មោះ</td>
              <td class="font-moul text-xl" >អ៊ុំ ចំរើន</td>
            </tr>
            <tr>
              <td class="p-1 pr-4 font-moul" >អង្គភាព</td>
              <td class="font-moul" >ខុទ្ទកាល័យ ឯកឧត្តមឧបនាយករដ្ឋមន្ត្រីប្រចាំការ</td>
            </tr>
            <tr>
              <td class="p-1 pr-4 font-moul" >តួនាទី</td>
              <td class="font-moul" >សន្តិសុខ</td>
            </tr>
            <tr>
              <td colspan="2" class="p-1 pr-4 relative " >
                <div class="absolute font-moul text-center right-0 leading-6" >រាជធានីភ្នំពេញ ថ្ងៃទី      ខែ      ឆ្នាំ ២០២៤<br/>ជ.រដ្ឋមន្ត្រី</div>
              </td>
            </tr>
          </table>
        </div>
        <div class="w-full flex flex-wrap justify-start py-6" >
          <QrcodeVue value="889223" />
        </div>
        <CornerArt />
      </div> -->
      <!-- Second card -->
      <!-- <div class="hidden card relative border border-gray-300 rounded p-8 -my-3 -mx-4">
        <div class="flex flex-initial" >
          <div class="flex-none p-4 " >
            <div class="w-full mb-2" >
              <div class="w-14 h-14 mx-auto bg-center bg-no-repeat bg-white bg-contain border-gray-200 " style="background-image: url('/src/assets/logo.svg')" ></div>
              <div class="w-full font-moul text-center text-yellow-500 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
            </div>
            <div class="mx-auto bg-center bg-no-repeat bg-white bg-cover " >
              <img src="/src/assets/profile/6.jpeg" class="h-32 mx-auto rounded-xl border border-gray-300" />
            </div>
            <div class="w-full h-6 text-center mx-auto my-2 font-bold " >OCM-ORG-888999</div>
            <qrcode-vue :value="'OCM-ORG-888888'" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" />
          </div>
          <div class="flex-grow p-4" >
            <n-tabs type="segment" animated>
              <n-tab-pane name="account-detail" tab="ព័ត៌មានផ្ទាល់ខ្លួន">
                <div class="py-4 text-left" >
                  <table>
                    <tr>
                      <td class="p-1 pr-4 font-moul" >ឈ្មោះ</td>
                      <td class="font-moul text-xl" >អ៊ុំ ចំរើន</td>
                    </tr>
                    <tr>
                      <td class="p-1 pr-4 font-moul" >អង្គភាព</td>
                      <td class="font-moul" >ខុទ្ទកាល័យ ឯកឧត្តមឧបនាយករដ្ឋមន្ត្រីប្រចាំការ</td>
                    </tr>
                    <tr>
                      <td class="p-1 pr-4 font-moul" >តួនាទី</td>
                      <td class="font-moul" >សន្តិសុខ</td>
                    </tr>
                    <tr>
                      <td class="p-1 pr-4 font-moul" >ទូរស័ព្ទ</td>
                      <td class="font-moul" >010 565656</td>
                    </tr>
                    <tr>
                      <td class="p-1 pr-4 font-moul" >អ៊ីមែល</td>
                      <td class="font-moul" >888999@gmail.com</td>
                    </tr>
                  </table>
                </div>
              </n-tab-pane>
              <n-tab-pane name="backgroud-information" tab="ព័ត៌មានផ្សេងទៀត">
                <div class="py-4" >
                  ព័ត៌មានផ្សេងទៀត
                </div>
              </n-tab-pane>
            </n-tabs>
          </div>
        </div>
        <CornerArt />
      </div> -->
      <!-- Third card -->
      <div class="relative p-8 mx-auto " >
        <!-- <Transition name="slide-fade" >
          <div v-if="officer!=null&&officer.id>0" class="mx-auto p-4 w-full flex flex-wrap" style="width: 360px; " >
            <div class="w-full mb-2" >
              <div class="w-20 h-20 mx-auto bg-center bg-no-repeat bg-white bg-contain border-gray-200 " :style="'background-image: url('+ocmLogoUrl+')'" ></div>
              <div class="w-full font-moul text-center text-yellow-500 my-2 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
              <div class="w-full font-moul text-center text-yellow-500 " >Office of the Council of Minister</div>
            </div>
            <div class="w-full" >
              <img :src="(officer.image!=''&&officer.image!=null? officer.image:ocmLogoUrl)" class="mx-auto rounded-md border border-gray-300 p-0 bg-white" style="max-height: 180px; max-width: 180px;" />
            </div>
            <div class="w-full h-6 text-center mx-auto my-2 font-bold " style=" font-size: 1rem;" >OCM-ORG-{{ officer.id }}</div>
            <div class="font-moul text-left w-full" >
              <table class=" w-full " >
                <tr>
                  <td class="p-1 pr-4 font-moul w-24" >ឈ្មោះ</td>
                  <td class="font-moul text-xl w-96 leading-8" >{{ officer.lastname + " " + officer.firstname }}</td>
                </tr>
                <tr v-if="officer != null && officer.organizations != null " >
                  <td class="p-1 pr-4 font-moul w-24" >អង្គភាព</td>
                  <td class="font-moul w-96" >{{ officer.organizations.map( (o) => o.name ).join( ', ' )}}</td>
                </tr>
                <tr v-if="officer != null && officer.positions != null ">
                  <td class="p-1 pr-4 font-moul w-24" >តួនាទី</td>
                  <td class="font-moul w-96" >{{ officer.positions.map( (o) => o.name ).join( ', ' )}}</td>
                </tr>
              </table>
            </div>
            <div class="w-full my-4" >
              <a :href="getPublicCardUrl(officer)" target="_blank_" >
                <qrcode-vue :value="getPublicCardUrl(officer)" :size="100" level="H" class=" mx-auto w-20" :render-as="'svg'" />
              </a>
            </div>
          </div>
        </Transition> -->
        <div class="" >{{ officer }}</div>
      </div>
    </div>
    <div class="fixed bottom-0 left-0 right-0">
      <Footer />
    </div>
    <CornerArt />
  </div>

</template>
<script>
  import { reactive , ref , onMounted , computed } from 'vue'
  import { useStore } from 'vuex'
  import { useRouter, useRoute } from 'vue-router'
  import QrcodeVue from 'qrcode.vue'
  import CornerArt from './../../components/widgets/frame/corner4.vue'
  import Footer from './../../components/footer/copyright.vue'
  import ocmLogoUrl from './../../assets/logo.svg'

  export default {
    name: "CardComponent" ,
    components: {
      QrcodeVue ,
      CornerArt ,
      Footer
    },
    setup(props){
      const router = useRouter()
      const store = useStore()
      const route = useRoute()
      const officer = ref(null)

      const userCountesies = computed( () => {
        return officer.value != undefined && Array.isArray( officer.value.countesies ) ? officer.value.countesies.map( ( c ) => c.name ).join(', ') : ''
      })
      
      function readOfficer(){
        if( route.params.id != undefined && parseInt( route.params.id ) > 0 ) {
          store.dispatch('people/read',{id:parseInt( route.params.id )}).then( res => {
            if( res.data.ok == true ){
              officer.value = res.data.record
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
        ocmLogoUrl
      }
    }
  }
</script>
  
<style scoped>
</style>