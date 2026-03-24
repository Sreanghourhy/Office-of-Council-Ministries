<template>
  <section class="p-[2%]">
    <div class="flex w-full justify-between py-3 mb-6 border-b pb-2">
      <h3 class="text-[15px] font-semibold text-[#1E3A8A]">ខ.២. ព័ត៌មានកូន</h3>
      <div class="flex items-center gap-4">
        <span class="text-[13px] text-[#2C3E50] font-medium">សរុប: {{ rows.length }} នាក់</span>
        <button
          type="button"
          class="inline-flex items-center gap-1 bg-[#1E3A8A] text-white rounded-md px-3 py-1.5 text-[13px] hover:bg-[#162E6B] duration-200"
          @click="addRow"
        >
          <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v5.5h5.5a.75.75 0 0 1 0 1.5h-5.5v5.5a.75.75 0 0 1-1.5 0v-5.5h-5.5a.75.75 0 0 1 0-1.5h5.5v-5.5A.75.75 0 0 1 10 3z" clip-rule="evenodd" />
          </svg>
          <span>បន្ថែម</span>
        </button>
      </div>
    </div>

    <div v-if="officer != undefined" class="overflow-x-auto">
      <div v-if="loading" class="w-full p-8 text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#1E3A8A]"></div>
        <p class="mt-2 text-gray-500">កំពុងផ្ទុកទិន្នន័យ...</p>
      </div>

      <table v-else class="w-full border-collapse overflow-y-hidden">
        <thead>
          <tr>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-12 text-center">ល.រ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">នាមត្រកូល</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">នាមខ្លួន</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-24 text-center">ភេទ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-40 text-center">ថ្ងៃខែឆ្នាំកំណើត</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">មុខរបរ</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">ក្នុងបន្ទុក ស្ថានភាព</th>
            <!-- <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-40 text-center">លេខបញ្ជីកំណើត</th> -->
            <!-- <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">លេខសៀវភៅ</th> -->
            <!-- <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-32 text-center">កាលបរិច្ឆេទចេញ</th> -->
            <!-- <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">អាសយដ្ឋាន</th> -->
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] text-center">ឯកសារ (PDF)</th>
            <th class="bg-[#E5EAF2] text-[#2C3E50] font-semibold text-[13px] p-2 border-b border-[#D8DEE8] w-24 text-center">សកម្មភាព</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="row._key" class="hover:bg-slate-50 transition-colors">
            <td class="p-2 border-b border-[#E5E7EB] text-center text-[13px] text-[#2C3E50]">
              {{ index + 1 }}
            </td>

            <!-- Lastname Field (New) -->
            <td class="w-[7%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'lastname')" @click="enableEdit(row, 'lastname')" class="table-display-box">
                {{ row.lastname || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.lastname" 
                  v-focus 
                  type="text" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                  placeholder="នាមត្រកូល"
                />
                <button @click="cancelEdit(row, 'lastname')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td>

            <!-- Firstname Field (New) -->
            <td class="w-[8%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'firstname')" @click="enableEdit(row, 'firstname')" class="table-display-box">
                {{ row.firstname || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.firstname" 
                  v-focus 
                  type="text" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                  placeholder="នាមខ្លួន"
                />
                <button @click="cancelEdit(row, 'firstname')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td>

            <!-- Gender Field (New) -->
<td class="w-[7%] p-2 border-b border-[#E5E7EB]">
  <div v-if="!isEditing(row, 'gender')" 
       @click="enableEdit(row, 'gender')" 
       class="table-display-box flex items-center justify-between px-2 cursor-pointer transition-all hover:border-green-500">
    <span>{{ row.gender === 'male' ? 'ប្រុស' : row.gender === 'female' ? 'ស្រី' : '---' }}</span>
    <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
    </svg>
  </div>

  <div v-else class="relative flex items-center">
    <n-select
      v-model:value="row.gender"
      v-focus
      size="small"
      :show-arrow="false" 
      :clearable="false"
      :options="[
        { label: 'ប្រុស', value: 'male' },
        { label: 'ស្រី', value: 'female' }
      ]"
      placeholder="ជ្រើសរើស"
      class="w-full gender-select-fix"
    />
    
    <button @click="cancelEdit(row, 'gender')" class="cancel-btn-absolute">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
    </button>
  </div>
</td>

            <!-- Date of Birth Field -->
            <td class="w-[10%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'dob')" @click="enableEdit(row, 'dob')" class="table-display-box">
                {{ formatDate(row.dob) || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.dob" 
                  v-focus 
                  type="date" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                />
                <button @click="cancelEdit(row, 'dob')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td>

            <!-- Occupation Field (New) -->
            <td class="p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'profession')" @click="enableEdit(row, 'profession')" class="table-display-box">
                {{ row.profession || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.profession" 
                  v-focus 
                  type="text" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                  placeholder="មុខរបរ"
                />
                <button @click="cancelEdit(row, 'profession')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td>

            <!-- Situation Status Field (New) -->
            <td class="p-2 border-b border-[#E5E7EB]">
              <!-- <div v-if="!isEditing(row, 'situation_status')" @click="enableEdit(row, 'situation_status')" class="table-display-box"> -->
              <div class="table-display-box">
                {{ row.custody }}
              </div>
              <!-- <div v-else class="relative flex items-center">
                <select v-model="row.situation_status" v-focus class="field-input-green" style="padding-right: 30px;">
                  <option value="">-- ជ្រើសរើស --</option>
                  <option value="រស់">រស់</option>
                  <option value="ស្លាប់">ស្លាប់</option>
                </select>
                <button @click="cancelEdit(row, 'situation_status')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div> -->
            </td>

            <!-- Birth Number Field -->
            <!-- <td class="w-[6%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'birth_number')" @click="enableEdit(row, 'birth_number')" class="table-display-box">
                {{ row.birth_number || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.birth_number" 
                  v-focus 
                  type="text" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                  placeholder="លេខបញ្ជីកំណើត"
                />
                <button @click="cancelEdit(row, 'birth_number')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td> -->

            <!-- Book Number Field -->
            <!-- <td class="w-[9%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'book_number')" @click="enableEdit(row, 'book_number')" class="table-display-box">
                {{ row.book_number || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.book_number" 
                  v-focus 
                  type="text" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                  placeholder="លេខសៀវភៅ"
                />
                <button @click="cancelEdit(row, 'book_number')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td> -->

            <!-- Issued Date Field -->
            <!-- <td class="w-[10%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'issued_date')" @click="enableEdit(row, 'issued_date')" class="table-display-box">
                {{ formatDate(row.issued_date) || '---' }}
              </div>
              <div v-else class="relative flex items-center">
                <input 
                  v-model="row.issued_date" 
                  v-focus 
                  type="date" 
                  class="field-input-green" 
                  style="padding-right: 30px;"
                />
                <button @click="cancelEdit(row, 'issued_date')" class="cancel-btn-absolute">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td> -->

            <!-- Address Field -->
            <!-- <td class="w-[20%] p-2 border-b border-[#E5E7EB]">
              <div v-if="!isEditing(row, 'address')" @click="enableEdit(row, 'address')" class="table-display-box">
                {{ getFullAddress(row) }}
              </div>
              <div v-else class="flex flex-col gap-1 relative min-w-[200px]">
                <select 
                  v-model="row.province_id" 
                  v-focus
                  class="field-input-green w-full"
                  @change="handleProvinceChange(row)"
                >
                  <option value="0">-- ជ្រើសរើសខេត្ត/ក្រុង --</option>
                  <option v-for="province in provinces" :key="province.id" :value="province.id">
                    {{ province.name_kh }}
                  </option>
                </select>
                
                <select 
                  v-model="row.district_id" 
                  class="field-input-green w-full"
                  :disabled="!row.province_id"
                  @change="handleDistrictChange(row)"
                >
                  <option value="0">-- ជ្រើសរើសស្រុក/ខណ្ឌ --</option>
                  <option v-for="district in getDistrictsForProvince(row.province_id)" :key="district.id" :value="district.id">
                    {{ district.name_kh }}
                  </option>
                </select>
                
                <select 
                  v-model="row.commune_id" 
                  class="field-input-green w-full"
                  :disabled="!row.district_id"
                >
                  <option value="0">-- ជ្រើសរើសឃុំ/សង្កាត់ --</option>
                  <option v-for="commune in getCommunesForDistrict(row.province_id, row.district_id)" :key="commune.id" :value="commune.id">
                    {{ commune.name_kh }}
                  </option>
                </select>
                
                <button @click="cancelEdit(row, 'address')" class="absolute -right-6 top-1 text-gray-400 hover:text-red-500">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
            </td> -->

            <!-- File Upload Field -->
            <td class="w-[10%] p-2 border-b border-[#E5E7EB]">
              <div class="certificate-upload">
                <label :for="`file-upload-${row._key}`" class="certificate-upload-trigger">ឯកសារ</label>
                <input :id="`file-upload-${row._key}`" type="file" class="hidden" accept=".pdf,image/*" @change="onFileChange(row, $event)" />
                <span class="certificate-file-name" :title="row.fileName || 'មិនទាន់ជ្រើសរើសឯកសារ'">
                  {{ shortenFileName(row.fileName) }}
                </span> 
                <button v-if="row.file || row.fileName" type="button" @click="clearFile(row)" class="certificate-upload-clear px-1">
                  <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.72 4.72a.75.75 0 0 1 1.06 0L10 8.94l4.22-4.22a.75.75 0 1 1 1.06 1.06L11.06 10l4.22 4.22a.75.75 0 1 1-1.06 1.06L10 11.06l-4.22 4.22a.75.75 0 1 1-1.06-1.06L8.94 10 4.72 5.78a.75.75 0 0 1 0-1.06z" clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </td>

            <!-- Actions Field -->
            <td class="border-b border-[#E5E7EB] text-center flex flex-row p-4 ">
              <n-tooltip trigger="hover">
                <template #trigger>
                  <svg 
                    @click="togglePdfModal(row)"
                    class="pdf-previewer text-red-500 w-5 h-5 cursor-pointer" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M509.2 490.8c-.7-1.3-1.4-1.9-2.2-2c-2.9 3.3-2.2 31.5 2.7 51.4c4-13.6 4.7-40.5-.5-49.4zm-1.6 120.5c-7.7 20-18.8 47.3-32.1 71.4c4-1.6 8.1-3.3 12.3-5c17.6-7.2 37.3-15.3 58.9-20.2c-14.9-11.8-28.4-27.7-39.1-46.2z" fill-opacity=".15" fill="currentColor"></path><path d="M534 352V136H232v752h560V394H576a42 42 0 0 1-42-42zm55 287.6c16.1-1.9 30.6-2.8 44.3-2.3c12.8.4 23.6 2 32 5.1c.2.1.3.1.5.2c.4.2.8.3 1.2.5c.5.2 1.1.4 1.6.7c.1.1.3.1.4.2c4.1 1.8 7.5 4 10.1 6.6c9.1 9.1 11.8 26.1 6.2 39.6c-3.2 7.7-11.7 20.5-33.3 20.5c-21.8 0-53.9-9.7-82.1-24.8c-25.5 4.3-53.7 13.9-80.9 23.1c-5.8 2-11.8 4-17.6 5.9c-38 65.2-66.5 79.4-84.1 79.4c-4.2 0-7.8-.9-10.8-2c-6.9-2.6-12.8-8-16.5-15c-.9-1.7-1.6-3.4-2.2-5.2c-1.6-4.8-2.1-9.6-1.3-13.6l.6-2.7c.1-.2.1-.4.2-.6c.2-.7.4-1.4.7-2.1c0-.1.1-.2.1-.3c4.1-11.9 13.6-23.4 27.7-34.6c12.3-9.8 27.1-18.7 45.9-28.4c15.9-28 37.6-75.1 51.2-107.4c-10.8-41.8-16.7-74.6-10.1-98.6c.9-3.3 2.5-6.4 4.6-9.1c.2-.2.3-.4.5-.6c.1-.1.1-.2.2-.2c6.3-7.5 16.9-11.9 28.1-11.5c16.6.7 29.7 11.5 33 30.1c1.7 8 2.2 16.5 1.9 25.7v.7c0 .5 0 1-.1 1.5c-.7 13.3-3 26.6-7.3 44.7c-.4 1.6-.8 3.2-1.2 5.2l-1 4.1l-.1.3c.1.2.1.3.2.5l1.8 4.5c.1.3.3.7.4 1c.7 1.6 1.4 3.3 2.1 4.8v.1c8.7 18.8 19.7 33.4 33.9 45.1c4.3 3.5 8.9 6.7 13.9 9.8c1.8-.5 3.5-.7 5.3-.9z" fill-opacity=".15" fill="currentColor"></path><path d="M391.5 761c5.7-4.4 16.2-14.5 30.1-34.7c-10.3 9.4-23.4 22.4-30.1 34.7zm270.9-83l.2-.3h.2c.6-.4.5-.7.4-.9c-.1-.1-4.5-9.3-45.1-7.4c35.3 13.9 43.5 9.1 44.3 8.6z" fill-opacity=".15" fill="currentColor"></path><path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM602 137.8L790.2 326H602V137.8zM792 888H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path><path d="M535.9 585.3c-.8-1.7-1.5-3.3-2.2-4.9c-.1-.3-.3-.7-.4-1l-1.8-4.5c-.1-.2-.1-.3-.2-.5l.1-.3l.2-1.1c4-16.3 8.6-35.3 9.4-54.4v-.7c.3-8.6-.2-17.2-2-25.6c-3.8-21.3-19.5-29.6-32.9-30.2c-11.3-.5-21.8 4-28.1 11.4c-.1.1-.1.2-.2.2c-.2.2-.4.4-.5.6c-2.1 2.7-3.7 5.8-4.6 9.1c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.4-51.2 107.4v.1c-27.7 14.3-64.1 35.8-73.6 62.9c0 .1-.1.2-.1.3c-.2.7-.5 1.4-.7 2.1c-.1.2-.1.4-.2.6c-.2.9-.5 1.8-.6 2.7c-.9 4-.4 8.8 1.3 13.6c.6 1.8 1.3 3.5 2.2 5.2c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-2.6-2.6-6-4.8-10.1-6.6c-.1-.1-.3-.1-.4-.2c-.5-.2-1.1-.4-1.6-.7c-.4-.2-.8-.3-1.2-.5c-.2-.1-.3-.1-.5-.2c-16.2-5.8-41.7-6.7-76.3-2.8l-5.3.6c-5-3-9.6-6.3-13.9-9.8c-14.2-11.3-25.1-25.8-33.8-44.7zM391.5 761c6.7-12.3 19.8-25.3 30.1-34.7c-13.9 20.2-24.4 30.3-30.1 34.7zM507 488.8c.8.1 1.5.7 2.2 2c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4zm-19.2 188.9c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2zm175.4-.9c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4z" fill="currentColor"></path></svg>
                </template>
                មើលឯកសារយោង។
              </n-tooltip>
              <n-tooltip trigger="hover">
                <template #trigger>
                  <svg
                    class="w-5 h-5 mx-auto text-red-500 cursor-pointer" 
                    @click="removeRow(index)" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>
                </template>
                លុបព័ត៌មាននេះ។
              </n-tooltip>
              <n-tooltip trigger="hover">
                <template #trigger>
                  <svg
                    class="w-5 h-5 mx-auto text-red-500 cursor-pointer" 
                    :disabled="!rowHasDownload(row)"
                    @click="downloadRowDocument(row)" 
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"></path><path d="M7 11l5 5l5-5"></path><path d="M12 4v12"></path></g></svg>
                </template>
                ទាញយកឯកសារ
              </n-tooltip>
            </td>
          </tr>
          <tr v-if="rows.length <= 0 && !loading">
            <td colspan="13" class="bg-white p-8 text-center text-gray-400 border-b border-[#E5E7EB] italic">មិនទាន់មានទិន្នន័យកូន</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="w-full p-8 text-center text-red-500 font-medium bg-red-50 rounded-lg">សូមបញ្ជាក់ព័ត៌មានមន្ត្រីជាមុនសិន។</div>
    <pdf-preview :model="model" :record="selectedCertificate" v-bind:show="pdfToggle" :onClose="togglePdfModal"/>
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
  directives: {
    focus: {
      mounted(el) {
        el.focus()
      }
    }
  },
  emits: ['changed'],
  props: {
    officer: { type: Object, default: undefined }
  },
  setup(props, { emit }) {
    const store = useStore()
    const rows = ref([])

    const editModeMap = ref({}) 
    const backupData = ref({}) 

    const originalSnapshot = ref([])
    const originalSnapshotKey = ref('[]')
    const isHydratingRows = ref(true)
    const loading = ref(false)
    
    // Store provinces with their nested districts and communes
    const provinces = ref([])
    const {
      rowHasDownload,
      downloadDocument
    } = useRowDocumentUpload(store, 'officerjobbackground/upload')
    
    // បង្កើត Row ថ្មី
    function nextKey() {
      const maxId = rows.value.reduce((max, row) => {
        const num = parseInt(row._key?.split('-').pop()) || 0
        return Math.max(max, num)
      }, 0)
      return `child-${maxId + 1}`
    }

    function normalizeRow(row = {}) {
      return {
        _key: row._key || '',
        id: row.id ?? null,
        lastname: row.lastname || '',
        firstname: row.firstname || '',
        gender: row.gender || '',
        profession: row.profession || '',
        custody: row.custody || '',
        dob: row.dob || '',
        province_id: row.province_id || 0,
        district_id: row.district_id || 0,
        commune_id: row.commune_id || 0,
        province_name: row.province_name || '',
        district_name: row.district_name || '',
        commune_name: row.commune_name || '',
        fileName: row.fileName || '',
        attachment: row.attachment || '',
        pdf: row.pdf || '',
        upload_name: row.file instanceof File ? row.file.name : '',
        upload_size: row.file instanceof File ? row.file.size : 0,
        upload_modified: row.file instanceof File ? row.file.lastModified : 0
      }
    }

    function buildRowsSnapshot(source = rows.value) {
      return JSON.stringify((source || []).map((row) => normalizeRow(row)))
    }

    function markRowsSnapshot(source = rows.value) {
      originalSnapshot.value = (source || []).map((row) => ({ ...row }))
      originalSnapshotKey.value = buildRowsSnapshot(source)
    }

    function addRow() {
      const key = nextKey()
      const newRow = {
        _key: key,
        id: null,
        dob: '', 
        custody: props.officer.people.lastname + ' ' + props.officer.people.firstname,
        birth_number: '',
        book_number: '',
        issued_date: new Date().toISOString().split('T')[0],
        province_id: 0,
        district_id: 0,
        commune_id: 0,
        province_name: '',
        district_name: '',
        commune_name: '',
        file: null, 
        fileName: '', 
        attachment: ''
      }
      rows.value.push(newRow)
      // Auto-enable edit for new rows    
    }

    // REPLACED: Initialize rows from officer data instead of fetching
    const initializeRows = () => {
      const children = props.officer?.people?.wedding_certificates?.[0]?.birth_certificates || []
      
      rows.value = children.map((child, index) => ({
        _key: child.id ? `child-${child.id}` : `child-temp-${index + 1}`,
        id: child.id || null,
        lastname: child.lastname,
        firstname: child.firstname,
        gender: child.gender,
        profession: child.profession,
        custody: props.officer.people.lastname + ' ' + props.officer.people.firstname,
        dob: toInputDate(child.dob),
        // birth_number: child.birth_number || '',
        // book_number: child.book_number || '',
        // issued_date: toInputDate(child.issued_date),
        // province_id: child.province_id || 0,
        // district_id: child.district_id || 0,
        // commune_id: child.commune_id || 0,
        // province_name: child.province?.name_kh || '',
        // district_name: child.district?.name_kh || '',
        // commune_name: child.commune?.name_kh || '',
        file: null,
        fileName: child.pdf ? 'ឯកសារបានភ្ជាប់' : '',
        attachment: child.pdf || '',
        pdf: child.pdf
      }))
      
      markRowsSnapshot(rows.value)
      editModeMap.value = {}
      backupData.value = {}
      loading.value = false
      isHydratingRows.value = true
    }

    // Edit Mode
    const enableEdit = (row, field) => {
      //get the value from the key where the field is
      const editKey = `${row._key}-${field}`
      // temparory save the value editkey 
      backupData.value[editKey] = row[field]
      editModeMap.value[editKey] = true
      
      // Load provinces when editing address
      if (field === 'address') {
        loadProvinces()
      }
    }
    
    const isEditing = (row, field) => {
      return editModeMap.value[`${row._key}-${field}`]
    }

    // Helper to get full address for display
    const getFullAddress = (row) => {
      const parts = []
      
      // Try to get from row first (if available from API)
      if (row.commune_name) parts.push(row.commune_name)
      if (row.district_name) parts.push(row.district_name)
      if (row.province_name) parts.push(row.province_name)
      
      // If not available, try to look up from provinces data
      if (parts.length === 0 && row.province_id && provinces.value.length > 0) {
        const province = provinces.value.find(p => p.id === row.province_id)
        if (province) {
          // Add province name
          parts.push(province.name_kh)
          
          // Find and add district name
          if (row.district_id && province.districts) {
            const district = province.districts.find(d => d.id === row.district_id)
            if (district) {
              parts.unshift(district.name_kh) // Add to beginning
                
              // Find and add commune name
              if (row.commune_id && district.communes) {
                const commune = district.communes.find(c => c.id === row.commune_id)
                if (commune) {
                  parts.unshift(commune.name_kh) // Add to beginning
                }
              }
            }
          }
        }
      }
      
      return parts.join(' / ')
    }

    // Get districts for a selected province from the nested data
    const getDistrictsForProvince = (provinceId) => {
      if (!provinceId || provinceId === 0) return []
      const province = provinces.value.find(p => p.id === provinceId)
      return province?.districts || []
    }

    // Get communes for a selected district from the nested data
    const getCommunesForDistrict = (provinceId, districtId) => {
      if (!provinceId || provinceId === 0 || !districtId || districtId === 0) return []
      const province = provinces.value.find(p => p.id === provinceId)
      if (!province) return []
      const district = province.districts.find(d => d.id === districtId)
      return district?.communes || []
    }

    // Load provinces (which include nested districts and communes)
    const loadProvinces = async () => {
      if (provinces.value.length > 0) return
      try {
        const response = await store.dispatch('province/list', { 
          search: '',
          perPage: 1000,
          page: 1
        })
        // console.log('Provinces response:', response)
        
        if (response?.data?.records) {
          provinces.value = response.data.records
          // console.log('Provinces loaded (records):', provinces.value.length)
        } else if (Array.isArray(response?.data)) {
          provinces.value = response.data
          // console.log('Provinces loaded (array):', provinces.value.length)
        } else if (response?.data) {
          provinces.value = response.data
          // console.log('Provinces loaded:', provinces.value)
        }
      } catch (error) {
        console.error('Error loading provinces:', error)
      }
    }

    // Handle province change
    const handleProvinceChange = (row) => {
      row.district_id = 0
      row.commune_id = 0
      const selectedProvince = provinces.value.find(p => p.id === row.province_id)
      if (selectedProvince) {
        row.province_name = selectedProvince.name_kh
      }
    }

    // Handle district change
    const handleDistrictChange = (row) => {
      row.commune_id = 0
      const province = provinces.value.find(p => p.id === row.province_id)
      if (province) {
        const selectedDistrict = province.districts.find(d => d.id === row.district_id)
        if (selectedDistrict) {
          row.district_name = selectedDistrict.name_kh
        }
      }
    }

    // Handle commune change
    const handleCommuneChange = (row) => {
      const province = provinces.value.find(p => p.id === row.province_id)
      if (province) {
        const district = province.districts.find(d => d.id === row.district_id)
        if (district) {
          const selectedCommune = district.communes.find(c => c.id === row.commune_id)
          if (selectedCommune) {
            row.commune_name = selectedCommune.name_kh
          }
        }
      }
    }

    function removeRow(index) {
      rows.value.splice(index, 1)
    }

    const disableEdit = (row, field) => {
       editModeMap.value[`${row._key}-${field}`] = false
    }

    const cancelEdit = (row, field) => {
      const editKey = `${row._key}-${field}`
      if (backupData.value.hasOwnProperty(editKey)) {
        row[field] = backupData.value[editKey]
      }
      editModeMap.value[editKey] = false
    }

    function toInputDate(value) {
      if (!value) return ''
      const d = new Date(value)
      return Number.isNaN(d.getTime()) ? '' : d.toISOString().slice(0, 10)
    }

    function formatDate(value) {
      if (!value) return '---'
      const d = new Date(value)
      if (Number.isNaN(d.getTime())) return '---'
      return d.toLocaleDateString('en-CA')
    }

    function formatDateForAPI(value) {
      if (!value) return null
      return value
    }

function onFileChange(row, event) {
  const file = event.target.files[0]
  if (!file) return

  // 1. Validation Settings
  const allowed_mime_types = ["application/pdf"]
  const allowed_size_mb = 20

  // 2. Check File Type
  if (allowed_mime_types.indexOf(file.type) === -1) {
    notify.error({
      title: "ឯកសារយោង",
      description: "អនុញ្ញាតតែឯកសារ PDF ប៉ុណ្ណោះ។",
      duration: 3000
    })
    event.target.value = ''
    return
  }

  // 3. Check File Size
  if (file.size > allowed_size_mb * 1024 * 1024) {
    notify.error({
      title: "ឯកសារយោង",
      description: `ទំហំឯកសារធំពេក។ អនុញ្ញាតត្រឹម ${allowed_size_mb}MB ប៉ុណ្ណោះ។`,
      duration: 3000
    })
    event.target.value = ''
    return
  }

  // 4. IMPORTANT: Clear the previous file reference first
  if (row.file) {
    row.file = null
  }

  // 5. Set the new file
  row.file = file
  row.fileName = file.name
  
  // 6. Tell the parent component to enable the "Save" button
  emit('changed', true)
}

function clearFile(row) {
  // Reset the data state
  row.file = null
  row.fileName = '' // Set to empty string to show no file
  
  // Force reset the file input
  const inputId = `file-upload-${row._key}`
  const fileInput = document.getElementById(inputId)
  if (fileInput) {
    fileInput.value = ''
    // Create a new file input to completely reset it
    fileInput.type = 'text'
    fileInput.type = 'file'
  }
  
  emit('changed', true)
}

    function shortenFileName(name) {
      const value = name || 'មិនទាន់ជ្រើសរើសឯកសារ'
      const max = 24
      if (value.length <= max) return value
      const head = value.slice(0, 12)
      const tail = value.slice(-8)
      return `${head}…${tail}`
    }

const persistChanges = async () => {
  const weddingCertificateId = props.officer?.people?.wedding_certificates?.[0]?.id
  if (!weddingCertificateId) {
    return false
  }

  try {
    // Track which rows have changes
    const changedRows = []
    
    // Identify changed rows by comparing with originalSnapshot
    for (const row of rows.value) {
      const originalRow = originalSnapshot.value.find(r => r.id === row.id)
      const hasFileToUpload = row.file instanceof File
      const hasDataChanged = !originalRow || buildRowsSnapshot([row]) !== buildRowsSnapshot([originalRow])
      
      if (hasDataChanged || hasFileToUpload) {
        changedRows.push(row)
      }
    }

    // Handle deleted rows
    const originalIds = originalSnapshot.value.map(r => r.id).filter(id => id)
    const currentIds = rows.value.map(r => r.id).filter(id => id)
    const deletedIds = originalIds.filter(id => !currentIds.includes(id))

    for (const id of deletedIds) {
      await store.dispatch('childcertificate/delete', id)
    }

    // Process ONLY changed rows (create or update)
    for (const row of changedRows) {
      // Prepare the payload with all fields - using wedding_certificate_id
      const payload = {
        people_id: props.officer?.people.id,
        wedding_certificate_id: weddingCertificateId,
        lastname: row.lastname || '',
        firstname: row.firstname || '',
        gender: row.gender || 'male',
        profession: row.profession || '',
        custody: row.custody || '',
        dob: formatDateForAPI(row.dob) || new Date().toISOString().split('T')[0],
        province_id: row.province_id || 0,
        district_id: row.district_id || 0,
        commune_id: row.commune_id || 0,
        pdf: row.pdf || ''
      }

      let response
      if (row.id) {
        // Update existing record
        payload.id = row.id
        response = await store.dispatch('childcertificate/update', payload)
      } else {
        // Create new record
        response = await store.dispatch('childcertificate/create', payload)
        
        // Update the row with the new ID from response
        if (response?.data?.record?.id) {
          row.id = response.data.record.id
          row._key = `child-${response.data.record.id}`
        }
      }

      // Handle file upload if there's a new file
      if (row.file && row.file instanceof File) {
        const recordId = row.id || response?.data?.record?.id || response?.data?.id
        if (recordId) {
          const formData = new FormData()
          formData.append('id', recordId)
          formData.append('file', row.file)

          try {
            const uploadResponse = await store.dispatch('childcertificate/upload', formData)
            
            if (uploadResponse?.data?.pdf) {
              row.pdf = uploadResponse.data.pdf
              row.fileName = uploadResponse.data.pdf
              row.attachment = uploadResponse.data.pdf
            }
            
            // Clear the file after successful upload
            row.file = null
            
            // Also clear the file input element
            const inputId = `file-upload-${row._key}`;
            const fileInput = document.getElementById(inputId);
            if (fileInput) {
              fileInput.value = '';
            }
            
          } catch (uploadError) {
            console.error('Child file upload failed:', uploadError)
          }
        }
      }
    }

    // Update originalSnapshot to match current rows
    markRowsSnapshot(rows.value)
    emit('changed', false)
    return true
    
  } catch (err) {
    console.error('Failed to save children info:', err)
    return false
  }
}
    // UPDATED: Use initializeRows instead of fetchChildren
    const cancelChanges = () => {
      initializeRows()
      editModeMap.value = {}
      backupData.value = {}
      emit('changed', false)
    }

    const markSaved = () => {
      markRowsSnapshot(rows.value)
      editModeMap.value = {}
      backupData.value = {}
      isHydratingRows.value = true
      emit('changed', false)
    }

    // --- COMPUTED ---
    const isDirty = computed(() => {
      return buildRowsSnapshot(rows.value) !== originalSnapshotKey.value
    })

    // --- WATCHERS ---
    watch(
      [() => props.officer?.people?.lastname, () => props.officer?.people?.firstname, () => props.officer?.people?.wedding_certificates?.[0]?.birth_certificates],
      ([lastname, firstname, children]) => {
        if (lastname !== undefined || firstname !== undefined || children !== undefined) {
          initializeRows()
        }
      },
      { immediate: true }
    )
    
    watch(rows, () => {
      if (isHydratingRows.value) {
        isHydratingRows.value = false
        return
      }
      emit('changed', isDirty.value)
    }, { deep: true })

    
    /**
     * Upload functions
     */
    /**
     * File upload
     */
    const model = reactive({
      name: 'childcertificate' ,
      module: 'childcertificates' ,
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
      
      rows, 
      loading,
      provinces,
      getFullAddress,
      getDistrictsForProvince,
      getCommunesForDistrict,
      handleProvinceChange,
      handleDistrictChange,
      handleCommuneChange,
      addRow, 
      removeRow, 
      isEditing, 
      enableEdit, 
      disableEdit, 
      cancelEdit, 
      onFileChange, 
      clearFile,
      shortenFileName,
      formatDate,
      persistChanges,
      cancelChanges,
      markSaved,
      isDirty,
      downloadRowDocument,
      rowHasDownload
    }
  }
}
</script>

<style scoped>
.table-display-box {
  width: 100%;
  /* background-color: #F1F5F9; */
  border: 1px solid #E2E8F0;
  border-radius: 4px;
  padding: 6px 8px;
  font-size: 13px;
  /* color: #1E3A8A; */
  font-weight: 500;
  text-align: center;
  min-height: 33px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.table-display-box:hover {
  border-color: #22C55E;
}

.field-input-green {
  width: 100%;
  border: 1px solid #22C55E;
  border-radius: 4px;
  padding: 6px 8px;
  font-size: 13px;
  background-color: #F1F5F9;
  color: #1E3A8A;
  font-weight: 500;
  text-align: center;
  outline: none;
  transition: all 0.2s ease-in-out;
  min-height: 33px;
}

/* Remove the background image that was causing double calendar icons */
.field-input-green[type="date"] {
  background-image: none;
}

.cancel-btn-absolute {
  position: absolute;
  right: 6px;
  color: #EF4444;
  padding: 2px;
  border-radius: 4px;
  transition: background-color 0.2s;
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cancel-btn-absolute:hover {
  background-color: #FEF2F2;
}

.certificate-upload {
  width: 100%;
  height: 33px;
  display: flex;
  align-items: center;
  border: 1px solid #d8dee8;
  border-radius: 4px;
  background: #fff;
  overflow: hidden;
}

.certificate-upload:hover { border-color: #22C55E; }

.certificate-upload-trigger {
  height: 100%;
  display: inline-flex;
  align-items: center;
  border-right: 1px solid #d8dee8;
  background: #f8fafc;
  color: #1e3a8a;
  font-size: 11px;
  padding: 0 8px;
  cursor: pointer;
  white-space: nowrap;
}

.certificate-file-name {
  flex: 1;
  min-width: 0;
  color: #2c3e50;
  font-size: 11px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 0 6px;
  text-align: center;
}

.certificate-upload-clear { color: #9ca3af; cursor: pointer; }
.certificate-upload-clear:hover { color: #dc2626; }

select.field-input-green {
  text-align-last: center;
  appearance: none;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
