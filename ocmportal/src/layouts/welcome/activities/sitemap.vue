<template>
    <div class="w-full py-4 flex flex-wrap mx-auto" style="width: 1024px;" >
        <div class="w-full text-left font-moul border-b border-gray-200 h-6 flex" >
            <div class="flex-grow text-left font-moul h-6 " >សកម្មភាពថ្នាក់ដឹកនាំ</div>
            <div class="flex-none text-right cursor-pointer hover:text-blue-500 duration-300 h-6 w-40" >អត្ថបទផ្សេងទៀត</div>
        </div>
        <div class="w-full py-4 text-left flex" >
            <div v-for="i in 3" :key="i" class="flex-wrap w-1/3 p-2 " >
                <table >
                    <tbody>
                        <tr>
                            <td style="vertical-align: top;" class="p-1" >
                                <img class="rounded-md " src="https://www.ocm.gov.kh/wp-content/uploads/2024/12/photo_2024-12-28-08.50.53-760x507.jpeg" />
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;" class="pt-4" >
                                <table >
                                    <tbody>
                                        <tr>
                                            <td class="trancate text-justify" >ឯកឧត្ដម វង្សី វិស្សុត ឧបនាយករដ្ឋមន្រ្តីប្រចាំការ ជំរុញថ្នាក់ដឹកនាំនិងមន្ត្រីរាជការនៃទីស្ដីការគណៈរដ្ឋមន្ត្រី ឱ្យខិតខំបំពេញការងារដើម្បីជាសេនាធិការជូនរាជរដ្ឋាភិបាល និងគណៈរដ្ឋមន្ត្រី កាន់តែមានគុណភាពនិងប្រសិទ្ធភាព</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script >
export default {
  methods: {
  },
  props: {
  },
    setup(){

    }
}
</script>