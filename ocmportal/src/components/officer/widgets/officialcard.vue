<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr ">
      <n-modal 
      v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick"  :on-after-enter="initial" transform-origin="center" 
      class=" bg-white" >
        <!-- Form edit account -->
        <div class="card relative border border-gray-300 rounded mx-auto overflow-visible" >
          <div v-if="record != undefined " id="official-card" class="flex relative official-card" >
            <div class="flex flex-wrap" style="height: 5.5cm; width: 8.5cm; padding: 6px; " > 
              <table class="w-full " style="border-spacing: 1px; " >
                <tbody>
                  <tr >
                    <td style="width: 2.8cm; vertical-align: top; padding: 0px 5px 2px 2px; font-size: 0.45rem; text-align: center; " >
                      <div style="position: relative; float: left; ">
                        <img
                          :src="getOfficerPhotoSrc(record)"
                          @error="setPhotoFallback"
                          style="border-radius: 2px;" />
                          <div style="float: left; text-align: center ; width: 100%; font-family: btb-black ; color: #000000; " >លេខ <span class="font-moul h-4" style="color: #000000; " >{{ $toKhmer( record.id ) }}</span>-គរម</div>
                      </div>
                    </td>
                    <td style="width: 5.7cm; vertical-align: top;" colspan="2" >
                      <table style="width: 6cm; border-spacing: 0px; ">
                        <tbody>
                          <tr>
                            <td class="text-left font-moul align-top" style="width: 0.05cm; vertical-align: top; color: #000000;  " >គោត្តនាម-នាម<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                            <td colspan="2" >
                              <div class="font-moul w-full" style="font-size: 0.6rem; height: 13px; line-height: 13px; color: #000000; " >{{ getKhmerFullName(record) }}</div>
                              <div class="font-bold leading-4 w-full" style="font-size: 0.5rem; height: 13px; line-height: 13px; color: #000000; ">{{ getEnglishFullName(record) }}</div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top; color: #000000; "  >ថ្ងៃខែឆ្នាំកំណើត<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                            <td class="leading-3  font-btb-black " style=" font-size: 0.55rem; color: #000000; "  >{{ getDate( record.people.dob ) }}</td>
                            <td class="leading-3  font-btb-black " style=" font-size: 0.55rem; color: #000000; " ><span style="font-size: 0.55rem; color: #000000; " class="font-moul" >ភេទ</span>&nbsp;៖&nbsp;{{ record.people.gender == 1 ? "ប្រុស" : "ស្រី" }}</td>
                          </tr>
                          <tr>
                            <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >អាសយដ្ឋាន<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                            <td  colspan="2" class="leading-3 font-btb-black" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; ">{{ $toKhmer( record.people.address ) }}</td>
                          </tr>
                          <tr>
                            <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >អង្គភាព<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                            <td  colspan="2" class="leading-3  font-btb-black" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; ">{{ getOrganizationName(record) }}</td>
                          </tr>
                          <tr>
                            <td class="text-left font-moul align-top" style="width: 2cm;  vertical-align: top;color: #000000; "  >មុខងារ<span style="float: right; font-size: 0.55rem; color: #000000; " >៖</span></td>
                            <td  colspan="2" class="leading-3  font-btb-black" style=" font-size: 0.55rem; line-height: 0.8rem; color: #000000; " >{{ getPositionName(record) }}</td>
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
                      <div
                        class="qr-touch-zone"
                        role="button"
                        tabindex="0"
                        @click="showQrLinkPopup(record)"
                        @keydown.enter.prevent="showQrLinkPopup(record)"
                        @keydown.space.prevent="showQrLinkPopup(record)"
                        title="ចុចដើម្បីបើកតំណមន្ត្រី"
                      >
                        <qrcode-vue :value="getOfficerPublicUrl(record)" :size="50" level="H" :render-as="'svg'" />
                      </div>
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

          <n-modal
            v-bind:show="qrPopup.show"
            :on-esc="closeQrPopup"
            :on-mask-click="closeQrPopup"
            transform-origin="center"
          >
            <n-card class="qr-popup-card" :bordered="false" size="small">
              <div class="qr-popup-header">
                <div>
                  <div class="font-moul qr-popup-title">តំណព័ត៌មានមន្ត្រី</div>
                  <div class="font-sr qr-popup-subtitle">ព័ត៌មានសង្ខេបរបស់មន្ត្រី</div>
                </div>
                <button type="button" class="qr-popup-close" @click="closeQrPopup">បិទ</button>
              </div>

              <div class="qr-popup-body font-sr">
                <div class="qr-popup-profile">
                  <img
                    :src="getOfficerPhotoSrc(record)"
                    @error="setPhotoFallback"
                    class="qr-popup-photo"
                    alt="Officer Photo"
                  />
                  <div class="qr-popup-profile-copy">
                    <div class="qr-popup-officer-name">{{ qrPopup.officerName }}</div>
                    <div class="qr-popup-officer-org">{{ qrPopup.organizationName }}</div>
                  </div>
                </div>

                <div class="qr-popup-info-grid">
                  <div class="qr-popup-info-item">
                    <div class="font-moul qr-popup-label">លេខ</div>
                    <div class="qr-popup-value">{{ $toKhmer(record?.id || '') }}</div>
                  </div>

                  <div class="qr-popup-info-item">
                    <div class="font-moul qr-popup-label">ថ្ងៃខែឆ្នាំកំណើត</div>
                    <div class="qr-popup-value">{{ getDate(record?.people?.dob) }}</div>
                  </div>

                  <div class="qr-popup-info-item">
                    <div class="font-moul qr-popup-label">ថ្ងៃចូលបម្រើការងារ</div>
                    <div class="qr-popup-value">{{ getDate(record?.unofficial_date) }}</div>
                  </div>

                  <div class="qr-popup-info-item">
                    <div class="font-moul qr-popup-label">ថ្ងៃក្របខ័ណ្ឌ</div>
                    <div class="qr-popup-value">{{ getDate(record?.official_date) }}</div>
                  </div>

                  <div class="qr-popup-info-item qr-popup-info-item-full">
                    <div class="font-moul qr-popup-label">អង្គភាព / មុខតំណែង</div>
                    <div class="qr-popup-value">{{ getOrganizationName(record) }} / {{ getPositionName(record) }}</div>
                  </div>

                </div>
              </div>
            </n-card>
          </n-modal>

          <div v-if="$hasPermission('portal_staff_save_official_officier_card')" class="absolute right-0 -top-8 bg-white rounded-md" >
            <svg class="w-6 h-6 p-1 cursor-pointer" 
            @click="saveOfficialCard" 
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M3 5.75A2.75 2.75 0 0 1 5.75 3h9.964a3.25 3.25 0 0 1 2.299.952l2.035 2.035c.61.61.952 1.437.952 2.299v9.964A2.75 2.75 0 0 1 18.25 21H5.75A2.75 2.75 0 0 1 3 18.25V5.75zM5.75 4.5c-.69 0-1.25.56-1.25 1.25v12.5c0 .69.56 1.25 1.25 1.25H6v-5.25A2.25 2.25 0 0 1 8.25 12h7.5A2.25 2.25 0 0 1 18 14.25v5.25h.25c.69 0 1.25-.56 1.25-1.25V8.286c0-.465-.184-.91-.513-1.238l-2.035-2.035a1.75 1.75 0 0 0-.952-.49V7.25a2.25 2.25 0 0 1-2.25 2.25h-4.5A2.25 2.25 0 0 1 7 7.25V4.5H5.75zm10.75 15v-5.25a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0-.75.75v5.25h9zm-8-15v2.75c0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75V4.5h-6z" fill="currentColor"></path></g></svg>
          </div>
          <div v-if="$hasPermission('portal_staff_print_card')" class="absolute right-8 -top-8 bg-white rounded-md" >
            <a v-if="record!=undefined" :href="getPrintCardUrl(record)" target="_blank_" >
              <svg class="w-6 h-6 p-1 cursor-pointer" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28 9h-3V3H7v6H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3v6h18v-6h3a2 2 0 0 0 2-2V11a2 2 0 0 0-2-2zM9 5h14v4H9zm14 22H9V17h14zm5-6h-3v-6H7v6H4V11h24z" fill="currentColor"></path></svg>
            </a>
          </div>
          <!-- <Frame4Corner /> -->
        </div>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed, useTemplateRef } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useMessage, useNotification } from 'naive-ui'
