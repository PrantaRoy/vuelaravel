<template>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" :to="{name: 'Home'}" >Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{name: 'Home'}">Home</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" :to="{name: 'About'}">About</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" v-if="$store.getters.getToken == 0" :to="{name: 'Register'}">Register</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" v-if="$store.getters.getToken == 0" :to="{name: 'Login'}">Login</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link"  v-if="$store.getters.getToken != 0" :to="{name: 'Dashboard'}">Dashboard</router-link>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" v-if="$store.getters.getToken != 0"  href="#" role="button" data-bs-toggle="dropdown">{{ name }}</a>
          <ul class="dropdown-menu">
            <li><router-link :to="{name: 'Profile'}" class="dropdown-item" v-if="$store.getters.getToken != 0"  href="#">Profile</router-link></li>
            <li><router-link :to="{name: 'Password'}" class="dropdown-item" v-if="$store.getters.getToken != 0"  href="#">Password</router-link></li>
            <li><button @click="logout" class="dropdown-item" href="#">Logout</button></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
 
</nav>

<router-view></router-view>

</template>
<script>
import {reactive ,ref} from 'vue';
import {useRouter} from 'vue-router';
import {useStore} from 'vuex'
export default{
  data(){
          return {
          name: ''
          }
     },
     setup(){

         let errors = ref([]) ;
         const router = useRouter();
         const store = useStore();
         const logout = async()=>{
          console.log('OKKKKK');
          await axios.post('/api/logout').then(res=>{
               if(res.data.success){
                  store.dispatch('removeToken');
                  router.push({name:'Login'});
                    toast(res.data.message, {
                         autoClose: 1000,
                    });
               }
          }).catch(e => {
               errors.value = e.response.data.message ;
               
          });
         }
         return{
               logout,
               errors
         }
     },
     mounted() {
        window.axios.get('/api/user').then(res => {
            this.name = res.data.name
        })
    }
}
</script>