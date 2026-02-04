<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-10" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >លិខិតឆ្លងដែន
                    <div class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <n-form class="flex flex-wrap " >
                            <div class="w-full p-4 border border-gray-200 rounded-md m-4  bg-white shadow flex flex-wrap " >
                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ព័ត៌មាន លិខិតឆ្លងដែន</div>
                                <n-form-item label="លេខសម្គាល់" class="w-1/4 p-1" >
                                    <n-input v-model:value="passportCertificate.number" placeholder="លេខសម្គាល់" class="w-full" />
                                </n-form-item>
                                <n-form-item label="លេខកូត" class="w-1/4 p-1" >
                                    <n-input v-model:value="passportCertificate.serial_number" placeholder="លេខកូត" />
                                </n-form-item>
                                <n-form-item label="ថ្ងៃចាប់ផ្ដើមសពុលភាព" class="w-1/4 p-4" >
                                    <n-date-picker v-model:value="passportCertificateStart" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃចាប់ផ្ដើមសពុលភាព" />
                                </n-form-item>
                                <n-form-item label="ថ្ងៃអស់សពុលភាព" class="w-1/4 p-4" >
                                    <n-date-picker v-model:value="passportCertificateEnd" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃអស់សពុលភាព" />
                                </n-form-item>
                                <n-form-item label="កំណត់សម្គាល់ លើផ្ទៃមុខ" class="w-1/2 p-1" >
                                    <n-input v-model:value="passportCertificate.distinguishing_mark" placeholder="កំណត់សម្គាល់" class="w-full" />
                                </n-form-item>
                                <n-form-item label="មុខរបរ" class="w-1/2 p-1" >
                                    <n-input v-model:value="passportCertificate.profession" placeholder="មុខរបរ" class="w-full" />
                                </n-form-item>
                                <n-form-item label="ប្រភេទ" class="w-1/2 p-1" >
                                    <n-radio-group v-model:value="passportCertificate.type" name="gender">
                                        <n-space>
                                            <n-radio
                                                value="government"
                                                label="រដ្ឋាភិបាល"
                                            />
                                            <n-radio
                                                value="normal"
                                                label="ប្រជាជន"
                                            />
                                        </n-space>
                                    </n-radio-group>
                                </n-form-item>
                                <!-- <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-4" >
                                    <n-date-picker v-model:value="passportCertificateDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                </n-form-item> -->

                                <n-form-item label="ទំនាក់ទំនងពេលអាសន្ន" class="w-full p-1" >
                                    <n-input v-model:value="passportCertificate.emergency_contact_person" placeholder="ទំនាក់ទំនងពេលអាសន្ន" class="w-full text-left" 
                                    type="textarea" show-count maxlength="5000" />
                                </n-form-item>
                                <n-form-item-row label="ទីកន្លែងកំណើត" class="w-full p-1" >
                                    <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                                    v-model:value="passportCertificate.pob" 
                                    type="textarea" show-count maxlength="5000" />
                                </n-form-item-row>
                                <n-form-item label="អសយដ្ឋាន" class="w-full p-1" >
                                    <n-input v-model:value="passportCertificate.address" placeholder="អសយដ្ឋាន" class="w-full text-left" 
                                    type="textarea" show-count maxlength="5000" />
                                </n-form-item>
                                <!-- <n-form-item label="កំពស់" class="w-full p-4" >
                                    <n-input v-model:value="passportCertificate.height" placeholder="កំពស់" class="w-full" />
                                </n-form-item> -->
                                <!-- <n-form-item label="សញ្ជាតិ" class="w-1/2 p-1" >
                                    <n-radio-group v-model:value="passportCertificate.nationality" name="gender">
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
                                <n-form-item label="ភេទ" class="w-1/2 p-4" >
                                    <n-radio-group v-model:value="passportCertificate.gender" name="gender">
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
                                </n-form-item> -->
                            </div> 
                        </n-form>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ លិខិតឆ្លងដែន</div>
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
            const passportCertificateStart = ref( new Date().getTime() )
            const passportCertificateEnd = ref( new Date().getTime() )
            const passportCertificateDob = ref( new Date().getTime() )
            const passportCertificate = reactive({
                people_id : props.record.id ,
                number : '' ,
                profession : '' ,
                height: '' , 
                distinguishing_mark: '' ,
                emergency_contact_person: '' ,
                address : '' ,
                type: '' ,
                country_code : '' ,
                nationality: '' ,
                dob: '' ,
                gender: '' ,
                start_date : '' ,
                end_date : '' ,
                pob: '' ,
                serial_number : ''
            })

            return {
                passportCertificateStart ,
                passportCertificateEnd ,
                passportCertificateDob ,
                passportCertificate
            }
        }
    }
</script>
<style scoped >
</style>