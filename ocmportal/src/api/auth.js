import axios from "axios"
import { authLogout, getAuthorization } from "../plugins/authentication"

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
  async login(url,params){
    return await axios({
      method: 'post' ,
      url: url ,
      data: params
    }).catch(handleAuthError)
  },
  async logout(url){
    return await axios({
      method: 'post' ,
      url: url ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async signup(url,params){
    return await axios({
      method: 'post' ,
      url: url ,
      data: params
    }).catch(handleAuthError)
  },
  async readProfile(url){
    return await axios({
      method: 'get' ,
      url: url ,
      data: params ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async updateProfile(url){
    return await axios({
      method: 'post' ,
      url: url ,
      data: params ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  
  async uploadProfilePicture(url,params){
    return await axios({
      method: 'post' ,
      url: url ,
      data: params ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  },
  async changePassword(url,params){
    return await axios({
      method: 'post' ,
      url: url ,
      data: params ,
      headers: buildHeaders()
    }).catch(handleAuthError)
  }
}
