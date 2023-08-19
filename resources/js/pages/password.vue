<template>
   <div class="container mt-3">
    <div class="justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2>Update Password</h2>
                </div>
                <form @submit.prevent="updatePassword">
                    <div class="card-body">
                        <p v-for="error in errors" :key=error class="text-danger">
                        <span v-for="err in error"> {{ err }}</span>
                    </p>

                    <div class="mb-3">
                        <label class="form-label">Old Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Enter current Password" v-model="form.password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input class="form-control" type="password" name="new_password"  placeholder="Enter New Password" v-model="form.new_password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Retype Password</label>
                        <input class="form-control" type="password" name="confirm_password" placeholder="Retype New Password" v-model="form.confirm_password">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</template>
<script>
import {reactive ,ref} from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default{
     setup(){
         let form = reactive({
          password : '',
          new_password: '',
          confirm_password : '',
         });
         let errors = ref([]) ;
         const updatePassword = async()=>{
         
          await axios.post('/api/update-password',form).then(res=>{
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
               updatePassword,
               errors
         }
     },
    
}

</script>