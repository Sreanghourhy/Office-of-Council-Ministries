<template>
  <div class="relative w-full" >
    <!-- Table of crud -->
    <div class="absolute left-0 top-12 right-0 bottom-12 vcb-table-panel">
      <!-- <div class="vcb-meeting-timestamp flex flex-wrap justify-center items-center w-full mb-8 bg-white border border-gray-200 p-2" > -->
        <!-- <div class="p-1 px-4 rounded shadow-sm m-1 cursor-pointer duration-300 hover:border-yellow-300 hover:text-yellow-800 border border-gray-200" >១ ខែមុន</div>
        <div class="p-1 px-4 rounded shadow-sm m-1 cursor-pointer duration-300 hover:border-yellow-300 hover:text-yellow-800 border border-gray-200" >១ សប្ដាហ៍មុន</div>
        <div class="p-1 px-4 rounded shadow-sm m-1 cursor-pointer duration-300 hover:border-yellow-300 hover:text-yellow-800 border border-gray-200" >ថ្ងៃនេះ</div>
        <div class="p-1 px-4 rounded shadow-sm m-1 cursor-pointer duration-300 hover:border-yellow-300 hover:text-yellow-800 border border-gray-200" >១ សប្ដាហ៍បន្ទាប់</div>
        <div class="p-1 px-4 rounded shadow-sm m-1 cursor-pointer duration-300 hover:border-yellow-300 hover:text-yellow-800 border border-gray-200" >១ ខែបន្ទាប់</div> -->
        <!-- Status filter dropdown list-->
        <!-- <div class="item" >
          <n-select 
            @update:value="updateStatus"
            placeholder="ស្ថានភាពកិច្ចប្រជុំ"
            :options="statuses" 
            multiple
          >
          </n-select>
        </div> -->
        <!-- Type filter dropdown list-->
        <!-- <div class="item" >
          <n-select 
            @update:value="updateType"
            placeholder="ប្រភេទកិច្ចប្រជុំ"
            :options="types"
            multiple
          >
          </n-select>
        </div> -->
        <!-- Organization filter dropdown list-->
        <!-- <div class="item" >
          <n-select 
            @update:value="updateOrganization"
            placeholder="ក្រសួង ស្ថាប័ន"
            :options="organizations"
            multiple
            filterable
          >
          </n-select>
        </div> -->
        <!-- Meeting member filter dropdown list-->
        <!-- <div class="item" >
          <n-select 
            @update:value="updatePeople"
            placeholder="សមាសភាពអង្គប្រជុំ"
            :options="people"
            multiple
            filterable
          >
          </n-select>
        </div> -->
        <!-- Meeting room filter dropdown list-->
        <!-- <div class="item" >
          <n-select 
            @update:value="updateRoom"
            placeholder="សាលប្រជុំ"
            :options="rooms"
            multiple
            filterable
          >
          </n-select>
        </div> -->
        <!-- Type filter dropdown list-->
        <!-- <div class="item" >
          <n-date-picker 
          clearable
          v-model:value="selectedDate" 
          @update:value="updateDate" 
          placeholder="បរិច្ឆែទប្រជុំ"
          type="date" />
        </div> -->
      <!-- </div> -->
      <Transition name="slide-fade" >
        <div v-if="Array.isArray( records ) && records.length > 0 " class="vcb-thumbnail mb-24" >
          <div v-for="(record, index) in records" :key='index' class="item " >
            <div class="content " >
              <div v-if="record.image != false && record.image != null && record.image != undefined " class="image-stick-top-left bg-80% bg-cover bg-center bg-no-repeat " :style=" 'background-image: url(' + record.image +');' " ></div>
              <div v-if="record.image == false || record.image == null || record.image == undefined " class="image-stick-top-left bg-contain bg-center bg-no-repeat " :style=" 'background-image: url('+ orgLogoUrl +');' " ></div>
              <div class="flex flex-wrap my-2" >
                <div class="w-full py-2" >
                  <div class="w-full text-left leading-6 my-2 text-md font-sr" ><pre class="w-full text-left leading-6 my-2 text-md font-sr text-wrap" >{{ applyTagMark( record.objective ) }}</pre></div>
                  <div class="w-full flex my-1">
                    <div class="w-1/2 text-left text-gray-600 leading-4 font-sr text-xxs">{{ record.type != undefined ? record.type.name : '' }}</div>
                    <div class="w-1/2 text-right text-gray-600 leading-6 font-sr text-xxs" v-html="record.organizations != undefined && record.organizations.length > 0 ? record.organizations.map( o => o.name ).join( '<br/>' ) : '' " ></div>
                  </div>
                  <div class="w-full flex my-1">
                    <div class="w-1/2 ">
                      <div v-for="(lm, index) in getListMembersLeaders(record)" :key="index" class="text-left text-gray-600 leading-4 font-sr text-xxs mb-2" v-html="lm.member.officers.map( 
                          o => 
                          // ( o.organization != undefined ? o.organization.name : '' ) + '<br/>' + ( o.position != undefined ? o.position.name : '' ) + '<br/>' +
                          ( o.countesy != undefined ? o.countesy.name : '' ) + ' ' + lm.member.lastname + ' ' + lm.member.firstname 
                        ).join(' ')"></div>
                    </div>
                    <div class="w-1/2 text-right text-gray-600 leading-4 font-sr text-xxs">
                      <div v-for="(member, index) in getListMembersDefenders(record)" :key="index" class="text-left text-gray-600 leading-4 font-sr text-xxs mb-2" v-html="member.officers.map( 
                          o => 
                          // ( o.organization != undefined ? o.organization.name : '' ) + '<br/>' + ( o.position != undefined ? o.position.name : '' ) + '<br/>' +
                          ( o.countesy != undefined ? o.countesy.name : '' ) + ' ' + member.lastname + ' ' + member.firstname 
                        ).join(' ')" ></div>
                    </div>
                  </div>
                  <div class="w-full flex my-1">
                    <div class="w-1/2 text-left text-gray-600 leading-4 font-sr text-xxs">{{ Array.isArray( record.rooms ) && record.rooms.length > 0 ? record.rooms.map( o => o.name ).join( ' , ' ) : '' }}</div>
                    <div class="w-1/2 text-right text-gray-600 leading-4 font-sr text-xxs"></div>
                  </div>
                  <div class="w-full flex my-1">
                    <div class="w-1/2 text-left text-gray-600 leading-4 font-sr text-xxs">{{ $toKhmer( dateFormat( new Date( record.date ) , 'dd-mm-yyyy' ) ) }}</div>
                    <div class="w-1/2 text-right text-gray-600 leading-4 font-sr text-xxs"></div>
                  </div>
                  <div class="w-full flex my-1">
                    <div class="w-1/2 text-left text-gray-600 leading-4 font-sr text-xxs">{{$toKhmer( record.start + ' - ' + record.end ) }}</div>
                  </div>
                </div>
              </div>
              <thumbnail-actions-form v-if="crud!=null" v-bind:crud="crud" v-bind:model="model" v-bind:record="record" :onClose="closeActions" />
            </div>
          </div>
        </div>
      </Transition>
      <Transition name="slide-fade" >
        <div v-if="!Array.isArray( records ) || ( Array.isArray( records ) && records.length <= 0 ) " class="mt-24 text-lg text-gray-600" >មិនមានព័ត៌មានសម្រាប់បង្ហាញឡើយ។</div>
      </Transition>
      <!-- Pagination of crud -->
      <div class="fixed left-0 right-0 bottom-8 flex flex-wrap" >
        <Transition name="slide-fade" >
          <!-- This pagination is for the media side with from Medium up -->
          <div v-if="pagination.totalPages > 1" class="vcb-table-pagination bg-blue-300 mx-auto">
            <n-tooltip trigger="hover">
              <template #trigger>
                <n-popselect 
                  trigger="click"
                  v-model:value="pagination.perPage"
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
                  <div class="cursor-pointer font-pvh rounded-full p-2 px-4 border border-gray-200 text-blue-600" >{{ $toKhmer( pagination.perPage ) }}</div>
                </n-popselect>
              </template>
              ចំនួនព័ត៌មានបង្ហាញម្ដង
            </n-tooltip>
            <!-- Information -->
            <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 mx-2" >{{ pagination.totalRecords > 0 ? $toKhmer( pagination.totalRecords ) + " ឯកសារ" : "" }}</div>
            <div class="vcb-table-pagination-info font-pvh text-blue-600 p-1 mx-2" >{{ pagination.totalPages > 0 ? $toKhmer( pagination.totalPages ) + " ទំព័រ" : "" }}</div>
            <!-- Pages (7) -->
            <div v-for="(page, index) in pagination.buttons" :key="index" :class=" (pagination.page == page ? ' vcb-pagination-page-active ' : ' vcb-pagination-page ' )" @click="pagination.page == page ? false : goTo(page) " >{{ $toKhmer( page ) }}</div>
            <!-- First -->
            <div v-if="pagination.page > 1 " class="vcb-pagination-page p-1" @click="first()" >
              <svg class="w-5 h-5 mx-auto" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M18.29 17.29a.996.996 0 0 0 0-1.41L14.42 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L12.3 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path><path d="M11.7 17.29a.996.996 0 0 0 0-1.41L7.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L5.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.38.38 1.01.38 1.4-.01z" fill="currentColor"></path></svg>
            </div>
            <!-- Previous -->
            <Transition name="slide-fade" >
              <div v-if="pagination.page > 1 " class="vcb-pagination-page p-1" @click="previous()" >
                <svg class="w-5 h-5 mx-auto" 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M14.71 15.88L10.83 12l3.88-3.88a.996.996 0 1 0-1.41-1.41L8.71 11.3a.996.996 0 0 0 0 1.41l4.59 4.59c.39.39 1.02.39 1.41 0c.38-.39.39-1.03 0-1.42z" fill="currentColor"></path></svg>
              </div>
            </Transition>
            <!-- Next -->
            <Transition name="slide-fade" >
              <div v-if="pagination.page < pagination.totalPages " class="vcb-pagination-page p-1" @click="next()" >
                <svg class="w-5 h-5 mx-auto" 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M9.29 15.88L13.17 12L9.29 8.12a.996.996 0 1 1 1.41-1.41l4.59 4.59c.39.39.39 1.02 0 1.41L10.7 17.3a.996.996 0 0 1-1.41 0c-.38-.39-.39-1.03 0-1.42z" fill="currentColor"></path></svg>
              </div>
            </Transition>
            <!-- Last -->
            <div v-if="pagination.page < pagination.totalPages "  class="vcb-pagination-page p-1" @click="last()" >
              <svg class="w-5 h-5 mx-auto" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M5.7 6.71a.996.996 0 0 0 0 1.41L9.58 12L5.7 15.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L7.12 6.71c-.39-.39-1.03-.39-1.42 0z" fill="currentColor"></path><path d="M12.29 6.71a.996.996 0 0 0 0 1.41L16.17 12l-3.88 3.88a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L13.7 6.7c-.38-.38-1.02-.38-1.41.01z" fill="currentColor"></path></svg>
            </div>
            <!-- Go to -->
            <!-- Total per page -->
          </div>
        </Transition>
      </div>
      <Transition name="slide-fade" >
        <div v-if="crudLoading" class="table-loading absolute flex left-0 top-0 right-0 bottom-0 bg-white bg-opacity-90 ">
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
    </div>
    <!-- Filter panel of crud -->
    <Transition name="slide-fade" >
      <div v-if="filter" class="vcb-filters-panel">
        <n-tooltip trigger="hover" >
          <template #trigger>
            <svg 
              @click="toggleFilter" 
              class="absolute bg-white rounded-full shadow p-1 right-2 top-2 w-10 h-10 border border-gray-200 cursor-pointer hover:text-green-500 duration-300" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z" fill="currentColor"></path></svg>
          </template>
          បិទផ្ទាំងចម្រោះព័ត៌មាន
        </n-tooltip>
        <div class="filter-title font-moul" >សូមជ្រើសរើសលក្ខណ សម្រង់ទិន្នន័យ៖</div>
        <div class="filter-actions" >
          <!-- Status filter dropdown list-->
          <div class="filter-action" >
            <n-select 
              @update:value="updateStatus"
              placeholder="ស្ថានភាពកិច្ចប្រជុំ"
              :options="statuses"
              multiple
            >
            </n-select>
          </div>
          <!-- Type filter dropdown list-->
          <div class="filter-action" >
            <n-select 
              @update:value="updateType"
              placeholder="ប្រភេទកិច្ចប្រជុំ"
              :options="types"
              multiple
            >
            </n-select>
          </div>
          <!-- Organization filter dropdown list-->
          <div class="filter-action" >
            <n-select 
              @update:value="updateOrganization"
              placeholder="ក្រសួង ស្ថាប័ន"
              :options="organizations"
              multiple
              filterable
            >
            </n-select>
          </div>
          <!-- Meeting member filter dropdown list-->
          <div class="filter-action" >
            <n-select 
              @update:value="updatePeople"
              placeholder="សមាសភាពអង្គប្រជុំ"
              :options="people"
              multiple
              filterable
            >
            </n-select>
          </div>
          <!-- Meeting room filter dropdown list-->
          <div class="filter-action" >
            <n-select 
              @update:value="updateRoom"
              placeholder="សាលប្រជុំ"
              :options="rooms"
              multiple
              filterable
            >
            </n-select>
          </div>
          <!-- Type filter dropdown list-->
          <div class="filter-action" >
            <n-date-picker 
            clearable
            v-model:value="selectedDate" 
            @update:value="updateDate" 
            placeholder="បរិច្ឆែទប្រជុំ"
            type="date" />
          </div>
        </div>
      </div>
    </Transition>
    <!-- Top action panel of crud -->
    <div class="absolute left-0 top-0 right-0 bg-white flex title-bar border-b border-gray-200 p-2 h-12 ">
      <div class="flex w-64 h-8 title " >
        <svg class="flex-none w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><g fill="none"><path d="M14.708 6a5.938 5.938 0 0 0-5.736 4.403l-1.773 6.623c.181-.017.365-.026.55-.026h2.045l1.593-5.951a3.438 3.438 0 0 1 3.32-2.549h18.587a3.438 3.438 0 0 1 3.32 2.549l4.756 17.77a3.72 3.72 0 0 1-3.594 4.681H21V36h16.776c4.09 0 7.066-3.878 6.01-7.828l-4.756-17.77A5.938 5.938 0 0 0 33.294 6H14.708zM34.75 40.5H20.995c.003-.083.005-.166.005-.25V38h13.751a1.25 1.25 0 0 1 0 2.5zM11.501 29a2.5 2.5 0 1 0 0-5a2.5 2.5 0 0 0 0 5zM4 22.75A3.75 3.75 0 0 1 7.75 19h7.5A3.75 3.75 0 0 1 19 22.75v17.5A3.75 3.75 0 0 1 15.25 44h-7.5A3.75 3.75 0 0 1 4 40.25v-17.5zm3.75-1.25c-.69 0-1.25.56-1.25 1.25v17.5c0 .69.56 1.25 1.25 1.25h7.5c.69 0 1.25-.56 1.25-1.25v-17.5c0-.69-.56-1.25-1.25-1.25h-7.5z" fill="currentColor"></path></g></svg>
        <div class="font-moul ml-2 h-8 leading-9" v-html="model.title" ></div>
      </div>
      <div class="flex-grow action-buttons flex-row-reverse flex">
        <div class="ml-2 flex flex-wrap">
          <n-tooltip v-if=" $hasPermission('portal_meeting_creating') " trigger="hover">
            <template #trigger>
              <svg class="w-8 h-8 cursor-pointer text-blue-500 duration-300" @click="showCreateModal" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M9 12h6"></path><path d="M12 9v6"></path></g></svg>
            </template>
            បន្ថែមទិន្នន័យថ្មី
          </n-tooltip>
        </div>
        <div class="w-3/5 md:w-2/5 relative h-8 " >
          <n-tooltip trigger="hover">
            <template #trigger>
              <div class="w-full relative" >
                <input type="text" @keypress.enter="getRecords" v-model="pagination.search" class="bg-gray-100 px-2 h-8 w-full rounded border border-gray-200 focus:border-blue-600 hover:border-blue-600 duration-300" placeholder="ស្វែងរក" />
                <svg class="absolute right-1 top-1 w-6 h-6 text-gray-400  cursor-pointer" @click="getRecords" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.5 3a5.5 5.5 0 0 1 4.227 9.02l4.127 4.126a.5.5 0 0 1-.638.765l-.07-.057l-4.126-4.127A5.5 5.5 0 1 1 8.5 3zm0 1a4.5 4.5 0 1 0 0 9a4.5 4.5 0 0 0 0-9z" fill="currentColor"></path></g></svg>
              </div>
            </template>
            សូមបញ្ចូលពាក្យគន្លឹះដើម្បីស្វែងរក
          </n-tooltip>
        </div>
        <div class="ml-2 flex flex-wrap">
          <n-tooltip trigger="hover">
            <template #trigger>
              <svg 
              class="mx-2 w-8 h-8 p-1 bg-white rounded-full border border-yellow-300 cursor-pointer text-yellow-500 duration-300"
              @click="toggleFilter" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M18 28h-4a2 2 0 0 1-2-2v-7.59L4.59 11A2 2 0 0 1 4 9.59V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v3.59a2 2 0 0 1-.59 1.41L20 18.41V26a2 2 0 0 1-2 2zM6 6v3.59l8 8V26h4v-8.41l8-8V6z" fill="currentColor"></path></svg>
            </template>
            សម្រង់ទិន្នន័យ
          </n-tooltip>
          <n-tooltip trigger="hover">
            <template #trigger>
              <a target='_blank' href="https://meeting.ocm.gov.kh/#/tvtemplate3" >
                <svg 
                class="mx-2 w-8 h-8 p-1 bg-white cursor-pointer text-blue-500 duration-300"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path data-v-781535bd="" d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 13H3V6c0-.55.45-1 1-1h16c.55 0 1 .45 1 1v10z" fill="currentColor"></path></svg>
              </a>
            </template>
            កាលវិភាគប្រជុំ
          </n-tooltip>
        </div>
      </div>
    </div>
    <!-- Form create account -->
    <create-form v-bind:model="model" v-bind:show="createModal.show" :onClose="closeCreateModal"/>
  </div>
