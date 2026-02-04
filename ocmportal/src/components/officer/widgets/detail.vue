<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-after-enter="initial" transform-origin="center">
        <n-card class="relative w-12/12 min-h-screen font-pvh text-xl p-0 " :bordered="false" size="small">
          <div class="absolute left-8 top-8 right-8 bottom-8 bg-white border border-gray-300 rounded p-8 -my-3 -mx-4">
            <div class="left-panel absolute left-0 top-0 bottom-0 w-48 bg-gray-100/80" >
              <n-scrollbar >
                <div class="officer-information-panel" >
                  <div class='officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white w-full cursor-pointer' >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="maskOrEscClick" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M16.88 2.88a1.25 1.25 0 0 0-1.77 0L6.7 11.29a.996.996 0 0 0 0 1.41l8.41 8.41c.49.49 1.28.49 1.77 0s.49-1.28 0-1.77L9.54 12l7.35-7.35c.48-.49.48-1.28-.01-1.77z" fill="currentColor"></path></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ចាកចេញ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_background_information')" :class=" ( activeMenu == 'background' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                  <!-- <div class='officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white w-full cursor-pointer' > -->
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('background')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28 8h2v8h-2z" fill="currentColor"></path><path d="M23 5h2v11h-2z" fill="currentColor"></path><path d="M18 10h2v6h-2z" fill="currentColor"></path><path d="M16 30h-2v-6a3.003 3.003 0 0 0-3-3H7a3.003 3.003 0 0 0-3 3v6H2v-6a5.006 5.006 0 0 1 5-5h4a5.006 5.006 0 0 1 5 5z" fill="currentColor"></path><path d="M9 9a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0-2a5 5 0 1 0 5 5a5 5 0 0 0-5-5z" fill="currentColor"></path></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ប្រវត្តិរូប</div>
                    </div>
                  </div>
                  <!-- <div :class=" ( activeMenu == 'profile' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('profile')" >
                      <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path></svg>
                      <div class="information-label text-md  text-center py-2 " >ព័ត៌មានមន្ត្រី</div>
                    </div>
                  </div> -->
                  <div v-if="$hasPermission('portal_staff_study_background')" :class=" ( activeMenu == 'educations' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('educations')">
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 640 512"><path d="M622.34 153.2L343.4 67.5c-15.2-4.67-31.6-4.67-46.79 0L17.66 153.2c-23.54 7.23-23.54 38.36 0 45.59l48.63 14.94c-10.67 13.19-17.23 29.28-17.88 46.9C38.78 266.15 32 276.11 32 288c0 10.78 5.68 19.85 13.86 25.65L20.33 428.53C18.11 438.52 25.71 448 35.94 448h56.11c10.24 0 17.84-9.48 15.62-19.47L82.14 313.65C90.32 307.85 96 298.78 96 288c0-11.57-6.47-21.25-15.66-26.87c.76-15.02 8.44-28.3 20.69-36.72L296.6 284.5c9.06 2.78 26.44 6.25 46.79 0l278.95-85.7c23.55-7.24 23.55-38.36 0-45.6zM352.79 315.09c-28.53 8.76-52.84 3.92-65.59 0l-145.02-44.55L128 384c0 35.35 85.96 64 192 64s192-28.65 192-64l-14.18-113.47l-145.03 44.56z" fill="currentColor"></path></svg> -->
                      <div class="information-label text-md text-center py-2 " >កម្រិតការសិក្សា</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_birth_background')" :class=" ( activeMenu == 'birthCertificates' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('birthCertificates')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M9.996 1.992c-.77 0-1.279.541-1.568 1.027c-.294.493-.45 1.07-.471 1.442c-.041.74.07 1.388.439 1.856c.384.488.96.675 1.6.675c.649 0 1.223-.209 1.605-.697c.369-.472.488-1.115.44-1.839c-.023-.352-.181-.926-.474-1.421c-.287-.485-.796-1.043-1.57-1.043zm-1.04 2.524c.01-.203.116-.624.331-.986c.22-.368.465-.538.71-.538c.239 0 .485.172.71.551c.217.37.325.793.337.978c.039.6-.074.958-.23 1.158c-.143.182-.385.313-.818.313c-.45 0-.682-.125-.814-.294c-.15-.19-.262-.544-.227-1.182zM5 8a2 2 0 0 0-2 2v6h-.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H17v-6a2 2 0 0 0-2-2H5zm11 8H4v-3.882l1.545 1.38a2 2 0 0 0 2.828-.162l.88-.99a1 1 0 0 1 1.495 0l.879.99a2 2 0 0 0 2.829.163L16 12.118V16zm0-5.224l-2.211 1.977a1 1 0 0 1-1.414-.081l-.88-.99a2 2 0 0 0-2.99 0l-.88.99a1 1 0 0 1-1.414.081L4 10.776V10a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.776z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md text-center py-2 " >អត្រានុកូលដ្ឋាន</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_wedding_background')" :class=" ( activeMenu == 'weddingCertificates' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('weddingCertificates')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="5" r="2"></circle><path d="M5 22v-5l-1-1v-4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4l-1 1v5"></path><circle cx="17" cy="5" r="2"></circle><path d="M15 22v-4h-2l2-6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1l2 6h-2v4"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >អាពាហ៍ពិពាហ៍</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_birth_kids_background')  && record.people != undefined && record.people != null && record.people.weddingCertificates != undefined && record.people.weddingCertificates != null && record.people.weddingCertificates.length > 0 " :class=" ( activeMenu == 'childCertificates' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('childCertificates')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="5" r="2"></circle><path d="M5 22v-5l-1-1v-4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4l-1 1v5"></path><circle cx="17" cy="5" r="2"></circle><path d="M15 22v-4h-2l2-6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1l2 6h-2v4"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >អត្រានុកូលដ្ឋានកូន</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_nid_background')" :class=" ( activeMenu == 'nationalityIdentityCards' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('nationalityIdentityCards')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md text-center py-2 " >អត្តសញ្ញាណបណ្ណ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_passport_background')" :class=" ( activeMenu == 'passports' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('passports')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 576 512"><path d="M528 32H48C21.5 32 0 53.5 0 80v16h576V80c0-26.5-21.5-48-48-48zM0 432c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V128H0v304zm352-232c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zm0 64c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zm0 64c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16zM176 192c35.3 0 64 28.7 64 64s-28.7 64-64 64s-64-28.7-64-64s28.7-64 64-64zM67.1 396.2C75.5 370.5 99.6 352 128 352h8.2c12.3 5.1 25.7 8 39.8 8s27.6-2.9 39.8-8h8.2c28.4 0 52.5 18.5 60.9 44.2c3.2 9.9-5.2 19.8-15.6 19.8H82.7c-10.4 0-18.8-10-15.6-19.8z" fill="currentColor"></path></svg> -->
                      <div class="information-label text-md  text-center py-2 " >លិខិតឆ្លងដែន</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_language_background')" :class=" ( activeMenu == 'language' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('language')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " 
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 112h288"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M192 64v48"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M272 448l96-224l96 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M301.5 384h133"></path><path d="M281.3 112S257 206 199 277S80 384 80 384" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M256 336s-35-27-72-75s-56-85-56-85" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ភាសា</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_working_background')" :class=" ( activeMenu == 'jobbackground' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('jobbackground')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M5 6.25A2.25 2.25 0 0 1 7.25 4h8.5A2.25 2.25 0 0 1 18 6.25V14h3.5v3.25a3.25 3.25 0 0 1-3.25 3.25H13V19h3.5V6.25a.75.75 0 0 0-.75-.75h-8.5a.75.75 0 0 0-.75.75V14H5V6.25zM18 19h.25A1.75 1.75 0 0 0 20 17.25V15.5h-2V19zm-3.75-2.5H13a2.49 2.49 0 0 0-.5-1.5h1.75a.75.75 0 0 1 0 1.5zM8 8.75A.75.75 0 0 1 8.75 8h5.5a.75.75 0 0 1 0 1.5h-5.5A.75.75 0 0 1 8 8.75zm0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zM1 16.5A1.5 1.5 0 0 1 2.5 15h8a1.5 1.5 0 0 1 1.5 1.5v4a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 1 20.5v-4zm10 .5a1 1 0 0 1-1-1H9a2 2 0 0 0 2 2v-1zm0 2a2 2 0 0 0-2 2h1a1 1 0 0 1 1-1v-1zm-8-3a1 1 0 0 1-1 1v1a2 2 0 0 0 2-2H3zm1 5a2 2 0 0 0-2-2v1a1 1 0 0 1 1 1h1zm4.25-2.5a1.75 1.75 0 1 0-3.5 0a1.75 1.75 0 0 0 3.5 0z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ប្រវត្តិការងារ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_rank_with_work_background')" :class=" ( activeMenu == 'rankbyworking' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('rankbyworking')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M15.527 3.001a1.5 1.5 0 0 1 1.5 1.5v1.396a2.5 2.5 0 0 1-1.362 2.226l-4.189 2.14a3.54 3.54 0 1 1-2.924 0l-4.188-2.14a2.5 2.5 0 0 1-1.356-2.04l-.007-.186V4.5a1.5 1.5 0 0 1 1.5-1.5h11.026zm-5.513 7.947a2.54 2.54 0 1 0 0 5.08a2.54 2.54 0 0 0 0-5.08zm2.54-6.947h-5.08v4.588l2.313 1.182a.5.5 0 0 0 .455 0l2.311-1.182V4.001zm-6.08 0H4.501a.5.5 0 0 0-.5.5v1.396l.007.14a1.5 1.5 0 0 0 .81 1.195l1.656.846V4.001zm9.053 0h-1.974v4.077l1.657-.846a1.5 1.5 0 0 0 .817-1.335V4.5a.5.5 0 0 0-.5-.5z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមផ្សេងៗ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_rank_with_certificate_background')" :class=" ( activeMenu == 'rankbycertificate' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('rankbycertificate')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M15.527 3.001a1.5 1.5 0 0 1 1.5 1.5v1.396a2.5 2.5 0 0 1-1.362 2.226l-4.189 2.14a3.54 3.54 0 1 1-2.924 0l-4.188-2.14a2.5 2.5 0 0 1-1.356-2.04l-.007-.186V4.5a1.5 1.5 0 0 1 1.5-1.5h11.026zm-5.513 7.947a2.54 2.54 0 1 0 0 5.08a2.54 2.54 0 0 0 0-5.08zm2.54-6.947h-5.08v4.588l2.313 1.182a.5.5 0 0 0 .455 0l2.311-1.182V4.001zm-6.08 0H4.501a.5.5 0 0 0-.5.5v1.396l.007.14a1.5 1.5 0 0 0 .81 1.195l1.656.846V4.001zm9.053 0h-1.974v4.077l1.657-.846a1.5 1.5 0 0 0 .817-1.335V4.5a.5.5 0 0 0-.5-.5z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ការដំឡើងឋានន្តរស័ក្តិ និងថ្នាក់តាមសញ្ញាបត្រ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_salary_background')" :class=" ( activeMenu == 'freenosalary' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('freenosalary')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10 2a3 3 0 0 0-.5 5.96V9.5h-3A1.5 1.5 0 0 0 5 11v1.042a3.001 3.001 0 1 0 1 0V11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1.042a3.001 3.001 0 1 0 1 0V11a1.5 1.5 0 0 0-1.5-1.5h-3V7.96A3.001 3.001 0 0 0 10 2zM8 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0zM3.5 15a2 2 0 1 1 4.001 0A2 2 0 0 1 3.5 15zm11-2a2 2 0 1 1 0 4.001a2 2 0 0 1 0-4.001z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ទំនេរគ្មានបៀវត្ស</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_officer_out_krobkhan_background')" :class=" ( activeMenu == 'officeroutkrobkhan' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('officeroutkrobkhan')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10 2a3 3 0 0 0-.5 5.96V9.5h-3A1.5 1.5 0 0 0 5 11v1.042a3.001 3.001 0 1 0 1 0V11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1.042a3.001 3.001 0 1 0 1 0V11a1.5 1.5 0 0 0-1.5-1.5h-3V7.96A3.001 3.001 0 0 0 10 2zM8 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0zM3.5 15a2 2 0 1 1 4.001 0A2 2 0 0 1 3.5 15zm11-2a2 2 0 1 1 0 4.001a2 2 0 0 1 0-4.001z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ក្រៅក្របខ័ណ្ឌដើម</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_medal_history_background')" :class=" ( activeMenu == 'officermedalhistory' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('officermedalhistory')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10 2a3 3 0 0 0-.5 5.96V9.5h-3A1.5 1.5 0 0 0 5 11v1.042a3.001 3.001 0 1 0 1 0V11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1.042a3.001 3.001 0 1 0 1 0V11a1.5 1.5 0 0 0-1.5-1.5h-3V7.96A3.001 3.001 0 0 0 10 2zM8 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0zM3.5 15a2 2 0 1 1 4.001 0A2 2 0 0 1 3.5 15zm11-2a2 2 0 1 1 0 4.001a2 2 0 0 1 0-4.001z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ការលើកសសើរ</div>
                    </div>
                  </div>
                  <div v-if="$hasPermission('portal_staff_officer_panelty_background')" :class=" ( activeMenu == 'officerpaneltyhistory' ? 'officer-information-item-active bg-blue-500/80 duration-500  text-white' : 'officer-information-item hover:bg-blue-500/80 duration-500  hover:text-white' ) + ' w-full cursor-pointer ' " >
                    <div class="officer-information-content border-b border-gray-200 py-2" @click="setActiveMenu('officerpaneltyhistory')" >
                      <!-- <svg class="w-12 h-12 rounded-lg mx-auto " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10 2a3 3 0 0 0-.5 5.96V9.5h-3A1.5 1.5 0 0 0 5 11v1.042a3.001 3.001 0 1 0 1 0V11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1.042a3.001 3.001 0 1 0 1 0V11a1.5 1.5 0 0 0-1.5-1.5h-3V7.96A3.001 3.001 0 0 0 10 2zM8 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0zM3.5 15a2 2 0 1 1 4.001 0A2 2 0 0 1 3.5 15zm11-2a2 2 0 1 1 0 4.001a2 2 0 0 1 0-4.001z" fill="currentColor"></path></g></svg> -->
                      <div class="information-label text-md  text-center py-2 " >ការដាក់វិន័យ</div>
                    </div>
                  </div>
                </div>
              </n-scrollbar>
            </div>
            <div class="right-panel absolute left-48 top-0 bottom-0 right-0 bg-gray-100/50 border-l border-gray-300 p-8" >
              <!-- Background Information -->
              <background-information v-bind:record="record" v-bind:show="showBackgroundInformationPanel" />
              <!-- Profile -->
              <profile-information v-bind:record="record" v-bind:show="showProfilePanel" />
              <!-- Educations -->
              <education-certificate v-bind:model="model" v-bind:record="record" v-bind:show="showEducationPanel" :onClose="clearRecord" />
              <!-- Birth Certificates -->
              <birth-certificate v-bind:model="model" v-bind:record="record" v-bind:show="showBirthCertificatePanel" />
              <!-- Wedding Certificates -->
              <wedding-certificate v-bind:record="record" v-bind:show="showWeddingCertificatePanel" />
              <!-- Child Certificates -->
              <child-certificate v-bind:record="record" v-bind:show="showChildCertificatePanel" />
              <!-- Nationality Identity Cards -->
              <nationality-certificate v-bind:record="record" v-bind:show="showNicPanel" />
              <!-- Passports -->
              <passport-certificate v-bind:record="record" v-bind:show="showPassportPanel" />
              <!-- Rewards -->
              <spoken-language v-bind:record="record" v-bind:show="showSpokenLanguagePanel" />
              <!-- Officer Job Background -->
              <Officer-Job-Background v-bind:record="record" v-bind:show="showJobBackgroundPanel" />
              <!-- Salary range -->
              <!-- <salary-range-information v-bind:record="record" v-bind:show="showSalaryRangePanel" /> -->
              <!-- Organization, Position, Ranks -->
              <orgpos-information v-bind:record="record" v-bind:show="showOrgposPanel" />
              <!-- Rewards -->
              <achievement-information v-bind:record="record" v-bind:show="showAchievementsPanel" />
              <!-- OfficerRankByCertificate -->
              <officer-rank-by-certificate v-bind:record="record" v-bind:show="showOfficerRankByCertificatePanel" />
              <!-- OfficerRankByWorking -->
              <officer-rank-by-working v-bind:record="record" v-bind:show="showOfficerRankByWorkingPanel" />
              <!-- Officer free no salary -->
              <officer-free-no-salary v-bind:record="record" v-bind:show="showOfficerFreeNoSalaryPanel" />
              <!-- Officer out krob khan-->
              <officer-out-krobkhan v-bind:record="record" v-bind:show="showOfficerOutKrobKhanWorkPanel" />
              <!-- Officer out krob khan-->
              <officer-medal-history v-bind:record="record" v-bind:show="showOfficerMedalHistoryPanel" />
              <!-- Officer out krob khan-->
              <officer-panelty-history v-bind:record="record" v-bind:show="showOfficerPenaltyPanel" />
            </div>
          </div>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

// import Frame4Corner from './../../widgets/frame/corner4.vue'
// import QrcodeVue from 'qrcode.vue'
import ocmLogoUrl from './../../../assets/logo.svg'
import dateFormat from 'dateformat'

import BirthCertificate from './details/birthcertificate.vue'
import EducationCertificate from './details/educationcertificate.vue'
import WeddingCertificate from './details/weddingcertificate.vue'
import ChildCertificate from './details/childcertificate.vue'
import NationalityCertificate from './details/niccertificate.vue'
import PassportCertificate from './details/passportcertificate.vue'
import ProfileInformation from './details/profile.vue'
import SpokenLanguage from './details/spokenlanguage.vue'
import OfficerJobBackground from './details/officerjobbackground.vue'

import SalaryRangeInformation from './details/salaryrange.vue'
import OrgposInformation from './details/org_pos.vue'
import AchievementInformation from './details/achievement.vue'
import BackgroundInformation from './details/background.vue'
import OfficerRankByCertificate from './details/officerrankbycertificate.vue'
import OfficerRankByWorking from './details/officerrankbyworking.vue'
import OfficerFreeNoSalary from './details/officerfreenosalary.vue'
import OfficerOutKrobkhan from './details/officeroutkrobkhan.vue'
import OfficerMedalHistory from './details/officermedalhistory.vue'
import OfficerPaneltyHistory from './details/officerpaneltyhistory.vue'

export default {
  components: {
    ocmLogoUrl ,
    BirthCertificate ,
    EducationCertificate ,
    WeddingCertificate ,
    ChildCertificate ,
    NationalityCertificate ,
    PassportCertificate ,
    ProfileInformation ,
    SalaryRangeInformation ,
    OrgposInformation ,
    AchievementInformation ,
    BackgroundInformation ,
    SpokenLanguage ,
    OfficerJobBackground ,
    OfficerRankByWorking ,
    OfficerRankByCertificate ,
    OfficerFreeNoSalary ,
    OfficerOutKrobkhan ,
    OfficerMedalHistory ,
    OfficerPaneltyHistory
  },
  props: {
    model: {
      type: Object ,
      required: true ,
      default: () => {
        return reactive({
          name: 'Undefined' ,
          title: 'No title'
        })
      },
      // validator: (val) => {}
    } , 
    record: {
      type: Object ,
      required: true ,
      default: () => {
        return reactive({
          id: 0 ,
          username: '' ,
          firstname: '' ,
          lastname: '' ,
          nid: '' ,
          dob: '' ,
          marry_status: '' ,
          email: '' ,
          phone: '' ,
          person: null ,
          orgainzations: [] ,
          positions: [] ,
          countesies: []
        })
      },
      // validator: (val) => {
      //   for(var field in ['id','username','firstname','lastname','email','phone','password','active'] ){
      //     if( !val.hasOwnProperty(field) ) return false
      //   }
      //   return true 
      // }
    },
    show: {
      type: Boolean ,
      default: false
    },
    onClose: {
      type: Function
    } ,
    // onShow: {
    //   type: Function
    // }
  },
  setup(props){
    var store = useStore()
    const message = useMessage()
    const notify = useNotification()

    const selectedOrganizations = ref([])
    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const selectedPositions = ref([])
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 

    /**
     * Variables
     */    
    var rules = {
        firstname: {
          required: true,
          message: 'សូមបញ្ចូលឈ្មោះ',
          trigger: [ 'blur']
        },
        lastname: {
          required: true,
          message: 'សូមបញ្ចូលត្រកូល',
          trigger: [ 'blur']
        }
    }
    /**
     * Functions
     */
    function clearRecord( actionStatus ){
      props.onClose( actionStatus )
    }
  
    function maskOrEscClick(){
      props.onClose( 1 )
    }

    const activeMenu = ref('')
    const showBackgroundInformationPanel = ref(false)
    const showProfilePanel = ref(false)
    const showEducationPanel = ref(false)
    const showBirthCertificatePanel = ref(false)
    const showWeddingCertificatePanel = ref(false)
    const showChildCertificatePanel = ref(false)    
    const showNicPanel = ref(false)
    const showPassportPanel = ref(false)
    const showSalaryRangePanel = ref(false)
    const showSpokenLanguagePanel = ref(false)
    const showJobBackgroundPanel = ref(false)
    const showOrgposPanel = ref(false)
    const showAchievementsPanel = ref(false)
    const showOfficerRankByCertificatePanel = ref(false)
    const showOfficerRankByWorkingPanel = ref(false)
    const showOfficerFreeNoSalaryPanel = ref(false)
    const showOfficerOutKrobKhanWorkPanel = ref(false)
    const showOfficerMedalHistoryPanel = ref(false)
    const showOfficerPenaltyPanel = ref(false)
    const profileInformationMenus = ref([
      'profile' , 
      'educations' , 
      'birthCertificates' , 
      'weddingCertificates' , 
      'childCertificates' , 
      'nationalityIdentityCards' , 
      'passports' ,
      'salaryrange' ,
      'org_pos' ,
      'achievements' ,
      'background' ,
      'punishment' ,
      'language' ,
      'jobbackground' ,
      'rankbyworking' ,
      'rankbycertificate' ,
      'freenosalary' ,
      'officeroutkrobkhan' ,
      'officermedalhistory' ,
      'officerpaneltyhistory'
    ])
    function setActiveMenu( menu ){
      menu = profileInformationMenus.value.find( m => m == menu )
      activeMenu.value = menu == undefined || menu == null || menu == ''
        ? 'background'
        : menu

      showOfficerPenaltyPanel.value = showOfficerMedalHistoryPanel.value = showOfficerOutKrobKhanWorkPanel.value = showOfficerFreeNoSalaryPanel.value = showOfficerRankByWorkingPanel.value = showOfficerRankByCertificatePanel.value = showJobBackgroundPanel.value = showSpokenLanguagePanel.value = showChildCertificatePanel.value = showBackgroundInformationPanel.value = showAchievementsPanel.value = showOrgposPanel.value = showSalaryRangePanel.value = showProfilePanel.value = showEducationPanel.value = showBirthCertificatePanel.value = showWeddingCertificatePanel.value = showNicPanel.value = showPassportPanel.value = false

      switch( menu ){
        case 'educations' : 
          showEducationPanel.value = true 
          getCertificateLevels()
          getCertificates()
          break;
        case 'birthCertificates' : 
          showBirthCertificatePanel.value = true
          getBirthCertificates()
          break;
        case 'weddingCertificates' : 
          showWeddingCertificatePanel.value = true 
          getWeddingCertificates()
          break;
        case 'childCertificates' : 
          showChildCertificatePanel.value = true 
          getChildCertificates()
          break;
        case 'nationalityIdentityCards' : 
          showNicPanel.value = true 
          getNics()
          break;
        case 'passports' : 
          showPassportPanel.value = true 
          getPassports()
          break;
        case 'salaryrange' : 
          showSalaryRangePanel.value = true 
          break;
        case 'org_pos' : 
          showOrgposPanel.value = true 
          break;
        case 'achievements' : 
          showAchievementsPanel.value = true 
          getAchievements()
          break;
        case 'profile':
          showProfilePanel.value = true 
          break;
        case 'language' : 
          showSpokenLanguagePanel.value = true 
          getSpokenLanguage()
          break;
        case 'jobbackground' : 
          showJobBackgroundPanel.value = true 
          getOfficerJobBackgrounds()
          break;
        case 'rankbyworking' : 
          showOfficerRankByWorkingPanel.value = true 
          getOfficerRankByWorkings()
          getRanks()
          break;
        case 'rankbycertificate' : 
          showOfficerRankByCertificatePanel.value = true 
          getOfficerRankByCertificates()
          getRanks()
          break;
        case 'officeroutkrobkhan' : 
          showOfficerOutKrobKhanWorkPanel.value = true 
          getOfficerOutKrobKhan()
          break;
        case 'freenosalary' : 
          showOfficerFreeNoSalaryPanel.value = true 
          getOfficerFreeNoSalary()
          break;
        case 'officermedalhistory' : 
          showOfficerMedalHistoryPanel.value = true 
          getOfficerMedalHistory()
          break;
        case 'officerpaneltyhistory' : 
            showOfficerPenaltyPanel.value = true 
            getOfficerPenalty()
          break;
        default: 
          showBackgroundInformationPanel.value = true
          break;
      }
    }

    // function getProvinces(){
    //   store.dispatch( 'province/list' ).then( res => {
    //     store.commit('province/setAllRecords',res.data.records)
    //   }).catch( err => {
    //     console.log( err )
    //   })
    // }

    function getCertificates(){
      store.dispatch('certificate/list',{
        search : '' ,
        page: 1 , 
        perPage : 100 ,
        people_id: props.record.people_id
      }).then( res => {
          store.commit( 'certificate/setRecords', res.data.records )
      }).catch( err => {
          console.log( err )
      })
    }
    function getSpokenLanguage(){
      store.dispatch('spokenlanguage/list',{
        search : '' ,
        page: 1 , 
        perPage : 100 ,
        people_id: props.record.people_id
      }).then( res => {
          store.commit( 'spokenlanguage/setRecords', res.data.records )
      }).catch( err => {
          console.log( err )
      })
    }
    function getCertificateLevels(){
        store.dispatch( 'certificate/group' ).then( res => {
          store.commit( 'certificate/setGroups', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getBirthCertificates(){
        store.dispatch('birthcertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          people_id: props.record.people_id ,
          wedding_certificate_id : 0 
        }).then( res => {
            store.commit( 'birthcertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerJobBackgrounds(){
        store.dispatch('officerjobbackground/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officerjobbackground/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getAchievements(){
        store.dispatch('archeivement/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'archeivement/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerRankByWorkings(){
        store.dispatch('officerrankbyworking/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officerrankbyworking/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerRankByCertificates(){
        store.dispatch('officerrankbycertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officerrankbycertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerFreeNoSalary(){
        store.dispatch('officerpendingwork/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id ,
          type: 1 // 0 : Change Krobkhan , 1 : No salary
        }).then( res => {
            store.commit( 'officerpendingwork/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    } 
    
    function getOfficerMedalHistory(){
        store.dispatch('officermedalhistory/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officermedalhistory/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    } 

    function getOfficerPenalty(){
      store.dispatch('officerpenaltyhistory/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officerpenaltyhistory/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerOutKrobKhan(){
        store.dispatch('officerpendingwork/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id ,
          type: 0 // 0 : Change Krobkhan , 1 : No salary
        }).then( res => {
            store.commit( 'officerpendingwork/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }    
  
    function getRanks(){
      store.dispatch('rank/list',{
          search : '' ,
          page: 1 , 
          perPage : 100
        }).then( res => {
            store.commit( 'rank/setAllRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getOfficerRankByCertificates(){
        store.dispatch('officerrankbycertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          officer_id: props.record.id
        }).then( res => {
            store.commit( 'officerrankbycertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }

    function getWeddingCertificates(){
        store.dispatch('weddingcertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          people_id: props.record.people_id
        }).then( res => {
            store.commit( 'weddingcertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }
    function getChildCertificates(){
        store.dispatch('childcertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          people_id: props.record.people_id ,
          id: props.record.id 
        }).then( res => {
            store.commit( 'childcertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }
    function getNics(){
        store.dispatch('niccertificate/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          people_id: props.record.people.id
        }).then( res => {
            store.commit( 'niccertificate/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }
    function getPassports(){
        store.dispatch('passport/list',{
          search : '' ,
          page: 1 , 
          perPage : 100 ,
          people_id: props.record.people_id
        }).then( res => {
            store.commit( 'passport/setRecords', res.data.records )
        }).catch( err => {
            console.log( err )
        })
    }
    

    function initial(){
      // selectedOrganizations.value = [463]
      setActiveMenu()
      // getProvinces()
    }

    return {
      /**
       * Variables
       */
      rules ,
      organizations ,
      positions ,
      /**
       * Functions
       */
      initial ,
      clearRecord ,
      maskOrEscClick  ,
      ocmLogoUrl ,
      dateFormat ,
      /**
       * Menu selection
       */
      setActiveMenu ,
      activeMenu ,
      /**
       * Panel toggler
       */
      showBackgroundInformationPanel ,
      showProfilePanel ,
      showEducationPanel ,
      showBirthCertificatePanel ,
      showWeddingCertificatePanel ,
      showChildCertificatePanel ,
      showNicPanel ,
      showPassportPanel ,
      showSalaryRangePanel ,
      showOrgposPanel ,
      showAchievementsPanel ,
      showSpokenLanguagePanel ,
      showJobBackgroundPanel ,
      showOfficerRankByCertificatePanel ,
      showOfficerRankByWorkingPanel ,
      showOfficerFreeNoSalaryPanel ,
      showOfficerOutKrobKhanWorkPanel ,
      showOfficerMedalHistoryPanel ,
      showOfficerPenaltyPanel
    }
  }
}
</script>
<style scoped >
  .n-card, .n-modal {
    @apply bg-transparent;
  }
</style>