<template>
  <section  class="p-[2%] transition-all duration-300" >
    <h3 class="w-full text-left text-[15px] font-semibold mb-6 border-b pb-2 text-[#1E3A8A]">
      គ. ព័ត៌មានទំនាក់ទំនងក្នុងករណីមានអាសន្ន
    </h3>

    <div class="flex flex-row gap-8 w-full items-start">
      <div class="flex flex-col gap-4 flex-1">
        <!-- Khmer Name Fields -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ឈ្មោះជាភាសារខ្មែរ</label>
          <div :class="['w-full relative group', fieldStateClass(['e_lastname', 'e_firstname'])]">
            <div v-if="shouldShowDisplay('e_lastname') && shouldShowDisplay('e_firstname')" @click="enableEdit('e_lastname')" class="flex gap-1">
              <div 
                   :class="[
                     'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.e_lastname ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.e_lastname || 'នាមត្រកូល' }}
              </div> 
              <div @click="enableEdit('e_firstname')"
                   :class="[
                     'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer hover:border-[#22C55E] duration-150 text-left',
                     formData.e_firstname ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                   ]">
                {{ formData.e_firstname || 'នាមខ្លួន' }}
              </div>
            </div>
            <div v-else class="flex flex-col relative">
              <div class="flex flex-row gap-1">
                <input v-model="formData.e_lastname" v-focus type="text" class="field-input-green" placeholder="នាមត្រកូល" />
                <input v-model="formData.e_firstname" type="text" class="field-input-green" placeholder="នាមខ្លួន" />
              </div>
              <button @click="cancelNameEdit" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_lastname') || getPrevious('e_firstname')" class="text-[10px] text-blue-500 mt-1 italic text-left">
                មុនកែ: {{ originalSnapshot.e_lastname }} {{ originalSnapshot.e_firstname }}
              </span> -->
            </div>
          </div>
        </div>

        <!-- Relationship Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ទំនាក់ទំនងត្រូវជា</label>
          <div :class="['w-full relative', fieldStateClass('e_relationship')]">
            <div v-if="shouldShowDisplay('e_relationship')" @click="enableEdit('e_relationship')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_relationship ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_relationship || 'ឧ. បងប្រុស' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.e_relationship" v-focus type="text" class="field-input-green" placeholder="ឧ. បងប្រុស" />
              <button @click="cancelEdit('e_relationship')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_relationship')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_relationship }}</span> -->
            </div>
          </div>
        </div>

        <!-- Address Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">អាសយដ្ឋានបច្ចុប្បន្ន</label>
          <div :class="['w-full relative', fieldStateClass('e_address')]">
            <div v-if="shouldShowDisplay('e_address')" @click="enableEdit('e_address')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_address ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_address || 'បញ្ចូលអាសយដ្ឋាន' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.e_address" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលអាសយដ្ឋាន..." />
              <button @click="cancelEdit('e_address')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_address')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_address }}</span> -->
            </div>
          </div>
        </div>

        <!-- Phone Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">លេខទូរសព្ទ</label>
          <div :class="['w-full relative', fieldStateClass('e_phone')]">
            <div v-if="shouldShowDisplay('e_phone')" @click="enableEdit('e_phone')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_phone ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_phone || 'បញ្ចូលលេខទូរសព្ទ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.e_phone" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលលេខទូរសព្ទ" />
              <button @click="cancelEdit('e_phone')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_phone')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_phone }}</span> -->
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-4 flex-1">
        <!-- Gender Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">ភេទ</label>
          <div :class="['w-full relative', fieldStateClass('e_gender')]">
            <div v-if="shouldShowDisplay('e_gender')" @click="enableEdit('e_gender')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_gender != null ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_gender == 0 ? 'ស្រី' : 'ប្រុស' }}
            </div>
            <div v-else class="flex flex-col relative">
              <select v-model="formData.e_gender" v-focus class="field-input-green">
                <option :value="1">ប្រុស</option>
                <option :value="0">ស្រី</option>
              </select>
              <button @click="cancelEdit('e_gender')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_gender')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_gender == 0 ? 'ស្រី' : 'ប្រុស' }}</span> -->
            </div>
          </div>
        </div>

        <!-- Profession Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">មុខរបរ</label>
          <div :class="['w-full relative', fieldStateClass('e_profession')]">
            <div v-if="shouldShowDisplay('e_profession')" @click="enableEdit('e_profession')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_profession ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_profession || 'បញ្ចូលមុខរបរ' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.e_profession" v-focus type="text" class="field-input-green" placeholder="បញ្ចូលមុខរបរ..." />
              <button @click="cancelEdit('e_profession')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_profession')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_profession }}</span> -->
            </div>
          </div>
        </div>

        <!-- Email Field -->
        <div class="grid grid-cols-[180px_1fr] items-center gap-4 min-h-[40px]">
          <label class="text-[13px] text-left font-medium text-[#2C3E50]">អ៊ីមែល</label>
          <div :class="['w-full relative', fieldStateClass('e_email')]">
            <div v-if="shouldShowDisplay('e_email')" @click="enableEdit('e_email')" 
                 :class="[
                   'field-display-box w-full border rounded px-3 py-2 text-[13px] font-medium cursor-pointer text-left hover:border-[#22C55E] duration-150',
                   formData.e_email ? 'border-[#E2E8F0]' : 'bg-white border-dashed border-gray-300 text-gray-400'
                 ]">
              {{ formData.e_email || 'example@mail.com' }}
            </div>
            <div v-else class="flex flex-col relative">
              <input v-model="formData.e_email" v-focus type="email" class="field-input-green" placeholder="បញ្ចូលអ៊ីមែល" />
              <button @click="cancelEdit('e_email')" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
              <!-- <span v-if="getPrevious('e_email')" class="text-[10px] text-blue-500 mt-1 italic text-left">មុនកែ: {{ originalSnapshot.e_email }}</span> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref, watch, computed } from 'vue'
