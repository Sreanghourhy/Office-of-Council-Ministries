<template >
    <div class="birth-information" >
        <Transition name="slide-fade" >
            <div v-if="officer != undefined && officer != null " class="absolute left-0 right-0 bottom-0 top-0 flex overflow-hidden" >
                <!-- Section nav sidebar: full height, same as global sidebar (under header) -->
                <profile-section-sidebar
                    :items="sectionNavItems"
                    :active-index="activeNavIndex"
                    @select-section="onSectionNavSelect"
                />
                <!-- Main content: header + scrollable body -->
                <div
                    class="flex-1 min-h-0 min-w-0 flex flex-col overflow-hidden"
                    @pointerdown.capture="markCareerInteraction"
                    @keydown.capture="markCareerInteraction"
                    @input.capture="markCareerInteraction"
                    @change.capture="markCareerInteraction"
                >
                    <div class="font-moul border-b border-gray-200 w-full pb-2 mb-4 relative flex flex-shrink-0 px-4 pt-4" >
                        <div class="w-full font-moul " >ជីវប្រវត្តិ{{ officer_type_name }}</div>
                        <div class="bg-white rounded-md hover:text-blue-600 duration-300 w-28" >
                            <router-link v-if="officer!=undefined" to="/hr/officer" class="py-1 px-4 border border-blue-400 rounded " >បញ្ជីមន្ត្រី</router-link>
                        </div>
                        <div class="bg-white rounded-md hover:text-blue-600 duration-300 w-28" >
                            <a v-if="officer!=undefined" href="#" class="py-1 px-4 border border-blue-400 rounded " @click.prevent="openPrintProfile(officer)">បោះពុម្ភ</a>
                        </div>
                    </div>
                <div class="flex-1 min-h-0 flex flex-col min-w-0 p-4 pb-8">
                    <n-scrollbar
                        ref="mainScrollbarRef"
                        class="flex-1 min-h-0"
                        @scroll="onMainScroll"
                    >
                    <div :class="['body', hasCareerChanges ? 'pb-24' : '']" >
                        <!-- User Profile -->
                        <div
                            :ref="(el) => setCareerSectionAnchor('personal', el)"
                            :class="['career-section-anchor', careerSectionChanged.personal ? 'career-section-modified' : '', focusedChangedSection === 'personal' ? 'career-section-focus' : '']"
                        >
                            <profile-component
                                ref="personalSectionRef"
                                v-bind:officer="officer"
                                @changed="onCareerSectionChanged('personal', $event)"
                            />
                        </div>
                        <!-- End user profile -->
                        <template v-if="!personalOnlyMode">
                        <div
                            :ref="(el) => setFormSectionAnchor('family', el)"
                            class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto "
                        >
                            <div class="w-full p-4 " >
                                <div class="relative w-full mb-6 border-b border-[#D8DEE8] pb-3 font-moul text-[#1E3A8A] text-left text-xl md:text-2xl leading-tight " >ខ. ព័ត៌មានគ្រួសារ</div>
                                <table class="w-full" style="border-spacing: 0px; " >
                                    <tbody>
                                        <tr>
                                            <td>
                                                <MaritalStatusComponent 
                                                    :ref="(el) => { 
                                                        maritalStatusSectionRef = el; 
                                                        setCareerSectionAnchor('maritalStatus', el); 
                                                        setFormSectionAnchor('maritalStatus', el); 
                                                    }" 
                                                    :officer="officer" 
                                                    @changed="(hasChanged, newVal) => onMaritalStatusChanged(hasChanged, newVal)" 
                                                />
                                                
                                                <!-- <SpouseInformationComponent v-bind:officer="officer" /> -->
                                                <SpouseInformationComponent 
                                                :ref="(el) => { 
                                                    spouseInformationSectionRef = el; // FIXED: Added 'Information'
                                                    setCareerSectionAnchor('spouseInformation', el); 
                                                }" 
                                                    :officer="officer" 
                                                    :status="formData.people.marry_status"
                                                    @changed="(val) => onCareerSectionChanged('spouseInformation', val)" 
                                                    />
    
                                                <div class="relative">
                                                    <ChildrenInformationComponent 
                                                        :ref="(el) => { 
                                                            childrenInformationSectionRef  = el; 
                                                            setCareerSectionAnchor('childrenInformation', el); 
                                                        }" 
                                                        :officer="officer" 
                                                        @changed="(val) => onCareerSectionChanged('childrenInformation', val)" 
                                                    />

                                                    <div 
                                                        v-if="officer?.people?.marry_status !== 'married'"
                                                        class="absolute inset-0 flex items-center justify-center bg-white/80 text-gray-600 text-sm"
                                                    >
                                                        <span class="text-gray-600 text-sm -translate-y-4">សូមបញ្ចូលព័ត៌មានអាពាហ៍ពិពាហ៍ជាមុនសិន</span>
                                                    </div>
                                                </div>
                                                    <!-- <ParentsInformationComponent v-bind:officer="officer" /> -->
                                                    <ParentsInformationComponent 
                                                    :ref="(el) => { 
                                                        parentsInformationSectionRef = el; 
                                                        setCareerSectionAnchor('parentsInformation', el); // Changed from 'parents'
                                                    }" 
                                                    :officer="officer" 
                                                    @changed="(val) => onCareerSectionChanged('parentsInformation', val)" 
                                                />
                                                <!-- <ChildrenInformationComponent v-bind:officer="officer"/> -->
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div
                            :ref="(el) => setFormSectionAnchor('emergency', el)"
                            class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto "
                        >
                            <div class="w-full p-4 " >
                                <emergencyContactInformationomponent 
                                    :ref="(el) => { 
                                        emergencyInformationSectionRef = el;
                                        setCareerSectionAnchor('emergencyInformation', el);
                                    }" 
                                    :officer="officer" 
                                    @changed="(val) => onCareerSectionChanged('emergencyInformation', val)" 
                                />
                            </div>
                        </div>
                        <!-- Education background -->
                        <div :ref="(el) => setFormSectionAnchor('education', el)">
                            <education-component v-bind:officer="officer" />
                        </div>
                        <!-- Education background end-->
                        <!-- Language -->
                        <div
                            :ref="(el) => setCareerSectionAnchor('language', el)"
                            :class="['career-section-anchor', careerSectionChanged.language ? 'career-section-modified' : '', focusedChangedSection === 'language' ? 'career-section-focus' : '']"
                        >
                            <spoken-language-component
                                ref="languageSectionRef"
                                v-bind:officer="officer"
                                @changed="onCareerSectionChanged('language', $event)"
                            />
                        </div>
                        <!-- End language -->
                        <!-- Working background -->
                        <div
                            :ref="(el) => setFormSectionAnchor('workHistory', el)"
                            class="form-panel border border-[#D8DEE8] rounded-sm m-4 bg-white w-full mx-auto"
                            >
                            <div class="w-full p-6" >
                                <div class="relative w-full mb-6 border-b border-[#D8DEE8] pb-3 font-moul text-[#1E3A8A] text-left text-xl md:text-2xl leading-tight" >
                                    ច. ប្រវត្តិការងារ
                                </div>
                                <div
  :ref="(el) => setCareerSectionAnchor('krobKhan', el)"
  :class="[
    'career-section-anchor',
    careerSectionChanged.krobKhan ? 'career-section-modified' : '',
    focusedChangedSection === 'krobKhan' ? 'career-section-focus' : ''
  ]"
