<template>
  <section 
    class="p-[2%] transition-all duration-300"
    :class="[
      !isEnabled
        ? 'opacity-50 pointer-events-none select-none grayscale-[30%]' 
        : 'opacity-100'
    ]"
  >
    <h3 class="w-full text-left text-[15px] font-semibold mb-6 border-b pb-2 text-[#1E3A8A]">
      ខ.១. ព័ត៌មានប្តីឬប្រពន្ធ
    </h3>

    <div class="flex flex-row gap-8 w-full items-start">
      <div class="flex flex-col gap-4 flex-1">
        
        <!-- Khmer Name Field (Lastname + Firstname) -->
<div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
  <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះប្តីឬប្រពន្ធ</label>
  <div class="w-full relative group">
    <div v-if="shouldShowDisplay('name_kh')" @click="enableEdit('name_kh')" class="flex gap-1">
      <div 
           :class="[
             'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
             formData.lastname_kh ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
           ]">
        {{ formData.lastname_kh || 'គោត្តនាម' }}
      </div> 
      <div
           :class="[
             'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
             formData.firstname_kh ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
           ]">
        {{ formData.firstname_kh || 'នាម' }}
      </div>
    </div>
    <div v-else class="flex flex-col relative">
      <div class="flex flex-row gap-1">
        <!-- Lastname field first (tab index 1) -->
        <input 
          v-model="formData.lastname_kh" 
          v-focus 
          type="text" 
          class="field-input-green" 
          placeholder="គោត្តនាម"
          ref="lastnameKhInput"
        />
        <!-- Firstname field second (tab index 2) -->
        <input 
          v-model="formData.firstname_kh" 
          type="text" 
          class="field-input-green" 
          placeholder="នាម"
        />
      </div>
      <button @click="cancelEdit('name_kh')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
      <!-- <span v-if="getPrevious('name_kh')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.name_kh }}</span> -->
    </div>
  </div>
</div>

<!-- English Name Field (Firstname + Lastname) - Keep same order as Khmer for consistency -->
<div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
  <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះជាអក្សរពុម្ពឡាតាំង</label>
  <div class="w-full relative">
    <div v-if="shouldShowDisplay('name_en')" @click="enableEdit('name_en')" class="flex gap-1">
      <!-- In display mode, show in same order as Khmer: Lastname then Firstname -->
      <div 
           :class="[
             'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
             formData.lastname_en ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
           ]">
        {{ formData.lastname_en || 'lastname' }}
      </div> 
      <div
           :class="[
             'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
             formData.firstname_en ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
           ]">
        {{ formData.firstname_en || 'firstname' }}
      </div>
    </div>
    <div v-else class="flex flex-col relative">
      <div class="flex flex-row gap-1">
        <!-- Keep SAME ORDER as Khmer: Lastname first, then Firstname -->
        <input 
          v-model="formData.lastname_en" 
          v-focus 
          type="text" 
          class="field-input-green" 
          placeholder="lastname"
        />
        <input 
          v-model="formData.firstname_en" 
          type="text" 
          class="field-input-green" 
          placeholder="firstname"
        />
      </div>
      <button @click="cancelEdit('name_en')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
      <span v-if="getPrevious('name_en')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.name_en }}</span>
    </div>
  </div>
