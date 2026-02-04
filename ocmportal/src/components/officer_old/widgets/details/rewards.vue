<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-10" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >រង្វាន់ និងការលើកទឹកចិត្ត
                    <div class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <n-form class="flex flex-wrap" >
                            <div class="w-full p-4 border border-gray-200 rounded-md m-4  bg-white shadow " >
                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ព័ត៌មាន រង្វាន់ និងការលើកទឹកចិត្ត</div>
                                
                            </div> 
                        </n-form>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ រង្វាន់ និងការលើកទឹកចិត្</div>
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