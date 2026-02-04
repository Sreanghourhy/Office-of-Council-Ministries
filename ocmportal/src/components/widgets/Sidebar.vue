<template>
  <div class="relative flex flex-wrap content-center z-50 " >
    <!-- Start transaction of the apps -->
        <!-- Apps -->
        <Transition  name="slide-fade" >
          <div v-if="true" class="fixed top-12 bg-white bottom-0 left-0 w-40 z-40 flex flex-wrap content-start bg-opacity-95 shadow-md">
              <!-- Search -->
              <!-- <div class='absolute top-0 left-0 right-0 flex flex-wrap content-center w-2/5 py-4 m-auto md:w-2/5 xl:w-1/5 lg:w-1/5 ' >
                  <n-input 
                    suffix="ios-search" 
                    placeholder="Search ..." 
                    clearable 
                    v-model:value="search" 
                    @keyup="filterApps()"  
                  >
                    <template #prefix>
                      <svg class="w-4 h-4 text-gray-400 " 
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M29 27.586l-7.552-7.552a11.018 11.018 0 1 0-1.414 1.414L27.586 29zM4 13a9 9 0 1 1 9 9a9.01 9.01 0 0 1-9-9z" fill="currentColor"></path></svg>
                    </template>
                  </n-input>
              </div> -->
              <!-- End search -->
              <!-- Apps -->
              <div class="sidebar">
                <div v-for="(app, index) in matchedApps" :key="index" class="sidebar-item">
                  <div v-if="$hasPermission(app.permissions)" class='item-content ' @click="$router.push(app.url)"  >
                    <div class="item-icon " v-html="app.svg" ></div>
                    <div class="item-label font-btb text-xs font-btb-black" v-html="app.name" ></div>
                    <svg class="absolute right-2 h-4 w-2 mt-1  text-gray-500 " 
                    v-if="app.children != undefined && app.children.length > 0"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M7.38 21.01c.49.49 1.28.49 1.77 0l8.31-8.31a.996.996 0 0 0 0-1.41L9.15 2.98c-.49-.49-1.28-.49-1.77 0s-.49 1.28 0 1.77L14.62 12l-7.25 7.25c-.48.48-.48 1.28.01 1.76z" fill="currentColor"></path></svg>
                  </div>
                  <!-- children -->
                  <div class="sidebar-children" >
                    <div class="sidebar-children-item" v-for="(childApp , cIndex ) in app.children" :key="cIndex" >
                      <div v-if="$hasPermission(childApp.permissions)"  class='child-item-content ' @click="$router.push(childApp.url)"  >
                        <div class="child-item-icon " v-html="childApp.svg" ></div>
                        <div class="child-item-label font-btb text-xs font-btb-black" v-html="childApp.name" ></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div @click="logout()" class="sidebar-item">
                  <div class='item-content ' >
                    <div class="item-icon " >
                      <svg class="text-red-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
                    </div>
                    <div class="item-label font-btb text-xs font-btb-black " >ចេញ</div>
                  </div>
                </div>
                <!-- <div class="py-4 px-8 duration-300 transform hover:scale-110 text-center p-2 m-4  cursor-pointer hover:bg-gray-50 hover:bg-opacity-10 rounded-lg">
                    <div @click="logout()" class='w-full dashboard-widget-link' >
                      <div class="text-gray-100 w-16 mx-auto my-2 " >
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M10.5 2.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zM13.743 4a.5.5 0 1 0-.499.867a6.5 6.5 0 1 1-6.494.004a.5.5 0 1 0-.5-.866A7.5 7.5 0 1 0 13.743 4z" fill="currentColor"></path></g></svg>
                      </div>
                      <div class="font-pvh p-2 m-auto text-xs text-center text-gray-100" >ចេញ</div>
                    </div>
                </div> -->
                <div class="absolute left-0 right-0 bottom-0 bg-red-400" >
                  <Footer />
                </div>
              </div>
              <!-- End apps -->
          </div>
        </Transition>
    <!-- End transaction of the apps -->
  </div>
</template>