</div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ថ្ងៃខែឆ្នាំកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('dob')" @click="enableEdit('dob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-center hover:border-[#22C55E] duration-150',
                   formData.dob ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.dob || 'ថ្ងៃ-ខែ-ឆ្នាំ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.dob" v-focus type="date" class="field-input-green" />
              <button @click="cancelEdit('dob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('dob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.dob }}</span> -->
            </div>
          </div>
        </div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">លេខអត្តសញ្ញាណខ្មែរ</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('nid')" @click="enableEdit('nid')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.nid ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.nid || 'លេខអត្តសញ្ញាណខ្មែរ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.nid" v-focus type="text" class="field-input-green" />
              <button @click="cancelEdit('nid')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('nid')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.nid }}</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ទីកន្លែងកំណើត</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('pob')" @click="enableEdit('pob')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.pob ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.pob || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.pob" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលទីកន្លែងកំណើត..." />
              <button @click="cancelEdit('pob')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('pob')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.pob }}</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">មុខរបរ/មុខតំណែង</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('occupation')" @click="enableEdit('occupation')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.occupation ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.occupation || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <!-- <div v-if="shouldShowDisplay('occupation')" @click="enableEdit('occupation')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.occupation ? 'bg-[#F1F5F9] border-[#E2E8F0]  text-[#1E3A8A]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.occupation || 'មិនទាន់មានទិន្នន័យ' }}
            </div> -->
            <div v-else class="flex flex-col relative">
              <input v-model="formData.occupation" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលមុខរបរ..." />
              <button @click="cancelEdit('occupation')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('occupation')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.occupation }}</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះអង្គភាព</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('profession_organization')" @click="enableEdit('profession_organization')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.profession_organization ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.profession_organization || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.profession_organization" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលឈ្មោះអង្គភាព..." />
              <button @click="cancelEdit('profession_organization')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">អាសយដ្ឋានបច្ចុប្បន្ន</label>
          <div class="w-full relative">
            <div v-if="shouldShowDisplay('current_address')" @click="enableEdit('current_address')" 
                 :class="[
                   'w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.current_address ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.current_address || 'មិនទាន់មានទិន្នន័យ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.current_address" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលអាសយដ្ឋាន..." />
              <button @click="cancelEdit('current_address')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <span v-if="getPrevious('current_address')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.current_address }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-6 flex-1">
        <div class="flex flex-col gap-2">
          <!-- <label class="text-[13px] text-left font-medium text-[#2C3E50]">អត្តសញ្ញាណ</label> -->
          <div class="flex flex-row gap-4">
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">ជនជាតិ ៖</span>
              <!-- :class="['text-[13px] font-semibold cursor-pointer border-b border-dashed hover:text-[#22C55E]',  -->
              <div v-if="shouldShowDisplay('national')" @click="enableEdit('national')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green hover:border-[#22C55E] duration-150', 
                            formData.national ? 'text-[#1E3A8A] border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.national || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.national" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('national')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
            <div class="flex items-center gap-2 flex-1">
              <span class="text-[13px] whitespace-nowrap text-[#2C3E50]">សញ្ជាតិ ៖</span>
              <div v-if="shouldShowDisplay('nationality')" @click="enableEdit('nationality')" 
                   :class="['w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left field-input-green hover:border-[#22C55E] duration-150', 
                            formData.nationality ? 'text-[#1E3A8A] border-gray-300' : 'text-gray-400 border-gray-200']">
                {{ formData.nationality || 'ជ្រើសរើស' }}
              </div>
              <div v-else class="flex items-center gap-1 relative flex-1">
                <input v-model="formData.nationality" v-focus type="text" class="field-input-green px-2 py-1" />
                <button @click="cancelEdit('nationality')" class="text-gray-400 hover:text-red-500">×</button>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full max-w-md">
          <div 
            class="group flex items-center relative border-2 transition-all duration-200 rounded-lg p-1.5 bg-white"
            :class="[
              (!formData.pdf_file && !formData.existing_pdf_name) 
                ? ' hover:border-[#22C55E] hover:bg-[#F0FFF4]' 
                : 'border-[#22C55E] border-solid bg-[#F8FAFC]'
            ]"
          >
            
            <div class="flex-1 min-w-0 flex items-center px-2">
              
              <div v-if="!formData.pdf_file && !formData.existing_pdf_name" 
                  class="absolute left-[115px] top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-[13px]">
                ឯកសារភ្ជាប់ (PDF)
              </div>

              <input 
                v-if="!formData.pdf_file && !formData.existing_pdf_name" 
                type="file" 
                accept=".pdf" 
                @change="handleFileUpload" 
                class="block w-full text-[13px] 
                  text-transparent flex-1
                  file:mr-3 file:py-1 file:px-3
                  file:rounded-md file:border-0
                  file:text-[12px] file:font-semibold
                  file:bg-[#22C55E] file:text-white
                  hover:file:bg-[#1BA850] cursor-pointer" 
              />

              <div v-else class="flex items-center gap-3 overflow-hidden w-full">
                <div class="bg-red-100 p-1.5 rounded-md flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="flex flex-col min-w-0">
                  <span class="text-[13px] text-[#2C3E50] font-bold truncate">
                    {{ formData.pdf_file ? formData.pdf_file.name : formData.existing_pdf_name }}
                  </span>
                  <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">PDF Document</span>
                </div>
                
                <button 
                  type="button" 
                  @click="cancelFileUpload" 
                  class="ml-auto p-1 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-all"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>

            <div v-if="formData.pdf_file || formData.existing_pdf_name" class="flex items-center gap-1 pl-2 border-l border-gray-200 ml-2">
              <n-tooltip trigger="hover">
                <template #trigger>
                  <button 
                    @click="togglePdfModal(formData)"
                    class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors"
                  >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </template>
                មើលឯកសារ
              </n-tooltip>

              <n-tooltip trigger="hover">
                <template #trigger>
                  <button 
                    @click="downloadRowDocument(formData)"
                    :disabled="!rowHasDownload(formData)"
                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                  >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                  </button>
                </template>
                ទាញយក
              </n-tooltip>
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
                    v-model="formData.spouse_death" 
                    :value="0"
                    class="w-4 h-4 text-[#22C55E] border-gray-300 focus:ring-[#22C55E] focus:ring-1 cursor-pointer"
                  />
                  <span class="text-[13px] text-[#2C3E50]">រស់</span>
                </label>
                
                <!-- Dead Option (value = 1) -->
                <label class="flex items-center gap-2 cursor-pointer">
                  <input 
                    type="radio" 
                    v-model="formData.spouse_death" 
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
    <pdf-preview v-model:model="model" v-model:record="selectedCertificate" v-bind:show="pdfToggle" :onClose="togglePdfModal"/>
  </section>
</template>

<script>
import { ref, watch, computed , reactive } from 'vue'
import { useStore } from 'vuex'
import PdfPreview from './pdfpreview.vue'
import { useRowDocumentUpload } from './use-row-document-upload'

export default {
  components: {
    PdfPreview
  },  
  props: {
    officer: { type: Object, default: () => ({}) },
    status: { type: String, default: 'single' }
  },
  directives: {
    focus: {
      mounted(el) {
        el.focus()
      }
    }
  },
  emits: ['changed'],
  setup(props, { emit }) {
    const store = useStore()
    
    // Add initial load flag
    const isInitialLoad = ref(true)
    
    //DTO Concept
    const formData = ref({
      name_kh: '', firstname_kh: '', lastname_kh: '', 
      name_en: '', firstname_en: '', lastname_en: '', 
      dob: '', pob: '', current_address: '', occupation: '', nid: '',
      national: '', nationality: '',   spouse_death: '', profession_organization: '',  
      pdf_file: null, existing_pdf_name: '',
    })

    const originalSnapshot = ref({})
    const editModeFields = ref(new Set())
    const weddingCertificateId = ref(null)

    const {
      rowHasDownload,
      downloadDocument
    } = useRowDocumentUpload(store, 'officerjobbackground/upload')
    
    // Computed property for enabled state
    const isEnabled = computed(() => {
      return props.status === 'married' || props.officer?.people?.marry_status === 'married'
    })

    // Get people_id
    const getPeopleId = () => {
      return props.officer?.people?.id || props.officer?.people_id || null
    }

    // Get wedding certificate (FIXED - was missing)
    const getWeddingCert = () => {
      return props.officer?.people?.wedding_certificates?.[0] || null
    }

    // Helper function to format date to YYYY-MM-DD
    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      return Number.isNaN(d.getTime()) ? '' : d.toISOString().slice(0, 10)
    }

    // Helper function to format date for API
    function formatDateForAPI(value) {
      if (!value) return null
      return value
    }

    // Hydrate data from officer prop
    function hydrateData() {
      const wc = props.officer?.people?.wedding_certificates?.[0]
      const source = wc || {}
      
      weddingCertificateId.value = wc?.id ?? null

      // Get existing PDF name
      let existingPdf = ''
      if (wc?.pdf) {
        const p = typeof wc.pdf === 'string' ? wc.pdf : ''
        const parts = p.split(/[/\\]/)
        existingPdf = parts[parts.length - 1] || 'ឯកសារបានភ្ជាប់'
      }

      // FIXED: Removed extra } at the end
      const mapped = {
        name_kh: source.spouse_firstname ? `${source.spouse_lastname} ${source.spouse_firstname}`.trim() : '',
        firstname_kh: source.spouse_firstname || '',
        lastname_kh: source.spouse_lastname || '',
        name_en: source.spouse_enfirstname ? `${source.spouse_enfirstname} ${source.spouse_enlastname}`.trim() : '',
        firstname_en: source.spouse_enfirstname || '',
        lastname_en: source.spouse_enlastname || '',
        dob: toInputDate(source.spouse_dob),
        nid: source.spouse_nid || '', 
        pob: source.spouse_pob || '',
        current_address: source.spouse_address || '',
        occupation: source.spouse_profession || '',
        national: source.spouse_national || '',
        nationality: source.spouse_nationality || '',
        spouse_death: source.spouse_death ?? '',
        profession_organization: source.spouse_profession_organization || '',
        pdf_file: null,
        existing_pdf_name: existingPdf,
        pdf: source.pdf,
        id: source.id 
      }

      formData.value = { ...mapped }
      originalSnapshot.value = JSON.parse(JSON.stringify(mapped))
      editModeFields.value.clear()
      
      // Reset initial load flag after hydration
      isInitialLoad.value = true
    }

const persistChanges = async () => {
  console.log('🔵 CHILD (Spouse): persistChanges started')
  
  try {
    if (!isEnabled.value) {
      return false
    }

    const pid = getPeopleId()
    if (!pid) {
      console.error('🔴 CHILD (Spouse): No people_id found')
      return false
    }

    const payload = JSON.parse(JSON.stringify(props.officer))
    
    if (!payload.people) {
      payload.people = {}
    }
    
    if (!payload.people.wedding_certificates || !Array.isArray(payload.people.wedding_certificates)) {
      payload.people.wedding_certificates = []
    }
    
    if (payload.people.wedding_certificates.length === 0) {
      payload.people.wedding_certificates.push({})
    }
    
    const cert = payload.people.wedding_certificates[0]

    // ==================== MAP SPOUSE DATA TO BIRTH CERTIFICATE FIELDS ====================
    const mappedData = {
      // Map spouse fields to birth certificate fields
      spouse_firstname: formData.value.firstname_kh || '',
      spouse_lastname: formData.value.lastname_kh || '',
      spouse_enfirstname: formData.value.firstname_en || '',
      spouse_enlastname: formData.value.lastname_en || '',
      spouse_dob: formatDateForAPI(formData.value.dob),
      spouse_nid: formData.value.nid || '',
      spouse_pob: formData.value.pob || '',
      spouse_address: formData.value.current_address || '',
      spouse_profession: formData.value.occupation || '',
      spouse_national: formData.value.national || '',
      spouse_nationality: formData.value.nationality || '',
      spouse_death: formData.value.spouse_death ?? '',
      spouse_profession_organization: formData.value.profession_organization || '',
      
      // Required fields that your backend expects
      birth_number: '',
      book_number: '',
      year: new Date().getFullYear().toString(),
      province_id: 0,
      district_id: 0,
      commune_id: 0,
      organization: '',
      gender: 'male',
      issued_date: new Date().toISOString().split('T')[0],
      issued_location: '',
    }
    
    // Copy mapped data to cert
    Object.assign(cert, mappedData)
    // ==================== END MAPPING ====================

    let response
    const isNewWeddingCertificate = !weddingCertificateId.value
    
    if (isNewWeddingCertificate) {
      console.log('🔵 CHILD (Spouse): Creating new wedding certificate')
      
      // Make sure we have people_id for create
      cert.people_id = pid
      
      // Don't send id for new records
      delete cert.id
      
      console.log('🔵 CHILD (Spouse): Sending payload:', cert)
      
      response = await store.dispatch('weddingcertificate/create', cert)
      console.log('🔵 CHILD (Spouse): Create response:', response)
      
      if (response?.data?.record?.id) {
        weddingCertificateId.value = response.data.record.id
      }
    } else {
      console.log('🔵 CHILD (Spouse): Updating existing wedding certificate')
      
      cert.id = weddingCertificateId.value
      
      response = await store.dispatch('weddingcertificate/update', cert)
      console.log('🔵 CHILD (Spouse): Update response:', response)
    }

    if (response?.data?.ok || response?.status === 200) {
      if (formData.value.pdf_file) {
        const recordId = weddingCertificateId.value || response?.data?.record?.id
        if (recordId) {
          const formDataUpload = new FormData()
          formDataUpload.append('id', recordId)
          formDataUpload.append('file', formData.value.pdf_file)
          await store.dispatch('weddingcertificate/upload', formDataUpload)
        }
      }

      originalSnapshot.value = JSON.parse(JSON.stringify(formData.value))
      editModeFields.value.clear()
      emit('changed', false)
      return true
    }
    
    return false
    
  } catch (err) {
    console.error("🔴 CHILD (Spouse): Failed to save spouse info:", err)
    if (err.response) {
      console.error('🔴 CHILD: Error response:', err.response.data)
      console.error('🔴 CHILD: Error status:', err.response.status)
    }
    return false
  }
}

    const cancelChanges = () => {
      hydrateData()
      editModeFields.value.clear()
      emit('changed', false)
    }

    const markSaved = () => {
      originalSnapshot.value = JSON.parse(JSON.stringify(formData.value))
      editModeFields.value.clear()
      emit('changed', false)
    }

    // --- UI METHODS ---
    const shouldShowDisplay = (field) => !editModeFields.value.has(field)
    
    const enableEdit = (field) => {
      if (!isEnabled.value) return
      editModeFields.value.add(field)
    }

    const cancelEdit = (field) => {
      formData.value[field] = originalSnapshot.value[field]
      editModeFields.value.delete(field)
      
      if (field === 'firstname_kh' || field === 'lastname_kh') {
        formData.value.name_kh = `${formData.value.firstname_kh} ${formData.value.lastname_kh}`.trim()
      }
      if (field === 'firstname_en' || field === 'lastname_en') {
        formData.value.name_en = `${formData.value.firstname_en} ${formData.value.lastname_en}`.trim()
      }
    }

    const getPrevious = (field) => {
      return (formData.value[field] !== originalSnapshot.value[field]) ? originalSnapshot.value[field] : null
    }

const handleFileUpload = (event) => {
  const file = event.target.files[0]; // We only need one file for the wedding certificate
  if (!file) return;

  // 1. Validation Logic
  const allowed_mime_types = ["application/pdf"];
  const allowed_size_mb = 5; // Usually 5MB is standard for OCM docs

  if (allowed_mime_types.indexOf(file.type) === -1) {
    // Note: ensure 'notify' is imported or available in your context
    console.error("Only PDF allowed"); 
    return;
  }

  if (file.size > allowed_size_mb * 1024 * 1024) {
    console.error("File too large");
    return;
  }

  // 2. State Sync - This is what fixes your "Reload" and "Display" issues
  formData.value.pdf_file = file; // Store the object for the API
  formData.value.existing_pdf_name = file.name; // Store the name for the UI chip
  
  // 3. Notify Parent
  emit('changed', true);

  // 4. Optional: Binary Reading (Only if your backend requires Base64)
  // Most Laravel backends prefer the raw File object via FormData
  /*
  let reader = new FileReader();
  reader.onload = (e) => {
      // If you need the base64 string for something else:
      // const base64 = btoa(e.target.result);
  };
  reader.readAsBinaryString(file);
  */
};

const cancelFileUpload = () => {
  formData.value.pdf_file = null;
  formData.value.existing_pdf_name = '';
  
  // This resets the actual HTML element so you can pick the same file again
  const input = document.querySelector('input[type="file"]');
  if (input) input.value = '';

  emit('changed', true);
};

    // --- COMPUTED ---
    const isDirty = computed(() => {
      return JSON.stringify(formData.value) !== JSON.stringify(originalSnapshot.value)
    })

    // FIXED: Watch with initial load flag
    watch(formData, () => {
      // Skip emit during initial load
      if (isInitialLoad.value) {
        isInitialLoad.value = false
        return
      }
      
      // Update compound names
      formData.value.name_kh = `${formData.value.firstname_kh} ${formData.value.lastname_kh}`.trim()
      formData.value.name_en = `${formData.value.firstname_en} ${formData.value.lastname_en}`.trim()
      
      emit('changed', isDirty.value)
    }, { deep: true })

    watch(() => props.officer, hydrateData, { immediate: true, deep: true })

    /**
     * Upload functions
     */
    /**
     * File upload
     */
    const model = reactive({
        name: 'weddingcertificate' ,
        module: 'weddingcertificates' ,
        title: 'អត្រានុកុលដ្ឋានកូន'
    })
    async function downloadRowDocument(row) {
      try {
        await downloadDocument(row, `${model.name}/pdf`)
      } catch (error) {
        console.error('Public work download error:', error)
        window.alert('Unable to download attachment.')
      }
    }
    const certificates = computed( () => {
    return store.getters[model.name + '/getRecords']
    })

    const selectedCertificate = ref(null)
    const pdfToggle = ref(false)
    function togglePdfModal(cert) {
      console.log(cert)
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
    
    return {
        model,
        pdfToggle,
        togglePdfModal,
        selectedCertificate,  
            
      formData,
      originalSnapshot,
      shouldShowDisplay,
      enableEdit,
      cancelEdit,
      getPrevious,
      handleFileUpload,
      cancelFileUpload,
      persistChanges,
      cancelChanges,
      markSaved,
      isEnabled,
      isDirty,
      downloadRowDocument,
      rowHasDownload
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
.field-input-green:focus { 
  border-color: #22C55E; 
  box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.2);
}
input[type="date"]::-webkit-calendar-picker-indicator { 
  cursor: pointer; 
  position: absolute; 
  right: 30px; 
}
input[type="date"].field-input-green { 
  padding-right: 60px; 
}
</style>