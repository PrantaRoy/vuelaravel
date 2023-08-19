<template>
     <div class="container mt-3">
          <p v-for="error in errors" :key=error class="text-danger">
               <span v-for="err in error"> {{ err }}</span>
          </p>
               <div class="row justify-content-center ">
                    <form @submit.prevent="updateProfile">
                         <div class="card">
                              <div class="card-header">
                                   <h2>Update Profile</h2>
                              </div>
                              <div class="card-body">
                                   <div class="row">
                              <div class="col-lg-6">
                                   <div class="mb-3 mt-3">
                                        <label for="email" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" v-model="form.name">
                                   </div>
                              </div>
                              <div class="col-lg-6">
                                   <div class="mb-3 mt-3">
                                        <label for="email" class="form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" v-model="form.phone">
                                   </div>
                              </div>
                    
                              <div class="col-lg-12">
                                        <div class="mb-3 mt-3">
                                             <label for="email" class="form-label">Email:</label>
                                             <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" v-model="form.email">
                                        </div>
                              </div>
                         </div>
                              </div>
                              <div class="card-footer">
                             
                             <div class="row">
                                   <button type="submit" class="btn btn-primary">Update</button>
                             </div>
                      
                       </div>
                         </div>
                         
                         
                    </form>
                    
               </div>
          </div>
</template>

<script>

import {reactive ,ref} from 'vue';
import {useRouter} from 'vue-router';
import {useStore} from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default{
     setup(){
         let form = reactive({
          email : '',
          name: '',
          phone : '',
         });
         let errors = ref([]) ;
         const router = useRouter();
         const store = useStore();
         const updateProfile = async()=>{
         
          await axios.post('/api/update-profile',form).then(res=>{
               if(res.data.success){
                    toast(res.data.message, {
                         autoClose: 1000,
                    });
               }
          }).catch(e => {
               errors.value = e.response.data.message ;
               
          });
         }
         return{
               form,
               updateProfile,
               errors
         }
     },
     mounted() {
        window.axios.get('/api/user').then(res => {
            this.form.name = res.data.name
            this.form.email = res.data.email
            this.form.phone = res.data.phone
        })
    }
}
</script>