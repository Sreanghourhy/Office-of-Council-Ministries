<template>
  <section  class="p-[2%] transition-all duration-300" >
    <!-- Father Section -->
    <h3 class="w-full text-left text-[15px] font-semibold text-[#1E3A8A] mb-6 border-b pb-2">
      ខ.៣. ព័ត៌មានឪពុក និង​ម្ដាយបង្កើត
    </h3>

    <div class="flex flex-row gap-8 w-full items-start mb-8">
      <div class="flex flex-col gap-4 flex-1">
        <!-- Father Name Khmer -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឪពុកឈ្មោះ</label>
          <div class="w-full relative group">
            <div v-if="shouldShowDisplay('f_name_kh')" @click="enableEdit('f_name_kh')" class="flex gap-1">
              <div 
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.f_lastname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.f_lastname || 'ត្រកូល ' }}
              </div> 
              <div
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.f_firstname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.f_firstname || 'នាម ' }}
              </div>
            </div>
            <div v-else class="flex flex-col relative">
              <div class="flex flex-row gap-1">
                <input v-model="formData.f_lastname" v-focus type="text" class="field-input-green" placeholder="ត្រកូល" />
                <input v-model="formData.f_firstname" type="text" class="field-input-green" placeholder="នាម" />
              </div>
              <button @click="cancelEdit('f_name_kh')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('f_name_kh')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_name_kh }}</span> -->
            </div>
          </div>
        </div>

        <!-- Father Name English -->
        <!-- <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះជាអក្សរពុម្ពឡាតាំង</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('f_name_en')" @click="enableEdit('f_name_en')" class="flex gap-1">
              <div
              :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.f_en_firstname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.f_en_firstname || 'First name ' }}
              </div>
              <div 
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.f_en_lastname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.f_en_lastname || 'Last name ' }}
              </div> 
            </div>
            <div v-else class="flex flex-col relative">
              <div class="flex flex-row gap-1">
                <input v-model="formData.f_en_firstname" v-focus type="text" class="field-input-green" placeholder="First name" />
                <input v-model="formData.f_en_lastname"  type="text" class="field-input-green" placeholder="Last name" />
              </div>
              <button @click="cancelEdit('f_name_en')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('f_name_en')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_name_en }}</span>
            </div>
          </div>
        </div> -->

        <!-- Father Date of Birth -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ថ្ងៃខែឆ្នាំកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('f_dob')" @click="enableEdit('f_dob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-center hover:border-[#22C55E] duration-150',
                   formData.f_dob ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.f_dob || 'ថ្ងៃ-ខែ-ឆ្នាំ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.f_dob" v-focus type="date" class="field-input-green" />
              <button @click="cancelEdit('f_dob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('f_dob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_dob }}</span> -->
            </div>
          </div>
        </div>

        <!-- Father Place of Birth -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ទីកន្លែងកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('f_pob')" @click="enableEdit('f_pob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.f_pob ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.f_pob || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.f_pob" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលទីកន្លែងកំណើត..." />
              <button @click="cancelEdit('f_pob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('f_pob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_pob }}</span> -->
            </div>
          </div>
        </div>

        <!-- Father Current Address -->
        <!-- <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">អាសយដ្ឋានបច្ចុប្បន្ន</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('f_address')" @click="enableEdit('f_address')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.f_address ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.f_address || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.f_address" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលអាសយដ្ឋាន..." />
              <button @click="cancelEdit('f_address')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('f_address')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_address }}</span>
            </div>
          </div>
        </div> -->

        <!-- Father Occupation -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">មុខរបរ/មុខតំណែង</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('f_occupation')" @click="enableEdit('f_occupation')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.f_occupation ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.f_occupation || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.f_occupation" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលមុខរបរ..." />
              <button @click="cancelEdit('f_occupation')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('f_occupation')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.f_occupation }}</span> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Father Identity Fields -->
      <div class="flex flex-col gap-6 flex-1">
        <div class="flex flex-col gap-2">
          <div class="flex flex-row gap-4">
            <!-- Father National -->
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">ជនជាតិ ៖</span>
              <div v-if="shouldShowDisplay('f_national')" @click="enableEdit('f_national')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green  hover:border-[#22C55E] duration-150', 
                            formData.f_national ? ' border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.f_national || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.f_national" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('f_national')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
            <!-- Father Nationality -->
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">សញ្ជាតិ ៖</span>
              <div v-if="shouldShowDisplay('f_nationality')" @click="enableEdit('f_nationality')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green hover:border-[#22C55E] duration-150', 
                            formData.f_nationality ? ' border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.f_nationality || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.f_nationality" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('f_nationality')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-2">
              <div class="flex flex-row gap-4">
                <div class="flex items-center gap-4 flex-1">
                  <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">ស្ថានភាព ៖</span>
                  <div class="flex items-center gap-6">
                    <!-- Alive Option (value = 0) -->
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input 
                        type="radio" 
                        v-model="formData.f_death" 
                        :value="0"
                        class="w-4 h-4 text-[#22C55E] border-gray-300 focus:ring-[#22C55E] focus:ring-1 cursor-pointer"
                      />
                      <span class="text-[13px] text-[#2C3E50]">រស់</span>
                    </label>
                    
                    <!-- Dead Option (value = 1) -->
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input 
                        type="radio" 
                        v-model="formData.f_death" 
                        :value="1"
                        class="w-4 h-4 text-[#EF4444] border-gray-300 focus:ring-[#EF4444] focus:ring-1 cursor-pointer"
                      />
                      <span class="text-[13px] text-[#2C3E50]">ស្លាប់</span>
                    </label>
                  </div>
                </div>
              </div>
              <!-- Optional: Display current status in display mode -->
              <!-- <div v-if="shouldShowDisplay('spouse_death')" class="text-[12px] text-gray-500 mt-1">
                ស្ថានភាពបច្ចុប្បន្ន៖ 
                <span :class="formData.spouse_death === 0 ? 'text-green-600' : 'text-red-600'">
                  {{ formData.spouse_death === 0 ? 'រស់' : formData.spouse_death === 1 ? 'ស្លាប់' : 'មិនទាន់កំណត់' }}
                </span>
              </div> -->
            </div>
            <!-- ==================== END NEW ==================== -->
      </div>
    </div>

    <!-- Mother Section -->
    <!-- <h3 class="w-full text-left text-[15px] font-semibold  mb-6 border-b pb-2 text-[#1E3A8A]">
      ខ.៤. ព័ត៌មានម្ដាយ
    </h3> -->
    <hr class="mb-5">

    <div class="flex flex-row gap-8 w-full items-start">
      <div class="flex flex-col gap-4 flex-1">
        <!-- Mother Name Khmer -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ម្ដាយឈ្មោះ</label>
          <div class="w-full relative group">
            <div v-if="shouldShowDisplay('m_name_kh')" @click="enableEdit('m_name_kh')" class="flex gap-1">
              <div
              :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.m_firstname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.m_firstname || 'នាម ' }}
              </div>
              <div 
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.m_lastname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.m_lastname || 'ត្រកូល ' }}
              </div> 
            </div>
            <div v-else class="flex flex-col relative">
              <div class="flex flex-row gap-1">
                <input v-model="formData.m_firstname" v-focus type="text" class="field-input-green" placeholder="នាម" />
                <input v-model="formData.m_lastname"  type="text" class="field-input-green" placeholder="ត្រកូល" />
              </div>
              <button @click="cancelEdit('m_name_kh')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('m_name_kh')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_name_kh }}</span> -->
            </div>
          </div>
        </div>

        <!-- Mother Name English -->
        <!-- <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះជាអក្សរពុម្ពឡាតាំង</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('m_name_en')" @click="enableEdit('m_name_en')" class="flex gap-1">
              <div 
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.m_en_lastname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.m_en_lastname || 'Last name ' }}
              </div> 
              <div
                   :class="[
                     'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.m_en_firstname ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.m_en_firstname || 'First name ' }}
              </div>
            </div>
            <div v-else class="flex flex-col relative">
              <div class="flex flex-row gap-1">
                <input v-model="formData.m_en_lastname" v-focus type="text" class="field-input-green" placeholder="Last name" />
                <input v-model="formData.m_en_firstname" type="text" class="field-input-green" placeholder="First name" />
              </div>
              <button @click="cancelEdit('m_name_en')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('m_name_en')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_name_en }}</span>
            </div>
          </div>
        </div> -->

        <!-- Mother Date of Birth -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ថ្ងៃខែឆ្នាំកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('m_dob')" @click="enableEdit('m_dob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-center hover:border-[#22C55E] duration-150',
                   formData.m_dob ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.m_dob || 'ថ្ងៃ-ខែ-ឆ្នាំ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.m_dob" v-focus type="date" class="field-input-green" />
              <button @click="cancelEdit('m_dob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('m_dob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_dob }}</span> -->
            </div>
          </div>
        </div>

        <!-- Mother Place of Birth -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ទីកន្លែងកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('m_pob')" @click="enableEdit('m_pob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.m_pob ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.m_pob || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.m_pob" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលទីកន្លែងកំណើត..." />
              <button @click="cancelEdit('m_pob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('m_pob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_pob }}</span> -->
            </div>
          </div>
        </div>

        <!-- Mother Current Address -->
        <!-- <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">អាសយដ្ឋានបច្ចុប្បន្ន</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('m_address')" @click="enableEdit('m_address')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.m_address ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.m_address || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.m_address" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលអាសយដ្ឋាន..." />
              <button @click="cancelEdit('m_address')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('m_address')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_address }}</span>
            </div>
          </div>
        </div> -->

        <!-- Mother Occupation -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">មុខរបរ/មុខតំណែង</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('m_occupation')" @click="enableEdit('m_occupation')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.m_occupation ? 'border-[#E2E8F0] ' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.m_occupation || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.m_occupation" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលមុខរបរ..." />
              <button @click="cancelEdit('m_occupation')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('m_occupation')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.m_occupation }}</span> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Mother Identity Fields -->
      <div class="flex flex-col gap-6 flex-1">
        <div class="flex flex-col gap-2">
          <div class="flex flex-row gap-4">
            <!-- Mother National -->
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">ជនជាតិ ៖</span>
              <div v-if="shouldShowDisplay('m_national')" @click="enableEdit('m_national')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green hover:border-[#22C55E] duration-150', 
                            formData.m_national ? ' border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.m_national || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.m_national" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('m_national')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
            <!-- Mother Nationality -->
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">សញ្ជាតិ ៖</span>
              <div v-if="shouldShowDisplay('m_nationality')" @click="enableEdit('m_nationality')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green hover:border-[#22C55E] duration-150', 
                            formData.m_nationality ? ' border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.m_nationality || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.m_nationality" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('m_nationality')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2">
              <div class="flex flex-row gap-4">
                <div class="flex items-center gap-4 flex-1">
                  <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">ស្ថានភាព ៖</span>
                  <div class="flex items-center gap-6">
                    <!-- Alive Option (value = 0) -->
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input 
                        type="radio" 
                        v-model="formData.m_death" 
                        :value="0"
                        class="w-4 h-4 text-[#22C55E] border-gray-300 focus:ring-[#22C55E] focus:ring-1 cursor-pointer"
                      />
                      <span class="text-[13px] text-[#2C3E50]">រស់</span>
                    </label>
                    
                    <!-- Dead Option (value = 1) -->
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input 
                        type="radio" 
                        v-model="formData.m_death" 
                        :value="1"
                        class="w-4 h-4 text-[#EF4444] border-gray-300 focus:ring-[#EF4444] focus:ring-1 cursor-pointer"
                      />
                      <span class="text-[13px] text-[#2C3E50]">ស្លាប់</span>
                    </label>
                  </div>
                </div>
              </div>
              <!-- Optional: Display current status in display mode -->
              <!-- <div v-if="shouldShowDisplay('spouse_death')" class="text-[12px] text-gray-500 mt-1">
                ស្ថានភាពបច្ចុប្បន្ន៖ 
                <span :class="formData.spouse_death === 0 ? 'text-green-600' : 'text-red-600'">
                  {{ formData.spouse_death === 0 ? 'រស់' : formData.spouse_death === 1 ? 'ស្លាប់' : 'មិនទាន់កំណត់' }}
                </span>
              </div> -->
            </div>
            <!-- ==================== END NEW ==================== -->
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref, watch, computed } from 'vue'
import { useStore } from 'vuex'

export default {
  directives: {
    focus: { mounted(el) { el.focus() } }
  },
  emits: ['changed'],
  props: {
    officer: { type: Object, default: () => ({}) }
  },
  setup(props, { emit }) {
    const store = useStore()
    const editModeFields = ref(new Set())
    const originalSnapshot = ref({})
    const originalSnapshotKey = ref('')
    
    // ADD THIS - initial load flag to prevent emitting on first load
    const isInitialLoad = ref(true)
    
    const formData = ref({
      f_name_kh: '', f_firstname: '', f_lastname: '',
      f_name_en: '', f_en_firstname: '', f_en_lastname: '',
      f_dob: '', f_pob: '', f_address: '', f_occupation: '', f_national: '', f_nationality: '', f_death: '',
      m_name_kh: '', m_firstname: '', m_lastname: '',
      m_name_en: '', m_en_firstname: '', m_en_lastname: '',
      m_dob: '', m_pob: '', m_address: '', m_occupation: '', m_national: '', m_nationality: '', m_death: '',
    })

    const getPeopleId = () => {
      return props.officer?.people?.id || props.officer?.people_id || null
    }

    // Helper function to format date for API
    function formatDateForAPI(value) {
      if (!value) return null
      return value
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      return Number.isNaN(d.getTime()) ? '' : d.toISOString().slice(0, 10)
    }

    function buildSnapshot(source = formData.value) {
      const current = source || {}
      return JSON.stringify({
        f_firstname: current.f_firstname || '',
        f_lastname: current.f_lastname || '',
        f_en_firstname: current.f_en_firstname || '',
        f_en_lastname: current.f_en_lastname || '',
        f_dob: current.f_dob || '',
        f_pob: current.f_pob || '',
        f_address: current.f_address || '',
        f_occupation: current.f_occupation || '',
        f_national: current.f_national || '',
        f_nationality: current.f_nationality || '',
        f_death: current.f_death ?? '',
        m_firstname: current.m_firstname || '',
        m_lastname: current.m_lastname || '',
        m_en_firstname: current.m_en_firstname || '',
        m_en_lastname: current.m_en_lastname || '',
        m_dob: current.m_dob || '',
        m_pob: current.m_pob || '',
        m_address: current.m_address || '',
        m_occupation: current.m_occupation || '',
        m_national: current.m_national || '',
        m_nationality: current.m_nationality || '',
        m_death: current.m_death ?? ''
      })
    }

    function markSnapshot(source = formData.value) {
      originalSnapshot.value = { ...source }
      originalSnapshotKey.value = buildSnapshot(source)
    }

    function hydrateData() {
      if (!props.officer?.people) return
      const p = props.officer.people

      const mapped = {
        f_name_kh: `${p.father_firstname || ''} ${p.father_lastname || ''}`.trim(),
        f_firstname: p.father_firstname || '',
        f_lastname: p.father_lastname || '',
        f_name_en: `${p.father_enfirstname || ''} ${p.father_enlastname || ''}`.trim(),
        f_en_firstname: p.father_enfirstname || '',
        f_en_lastname: p.father_enlastname || '',
        f_dob: toInputDate(p.father_dob),
        f_pob: p.father_pob || '',
        f_address: p.father_address || '',
        f_occupation: p.father_profession || '',
        f_national: p.father_national || '',
        f_nationality: p.father_nationality || '',
        f_death: p.father_death ?? '',

        m_name_kh: `${p.mother_firstname || ''} ${p.mother_lastname || ''}`.trim(),
        m_firstname: p.mother_firstname || '',
        m_lastname: p.mother_lastname || '',
        m_name_en: `${p.mother_enfirstname || ''} ${p.mother_enlastname || ''}`.trim(),
        m_en_firstname: p.mother_enfirstname || '',
        m_en_lastname: p.mother_enlastname || '',
        m_dob: toInputDate(p.mother_dob),
        m_pob: p.mother_pob || '',
        m_address: p.mother_address || '',
        m_occupation: p.mother_profession || '',
        m_national: p.mother_national || '',
        m_nationality: p.mother_nationality || '',
        m_death: p.mother_death ?? '',
      }

      formData.value = { ...mapped }
      markSnapshot(mapped)
      editModeFields.value.clear()
      
      // Reset initial load flag after hydration
      isInitialLoad.value = true
    }

    const persistChanges = async () => {
      // IMPORTANT: Check if there are actually any changes
      if (!isDirty.value) {
        return true
      }
      
      try {
        const pid = getPeopleId()
        if (!pid) {
          return false
        }

        const payload = {
          id: props.officer?.id,
          people: {
            father_firstname: formData.value.f_firstname || '',
            father_lastname: formData.value.f_lastname || '',
            father_enfirstname: formData.value.f_en_firstname || '',
            father_enlastname: formData.value.f_en_lastname || '',
            father_dob: formatDateForAPI(formData.value.f_dob) || null,
            father_pob: formData.value.f_pob || '',
            father_address: formData.value.f_address || '',
            father_profession: formData.value.f_occupation || '',
            father_national: formData.value.f_national || '',
            father_nationality: formData.value.f_nationality || '',
            father_death: formData.value.f_death ?? '',
            mother_firstname: formData.value.m_firstname || '',
            mother_lastname: formData.value.m_lastname || '',
            mother_enfirstname: formData.value.m_en_firstname || '',
            mother_enlastname: formData.value.m_en_lastname || '',
            mother_dob: formatDateForAPI(formData.value.m_dob) || null,
            mother_pob: formData.value.m_pob || '',
            mother_address: formData.value.m_address || '',
            mother_profession: formData.value.m_occupation || '',
            mother_national: formData.value.m_national || '',
            mother_nationality: formData.value.m_nationality || '',
            mother_death: formData.value.m_death ?? ''
          }
        }

        // Dispatch to Vuex - using the officer update endpoint
        const res = await store.dispatch('officer/update', payload)

        if (res?.data?.ok || res?.status === 200) {
          if (props.officer?.people) {
            Object.assign(props.officer.people, payload.people)
          }
          
          // Update the original snapshot with the new values
          markSnapshot(formData.value)
          editModeFields.value.clear()
          emit('changed', false)
          return true
        }
        
        return false
        
      } catch (err) {
        console.error('Failed to save parents info:', err)
        return false
      }
    }
    
    const cancelChanges = () => {
        hydrateData()
        editModeFields.value.clear()
        emit('changed', false)
    }

    const isDirty = computed(() => buildSnapshot(formData.value) !== originalSnapshotKey.value)

    // MODIFIED THIS WATCHER - with initial load flag
    watch(formData, () => {
      // Skip emit during initial load
      if (isInitialLoad.value) {
        isInitialLoad.value = false
        return
      }
      emit('changed', isDirty.value)
    }, { deep: true })

    watch(() => props.officer?.people, hydrateData, { immediate: true })

    return { 
      formData, 
      shouldShowDisplay: (field) => !editModeFields.value.has(field),
      enableEdit: (field) => editModeFields.value.add(field),
      cancelEdit: (field) => {
        formData.value[field] = originalSnapshot.value[field]
        editModeFields.value.delete(field)
        if (field.includes('name')) {
            // Re-sync compound name fields if firstname/lastname was canceled
            formData.value.f_name_kh = `${originalSnapshot.value.f_firstname} ${originalSnapshot.value.f_lastname}`.trim()
            formData.value.m_name_kh = `${originalSnapshot.value.m_firstname} ${originalSnapshot.value.m_lastname}`.trim()
        }
      },
      getPrevious: (field) => (formData.value[field] !== originalSnapshot.value[field]) ? originalSnapshot.value[field] : null,
      persistChanges,  // Make sure this is exposed
      cancelChanges,   // Make sure this is exposed
      markSaved: () => {  // Add this method for compatibility
        markSnapshot(formData.value)
        editModeFields.value.clear();
        emit('changed', false);
      },
      isDirty,
      originalSnapshot
    }
  }
}
</script>

<style scoped>
.field-input-green {
  width: 100%;
  border: 1px solid #E2E8F0;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 13px;
  /* background-color: #F1F5F9; */
  /* color: #1E3A8A; */
  font-weight: 500;
  text-align: left;
  outline: none;
  min-height: 38px;
}
.field-input-green:focus { border-color: #22C55E; }
input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; position: absolute; right: 30px; }
input[type="date"].field-input-green { padding-right: 60px; }
</style>
