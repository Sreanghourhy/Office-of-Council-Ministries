<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick" :on-after-enter="initial" transform-origin="center">
        <n-card class="w-10/12 sm:w-3/4 md:w-8/12 lg:w-3/5 xl:w-7/12" title="កែប្រែព័ត៌មានមន្ត្រី" :bordered="false" size="small">
          <template #header-extra>
            <n-button type="success" @click="update" >
              <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
              </template>
              រក្សាទុក
            </n-button>
          </template>
          <!-- Form edit account -->
          <div class="crud-create-form w-full border-t">
            <!-- Tab -->
            <n-tabs type="segment" animated>
              <n-tab-pane name="account-detail" tab="ព័ត៌មានផ្ទាល់ខ្លួន">
                <div class="py-4" >
                  <div class=" mx-auto p-4 flex-wrap">
                    <div class="crud-form-panel w-full flex flex-wrap ">
                      <n-form v-if="record!=null" 
                        class="w-full text-left font-btb text-lg flex flex-wrap" 
                        :label-width="80"
                        :model="record"
                        :rules="rules"
                        size="large"
                        ref="formRef"
                      >
                        <n-form-item label="ត្រកូល" class="w-6/12 p-1" >
                          <n-input v-model:value="record.people.lastname" placeholder="នាមត្រកូល" />
                        </n-form-item>
                        <n-form-item label="ឈ្មោះ" class="w-6/12 p-1" >
                          <n-input v-model:value="record.people.firstname" placeholder="នាមខ្លួន" />
                        </n-form-item>
                        <n-form-item label="ត្រកូល (អង់គ្លេស)" class="w-6/12 p-1" >
                          <n-input v-model:value="record.people.enlastname" placeholder="នាមត្រកូល" />
                        </n-form-item>
                        <n-form-item label="ឈ្មោះ (អង់គ្លេស)" class="w-6/12 p-1" >
                          <n-input v-model:value="record.people.enfirstname" placeholder="នាមខ្លួន" />
                        </n-form-item>
                        <n-form-item label="ថ្ងៃខែឆ្នាំកំណើត" class="w-full p-1" >
                          <n-date-picker v-model:value="dob" type="date" format="dd-MM-yyyy"  placeholder="ថ្ងៃខែឆ្នាំកំណើត" class="w-1/2" />
                        </n-form-item>
                        <n-form-item label="ជនជាតិ" class="w-1/3 p-1" >
                            <n-radio-group v-model:value="record.people.national" name="national">
                                <n-space>
                                    <n-radio
                                        value="ខ្មែរ"
                                        label="ខ្មែរ"
                                    />
                                    <n-radio
                                        value="ផ្សេង"
                                        label="ផ្សេងទៀត"
                                    />
                                </n-space>
                            </n-radio-group>
                        </n-form-item>  
                        <n-form-item label="សញ្ជាតិ" class="w-1/3 p-1" >
                            <n-radio-group v-model:value="record.people.nationality" name="nationality">
                                <n-space>
                                    <n-radio
                                        value="ខ្មែរ"
                                        label="ខ្មែរ"
                                    />
                                    <n-radio
                                        value="ផ្សេង"
                                        label="ផ្សេងទៀត"
                                    />
                                </n-space>
                            </n-radio-group>
                        </n-form-item>  
                        <n-form-item label="ភេទ" class="w-3/12 p-1 " >
                          <n-radio-group v-model:value="record.people.gender" class="mx-auto" >
                            <n-space>
                              <n-radio
                                v-for="gender in [{label:'ស្រី',value:0},{label:'ប្រុស',value:1}]"
                                :key="gender.value"
                                :value="gender.value"
                                :label="gender.label"
                              />
                            </n-space>
                          </n-radio-group>
                        </n-form-item>
                        <n-form-item label="រៀបអាពាហ៍ពិពាហ៍" class="w-5/12 p-1" >
                          <n-radio-group v-model:value="record.people.marry_status" class="mx-auto" >
                            <n-space>
                              <n-radio
                              v-for="status in [{label:'នៅលីវ',value:'single'},{label:'រៀបអាពាហ៍ពិពាហ៍',value:'married'},{label:'ពោះមាយ / មេមាយ',value:'divorced'}]"
                              :key="status.value"
                              :value="status.value"
                              :label="status.label"
                              />
                            </n-space>
                          </n-radio-group>
                        </n-form-item>
                        <n-form-item label="កាយសម្បទា" class="w-full p-1" >
                          <n-radio-group v-model:value="record.people.body_condition" class="w-1/2" >
                            <n-space>
                              <n-radio
                              v-for="status in [{label:'គ្រប់គ្រាន់',value:'0'},{label:'មិនគ្រប់គ្រាន់',value:'1'}]"
                              :key="status.value"
                              :value="status.value"
                              :label="status.label"
                              />
                            </n-space>
                          </n-radio-group>
                          <n-input v-if="record.people.body_condition==1" v-model:value="record.people.body_condition_desp" placeholder="លក្ខណមិនគ្រប់គ្រាន់" class="w-1/2" />
                        </n-form-item>
                        <n-form-item label="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.nid" placeholder="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" />
                        </n-form-item>
                        <n-form-item label="អ៉ីមែល" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.email" placeholder="អ៉ីមែល" />
                        </n-form-item>
                        <n-form-item label="ទូរសព្ទផ្ទាល់ខ្លួន" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.mobile_phone" placeholder="ទូរសព្ទផ្ទាល់ខ្លួន" />
                        </n-form-item>
                        <n-form-item label="ទូរសព្ទការិយាល័យ" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.office_phone" placeholder="ទូរសព្ទការិយាល័យ" />
                        </n-form-item>
                        <div class="w-full mr-1 border-b border-gray-100  mb-2 " >អាសយដ្ឋាន</div>
                          <n-form-item label="ខេត្ត ក្រុង" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.address_province_id"
                              placeholder="ខេត្ត ក្រុង" 
                              filterable
                              clearable
                              :options="provinceOptions"
                              @update:value="setProvince()" >
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ស្រុក ខណ្ឌ" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.address_district_id"
                              placeholder="ស្រុក ខណ្ឌ" 
                              filterable
                              clearable
                              :options="districtOptions"
                              @update:value="setDistrict()">
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ឃុំ សង្កាត់" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.address_commune_id"
                              placeholder="ឃុំ សង្កាត់" 
                              filterable
                              clearable
                              :options="communeOptions"
                              @update:value="setCommune()">
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ភូមិ" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.address_village_id"
                              placeholder="ភូមិ" 
                              filterable
                              clearable
                              :options="villageOptions"
                              @update:value="setVillage()">
                            </n-select>
                          </n-form-item>
                          <n-form-item-row label="ព័ត៌មានផ្សេងៗពីអាសយដ្ឋាន" >
                            <n-input 
                              placeholder="ព័ត៌មានផ្សេងៗពីអាសយដ្ឋាន" 
                              class="text-left" 
                              v-model:value="record.people.address" 
                              type="textarea" show-count maxlength="5000" />
                          </n-form-item-row>
                          <div class="w-full mr-1 border-b border-gray-100  mb-2 " >ទីកន្លែងកំណើត</div>
                          <n-form-item label="ខេត្ត ក្រុង" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.pob_province_id"
                              placeholder="ខេត្ត ក្រុង" 
                              filterable
                              clearable
                              :options="pobProvinceOptions"
                              @update:value="pobSetProvince()" >
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ស្រុក ខណ្ឌ" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.pob_district_id"
                              placeholder="ស្រុក ខណ្ឌ" 
                              filterable
                              clearable
                              :options="pobDistrictOptions"
                              @update:value="pobSetDistrict()">
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ឃុំ សង្កាត់" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.pob_commune_id"
                              placeholder="ឃុំ សង្កាត់" 
                              filterable
                              clearable
                              :options="pobCommuneOptions"
                              @update:value="pobSetCommune()">
                            </n-select>
                          </n-form-item>
                          <n-form-item label="ភូមិ" class="w-1/5 p-1" >
                            <n-select 
                              v-model:value="record.people.pob_village_id"
                              placeholder="ភូមិ" 
                              filterable
                              clearable
                              :options="pobVillageOptions"
                              @update:value="pobSetVillage()">
                            </n-select>
                          </n-form-item>
                          <n-form-item-row label="ព័ត៌មានផ្សេងៗពីទីកន្លែងកំណើត" >
                            <n-input placeholder="ព័ត៌មានផ្សេងៗពីទីកន្លែងកំណើត" class="text-left" 
                            v-model:value="record.people.pob" 
                            type="textarea" show-count maxlength="5000" />
                          </n-form-item-row>
                      </n-form>
                      <div class="w-1/2 h-8"></div>  
                    </div>
                  </div>
                </div>
              </n-tab-pane>
              <n-tab-pane name="organization-detail" tab="ព័ត៌មានក្នុងអង្គភាព">
                <div class=" mx-auto p-4 flex-wrap">
                  <div class="crud-form-panel w-full flex flex-wrap ">
                    <n-form v-if="record!=null" 
                      class="w-full text-left font-btb text-lg flex flex-wrap" 
                      :label-width="80"
                      :model="record"
                      :rules="rules"
                      size="large"
                      ref="formRef"
                    >
                      <n-form-item label="អត្តលេខ" class="w-6/12 p-1" >
                        <n-input v-model:value="record.code" placeholder="អត្តលេខ" />
                      </n-form-item>
                      <!-- <n-form-item label="ថ្ងៃខែឆ្នាំចូលបម្រើការកម្មសិក្សា" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="unofficial_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃខែឆ្នាំចូលបម្រើការ" class="w-full" />
                      </n-form-item> -->
                      <n-form-item label="ថ្ងៃខែឆ្នាំចូលក្របខ័ណ្ឌ" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="unofficial_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃខែឆ្នាំចូលក្របខ័ណ្ឌ" class="w-full" />
                      </n-form-item>
                      <!-- <n-form-item label="ថ្ងៃខែឆ្នាំចូលពេញសិទ្ធិ (តាំងស៊ប់)" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="official_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃខែឆ្នាំតាំងស៊ប់" class="w-full" />
                      </n-form-item> -->
                      <n-form-item label="ថ្ងៃខែឆ្នាំតាំងស៊ប់" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="official_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃខែឆ្នាំតាំងស៊ប់" class="w-full" />
                      </n-form-item>
                      <n-form-item label="ទូរសព្ទ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.phone" placeholder="ទូរសព្ទ" />
                      </n-form-item>
                      <n-form-item label="ប្រភេទមន្ត្រី" class="w-full p-1" >
                      <n-radio-group v-model:value="record.additional_officer_type" name="radiogroup">
                        <n-space>
                          <n-radio
                            v-for="officerType in [
                              {
                                value : 'politician' ,
                                label: 'មន្ត្រីនយោបាយ'
                              },
                              {
                                value : 'admin_official' ,
                                label: 'មន្ត្រីមុខងារសាធារណៈ'
                              },
                              {
                                value : 'admin_unofficial' ,
                                label: 'មន្ត្រីជាប់កិច្ចសន្យា'
                              },
                              {
                                value : 'contracted_officer' ,
                                label: 'មន្ត្រីផ្អែកលើកិច្ចព្រមព្រៀងការងារ'
                              }
                            ]"
                            :key="officerType.value"
                            :value="officerType.value"
                            :label="officerType.label"
                          />
                        </n-space>
                      </n-radio-group>
                    </n-form-item>
                      <div v-if="record.code != undefined && record.code.length > 0 " class="w-full mb-4 " >
                        <div class="w-full py-2 " >ក្របខ័ណ្ឌ</div>
                        <div class="flex flex-wrap border border-gray-200 p-4 " >
                          <n-form-item label="ប្រភេទក្របខ័ណ្ឌ" class="w-1/2 p-1" >
                            <n-select
                              v-model:value="selectedAnk"
                              filterable
                              placeholder="ប្រភេទក្របខ័ណ្ឌ"
                              :options="ankOptions"
                              @update:value="setKrobKhan"
                              clearable
                            />
                          </n-form-item>
                          <n-form-item label="ក្របខ័ណ្ឌ" class="w-1/2 p-1" >
                            <n-select
                              v-model:value="selectedKrobKhan"
                              filterable
                              placeholder="ក្របខ័ណ្ឌ"
                              :options="krobKhanOptions"
                              @update:value="setRank"
                              clearable
                            />
                          </n-form-item>
                          <n-form-item label="ឋានន្តរស័ក្ដិ" class="w-1/2 p-1" >
                            <n-select
                              v-model:value="selectedRank"
                              filterable
                              placeholder="ឋានន្តរស័ក្ដិ"
                              :options="rankOptions"
                              @update:value="setThnak"
                              clearable
                            />
                          </n-form-item>
                          <n-form-item label="ថ្នាក់" class="w-1/2 p-1" >
                            <n-select
                              v-model:value="selectedThnak"
                              filterable
                              placeholder="ថ្នាក់"
                              :options="thnakOptions"
                              clearable
                            />
                          </n-form-item>
                        </div>
                      </div>
                      <n-form-item label="លិខិតឆ្លងដែន" class="w-1/2 p-1" >
                        <n-input v-model:value="record.passport" placeholder="លិខិតឆ្លងដែន" />
                      </n-form-item>
                      <n-form-item label="អ៉ីមែល" class="w-1/2 p-1" >
                        <n-input v-model:value="record.email" placeholder="អ៉ីមែល" />
                      </n-form-item>
                      <n-form-item label="ងារ" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedCountesies"
                          filterable
                          placeholder="សូមជ្រើសរើសងារ"
                          :options="countesies"
                          multiple
                        />
                      </n-form-item>
                      <!-- <n-form-item label="អង្គភាព" path="organization" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedOrganization"
                          filterable
                          placeholder="សូមជ្រើសរើសអង្គភាព"
                          :options="organizations"
                        />
                      </n-form-item>
                       -->
                      <n-form-item label="តួនាទី" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedOrganizationStructurePosition"
                          filterable
                          placeholder="សូមជ្រើសរើសតួនាទី"
                          :options="organizationStructurePositions"
                        />
                      </n-form-item>
                      <!-- <n-form-item label="ឋានៈស្មើ" path="position" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedUnofficialPosition"
                          filterable
                          placeholder="សូមជ្រើសរើសឋានៈស្មើ"
                          :options="positions"
                        />
                      </n-form-item> -->
                      <Transition name="slide-fade" >
                        <div 
                        v-if="record.organizationPeople != null && record.organizationPeople != undefined && record.organizationPeople.length > 0 "
                        class="w-full border border-gray-200 rounded p-4"
                        >
                          <div class="w-full mb-4" >លេខសម្កាល់មន្ត្រីក្នុងស្ថាប័នស្ថិតនៅ</div>
                          <div class="w-full mb-4" v-for="(organizationPivot, index) in record.organizationPeople" :key="index" >
                            <div class="w-full " >{{ $toKhmer( index + 1 ) + '. ' +organizationPivot.organization.name }}{{ organizationPivot.organization.code != "" && organizationPivot.organization.code != undefined && organizationPivot.organization.code.length > 0 ? ' - ' + organizationPivot.organization.code : '' }}</div>
                            <div class="w-1/2 p-4" >
                              <n-input v-model:value="organizationPivot.code" placeholder="លេខកូដ" @blur="updatePeopleCodeWithinOrganization(organizationPivot)" />
                            </div>
                          </div>
                        </div>
                      </Transition>
                    </n-form>
                  </div>
                </div>
              </n-tab-pane>
              <n-tab-pane name="parent" tab="ព័ត៌មានឪពុកម្ដាយបង្កើត" >
                <div class="parent-panel w-full flex flex-wrap" >
                  <!-- Father information -->
                  <n-form class="flex flex-wrap w-full " >
                      <div class="flex flex-wrap  w-full " >
                          <div class="w-full mb-4 border-b border-gray-200 py-2 font-btb-black " >ព័ត័មានឪពុកបង្កើត</div>
                          <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.father_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.father_firstname" placeholder="នាម ខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.father_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                          </n-form-item>
                          <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.father_enfirstname" placeholder="នាម អង់គ្លេស" />
                          </n-form-item>

                          <n-form-item label="ថ្ងៃខែឆ្នាំកំណើត" class="w-1/3 p-1" >
                              <n-date-picker v-model:value="fatherDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃខែឆ្នាំកំណើត" class="w-full" />
                          </n-form-item>
                          <n-form-item label="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.father_nid" placeholder="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="មុខរបរ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.father_profession" placeholder="មុខរបរ" />
                          </n-form-item>

                          <n-form-item label="ជនជាតិ" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.father_national" name="national">
                                  <n-space>
                                      <n-radio
                                          value="ខ្មែរ"
                                          label="ខ្មែរ"
                                      />
                                      <n-radio
                                          value="ផ្សេង"
                                          label="ផ្សេងទៀត"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="សញ្ជាតិ" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.father_nationality" name="nationality">
                                  <n-space>
                                      <n-radio
                                          value="ខ្មែរ"
                                          label="ខ្មែរ"
                                      />
                                      <n-radio
                                          value="ផ្សេង"
                                          label="ផ្សេងទៀត"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.father_death" name="death">
                                  <n-space>
                                      <n-radio
                                          :value="0"
                                          label="រស់"
                                      />
                                      <n-radio
                                          :value="1"
                                          label="ស្លាប់"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="ទីកន្លែងកំណើត" class="w-1/2 p-1" >
                              <n-input type="textarea" v-model:value="record.people.father_pob" placeholder="ទីកន្លែងកំណើត" />
                          </n-form-item>
                          <n-form-item label="អាសយដ្ឋានបច្ចុប្បន្ន" class="w-1/2 p-1" >
                              <n-input type="textarea" v-model:value="record.people.father_address" placeholder="អាសយដ្ឋានបច្ចុប្បន្ន" />
                          </n-form-item>
                      </div>
                      <!-- Mother information -->
                      <div class="w-full flex flex-wrap " >
                          <div class="w-full mb-4 border-b border-gray-200 py-2 font-btb-black " >ព័ត័មានម្ដាយបង្កើត</div>
                          <n-form-item label="គោត្តនាម (ខ្មែរ)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.mother_lastname" placeholder="គោត្តនាម ខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="នាម (ខ្មែរ)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.mother_firstname" placeholder="នាម ខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="គោត្តនាម (អង់គ្លេស)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.mother_enlastname" placeholder="គោត្តនាម អង់គ្លេស" />
                          </n-form-item>
                          <n-form-item label="នាម (អង់គ្លេស)" class="w-1/2 p-1" >
                              <n-input v-model:value="record.people.mother_enfirstname" placeholder="នាម អង់គ្លេស" />
                          </n-form-item>

                          <n-form-item label="ថ្ងៃខែឆ្នាំកំណើត" class="w-1/3 p-1" >
                              <n-date-picker v-model:value="motherDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃខែឆ្នាំកំណើត" class="w-full" />
                          </n-form-item>
                          <n-form-item label="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.mother_nid" placeholder="លេខអត្តសញ្ញាណបណ្ណសញ្ជាតិខ្មែរ" />
                          </n-form-item>
                          <n-form-item label="មុខរបរ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.mother_profession" placeholder="មុខរបរ" />
                          </n-form-item>

                          <n-form-item label="ជនជាតិ" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.mother_national" name="mother_national">
                                  <n-space>
                                      <n-radio
                                          value="ខ្មែរ"
                                          label="ខ្មែរ"
                                      />
                                      <n-radio
                                          value="ផ្សេង"
                                          label="ផ្សេងទៀត"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="សញ្ជាតិ" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.mother_nationality" name="mother_nationality">
                                  <n-space>
                                      <n-radio
                                          value="ខ្មែរ"
                                          label="ខ្មែរ"
                                      />
                                      <n-radio
                                          value="ផ្សេង"
                                          label="ផ្សេងទៀត"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="" class="w-1/3 p-1" >
                              <n-radio-group v-model:value="record.people.mother_death" name="mother_death">
                                  <n-space>
                                      <n-radio
                                          :value="0"
                                          label="រស់"
                                      />
                                      <n-radio
                                          :value="1"
                                          label="ស្លាប់"
                                      />
                                  </n-space>
                              </n-radio-group>
                          </n-form-item>  
                          <n-form-item label="ទីកន្លែងកំណើត" class="w-1/2 p-1" >
                              <n-input type="textarea" v-model:value="record.people.mother_pob" placeholder="ទីកន្លែងកំណើត" />
                          </n-form-item>
                          <n-form-item label="អាសយដ្ឋានបច្ចុប្បន្ន" class="w-1/2 p-1" >
                              <n-input type="textarea" v-model:value="record.people.mother_address" placeholder="អាសយដ្ឋានបច្ចុប្បន្ន" />
                          </n-form-item>
                      </div>
                  </n-form>
              </div>
              </n-tab-pane>
              <n-tab-pane name="emergency-contact" tab="ទំនាក់ទំនងក្នុងករណីមានអាសន្ន">
                <div class=" mx-auto p-4 flex-wrap">
                  <div class="crud-form-panel w-full flex flex-wrap ">
                    <n-form v-if="record!=null" 
                      class="w-full text-left font-btb text-lg flex flex-wrap" 
                      :label-width="80"
                      :model="record"
                      :rules="rules"
                      size="large"
                      ref="formRef"
                    >
                      <n-form-item label="គោត្តនាម" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_lastname" placeholder="គោត្តនាម" />
                      </n-form-item>
                      <n-form-item label="នាម" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_firstname" placeholder="នាម" />
                      </n-form-item>
                      <n-form-item label="ភេទ" class="w-1/2 p-1" >
                        <n-radio-group v-model:value="record.people.emergency_gender" class="w-full" >
                          <n-space>
                            <n-radio
                            v-for="status in [{label:'ប្រុស',value:1},{label:'ស្រី',value:0},{label:'ផ្សេងៗ',value:2}]"
                            :key="status.value"
                            :value="status.value"
                            :label="status.label"
                            />
                          </n-space>
                        </n-radio-group>
                      </n-form-item>
                      <n-form-item label="ទំនាក់ទំនងត្រូវជា" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_relationship" placeholder="ទំនាក់ទំនងត្រូវជា" />
                      </n-form-item>
                      <n-form-item label="មុខរបរ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_profession" placeholder="មុខរបរ" />
                      </n-form-item>
                      <n-form-item label="ទូរសព្ទ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_phone" placeholder="ទូរសព្ទ" />
                      </n-form-item>
                      <n-form-item label="អ៉ីមែល" class="w-full p-1" >
                        <n-input v-model:value="record.people.emergency_email" placeholder="អ៉ីមែល" />
                      </n-form-item>
                      <n-form-item label="អាសយដ្ឋាន" class="w-full p-1" >
                        <n-input v-model:value="record.people.emergency_address" placeholder="អាសយដ្ឋាន" />
                      </n-form-item>
                    </n-form>
                  </div>
                </div>
              </n-tab-pane>
            </n-tabs>
          </div>
          <!-- End form edit account -->
          <template #footer></template>
        </n-card>
      </n-modal>
    </div>
    <!-- End of edit account -->
