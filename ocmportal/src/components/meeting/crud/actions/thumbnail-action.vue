<template>
  <div class="actions z-40" >
    <Transition name="slide-fade" >
      <div v-if="show" class="panel" >
        <!-- <n-tooltip trigger="hover">
          <template #trigger>
            <svg class="action text-red-500" @click="showPdfModal(record)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
          </template>
          ឯកសារយោង
        </n-tooltip> -->
        <!-- <n-tooltip trigger="hover">
          <template #trigger>
            <svg class="action text-blue-500" @click="showPictureModal(record)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><rect x="48" y="80" width="416" height="352" rx="48" ry="48" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect><circle cx="336" cy="176" r="32" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></circle><path d="M304 335.79l-90.66-90.49a32 32 0 0 0-43.87-1.3L48 352" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M224 432l123.34-123.34a32 32 0 0 1 43.11-2L464 368" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg>
          </template>
          រូបតំណាង
        </n-tooltip> -->
        <!-- <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showReportModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M22 27.18l-2.59-2.59L18 26l4 4l8-8l-1.41-1.41L22 27.18z" fill="currentColor"></path><path d="M15 28H8V4h8v6a2.006 2.006 0 0 0 2 2h6v6h2v-8a.91.91 0 0 0-.3-.7l-7-7A.909.909 0 0 0 18 2H8a2.006 2.006 0 0 0-2 2v24a2.006 2.006 0 0 0 2 2h7zm3-23.6l5.6 5.6H18z" fill="currentColor"></path></svg>
              <div class="action-label" >របក.សរុបអង្គប្រជុំ</div>
            </div>
          </template>
          របាយការណ៍សរុបអង្គប្រជុំ
        </n-tooltip> -->
        <!-- <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showTechReportModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M336 264.13V436c0 24.3-19.05 44-42.95 44H107c-23.95 0-43-19.7-43-44V172a44.26 44.26 0 0 1 44-44h94.12a24.55 24.55 0 0 1 17.49 7.36l109.15 111a25.4 25.4 0 0 1 7.24 17.77z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><path d="M200 128v108a28.34 28.34 0 0 0 28 28h108" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M176 128V76a44.26 44.26 0 0 1 44-44h94a24.83 24.83 0 0 1 17.61 7.36l109.15 111A25.09 25.09 0 0 1 448 168v172c0 24.3-19.05 44-42.95 44H344" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><path d="M312 32v108a28.34 28.34 0 0 0 28 28h108" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg>
              <div class="action-label" >របក.បច្ចេកទេស</div>
            </div>
          </template>
          របាយការណ៍បច្ចេកទេស
        </n-tooltip> -->
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-red-500" @click="showOthersDocumentModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path data-v-dbedf028="" d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v1.25c0 .41-.34.75-.75.75s-.75-.34-.75-.75V8c0-.55.45-1 1-1H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2c-.28 0-.5-.22-.5-.5v-5c0-.28.22-.5.5-.5h2c.83 0 1.5.67 1.5 1.5v3zm4-3.75c0 .41-.34.75-.75.75H19v1h.75c.41 0 .75.34.75.75s-.34.75-.75.75H19v1.25c0 .41-.34.75-.75.75s-.75-.34-.75-.75V8c0-.55.45-1 1-1h1.25c.41 0 .75.34.75.75zM9 9.5h1v-1H9v1zM3 6c-.55 0-1 .45-1 1v13c0 1.1.9 2 2 2h13c.55 0 1-.45 1-1s-.45-1-1-1H5c-.55 0-1-.45-1-1V7c0-.55-.45-1-1-1zm11 5.5h1v-3h-1v3z" fill="currentColor"></path></svg>
              <div class="action-label" >ឯកសារយោងផ្សេងទៀត</div>
            </div>
          </template>
          ឯកសារយោងផ្សេងទៀត
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showPrengModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M8.75 11.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5zm0 2.75a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5zm0 2.75a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5zm4.835-14.414l5.829 5.828A2 2 0 0 1 20 9.828V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h6.172c.028 0 .055.004.082.007c.02.003.04.006.059.007c.215.015.427.056.624.138c.057.024.112.056.166.087l.05.029l.047.024a.652.652 0 0 1 .081.044c.078.053.148.116.219.18a.63.63 0 0 0 .036.03a.491.491 0 0 1 .049.04zM18 20.5a.5.5 0 0 0 .5-.5V10H14a2 2 0 0 1-2-2V3.5H6a.5.5 0 0 0-.5.5v16a.5.5 0 0 0 .5.5h12zm-.622-12L13.5 4.621V8a.5.5 0 0 0 .5.5h3.378z" fill="currentColor"></path></g></svg>
              <div class="action-label" >សេចក្ដីព្រាង</div>
            </div>
          </template>
          សេចក្ដីព្រាង
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-red-500" @click="showMinisterPrengModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
              <div class="action-label" >សេចក្ដីព្រាងរដ្ឋមន្ត្រី</div>
            </div>
          </template>
          សេចក្ដីព្រាងរដ្ឋមន្ត្រី
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-red-500" @click="showRegulatorModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
              <div class="action-label" >ឯកសារគតិយុត្ត</div>
            </div>
          </template>
          ឯកសារគតិយុត្ត
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showMemberModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M8.75 3.75a2.75 2.75 0 1 0-5.5 0a2.75 2.75 0 0 0 5.5 0zm-4.5 0a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0zM2.5 7.5h4.183c-.164.31-.286.646-.358 1H2.5A.5.5 0 0 0 2 9v.5c0 1.26 1.099 2.614 3.096 2.93c-.322.22-.59.513-.781.854C2.205 12.713 1 11.087 1 9.5V9a1.5 1.5 0 0 1 1.5-1.5zm5.379 0c.504-.61 1.267-1 2.121-1a2.744 2.744 0 0 1 2.646 2a2.753 2.753 0 0 1-3.893 3.202A2.75 2.75 0 0 1 7.88 7.5zm.54 1a1.75 1.75 0 1 0 3.164 1.5a1.75 1.75 0 0 0-3.165-1.5zm7.266 4.784a2.513 2.513 0 0 0-.781-.853C16.9 12.114 18 10.759 18 9.5V9a.5.5 0 0 0-.5-.5h-3.825a3.726 3.726 0 0 0-.357-1H17.5A1.5 1.5 0 0 1 19 9v.5c0 1.587-1.206 3.212-3.315 3.784zm-1.198.087c-.264-.231-.609-.371-.987-.371h-7A1.496 1.496 0 0 0 5 14.5v.5c0 1.971 1.86 4 5 4c3.14 0 5-2.029 5-4v-.5c0-.45-.198-.854-.513-1.13zM6 14.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v.5c0 1.438-1.432 3-4 3s-4-1.562-4-3v-.5zM14 1a2.75 2.75 0 1 1 0 5.5A2.75 2.75 0 0 1 14 1zm0 1a1.75 1.75 0 1 0 0 3.5A1.75 1.75 0 0 0 14 2z" fill="currentColor"></path></g></svg>
              <div class="action-label" >សមាសភាពប្រជុំ</div>
            </div>  
          </template>
          សមាសភាព
        </n-tooltip>
        <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showRoomModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M18 13c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1l1.27.67c.33.18.73-.06.73-.44v-2.46c0-.38-.4-.62-.73-.44L18 14v-1zm-7.2-9.1l-6 4.5c-.5.38-.8.97-.8 1.6v9c0 1.1.9 2 2 2h13c.55 0 1-.45 1-1s-.45-1-1-1H6v-9l6-4.5l6 4.5v1h2v-1c0-.63-.3-1.22-.8-1.6l-6-4.5a2.01 2.01 0 0 0-2.4 0z" fill="currentColor"></path></svg>
              <div class="action-label" >បន្ទប់ប្រជុំ</div>
            </div>  
          </template>
          បន្ទប់ប្រជុំ
        </n-tooltip>
        <!-- <n-tooltip trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500" @click="showDetailModal(record)" 
              xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="40" d="M196 220h64v172"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="40" d="M187 396h138"></path><path d="M256 160a32 32 0 1 1 32-32a32 32 0 0 1-32 32z" fill="currentColor"></path></svg>
              <div class="action-label" >ព័ត៌មានលម្អិត</div>
            </div>
          </template>
          ព័ត៌មានលម្អិត
        </n-tooltip> -->
        <n-tooltip v-if="$hasPermission('portal_meeting_creating')" trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-blue-500 " @click="showEditModal(record)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M4 15h5.986c-.227.3-.4.639-.51 1H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5.232c-.326.14-.631.343-.897.609L15 9.944V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1zm8-9.5a.5.5 0 0 1 1 0v6.444l-.88.88A.498.498 0 0 1 12 12.5v-7zm-7 2a.5.5 0 0 1 1 0v5a.5.5 0 0 1-1 0v-5zM9 9a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 1 0v-3A.5.5 0 0 0 9 9zm1.98 6.377l4.83-4.83a1.87 1.87 0 1 1 2.645 2.646l-4.83 4.829a2.197 2.197 0 0 1-1.02.578l-1.498.374a.89.89 0 0 1-1.079-1.078l.375-1.498c.096-.386.296-.74.578-1.02z" fill="currentColor"></path></g></svg>
              <div class="action-label" >កែប្រែ</div>
            </div>
          </template>
          កែប្រែ
        </n-tooltip>
        <n-tooltip v-if="$hasPermission('portal_meeting_publishing')" trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg :class="'action ' + ( parseInt( record.active ) == 1 ? ' text-green-500 ' : ' text-gray-500 ') " @click="toggleActive(record)" :title="record.active == 1 ? 'គណនីនេះកំពុងបើកតំណើរការ' : 'គណនីនេះកំពុងត្រូវបានបិទមិនអាចប្រើប្រាស់បាន' "  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8zm3.88-11.71L10 14.17l-1.88-1.88a.996.996 0 1 0-1.41 1.41l2.59 2.59c.39.39 1.02.39 1.41 0L17.3 9.7a.996.996 0 0 0 0-1.41c-.39-.39-1.03-.39-1.42 0z" fill="currentColor"></path></svg>
              <div class="action-label" >បិទ/បើក</div>
            </div>
          </template>
          បិទ និង បើក ព័ត៌មាន
        </n-tooltip>  
        <n-tooltip v-if="$hasPermission('portal_meeting_deleting') && user!=null && user!=undefined && user.id == record.created_by" trigger="hover">
          <template #trigger>
            <div class="action-board" >
              <svg class="action text-red-500" @click="deleteAccount(record)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 112h352" fill="currentColor"></path><path d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M184 176l8 224"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M328 176l-8 224"></path></svg>              
              <div class="action-label" >លុបគណនី</div>
            </div>
          </template>
          លុប
        </n-tooltip>
      </div>
    </Transition>
    <n-tooltip v-if="show" trigger="hover">
      <template #trigger>
        <div class="action-toggle bg-blue-500 text-gray-50" @click="toggleActions" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M8.12 14.71L12 10.83l3.88 3.88a.996.996 0 1 0 1.41-1.41L12.7 8.71a.996.996 0 0 0-1.41 0L6.7 13.3a.996.996 0 0 0 0 1.41c.39.38 1.03.39 1.42 0z" fill="currentColor"></path></svg>
        </div>
      </template>
      បិទមុខងារផ្សេងៗ
    </n-tooltip>
    <n-tooltip v-if="!show" trigger="hover">
      <template #trigger>
        <div class="action-toggle bg-gray-200 hover:bg-blue-500 duration-500 hover:text-gray-50" @click="toggleActions" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M8.12 9.29L12 13.17l3.88-3.88a.996.996 0 1 1 1.41 1.41l-4.59 4.59a.996.996 0 0 1-1.41 0L6.7 10.7a.996.996 0 0 1 0-1.41c.39-.38 1.03-.39 1.42 0z" fill="currentColor"></path></svg>
        </div>
      </template>
      មុខងារផ្សេងៗ
    </n-tooltip>
    <n-tooltip v-if="!show" trigger="hover">
      <template #trigger>
        <div :class=" 'record-active ' + ( parseInt( record.active ) == 1 ? ' text-green-500 ' : ' text-gray-500 ') " @click="toggleActions" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M699 353h-46.9c-10.2 0-19.9 4.9-25.9 13.3L469 584.3l-71.2-98.8c-6-8.3-15.6-13.3-25.9-13.3H325c-6.5 0-10.3 7.4-6.5 12.7l124.6 172.8a31.8 31.8 0 0 0 51.7 0l210.6-292c3.9-5.3.1-12.7-6.4-12.7z" fill="currentColor"></path><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"></path></svg>
        </div>
      </template>
      ស្ថានភាពព័ត៌មាន ៖ {{ ( parseInt( record.active ) == 1 ? ' កំពុងប្រើប្រាស់ ' : ' បិទការប្រើប្រាស់ ') }}
    </n-tooltip>
    <n-tooltip v-if="!show && record.summary != undefined && record.summary != null && record.summary.length > 0" trigger="hover">
      <template #trigger>
        <div class="record-summary text-blue-500" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g data-v-dbedf028="" fill="none"><path data-v-dbedf028="" d="M8 10.25a.75.75 0 0 1 .75-.75h10a.75.75 0 0 1 0 1.5h-10a.75.75 0 0 1-.75-.75zm0 4.5a.75.75 0 0 1 .75-.75h10a.75.75 0 0 1 0 1.5h-10a.75.75 0 0 1-.75-.75zm.75 3.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5zM14 2a.75.75 0 0 1 .75.75V4h3.75V2.75a.75.75 0 0 1 1.5 0V4h.75A2.25 2.25 0 0 1 23 6.25v12.996a.75.75 0 0 1-.22.53l-5.504 5.504a.75.75 0 0 1-.53.22H6.75a2.25 2.25 0 0 1-2.25-2.25v-17A2.25 2.25 0 0 1 6.75 4H8V2.75a.75.75 0 0 1 1.5 0V4h3.75V2.75A.75.75 0 0 1 14 2zM6 6.25v17c0 .414.336.75.75.75h9.246v-3.254a2.25 2.25 0 0 1 2.25-2.25H21.5V6.25a.75.75 0 0 0-.75-.75h-14a.75.75 0 0 0-.75.75zm12.246 13.746a.75.75 0 0 0-.75.75v2.193l2.943-2.943h-2.193z" fill="currentColor"></path></g></svg>
        </div>
      </template>
      {{ record.summary }}
    </n-tooltip>
    <n-tooltip v-if="!show && record.pdf == true" trigger="hover">
      <template #trigger>
        <div class="record-pdf text-red-500 " @click="showPdfPreviewModal" >
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>
        </div>
      </template>
      ឯកសារយោង
    </n-tooltip>
    <n-tooltip v-if="!show" trigger="hover">
      <template #trigger>
        <div :class=" ' record-status text-xxs font-bold ' + ( statuses.find( s => s.value == record.status ).color ) " >
          {{ statuses.find( s => s.value == record.status ).label }}
        </div>
      </template>
      ស្ថានភាពប្រជុំ
    </n-tooltip>
    <!-- Form update account -->
    <update-form v-bind:model="model" v-bind:record="record" v-bind:show="editModal.show" :onClose="closeUpdate"/>
    <!-- Form update account -->
    <detail-form v-bind:model="model" v-bind:record="record" v-bind:show="detailModal.show" :onClose="closeDetail"/>
    <!-- Form upload picture -->
    <picture-form v-bind:model="model" v-bind:record="record" v-bind:show="pictureModal.show" :onClose="closePicture"/>
    <!-- Form upload pdf -->
    <pdf-form v-bind:model="model" v-bind:record="record" v-bind:show="pdfModal.show" :onClose="closePdf"/>
    <!-- Form upload pdf -->
    <pdf-preview-form v-bind:model="model" v-bind:record="record" v-bind:show="pdfPreviewModal.show" :onClose="closePdfPreview"/>
    <!-- Form regulator -->
    <regulator-form v-bind:model="model" v-bind:record="record" v-bind:show="regulatorModal.show" :onClose="closeRegulator"/>
    <!-- Form preng -->
    <preng-form v-bind:model="model" v-bind:record="record" v-bind:show="prengModal.show" :onClose="closePreng"/>
    <!-- Form minister preng -->
    <minister-preng-form v-bind:model="model" v-bind:record="record" v-bind:show="ministerPrengModal.show" :onClose="closeMinisterPreng"/>
    <!-- Form others document -->
    <others-document-form v-bind:model="model" v-bind:record="record" v-bind:show="othersDocumentModal.show" :onClose="closeOthersDocument"/>
    <!-- Form others document -->
    <report-form v-bind:model="model" v-bind:record="record" v-bind:show="reportModal.show" :onClose="closeReport"/>
    <!-- Form others document -->
    <tech-report-form v-bind:model="model" v-bind:record="record" v-bind:show="techReportModal.show" :onClose="closeTechReport"/>
    <!-- Form member account -->
    <member-form v-bind:model="model" v-bind:record="record" v-bind:show="memberModal.show" :onClose="closeMember"/>
    <!-- Form room -->
    <room-form v-bind:model="model" v-bind:record="record" v-bind:show="roomModal.show" :onClose="closeRoom"/>
  </div>