>
  <krob-khan-component
    ref="krobKhanSectionRef"
    v-bind:officer="officer"
    @changed="onCareerSectionChanged('krobKhan', $event)"
  />
</div>
                                <div class="relative w-full mb-4 font-semibold text-[#1E3A8A] text-[15px] text-left px-4 py-3 ">
                                    ច.១​​. មុខដំណែង (សូមបំពេញតាមលំដាប់ ពីថ្មីទៅចាស់)
                                </div>

                                <div
                                    :ref="(el) => setCareerSectionAnchor('public', el)"
                                    :class="['career-section-anchor', careerSectionChanged.public ? 'career-section-modified' : '', focusedChangedSection === 'public' ? 'career-section-focus' : '']"
                                >
                                
                                    <public-work-component
                                        ref="publicWorkSectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('public', $event)"
                                    />
                                </div>
                                <div
                                    :ref="(el) => setCareerSectionAnchor('private', el)"
                                    :class="['career-section-anchor', careerSectionChanged.private ? 'career-section-modified' : '', focusedChangedSection === 'private' ? 'career-section-focus' : '']"
                                >
                                    <private-work-component
                                        ref="privateWorkSectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('private', $event)"
                                    />
                                </div>
                                <div
                                    :ref="(el) => setCareerSectionAnchor('rankWorking', el)"
                                    :class="['career-section-anchor', careerSectionChanged.rankWorking ? 'career-section-modified' : '', focusedChangedSection === 'rankWorking' ? 'career-section-focus' : '']"
                                >
                                    <rank-by-working-component
                                        ref="rankByWorkingSectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('rankWorking', $event)"
                                    />
                                </div>
                                <div
                                    :ref="(el) => setCareerSectionAnchor('rankCertificate', el)"
                                    :class="['career-section-anchor', careerSectionChanged.rankCertificate ? 'career-section-modified' : '', focusedChangedSection === 'rankCertificate' ? 'career-section-focus' : '']"
                                >
                                    <rank-by-certificate-component
                                        ref="rankByCertificateSectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('rankCertificate', $event)"
                                    />
                                </div>
                                <div
                                    :ref="(el) => setCareerSectionAnchor('outKrobKhan', el)"
                                    :class="['career-section-anchor', careerSectionChanged.outKrobKhan ? 'career-section-modified' : '', focusedChangedSection === 'outKrobKhan' ? 'career-section-focus' : '']"
                                >
                                    <outkrobkhan-component
                                        ref="outKrobKhanSectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('outKrobKhan', $event)"
                                    />
                                </div>
                                <div
                                    :ref="(el) => setCareerSectionAnchor('otherStatus', el)"
                                    :class="['career-section-anchor', careerSectionChanged.otherStatus ? 'career-section-modified' : '', focusedChangedSection === 'otherStatus' ? 'career-section-focus' : '']"
                                >
                                    <no-salary-component
                                        ref="noSalarySectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('otherStatus', $event)"
                                    />
                                </div>
                            </div>
                        </div>
                        </template>
<!-- ///////////////////////////////////////////////////////////////////////////////// -->
                        <career-save-footer-component
                            :visible="hasCareerChanges"
                            :changed-count="changedSectionCount"
                            :can-navigate="canNavigateChanges"
                            @previous="goToPreviousChange"
                            @next="goToNextChange"
                            @cancel-section="cancelActiveCareerSection"
                            @cancel-all="cancelAllCareerSections"
                            @save-all="saveAllCareerSections"
                        />
