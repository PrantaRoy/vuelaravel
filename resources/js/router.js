import {createWebHistory, createRouter} from 'vue-router';

import home from './pages/home.vue';
import register from './pages/register.vue';
import login from './pages/login.vue';
import about from './pages/about.vue';
import dashboard from './pages/dashboard.vue';
import profile from './pages/profile.vue';
import password from './pages/password.vue';
import store from './store/index.js';

import taskedit from './pages/taskedit.vue';

const routes = [
     {
          path:'/',
          name : 'Home',
          component : home
     },
     {
          path:'/login',
          name : 'Login',
          component : login,
          meta:{
               requiresAuth:false
          }
     },
     {
          path:'/register',
          name : 'Register',
          component : register,
          meta:{
               requiresAuth:false
          }
     },
     {
          path:'/about',
          name : 'About',
          component : about
     },
     {
          path:'/dashboard',
          name : 'Dashboard',
          component : dashboard,
          meta:{
               requiresAuth:true
          }
     },
     {
          path:'/profile',
          name : 'Profile',
          component : profile,
          meta:{
               requiresAuth:true
          }
     },
     {
          path:'/password',
          name : 'Password',
          component : password,
          meta:{
               requiresAuth:true
          }
     },
     {
          path:'/edit-task',
          name : 'EditTask',
          component : taskedit,
         
     }
];

const router = createRouter({
     history: createWebHistory(),
     routes
});

router.beforeEach((to,form) => {

     if(to.meta.requiresAuth && store.getters.getToken == 0){
          return {name : 'Login'}
     }
     if(to.meta.requiresAuth == false && store.getters.getToken != 0){
          return {name : 'Dashboard'}
     }
});

export default router;