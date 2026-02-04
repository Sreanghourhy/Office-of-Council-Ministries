<template>
  <div class="w-full" >
    <!-- Title of crud -->
    <div class="flex w-full h-10 py-1 pl-4 title  border-b bg-gray-100" >
      <!-- <svg class="text-red-500 mr-2 w-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
      <div class="leading-6 font-moul" v-html="model.title + ' ' + 'នៃថតឯកសារ' " ></div> -->
      <div class="submenu-icon h-8 flex w-1/2">
        <svg class="flex-none mr-2 text-yellow-600" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M7.167 3c.27 0 .535.073.765.21l.135.09l1.6 1.2H15.5a2.5 2.5 0 0 1 2.479 2.174l.016.162L18 7v7.5a2.5 2.5 0 0 1-2.336 2.495L15.5 17h-11a2.5 2.5 0 0 1-2.495-2.336L2 14.5v-9a2.5 2.5 0 0 1 2.336-2.495L4.5 3h2.667zm.99 4.034a1.5 1.5 0 0 1-.933.458l-.153.008L3 7.499V14.5a1.5 1.5 0 0 0 1.356 1.493L4.5 16h11a1.5 1.5 0 0 0 1.493-1.355L17 14.5V7a1.5 1.5 0 0 0-1.355-1.493L15.5 5.5H9.617l-1.46 1.534zM7.168 4H4.5a1.5 1.5 0 0 0-1.493 1.356L3 5.5v.999l4.071.001a.5.5 0 0 0 .302-.101l.06-.054L8.694 5.02L7.467 4.1a.5.5 0 0 0-.22-.093L7.167 4z" fill="currentColor"></path></g></svg>
        <div class="submenu-icon-title text-xs flex-grow  text-left leading-9 font-moul" v-html="model.title + ' ' + 'នៃថតឯកសារ' " ></div>
      </div>
      <div class="flex justify-end h-6 w-1/2" >
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="flex-grow relative flex justify-end" >
              <input type="text" 
                class="bg-gray-100 px-2 h-8 text-xs w-full rounded border border-gray-200 duration-300 focus:border-blue-600 hover:border-blue-600 "
                @keypress.enter="filterRecords(false)" v-model="table.search" 
                placeholder="ស្វែងរក"
                />
                <svg class="absolute w-8 right-1 top-0 text-gray-400 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
            </div>
          </template>
          ប្រអប់ស្វែងរកថតឯកសារ
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <svg 
              class="flex-none w-8 mr-2 h-8 ml-2 text-blue-500 cursor-pointer"
              @click="$router.push('/folder')"
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M7.167 3c.27 0 .535.073.765.21l.135.09l1.6 1.2H15.5a2.5 2.5 0 0 1 2.479 2.174l.016.162L18 7v7.5a2.5 2.5 0 0 1-2.336 2.495L15.5 17h-11a2.5 2.5 0 0 1-2.495-2.336L2 14.5v-9a2.5 2.5 0 0 1 2.336-2.495L4.5 3h2.667zm.99 4.034a1.5 1.5 0 0 1-.933.458l-.153.008L3 7.499V14.5a1.5 1.5 0 0 0 1.356 1.493L4.5 16h11a1.5 1.5 0 0 0 1.493-1.355L17 14.5V7a1.5 1.5 0 0 0-1.355-1.493L15.5 5.5H9.617l-1.46 1.534zM7.168 4H4.5a1.5 1.5 0 0 0-1.493 1.356L3 5.5v.999l4.071.001a.5.5 0 0 0 .302-.101l.06-.054L8.694 5.02L7.467 4.1a.5.5 0 0 0-.22-.093L7.167 4z" fill="currentColor"></path></g></svg>
          </template>
          ថតឯកសារ
        </n-tooltip>
      </div>
    </div>
    <!-- Table of crud -->
    <div class="vcb-table-panel">
      <Transition name="fade" >
        <div v-if="table.records.matched.length > 0" class="vcb-table w-full " >
          <div class="vcb-result-message w-full pb-2 border-b border-gray-100 text-left font-pvh mb-4">លទ្ធផលនែការស្វែងរកគឺ ៖ {{ $toKhmer( table.pagination.totalRecords ) }} ឯកសារ {{ table.pagination.totalPages > 0 ? " - " + $toKhmer( table.pagination.totalPages ) + " ទំព័រ" : "" }} </div>
          <div v-for="(document, index) in table.records.matched" :key='index' class="vcb-table-row border-b text-left relative mb-8" >
            <div class="vcb-table-cell text-md mb-2 leading-7 text-left break-words " v-html=" $toKhmer( index + 1 ) + '. ' + applyTagMark(document.objective)" ></div>
            <div  class="vcb-table-cell text-xs mb-2" >
              {{ document.type != undefined ? document.type.name : '' }} {{ '/' + $toKhmer( document.fid ) }} {{ ' - ' + $toKhmer( document.year.slice(0,10) ) }} 
              <!-- {{ document.createdBy != undefined ? ( ' - ' + document.createdBy.lastname + ' ' + document.createdBy.firstname ) : '' }} -->
            </div>
            <!-- Document Actions -->
            <div class="record-actions-panel flex flex-wrap mb-2 flex-row-reverse absolute right-0 bottom-0" >
                <n-tooltip trigger="hover">
                  <template #trigger>
                    <svg class="cursor-pointer text-red-500 mr-4 w-5 " @click="removeDocumentFromFolder(document)" title="ដកឯកសារចេញពីថត"
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>
                  </template>
                  ដកចេញពីថតឯកសារនេះ
                </n-tooltip>
                <n-tooltip v-if="document.pdf"  trigger="hover">
                  <template #trigger>
                    <svg class="cursor-pointer text-red-500 mr-4 w-5" @click="showPdfPreviewModal(document)"
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
                  </template>
                  មើលឯកសារយោង
                </n-tooltip>
              </div>
          </div>
        </div>
      </Transition>
      <Transition name="slide-fade" >
        <div v-if=" table.pagination.totalPages <= 0" class="vcb-table w-full p-16" >មិនមានព័ត៌មាននោះឡើយ។</div>
      </Transition>
      <!-- Loading -->
      <Transition name="slide-fade" >
        <div v-if="table.loading" class="table-loading fixed flex h-screen left-0 top-10 right-0 bottom-0 bg-white bg-opacity-80 ">
          <div class="flex mx-auto items-center">
            <div class="spinner">
              <svg class="animate-spin w-16 mx-auto text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48s21.49-48 48-48s48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48s48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48s48-21.49 48-48s-21.491-48-48-48z" fill="currentColor"></path></svg>
              <br/><br/>កំពុងអាន...
            </div>
          </div>
          <div class="absolute top-1 right-1 cursor-pointer bg-white rounded-full " @click="closeTableLoading" >
            <svg class="w-14 mx-auto text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
          </div>
        </div>
      </Transition>
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
    <!-- Filter panel of crud -->
    <div v-if="filterPanel" class="vcb-filter-panel h-64">
      <div class="filter-container relative w-full flex">
        <svg 
          class="absolute right-0 top-0 cursor-pointer text-red-700"
          @click="filterPanel=!filterPanel"
          xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192s192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 320L192 192"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 320l128-128"></path></svg>
      </div>
    </div>
    <!-- PDF Dialog -->
    <pdf-preview-form v-bind:model="model" v-bind:record="pdfPreviewRecord" v-bind:show="pdfPreviewModal.show" :onClose="closePdfPreviewModal"/>
  </div>
