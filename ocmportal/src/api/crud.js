import axios from "axios"
import { authLogout, getAuthorization } from "./../plugins/authentication"

const buildHeaders = (headers = {}) => {
  const authorization = getAuthorization()

  return authorization
    ? { ...headers, Authorization: authorization }
    : headers
}

const handleAuthError = (error) => {
  if (error?.response?.status === 401) {
    authLogout()
  }

  return Promise.reject(error)
}

export default {
  async list(url,params){
    return await axios({
      method: 'GET' ,
      url: url ,
      data: params ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async read(url,params){
    return await axios({
      method: 'GET' ,
      url: url ,
      data: params,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async create(url,params){
    return await axios({
      method: 'POST' ,
      url: url ,
      data: params,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async update(url,params){
    return await axios({
      method: 'PUT' ,
      url: url ,
      data: params,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async patch(url,params){
    return await axios({
      method: 'PATCH' ,
      url: url ,
      data: params,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async delete(url,params){
    return await axios({
      method: 'DELETE' ,
      url: url ,
      data: params,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async upload(url,formData){
    return await axios.post( url , formData ,
      { 
        headers: buildHeaders({
          'Content-Type': 'multipart/form-data' ,
        })
      }
    ).catch(handleAuthError)
  }
}
