<template >
    <div v-if="show" class="birth-information" >
        <Transition name="slide-fade" >
            <div v-if="record != undefined && record != null " class="absolute left-0 right-0 bottom-0 top-0 p-8 mb-6 flex flex-wrap" >
                <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 " >ជីវប្រវត្តិមន្ត្រីរាជការ</div>
                <n-scrollbar >
                    <div class="body" >
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <!-- Personal Information -->
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ក. ព័ត៌មានផ្ទាល់ខ្លួន</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td class="w-48 " >ឈ្មោះជាភាសាខ្មែរ</td>
                                            <td >{{ 'គោត្តនាម ៖ ' + record.people.lastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " + record.people.firstname }}</td>
                                            <td>ភេទ ៖ </td>
                                            <td class="">{{ parseInt( record.people.gender ) == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                            <td colspan="3" >{{ 'គោត្តនាម ៖ ' + record.people.enlastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " +  record.people.enfirstname }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                            <td>{{ ( ( record != null && record.people != undefined && record.people != null && record.people.dob != null  ) ? $toKhmer( dateFormat( new Date(record.people.dob) , 'dd-mm-yyyy' ) ) : '' ) }}</td>
                                            <td class="">ជនជាតិ ៖ ខ្មែរ</td>
                                            <td class="">សញ្ជាតិ ៖ ខ្មែរ</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                            <!-- <td colspan="3" >{{ ( ( record != null && record.people != undefined && record.people != null && record.people.pob != null  ) ? $toKhmer( record.people.pob ) : '' ) }}</td> -->
                                            <td colspan="3" >ភូមិ {{ ( ( record != null && record.people != undefined && record.people != null && record.people.address != null  ) ? $toKhmer( record.people.address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                            <td colspan="3" >{{ ( ( record != null && record.people != undefined && record.people != null && record.people.address != null  ) ? $toKhmer( record.people.address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អាសយដ្ឋានអចិន្ត្រៃយ៍</td>
                                            <td colspan="3" >{{ ( ( record != null && record.people != undefined && record.people != null && record.people.current_address != null  ) ? $toKhmer( record.people.current_address ) : '' ) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >លេខទូរសព្ទ</td>
                                            <td >{{ record.people.phone }}</td>
                                            <td class="" >អ៉ីមែល</td>
                                            <td >{{ record.people.email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >អត្តលេខមន្ត្រីរាជការ</td>
                                            <td class="" >{{ record.code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >លេខអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ</td>
                                            <td>{{ ( ( record != null && record.people != undefined && record.people != null && record.people.nid != null  ) ? record.people.nid : '' ) }}</td>
                                            <td class="">សុពលភាព ៖ 01-01-2019</td>
                                            <td class="">ដល់ថ្ងៃ ៖ 01-01-2029</td>
                                        </tr>
                                        <tr>
                                            <td class="w-48 " >កាយសម្បទា</td>
                                            <td>
                                                <n-space item-style="display: flex;" align="center">
                                                    <n-space>
                                                        <n-radio>គ្រប់គ្រាន់</n-radio>
                                                        <n-radio>ពិការភាព</n-radio>
                                                    </n-space>
                                                </n-space>
                                            </td>
                                            <td colspan="2" class="">ប្រភេទពិការភាព ៖ </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <!-- Family Information -->
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-moul " >ខ. ព័ត៌មានគ្រួសារ</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td colspan="4" > 
                                                <n-space item-style="display: flex;" align="center">
                                                    <n-space>
                                                        <n-radio>នៅលីវ</n-radio>
                                                        <n-radio>រៀបការហើយ</n-radio>
                                                        <n-radio>ពោះមាយ / មេមាយ</n-radio>
                                                    </n-space>
                                                </n-space>
                                            </td>
                                        </tr>
                                        <!-- Spouse Information -->
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.១ ព័ត៌មានប្រពន្ធឬប្ដី</div>
                                                <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr >
                                                            <td class="w-48 " >លេខសំបុត្រអាពាហ៍ពិពាហ៍</td>
                                                            <td>123456789</td>
                                                            <td class="w-48 " >លេខសៀវភៅអាពាហ៍ពិពាហ៍</td>
                                                            <td>123456789</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះប្រពន្ធឬប្តី</td>
                                                            <td>អ៊ុំ ចំរើន</td>
                                                            <td>រស់</td>
                                                            <td>ស្លាប់</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                            <td>អ៊ុំ ចំរើន</td>
                                                            <td>រស់</td>
                                                            <td>ស្លាប់</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ថ្ងៃខែឆ្នាំកំណើត</td>
                                                            <td>ទឹកថ្លា សែនសុខ ភ្នំពេញ</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ</td>
                                                            <td>០១០៩៨៧៦៥៤</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ទីកន្លែងកំណើត</td>
                                                            <td>ទឹកថ្លា សែនសុខ ភ្នំពេញ</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                            <td>ទឹកថ្លា សែនសុខ ភ្នំពេញ</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">មុខរបរបច្ចុប្បន្ន</td>
                                                            <td>មន្ត្រីរាជការ</td>
                                                        </tr>
                                                        <tr >
                                                            <td class="w-48 ">ឈ្មោះអង្គភាព</td>
                                                            <td>ទីស្ដីការគណៈរដ្ឋមន្ត្រី</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Kids Information -->
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.២ ព័ត៌មានកូន</div>
                                                <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr >
                                                            <td class="w-48 pb-2" >មានកូនចំនួន ៣ នាក់</td>
                                                            <td class="w-48" >កូនស្រីចំនួន ១ នាក់</td>
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
                                                                        <tr v-for="(o,i) in 3"  :key="i">
                                                                            <td class="w-24 " >{{ $toKhmer( i + 1 ) }}. </td>
                                                                            <td>អ៊ុំ ចំរើន</td>
                                                                            <td>ប្រុស</td>
                                                                            <td>០១ មករា ១៩៩៥</td>
                                                                            <td>នៅរៀន</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Father and Mother Information -->
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ខ.៣ ព័ត៌មានឪពុកនិងម្ដាយបង្កើត</div>
                                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានឪពុក</div>
                                                    <table class="w-full" style="border-spacing: 0px; " >
                                                        <tbody>
                                                            <tr>
                                                                <td class="w-48 " >ឪពុកឈ្មោះ</td>
                                                                <td >អ៊ុំ</td>
                                                                <td>ចំរើន</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                                <td >OUM</td>
                                                                <td>CHAMROEUN</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                                                <td>០១ មករា ១៩៦១</td>
                                                                <td class="">ជនជាតិ ៖ ខ្មែរ</td>
                                                                <td class="">សញ្ជាតិ ៖ ខ្មែរ</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                                <td colspan="3" >ទីកន្លែងកំណើត</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                                <td colspan="3" >ទីលំនៅបច្ចុប្បន្ន</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                                <td colspan="3" >លក់ដូរ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានម្ដាយ</div>
                                                    <table class="w-full" style="border-spacing: 0px; " >
                                                        <tbody>
                                                            <tr>
                                                                <td class="w-48 " >ម្ដាយឈ្មោះ</td>
                                                                <td >អ៊ុំ</td>
                                                                <td>ចំរើន</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                                                                <td >OUM</td>
                                                                <td>CHAMROEUN</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                                                                <td>០១ មករា ១៩៦១</td>
                                                                <td class="">ជនជាតិ ៖ ខ្មែរ</td>
                                                                <td class="">សញ្ជាតិ ៖ ខ្មែរ</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                                <td colspan="3" >ទីកន្លែងកំណើត</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                                <td colspan="3" >ទីលំនៅបច្ចុប្បន្ន</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                                <td colspan="3" >មេផ្ទះ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    
                                                <!-- <table class="w-full" style="border-spacing: 0px; " >
                                                    <tbody>
                                                        <tr >
                                                            <td>
                                                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានឪពុក</div>
                                                                <table class="w-full" style="border-spacing: 0px; " >
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="w-48 " >ឈ្មោះ</td>
                                                                            <td >ត្រកូល</td>
                                                                            <td>ឈ្មោះ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ភឡាតាំង</td>
                                                                            <td >ត្រកូល</td>
                                                                            <td>ឈ្មោះ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ថ្ងៃ ខែ ឆ្នាំ កំណើត</td>
                                                                            <td>០១ មករា ១៩៦១</td>
                                                                            <td class="">ជនជាតិ ៖ ខ្មែរ</td>
                                                                            <td class="">សញ្ជាតិ ៖ ខ្មែរ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                                            <td colspan="3" >ទីកន្លែងកំណើត</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                                            <td colspan="3" >ទីលំនៅបច្ចុប្បន្ន</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                                            <td colspan="3" >លក់ដូរ</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ព័ត៌មានម្ដាយ</div>
                                                                <table class="w-full" style="border-spacing: 0px; " >
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="w-48 " >ឈ្មោះ</td>
                                                                            <td >ត្រកូល</td>
                                                                            <td>ឈ្មោះ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ភឡាតាំង</td>
                                                                            <td >ត្រកូល</td>
                                                                            <td>ឈ្មោះ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ថ្ងៃ ខែ ឆ្នាំ កំណើត</td>
                                                                            <td>០១ មករា ១៩៦១</td>
                                                                            <td class="">ជនជាតិ ៖ ខ្មែរ</td>
                                                                            <td class="">សញ្ជាតិ ៖ ខ្មែរ</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >ទីកន្លែងកំណើត</td>
                                                                            <td colspan="3" >ទីកន្លែងកំណើត</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                                                                            <td colspan="3" >ទីលំនៅបច្ចុប្បន្ន</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="w-48 " >មុខរបរបច្ចុប្បន្ន</td>
                                                                            <td colspan="3" >មេផ្ទះ</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table> -->
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <!-- Family Information -->
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >គ. ព័ត៌មានទំនាក់ទំនងក្នុងករណីមានអាសន្ន</div>
                                    <table class="w-full" style="border-spacing: 0px; " >
                                        <tbody>
                                            <tr>
                                                <td class="w-48 " >ឈ្មោះជាភាសារខ្មែរ ៖ </td>
                                                <td >អ៊ុំ</td>
                                                <td>ចំរើន</td>
                                                <td >ប្រុស</td>
                                            </tr>
                                            <tr>
                                                <td class="w-48 " >ទំនាក់ទំនងត្រូវជា ៖ </td>
                                                <td >ប្ដី</td>
                                                <td>មុខរបរ ៖ </td>
                                                <td >មន្ត្រីរាជការ</td>
                                            </tr>
                                            <tr>
                                                <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន ៖ </td>
                                                <td colspan="3" ># ៩០៥ស៊ី ផ្លូវ ០១ ភូមិ បុរី១០០ខ្នង ឃុំ/សង្កាត់ ទឹកថ្លា ស្រុក/ខណ្ឌ  សែនសុខ រាជធានី/ខេត្ត ភ្នំពេញ</td>
                                            </tr>
                                            <tr>
                                                <td class="w-48 " >លេខទូរសព្ទ ៖ </td>
                                                <td >០១២ ៣៩១៨៤៨</td>
                                                <td class="w-48 " >អ៉ីមែល ៖ </td>
                                                <td >chamroeunoum@gmail.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto " >
                            <!-- Family Information -->
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-4 border-b border-gray-200 pb-2 font-btb-black " >ឃ. កំរិតវប្បធម៌ទូទៅ ការបណ្ដុះបណ្ដាលមុខវិជ្ជាជីវៈ និងការបណ្ដុះបណ្ដាលបន្ត</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <!-- Study background -->
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
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " >វិទ្យាល័យ</td>
                                                            <td class="border-b border-gray-100 p-2 " >វិទ្យាល័យទួលទំពូង</td>
                                                            <td class="border-b border-gray-100 p-2 " >ភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " >មធ្យមសិក្សាកម្រិត២</td>
                                                            <td class="border-b border-gray-100 p-2 " >ចំណេះដឹងទូទៅ</td>
                                                            <td class="border-b border-gray-100 p-2 " >០១ មករា ២០០៥</td>
                                                            <td class="border-b border-gray-100 p-2 " >០១ មករា ២០០៩</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="border-b border-gray-100 p-2 " >២. កម្រិតបណ្ដុះបណ្ដាលវិជ្ជាជីវៈមូលដ្ឋាន និងក្រោយមូលដ្ឋាន (សូមបំពេញតាមលំដាប់ថ្មីទៅចាស់)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " >ក្រោយឧត្តម</td>
                                                            <td class="border-b border-gray-100 p-2 " >សកលវិទ្យាល័យភូមិន្ទភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " >ភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " >អនុបណ្ឌិត</td>
                                                            <td class="border-b border-gray-100 p-2 " >វិទ្យាសាស្ត្រកុំព្យូទ័រ</td>
                                                            <td class="border-b border-gray-100 p-2 " >២០០៥</td>
                                                            <td class="border-b border-gray-100 p-2 " >២០០៩</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " >ឧត្តម</td>
                                                            <td class="border-b border-gray-100 p-2 " >សកលវិទ្យាល័យភូមិន្ទភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " >ភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " >បរិញ្ញាបត្រ</td>
                                                            <td class="border-b border-gray-100 p-2 " >វិទ្យាសាស្ត្រកុំព្យូទ័រ</td>
                                                            <td class="border-b border-gray-100 p-2 " >២០០៥</td>
                                                            <td class="border-b border-gray-100 p-2 " >២០០៩</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="border-b border-gray-100 p-2 " >៣. វគ្គបណ្ដុះបណ្ដាលបន្ត និងវគ្គសិក្សា (សូមបំពេញវគ្គសក្សាថ្មី សំខាន់ និងចាំបាច់)</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " colspan="2" >សាលាភូមិន្ទរដ្ឋបាល</td>
                                                            <td class="border-b border-gray-100 p-2 " >ភ្នំពេញ</td>
                                                            <td class="border-b border-gray-100 p-2 " colspan="2" >វគ្គសុក្រឹតកាមន្ត្រីជាន់ខ្ពស់ឆ្នាំ២០២២</td>
                                                            <td class="border-b border-gray-100 p-2 " >ឯកទេសរដ្ឋបាលទូទៅ</td>
                                                            <!-- <td class="border-b border-gray-100 p-2 " >២០០៥</td>
                                                            <td class="border-b border-gray-100 p-2 " >២០០៩</td> -->
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
                                        <tr>
                                            <td class="border-b border-gray-100 p-2 " >អង់គ្លេស</td>
                                            <td class="border-b border-gray-100 p-2 " >A</td>
                                            <td class="border-b border-gray-100 p-2 " >B</td>
                                            <td class="border-b border-gray-100 p-2 " >C</td>
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
                                    <tr>
                                        <td>
                                            <div class="relative w-full font-btb-black " ></div>
                                            <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                <tbody>
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >ថ្ងៃខែឆ្នាំចូលបម្រើក្របខណ្ឌរដ្ឋ ៖ </td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >ថ្ងៃខែឆ្នាំតាំងស៊ុប់ក្នុងក្របខ័ណ្ឌរដ្ឋ ៖ </td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១២</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >ឈ្មោះក្របខណ្ឌ ៖ </td>
                                                        <td class="border-b border-gray-100 p-2 " >ក.៣.៤.</td>
                                                        <td class="border-b border-gray-100 p-2 " >ក្របខណ្ឌ ឋានន្តរស័ក្ត និងថ្នាក់បច្ចុប្បន្ន ៖ </td>
                                                        <td class="border-b border-gray-100 p-2 " >ក.៣.២.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working background in public sector -->
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
                                                        <th >អង្គភាព</th>
                                                        <th >ការិយាល័យ</th>
                                                        <th>មុខតំណែង</th>
                                                        <th >ជំនាញ/បច្ចេកទេស<br/>ក្នុងមុខតំណេង</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១២</td>
                                                        <td class="border-b border-gray-100 p-2 " >ទីស្ដីការគណៈរដ្ឋមន្ត្រី</td>
                                                        <td class="border-b border-gray-100 p-2 " >អគ្គលេខាធិកាដ្ឋានរាជរដ្ឋាភិបាល</td>
                                                        <td class="border-b border-gray-100 p-2 " >ការិយាល័យព័ត៌មានវិទ្យា</td>
                                                        <td class="border-b border-gray-100 p-2 " >មន្ត្រីបច្ចេកទេសព័ត៌មានវិទ្យា</td>
                                                        <td class="border-b border-gray-100 p-2 " >អភិវឌ្ឍកម្មវិធី</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working background in private sector -->
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
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១២</td>
                                                        <td class="border-b border-gray-100 p-2 " >Fourth Sector Innovation</td>
                                                        <td class="border-b border-gray-100 p-2 " >ប្រធានគម្រោងផ្នែកគេហទំព័រ</td>
                                                        <td class="border-b border-gray-100 p-2 " >គ្រប់គ្រងគម្រោងកម្មវិធី</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working - Rank adjustment -->
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
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១២</td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <!-- <td class="border-b border-gray-100 p-2 " >Fourth Sector Innovation</td>
                                                        <td class="border-b border-gray-100 p-2 " >ប្រធានគម្រោងផ្នែកគេហទំព័រ</td>
                                                        <td class="border-b border-gray-100 p-2 " >គ្រប់គ្រងគម្រោងកម្មវិធី</td>
                                                        <td class="border-b border-gray-100 p-2 " >ប្រធានគម្រោងផ្នែកគេហទំព័រ</td>
                                                        <td class="border-b border-gray-100 p-2 " >គ្រប់គ្រងគម្រោងកម្មវិធី</td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working - Rank adjustment base on certificate  -->
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
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១២</td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <td class="border-b border-gray-100 p-2 " ></td>
                                                        <!-- <td class="border-b border-gray-100 p-2 " >Fourth Sector Innovation</td>
                                                        <td class="border-b border-gray-100 p-2 " >ប្រធានគម្រោងផ្នែកគេហទំព័រ</td>
                                                        <td class="border-b border-gray-100 p-2 " >គ្រប់គ្រងគម្រោងកម្មវិធី</td>
                                                        <td class="border-b border-gray-100 p-2 " >ប្រធានគម្រោងផ្នែកគេហទំព័រ</td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working - Pending work -->
                                    <tr>
                                        <td>
                                            <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.៤-ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម / ទំនេរពីមុខងារ (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
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
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១៣</td>
                                                        <td class="border-b border-gray-100 p-2 " >ក្រសួងព័ត៌មាន</td>
                                                        <td class="border-b border-gray-100 p-2 " >២៤ ខែ</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Working - work without salary -->
                                    <tr>
                                        <td>
                                            <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ច.៥-ស្ថានភាពស្ថិតនៅក្នុងភាពទំនេរគ្មានបៀវត្ស (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)</div>
                                            <table class="w-full border border-gray-100 " style="border-spacing: 0px; " >
                                                <thead>
                                                    <tr class="bg-gray-300 " >
                                                        <th class="w-48 " >លេខលិខិត</th>
                                                        <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>ចាប់ផ្ដើម</th>
                                                        <th class="w-48 " >ថ្ងៃខែឆ្នាំ<br/>បញ្ចប់</th>
                                                        <th >ក្រសួង/ស្ថាប័ន</th>
                                                        <th>ចំនួន(ខែ/ឆ្នាំ)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >001</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១៣</td>
                                                        <td class="border-b border-gray-100 p-2 " >ក្រសួងព័ត៌មាន</td>
                                                        <td class="border-b border-gray-100 p-2 " >២៤ ខែ</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-b border-gray-100 p-2 " >002</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០០៩</td>
                                                        <td class="border-b border-gray-100 p-2 " >០១ មករា ២០១១</td>
                                                        <td class="border-b border-gray-100 p-2 " >ក្រសួងព័ត៌មាន</td>
                                                        <td class="border-b border-gray-100 p-2 " >២៤ ខែ</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
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
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!-- Reward & Penalty -->
                                        <tr>
                                            <td>
                                                <div class="relative w-full my-4 border-b border-gray-200 pb-2 font-btb-black " >ឆ.២-ការដាក់វិន័យ</div>
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
                                                        <tr>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                            <td class="border-b border-gray-100 p-2 " ></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                birthCertificateDob ,
                dateFormat
            }
        }
    }
</script>
<style scoped >
</style>