<!-- ///////////////////////////////////////////////////////////////////////////////// -->
                        <template v-if="!personalOnlyMode">
                        <!-- Reward & Penalty -->
                        <div
                            :ref="(el) => setCareerSectionAnchor('medalHistory', el)"
                            :class="['career-section-anchor', careerSectionChanged.medalHistory ? 'career-section-modified' : '', focusedChangedSection === 'medalHistory' ? 'career-section-focus' : '']"
                            class="form-panel border border-[#D8DEE8] rounded-sm m-4 bg-white w-full mx-auto"
                        >
                            <div class="w-full p-6" >
                                <div class="relative w-full mb-6 border-b border-[#D8DEE8] pb-3 font-moul text-[#1E3A8A] text-left text-xl md:text-2xl leading-tight" >ឆ. ការលើកសរសើរ ឬដាក់វិន័យ</div>
                                <medal-history-component
                                    ref="medalHistorySectionRef"
                                    v-bind:officer="officer"
                                    @changed="onCareerSectionChanged('medalHistory', $event)"
                                />
                                <div
                                    :ref="(el) => setCareerSectionAnchor('penaltyHistory', el)"
                                    :class="['career-section-anchor', careerSectionChanged.penaltyHistory ? 'career-section-modified' : '', focusedChangedSection === 'penaltyHistory' ? 'career-section-focus' : '']"
                                >
                                    <penalty-history-component
                                        ref="penaltyHistorySectionRef"
                                        v-bind:officer="officer"
                                        @changed="onCareerSectionChanged('penaltyHistory', $event)"
                                    />
                                </div>
                            </div> 
                        </div>
                        <div
                            :ref="(el) => setFormSectionAnchor('status', el)"
                            class="form-panel border border-gray-200 rounded-md m-4  bg-white shadow w-full mx-auto "
                        >
                            <div class="w-full p-4 " >
                                <div class="relative w-full border-b border-gray-200 pb-2 font-moul mb-4 " >ជ. ការបញ្ជាក់អំពីស្ថានភាព</div>
                                <table class="w-full"  >  
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="flex leading-6 " >
                                                <svg v-if="officer.additional_officer_type == 'politician'" class="w-6 h-6 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM6 26V6h20v20z" fill="currentColor"></path><path d="M14 21.5l-5-4.96L10.59 15L14 18.35L21.41 11L23 12.58l-9 8.92z" fill="currentColor"></path></svg>
                                                <svg v-if="officer.additional_officer_type != 'politician'" class="w-6 h-6 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect></svg>
                                                មន្ត្រីនយោបាយ
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex leading-6 " >
                                                <svg v-if="officer.additional_officer_type == 'admin_official'" class="w-6 h-6 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM6 26V6h20v20z" fill="currentColor"></path><path d="M14 21.5l-5-4.96L10.59 15L14 18.35L21.41 11L23 12.58l-9 8.92z" fill="currentColor"></path></svg>
                                                <svg v-if="officer.additional_officer_type != 'admin_official'" class="w-6 h-6 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect></svg>
                                                មន្ត្រីមុខងារសាធារណៈ
                                                </div>
                                                </td>
                                            <td>
                                                <div class="flex leading-6 " >
                                                <svg v-if="officer.additional_officer_type == 'admin_unofficial'" class="w-6 h-6 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM6 26V6h20v20z" fill="currentColor"></path><path d="M14 21.5l-5-4.96L10.59 15L14 18.35L21.41 11L23 12.58l-9 8.92z" fill="currentColor"></path></svg>
                                                <svg v-if="officer.additional_officer_type != 'admin_unofficial'" class="w-6 h-6 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect></svg>
                                                មន្ត្រីជាប់កិច្ចសន្យា
                                                </div>
                                                </td>
                                            <td>
                                                <div class="flex leading-6 " >
                                                <svg v-if="officer.additional_officer_type == 'contracted_officer'" class="w-6 h-6 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM6 26V6h20v20z" fill="currentColor"></path><path d="M14 21.5l-5-4.96L10.59 15L14 18.35L21.41 11L23 12.58l-9 8.92z" fill="currentColor"></path></svg>
                                                <svg v-if="officer.additional_officer_type != 'contracted_officer'" class="w-6 h-6 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect></svg>
                                                មន្ត្រីផ្អែកលើកិច្ចព្រមព្រៀងការងារ
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                            </div>
                        <div class="w-full relative" >
                            <div class="absolute left-0 top-0 w-80" >
                                <!-- <p class="indent-4 leading-6 text-justify " ><span class="text-red-500 mr-1 " >*</span>អង្គភាព {{ officer.organization.name }}</p>
                                <p class="indent-4 leading-6 text-justify ">ខ្ញុំសូមធានាទទួលខុសត្រូវចំពោះមុខច្បាប់ថា ព័ត៌មាន រូបថត និងហត្ថលេខា ក្នុងជីវប្រវត្តិ{{ officer_type_name }}នេះ ពិតជារបស់ <span class="font-moul" >{{ officer.people.lastname + ' ' + officer.people.firstname }}</span> ដែលជាមន្ត្រីកំពុងបំរើការងារនៅក្នុងក្រសួង និងអង្គភាពក្រោមឪវាទរបស់ក្រសួងពិតប្រាកដមែន។</p>
                                <p class="text-center leading-6 " >ថ្ងៃ <span class="signature-date-line"></span> ទី <span class="signature-date-line"></span> ខែ <span class="signature-date-line signature-date-line-month"></span> ឆ្នាំ <span class="signature-date-line signature-date-line-year"></span></p>
                                <p class="text-center leading-6">ព.ស. {{ $toKhmer(String(today.getFullYear() + 543)) }}</p>
                                <p class="text-center leading-6 " >រាជធានីភ្នំពេញ ថ្ងៃទី <span class="signature-date-line"></span> ខែ <span class="signature-date-line signature-date-line-month"></span> ឆ្នាំ {{ $toKhmer(today.getFullYear()) }} </p> -->
                                <!-- <p class="text-center leading-6 " >រាជធានីភ្នំពេញ ថ្ងៃទី {{ $getKhDay() }} ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}    </p> -->
                            </div>
                            <div ref="printDateErrorAnchorRef" class="absolute right-0 top-0  w-96 overflow-visible" >
                                <p class="indent-4 leading-6 text-justify " ><span class="text-red-500 mr-1 " >*</span>សាមីខ្លួន</p>
                                <p class="indent-4 leading-6 text-justify ">ខ្ញុំសូមធានាទទួលខុសត្រូវចំពោះមុខច្បាប់ ព័ត៌មានបានបំពេញក្នុងជីវប្រវត្តិការនេះ ពិតជាត្រឹមត្រូវប្រាកដមែន។</p>
                                <div class="signature-date-lines-wrap">
                                    <p class="text-center leading-6 " ><span class="text-red-500 mr-1 " >*</span> ថ្ងៃ <input v-model="signatureWeekday" class="signature-date-input signature-date-weekday" type="text" maxlength="20" /> ទី <input v-model="signatureDateDay" class="signature-date-input" type="text" maxlength="20" /> ខែ <input v-model="signatureDateMonth" class="signature-date-input signature-date-month" type="text" maxlength="15" /> ឆ្នាំ <input v-model="signatureDateYear" class="signature-date-input signature-date-year" type="text" maxlength="15" /></p>
                                    <p class="text-center leading-6">ព.ស. {{ $toKhmer(String(today.getFullYear() + 543)) }}</p>
                                    <p class="text-center leading-6 " ><span class="text-red-500 mr-1 " >*</span> <input v-model="signatureDatePlace" class="signature-date-input signature-date-place" type="text" maxlength="50" /> ថ្ងៃទី <input v-model="signatureDateDay2" class="signature-date-input" type="text" maxlength="2" /> ខែ <input v-model="signatureDateMonth2" class="signature-date-input signature-date-month" type="text" maxlength="15" /> ឆ្នាំ {{ $toKhmer( signatureDateYear2 ) }}</p>
                                </div>
                                <p v-if="printDateError" class="text-center text-red-500 text-xs leading-4 mt-1">{{ printDateError }}</p>
                                <!-- <p class="text-center leading-6 " >រាជធានីភ្នំពេញ ថ្ងៃទី {{ $toKhmer( (today.getDay() +'' ).padStart(2,'0') ) }}  ខែ {{ $getKhMonth() }} ឆ្នាំ {{ $toKhmer( today.getFullYear() ) }}</p> -->
                                <p class="text-center mt-10" ><span class="font-moul" >{{ 
                                // ( officer.countesy != undefined && officer.countesy != null ? officer.countesy.name + ' ' : '' ) + 
                                officer.people.lastname + ' ' + officer.people.firstname }}</span></p>
                            </div>
                        </div>
                        </template>
                    </div>
                    </n-scrollbar>
                </div>
                </div>
            </div>
        </Transition>
      <!-- Loading -->
      <Transition name="slide-fade">
        <div v-if="profileLoading" class="table-loading fixed flex h-screen left-0 top-10 right-0 bottom-0 bg-white bg-opacity-90 z-10">
          <div class="flex mx-auto items-center">
            <div class="spinner">
              <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
              <br/><br/>កំពុងអាន...
            </div>
          </div>
        </div>
      </Transition>
        <Transition name="slide-fade">
            <div v-if="!profileLoading && (officer == undefined || officer == null)">មានបញ្ហាក្នុងការបង្ហាញ ព័ត៌មានមន្ត្រី</div>
        </Transition>
    </div>    
