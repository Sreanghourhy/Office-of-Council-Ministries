<template>
    <section class="mb-10 bg-white border border-[#D8DEE8] rounded-sm">
        <div v-if="officer != undefined && officer.people != undefined " class="w-full" >
            <div class="flex items-center justify-between px-4 py-3 border-b border-[#D8DEE8]">
                <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ក. ព័ត៌មានផ្ទាល់ខ្លួន</h3>
            </div>
            <div class="px-4 pb-4">
            <table v-if=" officer.people != undefined && officer.people != null " class="w-full border-collapse" style="border-spacing: 0px;" >
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td rowspan="11" >
                            <div class="relative group mx-auto" style="width: 3.2cm; height: 4.2cm;">
                                <img :src="previewImage || (officer.image != undefined && officer.image != null ? officer.image : ocmLogoUrl)" class="w-full h-full object-cover border border-gray-200" />
                                <!-- Upload overlay -->
                                <div 
                                    class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer"
                                    @click="triggerFileInput"
                                >
                                    <svg class="w-8 h-8 text-white mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                        <circle cx="256" cy="272" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                    </svg>
                                    <span class="text-white text-xs">ប្ដូររូបភាព</span>
                                </div>
                                <!-- Hidden file input -->
                                <input 
                                    type="file" 
                                    ref="fileInput"
                                    accept="image/jpeg,image/png"
                                    class="hidden"
                                    @change="handleFileSelect"
                                />
                                <!-- Upload button (shows when file is selected) -->
                                <div v-if="selectedFile" class="absolute -bottom-10 left-0 right-0 flex justify-center gap-2">
                                    <button 
                                        @click.stop="uploadPhoto"
                                        class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 flex items-center gap-1"
                                        :disabled="isUploading"
                                    >
                                        <svg v-if="isUploading" class="animate-spin w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        រក្សាទុក
                                    </button>
                                    <button 
                                        @click.stop="cancelFileSelect"
                                        class="px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600"
                                    >
                                        បោះបង់
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >ឈ្មោះជាភាសាខ្មែរ</td>
                        <td v-if="!isEditing" >{{ 'គោត្តនាម ៖ ' + officer.people.lastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " + officer.people.firstname }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass(['lastname', 'firstname'])]" >
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <input v-model="editData.lastname" type="text" placeholder="គោត្តនាម" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                                <input v-model="editData.firstname" type="text" placeholder="នាមខ្លួន" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                            </div>
                        </td>
                        <td colspan="2" v-if="!isEditing" >ភេទ ៖ {{ parseInt( officer.people.gender ) == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
                        <td colspan="2" v-if="isEditing" :class="['p-1', changedCellClass('gender')]" >
                            <span class="flex items-center gap-4">
                                <label class="inline-flex items-center gap-1 cursor-pointer">
                                    <input v-model.number="editData.gender" type="radio" :value="1" name="gender" class="rounded-full border-[#D8DEE8]" />
                                    <span class="text-[13px]">ប្រុស</span>
                                </label>
                                <label class="inline-flex items-center gap-1 cursor-pointer">
                                    <input v-model.number="editData.gender" type="radio" :value="0" name="gender" class="rounded-full border-[#D8DEE8]" />
                                    <span class="text-[13px]">ស្រី</span>
                                </label>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >ឈ្មោះជាអក្សរពុម្ពឡាតាំង</td>
                        <td colspan="3" v-if="!isEditing" >{{ 'គោត្តនាម ៖ ' + officer.people.enlastname }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ " នាមខ្លួន ៖ " +  officer.people.enfirstname }}</td>
                        <td colspan="3" v-if="isEditing" :class="['p-1', changedCellClass(['enlastname', 'enfirstname'])]" >
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <input v-model="editData.enlastname" type="text" placeholder="Last Name" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onUppercaseLetterInput(editData, 'enlastname')" />
                                <input v-model="editData.enfirstname" type="text" placeholder="First Name" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onUppercaseLetterInput(editData, 'enfirstname')" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >ថ្ងៃខែឆ្នាំកំណើត</td>
                        <td v-if="!isEditing">{{ ( ( officer.people.dob != null  ) ? $toKhmer( dateFormat( new Date(officer.people.dob) , 'dd-mm-yyyy' ) ) : '' ) }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('dob')]">
                            <input v-model="dobForInput" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                        </td>
                        <td v-if="!isEditing">ជនជាតិ ៖ {{ officer.people.national }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('national')]">
                            <div class="space-y-2">
                                <select v-model="nationalSelection" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @change="onNationalSelectionChange(nationalSelection)">
                                    <option value="khmer">ខ្មែរ</option>
                                    <option value="other">ផ្សេងៗ</option>
                                </select>
                                <input v-if="nationalSelection === 'other'" v-model="editData.national" type="text" placeholder="ជនជាតិ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                            </div>
                        </td>
                        <td v-if="!isEditing">សញ្ជាតិ ៖ {{ officer.people.nationality }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('nationality')]">
                            <div class="space-y-2">
                                <select v-model="nationalitySelection" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @change="onNationalitySelectionChange(nationalitySelection)">
                                    <option value="khmer">ខ្មែរ</option>
                                    <option value="other">ផ្សេងៗ</option>
                                </select>
                                <input v-if="nationalitySelection === 'other'" v-model="editData.nationality" type="text" placeholder="សញ្ជាតិ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >ទីកន្លែងកំណើត</td>
                        <td colspan="3" v-if="!isEditing" >ភូមិ {{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.pob != null  ) ? $toKhmer( officer.people.pob ) : '' ) }}</td>
                        <td colspan="3" v-if="isEditing" :class="['p-1', changedCellClass('pob')]">
                            <textarea v-model="editData.pob" placeholder="ទីកន្លែងកំណើត" class="field-input field-input-textarea w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white resize-y" rows="2"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >អាសយដ្ឋានបច្ចុប្បន្ន</td>
                        <td colspan="3" v-if="!isEditing" >{{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.address != null  ) ? $toKhmer( officer.people.address ) : '' ) }}</td>
                        <td colspan="3" v-if="isEditing" :class="['p-1', changedCellClass('address')]">
                            <textarea v-model="editData.address" placeholder="អាសយដ្ឋានបច្ចុប្បន្ន" class="field-input field-input-textarea w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white resize-y" rows="2"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >អាសយដ្ឋានអចិន្ត្រៃយ៍</td>
                        <td colspan="3" v-if="!isEditing" >{{ ( ( officer != null && officer.people != undefined && officer.people != null && officer.people.current_address != null  ) ? $toKhmer( officer.people.current_address ) : '' ) }}</td>
                        <td colspan="3" v-if="isEditing" :class="['p-1', changedCellClass('current_address')]">
                            <textarea v-model="editData.current_address" placeholder="អាសយដ្ឋានអចិន្ត្រៃយ៍" class="field-input field-input-textarea w-full border border-[#D8DEE8] rounded px-2 py-1.5 text-[13px] bg-white resize-y" rows="2"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >លេខទូរសព្ទ</td>
                        <td v-if="!isEditing" >{{ $toKhmer( officer.people.mobile_phone ) }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('mobile_phone')]">
                            <input v-model="editData.mobile_phone" type="text" inputmode="numeric" placeholder="លេខទូរសព្ទ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onNumericInput(editData, 'mobile_phone')" />
                        </td>
                        <td colspan="2" v-if="!isEditing" >អ៉ីមែល៖ {{ officer.people.email }}</td>
                        <td colspan="2" v-if="isEditing" :class="['p-1', changedCellClass('email')]">
                            <input v-model="editData.email" type="text" placeholder="អ៉ីមែល" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >អត្តលេខមន្ត្រីរាជការ</td>
                        <td colspan="3" v-if="!isEditing" >{{ $toKhmer( officer.code ) }}</td>
                        <td colspan="3" v-if="isEditing" :class="['p-1', changedCellClass('code')]">
                            <input v-model="editData.code" type="text" inputmode="numeric" placeholder="អត្តលេខមន្ត្រីរាជការ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onNumericInput(editData, 'code')" />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-48 " >លេខអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ</td>
                        <td v-if="!isEditing">{{ officer.people.nid ? $toKhmer( officer.people.nid ) : '' }}</td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('nid')]">
                            <input v-model="editData.nid" type="text" inputmode="numeric" placeholder="លេខអត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onNumericInput(editData, 'nid')" />
                        </td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                    <tr v-if="officer.people.passports != null && officer.people.passports != undefined && officer.people.passports.length > 0" >
                        <td class="w-48 " >លេខលិខិតឆ្លងដែន</td>
                        <td>{{ $toKhmer( officer.people.passports[0].number ) }}</td>
                        <td class="">សុពលភាព ៖ {{ $toKhmer( officer.people.passports[0].effective_date ) }}</td>
                        <td class="">ដល់ថ្ងៃ ៖ {{ $toKhmer( officer.people.passports[0].expired_date ) }}</td>
                    </tr>
                    <tr>
                        <td class="w-48 " >កាយសម្បទា</td>
                        <td v-if="!isEditing">
                            <span class="flex items-center gap-4">
                                <span class="text-[13px]">{{ parseInt( officer.people.body_condition ) == 0 ? 'គ្រប់គ្រាន់' : 'ពិការភាព' }}</span>
                            </span>
                        </td>
                        <td v-if="isEditing" :class="['p-1', changedCellClass('body_condition')]">
                            <span class="flex items-center gap-4">
                                <label class="inline-flex items-center gap-1 cursor-pointer">
                                    <input v-model.number="editData.body_condition" type="radio" :value="0" name="body_condition" class="rounded-full border-[#D8DEE8]" />
                                    <span class="text-[13px]">គ្រប់គ្រាន់</span>
                                </label>
                                <label class="inline-flex items-center gap-1 cursor-pointer">
                                    <input v-model.number="editData.body_condition" type="radio" :value="1" name="body_condition" class="rounded-full border-[#D8DEE8]" />
                                    <span class="text-[13px]">ពិការភាព</span>
                                </label>
                            </span>
                        </td>
                        <td colspan="2" v-if="!isEditing">ប្រភេទពិការភាព ៖ {{ parseInt( officer.people.body_condition ) == 1 ? officer.people.body_condition_desp : '' }}</td>
                        <td colspan="2" v-if="isEditing" :class="['p-1', changedCellClass('body_condition_desp')]">
                            <input v-model="editData.body_condition_desp" type="text" placeholder="ប្រភេទពិការភាព" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" :disabled="parseInt(editData.body_condition) != 1" />
                        </td>
                    </tr>
                    <!-- Birth Certificate Section (career-history style) -->
                    <tr>
                        <td colspan="5" class="pt-4">
                            <div class="w-full py-2 border-b border-[#D8DEE8]">
                                <h3 class="text-[15px] font-semibold text-[#1E3A8A]">សំបុត្រកំណើត / បញ្ជាក់កំណើត</h3>
                            </div>
                        </td>
                    </tr>
                        <tr>
                            <td class="w-48 p-1">លេខសំបុត្រ</td>
                            <td :class="['p-1', changedCellClass('birth_number')]">
                                <input v-model="birthCertData.birth_number" type="text" inputmode="numeric" placeholder="លេខសំបុត្រ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onNumericInput(birthCertData, 'birth_number')" />
                            </td>
                            <td class="w-48 p-1">លេខសៀវភៅ</td>
                            <td colspan="2" :class="['p-1', changedCellClass('book_number')]">
                                <input v-model="birthCertData.book_number" type="text" inputmode="numeric" placeholder="លេខសៀវភៅ" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" @input="onNumericInput(birthCertData, 'book_number')" />
                            </td>
                        </tr>
                        <tr>
                            <td class="w-48 p-1">ថ្ងៃខែឆ្នាំ</td>
                            <td :class="['p-1', changedCellClass('year')]">
                                <input v-model="birthCertYearForInput" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                            </td>
                            <td class="w-48 p-1">ថ្ងៃខែឆ្នាំចុះលេខ</td>
                            <td colspan="2" :class="['p-1', changedCellClass('issued_date')]">
                                <input v-model="birthCertIssuedDateForInput" type="date" class="field-input w-full border border-[#D8DEE8] rounded px-2 text-[13px] bg-white" />
                            </td>
                        </tr>
                        <tr>
                            <td class="w-48 p-1">ខេត្ត/ក្រុង</td>
                            <td :class="['p-1', changedCellClass('province_id')]">
                                <n-select
                                    v-model:value="birthCertData.province_id"
                                    filterable
                                    clearable
                                    size="small"
                                    class="w-full uniform-select"
                                    placeholder="ខេត្ត ក្រុង"
                                    :options="bcProvinceOptions"
                                    @update:value="bcHandleProvinceChange"
                                />
                            </td>
                            <td class="w-48 p-1">ស្រុក/ខណ្ឌ</td>
                            <td colspan="2" :class="['p-1', changedCellClass('district_id')]">
                                <n-select
                                    v-model:value="birthCertData.district_id"
                                    filterable
                                    clearable
                                    :disabled="selectedProvinceId <= 0"
                                    size="small"
                                    class="w-full uniform-select"
                                    :placeholder="selectedProvinceId > 0 ? 'ស្រុក ខណ្ឌ' : 'សូមជ្រើសរើស ខេត្ត/ក្រុង ជាមុនសិន'"
                                    :options="filteredBcDistrictOptions"
                                    @update:value="bcHandleDistrictChange"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td class="w-48 p-1">ឃុំ/សង្កាត់</td>
                            <td colspan="4" :class="['p-1', changedCellClass('commune_id')]">
                                <n-select
                                    v-model:value="birthCertData.commune_id"
                                    filterable
                                    clearable
                                    :disabled="selectedDistrictId <= 0"
                                    size="small"
                                    class="w-full uniform-select"
                                    :placeholder="selectedDistrictId > 0 ? 'ឃុំ សង្កាត់' : 'សូមជ្រើសរើស ស្រុក/ខណ្ឌ ជាមុនសិន'"
                                    :options="filteredBcCommuneOptions"
                                />
                            </td>
                        </tr>
                        <!-- Attached birth certificate file (edit mode) -->
                        <tr>
                            <td class="w-48 p-1 align-top pt-2">ឯកសារភ្ជាប់</td>
                            <td colspan="4" :class="['p-1', changedCellClass('birth_cert_file')] + ' relative ' ">
                                <div class="certificate-upload">
                                    <label
                                        for="birth-certificate-upload"
                                        class="certificate-upload-trigger"
                                    >
                                        ឯកសារ
                                    </label>
                                    <input
                                        id="birth-certificate-upload"
                                        type="file"
                                        accept="image/*,.pdf,application/pdf"
                                        class="hidden"
                                        @change="onBirthCertFileChange"
                                    />
                                    <span class="certificate-file-name" :title="birthCertFileName || 'មិនទាន់ជ្រើសរើសឯកសារ'">
                                        {{ shortenFileName(birthCertFileName) }}
                                    </span>
                                    <span
                                        v-if="birthCertFileName"
                                        class="certificate-file-type"
                                    >
                                        {{ birthCertFileTypeLabel }}
                                    </span>
                                    <button
                                        v-if="birthCertFileName"
                                        type="button"
                                        class="certificate-upload-clear"
                                        @click="clearBirthCertFile"
                                    >
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M4.72 4.72a.75.75 0 0 1 1.06 0L10 8.94l4.22-4.22a.75.75 0 1 1 1.06 1.06L11.06 10l4.22 4.22a.75.75 0 1 1-1.06 1.06L10 11.06l-4.22 4.22a.75.75 0 1 1-1.06-1.06L8.94 10 4.72 5.78a.75.75 0 0 1 0-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <n-tooltip trigger="hover" class="" >
                                    <template #trigger>
                                        <svg
                                            @click="canDownloadBirthCert ? downloadBirthCert() : false"
                                            :class="[
                                                'w-6 h-6 absolute top-1 right-8',
                                                canDownloadBirthCert ? 'text-[#2563EB] cursor-pointer' : 'text-[#CBD5E1] cursor-not-allowed'
                                            ]"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 3v11m0 0l4-4m-4 4l-4-4M4 17.5v.75A1.75 1.75 0 0 0 5.75 20h12.5A1.75 1.75 0 0 0 20 18.25v-.75"
                                            />
                                        </svg>
                                    </template>
                                    Download attachment
                                </n-tooltip>
                                <n-tooltip trigger="hover" class="" >
                                    <template #trigger>
                                    <svg 
                                        @click="canPreviewBirthCert ? togglePdfModal(birthCertPreviewRecord || birthCertData) : false"
                                        :class="[
                                            'pdf-previewer w-6 h-6 absolute right-0 top-1',
                                            canPreviewBirthCert ? 'text-red-500 cursor-pointer' : 'text-[#CBD5E1] cursor-not-allowed'
                                        ]"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M509.2 490.8c-.7-1.3-1.4-1.9-2.2-2c-2.9 3.3-2.2 31.5 2.7 51.4c4-13.6 4.7-40.5-.5-49.4zm-1.6 120.5c-7.7 20-18.8 47.3-32.1 71.4c4-1.6 8.1-3.3 12.3-5c17.6-7.2 37.3-15.3 58.9-20.2c-14.9-11.8-28.4-27.7-39.1-46.2z" fill-opacity=".15" fill="currentColor"></path><path d="M534 352V136H232v752h560V394H576a42 42 0 0 1-42-42zm55 287.6c16.1-1.9 30.6-2.8 44.3-2.3c12.8.4 23.6 2 32 5.1c.2.1.3.1.5.2c.4.2.8.3 1.2.5c.5.2 1.1.4 1.6.7c.1.1.3.1.4.2c4.1 1.8 7.5 4 10.1 6.6c9.1 9.1 11.8 26.1 6.2 39.6c-3.2 7.7-11.7 20.5-33.3 20.5c-21.8 0-53.9-9.7-82.1-24.8c-25.5 4.3-53.7 13.9-80.9 23.1c-5.8 2-11.8 4-17.6 5.9c-38 65.2-66.5 79.4-84.1 79.4c-4.2 0-7.8-.9-10.8-2c-6.9-2.6-12.8-8-16.5-15c-.9-1.7-1.6-3.4-2.2-5.2c-1.6-4.8-2.1-9.6-1.3-13.6l.6-2.7c.1-.2.1-.4.2-.6c.2-.7.4-1.4.7-2.1c0-.1.1-.2.1-.3c4.1-11.9 13.6-23.4 27.7-34.6c12.3-9.8 27.1-18.7 45.9-28.4c15.9-28 37.6-75.1 51.2-107.4c-10.8-41.8-16.7-74.6-10.1-98.6c.9-3.3 2.5-6.4 4.6-9.1c.2-.2.3-.4.5-.6c.1-.1.1-.2.2-.2c6.3-7.5 16.9-11.9 28.1-11.5c16.6.7 29.7 11.5 33 30.1c1.7 8 2.2 16.5 1.9 25.7v.7c0 .5 0 1-.1 1.5c-.7 13.3-3 26.6-7.3 44.7c-.4 1.6-.8 3.2-1.2 5.2l-1 4.1l-.1.3c.1.2.1.3.2.5l1.8 4.5c.1.3.3.7.4 1c.7 1.6 1.4 3.3 2.1 4.8v.1c8.7 18.8 19.7 33.4 33.9 45.1c4.3 3.5 8.9 6.7 13.9 9.8c1.8-.5 3.5-.7 5.3-.9z" fill-opacity=".15" fill="currentColor"></path><path d="M391.5 761c5.7-4.4 16.2-14.5 30.1-34.7c-10.3 9.4-23.4 22.4-30.1 34.7zm270.9-83l.2-.3h.2c.6-.4.5-.7.4-.9c-.1-.1-4.5-9.3-45.1-7.4c35.3 13.9 43.5 9.1 44.3 8.6z" fill-opacity=".15" fill="currentColor"></path><path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM602 137.8L790.2 326H602V137.8zM792 888H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path><path d="M535.9 585.3c-.8-1.7-1.5-3.3-2.2-4.9c-.1-.3-.3-.7-.4-1l-1.8-4.5c-.1-.2-.1-.3-.2-.5l.1-.3l.2-1.1c4-16.3 8.6-35.3 9.4-54.4v-.7c.3-8.6-.2-17.2-2-25.6c-3.8-21.3-19.5-29.6-32.9-30.2c-11.3-.5-21.8 4-28.1 11.4c-.1.1-.1.2-.2.2c-.2.2-.4.4-.5.6c-2.1 2.7-3.7 5.8-4.6 9.1c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.4-51.2 107.4v.1c-27.7 14.3-64.1 35.8-73.6 62.9c0 .1-.1.2-.1.3c-.2.7-.5 1.4-.7 2.1c-.1.2-.1.4-.2.6c-.2.9-.5 1.8-.6 2.7c-.9 4-.4 8.8 1.3 13.6c.6 1.8 1.3 3.5 2.2 5.2c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-2.6-2.6-6-4.8-10.1-6.6c-.1-.1-.3-.1-.4-.2c-.5-.2-1.1-.4-1.6-.7c-.4-.2-.8-.3-1.2-.5c-.2-.1-.3-.1-.5-.2c-16.2-5.8-41.7-6.7-76.3-2.8l-5.3.6c-5-3-9.6-6.3-13.9-9.8c-14.2-11.3-25.1-25.8-33.8-44.7zM391.5 761c6.7-12.3 19.8-25.3 30.1-34.7c-13.9 20.2-24.4 30.3-30.1 34.7zM507 488.8c.8.1 1.5.7 2.2 2c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4zm-19.2 188.9c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2zm175.4-.9c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4z" fill="currentColor"></path></svg>
                                    </template>
                                    មើលឯកសារយោង។
                                </n-tooltip>
                            </td>
                        </tr>
                </tbody>
            </table>
            </div>
        </div> 
        <div v-if="officer==undefined" class="w-full p-8 text-center text-[#DC2626] text-[13px]">សូមបញ្ជាកព័ត៌មានមន្ត្រីជាមុនសិន។</div>
        <pdf-preview v-model:model="model" v-model:record="selectedCertificate" v-bind:show="pdfToggle" :onClose="togglePdfModal"/>
    </section>
