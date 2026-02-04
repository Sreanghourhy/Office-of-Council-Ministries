<template>
  <div class="vcb-pop-create font-ktr ">
    <div class="card relative mx-auto overflow-visible" >
      <div v-if="officer != undefined " id="official-card" class="relative official-card items-center place-items-center " >
        <div class="flex flex-wrap mx-auto" style="height: 5.5cm; width: 8.5cm; padding: 6px; " > 
          <table class="w-full " style="border-spacing: 1px; " >
            <tbody>
              <tr >
                <td style="width: 2.8cm; vertical-align: top; padding: 0px 5px 2px 2px; font-size: 0.45rem; text-align: center; " >
                  <div style="position: relative; float: left; ">
                    <!-- :src=" ( savedOfficialCardBase64  != null ?  'data:image/jpg;base64,' + savedOfficialCardBase64 : ocmLogoUrl ) " -->
                    <img
                      :src=" officer.image != '' ? officer.image : ocmLogoUrl "
                      style="border-radius: 2px;" />
                      <div style="float: left; text-align: center ; width: 100%; font-family: btb-black ; color: #000000; " >លេខ <span class="font-moul h-4" style="color: #000000; " >{{ $toKhmer( officer.id ) }}</span>-គរម</div>
                  </div>
                </td>
                <td style="width: 5.7cm; vertical-align: top;" colspan="2" >
                  <table style="width: 6cm; border-spacing: 0px; ">
                    <tbody>
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 0.05cm; vertical-align: top; color: #000000;  " >គោត្តនាម-នាម<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td colspan="2" >
                          <div class="font-moul w-full text-left" style="font-size: 0.6rem; height: 13px; line-height: 13px; color: #000000; " >{{ officer.people.lastname + " " + officer.people.firstname }}</div>
                          <div class="font-bold leading-4 w-full text-left " style="font-size: 0.5rem; height: 13px; line-height: 13px; color: #000000; ">{{
                              ( officer.people.enlastname != undefined && officer.people.enlastname != null ? officer.people.enlastname : '' ) + 
                              ( officer.people.enfirstname != undefined && officer.people.enfirstname != null ? ' ' + officer.people.enfirstname : '' )
                            }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top; color: #000000; "  >ថ្ងៃខែឆ្នាំកំណើត<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td class="leading-3  font-btb-black text-left" style=" font-size: 0.55rem; color: #000000; "  >{{ getDate( officer.people.dob ) }}</td>
                        <td class="leading-3  font-btb-black " style=" font-size: 0.55rem; color: #000000; " ><span style="font-size: 0.55rem; color: #000000; " class="font-moul" >ភេទ</span>&nbsp;៖&nbsp;{{ officer.people.gender == 1 ? "ប្រុស" : "ស្រី" }}</td>
                      </tr>
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >អាសយដ្ឋាន<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td  colspan="2" class="leading-3 font-btb-black text-left" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; ">{{ $toKhmer( officer.people.address ) }}</td>
                      </tr>
                      <!-- <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >អង្គភាព<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td  colspan="2" class="leading-3  font-btb-black text-left" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; ">{{ officer.organization.name }}</td>
                      </tr>
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >មុខងារ<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td  colspan="2" class="leading-3  font-btb-black text-left" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; " >{{ officer.position.name }}</td>
                      </tr> -->
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >អង្គភាព<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td  colspan="2" class="text-left leading-3  font-btb-black" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; ">{{ 
                        officer.job!=undefined 
                          ? (
                            officer.job.organization_structure_position != undefined && officer.job.organization_structure_position.organization_structure != undefined && officer.job.organization_structure_position.organization_structure.organization != undefined
                              ? officer.job.organization_structure_position.organization_structure.organization.name 
                              : officer.organization.name                             
                          )
                          : officer.organization.name 
                        }}</td>
                      </tr>
                      <tr>
                        <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >មុខងារ<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                        <td  colspan="2" class="text-left leading-3  font-btb-black" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; " >{{ 
                        officer.job!=undefined 
                          ? (
                            officer.job.organization_structure_position != undefined && officer.job.organization_structure_position.position != undefined
                            ? officer.job.organization_structure_position.position.name 
                            : officer.position.name 
                          )
                          : officer.position.name 
                        }}</td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td class=" font-btb-black" style="width: 3cm; vertical-align: middle; position: relative;" >
                  <div style="position: absolute ; font-family: btb-black; left: -6px; width: 105px ; bottom: 10px; text-align: center; font-size: 0.47rem; line-height: 0.9rem; color: #000000; font-weight: 900; " >បណ្ណសម្គាល់ខ្លួននេះផុតកំណត់នៅ<br/>ថ្ងៃទី០១ ខែកញ្ញា ឆ្នាំ២០២៦</div>
                </td>
                <td style="width: 2cm; padding: 0cm 0cm 0.2cm 0.45cm;">
                  <qrcode-vue :value=" 'https://hr.ocm.gov.kh/#/officer/card/'+officer.public_key " :size="50" level="H" :render-as="'svg'" />
                </td>
                <td class="relative" style="width: 3.5cm; text-align: center; vertical-align: top; " >
                  <!-- <img class="absolute top-1 right-3 bg-cover bg-no-repeat bg-center" style="width: 1.4cm; height: 1.4cm; " :src="royalstamp" />
                  <div class="" >រាជធានីភ្នំពេញ ថ្ងៃទី{{ "០១" }} ខែ{{ "មករា" }} ឆ្នាំ{{ "២០២៣" }}<br/>ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div> -->
                </td>
              </tr>
            </tbody>
          </table>
        </div> 
      </div>
      <!-- <div class="absolute right-0 -top-8 bg-white rounded-md" >
        <svg class="w-6 h-6 p-1 cursor-pointer" 
        @click="saveOfficialCard" 
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M3 5.75A2.75 2.75 0 0 1 5.75 3h9.964a3.25 3.25 0 0 1 2.299.952l2.035 2.035c.61.61.952 1.437.952 2.299v9.964A2.75 2.75 0 0 1 18.25 21H5.75A2.75 2.75 0 0 1 3 18.25V5.75zM5.75 4.5c-.69 0-1.25.56-1.25 1.25v12.5c0 .69.56 1.25 1.25 1.25H6v-5.25A2.25 2.25 0 0 1 8.25 12h7.5A2.25 2.25 0 0 1 18 14.25v5.25h.25c.69 0 1.25-.56 1.25-1.25V8.286c0-.465-.184-.91-.513-1.238l-2.035-2.035a1.75 1.75 0 0 0-.952-.49V7.25a2.25 2.25 0 0 1-2.25 2.25h-4.5A2.25 2.25 0 0 1 7 7.25V4.5H5.75zm10.75 15v-5.25a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0-.75.75v5.25h9zm-8-15v2.75c0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75V4.5h-6z" fill="currentColor"></path></g></svg>
      </div>
      <div class="absolute right-8 -top-8 bg-white rounded-md" >
        <a v-if="officer!=undefined" :href="getPrintCardUrl(officer)" target="_blank_" >
          <svg class="w-6 h-6 p-1 cursor-pointer" 
          xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28 9h-3V3H7v6H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3v6h18v-6h3a2 2 0 0 0 2-2V11a2 2 0 0 0-2-2zM9 5h14v4H9zm14 22H9V17h14zm5-6h-3v-6H7v6H4V11h24z" fill="currentColor"></path></svg>
        </a>
      </div> -->
      <!-- <Frame4Corner /> -->
    </div>
  </div>
