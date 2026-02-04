import crud from './../../../api/crud'
// initial state
const state = () => ({
  model: {
    name: "meeting" ,
    module: "meetings/meetings" ,
    title: "កិច្ចប្រជុំ" 
  },
  server: import.meta.env.VITE_API_SERVER ,
  columns: {
    all: ['id'] ,
    visible : ['id'] ,
    searchable : []
  } , 
  records: {
    all : [] ,
    selected: [] ,
    matched: [] ,
    record : null ,
    created: [] ,
    updated: [] ,
    deleted: []
  },
  pagination: {
    ids: [] ,
    page: 0 ,
    perPage: 10 ,
    search: '' ,
    totalRecords : 0 ,
    totalPages : 0 ,
    totalButtons: 10 ,
    buttons: [] ,
    start: 1 , 
    end: 1 
  }
})
// getters
const getters = {
  pagination(state, getters, rootState) {
    return state.pagination
  },
  records(state,getters,rootState){
    return state.records
  },
  rootState(state,getters,rootState){
    return rootState
  },
  server(state,getters,rootState){
    return state.server
  },
  columns(state,getters,rootState){
    return state.columns
  },
  model(state,getters,rootState){
    return state.model
  },
}

// actions
const actions = {
  /**
   * Crud functions
   */
  async list ({ state, commit, rootState },params) {
    return await crud.list(
      import.meta.env.VITE_API_SERVER+"/"+state.model.module + "?" + new URLSearchParams({
        search: params.search ,
        perPage: params.perPage ,
        page: params.page
      }).toString()
    )
  },
  async read ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read")
  },
  async create ({ state, commit, rootState },params) {
    return await crud.create(import.meta.env.VITE_API_SERVER+"/"+state.model.module+'/create',params)
  },
  async update ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.module+'/update',params)
  },
  async delete ({ state, commit, rootState },params) {
    return await crud.delete(import.meta.env.VITE_API_SERVER+"/"+state.model.module+'/delete',params)
  },
  async toggleActive({state, commit, rootState}, params){
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/toggleactive",params)
  },
  async uploadPicture({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/picture",formData)
  },
  async uploadPdf({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/pdf",formData)
  },
  async pdf ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/pdf?id="+params.id)
  },
  // Custom function
  async scheduleOnTv ({ state, commit, rootState },params) {
    return await crud.list(state.server+"/meetings/schedule" + "?" + new URLSearchParams({
          search: params.search ,
          perPage: params.perPage ,
          page: params.page
        }).toString()
      )
  },
  async regulators ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/regulators")
  },
  async toggleMeetingRegulator ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.meeting.id+"/regulator/"+params.regulator.id+'/toggle')
  },
  async toggleMeetingMember ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.meeting.id+"/member/"+params.member.id+'/toggle')
  },
  async updateMemberGroupAndRole ({ state, commit, rootState },params) {
    return await crud.create(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/update_group_role",params)
  },
  /** Regulator */
  async readRegulator ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/regulators/pdf?id="+params.id)
  },
  /** Report */
  async uploadReports({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/reports",formData)
  },
  async readReport ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/report/"+params.serial)
  },
  async removeReport ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/report/"+params.serial)
  },
  /** Tech Report */
  async uploadTechReports({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/techreports",formData)
  },
  async readTechReport ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/techreport/"+params.serial)
  },
  async removeTechReport ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/techreport/"+params.serial)
  },
  /** Preeng */
  async uploadSeichdeyPreengs({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/preengs",formData)
  },
  async readPreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/preeng/"+params.serial)
  },
  async removePreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/preeng/"+params.serial)
  },
  /** Minister Preeng */
  async uploadMinisterPreengs({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/ministerpreengs",formData)
  },
  async readMinisterPreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/ministerpreeng/"+params.serial)
  },
  async removeMinisterPreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/ministerpreeng/"+params.serial)
  },
  /** Other documents */
  async uploadOtherDocuments({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/otherdocuments",formData)
  },
  async readOtherDocument ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/otherdocument/"+params.serial)
  },
  async removeOtherDocument ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/otherdocument/"+params.serial)
  },
  /** Minister Preeng */
  async uploadMinisterPreengs({ state, commit, rootState },formData) {
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/upload/ministerpreengs",formData)
  },
  async readMinisterPreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/read/ministerpreeng/"+params.serial)
  },
  async removeMinisterPreeng ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.id+"/remove/ministerpreeng/"+params.serial)
  },

  async toggleMeetingRoom ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.module+"/"+params.meeting.id+"/room/"+params.room.id+'/toggle')
  },
  
  
}