</template>
<script>
import dateFormat from 'dateformat'
import { ref, reactive, watch, computed, onMounted, onBeforeUnmount } from 'vue'
import { useStore } from 'vuex'
import ocmLogoUrl from '@assets/logo.svg'
import PdfPreview from './pdfpreview.vue'

export default {
    name: 'ProfileOfficer',
    emits: ['changed'],
    props: {
        // ជាការប្រកាសអថេរ ពីសមាសធាតុ មេ និងកូន
        officer: {
            type: Object,
            default: undefined
        }
    },
    components: {
        PdfPreview
    },
    // Composition way
    setup(props, { emit }) {
        const store = useStore()
        const isEditing = ref(true)

        const notify = {
            warning: (opts) => { window.alert(opts?.content || opts?.title || '') },
            success: () => {},
            error: (opts) => { window.alert(opts?.content || opts?.title || '') }
        }
        const KHMER_OPTION_VALUE = 'khmer'
        const OTHER_OPTION_VALUE = 'other'
        const KHMER_LABEL = 'ខ្មែរ'
        
        // Profile picture upload refs
        const fileInput = ref(null)
        const selectedFile = ref(null)
        const previewImage = ref(null)
        const isUploading = ref(false)
        const nationalSelection = ref(KHMER_OPTION_VALUE)
        const nationalitySelection = ref(KHMER_OPTION_VALUE)
        
        // Edit data reactive object
        const editData = reactive({
            id: null,
            people_id: null,
            code: '',
            lastname: '',
            firstname: '',
            enlastname: '',
            enfirstname: '',
            gender: 1,
            dob: null,
            national: '',
            nationality: '',
            pob: '',
            address: '',
            current_address: '',
            mobile_phone: '',
            email: '',
            body_condition: 0,
            body_condition_desp: '' ,
            nid: ''
        })

        const dobForInput = computed({
            get () {
                if (!editData.dob) return ''
                const d = new Date(editData.dob)
                return Number.isNaN(d.getTime()) ? '' : dateFormat(d, 'yyyy-mm-dd')
            },
            set (v) {
                editData.dob = v ? new Date(v).getTime() : null
            }
        })

        const personalFieldKeys = [
            'code',
            'lastname',
            'firstname',
            'enlastname',
            'enfirstname',
            'gender',
            'dob',
            'national',
            'nationality',
            'pob',
            'address',
            'current_address',
            'mobile_phone',
            'email',
            'body_condition',
            'body_condition_desp',
            'nid'
        ]
        const birthCertFieldKeys = [
            'birth_number',
            'book_number',
            'year',
            'issued_date',
            'province_id',
            'district_id',
            'commune_id',
            'birth_cert_file'
        ]
        const trackedFieldKeys = [...personalFieldKeys, ...birthCertFieldKeys]
        const savedSnapshot = ref('{}')

        function toDateString(ms) {
            if (ms === null || ms === undefined || ms === '') return ''
            const d = new Date(ms)
            if (Number.isNaN(d.getTime())) return ''
            return dateFormat(d, 'yyyy-mm-dd')
        }

        function normalizeString(value) {
            if (value === null || value === undefined) return ''
            return String(value)
        }

        function normalizeNumber(value, fallback = 0) {
            const parsed = parseInt(value, 10)
            return Number.isNaN(parsed) ? fallback : parsed
        }

        function normalizeNullableNumber(value) {
            if (value === null || value === undefined || value === '') return null
            const parsed = parseInt(value, 10)
            return Number.isNaN(parsed) ? null : parsed
        }

        function sanitizeDigits(value) {
            return String(value ?? '').replace(/\D+/g, '')
        }

        function sanitizeUppercaseLetters(value) {
            return String(value ?? '')
                .toUpperCase()
                .replace(/[^A-Z\s]+/g, '')
        }

        function onNumericInput(target, key) {
            if (!target || !key) return
            target[key] = sanitizeDigits(target[key])
        }

        function onUppercaseLetterInput(target, key) {
            if (!target || !key) return
            target[key] = sanitizeUppercaseLetters(target[key])
        }

        function syncSelectionField(fieldKey, selectionRef, rawValue) {
            const normalized = normalizeString(rawValue).trim()
            if (normalized === '' || normalized === KHMER_LABEL) {
                selectionRef.value = KHMER_OPTION_VALUE
                editData[fieldKey] = KHMER_LABEL
                return
            }

            selectionRef.value = OTHER_OPTION_VALUE
            editData[fieldKey] = rawValue || ''
        }

        function onNationalSelectionChange(value) {
            nationalSelection.value = value
            if (value === KHMER_OPTION_VALUE) {
                editData.national = KHMER_LABEL
            } else if (normalizeString(editData.national).trim() === KHMER_LABEL) {
                editData.national = ''
            }
        }

        function onNationalitySelectionChange(value) {
            nationalitySelection.value = value
            if (value === KHMER_OPTION_VALUE) {
                editData.nationality = KHMER_LABEL
            } else if (normalizeString(editData.nationality).trim() === KHMER_LABEL) {
                editData.nationality = ''
            }
        }

        function currentBirthCertFileSnapshot() {
            if (birthCertFile.value) {
                return `local:${birthCertFile.value.name}:${birthCertFile.value.size}:${birthCertFile.value.lastModified}`
            }
            const storedPdf = props.officer?.people?.birth_certificate?.pdf
            return `stored:${normalizeString(storedPdf)}`
        }

        function createSnapshot() {
            return {
                code: normalizeString(editData.code),
                lastname: normalizeString(editData.lastname),
                firstname: normalizeString(editData.firstname),
                enlastname: normalizeString(editData.enlastname),
                enfirstname: normalizeString(editData.enfirstname),
                gender: normalizeNumber(editData.gender, 1),
                dob: toDateString(editData.dob),
                national: normalizeString(editData.national),
                nationality: normalizeString(editData.nationality),
                pob: normalizeString(editData.pob),
                address: normalizeString(editData.address),
                current_address: normalizeString(editData.current_address),
                mobile_phone: normalizeString(editData.mobile_phone),
                email: normalizeString(editData.email),
                body_condition: normalizeNumber(editData.body_condition, 0),
                body_condition_desp: normalizeString(editData.body_condition_desp),
                nid: normalizeString(editData.nid),
                birth_number: normalizeString(birthCertData.birth_number),
                book_number: normalizeString(birthCertData.book_number),
                year: toDateString(birthCertData.year),
                issued_date: toDateString(birthCertData.issued_date),
                province_id: normalizeNullableNumber(birthCertData.province_id),
                district_id: normalizeNullableNumber(birthCertData.district_id),
                commune_id: normalizeNullableNumber(birthCertData.commune_id),
                birth_cert_file: currentBirthCertFileSnapshot() ,
                pdf: birthCertData.pdf 
            }
        }

        const changedFields = computed(() => {
            let saved = {}
            try {
                saved = JSON.parse(savedSnapshot.value || '{}')
            } catch (err) {
                saved = {}
            }
            const current = createSnapshot()
            const flags = {}
            for (const key of trackedFieldKeys) {
                flags[key] = JSON.stringify(current[key]) !== JSON.stringify(saved[key])
            }
            return flags
        })

        const hasUnsavedChanges = computed(() => trackedFieldKeys.some((key) => changedFields.value[key] === true))

        function changedCellClass(keys) {
            const fieldList = Array.isArray(keys) ? keys : [keys]
            return fieldList.some((key) => changedFields.value[key] === true) ? 'changed-cell' : ''
        }

        function markSaved() {
            savedSnapshot.value = JSON.stringify(createSnapshot())
            emit('changed', false)
        }

        // Initialize edit data from officer prop
        const initializeEditData = () => {
            if (props.officer && props.officer.people) {
                editData.id = props.officer.id
                editData.people_id = props.officer.people.id
                editData.code = props.officer.code || ''
                editData.lastname = props.officer.people.lastname || ''
                editData.firstname = props.officer.people.firstname || ''
                editData.enlastname = props.officer.people.enlastname || ''
                editData.enfirstname = props.officer.people.enfirstname || ''
                editData.gender = props.officer.people.gender ?? 1
                editData.dob = props.officer.people.dob ? new Date(props.officer.people.dob).getTime() : null
                syncSelectionField('national', nationalSelection, props.officer.people.national)
                syncSelectionField('nationality', nationalitySelection, props.officer.people.nationality)
                editData.pob = props.officer.people.pob || ''
                editData.address = props.officer.people.address || ''
                editData.current_address = props.officer.people.current_address || ''
                editData.mobile_phone = props.officer.people.mobile_phone || ''
                editData.email = props.officer.people.email || ''
                editData.body_condition = props.officer.people.body_condition ?? 0
                editData.body_condition_desp = props.officer.people.body_condition_desp || ''
                editData.nid = props.officer.people.nid || ''
            }
        }

        // Toggle edit mode
        const toggleEdit = () => {
            isEditing.value = true
        }

        // Cancel edit
        const cancelEdit = () => {
            initializeEditData()
        }

        // Save changes
        const save = async ({ silent = false, markSavedAfterSuccess = true } = {}) => {
            try {
                // Validate required fields
                if (!editData.lastname || !editData.firstname) {
                    notify.warning({
                        title: 'ពិនិត្យព័ត៌មាន',
                        content: 'សូមបំពេញឈ្មោះជាភាសាខ្មែរ',
                        duration: 2000
                    })
                    return false
                }

                if (!editData.enlastname || !editData.enfirstname) {
                    notify.warning({
                        title: 'ពិនិត្យព័ត៌មាន',
                        content: 'សូមបំពេញឈ្មោះជាអក្សរឡាតាំង',
                        duration: 2000
                    })
                    return false
                }

                if (nationalSelection.value === OTHER_OPTION_VALUE && !normalizeString(editData.national).trim()) {
                    notify.warning({
                        title: 'ព័ត៌មានផ្ទាល់ខ្លួន',
                        content: 'សូមបំពេញជនជាតិ',
                        duration: 2000
                    })
                    return false
                }

                if (nationalitySelection.value === OTHER_OPTION_VALUE && !normalizeString(editData.nationality).trim()) {
                    notify.warning({
                        title: 'ព័ត៌មានផ្ទាល់ខ្លួន',
                        content: 'សូមបំពេញសញ្ជាតិ',
                        duration: 2000
                    })
                    return false
                }

                editData.national = nationalSelection.value === KHMER_OPTION_VALUE
                    ? KHMER_LABEL
                    : normalizeString(editData.national).trim()
                editData.nationality = nationalitySelection.value === KHMER_OPTION_VALUE
                    ? KHMER_LABEL
                    : normalizeString(editData.nationality).trim()

                // Update people data (backend expects people_id, officer_id, user_id for validation)
                const peopleResponse = await store.dispatch('people/update', {
                    id: editData.people_id,
                    people_id: editData.people_id,
                    officer_id: props.officer?.id,
                    user_id: store.state.auth?.user?.id,
                    lastname: editData.lastname,
                    firstname: editData.firstname,
                    enlastname: editData.enlastname,
                    enfirstname: editData.enfirstname,
                    gender: editData.gender,
                    dob: editData.dob ? dateFormat(new Date(editData.dob), 'yyyy-mm-dd') : null,
                    national: editData.national,
                    nationality: editData.nationality,
                    pob: editData.pob,
                    address: editData.address,
                    current_address: editData.current_address,
                    mobile_phone: editData.mobile_phone,
                    email: editData.email,
                    body_condition: editData.body_condition,
                    body_condition_desp: editData.body_condition_desp,
                    nid: editData.nid
                })

                // Update officer code if changed
                if (editData.code !== props.officer.code) {
                    await store.dispatch('officer/update', {
                        id: editData.id,
                        code: editData.code
                    })
                }

                if (peopleResponse.data.ok === true || peopleResponse.data.user != null) {
                    if (!silent) {
                        notify.success({
                            title: 'រក្សារទុករួចរាល់',
                            content: 'បានរក្សារទុកព័ត៌មានផ្ទាល់ខ្លួនរួចរាល់។',
                            duration: 2000
                        })
                    }
                    
                    const savedPeople = peopleResponse.data?.record || {}

                    // Update the officer prop data
                    Object.assign(props.officer.people, {
                        lastname: savedPeople.lastname ?? editData.lastname,
                        firstname: savedPeople.firstname ?? editData.firstname,
                        enlastname: savedPeople.enlastname ?? editData.enlastname,
                        enfirstname: savedPeople.enfirstname ?? editData.enfirstname,
                        gender: savedPeople.gender ?? editData.gender,
                        dob: savedPeople.dob ?? (editData.dob ? dateFormat(new Date(editData.dob), 'yyyy-mm-dd') : null),
                        national: savedPeople.national ?? editData.national,
                        nationality: savedPeople.nationality ?? editData.nationality,
                        pob: savedPeople.pob ?? editData.pob,
                        address: savedPeople.address ?? editData.address,
                        current_address: savedPeople.current_address ?? editData.current_address,
                        mobile_phone: savedPeople.mobile_phone ?? editData.mobile_phone,
                        email: savedPeople.email ?? editData.email,
                        body_condition: savedPeople.body_condition ?? editData.body_condition,
                        body_condition_desp: savedPeople.body_condition_desp ?? editData.body_condition_desp,
                        nid: savedPeople.nid ?? editData.nid
                    })
                    
                    if (editData.code !== props.officer.code) {
                        props.officer.code = editData.code
                    }

                    if (markSavedAfterSuccess) {
                        markSaved()
                    }
                    return true
                } else {
                    notify.error({
                        title: 'មានបញ្ហា',
                        content: peopleResponse.data.message || 'មានបញ្ហាក្នុងការរក្សារទុកព័ត៌មាន',
                        duration: 3000
                    })
                    return false
                }
            } catch (error) {
                console.error('Error saving profile:', error)
                notify.error({
                    title: 'មានបញ្ហា',
                    content: 'មានបញ្ហាក្នុងការរក្សារទុកព័ត៌មាន។ សូមព្យាយាមម្តងទៀត។',
                    duration: 3000
                })
                return false
            }
        }

        function cancelChanges() {
            initializeEditData()
            initializeBirthCertData()
            clearBirthCertFile()
            markSaved()
        }

        async function persistChanges() {
            const shouldSavePersonal = personalFieldKeys.some((key) => changedFields.value[key] === true)
            const shouldSaveBirthCert = birthCertFieldKeys.some((key) => changedFields.value[key] === true)
            if (!shouldSavePersonal && !shouldSaveBirthCert) return true

            if (shouldSavePersonal) {
                const personalSaved = await save({ silent: true, markSavedAfterSuccess: false })
                if (!personalSaved) return false
            }

            if (shouldSaveBirthCert) {
                const birthCertSaved = await saveBirthCert({ silent: true, markSavedAfterSuccess: false })
                if (!birthCertSaved) return false
            }

            markSaved()
            return true
        }

        // Profile picture upload functions
        const triggerFileInput = () => {
            if (fileInput.value) {
                fileInput.value.click()
            }
        }

        const handleFileSelect = (event) => {
            const file = event.target.files[0]
            if (!file) return

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png']
            if (!allowedTypes.includes(file.type)) {
                notify.error({
                    title: 'ប្រភេទឯកសារមិនត្រឹមត្រូវ',
                    content: 'សូមជ្រើសរើសរូបភាពប្រភេទ JPG ឬ PNG។',
                    duration: 3000
                })
                return
            }

            // Validate file size (max 5MB)
            const maxSize = 5 * 1024 * 1024
            if (file.size > maxSize) {
                notify.error({
                    title: 'ទំហំឯកសារធំពេក',
                    content: 'ទំហំរូបភាពមិនអាចលើសពី ៥ មេកាបៃ។',
                    duration: 3000
                })
                return
            }

            selectedFile.value = file

            // Create preview
            const reader = new FileReader()
            reader.onload = (e) => {
                previewImage.value = e.target.result
            }
            reader.readAsDataURL(file)
        }

        const cancelFileSelect = () => {
            selectedFile.value = null
            previewImage.value = null
            if (fileInput.value) {
                fileInput.value.value = ''
            }
        }

        const uploadPhoto = async () => {
            if (!selectedFile.value || !props.officer) return

            // Prefer the officer's own user id; fall back to authenticated user
            const targetUserId = props.officer.user?.id || store.state.auth?.user?.id
            if (!targetUserId) {
                notify.error({
                    title: 'មានបញ្ហា',
                    content: 'រកមិនឃើញគណនីអ្នកប្រើប្រាស់សម្រាប់ដាក់រូបភាព។',
                    duration: 3000
                })
                return
            }

            isUploading.value = true

            try {
                const formData = new FormData()
                formData.append('id', targetUserId)
                formData.append('files', selectedFile.value, selectedFile.value.name)

                // Use the shared user profile photo endpoint:
                // POST /users/profile/photo/change
                const response = await store.dispatch('user/uploadProfilePicture', formData)

                if (response.data && response.data.record) {
                    const record = response.data.record

                    notify.success({
                        title: 'ជោគជ័យ',
                        content: 'បានផ្លាស់ប្ដូររូបភាពរួចរាល់។',
                        duration: 2000
                    })

                    const avatarUrl = record.avatar_url || null
                    if (avatarUrl) {
                        if (props.officer.user) {
                            props.officer.user.avatar_url = avatarUrl
                        }
                        // Keep using officer.image for the card/profile photo
                        props.officer.image = avatarUrl
                    }

                    cancelFileSelect()
                } else {
                    notify.error({
                        title: 'មានបញ្ហា',
                        content: response.data?.message || 'មានបញ្ហាក្នុងការផ្លាស់ប្ដូររូបភាព។',
                        duration: 3000
                    })
                }
            } catch (error) {
                console.error('Upload error:', error)
                notify.error({
                    title: 'មានបញ្ហា',
                    content: 'មានបញ្ហាក្នុងការផ្លាស់ប្ដូររូបភាព។ សូមព្យាយាមម្តងទៀត។',
                    duration: 3000
                })
            } finally {
                isUploading.value = false
            }
        }

        // ============ Birth Certificate Editing ============
        const bcSelectedProvince = ref(null)
        const bcSelectedDistrict = ref(null)
        const birthCertFile = ref(null)
        const birthCertLocalPreviewUrl = ref('')
        const locationLoading = ref(false)

        function extractBirthCertDisplayFileName(value) {
            const rawValue = typeof value === 'string' ? value : ''
            if (!rawValue) return ''
            const withoutQuery = rawValue.split('?')[0].split('#')[0]
            const parts = withoutQuery.split(/[/\\]/)
            const fileName = parts[parts.length - 1] || ''
            const displayName = fileName.replace(/^\d+-/, '') || fileName
            try {
                return decodeURIComponent(displayName)
            } catch (error) {
                return displayName
            }
        }

        const birthCertFileName = computed(() => {
            if (birthCertFile.value) return birthCertFile.value.name
            const bc = props.officer?.people?.birth_certificate
            if (bc?.pdf) {
                const savedFileName = extractBirthCertDisplayFileName(bc.pdf)
                if (savedFileName) return savedFileName
                return 'birth-certificate.pdf'
                return extractBirthCertDisplayFileName(bc.pdf) || 'áž¯áž€ážŸáž¶ážšáž”áž¶áž“áž—áŸ’áž‡áž¶áž”áŸ‹'
                const p = typeof bc.pdf === 'string' ? bc.pdf : ''
                const parts = p.split(/[/\\]/)
                return parts[parts.length - 1] || 'ឯកសារបានភ្ជាប់'
            }
            return ''
        })

        const shortenFileName = (name) => {
            const value = name || 'មិនទាន់ជ្រើសរើសឯកសារ'
            const max = 24
            if (value.length <= max) return value
            const head = value.slice(0, 12)
            const tail = value.slice(-8)
            return `${head}…${tail}`
        }

        const birthCertFileTypeLabel = computed(() => {
            if (!birthCertFile.value) return ''
            const t = birthCertFile.value.type
            if (t === 'application/pdf') return 'PDF'
            if (t && t.startsWith('image/')) return 'IMG'
            return 'FILE'
        })

        function onBirthCertFileChange(event) {
            const file = event?.target?.files?.[0]
            if (!file) return
            if (birthCertLocalPreviewUrl.value) {
                window.URL.revokeObjectURL(birthCertLocalPreviewUrl.value)
            }
            birthCertFile.value = file
            birthCertLocalPreviewUrl.value = window.URL.createObjectURL(file)
            event.target.value = ''
        }

        function clearBirthCertFile() {
            if (birthCertLocalPreviewUrl.value) {
                window.URL.revokeObjectURL(birthCertLocalPreviewUrl.value)
                birthCertLocalPreviewUrl.value = ''
            }
            birthCertFile.value = null
            const input = document.getElementById('birth-certificate-upload')
            if (input) input.value = ''
        }

        onBeforeUnmount(() => {
            if (birthCertLocalPreviewUrl.value) {
                window.URL.revokeObjectURL(birthCertLocalPreviewUrl.value)
            }
        })

        // Birth certificate data
        const birthCertData = reactive({
            id: null,
            people_id: null,
            birth_number: '',
            book_number: '',
            year: null,
            issued_date: null,
            province_id: null,
            district_id: null,
            commune_id: null,
            pdf: null
        })

        const birthCertYearForInput = computed({
            get () {
                if (!birthCertData.year) return ''
                const d = new Date(birthCertData.year)
                return Number.isNaN(d.getTime()) ? '' : dateFormat(d, 'yyyy-mm-dd')
            },
            set (v) {
                birthCertData.year = v ? new Date(v).getTime() : null
            }
        })

        const birthCertIssuedDateForInput = computed({
            get () {
                if (!birthCertData.issued_date) return ''
                const d = new Date(birthCertData.issued_date)
                return Number.isNaN(d.getTime()) ? '' : dateFormat(d, 'yyyy-mm-dd')
            },
            set (v) {
                birthCertData.issued_date = v ? new Date(v).getTime() : null
            }
        })

        function getProvinceRecords() {
            return store.getters['province/records']?.all || []
        }

        function getDistrictRecords() {
            return store.getters['district/records']?.all || []
        }

        function getCommuneRecords() {
            return store.getters['commune/records']?.all || []
        }

        function getVillageRecords() {
            return store.getters['village/records']?.all || []
        }

        async function ensureLocationRecordsLoaded() {
            if (locationLoading.value) return

            const hasProvince = getProvinceRecords().length > 0
            const hasDistrict = getDistrictRecords().length > 0
            const hasCommune = getCommuneRecords().length > 0
            if (hasProvince && hasDistrict && hasCommune) return

            locationLoading.value = true
            try {
                const res = await store.dispatch('province/pdcv')
                const provinces = Array.isArray(res?.data?.provinces) ? res.data.provinces : []
                const districts = Array.isArray(res?.data?.districts) ? res.data.districts : []
                const communes = Array.isArray(res?.data?.communes) ? res.data.communes : []
                const villages = Array.isArray(res?.data?.villages) ? res.data.villages : []

                if (provinces.length > 0) store.commit('province/setAllRecords', provinces)
                if (districts.length > 0) store.commit('district/setAllRecords', districts)
                if (communes.length > 0) store.commit('commune/setAllRecords', communes)
                if (villages.length > 0) store.commit('village/setAllRecords', villages)
            } catch (err) {
                console.log(err)
            } finally {
                locationLoading.value = false
                syncBirthCertLocationSelection()
            }
        }

        function syncBirthCertLocationSelection() {
            const provinces = getProvinceRecords()
            const districts = getDistrictRecords()
            const communes = getCommuneRecords()

            bcSelectedProvince.value = provinces.find((p) => p.id == birthCertData.province_id) || null
            bcSelectedDistrict.value = districts.find((d) => d.id == birthCertData.district_id) || null

            if (
                birthCertData.district_id &&
                bcSelectedProvince.value &&
                bcSelectedDistrict.value &&
                bcSelectedDistrict.value.province_id != bcSelectedProvince.value.id
            ) {
                birthCertData.district_id = null
                birthCertData.commune_id = null
                bcSelectedDistrict.value = null
            }

            if (
                birthCertData.commune_id &&
                bcSelectedDistrict.value &&
                !communes.some((c) => c.id == birthCertData.commune_id && c.district_id == bcSelectedDistrict.value.id)
            ) {
                birthCertData.commune_id = null
            }
        }

        const selectedProvinceId = computed(() => parseInt(birthCertData.province_id || 0, 10) || 0)
        const selectedDistrictId = computed(() => parseInt(birthCertData.district_id || 0, 10) || 0)

        // Province options for birth certificate
        const bcProvinceOptions = computed(() => {
            const provinces = getProvinceRecords()
            if (provinces.length > 0) {
                return provinces.map((p) => ({ label: p.name_kh, value: p.id }))
            }
            return []
        })

        // District options filtered by selected province
        const bcDistrictOptions = computed(() => {
            const districts = getDistrictRecords()
            if (selectedProvinceId.value > 0) {
                return districts
                    .filter((d) => d.province_id == selectedProvinceId.value)
                    .map((d) => ({ label: d.name_kh, value: d.id }))
            }
            return [{ label: 'សូមជ្រើសរើស ខេត្ត ឬ ក្រុង ជាមុនសិន', value: null }]
        })

        // Commune options filtered by selected district
        const bcCommuneOptions = computed(() => {
            const communes = getCommuneRecords()
            if (selectedDistrictId.value > 0) {
                return communes
                    .filter((c) => c.district_id == selectedDistrictId.value)
                    .map((c) => ({ label: c.name_kh, value: c.id }))
            }
            return [{ label: 'សូមជ្រើសរើស ស្រុក ឬ ខណ្ឌ ជាមុនសិន', value: null }]
        })

        const filteredBcDistrictOptions = computed(() => {
            return selectedProvinceId.value > 0
                ? bcDistrictOptions.value.filter((option) => option?.value !== null)
                : []
        })

        const filteredBcCommuneOptions = computed(() => {
            return selectedDistrictId.value > 0
                ? bcCommuneOptions.value.filter((option) => option?.value !== null)
                : []
        })

        const getExistingBirthCertRecord = () => {
            const directBirthCert = props.officer?.people?.birth_certificate
            if (directBirthCert && directBirthCert.id) {
                return directBirthCert
            }

            const birthCertificates = props.officer?.people?.birth_certificates
            if (Array.isArray(birthCertificates) && birthCertificates.length > 0) {
                return birthCertificates[birthCertificates.length - 1]
            }

            return birthCertificates && birthCertificates.id ? birthCertificates : null
        }

        // Initialize birth certificate data
        const initializeBirthCertData = () => {
            if (props.officer && props.officer.people) {
                const bc = getExistingBirthCertRecord()
                clearBirthCertFile()
                birthCertData.people_id = props.officer.people.id
                if (bc) {
                    birthCertData.id = bc.id
                    birthCertData.birth_number = bc.birth_number || ''
                    birthCertData.book_number = bc.book_number || ''
                    birthCertData.year = bc.year ? new Date(bc.year).getTime() : null
                    birthCertData.issued_date = bc.issued_date ? new Date(bc.issued_date).getTime() : null
                    birthCertData.province_id = bc.province_id || null
                    birthCertData.district_id = bc.district_id || null
                    birthCertData.commune_id = bc.commune_id || null
                    birthCertData.pdf = bc.pdf || null 
                } else {
                    birthCertData.id = null
                    birthCertData.birth_number = ''
                    birthCertData.book_number = ''
                    birthCertData.year = null
                    birthCertData.issued_date = null
                    birthCertData.province_id = null
                    birthCertData.district_id = null
                    birthCertData.commune_id = null
                    birthCertData.pdf = null 
                    bcSelectedProvince.value = null
                    bcSelectedDistrict.value = null
                    
                }
            }
            syncBirthCertLocationSelection()
        }

        const bcHandleProvinceChange = (value) => {
            const previousProvinceId = normalizeNullableNumber(bcSelectedProvince.value?.id)
            const nextProvinceId = normalizeNullableNumber(value)
            birthCertData.province_id = nextProvinceId
            bcSelectedProvince.value = getProvinceRecords().find((p) => p.id == nextProvinceId) || null

            if (previousProvinceId !== nextProvinceId) {
                bcSelectedDistrict.value = null
                birthCertData.district_id = null
                birthCertData.commune_id = null
            }
        }

        const bcHandleDistrictChange = (value) => {
            const previousDistrictId = normalizeNullableNumber(bcSelectedDistrict.value?.id)
            const nextDistrictId = normalizeNullableNumber(value)
            birthCertData.district_id = nextDistrictId
            bcSelectedDistrict.value = getDistrictRecords().find((d) => d.id == nextDistrictId) || null

            if (previousDistrictId !== nextDistrictId) {
                birthCertData.commune_id = null
            }
        }

        // Set province and reset district/commune
        const bcSetProvince = () => {
            bcSelectedProvince.value = getProvinceRecords().find((p) => p.id == birthCertData.province_id) || null
            bcSelectedDistrict.value = null
            birthCertData.district_id = null
            birthCertData.commune_id = null
        }

        // Set district and reset commune
        const bcSetDistrict = () => {
            bcSelectedDistrict.value = getDistrictRecords().find((d) => d.id == birthCertData.district_id) || null
            birthCertData.commune_id = null
        }

        onMounted(() => {
            ensureLocationRecordsLoaded()
        })

        watch(() => props.officer, (newOfficer) => {
            if (newOfficer && newOfficer.people) {
                initializeEditData()
                initializeBirthCertData()
                markSaved()
            }
        }, { immediate: true, deep: true })

        watch(hasUnsavedChanges, (changed) => {
            emit('changed', changed === true)
        }, { immediate: true })

        watch(
            () => [getProvinceRecords().length, getDistrictRecords().length, getCommuneRecords().length, getVillageRecords().length],
            () => {
                syncBirthCertLocationSelection()
            }
        )

        // Save birth certificate
        const saveBirthCert = async ({ silent = false, markSavedAfterSuccess = true } = {}) => {
            try {
                const existingBirthCert = getExistingBirthCertRecord()
                const existingBirthCertId = birthCertData.id || existingBirthCert?.id || null
                const normalizedProvinceId = normalizeNullableNumber(birthCertData.province_id)
                const normalizedDistrictId = normalizeNullableNumber(birthCertData.district_id)
                const normalizedCommuneId = normalizeNullableNumber(birthCertData.commune_id)
                birthCertData.province_id = normalizedProvinceId
                birthCertData.district_id = normalizedDistrictId
                birthCertData.commune_id = normalizedCommuneId
                const payload = {
                    people_id: birthCertData.people_id,
                    birth_number: birthCertData.birth_number,
                    book_number: birthCertData.book_number,
                    year: birthCertData.year ? dateFormat(new Date(birthCertData.year), 'yyyy-mm-dd') : null,
                    issued_date: birthCertData.issued_date ? dateFormat(new Date(birthCertData.issued_date), 'yyyy-mm-dd') : null,
                    province_id: normalizedProvinceId,
                    district_id: normalizedDistrictId,
                    commune_id: normalizedCommuneId,
                    pdf: birthCertData.pdf ,
                    wedding_certificate_id: null // Officer's own birth cert, not child's
                }

                let response
                if (existingBirthCertId) {
                    // Update existing
                    payload.id = existingBirthCertId
                    response = await store.dispatch('birthcertificate/update', payload)
                } else {
                    // Create new
                    response = await store.dispatch('birthcertificate/create', payload)
                }

                if (response.data && response.data.ok) {
                    const record = response.data.record
                    birthCertData.id = record.id
                    birthCertData.birth_number = record.birth_number || ''
                    birthCertData.book_number = record.book_number || ''
                    birthCertData.year = record.year ? new Date(record.year).getTime() : null
                    birthCertData.issued_date = record.issued_date ? new Date(record.issued_date).getTime() : null
                    birthCertData.province_id = normalizeNullableNumber(record.province_id)
                    birthCertData.district_id = normalizeNullableNumber(record.district_id)
                    birthCertData.commune_id = normalizeNullableNumber(record.commune_id)
                    birthCertData.pdf = record.pdf || birthCertData.pdf
                    if (!props.officer.people.birth_certificate) {
                        props.officer.people.birth_certificate = {}
                    }
                    props.officer.people.birth_certificate.id = record.id
                    props.officer.people.birth_certificate.birth_number = record.birth_number
                    props.officer.people.birth_certificate.book_number = record.book_number
                    props.officer.people.birth_certificate.year = record.year
                    props.officer.people.birth_certificate.issued_date = record.issued_date
                    props.officer.people.birth_certificate.province_id = record.province_id
                    props.officer.people.birth_certificate.district_id = record.district_id
                    props.officer.people.birth_certificate.commune_id = record.commune_id
                    if (!Array.isArray(props.officer.people.birth_certificates)) {
                        props.officer.people.birth_certificates = []
                    }
                    const storedIndex = props.officer.people.birth_certificates.findIndex((item) => item.id == record.id)
                    if (storedIndex >= 0) {
                        props.officer.people.birth_certificates[storedIndex] = {
                            ...props.officer.people.birth_certificates[storedIndex],
                            ...record
                        }
                    } else {
                        props.officer.people.birth_certificates.push(record)
                    }
                    
                    const provinces = store.getters['province/records']
                    const districts = store.getters['district/records']
                    const communes = store.getters['commune/records']
                    if (provinces && provinces.all) {
                        props.officer.people.birth_certificate.province = provinces.all.find(p => p.id == record.province_id) || null
                    }
                    if (districts && districts.all) {
                        props.officer.people.birth_certificate.district = districts.all.find(d => d.id == record.district_id) || null
                    }
                    if (communes && communes.all) {
                        props.officer.people.birth_certificate.commune = communes.all.find(c => c.id == record.commune_id) || null
                    }
                    syncBirthCertLocationSelection()

                    // Upload attached birth certificate file if selected
                    if (birthCertFile.value) {
                        try {
                            const formData = new FormData()
                            formData.append('id', record.id)
                            formData.append('file', birthCertFile.value, birthCertFile.value.name)
                            const uploadRes = await store.dispatch('birthcertificate/upload', formData)
                            if (uploadRes.data && uploadRes.data.record && uploadRes.data.record.pdf) {
                                birthCertData.pdf = uploadRes.data.record.pdf
                                props.officer.people.birth_certificate.pdf = uploadRes.data.record.pdf
                                const updatedIndex = Array.isArray(props.officer.people.birth_certificates)
                                    ? props.officer.people.birth_certificates.findIndex((item) => item.id == record.id)
                                    : -1
                                if (updatedIndex >= 0) {
                                    props.officer.people.birth_certificates[updatedIndex] = {
                                        ...props.officer.people.birth_certificates[updatedIndex],
                                        pdf: uploadRes.data.record.pdf
                                    }
                                }
                            }
                            clearBirthCertFile()
                        } catch (uploadErr) {
                            console.error('Birth certificate upload error:', uploadErr)
                            notify.error({
                                title: 'ឯកសារភ្ជាប់',
                                content: 'រក្សាទុកព័ត៌មានបាន តែមានបញ្ហាក្នុងការផ្ទុកឯកសារ។ សូមព្យាយាមភ្ជាប់ឯកសារម្តងទៀត។',
                                duration: 3000
                            })
                        }
                    }

                    if (!silent) {
                        notify.success({
                            title: 'ជោគជ័យ',
                            content: 'បានរក្សាទុកព័ត៌មានសំបុត្រកំណើតរួចរាល់។',
                            duration: 2000
                        })
                    }

                    if (markSavedAfterSuccess) {
                        markSaved()
                    }
                    return true
                } else {
                    notify.error({
                        title: 'មានបញ្ហា',
                        content: response.data?.message || 'មានបញ្ហាក្នុងការរក្សាទុកព័ត៌មាន។',
                        duration: 3000
                    })
                    return false
                }
            } catch (error) {
                console.error('Save birth certificate error:', error)
                notify.error({
                    title: 'មានបញ្ហា',
                    content: 'មានបញ្ហាក្នុងការរក្សាទុកព័ត៌មាន។ សូមព្យាយាមម្តងទៀត។',
                    duration: 3000
                })
                return false
            }
        }

        /**
         * Upload functions
         */
        /**
         * File upload
         */
        const model = reactive({
            name: 'birthcertificate',
            module: 'birthcertificates',
            title: 'អត្រានុកុលដ្ឋានកូន'
        })
        const certificates = computed( () => {
        return store.getters[model.name + '/getRecords']
        })

        const selectedCertificate = ref(null)
        const pdfToggle = ref(false)
        function togglePdfModal(cert) {
            selectedCertificate.value = cert == undefined || cert == null ? null : cert
            pdfToggle.value = !pdfToggle.value
        }
        const uploadHelper = ref(false)
        function uploadToggler(certificate) {
            uploadHelper.value = !uploadHelper.value
            if( certificate == null || certificate == undefined ){
                
            }else{
                selectedCertificate.value = certificate
            }
        }
        
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

        const birthCertStoredRecord = computed(() => {
            if (birthCertData.id && birthCertData.pdf) {
                return {
                    id: birthCertData.id,
                    pdf: birthCertData.pdf,
                    filename: extractBirthCertDisplayFileName(birthCertData.pdf)
                }
            }

            const directBirthCert = props.officer?.people?.birth_certificate
            if (directBirthCert?.id && directBirthCert?.pdf) {
                return {
                    ...directBirthCert,
                    filename: extractBirthCertDisplayFileName(directBirthCert.pdf)
                }
            }

            const birthCertificates = props.officer?.people?.birth_certificates
            if (Array.isArray(birthCertificates) && birthCertificates.length > 0) {
                const latestBirthCert = birthCertificates[birthCertificates.length - 1]
                if (latestBirthCert?.id && latestBirthCert?.pdf) {
                    return {
                        ...latestBirthCert,
                        filename: extractBirthCertDisplayFileName(latestBirthCert.pdf)
                    }
                }
            }

            return null
        })

        const birthCertPreviewRecord = computed(() => {
            if (birthCertFile.value instanceof File && birthCertLocalPreviewUrl.value) {
                return {
                    id: birthCertData.id || null,
                    pdf: true,
                    localPdfUrl: birthCertLocalPreviewUrl.value,
                    filename: birthCertFile.value.name
                }
            }

            return birthCertStoredRecord.value
        })

        const canPreviewBirthCert = computed(() => birthCertPreviewRecord.value != null)
        const canDownloadBirthCert = computed(() => birthCertFile.value instanceof File || canPreviewBirthCert.value)

        function triggerBrowserDownload(url, filename) {
            const anchor = document.createElement('a')
            anchor.href = url
            anchor.download = filename
            anchor.style.display = 'none'
            document.body.appendChild(anchor)
            anchor.click()
            document.body.removeChild(anchor)
        }

        async function downloadBirthCert() {
            try {
                if (birthCertFile.value instanceof File) {
                    const objectUrl = window.URL.createObjectURL(birthCertFile.value)
                    triggerBrowserDownload(objectUrl, birthCertFile.value.name || 'birth-certificate')
                    window.setTimeout(() => window.URL.revokeObjectURL(objectUrl), 1000)
                    return
                }

                const record = birthCertStoredRecord.value
                if (!record?.id || !record?.pdf) {
                    notify.warning({
                        title: 'Birth Certificate',
                        content: 'No attachment is available to download.',
                        duration: 3000
                    })
                    return
                }

                const res = await store.dispatch(`${model.name}/pdf`, { id: record.id })
                const fileUrl = res?.data?.pdf
                if (!fileUrl) {
                    throw new Error('Birth certificate file URL is missing')
                }

                triggerBrowserDownload(
                    fileUrl,
                    res?.data?.filename || record?.filename || `birth-certificate-${record.id}.pdf`
                )
            } catch (error) {
                console.error('Birth certificate download error:', error)
                notify.error({
                    title: 'Birth Certificate',
                    content: 'Unable to download the attachment.',
                    duration: 3000
                })
            }
        }
        
        return {
            model,
            pdfToggle,
            togglePdfModal,
            selectedCertificate,
            birthCertStoredRecord,
            birthCertPreviewRecord,
            canPreviewBirthCert,
            canDownloadBirthCert,
            downloadBirthCert,
      
            dateFormat,
            isEditing,
            editData,
            dobForInput,
            birthCertYearForInput,
            birthCertIssuedDateForInput,
            nationalSelection,
            nationalitySelection,
            selectedProvinceId,
            selectedDistrictId,
            changedCellClass,
            hasUnsavedChanges,
            toggleEdit,
            cancelEdit,
            save,
            cancelChanges,
            persistChanges,
            markSaved,
            ocmLogoUrl,
            // Profile picture upload
            fileInput,
            selectedFile,
            previewImage,
            isUploading,
            triggerFileInput,
            handleFileSelect,
            cancelFileSelect,
            uploadPhoto,
            // Birth certificate
            birthCertData,
            bcProvinceOptions,
            bcDistrictOptions,
            bcCommuneOptions,
            filteredBcDistrictOptions,
            filteredBcCommuneOptions,
            bcSetProvince,
            bcSetDistrict,
            bcHandleProvinceChange,
            bcHandleDistrictChange,
            saveBirthCert,
            birthCertFile,
            birthCertFileName,
            shortenFileName,
            birthCertFileTypeLabel,
            onBirthCertFileChange,
            clearBirthCertFile,
            onNumericInput,
            onUppercaseLetterInput,
            onNationalSelectionChange,
            onNationalitySelectionChange
        }
    }
}
</script>
<style scoped>
.field-input {
    height: 32px;
    box-sizing: border-box;
    text-align: left;
}

