import {createWebHistory, createRouter} from 'vue-router';

import home from './pages/home.vue';
import register from './pages/register.vue';
import login from './pages/login.vue';
import about from './pages/about.vue';
import dashboard from './pages/dashboard.vue';
import store from './store/index.js';

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