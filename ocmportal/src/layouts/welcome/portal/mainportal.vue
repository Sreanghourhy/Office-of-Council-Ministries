<template>
  <div class="main-portal pt-10 " :style=" 'background-image: url( ' + pkachan + ' ); ' " >
    <div class="portal-panel mx-auto" >
      <Transition name="slide-fade" >
        <div v-if="visibleHelper" class="text-center mt-8 " >
          <div class="my-2 font-moul text-gray-700 text-3xl ">{{ $store.state.system.name }}</div>
          <!-- <div class="w-20 mx-auto mt-4">
            <img :src="logo" class="w-full" >
          </div>
          <div class="my-2 font-moul text-yellow-500">ទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
          <div class="my-2 text-4xl font-tacteing" >3</div>
          <div class="my-2 text-2xl ">{{ $store.state.system.name }} នៃ {{ $store.state.company.name }}</div> -->
        </div>
      </Transition>
      <!-- Services -->
      <Transition name="slide-fade" >
        <div v-if="visibleHelper" class="portal-panel mt-8 py-10" >
          <div class="portal-services ">
            <!-- <div v-if="$hasPermission('portal_mission_permission')" class="portal-service-item">
                <div class='portal-service-content' >
                    <svg class="portal-service-icon text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>
                    <div class="portal-service-label font-moul" >ច្បាប់ និងបេសកកម្ម</div>
                </div>
            </div> -->
            <!-- <div v-if="$hasPermission('portal_attendant')" class="portal-service-item">
                <div @click="routeTo('/hr/attendant' ) " class='portal-service-content' >
                    <svg class="portal-service-icon text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41c-.24.13-.54.04-.68-.2a.506.506 0 0 1 .2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52c.25.13.34.43.21.67a.49.49 0 0 1-.44.28zM3.5 9.72a.499.499 0 0 1-.41-.79c.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25a.5.5 0 0 1-.12.7c-.23.16-.54.11-.7-.12a9.388 9.388 0 0 0-3.39-2.94c-2.87-1.47-6.54-1.47-9.4.01c-1.36.7-2.5 1.7-3.4 2.96c-.08.14-.23.21-.39.21zm6.25 12.07a.47.47 0 0 1-.35-.15c-.87-.87-1.34-1.43-2.01-2.64c-.69-1.23-1.05-2.73-1.05-4.34c0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39s-4.66 1.97-4.66 4.39c0 1.44.32 2.77.93 3.85c.64 1.15 1.08 1.64 1.85 2.42c.19.2.19.51 0 .71c-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89c-1.49-1.01-2.38-2.65-2.38-4.39c0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56c.71.48 1.54.71 2.54.71c.24 0 .64-.03 1.04-.1c.27-.05.53.13.58.41c.05.27-.13.53-.41.58c-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02c-1.59-.44-2.63-1.03-3.72-2.1a7.297 7.297 0 0 1-2.17-5.22c0-1.62 1.38-2.94 3.08-2.94s3.08 1.32 3.08 2.94c0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83c-2.84 0-5.44 1.58-6.61 4.03c-.39.81-.59 1.76-.59 2.8c0 .78.07 2.01.67 3.61c.1.26-.03.55-.29.64c-.26.1-.55-.04-.64-.29a11.14 11.14 0 0 1-.73-3.96c0-1.2.23-2.29.68-3.24c1.33-2.79 4.28-4.6 7.51-4.6c4.55 0 8.25 3.51 8.25 7.83c0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51c.95.94 1.86 1.46 3.27 1.85c.27.07.42.35.35.61c-.05.23-.26.38-.47.38z" fill="currentColor"></path></svg>
                    <div class="portal-service-label font-moul" >វត្តមាន</div>
                </div>
            </div> -->
            <div v-if="$hasPermission('portal_attendant')" class="portal-service-item">
                <div @click="routeTo('/structure' ) " class='portal-service-content' >
                    <svg class="portal-service-icon text-gray-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><g fill="none"><path d="M16 2a5 5 0 0 0-1.001 9.9v3.099H9.733A2.733 2.733 0 0 0 7 17.732V20.1A5.002 5.002 0 0 0 8 30a5 5 0 0 0 1-9.9v-2.368c0-.405.329-.733.733-.733h12.534c.405 0 .733.328.733.733V20.1a5.002 5.002 0 0 0 1 9.9a5 5 0 0 0 1-9.9v-2.368a2.733 2.733 0 0 0-2.733-2.733H17V11.9A5.002 5.002 0 0 0 16 2zm-3 5a3 3 0 1 1 6 0a3 3 0 0 1-6 0zM5 25a3 3 0 1 1 6 0a3 3 0 0 1-6 0zm19-3a3 3 0 1 1 0 6a3 3 0 0 1 0-6z" fill="currentColor"></path></g></svg>
                    <div class="portal-service-label font-moul" >អង្គការលេខទីស្ដីការគណៈរដ្ឋមន្ត្រី</div>
                </div>
            </div>
            <div v-if="$hasPermission('portal_staff')" class="portal-service-item">
                <div @click="routeTo('hr/officer' ) " class='portal-service-content' >
                    <svg class="portal-service-icon text-green-700 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M17.254 11a2.25 2.25 0 0 1 2.25 2.25v6.249a5.501 5.501 0 0 1-11.002 0V13.25a2.25 2.25 0 0 1 2.25-2.25h6.502zm0 1.5h-6.502a.75.75 0 0 0-.75.75v6.249a4.001 4.001 0 0 0 8.002 0V13.25a.75.75 0 0 0-.75-.75zM4.25 11h4.156a3.243 3.243 0 0 0-.817 1.5H4.25a.75.75 0 0 0-.75.75v5.249a3.001 3.001 0 0 0 4.238 2.735c.133.49.324.956.564 1.392A4.501 4.501 0 0 1 2 18.499V13.25A2.25 2.25 0 0 1 4.25 11zm19.5 0A2.25 2.25 0 0 1 26 13.25v5.25a4.5 4.5 0 0 1-6.298 4.127l.056-.102c.214-.406.387-.837.511-1.289A3 3 0 0 0 24.5 18.5v-5.25a.75.75 0 0 0-.749-.75h-3.333A3.242 3.242 0 0 0 19.6 11h4.151zM14 3a3.5 3.5 0 1 1 0 7a3.5 3.5 0 0 1 0-7zm8.003 1a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM5.997 4a3 3 0 1 1 0 6a3 3 0 0 1 0-6zM14 4.5a2 2 0 1 0 0 4a2 2 0 0 0 0-4zm8.003 1a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3zm-16.006 0a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3z" fill="currentColor"></path></g></svg>
                    <div class="portal-service-label font-moul" >មន្ត្រីរាជការមុខងារសាធារណៈ</div>
                </div>
            </div>
            <!-- <div v-if="$hasPermission('portal_regulator')" class="portal-service-item">
                <div @click="routeTo( 'regulator' ) " class='portal-service-content' >
                    <svg class="portal-service-icon text-red-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 384 512"><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5c-17.2-10.5-28.7-25-36.8-46.3c3.9-16.1 10.1-40.6 5.4-56c-4.2-26.2-37.8-23.6-42.6-5.9c-4.4 16.1-.4 38.5 7 67.1c-10 23.9-24.9 56-35.4 74.4c-20 10.3-47 26.2-51 46.2c-3.3 15.8 26 55.2 76.1-31.2c22.4-7.4 46.8-16.5 68.4-20.1c18.9 10.2 41 17 55.8 17c25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35c-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8c-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7c8.3 15.1 18.9 27.2 30.1 35.5c-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z" fill="currentColor"></path></svg>
                    <div class="portal-service-label font-moul" >ឯកសារច្បាប់ និងលិខិតបទដ្ឋានគតិយុត្ត</div>
                </div>
            </div>
            <div v-if="$hasPermission('portal_meeting')" class="portal-service-item">
                <div @click="routeTo( 'meeting' ) " class='portal-service-content' >
                    <svg class="portal-service-icon text-blue-500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><g fill="none"><path d="M4.094 5.346A3.063 3.063 0 0 1 7.072 3h9.858c1.415 0 2.646.97 2.978 2.346l1.992 8.273A3.55 3.55 0 0 1 18.448 18H10.5v-1.5h7.947a2.05 2.05 0 0 0 1.993-2.53L18.45 5.697A1.563 1.563 0 0 0 16.93 4.5H7.073c-.722 0-1.35.495-1.52 1.197L4.879 8.5H3.75c-.144 0-.285.011-.423.032l.767-3.186zM10.49 20.5h6.762a.75.75 0 1 0 0-1.5h-6.75v1.25c0 .084-.005.168-.012.25zm-4.74-6a1.25 1.25 0 1 0 0-2.5a1.25 1.25 0 0 0 0 2.5zM2 11.25c0-.966.784-1.75 1.75-1.75h4c.968 0 1.751.784 1.751 1.75v9A1.75 1.75 0 0 1 7.751 22h-4A1.75 1.75 0 0 1 2 20.25v-9zM3.75 11a.25.25 0 0 0-.25.25v9c0 .138.112.25.25.25h4a.25.25 0 0 0 .25-.25v-9a.25.25 0 0 0-.25-.25h-4z" fill="currentColor"></path></g></svg>
                    <div class="portal-service-label font-moul" >កិច្ចប្រជុំគណៈរដ្ឋមន្ត្រី</div>
                </div>
            </div> -->
          </div>
        </div>
      </Transition>
      <!-- <div class="mt-8 mx-auto " style="width: 1024px;" >
        <leader-activity />
      </div>
      <div class="mt-8 mx-auto " style="width: 1024px;" >
        <leader-photo-top-activity />
      </div> -->
    </div>
    <!-- End Meeting Schedule -->
    <div class="fixed left-0 right-0 bottom-0" >
      <Footer />
    </div>
    <div class="fixed right-0 top-12 p-4 flex flex-row" >
      <DigitalClock dgClass="w-64 text-right leading-7 p-1" />
      <!-- <router-link to="/login" >
        <div class="w-24 text-green-600 flex flex-row text-md leading-6 mx-2 h-8 p-1 rounded-full border border-green-600 hover:bg-white duration-500" >
          <svg class="w-6 h-6 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><defs></defs><path d="M521.7 82c-152.5-.4-286.7 78.5-363.4 197.7c-3.4 5.3.4 12.3 6.7 12.3h70.3c4.8 0 9.3-2.1 12.3-5.8c7-8.5 14.5-16.7 22.4-24.5c32.6-32.5 70.5-58.1 112.7-75.9c43.6-18.4 90-27.8 137.9-27.8c47.9 0 94.3 9.3 137.9 27.8c42.2 17.8 80.1 43.4 112.7 75.9c32.6 32.5 58.1 70.4 76 112.5C865.7 417.8 875 464.1 875 512c0 47.9-9.4 94.2-27.8 137.8c-17.8 42.1-43.4 80-76 112.5s-70.5 58.1-112.7 75.9A352.8 352.8 0 0 1 520.6 866c-47.9 0-94.3-9.4-137.9-27.8A353.84 353.84 0 0 1 270 762.3c-7.9-7.9-15.3-16.1-22.4-24.5c-3-3.7-7.6-5.8-12.3-5.8H165c-6.3 0-10.2 7-6.7 12.3C234.9 863.2 368.5 942 520.6 942c236.2 0 428-190.1 430.4-425.6C953.4 277.1 761.3 82.6 521.7 82zM395.02 624v-76h-314c-4.4 0-8-3.6-8-8v-56c0-4.4 3.6-8 8-8h314v-76c0-6.7 7.8-10.5 13-6.3l141.9 112a8 8 0 0 1 0 12.6l-141.9 112c-5.2 4.1-13 .4-13-6.3z" fill="currentColor"></path></svg>
          ចូលប្រព័ន្ធ
        </div>
      </router-link> -->
      <div @click="logout()" class="cursor-pointer w-28 text-red-600 flex flex-row text-md leading-6 mx-2 h-8 p-1 rounded-full border border-red-600 hover:bg-red-100 duration-500" >
        <svg class="w-6 h-6 mr-1 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M868 732h-70.3c-4.8 0-9.3 2.1-12.3 5.8c-7 8.5-14.5 16.7-22.4 24.5a353.84 353.84 0 0 1-112.7 75.9A352.8 352.8 0 0 1 512.4 866c-47.9 0-94.3-9.4-137.9-27.8a353.84 353.84 0 0 1-112.7-75.9a353.28 353.28 0 0 1-76-112.5C167.3 606.2 158 559.9 158 512s9.4-94.2 27.8-137.8c17.8-42.1 43.4-80 76-112.5s70.5-58.1 112.7-75.9c43.6-18.4 90-27.8 137.9-27.8c47.9 0 94.3 9.3 137.9 27.8c42.2 17.8 80.1 43.4 112.7 75.9c7.9 7.9 15.3 16.1 22.4 24.5c3 3.7 7.6 5.8 12.3 5.8H868c6.3 0 10.2-7 6.7-12.3C798 160.5 663.8 81.6 511.3 82C271.7 82.6 79.6 277.1 82 516.4C84.4 751.9 276.2 942 512.4 942c152.1 0 285.7-78.8 362.3-197.7c3.4-5.3-.4-12.3-6.7-12.3zm88.9-226.3L815 393.7c-5.3-4.2-13-.4-13 6.3v76H488c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h314v76c0 6.7 7.8 10.5 13 6.3l141.9-112a8 8 0 0 0 0-12.6z" fill="currentColor"></path></svg>
        ចេញពីប្រព័ន្ធ
      </div>
    </div>
    <float-top-menu v-bind:title="title" />
    <!-- <sidebar /> -->
    <!-- <div class="mt-8 mx-auto bg-gray-50 -ml-10 -mr-10 mb-0" >
      <sitemap />
    </div> -->
  </div>