// mutations
const mutations = {
  setModel( state, model ){
    state.model = model
  },
  setPagination(state , pagination ){
      state.pagination = pagination
  },
  setPaginationIds( state , ids ){
    state.pagination.ids = ids != null && ids != undefined && ids.length > 0 ? ids.filter( ( id ) => parseInt( id ) > 0 ) : []
  },
  setPaginationPage( state , page ){
    if( !(typeof page === 'number') ){
      throw new Error(`លេខទំព័រមិនត្រឹមត្រូវ ៖ ${page} មិនមែនជាប្រភេទតួលេខ។`)
    }
    state.pagination.page = parseInt( page )
  },
  setPaginationPerPage( state , perPage ){
    if( !(typeof perPage === 'number') ){
      throw new Error(`ចំនួនទិន្នន័យក្នុង ១ ទំព័រ មិនត្រឹមត្រូវ ៖ ${perPage} មិនមែនជាប្រភេទតួលេខ។`)
    }
    state.pagination.perPage = parseInt( perPage )
  },
  setPaginationSearch( state , search ){
    if( string == null || string == undefined ){
      throw new Error(`សូមបញ្ចូលពាក្យគន្លឹះដើម្បីស្វែងរក : ${string}`);
    }
    state.pagination.search = string
  },
  setPaginationStart( state , start ){
    if( !(typeof start === 'number') ){
      throw new Error(`លេខទំព័រមិនត្រឹមត្រូវ ៖ ${start} មិនមែនជាប្រភេទតួលេខ។`)
    }
    state.pagination.start = parseInt( start )
  },
  setPaginationEnd( state , end ){
    if( !(typeof end === 'number') ){
      throw new Error(`លេខទំព័រមិនត្រឹមត្រូវ ៖ ${end} មិនមែនជាប្រភេទតួលេខ។`)
    }
    state.pagination.end = parseInt( stendart )
  },
  setServer(state , server ){
      if( server == null || server == undefined || server == "" ){
          throw new Error(`សូមបញ្ជាក់ពី Server ៖ ${server}`);
      }
      state.server = server
  },
  setColumns(state ,columns){
    if( !Array.isArray( columns ) || ( Array.isArray( columns ) && columns.length <= 0 ) ){
        throw new Error(`សូមបញ្ចូលឈ្មោះក្បាលតារាង ៖ ${columns}`);
    }
    state.columns.all = columns
    state.columns.visible = columns
  },
  setVisibleColumns(state ,columns){
    console.log( columns)
      if( !Array.isArray( columns ) || ( Array.isArray( columns ) && columns.length <= 0 ) ){
          throw new Error(`សូមបញ្ចូលឈ្មោះក្បាលតារាង ៖ ${columns}`);
      }
      state.columns.visible = columns
  },
  setSearchableColumns(state ,columns){
      if( !Array.isArray( columns ) || ( Array.isArray( columns ) && columns.length <= 0 ) ){
          throw new Error(`សូមបញ្ចូលឈ្មោះក្បាលតារាង ៖ ${columns}`);
      }
      state.columns.searchable = columns
  },
  setAllRecords( state , records ){
    state.records.all = state.records.matched = records 
  },
  setMatchedRecords( state , records ){
    state.records.matched = records
  },
  setSelectedRecords( state , records ){
    state.records.selected = records
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}