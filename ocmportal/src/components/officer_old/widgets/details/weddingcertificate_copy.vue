<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-10" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >អាពាហ៍ពិពាហ៍
                    <div class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <n-form class="flex flex-wrap " >
                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ព័ត៌មាន អាពាហ៍ពិពាហ៍</div>
                                    <n-form-item label="លេខចុះ" >
                                        <n-input v-model:value="weddingCertificate.number" placeholder="លេខចុះ" />
                                    </n-form-item>
                                    <n-form-item label="លេខសៀវភៅ" >
                                        <n-input v-model:value="weddingCertificate.book_number" placeholder="លេខសៀវភៅ" />
                                    </n-form-item>
                                    <n-form-item label="ឆ្នាំចុះលេខ" >
                                        <n-input v-model:value="weddingCertificate.year" placeholder="ឆ្នាំចុះលេខ" />
                                    </n-form-item>
                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" >
                                        <n-date-picker v-model:value="weddingCertificateIssuedDate" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" />
                                    </n-form-item>
                                    <n-form-item label="ឈ្មោះអ្នកចុះហត្ថលេខា" >
                                        <n-input v-model:value="weddingCertificate.signed_name" placeholder="ឈ្មោះអ្នកចុះហត្ថលេខា" />
                                    </n-form-item>
                                </div>
                            </div> 

                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ទីតាំងធ្វើ លិខិតអត្រានុកុលដ្ឋាន</div>
                                    <n-form-item label="ខេត្ត ក្រុង" >
                                        <n-select 
                                            v-model:value="weddingCertificate.province_id" 
                                            placeholder="ខេត្ត ក្រុង" 
                                            filterable
                                            clearable
                                            :options="provinceOptions"
                                            @update:value="setProvince()" >
                                        </n-select>
                                    </n-form-item>
                                    <n-form-item label="ស្រុក ខណ្ឌ" >
                                        <n-select 
                                            v-model:value="weddingCertificate.district_id" 
                                            placeholder="ស្រុក ខណ្ឌ" 
                                            filterable
                                            clearable
                                            :options="districtOptions"
                                            @update:value="setDistrict()" >
                                        </n-select>
                                    </n-form-item>
                                    <n-form-item label="ឃុំ សង្កាត់" >
                                        <n-select 
                                            v-model:value="weddingCertificate.commune_id" 
                                            placeholder="ឃុំ សង្កាត់" 
                                            filterable
                                            clearable
                                            :options="communeOptions"
                                            @update:value="setCommune()" >
                                        </n-select>
                                    </n-form-item>

                                    <n-form-item-row label="ទីតាំងដែលធ្វើលិខិត" >
                                        <n-input placeholder="ទីតាំងដែលធ្វើលិខិត" class="text-left" 
                                        v-model:value="weddingCertificate.issued_location" 
                                        type="textarea" show-count maxlength="5000" />
                                    </n-form-item-row>
                                </div>
                            </div>

                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត៌មានប្ដី</div>
                                    <n-form-item label="គោត្តនាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.hushand_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                    </n-form-item>
                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.hushand_firstname" placeholder="នាម ខ្មែរ" />
                                    </n-form-item>
                                    <n-form-item label="គោត្តនាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.hushand_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                    </n-form-item>
                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.hushand_enfirstname" placeholder="នាម អង់គ្លេស" />
                                    </n-form-item>

                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.husband_profession" placeholder="មុខរបរ" />
                                    </n-form-item>

                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/3 p-1" >
                                        <n-date-picker v-model:value="husbandDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                    </n-form-item>

                                    <n-form-item label="ជនជាតិ" class="w-1/3 p-1" >
                                        <n-radio-group v-model:value="weddingCertificate.hushand_national" >
                                            <n-space>
                                                <n-radio
                                                    value="khmer"
                                                    label="ខ្មែរ"
                                                />
                                                <n-radio
                                                    value="others"
                                                    label="ផ្សេងទៀត"
                                                />
                                            </n-space>
                                        </n-radio-group>
                                    </n-form-item>

                                    <n-form-item label="សញ្ជាតិ" class="w-1/3 p-1" >
                                        <n-radio-group v-model:value="weddingCertificate.hushand_nationality" >
                                            <n-space>
                                                <n-radio
                                                    value="khmer"
                                                    label="ខ្មែរ"
                                                />
                                                <n-radio
                                                    value="others"
                                                    label="ផ្សេងទៀត"
                                                />
                                            </n-space>
                                        </n-radio-group>
                                    </n-form-item>

                                    <n-form-item-row label="អសយដ្ឋានប្រព័ន្ធ" class="w-full p-1" >
                                        <n-input placeholder="អសយដ្ឋានប្រព័ន្ធ" class="text-left" 
                                        v-model:value="weddingCertificate.husband_address" 
                                        type="textarea" show-count maxlength="5000" />
                                    </n-form-item-row>
                                </div>
                            </div>

                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត៌មានប្រព័ន្ធ</div>
                                    <n-form-item label="គោត្តនាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.wife_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                    </n-form-item>
                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.wife_firstname" placeholder="នាម ខ្មែរ" />
                                    </n-form-item>
                                    <n-form-item label="គោត្តនាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.wife_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                    </n-form-item>
                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.wife_enfirstname" placeholder="នាម អង់គ្លេស" />
                                    </n-form-item>

                                    <n-form-item label="នាម" class="w-1/2 p-1" >
                                        <n-input v-model:value="weddingCertificate.wife_profession" placeholder="មុខរបរ" />
                                    </n-form-item>

                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/3 p-1" >
                                        <n-date-picker v-model:value="wifeDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                    </n-form-item>

                                    <n-form-item label="ជនជាតិ" class="w-1/3 p-1" >
                                        <n-radio-group v-model:value="weddingCertificate.wife_national" name="gender">
                                            <n-space>
                                                <n-radio
                                                    value="khmer"
                                                    label="ខ្មែរ"
                                                />
                                                <n-radio
                                                    value="others"
                                                    label="ផ្សេងទៀត"
                                                />
                                            </n-space>
                                        </n-radio-group>
                                    </n-form-item>

                                    <n-form-item label="សញ្ជាតិ" class="w-1/3 p-1" >
                                        <n-radio-group v-model:value="weddingCertificate.wife_nationality" name="gender">
                                            <n-space>
                                                <n-radio
                                                    value="khmer"
                                                    label="ខ្មែរ"
                                                />
                                                <n-radio
                                                    value="others"
                                                    label="ផ្សេងទៀត"
                                                />
                                            </n-space>
                                        </n-radio-group>
                                    </n-form-item>

                                    <n-form-item-row label="អសយដ្ឋានប្រព័ន្ធ" class="w-full p-1" >
                                        <n-input placeholder="អសយដ្ឋានប្រព័ន្ធ" class="text-left" 
                                        v-model:value="weddingCertificate.wife_address" 
                                        type="textarea" show-count maxlength="5000" />
                                    </n-form-item-row>
                                </div>
                            </div>

                        </n-form>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ អាពាហ៍ពិពាហ៍</div>
        </Transition>
    </div>    
