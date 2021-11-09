<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Manufacturing Orders List</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Order ID</th>
                      <th>Product</th>
                      <th>Order Date</th>
                      <th>Production Deadline</th>
                     
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="manufacturingOrder in manufacturingOrders.data" :key="manufacturingOrder.id">

                      <td>{{manufacturingOrder.id}}</td>
                      <td>{{manufacturingOrder.morder_number}}</td>
                      <td class="text-capitalize">{{manufacturingOrder.product.name}}</td>
                      <td>{{manufacturingOrder.morder_date}}</td>
                      <td>{{manufacturingOrder.production_deadline}}</td>
                      
                      
                      <td>

                        <a href="#" @click="editModal(manufacturingOrder)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                         /
                        <a href="#" @click="deleteSalesOrder(manufacturingOrder.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="manufacturingOrders" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Manufacturing Order</h5>
                    <h5 class="modal-title" v-show="editmode">Update Manufacturing Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateManufacturingOrder() : createManufacturingOrder()">
                    <div class="modal-body">

                        <div class="form-group">

                            <label>Order ID</label>
                            <input v-model="form.order_id" type="text" name="order_id" v-bind:placeholder="form.order_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('order_id') }">
                            <has-error :form="form" field="order_id"></has-error>
                            
                        </div>

                        <div class="form-group">
                            <label>Product Name</label>
                            <select class="form-control" v-model="form.product_id">
                              <option 
                                  v-for="(cat,index) in products" :key="index"
                                  :value="index"
                                  :selected="index == form.product_id">{{ cat }}</option>
                            </select>
                         
                        </div> 

                        <div class="form-group">
                            <label>Order Date</label>
                            <input v-model="form.order_date" type="date" name="order_date"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('order_date') }">
                            <has-error :form="form" field="order_date"></has-error>
                            
                        </div>

                        <div class="form-group">

                            <label>Production Deadline</label>
                            <input v-model="form.production_deadline" type="date" name="production_deadline"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('production_deadline') }">
                            <has-error :form="form" field="production_deadline"></has-error>
                            
                        </div>



                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
import moment from 'moment'
    export default {
        data () {
            return {

                moment: moment,

                editmode: false,
                products : {},
                manufacturingOrders:{},
                order_num: [{
                         nextOrderNumberAttribute:"",
                         nextOrderNumber:"",
                         morder_prefix:""
                        }],

                
                form: new Form({
                    id : '',
                    product_id: '',
                    order_id:'',
                    order_date:moment().format('YYYY-MM-DD').toString(),
                    production_deadline:moment().format('YYYY-MM-DD').toString()
                    
                })
                
            }
        },
        methods: {

            getResults(page = 1) {

                  this.$Progress.start();
                  
                  axios.get('/api/manufacturingOrder?page=' + page).then(({ data }) => (this.manufacturingOrders = data.data));

                  this.$Progress.finish();
            },

            loadManufacturingOrders(){
              axios.get("/api/manufacturingOrder").then(({ data }) => (this.manufacturingOrders = data.data)).catch( () => {console.log("unable to load")});
            },

            
            loadOrderNumbers(){
              axios.get("/api/create/morder").then(({ data }) => (this.order_num = data));
              },

            loadProducts(){
              axios.get("/api/product/list").then(({ data }) => (this.products = data.data));
              },

            updateManufacturingOrder(){
                this.$Progress.start();
                this.form.put('/api/manufacturingOrder/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadManufacturingOrders();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(manufacturingOrder){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(manufacturingOrder);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                this.form.order_id = this.order_num.nextOrderNumber;
                $('#addNew').modal('show');
            },

          
            
            createManufacturingOrder(){

                this.form.post('/api/manufacturingOrder')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadManufacturingOrders();
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },

            deleteManufacturingOrder(id){
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
                              this.form.delete('api/manufacturingOrder/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your row has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadManufacturingOrders();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadOrderNumbers();
            this.loadManufacturingOrders();
            this.loadProducts();
            this.$Progress.finish();

        }
    }
</script>
