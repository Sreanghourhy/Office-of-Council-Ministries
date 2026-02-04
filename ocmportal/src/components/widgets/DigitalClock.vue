<template>
    <!-- Start Widget -->
    <div :class="dgClass!=undefined && dgClass.length > 0 ? dgClass : 'time' ">
        {{ $toKhmer( clock.date ) + ' ' + $toKhmer( clock.time ) }}
    </div>
    <!-- End widget -->
</template>
<script>
import { ref, reactive, computed } from 'vue'
export default {
    props: {
        size : {
            type: Number ,
            required: false ,
            default: () => {
                return 0
            }
        } ,
        dgClass : {
            type: String ,
            required: false ,
            default: () => {
                return ''
            }
        } ,
        prefix : {
            type: String ,
            required: false ,
            default: () => {
                return ''
            }
        },
        suffix : {
            type: String ,
            required: false ,
            default: () => {
                return ''
            }
        }
    },
    components: {
        
    },
    setup(){
        const clock = reactive({
            time: '',
            date: ''
        })

        const week = ['អាទិត្យ', 'ច័ន្ទ', 'អង្គារ៍', 'ពុធ', 'ព្រហស្បត៍', 'សុក្រ', 'សៅរ៍'];
        const timerID = setInterval(updateTime, 1000);

        function updateTime() {
            var cd = new Date();
            clock.time = zeroPadding(cd.getHours(), 2) + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2);
            clock.date = zeroPadding(cd.getFullYear(), 4) + '-' + zeroPadding(cd.getMonth()+1, 2) + '-' + zeroPadding(cd.getDate(), 2);
        };

        function zeroPadding(num, digit) {
            var zero = '';
            for(var i = 0; i < digit; i++) {
                zero += '0';
            }
            return (zero + num).slice(-digit);
        }

        updateTime()

        return {
            clock ,
            updateTime ,
            zeroPadding
        };
    },
    data() {
        return {
            icon: {
                size: this.size
            }
        }
    },
    computed: {

    },
    mounted() {
        
    },
    methods: {
        /** Get total documents of the user */
    },
}
</script>
<style scoped >
    .time {
        @apply leading-tight font-bold text-gray-700 ;
    }
</style>