<script>
import { reactive, ref , computed, onMounted } from 'vue'
import { isAuth, authLogout , isAdmin , getUser } from '../../plugins/authentication'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { useDialog , useMessage } from 'naive-ui'
import Footer from '@components/footer/copy-right-sidebar.vue'
export default {  
  components: {
    Footer
  } ,
  name: 'dock' ,
  props: {
    show : false ,
    showLuncher: false ,
    close: {
      type: Function
    } ,
  },
  setup(props){
    
    let search = ref(null)
    let apps = ref([
    {
          url: '/welcome' ,
          icon: 'SpeedometerOutline' ,
          svg: '<svg class="text-blue-500 w-6 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 640 512"><path d="M272 191.91c-17.6 0-32 14.4-32 32v80c0 8.84-7.16 16-16 16s-16-7.16-16-16v-76.55c0-17.39 4.72-34.47 13.69-49.39l77.75-129.59c9.09-15.16 4.19-34.81-10.97-43.91c-14.45-8.67-32.72-4.3-42.3 9.21c-.2.23-.62.21-.79.48l-117.26 175.9C117.56 205.9 112 224.31 112 243.29v80.23l-90.12 30.04A31.974 31.974 0 0 0 0 383.91v96c0 10.82 8.52 32 32 32c2.69 0 5.41-.34 8.06-1.03l179.19-46.62C269.16 449.99 304 403.8 304 351.91v-128c0-17.6-14.4-32-32-32zm346.12 161.73L528 323.6v-80.23c0-18.98-5.56-37.39-16.12-53.23L394.62 14.25c-.18-.27-.59-.24-.79-.48c-9.58-13.51-27.85-17.88-42.3-9.21c-15.16 9.09-20.06 28.75-10.97 43.91l77.75 129.59c8.97 14.92 13.69 32 13.69 49.39V304c0 8.84-7.16 16-16 16s-16-7.16-16-16v-80c0-17.6-14.4-32-32-32s-32 14.4-32 32v128c0 51.89 34.84 98.08 84.75 112.34l179.19 46.62c2.66.69 5.38 1.03 8.06 1.03c23.48 0 32-21.18 32-32v-96c0-13.77-8.81-25.99-21.88-30.35z" fill="currentColor"></path></svg>' ,
          name: 'ស្វាគមន៍',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            'portal'
          ],
      },
      {
          url: '/dashboard' ,
          icon: 'SpeedometerOutline' ,
          svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><path d="M326.1 231.9l-47.5 75.5a31 31 0 0 1-7 7a30.11 30.11 0 0 1-35-49l75.5-47.5a10.23 10.23 0 0 1 11.7 0a10.06 10.06 0 0 1 2.3 14z" fill="currentColor"></path><path d="M256 64C132.3 64 32 164.2 32 287.9a223.18 223.18 0 0 0 56.3 148.5c1.1 1.2 2.1 2.4 3.2 3.5a25.19 25.19 0 0 0 37.1-.1a173.13 173.13 0 0 1 254.8 0a25.19 25.19 0 0 0 37.1.1l3.2-3.5A223.18 223.18 0 0 0 480 287.9C480 164.2 379.7 64 256 64z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 128v32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M416 288h-32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M128 288H96"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M165.49 197.49l-22.63-22.63"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M346.51 197.49l22.63-22.63"></path></svg>' ,
          name: 'សង្ខេបព័ត៌មាន',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            'portal'
          ],
      },
      {
          url: '/regulator' ,
          icon: 'FilePdfOutlined' ,
          svg: '<svg class="text-red-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M531.3 574.4l.3-1.4c5.8-23.9 13.1-53.7 7.4-80.7c-3.8-21.3-19.5-29.6-32.9-30.2c-15.8-.7-29.9 8.3-33.4 21.4c-6.6 24-.7 56.8 10.1 98.6c-13.6 32.4-35.3 79.5-51.2 107.5c-29.6 15.3-69.3 38.9-75.2 68.7c-1.2 5.5.2 12.5 3.5 18.8c3.7 7 9.6 12.4 16.5 15c3 1.1 6.6 2 10.8 2c17.6 0 46.1-14.2 84.1-79.4c5.8-1.9 11.8-3.9 17.6-5.9c27.2-9.2 55.4-18.8 80.9-23.1c28.2 15.1 60.3 24.8 82.1 24.8c21.6 0 30.1-12.8 33.3-20.5c5.6-13.5 2.9-30.5-6.2-39.6c-13.2-13-45.3-16.4-95.3-10.2c-24.6-15-40.7-35.4-52.4-65.8zM421.6 726.3c-13.9 20.2-24.4 30.3-30.1 34.7c6.7-12.3 19.8-25.3 30.1-34.7zm87.6-235.5c5.2 8.9 4.5 35.8.5 49.4c-4.9-19.9-5.6-48.1-2.7-51.4c.8.1 1.5.7 2.2 2zm-1.6 120.5c10.7 18.5 24.2 34.4 39.1 46.2c-21.6 4.9-41.3 13-58.9 20.2c-4.2 1.7-8.3 3.4-12.3 5c13.3-24.1 24.4-51.4 32.1-71.4zm155.6 65.5c.1.2.2.5-.4.9h-.2l-.2.3c-.8.5-9 5.3-44.3-8.6c40.6-1.9 45 7.3 45.1 7.4zm191.4-388.2L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0 0 42 42h216v494z" fill="currentColor"></path></svg>' ,
          name: 'ឯកសារគតិយុត្ត',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            	'portal_regulator'
          ],
          children: [
            {
              url: '/regulator' ,
              icon: 'Search' ,
              svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="10" r="7"></circle><path d="M21 21l-6-6"></path></g></svg>' ,
              name: 'ស្វែងរក',
              roles: [
                1, // Super
                2, // Administrator
                // 3, // backend
              ],
              permissions: [
                'portal_regulator'
              ],
            },
            {
              url: '/folder' ,
              icon: 'ListChecked' ,
              svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M7.167 3c.27 0 .535.073.765.21l.135.09l1.6 1.2H15.5a2.5 2.5 0 0 1 2.479 2.174l.016.162L18 7v7.5a2.5 2.5 0 0 1-2.336 2.495L15.5 17h-11a2.5 2.5 0 0 1-2.495-2.336L2 14.5v-9a2.5 2.5 0 0 1 2.336-2.495L4.5 3h2.667zm.99 4.034a1.5 1.5 0 0 1-.933.458l-.153.008L3 7.499V14.5a1.5 1.5 0 0 0 1.356 1.493L4.5 16h11a1.5 1.5 0 0 0 1.493-1.355L17 14.5V7a1.5 1.5 0 0 0-1.355-1.493L15.5 5.5H9.617l-1.46 1.534zM7.168 4H4.5a1.5 1.5 0 0 0-1.493 1.356L3 5.5v.999l4.071.001a.5.5 0 0 0 .302-.101l.06-.054L8.694 5.02L7.467 4.1a.5.5 0 0 0-.22-.093L7.167 4z" fill="currentColor"></path></g></svg>' ,
              name: 'ថតឯកសារ',
              roles: [
                1, // Super
                2, // Administrator
                // 3, // backend
              ],
              permissions: [
                'portal_regulator_folder'
              ],
            },
            {
              url: '/regulator/favorites' ,
              icon: 'QrCode28Regular' ,
              svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M4 16V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v11a1 1 0 0 1-1 1H5a1 1 0 0 0 1 1h9.5a.5.5 0 0 1 0 1H6a2 2 0 0 1-2-2zM15 4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v11h10V4zm-4.546 1.29a.5.5 0 0 0-.907 0l-.822 1.77l-1.937.234a.5.5 0 0 0-.28.863l1.429 1.328L7.56 11.4a.5.5 0 0 0 .734.533L10 10.985l1.706.948a.5.5 0 0 0 .733-.533l-.375-1.915l1.43-1.328a.5.5 0 0 0-.281-.863l-1.937-.235l-.822-1.77zm-.94 2.443L10 6.687l.486 1.046a.5.5 0 0 0 .393.286l1.145.138l-.845.785a.5.5 0 0 0-.15.463l.222 1.131l-1.008-.56a.5.5 0 0 0-.486 0l-1.007.56l.221-1.131a.5.5 0 0 0-.15-.463l-.844-.785L9.12 8.02a.5.5 0 0 0 .394-.286z" fill="currentColor"></path></g></svg>' ,
              name: 'ឯកសារចំណូលចិត្ត',
              roles: [
                1, // Super
                2, // Administrator
                3, // backend
              ],
              permissions: [
                'portal_regulator_favorite'
              ],
            },
          ]
      },
      {
          url: '/meeting' ,
          icon: 'DeviceMeetingRoom24Regular' ,
          svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3.658 4.946A2.5 2.5 0 0 1 6.096 3h7.807a2.5 2.5 0 0 1 2.438 1.946l1.591 7A2.5 2.5 0 0 1 15.494 15H9v-1h6.494a1.5 1.5 0 0 0 1.463-1.832l-1.59-7A1.5 1.5 0 0 0 13.902 4H6.096a1.5 1.5 0 0 0-1.462 1.168L4.217 7H3.5c-.106 0-.21.007-.313.02l.471-2.074zM8.95 17h5.55a.5.5 0 0 0 0-1H9v.5c0 .171-.017.338-.05.5zM5 12a1 1 0 1 0 0-2a1 1 0 0 0 0 2zM2 9.5A1.5 1.5 0 0 1 3.5 8h3A1.5 1.5 0 0 1 8 9.5v7A1.5 1.5 0 0 1 6.5 18h-3A1.5 1.5 0 0 1 2 16.5v-7zM3.5 9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5h-3z" fill="currentColor"></path></g></svg>' ,
          name: 'កិច្ចប្រជុំ',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            'portal_meeting'
          ],
          children: [
            {
              url: '/meeting' ,
              icon: 'ListChecked' ,
              svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3.658 4.946A2.5 2.5 0 0 1 6.096 3h7.807a2.5 2.5 0 0 1 2.438 1.946l1.591 7A2.5 2.5 0 0 1 15.494 15H9v-1h6.494a1.5 1.5 0 0 0 1.463-1.832l-1.59-7A1.5 1.5 0 0 0 13.902 4H6.096a1.5 1.5 0 0 0-1.462 1.168L4.217 7H3.5c-.106 0-.21.007-.313.02l.471-2.074zM8.95 17h5.55a.5.5 0 0 0 0-1H9v.5c0 .171-.017.338-.05.5zM5 12a1 1 0 1 0 0-2a1 1 0 0 0 0 2zM2 9.5A1.5 1.5 0 0 1 3.5 8h3A1.5 1.5 0 0 1 8 9.5v7A1.5 1.5 0 0 1 6.5 18h-3A1.5 1.5 0 0 1 2 16.5v-7zM3.5 9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5h-3z" fill="currentColor"></path></g></svg>' ,
              name: 'គ្រប់គ្រប់កិច្ចប្រជុំ',
              roles: [
                1, // Super
                2, // Administrator
                3, // backend
              ],
              permissions: [
                'portal_meeting_listing'
              ],
            },
            {
              url: '/meeting/schedule' ,
              icon: 'QrCode28Regular' ,
              svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M928 224H768v-56c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v56H548v-56c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v56H328v-56c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v56H96c-17.7 0-32 14.3-32 32v576c0 17.7 14.3 32 32 32h832c17.7 0 32-14.3 32-32V256c0-17.7-14.3-32-32-32zm-40 568H136V296h120v56c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-56h148v56c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-56h148v56c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-56h120v496zM416 496H232c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zm0 136H232c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zm308.2-177.4L620.6 598.3l-52.8-73.1c-3-4.2-7.8-6.6-12.9-6.6H500c-6.5 0-10.3 7.4-6.5 12.7l114.1 158.2a15.9 15.9 0 0 0 25.8 0l165-228.7c3.8-5.3 0-12.7-6.5-12.7H737c-5-.1-9.8 2.4-12.8 6.5z" fill="currentColor"></path></svg>' ,
              name: 'កាលវិភាគប្រជុំ',
              roles: [
                1, // Super
                2, // Administrator
                3, // backend
              ],
              permissions: [
                'portal_meeting_schedule'
              ],
            },
          ]
      },
      // {
      //     url: '/user' ,
      //     icon: 'SupervisedUserCircleOutlined' ,
      //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12.5 10c0-1.65-1.35-3-3-3s-3 1.35-3 3s1.35 3 3 3s3-1.35 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1zm6.5 2c1.11 0 2-.89 2-2c0-1.11-.89-2-2-2c-1.11 0-2.01.89-2 2c0 1.11.89 2 2 2zM11.99 2.01c-5.52 0-10 4.48-10 10s4.48 10 10 10s10-4.48 10-10s-4.48-10-10-10zM5.84 17.12c.68-.54 2.27-1.11 3.66-1.11c.07 0 .15.01.23.01c.24-.64.67-1.29 1.3-1.86A9.05 9.05 0 0 0 9.5 14c-1.3 0-3.39.45-4.73 1.43c-.5-1.04-.78-2.2-.78-3.43c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.2-.27 2.34-.75 3.37c-1-.59-2.36-.87-3.24-.87c-1.52 0-4.5.81-4.5 2.7v2.78a7.935 7.935 0 0 1-5.66-2.86z" fill="currentColor"></path></svg>' ,
      //     name: 'គណនី',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       // 3, // backend
      //     ]
      // },
      // {
      //     url: '/officer' ,
      //     icon: 'ContactCard32Regular' ,
      //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><g fill="none"><path d="M18 13a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2h-6a1 1 0 0 1-1-1zm1 4a1 1 0 1 0 0 2h6a1 1 0 0 0 0-2h-6zm-6-4a2 2 0 1 1-4 0a2 2 0 0 1 4 0zm-6 4.5A1.5 1.5 0 0 1 8.5 16h5a1.5 1.5 0 0 1 1.5 1.5s0 3.5-4 3.5s-4-3.5-4-3.5zM2 7.25A3.25 3.25 0 0 1 5.25 4h21.5A3.25 3.25 0 0 1 30 7.25v17.5A3.25 3.25 0 0 1 26.75 28H5.25A3.25 3.25 0 0 1 2 24.75V7.25zM5.25 6C4.56 6 4 6.56 4 7.25v17.5c0 .69.56 1.25 1.25 1.25h21.5c.69 0 1.25-.56 1.25-1.25V7.25C28 6.56 27.44 6 26.75 6H5.25z" fill="currentColor"></path></g></svg>' ,
      //     name: 'មន្ត្រី',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       // 3, // backend
      //     ]
      // },
      // {
      //     url: '/profile' ,
      //     icon: 'UserAvatar' ,
      //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path></svg>' ,
      //     name: 'ព័ត៌មានផ្ទាល់ខ្លួន',
      //     roles: [
      //       // 1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ]
      // },
      {
          url: '/hr/officer' ,
          icon: 'PeopleTeam16Regular' ,
          svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M6.002 4a1.998 1.998 0 1 1 3.996 0a1.998 1.998 0 0 1-3.996 0zM8 3.002a.998.998 0 1 0 0 1.996a.998.998 0 0 0 0-1.996zM11 4.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm1.5-.5a.5.5 0 1 0 0 1a.5.5 0 0 0 0-1zm-9-1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zM3 4.5a.5.5 0 1 1 1 0a.5.5 0 0 1-1 0zM4.268 7A1.99 1.99 0 0 0 4 8H2v2.5a1.5 1.5 0 0 0 2.096 1.377c.074.331.19.647.34.942A2.5 2.5 0 0 1 1 10.5V8a1 1 0 0 1 1-1h2.268zm7.296 5.819A2.5 2.5 0 0 0 15 10.5V8a1 1 0 0 0-1-1h-2.268c.17.294.268.635.268 1h2v2.5a1.5 1.5 0 0 1-2.096 1.377c-.075.331-.19.647-.34.942zM6 6.999a1 1 0 0 0-1 1V11a3 3 0 0 0 6 0V8a1 1 0 0 0-1-1H6zm0 1h4V11a2 2 0 0 1-4 0V8z" fill="currentColor"></path></g></svg>' ,
          name: 'មន្ត្រី',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            'portal_staff'
          ]
          // , children: [
          //   {
          //     url: '/hr/officer' ,
          //     icon: 'Organization20Regular' ,
          //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M6.002 4a1.998 1.998 0 1 1 3.996 0a1.998 1.998 0 0 1-3.996 0zM8 3.002a.998.998 0 1 0 0 1.996a.998.998 0 0 0 0-1.996zM11 4.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm1.5-.5a.5.5 0 1 0 0 1a.5.5 0 0 0 0-1zm-9-1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zM3 4.5a.5.5 0 1 1 1 0a.5.5 0 0 1-1 0zM4.268 7A1.99 1.99 0 0 0 4 8H2v2.5a1.5 1.5 0 0 0 2.096 1.377c.074.331.19.647.34.942A2.5 2.5 0 0 1 1 10.5V8a1 1 0 0 1 1-1h2.268zm7.296 5.819A2.5 2.5 0 0 0 15 10.5V8a1 1 0 0 0-1-1h-2.268c.17.294.268.635.268 1h2v2.5a1.5 1.5 0 0 1-2.096 1.377c-.075.331-.19.647-.34.942zM6 6.999a1 1 0 0 0-1 1V11a3 3 0 0 0 6 0V8a1 1 0 0 0-1-1H6zm0 1h4V11a2 2 0 0 1-4 0V8z" fill="currentColor"></path></g></svg>' ,
          //     name: 'បញ្ជីមន្ត្រី',
          //     roles: [
          //       1, // Super
          //       2, // Administrator
          //       3, // backend
          //     ],
          //     permissions: [
          //       'portal_staff_listing'
          //     ]
          //   }
          // ]
      },
      // {
      //   url: '/hr/attendant' ,
      //   icon: 'ListChecked' ,
      //   svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>' ,
      //   name: 'វត្តមាន',
      //   roles: [
      //     1, // Super
      //     2, // Administrator
      //     3, // backend
      //   ],
      //   permissions: [
      //     'portal_attendant'
      //   ],
      //   children: [
      //     // {
      //     //   url: '/hr/attendant' ,
      //     //   icon: 'QrCode28Regular' ,
      //     //   svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>' ,
      //     //   name: 'បញ្ជីវត្តមានមន្ត្រី',
      //     //   roles: [
      //     //     1, // Super
      //     //     2, // Administrator
      //     //     3, // backend
      //     //   ],
      //     //   permissions: [
      //     //     'portal_attendant'
      //     //   ]
      //     // },
      //     {
      //       url: '/hr/attendant/my' ,
      //       icon: 'QrCode28Regular' ,
      //       svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>' ,
      //       name: 'វត្តមានខ្លួនឯង',
      //       roles: [
      //         // 1, // Super
      //         // 2, // Administrator
      //         3, // backend
      //       ],
      //       permissions: [
      //         'portal_attendant'
      //       ]
      //     },
      //     {
      //       url: '/hr/attendant/qrcodes' ,
      //       icon: 'QrCode28Regular' ,
      //       svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M10.75 15A2.25 2.25 0 0 1 13 17.25v5.5A2.25 2.25 0 0 1 10.75 25h-5.5A2.25 2.25 0 0 1 3 22.75v-5.5A2.25 2.25 0 0 1 5.25 15h5.5zm7.585 0v3.333h3.332v3.334h-3.332v3.332H15v-3.333h3.333v-3.333H15V15h3.334zM25 21.666V25h-3.333v-3.333H25zM10.75 16.5h-5.5a.75.75 0 0 0-.75.75v5.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-5.5a.75.75 0 0 0-.75-.75zm-1.25 2v3h-3v-3h3zM25 15v3.333h-3.333V15H25zM10.75 3A2.25 2.25 0 0 1 13 5.25v5.5A2.25 2.25 0 0 1 10.75 13h-5.5A2.25 2.25 0 0 1 3 10.75v-5.5A2.25 2.25 0 0 1 5.25 3h5.5zm12 0A2.25 2.25 0 0 1 25 5.25v5.5A2.25 2.25 0 0 1 22.75 13h-5.5A2.25 2.25 0 0 1 15 10.75v-5.5A2.25 2.25 0 0 1 17.25 3h5.5zm-12 1.5h-5.5a.75.75 0 0 0-.75.75v5.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-5.5a.75.75 0 0 0-.75-.75zm12 0h-5.5a.75.75 0 0 0-.75.75v5.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-5.5a.75.75 0 0 0-.75-.75zM9.5 6.5v3h-3v-3h3zm12 0v3h-3v-3h3z" fill="currentColor"></path></g></svg>' ,
      //       name: 'QRកូដសម្រាប់ស្កេនវត្តមាន',
      //       roles: [
      //         1, // Super
      //         2, // Administrator
      //         3, // backend
      //       ],
      //       permissions: [
      //         // 'portal_attendant_qrcodes'
      //         'portal_attendant'
      //       ]
      //     }
      //   ]
      // },
      // {
      //   url: '/hr/attendant/my' ,
      //   icon: 'QrCode28Regular' ,
      //   svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>' ,
      //   name: 'វត្តមាន',
      //   roles: [
      //     // 1, // Super
      //     // 2, // Administrator
      //     3, // backend
      //   ],
      //   permissions: [
      //     'portal_attendant'
      //   ]
      // },
      // {
      //     url: '/task' ,
      //     icon: 'TasksApp20Regular' ,
      //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M4 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9.883l-1 1.01V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h4.085c.071.2.185.389.344.55l.441.45H6a2 2 0 0 1-2-2V4zm4 1.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0zM9.5 5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm0 4a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zM9 13.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm-2-3a1 1 0 1 0 0-2a1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2a1 1 0 0 0 0 2zm10.855.352a.5.5 0 0 0-.71-.704l-3.643 3.68l-1.645-1.678a.5.5 0 1 0-.714.7l1.929 1.968a.6.6 0 0 0 .855.002l3.928-3.968z" fill="currentColor"></path></g></svg>' ,
      //     name: 'ការងារ',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       3, // backend
      //     ],
      //     permissions: [
      //       'portal_task'
      //     ]
      // },

      // {
      //     url: '/setting' ,
      //     icon: 'Settings20Regular' ,
      //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M1.91 7.383a8.491 8.491 0 0 1 1.78-3.08a.5.5 0 0 1 .54-.135l1.918.686a1 1 0 0 0 1.32-.762l.366-2.006a.5.5 0 0 1 .388-.4a8.532 8.532 0 0 1 3.555 0a.5.5 0 0 1 .387.4l.367 2.006a1 1 0 0 0 1.32.762l1.918-.686a.5.5 0 0 1 .54.136a8.491 8.491 0 0 1 1.78 3.079a.5.5 0 0 1-.152.535l-1.555 1.32a1 1 0 0 0 0 1.524l1.555 1.32a.5.5 0 0 1 .152.535a8.491 8.491 0 0 1-1.78 3.08a.5.5 0 0 1-.54.135l-1.918-.686a1 1 0 0 0-1.32.762l-.367 2.007a.5.5 0 0 1-.387.399a8.53 8.53 0 0 1-3.555 0a.5.5 0 0 1-.388-.4l-.365-2.006a1 1 0 0 0-1.32-.762l-1.919.686a.5.5 0 0 1-.54-.136a8.49 8.49 0 0 1-1.78-3.079a.5.5 0 0 1 .153-.535l1.554-1.32a1 1 0 0 0 0-1.524l-1.554-1.32a.5.5 0 0 1-.153-.535zm1.061-.006l1.294 1.098a2 2 0 0 1 0 3.05L2.97 12.623c.292.782.714 1.51 1.245 2.152l1.596-.57a2 2 0 0 1 2.64 1.525l.305 1.668a7.556 7.556 0 0 0 2.485 0l.305-1.67a1.998 1.998 0 0 1 2.64-1.524l1.597.571a7.492 7.492 0 0 0 1.245-2.152l-1.294-1.098a1.998 1.998 0 0 1 0-3.05l1.294-1.098a7.491 7.491 0 0 0-1.245-2.152l-1.596.57a2 2 0 0 1-2.64-1.524l-.306-1.669a7.555 7.555 0 0 0-2.485 0l-.304 1.669a2 2 0 0 1-2.641 1.525l-1.596-.571a7.491 7.491 0 0 0-1.245 2.152zM7.5 10a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0zm1 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 0 0-3 0z" fill="currentColor"></path></g></svg>' ,
      //     name: 'ការកំណត់',
      //     roles: [
      //       1, // Super
      //       2, // Administrator
      //       // 3, // backend
      //     ],
      //     permissions: [
      //       'portal_setting'
      //     ]
      //     , children: [
      //       {
      //         url: '/profile' ,
      //         icon: 'UserAvatar' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path></svg>' ,
      //         name: 'ព័ត៌មានផ្ទាល់ខ្លួន',
      //         roles: [
      //           // 1, // Super
      //           2, // Administrator
      //           3, // backend
      //         ]
      //       },
      //       {
      //         url: '/user' ,
      //         icon: 'SupervisedUserCircleOutlined' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12.5 10c0-1.65-1.35-3-3-3s-3 1.35-3 3s1.35 3 3 3s3-1.35 3-3zm-3 1c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1zm6.5 2c1.11 0 2-.89 2-2c0-1.11-.89-2-2-2c-1.11 0-2.01.89-2 2c0 1.11.89 2 2 2zM11.99 2.01c-5.52 0-10 4.48-10 10s4.48 10 10 10s10-4.48 10-10s-4.48-10-10-10zM5.84 17.12c.68-.54 2.27-1.11 3.66-1.11c.07 0 .15.01.23.01c.24-.64.67-1.29 1.3-1.86A9.05 9.05 0 0 0 9.5 14c-1.3 0-3.39.45-4.73 1.43c-.5-1.04-.78-2.2-.78-3.43c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.2-.27 2.34-.75 3.37c-1-.59-2.36-.87-3.24-.87c-1.52 0-4.5.81-4.5 2.7v2.78a7.935 7.935 0 0 1-5.66-2.86z" fill="currentColor"></path></svg>' ,
      //         name: 'គណនី',
      //         roles: [
      //           1, // Super
      //           2, // Administrator
      //           // 3, // backend
      //         ]
      //       },
      //       {
      //         url: '/officer' ,
      //         icon: 'ContactCard32Regular' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><g fill="none"><path d="M18 13a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2h-6a1 1 0 0 1-1-1zm1 4a1 1 0 1 0 0 2h6a1 1 0 0 0 0-2h-6zm-6-4a2 2 0 1 1-4 0a2 2 0 0 1 4 0zm-6 4.5A1.5 1.5 0 0 1 8.5 16h5a1.5 1.5 0 0 1 1.5 1.5s0 3.5-4 3.5s-4-3.5-4-3.5zM2 7.25A3.25 3.25 0 0 1 5.25 4h21.5A3.25 3.25 0 0 1 30 7.25v17.5A3.25 3.25 0 0 1 26.75 28H5.25A3.25 3.25 0 0 1 2 24.75V7.25zM5.25 6C4.56 6 4 6.56 4 7.25v17.5c0 .69.56 1.25 1.25 1.25h21.5c.69 0 1.25-.56 1.25-1.25V7.25C28 6.56 27.44 6 26.75 6H5.25z" fill="currentColor"></path></g></svg>' ,
      //         name: 'បុគ្គលិក',
      //         roles: [
      //           1, // Super
      //           2, // Administrator
      //           // 3, // backend
      //         ]
      //       },
      //       {
      //         url: '/position' ,
      //         icon: 'Organization20Regular' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M28.07 21L22 15l6.07-6l1.43 1.41L24.86 15l4.64 4.59L28.07 21z" fill="currentColor"></path><path d="M22 30h-2v-5a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v5H2v-5a7 7 0 0 1 7-7h6a7 7 0 0 1 7 7z" fill="currentColor"></path><path d="M12 4a5 5 0 1 1-5 5a5 5 0 0 1 5-5m0-2a7 7 0 1 0 7 7a7 7 0 0 0-7-7z" fill="currentColor"></path></svg>' ,
      //         name: 'តួនាទី',
      //         roles: [
      //           1, // Super
      //           2, // Administrator
      //           // 3, // backend
      //         ]
      //       },
      //       {
      //         url: '/organization' ,
      //         icon: 'Organization20Regular' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M9 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H10v1a5 5 0 0 1 5 5v1h1a2 2 0 0 1 2 2v4a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-4a2 2 0 0 1 2-2h1v-1a5.002 5.002 0 0 1 4-4.9V2.5zm7 9.5h-1.5a.5.5 0 0 1-.5-.5V10a4 4 0 0 0-8 0v1.5a.5.5 0 0 1-.5.5H4a1 1 0 0 0-1 1v4h5v-2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2h5v-4a1 1 0 0 0-1-1zM6 13.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zm9 0a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM8.5 9a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 1 0v-2a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 0-1 0v2a.5.5 0 0 0 1 0v-2zM9 17h2v-2H9v2z" fill="currentColor"></path></g></svg>' ,
      //         name: 'អង្គភាព',
      //         roles: [
      //           1, // Super
      //           2, // Administrator
      //           // 3, // backend
      //         ]
      //       },
      //       {
      //         url: '/generalsetting' ,
      //         icon: 'CalendarSettings16Regular' ,
      //         svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M14 4.5A2.5 2.5 0 0 0 11.5 2h-7A2.5 2.5 0 0 0 2 4.5v7A2.5 2.5 0 0 0 4.5 14h1.757a5.507 5.507 0 0 1-.657-1H4.5A1.5 1.5 0 0 1 3 11.5V6h4.337c.895-.63 1.986-1 3.163-1c1.33 0 2.55.472 3.5 1.257V4.5zm-3.5.5H3v-.5A1.5 1.5 0 0 1 4.5 3h7A1.5 1.5 0 0 1 13 4.5V5h-2.5zM6.635 9.92a2 2 0 0 0 1.43-2.478l-.155-.557c.254-.195.529-.362.821-.497l.338.358a2 2 0 0 0 2.91.001l.324-.343c.298.14.578.314.835.518l-.126.422a2 2 0 0 0 1.456 2.519l.349.082a4.698 4.698 0 0 1 .01 1.017l-.46.118a2 2 0 0 0-1.431 2.478l.156.556c-.254.196-.53.363-.822.498l-.338-.358a2 2 0 0 0-2.909-.002l-.325.345a4.322 4.322 0 0 1-.835-.518l.127-.423a2 2 0 0 0-1.456-2.519l-.35-.083a4.702 4.702 0 0 1-.01-1.016l.461-.118zm4.865.58a1 1 0 1 0-2 0a1 1 0 0 0 2 0z" fill="currentColor"></path></g></svg>' ,
      //         name: 'កំណត់ទូទៅ',
      //         roles: [
      //           1, // Super
      //           2, // Administrator
      //           // 3, // backend
      //         ]
      //       },
      //     ]
      // },
      {
          url: '/structure' ,
          icon: 'Organization32Regular' ,
          svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><g fill="none"><path d="M16 2a5 5 0 0 0-1.001 9.9v3.099H9.733A2.733 2.733 0 0 0 7 17.732V20.1A5.002 5.002 0 0 0 8 30a5 5 0 0 0 1-9.9v-2.368c0-.405.329-.733.733-.733h12.534c.405 0 .733.328.733.733V20.1a5.002 5.002 0 0 0 1 9.9a5 5 0 0 0 1-9.9v-2.368a2.733 2.733 0 0 0-2.733-2.733H17V11.9A5.002 5.002 0 0 0 16 2zm-3 5a3 3 0 1 1 6 0a3 3 0 0 1-6 0zM5 25a3 3 0 1 1 6 0a3 3 0 0 1-6 0zm19-3a3 3 0 1 1 0 6a3 3 0 0 1 0-6z" fill="currentColor"></path></g></svg>' ,
          name: 'អង្គការលេខ',
          roles: [
            1, // Super
            2, // Administrator
            3, // backend
          ],
          permissions: [
            'portal_staff'
          ]
          // , children: [
          //   {
          //     url: '/hr/officer' ,
          //     icon: 'Organization20Regular' ,
          //     svg: '<svg class="text-blue-500 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M6.002 4a1.998 1.998 0 1 1 3.996 0a1.998 1.998 0 0 1-3.996 0zM8 3.002a.998.998 0 1 0 0 1.996a.998.998 0 0 0 0-1.996zM11 4.5a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0zm1.5-.5a.5.5 0 1 0 0 1a.5.5 0 0 0 0-1zm-9-1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zM3 4.5a.5.5 0 1 1 1 0a.5.5 0 0 1-1 0zM4.268 7A1.99 1.99 0 0 0 4 8H2v2.5a1.5 1.5 0 0 0 2.096 1.377c.074.331.19.647.34.942A2.5 2.5 0 0 1 1 10.5V8a1 1 0 0 1 1-1h2.268zm7.296 5.819A2.5 2.5 0 0 0 15 10.5V8a1 1 0 0 0-1-1h-2.268c.17.294.268.635.268 1h2v2.5a1.5 1.5 0 0 1-2.096 1.377c-.075.331-.19.647-.34.942zM6 6.999a1 1 0 0 0-1 1V11a3 3 0 0 0 6 0V8a1 1 0 0 0-1-1H6zm0 1h4V11a2 2 0 0 1-4 0V8z" fill="currentColor"></path></g></svg>' ,
          //     name: 'បញ្ជីមន្ត្រី',
          //     roles: [
          //       1, // Super
          //       2, // Administrator
          //       3, // backend
          //     ],
          //     permissions: [
          //       'portal_staff_listing'
          //     ]
          //   }
          // ]
      },
      // {
      //   url: '/reports' ,
      //   icon: 'Reports' ,
      //   svg: '<svg class="text-blue-500 h-6" <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M8.496 8a1.5 1.5 0 0 1 1.5 1.5l-.001.748c.103 1.837-1.312 2.753-3.935 2.753C3.446 13 2 12.097 2 10.275V9.5A1.5 1.5 0 0 1 3.5 8h4.996zm4 0a1.5 1.5 0 0 1 1.5 1.5v.527c.09 1.647-1.16 2.473-3.444 2.473c-.31 0-.602-.015-.874-.045c.29-.268.507-.587.645-.958l.229.003c1.784 0 2.497-.471 2.444-1.446V9.5a.5.5 0 0 0-.5-.5h-2.063a2 2 0 0 0-.615-1h2.678zm-4 1H3.5a.5.5 0 0 0-.5.5v.775C3 11.42 3.928 12 6.06 12c2.124 0 3-.567 2.936-1.725V9.5a.5.5 0 0 0-.5-.5zM6 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zm5 1a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM6 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm5 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2z" fill="currentColor"></path></g></svg>' ,
      //   name: 'របាយការណ៍',
      //   roles: [
      //     1, // Super
      //     2, // Administrator
      //     3, // backend
      //   ],
      //   permissions: [
      //     'portal_staff'
      //   ]
      //   , children: [
      //     {
      //       url: '/reports/report1' ,
      //       icon: 'Organization20Regular' ,
      //       svg: '<svg class="text-blue-500 h-6" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M8.496 8a1.5 1.5 0 0 1 1.5 1.5l-.001.748c.103 1.837-1.312 2.753-3.935 2.753C3.446 13 2 12.097 2 10.275V9.5A1.5 1.5 0 0 1 3.5 8h4.996zm4 0a1.5 1.5 0 0 1 1.5 1.5v.527c.09 1.647-1.16 2.473-3.444 2.473c-.31 0-.602-.015-.874-.045c.29-.268.507-.587.645-.958l.229.003c1.784 0 2.497-.471 2.444-1.446V9.5a.5.5 0 0 0-.5-.5h-2.063a2 2 0 0 0-.615-1h2.678zm-4 1H3.5a.5.5 0 0 0-.5.5v.775C3 11.42 3.928 12 6.06 12c2.124 0 3-.567 2.936-1.725V9.5a.5.5 0 0 0-.5-.5zM6 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zm5 1a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM6 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm5 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2z" fill="currentColor"></path></g></svg>' ,
      //       name: 'មន្ត្រីតាមអង្គភាព',
      //       roles: [
      //         1, // Super
      //         2, // Administrator
      //         3, // backend
      //       ],
      //       permissions: [
      //         'portal_staff_listing'
      //       ]
      //     },
      //     {
      //       url: '/reports/report2' ,
      //       icon: 'Organization20Regular' ,
      //       svg: '<svg class="text-blue-500 h-6" <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M8.496 8a1.5 1.5 0 0 1 1.5 1.5l-.001.748c.103 1.837-1.312 2.753-3.935 2.753C3.446 13 2 12.097 2 10.275V9.5A1.5 1.5 0 0 1 3.5 8h4.996zm4 0a1.5 1.5 0 0 1 1.5 1.5v.527c.09 1.647-1.16 2.473-3.444 2.473c-.31 0-.602-.015-.874-.045c.29-.268.507-.587.645-.958l.229.003c1.784 0 2.497-.471 2.444-1.446V9.5a.5.5 0 0 0-.5-.5h-2.063a2 2 0 0 0-.615-1h2.678zm-4 1H3.5a.5.5 0 0 0-.5.5v.775C3 11.42 3.928 12 6.06 12c2.124 0 3-.567 2.936-1.725V9.5a.5.5 0 0 0-.5-.5zM6 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zm5 1a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM6 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm5 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2z" fill="currentColor"></path></g></svg>' ,
      //       name: 'មន្ត្រីតាមតួនាទី',
      //       roles: [
      //         1, // Super
      //         2, // Administrator
      //         3, // backend
      //       ],
      //       permissions: [
      //         'portal_staff_listing'
      //       ]
      //     },
      //     {
      //       url: '/reports/report3' ,
      //       icon: 'Organization20Regular' ,
      //       svg: '<svg class="text-blue-500 h-6" <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16"><g fill="none"><path d="M8.496 8a1.5 1.5 0 0 1 1.5 1.5l-.001.748c.103 1.837-1.312 2.753-3.935 2.753C3.446 13 2 12.097 2 10.275V9.5A1.5 1.5 0 0 1 3.5 8h4.996zm4 0a1.5 1.5 0 0 1 1.5 1.5v.527c.09 1.647-1.16 2.473-3.444 2.473c-.31 0-.602-.015-.874-.045c.29-.268.507-.587.645-.958l.229.003c1.784 0 2.497-.471 2.444-1.446V9.5a.5.5 0 0 0-.5-.5h-2.063a2 2 0 0 0-.615-1h2.678zm-4 1H3.5a.5.5 0 0 0-.5.5v.775C3 11.42 3.928 12 6.06 12c2.124 0 3-.567 2.936-1.725V9.5a.5.5 0 0 0-.5-.5zM6 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zm5 1a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM6 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm5 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2z" fill="currentColor"></path></g></svg>' ,
      //       name: 'មន្ត្រីតាមអង្គភាព, តួនាទី',
      //       roles: [
      //         1, // Super
      //         2, // Administrator
      //         3, // backend
      //       ],
      //       permissions: [
      //         'portal_staff_listing'
      //       ]
      //     }
      //   ]
      // },
    ])
    /** End app metadata */
    let toggleApps = ref(false)
    let user = reactive({})

    let matchedApps = ref([])
    function filterApps(){
      matchedApps.value = []
      /**
       * Filter the apps base on the search string
       */
      matchedApps.value = ( search.value != null && search.value.trim() != '' ) 
      ? apps.value.filter( app => app.name.indexOf( search.value ) != -1 )
      : apps.value
      /**
       * Filter the apps base on the user role
       */
      let userRoleIds = ( getUser() != null && getUser().roles != undefined && Array.isArray( getUser().roles ) ) ? getUser().roles.map(r=>r.id) : false
      
      /**
       * Error getting user role
       */
      matchedApps.value = matchedApps.value.filter( 
        app => app.roles.find( 
          role => userRoleIds.includes(role)
        ) 
      )
    }

    function logoutConfirmation(){
        console.log( "confirm before logout" )
    }

    const dialog = useDialog();
    const message = useMessage();
    const store = useStore();
    const router = useRouter()
    const route = useRoute()

    async function logout(){
      const d = dialog.warning({
        title: 'ចាកចេញ',
        content: 'តើអ្នកចង់ចាកចេញមែនទេ?',
        positiveText: 'បាទ / ចាស',
        negativeText: 'ទេ',
        onPositiveClick: () => {
          /**
           * Check whether the user has logged out already
           */
          if( isAuth() ) {
            /**
             * Show confirm dialog
             */
            d.loading = true
            store.dispatch('auth/logout').then( res => {
              message.success("អ្នកបានចាកចេញដោយជោគជ័យ។")
              d.loading = false
            }).catch( err => {
              console.log( err )
            })
            authLogout()
            window.location.href = '/'
          }else{
            window.location.href = '/login'
          }
        },
        // onNegativeClick: () => {
        //   message.error('Not Sure')
        // }
      })
    }
    function isAdminAccount(){
      return isAdmin()
    }

    filterApps()

    return {
      logout ,
      search ,
      matchedApps ,
      apps ,
      toggleApps ,
      user ,
      filterApps ,
      logoutConfirmation ,
      isAdminAccount 
    }
  }
}
</script>
<style scoped>
/* we will explain what these classes do next! */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
  transition: all 0.1s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(-20px);
  opacity: 0;
}

