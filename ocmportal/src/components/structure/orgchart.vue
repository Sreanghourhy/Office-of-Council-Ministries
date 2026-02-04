<template>
  <div class="relative w-full " >
    <Transition name="slide-fade" >
      <div v-if="dataFlattened"  class="" >
        <div class="chart-container border bg-gray-50 fixed left-40 top-12 right-0 bottom-0 " > </div>
        <div @click="rednerCompactChart()" class="absolute right-2 top-2 p-1 h-8 leading-6 w-28 bg-blue-700 rounded text-white cursor-pointer hover:bg-green-700 duration-300 " >ប្ដូររាងឋានានុក្រម</div>
        <div class="absolute right-32 top-2 w-1/5 " >
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="w-full relative" >
                <input type="text" @keypress.enter="filterChart(event)" v-model="searchChart" class="bg-gray-100 px-2 h-8 w-full rounded border border-gray-200 focus:border-blue-600 hover:border-blue-600 duration-300" placeholder="ស្វែងរក" />
                <svg class="absolute right-1 top-1 w-6 h-6 text-gray-400  cursor-pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
              </div>
            </template>
            សូមបញ្ចូលពាក្យគន្លឹះដើម្បីស្វែងរក
          </n-tooltip>
        </div>
      </div>
    </Transition>
    <Transition name="slide-fade" >
      <div v-if="panelOfficerHelper" 
        id="orgchart_officers_list" 
        class="absolute flex flex-wrap left-0 top-10 right-0 bottom-0 pb-12 bg-gray-100 bg-opacity-95 shadow overflow-scroll" >
        <!-- Officer Actions End -->
        <div v-if="Array.isArray( table.records.matched ) && table.records.matched.length > 0 " class="vcb-thumbnail mb-12 w-full" >
          <div v-for="(record, index) in table.records.matched" :key='index' class="item" >
            <div class="content" >
              <div v-if="record.image != false && record.image != null && record.image != undefined " class="image bg-cover bg-no-repeat " :style=" 'background-image: url(' + record.image +');' " ></div>
              <div v-if="record.image == false || record.image == null || record.image == undefined " class="image bg-contain bg-center bg-no-repeat " :style=" 'background-image: url('+ocmLogoUrl+');' " ></div>
              <div class="flex flex-wrap " >
                <div class="w-full py-2" >
                  <div v-if="record.countesy != undefined && record.countesy != null " class="w-full officer-countesy text-center font-moul mr-2" >{{  record.countesy.name }}</div>
                  <div v-if="record.people != undefined && record.people != null " class="w-full officer-name text-center font-moul leading-6 tracking-wider" >{{ record.people.lastname + " " + record.people.firstname }}<br/>{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
                </div>
                <div class="w-full flex flex-wrap justify-between text-gray-600" >
                  <div class="w-1/2 flex flex-wrap " >
                    <div v-if=" ( record.official_date != undefined && record.official_date != null ) " class="text-left text-xxs mt-1 leading-5 tracking-wider w-full" >{{ $toKhmer( dateFormat( new Date( record.official_date ) , 'dd-mm-yyyy' ) ) }}<br/></div>
                    <div v-if=" record.current_job != undefined && record.current_job != null " class="text-left text-xxs leading-5 tracking-wider w-full" >{{ 
                      record.current_job.organization_structure_position != undefined && record.current_job.organization_structure_position != null 
                        ? record.current_job.organization_structure_position.position != undefined && record.current_job.organization_structure_position.position != null 
                          ? record.current_job.organization_structure_position.position.name 
                          : '' 
                        : '' 
                    }}</div>
                  </div>
                  <div v-if=" record.current_job != undefined && record.current_job != null " class="w-1/2 text-right text-xxs my-1  leading-5 tracking-wide" >{{ 
                    record.current_job.organization_structure_position != undefined && record.current_job.organization_structure_position != null 
                        ? record.current_job.organization_structure_position.organization_structure != undefined && record.current_job.organization_structure_position.organization_structure != null 
                          ? record.current_job.organization_structure_position.organization_structure.organization.name 
                          : 'ok' 
                        : 'no'  
                  }}</div>
                </div>
                <div class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider flex flex-wrap" >
                  <div v-if="record.code != null && record.code != undefined && record.code != '' " 
                     class="w-full text-left font-bold leading-6 tracking-wider h-4" style="font-size: 0.5rem; " >{{ $toKhmer( record.code ) }}</div>
                  <div v-if="(record.code == null || record.code == undefined || record.code == '' ) && record.card != null && record.card != undefined && record.card.id > 0" 
                    class="w-full text-vcb-xs text-left font-bold leading-6 tracking-wider" >{{ $toKhmer( record.card.number ) }}</div>
                  <div v-if="(record.code == null || record.code == undefined || record.code == '' ) && (record.card == null || record.card == undefined ) && ( record.organization != undefined && record.organization != null ) " 
                    class="w-full text-xxs text-left font-bold leading-6 tracking-wider" 
                    v-html=" $toKhmer( ( record.organization != undefined && record.organization.prefix != null && record.organization.prefix != '' ? record.organization.prefix + '-'  : '' ) + ( record.id + '' ).padStart( 4 , '0' ) )" ></div>
                  <!-- <div v-if="record.code != ''" class="w-full text-left font-bold leading-6 tracking-wider h-4" style="font-size: 0.5rem; " >{{ $toKhmer( record.code ) }}</div> -->
                  <div v-if="record.people != undefined && record.people.nid != '' && record.people.nid != null " class="w-full text-left font-bold leading-6 tracking-wider h-4" style="font-size: 0.5rem; " >
                    <!-- <svg class="w-3 h-3 inline mr-1 text-blue-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 576 512"><path d="M528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm0 400H48V80h480v352zM208 256c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64zm-89.6 128h179.2c12.4 0 22.4-8.6 22.4-19.2v-19.2c0-31.8-30.1-57.6-67.2-57.6c-10.8 0-18.7 8-44.8 8c-26.9 0-33.4-8-44.8-8c-37.1 0-67.2 25.8-67.2 57.6v19.2c0 10.6 10 19.2 22.4 19.2zM360 320h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8z" fill="currentColor"></path></svg> -->
                    {{ $toKhmer( record.people.nid ) }}</div>
                  <div v-if="record.people != undefined && record.people.dob != '' && record.people.dob != null " class="w-full text-left font-bold leading-6 tracking-wider h-4" style="font-size: 0.5rem; " >
                    <!-- <svg class="w-3 h-3 inline mr-1 text-blue-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 448 512"><path d="M448 384c-28.02 0-31.26-32-74.5-32c-43.43 0-46.825 32-74.75 32c-27.695 0-31.454-32-74.75-32c-42.842 0-47.218 32-74.5 32c-28.148 0-31.202-32-74.75-32c-43.547 0-46.653 32-74.75 32v-80c0-26.5 21.5-48 48-48h16V112h64v144h64V112h64v144h64V112h64v144h16c26.5 0 48 21.5 48 48v80zm0 128H0v-96c43.356 0 46.767-32 74.75-32c27.951 0 31.253 32 74.75 32c42.843 0 47.217-32 74.5-32c28.148 0 31.201 32 74.75 32c43.357 0 46.767-32 74.75-32c27.488 0 31.252 32 74.5 32v96zM96 96c-17.75 0-32-14.25-32-32c0-31 32-23 32-64c12 0 32 29.5 32 56s-14.25 40-32 40zm128 0c-17.75 0-32-14.25-32-32c0-31 32-23 32-64c12 0 32 29.5 32 56s-14.25 40-32 40zm128 0c-17.75 0-32-14.25-32-32c0-31 32-23 32-64c12 0 32 29.5 32 56s-14.25 40-32 40z" fill="currentColor"></path></svg> -->
                    {{ $toKhmer( dateFormat( new Date( record.people.dob ) , 'dd-mm-yyyy' ) ) }}</div>
                  <div v-if="record.rank != null && record.rank != undefined " class="w-full text-left font-bold leading-6 tracking-wider " style="font-size: 0.5rem; " >
                    <!-- <svg class="w-3 h-3 inline mr-1 text-blue-600 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 7v13H7V7l5-3z"></path><path d="M10 13l2-1l2 1"></path><path d="M10 17l2-1l2 1"></path><path d="M10 9l2-1l2 1"></path></g></svg> -->
                    {{ $toKhmer( record.rank.prefix + ' ' + record.rank.name ) }}
                  </div>
                </div>
                <div v-if=" record.current_job != undefined && record.current_job != null " class="absolute right-10 top-2 w-1 h-1 bg-green-400 rounded-full " ></div>
              </div>
              <thumbnail-actions-form v-bind:model="officerModel" v-bind:record="record" :onClose="closeActions" />
            </div>
          </div>
        </div>
        <div v-if="table.records.matched.length <= 0 || table.records.matched == null " 
          class="vcb-thumbnail mb-12 w-full p-8 text-md" >
          មិនមានព័ត៌មានសម្រាប់បង្ហាញឡើយ។
        </div>
        <!-- Pagination of crud -->
        <div class="fixed left-0 right-0 bottom-8 flex flex-wrap" >
          <Transition name="slide-fade" >
            <!-- This pagination is for the media side with from Medium up -->
            <div v-if="table.pagination.totalPages > 1" class="vcb-table-pagination bg-blue-300 mx-auto">
              <n-tooltip trigger="hover">
                <template #trigger>
                  <n-popselect 
                    trigger="click"
                    v-model:value="table.pagination.perPage"
                    :options="[
                      { label: 5 , value: 5 } ,
                      { label: 10 , value: 10 } ,
                      { label: 20 , value: 20 } ,
                      { label: 30 , value: 30 } ,
                      { label: 40 , value: 40 } ,
                      { label: 50 , value: 50 } ,
                      { label: 100 , value: 100 } ,
                      { label: 200 , value: 200 } ,
                      { label: 500 , value: 500 } ,
                    ]"
                    size="small"
                    scrollable
                    @update:value="goTo(1)"
                  >
                    <div class="cursor-pointer font-pvh rounded-full p-2 px-4 border border-gray-200 text-blue-600" >{{ $toKhmer( table.pagination.perPage ) }}</div>
                  </n-popselect>
                </template>
                ចំនួនព័ត៌មានបង្ហាញម្ដង
              </n-tooltip>
              <!-- Information -->
              <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 mx-2" >{{ table.pagination.totalRecords > 0 ? $toKhmer( table.pagination.totalRecords ) + " ឯកសារ" : "" }}</div>
              <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 mx-2" >{{ table.pagination.totalPages > 0 ? $toKhmer( table.pagination.totalPages ) + " ទំព័រ" : "" }}</div>
              <!-- Pages (7) -->
              <div v-for="(page, index) in table.pagination.buttons" :key="index" :class=" (table.pagination.page == page ? ' vcb-pagination-page-active ' : ' vcb-pagination-page ' )" @click="table.pagination.page == page ? false : goTo(page) " >{{ $toKhmer( page ) }}</div>
              <!-- First -->
              <div v-if="table.pagination.page > 1 " class="vcb-pagination-page p-1" @click="first()" >
                <svg class="w-5 h-5 mx-auto" 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M18.29 17.29a.996.996 0 0 0 0-1.41L14.42 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L12.3 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path><path d="M11.7 17.29a.996.996 0 0 0 0-1.41L7.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L5.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path></svg>
              </div>
              <!-- Previous -->
              <Transition name="slide-fade" >
                <div v-if="table.pagination.page > 1 " class="vcb-pagination-page p-1" @click="previous()" >
                  <svg class="w-5 h-5 mx-auto" 
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M14.71 15.88L10.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L8.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.39.39 1.02.39 1.41 0c.38-.39.39-1.03 0-1.42z" fill="currentColor"></path></svg>
                </div>
              </Transition>
              <!-- Next -->
              <Transition name="slide-fade" >
                <div v-if="table.pagination.page < table.pagination.totalPages " class="vcb-pagination-page p-1" @click="next()" >
                  <svg class="w-5 h-5 mx-auto" 
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9.29 15.88L13.17 12L9.29 8.12a.996.996 0 1 1 1.41-1.41l4.59 4.59c.39.39.39 1.02 0 1.41L10.7 17.3a.996.996 0 0 1-1.41 0c-.38-.39-.39-1.03 0-1.42z" fill="currentColor"></path></svg>
                </div>
              </Transition>
              <!-- Last -->
              <div v-if="table.pagination.page < table.pagination.totalPages "  class="vcb-pagination-page p-1" @click="last()" >
                <svg class="w-5 h-5 mx-auto" 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M5.7 6.71a.996.996 0 0 0 0 1.41L9.58 12L5.7 15.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L7.12 6.71c-.39-.39-1.03-.39-1.42 0z" fill="currentColor"></path><path d="M12.29 6.71a.996.996 0 0 0 0 1.41L16.17 12l-3.88 3.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L13.7 6.7c-.38-.38-1.02-.38-1.41.01z" fill="currentColor"></path></svg>
              </div>
              <!-- Go to -->
              <!-- Total per page -->
            </div>
          </Transition>
        </div>
        <!-- Officer Actions -->
        <div class="fixed left-40 top-12 right-0 flex title-bar border-b border-gray-200 bg-white h-10 ">
          <!-- Title of crud -->
          <div class="flex w-90 h-10 py-1 title px-4" >
            <div class="font-moul leading-9" v-html="selectedOrganization != null ? selectedOrganization.organization.name : '' " ></div>
          </div>
          <!-- Actions button of the crud -->
          <div class="flex-grow action-buttons flex-row-reverse flex px-4">
            <div class="mt-1 ml-2 flex flex-wrap">
              <n-tooltip trigger="hover">
                <template #trigger>
                  <svg 
                  @click="closeOfficersPanel" 
                  class="ml-1 w-7 h-7 p-1 mt-1 bg-white rounded-full border border-gray-300 cursor-pointer hover:text-green-500 duration-300" 
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.658 4.527a.5.5 0 0 0-.316.948l1.158.386v1.14a.5.5 0 0 0 1 0V5.86l1.158-.386a.5.5 0 1 0-.316-.948L10 4.974l-1.342-.447zm1.77-2.46a1.5 1.5 0 0 0-.855 0l-2.865.85a.99.99 0 0 0-.708.95v4.26a1 1 0 0 0 .715.96l2.792.829A.503.503 0 0 0 9.5 10v1H8a2 2 0 0 0-2 2v.05a2.5 2.5 0 1 0 1 0V13a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v.05a2.5 2.5 0 1 0 1 0V13a2 2 0 0 0-2-2h-1.5v-1a.506.506 0 0 0-.007-.085l2.792-.83A1 1 0 0 0 14 8.128V3.874a1 1 0 0 0-.715-.959l-2.858-.849zm-.57.958a.5.5 0 0 1 .284 0L13 3.874v4.254l-2.858.849a.5.5 0 0 1-.284 0L7 8.127V3.875l2.858-.85zM5 15.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm8.5-1.5a1.5 1.5 0 1 1 0 3a1.5 1.5 0 0 1 0-3z" fill="currentColor"></path></g></svg>
                </template>
                បិទព័ត៌មានមន្ត្រី និងថ្នាក់ដឹកនាំ
              </n-tooltip>
            </div>
            <div class="w-3/5 md:w-2/5 relative" >
              <n-tooltip trigger="hover">
                <template #trigger>
                  <div class="w-full relative" >
                    <input type="text" @keypress.enter="filterRecords(false)" v-model="table.search" class="bg-gray-100 px-2 h-8 my-1 w-full rounded border border-gray-200 focus:border-blue-600 hover:border-blue-600 duration-300" placeholder="ស្វែងរក" />
                    <svg class="absolute right-1 top-2 w-6 h-6 text-gray-400  cursor-pointer" @click="filterRecords(false)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
                  </div>
                </template>
                សូមបញ្ចូលពាក្យគន្លឹះដើម្បីស្វែងរក
              </n-tooltip>
            </div>
            <!-- <div class="mt-1 mr-2 flex flex-wrap">
              <n-tooltip v-if="$hasPermission('portal_staff_creating')" trigger="hover">
                <template #trigger>
                  <div @click="showCreateModal()" class="flex cursor-pointer hover:text-green-500 duration-300 ml-2 leading-8" >
                    <svg class="w-7 h-7 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg>
                    មន្ត្រីមានអត្តលេខ
                  </div>
                </template>
                មន្ត្រីរាជការមុខងារសាធារណៈ
              </n-tooltip>
              <n-tooltip v-if="$hasPermission('portal_staff_creating')" trigger="hover">
                <template #trigger>
                  <div @click="showCreateNonOfficerModal()" class="flex cursor-pointer hover:text-green-500 duration-300 ml-2 leading-8" >
                    <svg class="w-7 h-7 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg>
                    មន្ត្រីគ្មានអត្តលេខ
                  </div>
                </template>
                មន្ត្រីនយោបាយ
              </n-tooltip> 
            </div> -->
          </div>
        </div>
      </div>
    </Transition>
    <Transition name="slide-fade" >
      <div v-if="table.loading" class="fixed flex h-screen left-40 top-0 right-0 bottom-0 bg-white bg-opacity-90">
        <div class="flex mx-auto items-center">
          <div class="spinner">
            <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
            <br/><br/>កំពុងអានមន្ត្រី...
          </div>
        </div>
      </div>
    </Transition>
    <!-- Loading -->
    <Transition name="slide-fade" >
      <div v-if="loading" class="fixed flex h-screen left-0 top-0 right-0 bottom-0 bg-white bg-opacity-90 bg-white ">
        <div class="flex mx-auto items-center">
          <div class="spinner">
            <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
            <br/><br/>កំពុងអានអង្គការលេខ...
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>