import Frame4Corner from '@components/widgets/frame/corner4.vue'
import QrcodeVue, { QrcodeCanvas, QrcodeSvg } from 'qrcode.vue'
import ocmLogoUrl from '@assets/logo.svg'
import logoPngUrl from '@assets/logo.png'
import blurBackground from '@assets/bg_stp.png'
import blurBackgroundZ from '@assets/bg_stp_z.png'
import royalstamp from '@assets/st.png'
import dateFormat from 'dateformat'
import html2canvas from 'html2canvas'
import { getDate } from '@utils/khmer.js'
import { imgUrlToBase64 } from '@utils/image/read.js'
import { HtmlToPaper } from '@utils/htmltopaper.js'

export default {
  components: {
    Frame4Corner ,
    QrcodeVue ,
    QrcodeCanvas ,
    QrcodeSvg
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
      required: true
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
  setup(props,context){
    const store = useStore()
    const router = useRouter()
    const route = useRoute()
    const message = useMessage()
    const notify = useNotification()
    const officer = ref(null)

    const selectedOrganizations = ref([])
    const selectedPositions = ref([])

    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 

    const userCountesies = computed( () => {
      return props.record != undefined && Array.isArray( props.record.countesies ) ? props.record.countesies.map( ( c ) => c.name ).join(', ') : ''
    })
    
    const officerCode = computed( () => {
      return ( props.record.organization != undefined && props.record.organization.prefix != undefined && props.record.organization.prefix.length > 0 ? props.record.organization.prefix : 'OCM' ) + '-' + props.record.id
    })

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
      return window.location.origin+'/#/officer/card/'+record.id
    }

    function getPrintCardUrl(record){
      return window.location.origin+'/#/officer/print/card/'+record.id
    }

    function getKhmerFullName(record){
      return [record?.people?.lastname, record?.people?.firstname].filter(Boolean).join(' ').trim()
    }

    function getEnglishFullName(record){
      return [record?.people?.enlastname, record?.people?.enfirstname].filter(Boolean).join(' ').trim()
    }

    function getOrganizationName(record){
      return (
        record?.current_job?.organization_structure_position?.organization_structure?.organization?.name ||
        record?.jobs?.[0]?.organizationStructurePosition?.organizationStructure?.organization?.name ||
        record?.organization?.name ||
        ''
      )
    }

    function getPositionName(record){
      return (
        record?.current_job?.organization_structure_position?.position?.name ||
        record?.jobs?.[0]?.organizationStructurePosition?.position?.name ||
        record?.position?.name ||
        ''
      )
    }

    function getOfficerPhotoSrc(record){
      if (savedOfficialCardBase64.value != null && `${savedOfficialCardBase64.value}`.length > 0) {
        return 'data:image/jpg;base64,' + savedOfficialCardBase64.value
      }

      if (record?.image != null && `${record.image}`.trim().length > 0) {
        return record.image
      }

      return logoPngUrl
    }

    function setPhotoFallback(event){
      if (event?.target) {
        event.target.onerror = null
        event.target.src = logoPngUrl
      }
    }

    const savedOfficialCardBase64 = ref(null)
    const scaling = ref(8) ; // The number 3 is the most clear for printing with envolis printer
    const qrPopup = reactive({
      show: false,
      officerName: '',
      organizationName: ''
    })

    function getOfficerPublicUrl(record){
      if (record?.public_key != null && `${record.public_key}`.trim().length > 0) {
        return 'https://hr.ocm.gov.kh/#/officer/card/' + record.public_key
      }
      return window.location.origin + '/#/officer/card/' + record.id
    }

    function showQrLinkPopup(record){
      qrPopup.officerName = getKhmerFullName(record) || 'មិនមានឈ្មោះ'
      qrPopup.organizationName = getOrganizationName(record) || 'មិនមានអង្គភាព'
      qrPopup.show = true
    }

    function closeQrPopup(){
      qrPopup.show = false
    }

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
        link.download = props.record.id+'-'+( getEnglishFullName(props.record) || 'official-card' ).replace(/\s+/g, '-')+'-'+scaling.value+'.png'
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
      });
    }

    function readRecord(){
      store.dispatch('officer/publicphoto',{id:props.record.id}).then( res => {
        savedOfficialCardBase64.value = res.data.photo != undefined && res.data.photo != "" && res.data.photo.length > 0 ? res.data.photo : null 
      }).catch( err => {
        console.log( err )
      })
    }

    // function getPublicCardUrl(record){
    //   // return window.location.origin+'/#/officer/card/'+record.id
    //   return 'https://hr.ocm.gov.kh/#/officer/card/'+record.public_key
    // }

    function initial(){
      readRecord()
    }

    return {
      /**
       * Variables
       */
      rules ,
      organizations ,
      positions , 
      userCountesies ,
      getPublicCardUrl ,
      /**
       * Functions
       */
      initial ,
      clearRecord ,
      maskOrEscClick ,
      ocmLogoUrl ,
      blurBackground ,
      blurBackgroundZ  ,
      officerCode ,
      dateFormat ,
      royalstamp ,
      saveOfficialCard ,
      savedOfficialCardBase64 ,
      qrPopup,
      getOfficerPublicUrl,
      showQrLinkPopup,
      closeQrPopup,
      getDate ,
      getPrintCardUrl,
      getKhmerFullName,
      getEnglishFullName,
      getOrganizationName,
      getPositionName,
      getOfficerPhotoSrc,
      setPhotoFallback
    }
  }
}
</script>
<style scoped >
  .official-card * {
    font-size: 0.5rem;
  }

  .qr-touch-zone {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 2px;
    background: #ffffff;
    cursor: pointer;
    transition: 0.2s ease;
  }

  .qr-touch-zone:hover,
  .qr-touch-zone:focus-visible {
    border-color: #60a5fa;
    box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
    outline: none;
  }

  .qr-popup-card {
    width: min(92vw, 620px);
    border-radius: 14px;
    padding: 10px;
  }

  .qr-popup-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 10px;
  }

  .qr-popup-title {
    font-size: 16px;
    color: #0f172a;
  }

  .qr-popup-subtitle {
    margin-top: 3px;
    font-size: 13px;
    color: #64748b;
  }

  .qr-popup-close {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 13px;
    line-height: 1;
    padding: 8px 12px;
    cursor: pointer;
  }

  .qr-popup-body {
    padding-top: 12px;
  }

  .qr-popup-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .qr-popup-photo {
    width: 72px;
    height: 92px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
  }

  .qr-popup-profile-copy {
    min-width: 0;
  }

  .qr-popup-officer-name {
    font-size: 16px;
    color: #0f172a;
    margin-bottom: 4px;
  }

  .qr-popup-officer-org {
    font-size: 13px;
    color: #475569;
    margin-bottom: 0;
    word-break: break-word;
  }

  .qr-popup-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
  }

  .qr-popup-info-item {
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #f8fafc;
    padding: 9px 10px;
  }

  .qr-popup-info-item-full {
    grid-column: 1 / -1;
  }

  .qr-popup-label {
    font-size: 12px;
    color: #334155;
    margin-bottom: 3px;
  }

  .qr-popup-value {
    font-size: 13px;
    color: #0f172a;
    line-height: 1.45;
    word-break: break-word;
  }

  @media (max-width: 640px) {
    .qr-popup-info-grid {
      grid-template-columns: 1fr;
    }
  }

  .image {
    border-radius: 0.125rem;
    width: 100%;
    flex: 0 0 auto;
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
    background: #ffffff;
    margin-bottom: 0;
  }
</style>