</template>
<script>
import { reactive ,ref } from 'vue'
import { useStore } from 'vuex'
import { useDialog, useMessage, useNotification } from 'naive-ui'
import UpdateForm from './../widgets/update.vue'
import DetailForm from './../widgets/detail.vue'
import PictureForm from './../widgets/picture.vue'
import PdfForm from './../widgets/pdf.vue'
import MemberForm from './../widgets/member.vue'
import RegulatorForm from './../widgets/regulator.vue'
import PrengForm from './../widgets/preng.vue'
import MinisterPrengForm from './../widgets/ministerpreng.vue'
import OthersDocumentForm from './../widgets/othersdocument.vue'
import PdfPreviewForm from './../widgets/pdfpreview.vue'
import ReportForm from './../widgets/report.vue'
import TechReportForm from './../widgets/techreport.vue'
import RoomForm from './../widgets/room.vue'
import { getUser } from '@plugins/authentication'
/**
 * CRUD component form
 */
export default {
  name: "ThumbnailActions" ,
  components: {
    UpdateForm ,
    DetailForm ,
    MemberForm ,
    RegulatorForm ,
    PictureForm ,
    PdfForm ,
    PdfPreviewForm ,
    PrengForm ,
    MinisterPrengForm ,
    OthersDocumentForm ,
    ReportForm ,
    TechReportForm ,
    RoomForm
  } ,
  props: {
    crud: {
      required: true ,
      type: Object
    },
    model: {
      required: true ,
      type: Object
    },
    record: {
      required: true ,
      type: Object ,
    },
    onClose: {
      required: true ,
      type: Function
    }
  },
  setup(props){
    var store = useStore()
    const dialog = useDialog()
    const message = useMessage()
    const notify = useNotification()
    
    const user = ref( getUser() )

    const statuses = reactive([
      {
        label: 'ទាំងអស់' ,
        value : null ,
        color: 'text-gray-200'
      },
      {
        label: 'មិនទាន់ប្រជុំ' ,
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

    const show = ref(false)
    function toggleActions( actionStatus ){
      show.value = !show.value
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closeDetail(actionStatus){
      detailModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closeRegulator( actionStatus ){
      regulatorModal.show = false 
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closePicture(actionStatus){
      pictureModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closePdf(actionStatus){
      pdfModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closePdfPreview(actionStatus){
      pdfPreviewModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closeUpdate(actionStatus){
      editModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closeMember(actionStatus){
      memberModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function closeActions(actionStatus){
      show.value = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function toggleActive(record){
      show.value = false
      props.crud.toggleActive
      store.dispatch( props.model.name+'/toggleActive',{
        id: record.id
      }).then( res => {
        if( res.data.ok ){
          notify.success({
            title: 'ស្ថានភាពគណនី' ,
            description: 'ស្ថានភាពគណនីបានកែប្រែជោគជ័យ។' ,
            duration: 3000
          })
          closeActions( 1 )
        }else{
          notify.error({
            title: 'ស្ថានភាពគណនី' ,
            description: 'មានបញ្ហាក្នុងពេលកែប្រែស្ថានភាពគណនី។' ,
            duration: 3000
          })
        }
      }).catch( err => {
        message.error( err )
      })
      closeActions( 0 )
    }

    var editRecord = reactive({
      id: 0 ,
      name: "" ,
      desp: "" ,
      pid: 0 ,
      tpid: "" ,
      active: 0 ,
      image: null ,
      model: null ,
      pdf: null
    })
    var editModal = reactive({show:false})
    function showEditModal(record){
      editModal.show = true
      show.value = false
    }

    var detailModal = reactive({show:false})
    function showDetailModal(record){
      detailModal.show = true
      show.value = false
    }

    var pictureModal = reactive({show:false})
    function showPictureModal(record){
      pictureModal.show = true
      show.value = false
    }

    var pdfModal = reactive({show:false})
    function showPdfModal(record){
      pdfModal.show = true
      show.value = false
    }

    var pdfPreviewModal = reactive({show:false})
    function showPdfPreviewModal(record){
      pdfPreviewModal.show = true
      show.value = false
    }

    var memberModal = reactive({show:false})
    function showMemberModal(record){
      memberModal.show = true
      show.value = false
    }

    var regulatorModal = reactive({show:false})
    function showRegulatorModal(record){
      regulatorModal.show = true
      show.value = false
    }

    var prengModal = reactive({show:false})
    function showPrengModal(record){
      prengModal.show = true
      show.value = false
    }

    function closePreng(actionStatus){
      prengModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    var ministerPrengModal = reactive({show:false})
    function showMinisterPrengModal(record){
      ministerPrengModal.show = true
      show.value = false
    }

    function closeMinisterPreng(actionStatus){
      ministerPrengModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    var othersDocumentModal = reactive({show:false})
    function showOthersDocumentModal(record){
      othersDocumentModal.show = true
      show.value = false
    }

    function closeOthersDocument(actionStatus){
      othersDocumentModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    var reportModal = reactive({show:false})
    function showReportModal(record){
      reportModal.show = true
      show.value = false
    }

    function closeReport(actionStatus){
      reportModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    var techReportModal = reactive({show:false})
    function showTechReportModal(record){
      techReportModal.show = true
      show.value = false
    }

    function closeTechReport(actionStatus){
      techReportModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    var roomModal = reactive({show:false})
    function showRoomModal(record){
      roomModal.show = true
      show.value = false
    }

    function closeRoom(actionStatus){
      roomModal.show = false
      if( parseInt( actionStatus ) > 0 ) props.onClose( actionStatus )
    }

    function deleteAccount(record){
      show.value = false
      dialog.warning({
        title: "លុបគណនី" ,
        content: "តើអ្នកចង់ លុប គណនីនេះមែនទេ ?" ,
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          store.dispatch(props.model.name+'/delete',{id:record.id}).then( res => {
            if( res.data.ok ){
              notify.success({
                title: 'លុបទិន្នន័យ' ,
                description: 'លុបបានរួចរាល់។' ,
                duration: 3000
              })
              closeActions(1)
            }else{
              notify.success({
                title: 'លុបទិន្នន័យ' ,
                description: 'មានបញ្ហាក្នុងពេលលុបទិន្នន័យ។' ,
                duration: 3000
              })
            }
          }).catch( err => {
            message.error( err )
          })
          closeActions( 0 )
        },
        onNegativeClick: () => {
        }
      })
    }

    return {
      /**
       * Variables
       */
      /**
       * Editing
       */
      editModal ,
      showEditModal ,
      editRecord ,
      closeUpdate ,
      /**
       * Detail modal
       */
      showDetailModal ,
      detailModal ,
      closeDetail ,
      /**
       * Picture modal
       */
      showPictureModal ,
      pictureModal ,
      closePicture ,
      /**
       * Pdf modal
       */
      showPdfModal ,
      pdfModal ,
      closePdf ,
      /**
       * Pdf Preview modal
       */
      showPdfPreviewModal ,
      pdfPreviewModal ,
      closePdfPreview ,
      /**
       * Member modal
       */
      showMemberModal ,
      memberModal ,
      closeMember ,
      /**
       * Regulator modal
       */
      showRegulatorModal ,
      regulatorModal ,
      closeRegulator ,
      /**
       * Preng
       */
      prengModal ,
      showPrengModal ,
      closePreng ,
      /**
       * Minister Preng
       */
      ministerPrengModal ,
      showMinisterPrengModal ,
      closeMinisterPreng ,
      /**
       * Other documents
       */
      othersDocumentModal ,
      showOthersDocumentModal ,
      closeOthersDocument ,
      /**
       * Report
       */
      reportModal ,
      showReportModal ,
      closeReport ,
      /**
       * Tech Report
       */
      techReportModal ,
      showTechReportModal ,
      closeTechReport ,
      /**
       * Room
       */
      roomModal ,
      showRoomModal ,
      closeRoom ,
      /**
       * Functions
       */
      toggleActive ,
      deleteAccount ,
      toggleActions ,
      show ,
      closeActions ,
      // Meeting status
      statuses ,
      user
    }
  }
}

</script>
<style type="text/css" scoped >
.actions {
  @apply flex flex-wrap justify-center absolute left-0 top-0 right-0 bottom-0;
}
.actions .action-toggle {
  @apply absolute top-1 right-1 w-6 h-6 p-1 rounded-full cursor-pointer ;
}
.actions .record-active {
  @apply absolute bottom-1 left-1 w-6 h-6 cursor-pointer ;
}
.actions .record-status {
  @apply absolute bottom-0 right-0 p-2 px-4 rounded-tl-md cursor-pointer bg-gray-100 shadow-inner;
}
.actions .record-summary {
  @apply absolute bottom-1 left-9 w-6 h-6 cursor-pointer ;
}
 .actions .record-pdf {
  @apply absolute bottom-1 left-9 w-6 h-6 cursor-pointer ;
}
 .actions .panel {
  @apply bg-white bg-opacity-90 absolute w-full top-0 bottom-0 border-gray-200 flex flex-wrap justify-center items-center p-4 rounded-lg;
}
 .actions .action-board {
  @apply m-2;
}
 .actions .action-board .action {
  @apply cursor-pointer w-7 mb-1 mx-auto p-1 bg-white border border-gray-300 rounded-full hover:scale-125 transform-gpu duration-300 ;
}
 .actions .action-board .action-label {
  font-size: 0.5rem;
}
</style>