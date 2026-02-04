<template>
  <div class="relative w-full" >
  <!-- Top action panel of crud -->
    <div class="flex title-bar border-b border-gray-200 bg-white ">
      <!-- Title of crud -->
      <div class="flex w-64 h-10 py-1 title px-4" >
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M17.254 11a2.25 2.25 0 0 1 2.25 2.25v6.249a5.501 5.501 0 0 1-11.002 0V13.25a2.25 2.25 0 0 1 2.25-2.25h6.502zm0 1.5h-6.502a.75.75 0 0 0-.75.75v6.249a4.001 4.001 0 0 0 8.002 0V13.25a.75.75 0 0 0-.75-.75zM4.25 11h4.156a3.243 3.243 0 0 0-.817 1.5H4.25a.75.75 0 0 0-.75.75v5.249a3.001 3.001 0 0 0 4.238 2.735c.133.49.324.956.564 1.392A4.501 4.501 0 0 1 2 18.499V13.25A2.25 2.25 0 0 1 4.25 11zm19.5 0A2.25 2.25 0 0 1 26 13.25v5.25a4.5 4.5 0 0 1-6.298 4.127l.056-.102c.214-.406.387-.837.511-1.289A3 3 0 0 0 24.5 18.5v-5.25a.75.75 0 0 0-.749-.75h-3.333A3.242 3.242 0 0 0 19.6 11h4.151zM14 3a3.5 3.5 0 1 1 0 7a3.5 3.5 0 0 1 0-7zm8.003 1a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM5.997 4a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM14 4.5a2 2 0 1 0 0 4a2 2 0 0 0 0-4zm8.003 1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm-16.006 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z" fill="currentColor"></path></g></svg>
        <div class="font-moul ml-2 leading-9" v-html="model.title" ></div>
      </div>
      <!-- Actions button of the crud -->
      <div class="flex-grow action-buttons flex-row-reverse flex px-4">
        <!-- New Button -->
        <div class="mt-1 ml-2 flex flex-wrap">
          <n-tooltip trigger="hover">
            <template #trigger>
              <svg class="ml-1 w-7 h-7 p-1 mt-1 bg-white rounded-full border border-gray-300 cursor-pointer hover:text-green-500 duration-300" @click="toggleFilter()" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path></svg>
            </template>
            សម្រង់ទិន្នន័យ
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
        <div class="mt-1 mr-2 flex flex-wrap">
          <n-tooltip v-if="$hasPermission('portal_staff_creating')" trigger="hover">
            <template #trigger>
              <div @click="tableView()" class="flex cursor-pointer hover:text-green-500 duration-300 ml-2 leading-8" >
                <svg class="w-6 h-6 mt-1 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M25 6.75A3.75 3.75 0 0 0 21.25 3H6.75A3.75 3.75 0 0 0 3 6.75v14.5A3.75 3.75 0 0 0 6.75 25h14.5A3.75 3.75 0 0 0 25 21.25V6.75zM4.5 11h5v6h-5v-6zM17 17h-6v-6h6v6zM4.5 18.5h5v5H6.75a2.25 2.25 0 0 1-2.25-2.25V18.5zm12.5 5h-6v-5h6v5zm6.5-2.25a2.25 2.25 0 0 1-2.25 2.25H18.5v-5h5v2.75zm0-10.25v6h-5v-6h5zm-19-4.25A2.25 2.25 0 0 1 6.75 4.5h14.5a2.25 2.25 0 0 1 2.25 2.25V9.5h-19V6.75z" fill="currentColor"></path></g></svg>
                តារាង
              </div>
            </template>
            បង្ហាញជាតារាង
          </n-tooltip>
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
          <!-- 
          <n-tooltip trigger="hover">
            <template #trigger>
              <svg class="mx-1 w-7 h-7 p-1 bg-white rounded-full border border-gray-300 cursor-pointer hover:text-green-500 duration-300" @click="$router.push('/people/export')" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494zM514.1 580.1l-61.8-102.4c-2.2-3.6-6.1-5.8-10.3-5.8h-38.4c-2.3 0-4.5.6-6.4 1.9c-5.6 3.5-7.3 10.9-3.7 16.6l82.3 130.4l-83.4 132.8a12.04 12.04 0 0 0 10.2 18.4h34.5c4.2 0 8-2.2 10.2-5.7L510 664.8l62.3 101.4c2.2 3.6 6.1 5.7 10.2 5.7H620c2.3 0 4.5-.7 6.5-1.9c5.6-3.6 7.2-11 3.6-16.6l-84-130.4l85.3-132.5a12.04 12.04 0 0 0-10.1-18.5h-35.7c-4.2 0-8.1 2.2-10.3 5.8l-61.2 102.3z" fill="currentColor"></path></svg>
            </template>
            នាំចេញទិន្នន័យ
          </n-tooltip> -->
        </div>
      </div>
    </div>
    <!-- Table of crud -->
    <div class="vcb-table-panel relative ">
      <Transition name="fade" >
        <div v-if="Array.isArray( table.records.matched ) && table.records.matched.length > 0 " class="vcb-thumbnail mb-12" >
          <div v-for="(record, index) in table.records.matched" :key='index' class="item" >
            <div class="content" >
              <div v-if="record.image != false && record.image != null && record.image != undefined " class="image bg-cover bg-no-repeat " :style=" 'background-image: url(' + record.image +');' " ></div>
              <div v-if="record.image == false || record.image == null || record.image == undefined " class="image bg-contain bg-center bg-no-repeat " :style=" 'background-image: url('+ocmLogoUrl+');' " ></div>
              <div class="flex flex-wrap " >
                <div class="w-full py-2" >
                  <div v-if="record.countesy != undefined && record.countesy != null " class="w-full officer-countesy text-center font-moul" >{{  record.countesy.name }}</div>
                  <div v-if="record.people != undefined && record.people != null " class="w-full officer-name text-center font-moul tracking-wider pt-1" >{{ record.people.lastname + " " + record.people.firstname }}</div>
                  <div v-if="record.people != undefined && record.people != null " class="w-full officer-name text-center font-moul tracking-wider" >{{ record.people.enlastname + " " + record.people.enfirstname }}</div>
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
                <div v-if="record.card != null && record.card != undefined && record.card.id > 0" class="absolute left-1 top-1 text-vcb-xs text-left font-bold leading-6 tracking-wider" >{{ $toKhmer( record.card.number ) }}</div>
                <!-- <div v-if="(record.card == null || record.card == undefined ) && ( record.organization != undefined && record.organization != null ) " class="absolute left-1 top-1 text-xxs text-left font-bold leading-6 tracking-wider" v-html=" $toKhmer( ( record.organization != undefined && record.organization.prefix != null && record.organization.prefix != '' ? record.organization.prefix + '-'  : '' ) + ( record.id + '' ).padStart( 4 , '0' ) )" ></div> -->
                <div v-if="record.rank != null && record.rank != undefined " class="absolute left-1 top-5 text-vcb-xs text-left font-bold leading-6 tracking-wider text-xxs " v-html=" $toKhmer( record.rank.prefix + ' ' + record.rank.name )" ></div>
                <div v-if=" record.current_job != undefined && record.current_job != null " class="absolute right-10 top-2 w-1 h-1 bg-green-400 rounded-full " ></div>
              </div>
              <thumbnail-actions-form v-bind:model="model" v-bind:record="record" :onClose="closeActions" />
            </div>
          </div>
        </div>
      </Transition>
      <!-- Loading -->
      <Transition name="slide-fade" >
        <div v-if="locationLoading == true || table.loading == true " class="table-loading fixed flex h-screen left-0 top-10 right-0 bottom-0 bg-white bg-opacity-90 ">
          <div class="flex mx-auto items-center">
            <div class="spinner">
              <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
              <br/><br/>កំពុងអាន...
            </div>
          </div>
          <div class="absolute top-2 right-2 cursor-pointer bg-white rounded-full " @click="closeTableLoading" >
            <svg class="w-10 mx-auto text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
          </div>
        </div>
      </Transition>
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
    </div>
    <!-- Form create account -->
    <create-form v-bind:model="model" v-bind:show="createModal.show" :onClose="closeCreateModal"/>
    <create-non-officer-form v-bind:model="model" v-bind:show="createNonOfficerModal.show" :onClose="closeCreateNonOfficerModal"/>
    <!-- Filter panel of crud -->
    <Transition name="slide-fade" >
      <div v-if="filter" class="vcb-filters-panel">
        <svg @click="toggleFilter()" class="absolute bg-white rounded-full shadow p-2 right-2 top-2 w-10 h-10 border border-gray-200 cursor-pointer hover:text-green-500 duration-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path></svg>
        <div class="filter-title font-moul" >សូមជ្រើសរើសលក្ខណ សម្រង់ទិន្នន័យ៖</div>
        <div class="filter-actions" >
          <div class="filter-action" >
            <!-- Positions -->
            <n-select v-model:value="selectedPositions" filterable clearable multiple @update:value="filterRecords(false)" placeholder="សូមជ្រើសរើស មុខតំណែង" :options="optionPositions" />
          </div>
          <div class="filter-action" >
            <!-- Organizations -->
            <n-select v-model:value="selectedOrganizations" filterable clearable multiple @update:value="filterRecords(false)" placeholder="សូមជ្រើសើស ស្ថាប័ន / អង្គភាព" :options="optionOrganizations" />
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>
<script>
import { reactive ,ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import ocmLogoUrl from './../../../assets/logo.svg'
import dateFormat from 'dateformat'
/**
 * CRUD component form
 */
import CreateForm from './../widgets/create.vue'
import CreateNonOfficerForm from './../widgets/createnonofficer.vue'
import ThumbnailActionsForm from './actions/thumbnail-action.vue'
export default {
  name: "People" ,
  components: {
    QrcodeVue ,
    Vue3Barcode,
    /**
     * Forms
     */
    CreateForm ,
    CreateNonOfficerForm ,
    ThumbnailActionsForm
  },
  setup(){
    const store = useStore()
    const route = useRoute()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()
    const router = useRouter()

    const peopleIds = ref( 
      route.params.ids != undefined && route.params.ids.trim().length > 0 ? route.params.ids.split(',') : null
    )

    /**
     * Variables
     */    
    const model = reactive( {
      name: "officer" ,
      module: "officers" ,
      title: "មន្ត្រីរាជការមុខងារសាធារណៈ"
    })
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

    function filterRecords(helper=true){
      if( helper ){
        table.records.matched = []
        if( table.search != "" ) {
          for(var index in table.records.all ){
            for(var field in table.records.all[index] ){
              if( (""+table.records.all[index][field]).includes( table.search ) !== false ) {
                table.records.matched.push( table.records.all[index] )
                break;
              }
            }
          }
        }
        if( table.records.matched.length <= 0 ) {
          table.records.matched = table.records.all
        }
      }else{
        setTimeout( function(){
          table.pagination.page = 1
          getRecords()
        } , 500 )
      }
    }

    /**
     * Functions
     */
    function getRecords(){
      /**
       * Clear time interval after calling
       */
      window.clearTimeout()
      table.loading = true
      store.dispatch(model.name+'/list',{
        search: table.search ,
        perPage: table.pagination.perPage ,
        page: table.pagination.page ,
        positions: selectedPositions.value ,
        organizations: selectedOrganizations.value ,
        ids: peopleIds.value
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
      }).catch( err => {
        console.log( err )
      })
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
      getRecords()
    }
    function updatePerpage(perPage){
      table.pagination.perPage = perPage < 5 ? 5 : ( perPage > 100 ? 100 : perPgae )
      table.pagination.page = 1
      getRecords()
    }

    /**
     * Create modal handling
     */
    var createModal = reactive({show:false})
    function showCreateModal(){
      createModal.show = true
    }

    function closeCreateModal( actionStatus ){
      createModal.show = false
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }

    /**
     * Create non officer modal handling
     */
     var createNonOfficerModal = reactive({show:false})
    function showCreateNonOfficerModal(){
      createNonOfficerModal.show = true
    }

    function closeCreateNonOfficerModal( actionStatus ){
      createNonOfficerModal.show = false
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }

    function closeActions( actionStatus ){
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }
    
    /**
     * Load positions
     */
    const selectedPositions = ref(null)
    const optionPositions = computed( () => {
      let positions = Array.isArray( store.getters['position/getRecords'] ) && store.getters['position/getRecords'].length > 0 ? store.getters['position/getRecords'] : []
      positions = positions.map( ( p ) => { return { label : p.name , value : p.id } })
      positions.unshift({ label: 'សូមជ្រើសរើស មុនតំណែង' , value: null })
      return positions
    })
    function getPositions(){
      store.dispatch('position/structurePosition',{
        page: 1 ,
        perPage: 1000 ,
        search: ''
      }).then(res=>{
        store.commit('position/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានតំណែង' ,
          description: 'មានបញ្ហាពេលអានតំណែង។'
        })
        console.log( err )
      })
    }

    /**
     * Load positions
     */
    const selectedOrganizations = ref(null)
    const optionOrganizations = computed( () => {
      let organizations = Array.isArray( store.getters['organization/getRecords'] ) && store.getters['organization/getRecords'].length > 0 ? store.getters['organization/getRecords'] : []
      organizations = organizations.map( ( p ) => { return { label : p.name , value : p.id } })
      organizations.unshift({ label: 'សូមជ្រើសរើស ស្ថាប័ន / អង្គភាព' , value: null })
      return organizations
    })
    function getOrganizations(){
      store.dispatch('organization/organizationStructure',{
        page: 1 ,
        perPage: 1000 ,
        search: '' ,
        id: 0
      }).then(res=>{
        store.commit('organization/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានអង្គភាព' ,
          description: 'មានបញ្ហាពេលអានអានអង្គភាព។'
        })
        console.log( err )
      })
    }

    /**
     * Load positions
     */
     const selectedCountesies = ref(null)
    const optionCountesies = computed( () => {
      let countesies = Array.isArray( store.getters['countesy/getRecords'] ) && store.getters['countesy/getRecords'].length > 0 ? store.getters['countesy/getRecords'] : []
      countesies = countesies.map( ( p ) => { return { label : p.name , value : p.id } })
      countesies.unshift({ label: 'សូមជ្រើសរើស ងារ' , value: null })
      return countesies
    })
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
    
    const filter = ref(false)    
    function toggleFilter(){
      filter.value = !filter.value
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

    const locationLoading = ref(false)
    function getProvinces(){
      if( store.getters['province/records'].all.length <= 0 ){
        locationLoading.value = true
        store.dispatch( 'province/list' ).then( res => {
          store.commit('province/setAllRecords',res.data.records)
          locationLoading.value = false
        }).catch( err => {
          console.log( err )
        })
      }
    }

    function getPdcv(){
      if( store.getters['province/records'].all.length <= 0 ){
        locationLoading.value = true
        store.dispatch( 'province/pdcv' ).then( res => {
          store.commit('province/setAllRecords',res.data.provinces)
          store.commit('district/setAllRecords',res.data.districts)
          store.commit('commune/setAllRecords',res.data.communes)
          store.commit('village/setAllRecords',res.data.villages)
          locationLoading.value = false
        }).catch( err => {
          console.log( err )
        })
      }
    }

    function tableView(){
      router.push('/hr/officer/table')
    }
    /**
     * Initial the data
     */
    getOrganizations()
    getPositions()
    getRankStructure()
    getCountesies()
    getRecords()
    getPdcv()
        


    return {
      /**
       * Variables
       */
      model ,
      table ,
      ocmLogoUrl ,
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
      /**
       * Creating
       */
      createModal ,
      showCreateModal ,
      closeCreateModal ,
      /**
       * Creating non officer
       */
      createNonOfficerModal ,
      showCreateNonOfficerModal ,
      closeCreateNonOfficerModal ,
      closeActions ,
      /**
       * Functions
       */
      toggleFilter ,
      filterRecords ,
      filter ,
      /**
      * Filters
      */
      optionPositions ,
      selectedPositions ,
      selectedCountesies ,
      optionOrganizations ,
      selectedOrganizations ,
      dateFormat ,
      locationLoading ,
      tableView
    }
  }
}

</script>
<style type="text/css" scoped >
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
  @apply border rounded-full border-gray-200 p-2 w-16 h-16 flex-none mx-auto overflow-hidden bg-white ;
}
.vcb-filters-panel {
  @apply fixed left-40 top-10 right-0 bottom-0 bg-opacity-60 bg-white ;
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