import * as d3 from 'd3'
import { OrgChart } from 'd3-org-chart'
import { onMounted, reactive ,ref , inject } from 'vue'
import { useStore } from 'vuex'
import Frame4Corner from './../widgets/frame/corner4.vue'
import ocmLogoUrl from './../../assets/logo.svg'
import ocmLogoUrlPng from './../../assets/logo.png'
import ThumbnailActionsForm from '../officer/listing/actions/thumbnail-action.vue'
import dateFormat from 'dateformat'
import { useNotification } from 'naive-ui'

/**
 * CRUD component form
 */

export default {
  name: "OrganizationOrgchart" ,
  components: { 
    Frame4Corner ,
    ThumbnailActionsForm
  },
  setup(){

    const store = useStore()
    const notify = useNotification()    
    const toKhmer = inject('toKhmer')

    const organizationStructure = ref([])
    function readOrganizationStructure(children){
      return children.map( (child) => {
        let parent = [{
          // Fields use by the organization chart
          id: child.id ,
          parentId: parseInt( child.pid ) > 0 ? parseInt( child.pid ) : null ,
          name: child.organization.name , 
          desp: child.organization.desp ,
          image: child.organization.image ,
          // Field others
          pid: child.pid ,
          tpid: child.tpid ,
          organization: child.organization ,
          root_position: child.root_position ,
          pdf: child.organization.pdf ,
          total_jobs: child.total_jobs ,
          total_jobs_of_parent_position: child.total_jobs_of_parent_position ,
          total_jobs_of_children_position: child.total_jobs_of_children_position ,

        }]
        if( child.children != undefined && child.children != null ){
          return parent.concat( readOrganizationStructure(child.children) )
        }else{
          return parent
        }
      }).flat(Infinity)
    }

    const dataFlattened = ref([])
    const chart = ref(null)
    const chartCompact = ref(false)
    const loading = ref(true)
    const nodes = ref([])
    function drawingOrgchart(){
      store.dispatch('organization/getStructure' , { organization_structure_id : 1 },{
        search: '' ,
        perPage: 1000 , 
        page: 1 ,
        id: 2
      }).then( res => {
          nodes.value = []
          nodes.value.push( {
            id: res.data.record.id ,
            parentId: parseInt( res.data.record.pid ) > 0 ? parseInt( res.data.record.pid ) : null ,
            name: res.data.record.organization.name ,
            pid: res.data.record.pid  ,
            organization: res.data.record.organization ,
            image: res.data.record.root_position.image != "" && res.data.record.root_position.image != undefined ? res.data.record.root_position.image : ocmLogoUrlPng ,
            _centered: true ,
            // Field others
            pid: res.data.record.pid ,
            tpid: res.data.record.tpid ,
            organization: res.data.record.organization ,
            total_jobs : res.data.record.total_jobs ,
            total_jobs_of_parent_position: res.data.record.total_jobs_of_parent_position ,
            total_jobs_of_children_position: res.data.record.total_jobs_of_children_position
          } )

          if( res.data.records != undefined && res.data.records != null ){
            for(const e of res.data.records ){
              nodes.value.push({
                id: e.id ,
                parentId: parseInt( e.pid ) > 0 ? parseInt( e.pid ) : null ,
                name: e.organization.name ,
                pid: e.pid ,
                organization: e.organization ,
                image: e.root_position != null && e.root_position.image != "" && e.root_position.image != undefined ? e.root_position.image : ocmLogoUrl ,
                // Field others
                pid: e.pid ,
                tpid: e.tpid ,
                total_jobs: e.total_jobs ,
                organization: e.organization ,
                total_jobs_of_parent_position: e.total_jobs_of_parent_position ,
                total_jobs_of_children_position: e.total_jobs_of_children_position
              })
            }
          }

          drawChart()
          
        // }) // Finish building chart
      }).catch( err => { console.log( err ) } );

    }
    function rednerCompactChart(){
      chartCompact.value = !chartCompact.value
      console.log( chartCompact.value )
      chart.value.compact( chartCompact.value ).render().fit()
    }

    function drawChart(){
      dataFlattened.value = nodes.value
      dataFlattened.value.columns = 'id,name,image,parentId,desp'
      chart.value = new OrgChart()
        .container('.chart-container')

        .compact(false)
        .pagingStep((d) => 5)
        .minPagingVisibleNodes((d) => 3)
        .pagingButton((d, i, arr, state) => {
          const step = state.pagingStep(d.parent);
          const currentIndex = d.parent.data._pagingStep;
          const diff = d.parent.data._directSubordinatesPaging - currentIndex;
          const min = Math.min(diff, step);
          return `
                    <div style="margin-top:50px;">
                        <div style="display:flex;width:170px;border-radius:20px;padding:5px 15px; padding-bottom:4px;;background-color:#E5E9F2">
                        <div><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.59 7.41L10.18 12L5.59 16.59L7 18L13 12L7 6L5.59 7.41ZM16 6H18V18H16V6Z" fill="#716E7B" stroke="#716E7B"/>
                        </svg>
                        </div><div style="line-height:2"> បង្ហាញអង្គភាព ${ toKhmer(min )} បន្ទាប់</div></div>
                    </div>
                  `;
        })
        .data( 
          dataFlattened.value
        )
        .svgHeight(window.innerHeight - 55)
        .initialZoom(0.8)
        // .nodeWidth((d3Node) => {
        //   let i = 0;
        //   if (d3Node.parent) { i = d3Node.parent.children.indexOf(d3Node); }
        //   if (i && i == d3Node.parent.children.length - 1) { return 600; }
        //   return (!i || i == d3Node.parent.children.length - 1) ? 300 : 100
        // })
        // .nodeHeight((d3Node) => {
        //   let i = 0;
        //   if (d3Node.parent) { i = d3Node.parent.children.indexOf(d3Node); }
        //   if (i && i == d3Node.parent.children.length - 1) { return 300; }
        //   return (!i || i == d3Node.parent.children.length - 1) ? 200 : 100
        // })
        .siblingsMargin(d3Node => 50)
        .childrenMargin(d3Node => 50)
        // .neightbourMargin((n1, n2) => 50)
        // .compactMarginPair(d3Node => 70)
        // .compactMarginBetween(d3Node => 50)
        .setActiveNodeCentered(true)
        // .layout(new URLSearchParams(new URL(document.location.href).search).get('layout') || "top")
        .layout("top")
        .linkUpdate(function (d3Node, i, arr) {
            const link = this;
            d3.select(link)
                .attr('stroke-dasharray', !i ? '2 2' : 'none')
                .attr('stroke-width', 3)
        })
        .nodeUpdate(function (node, i, arr) {
            d3.select(this).on('click.node', (event, d, i) => {
              selectedOrganization.value = d.data
              getOfficers()
              chart.value.setCentered( d.data.id +'' ).render()
            })
        })
        .nodeHeight(d => 100)
        .nodeWidth(d => {
            return 400
        })
        .childrenMargin(d => 90)
        .onNodeClick( d => {
          // this.selectedNode = this.dataFlattened.find( node => node.id == d )
          // this.organizationModal = true
          /**
           * Show drawer for adding
           */
          // this.nodeVal.pid = this.selectedNode.id 
        })
        .compactMarginBetween(d => 35)
        .compactMarginPair(d => 30)
        // .neightbourMargin((a, b) => 20)
        .buttonContent(({ node, state }) => {
          return `<div class="border border-gray-300 bg-white rounded-md flex flex-row h-6 font-bold text-blue-500" >
            <svg class="w-4" style="margin: 2px 5px auto 5px; " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M9 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H10v1a5 5 0 0 1 5 5v1h1a2 2 0 0 1 2 2v4a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-4a2 2 0 0 1 2-2h1v-1a5.002 5.002 0 0 1 4-4.9V2.5zm7 9.5h-1.5a.5.5 0 0 1-.5-.5V10a4 4 0 0 0-8 0v1.5a.5.5 0 0 1-.5.5H4a1 1 0 0 0-1 1v4h5v-2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2h5v-4a1 1 0 0 0-1-1zM6 13.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zm9 0a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM8.5 9a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM9 17h2v-2H9v2z" fill="currentColor"></path></g></svg>
            <div class="" style="margin: 1px 5px auto 5px; " >${ toKhmer( node.data._directSubordinates ) }</div>
            </div>`
        })
        .linkUpdate(function (d, i, arr) {
            d3.select(this)
                .attr("stroke", d => d.data._upToTheRootHighlighted ? '#152785' : '#E4E2E9')
                .attr("stroke-width", d => d.data._upToTheRootHighlighted ? 5 : 1)

            if (d.data._upToTheRootHighlighted) {
                d3.select(this).raise()
            }
        })
        .nodeContent(function (d, i, arr, state) {
            const colors = ['#278B8D', '#404040', '#0C5C73', '#33C6CB'];
            const color = "#FFFFFF"
            console.log( d )
            return `<div 
              style="font-family: 'Inter', sans-serif;background-color:${color}; position:absolute;margin-top:-1px; margin-left:-1px;width:${d.width}px;height:${d.height}px;border-radius:10px; border : ${d.data._highlighted || d.data._upToTheRootHighlighted ? '5px solid #E27396"' : '1px solid #E4E2E9"'}}">
                      <div class="border overflow-hidden border-gray-200" style="background-color:${color};position:absolute;margin-top:-25px;margin-left:${15}px;border-radius:100px;width:50px;height:50px;" >
                      <!-- Picture -->` +
                      (
                        // d.data.image!=null && d.data.image!=undefined
                        false
                        ? `<div class="bg-center bg-cover " style="background-image: url(`+ d.data.image +`); width: 50px; height: 50px;  background-repeat: no-repeat; background-position: center;" ></div>`
                        // : `<svg class='w-8 h-8 m-2' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M9 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H10v1a5 5 0 0 1 5 5v1h1a2 2 0 0 1 2 2v4a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-4a2 2 0 0 1 2-2h1v-1a5.002 5.002 0 0 1 4-4.9V2.5zm7 9.5h-1.5a.5.5 0 0 1-.5-.5V10a4 4 0 0 0-8 0v1.5a.5.5 0 0 1-.5.5H4a1 1 0 0 0-1 1v4h5v-2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2h5v-4a1 1 0 0 0-1-1zM6 13.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zm9 0a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM8.5 9a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM9 17h2v-2H9v2z" fill="currentColor"></path></g></svg>`
                        : `<div class="" style="background-image: url(`+ ocmLogoUrlPng +`); width: 50px; height: 50px;  background-size: 70%; background-repeat: no-repeat; background-position: center;" ></div>`
                      )
                      + `</div><!-- Menu icon -->
                      <!-- <div style="color:#08011E;position:absolute;right:20px;top:17px;font-size:10px;"><i class="fas fa-ellipsis-h"></i></div> -->
                      <!-- Name of the shape -->
                      <div style="" class="text-center text-gray-600 p-4 pt-6 font-moul leading-7" > ${d.data.name} </div>
                      <!-- Position of the shape -->
                      <!-- <div style="color:#716E7B;margin: 3px 10px 5px 10px;font-size:12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;  text-align: center; ">OK</div> -->`+ 
                      ( 
                        parseInt( d.data.total_jobs_of_parent_position ) > 0
                          ?
                          `<!-- Total staffs of each positions within the organization -->
                          <div style="position: absolute; right: 5px; bottom: -4px; border: 1px solid #CCC; background-color: #FFF; color:#716E7B; border-radius: 5px; height: 22px; padding: 2px; float: left;" >
                            <svg class="text-blue-600" style=" float: left; width: 11px; height: 11px; margin: 2px 5px auto 5px; display: inline-block; font-size: 12px ;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 448 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm95.8 32.6L272 480l-32-136l32-56h-96l32 56l-32 136l-47.8-191.4C56.9 292 0 350.3 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-72.1-56.9-130.4-128.2-133.8z" fill="currentColor"></path></svg>
                            <div class="text-blue-600" style=" float: right; font-size: 11px ; margin: 0px 5px 0px 0px; " >` + toKhmer( parseInt( d.data.total_jobs_of_parent_position ) ) + `</div>
                          </div>`
                          : ''
                      )
                      +
                      ( 
                        parseInt( d.data.total_jobs ) > 0
                          ?
                          `<!-- Total Staffs in the whole organization structure -->
                          <div style="position: absolute; left: 5px; bottom: -4px; border: 1px solid #CCC; background-color: #FFF; color:#716E7B; border-radius: 5px; height: 22px; padding: 2px; float: left;" >
                            <svg class="text-blue-600" style=" float: left; width: 11px; height: 11px; margin: 2px 5px auto 5px; display: inline-block; font-size: 12px ;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M12.475 8.014a1 1 0 0 1 .993.884l.007.116v4.368a3.484 3.484 0 0 1-6.964.19l-.005-.19V9.014a1 1 0 0 1 .883-.993l.117-.007h4.969zm0 1h-4.97v4.368a2.484 2.484 0 0 0 4.964.163l.006-.163V9.014zm-6.701-1a1.988 1.988 0 0 0-.26.82l-.008.18h-2.49v3.74a1.856 1.856 0 0 0 2.618 1.693c.08.329.196.644.344.94a2.856 2.856 0 0 1-3.957-2.466l-.004-.168V9.014a1 1 0 0 1 .883-.993l.117-.007h2.757zm8.433 0h2.784a1 1 0 0 1 .993.884l.007.116v3.74a2.855 2.855 0 0 1-3.984 2.624c.148-.298.264-.613.343-.943a1.856 1.856 0 0 0 2.635-1.536l.006-.145v-3.74h-2.516l-.006-.149a1.989 1.989 0 0 0-.262-.851zM9.988 2.989a2.227 2.227 0 1 1 0 4.455a2.227 2.227 0 0 1 0-4.455zm4.988.628a1.913 1.913 0 1 1 0 3.827a1.913 1.913 0 0 1 0-3.827zm-9.96 0a1.913 1.913 0 1 1 0 3.827a1.913 1.913 0 0 1 0-3.827zm4.972.372a1.227 1.227 0 1 0 0 2.455a1.227 1.227 0 0 0 0-2.455zm4.988.628a.913.913 0 1 0 0 1.827a.913.913 0 0 0 0-1.827zm-9.96 0a.913.913 0 1 0 0 1.827a.913.913 0 0 0 0-1.827z" fill="currentColor"></path></g></svg>
                            <div class="text-blue-600" style=" float: right; font-size: 11px ; margin: 0px 5px 0px 0px; " >` + toKhmer( d.data.total_jobs ) + `</div>
                          </div>`
                          : ''
                      )+
                    `</div>`;
        })
        .render()
        // .expandAll()
        .fit()
        loading.value = false
    }

    const searchChart = ref('')
    function filterChart() {
      // Get input value
      const value = searchChart.value

      // Clear previous higlighting
      chart.value.clearHighlighting();

      // Get chart nodes
      const data = chart.value.data();

      // Mark all previously expanded nodes for collapse
      data.forEach((d) => (d._expanded = false));

      const foundedNode = ref(null)
      // Loop over data and check if input value matches any name
      data.forEach((d) => {
        if (value != '' && d.name.toLowerCase().includes(value.toLowerCase())) {
          // If matches, mark node as highlighted
          d._highlighted = true;
          d._expanded = true;
          foundedNode.value = d
        }
      });

      // Update data and rerender graph
      chart.value.data(data)
      if( foundedNode.value._highlighted == true ){
        chart.value.setHighlighted( foundedNode.value.id )
        // chart.value.setUpToTheRootHighlighted( foundedNode.value.id )
      }
      chart.value.render().fit()
    }
    
    function addChild(){
      this.$store.dispatch( 'organizations/addchild',{
        name: this.childNode.name ,
        // document_id : 0 , // Id of the document that this record despribe
        pid : this.nodeVal.parentId > 0 ? this.nodeVal.parentId : 0 , // Id of the parent record
        desp: this.childNode.desp ,
        image: '' // this.nodeVal.image
      }).then( res => {
        if( res.data.ok ){

          chart.value.addNode({
            id: res.data.record.id,
            parentId: res.data.record.pid ,
            name: res.data.record.name,
            image: res.data.record.image != "" ? res.data.record.image : ocmLogoUrlPng ,
            desp: res.data.record.desp ,
            _centered: true
          })
        
          this.nodeVal = {
            id: 0 ,
            parentId: 0 ,
            name: "" ,
            image: "" ,
            desp: ''
          }
          this.childNode = reactive({
            id: 0 ,
            parentId: 0 ,
            name: "" ,
            image: "" ,
            desp: ''
          })
        }else{
          console.log( res.data.message )
        }
      }).catch( err => {
        console.log( err )
      })
    }

    onMounted(()=>{
      drawingOrgchart()
    })

    
    const panelOfficerHelper = ref(false)
    const selectedOrganization = ref(null)
    const table = reactive( {
      loading: false ,
      search: '' ,
      records: {
        all: [] ,
        matched: []
      },
      columns: {
        searchable: {
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          email: '' ,
          phone: '' ,
          active: ''
        },
        format: {
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          email: '' ,
          phone: '' ,
          active: ''
        }
      } ,
      pagination: {
        perPage: 20 ,
        page: 1 ,
        totalPages: 0 ,
        totalRecords: 0 ,
        start: 0 ,
        end: 0 ,
        buttons: []
      }
    })

    function filterRecords(){
      setTimeout( function(){
        table.pagination.page = 1
        getOfficers()
      } , 500 )
    }

    /**
     * Functions
     */
    function getOfficers(){
      if( selectedOrganization.value != null && selectedOrganization.value.id != undefined && selectedOrganization.value.id > 0 ){
        console.log( selectedOrganization.value )
        /**
         * Clear time interval after calling
         */
        panelOfficerHelper.value = true
        window.clearTimeout()
        table.loading = true
        store.dispatch('officer/list',{
          search: table.search ,
          perPage: table.pagination.perPage ,
          page: table.pagination.page ,
          positions: [] ,
          organizations: [selectedOrganization.value.organization.id ] ,
          ids: []
        }).then(res => {
          table.records.all = table.records.matched = res.data.records
          table.pagination = res.data.pagination
          
          var paginationNumberList = 10
          if( ( table.pagination.page - ( parseInt( paginationNumberList / 2 ) + 1 ) ) < 1 ){
            table.pagination.start = 1
            table.pagination.end = table.pagination.totalPages > paginationNumberList ? paginationNumberList : table.pagination.totalPages
          }
          else{
            table.pagination.start = table.pagination.page - parseInt( paginationNumberList / 2 )
            table.pagination.end = table.pagination.page >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + parseInt( paginationNumberList / 2 )
          }
          /**
           * Create pagination buttons
           */
          table.pagination.buttons = []
          for(var i=table.pagination.start;i<=table.pagination.end;i++){
            i <= table.pagination.totalPages ? table.pagination.buttons.push(i) : false
          }
          
          closeTableLoading()
          if( table.records.matched.length <= 0 ){
            notify.info({
              title: 'ព័ត៌មានមន្ត្រី និងថ្នាក់ដឹកនាំ' ,
              content: 'មិនមានព័ត៌មានឡើយ។' ,
              duration: 2000
            })
          }
        }).catch( err => {
          console.log( err )
        })
      }
    }
    
    function closeTableLoading(){
      table.loading = false
    }

    /**
     * Pagination functions
     */
     function first(){
      goTo( table.pagination.totalPages > 0 ? 1 : 0 )
    }
    function previous(){
      goTo( table.pagination.page <= 1 ? 1 : table.pagination.page - 1 )
    }
    function next(){
      goTo( table.pagination.page >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + 1 )
    }
    function last(){
      goTo( table.pagination.totalPages > 0 ? table.pagination.totalPages : 0 )
    }
    function goTo(page){
      table.pagination.page = page >= table.pagination.totalPages ? table.pagination.totalPages : ( page < 1 ? 1 : page)
      getOfficers()
    }
    function updatePerpage(perPage){
      table.pagination.perPage = perPage < 5 ? 5 : ( perPage > 100 ? 100 : perPgae )
      table.pagination.page = 1
      getOfficers()
    }

    function closeActions( actionStatus ){
      if( parseInt( actionStatus ) > 0 ) getOfficers()
    }

    function closeOfficersPanel(){
      table.records.all = table.records.matched = []
      panelOfficerHelper.value = false
      table.loading = false
      table.search = ''
      table.pagination = {
        perPage: 20 ,
        page: 1 ,
        totalPages: 0 ,
        totalRecords: 0 ,
        start: 0 ,
        end: 0 ,
        buttons: []
      }
    }

    function getRankStructure(){
      if( store.getters['rank/records'].all.length <= 0 ){
        store.dispatch('rank/structure').then( 
          res => {
            if( res.data.ok ){
              store.commit('rank/setAllRecords',res.data.records)
            }else{
              notify.info({
                title: 'អានព័ត៌មានតួនាទី' ,
                content: res.data.message
              })
            }
          }
        ).catch( err => {
          console.log( err )
        })
      }
    }

    function getCountesies(){
      store.dispatch('countesy/list',{
        page: 1 ,
        perPage: 1000 ,
        search: ''
      }).then(res=>{
        store.commit('countesy/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានងារ' ,
          description: 'មានបញ្ហាពេលអានងារ។'
        })
        console.log( err )
      })
    }

    function getPdcv(){
      if( store.getters['province/records'].all.length <= 0 ){
        store.dispatch( 'province/pdcv' ).then( res => {
          store.commit('province/setAllRecords',res.data.provinces)
          store.commit('district/setAllRecords',res.data.districts)
          store.commit('commune/setAllRecords',res.data.communes)
          store.commit('village/setAllRecords',res.data.villages)
        }).catch( err => {
          console.log( err )
        })
      }
    }

    getRankStructure()
    getCountesies()
    getPdcv()

    return {
      ocmLogoUrl ,
      ocmLogoUrlPng,
      model: {
        name: "organizations" ,
        title: "រចនាសម្ព័ន្ធក្រសួង"
      },
      officerModel : {
        name: "officer" ,
        module: "officers" ,
        title: "មន្ត្រីរាជការមុខងារសាធារណៈ"
      },
      chart ,
      dataFlattened,
      chart,
      loading ,
      organizationStructure ,
      dateFormat ,
      closeOfficersPanel ,
      panelOfficerHelper,
      closeActions ,
      selectedOrganization ,
      table ,
      /**
       * Table
       */
      filterRecords ,
      /**
       * Pagination functions
       */
      updatePerpage ,
      goTo ,
      previous ,
      next ,
      first , 
      last ,
      /**
       * Loading overlay
       */
      closeTableLoading ,
      filterChart ,
      searchChart ,
      rednerCompactChart
    }
  }
}