/**
Parent Menu
 */
.sidebar {
  @apply flex flex-wrap w-full;
}
.sidebar .sidebar-item {
  @apply relative w-full border-b border-gray-100 cursor-pointer  ;
}
.sidebar .sidebar-item:hover {
  @apply border-b  border-blue-500 bg-blue-50 duration-300;
}
.sidebar .sidebar-item:hover .sidebar-children {
  display: block;
  @apply transform-gpu duration-300;
}
.sidebar .sidebar-item:hover .item-icon , .sidebar .sidebar-item:hover .item-label {
  @apply text-blue-600 duration-300 ;
}
.item-content {
  @apply w-full flex h-10 p-2 ;
}
.item-icon {
  @apply text-gray-600 w-6 flex-none h-6  ;
}
.item-label {
  @apply h-6 text-left text-gray-800 flex-grow leading-6 pl-2  ;
}
/**
Child
*/
.sidebar-children {
  display: none;
  @apply absolute left-40 top-0 bg-white shadow-sm w-48;
}
.sidebar-children-item {
  @apply border-b border-gray-100 cursor-pointer ;
}
.sidebar-children-item:hover {
  @apply border-b border-blue-500 bg-blue-50 duration-300;
}

.child-item-content {
  @apply w-full flex h-10 border-gray-200 p-2 ;
}
.child-item-content:hover .child-item-icon , .child-item-content:hover .child-item-label {
  @apply text-blue-600 duration-300 ;
}
.child-item-icon {
  @apply text-gray-600 w-6 flex-none h-6 ;
}
.child-item-label {
  @apply h-6 text-left text-gray-800 flex-grow leading-6 pl-2  ;
}
</style>