</template>
<script>

import { ref, reactive , onMounted , computed } from 'vue'
import { isAuth, getUser , authLogout } from './../../../plugins/authentication.js'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { useDialog } from 'naive-ui'
import DigitalClock from '@components/widgets/DigitalClock.vue'
import { useNotification , useMessage } from 'naive-ui'
import pkachan from '@assets/pkachan.png'
import logo from '@assets/logo.png'
import pkachanwhite from '@assets/pkachanbulletwhite.png'
import dateFormat from 'dateformat'
import Footer from '@components/footer/copy-right.vue'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'

import LeaderActivity from './../activities/leader.vue'
import LeaderPhotoTopActivity from './../activities/leader-photo-top.vue'
import Sitemap from './../activities/sitemap.vue'

export default {
  name: 'MainPortal' ,
  components: {
    DigitalClock ,
    Footer ,
    FloatTopMenu ,
    Sidebar ,
    LeaderActivity ,
    LeaderPhotoTopActivity ,
    Sitemap
  },
  setup(){
    /**
     * Components to use
     */
    const store = useStore()
    const router = useRouter()
    const notify = useNotification()
    const dialog = useDialog()

    const title = ref("ទំព័រស្វាគមន៍")
  
    const model = reactive({
      name: 'portal' ,
      module: 'portals' ,
      title: 'ច្រកចេញចូលតែមួយ'
    })

    const full_date = ref(null)

    window.addEventListener("resize", reportWindowSize);
    const windowHeight = ref( window.innerHeight )
    const windowWidth = ref( window.innerWidth )
    function reportWindowSize(){
      windowWidth.value = window.innerWidth
      // Limit the height with width
      if( window.innerWidth >= 300 && window.innerWidth <= 399 && window.innerHeight >= 200 && window.innerHeight <= 550 ){
        windowHeight.value = window.innerHeight > 350 ? 350 : window.innerHeight
      }
      else if( window.innerWidth >= 400 && window.innerWidth <= 499 ){
        windowHeight.value = window.innerHeight > 400 ? 400 : window.innerHeight
      }
      else if( window.innerWidth >= 500 && window.innerWidth <= 599 && window.innerHeight <= 799 ){
        windowHeight.value = window.innerHeight > 500 ? 500 : window.innerHeight
      }
      else if( window.innerWidth >= 600 && window.innerWidth <= 699 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 700 && window.innerWidth <= 799 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 800 && window.innerWidth <= 899 ){
        windowHeight.value = window.innerHeight > 600 ? 600 : window.innerHeight
      }
      else if( window.innerWidth >= 900 && window.innerWidth <= 999 ){
        windowHeight.value = window.innerHeight > 700 ? 700 : window.innerHeight
      }
      else if( window.innerWidth >= 1000 && window.innerWidth <= 1099 ){
        windowHeight.value = window.innerHeight > 800 ? 800 : window.innerHeight
      }
      else if( window.innerWidth >= 1100 && window.innerWidth <= 1199 ){
        windowHeight.value = window.innerHeight > 900 ? 900 : window.innerHeight
      }
      else if( window.innerWidth >= 1200 && window.innerWidth <= 1399 ){
        windowHeight.value = window.innerHeight > 999 ? 999 : window.innerHeight
      }
      else if( window.innerWidth >= 1400 && window.innerWidth <= 1499 ){
        windowHeight.value = window.innerHeight > 1099 ? 1099 : window.innerHeight
      }
      else if( window.innerWidth >= 1500 && window.innerWidth <= 1999 ){
        windowHeight.value = window.innerHeight > 1099 ? 1099 : window.innerHeight
      }
      else if( window.innerWidth >= 2000 && window.innerWidth <= 2299 ){
        windowHeight.value = window.innerHeight > 1299 ? 1299 : window.innerHeight
      }
      else if( window.innerWidth >= 2400 && window.innerWidth <= 2799 ){
        windowHeight.value = window.innerHeight > 1499 ? 1499 : window.innerHeight
      }
      else if( window.innerWidth >= 2800 && window.innerWidth <= 3800 ){
        windowHeight.value = window.innerHeight > 2199 ? 2199 : window.innerHeight
      }
      else{
        windowHeight.value = window.innerHeight
      }
    }

    const headerHeight = computed(() => {
      return windowHeight.value * 0.08
    })
    const footerHeight = computed(() => {
      return windowHeight.value * 0.08
    })
    const bodyHeight = computed(() => {
      return windowHeight.value * 0.84
    })

    onMounted( () => {
      reportWindowSize()
    })

    function openNewTap(url){
      window.open( url , '_blank' );
    }
    function routeTo(uri){
      router.push( uri )
    }
    function isSameDate( date ){
      return dateFormat( new Date( date ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    function isSameDatetime( datetime ){
      return dateFormat( new Date( datetime ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    const visibleHelper = ref(false) 
    setTimeout( () => {
      visibleHelper.value = true
      clearTimeout()
    },500)

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

    return {
      title ,
      logout, 
      full_date ,
      windowHeight ,
      windowWidth ,
      headerHeight ,
      footerHeight ,
      bodyHeight ,
      pkachan ,
      pkachanwhite ,
      dateFormat ,
      logo , 
      // Functions 
      isSameDate ,
      isSameDatetime ,
      visibleHelper ,
      openNewTap ,
      routeTo
    }
  }
}
</script>
<style scoped >

.main-portal {
  @apply min-h-screen p-8 mt-12 ;
}

.main-portal .portal-services {
  @apply flex flex-wrap justify-center w-full ;
}

.main-portal .portal-services .portal-service-item {
  @apply m-4 min-w-40; 
}

.portal-service-item .portal-service-content {
  @apply w-full p-4 cursor-pointer rounded-lg bg-white border border-gray-200 hover:bg-yellow-50 duration-500 transform hover:scale-110 ;
}

.portal-service-content .portal-service-icon {
  @apply w-12 h-12 mx-auto mb-4 ;
}

.portal-service-content .portal-service-label {
  @apply p-2 m-auto text-center text-gray-700 ;
}

/* @import url(./min-w-300.css);
@import url(./min-w-400.css);
@import url(./min-w-500.css);
@import url(./min-w-600.css);
@import url(./min-w-700.css);
@import url(./min-w-800.css);
@import url(./min-w-900.css);
@import url(./min-w-1000.css);
@import url(./min-w-1100.css);
@import url(./min-w-1200.css);
@import url(./min-w-1400.css);
@import url(./min-w-1500.css);
@import url(./min-w-2000.css);
@import url(./min-w-2400.css);
@import url(./min-w-2800.css); */
</style>
