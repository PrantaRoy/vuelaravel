<template>
     <div class="container mt-3">
          <h2>Register Here </h2>
          <p v-for="error in errors" :key=error class="text-danger">
               <span v-for="err in error"> {{ err }}</span>
          </p>
               <div class="row justify-content-center ">
                    <form @submit.prevent="register">
                    <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" v-model="form.name">
                    </div>
                    <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" v-model="form.phone">
                    </div>
                    <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" v-model="form.email">
                    </div>
                    
                    <div class="mb-3 mt-3">
                    <label for="pwd" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" v-model="form.password">
                    </div>

                    <div class="mb-3">
                    <label for="pwd" class="form-label">Retype Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter Confirm password" name="confirm_password" v-model="form.confirm_password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    
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
          name: '',
          phone : '',
          password : '',
          confirm_password : '',
         });
         let errors = ref([]) ;
         const router = useRouter();
         const store = useStore();
         const register = async()=>{
          await axios.post('/api/register',form).then(res=>{
               if(res.data.success){
                    store.dispatch('setToken', res.data.data.token);
                    router.push({name:'Dashboard'});
               }
          }).catch(e => {
               errors.value = e.response.data.message
          });
         }
         return{
               form,
               register,
               errors
         }
     }
}
</script>