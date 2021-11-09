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
                      Build New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Product Name</th>
                      <th>Technician</th>
                      <th>Notes</th>
                      <th>Est.Time</th>
                      <th>Customer </th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="build in builds.data" :key="build.id">

                      <td>{{build.id}}</td>
                      <td>{{build.product.name}}</td>
                      <td>{{build.user.name}}</td>
                      <td>{{build.notes | truncate(30, '...')}}</td>
                      <td>{{build.production_time}}</td>
                      <td>{{build.customer.fname}}</td>
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
                    <h5 class="modal-title" v-show="!editmode">Build New Product</h5>
                    <h5 class="modal-title" v-show="editmode">Edit production</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateBuild() : createBuild()">
                    <div class="modal-body">
                        <div class="form-group">
                          <label>Product</label>
                            <select class="form-control" v-model="form.product_id">
                              <option 
                                  v-for="(name,index) in products" :key="index"
                                  :value="index"
                                  :selected="index == form.product_id">{{ name }}</option>
                            </select>
                            <has-error :form="form" field="product_id"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Technician</label>
                            <select class="form-control" v-model="form.user_id">
                              <option 
                                  v-for="(name,index) in users" :key="index"
                                  :value="index"
                                  :selected="index == form.user_id">{{ name }}</option>
                            </select>
                            <has-error :form="form" field="user_id"></has-error>
                        </div>

                      
                        <div class="form-group">
                            <label>Notes</label>
                            <input v-model="form.notes" type="text" name="notes"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('notes') }">
                            <has-error :form="form" field="notes"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Est.Time</label>
                            <input v-model="form.production_time" type="text" name="production_time"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('production_time') }">
                            <has-error :form="form" field="production_time"></has-error>
                        </div>
                         
                         
                         <div class="form-group">

                            <label>Customer</label>
                            <select class="form-control" v-model="form.customer_id">
                              <option 
                                  v-for="(fname,index) in customers" :key="index"
                                  :value="index"
                                  :selected="index == form.customer_id">{{ fname }}</option>
                            </select>
                            <has-error :form="form" field="customer_id"></has-error>
                        </div>
                        


                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" v-model="form.production_stage_id">
                              <option 
                                  v-for="(name,index) in productionStages" :key="index"
                                  :value="index"
                                  :selected="index == form.production_stage_id">{{ name }}</option>
                            </select>
                            <has-error :form="form" field="production_stage_id"></has-error>
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
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                builds : {},
                form: new Form({
                    id : '',
                    product_id : '',
                    user_id: '',
                    notes: '',
                    production_time: '',
                    customer_id: '',
                    production_stage_id:'',   
                }),
                products: [],
                users: [],
                customers: [],
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
          
          loadBuilds(){

            // if(this.$gate.isAdmin()){
              axios.get("api/build").then(({ data }) => (this.builds = data.data));
            // }
          },

          loadProducts(){
              axios.get("/api/product/list").then(({ data }) => (this.products = data.data));
          },

          loadCustomers(){
              axios.get("/api/customer/list").then(({ data }) => (this.customers = data.data));
          },

          loadUsers(){
              axios.get("/api/user/list").then(({ data }) => (this.users = data.data));
          },

          loadStatus(){
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
          updateBuild(){
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
          deleteBuild(id){
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
            this.loadProducts();
            this.loadUsers();
            this.loadCustomers();
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
    }
</script>
