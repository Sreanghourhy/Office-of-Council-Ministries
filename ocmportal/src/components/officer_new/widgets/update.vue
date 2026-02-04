<template>
  <!-- Form edit account -->
    <div class="vcb-pop-create font-ktr">
      <n-modal v-bind:show="show" :on-esc="maskOrEscClick" :on-mask-click="maskOrEscClick" :on-after-enter="initial" transform-origin="center">
        <n-card class="w-10/12 sm:w-3/4 md:w-8/12 lg:w-3/5 xl:w-7/12" :title="'កែប្រែព័ត៌មាន' + model.title" :bordered="false" size="small">
          <template #header-extra>
            <n-button type="success" @click="update" >
              <template #icon>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><g fill="none"><path d="M3 5a2 2 0 0 1 2-2h8.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 17 6.621V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1v-4.5A1.5 1.5 0 0 1 6.5 10h7a1.5 1.5 0 0 1 1.5 1.5V16a1 1 0 0 0 1-1V6.621a1 1 0 0 0-.293-.707l-1.621-1.621A1 1 0 0 0 13.379 4H13v2.5A1.5 1.5 0 0 1 11.5 8h-4A1.5 1.5 0 0 1 6 6.5V4H5zm2 0v2.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5V4H7zm7 12v-4.5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5V16h8z" fill="currentColor"></path></g></svg>
              </template>
              រក្សារទុក
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
                        <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full p-1" >
                          <n-date-picker v-model:value="dob" type="date" format="dd-MM-yyyy"  placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-1/2" />
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
                        <n-form-item label="ស្ថានភាពរៀបការ" class="w-5/12 p-1" >
                          <n-radio-group v-model:value="record.people.marry_status" class="mx-auto" >
                            <n-space>
                              <n-radio
                              v-for="status in [{label:'នៅលីវ',value:'single'},{label:'រៀបការរួច',value:'married'},{label:'ពោះមាយ / មេមាយ',value:'divorced'}]"
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
                        <n-form-item label="លេខអត្តសញ្ញាណបណ្ណ" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.nid" placeholder="លេខអត្តសញ្ញាណបណ្ណ" />
                        </n-form-item>
                        <n-form-item label="អ៊ីមែល" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.email" placeholder="អ៊ីមែល" />
                        </n-form-item>
                        <n-form-item label="ទូរស័ព្ទផ្ទាល់ខ្លួន" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.mobile_phone" placeholder="ទូរស័ព្ទផ្ទាល់ខ្លួន" />
                        </n-form-item>
                        <n-form-item label="ទូរស័ព្ទការិយាល័យ" class="w-1/2 p-1" >
                          <n-input v-model:value="record.people.office_phone" placeholder="ទូរស័ព្ទការិយាល័យ" />
                        </n-form-item>
                        <n-form-item-row label="អសយដ្ឋានបច្ចុប្បន្ន" >
                          <n-input 
                            placeholder="អសយដ្ឋានបច្ចុប្បន្ន" 
                            class="text-left" 
                            v-model:value="record.people.address" 
                            type="textarea" show-count maxlength="5000" />
                        </n-form-item-row>
                        <n-form-item-row label="ទីកន្លែងកំណើត" >
                          <n-input placeholder="ទីកន្លែងកំណើត" class="text-left" 
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
                      <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចូលបម្រើការកម្មសិក្សារ" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="unofficial_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃខែឆ្នាំ ចូលបម្រើការ" class="w-full" />
                      </n-form-item>
                      <n-form-item label="ថ្ងៃ ខែ ឆ្នាំ ចូលពេញសិទ្ធិ (តាំងស៊ុប)" class="w-6/12 p-1" >
                        <n-date-picker v-model:value="official_date" format="dd-MM-yyyy" type="date" placeholder="ថ្ងៃ ខែ ឆ្នាំ តាំងស៊ុប" class="w-full" />
                      </n-form-item>
                      <n-form-item label="ទូរស័ព្ទ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.phone" placeholder="ទូរស័ព្ទ" />
                      </n-form-item>
                      <n-form-item label="ប្រភេទក្របខណ្ឌ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.officer_type" placeholder="ប្រភេទក្របខណ្ឌ" />
                      </n-form-item>
                      <n-form-item label="កាំប្រាក់ខែ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.salary_rank" placeholder="កាំប្រាក់ខែ" />
                      </n-form-item>
                      <n-form-item label="លេខិតឆ្លងដែន" class="w-1/2 p-1" >
                        <n-input v-model:value="record.passport" placeholder="លេខិតឆ្លងដែន" />
                      </n-form-item>
                      <n-form-item label="អ៊ីមែល" class="w-1/2 p-1" >
                        <n-input v-model:value="record.email" placeholder="អ៊ីមែល" />
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
                      <n-form-item label="តួនាទី" path="position" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedPosition"
                          filterable
                          placeholder="សូមជ្រើសរើសតួនាទី"
                          :options="positions"
                        />
                      </n-form-item> -->
                      <n-form-item label="តួនាទី" class="w-full mb-4" >
                        <n-select
                          v-model:value="selectedOrganizationStructurePosition"
                          filterable
                          placeholder="សូមជ្រើសរើសតួនាទី"
                          :options="organizationStructurePositions"
                        />
                      </n-form-item>
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
                              <n-date-picker v-model:value="fatherDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" />
                          </n-form-item>
                          <n-form-item label="លេខអត្តសញ្ញាណបណ្ណ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.father_nid" placeholder="លេខអត្តសញ្ញាណបណ្ណ" />
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
                              <n-date-picker v-model:value="motherDob" type="date" clearable format="dd-MM-yyyy" placeholder="ថ្ងៃ ខែ ឆ្នាំ កំណើត" class="w-full" />
                          </n-form-item>
                          <n-form-item label="លេខអត្តសញ្ញាណបណ្ណ" class="w-1/3 p-1" >
                              <n-input v-model:value="record.people.mother_nid" placeholder="លេខអត្តសញ្ញាណបណ្ណ" />
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
                      <n-form-item label="ទូរស័ព្ទ" class="w-1/2 p-1" >
                        <n-input v-model:value="record.people.emergency_phone" placeholder="ទូរស័ព្ទ" />
                      </n-form-item>
                      <n-form-item label="អ៊ីមែល" class="w-full p-1" >
                        <n-input v-model:value="record.people.emergency_email" placeholder="អ៊ីមែល" />
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
    const selectedCountesies = ref([])

    const organizationStructurePositions = ref([])
    const organizations = computed( () => 
      store.getters['organizations/getRecords'].map( o => ( { label: o.name , value : o.id } ) )
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
    }

    function maskOrEscClick(){
      props.onClose( 0 )
    }

    function update(){
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
          'countesy_id' : selectedCountesies.value != null ? selectedCountesies.value[0] : 0 ,
          'passport' : props.record.passport ,
          'email' : props.record.email ,
          'phone' : props.record.phone ,
          'salary_rank' : props.record.salary_rank ,
          'officer_type' : props.record.officer_type ,
          'official_date' : official_date.value != null ? dateFormat( new Date(official_date.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
          'unofficial_date' : unofficial_date.value != null ? dateFormat( new Date(unofficial_date.value) , "yyyy-mm-dd" ) : dateFormat( new Date() , "yyyy-mm-dd" ) ,
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
            'address' : props.record.people.address ,
            'pob' : props.record.people.pob ,
            'body_condition' : props.record.people.body_condition ,
            'body_condition_desp' : props.record.people.body_condition_desp ,
            'nationality' : props.record.people.nationality ,
            'national' : props.record.people.national ,
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
            title: 'រក្សារទុកព័ត៌មាន' ,
            description: res.data.message ,
            duration: 2000
          })
          clearRecord( 1 )
        }else{
          notify.error({
            title: 'រក្សារទុកព័ត៌មាន' ,
            description: 'មានបញ្ហាក្នុងពេលរក្សារទុកព័ត៌មាន។' ,
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
              title: 'រក្សារទុកព័ត៌មាន' ,
              description: res.data.message ,
              duration: 2000
            })
          }else{
            notify.error({
              title: 'រក្សារទុកព័ត៌មាន' ,
              description: 'មានបញ្ហាក្នុងពេលរក្សារទុកព័ត៌មាន។' ,
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
      store.dispatch('organizations/getOrganizationStructurePosition',{
        organization_structure_id : false
      }).then( 
        res => {
          if( res.data.ok ){
            organizationStructurePositions.value = res.data.records.map( p => {
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

    const fatherDob = ref( ( new Date() ).getTime() )
    const motherDob = ref( ( new Date() ).getTime() )

    function initial(){
      console.log( props.record )
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

      fatherDob.value = props.record.prople.father_dob != undefined && props.record.prople.father_dob.length > 0
      ? (new Date( props.record.prople.father_dob )).getTime()
      : (new Date()).getTime()

      motherDob.value = props.record.prople.mother_dob != undefined && props.record.prople.mother_dob.length > 0
      ? (new Date( props.record.prople.mother_dob )).getTime()
      : (new Date()).getTime()

      selectedOrganization.value = props.record.organization != null && props.record.organization != undefined ? props.record.organization.id : null
      selectedPosition.value = props.record.position != null && props.record.position != undefined ? props.record.position.id : null
      selectedCountesies.value = props.record.countesy != null && props.record.countesy != undefined ? [props.record.countesy.id] : null
      selectedOrganizationStructurePosition.value = props.record.current_job != null && props.record.current_job != undefined
        ? props.record.current_job.organization_structure_position_id 
        : null
    }

    return {
      /**
       * Variables
       */
      rules ,
      selectedOrganization ,
      organizations ,
      selectedPosition ,
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
      organizationStructurePositions 
    }
  }
}
</script>
<style type="text/css" scoped >
</style>