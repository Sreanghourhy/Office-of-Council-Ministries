<template>
    <div class="absolute left-1 top-1 w-14 text-4xl font-tacteing text-yellow-800 corner-tl" >*</div>
    <div class="absolute right-1 top-1 w-14 text-4xl font-tacteing text-yellow-800 corner-tr" >&</div>
    <div class="absolute right-1 bottom-1 w-14 text-4xl font-tacteing text-yellow-800 corner-br" >-</div>
    <div class="absolute left-1 bottom-1 w-14 text-4xl font-tacteing text-yellow-800 corner-bl" >,</div>
</template>
<script>

export default {
    components: {
        
    },
    props: [
        'size'
    ],
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