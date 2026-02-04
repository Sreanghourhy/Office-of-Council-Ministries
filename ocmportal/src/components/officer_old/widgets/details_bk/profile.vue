<template >
    <div v-if="show" class="birth-information" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="flex flex-wrap" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 " >ព័ត៌មានមន្ត្រី</div>
                <n-scrollbar >
                    <div class="body" >
                        <div class="w-12/12 p-4 border border-gray-200 rounded-md m-4  bg-white shadow " >
                            <!-- Profile -->
                            <div class="profile-information" >
                                <div class="flex flex-wrap" >
                                    <div class="w-full pb-4  border-b border-gray-200 " >
                                    <div class="flex flex-initial" >
                                        <div class="flex-none" >
                                        <div class="w-24 overflow-hidden mx-auto bg-center bg-no-repeat bg-white bg-cover rounded border border-gray-200 p-1" >
                                            <img 
                                            class="w-full mx-auto"
                                            :src="record.image!=''? record.image : ocmLogoUrl "  />
                                        </div>
                                        </div>
                                        <div class="flex-grow flex flex-initial" >
                                        <div class="profile_information ml-4 flex-grow" >
                                            <div v-if="record.people != null && record.people != undefined" class="w-full leading-6 text-md font-moul mb-2 ">{{ record.countesy != undefined && record.countesy != null ? record.countesy.name : "" }} {{ record.people.lastname + " " + record.people.firstname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                                            <div v-if="record.code != null && record.code.length > 0" class="w-full leading-6 text-md font-moul mb-2">OCM-ORG-{{ $toKhmer( record.id ) }}</div>
                                            <div v-if="record != null && record.position != null " class="w-full leading-6 text-md mb-2 ">{{ record.position.name }}</div>
                                            <div v-if="record != null && record.organization != null " class="w-full leading-6 text-md ">{{ record.organization.name }}</div>
                                        </div>
                                        <div class="flex-none w-48" >
                                            <qrcode-vue :value="'OCM-ORG-'+record.id" :size="100" level="H" class=" mx-auto p-2 border border-gray-200 rounded" :render-as="'svg'" />
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="w-full p-4" >
                                    <n-tabs type="segment" animated>
                                        <n-tab-pane name="officer-detail" tab="ព័ត៌មានក្នុងស្ថាប័ន">
                                        <div class="py-4" >
                                            <div v-if="record.people != null && record.people != undefined" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex font-moul">{{ record.countesy != undefined && record.countesy != null ? record.countesy.name : "" }} {{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                                            <div v-if="record.code != null && record.code.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អត្តលេខ ៖ {{ $toKhmer( record.code ) }}</div>
                                            <div v-if="record != null && record.position != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">តួនាទី ៖ {{ record.position.name }}</div>
                                            <div v-if="record != null && record.organization != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អង្គភាព ៖ {{ record.organization.name }}</div>
                                        </div>
                                        </n-tab-pane>
                                        <n-tab-pane name="account-detail" tab="ព័ត៌មានគណនី">
                                        <div class="py-4" >
                                            <div v-if="record.user.username != null && record.user.username.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ឈ្មោះប្រើប្រាស់ក្នុងប្រព័ន្ធ ៖ {{ record.user.username }}</div>
                                            <div v-if="record.user.phone != null && record.user.phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ទូរស័ព្ទ ៖ {{ $toKhmer( record.user.phone ) }}</div>
                                            <div v-if="record.user.email != null && record.user.email.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">អ៊ីមែល ៖ {{ record.user.email }}</div>
                                            <div v-if="record.user.last_login != null && record.user.last_login.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ចូលចុងក្រោយ ៖ {{ $toKhmer( dateFormat( new Date( record.user.last_login ) , 'dd-mm-yyyy' ) ) }}</div>
                                            <div v-if="record.user.ip != null && record.user.ip.length > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខម៉ាស៊ីន ៖ {{ $toKhmer( record.user.ip ) }}</div>
                                            <div v-if="record.user.login_count != null && parseInt( record.user.login_count ) > 0 " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">បានចូលចំនួន ៖ {{ $toKhmer( record.user.login_count ) }}</div>
                                        </div>
                                        </n-tab-pane>
                                        <n-tab-pane name="backgroud-information" tab="ព័ត៌មានផ្ទាល់ខ្លួន">
                                        <div class="py-4" >
                                            <div v-if="record.people != null && record.people != undefined" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex font-moul">{{ record.countesy != undefined && record.countesy != null ? record.countesy.name : "" }} {{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.nid != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខអត្តសញ្ញាណបណ្ណ ៖ {{ $toKhmer( record.people.nid ) }}</div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.dob != null " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">ថ្ងៃ ខែ ឆ្នាំ កំណើត ៖ {{ $toKhmer( dateFormat( new Date(record.people.dob) , 'dd-mm-yyyy' ) ) }}</div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.mobile_phone != null && record.people.mobile_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទផ្ទាល់ខ្លួន ៖ {{ $toKhmer( record.people.mobile_phone ) }}</div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.office_phone != null && record.people.office_phone.length > 0" class="w-full mb-4 pb-2 leading-6 border-b border-gray-200">លេខទូរស័ព្ទការិយាល័យ ៖ {{ $toKhmer( record.people.office_phone ) }}</div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.people.marry_status == 'married' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                                            រៀបការរួច
                                            <svg class="w-4 h-4 text-pink-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M8 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M24 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path><path d="M26 30h-4a2 2 0 0 1-2-2v-7h2v7h4v-9h2v-6a1 1 0 0 0-1-1h-6.42L16 20l-4.58-8H5a1 1 0 0 0-1 1v6h2v9h4v-7h2v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h7.58L16 16l3.42-6H27a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2z" fill="currentColor"></path></svg>
                                            </div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.marry_status == 'single' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                                            នៅលីវ
                                            <svg class="w-4 h-4 text-blue-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 30h-4a2 2 0 0 1-2-2v-7a2 2 0 0 1-2-2v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6a2 2 0 0 1-2 2v7a2 2 0 0 1-2 2zm-5-18a.94.94 0 0 0-1 1v6h2v9h4v-9h2v-6a.94.94 0 0 0-1-1z" fill="currentColor"></path><path d="M16 9a4 4 0 1 1 4-4a4 4 0 0 1-4 4zm0-6a2 2 0 1 0 2 2a2 2 0 0 0-2-2z" fill="currentColor"></path></svg>
                                            </div>
                                            <div v-if="record != null && record.people != undefined && record.people != null && record.people.marry_status != null && record.marry_status == 'devorced' " class="w-full mb-4 pb-2 leading-6 border-b border-gray-200 flex flex-wrap ">
                                            ពោះមាយ / មេមាយ
                                            <svg class="w-4 h-4 text-blue-500 ml-4 mt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M13 12a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v1.5C2 15.554 4.088 17 7.5 17c.459 0 .893-.026 1.302-.076l-.363-.363a1.494 1.494 0 0 1-.359-.576c-.187.01-.38.015-.58.015C4.579 16 3 14.907 3 13.5V12a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v.085a1.496 1.496 0 0 1 1 1.414V12zm5 .5c0 .425-.065.822-.193 1.185l-.829-.828c.015-.115.022-.234.022-.357V12a1 1 0 0 0-1-1h-2.171a3 3 0 0 0-.594-1H16a2 2 0 0 1 2 2v.5zm-7-7a3.5 3.5 0 1 0-7 0a3.5 3.5 0 0 0 7 0zm-6 0a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0zm12 1a2.5 2.5 0 1 0-5 0a2.5 2.5 0 0 0 5 0zm-4 0a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm-1.854 11.354a.5.5 0 0 0 .708-.708L10.707 16h5.586l-1.147 1.146a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708.708L16.293 15h-5.586l1.147-1.146a.5.5 0 0 0-.708-.708l-2 2a.5.5 0 0 0 0 .708l2 2zM11.243 15h1.325h-1.325z" fill="currentColor"></path></g></svg>
                                            </div>
                                        </div>
                                        </n-tab-pane>
                                    </n-tabs>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ ព័ត៌មានមន្ត្រី</div>
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
        components: {
            Frame4Corner ,
            QrcodeVue ,
        },
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
            console.log( props.record )
            console.log( props.show )
            const birthCertificateDob = ref( new Date() )
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
                pob: '' ,
                issued_date : '' ,
                issued_location: '' ,
                signed_name : '' ,
                wedding_certificate_id : 0 ,
                pdf : ''
            })
            return {
                birthCertificate ,
                birthCertificateDob
            }
        }
    }
</script>
<style scoped >
</style>