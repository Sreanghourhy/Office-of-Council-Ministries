<template>
  <div class="screen-background">
    <div class="portal-panel" >

    </div>
  </div>
</template>
<script>

import { ref, reactive , onMounted , computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import DigitalClock from '@components/widgets/DigitalClock.vue'
import { useNotification , useMessage } from 'naive-ui'
import pkachan from '@assets/pkachan.png'
import pkachanwhite from '@assets/pkachanbulletwhite.png'
import dateFormat from 'dateformat'

export default {
  methods: {
  },
  name: 'MainPortal' ,
  components: {
    DigitalClock 
  },
  setup(){
    /**
     * Components to use
     */
    const store = useStore()
    const router = useRouter()
    const notify = useNotification()
    const message = useMessage()
  
    const model = reactive({
      name: 'portal' ,
      module: 'portals' ,
      title: 'ច្រកចេញចូលតែមួយ'
    })

    
    const full_date = ref(null)

    const toggleLoginForm = ref(false)
    onMounted( () => {
      setTimeout( function(){
        toggleLoginForm.value = true
      } , 200 )
    })

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

    function isSameDate( date ){
      return dateFormat( new Date( date ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    function isSameDatetime( datetime ){
      return dateFormat( new Date( datetime ) , "dd-mm-yyyy" ) == dateFormat( Date.now() , 'dd-mm-yyyy' )
    }

    return {
      toggleLoginForm ,
      full_date ,
      windowHeight ,
      windowWidth ,
      headerHeight ,
      footerHeight ,
      bodyHeight ,
      pkachan ,
      pkachanwhite ,
      dateFormat ,
      // Functions 
      isSameDate ,
      isSameDatetime
    }
  }
}
</script>
<style scoped >

@import url(./min-w-300.css);
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
@import url(./min-w-2800.css);
</style>
