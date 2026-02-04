<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick" :on-after-enter="initial" transform-origin="center">
        <n-card class="w-10/12 sm:w-3/4 md:w-8/12 lg:w-3/5 xl:w-7/12" title="បន្ថែមមន្ត្រីគ្មានអត្តលេខ" :bordered="false" size="small">
          <template #header-extra>
            <n-button type="success" @click="create()" >
              <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
              </template>
              រក្សាទុក
            </n-button>
          </template>
          <!-- Form edit account -->
          <div class="crud-create-form w-full border-t">
            <div class=" mx-auto p-4 flex-wrap">
              <div class="crud-form-panel w-full flex flex-wrap ">
                <!-- :rules="rules" -->
                <n-form v-if="record!=null" 
                  class="w-full text-left font-btb text-lg flex flex-wrap" 
                  :label-width="80"
                  :model="record"
                  size="large"
                  ref="formRef"
                >
                  <n-form-item label="គោត្តនាម" path="lastname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.lastname" placeholder="គោត្តនាម" />
                  </n-form-item>
                  <n-form-item label="នាមខ្លួន" path="firstname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.firstname" placeholder="នាមខ្លួន" />
                  </n-form-item>
                  <n-form-item label="គោត្តនាម (ជាអក្សរពុម្ភឡាតាំង)" path="enlastname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.enlastname" placeholder="គោត្តនាម" />
                  </n-form-item>
                  <n-form-item label="នាមខ្លួន (ជាអក្សរពុម្ភឡាតាំង)" path="enfirstname" class="w-6/12 p-1" >
                    <n-input v-model:value="record.people.enfirstname" placeholder="នាមខ្លួន" />
                  </n-form-item>
                  <n-form-item label="ងារ" path="officer_countesy" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedCountesies"
                      filterable
                      placeholder="សូមជ្រើសរើសងារ"
                      :options="countesies"
                      multiple
                    />
                  </n-form-item>
                  <n-form-item label="ថ្ងៃខែឆ្នាំកំណើត" path="dob" class="w-4/12 p-1" >
                    <n-date-picker v-model:value="dob" type="date" format="dd-MM-yyyy" placeholder="ថ្ងៃខែឆ្នាំកំណើត" class="w-full" />
                  </n-form-item>
                  <n-form-item label="ភេទ" path="gender" class="w-3/12 p-1 " >
                    <n-radio-group name="gender" v-model:value="record.people.gender" class="mx-auto" >
                      <n-space>
                        <n-radio
                          v-for="gender in [{label:'ស្រី',value:0},{label:'ប្រុស',value:1}]"
                          :key="gender.value"
                          :value="gender.value"
                          :label="gender.label"
                        />
                      </n-space>
                    </n-radio-group>
                  </n-form-item>
                  <n-form-item label="រៀបអាពាហ៍ពិពាហ៍" path="marry" class="w-5/12 p-1" >
                    <n-radio-group name="marry" v-model:value="record.people.marry_status" class="mx-auto" >
                      <n-space>
                        <n-radio
                        v-for="status in [{label:'នៅលីវ',value:'single'},{label:'រៀបអាពាហ៍ពិពាហ៍',value:'married'},{label:'លះលែង',value:'divorced'}]"
                        :key="status.value"
                        :value="status.value"
                        :label="status.label"
                        />
                      </n-space>
                    </n-radio-group>
                  </n-form-item>
                  <n-form-item label="អ៉ីមែល" path="email" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.email" placeholder="អ៉ីមែល" />
                  </n-form-item>
                  <n-form-item label="ទូរសព្ទផ្ទាល់ខ្លួន" path="mobile_phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.mobile_phone" placeholder="ទូរសព្ទផ្ទាល់ខ្លួន" />
                  </n-form-item>
                  <n-form-item label="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" path="nid" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.nid" placeholder="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" />
                  </n-form-item>
                  <n-form-item label="ទូរសព្ទការិយាល័យ" path="phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.people.office_phone" placeholder="ទូរសព្ទការិយាល័យ" />
                  </n-form-item>
                  <div class="w-full mr-1 border-b border-gray-100  mb-2 " >អាសយដ្ឋាន</div>
                  <n-form-item label="ខេត្ត ក្រុង" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.address_province_id"
                      placeholder="ខេត្ត ក្រុង" 
                      filterable
                      clearable
                      :options="provinceOptions"
                      @update:value="setProvince()" >
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ស្រុក ខណ្ឌ" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.address_district_id"
                      placeholder="ស្រុក ខណ្ឌ" 
                      filterable
                      clearable
                      :options="districtOptions"
                      @update:value="setDistrict()">
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ឃុំ សង្កាត់" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.address_commune_id"
                      placeholder="ឃុំ សង្កាត់" 
                      filterable
                      clearable
                      :options="communeOptions"
                      @update:value="setCommune()">
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ភូមិ" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.address_village_id"
                      placeholder="ភូមិ" 
                      filterable
                      clearable
                      :options="villageOptions"
                      @update:value="setVillage()">
                    </n-select>
                  </n-form-item>
                  <n-form-item-row label="ព័ត៌មានផ្សេងៗពីអាសយដ្ឋាន" >
                    <n-input 
                      placeholder="ព័ត៌មានផ្សេងៗពីអាសយដ្ឋាន" 
                      class="text-left" 
                      v-model:value="record.people.address" 
                      type="textarea" show-count maxlength="5000" />
                  </n-form-item-row>
                  <div class="w-full mr-1 border-b border-gray-100  mb-2 " >ទីកន្លែងកំណើត</div>
                  <n-form-item label="ខេត្ត ក្រុង" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.pob_province_id"
                      placeholder="ខេត្ត ក្រុង" 
                      filterable
                      clearable
                      :options="pobProvinceOptions"
                      @update:value="pobSetProvince()" >
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ស្រុក ខណ្ឌ" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.pob_district_id"
                      placeholder="ស្រុក ខណ្ឌ" 
                      filterable
                      clearable
                      :options="pobDistrictOptions"
                      @update:value="pobSetDistrict()">
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ឃុំ សង្កាត់" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.pob_commune_id"
                      placeholder="ឃុំ សង្កាត់" 
                      filterable
                      clearable
                      :options="pobCommuneOptions"
                      @update:value="pobSetCommune()">
                    </n-select>
                  </n-form-item>
                  <n-form-item label="ភូមិ" class="w-1/5 p-1" >
                    <n-select 
                      v-model:value="record.people.pob_village_id"
                      placeholder="ភូមិ" 
                      filterable
                      clearable
                      :options="pobVillageOptions"
                      @update:value="pobSetVillage()">
                    </n-select>
                  </n-form-item>
                  <n-form-item-row label="ព័ត៌មានផ្សេងៗពីទីកន្លែងកំណើត" >
                    <n-input placeholder="ព័ត៌មានផ្សេងៗពីទីកន្លែងកំណើត" class="text-left" 
                    v-model:value="record.people.pob" 
                    type="textarea" show-count maxlength="5000" />
                  </n-form-item-row>
                  <!-- <div class="w-full mt-2 mb-4 py-1 border-b border-gray-200 " >ព័ត៌មានពីក្រសួង ឬ ស្ថាប័នកំពុងនៅ៖</div> -->
                  <div class="w-full mt-2 mb-4 py-1 border-b border-gray-200 " >ព័ត៌មានក្នុងអង្គភាព</div>
                  <!-- <n-form-item label="អត្តលេខ" path="code" class="w-6/12 p-1" >
                    <n-input v-model:value="record.officer_code" placeholder="អត្តលេខ" />
                  </n-form-item> -->
                  <!-- <n-form-item label="ថ្ងៃខែឆ្នាំចូលពេញសិទ្ធិ (តាំងស៊ុប)" path="officer_dob" class="w-6/12 p-1" >
                    <n-date-picker v-model:value="officer_dob" type="date" placeholder="ថ្ងៃខែឆ្នាំកំណើត" class="w-full" />
                  </n-form-item> -->
                  <n-form-item label="ប្រភេទមន្ត្រី" class="w-full p-1" >
                    <n-radio-group v-model:value="record.additional_officer_type" name="radiogroup">
                      <n-space>
                        <n-radio
                          v-for="officerType in [
                            {
                              value : 'politician' ,
                              label: 'មន្ត្រីនយោបាយ'
                            },
                            // {
                            //   value : 'admin_official' ,
                            //   label: 'មន្ត្រីមុខងារសាធារណៈ'
                            // },
                            {
                              value : 'admin_unofficial' ,
                              label: 'មន្ត្រីជាប់កិច្ចសន្យា'
                            },
                            {
                              value : 'contracted_officer' ,
                              label: 'មន្ត្រីផ្អែកលើកិច្ចព្រមព្រៀងការងារ'
                            }
                          ]"
                          :key="officerType.value"
                          :value="officerType.value"
                          :label="officerType.label"
                        />
                      </n-space>
                    </n-radio-group>
                  </n-form-item>
                  <n-form-item label="ទូរសព្ទ" path="officer_phone" class="w-1/2 p-1" >
                    <n-input v-model:value="record.officer_phone" placeholder="ទូរសព្ទ" />
                  </n-form-item>
                  <!-- <div class="w-full" >
                    <div class="w-full border-b border-gray-200 py-2 mb-2 " >ក្របខ័ណ្ឌ</div>
                    <div class="flex flex-wrap " >
                      <n-form-item label="អង្គ" class="w-1/5 p-1" >
                        <n-select
                          v-model:value="selectedAnk"
                          filterable
                          placeholder="អង្គ"
                          :options="visayOptions"
                          @update:value="updateKrobKhan"
                        />
                      </n-form-item>
                      <n-form-item label="ប្រភេទក្របខ័ណ្ឌ" class="w-1/5 p-1" >
                        <n-select
                          v-model:value="selectedKrobKhan"
                          filterable
                          placeholder="ប្រភេទក្របខ័ណ្ឌ"
                          :options="krobKhanOptions"
                          @update:value="updateRank"
                        />
                      </n-form-item>
                      <n-form-item label="ឋានន្តរស័ក្ដិ" class="w-1/5 p-1" >
                        <n-select
                          v-model:value="selectedRank"
                          filterable
                          placeholder="ឋានន្តរស័ក្ដិ"
                          :options="rankOptions"
                          @update:value="updateThnaks"
                        />
                      </n-form-item>
                      <n-form-item label="ថ្នាក់" class="w-1/5 p-1" >
                        <n-select
                          v-model:value="selectedThnak"
                          filterable
                          placeholder="ថ្នាក់"
                          :options="thnakOptions"
                        />
                      </n-form-item>
                    </div>
                  </div> -->
                  <n-form-item label="លេខលិខិតឆ្លងដែន" path="officer_passport" class="w-1/2 p-1" >
                    <n-input v-model:value="record.officer_passport" placeholder="លេខលិខិតឆ្លងដែន" />
                  </n-form-item>
                  <n-form-item label="អ៉ីមែល" path="officer_email" class="w-full p-1" >
                    <n-input v-model:value="record.officer_email" placeholder="អ៉ីមែល" />
                  </n-form-item>
                  <!-- <n-form-item label="អង្គភាព" path="officer_organization" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedOrganization"
                      filterable
                      placeholder="សូមជ្រើសរើសអង្គភាព"
                      :options="organizations"
                    />
                  </n-form-item>
                   -->
                  <n-form-item label="មុខតំណែង" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedOrganizationStructurePosition"
                      filterable
                      placeholder="សូមជ្រើសរើសមុខតំណែង"
                      :options="organizationStructurePositions"
                    />
                  </n-form-item>
                  <!-- <n-form-item label="ឋានៈស្មើ" path="officer_position" class="w-full mb-4" >
                    <n-select
                      v-model:value="selectedUnofficialPosition"
                      filterable
                      placeholder="សូមជ្រើសរើសឋានៈស្មើ"
                      :options="positions"
                    />
                  </n-form-item> -->
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
          people: {
            firstname: '' ,
            lastname: '' ,
            email: '' ,
            gender: '' ,
            mobile_phone: '' ,
            office_phone: '' ,
            dob: null ,
            nid: '' ,
            marry_status: null ,
            address : null ,
            pob : null
          },     
          orgainzation_id: null ,
          position_id: null ,
          countesy_id: null ,
          officer_dob: null ,
          officer_phone: '' ,
          officer_email: '' ,
          officer_passport: ''
        })
      },
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
    var store = useStore()
    const message = useMessage()
    const notify = useNotification()

    const selectedOrganization = ref(null)
    const selectedPosition = ref(null)
    const selectedUnofficialPosition = ref(null)
    const selectedCountesies = ref([])

    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 
    const countesies = computed( () => 
      store.getters['countesy/getRecords'].map( c => ( { label: c.name , value : c.id } ) )
    ) 

    const selectedProvince = ref(null)
    const selectedDistrict = ref(null)
    const selectedCommune = ref(null)
    const selectedVillage = ref(null)
    const pobSelectedProvince = ref(null)
    const pobSelectedDistrict = ref(null)
    const pobSelectedCommune = ref(null)
    const pobSelectedVillage = ref(null)
    const provinceOptions = computed( () => {
        return store.getters['province/records'].all.length != undefined || store.getters['province/records'].all.length > 0 
          ? store.getters['province/records'].all.map( ( p ) => { return { label: p.name_kh , value : p.id } } )
          : [{ label : 'មិនមាន ខេត្ត ឬ​ ក្រុង ឡើយ' , value : null }]
    })
    const districtOptions = computed( () => {
      return selectedProvince.value != undefined && selectedProvince.value != null  && selectedProvince.value.id > 0
        ? store.getters['district/records'].all.filter( (d) => d.province_id == selectedProvince.value.id ).map( ( d ) => { return { label: d.name_kh , value : d.id } } )
        : store.getters['district/records'].all.map( ( d ) => { return { label: d.name_kh , value : d.id } } )
    })
    const communeOptions = computed( () => {
      return selectedDistrict.value != undefined && selectedDistrict.value != null  && selectedDistrict.value.id > 0
        ? store.getters['commune/records'].all.filter( (c) => c.district_id == selectedDistrict.value.id ).map( ( c ) => { return { label: c.name_kh , value : c.id } } )
        : store.getters['commune/records'].all.map( ( c ) => { return { label: c.name_kh , value : c.id } } )
    })
    const villageOptions = computed( () => {
      return selectedCommune.value != undefined && selectedCommune.value != null  && selectedCommune.value.id > 0
        ? store.getters['village/records'].all.filter( (v) => v.commune_id == selectedCommune.value.id ).map( ( v ) => { return { label: v.name_kh , value : v.id } } )
        : store.getters['village/records'].all.map( ( v ) => { return { label: v.name_kh , value : v.id } } )
    })
    const pobProvinceOptions = computed( () => {
        return store.getters['province/records'].all.length != undefined || store.getters['province/records'].all.length > 0 
          ? store.getters['province/records'].all.map( ( p ) => { return { label: p.name_kh , value : p.id } } )
          : [{ label : 'មិនមាន ខេត្ត ឬ​ ក្រុង ឡើយ' , value : null }]
    })
    const pobDistrictOptions = computed( () => {
        return pobSelectedProvince.value != undefined && pobSelectedProvince.value != null  && pobSelectedProvince.value.id > 0
        ? store.getters['district/records'].all.filter( (d) => d.province_id == pobSelectedProvince.value.id ).map( ( d ) => { return { label: d.name_kh , value : d.id } } )
        : store.getters['district/records'].all.map( ( d ) => { return { label: d.name_kh , value : d.id } } )
    })
    const pobCommuneOptions = computed( () => {
        return pobSelectedDistrict.value != undefined && pobSelectedDistrict.value != null  && pobSelectedDistrict.value.id > 0
        ? store.getters['commune/records'].all.filter( (c) => c.district_id == pobSelectedDistrict.value.id ).map( ( c ) => { return { label: c.name_kh , value : c.id } } )
        : store.getters['commune/records'].all.map( ( c ) => { return { label: c.name_kh , value : c.id } } )
    })
    const pobVillageOptions = computed( () => {
        return pobSelectedCommune.value != undefined && pobSelectedCommune.value != null  && pobSelectedCommune.value.id > 0
        ? store.getters['village/records'].all.filter( (v) => v.commune_id == pobSelectedCommune.value.id ).map( ( v ) => { return { label: v.name_kh , value : v.id } } )
        : store.getters['village/records'].all.map( ( v ) => { return { label: v.name_kh , value : v.id } } )
    })
    function setProvince(){
      selectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.address_province_id )
      selectedDistrict.value = null
      selectedCommune.value = null
      selectedVillage.value = null
      props.record.people.address_district_id = null
      props.record.people.address_commune_id = null
      props.record.people.address_village_id = null
    }

    function setDistrict(){
      selectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.address_district_id )
      selectedCommune.value = null
      selectedVillage.value = null
      props.record.people.address_commune_id = null
      props.record.people.address_village_id = null
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedDistrict.value != null && selectedDistrict.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedDistrict.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
    }

    function setCommune(){
      // selectedCommune.value = selectedDistrict.value.communes.find( d => d.id == props.record.people.address_commune_id )
      selectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.address_commune_id )
      selectedVillage.value = null
      props.record.people.address_village_id = null
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedCommune.value != null && selectedCommune.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedCommune.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
      if( selectedDistrict.value == null || ( selectedDistrict.value != null && selectedCommune.value != null && selectedCommune.value.district_id != selectedDistrict.value.id ) ){
        selectedDistrict.value = store.getters['district/records'].all.find( d => d.id == selectedCommune.value.district_id )
        props.record.people.address_district_id = selectedDistrict.value.id
      }
    }

    function setVillage(){
      // selectedVillage.value = selectedCommune.value.villages.find( d => d.id == props.record.people.address_village_id )
      selectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.address_village_id )
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedCommune.value != null && selectedVillage.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedVillage.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
      if( selectedDistrict.value == null || ( selectedDistrict.value != null && selectedVillage.value != null && selectedVillage.value.district_id != selectedDistrict.value.id ) ){
        selectedDistrict.value = store.getters['district/records'].all.find( d => d.id == selectedVillage.value.district_id )
        props.record.people.address_district_id = selectedDistrict.value.id
      }
      if( selectedCommune.value == null || ( selectedCommune.value != null && selectedVillage.value != null && selectedVillage.value.commune_id != selectedCommune.value.id ) ){
        selectedCommune.value = store.getters['commune/records'].all.find( c => c.id == selectedVillage.value.commune_id )
        props.record.people.address_commune_id = selectedCommune.value.id
      }
    }

    function pobSetProvince(){
      pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.pob_province_id )
      pobSelectedDistrict.value = null
      pobSelectedCommune.value = null
      pobSelectedVillage.value = null
      props.record.people.pob_district_id = null 
      props.record.people.pob_commune_id = null 
      props.record.people.pob_village_id = null 
    }

    function pobSetDistrict(){
      // pobSelectedDistrict.value = pobSelectedProvince.value.districts.find( d => d.id == props.record.people.pob_district_id )
      pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.pob_district_id )
      pobSelectedCommune.value = null
      pobSelectedVillage.value = null
      props.record.people.pob_commune_id = null 
      props.record.people.pob_village_id = null 
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedDistrict.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedDistrict.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
    }

    function pobSetCommune(){
      // pobSelectedCommune.value = pobSelectedDistrict.value.communes.find( d => d.id == props.record.people.pob_commune_id )
      pobSelectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.pob_commune_id )
      pobSelectedVillage.value = null
      props.record.people.pob_village_id = null 
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedCommune.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedCommune.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
      if( pobSelectedDistrict.value == null || ( pobSelectedDistrict.value != null && pobSelectedDistrict.value != null && pobSelectedCommune.value.district_id != pobSelectedDistrict.value.id ) ){
        pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == pobSelectedCommune.value.district_id )
        props.record.people.pob_district_id = pobSelectedDistrict.value.id
      }
    }

    function pobSetVillage(){
      // pobSelectedVillage.value = pobSelectedCommune.value.villages.find( d => d.id == props.record.people.pob_village_id )
      pobSelectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.pob_village_id )
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedVillage.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedVillage.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
      if( pobSelectedDistrict.value == null || ( pobSelectedDistrict.value != null && pobSelectedDistrict.value != null && pobSelectedVillage.value.district_id != pobSelectedDistrict.value.id ) ){
        pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == pobSelectedVillage.value.district_id )
        props.record.people.pob_district_id = pobSelectedDistrict.value.id
      }
      if( pobSelectedCommune.value == null || ( pobSelectedCommune.value != null && pobSelectedCommune.value != null && pobSelectedVillage.value.commune_id != pobSelectedCommune.value.id ) ){
        pobSelectedCommune.value = store.getters['commune/records'].all.find( p => p.id == pobSelectedVillage.value.commune_id )
        props.record.people.pob_commune_id = pobSelectedCommune.value.id
      }
    }
    
    const dob = ref( null )
    dob.value = props.record.people.dob != '' && props.record.people.dob != undefined
    ? (new Date( props.record.people.dob )).getTime()
    : (new Date()).getTime()

    const officer_dob = ref( null )
    officer_dob.value = props.record.officer_dob != '' && props.record.officer_dob != undefined
    ? (new Date( props.record.officer_dob )).getTime()
    : (new Date()).getTime()

    /**
     * Variables
     */    
    var rules = {
        firstname: {
          required: true,
          message: 'សូមបញ្ចូល នាម ជាភាសារខ្មែរ',
          trigger: [ 'blur']
        },
        lastname: {
          required: true,
          message: 'សូមបញ្ចូល គោត្តនាម ជាភាសារខ្មែរ',
          trigger: [ 'blur']
        },
        enfirstname: {
          required: true,
          message: 'សូមបញ្ចូល នាម ជាភាសារអង់គ្លេស',
          trigger: [ 'blur']
        },
        enlastname: {
          required: true,
          message: 'សូមបញ្ចូល គោត្តនាម ជាភាសារអង់គ្លេស',
          trigger: [ 'blur']
        },
        dob: {
          required: true,
          message: 'សូមបញ្ចូល ថ្ងែខែឆ្នាំកំណើត',
          trigger: [ 'blur']
        },
        officer_organization: {
          required: true,
          message: 'សូមជ្រើសរើសអង្គភាព',
          trigger: [ 'blur']
        },
        officer_position: {
          required: true,
          message: 'សូមជ្រើសរើសតួនាទី',
          trigger: [ 'blur']
        },
    }
    /**
     * Functions
     */
    function clearRecord( actionStatus ){
      props.record.id = 0
      props.record.people = {
        firstname: '' ,
        lastname: '' ,
        email: '' ,
        gender: '' ,
        mobile_phone: '' ,
        office_phone: '' ,
        dob: null ,
        nid: '' ,
        marry_status: null
      }
      props.record.code = '' ,
      props.record.orgainzation_id = null ,
      props.record.position_id = null ,
      props.record.countesy_id = null ,
      props.record.officer_dob = null ,
      props.record.phone = '' ,
      props.record.email = '' ,
      props.record.passport = ''
      
      props.onClose( actionStatus )
    }

    function maskOrEscClick(){
      props.record.id = 0
      props.record.people = {
        firstname: '' ,
        lastname: '' ,
        email: '' ,
        gender: '' ,
        mobile_phone: '' ,
        office_phone: '' ,
        dob: null ,
        nid: '' ,
        marry_status: null ,
      }
      props.record.code = '' ,
      props.record.orgainzation_id = null ,
      props.record.position_id = null ,
      props.record.countesy_id = null ,
      props.record.officer_dob = null ,
      props.record.phone = '' ,
      props.record.email = '' ,
      props.record.passport = ''

      props.onClose( 0 )
    }

    function create(){
      if( 
        props.record.people.lastname == "" || 
        props.record.people.firstname == "" ||
        props.record.people.enlastname == "" || 
        props.record.people.enfirstname == "" 
      ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញឈ្មោះជា ភាសារខ្មែរ និង អង់គ្លេស ឲ្យបានពេញលេញ' ,
          duration: 2000
        })
        return false
      }
      if( 
        props.record.people.mobile_phone == "" && props.record.people.email == ""
      ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញលេខទូរសព្ទ ឬ អ៉ីមែលរបស់អ្នក' ,
          duration: 2000
        })
        return false
      }
      if( 
        props.record.people.nid == ""
      ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញលេខអត្តសញ្ញាញបណ្ណ' ,
          duration: 2000
        })
        return false
      }
      if( parseInt( selectedOrganization.value ) <= 0 ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមជ្រើសរើសអង្គភាព' ,
          duration: 2000
        })
      }
      if( parseInt( selectedOrganizationStructurePosition.value) <= 0 ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមជ្រើសរើសតួនាទី' ,
          duration: 2000
        })
      }
      if( props.record.people.mobile_phone == "" && props.record.people.email == "" ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'សូមបំពេញ លេខទូរសព្ទផ្ទាល់ខ្លួន ឬ អ៉ីមែល' ,
          duration: 2000
        })
        return false
      }
      if( props.model === undefined || props.model.name == "" ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
          duration: 2000
        })
        return false
      }
      
      props.record.people.dob = dob.value != null && parseInt( dob.value ) > 0 ? dateFormat( new Date(dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" )

      store.dispatch( props.model.name+'/createNonOfficer',
        {
          'id' : props.record.id ,
          // 'officer_code' : props.record.officer_code ,
          // 'officer_dob' : officer_dob.value != null && parseInt( officer_dob.value ) > 0 ? dateFormat( new Date(officer_dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'organization_id' : selectedOrganization.value != null ? selectedOrganization.value : 0 ,
          'position_id' : selectedPosition.value != null ? selectedPosition.value : 0 ,
          'unofficial_position_id' : parseInt( selectedUnofficialPosition.value ) > 0 ? selectedUnofficialPosition.value : 0 ,
          'organization_structure_position_id' : selectedOrganizationStructurePosition.value != null ? selectedOrganizationStructurePosition.value : 0 ,
          'countesy_id' : selectedCountesies.value != null ? selectedCountesies.value[0] : 0 ,
          'officer_passport' : props.record.officer_passport ,
          'salary_rank' : props.record.salary_rank ,
          'officer_type' : props.record.officer_type ,
          'additional_officer_type' : props.record.additional_officer_type ,
          'officer_email' : props.record.officer_email ,
          'officer_phone' : props.record.officer_phone ,
          // People
          'firstname' : props.record.people.firstname ,
          'lastname' : props.record.people.lastname ,
          'enfirstname' : props.record.people.enfirstname ,
          'enlastname' : props.record.people.enlastname ,
          'gender' : props.record.people.gender ,
          'email' : props.record.people.email ,
          'mobile_phone' : props.record.people.mobile_phone ,
          'office_phone' : props.record.people.office_phone ,
          'dob' : dob.value != null ? dateFormat( new Date(dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'nid' : props.record.people.nid ,
          'passport' : props.record.people.passport ,
          'marry_status' : props.record.people.marry_status ,
          'body_condition' : parseInt( props.record.people.body_condition ),
          'body_condition_desp' : props.record.people.body_condition_desp ,
          'nationality' : props.record.people.nationality ,
          'national' : props.record.people.national ,
          'address' : props.record.people.address ,
          'address_province_id' : parseInt( props.record.people.address_province_id ) ,
          'address_district_id' : parseInt( props.record.people.address_district_id ) ,
          'address_commune_id' : parseInt( props.record.people.address_commune_id ) ,
          'address_village_id' : parseInt( props.record.people.address_village_id ) ,
          'pob' : props.record.people.pob ,
          'pob_province_id' : parseInt( props.record.people.pob_province_id ) ,
          'pob_district_id' : parseInt( props.record.people.pob_district_id ) ,
          'pob_commune_id' : parseInt( props.record.people.pob_commune_id ) ,
          'pob_village_id' : parseInt( props.record.people.pob_village_id )
        }
      // {
      //   firstname: props.record.firstname ,
      //   lastname: props.record.lastname ,
      //   gender: props.record.gender ,
      //   email: props.record.email.toLowerCase() ,
      //   mobile_phone: props.record.mobile_phone ,
      //   office_phone: props.record.office_phone ,
      //   dob: props.record.dob ,
      //   nid: props.record.nid ,
      //   marry_status: props.record.marry_status ,
      //   organizations: selectedOrganizations.value ,
      //   positions: selectedPositions.value ,
      //   countesies: selectedCountesies.value ,
      // }
      ).then( res => {
        if( res.data.ok ){
          notify.success({
            title: 'រក្សាទុកព័ត៌មាន' ,
            description: res.data.message ,
            duration: 2000
          })
          clearRecord( 1 )
        }else{
          notify.error({
            title: 'រក្សាទុកព័ត៌មាន' ,
            description: 'មានបញ្ហាក្នុងពេលរក្សាទុកព័ត៌មាន។' ,
            duration: 2000
          })
        }
      }).catch( err => {
        message.error( err )
      })
      clearRecord( 0 )
    }
    const selectedOrganizationStructurePosition = ref(null)
    const organizationStructurePositions = ref([])
    function getPositionStructures(){
      store.dispatch('organization/getOrganizationStructurePosition',{
        organization_structure_id : false
      }).then( 
        res => {
          if( res.data.ok ){
            organizationStructurePositions.value = res.data.records.filter( p => {
              return p.organizationStructure != undefined
            }).map( p => {
              return {
                label : p.organizationStructure.organization.name + ' - ' + p.position.name ,
                value : p.id
              }
            })
          }else{
            notify.info({
              title: 'អានព័ត៌មានតួនាទី' ,
              content: res.data.message
            })
          }
        }
      ).catch( err => {
        console.log( err )
      })
    }


    const anks = ref([])
    const selectedAnk = ref(null)
    function getRankStructure(){
       anks.value = store.getters['rank/records'].all
    }    
    const visayOptions = computed(()=>{
      return anks.value.length > 0
        ? (
          anks.value.map( ( v ) => { return { label: v.visay , value : v.visay } } )
        )
        : [ { label: 'មិនមានវិស័យ' , value : 0 } ]
    })
    const krobkhans = ref([])
    const selectedKrobKhan = ref(null)
    const selectedRank = ref(null)
    const ranks = ref([])
    function updateKrobKhan(){
      selectedKrobKhan.value = null
      selectedRank.value = null
      selectedThnak.value = null 
      let v = anks.value.find( ( v ) => v.visay == selectedAnk.value )
      if( v != undefined ){
        krobkhans.value = v.krobkhans
      }else{
        notify.info({
          title: 'ព័ត៌មានក្របខ័ណ្ឌ' ,
          content : 'មិនមានព័ត៌មានក្របខ័ណ្ឌក្នុងវិស័យនេះ'  ,
          duration: 2000
        })
      }
    }
    const krobKhanOptions = computed( () => {
      if( krobkhans.value.length > 0 ){
        let uniqueKrobKhans = new Array()
        for( let i in krobkhans.value ){
          if ( uniqueKrobKhans.indexOf( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name ) == -1 ){
            uniqueKrobKhans.push( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name )
          }
        }
        return uniqueKrobKhans.map( ( k ) => { return { label: k , value : k } } )
      }else{
        return [ { label: 'មិនមានក្របខ័ណ្ឌ' , value : 0 } ]
      }
    })
    const rankOptions = computed( () => {
      if( ranks.value.length > 0 ){
        return ranks.value
      }else{
        return [ { label: 'មិនមានឋានន្តរស័ក្តិ' , value : 0 } ]
      }
    })
    function updateRank(){
      selectedRank.value = null
      selectedThnak.value = null 
      ranks.value = []
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name == selectedKrobKhan.value ){
            if ( ranks.value.find( r => r.value == krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank ) == undefined ){
              ranks.value.push( 
                { 
                  label : krobkhans.value[i].rank ,
                  // label : krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank ,
                  value : krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank
                }
              )
            }
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានឋានន្តរស័ក្តិ' ,
          content : 'មិនមានព័ត៌មានឋានន្តរស័ក្តិ' ,
          duration: 2000
        })
      }
    }
    const selectedThnak = ref(null)
    const thnaks = ref({
      key: '' ,
      options: []
    })
    function updateThnaks(){
      selectedThnak.value = null 
      thnaks.value = []
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank == selectedRank.value ){
            thnaks.value.key = krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank
            thnaks.value.options = krobkhans.value[i].thnaks.map( t => { 
                return { 
                label: t.thnak , 
                // label: krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank + '.' + t.thnak , 
                value : krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name + "." + krobkhans.value[i].rank + '.' + t.thnak 
              }
            })
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានថ្នាក់' ,
          content : 'មិនមានព័ត៌មានថ្នាក់' ,
          duration: 2000
        })
      }
    }
    const thnakOptions = computed( () => {
      if( thnaks.value.options.length > 0 ){
        console.log( thnaks.value )
        return thnaks.value.options
      }else{
        return [ { label: 'មិនមានថ្នាក់' , value : 0 } ]
      }
    })

    function initial(){
      getRankStructure()
      getPositionStructures()
      // selectedOrganizations.value = [463]
      // selectedOrganizations.value = Array.isArray( props.record.organizations ) ? props.record.organizations.map( o => o.id ) : []
      // selectedPositions.value = Array.isArray( props.record.positions ) ? props.record.positions.map( o => o.id ) : []
      // selectedCountesies.value = Array.isArray( props.record.countesies ) ? props.record.countesies.map( c => c.id ) : []
    }

    return {
      /**
       * Variables
       */
      rules ,
      selectedOrganization ,
      organizations ,
      selectedPosition ,
      selectedUnofficialPosition ,
      positions ,
      selectedCountesies ,
      countesies ,
      dob ,
      officer_dob ,
      /**
       * Functions
       */
      create  ,
      initial ,
      clearRecord ,
      maskOrEscClick ,
      getPositionStructures ,
      organizationStructurePositions ,
      selectedOrganizationStructurePosition ,
      provinceOptions ,
      districtOptions ,
      communeOptions ,
      villageOptions ,
      pobProvinceOptions ,
      pobDistrictOptions ,
      pobCommuneOptions ,
      pobVillageOptions ,
      setProvince ,
      setDistrict ,
      setCommune ,
      setVillage ,
      pobSetProvince ,
      pobSetDistrict ,
      pobSetCommune ,
      pobSetVillage ,
      // 
      anks , 
      selectedAnk ,
      visayOptions ,
      krobKhanOptions ,
      selectedKrobKhan ,
      krobkhans ,
      updateKrobKhan ,
      selectedRank , 
      updateRank ,
      rankOptions ,
      selectedThnak , 
      thnaks ,
      thnakOptions ,
      updateThnaks
    }
  }
}
</script>
<style type="text/css" scoped >
  
</style>