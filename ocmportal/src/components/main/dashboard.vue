<template >
    <div class=" ocm-dashboard relative " >
        <div class="dashboard-panel mt-12">
            <Transition name="slide-fade" >
                <div class="fader flex flex-wrap" >
                    <div class="p-2" >
                        <div class="dashboard-item font-moul" @click="$router.push('/profile')" >
                            <svg 
                                class="w-20 mb-4 mx-auto text-blue-500"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3.003 3.003 0 0 1-3 3z" fill="currentColor"></path><path d="M16 2a14 14 0 1 0 14 14A14.016 14.016 0 0 0 16 2zm-6 24.377V25a3.003 3.003 0 0 1 3-3h6a3.003 3.003 0 0 1 3 3v1.377a11.899 11.899 0 0 1-12 0zm13.992-1.451A5.002 5.002 0 0 0 19 20h-6a5.002 5.002 0 0 0-4.992 4.926a12 12 0 1 1 15.985 0z" fill="currentColor"></path></svg>
                            ព័ត៌មានផ្ទាល់ខ្លួន
                        </div>
                    </div>
                    <div class="p-2" >
                        <div class="dashboard-item font-moul " @click="$router.push('/cards')" >
                            <svg 
                                class="w-20 mb-4 text-blue-500"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 28 28"><g fill="none"><path d="M15 11.75a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 3.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm-4.5-3.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0zM7 14.5h5a1 1 0 0 1 1 1v.5s-.5 2.5-3.5 2.5S6 16 6 16v-.5a1 1 0 0 1 1-1zM2.004 6.75A2.75 2.75 0 0 1 4.754 4H23.25A2.75 2.75 0 0 1 26 6.75v14.5A2.75 2.75 0 0 1 23.25 24H4.755a2.75 2.75 0 0 1-2.75-2.75V6.75zm2.75-1.25c-.69 0-1.25.56-1.25 1.25v14.5c0 .69.56 1.25 1.25 1.25H23.25c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H4.755z" fill="currentColor"></path></g></svg>
                            កាតមន្ត្រី
                        </div>
                    </div>
                    <div class="p-2" >
                        <div class="dashboard-item font-moul " @click="$router.push('/attendants')" >
                            <svg 
                                class="w-20 mb-4 text-blue-500"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"><path d="M16 8h14v2H16z" fill="currentColor"></path><path d="M6 10.59L3.41 8L2 9.41l4 4l8-8L12.59 4L6 10.59z" fill="currentColor"></path><path d="M16 22h14v2H16z" fill="currentColor"></path><path d="M6 24.59L3.41 22L2 23.41l4 4l8-8L12.59 18L6 24.59z" fill="currentColor"></path></svg>
                            វត្តមាន
                        </div>
                    </div>
                    <div class="p-2" >
                        <div class="dashboard-item font-moul " @click="$router.push('/meetings')" >
                            <svg 
                                class="w-20 mb-4 text-blue-500"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><g fill="none"><path d="M14.708 6a5.938 5.938 0 0 0-5.736 4.403l-1.773 6.623c.181-.017.365-.026.55-.026h2.045l1.593-5.951a3.438 3.438 0 0 1 3.32-2.549h18.587a3.438 3.438 0 0 1 3.32 2.549l4.756 17.77a3.72 3.72 0 0 1-3.594 4.681H21V36h16.776c4.09 0 7.066-3.878 6.01-7.828l-4.756-17.77A5.938 5.938 0 0 0 33.294 6H14.708zM34.75 40.5H20.995c.003-.083.005-.166.005-.25V38h13.751a1.25 1.25 0 0 1 0 2.5zM11.501 29a2.5 2.5 0 1 0 0-5a2.5 2.5 0 0 0 0 5zM4 22.75A3.75 3.75 0 0 1 7.75 19h7.5A3.75 3.75 0 0 1 19 22.75v17.5A3.75 3.75 0 0 1 15.25 44h-7.5A3.75 3.75 0 0 1 4 40.25v-17.5zm3.75-1.25c-.69 0-1.25.56-1.25 1.25v17.5c0 .69.56 1.25 1.25 1.25h7.5c.69 0 1.25-.56 1.25-1.25v-17.5c0-.69-.56-1.25-1.25-1.25h-7.5z" fill="currentColor"></path></g></svg>
                            កិច្ចប្រជុំ
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
        <!-- <Transition name="slide-fade" >
            <div class="fixed left-0 top-0 right-0 bg-white flex flex-wrap border-b border-gray-200 p-2 h-12 " >
                <svg class="w-8 h-8" 
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1024 1024"><path d="M924.8 385.6a446.7 446.7 0 0 0-96-142.4a446.7 446.7 0 0 0-142.4-96C631.1 123.8 572.5 112 512 112s-119.1 11.8-174.4 35.2a446.7 446.7 0 0 0-142.4 96a446.7 446.7 0 0 0-96 142.4C75.8 440.9 64 499.5 64 560c0 132.7 58.3 257.7 159.9 343.1l1.7 1.4c5.8 4.8 13.1 7.5 20.6 7.5h531.7c7.5 0 14.8-2.7 20.6-7.5l1.7-1.4C901.7 817.7 960 692.7 960 560c0-60.5-11.9-119.1-35.2-174.4zM761.4 836H262.6A371.12 371.12 0 0 1 140 560c0-99.4 38.7-192.8 109-263c70.3-70.3 163.7-109 263-109c99.4 0 192.8 38.7 263 109c70.3 70.3 109 163.7 109 263c0 105.6-44.5 205.5-122.6 276zM623.5 421.5a8.03 8.03 0 0 0-11.3 0L527.7 506c-18.7-5-39.4-.2-54.1 14.5a55.95 55.95 0 0 0 0 79.2a55.95 55.95 0 0 0 79.2 0a55.87 55.87 0 0 0 14.5-54.1l84.5-84.5c3.1-3.1 3.1-8.2 0-11.3l-28.3-28.3zM490 320h44c4.4 0 8-3.6 8-8v-80c0-4.4-3.6-8-8-8h-44c-4.4 0-8 3.6-8 8v80c0 4.4 3.6 8 8 8zm260 218v44c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8v-44c0-4.4-3.6-8-8-8h-80c-4.4 0-8 3.6-8 8zm12.7-197.2l-31.1-31.1a8.03 8.03 0 0 0-11.3 0l-56.6 56.6a8.03 8.03 0 0 0 0 11.3l31.1 31.1c3.1 3.1 8.2 3.1 11.3 0l56.6-56.6c3.1-3.1 3.1-8.2 0-11.3zm-458.6-31.1a8.03 8.03 0 0 0-11.3 0l-31.1 31.1a8.03 8.03 0 0 0 0 11.3l56.6 56.6c3.1 3.1 8.2 3.1 11.3 0l31.1-31.1c3.1-3.1 3.1-8.2 0-11.3l-56.6-56.6zM262 530h-80c-4.4 0-8 3.6-8 8v44c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8v-44c0-4.4-3.6-8-8-8z" fill="currentColor"></path></svg>
                <div class="h-8 leading-9 ml-1 font-pvh " >សង្ខេបព័ត៌មាន</div>
            </div>
        </Transition> -->
        <window-bar :title="model.title" :icon="4" />
    </div>
