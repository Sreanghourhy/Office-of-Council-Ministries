<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-0" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >កម្រិតការសិក្សារ
                    <div @click="formToggler" class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <div v-for="(certificate , index) in certificates" :key="index" class="certificate relative w-full rounded-lg shadow bg-white p-4 mb-2 " >
                            <div class="field_name w-full p-1 " >ជំនាញ ៖ {{ certificate.field_name }}</div>
                            <div class="certificate_leverl w-full p-1 " >កម្រិត ៖ {{ certificate.group != undefined ? certificate.group.name : '' }}</div>
                            <div class="start_date absolute top-4 right-4 h-8 w-48 text-right" >ឆ្នាំសិក្សា ៖ {{ $toKhmer( dateFormat( new Date( certificate.start ) , 'yyyy') + ' - ' + dateFormat( new Date( certificate.end ) , 'yyyy') ) }}</div>
                            <div class="education_center_name w-full p-1 " >គ្រឹះស្ថានសិក្សា ៖ {{ certificate.place_name }}</div>
                            <div class="education_center_location w-full p-1 " >ទីតាំងគ្រឹះស្ថានសិក្សា ៖ {{ certificate.location }}</div>
                            <div class="absolute bottom-0 right-0 w-40 flex flex-row-reverse" >
                                <svg 
                                @click="uploadToggler(certificate)" 
                                class="w-6 h-6 m-2 text-blue-500 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5c0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4c0-2.05 1.53-3.76 3.56-3.97l1.07-.11l.5-.95A5.469 5.469 0 0 1 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5l1.53.11A2.98 2.98 0 0 1 22 15c0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z" fill="currentColor"></path></svg>
                                <svg 
                                v-if="certificate.pdf==true"
                                @click="togglePdfModal(certificate)"
                                class="w-6 h-6 m-2 text-red-500 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
                                <svg 
                                @click="edit(certificate)"
                                class="w-6 h-6 m-2 text-blue-500 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M4 15h5.986c-.227.3-.4.639-.51 1H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5.232c-.326.14-.631.343-.897.609L15 9.944V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1zm8-9.5a.5.5 0 0 1 1 0v6.444l-.88.88A.498.498 0 0 1 12 12.5v-7zm-7 2a.5.5 0 0 1 1 0v5a.5.5 0 0 1-1 0v-5zM9 9a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-3A.5.5 0 0 0 9 9zm1.98 6.377l4.83-4.83a1.87 1.87 0 1 1 2.645 2.646l-4.83 4.829a2.197 2.197 0 0 1-1.02.578l-1.498.374a.89.89 0 0 1-1.079-1.078l.375-1.498c.096-.386.296-.74.578-1.02z" fill="currentColor"></path></g></svg>
                                <svg 
                                @click="destroy(certificate)"
                                class="w-6 h-6 m-2 text-red-500 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>
                            </div>
                        </div>
                        <div v-if="certificates == undefined || certificates == null || ( certificates.length <= 0 )" >
                            មិនទាន់មានសញ្ញាបត្រនៅឡើយ
                        </div>
                    </div>
                </n-scrollbar>
                <!-- Create - update form -->
                <Transition name="slide-fade" >
                    <div v-if="formHelper" class="form absolute top-0 right-0 bottom-0 left-0 bg-gray-100/80" >
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-1/2 mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ព័ត៌មាន កម្រិតការសិក្សារ
                                    <svg 
                                    class="w-7 h-7 text-green-500 absolute right-0 -top-2 cursor-pointer " 
                                    @click="save"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
                                    <svg 
                                    class="w-7 h-7 text-red-500 absolute right-12 -top-2 cursor-pointer " 
                                    @click="formToggler"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
                                </div>
                                <n-form class="flex flex-wrap w-full " >
                                    <n-form-item label="កម្រិតសញ្ញាបត្រ" >
                                        <n-radio-group v-model:value="selectedCertificateLevel" name="certificate_level">
                                            <n-space>
                                                <n-radio
                                                    v-for="(level , index) in certificate_levels"
                                                    :key="index"
                                                    :value="level.value"
                                                    :label="level.label" 
                                                    />
                                            </n-space>
                                        </n-radio-group>
                                    </n-form-item>
                                    <n-form-item label="ឈ្មោះជំនាញ" class="w-full" >
                                        <n-input v-model:value="educationCertificate.field_name" placeholder="ឈ្មោះជំនាញ" />
                                    </n-form-item>
                                    <n-form-item label="ឆ្នាំ ចូលរៀន" class="w-1/2" >
                                        <n-date-picker v-model:value="educationCertificateStart" type="year" clearable format="yyyy" placeholder="ឆ្នាំ ចូលរៀន" />
                                    </n-form-item>
                                    <n-form-item label="ឆ្នាំ បញ្ចប់" class="w-1/2" >
                                        <n-date-picker v-model:value="educationCertificateEnd" type="year" clearable format="yyyy" placeholder="ឆ្នាំ បញ្ចប់" />
                                    </n-form-item>
                                    <n-form-item label="ឈ្មោះគ្រឹះស្ថានសិក្សារ" class="w-full" >
                                        <n-input v-model:value="educationCertificate.place_name" placeholder="ឈ្មោះគ្រឹះស្ថានសិក្សារ" />
                                    </n-form-item>
                                    <n-form-item label="ទីតាំនៃគ្រឹះស្ថានសិក្សារ" class="w-full" >
                                        <n-input v-model:value="educationCertificate.location" placeholder="ទីតាំនៃគ្រឹះស្ថានសិក្សារ" 
                                            class="text-left" 
                                            type="textarea" show-count maxlength="5000" />
                                    </n-form-item>
                                </n-form>
                            </div> 
                        </div>
                    </div>
                </Transition>
                <!-- Upload Pdf-->
                <Transition name="slide-fade" >
                    <div v-if="uploadHelper" class="form absolute top-0 right-0 bottom-0 left-0 bg-gray-100/80" >
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-1/2 mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ភ្ជាប់ឯកសារយោង
                                    <svg 
                                    @click="uploadFiles"
                                    class="w-7 h-7 text-green-700 absolute right-0 -top-2 cursor-pointer " 
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M518.3 459a8 8 0 0 0-12.6 0l-112 141.7a7.98 7.98 0 0 0 6.3 12.9h73.9V856c0 4.4 3.6 8 8 8h60c4.4 0 8-3.6 8-8V613.7H624c6.7 0 10.4-7.7 6.3-12.9L518.3 459z" fill="currentColor"></path><path d="M811.4 366.7C765.6 245.9 648.9 160 512.2 160S258.8 245.8 213 366.6C127.3 389.1 64 467.2 64 560c0 110.5 89.5 200 199.9 200H304c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8h-40.1c-33.7 0-65.4-13.4-89-37.7c-23.5-24.2-36-56.8-34.9-90.6c.9-26.4 9.9-51.2 26.2-72.1c16.7-21.3 40.1-36.8 66.1-43.7l37.9-9.9l13.9-36.6c8.6-22.8 20.6-44.1 35.7-63.4a245.6 245.6 0 0 1 52.4-49.9c41.1-28.9 89.5-44.2 140-44.2s98.9 15.3 140 44.2c19.9 14 37.5 30.8 52.4 49.9c15.1 19.3 27.1 40.7 35.7 63.4l13.8 36.5l37.8 10C846.1 454.5 884 503.8 884 560c0 33.1-12.9 64.3-36.3 87.7a123.07 123.07 0 0 1-87.6 36.3H720c-4.4 0-8 3.6-8 8v60c0 4.4 3.6 8 8 8h40.1C870.5 760 960 670.5 960 560c0-92.7-63.1-170.7-148.6-193.3z" fill="currentColor"></path></svg>
                                    <svg 
                                    class="w-7 h-7 text-red-500 absolute right-12 -top-2 cursor-pointer " 
                                    @click="uploadToggler"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
                                </div>
                            </div> 
                            <n-form class="flex flex-wrap w-full " >
                                <n-form-item label="ឯកសារយោង" path="pdfs" class="w-4/5 mx-auto " >
                                    <input type="file" placeholder="ឯកសារយោង" @change="fileChange" class="hidden " id="referenceDocument" />
                                    <div class="border rounded border-gray-200 w-full text-sm text-center cursor-pointer hover:border-green-500" @click="clickUpload" >
                                    <div class="no-files-upload h-full w-full p-4">
                                        <svg 
                                        class="text-red-600 w-14 mx-auto"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
                                        <br/>បញ្ចូលឯកសារយោង ដើម្បីជំនួសឯកសារដែលមានរួចហើយ។
                                    </div>
                                    <div class="list-files-upload w-full p-4" >
                                        <div class="selectedFiles w-full m-2" v-for="(pdf,index) in record.pdfs" :key="index" v-html="'ឯកសារយោងមានឈ្មោះ៖ ' + pdf.name + ' , ទំហំ៖ ' + (pdf.size/1024/1024).toFixed(2) + ' មេកាបៃ (MB)' " ></div>
                                    </div>
                                    </div>
                                </n-form-item>
                            </n-form>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ កម្រិតការសិក្សារ</div>
        </Transition>
        <pdf-preview v-model:model="model" v-model:record="selectedCertificate" v-bind:show="pdfToggle" :onClose="togglePdfModal"/>
    </div>  