</template>
<script>
import Crud from '@classes/Crud.js'
import { reactive ,ref , onMounted , computed } from 'vue'
import { useStore } from 'vuex'
import QrcodeVue from 'qrcode.vue'
import Vue3Barcode from 'vue3-barcode'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import dateFormat from 'dateformat'
import orgLogoUrl from '@assets/logo.png'

/**
 * CRUD component form
 */

import ThumbnailActionsForm from './../actions/thumbnail-action.vue'
import CreateForm from './../widgets/create.vue'
export default {
  name: "CRUDThumbnail" ,
  components: {
    QrcodeVue ,
    Vue3Barcode,
    ThumbnailActionsForm ,
    CreateForm
  },
  props: {
    model: {
      required: true ,
      default: () => {
        return reactive({
          name: 'meeting' ,
          modules: 'meetings' ,
          title: 'កិច្ចប្រជុំ'
        })
      }
    }
  },
  setup(props){
    const store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()
    const crud = ref(null)

    const server = ref( store.getters[ props.model.name + '/server'] )
    const pagination = ref( store.getters[ props.model.name + '/pagination'] )
    const columns = ref( store.getters[ props.model.name + '/columns'] )
    const records = ref([])

    const crudLoading = ref(false)
    function getRecords(){
      crudLoading.value = true
      crud.value.list( 
        {
          ids: Array.isArray( pagination.value.ids ) && pagination.value.ids.length > 0 ? pagination.value.ids : [] ,
          page: parseInt( pagination.value.page ) > 0 ? parseInt( pagination.value.page ) : 1 ,
          perPage: parseInt( pagination.value.perPage ) > 0 ? parseInt( pagination.value.perPage ) : 10 ,
          search : pagination.value.search != null && pagination.value.search != undefined && pagination.value.search != "" ? pagination.value.search : "" ,

          date: selectedDate.value == null ? '' : dateFormat( new Date( selectedDate.value ) , 'yyyy-mm-dd' ) ,
          statuses: selectedStatuses.value ,
          types: selectedTypes.value ,
          members : selectedPeople.value ,
          organizations : selectedOrganizations.value ,
          rooms : selectedRooms.value

        },
        ( res ) => {
          pagination.value = crud.value.getPagination()
          records.value = res.data.records
          window.clearTimeout()
          closeTableLoading()
        },
        ( error ) => {
          closeTableLoading()
        }
      )
    }

    function first(){
      goTo( pagination.value.totalPages > 0 ? 1 : 0 )
    }
    function previous(){
      goTo( pagination.value.page <= 1 ? 1 : pagination.value.page - 1 )
    }
    function next(){
      goTo( pagination.value.page >= pagination.value.totalPages ? pagination.value.totalPages : pagination.value.page + 1 )
    }
    function last(){
      goTo( pagination.value.totalPages > 0 ? pagination.value.totalPages : 0 )
    }
    function goTo(page){
      pagination.value.page = page >= pagination.value.totalPages ? pagination.value.totalPages : ( page < 1 ? 1 : page)
      getRecords()
    }
    function updatePerpage(perPage){
      pagination.value.perPage = perPage < 5 ? 5 : ( perPage > 100 ? 100 : perPgae )
      pagination.value.page = 1
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

    const filter = ref(false)    
    function toggleFilter(){
      filter.value = !filter.value
    }
  
    function closeTableLoading(){
      crudLoading.value = false
    }
    function closeActions( actionStatus ){
      if( parseInt( actionStatus ) > 0 ) getRecords()
    }

    function getListMembersDefenders(record){
      return record.listMembers != undefined && record.listMembers.length > 0
        ? record.listMembers.filter( o => o.group == 'defender' ).map( lm => 
          (
            lm.member.officers != undefined && lm.member.officers.length > 0 
              ? lm.member
              : []
          )
        )
        : []
    }

    function getListMembersLeaders(record){
      let result = record.listMembers != undefined && record.listMembers.length > 0
        ? record.listMembers.filter( o => o.group == 'lead_meeting' && o.member != undefined && o.member.officers != undefined && o.member.officers.length > 0  )
        : []
      return result 
    }
    
    const search = ref(null)
    
    /**
     * Mark the matched text with in search box
     */
    function applyTagMark(str){
      // Split the string by whitespace
      if( pagination.value.search != undefined && pagination.value.search.trim() != "" ){
        var arrStrSearch = pagination.value.search.split(/(\s+)/).filter( e => e.trim().length > 0).map( e => e.replaceAll(" ","") )
        for( var i in arrStrSearch ){
          if( str.includes( arrStrSearch[i] ) ) str = str.replaceAll( arrStrSearch[i] , '<mark>' + arrStrSearch[i] + '</mark>' ) 
        }
      }
      return str
    }

    onMounted( () => {
      initial()
    })

    const selectedStatuses = ref([])
    const statuses = reactive([
      {
        label: 'ទាំងអស់' ,
        value : null ,
        color: 'text-gray-200'
      },
      {
        label: 'មិនទាន់ប្រជុំ',
        value : 1 ,
        color: ' text-blue-600 ' 
      } ,
      {
        label: 'កំពុងប្រជុំ' ,
        value : 2 ,
        color: ' text-green-600' 
      } ,
      {
        label: 'នៅបន្ត' ,
        value : 4 ,
        color: ' text-yellow-600' 
      } ,
      {
        label: 'ប្ដូរ' ,
        value : 8 ,
        color: ' text-pink-600' 
      } ,
      {
        label: 'ពន្យាពេល' ,
        value : 16 ,
        color: ' text-brown-600' 
      } ,
      {
        label: 'ចប់' ,
        value : 32 ,
        color: ' text-gray-600' 
      }
    ])
    function updateStatus(value, selection){
      selectedStatuses.value = value.filter( ( val ) => parseInt( val ) > 0 )
      goTo(1)
    }

    const today = computed(() => {
      return dateFormat( new Date( attendantDate.value ) , 'yyyy-mm-dd' )
    })

    function getStatusLabel( code ){
      let status = statuses.find( s => s.code == code )
      return status != undefined ? status.label : "មិនមាន"
    }

    function getTypes(){
      store.dispatch('meetingType/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingType/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }
    const types = computed( () => {
      let types = 
        store.getters['meetingType/records'].all.map( type => {
          return { label : type.name , value : type.id }
        })
        types.unshift({
          label: 'ទាំងអស់' ,
          value: 0
        })
      return types
    })
    const selectedTypes = ref([])
    function updateType(value,selection){
      selectedTypes.value = value
      goTo(1)
    }

    function getOrganizations(){
      store.dispatch('meetingOrganization/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingOrganization/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }
    const organizations = computed( () => {
      let organizations = 
        store.getters['meetingOrganization/records'].all.map( organization => {
          return { label : organization.name , value : organization.id }
        })
        organizations.unshift({
          label: 'ទាំងអស់' ,
          value: 0
        })
      return organizations
    })
    const selectedOrganizations = ref([])
    function updateOrganization(value,selection){
      selectedOrganizations.value = value
      goTo(1)
    }

    function getPeople(){
      store.dispatch('meetingPeople/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingPeople/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }
    const people = computed( () => {
      let people = 
        store.getters['meetingPeople/records'].all.map( person => {
          return { label : person.lastname + " " + person.firstname , value : person.id }
        })
        people.unshift({
          label: 'ទាំងអស់' ,
          value: 0
        })
      return people
    })
    const selectedPeople = ref([])
    function updatePeople(value,selection){
      selectedPeople.value = value
      goTo(1)
    }

    function getRooms(){
      store.dispatch('meetingRoom/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingRoom/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }
    const rooms = computed( () => {
      let rooms = 
        store.getters['meetingRoom/records'].all.map( room => {
          return { label : room.name , value : room.id }
        })
        rooms.unshift({
          label: 'ទាំងអស់' ,
          value: 0
        })
      return rooms
    })
    const selectedRooms = ref([])
    function updateRoom(value,selection){
      selectedRooms.value = value
      goTo(1)
    }

    function getCountesies(){
      store.dispatch('meetingCountesy/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingCountesy/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }

    function getPositions(){
      store.dispatch('meetingPosition/list',{page:1, perPage : 1000 , search : '' })
      .then( res => {
        store.commit('meetingPosition/setAllRecords', res.data.records)
      }).catch( err => {
        notify.error( err )
      })
    }

    // const selectedDate = ref( new Date().getTime() )
    const selectedDate = ref( null )
    function updateDate(value){
      selectedDate.value = value
      goTo(1)
    }

    function initial(){
      store.commit( props.model.name+"/setColumns", [ 'id' , 'name' , 'desp' , 'active' , 'image' , 'pdf' , 'pid' , 'tpid' ] )
      store.commit( props.model.name+"/setModel", props.model )

      crud.value = new Crud()
      crud.value.setConfig( import.meta.env.VITE_API_SERVER , store.getters[props.model.name+'/model'] , store.getters[props.model.name+'/columns'].all )
      
      getRecords()
      getTypes()
      getOrganizations()
      getPositions()
      getCountesies()
      getPeople()
      getRooms()
    }

    return {
      // Variables
      crud ,
      crudLoading ,
      /**
       * Computed Property from store
       */
      records ,
      columns ,
      pagination ,
      // Functions
      closeActions ,
      closeTableLoading ,
      /**
       * Variables
       */
      search ,
      /**
       * Create Modal
       */
      createModal ,
      showCreateModal,
      closeCreateModal ,
      /**
       * Records Functions
       */
      getRecords ,
      applyTagMark ,
      filter, 
      toggleFilter ,
      previous ,
      next ,
      goTo ,
      updatePerpage ,
      last ,
      first ,
      /**
       * Filter functions
       */
      updateStatus ,
      statuses , 
      selectedStatuses ,
      today ,
      getStatusLabel ,
      updateType ,
      types ,
      updateOrganization ,
      organizations ,
      updatePeople ,
      people ,
      updateRoom ,
      rooms ,
      selectedDate ,
      updateDate ,
      orgLogoUrl ,
      getListMembersLeaders ,
      getListMembersDefenders ,
      dateFormat
    }
  }
}

</script>
<style type="text/css" scoped >
.vcb-thumbnail {
  @apply flex flex-wrap justify-center;
}
.vcb-thumbnail .item {
  @apply 2xl:w-1/4 xl:w-1/3 lg:w-1/2 md:w-1/2 sm:w-1/2 w-1/2 p-2 py-4 ;
}
.vcb-meeting-timestamp .item {
  @apply 2xl:w-1/5 xl:w-1/5 lg:w-1/4 md:w-1/3 sm:w-1/3 w-1/2 p-1 ;
}
.vcb-thumbnail .item .content {
  @apply border rounded-lg duration-500 p-4 relative hover:scale-105 transform-gpu bg-white;
  /* min-height: 200px;  */
}
.vcb-thumbnail .item .content .image {
  @apply border rounded-full border-gray-200 p-2 w-20 h-20 flex-none mx-auto overflow-hidden bg-white ;
}
.vcb-thumbnail .item .content .image-stick-top-left {
  @apply absolute left-2 -top-5 border rounded-full border-gray-200 p-2 w-10 h-10 flex-none mx-auto overflow-hidden bg-white z-50;
}
.vcb-table-pagination-info {
  @apply text-blue-600 leading-7 p-1 mx-1 ;
}
.vcb-filters-panel {
  @apply absolute left-0 top-12 right-0 bottom-0 bg-opacity-90 p-12 bg-gray-100;
}
.vcb-filters-panel .filter-title {
  @apply w-full text-left ;
}
.vcb-filters-panel .filter-actions {
  @apply w-full text-left p-4 flex flex-wrap justify-center;
}
.vcb-filters-panel .filter-actions .filter-action {
  @apply p-2 m-2 bg-white rounded-sm border border-gray-300 w-4/6 sm:w-2/5 md:w-1/3 lg:w-1/4 xl:w-2/6 ;
}
</style>