</template>
<script >
import { reactive , ref , computed, watch, onBeforeUnmount, onMounted, nextTick } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'
import { useRoute , useRouter } from 'vue-router'

import Frame4Corner from '@components/widgets/frame/corner4.vue'
import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from '@assets/logo.svg'
import moment from 'moment'
import dateFormat from 'dateformat'
import { getKhmerDateParts } from '@utils/khmerLunar'
import { getMonth, parseNumber } from '@utils/khmer'

// Import component of the main component of officer profile
import ProfileComponent from './../widgets/backgroundchilds/profile.vue'
import EducationComponent from './../widgets/backgroundchilds/education.vue'
import SpokenLanguageComponent from './../widgets/backgroundchilds/language.vue'
import KrobKhanComponent from '../widgets/backgroundchilds/krobkhan.vue'
import PublicWorkComponent from './../widgets/backgroundchilds/publicwork.vue'
import PrivateWorkComponent from './../widgets/backgroundchilds/privatework.vue'
import RankByWorkingComponent from './../widgets/backgroundchilds/rankbyworking.vue'
import RankByCertificateComponent from './../widgets/backgroundchilds/rankbycertificate.vue'
import OutkrobkhanComponent from '../widgets/backgroundchilds/outkrobkhan.vue'
import NoSalaryComponent from './../widgets/backgroundchilds/freenosalary.vue'
import MedalHistoryComponent from './../widgets/backgroundchilds/medalhistory.vue'
import PenaltyHistoryComponent from './../widgets/backgroundchilds/penaltyhistory .vue'
import MaritalStatusComponent from './../widgets/backgroundchilds/maritalStatus.vue'
import CareerSaveFooterComponent from './../widgets/backgroundchilds/career-save-footer.vue'
import SpouseInformationComponent from './../widgets/backgroundchilds/spouseInformation.vue'
import ParentsInformationComponent from '../widgets/backgroundchilds/parentsInformation.vue'
import ChildrenInformationComponent from './../widgets/backgroundchilds/childrenInformation.vue'
import emergencyContactInformationomponent from './../widgets/backgroundchilds/emergencyContactInformation.vue'
import ProfileSectionSidebar from './profile-section-sidebar.vue'