</template>
<script>
import { reactive , ref , computed, watch , onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useMessage, useNotification } from 'naive-ui'
import Frame4Corner from '@components/widgets/frame/corner4.vue'
import QrcodeVue, { QrcodeCanvas, QrcodeSvg } from 'qrcode.vue'
import ocmLogoUrl from '@assets/logo.svg'
import blurBackground from '@assets/bg_stp.png'
import blurBackgroundZ from '@assets/bg_stp_z.png'
import royalstamp from '@assets/st.png'
import dateFormat from 'dateformat'
import html2canvas from 'html2canvas'
import { getDate } from '@utils/khmer.js'

  export default {
    name: "CardComponent" ,
    components: {
      Frame4Corner ,
      QrcodeVue ,
      QrcodeCanvas ,
      QrcodeSvg
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
              console.log( res.data.record )
              // officer.value = res.data.record
              if( res.data.record != undefined && res.data.record.public_key != undefined && res.data.record.public_key.length > 0 ){
                // window.location.replace( 'https://hr.ocm.gov.kh/#/officer/card/'+res.data.record.public_key )
                officer.value = res.data.record
                console.log( officer.value )
                // if( officer.value != null && parseInt( officer.value.id ) > 0 ){
                //   readRecord()
                // }
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

      const savedOfficialCardBase64 = ref(null)
      const scaling = ref(8) ; // The number 3 is the most clear for printing with envolis printer
      function saveOfficialCard(){
        html2canvas(document.querySelector("#official-card"),{
          imageTimeout: 15000 , // 15s
          scale: scaling.value ,
          useCORS: true , // Try to load image from server side with cors ,
          allowTaint: false ,
          proxy: props.record.image
        }).then(canvas => {
          const link = document.createElement('a')
          link.href = canvas.toDataURL('image/png')
          link.download = props.record.id+'-'+props.record.people.enlastname+'-'+props.record.people.enfirstname+'-'+scaling.value+'.png'
          document.body.appendChild(link)
          link.click()
          document.body.removeChild(link)
        });
      }

      function readRecord(){
        store.dispatch('officer/publicphoto',{id:officer.value.id}).then( res => {
          savedOfficialCardBase64.value = res.data.photo != undefined && res.data.photo != "" && res.data.photo.length > 0 ? res.data.photo : null 
        }).catch( err => {
          console.log( err )
        })
      }

      return {
        userCountesies ,
        getPublicCardUrl ,
        officer ,
        ocmLogoUrl ,
        officerNotFound ,
        officer ,
        getDate ,
        savedOfficialCardBase64
      } 
    },
    updated(){
      setTimeout(function(){
        window.print()
        window.close()
        clearTimeout()
      },500)
    }
  }
</script>
  
<style scoped >
  .official-card * {
    font-size: 0.5rem;
  }
  .image {
    @apply rounded-sm w-full flex-none mx-auto overflow-hidden bg-white mb-0;
  }
</style>