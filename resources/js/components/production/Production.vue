<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Production Queue</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Schedule Production
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Order #</th>
                      <th>Order Type</th>
                      <th>Technician</th>
                      <th>Notes</th>
                      
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(build, index) in builds.data" :key="build.id">

                      <td>{{ index + 1}}</td>
                      <td>{{build.buildable_id}}</td>
                      <td>{{build.buildable_type}}</td>
                      <td>{{build.user.name}}</td>
                      <td>{{build.notes | truncate(40, '...')}}</td>
                     
                      
                      <td>
                        <span  :class ="{
                                              'badge badge-success': build.production_stage.name === 'Done',
                                              'badge badge-danger': build.production_stage.name === 'Blocked',
                                              'badge badge-warning': build.production_stage.name === 'Not started',
                                              'badge badge-info': build.production_stage.name === 'Work-in-Progress',
                                         }"

                        > {{build.production_stage.name}} 
                        </span> </td>
                      <td>
                        
                        <a href="#" @click="editModal(build)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteBuild(build.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="builds" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Schedule Production</h5>
                    <h5 class="modal-title" v-show="editmode">Edit production</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form @submit.prevent="editmode ? updateBuild() : createBuild()">

                    <div class="modal-body">

                        <div class="form-group">

                          <label>Order Type</label>

                            <select class="form-control" v-model= "form.buildable_type">

                              <option 
                                  v-for= "orderType in orderTypes" :key= "orderType.id"
                                  :value= "orderType.name"
                            
                              >

                               {{ orderType.name }} 

                              </option>

                            </select>

                           
                        </div>


                         <div class="form-group">

                            <label> Order Id </label>

                            <select class="form-control" v-model= "form.buildable_id">
                              <option 
                                  v-for = "orderId in orderIds" :key= "orderId.id"
                                  :value = "orderId.order_number"
                                  
                              >
                                  
                                {{ orderId.order_number }}

                              </option>

                            </select>

                           
                        </div>

                        <div class="form-group">
                            <label> Technician </label>
                            <select class="form-control" v-model= "form.user_id">
                              <option 
                                  v-for = "(name,index) in users" :key= "index"
                                  :value = "index"
                                  :selected = "index == form.user_id"> {{ name }} </option>
                            </select>
                           
                        </div>

                      
                        <div class="form-group">
                            <label>Notes</label>
                            <input v-model= "form.notes" type="text" name="notes"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('notes') }">
                            
                        </div>

                      

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" v-model= "form.production_stage_id">
                              <option 
                                  v-for= "(name,index) in productionStages" :key= "index"
                                  :value= "index"
                                  :selected= "index == form.production_stage_id" > {{ name }} </option>
                            </select>
                            
                        </div>

             </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Build</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
  
    export default {
      components: {
         
        },
        data () {
            return {
                editmode: false,

                builds : {},

                form: new Form({
                    id : '',
                    buildable_type : '',
                    user_id: '',
                    notes: '',
                    buildable_id: '',
                    production_stage_id:'',   
                }),

                orderTypes: [
                  { 
                    id: 1,
                    name: 'Manufacturing Order'

                  },
                  { 
                    id: 2,
                    name: 'Sales Order'

                  }
                ],

                users: [],
                orderIds: [],
                productionStages:[],
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/build?page=' + page).then(({ data }) => (this.builds = data.data));

              this.$Progress.finish();
          },
          
          loadBuilds()
          {
              axios.get("api/build").then(({ data }) => (this.builds = data.data));
          },

          loadProducts(){
              axios.get("/api/product/list").then(({ data }) => (this.products = data.data));
          },

          loadUsers()
          {
              axios.get("/api/user/list").then(({ data }) => (this.users = data.data));
          },

          loadStatus()
          {
              axios.get("/api/status/list").then(({ data }) => (this.productionStages = data.data));
          },
       
          editModal(build){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(build);
          },

          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },

          createBuild(){
              this.$Progress.start();

              this.form.post('api/build')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadBuilds();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again2'
                  });
              })
          },
          
          updateBuild()
          {
              this.$Progress.start();
              this.form.put('api/build/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadBuilds();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },

          deleteBuild(id)
          {
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/build/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadBuilds();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {
            
        },
        created() {

            this.$Progress.start();
            this.loadBuilds();
            this.loadUsers();
            this.loadStatus();
            this.$Progress.finish();
        },

        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },

        computed: {

          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          }, 
        },

        watch: {

          'form.buildable_type': function(){

             if(this.form.buildable_type === 'Manufacturing Order')
             {

              axios.get("/api/manufacturingOrder/all")
                   .then(({ data }) => (this.orderIds = data.data));
                 
             }

             else
             {
                axios.get("/api/salesOrder/all")
                     .then(({ data }) => (this.orderIds = data.data));
                       
             }
          },

        }
    }
</script>