import Crud from '../../../classes/Crud'
    export default {
        components: {
            ProfileSectionSidebar,
            Frame4Corner ,
            QrcodeVue ,
            ProfileComponent ,
            EducationComponent ,
            SpokenLanguageComponent ,
            KrobKhanComponent ,
            PublicWorkComponent ,
            PrivateWorkComponent ,
            RankByWorkingComponent,
            RankByCertificateComponent,
            OutkrobkhanComponent,
            NoSalaryComponent,
            MedalHistoryComponent,
            PenaltyHistoryComponent,
            MaritalStatusComponent,
            CareerSaveFooterComponent,
            SpouseInformationComponent,
            ParentsInformationComponent,
            ChildrenInformationComponent,
            emergencyContactInformationomponent
        },
        setup(props){
            const store = useStore()
            const message = useMessage()
            const route = useRoute()
            const router = useRouter()
            const officer = ref(null)
            const profileLoading = ref(true)
            const today = ref( new Date() )
            const todayKhLunarText = ref('')
            const signatureWeekday = ref( '' )
            const signatureDateDay = ref( '' )
            const signatureDateMonth = ref( '' )
            const signatureDateYear = ref( '' )
            const signatureDateDay2 = ref( '' )
            const signatureDateYear2 = ref( String( new Date().getFullYear() ) )
            const signatureDateMonth2 = ref( '' )
            const signatureDatePlace = ref( '' )
            const printDateError = ref('')
            const printDateErrorAnchorRef = ref(null)
            const personalSectionRef = ref(null)
            const krobKhanSectionRef = ref(null)
            const languageSectionRef = ref(null)
            const publicWorkSectionRef = ref(null)
            const privateWorkSectionRef = ref(null)
            const rankByWorkingSectionRef = ref(null)
            const rankByCertificateSectionRef = ref(null)
            const outKrobKhanSectionRef = ref(null)
            const noSalarySectionRef = ref(null)
            const medalHistorySectionRef = ref(null)
            const penaltyHistorySectionRef = ref(null)
            const maritalStatusSectionRef = ref(null)  //1. decalre a variable
            const spouseInformationSectionRef = ref(null) 
            const parentsInformationSectionRef = ref(null) 
            const childrenInformationSectionRef = ref(null) 
            const emergencyInformationSectionRef = ref(null) 
            const spouseSectionRef = ref(null)
            const personalOnlyMode = true
            const careerSectionChanged = reactive({    //2. define here, but doesn't need to be in order
                personal: false,
                maritalStatus: false,
                spouseInformation: false,
                parentsInformation: false,
                childrenInformation: false,
                emergencyInformation: false,
                krobKhan: false,
                family: false,
                language: false,
                public: false,
                private: false,
                rankWorking: false,
                rankCertificate: false,
                outKrobKhan: false,
                otherStatus: false,
                medalHistory: false,
                penaltyHistory: false
            })
            const formData = reactive({
                people: {
                    // Fallback to 'single' if the officer data isn't loaded yet
                    marry_status: props.officer?.people?.marry_status || 'single'
                }
            })
            const careerSectionOrder = personalOnlyMode
                ? ['personal']
                : ['personal', 'maritalStatus', 'spouseInformation', 'parentsInformation', 'childrenInformation', 'emergencyInformation', 'language', 'krobKhan', 'public', 'private', 'rankWorking', 'rankCertificate', 'outKrobKhan', 'otherStatus', 'medalHistory', 'penaltyHistory']  //3. define it here but have to be in order
            const careerSectionAnchors = reactive({   //4. define the here too, and it disorder
                personal: null,
                maritalStatus: null,
                spouseInformation: null,
                parentsInformation: null,
                childrenInformation: null,
                emergencyInformation: null,
                language: null,
                krobKhan: null,
                public: null,
                private: null,
                rankWorking: null,
                rankCertificate: null,
                outKrobKhan: null,
                otherStatus: null,
                medalHistory: null,
                penaltyHistory: null
            })
            const focusedChangedSection = ref('')
            const activeChangedSection = ref('')
            const isInitializingCareerSections = ref(true)
            const hasCareerUserInteraction = ref(false)
            let focusResetTimer = null

            const mainScrollbarRef = ref(null)
            const activeNavIndex = ref(0)
            const isProgrammaticScroll = ref(false)
            const formSectionAnchors = reactive({  //5. this is optional 
                family: null,
                emergency: null,
                education: null,
                language: null,
                workHistory: null,
                status: null
            })
            const sectionNavItems = [
                { id: 'personal', label: 'ក. ព័ត៌មានផ្ទាល់ខ្លួន' },
                { id: 'family', label: 'ខ. ព័ត៌មានគ្រួសារ' },
               // { id: 'family', label: 'ខ.៣ ព័ត៌មានឪពុកនិងម្ដាយបង្កើត' },
                { id: 'emergency', label: 'គ. ព័ត៌មានទំនាក់ទំនងក្នុងករណីមានអាសន្ន' },
                { id: 'education', label: 'ឃ. កំរិតវប្បធម៌ទូទៅ' },
                { id: 'language', label: 'ង. ភាសាបរទេស' },
                { id: 'krobKhan', label: 'ច. ប្រវត្តិការងារ' },
                // { id: 'public', label: 'ច.១. មុខដំណែង' },
                // { id: 'rankWorking', label: 'ច.២.ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមវេនជ្រើសរើស' },
                // { id: 'rankCertificate', label: 'ច.៣.ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមសញ្ញាបត្រ' },
                // { id: 'outKrobKhan', label: 'ច.៤.ស្ថានភាពស្ថិតនៅក្រៅក្របខ័ណ្ឌដើម' },
                // { id: 'otherStatus', label: 'ច.៥.ស្ថានភាពផ្សេងៗ' },
                { id: 'medalHistory', label: 'ឆ-ការលើកសរសើរ ឬដាក់វិន័យ' },
                // { id: 'medalHistory', label: 'ឆ.១-ការលើកសរសើរ' },
                // { id: 'penaltyHistory', label: 'ឆ.២-ការដាក់វិន័យ' },
                { id: 'status', label: 'ជ. ការបញ្ជាក់អំពីស្ថានភាព' }
            ]
            if (personalOnlyMode) {
                sectionNavItems.splice(1)
            }

            const additional_officer_types = ref([
              {
                  key : 'politician' ,
                  label: 'មន្ត្រីនយោបាយ' 
              },
              {
                  key : 'admin_official' ,
                  label: 'មន្ត្រីមុខងារសាធារណៈ' 
              },
              {
                  key : 'admin_unofficial' ,
                  label: 'មន្ត្រីជាប់កិច្ចសន្យា' 
              },
              {
                  key : 'contracted_officer' ,
                  label: 'មន្ត្រីផ្អែកលើកិច្ចព្រមព្រៀងការងារ' 
              },
            ])

            const officer_type_name = ref('មន្ត្រីរាជការ')
            const additional_officer_type = ref( null )

            // const model = reactive({
            //     name: 'Officer',
            //     module: 'officers',
            //     title: 'ប្រវត្តិមន្ត្រី',
            // })
            // let crud = new Crud()
            // crud.setServer(import.meta.env.VITE_API_SERVER)
            // crud.setModel(model.module)

            store.dispatch('officer/mybackground',{
                id: route.params.id,
                section: personalOnlyMode ? 'personal' : undefined
            }).then( async (res) => {
                officer.value = ( res.data.ok == true ) ? res.data.record : null
                if (officer.value != null) {
                    additional_officer_type.value = additional_officer_types.value.find( aot => aot.key == officer.value.additional_officer_type )
                    officer_type_name.value = additional_officer_type.value == null || additional_officer_type.value == undefined ? "មន្ត្រីរាជការ" : additional_officer_type.value.label
                }
                profileLoading.value = false
                isInitializingCareerSections.value = true
                hasCareerUserInteraction.value = false
                await nextTick()
                markAllCareerSectionsSaved()
                clearCareerChangedState()
                isInitializingCareerSections.value = false
            }).catch( err => {
                console.log( err )
                profileLoading.value = false
                isInitializingCareerSections.value = false
                hasCareerUserInteraction.value = false
            })

            onMounted(() => {
                const kh = getKhmerDateParts(today.value)
                todayKhLunarText.value = kh.headerText
                if (!signatureWeekday.value) signatureWeekday.value = kh.weekday
                if (!signatureDateDay.value) signatureDateDay.value = kh.day
                if (!signatureDateMonth.value) signatureDateMonth.value = kh.month
                if (!signatureDateYear.value) signatureDateYear.value = kh.year
                if (!signatureDatePlace.value) signatureDatePlace.value = 'រាជធានីភ្នំពេញ'
                if (!signatureDateDay2.value) signatureDateDay2.value = parseNumber(dateFormat(today.value, 'dd'))
                if (!signatureDateMonth2.value) signatureDateMonth2.value = getMonth(dateFormat(today.value, 'mm'))
                if (!signatureDateYear2.value) signatureDateYear2.value = parseNumber(String(today.value.getFullYear()))
            })

            // Function សម្រាប់​តាម marry status របស់user នៅពេលកំពុងជ្រើសរើស
            const onMaritalStatusChanged = (hasChanged, newVal) => {
                console.log("Radio clicked! New value is:", newVal); // Check your F12 console
                if (newVal) {
                    // Direct assignment is usually the most reliable for reactivity
                    formData.people.marry_status = newVal;
                }
                onCareerSectionChanged('maritalStatus', hasChanged);
            }
        
            function getPrintCardUrl(record){
                return window.location.origin+'/#/officer/print/profile/'+record.id
            }

            function openPrintProfile(record){
                const requiredFields = [
                    signatureDateDay.value,
                    signatureDateMonth.value,
                    signatureDateYear.value,
                    signatureDatePlace.value,
                    signatureDateDay2.value,
                    signatureDateMonth2.value
                ]
                const isMissing = requiredFields.some((v) => String(v ?? '').trim().length === 0)
                if (isMissing) {
                    printDateError.value = 'សូមបំពេញ ថ្ងៃ ខែ ឆ្នាំ ខាងស្ដាំ មុនបោះពុម្ភ'
                    nextTick(() => {
                        if (printDateErrorAnchorRef.value && typeof printDateErrorAnchorRef.value.scrollIntoView === 'function') {
                            printDateErrorAnchorRef.value.scrollIntoView({ behavior: 'smooth', block: 'center' })
                        }
                    })
                    return
                }
                const payload = {
                    weekday: signatureWeekday.value,
                    day: signatureDateDay.value,
                    month: signatureDateMonth.value,
                    year: signatureDateYear.value,
                    place: signatureDatePlace.value,
                    day2: signatureDateDay2.value,
                    month2: signatureDateMonth2.value,
                    year2: signatureDateYear2.value
                }
                try {
                    localStorage.setItem('officerPrintSignatureDates', JSON.stringify(payload))
                } catch (e) {}
                window.open(getPrintCardUrl(record), '_blank')
            }

            watch(
                [signatureDateDay, signatureDateMonth, signatureDateYear, signatureDatePlace, signatureDateDay2, signatureDateMonth2],
                () => {
                    if (!printDateError.value) return
                    const requiredFields = [
                        signatureDateDay.value,
                        signatureDateMonth.value,
                        signatureDateYear.value,
                        signatureDatePlace.value,
                        signatureDateDay2.value,
                        signatureDateMonth2.value
                    ]
                    const isMissing = requiredFields.some((v) => String(v ?? '').trim().length === 0)
                    if (!isMissing) printDateError.value = ''
                }
            )

            const hasCareerChanges = computed(() => {
                return Object.values(careerSectionChanged).some((changed) => changed === true)
            })
            const changedSectionKeys = computed(() => {
                return careerSectionOrder.filter((section) => careerSectionChanged[section] === true)
            })
            const changedSectionCount = computed(() => changedSectionKeys.value.length)
            const canNavigateChanges = computed(() => changedSectionCount.value > 0)

            watch(changedSectionKeys, (sections) => {
                if (sections.length === 0) {
                    activeChangedSection.value = ''
                    focusedChangedSection.value = ''
                    return
                }

                if (!sections.includes(activeChangedSection.value)) {
                    activeChangedSection.value = sections[0]
                }
            })

            onBeforeUnmount(() => {
                if (focusResetTimer) {
                    clearTimeout(focusResetTimer)
                }
            })

            function setCareerSectionAnchor(section, el) {
                if (Object.prototype.hasOwnProperty.call(careerSectionAnchors, section)) {
                    careerSectionAnchors[section] = el || null
                }
            }

            function setFormSectionAnchor(section, el) {
                if (Object.prototype.hasOwnProperty.call(formSectionAnchors, section)) {
                    formSectionAnchors[section] = el || null
                }
            }

            function scrollToSection(sectionId) {
                const targetEl = careerSectionAnchors[sectionId] || formSectionAnchors[sectionId]
                if (!targetEl || typeof targetEl.scrollIntoView !== 'function') return
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' })
                flashFocusedSection(sectionId)
            }

            function onSectionNavSelect(sectionId, index) {
                activeNavIndex.value = index
                isProgrammaticScroll.value = true
                scrollToSection(sectionId)
                // Allow smooth scroll animation to finish before re-enabling scroll tracking
                setTimeout(() => {
                    isProgrammaticScroll.value = false
                }, 450)
            }

            function flashFocusedSection(section) {
                focusedChangedSection.value = section
                if (focusResetTimer) {
                    clearTimeout(focusResetTimer)
                }
                focusResetTimer = setTimeout(() => {
                    if (focusedChangedSection.value === section) {
                        focusedChangedSection.value = ''
                    }
                }, 1300)
            }

            function scrollToCareerSection(section) {
                const targetEl = careerSectionAnchors[section]
                if (!targetEl || typeof targetEl.scrollIntoView !== 'function') return

                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' })
                flashFocusedSection(section)
            }

            function moveToChangedSection(step) {
                const sections = changedSectionKeys.value
                if (sections.length === 0) return

                if (sections.length === 1) {
                    activeChangedSection.value = sections[0]
                    scrollToCareerSection(sections[0])
                    return
                }

                const currentIndex = Math.max(sections.indexOf(activeChangedSection.value), 0)
                const nextIndex = (currentIndex + step + sections.length) % sections.length
                const nextSection = sections[nextIndex]
                activeChangedSection.value = nextSection
                scrollToCareerSection(nextSection)
            }

            function goToPreviousChange() {
                moveToChangedSection(-1)
            }

            function goToNextChange() {
                moveToChangedSection(1)
            }

            function onMainScroll(e) {
                if (isProgrammaticScroll.value) {
                    return
                }
                const container = e?.target
                if (!container) return

                const scrollTop = container.scrollTop || container.scrollTop === 0 ? container.scrollTop : 0
                const scrollHeight = container.scrollHeight || 0
                const clientHeight = container.clientHeight || container.offsetHeight || 0

                // If we're very close to the bottom, force last section (status) active
                const remaining = scrollHeight - (scrollTop + clientHeight)
                if (scrollHeight > 0 && clientHeight > 0 && remaining < 40) {
                    const lastIndex = sectionNavItems.length - 1
                    if (activeNavIndex.value !== lastIndex) {
                        activeNavIndex.value = lastIndex
                    }
                    return
                }

                const containerTop = container.getBoundingClientRect().top
                const thresholdTop = containerTop + clientHeight * 0.15

                let bestIndex = activeNavIndex.value
                let bestDistance = Number.POSITIVE_INFINITY

                sectionNavItems.forEach((item, index) => {
                    const el = careerSectionAnchors[item.id] || formSectionAnchors[item.id]
                    if (!el || typeof el.getBoundingClientRect !== 'function') return

                    const rect = el.getBoundingClientRect()
                    const distance = Math.abs(rect.top - thresholdTop)

                    if (distance < bestDistance) {
                        bestDistance = distance
                        bestIndex = index
                    }
                })

                if (bestIndex !== activeNavIndex.value) {
                    activeNavIndex.value = bestIndex
                }
            }

            function onCareerSectionChanged(section, changed) {
                if (!careerSectionChanged.hasOwnProperty(section)) return
                if (isInitializingCareerSections.value) {
                    careerSectionChanged[section] = false
                    return
                }
                if (!hasCareerUserInteraction.value && changed === true) {
                    careerSectionChanged[section] = false
                    return
                }
                careerSectionChanged[section] = changed === true
                if (changed === true && !activeChangedSection.value) {
                    activeChangedSection.value = section
                }
            }

            function markCareerInteraction() {
                hasCareerUserInteraction.value = true
            }

            function clearCareerChangedState() {
                Object.keys(careerSectionChanged).forEach((section) => {
                    careerSectionChanged[section] = false
                })
                focusedChangedSection.value = ''
                activeChangedSection.value = ''
            }

            function markAllCareerSectionsSaved() {
                const sectionRefs = getCareerSectionRefs()
                Object.values(sectionRefs).forEach((sectionRef) => {
                    if (!sectionRef) return
                    if (typeof sectionRef.markSaved === 'function') {
                        sectionRef.markSaved()
                    }
                })
            }

            function getCareerSectionRefs() {   //6. define here and disorder
                return {
                    personal: personalSectionRef.value,
                    maritalStatus: maritalStatusSectionRef.value,
                    spouseInformation: spouseInformationSectionRef.value,
                    parentsInformation: parentsInformationSectionRef.value,
                    childrenInformation: childrenInformationSectionRef.value,
                    emergencyInformation: emergencyInformationSectionRef.value,
                    krobKhan: krobKhanSectionRef.value,
                    language: languageSectionRef.value,
                    public: publicWorkSectionRef.value,
                    private: privateWorkSectionRef.value,
                    rankWorking: rankByWorkingSectionRef.value,
                    rankCertificate: rankByCertificateSectionRef.value,
                    outKrobKhan: outKrobKhanSectionRef.value,
                    otherStatus: noSalarySectionRef.value,
                    medalHistory: medalHistorySectionRef.value,
                    penaltyHistory: penaltyHistorySectionRef.value
                }
            }

            async function cancelCareerSection(section) {
                const sectionRef = getCareerSectionRefs()[section]
                if (!sectionRef) return false

                if (typeof sectionRef.cancelChanges === 'function') {
                    await sectionRef.cancelChanges()
                    if (careerSectionChanged.hasOwnProperty(section)) {
                        careerSectionChanged[section] = false
                    }
                    return true
                }

                if (typeof sectionRef.markSaved === 'function') {
                    sectionRef.markSaved()
                    if (careerSectionChanged.hasOwnProperty(section)) {
                        careerSectionChanged[section] = false
                    }
                    return true
                }

                return false
            }

            async function cancelActiveCareerSection() {
                if (!hasCareerChanges.value) return

                let section = activeChangedSection.value
                if (!section || careerSectionChanged[section] !== true) {
                    section = changedSectionKeys.value[0]
                }
                if (!section) return

                activeChangedSection.value = section
                scrollToCareerSection(section)

                try {
                    await cancelCareerSection(section)
                    message.success('បានបោះបង់ការកែប្រែផ្នែកនេះ')
                } catch (err) {
                    console.log(err)
                    message.error('មានបញ្ហាក្នុងការបោះបង់ការកែប្រែ')
                }
            }

            async function cancelAllCareerSections() {
                if (!hasCareerChanges.value) return

                const sections = [...changedSectionKeys.value]

                try {
                    for (const section of sections) {
                        await cancelCareerSection(section)
                    }
                    clearCareerChangedState()
                    message.success('បានបោះបង់ការកែប្រែទាំងអស់')
                } catch (err) {
                    console.log(err)
                    message.error('មានបញ្ហាក្នុងការបោះបង់ការកែប្រែ')
                }
            }

            async function submitForm() {
                if (spouseSectionRef.value && typeof spouseSectionRef.value.persistMarriageCertAttachment === 'function') {
                    await spouseSectionRef.value.persistMarriageCertAttachment()
                }
                await saveAllCareerSections()
            }

            async function saveAllCareerSections() {
                if (!hasCareerChanges.value) return

                const sectionRefs = getCareerSectionRefs()

                try {
                    isInitializingCareerSections.value = true
                    hasCareerUserInteraction.value = false
                    for (const section of careerSectionOrder) {
                        if (careerSectionChanged[section] !== true) continue
                        const sectionRef = sectionRefs[section]
                        if (!sectionRef) continue

                        if (typeof sectionRef.persistChanges === 'function') {
                            const persisted = await sectionRef.persistChanges()
                            if (persisted === false) {
                                throw new Error(`Failed to save section: ${section}`)
                            }
                            if (careerSectionChanged.hasOwnProperty(section)) {
                                careerSectionChanged[section] = false
                            }
                        } else if (typeof sectionRef.markSaved === 'function') {
                            sectionRef.markSaved()
                            if (careerSectionChanged.hasOwnProperty(section)) {
                                careerSectionChanged[section] = false
                            }
                        }
                    }

                    const res = await store.dispatch('officer/mybackground', {
                        id: route.params.id,
                        section: personalOnlyMode ? 'personal' : undefined
                    })
                    if (res?.data?.ok === true) {
                        officer.value = res.data.record
                        additional_officer_type.value = additional_officer_types.value.find((aot) => aot.key == officer.value.additional_officer_type)
                        officer_type_name.value = additional_officer_type.value == null || additional_officer_type.value == undefined ? 'មន្ត្រីរាជការ' : additional_officer_type.value.label
                    }
                    await nextTick()
                    markAllCareerSectionsSaved()
                    clearCareerChangedState()
                    isInitializingCareerSections.value = false
                    hasCareerUserInteraction.value = false

                    message.success('បានរក្សាទុកការកែប្រែទាំងអស់')
                } catch (err) {
                    isInitializingCareerSections.value = false
                    console.log(err)
                    if (String(err?.message || '') === 'Failed to save section: krobKhan') {
                        message.error('ច. ប្រវត្តិក្របខ័ណ្ឌ មិនទាន់បំពេញគ្រប់ទិន្នន័យ ឬមានបញ្ហាក្នុងការរក្សាទុក')
                    } else {
                        message.error('មានបញ្ហាក្នុងការរក្សាទុកការកែប្រែ')
                    }
                }
            }

            // PARENT SCRIPT
            watch(() => props.officer, (newVal) => {
                if (newVal?.people?.marry_status) {
                    formData.people.marry_status = newVal.people.marry_status;
                }
            }, { immediate: true });

            return {
                profileLoading ,
                today ,
                todayKhLunarText ,
                signatureWeekday ,
                signatureDateDay ,
                signatureDateMonth ,
                signatureDateYear ,
                signatureDateDay2 ,
                signatureDateMonth2 ,
                signatureDateYear2 ,
                signatureDatePlace ,
                printDateError ,
                printDateErrorAnchorRef ,
                personalOnlyMode,
                officer ,
                dateFormat ,
                getPrintCardUrl ,
                openPrintProfile ,
                officer_type_name ,
                submitForm ,
                personalSectionRef,
                maritalStatusSectionRef,
                spouseInformationSectionRef,
                parentsInformationSectionRef,
                childrenInformationSectionRef,
                emergencyInformationSectionRef,
                krobKhanSectionRef,
                languageSectionRef,
                publicWorkSectionRef,
                privateWorkSectionRef,
                rankByWorkingSectionRef,
                rankByCertificateSectionRef,
                outKrobKhanSectionRef,
                noSalarySectionRef,
                medalHistorySectionRef,
                penaltyHistorySectionRef,
                careerSectionChanged,
                hasCareerChanges,
                changedSectionCount,
                canNavigateChanges,
                focusedChangedSection,
                setCareerSectionAnchor,
                onCareerSectionChanged,
                markCareerInteraction,
                goToPreviousChange,
                goToNextChange,
                cancelActiveCareerSection,
                cancelAllCareerSections,
                saveAllCareerSections,
                mainScrollbarRef,
                activeNavIndex,
                sectionNavItems,
                setFormSectionAnchor,
                scrollToSection,
                onSectionNavSelect,
                isProgrammaticScroll,
                onMainScroll,
                formData,
                onMaritalStatusChanged
            }
        }
    }
