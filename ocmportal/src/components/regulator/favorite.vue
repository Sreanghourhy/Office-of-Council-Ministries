<template>
  <div v-if="$hasPermission('portal_regulator_favorite')"  class="min-h-screen ">
    <div class="absolute left-40 top-12 right-0 bottom-0 " >
      <div class="flex w-full border-b z-50 bg-gray-100 " >
        <div class="flex w-full pl-4 py-2 title " >
          <div class="submenu-icon h-6 flex">
            <svg class="flex-none w-6 mr-2 text-red-600" 
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
            <div class="submenu-icon-title text-xs flex-grow w-full leading-6 font-moul" v-html="model.title" ></div>
          </div>
        </div>
      </div>
      <div class="flex w-full" >
        <div class="flex-grow p-4">
          <!-- Search box -->
          <div class="relative text-left" >
            <input type="text" placeholder="សូមដកឃ្លាដើម្បីបន្ថែមលក្ខណស្វែងរក ..." @keypress.enter="filterRecords(false)" v-model="table.search" class="bg-white pl-4 pr-10 h-10 w-full rounded-full border border-gray-300 transition duration-500 focus:border-blue-600 hover:border-blue-600" />
            <svg class="absolute w-8 right-2 bottom-1 text-gray-400 cursor-pointer" @click="filterRecords(false)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
          </div>
          <!-- Search box -->
          <div class="pt-4 flex justify-center flex-wrap" >
            <div class="filter-control" >
              <n-input v-model:value="fid" type="text" placeholder="លេខចុះ" @update:value="filterRecordsWithKeyPress()" />
            </div>
            <div class="filter-control" >
              <n-date-picker v-model:value="year" @update:value="filterRecords(false)"  placeholder="ថ្ងៃខែឆ្នាំ" type="date" clearable />
            </div>
            <div class="filter-control-select" >
              <n-select
                v-model:value="selectedTypes"
                filterable
                placeholder="ប្រភេទ"
                :options="types"
                multiple
                @update:value="filterRecords(false)" 
              />
            </div>
            <div class="filter-control hidden" >
              <n-select
                v-model:value="selectedOrganizations"
                filterable
                placeholder="ក្រសួងស្ថាប័ន"
                :options="organizations"
                multiple
                @update:value="filterRecords(false)" 
              />
            </div>
            <div class="filter-control hidden" >
              <n-select
                v-model:value="selectedSignatures"
                filterable
                placeholder="ហត្ថលេខា"
                :options="signatures"
                multiple
                @update:value="filterRecords(false)" 
              />
            </div>
            <div class="relative filter-control-button hidden" @click="filterRecords(false)" >
              ស្វែងរក
              <svg class="absolute right-1 h-6 top-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
            </div>
            <div class="relative filter-control-button-clear hidden " @click="clearSearch(false)" >
              សំអាត
              <svg class="absolute right-1 h-6 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>
            </div>
          </div>
        </div>
      </div>
      <!-- End public folder -->
      <Transition name="fade" >
        <div v-if="Array.isArray( table.records.matched ) && table.records.matched.length > 0 " class="flex flex-wrap z-40">
          <div class="vcb-result-message w-full m-4 pb-2 border-b border-gray-100 text-left font-pvh">លទ្ធផលនែការស្វែងរកគឺ ៖ {{ $toKhmer( table.pagination.totalRecords ) }} ឯកសារ {{ table.pagination.totalPages > 0 ? " - " + $toKhmer( table.pagination.totalPages ) + " ទំព័រ" : "" }} </div>
          <!-- Table of crud -->
          <div class="vcb-table-panel flex flex-row w-full">
            <div class="vcb-table w-full " >
              <div v-for="(document, index) in table.records.matched" :key='index' class="vcb-table-row text-left mb-4 border-b border-gray-100 relative" >
                <div class="vcb-table-cell mb-2 leading-6 text-left break-words" v-html=" $toKhmer( ( table.pagination.perPage * ( table.pagination.page - 1 ) ) + index + 1 ) + '. ' + applyTagMark(document.objective)" ></div>
                <div  class="vcb-table-cell " v-html="applyTagMark( ( document.type != undefined && document.type != null && prefixOfTypes[ document.type.id ].length > 0? prefixOfTypes[ document.type.id ] + '/' : '' ) + $toKhmer( applyTagMark( document.fid ) ) + ( ' - ' + $toKhmer(document.year.slice(0,10)) ) ) " ></div>
                <!-- {{ document.createdBy != undefined ? ( ' - ' + document.createdBy.lastname + ' ' + document.createdBy.firstname ) : '' }} -->
                <div class="vcb-table-actions-panel h-5">
                  <svg 
                    v-if="document.pdf"  
                    class="cursor-pointer text-red-500 ml-4 mb-1" 
                    @click="showPdfPreviewModal(document)" 
                    title="មើលឯកសារ" alt="មើលឯកសារ" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M7.503 13.002a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-.5H8.5a1.5 1.5 0 0 0 0-3h-.997zm.997 2h-.497v-1H8.5a.5.5 0 1 1 0 1zm6.498-1.5a.5.5 0 0 1 .5-.5h1.505a.5.5 0 1 1 0 1h-1.006l-.001 1.002h1.007a.5.5 0 0 1 0 1h-1.007l.002.497a.5.5 0 0 1-1 .002l-.003-.998v-.002l.003-2.002zm-3.498-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h.498a2 2 0 0 0 0-4H11.5zm.5 3v-2a1 1 0 0 1 0 2zM20 20v-1.164c.591-.281 1-.884 1-1.582V12.75c0-.698-.409-1.3-1-1.582v-1.34a2 2 0 0 0-.586-1.414l-5.829-5.828a.491.491 0 0 0-.049-.04a.63.63 0 0 1-.036-.03a2.072 2.072 0 0 0-.219-.18a.652.652 0 0 0-.08-.044l-.048-.024l-.05-.029c-.054-.031-.109-.063-.166-.087a1.977 1.977 0 0 0-.624-.138c-.02-.001-.04-.004-.059-.007A.605.605 0 0 0 12.172 2H6a2 2 0 0 0-2 2v7.168c-.591.281-1 .884-1 1.582v4.504c0 .698.409 1.3 1 1.582V20a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-2 .5H6a.5.5 0 0 1-.5-.5v-.996h13V20a.5.5 0 0 1-.5.5zm.5-10.5v1h-13V4a.5.5 0 0 1 .5-.5h6V8a2 2 0 0 0 2 2h4.5zm-1.122-1.5H14a.5.5 0 0 1-.5-.5V4.621L17.378 8.5zm-12.628 4h14.5a.25.25 0 0 1 .25.25v4.504a.25.25 0 0 1-.25.25H4.75a.25.25 0 0 1-.25-.25V12.75a.25.25 0 0 1 .25-.25z" fill="currentColor"></path></g></svg>
                  <svg 
                    class="cursor-pointer text-blue-700 mx-1 mb-1" 
                    @click="showFolderModalPopup(document)"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M7.167 3c.27 0 .535.073.765.21l.135.09l1.6 1.2H15.5a2.5 2.5 0 0 1 2.479 2.174l.016.162L18 7v7.5a2.5 2.5 0 0 1-2.336 2.495L15.5 17h-11a2.5 2.5 0 0 1-2.495-2.336L2 14.5v-9a2.5 2.5 0 0 1 2.336-2.495L4.5 3h2.667zm.99 4.034a1.5 1.5 0 0 1-.933.458l-.153.008L3 7.499V14.5a1.5 1.5 0 0 0 1.356 1.493L4.5 16h11a1.5 1.5 0 0 0 1.493-1.355L17 14.5V7a1.5 1.5 0 0 0-1.355-1.493L15.5 5.5H9.617l-1.46 1.534zM7.168 4H4.5a1.5 1.5 0 0 0-1.493 1.356L3 5.5v.999l4.071.001a.5.5 0 0 0 .302-.101l.06-.054L8.694 5.02L7.467 4.1a.5.5 0 0 0-.22-.093L7.167 4z" fill="currentColor"></path></g></svg>
                </div>
              </div>
            </div>
          </div>
          <!-- Loading -->
          <Transition name="slide-fade" >
            <div v-if="table.loading" class="table-loading fixed flex h-screen left-0 top-10 right-0 bottom-0 bg-white bg-opacity-90 ">
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
      </Transition>
    </div>
    <float-top-menu title="ឯកសារចំណូលចិត្ត" />
    <sidebar />
    <!-- Folder modal selection -->
    <n-modal v-model:show="showFolderModal" @on-after-leave="showFolderModal.value=false" >
      <n-card
        style="width: 600px"
        title="សូមជ្រើសរើសថតឯកសារ"
        :bordered="false"
        size="huge"
        role="dialog"
        aria-modal="true"
      >
        <!-- <template #header-extra>
          Oops!
        </template> -->
        <!-- Where the available folder of the user -->
        <div v-for="(folder, index) in listFolders" :key="index" class="p-2 cursor-pointer hover:bg-gray-100 rounded duration-500 flex" 
          @click=" !folder.exists ? addDocumentToFolder(folder) : removeDocumentFromFolder(folder) "
        >
          <div class="flex-grow">
            {{ (index +1 ) + '. ' + folder.name }}
          </div>
          <svg 
            v-if="!folder.exists"
            class="text-gray-600 flex-none w-6 h-6"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M13.854 7.854a.5.5 0 0 0-.708-.708L8.5 11.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l5-5zM5.682 3A2.682 2.682 0 0 0 3 5.682v8.636C3 15.8 4.2 17 5.682 17h8.636C15.8 17 17 15.8 17 14.318V5.682C17 4.2 15.8 3 14.318 3H5.682zM4 5.682C4 4.753 4.753 4 5.682 4h8.636C15.247 4 16 4.753 16 5.682v8.636c0 .929-.753 1.682-1.682 1.682H5.682A1.682 1.682 0 0 1 4 14.318V5.682z" fill="currentColor"></path></g></svg>
          <svg
            v-if="folder.exists" class="text-green-600 flex-none  w-6 h-6"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M13.854 7.854a.5.5 0 0 0-.708-.708L8.5 11.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l5-5zM5.682 3A2.682 2.682 0 0 0 3 5.682v8.636C3 15.8 4.2 17 5.682 17h8.636C15.8 17 17 15.8 17 14.318V5.682C17 4.2 15.8 3 14.318 3H5.682zM4 5.682C4 4.753 4.753 4 5.682 4h8.636C15.247 4 16 4.753 16 5.682v8.636c0 .929-.753 1.682-1.682 1.682H5.682A1.682 1.682 0 0 1 4 14.318V5.682z" fill="currentColor"></path></g></svg>
        </div>
        <!-- <template #footer>
          Footer
        </template> -->
      </n-card>
    </n-modal>
    <!-- End folder modal selection -->
    <!-- PDF Dialog -->
    <pdf-preview-form v-bind:model="model" v-bind:record="pdfPreviewRecord" v-bind:show="pdfPreviewModal.show" :onClose="closePdfPreviewModal"/>
  </div>
