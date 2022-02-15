<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sales Orders</h3>

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
                      <th>Order #</th>
                      <th>Customer Name</th>
                      <th>Product Name</th>
                      <th>Order Date</th>
                      <th>Delivery Deadline</th>
                      <th>Est.Time</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(salesOrder, index) in salesOrders.data" :key="salesOrder.id">

                      <td>{{ index + 1}}</td>
                      <td>{{ salesOrder.order_number }}</td>
                      <td class="text-capitalize">{{ salesOrder.customer.fname }} {{ salesOrder.customer.lname }}</td>
                      <td class="text-capitalize">{{ salesOrder.product.name }}</td> 
                      <td>{{ salesOrder.order_date }}</td>
                      <td>{{ salesOrder.delivery_deadline }}</td>
                      <td>{{ moment.duration( moment(salesOrder.delivery_deadline, "DD-MM-YYYY" ).diff(moment(salesOrder.order_date, "DD-MM-YYYY"))).asDays() }} <span> Day(s) </span> </td>
                      
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


       

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show= "!editmode">Create New sales Order</h5>
                    <h5 class="modal-title" v-show= "editmode">Update sales Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent= "editmode ? updateSalesOrder() : createSalesOrder()">
                    <div class="modal-body">

                        <div class="form-group">

                            <label> Order # </label>

                            <input  
                                   type = "text" 
                                   name = "order_number" 
                                   v-bind:placeholder = "form.order_number" 
                                   v-model = "form.order_number"
                                   class= "form-control" :class = "{ 'is-invalid': form.errors.has('order_number') }"
                            >

                            <has-error :form= "form" field="order_number"> </has-error>
                            
                        </div>


                        <div class="form-group">

                            <label>Customer Name</label>

                         <!--      <v-select
                                                                                                        
                                                       
                                                         label= "fname"
                                                         placeholder= "Select or search Customer"
                                                         name = "customer_id"
                                                         :options = "customers"
                                                         :clearable = "true"
                                                         :searchable= "true"
                                                         :closeOnSelect= "true"
                                                         v-model = "form.customer_id"
                                                         :reduce = "fname => fname.id "
                                                         > 

                                                         <template v-slot:option= "customer">

                                                         {{ customer.fname }}   {{ customer.lname }} 

                                                        </template>

                                                        <template slot="selected-option" slot-scope= "supplier">
                                                      
                                                         {{ supplier.fname }}   {{ supplier.lname }} 
                                                        </template>

                                         
                              </v-select> 
                              
                               -->







                            <select class="form-control" v-model= "form.customer_id">
                              <option 
                                  v-for= "customer in customers" :key= "customer.id"
                                  :value= "customer.id"
                                  :selected= "customer.id == form.customer_id"> {{ customer.fname }} {{customer.lname}} || {{customer.phone}}</option>
                            </select>
                     
                        </div>

                          <div class="form-group">
                            <label>Product Name</label>
                            <select class="form-control" v-model= "form.product_id" >
                              <option 
                                  v-for= "(cat,index) in products" :key= "index"
                                  :value= "index"
                                  :selected= "index == form.product_id"
                              >
                              {{ cat }}
                              </option>
                            </select>
                         
                        </div>

                        

                        <div class="form-group">

                            <label>Order Date</label>
                            <input v-model= "form.order_date" type="date" name= "order_date"
                                class= "form-control" :class="{ 'is-invalid': form.errors.has('order_date') }">
                            <has-error :form= "form" field= "order_date"></has-error>
                            
                        </div>

                        <div class="form-group">

                            <label>Delivery Deadline</label>
                            <input v-model= "form.delivery_deadline" type= "date" name= "delivery_deadline"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('delivery_deadline') }">
                            <has-error :form= "form" field= "delivery_deadline"></has-error>
                            
                        </div>

                          <div class="form-group">
                            <label>Status</label>
                            <select class= "form-control" v-model= "form.order_status_id">
                              <option 
                                  v-for= "(cat,index) in status" :key= "index"
                                  :value= "index"
                                  :selected= "index == form.order_status_id"
                              >
                                 {{ cat }} 
                              </option>
                            </select>
                         
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show= "editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show= "!editmode" type="submit" class="btn btn-primary">Create</button>
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
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

    export default {

      components: {

        vSelect
        },
        
        data () {
            return {
              moment:moment,

                editmode: false,
                products : {},
                customers : {},
                salesOrders:{},
                status:{},
                suppliers:[],
                order_num: [{
                         nextOrderNumberAttribute:"",
                         nextOrderNumber:"",
                         sorder_prefix:""
                        }],
                form: new Form({
                    id : '',
                    product_id: '',
                    customer_id: '',
                    order_date: moment().format('YYYY-MM-DD').toString(),
                    delivery_deadline: moment().format('YYYY-MM-DD').toString(),
                    order_status_id: '',
                    order_number: ''
                })
            }
        },

  //this.newInvoice.invoice_number = this.invoicePrefix + '-' + this.invoiceNumAttribute

        methods: {

            getResults(page = 1)
            {

                  this.$Progress.start();
                  
                  axios.get('/api/salesOrder?page=' + page).then(({ data }) => (this.salesOrders = data.data));

                  this.$Progress.finish();
            },

           loadSalesOrders()
           {
              
              axios.get("/api/salesOrder")
                   .then(({ data }) => (this.salesOrders = data.data))
                   .catch( () => {console.log("unable to load")});
              
            },

            loadOrderNumber()
            {
               axios.get("/api/create/sorder")
                    .then(({ data }) => (this.order_num = data))
                    .catch( () => {console.log("unable to load")});
              
            },

           

            loadProducts()
            {
              axios.get("/api/product/list")
                   .then(({ data }) => (this.products = data.data));
            },

            loadCustomers()
            {
              axios.get("/api/customer/list").then(({ data }) => (this.customers = data.data));
            },

            
            loadStatus()
            {
              axios.get("/api/orderStatus/list").then(({ data }) => (this.status = data.data));
            },

            updateSalesOrder()
            {
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

                    this.loadSalesOrders();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            editModal(salesOrder)
            {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(salesOrder);
            },

            newModal()
            {
                this.editmode = false;
                this.form.order_number = this.order_num.nextOrderNumber;    
                $('#addNew').modal('show');
              
            },
  
            createSalesOrder()
            {
                this.$Progress.start(); 
                this.form.post('/api/salesOrder')
                .then((response)=>{
                    $('#addNew').modal('hide');

                    Toast.fire({
                            icon: 'success',
                            title: response.data.message
                    });
                    this.form.reset();
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
                                      'The Sales order has been deleted.',
                                      'success'
                                      );
                                 
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
            this.loadOrderNumber();
            this.loadProducts();
            this.loadCustomers();
            this.loadStatus();
            this.$Progress.finish();

        },
       
    }
</script>