</template>
<script >
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

import Frame4Corner from '@components/widgets/frame/corner4.vue'
import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from '@assets/logo.svg'
import dateFormat from 'dateformat'
    export default {
        components: {},
        props: {
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
            },
            show: {
                type: Boolean ,
                default: false
            },
            onClose: {
                type: Function
            },
        },
        setup(props){
            const weddingCertificateIssuedDate = ref( new Date().getTime() )
            const husbandDateOfBirth = ref( new Date().getTime() )
            const wifeDateOfBirth = ref( new Date().getTime() )
            const weddingCertificate = reactive({
                husband_id : 0 ,
                wife_id : 0 ,
                wedding_number : '' ,
                book_number : '' ,
                year : '' ,
                province_id : 0 ,
                district_id : 0 ,
                commune_id : 0 ,
                issued_location : '' ,
                issued_date : '' ,
                signed_name : '' ,

                // Husband
                husband_firstname: '' ,
                husband_lastname: '' ,
                husband_enfirstname: '' ,
                husband_enlastname:'' ,
                husband_dob: '' ,
                husband_profession : '' ,
                husband_nationality: '' ,
                husband_national : '' ,
                husband_address : '' ,

                // Wife
                wife_firstname: '' ,
                wife_lastname: '' ,
                wife_enfirstname: '' ,
                wife_enlastname:'' ,
                wife_dob: '' ,
                wife_profession : '' ,
                wife_nationality: '' ,
                wife_national : '' ,
                wife_address : '' ,

            })


            const selectedProvince = ref(null)
            const selectedDistrict = ref(null)
            const selectedCommune = ref(null)
            const provinceOptions = computed( () => {
                return store.getters['province/records'].all.map( ( p ) => { return { label: p.name_kh , value : p.id } } )
            })
            const districtOptions = computed( () => {
                return selectedProvince != undefined && selectedProvince.value != undefined && selectedProvince.value != null 
                    ? selectedProvince.value.districts.map( ( d ) => { return { label: d.name_kh , value : d.id } } )
                    : [{ label : 'សូមជ្រើសរើស ខេត្ត ឬ ក្រុង ជាមុនសិន' , value : null }]
            })
            const communeOptions = computed( () => {
                return selectedDistrict != undefined && selectedDistrict.value != undefined && selectedDistrict.value != null 
                    ? selectedDistrict.value.communes.map( ( c ) => { return { label: c.name_kh , value : c.id } } )
                    : [{ label : 'សូមជ្រើសរើស ឃុំ ឬ សង្កាត់ ជាមុនសិន' , value : null }]
            })

            function setProvince(){
                selectedProvince.value = store.getters['province/records'].all.find( p => p.id == birthCertificate.province_id )
                selectedDistrict.value = null
                birthCertificate.district_id = null
            }

            function setDistrict(){
                selectedDistrict.value = selectedProvince.value.districts.find( d => d.id == birthCertificate.district_id )
                selectedCommune.value = null
                birthCertificate.commune_id = null
            }

            function setCommune(){
                selectedCommune.value = selectedDistrict.value.communes.find( d => d.id == birthCertificate.commune_id )
            }

            return {
                weddingCertificate ,
                weddingCertificateIssuedDate ,
                husbandDateOfBirth ,
                wifeDateOfBirth  ,
                setProvince ,
                setDistrict ,
                setCommune ,
                provinceOptions ,
                districtOptions ,
                communeOptions
            } 
        }
    }
</script>
<style scoped >
</style>