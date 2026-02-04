<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-10" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >អត្រានុកុលដ្ឋាន
                    <div class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <n-form class="flex flex-wrap " >
                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >លេខសៀវភៅ អត្រានុកុលដ្ឋាន</div>
                                    <n-form-item label="លេខចុះ" >
                                        <n-input v-model:value="birthCertificate.birth_number" placeholder="លេខចុះ" />
                                    </n-form-item>
                                    <n-form-item label="លេខសៀវភៅ" >
                                        <n-input v-model:value="birthCertificate.book_number" placeholder="លេខសៀវភៅ" />
                                    </n-form-item>
                                    <n-form-item label="ឆ្នាំចុះលេខ" >
                                        <n-input v-model:value="birthCertificate.year" placeholder="ឆ្នាំចុះលេខ" />
                                    </n-form-item>
                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" >
                                        <n-date-picker v-model:value="birthCertificateIssuedDate" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" />
                                    </n-form-item>
                                    <n-form-item label="ឈ្មោះអ្នកចុះហត្ថលេខា" >
                                        <n-input v-model:value="birthCertificate.signed_name" placeholder="ឈ្មោះអ្នកចុះហត្ថលេខា" />
                                    </n-form-item>
                                </div>
                            </div> 

                            <div class="w-1/2 p-2 " >
                                <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg " >
                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ទីតាំងធ្វើ លិខិតអត្រានុកុលដ្ឋាន</div>
                                    <n-form-item label="ខេត្ត ក្រុង" >
                                        <n-select 
                                            v-model:value="birthCertificate.province_id" 
                                            placeholder="ខេត្ត ក្រុង" 
                                            :options="[
                                                { 
                                                    label: 'ភ្នំពេញ' , 
                                                    value: 1
                                                }
                                            ]">
                                        </n-select>
                                    </n-form-item>
                                    <n-form-item label="ស្រុក ខណ្ឌ" >
                                        <n-select 
                                            v-model:value="birthCertificate.district_id" 
                                            placeholder="ស្រុក ខណ្ឌ" 
                                            :options="[
                                                { 
                                                    label: 'សែនសុខ' , 
                                                    value: 1
                                                }
                                            ]">
                                        </n-select>
                                    </n-form-item>
                                    <n-form-item label="ឃុំ សង្កាត់" >
                                        <n-select 
                                            v-model:value="birthCertificate.commune_id" 
                                            placeholder="ឃុំ សង្កាត់" 
                                            :options="[
                                                { 
                                                    label: 'ទឺកថ្លា' , 
                                                    value: 1
                                                }
                                            ]">
                                        </n-select>
                                    </n-form-item>

                                    <n-form-item-row label="ទីតាំងដែលធ្វើលិខិត" >
                                        <n-input placeholder="ទីតាំងដែលធ្វើលិខិត" class="text-left" 
                                        v-model:value="birthCertificate.issued_location" 
                                        type="textarea" show-count maxlength="5000" />
                                    </n-form-item-row>
                                </div>
                            </div>

                            <div class="w-full p-4 border border-gray-200 rounded-md m-4 flex flex-wrap bg-white shadow " >
                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មានសាមីខ្លួន</div>
                                <n-form-item label="គោត្តនាម" class="w-1/2 p-4" >
                                    <n-input v-model:value="birthCertificate.lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                </n-form-item>
                                <n-form-item label="នាម" class="w-1/2 p-4" >
                                    <n-input v-model:value="birthCertificate.firstname" placeholder="នាម ខ្មែរ" />
                                </n-form-item>
                                <n-form-item label="គោត្តនាម" class="w-1/2 p-4" >
                                    <n-input v-model:value="birthCertificate.enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                </n-form-item>
                                <n-form-item label="នាម" class="w-1/2 p-4" >
                                    <n-input v-model:value="birthCertificate.enfirstname" placeholder="នាម អង់គ្លេស" />
                                </n-form-item>

                                <n-form-item label="ភេទ" class="w-1/2 p-4" >
                                    <n-radio-group v-model:value="birthCertificate.gender" name="gender">
                                        <n-space>
                                            <n-radio
                                                value="male"
                                                label="ប្រុស"
                                            />
                                            <n-radio
                                                value="female"
                                                label="ស្រី"
                                            />
                                            <n-radio
                                                value="others"
                                                label="ផ្សេងទៀត"
                                            />
                                        </n-space>
                                    </n-radio-group>
                                </n-form-item>

                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-4" >
                                    <n-date-picker v-model:value="birthCertificateDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                </n-form-item>

                                <n-form-item label="ជនជាតិ" class="w-1/2 p-4" >
                                    <n-radio-group v-model:value="birthCertificate.national" name="gender">
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

                                <n-form-item label="សញ្ជាតិ" class="w-1/2 p-4" >
                                    <n-radio-group v-model:value="birthCertificate.nationality" name="gender">
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

                                <n-form-item-row label="ទីកន្លែងកំណើត" class="w-full p-4" >
                                    <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                                    v-model:value="birthCertificate.pob" 
                                    type="textarea" show-count maxlength="5000" />
                                </n-form-item-row>

                                <n-form-item label="លេខសំបុត្រអាពាហ៍ពិពាហ៍" class="w-full p-4" >
                                    <n-input v-model:value="birthCertificate.wedding_number" placeholder="លេខសំបុត្រអាពាហ៍ពិពាហ៍" class="w-full" />
                                </n-form-item>
                                
                            </div>

                        </n-form>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ សំបុត្រកណើត និង សំបុត្របញ្ជាក់កំណើត </div>
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
            const birthCertificateDob = ref( new Date().getTime() )
            const birthCertificateIssuedDate = ref( new Date().getTime() )
            const birthCertificate = reactive({
                people_id : props.record.id ,
                birth_number : null ,
                book_number : null ,
                year : null ,
                province_id : null ,
                district_id : null ,
                commune_id : null ,
                firstname : '' ,
                lastname : '' ,
                enfirstname : '' ,
                enlastname : '' ,
                gender : '' ,
                dob: '' ,
                nationality: '' ,
                national: '' ,
                pob: '' ,
                issued_date : '' ,
                issued_location: '' ,
                signed_name : '' ,
                wedding_certificate_id : 0 ,
                pdf : ''
            })
            return {
                birthCertificate ,
                birthCertificateDob ,
                birthCertificateIssuedDate
            }
        }
    }
</script>
<style scoped >
</style>