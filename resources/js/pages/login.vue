<template>
<div class="container mt-3">
     <h2>Login Form</h2>
          <div class="row justify-content-center ">
               <div class="col-sm-6">
               <p v-if="error" class="text-danger">{{ error }}</p>
               <form @submit.prevent="login">
               <div class="mb-3 mt-3">
               <label for="email" class="form-label">Email:</label>
               <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" v-model="form.email">
               </div>
               <div class="mb-3">
               <label for="pwd" class="form-label">Password:</label>
               <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" v-model="form.password">
               </div>
               
               <button type="submit" class="btn btn-primary">Submit</button>
               </form>
               </div>
               
          </div>
     </div>
</template>
<script>

import {reactive ,ref} from 'vue';
import {useRouter} from 'vue-router';
import {useStore} from 'vuex'
export default{
     setup(){
         let form = reactive({
          email : '',
          password : ''
         });
         let error = ref('') ;
         const router = useRouter()
         const store = useStore()
         const login = async()=>{
          await axios.post('/api/login',form).then(res=>{
          
               if(res.data.success){
                    store.dispatch('setToken', res.data.data.token);
                    router.push({name:'Dashboard'});
               }else{
                
                    error.value = res.data.message;
               }
          });
         }
         return{
               form,
               login,
               error
         }
     }
}
</script>