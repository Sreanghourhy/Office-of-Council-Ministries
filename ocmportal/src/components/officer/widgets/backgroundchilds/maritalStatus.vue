<template>
  <div class="flex flex-col p-[2%]">
    <!-- <label class="w-full text-left text-[15px] font-semibold text-[#1E3A8A] mb-6 border-b pb-2">
      ខ.១​​. ស្ថានភាពគ្រួសារ
    </label> -->

    <n-radio-group v-model:value="formData.marry_status">
      <n-space>
        <n-radio value="single">នៅលីវ</n-radio>
        <n-radio value="married">រៀបការហើយ</n-radio>
        <n-radio value="divorced">ពោះម៉ាយ / មេមាយ</n-radio>
      </n-space>
    </n-radio-group>
  </div>
</template>

<script>
import { ref, watch } from 'vue'
import { useStore } from 'vuex'

export default {
  emits: ['changed'], // we need to inform parent that the child want to change, a child component is just blue it doesnt have life unless parent use it. If a child wants its changes to affect the parent or other parts of the app, it can’t just silently change its internal state. If a child wants its changes to affect the parent or other parts of the app, it can’t just silently change its internal state.
  props: {
    officer: { type: Object, default: undefined }  // props over is actually a parameter for parents component to pass with the type of object if no prop pass it will take defualt value which data it can be ({people: {id: 1, name: 'john doe', marry_status: 'married'}}department: hr) or some props: ['message']
  },
  setup(props, { emit }) {   // child to parent should with the brain
    const store = useStore()

    const formData = ref({
      marry_status: 'single'
    })  //form data is use store the current. tell vue to update formdata, where marry status is single without this 
        //with this it will show single at first render but without this when their a changes it will not render again

    const originalValue = ref(props.officer?.people?.marry_status || 'single')

    const hydrateData = () => {
      const status = props.officer?.people?.marry_status || 'single'
      formData.value.marry_status = status
      originalValue.value = status
    }

    const persistChanges = async () => {
      try {
        const payload = {
          id: props.officer?.id,
          people: {
            marry_status: formData.value.marry_status
          }
        }

        const res = await store.dispatch('officer/update', payload)

        if (res?.status === 200) {
          if (props.officer?.people) {
            props.officer.people.marry_status = formData.value.marry_status
          }
          originalValue.value = formData.value.marry_status
          emit('changed', false)
          return true
        }

        return false
      } catch (err) {
        console.error(err)
        return false
      }
    }

    watch(() => props.officer?.people?.marry_status, hydrateData, { immediate: true })

    watch(() => formData.value.marry_status, (newVal) => {
      emit('changed', newVal !== originalValue.value, newVal)
    })

    return {
      formData,
      persistChanges
    }
  }
}
</script>




<!-- 
export → makes something from this file available to other files.
export default → marks one “main thing” in the file that will be imported without curly braces.
Example 1 – exporting multiple things:
```
export const pi = 3.14
export const e = 2.71
```
To import:
```
import { pi, e } from './math.js'
```
Example 2 – default export:
```
const mathConstants = { pi: 3.14, e: 2.71 }
export default mathConstants
```
To import:
```
import constants from './math.js'
console.log(constants.pi) // 3.14
```
-->