</template>
<script>
import { reactive , ref , computed } from 'vue'
import { useStore } from 'vuex'
import { useMessage, useNotification } from 'naive-ui'

import dateFormat from "dateformat";
import { keysWithFilter } from 'naive-ui/es/tree/src/utils';

export default {
  watch: {
  },
  props: {
    model: {
      type: Object ,
      required: true ,
      default: () => {
        return reactive({
          name: 'Undefined' ,
          title: 'No title'
        })
      },
      // validator: (val) => {}
    } , 
    record: {
      type: Object ,
      required: true ,
      default: () => {
        return reactive({
          id: 0 ,
          firstname: '' ,
          lastname: '' ,
          email: '' ,
          gender: '' ,
          mobile_phone: '' ,
          office_phone: '' ,
          dob: null ,
          nid: '' ,
          marry_status: null ,
          user: null ,
          orgainzations: [] ,
          positions: [] ,
          official_date ,
          unofficial_date 
        })
      },
    },
    show: {
      type: Boolean ,
      default: false
    },
    onClose: {
      type: Function
    } ,
    // onShow: {
    //   type: Function
    // }
  },
  setup(props){
    var store = useStore()
    const message = useMessage()
    const notify = useNotification()

    const selectedOrganization = ref(null)
    const selectedOrganizationStructurePosition = ref(null)
    const selectedPosition = ref(null)
    const selectedUnofficialPosition = ref(null)
    const selectedCountesies = ref([])

    const organizationStructurePositions = ref([])
    const organizations = computed( () => 
      store.getters['organization/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    )
    const positions = computed( () => 
      store.getters['position/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
    ) 
    const countesies = computed( () => 
      store.getters['countesy/getRecords'].map( c => ( { label: c.name , value : c.id } ) )
    ) 
    
    const dob = ref( null )

    const official_date = ref( null )

    const unofficial_date = ref( null )

    /**
     * Variables
     */    
    var rules = {
        firstname: {
          required: true,
          message: 'សូមបញ្ចូលឈ្មោះ',
          trigger: [ 'blur']
        },
        lastname: {
          required: true,
          message: 'សូមបញ្ចូលត្រកូល',
          trigger: [ 'blur']
        }
    }
    /**
     * Functions
     */
     function clearRecord( actionStatus ){
      props.onClose( actionStatus )
      selectedAnk.value = null
      selectedKrobKhan.value = null 
      selectedThnak.value = null
      selectedRank.value = null
    }

    function maskOrEscClick(){
      props.onClose( 0 )
      selectedAnk.value = null
      selectedKrobKhan.value = null 
      selectedThnak.value = null
      selectedRank.value = null
    }

    function update(){
      // if( props.record.code != undefined && props.record.code.length > 0 ){
      //   if( 
      //     selectedAnk.value == "" || selectedAnk.value == null ||
      //     selectedKrobKhan.value == "" || selectedKrobKhan.value == null ||
      //     selectedRank.value == "" || selectedRank.value == null ||
      //     selectedThnak.value == "" || selectedThnak.value == null
      //   ){
      //     notify.warning({
      //       title: 'ពិនិត្យព័ត៌មាន' ,
      //       description: 'សូមបំពេញព័ត៌មានពីក្របខ័ណ្ឌអោយបានពេញលេញ។' ,
      //       duration: 2000
      //     })
      //     return false
      //   }
      // }
      if( props.model === undefined || props.model.name == "" ){
        notify.warning({
          title: 'ពិនិត្យព័ត៌មាន' ,
          description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
          duration: 2000
        })
        return false
      }
      store.dispatch( props.model.name+'/update',
        {
          'id' : props.record.id ,
          'code' : props.record.code ,
          'organization_structure_position_id' : selectedOrganizationStructurePosition.value != null ? selectedOrganizationStructurePosition.value : 0 ,
          'organization_id' : selectedOrganization.value != null ? selectedOrganization.value : 0 ,
          'position_id' : selectedPosition.value != null ? selectedPosition.value : 0 ,
          'unofficial_position_id' : parseInt( selectedUnofficialPosition.value ) > 0 ? selectedUnofficialPosition.value : 0 ,
          'countesy_id' : selectedCountesies.value != null ? selectedCountesies.value[0] : 0 ,
          'passport' : props.record.passport ,
          'email' : props.record.email ,
          'phone' : props.record.phone ,
          'salary_rank' : props.record.salary_rank ,
          'officer_type' : props.record.officer_type ,
          'additional_officer_type' : props.record.additional_officer_type ,
          'official_date' : official_date.value != null ? dateFormat( new Date(official_date.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'unofficial_date' : unofficial_date.value != null ? dateFormat( new Date(unofficial_date.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'ank' : selectedAnk.value != null && selectedAnk.value.length > 0 ? selectedAnk.value : ( props.record.rank != undefined ? props.record.rank.ank : '' ) ,
          'krobkhan' : selectedKrobKhan.value != null && selectedKrobKhan.value.length > 0 ? selectedKrobKhan.value : ( props.record.rank != undefined ? props.record.rank.krobkhan : '' ) ,
          'rank' : selectedRank.value != null && selectedRank.value.length > 0 ? selectedRank.value : ( props.record.rank != undefined ? props.record.rank.rank : '' ) ,
          'thnak' : selectedThnak.value != null && selectedThnak.value.length > 0 ? selectedThnak.value : ( props.record.rank != undefined ? props.record.rank.thnak : '' ) ,
          'people' : {
            'firstname' : props.record.people.firstname ,
            'lastname' : props.record.people.lastname ,
            'enfirstname' : props.record.people.enfirstname ,
            'enlastname' : props.record.people.enlastname ,
            'gender' : props.record.people.gender ,
            'email' : props.record.people.email ,
            'mobile_phone' : props.record.people.mobile_phone ,
            'office_phone' : props.record.people.office_phone ,
            'dob' : dob.value != null ? dateFormat( new Date(dob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
            'nid' : props.record.people.nid ,
            'passport' : props.record.people.passport ,
            'marry_status' : props.record.people.marry_status ,
            'body_condition' : parseInt( props.record.people.body_condition ),
            'body_condition_desp' : props.record.people.body_condition_desp ,
            'nationality' : props.record.people.nationality ,
            'national' : props.record.people.national ,
            'address' : props.record.people.address ,
            'address_province_id' : parseInt( props.record.people.address_province_id ) ,
            'address_district_id' : parseInt( props.record.people.address_district_id ) ,
            'address_commune_id' : parseInt( props.record.people.address_commune_id ) ,
            'address_village_id' : parseInt( props.record.people.address_village_id ) ,
            'pob' : props.record.people.pob ,
            'pob_province_id' : parseInt( props.record.people.pob_province_id ) ,
            'pob_district_id' : parseInt( props.record.people.pob_district_id ) ,
            'pob_commune_id' : parseInt( props.record.people.pob_commune_id ) ,
            'pob_village_id' : parseInt( props.record.people.pob_village_id ) ,
            // parent 
            // father 
            'father_lastname' : props.record.people.father_lastname ,
            'father_firstname' : props.record.people.father_firstname ,
            'father_enlastname' : props.record.people.father_enlastname ,
            'father_enfirstname' : props.record.people.father_enfirstname ,
            'father_dob' : fatherDob.value != null ? dateFormat( new Date(fatherDob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
            'father_pob' : props.record.people.father_pob ,
            'father_address' : props.record.people.father_address ,
            'father_nid' : props.record.people.father_nid ,
            'father_profession' : props.record.people.father_profession ,
            'father_death' : props.record.people.father_death ,

            'father_nationality' : props.record.people.father_nationality ,
            'father_national' : props.record.people.father_national ,
            // mother 
            'mother_lastname' : props.record.people.mother_lastname ,
            'mother_firstname' : props.record.people.mother_firstname ,
            'mother_enlastname' : props.record.people.mother_enlastname ,
            'mother_enfirstname' : props.record.people.mother_enfirstname ,
            'mother_dob' : motherDob.value != null ? dateFormat( new Date(motherDob.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
            'mother_pob' : props.record.people.mother_pob ,
            'mother_address' : props.record.people.mother_address ,
            'mother_nid' : props.record.people.mother_nid ,
            'mother_profession' : props.record.people.mother_profession ,
            'mother_death' : props.record.people.mother_death ,
            
            'mother_nationality' : props.record.people.mother_nationality ,
            'mother_national' : props.record.people.mother_national ,
            // Emergency 
            'emergency_lastname' : props.record.people.emergency_lastname ,
            'emergency_firstname' : props.record.people.emergency_firstname ,
            'emergency_gender' : props.record.people.emergency_gender ,
            'emergency_relationship' : props.record.people.emergency_relationship ,
            'emergency_profession' : props.record.people.emergency_profession ,
            'emergency_address' : props.record.people.emergency_address ,
            'emergency_phone' : props.record.people.emergency_phone ,
            'emergency_email' : props.record.people.emergency_email
          }
        }
      // {
      //   id: props.record.id ,
      //   firstname: props.record.firstname ,
      //   lastname: props.record.lastname ,
      //   gender: props.record.gender ,
      //   email: props.record.email.toLowerCase() ,
      //   mobile_phone: props.record.mobile_phone ,
      //   office_phone: props.record.office_phone ,
      //   dob: props.record.dob ,
      //   nid: props.record.nid ,
      //   marry_status: props.record.marry_status ,
      //   organizations: selectedOrganization.value ,
      //   positions: selectedPosition.value ,
      //   countesies: selectedCountesies.value
      // }
    ).then( res => {
        if( res.data.ok ){
          notify.success({
            title: 'រក្សាទុកព័ត៌មាន' ,
            description: res.data.message ,
            duration: 2000
          })
          clearRecord( 1 )
        }else{
          notify.error({
            title: 'រក្សាទុកព័ត៌មាន' ,
            description: 'មានបញ្ហាក្នុងពេលរក្សាទុកព័ត៌មាន។' ,
            duration: 2000
          })
        }
      }).catch( err => {
        message.error( err )
      })
      clearRecord( 0 )
    }

    function updatePeopleCodeWithinOrganization(organizationPivot){
      if( organizationPivot.code != "" && organizationPivot.code.length > 0 ){
        if( props.model === undefined || props.model.name == "" ){
          notify.warning({
            title: 'ពិនិត្យព័ត៌មាន' ,
            description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
            duration: 2000
          })
          return false
        }
        store.dispatch( props.model.name+'/updateOrganizationCode',{
          people_id: organizationPivot.people_id ,
          organization_id : organizationPivot.organization_id ,
          code : organizationPivot.code
        }).then( res => {
          if( res.data.ok ){
            notify.success({
              title: 'រក្សាទុកព័ត៌មាន' ,
              description: res.data.message ,
              duration: 2000
            })
          }else{
            notify.error({
              title: 'រក្សាទុកព័ត៌មាន' ,
              description: 'មានបញ្ហាក្នុងពេលរក្សាទុកព័ត៌មាន។' ,
              duration: 2000
            })
          }
        }).catch( err => {
          message.error( err )
        })
      }
    }
  
    // function getRecord(){
    //   if( props.model === undefined || props.model.name == "" ){
    //     notify.warning({
    //       title: 'ពិនិត្យព័ត៌មាន' ,
    //       description: 'ទម្រង់នៃព័ត៌មានមិនទាន់បានកំណត់។' ,
    //       duration: 2000
    //     })
    //     return false
    //   }
    //   store.dispatch( props.model.name+'/read',{ id : props.record.id }).then( res => {
    //     if( res.data.ok ){
    //       notify.success({
    //         title: 'អានព័ត៌មាន' ,
    //         description: res.data.message ,
    //         duration: 2000
    //       })
    //     }else{
    //       notify.error({
    //         title: 'អានព័ត៌មាន' ,
    //         description: 'មានបញ្ហាក្នុងពេលអានព័ត៌មាន។' ,
    //         duration: 2000
    //       })
    //     }
    //   }).catch( err => {
    //     message.error( err )
    //   })
    // }

    function getPositionStructures(){
      store.dispatch('organization/getOrganizationStructurePosition',{
        organization_structure_id : false
      }).then( 
        res => {
          if( res.data.ok ){
            organizationStructurePositions.value = res.data.records.filter( p => {
              return p.organizationStructure != undefined
            }).map( p => {
              return {
                label : p.organizationStructure.organization.name + ' - ' + p.position.name ,
                value : p.id
              }
            })
          }else{
            notify.info({
              title: 'អានព័ត៌មានតួនាទី' ,
              content: res.data.message
            })
          }
        }
      ).catch( err => {
        console.log( err )
      })
    }

    const selectedProvince = ref(null)
    const selectedDistrict = ref(null)
    const selectedCommune = ref(null)
    const selectedVillage = ref(null)
    const pobSelectedProvince = ref(null)
    const pobSelectedDistrict = ref(null)
    const pobSelectedCommune = ref(null)
    const pobSelectedVillage = ref(null)
    const provinceOptions = computed( () => {
        return store.getters['province/records'].all.length != undefined || store.getters['province/records'].all.length > 0 
          ? store.getters['province/records'].all.map( ( p ) => { return { label: p.name_kh , value : p.id } } )
          : [{ label : 'មិនមាន ខេត្ត ឬ​ ក្រុង ឡើយ' , value : null }]
    })
    const districtOptions = computed( () => {
      return selectedProvince.value != undefined && selectedProvince.value != null  && selectedProvince.value.id > 0
        ? store.getters['district/records'].all.filter( (d) => d.province_id == selectedProvince.value.id ).map( ( d ) => { return { label: d.name_kh , value : d.id } } )
        : store.getters['district/records'].all.map( ( d ) => { return { label: d.name_kh , value : d.id } } )
    })
    const communeOptions = computed( () => {
      return selectedDistrict.value != undefined && selectedDistrict.value != null  && selectedDistrict.value.id > 0
        ? store.getters['commune/records'].all.filter( (c) => c.district_id == selectedDistrict.value.id ).map( ( c ) => { return { label: c.name_kh , value : c.id } } )
        : store.getters['commune/records'].all.map( ( c ) => { return { label: c.name_kh , value : c.id } } )
    })
    const villageOptions = computed( () => {
      return selectedCommune.value != undefined && selectedCommune.value != null  && selectedCommune.value.id > 0
        ? store.getters['village/records'].all.filter( (v) => v.commune_id == selectedCommune.value.id ).map( ( v ) => { return { label: v.name_kh , value : v.id } } )
        : store.getters['village/records'].all.map( ( v ) => { return { label: v.name_kh , value : v.id } } )
    })
    const pobProvinceOptions = computed( () => {
        return store.getters['province/records'].all.length != undefined || store.getters['province/records'].all.length > 0 
          ? store.getters['province/records'].all.map( ( p ) => { return { label: p.name_kh , value : p.id } } )
          : [{ label : 'មិនមាន ខេត្ត ឬ​ ក្រុង ឡើយ' , value : null }]
    })
    const pobDistrictOptions = computed( () => {
        return pobSelectedProvince.value != undefined && pobSelectedProvince.value != null  && pobSelectedProvince.value.id > 0
        ? store.getters['district/records'].all.filter( (d) => d.province_id == pobSelectedProvince.value.id ).map( ( d ) => { return { label: d.name_kh , value : d.id } } )
        : store.getters['district/records'].all.map( ( d ) => { return { label: d.name_kh , value : d.id } } )
    })
    const pobCommuneOptions = computed( () => {
        return pobSelectedDistrict.value != undefined && pobSelectedDistrict.value != null  && pobSelectedDistrict.value.id > 0
        ? store.getters['commune/records'].all.filter( (c) => c.district_id == pobSelectedDistrict.value.id ).map( ( c ) => { return { label: c.name_kh , value : c.id } } )
        : store.getters['commune/records'].all.map( ( c ) => { return { label: c.name_kh , value : c.id } } )
    })
    const pobVillageOptions = computed( () => {
        return pobSelectedCommune.value != undefined && pobSelectedCommune.value != null  && pobSelectedCommune.value.id > 0
        ? store.getters['village/records'].all.filter( (v) => v.commune_id == pobSelectedCommune.value.id ).map( ( v ) => { return { label: v.name_kh , value : v.id } } )
        : store.getters['village/records'].all.map( ( v ) => { return { label: v.name_kh , value : v.id } } )
    })
    function setProvince(){
      selectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.address_province_id )
      selectedDistrict.value = null
      selectedCommune.value = null
      selectedVillage.value = null
      props.record.people.address_district_id = null
      props.record.people.address_commune_id = null
      props.record.people.address_village_id = null
    }

    function setDistrict(){
      selectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.address_district_id )
      selectedCommune.value = null
      selectedVillage.value = null
      props.record.people.address_commune_id = null
      props.record.people.address_village_id = null
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedDistrict.value != null && selectedDistrict.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedDistrict.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
    }

    function setCommune(){
      // selectedCommune.value = selectedDistrict.value.communes.find( d => d.id == props.record.people.address_commune_id )
      selectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.address_commune_id )
      selectedVillage.value = null
      props.record.people.address_village_id = null
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedCommune.value != null && selectedCommune.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedCommune.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
      if( selectedDistrict.value == null || ( selectedDistrict.value != null && selectedCommune.value != null && selectedCommune.value.district_id != selectedDistrict.value.id ) ){
        selectedDistrict.value = store.getters['district/records'].all.find( d => d.id == selectedCommune.value.district_id )
        props.record.people.address_district_id = selectedDistrict.value.id
      }
    }

    function setVillage(){
      // selectedVillage.value = selectedCommune.value.villages.find( d => d.id == props.record.people.address_village_id )
      selectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.address_village_id )
      // Check whether the parent province is the right one
      if( selectedProvince.value == null || ( selectedProvince.value != null && selectedCommune.value != null && selectedVillage.value.province_id != selectedProvince.value.id ) ){
        selectedProvince.value = store.getters['province/records'].all.find( p => p.id == selectedVillage.value.province_id )
        props.record.people.address_province_id = selectedProvince.value.id
      }
      if( selectedDistrict.value == null || ( selectedDistrict.value != null && selectedVillage.value != null && selectedVillage.value.district_id != selectedDistrict.value.id ) ){
        selectedDistrict.value = store.getters['district/records'].all.find( d => d.id == selectedVillage.value.district_id )
        props.record.people.address_district_id = selectedDistrict.value.id
      }
      if( selectedCommune.value == null || ( selectedCommune.value != null && selectedVillage.value != null && selectedVillage.value.commune_id != selectedCommune.value.id ) ){
        selectedCommune.value = store.getters['commune/records'].all.find( c => c.id == selectedVillage.value.commune_id )
        props.record.people.address_commune_id = selectedCommune.value.id
      }
    }

    function pobSetProvince(){
      pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.pob_province_id )
      pobSelectedDistrict.value = null
      pobSelectedCommune.value = null
      pobSelectedVillage.value = null
      props.record.people.pob_district_id = null 
      props.record.people.pob_commune_id = null 
      props.record.people.pob_village_id = null 
    }

    function pobSetDistrict(){
      // pobSelectedDistrict.value = pobSelectedProvince.value.districts.find( d => d.id == props.record.people.pob_district_id )
      pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.pob_district_id )
      pobSelectedCommune.value = null
      pobSelectedVillage.value = null
      props.record.people.pob_commune_id = null 
      props.record.people.pob_village_id = null 
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedDistrict.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedDistrict.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
    }

    function pobSetCommune(){
      // pobSelectedCommune.value = pobSelectedDistrict.value.communes.find( d => d.id == props.record.people.pob_commune_id )
      pobSelectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.pob_commune_id )
      pobSelectedVillage.value = null
      props.record.people.pob_village_id = null 
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedCommune.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedCommune.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
      if( pobSelectedDistrict.value == null || ( pobSelectedDistrict.value != null && pobSelectedDistrict.value != null && pobSelectedCommune.value.district_id != pobSelectedDistrict.value.id ) ){
        pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == pobSelectedCommune.value.district_id )
        props.record.people.pob_district_id = pobSelectedDistrict.value.id
      }
    }

    function pobSetVillage(){
      // pobSelectedVillage.value = pobSelectedCommune.value.villages.find( d => d.id == props.record.people.pob_village_id )
      pobSelectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.pob_village_id )
      // Check whether the parent province is the right one
      if( pobSelectedProvince.value == null || ( pobSelectedProvince.value != null && pobSelectedProvince.value != null && pobSelectedVillage.value.province_id != pobSelectedProvince.value.id ) ){
        pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == pobSelectedVillage.value.province_id )
        props.record.people.pob_province_id = pobSelectedProvince.value.id
      }
      if( pobSelectedDistrict.value == null || ( pobSelectedDistrict.value != null && pobSelectedDistrict.value != null && pobSelectedVillage.value.district_id != pobSelectedDistrict.value.id ) ){
        pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == pobSelectedVillage.value.district_id )
        props.record.people.pob_district_id = pobSelectedDistrict.value.id
      }
      if( pobSelectedCommune.value == null || ( pobSelectedCommune.value != null && pobSelectedCommune.value != null && pobSelectedVillage.value.commune_id != pobSelectedCommune.value.id ) ){
        pobSelectedCommune.value = store.getters['commune/records'].all.find( p => p.id == pobSelectedVillage.value.commune_id )
        props.record.people.pob_commune_id = pobSelectedCommune.value.id
      }
    }

    const anks = ref([])
    const selectedAnk = ref(null)
    function getRankStructure(){
      anks.value = store.getters['rank/records'].all
      if( props.record.rank != undefined && props.record.rank != null ){
        selectedAnk.value = props.record.rank.ank
        selectedKrobKhan.value = props.record.rank.krobkhan
        selectedRank.value = props.record.rank.rank
        selectedThnak.value = props.record.rank.thnak
        updateKrobKhan()
      }
    }    
    const ankOptions = computed(()=>{
      return anks.value != undefined && Array.isArray( anks.value ) && anks.value.length > 0
        ? (
          anks.value.map( ( v ) => { return { label: v.ank , value : v.ank } } )
        )
        : [ { label: 'មិនមានវិស័យ' , value : 0 } ]
    })
    const krobkhans = ref([])
    const selectedKrobKhan = ref(null)
    const selectedRank = ref(null)
    const ranks = ref([])
    function setKrobKhan(){
      krobkhanHandleUpdateCounter.value++
      selectedRank.value = null
      selectedThnak.value = null 
      updateKrobKhan()
    }
    function updateKrobKhan(){
      krobkhans.value = []
      let v = anks.value.find( ( val ) => val.ank == selectedAnk.value )
      if( v != undefined ){
        krobkhans.value = v.krobkhans
        if( krobkhanHandleUpdateCounter.value <= 1 ) {
          selectedKrobKhan.value = props.record.rank != null && props.record.rank != undefined ? props.record.rank.krobkhan : null 
        }
        if( v.krobkhans.find( k => k.krobkhan == selectedKrobKhan.value ) == undefined ){
          selectedKrobKhan.value = null
        }
        updateRank()
      }else{
        notify.info({
          title: 'ព័ត៌មានក្របខ័ណ្ឌ' ,
          content : 'មិនមានព័ត៌មានពីអង្គនេះឡើយ'  ,
          duration: 2000
        })
      }
    }
    const krobKhanOptions = computed( () => {
      if( krobkhans.value != undefined && Array.isArray( krobkhans.value ) && krobkhans.value.length > 0 ){
        let uniqueKrobKhans = new Array()
        for( let i in krobkhans.value ){
          if ( uniqueKrobKhans.indexOf( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name ) == -1 ){
            // uniqueKrobKhans.push( krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name )
            uniqueKrobKhans.push( {
              label: krobkhans.value[i].krobkhan + "." + krobkhans.value[i].krobkhan_name ,
              value : krobkhans.value[i].krobkhan
            } )
          }
        }
        return uniqueKrobKhans.map( ( k ) => { return { label: k.label , value : k.value } } )
      }else{
        return [ { label: 'មិនមានក្របខ័ណ្ឌ' , value : 0 } ]
      }
    })
    const rankOptions = computed( () => {
      if( Array.isArray( ranks.value ) && ranks.value.length > 0 ){
        return ranks.value
      }else{
        return [ { label: 'មិនមានឋានន្តរស័ក្តិ' , value : 0 } ]
      }
    })
    function setRank(){
      selectedThnak.value = null 
      updateRank()
    }
    function updateRank(){
      ranks.value = []
      selectedRank.value = null
      selectedThnak.value = null 
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan == selectedKrobKhan.value ){
            for( let j in krobkhans.value[i].ranks ){
              ranks.value.push( {
                label: krobkhans.value[i].ranks[j].krobkhan+'.'+krobkhans.value[i].ranks[j].rank+'. ' + krobkhans.value[i].ranks[j].name ,
                value: krobkhans.value[i].ranks[j].rank
              })
            }
            if( krobkhanHandleUpdateCounter.value <= 1 ) {
              selectedRank.value = props.record.rank.rank
            }
            if( krobkhans.value[i].ranks.find( r => r.rank == selectedRank.value ) == undefined ){
              selectedRank.value = null
            }
            updateThnaks()
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានឋានន្តរស័ក្តិ' ,
          content : 'មិនមានព័ត៌មានឋានន្តរស័ក្តិ' ,
          duration: 2000
        })
      }
    }
    const selectedThnak = ref(null)
    const thnaks = reactive({
      key: '' ,
      options: []
    })
    function setThnak(){
      updateThnaks()
    }
    function updateThnaks(){
      thnaks.key = '' 
      thnaks.options = []
      selectedThnak.value = null 
      if( krobkhans.value.length > 0 ){
        for( let i in krobkhans.value ){
          if( krobkhans.value[i].krobkhan == selectedKrobKhan.value ){
            for( let j in krobkhans.value[i].ranks ){
              if( krobkhans.value[i].ranks[j].rank == selectedRank.value ){
                thnaks.key = krobkhans.value[i].ranks[j].rank
                thnaks.options = krobkhans.value[i].ranks[j].thnaks.map( t => { 
                  return { 
                    label: krobkhans.value[i].ranks[j].krobkhan+'.'+krobkhans.value[i].ranks[j].rank+'.'+t.thnak ,
                    value : t.thnak
                  }
                })

              }
            }
            if( krobkhanHandleUpdateCounter.value <= 1 ) {
              selectedThnak.value = props.record.rank.thnak
            }
            console.log( thnaks.options )
            if( Array.isArray( thnaks.options ) && thnaks.options.length > 0 ){
              thnaks.options.find( t => t.value == selectedThnak.value ) == undefined
            }else{
              selectedThnak.value = null
            }
          }
        }
      }else{
        notify.info({
          title: 'ព័ត៌មានឋានន្តរស័ក្តិ' ,
          content : 'មិនមានព័ត៌មានឋានន្តរស័ក្តិ' ,
          duration: 2000
        })
      }
    }
    const thnakOptions = computed( () => {
      if( thnaks.options != undefined && Array.isArray( thnaks.options ) && thnaks.options.length > 0 ){
        return thnaks.options
      }else{
        return [ { label: 'មិនមានថ្នាក់' , value : 0 } ]
      }
    })

    const fatherDob = ref( ( new Date() ).getTime() )
    const motherDob = ref( ( new Date() ).getTime() )
    const krobkhanHandleUpdateCounter = ref(0)
    function initial(){
      console.log( "INITIAL UPDATE" )
      console.log( props.record )
      krobkhanHandleUpdateCounter.value = 0
      getRankStructure()
      getPositionStructures( false )
      // getRecord()
      dob.value = props.record.people.dob != undefined && props.record.people.dob.length > 0
        ? (new Date( props.record.people.dob )).getTime()
        : (new Date()).getTime()
      official_date.value = props.record.official_date != undefined && props.record.official_date.length > 0
        ? (new Date( props.record.official_date )).getTime()
        : (new Date()).getTime()

      unofficial_date.value = props.record.unofficial_date != undefined && props.record.unofficial_date.length > 0
        ? (new Date( props.record.unofficial_date )).getTime()
        : (new Date()).getTime()

      fatherDob.value = props.record.people.father_dob != undefined && props.record.people.father_dob.length > 0
      ? (new Date( props.record.people.father_dob )).getTime()
      : (new Date()).getTime()

      motherDob.value = props.record.people.mother_dob != undefined && props.record.people.mother_dob.length > 0
      ? (new Date( props.record.people.mother_dob )).getTime()
      : (new Date()).getTime()

      selectedOrganization.value = props.record.organization != null && props.record.organization != undefined ? props.record.organization.id : null
      selectedPosition.value = props.record.position != null && props.record.position != undefined ? props.record.position.id : null
      selectedUnofficialPosition.value = props.record.current_job != null && props.record.current_job != undefined ? props.record.current_job.unofficial_position_id : null
      selectedCountesies.value = props.record.countesy != null && props.record.countesy != undefined ? [props.record.countesy.id] : null
      selectedOrganizationStructurePosition.value = props.record.current_job != null && props.record.current_job != undefined
        ? props.record.current_job.organization_structure_position_id 
        : null
      selectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.address_province_id )
      selectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.address_district_id )
      selectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.address_commune_id )
      selectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.address_village_id )
      
      pobSelectedProvince.value = store.getters['province/records'].all.find( p => p.id == props.record.people.pob_province_id )
      pobSelectedDistrict.value = store.getters['district/records'].all.find( p => p.id == props.record.people.pob_district_id )
      pobSelectedCommune.value = store.getters['commune/records'].all.find( p => p.id == props.record.people.pob_commune_id )
      pobSelectedVillage.value = store.getters['village/records'].all.find( p => p.id == props.record.people.pob_village_id )
      
      
    }

    return {
      /**
       * Variables
       */
      rules ,
      selectedOrganization ,
      organizations ,
      selectedPosition ,
      selectedUnofficialPosition ,
      positions ,
      selectedCountesies ,
      countesies ,
      dob ,
      official_date ,
      unofficial_date , 
      fatherDob ,
      motherDob ,
      /**
       * Functions
       */
      update  ,
      initial ,
      clearRecord ,
      maskOrEscClick ,
      updatePeopleCodeWithinOrganization  ,
      selectedOrganizationStructurePosition ,
      organizationStructurePositions  ,
      setProvince,
      setDistrict,
      setCommune,
      setVillage,
      pobSetProvince,
      pobSetDistrict,
      pobSetCommune,
      pobSetVillage,
      provinceOptions,
      districtOptions,
      communeOptions,
      villageOptions,
      pobProvinceOptions,
      pobDistrictOptions,
      pobCommuneOptions,
      pobVillageOptions ,
      selectedAnk ,
      selectedKrobKhan ,
      selectedRank , 
      selectedThnak ,
      ankOptions ,
      krobKhanOptions ,
      rankOptions ,
      thnakOptions ,
      setKrobKhan ,
      updateKrobKhan ,
      setRank ,
      updateRank ,
      setThnak ,
      updateThnaks
    }
  }
}
</script>
<style type="text/css" scoped >
</style>