</template>
<script >
import { reactive , ref , computed , onMounted , watch } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification , useDialog } from 'naive-ui'

import Frame4Corner from '@components/widgets/frame/corner4.vue'
import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from '@assets/logo.svg'
import dateFormat from 'dateformat'
import PdfPreview from './pdfpreview.vue'
    export default {
        components: {
            PdfPreview
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
            const store = useStore()
            const message = useMessage()
            const notify = useNotification()
            const dialog = useDialog()

            const model = reactive({
                name: 'certificate' ,
                module: 'certificates' ,
                title: 'កម្រិតការសិក្សា'
            })
            const certificates = computed( () => {
                return store.getters['certificate/getRecords']
            })

            const selectedCertificate = ref(null)

            const educationCertificateStart = ref( new Date().getTime() )
            const educationCertificateEnd = ref( new Date().getTime() )
            const educationCertificate = reactive({
                people_id : props.record.id ,
                field_name : '' ,
                start_date : '' ,
                end_date : '' ,
                location : '' ,
                place_name : '',
                certificate_group_id : 0 ,
                pdf: ''
            })

            const certificate_levels = computed( () => {
                return store.getters['certificate/getGroups'].map( ( g ) => { return { label : g.name , value : g.id } })
            })
            const selectedCertificateLevel = ref(0)

            const formHelper = ref(false)
            function formToggler() {
                formHelper.value = !formHelper.value
                if( formHelper.value == true ){
                    
                }else{
                    educationCertificateStart.value = ( new Date() ).getTime()
                    educationCertificateEnd.value = ( new Date() ).getTime()
                    educationCertificate.people_id = props.record.id
                    educationCertificate.field_name = ''
                    educationCertificate.start_date = ''
                    educationCertificate.end_date = ''
                    educationCertificate.location = ''
                    educationCertificate.place_name = ''
                    educationCertificate.certificate_group_id = 0
                    educationCertificate.pdf = ''
                }
            }

            const uploadHelper = ref(false)
            function uploadToggler(certificate) {
                uploadHelper.value = !uploadHelper.value
                if( certificate == null || certificate == undefined ){
                    
                }else{
                    selectedCertificate.value = certificate
                }
            }

            const pdfToggle = ref(false)
            function togglePdfModal(cert) {
                selectedCertificate.value = cert == undefined || cert == null ? null : cert 
                pdfToggle.value = !pdfToggle.value
            }

            function getCertificates(){
                store.dispatch('certificate/list',{
                search : '' ,
                page: 1 , 
                perPage : 100
                }).then( res => {
                    store.commit( 'certificate/setRecords', res.data.records );
                }).catch( err => {
                    console.log( err )
                })
            }
            
            function save(){
                store.dispatch( model.name + '/' + ( selectedCertificate.value != null && selectedCertificate.value.id > 0 ? 'update' : 'create' ) , 
                selectedCertificate.value != null && selectedCertificate.value.id > 0 
                    ? {
                        id: selectedCertificate.value.id ,
                        people_id : props.record.id ,
                        field_name : educationCertificate.field_name ,
                        start_date : dateFormat( new Date( educationCertificateStart.value ) , 'yyyy' ) ,
                        end_date : dateFormat( new Date( educationCertificateEnd.value ) , 'yyyy' ) ,
                        location : educationCertificate.location ,
                        place_name : educationCertificate.place_name ,
                        certificate_group_id : selectedCertificateLevel.value
                    }
                    : {
                        people_id : props.record.id ,
                        field_name : educationCertificate.field_name ,
                        start_date : dateFormat( new Date( educationCertificateStart.value ) , 'yyyy' ) ,
                        end_date : dateFormat( new Date( educationCertificateEnd.value ) , 'yyyy' ) ,
                        location : educationCertificate.location ,
                        place_name : educationCertificate.place_name ,
                        certificate_group_id : selectedCertificateLevel.value
                    }
                ).then( res => {
                    getCertificates()
                }).catch( err => {
                    console.log( err )
                })
                formHelper.value = false
            }

            function edit(certificate){
                selectedCertificate.value = certificate
                educationCertificate.field_name = selectedCertificate.value.field_name ,
                educationCertificate.location = selectedCertificate.value.location ,
                educationCertificate.place_name = selectedCertificate.value.place_name ,
                selectedCertificateLevel.value = selectedCertificate.value.certificate_group_id
                educationCertificateStart.value = ( new Date( selectedCertificate.value.start ) ).getTime()
                educationCertificateEnd.value = ( new Date( selectedCertificate.value.end ) ).getTime()
                formHelper.value = true
            }

            /**
             * Upload functions
             */
            /**
             * File upload
             */
            const pdfs = ref([])
            /**
             * On change
             */
            function fileChange(event){
                for(const file of event.target.files ){
                    // if( index == 'item' || index == 'length' ) continue;

                    // allowed types
                    let allowed_mime_types = [ 
                    /**
                     * Image mime type
                     */
                    // 'image/jpeg', 'image/png' 
                    /**
                     * Application file mime type
                     */
                    "application/pdf"
                    ];
                    
                    // allowed max size in MB
                    let allowed_size_mb = 25;

                    // Validate file type
                    if(allowed_mime_types.indexOf(file.type) == -1) {
                        notify.error({
                            title: "ឯកសារយោង" ,
                            description: "ឯកសារនេះជាប្រភេទ៖ "+ file.type +"។ អនុញ្ញាតតែឯកសារដែលមានប្រភេទជា PDF។" ,
                            duration: 3000
                        })
                        return;
                    }

                    // Validate file size
                    if(file.size > allowed_size_mb*1024*1024) {
                        notify.error({
                            title: "ឯកសារយោង" ,
                            description: "ទំហំនៃឯកសារគឺ៖ " + (file.size/1024/1024).toFixed(2) + " មេកាបៃ (MB) លើលទំហំដែលកំណត់គឺ ៥ មេកាបៃ។" ,
                            duration: 3000
                        })
                    return;
                    }


                    let reader = new FileReader();
                    reader.onerror = function(e) {
                        console.log('On error');
                    };
                    reader.onprogress = function(e) {
                        console.log('On progress');
                    };
                    reader.onabort = function(e) {
                        console.log('On abort');
                    };
                    reader.onloadstart = function(e) {
                        console.log( "On load start" )
                    };
                    reader.onload = function(e) {
                    // Ensure that the progress bar displays 100% at the end.
                    console.log( 'On load' )
                    /**
                     * Read binary string from 'e.target.result' and convert to base64
                     */
                    pdfs.value.push( btoa( e.target.result ) );
                    // formData.append('files', btoa( e.target.result ) )
                    }
                    // // // Read in the image file as base64 type
                    // // reader.readAsDataURL(file);
                    reader.readAsBinaryString(file);

                    // // Read in the image file as base64 type
                    // props.record.pdfs.push( window.URL.createObjectURL( file ) )
                    pdfs.value.push( file )
                }
            }
            /**
             * On click file upload
             */
            function clickUpload(){
                document.getElementById('referenceDocument').click()
            }
            function uploadFiles(){
                // console.log( props.record.pdfs )
                let formData = new FormData();
                formData.append('id', selectedCertificate.value.id )
                formData.append('file', pdfs.value[0] )
                notify.info({
                    title: 'រក្សារទុកព័ត៌មាន' ,
                    description: 'កំពុងបញ្ចូលឯកសារយោង។' ,
                    duration: 3000
                })
                store.dispatch('certificate/upload', formData ).then( res => {
                    notify.success({
                        title: 'រក្សារទុកព័ត៌មាន' ,
                        description: 'បានបញ្ចូលឯកសារយោងរួចរាល់។' ,
                        duration: 3000
                    })
                    pdfs.value = []
                }).catch( err => {
                    console.log( err )
                    notify.error({
                        title: 'រក្សារទុកព័ត៌មាន' ,
                        description: 'មានបញ្ហាពេលបញ្ចូលឯកសារយោង។' ,
                        duration: 3000
                    })
                })
                uploadHelper.value = false
                getCertificates()
            }
            // End Upload

            function destroy(record){
                dialog.warning({
                    title: "លុបកម្រិតសិក្សា" ,
                    content: "តើអ្នកចង់ លុប មែនទេ ?" ,
                    positiveText: 'បាទ / ចាស',
                    negativeText: 'ទេ',
                    onPositiveClick: () => {
                    store.dispatch(model.name+'/delete',{id:record.id}).then( res => {
                        if( res.data.ok ){
                        notify.success({
                            title: 'លុបកម្រិតសិក្សា' ,
                            description: 'លុបបានរួចរាល់។' ,
                            duration: 3000
                        })
                        getCertificates()
                        }else{
                        notify.success({
                            title: 'លុបកម្រិតសិក្សា' ,
                            description: 'មានបញ្ហាក្នុងពេលលុប។' ,
                            duration: 3000
                        })
                        }
                    }).catch( err => {
                    message.error( err )
                    })
                    },
                    onNegativeClick: () => {
                    }
                })
            }
            
            // certificates.value = store.getters['certificate/getRecords']
            return {
                model ,
                educationCertificateStart ,
                educationCertificateEnd ,
                educationCertificate ,
                certificate_levels ,
                /**
                 * Visible or invisible form
                 */
                formHelper ,
                formToggler ,
                pdfToggle ,
                togglePdfModal ,
                certificates ,
                selectedCertificate ,
                selectedCertificateLevel ,
                save ,
                edit ,
                selectedCertificate ,
                dateFormat ,
                uploadToggler ,
                uploadHelper ,
                fileChange ,
                clickUpload ,
                uploadFiles ,
                destroy
            }
        }
    }
</script>
<style scoped >
</style>