import { useStore } from 'vuex'

export default {
  directives: {
    focus: { mounted(el) { el.focus() } }
  },
  emits: ['changed'],
  props: {
    officer: { type: Object, default: () => ({}) } 
  },
  setup(props, { emit }) {
    const store = useStore()
    const formData = ref({
      e_lastname: '', e_firstname: '', e_gender: 1, 
      e_relationship: '', e_profession: '', e_address: '', 
      e_phone: '', e_email: ''
    })

    const originalSnapshot = ref({}) 
    const editModeFields = ref(new Set())

    function hydrateData() {
      const source = props.officer?.people || {};

      const mapped = {
        e_lastname: source.emergency_lastname || '',
        e_firstname: source.emergency_firstname || '',
        e_gender: source.emergency_gender ?? 1,
        e_relationship: source.emergency_relationship || '',
        e_profession: source.emergency_profession || '',
        e_address: source.emergency_address || '',
        e_phone: source.emergency_phone || '',
        e_email: source.emergency_email || ''
      }

      formData.value = { ...mapped }
      originalSnapshot.value = JSON.parse(JSON.stringify(mapped))
      editModeFields.value.clear()
    }

    // Add this missing function
    const getPrevious = (field) => {
      return formData.value[field] !== originalSnapshot.value[field] 
        ? originalSnapshot.value[field] 
        : null
    }
    // --- SAVE LOGIC FOR PARENT REF ---
    const persistChanges = async () => {
      try {
        const payload = {
          id: props.officer?.id,
          people: {
            emergency_lastname: formData.value.e_lastname,
            emergency_firstname: formData.value.e_firstname,
            emergency_gender: formData.value.e_gender,
            emergency_relationship: formData.value.e_relationship,
            emergency_profession: formData.value.e_profession,
            emergency_address: formData.value.e_address,
            emergency_phone: formData.value.e_phone,
            emergency_email: formData.value.e_email
          }
        };

        const res = await store.dispatch('officer/update', payload);
        
        if (res?.data?.ok || res?.status === 200) {
          if (props.officer?.people) {
            props.officer.people.emergency_lastname = formData.value.e_lastname;
            props.officer.people.emergency_firstname = formData.value.e_firstname;
            props.officer.people.emergency_gender = formData.value.e_gender;
            props.officer.people.emergency_relationship = formData.value.e_relationship;
            props.officer.people.emergency_profession = formData.value.e_profession;
            props.officer.people.emergency_address = formData.value.e_address;
            props.officer.people.emergency_phone = formData.value.e_phone;
            props.officer.people.emergency_email = formData.value.e_email;
          }
          originalSnapshot.value = JSON.parse(JSON.stringify(formData.value));
          editModeFields.value.clear();
          emit('changed', false);
          return true;
        }
        return false;
      } catch (err) {
        console.error("Emergency contact save failed:", err);
        return false;
      }
    };

    // Add this missing function
    const cancelNameEdit = () => {
      formData.value.e_lastname = originalSnapshot.value.e_lastname
      formData.value.e_firstname = originalSnapshot.value.e_firstname
      editModeFields.value.delete('e_lastname')
      editModeFields.value.delete('e_firstname')
    }

    // --- CANCEL LOGIC FOR PARENT REF ---
    const cancelChanges = () => {
      hydrateData(); // Reset formData from props.officer
      editModeFields.value.clear();
      emit('changed', false);
    };

    // --- MARK SAVED METHOD FOR PARENT REF (for compatibility) ---
    const markSaved = () => {
      // This method is called by the parent when it wants to mark the section as saved
      // without actually persisting to the server
      originalSnapshot.value = JSON.parse(JSON.stringify(formData.value));
      editModeFields.value.clear();
      emit('changed', false);
    };

    const shouldShowDisplay = (field) => !editModeFields.value.has(field)
    
    const enableEdit = (field) => editModeFields.value.add(field)
    
    const saveEdit = (field) => {
      editModeFields.value.delete(field)
      // Optionally auto-save on field exit if you want real-time saves
      // persistChanges(); 
    }
    
    const cancelEdit = (field) => {
      formData.value[field] = originalSnapshot.value[field]
      editModeFields.value.delete(field)
    }

    const fieldChanged = (fields) => {
      const fieldList = Array.isArray(fields) ? fields : [fields]
      return fieldList.some((field) => JSON.stringify(formData.value?.[field]) !== JSON.stringify(originalSnapshot.value?.[field]))
    }

    const fieldStateClass = (fields) => (fieldChanged(fields) ? 'changed-cell changed-cell-offset' : '')

    // Watchers
    watch(() => props.officer, hydrateData, { immediate: true, deep: true })

    const isDirty = computed(() => {
      return JSON.stringify(formData.value) !== JSON.stringify(originalSnapshot.value);
    })

    watch(formData, () => {
      emit('changed', isDirty.value);
    }, { deep: true })

    // EXPOSE EVERYTHING TO PARENT REF
    return { 
      formData, 
      getPrevious,
      cancelNameEdit, 
      shouldShowDisplay, 
      enableEdit, 
      saveEdit, 
      cancelEdit,
      fieldChanged,
      fieldStateClass,
      persistChanges,      // Required for Save All
      cancelChanges,       // Required for Cancel All
      markSaved,           // Required for compatibility
      isDirty,
      originalSnapshot 
    }
  }
}
</script>

