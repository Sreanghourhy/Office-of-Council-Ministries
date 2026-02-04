import { createRouter, createWebHashHistory } from 'vue-router'
import { getRoutes } from './plugins/route'

let routes = getRoutes()

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

// Meta Handling
// router.beforeEach((to, from, next) => {
//     if ( !isAuth() ){
//         next({ path: '/' })
//     }else if(isAuth()){
//         next()
//     }
//     return false
// })

// Meta Handling
// router.beforeEach((to, from, next) => {})
// .beforeResolve(async to => {
//     if (to.meta.requiresCamera) {
//         try {
//         await askForCameraPermission()
//         } catch (error) {
//         if (error instanceof NotAllowedError) {
//             // ... handle the error and then cancel the navigation
//             return false
//         } else {
//             // unexpected error, cancel the navigation and pass the error to the global handler
//             throw error
//         }
//         }
//     }
// })

export default router