<template>
     <div class="container mt-5">
          <h2> My Dashboard</h2>
          <div class="row mt-5">
               <div class="card">
                    <div class="card-header">
                        <div class="row">
                         <div class="col-lg-10">
                              <h2>My Task </h2>
                         </div>
                         <div class="col-lg-2">
                              <button type="button" v-if="add_new" class="btn btn-danger" @click="addTask">Close</button>
                              <button type="button" v-else class="btn btn-primary" @click="addTask">Add New Task</button>
                          

                         </div>
                        </div>
                        
                    </div>
                    <div class="card-body mb-5" v-if="add_new">
                         <p v-for="error in errors" :key=error class="text-danger">
                              <span v-for="err in error"> {{ err }}</span>
                         </p>
                         <form @submit.prevent="addNewTask">
                              <div class="row">
                              <div class="col-lg-12">
                                   <label class="form-label">Task Title</label>
                                   <input type="text" name="title"  class="form-control" placeholder="Task Title Here"  v-model="form.title">
                              </div>
                              <div class="col-lg-12 mt-4">
                                   <label class="form-label">Task Description </label>
                                  <textarea class="form-control" name="description" placeholder="Enter Task Description" v-model="form.description"></textarea>
                              </div>
                         </div>
                         <div class="row mt-4">
                              <button type="submit" class="btn btn-primary">Add Task</button>
                         </div>
                         </form>
                        
                    </div>
                    <div class="card-body">
                         <table class="table">
                              <thead>
                                   <th> SI </th>
                                   <th> Task </th>
                                   <th> Description</th>
                                   <th> Status </th>
                                   <th>Created</th>
                                   <th>Action</th>
                              </thead>
                              <tbody>
                                   <tr v-for="(task , i) in my_tasks" :key="i">
                                        <td>{{i+1 }}</td>
                                        <td>{{task.title }}</td>
                                        <td>{{task.description}}</td>
                                        <td>{{task.status}}</td>
                                        <td>{{task.created_at}}</td>
                                        <td>
                                             <route-link :to="{name: 'EditTask'}" class="btn btn-primary">Edit</route-link>
                                             <route-link class="btn btn-danger">Delete</route-link>
                                        </td>
                                   </tr>
                              </tbody>
                         </table>
                         
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
     data(){
          return {
          my_tasks: [],
          add_new : false
          }
     },

     methods: {
           addTask(){
               if(this.add_new){
                    this.add_new = false;
               }else{
                    this.add_new = true;
               }
          }
        },


     setup(){
          let tasks = [];
          let errors = ref([]) ;
          let form = reactive({
          title : '',
          description: '',
         });

         const addNewTask = async()=>{
         await axios.post('/api/add-tasks',form).then(res=>{
              if(res.data.success){
               my_tasks = res.data.data;
               add_new = false;
                   toast(res.data.message, {
                        autoClose: 1000,
                   });
                   
              }
         }).catch(e => {
          console.log(e);
              errors.value = e.response.data.message ;
              
         });
        }

          return {
               tasks,
               form,
               addNewTask,
               errors
             
          }
     },
     mounted() {
        window.axios.get('/api/my-tasks').then(res => {
          this.my_tasks = res.data.data;
        })
    }
}
</script>