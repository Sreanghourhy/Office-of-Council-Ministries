<template>
  <div class="relative w-full min-h-screen" oncontextmenu="return false; " :style=" ' background-image: url(' + pkachan + ');' "  >
    <!-- Top menu -->
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
    <float-top-menu v-bind:title="title" />
    <sidebar />
  </div>
</template>

<script>
import { ref , reactive } from 'vue'
import FloatTopMenu from '@components/menu/topmenu-float-items.vue'
import Sidebar from '@components/widgets/Sidebar.vue'
import pkachan from '@assets/pkachan.png'

export default {
  components: { 
    FloatTopMenu ,
    Sidebar
  },
  setup() {
    const model = reactive({
      name: 'DashboardWidgets' ,
      title: 'សង្ខេបព័ត៌មាន'
    })
    const title = ref("សង្ខេបព័ត៌មាន")
    return {
      model ,
      pkachan ,
      title
    };
  },
  name: "DashboardPage", 
  data() {
      return {};
  },
  computed: {},
  mounted() {
  },
  methods: {}
}
</script>