</template>
<script >
import { useDialog, useMessage, useNotification } from 'naive-ui'
import { ref , reactive, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { isAdmin } from '@plugins/authentication'
import WindowBar from '@components/widgets/WindowBar.vue'

/**
 * Dashboard 
 */


export default {
    name: 'Dashboard',
    components: {
        WindowBar
    },
    setup() {
        const router = useRouter()
        const store = useStore()
        const notify = useNotification()

        const model = reactive({
            name: 'dashboard' ,
            title: 'សង្ខេបព័ត៌មាន' 
        })
        const userWidget = reactive({
            total: 0 ,
            helper: false
        })
        onMounted( () => {
            store.dispatch( 'user/total' ).then( res => {
                userWidget.total = res.data.result.total
                userWidget.helper = true
            }).catch( err => {
                console.log( err )
            })
        })

        const regulatorWidget = reactive({
            total: 0 ,
            helper: false
        })
        onMounted( () => {
            store.dispatch( 'regulator/total' ).then( res => {
                regulatorWidget.total = res.data.result.total
                regulatorWidget.helper = true
            }).catch( err => {
                console.log( err )
            })
        })

        function isBackendManagement(){
            return isAdmin()
        }

        return {
            isBackendManagement ,
            userWidget ,
            regulatorWidget ,
            model
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

.fade-enter-active {
  animation: fade-in 0.5s;
}
.fade-leave-active {
  animation: fade-in 0.5s reverse;
}

.dashboard-panel {
    @apply p-4 flex flex-wrap justify-center items-center ;
}
.dashboard-panel .dashboard-item {
    @apply rounded-md hover:shadow p-4 duration-300 border border-gray-200 hover:border-gray-300 m-2 text-xs text-gray-600 cursor-pointer;
}
</style>