import crud from '../../api/crud'

// initial state
const state = () => ({
  model: {
    name: "officers" ,
    title: "មន្ត្រី" 
  },
  records: [] ,
  record: null ,

})

// getters
const getters = {
  getRecords (state, getters, rootState) {
    return state.records
  },
  getRecord (state, getters, rootState) {
    return state.record
  }
}

// actions
const actions = {
  async list ({ state, commit, rootState },params) {
    return await crud.list(import.meta.env.VITE_API_SERVER+"/"+state.model.name + "?" + new URLSearchParams({
        search: params.search ,
        perPage: params.perPage ,
        page: params.page,
        wild_search: params.wild_search == true ? 1 : 0 ,
        positions: params.positions ,
        organizations: params.organizations,
        education_levels: params.educatoin_levels,
        unofficial_position_ids: params.unofficial_position_ids,
        rank_ids : params.ranks ,
        ids: params.ids,
        officer_types : params.officer_types ,
        dob: params.dob,
        unofficial_date: params.unofficial_date,
        official_date : params.official_date
      }).toString()
    )
  },
  async officersunderorganization ({ state, commit, rootState },params) {
    return await crud.list(import.meta.env.VITE_API_SERVER+"/"+state.model.name + "/reports/officersunderorganization?" + new URLSearchParams({
        search: params.search ,
        perPage: params.perPage ,
        page: params.page ,
        positions: params.positions ,
        organizations: params.organizations ,
        ids: params.ids ,
      }).toString()
    )
  },
  async read ({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/"+params.id+'/read')
  },
  async readCardPublic ({ state, commit, rootState }, params) {
    return await crud.read(
      import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/"+encodeURIComponent(params.key)+'/card'
    )
  },
  async mybackground ({ state, commit, rootState },params) {
    const query = new URLSearchParams()
    if (params?.section) {
      query.set('section', params.section)
    }
    const queryString = query.toString()
    return await crud.read(
      import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/"+params.id+'/mybackground'+(queryString ? '?'+queryString : '')
    )
  },
  async publicphoto({ state, commit, rootState },params) {
    return await crud.read(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/"+params.id+'/publicphoto')
  },
  async create ({ state, commit, rootState },params) {
    return await crud.create(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/create",params)
  },
  async createNonOfficer ({ state, commit, rootState },params) {
    return await crud.create(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/createnonofficer",params)
  },
  async delete ({ state, commit, rootState },params) {
    return await crud.delete(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/"+params.id+"/delete")
  },
  async update ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/update",params)
  },
  async updateOrganizationCode ({ state, commit, rootState },params) {
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/update_organization_code",params)
  },
  async activate({state, commit, rootState}, params){
    return await crud.update(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/activate",params)
  },
  async upload({ state, commit, rootState },formData) {    
    return await crud.upload(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/upload",formData)
  },
  async setDocumentFocal ({ state, commit, rootState },params) {
    return await crud.create(import.meta.env.VITE_API_SERVER+"/"+state.model.name+"/setfocaldocument",params)
  }
}

// mutations
const mutations = {
  // increment (state) {
  //   // `state` is the local module state
  //   state.count++
  // }
  setRecords (state, records) {
    state.records = records
  },
  setRecord (state, record) {
    state.record = record
  },

  // decrementProductInventory (state, { id }) {
  //   const product = state.all.find(product => product.id === id)
  //   product.inventory--
  // }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
