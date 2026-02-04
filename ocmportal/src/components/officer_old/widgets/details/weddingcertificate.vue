<template >
    <div v-if="show" class="birth-information absolute left-0 right-0 bottom-0 top-0" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-0" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 h-8 leading-6 relative" >ព័ត៌មានអត្រានុកុលដ្ឋាន
                    <div @click="formToggler" class="absolute right-0 top-0 w-32 text-center border border-gray-300 bg-gray-100 cursor-pointer p-1 rounded-full px-2 hover:bg-white hover:border-green-500 duration-500" >បញ្ចូល</div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <div v-for="(certificate , index) in certificates" :key="index" class="certificate relative w-full rounded-lg shadow bg-white p-4 mb-2 " >
                            <div class="field_name w-full p-1 " >លេខអពាពិពាហ័ ៖ {{ certificate.wedding_number }}</div>
                            <div class="certificate_leverl w-full p-1 " >លេខសៀវភៅ ៖ {{ certificate.book_number }}</div>
                            <div class="start_date absolute top-4 right-4 h-8 w-48 text-right" >ឆ្នាំសិក្សា ៖ {{ $toKhmer( certificate.year ) }}</div>
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
                            មិនទាន់មាន លិខិតអាពាហ៍ពិពាហ៍ នៅឡើយ
                        </div>
                    </div>
                </n-scrollbar>
                <!-- Create - update form -->
                <Transition name="slide-fade" >
                    <div v-if="formHelper" class="form absolute top-0 right-0 bottom-0 left-0 bg-gray-100/80" >
                        <n-scrollbar>
                            <div class="form-panel border border-gray-200 rounded-md m-4 bg-white shadow w-2/3 mx-auto " >
                                <div class="w-full p-4 " >
                                    <div class="relative w-full mb-4 border-b border-gray-200 pb-2 h-8 leading-7 font-moul " >ព័ត៌មាន លិខិតរអាពាហ៍ពិពាហ៍
                                        <svg 
                                        class="w-7 h-7 text-green-500 absolute right-0 top-0 cursor-pointer " 
                                        @click="save"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
                                        <svg 
                                        class="w-7 h-7 text-red-500 absolute right-12 top-0 cursor-pointer " 
                                        @click="formToggler"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
                                    </div>
                                    <n-form class="flex flex-wrap w-full " >
                                        <div class="w-1/2 p-4 " >
                                            <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul " >លេខសៀវភៅ អាពាហ៍ពិពាហ៍</div>
                                                <n-form-item label="លេខចុះ" class="w-1/2 p-1" >
                                                    <n-input v-model:value="weddingCertificate.wedding_number" placeholder="លេខចុះ" />
                                                </n-form-item>
                                                <n-form-item label="លេខសៀវភៅ" class="w-1/2 p-1" >
                                                    <n-input v-model:value="weddingCertificate.book_number" placeholder="លេខសៀវភៅ" />
                                                </n-form-item>
                                                <n-form-item label="ឆ្នាំចុះលេខ" class="w-1/2 p-1" >
                                                    <n-input v-model:value="weddingCertificate.year" placeholder="ឆ្នាំចុះលេខ" />
                                                </n-form-item>
                                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" class="w-1/2 p-1" >
                                                    <n-date-picker v-model:value="issuedDate" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ ចុះលេខ" />
                                                </n-form-item>
                                                <n-form-item label="ឈ្មោះអ្នកចុះហត្ថលេខា" class="w-full p-1" >
                                                    <n-input v-model:value="weddingCertificate.signed_name" placeholder="ឈ្មោះអ្នកចុះហត្ថលេខា" />
                                                </n-form-item>
                                            </div>
                                        </div> 

                                        <div class="w-1/2 p-4 " >
                                            <div class=" border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ទីតាំងធ្វើ លិខិតអាពាហ៍ពិពាហ៍</div>
                                                <n-form-item label="ខេត្ត ក្រុង" class="w-1/2 p-1" >
                                                    <n-select 
                                                        v-model:value="weddingCertificate.province_id" 
                                                        placeholder="ខេត្ត ក្រុង" 
                                                        filterable
                                                        clearable
                                                        :options="provinceOptions"
                                                        @update:value="setProvince()" >
                                                    </n-select>
                                                </n-form-item>
                                                <n-form-item label="ស្រុក ខណ្ឌ" class="w-1/2 p-1" >
                                                    <n-select 
                                                        v-model:value="weddingCertificate.district_id" 
                                                        placeholder="ស្រុក ខណ្ឌ" 
                                                        filterable
                                                        clearable
                                                        :options="districtOptions"
                                                        @update:value="setDistrict()">
                                                    </n-select>
                                                </n-form-item>
                                                <n-form-item label="ឃុំ សង្កាត់" class="w-1/2 p-1" >
                                                    <n-select 
                                                        v-model:value="weddingCertificate.commune_id" 
                                                        placeholder="ឃុំ សង្កាត់" 
                                                        filterable
                                                        clearable
                                                        :options="communeOptions"
                                                        @update:value="setCommune()">
                                                    </n-select>
                                                </n-form-item>

                                                <n-form-item-row label="ទីតាំងដែលធ្វើលិខិត" class="w-full p-1" >
                                                    <n-input placeholder="ទីតាំងដែលធ្វើលិខិត" class="text-left" 
                                                    v-model:value="weddingCertificate.issued_location" 
                                                    type="textarea" show-count maxlength="5000" />
                                                </n-form-item-row>
                                            </div>
                                        </div>
                                        <!-- Husband -->
                                        <div class="parent-panel w-full flex flex-wrap p-2" >
                                            <div class="w-full p-2 " >
                                                <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ប្ដី</div>
                                                    <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.husband_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                    </n-form-item>
                                                    <n-form-item label="នាម (ខ្មែរ)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.husband_firstname" placeholder="នាម ខ្មែរ" />
                                                    </n-form-item>
                                                    <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.husband_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                    </n-form-item>
                                                    <n-form-item label="នាម (អង់គ្លេស)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.husband_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                    </n-form-item>
                                                    <n-form-item label="មុខរបរ" class="w-2/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.husband_profession" placeholder="មុខរបរ" />
                                                    </n-form-item>

                                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/4 p-1" >
                                                        <n-date-picker v-model:value="husbandDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                    </n-form-item>

                                                    <n-form-item label="សញ្ជាតិ" class="w-1/4 p-1" >
                                                        <n-radio-group v-model:value="weddingCertificate.husband_nationality" name="gender">
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

                                                    <n-form-item-row label="ទីកន្លែងកំណើត" class="w-1/2 p-2" >
                                                        <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                                                        v-model:value="weddingCertificate.husband_pob" 
                                                        type="textarea" show-count maxlength="5000" />
                                                    </n-form-item-row>
                                                    <n-form-item-row label="ទីលំនៅពេលចុះលិខិតអាពាហ៍ពិពាហ៍" class="w-1/2 p-2" >
                                                        <n-input placeholder="ទីលំនៅពេលចុះលិខិតអាពាហ៍ពិពាហ៍" class="text-left" 
                                                        v-model:value="weddingCertificate.husband_address" 
                                                        type="textarea" show-count maxlength="5000" />
                                                    </n-form-item-row>
                                                    
                                                    
                                                    <!-- parent -->
                                                    <div class="parent-panel w-full flex flex-wrap p-2" >
                                                        <!-- Father information -->
                                                        <div class="w-1/2 p-2 " >
                                                            <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ឪពុក</div>
                                                                <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_father_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_father_firstname" placeholder="នាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_father_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_father_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                                </n-form-item>

                                                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-1" >
                                                                    <n-date-picker v-model:value="husbandFatherDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                                </n-form-item>

                                                                <n-form-item label="សញ្ជាតិ" class="w-1/2 p-1" >
                                                                    <n-radio-group v-model:value="weddingCertificate.husband_father_nationality" name="gender">
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
                                                            </div>
                                                        </div>
                                                        <!-- Mother information -->
                                                        <div class="w-1/2 p-2 " >
                                                            <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap " >
                                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ម្ដាយ</div>
                                                                <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_mother_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_mother_firstname" placeholder="នាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_mother_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.husband_mother_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                                </n-form-item>

                                                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-1" >
                                                                    <n-date-picker v-model:value="husbandMotherDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                                </n-form-item>

                                                                <n-form-item label="សញ្ជាតិ" class="w-1/2 p-1" >
                                                                    <n-radio-group v-model:value="weddingCertificate.husband_mother_nationality" name="gender">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end parent -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Husband end -->
                                        <!-- Wife -->
                                        <div class="parent-panel w-full flex flex-wrap p-2" >
                                            <div class="w-full p-2 " >
                                                <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                    <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ប្រពន្ធ</div>
                                                    <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.wife_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                    </n-form-item>
                                                    <n-form-item label="នាម (ខ្មែរ)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.wife_firstname" placeholder="នាម ខ្មែរ" />
                                                    </n-form-item>
                                                    <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.wife_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                    </n-form-item>
                                                    <n-form-item label="នាម (អង់គ្លេស)" class="w-1/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.wife_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                    </n-form-item>
                                                    <n-form-item label="មុខរបរ" class="w-2/4 p-1" >
                                                        <n-input v-model:value="weddingCertificate.wife_profession" placeholder="មុខរបរ" />
                                                    </n-form-item>

                                                    <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/4 p-1" >
                                                        <n-date-picker v-model:value="wifeDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                    </n-form-item>

                                                    <n-form-item label="សញ្ជាតិ" class="w-1/4 p-1" >
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

                                                    <n-form-item-row label="ទីកន្លែងកំណើត" class="w-1/2 p-2" >
                                                        <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
                                                        v-model:value="weddingCertificate.wife_pob" 
                                                        type="textarea" show-count maxlength="5000" />
                                                    </n-form-item-row>
                                                    <n-form-item-row label="ទីលំនៅពេលចុះលិខិតអាពាហ៍ពិពាហ៍" class="w-1/2 p-2" >
                                                        <n-input placeholder="ទីលំនៅពេលចុះលិខិតអាពាហ៍ពិពាហ៍" class="text-left" 
                                                        v-model:value="weddingCertificate.wife_address" 
                                                        type="textarea" show-count maxlength="5000" />
                                                    </n-form-item-row>
                                                    
                                                    
                                                    <!-- parent -->
                                                    <div class="parent-panel w-full flex flex-wrap p-2" >
                                                        <!-- Father information -->
                                                        <div class="w-1/2 p-2 " >
                                                            <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap" >
                                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ឪពុក</div>
                                                                <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_father_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_father_firstname" placeholder="នាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_father_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_father_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                                </n-form-item>

                                                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-1" >
                                                                    <n-date-picker v-model:value="wifeFatherDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                                </n-form-item>

                                                                <n-form-item label="សញ្ជាតិ" class="w-1/2 p-1" >
                                                                    <n-radio-group v-model:value="weddingCertificate.wife_father_nationality" name="gender">
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
                                                            </div>
                                                        </div>
                                                        <!-- Mother information -->
                                                        <div class="w-1/2 p-2 " >
                                                            <div class="border border-gray-200 bg-white shadow p-4 rounded-lg flex flex-wrap " >
                                                                <div class="w-full mb-4 border-b border-gray-200 pb-2 font-moul" >ព័ត័មាន ម្ដាយ</div>
                                                                <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_mother_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_mother_firstname" placeholder="នាម ខ្មែរ" />
                                                                </n-form-item>
                                                                <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_mother_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                                                                </n-form-item>
                                                                <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                                                                    <n-input v-model:value="weddingCertificate.wife_mother_enfirstname" placeholder="នាម អង់គ្លេស" />
                                                                </n-form-item>

                                                                <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2 p-1" >
                                                                    <n-date-picker v-model:value="wifeMotherDateOfBirth" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" />
                                                                </n-form-item>

                                                                <n-form-item label="សញ្ជាតិ" class="w-1/2 p-1" >
                                                                    <n-radio-group v-model:value="weddingCertificate.wife_mother_nationality" name="gender">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end parent -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Wife end -->
                                    </n-form>
                                </div> 
                            </div>
                        </n-scrollbar>
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
            <div v-if="record == undefined || record == null " >មានបញ្ហាក្នុងការបង្ហាញ ព័ត៌មានឯកសារអត្រានុកុលដ្ឋាន</div>
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

            console.log( props.record )

            const model = reactive({
                name: 'weddingcertificate' ,
                module: 'weddingcertificates' ,
                title: 'លិខិតអាពាហ៍ពិពាហ៍'
            })
            const certificates = computed( () => {
                return store.getters[model.name + '/getRecords']
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

            const husbandDateOfBirth = ref( new Date().getTime() )
            const wifeDateOfBirth = ref( new Date().getTime() )
            const husbandMotherDateOfBirth = ref( new Date().getTime() )
            const husbandFatherDateOfBirth = ref( new Date().getTime() )
            const wifeMotherDateOfBirth = ref( new Date().getTime() )
            const wifeFatherDateOfBirth = ref( new Date().getTime() )
            const issuedDate = ref( new Date().getTime() )

            const weddingCertificate = reactive({
                'wedding_number' : '' ,
                'book_number' : '' , 
                'year' : '' ,
                'province_id' : null ,
                'district_id' : null ,
                'commune_id' : null ,
                
                'issued_date' : '' ,
                'issued_location' : '' ,
                'signed_name' : '' ,
                'wedding_certificate_id' : '' ,
                'pdf' : '' ,
                // husband
                'husband_id' : props.record.id ,
                'husband_firstname' : '' ,
                'husband_lastname' : '' ,
                'husband_enfirstname' : '' ,
                'husband_enlastname' : '' ,
                'husband_profession' : '' ,
                'husband_dob' : '' ,
                'husband_national' : '' ,
                'husband_nationality' : '' ,
                'husband_pob' : '' ,
                'husband_address' : '' ,
                // wife
                'wife_id' : props.record.id ,
                'wife_firstname' : '' ,
                'wife_lastname' : '' ,
                'wife_enfirstname' : '' ,
                'wife_enlastname' : '' ,
                'wife_profession' : '' ,
                'wife_dob' : '' ,
                'wife_national' : '' ,
                'wife_nationality' : '' ,
                'wife_pob' : '' ,
                'wife_address' : '' ,

                // Father
                'husband_father_firstname' : '' ,
                'husband_father_lastname' : '' ,
                'husband_father_enfirstname' : '' ,
                'husband_father_enlastname' : '' ,
                'husband_father_profession' : '' ,
                'husband_father_dob' : '' ,
                'husband_father_nationality' : '' ,
                'husband_father_pob' : '' ,
                // Mother
                'husband_mother_firstname' : '' ,
                'husband_mother_lastname' : '' ,
                'husband_mother_enfirstname' : '' ,
                'husband_mother_profession' : '' ,
                'husband_mother_enlastname' : '' ,
                'husband_mother_dob' : '' ,
                'husband_mother_nationality' : '' ,
                'husband_mother_pob' : '' ,
                // Father
                'wife_father_firstname' : '' ,
                'wife_father_lastname' : '' ,
                'wife_father_enfirstname' : '' ,
                'wife_father_enlastname' : '' ,
                'wife_father_profession' : '' ,
                'wife_father_dob' : '' ,
                'wife_father_nationality' : '' ,
                'wife_father_pob' : '' ,
                // Mother
                'wife_mother_firstname' : '' ,
                'wife_mother_lastname' : '' ,
                'wife_mother_enfirstname' : '' ,
                'wife_mother_profession' : '' ,
                'wife_mother_enlastname' : '' ,
                'wife_mother_dob' : '' ,
                'wife_mother_nationality' : '' ,
                'wife_mother_pob' : ''
            })

            const selectedCertificate = ref(null)
            const selectedCertificateLevel = ref(0)

            const formHelper = ref(false)
            function formToggler() {
                formHelper.value = !formHelper.value
                if( formHelper.value == true ){
                    
                }else{
                    husbandDateOfBirth.value = ( new Date() ).getTime()
                    husbandFatherDateOfBirth.value = ( new Date() ).getTime()
                    husbandMotherDateOfBirth.value = ( new Date() ).getTime()
                    wifeDateOfBirth.value = ( new Date() ).getTime()
                    wifeFatherDateOfBirth.value = ( new Date() ).getTime()
                    wifeMotherDateOfBirth.value = ( new Date() ).getTime()
                    issuedDate.value = ( new Date() ).getTime()
                    weddingCertificate.people_id = props.record.id ,
                    weddingCertificate.wedding_number = ''
                    weddingCertificate.book_number = ''
                    weddingCertificate.year = ''
                    weddingCertificate.province_id = null
                    weddingCertificate.district_id = null
                    weddingCertificate.commune_id = null 
                    weddingCertificate.issued_date = ''
                    weddingCertificate.issued_location = ''
                    weddingCertificate.signed_name = ''
                    weddingCertificate.wedding_certificate_id = ''
                    weddingCertificate.pdf = ''

                    weddingCertificate.husband_id = 0
                    weddingCertificate.husband_lastname = '' 
                    weddingCertificate.husband_firstname = '' 
                    weddingCertificate.husband_enlastname = '' 
                    weddingCertificate.husband_enfirstname = '' 
                    weddingCertificate.husband_profession = '' 
                    weddingCertificate.husband_dob = '' 
                    weddingCertificate.husband_national = '' 
                    weddingCertificate.husband_nationality = '' 
                    weddingCertificate.husband_pob = '' 
                    weddingCertificate.husband_address = '' 

                    weddingCertificate.wife_id = 0
                    weddingCertificate.wife_lastname = '' 
                    weddingCertificate.wife_firstname = '' 
                    weddingCertificate.wife_enlastname = '' 
                    weddingCertificate.wife_enfirstname = '' 
                    weddingCertificate.wife_profession = '' 
                    weddingCertificate.wife_dob = '' 
                    weddingCertificate.wife_national = '' 
                    weddingCertificate.wife_nationality = '' 
                    weddingCertificate.wife_pob = '' 
                    weddingCertificate.wife_address = '' 

                    // Father
                    weddingCertificate.husband_father_firstname = ''
                    weddingCertificate.husband_father_lastname = ''
                    weddingCertificate.husband_father_enfirstname = ''
                    weddingCertificate.husband_father_enlastname = ''
                    weddingCertificate.husband_father_profession = ''
                    weddingCertificate.husband_father_dob = ''
                    weddingCertificate.husband_father_nationality = ''
                    weddingCertificate.husband_father_pob = ''
                    // // Mother
                    weddingCertificate.husband_mother_firstname = ''
                    weddingCertificate.husband_mother_lastname = ''
                    weddingCertificate.husband_mother_enfirstname = ''
                    weddingCertificate.husband_mother_profession = ''
                    weddingCertificate.husband_mother_enlastname = ''
                    weddingCertificate.husband_mother_dob = ''
                    weddingCertificate.husband_mother_nationality = ''
                    weddingCertificate.husband_mother_pob = ''
                    // // Father
                    weddingCertificate.wife_father_firstname = ''
                    weddingCertificate.wife_father_lastname = ''
                    weddingCertificate.wife_father_enfirstname = ''
                    weddingCertificate.wife_father_enlastname = ''
                    weddingCertificate.wife_father_profession = ''
                    weddingCertificate.wife_father_dob = ''
                    weddingCertificate.wife_father_nationality = ''
                    weddingCertificate.wife_father_pob = ''
                    // // Mother
                    weddingCertificate.wife_mother_firstname = ''
                    weddingCertificate.wife_mother_lastname = ''
                    weddingCertificate.wife_mother_enfirstname = ''
                    weddingCertificate.wife_mother_profession = ''
                    weddingCertificate.wife_mother_enlastname = ''
                    weddingCertificate.wife_mother_dob = ''
                    weddingCertificate.wife_mother_nationality = ''
                    weddingCertificate.wife_mother_pob = ''

                }
            }

            function setProvince(){
                selectedProvince.value = store.getters['province/records'].all.find( p => p.id == weddingCertificate.province_id )
                selectedDistrict.value = null
                weddingCertificate.district_id = null
            }

            function setDistrict(){
                selectedDistrict.value = selectedProvince.value.districts.find( d => d.id == weddingCertificate.district_id )
                selectedCommune.value = null
                weddingCertificate.commune_id = null
            }

            function setCommune(){
                selectedCommune.value = selectedDistrict.value.communes.find( d => d.id == weddingCertificate.commune_id )
            }

            const uploadHelper = ref(false)
            function uploadToggler(certificate) {
                uploadHelper.value = !uploadHelper.value
                if( certificate == null || certificate == undefined ){
                    
                }else{
                    selectedCertificate.value = certificate
                }
                console.log( selectedCertificate.value )
            }

            const pdfToggle = ref(false)
            function togglePdfModal(cert) {
                selectedCertificate.value = cert == undefined || cert == null ? null : cert 
                pdfToggle.value = !pdfToggle.value
            }

            function getCertificates(){
                store.dispatch(model.name + '/list',{
                search : '' ,
                page: 1 , 
                perPage : 100
                }).then( res => {
                    store.commit( model.name + '/setRecords', res.data.records );
                }).catch( err => {
                    console.log( err )
                })
            }
            
            function save(){
                // if( selectedCertificate.value == undefined || selectedCertificate.value == null ){
                //     return false
                // }
                store.dispatch( model.name + '/' + ( selectedCertificate.value != null && selectedCertificate.value.id > 0 ? 'update' : 'create' ) , 
                selectedCertificate.value != null && selectedCertificate.value.id > 0
                    // Update
                    ? {
                        id: selectedCertificate.value.id ,
                        'wedding_number' : weddingCertificate.wedding_number ,
                        'book_number' : weddingCertificate.book_number ,
                        'year' : weddingCertificate.year ,
                        'province_id' : selectedProvince != undefined && selectedProvince.value != null ? selectedProvince.value.id : 0 ,
                        'district_id' : selectedDistrict != undefined && selectedDistrict.value != null ? selectedDistrict.value.id : 0 ,
                        'commune_id' : selectedCommune != undefined && selectedCommune.value != null ? selectedCommune.value.id : 0 ,
                        'issued_date' : issuedDate.value != undefined && issuedDate.value != null && issuedDate.value > 0 ? dateFormat( new Date( issuedDate.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'issued_location' : weddingCertificate.issued_location ,
                        'signed_name' : weddingCertificate.signed_name ,
                        // Husband
                        'husband_id' : 0 ,
                        'husband_lastname' : weddingCertificate.husband_lastname ,
                        'husband_firstname' : weddingCertificate.husband_firstname ,
                        'husband_enlastname' : weddingCertificate.husband_enlastname ,
                        'husband_enfirstname' : weddingCertificate.husband_enfirstname ,
                        'husband_profession' : weddingCertificate.husband_profession ,
                        'husband_dob' : husbandDateOfBirth.value != undefined && husbandDateOfBirth.value != null && husbandDateOfBirth.value > 0 ? dateFormat( new Date( husbandDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'husband_national' : weddingCertificate.husband_national ,
                        'husband_nationality' : weddingCertificate.husband_nationality ,
                        'husband_pob' : weddingCertificate.husband_pob ,
                        'husband_address' : weddingCertificate.husband_address ,
                        // Husband Father 
                        'husband_father_firstname' : weddingCertificate.husband_father_firstname ,
                        'husband_father_lastname' : weddingCertificate.husband_father_lastname ,
                        'husband_father_enfirstname' : weddingCertificate.husband_father_enfirstname ,
                        'husband_father_enlastname' : weddingCertificate.husband_father_enlastname ,
                        'husband_father_profession' : weddingCertificate.husband_father_profession ,
                        'husband_father_dob' : husbandFatherDateOfBirth.value != undefined && husbandFatherDateOfBirth.value != null && husbandFatherDateOfBirth.value > 0 ? dateFormat( new Date( husbandFatherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'husband_father_nationality' : weddingCertificate.husband_father_nationality ,
                        'husband_father_pob' : weddingCertificate.husband_father_pob ,
                        // Husband Mother 
                        'husband_mother_firstname' : weddingCertificate.husband_mother_firstname ,
                        'husband_mother_lastname' : weddingCertificate.husband_mother_lastname ,
                        'husband_mother_enfirstname' : weddingCertificate.husband_mother_enfirstname ,
                        'husband_mother_enlastname' : weddingCertificate.husband_mother_enlastname ,
                        'husband_mother_profession' : weddingCertificate.husband_mother_profession ,
                        'husband_mother_dob' : husbandMotherDateOfBirth.value != undefined && husbandMotherDateOfBirth.value != null && husbandMotherDateOfBirth.value > 0 ? dateFormat( new Date( husbandMotherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'husband_mother_nationality' : weddingCertificate.husband_mother_nationality ,
                        'husband_mother_pob' : weddingCertificate.husband_mother_pob ,
                        // Wife
                        'wife_id' : 0 ,
                        'wife_lastname' : weddingCertificate.wife_lastname ,
                        'wife_firstname' : weddingCertificate.wife_firstname ,
                        'wife_enlastname' : weddingCertificate.wife_enlastname ,
                        'wife_enfirstname' : weddingCertificate.wife_enfirstname ,
                        'wife_profession' : weddingCertificate.wife_profession ,
                        'wife_dob' : wifeDateOfBirth.value != undefined && wifeDateOfBirth.value != null && wifeDateOfBirth.value > 0 ? dateFormat( new Date( wifeDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_national' : weddingCertificate.wife_national ,
                        'wife_nationality' : weddingCertificate.wife_nationality ,
                        'wife_pob' : weddingCertificate.wife_pob ,
                        'wife_address' : weddingCertificate.wife_address ,
                        // Wife Father 
                        'wife_father_firstname' : weddingCertificate.wife_father_firstname ,
                        'wife_father_lastname' : weddingCertificate.wife_father_lastname ,
                        'wife_father_enfirstname' : weddingCertificate.wife_father_enfirstname ,
                        'wife_father_enlastname' : weddingCertificate.wife_father_enlastname ,
                        'wife_father_profession' : weddingCertificate.wife_father_profession ,
                        'wife_father_dob' : wifeFatherDateOfBirth.value != undefined && wifeFatherDateOfBirth.value != null && wifeFatherDateOfBirth.value > 0 ? dateFormat( new Date( wifeFatherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_father_nationality' : weddingCertificate.wife_father_nationality ,
                        'wife_father_pob' : weddingCertificate.wife_father_pob ,
                        // Wife Mother 
                        'wife_mother_firstname' : weddingCertificate.wife_mother_firstname ,
                        'wife_mother_lastname' : weddingCertificate.wife_mother_lastname ,
                        'wife_mother_enfirstname' : weddingCertificate.wife_mother_enfirstname ,
                        'wife_mother_enlastname' : weddingCertificate.wife_mother_enlastname ,
                        'wife_mother_profession' : weddingCertificate.wife_mother_profession ,
                        'wife_mother_dob' : wifeMotherDateOfBirth.value != undefined && wifeMotherDateOfBirth.value != null && wifeMotherDateOfBirth.value > 0 ? dateFormat( new Date( wifeMotherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_mother_nationality' : weddingCertificate.wife_mother_nationality ,
                        'wife_mother_pob' : weddingCertificate.wife_mother_pob
                    }
                    // Create
                    : {
                        'wedding_number' : weddingCertificate.wedding_number ,
                        'book_number' : weddingCertificate.book_number ,
                        'year' : weddingCertificate.year ,
                        'province_id' : selectedProvince != undefined && selectedProvince.value != null ? selectedProvince.value.id : 0 ,
                        'district_id' : selectedDistrict != undefined && selectedDistrict.value != null ? selectedDistrict.value.id : 0 ,
                        'commune_id' : selectedCommune != undefined && selectedCommune.value != null ? selectedCommune.value.id : 0 ,
                        'issued_date' : issuedDate.value != undefined && issuedDate.value != null && issuedDate.value > 0 ? dateFormat( new Date( issuedDate.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'issued_location' : weddingCertificate.issued_location ,
                        'signed_name' : weddingCertificate.signed_name ,
                        // Husband
                        'husband_id' : 0 ,
                        'husband_lastname' : weddingCertificate.husband_lastname ,
                        'husband_firstname' : weddingCertificate.husband_firstname ,
                        'husband_enlastname' : weddingCertificate.husband_enlastname ,
                        'husband_enfirstname' : weddingCertificate.husband_enfirstname ,
                        'husband_profession' : weddingCertificate.husband_profession ,
                        'husband_dob' : weddingCertificate.husband_dob ,
                        'husband_national' : weddingCertificate.husband_national ,
                        'husband_nationality' : weddingCertificate.husband_nationality ,
                        'husband_pob' : weddingCertificate.husband_pob ,
                        'husband_address' : weddingCertificate.husband_address ,
                        // Husband Father 
                        'husband_father_firstname' : weddingCertificate.husband_father_firstname ,
                        'husband_father_lastname' : weddingCertificate.husband_father_lastname ,
                        'husband_father_enfirstname' : weddingCertificate.husband_father_enfirstname ,
                        'husband_father_enlastname' : weddingCertificate.husband_father_enlastname ,
                        'husband_father_profession' : weddingCertificate.husband_father_profession ,
                        'husband_father_dob' : husbandFatherDateOfBirth.value != undefined && husbandFatherDateOfBirth.value != null && husbandFatherDateOfBirth.value > 0 ? dateFormat( new Date( husbandFatherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'husband_father_nationality' : weddingCertificate.husband_father_nationality ,
                        'husband_father_pob' : weddingCertificate.husband_father_pob ,
                        // Husband Mother 
                        'husband_mother_firstname' : weddingCertificate.husband_mother_firstname ,
                        'husband_mother_lastname' : weddingCertificate.husband_mother_lastname ,
                        'husband_mother_enfirstname' : weddingCertificate.husband_mother_enfirstname ,
                        'husband_mother_enlastname' : weddingCertificate.husband_mother_enlastname ,
                        'husband_mother_profession' : weddingCertificate.husband_mother_profession ,
                        'husband_mother_dob' : husbandMotherDateOfBirth.value != undefined && husbandMotherDateOfBirth.value != null && husbandMotherDateOfBirth.value > 0 ? dateFormat( new Date( husbandMotherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'husband_mother_nationality' : weddingCertificate.husband_mother_nationality ,
                        'husband_mother_pob' : weddingCertificate.husband_mother_pob ,
                        // Wife
                        'wife_id' : 0 ,
                        'wife_lastname' : weddingCertificate.wife_lastname ,
                        'wife_firstname' : weddingCertificate.wife_firstname ,
                        'wife_enlastname' : weddingCertificate.wife_enlastname ,
                        'wife_enfirstname' : weddingCertificate.wife_enfirstname ,
                        'wife_profession' : weddingCertificate.wife_profession ,
                        'wife_dob' : wifeDateOfBirth.value != undefined && wifeDateOfBirth.value != null && wifeDateOfBirth.value > 0 ? dateFormat( new Date( wifeDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_national' : weddingCertificate.wife_national ,
                        'wife_nationality' : weddingCertificate.wife_nationality ,
                        'wife_pob' : weddingCertificate.wife_pob ,
                        'wife_address' : weddingCertificate.wife_address ,
                        // Wife Father 
                        'wife_father_firstname' : weddingCertificate.wife_father_firstname ,
                        'wife_father_lastname' : weddingCertificate.wife_father_lastname ,
                        'wife_father_enfirstname' : weddingCertificate.wife_father_enfirstname ,
                        'wife_father_enlastname' : weddingCertificate.wife_father_enlastname ,
                        'wife_father_profession' : weddingCertificate.wife_father_profession ,
                        'wife_father_dob' : wifeFatherDateOfBirth.value != undefined && wifeFatherDateOfBirth.value != null && wifeFatherDateOfBirth.value > 0 ? dateFormat( new Date( wifeFatherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_father_nationality' : weddingCertificate.wife_father_nationality ,
                        'wife_father_pob' : weddingCertificate.wife_father_pob ,
                        // Wife Mother 
                        'wife_mother_firstname' : weddingCertificate.wife_mother_firstname ,
                        'wife_mother_lastname' : weddingCertificate.wife_mother_lastname ,
                        'wife_mother_enfirstname' : weddingCertificate.wife_mother_enfirstname ,
                        'wife_mother_enlastname' : weddingCertificate.wife_mother_enlastname ,
                        'wife_mother_profession' : weddingCertificate.wife_mother_profession ,
                        'wife_mother_dob' : wifeMotherDateOfBirth.value != undefined && wifeMotherDateOfBirth.value != null && wifeMotherDateOfBirth.value > 0 ? dateFormat( new Date( wifeMotherDateOfBirth.value ) , 'yyyy-mm-dd' ) : dateFormat( new Date( ) , 'yyyy-mm-dd' ) ,
                        'wife_mother_nationality' : weddingCertificate.wife_mother_nationality ,
                        'wife_mother_pob' : weddingCertificate.wife_mother_pob
                    }
                ).then( res => {
                    getCertificates()
                }).catch( err => {
                    console.log( err )
                })
                // formHelper.value = false
            }

            function loadLocationAndSelectThem(){
                
            }

            function edit(certificate){
                selectedCertificate.value = certificate
                if( selectedCertificate.value == undefined || selectedCertificate.value == null ){
                    return false
                }

                husbandDateOfBirth.value = selectedCertificate.value.husband_dob != undefined && selectedCertificate.value.husband_dob != null && selectedCertificate.value.husband_dob.length >0 ? ( new Date( selectedCertificate.value.husband_dob ) ).getTime() : ( new Date() ).getTime()
                husbandFatherDateOfBirth.value = selectedCertificate.value.husband_father_dob != undefined && selectedCertificate.value.husband_father_dob != null && selectedCertificate.value.husband_father_dob.length >0 ? ( new Date( selectedCertificate.value.husband_father_dob ) ).getTime() : ( new Date() ).getTime()
                husbandMotherDateOfBirth.value = selectedCertificate.value.husband_mother_dob != undefined && selectedCertificate.value.husband_mother_dob != null && selectedCertificate.value.husband_mother_dob.length >0 ? ( new Date( selectedCertificate.value.husband_mother_dob ) ).getTime() : ( new Date() ).getTime()
                wifeDateOfBirth.value = selectedCertificate.value.wife_dob != undefined && selectedCertificate.value.wife_dob != null && selectedCertificate.value.wife_dob.length >0 ? ( new Date( selectedCertificate.value.wife_dob ) ).getTime() : ( new Date() ).getTime()
                wifeFatherDateOfBirth.value = selectedCertificate.value.wife_father_dob != undefined && selectedCertificate.value.wife_father_dob != null && selectedCertificate.value.wife_father_dob.length >0 ? ( new Date( selectedCertificate.value.wife_father_dob ) ).getTime() : ( new Date() ).getTime()
                wifeMotherDateOfBirth.value = selectedCertificate.value.wife_mother_dob != undefined && selectedCertificate.value.wife_mother_dob != null && selectedCertificate.value.wife_mother_dob.length >0 ? ( new Date( selectedCertificate.value.wife_mother_dob ) ).getTime() : ( new Date() ).getTime()
                issuedDate.value = selectedCertificate.value.issued_date != undefined && selectedCertificate.value.issued_date != null && selectedCertificate.value.issued_date.length >0 ? ( new Date( selectedCertificate.value.issued_date ) ).getTime() : ( new Date() ).getTime()
                weddingCertificate.husband_id = props.record.husband_id ,
                weddingCertificate.wife_id = props.record.wife_id ,
                weddingCertificate.wedding_number = selectedCertificate.value.wedding_number
                weddingCertificate.book_number = selectedCertificate.value.book_number
                weddingCertificate.year = selectedCertificate.value.year
                weddingCertificate.province_id = parseInt( selectedCertificate.value.province_id ) > 0 ? selectedCertificate.value.province_id : null
                weddingCertificate.district_id = parseInt( selectedCertificate.value.district_id ) > 0 ? selectedCertificate.value.district_id : null
                weddingCertificate.commune_id = parseInt( selectedCertificate.value.commune_id ) > 0 ? selectedCertificate.value.commune_id : null
                weddingCertificate.issued_location = selectedCertificate.value.issued_location
                weddingCertificate.signed_name = selectedCertificate.value.signed_name
                weddingCertificate.pdf = selectedCertificate.value.pdf

                // Husband
                weddingCertificate.husband_id = selectedCertificate.value.husband_id
                weddingCertificate.husband_lastname = selectedCertificate.value.husband_lastname
                weddingCertificate.husband_firstname = selectedCertificate.value.husband_firstname
                weddingCertificate.husband_enlastname = selectedCertificate.value.husband_enlastname
                weddingCertificate.husband_enfirstname = selectedCertificate.value.husband_enfirstname
                weddingCertificate.husband_profession = selectedCertificate.value.husband_profession
                weddingCertificate.husband_dob = selectedCertificate.value.husband_dob
                weddingCertificate.husband_national = selectedCertificate.value.husband_national
                weddingCertificate.husband_nationality = selectedCertificate.value.husband_nationality
                weddingCertificate.husband_pob = selectedCertificate.value.husband_pob
                weddingCertificate.husband_address = selectedCertificate.value.husband_address

                // Wife
                weddingCertificate.wife_id = selectedCertificate.value.wife_id
                weddingCertificate.wife_lastname = selectedCertificate.value.wife_lastname
                weddingCertificate.wife_firstname = selectedCertificate.value.wife_firstname
                weddingCertificate.wife_enlastname = selectedCertificate.value.wife_enlastname
                weddingCertificate.wife_enfirstname = selectedCertificate.value.wife_enfirstname
                weddingCertificate.wife_profession = selectedCertificate.value.wife_profession
                weddingCertificate.wife_dob = selectedCertificate.value.wife_dob
                weddingCertificate.wife_national = selectedCertificate.value.wife_national
                weddingCertificate.wife_nationality = selectedCertificate.value.wife_nationality
                weddingCertificate.wife_pob = selectedCertificate.value.wife_pob
                weddingCertificate.wife_address = selectedCertificate.value.wife_address
                
                weddingCertificate.husband_father_firstname = selectedCertificate.value.husband_father_firstname
                weddingCertificate.husband_father_lastname = selectedCertificate.value.husband_father_lastname
                weddingCertificate.husband_father_enfirstname = selectedCertificate.value.husband_father_enfirstname
                weddingCertificate.husband_father_enlastname = selectedCertificate.value.husband_father_enlastname
                weddingCertificate.husband_father_nationality = selectedCertificate.value.husband_father_nationality
                weddingCertificate.husband_father_pob = selectedCertificate.value.husband_father_pob

                weddingCertificate.husband_mother_firstname = selectedCertificate.value.husband_mother_firstname
                weddingCertificate.husband_mother_lastname = selectedCertificate.value.husband_mother_lastname
                weddingCertificate.husband_mother_enfirstname = selectedCertificate.value.husband_mother_enfirstname
                weddingCertificate.husband_mother_enlastname = selectedCertificate.value.husband_mother_enlastname
                weddingCertificate.husband_mother_profession = selectedCertificate.value.husband_mother_profession
                weddingCertificate.husband_mother_nationality = selectedCertificate.value.husband_mother_nationality
                weddingCertificate.husband_mother_pob = selectedCertificate.value.husband_mother_pob

                weddingCertificate.wife_father_firstname = selectedCertificate.value.wife_father_firstname
                weddingCertificate.wife_father_lastname = selectedCertificate.value.wife_father_lastname
                weddingCertificate.wife_father_enfirstname = selectedCertificate.value.wife_father_enfirstname
                weddingCertificate.wife_father_enlastname = selectedCertificate.value.wife_father_enlastname
                weddingCertificate.wife_father_nationality = selectedCertificate.value.wife_father_nationality
                weddingCertificate.wife_father_pob = selectedCertificate.value.wife_father_pob

                weddingCertificate.wife_mother_firstname = selectedCertificate.value.wife_mother_firstname
                weddingCertificate.wife_mother_lastname = selectedCertificate.value.wife_mother_lastname
                weddingCertificate.wife_mother_enfirstname = selectedCertificate.value.wife_mother_enfirstname
                weddingCertificate.wife_mother_enlastname = selectedCertificate.value.wife_mother_enlastname
                weddingCertificate.wife_mother_profession = selectedCertificate.value.wife_mother_profession
                weddingCertificate.wife_mother_nationality = selectedCertificate.value.wife_mother_nationality
                weddingCertificate.wife_mother_pob = selectedCertificate.value.wife_mother_pob
            
                selectedProvince.value = store.getters['province/records'].all.find( p => p.id == weddingCertificate.province_id )
                selectedDistrict.value = selectedProvince.value.districts.find( d => d.id == weddingCertificate.district_id )
                selectedCommune.value = selectedDistrict.value.communes.find( d => d.id == weddingCertificate.commune_id )
                
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
                let formData = new FormData();
                formData.append('id', selectedCertificate.value.id )
                formData.append('file', pdfs.value[0] )
                notify.info({
                    title: 'រក្សារទុកព័ត៌មាន' ,
                    description: 'កំពុងបញ្ចូលឯកសារយោង។' ,
                    duration: 3000
                })
                store.dispatch(model.name + '/upload', formData ).then( res => {
                    notify.success({
                        title: 'រក្សារទុកព័ត៌មាន' ,
                        description: 'បានបញ្ចូលឯកសារយោងរួចរាល់។' ,
                        duration: 3000
                    })
                    pdfs.value = []
                    getCertificates()
                }).catch( err => {
                    console.log( err )
                    notify.error({
                        title: 'រក្សារទុកព័ត៌មាន' ,
                        description: 'មានបញ្ហាពេលបញ្ចូលឯកសារយោង។' ,
                        duration: 3000
                    })
                })
                uploadHelper.value = false
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
                weddingCertificate ,
                issuedDate ,
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
                dateFormat ,
                uploadToggler ,
                uploadHelper ,
                fileChange ,
                clickUpload ,
                uploadFiles ,
                destroy ,
                provinceOptions ,
                districtOptions ,
                communeOptions ,
                setProvince ,
                setDistrict ,
                setCommune ,
                husbandDateOfBirth ,
                wifeDateOfBirth ,
                husbandFatherDateOfBirth ,
                husbandMotherDateOfBirth ,
                wifeFatherDateOfBirth ,
                wifeMotherDateOfBirth
            }
        }
    }
</script>
<style scoped >
</style>