</template>
<script>
import { isAuth, getUser , authLogout } from '@plugins/authentication'
import { ref, computed, reactive, watch } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { useDialog, useNotification, useMessage } from 'naive-ui'
import VuePdfEmbed from 'vue-pdf-embed'
import dateFormat from 'dateformat'
import ocmLogoUrl from '@assets/logo.svg'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import Footer from '@components/footer/copy-right.vue'
import PdfPreviewForm from '@components/widgets/pdfpreview.vue'

export default {
  name: 'WelcomeTemplate' ,
  components: {
    VuePdfEmbed ,
    FloatTopMenu ,
    Sidebar ,
    Footer ,
    PdfPreviewForm
  },
  setup(){
    /**
     * Components to use
     */
    const store = useStore()
    const message = useMessage()
    const router = useRouter()
    const notify = useNotification()
    const dialog = useDialog()
    const subMenuHelper = ref(false)
    const showFolderModal = ref(false)
    const listFolders = ref([])
    const selectedRegulatorId = ref(0)
    const year = ref(null)
    const fid = ref(null)

    if( getUser() == undefined && getUser() == null ){
      router.push('/')  
    }

    /**
     * Data
     */

    const profilePicture = computed(() => {
      let user = getUser()
      return user !== null && user.avatar_url !== null ? user.avatar_url : null 
    })

    /**
     * Variables
     */    
    const model = reactive( {
      name: "regulatorSearch" ,
      title: "ស្វែងរក លិខិតបទដ្ឋានគតិយុត្ត"
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
    const filterPanel = ref(false)
    /**
     * Login function
     */
    const filterRecordsWithKeyPressHelper = ref(null)
    function filterRecordsWithKeyPress(){
      clearTimeout( filterRecordsWithKeyPressHelper.value )
      filterRecordsWithKeyPressHelper.value = setTimeout( function(){
        goTo(1)
      },500)
    }

    const filterRecordsDelayHelper = ref(null)
    function filterRecords(helper=true){
      clearTimeout( filterRecordsDelayHelper.value )
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
        filterRecordsDelayHelper.value = setTimeout( goTo(1) , 500 )
      }
    }

    function clearSearch(){
      fid.value = '' 
      year.value = null 
      selectedTypes.value = [] 
      selectedOrganizations.value = []
      selectedSignatures.value = []
      filterRecords(false)
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
      store.dispatch(model.name+'/favorites',{
        search: table.search ,
        perPage: table.pagination.perPage ,
        page: table.pagination.page ,
        fid : fid.value ,
        year : year.value > 0 ? dateFormat(year.value,'yyyy-mm-dd') : null ,
        types : selectedTypes.value ,
        organizations : selectedOrganizations.value ,
        signatures : selectedSignatures.value
      }).then(res => {
        table.records.all = table.records.matched = res.data.records
        table.pagination = res.data.pagination

        var paginationNumberList = 5
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
          table.pagination.buttons.push(i)
        }

        closeTableLoading()
      }).catch( err => {
        notify.warning({
          title : "កំហុសលេខ ៖ " + err.response.status ,
          content: err.response.data.message
          // content: "ការប្រើប្រាស់មានចំនួនច្រើន សូមរងចាំ បន្តិច ។"
        })
        console.log( err )
        table.loading = false
      })
    }
    function closeTableLoading(){
      table.loading = false
    }

    /**
     * Pagination functions
     */
    // function previous(){
    //   goTo( table.pagination.page <= 1 ? 1 : table.pagination.page - 1 )
    // }
    // function next(){
    //   goTo( table.pagination.page >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + 1 )
    // }
    // function goTo(page){
    //   table.pagination.page = page > table.pagination.totalPages ? table.pagination.totalPages : ( page < 1 ? 1 : page)
    //   getRecords()
    // }
    // function updatePerpage(perPage){
    //   table.pagination.perPage = perPage < 5 ? 5 : ( perPage > 100 ? 100 : perPgae )
    //   table.pagination.page = 1
    //   getRecords()
    // }

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

    const paginationButtons = computed(()=>{
      /**
       * 9 Buttons is recommended
       */
      return table.pagination.totalPages ? table.pagination.totalPages : 0
    })

    function applyTagMark(str){
      // Split the string by whitespace
      if( table.search.trim() != "" ){
        var arrStrSearch = table.search.split(/(\s+)/).filter( e => e.trim().length > 0).map( e => e.replaceAll(" ","") )
        for( var i in arrStrSearch ){
          if( str.includes( arrStrSearch[i] ) ) str = str.replaceAll( arrStrSearch[i] , '<mark>' + arrStrSearch[i] + '</mark>' ) 
        }
      }
      return str
    }

    /**
     * Check the authentication of the user
     */
    const isLoggedIn = computed(()=>{
      return isAuth()
    })

    function logout(){
      if( isAuth() ){
        dialog.warning({
          title : 'ចាកចេញ' ,
          content: () => 'តើអ្នកចង់ចាកចេញពីប្រព័ន្ធមែនទេ?' ,
          positiveText: 'បាទ / ចាស',
          negativeText: 'ទេ',
          onPositiveClick: () => {
            authLogout()
            router.push('/login')
          },
          onNegativeClick: () => {}
        })
      }
    }

    const selectedTypes = ref([])
    const types = computed(()=>{
      return store.getters['regulatorType/getRecords'].map( 
        type => (
          // { label: type.id + ". " + type.name , value : type.id }
          { label: type.name , value : type.id }
        )
      )
    })
    const selectedOrganizations = ref([])
    const organizations = computed(()=>{
      return store.getters['regulatorOrganization/getRecords'].map( 
        organization => (
          // { label: organization.id + ". " + organization.name , value : organization.id }
          { label: organization.name , value : organization.id }
        )
      )
    })
    const selectedSignatures = ref([])
    const signatures = computed(()=>{
      return store.getters['regulatorSignature/getRecords'].map( 
        signature => (
          // { label: signature.id + ". " + signature.name , value : signature.id }
          { label: signature.name , value : signature.id }
        )
      )
    })

    /**
     * Load pivot data of this model
     */
    function getTypes(){
      store.dispatch('regulatorType/list').then(res=>{
        store.commit('regulatorType/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានប្រភេទឯកសារ' ,
          description: 'មានបញ្ហាក្នុងពេលអានប្រភេទឯកសារ។'
        })
        console.log( err )
      })
    }
    function getSignatures(){
      store.dispatch('regulatorSignature/list').then(res=>{
        store.commit('regulatorSignature/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានហត្ថលេខា' ,
          description: 'មានបញ្ហាក្នុងពេលអានហត្ថលេខា។'
        })
        console.log( err )
      })
    }
    /**
     * Load pivot data of this model
     */
     function getOrganizations(){
      store.dispatch('regulatorOrganization/list',{
        perPage: 1000 ,
        page: 1 ,
        search : ''
      }).then(res=>{
        store.commit('regulatorOrganization/setRecords',res.data.records)
      }).catch(err =>{
        notify.error({
          title: 'អានអង្គភាពនៃឯកសាររួចរាល់' ,
          description: 'មានបញ្ហាក្នុងពេលអានអង្គភាពរបស់ឯកសារ។'
        })
        console.log( err )
      })
    }

    const prefixOfTypes = ref([
      'មិនមាន' ,
      'នស/រកម' ,
      'នស/រកត' ,
      'អនក្រ/បក' ,
      'ស.ជ.ណ' ,
      'សសរ' ,
      'សរ,សរណន' ,
      'ប្រ.ក' ,
      'គនបជ' ,
      'ផយស' ,
      'បប' ,
      'ផសក្រ' ,
      'អនក្រ.តត' ,
      'នស/រកត'
    ])

    /**
     * Functions of VuePdfEmbed
     */
    function askForPassword(helper){
      console.log( helper )
    }

    function failedLoadPdf(obj){
      notify.info( "Failed load pdf" )
      console.log( obj )
    }
    function pdfIsLoading(obj){
      notify.info( "loading pdf" )
      console.log( obj )
    }
    function pdfIsLoaded(obj){
      notify.info( "Loaded pdf" )
      console.log( obj )
    }
    function failedRenderPdf(obj){
      notify.info( "Failed redner pdf" )
      console.log( obj )
    }

    function getFolders(){
      store.dispatch('folder/listRegulatorWithValidation',{
        search: '' ,
        page: 1 ,
        perPage: 50 ,
        regulator_id : selectedRegulatorId.value
      }).then( res => {
        listFolders.value = res.data.records
      }).catch( err => {
        console.log( err.response )
      })
    }

    function showFolderModalPopup(regulator){
      showFolderModal.value = true
      /**
       * Mark the selected regulator
       */
      selectedRegulatorId.value = regulator.id
      getFolders()
    }

    function closeFolderModalPopup(){
      showFolderModal.value = false
      listFolders.value = []
      selectedRegulatorId.value = 0
    }

    function addDocumentToFolder(folder){
      store.dispatch('folder/addRegulator',{
        id: folder.id ,
        regulator_id : selectedRegulatorId.value
      }).then( res => {
        notify.success({
          title: "ដាក់ឯកសារចូលថត" ,
          content: res.data.message ,
          duration: 3000
        })
        showFolderModal.value = false
        getFolders()
      }).catch( err => {
        console.log( err.response.data )
        notify.error({
          title: "ដាក់ឯកសារចូលថត" ,
          content: res.response.data.message ,
          duration: 3000
        })
      })
    }

    function removeDocumentFromFolder(folder){
      store.dispatch('folder/removeRegulator',{
        id: folder.id ,
        regulator_id : selectedRegulatorId.value
      }).then( res => {
        notify.success({
          title: "ដកឯកសារចេញពីថត" ,
          content: res.data.message ,
          duration: 3000
        })
        showFolderModal.value = false
        getFolders( )
      }).catch( err => {
        console.log( err.response.data )
        notify.error({
          title: "ដកឯកសារចេញពីថត" ,
          content: res.response.data.message ,
          duration: 3000
        })
      })
    }

    /**
     * Pdf Preview Modal
     */
    var pdfPreviewModal = reactive({show:false})
    var pdfPreviewRecord = reactive({
      id: 0 ,
      fid: "" ,
      title: "" ,
      objective: "" ,
      type_id: null ,
      year: null ,
      pdfs: [] ,
      publish: 0 ,
      active: 0 ,
      accessibility: 0 ,
      types: [] ,
      orgainzations: [] ,
      ownOrgainzations: [] ,
      relatedOrgainzations: [] ,
      signatures: []
    })

    function showPdfPreviewModal(record){
      pdfPreviewRecord.id = record.id
      pdfPreviewRecord.fid = record.fid
      pdfPreviewRecord.title = record.title
      pdfPreviewRecord.objective = record.objective
      pdfPreviewRecord.type_id = record.type
      pdfPreviewRecord.year = new Date( record.year ).getTime()
      pdfPreviewRecord.publish = record.publish
      pdfPreviewRecord.pdf = record.pdf
      pdfPreviewRecord.active = record.active
      pdfPreviewRecord.accessibility = record.accessibility
      pdfPreviewRecord.types = record.types
      pdfPreviewRecord.organizations = record.organizations
      pdfPreviewRecord.ownOrganizations = record.ownOrganizations
      pdfPreviewRecord.relatedOrganizations = record.relatedOrganizations
      pdfPreviewRecord.signatures = record.signatures
      pdfPreviewModal.show = true
    }
    function closePdfPreviewModal(record){
      pdfPreviewModal.show = false
      closeActions( 0 )
    }
    
    /**
     * Start fetching records
     */
    getRecords()
    getTypes()
    getSignatures()
    getOrganizations()

    return {
      /**
       * Variables
       */
      model ,
      table ,
      filterPanel ,
      subMenuHelper ,
      prefixOfTypes ,
      /**
       * Table
       */
      filterRecords ,
      failedLoadPdf ,
      pdfIsLoading ,
      pdfIsLoaded ,
      failedRenderPdf ,
      /**
       * Pagination functions
       */
      updatePerpage ,
      goTo ,
      previous ,
      next ,
      paginationButtons ,
      isLoggedIn ,
      first , 
      last  ,
      /**
       * Loading overlay
       */
      closeTableLoading ,
      /**
       * Functions
       */
      logout ,
      applyTagMark ,
      clearSearch ,
      filterRecordsWithKeyPress ,
      /**
       * Components
       */
      /**
       * Show share modal
       */
      profilePicture ,
      /**
       * Public folder
       */
      selectedTypes ,
      types ,
      selectedOrganizations ,
      organizations ,
      selectedSignatures ,
      signatures ,
      year ,
      fid ,
      askForPassword ,
      ocmLogoUrl ,
      /**
       * Folder
       */
       showFolderModalPopup ,
       closeFolderModalPopup ,
       addDocumentToFolder ,
       removeDocumentFromFolder ,
       showFolderModal ,
       listFolders ,
       /**
        * Show PDF
        */
      pdfPreviewModal ,
      pdfPreviewRecord ,
      showPdfPreviewModal ,
      closePdfPreviewModal
    }
  },
  mounted(){
  }
}
</script>
<style scoped>
  .shareDocumentPdf {
    @apply text-red-500 m-8 w-48 h-48 p-8 cursor-pointer shadow border border-gray-100 rounded hover:border-gray-300 duration-300 ;
  }
  .filter-control {
    @apply w-40 m-1;
  }
  .filter-control-select {
    @apply w-40 min-w-max m-1;
  }
  .filter-control-button {
    @apply w-28 h-8 m-1 pl-2 cursor-pointer hover:border-green-600 text-green-600 duration-300 border border-green-300 text-left rounded leading-8 bg-white font-bold;
  }
  .filter-control-button-clear {
    @apply w-28 h-8 m-1 pl-2 cursor-pointer hover:border-red-600 text-red-600 duration-300 border border-red-300 text-left rounded leading-8 bg-white font-bold;
  }
  .vcb-pagination-page {
    @apply text-center align-middle leading-8 font-bold cursor-pointer;
  }
  .vcb-table {
    @apply mb-0;
  }
  .vcb-table-pagination {
    @apply p-2 h-12;
  }
  .vcb-table-pagination-info {
    @apply leading-7; 
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
