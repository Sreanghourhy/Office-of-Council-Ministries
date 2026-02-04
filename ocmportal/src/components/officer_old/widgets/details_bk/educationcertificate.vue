<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-10" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >កម្រិតការសិក្សារ
                    <div class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <n-form class="flex flex-wrap " >
                            <div class="w-full p-4 border border-gray-200 rounded-md m-4  bg-white shadow " >
                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ព័ត៌មាន កម្រិតការសិក្សារ</div>
                                <n-form-item label="កម្រឹតសញ្ញាបត្រ" >
                                    <n-radio-group v-model:value="educationCertificate.certificate_level" name="certificate_level">
                                        <n-space>
                                            <n-radio
                                                v-for="(level , index) in cerfiticate_levels"
                                                :key="index"
                                                :value="level.value"
                                                :label="level.label" />
                                        </n-space>
                                    </n-radio-group>
                                </n-form-item>
                                <n-form-item label="ឈ្មោះជំនាញ" >
                                    <n-input v-model:value="educationCertificate.field_name" placeholder="ឈ្មោះជំនាញ" />
                                </n-form-item>
                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចូលរៀន" >
                                    <n-date-picker v-model:value="educationCertificateStart" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" />
                                </n-form-item>
                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ បញ្ចប់" >
                                    <n-date-picker v-model:value="educationCertificateEnd" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" />
                                </n-form-item>
                                <n-form-item label="ឈ្មោះគ្រឹះស្ថានសិក្សារ" >
                                    <n-input v-model:value="educationCertificate.place_name" placeholder="ឈ្មោះគ្រឹះស្ថានសិក្សារ" />
                                </n-form-item>
                                <n-form-item label="ទីតាំនៃគ្រឹះស្ថានសិក្សារ" >
                                    <n-input v-model:value="educationCertificate.location" placeholder="ទីតាំនៃគ្រឹះស្ថានសិក្សារ" 
                                        class="text-left" 
                                        type="textarea" show-count maxlength="5000" />
                                </n-form-item>
                                
                            </div> 
                        </n-form>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ កម្រិតការសិក្សារ</div>
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
            const educationCertificateStart = ref( new Date().getTime() )
            const educationCertificateEnd = ref( new Date().getTime() )
            const educationCertificate = reactive({
                people_id : props.record.id ,
                field_name : '' ,
                certificate_group_id : 0 ,
                start_date : '' ,
                end_date : '' ,
                location : '' ,
                place_name : ''
            })

            const cerfiticate_levels = ref([
                {
                    label: 'បឋមភូមិ' , 
                    value: 'grade_9'
                },
                {
                    label: 'ទុតិយភូមិ' , 
                    value: 'grade_12'
                },
                {
                    label: 'បរិញ្ញាបត្ររង' , 
                    value: 'associate_bachelor'
                },
                {
                    label: 'បរិញ្ញាបត្រ' , 
                    value: 'bachelor'
                },
                {
                    label: 'អនុបណ្ឌិត' , 
                    value: 'master'
                },
                {
                    label: 'បណ្ឌិត វិទ្យាសាស្ត្រ' , 
                    value: 'doctorage'
                },
                {
                    label: 'បណ្ឌិត ទស្សនវិទ្យា' , 
                    value: 'doctor_of_pholosophy'
                },
                
            ])

            return {
                educationCertificateStart ,
                educationCertificateEnd ,
                educationCertificate ,
                cerfiticate_levels
            }
        }
    }
</script>
<style scoped >
</style>