.field-input-textarea {
    min-height: 72px;
    height: auto;
    resize: vertical;
}

.certificate-upload {
    width: 95%;
    min-width: 0;
    box-sizing: border-box;
    height: 32px;
    display: flex;
    align-items: center;
    gap: 4px;
    border: 1px solid #d8dee8;
    border-radius: 4px;
    background: #fff;
    padding: 0 4px 0 0;
    overflow: hidden;
}

.certificate-upload:hover {
    border-color: #22c55e;
}

.certificate-upload:focus-within {
    border-color: #16a34a;
    box-shadow: 0 0 0 1px rgba(22, 163, 74, 0.15);
}

.certificate-upload-trigger {
    height: 100%;
    display: inline-flex;
    align-items: center;
    border-radius: 0;
    border: none;
    border-right: 1px solid #d8dee8;
    background: #fff;
    color: #1e3a8a;
    font-size: 12px;
    padding: 0 10px;
    cursor: pointer;
    white-space: nowrap;
    box-sizing: border-box;
}
.certificate-upload-trigger:hover {
    background: #f8fafc;
}
.certificate-file-name {
    flex: 1;
    min-width: 0;
    background: #fff;
    color: #2c3e50;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-left: 4px;
}
.certificate-file-name-inline {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 280px;
    display: inline-block;
}
.certificate-file-type {
    font-size: 10px;
    line-height: 1;
    color: #1e3a8a;
    background: #e5eaf2;
    border-radius: 9999px;
    padding: 3px 6px;
}
.certificate-upload-clear {
    color: #9ca3af;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.certificate-upload-clear:hover {
    color: #dc2626;
}

.changed-cell {
    background: #fef2f2;
    box-shadow: inset 3px 0 0 #b91c1c;
}

.changed-cell .field-input {
    /* border-color: #dc2626 !important; */
}

:deep(.uniform-select .n-base-selection) {
    min-height: 32px !important;
    height: 32px !important;
    box-sizing: border-box;
    background-color: #fff !important;
}

:deep(.uniform-select .n-base-selection-label) {
    height: 100%;
    background-color: #fff !important;
}
</style>