</script>
<style scoped >
.signature-date-input {
    width: 5em;
    border: none;
    border-bottom: 1px dotted #333;
    text-align: center;
    font-size: inherit;
    background: transparent;
    padding: 0 2px;
}
.signature-date-input.signature-date-weekday { width: 7em; min-width: 7em; }
.signature-date-input.signature-date-month { width: 5em; min-width: 3.5em; }
.signature-date-input.signature-date-year { width: 7em; }
.signature-date-input.signature-date-place { width: 12em; min-width: 10em; }

.signature-date-line {
    display: inline-block;
    min-width: 5em;
    border-bottom: 1px dotted #333;
    vertical-align: bottom;
}
.signature-date-line-month { min-width: 5em; }
.signature-date-line-year { min-width: 3.5em; }

.signature-date-lines-wrap {
    min-width: 26rem;
    margin-left: -6rem; 
}

.career-section-anchor {
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    border-radius: 2px;
}

.career-section-modified {
    background-color: #f8fbff;
    box-shadow: inset 3px 0 0 #1e3a8a;
}

.career-section-focus {
    animation: sectionFocusFlash 1.3s ease;
}

@keyframes sectionFocusFlash {
    0% {
        box-shadow: inset 3px 0 0 #1e3a8a, 0 0 0 0 rgba(30, 58, 138, 0.3);
    }
    55% {
        box-shadow: inset 3px 0 0 #1e3a8a, 0 0 0 6px rgba(30, 58, 138, 0.08);
    }
    100% {
        box-shadow: inset 3px 0 0 #1e3a8a, 0 0 0 0 rgba(30, 58, 138, 0);
    }
}
</style>