</script>

<style scoped>
  [data-tooltip]:focus:after {
      display: none;
      border-bottom-color: none !important;
      ;
  }

  [data-tooltip]:focus:before {
      display: none;
      border-bottom-color: none !important;
      ;
  }

  [data-tooltip]:after {
      height: auto !important;
      padding: 11px 11px 11px 11px !important;
      content: attr(data-tooltip);
      white-space: pre;
      line-height: 16px !important;
      text-align: left !important;
  }

  .vcb-table-pagination-info {
      @apply leading-7; 
    }
  .vcb-thumbnail {
    @apply flex flex-wrap justify-center;
  }
  .vcb-thumbnail .item {
    @apply 2xl:w-2/12 xl:w-1/5 lg:w-1/4 md:w-1/3 sm:w-1/3 w-1/2 p-2 ;
  }
  .vcb-thumbnail .item .content {
    @apply border rounded-lg hover:shadow duration-500 p-4 pt-8 relative hover:scale-105 transform-gpu bg-white hover:bg-yellow-100;
  }
  .vcb-thumbnail .item .content .officer-countesy , .vcb-thumbnail .item .content .officer-name {
  font-size: 0.65rem;
}
  .vcb-thumbnail .item .content .image {
    @apply border rounded-full border-gray-200 p-2 w-20 h-20 flex-none mx-auto overflow-hidden bg-white ;
  }
  .vcb-filters-panel {
    @apply fixed left-0 top-10 right-0 bottom-0 bg-opacity-60 bg-white ;
  }
  .vcb-filters-panel .filter-title {
    @apply w-full text-left p-4 bg-white rounded-lg ;
  }
  .vcb-filters-panel .filter-actions {
    @apply w-full text-left p-4 flex flex-wrap justify-center;
  }
  .vcb-filters-panel .filter-actions .filter-action {
    @apply p-2 m-2 bg-white rounded-lg shadow border border-gray-300 w-4/6 sm:w-2/5 md:w-1/3 lg:w-1/4 xl:w-2/6 ;
  }

</style>