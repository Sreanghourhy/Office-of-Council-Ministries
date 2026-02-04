<template >
    <div v-if="show" class="birth-information" >
        <Transition name="slide-fade" >
            <div v-if="officer != undefined && officer != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-6 flex flex-wrap" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 relative " >ជីវប្រវត្តិមន្ត្រីរាជការ
                    <div class="absolute right-0 -top-1 bg-white rounded-md hover:text-blue-600 duration-300" >
                        <a v-if="officer!=undefined" :href="getPrintCardUrl(officer)" target="_blank_" >
                            <svg class="w-7 h-7 p-1 cursor-pointer" 
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28 9h-3V3H7v6H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3v6h18v-6h3a2 2 0 0 0 2-2V11a2 2 0 0 0-2-2zM9 5h14v4H9zm14 22H9V17h14zm5-6h-3v-6H7v6H4V11h24z" fill="currentColor"></path></svg>
                        </a>
                    </div>
                </div>
                <n-scrollbar >
                    <div class="body" >
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ក. ព័ត៌មានផ្ទាល់ខ្លួន</div>
                                <table v-if=" officer.people != undefined && officer.people != null " class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td rowspan="11" >
                                                <img :src="officer.image != undefined && officer.image != null ? officer.image : ocmLogoUrl " class="mx-auto border border-gray-200 " style="width: 3.2cm; height: 4.2cm; " />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ឈ្មោះជាភាសាខ្មែរ</td>
                                            <td >{{ 'គោត្តនាម ៖ ' + officer.people.lastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " + officer.people.firstname }}</td>
                                            <td colspan="2" >ភេទ ៖ {{ parseInt( officer.people.gender ) == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                            <td colspan="3" >{{ 'គោត្តនាម ៖ ' + officer.people.enlastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " +  officer.people.enfirstname }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                            <td>{{ ( ( officer.people.dob != null  ) ? $toKhmer( dateFormat( new Date(officer.people.dob) , 'dd-mm-yyyy' ) ) : '' ) }}</td>
                                            <td class="">ជនជាតិ ៖ {{ officer.people.national }}</td>
                                            <td class="">សញ្ជាតិ ៖ {{ officer.people.nationality }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                            <td colspan="3" >ភូមិ {{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.address != null  ) ? $toKhmer( officer.people.address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                            <td colspan="3" >{{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.address != null  ) ? $toKhmer( officer.people.address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អាសយដ្ឋានអចិន្ត្រៃយ៍</td>
                                            <td colspan="3" >{{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.current_address != null  ) ? $toKhmer( officer.people.current_address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >លេខទូរសព្ទ</td>
                                            <td >{{ $toKhmer( officer.people.mobile_phone ) }}</td>
                                            <td class="" colspan="2" >អ៉ីមែល៖ {{ officer.people.email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អត្តលេខមន្ត្រីរាជការ</td>
                                            <td colspan="3" class="" >{{ $toKhmer( officer.code ) }}</td>
                                        </tr>
                                        <tr v-if="officer.people.passports != null && officer.people.passports != undefined && officer.people.passports.length > 0" >
                                            <td class="w-48 " >លេខអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ</td>
                                            <td>{{ $toKhmer( officer.people.passports[0].number ) }}</td>
                                            <td class="">សុពលភាព ៖ {{ $toKhmer( officer.people.passports[0].effective_date ) }}</td>
                                            <td class="">ដល់ថ្ងៃ ៖ {{ $toKhmer( officer.people.passports[0].expired_date ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >កាយសម្បទា</td>
                                            <td>
                                                <n-space item-style="display: flex;" align="center">
                                                    <n-space>
                                                        <n-radio :checked=" parseInt( officer.people.body_condition ) == 0 ? true : false " >គ្រប់គ្រាន់</n-radio>
                                                        <n-radio :checked=" parseInt( officer.people.body_condition ) == 1 ? true : false " >ពិការភាព</n-radio>
                                                    </n-space>
                                                </n-space>
                                            </td>
                                            <td colspan="2" class="">ប្រភេទពិការភាព ៖ {{ parseInt( officer.people.body_condition ) == 1 ? officer.people.body_condition_desp : '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ខ. ព័ត៌មានគ្រួសារ</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td colspan="4" > 
                                                <n-space item-style="display: flex;" align="center">
                                                    <n-space>
                                                        <n-radio :checked=" officer.people.marry_status == 'single' ? true : false " >នៅលីវ</n-radio>
                                                        <n-radio :checked=" officer.people.marry_status == 'married' ? true : false " >រៀបការហើយ</n-radio>
                                                        <n-radio :checked=" officer.people.marry_status == 'divorced' ? true : false " >ពោះមាយ / មេមាយ</n-radio>
                                                    </n-space>
                                                </n-space>
                                            </td>
                                        </tr>
                                        <tr v-if=" officer.people.wedding_certificates != undefined && officer.people.wedding_certificates.length > 0 " >
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.១ ព័ត៌មានប្រពន្ធឬប្ដី</div>
                                                <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr >
                                                            <td class="w-48 " >លេខសំបុត្រអាពាហ៍ពិពាហ៍</td>
                                                            <td>{{ $toKhmer( officer.people.wedding_certificates[0].wedding_number ) }}</td>
                                                            <td class="w-48 " >លេខសៀវភៅអាពាហ៍ពិពាហ៍</td>
                                                            <td>{{ $toKhmer( officer.people.wedding_certificates[0].book_number ) }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះប្រពន្ធឬប្តី</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_lastname }} {{ officer.people.wedding_certificates[0].spouse_firstname }}</td>
                                                            <td>
                                                                <n-radio :checked=" officer.people.wedding_certificates[0].spouse_death == 0 ? true : false " >រស់</n-radio>
                                                            </td>
                                                            <td>
                                                                <n-radio :checked=" officer.people.wedding_certificates[0].spouse_death == 1 ? true : false " >ស្លាប់</n-radio>
                                                            </td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_enlastname }} {{ officer.people.wedding_certificates[0].spouse_enfirstname }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ថ្ងៃខែឆ្នាំកំណើត</td>
                                                            <td>{{ $toKhmer( officer.people.wedding_certificates[0].spouse_dob ) }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ</td>
                                                            <td>{{ $toKhmer( officer.people.wedding_certificates[0].spouse_nid ) }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ទីកន្លែងកំណើត</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_pob }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_address }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">មុខរបរបច្ចុប្បន្ន</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_profession }}</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះអង្គភាព</td>
                                                            <td>{{ officer.people.wedding_certificates[0].spouse_profession_organization }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr v-if="officer.people.wedding_certificates != undefined && officer.people.wedding_certificates.length > 0 " >
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.២ ព័ត៌មានកូន</div>
                                                <table v-if=" officer.people.wedding_certificates[0].birth_certificates != undefined && officer.people.wedding_certificates[0].birth_certificates != null && officer.people.wedding_certificates[0].birth_certificates.length > 0 " class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr >
                                                            <td class="w-48 pb-2" >មានកូនចំនួន {{ $toKhmer( officer.people.wedding_certificates[0].birth_certificates.length ) }} នាក់</td>
                                                            <td class="w-48" >កូនស្រីចំនួន {{ $toKhmer( officer.people.wedding_certificates[0].birth_certificates.filter( ( b ) => b.gender != 'male' ).length ) }} នាក់</td>
                                                        </tr>
                                                        <tr >
                                                            <td colspan="2" >
                                                                <table class="w-full" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-left w-24" >ល.រ</th>
                                                                            <th class="text-left">គោត្តនាមនិងនាមខ្លួន</th>
                                                                            <th class="text-left">ភេទ</th>
                                                                            <th class="text-left">ថ្ងៃខែឆ្នាំកំណើត</th>
                                                                            <th class="text-left">មុខរបរ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(o,i) in officer.people.wedding_certificates[0].birth_certificates"  :key="i">
                                                                            <td class="w-24 " >{{ $toKhmer( i + 1 ) }}. </td>
                                                                            <td>{{ o.lastname + ' ' + o.firstname }}</td>
                                                                            <td>{{ o.gender == "male" ? 'ប្រុស' : 'ស្រី' }}</td>
                                                                            <td>{{ o.dob != undefined && o.dob.length > 0 ? $toKhmer( dateFormat( new Date(o.dob) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                                            <td>{{ o.profession }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.៣ ព័ត៌មានឪពុកនិងម្ដាយបង្កើត</div>
                                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានឪពុក</div>
                                                <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-48 " >ឪពុកឈ្មោះ</td>
                                                            <td >{{ officer.people.father_lastname }}</td>
                                                            <td>{{ officer.people.father_firstname }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                            <td >{{ officer.people.father_enlastname }}</td>
                                                            <td>{{ officer.people.father_enfirstname }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                                            <td>{{ officer.people.father_dob != undefined && officer.people.father_dob.length > 0 ? $toKhmer( dateFormat( new Date(officer.people.father_dob) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="">ជនជាតិ ៖ {{  officer.people.father_national }}</td>
                                                            <td class="">សញ្ជាតិ ៖ {{ officer.people.father_nationality }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                            <td colspan="3" >{{ officer.people.father_pob }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                            <td colspan="3" >{{ officer.people.father_address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                            <td colspan="3" >{{ officer.people.father_profession }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានម្ដាយ</div>
                                                <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-48 " >ម្ដាយឈ្មោះ</td>
                                                            <td >{{ officer.people.mother_lastname }}</td>
                                                            <td>{{ officer.people.mother_firstname }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                            <td >{{ officer.people.mother_enlastname }}</td>
                                                            <td>{{ officer.people.mother_enfirstname }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                                            <td>{{ officer.people.mother_dob != undefined && officer.people.mother_dob.length > 0 ? $toKhmer( dateFormat( new Date(officer.people.mother_dob) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="">ជនជាតិ ៖ {{  officer.people.mother_national }}</td>
                                                            <td class="">សញ្ជាតិ ៖ {{ officer.people.mother_nationality }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                            <td colspan="3" >{{ officer.people.mother_pob }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                            <td colspan="3" >{{ officer.people.mother_address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                            <td colspan="3" >{{ officer.people.mother_profession }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >គ. ព័ត៌មានទំនាក់ទំនងក្នុងករណីមានអាសន្ន</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td class="w-48 " >ឈ្មោះជាភាសារខ្មែរ ៖ </td>
                                            <td >{{ officer.people.emergency_lastname }}</td>
                                            <td>{{ officer.people.emergency_firstname }}</td>
                                            <td >{{ officer.people.emergency_gender == 0 ? 'ស្រី' : 'ប្រុស' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ទំនាក់ទំនងត្រូវជា ៖ </td>
                                            <td >{{ officer.people.emergency_relationship }}</td>
                                            <td>មុខរបរ ៖ </td>
                                            <td >{{ officer.people.emergency_profession }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន ៖ </td>
                                            <td colspan="3" >{{ officer.people.emergency_address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >លេខទូរសព្ទ ៖ </td>
                                            <td >{{ $toKhmer( officer.people.emergency_phone ) }}</td>
                                            <td class="w-48 " >អ៉ីមែល ៖ </td>
                                            <td >{{ officer.people.emergency_email }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ឃ. កំរិតវប្បធម៌ទូទៅ ការបណ្ដុះបណ្ដាលមុខវិជ្ជាជីវៈ និងការបណ្ដុះបណ្ដាលបន្ត</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >វគ្គឬកម្រិតសិក្សា</th>
                                                            <th >គ្រឹះស្ថានសិក្សាបណ្ដុះបណ្ដាល</th>
                                                            <th>រាជធានី ខេត្ត ប្រទេស</th>
                                                            <th >សញ្ញាបត្រ</th>
                                                            <th>ជំនាញ</th>
                                                            <th >ថ្ងៃខែឆ្នាំចូលសិក្សា</th>
                                                            <th>ថ្ងៃខែឆ្នាំបញ្ចប់សិក្សា</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="7" class="border-b border-gray-100 p-2 " >១. កម្រិតវប្បធម៌ទូទៅ (សូមបំពេញកម្រិតចុងក្រោយ)</td>
                                                        </tr>
                                                        <tr v-for="(certificate , index) in officer.people.certificates.first" :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.group != undefined && certificate.group != null ? certificate.group.education_level : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.place_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.location }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.group != undefined && certificate.group != null ? ( certificate.certificate_group_id == 3 ? certificate.certificate_note : certificate.group.name ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.field_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( certificate.start ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( certificate.end ) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="border-b border-gray-100 p-2 " >២. កម្រិតបណ្ដុះបណ្ដាលវិជ្ជាជីវៈមូលដ្ឋាន និងក្រោយមូលដ្ឋាន (សូមបំពេញតាមលំដាប់ថ្មីទៅចាស់)</td>
                                                        </tr>
                                                        <tr v-for="(certificate , index) in officer.people.certificates.middle" :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.group != undefined && certificate.group != null ? certificate.group.education_level : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.place_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.location }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.group != undefined && certificate.group != null ? ( certificate.certificate_group_id == 8 ? certificate.certificate_note : certificate.group.name ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.field_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( certificate.start ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( certificate.end ) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="border-b border-gray-100 p-2 " >៣. វគ្គបណ្ដុះបណ្ដាលបន្ត និងវគ្គសិក្សា (សូមបំពេញវគ្គសក្សាថ្មី សំខាន់ និងចាំបាច់)</td>
                                                        </tr>
                                                        <tr v-for="(certificate , index) in officer.people.certificates.others" :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.place_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.location }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.field_name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ certificate.group != undefined && certificate.group != null ? certificate.group.name : '' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Language -->
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ង. ភាសាបរទេស (សូមបំពេញនូវកម្រិតចំណេះដឹងភាសាបរទេស ពីល្អ មធ្យម ខ្សោយ)</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <thead>
                                        <tr class="bg-gray-300 " >
                                            <th class="w-48 " >ភាសាបរទេស</th>
                                            <th >ការអាន</th>
                                            <th>ការសន្ទនា</th>
                                            <th >ការសសេរ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(language , index) in officer.people.languages" :key="index" >
                                            <td class="border-b border-gray-100 p-2 " >{{ language.name }}</td>
                                            <td class="border-b border-gray-100 p-2 " >{{ language.reading.toUpperCase() }}</td>
                                            <td class="border-b border-gray-100 p-2 " >{{ language.speaking.toUpperCase() }}</td>
                                            <td class="border-b border-gray-100 p-2 " >{{ language.writing.toUpperCase() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Working background -->
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ច. ប្រវត្តិការងារ</div>
                                <table class="w-full" style="border-spacing: 0px; " >  
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="relative w-full font-btb-black " ></div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " >ថ្ងៃខែឆ្នាំចូលបម្រើក្របខណ្ឌរដ្ឋ ៖ </td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ officer.unofficial_date != undefined && officer.unofficial_date.length > 0 ? $toKhmer( dateFormat( new Date( officer.unofficial_date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >ថ្ងៃខែឆ្នាំតាំងស៊ុប់ក្នុងក្របខ័ណ្ឌរដ្ឋ ៖ </td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ officer.official_date != undefined && officer.official_date.length > 0 ? $toKhmer( dateFormat( new Date( officer.official_date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " >ឈ្មោះក្របខណ្ឌ ៖ </td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ officer.officer_type }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >ក្របខណ្ឌ ឋានន្តរស័ក្ត និងថ្នាក់បច្ចុប្បន្ន ៖ </td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ officer.salary_rank }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.១-មុខតំណែង (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.១.១-ក្នុងវិស័យសាធារណៈ</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើការងារ</th>
                                                            <th >ថ្ងៃខែឆ្នាំ<br/>បញ្ចប់ការងារ</th>
                                                            <th>ក្រសួង-ស្ថាប័ន</th>
                                                            <th >នាយកដ្ឋាន-អង្គភាព</th>
                                                            <th>មុខតំណែង</th>
                                                            <th >ជំនាញ/បច្ចេកទេស<br/>ក្នុងមុខតំណេង</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(job,index) in officer.job_backgrounds.filter( (jb) => jb.sector == 0 )" :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ job.start != undefined && job.start.length > 0 ? $toKhmer( dateFormat( new Date( job.start ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ job.end != undefined && job.end.length > 0 ? $toKhmer( dateFormat( new Date( job.end ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.organization ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.sub_organization ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.position ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.skill_of_position ) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.១.២-ក្នុងវិស័យឯកជន</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើការងារ</th>
                                                            <th >ថ្ងៃខែឆ្នាំ<br/>បញ្ចប់ការងារ</th>
                                                            <th >គ្រឹះស្ថាន-អង្គភាព</th>
                                                            <th>តួនាទី</th>
                                                            <th >ជំនាញ/បច្ចេកទេស</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(job,index) in officer.job_backgrounds.filter( (jb) => jb.sector == 1 )" :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ job.start != undefined && job.start.length > 0 ? $toKhmer( dateFormat( new Date( job.start ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ job.end != undefined && job.end.length > 0 ? $toKhmer( dateFormat( new Date( job.end ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.organization ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.position ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( job.skill_of_position ) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.២-ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមវេនជ្រើសរើស អតីតភាព ប្ដូរប្រភេទក្របខ័ណ្ឌ និងនិយ័តកម្មថ្នាក់ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>សុពលភាព</th>
                                                            <th >ក្រសួង-ស្ថាប័ន</th>
                                                            <th >នាយកដ្ឋាន-អង្គភាព</th>
                                                            <th >ការិយាល័យ-ផ្នែក</th>
                                                            <th>ក្របខ័ណ្ឌ<br/>ឋានន្តរស័ក្ដិ និងថ្នាក់ចាស់</th>
                                                            <th>ក្របខ័ណ្ឌ<br/>ឋានន្តរស័ក្ដិ និងថ្នាក់ថ្មី</th>
                                                            <th >ប្រភេទ<br/>ដំឡើង/ប្ដូរ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(rank , index) in officer.ranking_by_workings " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.date != undefined && rank.date.length > 0 ? $toKhmer( dateFormat( new Date( rank.date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.sub_organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.sub_sub_organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.previous_rank.name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.rank.name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ changeTypes.find( (t) => t.key == rank.changing_type ).label }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.៣-ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមសញ្ញាបត្រ(សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>សុពលភាព</th>
                                                            <th >គ្រឹះស្ថានបណ្ដុះបណ្ដាល</th>
                                                            <th >ទីកន្លែងសិក្សា</th>
                                                            <th >សញ្ញាបត្របានទទួល</th>
                                                            <th>ក្របខ័ណ្ឌ<br/>ឋានន្តរស័ក្ដិ និងថ្នាក់ចាស់</th>
                                                            <th>ក្របខ័ណ្ឌ<br/>ឋានន្តរស័ក្ដិ និងថ្នាក់ថ្មី</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(rank , index) in officer.ranking_by_certificates " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.date != undefined && rank.date.length > 0 ? $toKhmer( dateFormat( new Date( rank.date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.location }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.certificate }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.previous_rank.name }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ rank.rank.name }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.៤-ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម / ទំនេរពីមុខងារ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>ចាប់ផ្ដើម</th>
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>បញ្ចប់</th>
                                                            <th >ក្រសួង/ស្ថាប័ន</th>
                                                            <th>មុខតំណែង</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(work , index) in officer.pending_works.filter( (w) => w.type == 0 ) " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ work.start != undefined && work.start.length > 0 ? $toKhmer( dateFormat( new Date( work.start ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ work.end != undefined && work.end.length > 0 ? $toKhmer( dateFormat( new Date( work.end ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( work.organization ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( work.position ) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.៥-ស្ថានភាពស្ថិតនៅក្នុងភាពទំនេរគ្មានបៀវត្ស (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>ចាប់ផ្ដើម</th>
                                                            <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>បញ្ចប់</th>
                                                            <th >ក្រសួង/ស្ថាប័ន</th>
                                                            <th>ចំនួន(ខែ/ឆ្នាំ)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(work , index) in officer.pending_works.filter( (w) => w.type == 1 ) " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ work.start != undefined && work.start.length > 0 ? $toKhmer( dateFormat( new Date( work.start ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ work.end != undefined && work.end.length > 0 ? $toKhmer( dateFormat( new Date( work.end ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( work.organization ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( work.total_months ) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Reward & Penalty -->
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <div class="w-full p-4 " >
                                <div class="relative w-full border-b border-gray-200 pb-2 font-btb-black " >ឆ-ការលើកសរសើរ ឬដាក់វិន័យ</div>
                                <table class="w-full" style="border-spacing: 0px; " >  
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ឆ.១-ការលើកសរសើរ (គ្រឿងឥស្សរិយយស មេដាយ បណ្ណសរសើរ)</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >លេខលិខិត</th>
                                                            <th class="w-48 " >កាលបរិច្ឆេទ</th>
                                                            <th >ក្រសួង/ស្ថាប័ន/រាជធានី/ខេត្ត (ស្នើសុំ)</th>
                                                            <th>បរិយាយ</th>
                                                            <th>ប្រភេទ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(medal , index) in officer.medal_histories " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( medal.fid ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ medal.date != undefined && medal.date.length > 0 ? $toKhmer( dateFormat( new Date( medal.date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ medal.organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ medal.desp }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ medal.type }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ឆ.២-ការដាក់វិន័យ</div>
                                                <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                    <thead>
                                                        <tr class="bg-gray-300 " >
                                                            <th class="w-48 " >លេខលិខិត</th>
                                                            <th class="w-48 " >កាលបរិច្ឆេទ</th>
                                                            <th >ក្រសួង/ស្ថាប័ន/រាជធានី/ខេត្ត</th>
                                                            <th>បរិយាយ</th>
                                                            <th>ប្រភេទ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(penalty , index) in officer.panelty_histories " :key="index" >
                                                            <td class="border-b border-gray-100 p-2 " >{{ $toKhmer( penalty.fid ) }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ penalty.date != undefined && penalty.date.length > 0 ? $toKhmer( dateFormat( new Date( penalty.date ) , 'dd-mm-yyyy' ) ) : '' }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ penalty.organization }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ penalty.desp }}</td>
                                                            <td class="border-b border-gray-100 p-2 " >{{ penalty.type }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="w-full relative" >
                            <div class="absolute left-0 top-0 w-80" >
                                <p class="indent-4 leading-6 text-justify " ><span class="text-red-500 mr-1 " >*</span>អង្គភាព {{ officer.organization.name }}</p>
                                <p class="indent-4 leading-6 text-justify ">ខ្ញុំសូមធានាទទួលខុសត្រូវចំពោះមុខច្បាប់ថា ព័ត៌មាន រូបថត និងហត្ថលេខា ក្នុងជីវប្រវត្តិមន្ត្រីរាជការនេះ ពិតជារបស់ <span class="font-moul" >{{ officer.people.lastname + ' ' + officer.people.firstname }}</span> ដែលជាមន្ត្រីកំពុងបំរើការងារនៅក្នុងក្រសួង និងអង្គភាពក្រោមឪវាទរបស់ក្រសួងពិតប្រាកដមែន។</p>
                                <p class="text-center leading-6 " >ថ្ងៃទី {{ $toKhmer( dateFormat( new Date() , 'dd' ) ) }}  ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}</p>
                                <!-- <p class="text-center leading-6 " >រាជធានីភ្នំពេញ ថ្ងៃទី {{ $getKhDay() }} ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}    </p> -->
                            </div>
                            <div class="absolute right-0 top-0 w-80" >
                                <p class="indent-4 leading-6 text-justify " ><span class="text-red-500 mr-1 " >*</span>សាមីខ្លួន</p>
                                <p class="indent-4 leading-6 text-justify ">ខ្ញុំសូមធានាទទួលខុសត្រូវចំពោះមុខច្បាប់ ព័ត៌មានបានបំពេញក្នុងជីវប្រវត្តិមន្ត្រីរាជការនេះ ពិតជាត្រឹមត្រូវប្រាកដមែន។</p>
                                <p class="text-center leading-6 " >ថ្ងៃទី {{ $toKhmer( dateFormat( new Date() , 'dd' ) ) }} ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}     </p>
                                <!-- <p class="text-center leading-6 " >រាជធានីភ្នំពេញ ថ្ងៃទី {{ $toKhmer( (today.getDay() +'' ).padStart(2,'0') ) }}  ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}</p> -->
                                <p class="text-center mt-28" ><span class="font-moul" >{{ 
                                // ( officer.countesy != undefined && officer.countesy != null ? officer.countesy.name + ' ' : '' ) + 
                                officer.people.lastname + ' ' + officer.people.firstname }}</span></p>
                            </div>
                        </div>
                    </div>
                </n-scrollbar>
            </div>
        </Transition>
        <Transition name="slide-fade" >
            <div v-if="officer == undefined || officer == null " >មានបញ្ហាក្នុងការបង្ហាញ ព័ត៌មានមន្ត្រី</div>
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
import moment from 'moment'
import dateFormat from 'dateformat'
    export default {
        components: {
            Frame4Corner ,
            QrcodeVue ,
        },
        props: {
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
            },
        },
        setup(props){
            const store = useStore()
            const officer = ref(null)
            const today = ref( new Date() )
            store.dispatch('officer/mybackground',{ id: props.record.id }).then( res => {
                officer.value = ( res.data.ok == true ) ? res.data.record : null
            }).catch( err => {
                console.log( err )
            })

            const changeTypes = ref([
                {
                    key : 0 ,
                    label: 'វេនជ្រើសរើស' 
                },
                {
                    key : 1 ,
                    label: 'អតីតភាព' 
                },
                {
                    key : 2 ,
                    label: 'ប្ដូរប្រភេទក្របខណ្ឌ' 
                },
                {
                    key : 4 ,
                    label: 'និយ័តកម្មថ្នាក់' 
                },
            ])

            function getPrintCardUrl(record){
                return window.location.origin+'/#/officer/print/profile/'+record.id
            }

            return {
                today ,
                officer ,
                dateFormat ,
                changeTypes ,
                getPrintCardUrl
            }
        }
    }
</script>
<style scoped >
</style>