</template>
<script>
import { reactive, computed, ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import VuePdfEmbed from 'vue-pdf-embed'
import { useDialog, useMessage, useNotification } from 'naive-ui'
/**
 * CRUD component form
 */
import CreateForm from './create.vue'
import UpdateForm from './update.vue'
import AddRemoveReaderForm from './actions/addremovereader.vue'
import AccessibilityForm from './actions/accessibility.vue'
import PdfPreviewForm from '@components/widgets/pdfpreview.vue'
export default {
  name: "Regulator" ,
  components: {
    QrcodeVue ,
    Vue3Barcode,
    CreateForm,
    UpdateForm,
    VuePdfEmbed ,
    AddRemoveReaderForm ,
    AccessibilityForm ,
    PdfPreviewForm
  },
  setup(){
    const store = useStore()
    const route = useRoute()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()
    const showFolderModal = ref(false)
    const listFolders = ref([])
    const selectedDocumentId = ref(0)
    /**
     * Variables
     */    
    const model = reactive( {
      name: "regulator" ,
      title: "ឯកសារ"
    })

    const regulatorAccessibilities = ref([
      "បិទទាំងស្រុង" , // 0 
      "ខ្លួនឯង និង អ្នកដែលចែករំលែកទៅ" , // 1 
      "ទូទាំងប្រព័ន្ធ" , // 2 
      "" , // 3 
      "ជាសកល" , // 4 
    ])

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
        setTimeout( goTo(1) , 500 )
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
      store.dispatch("folder/regulators",{
        id: route.params.id ,
        search: table.search ,
        perPage: table.pagination.perPage ,
        page: table.pagination.page
      }).then(res => {
        console.log( res )
        if( res.data.ok ){
          table.records.all = table.records.matched = res.data.records
          table.pagination = res.data.pagination

          var paginationNumberList = 5
          if( ( table.pagination.page - ( paginationNumberList - 1 ) ) < 1 ){
            table.pagination.start = 1
            table.pagination.end = table.pagination.totalPages > 9 ? 9 : table.pagination.totalPages
          }
          else{
            table.pagination.start = table.pagination.page  - ( paginationNumberList - 1 )
            table.pagination.end = table.pagination.page + 4 >= table.pagination.totalPages ? table.pagination.totalPages : table.pagination.page + 4
          }
          /**
           * Create pagination buttons
           */
          table.pagination.buttons = []
          for(var i=table.pagination.start;i<=table.pagination.end;i++){
            table.pagination.buttons.push(i)
          }
        }else{
          table.records.all = table.records.matched = []
          notify.warning({
            title: 'អានឯកសារ' ,
            description: res.data.message ,
            duration: 3000
          })
        }
        closeTableLoading()
      }).catch( err => {
        table.records.all = table.records.matched = []
        notify.warning({
            title: 'អានឯកសារ' ,
            description: err.response.data.message ,
            duration: 3000
          })
          closeTableLoading()
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


    const paginationButtons = computed(()=>{
      /**
       * 9 Buttons is recommended
       */
      return table.pagination.totalPages ? table.pagination.totalPages : 0
    })

    function activateRegulator(record){
      dialog.warning({
        title: "បិទ ឬ បើក ឯកសារ" ,
        content: "តើអ្នកចង់ " + ( record.active == 1 ? "បិទ" : "បើក" )+ " ឯកសារនេះមែនទេ ?" ,
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          store.dispatch( model.name+(parseInt(record.active)==1?'/deactivate':'/activate'),{id:record.id}).then( res => {
            if( res.data.ok ){
              notify.success({
                title: 'ស្ថានភាពឯកសារ' ,
                description: 'ស្ថានភាពឯកសារបានកែប្រែជោគជ័យ។' ,
                duration: 3000
              })
              getRecords()
            }else{
              notify.error({
                title: 'ស្ថានភាពគណនី' ,
                description: 'មានបញ្ហាក្នុងពេលកែប្រែស្ថានភាពឯកសារ។' ,
                duration: 3000
              })
            }
          }).catch( err => {
            message.error( err )
          })
        },
        onNegativeClick: () => {
          
        }
      })
    }
    /**
     * Create modal handling
     */
    var createModal = reactive({show:false})
    function showCreateModal(){
      createModal.show = true
    }

    function closeCreateModal(){
      createModal.show = false
      getRecords()
    }

    var editModal = reactive({show:false})
    var editRecord = reactive({
      id: 0 ,
      number: "" ,
      title: "" ,
      objective: "" ,
      type_id: null ,
      year: null ,
      pdfs: [] ,
      publish: 0 ,
      active: 0 
    })
    function showEditModal(record){
      editRecord.id = record.id
      editRecord.number = record.fid
      editRecord.title = record.title
      editRecord.objective = record.objective
      editRecord.type_id = record.document_type
      editRecord.year = new Date( record.year ).getTime()
      editRecord.publish = record.publish
      editRecord.active = record.active
      // editRecord.pdfs = record.pdf
      editModal.show = true
    }
    function closeEditModal(record){
      editModal.show = false
      getRecords()
    }

    /**
     * Action Modal
     */
    var regulatorModal = reactive({show:false})
    var regulatorRecord = reactive({
      id: 0 ,
      number: "" ,
      title: "" ,
      objective: "" ,
      type_id: null ,
      year: null ,
      pdfs: [] ,
      publish: 0 ,
      active: 0 ,
      accessibility: 0
    })
    function showShareRegulatorModal(record){
      regulatorRecord.id = record.id
      regulatorRecord.number = record.fid
      regulatorRecord.title = record.title
      regulatorRecord.objective = record.objective
      regulatorRecord.type_id = record.document_type
      regulatorRecord.year = new Date( record.year ).getTime()
      regulatorRecord.publish = record.publish
      regulatorRecord.active = record.active
      regulatorRecord.accessibility = record.accessibility
      // actionRecord.pdfs = record.pdf
      regulatorModal.show = true
    }
    function closeShareRegulatorModal(record){
      regulatorModal.show = false
      getRecords()
    }

    /**
     * Accessibility Modal
     */
    var accessibilityModal = reactive({show:false})
    var accessibilityRecord = reactive({
      id: 0 ,
      number: "" ,
      title: "" ,
      objective: "" ,
      type_id: null ,
      year: null ,
      pdfs: [] ,
      publish: 0 ,
      active: 0 ,
      accessibility : 0
    })
    function showAccessibilityModal(record){
      accessibilityRecord.id = record.id
      accessibilityRecord.number = record.fid
      accessibilityRecord.title = record.title
      accessibilityRecord.objective = record.objective
      accessibilityRecord.type_id = record.document_type
      accessibilityRecord.year = new Date( record.year ).getTime()
      accessibilityRecord.publish = record.publish
      accessibilityRecord.active = record.active
      accessibilityRecord.accessibility = record.accessibility
      // actionRecord.pdfs = record.pdf
      accessibilityModal.show = true
    }
    function closeAccessibilityModal(record){
      accessibilityModal.show = false
      getRecords()
    }

    function destroy(record){
      dialog.warning({
        title: "លុបឯកសារ" ,
        content: "តើអ្នកចង់ លុប ឯកសារនេះមែនទេ ?" ,
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          store.dispatch(model.name+'/delete',{id:record.id}).then( res => {
            if( res.data.ok ){
              notify.success({
                title: 'លុបឯកសារ' ,
                description: 'លុបបានរួចរាល់។' ,
                duration: 3000
              })
              getRecords()
            }else{
              notify.success({
                title: 'លុបឯកសារ' ,
                description: 'មានបញ្ហាក្នុងពេលលុបឯកសារ។' ,
                duration: 3000
              })
            }
        }).catch( err => {
          message.error( err )
        })
        },
        onNegativeClick: () => {
        }
      })
    }

    /**
     * Load pivot data of this model
     */
    function getDocumentTypes(){
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

    /**
     * Mark the matched text with in search box
     */
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

    function addDocumentToFolder(folder){
      store.dispatch('folder/addRegulator',{
        id: folder.id ,
        document_id : selectedDocumentId.value
      }).then( res => {
        notify.success({
          title: "ដាក់ឯកសារចូលថត" ,
          content: res.data.message ,
          duration: 3000
        })
        
      }).catch( err => {
        console.log( err.response.data )
        notify.error({
          title: "ដាក់ឯកសារចូលថត" ,
          content: res.response.data.message ,
          duration: 3000
        })
      })
    }

    function removeDocumentFromFolder(document){
      dialog.warning({
        title: "ដកឯកសារ" ,
        content: "តើអ្នកចង់ ដកឯកសារនេះចេញមែនទេ?" ,
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          store.dispatch('folder/removeRegulator',{
            id: route.params.id ,
            regulator_id : document.id
          }).then( res => {
            notify.success({
              title: "ដកឯកសារចេញពីថត" ,
              content: res.data.message ,
              duration: 3000
            })
            getRecords()
          }).catch( err => {
            console.log( err.response.data )
            notify.error({
              title: "ដកឯកសារចេញពីថត" ,
              content: res.response.data.message ,
              duration: 3000
            })
          })
        },
        onNegativeClick: () => {
        }
      })
    }

    /**
     * Initial the data
     */
    getRecords()
    getDocumentTypes()


    return {
      /**
       * Variables
       */
      model ,
      table ,
      filterPanel ,
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
      last , 
      first ,
      paginationButtons ,
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
       * Editing
       */
      editModal ,
      showEditModal ,
      closeEditModal , 
      editRecord ,
      /**
       * Actions
       */
      showShareRegulatorModal ,
      closeShareRegulatorModal , 
      /**
       * Functions
       */
      activateRegulator ,
      destroy ,
      applyTagMark ,
      /**
       * Actions
       */
      regulatorModal ,
      showShareRegulatorModal ,
      closeShareRegulatorModal , 
      regulatorRecord ,
      /**
       * Accessibility
       */
      accessibilityModal ,
      showAccessibilityModal ,
      closeAccessibilityModal ,
      accessibilityRecord ,
      /**
       * Folder
       */
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