<style scoped>
.changed-cell-offset {
  margin-left: -6px;
  padding-left: 6px;
  border-radius: 0;
}

.flex.flex-col.relative > button {
  display: none;
}

.table-display-box {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #F1F5F9;
  border: 1px solid #E2E8F0;
  border-radius: 4px;
  padding: 0 12px;
  font-size: 13px;
  color: #1E3A8A;
  font-weight: 500;
  cursor: pointer;
  transition: border-color 0.15s ease;
}

.table-display-box:hover { border-color: #22C55E; }

.field-input-green {
  width: 100%;
  border: 1px solid #E2E8F0;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 13px;
  /* background-color: #F1F5F9; */
  /* color: #1E3A8A; */
  font-weight: 500;
  text-align: left;
  outline: none;
  min-height: 38px;
}
.field-input-green:focus { 
  border-color: #22C55E; 
  box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.2);
}
input[type="date"]::-webkit-calendar-picker-indicator { 
  cursor: pointer; 
  position: absolute; 
  right: 30px; 
}
input[type="date"].field-input-green { 
  padding-right: 60px; 
}

.cancel-btn-absolute {
  position: absolute;
  right: 6px;
  color: #9CA3AF;
  padding: 4px;
  border-radius: 4px;
  transition: color 0.2s, background-color 0.2s;
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cancel-btn-absolute:hover {
  color: #EF4444;
  background-color: #FEF2F2;
}

.pr-8 { padding-right: 2rem; }

select.field-input-green {
  text-align-last: center;
}

.field-input-green::placeholder {
  color: #94A3B8;
  opacity: 1;
  font-weight: 400;
  font-size: 12px;
}

select.field-input-green:invalid,
select.field-input-green option[value=""][disabled] {
  color: #94A3B8;
}
</style>


<style scoped>

</style>
