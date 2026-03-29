export const authLogout = () => {
  try {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  } catch (error) {
    console.log(error)
  }
}
const hasExpiredToken = (token) => {
  if (!token || !token.access_token || !token.token_type) {
    return true
  }

  if (!token.expires_at) {
    return false
  }

  const expiresAt = new Date(token.expires_at)
  if (Number.isNaN(expiresAt.getTime())) {
    return false
  }

  return expiresAt < new Date()
}
export const isAuth = () => {
  try {
    const token = getToken()
    const user = getUser()

    if( user != null && !hasExpiredToken(token) ){
      return true
    }

    if( token != null || user != null ){
      authLogout()
    }

    return false
  } catch (error) {
    console.log(error)
  }
}
export const getToken = () => {
  try {
    return JSON.parse( localStorage.getItem('token') )
  } catch (error) {
    console.log(error)
  }
}
export const getAuthorization = () => {
  try {
    const token = getToken()

    if( hasExpiredToken(token) ){
      if( token != null ){
        authLogout()
      }
      return false
    }

    return token.token_type + ' ' + token.access_token
  } catch (error) {
    console.log(error)
  }
}
export const getAccessToken = () => {
  try {
    return getToken() != null ? getToken().access_token : ''
  } catch (error) {
    console.log(error)
  }
}
export const getAccessTokenType = () => {
  try {
    return getToken() != null ? getToken().token_type : ''
  } catch (error) {
    console.log(error)
  }
}
export const getExpiresAt = () => {
  try {
    const token = getToken()
    return token != null ? token.expires_at : null
  } catch (error) {
    console.log(error)
  }
}
export const setToken = (token) => {
  localStorage.setItem('token', JSON.stringify( token ));
}

export const getUser = () => {
  try {
    return JSON.parse(localStorage.getItem('user'))
  } catch (error) {
    console.log(error)
  }
}
export const setUser = (user) => {
  localStorage.setItem('user',JSON.stringify(user));
}
export const isAdmin = () => {
  let admin = getUser()
  if( isAuth() && admin !== null && admin.role == 1 ){
    return true 
  }
  return false
}
export const permissions = () => {
  let user = getUser()
  return user != null && user != undefined && user.permissions != undefined && user.permissions.length > 0 ? user.permissions : []
}
export const roles = () => {
  let user = getUser()
  return user != null && user != undefined && user.roles != undefined && user.roles.length > 0 ? user.roles : []
}
export const hasPermission = ( code ) => {
  return  Array.isArray( code ) ? (
    permissions().find( p => code.includes( p ) ) != undefined
    ? true : false
  ) : permissions().includes( code )
}
