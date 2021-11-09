<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Sales Orders List</h3>

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
                      <th>Customer Name</th>
                      <th>Product Name</th>
                      <th>Order Date</th>
                      <th>Delivery Deadline</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="salesOrder in salesOrders.data" :key="salesOrder.id">

                      <td>{{salesOrder.id}}</td>
                      <td>{{salesOrder.sorder_number}}</td>
                      <td class="text-capitalize">{{salesOrder.customer.fname}}</td>
                      <td class="text-capitalize">{{salesOrder.product.name}}</td> 
                      <td>{{salesOrder.sorder_date}}</td>
                      <td>{{salesOrder.delivery_deadline}}</td>
                      <td>

                         <span  :class ="{
                                              'badge badge-success': salesOrder.order_status.name === 'Delivered',
                                              'badge badge-danger': salesOrder.order_status.name === 'Shipping',
                                              'badge badge-warning': salesOrder.order_status.name === 'Packaging',
                                              'badge badge-info': salesOrder.order_status.name === 'Processing',
                                         }"

                          > 
                        
                            {{salesOrder.order_status.name}}
                         </span>
                        </td>
                      
                      <td>

                        <a href="#" @click="editModal(salesOrder)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                          /
                        <a href="#" @click="deleteSalesOrder(salesOrder.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="salesOrders" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Create New sales Order</h5>
                    <h5 class="modal-title" v-show="editmode">Update sales Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateSalesOrder() : createSalesOrder()">
                    <div class="modal-body">

                        <div class="form-group">

                            <label>Order ID</label>
                            <input v-model="form.order_id" type="text" name="order_id" v-bind:placeholder="form.order_id"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('order_id') }">
                            <has-error :form="form" field="order_id"></has-error>
                            
                        </div>


                        <div class="form-group">
                            <label>Customer Name</label>
                            <select class="form-control" v-model="form.customer_id">
                              <option 
                                  v-for="(cat,index) in customers" :key="index"
                                  :value="index"
                                  :selected="index == form.customer_id">{{ cat }}</option>
                            </select>
                         
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

                            <label>Delivery Deadline</label>
                            <input v-model="form.delivery_deadline" type="date" name="delivery_deadline"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('delivery_deadline') }">
                            <has-error :form="form" field="delivery_deadline"></has-error>
                            
                        </div>

                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" v-model="form.status_id">
                              <option 
                                  v-for="(cat,index) in status" :key="index"
                                  :value="index"
                                  :selected="index == form.status_id">{{ cat }}</option>
                            </select>
                         
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
              moment:moment,

                editmode: false,
                products : {},
                customers : {},
                salesOrders:{},
                status:{},
                order_num: [{
                         nextOrderNumberAttribute:"",
                         nextOrderNumber:"",
                         sorder_prefix:""
                        }],
                form: new Form({
                    id : '',
                    product_id: '',
                    customer_id:'',
                    order_date:moment().format('YYYY-MM-DD').toString(),
                    delivery_deadline:moment().format('YYYY-MM-DD').toString(),
                    status_id:'',
                    order_id: ''
                })
            }
        },

  //this.newInvoice.invoice_number = this.invoicePrefix + '-' + this.invoiceNumAttribute

        methods: {

            getResults(page = 1) {

                  this.$Progress.start();
                  
                  axios.get('/api/salesOrder?page=' + page).then(({ data }) => (this.salesOrders = data.data));

                  this.$Progress.finish();
            },

           loadSalesOrders(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/salesOrder").then(({ data }) => (this.salesOrders = data.data)).catch( () => {console.log("unable to load")});
                }
            },

            loadOrderNumber(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/create/sorder").then(({ data }) => (this.order_num = data)).catch( () => {console.log("unable to load")});
                }
            },
            loadProducts(){
              axios.get("/api/product/list").then(({ data }) => (this.products = data.data));
              },

            loadCustomers(){
              axios.get("/api/customer/list").then(({ data }) => (this.customers = data.data));
               },

            
            loadStatus(){
              axios.get("/api/orderStatus/list").then(({ data }) => (this.status = data.data));
               },

            updateSalesOrder(){
                this.$Progress.start();
                this.form.put('/api/salesOrder/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadSalesOrders();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(salesOrder){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(salesOrder);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                this.form.order_id = this.order_num.nextOrderNumber;    
                $('#addNew').modal('show');
              
            },

            
            
            createSalesOrder(){

                this.form.post('/api/salesOrder')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });

                    this.$Progress.finish();
                    this.loadSalesOrders();
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },

            deleteSalesOrder(id){
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
                              this.form.delete('api/salesOrder/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your row has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadSalesOrders();
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
            this.loadSalesOrders();
            this.loadOrderNumber()
            this.loadProducts();
            this.loadCustomers();
            this.loadStatus();
            this.$Progress.finish();

        },
       
    }
</script>
