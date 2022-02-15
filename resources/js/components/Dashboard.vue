<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Production</span>
                            <span class="info-box-number">
                            {{ production }}
                           
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Customer Orders</span>
                            <span class="info-box-number">{{ customerOrders }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">manufacturing Order</span>
                            <span class="info-box-number">{{ morderCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Customers</span>
                            <span class="info-box-number">{{ customers }}</span>
                        </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Sales Orders </h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th> Order ID </th>
                                    <th> Item </th>
                                    <th> Status </th>
                                    <th> Customer </th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                <tr v-for="salesOrder in salesOrders" :key="salesOrder.id">

                                    <td> {{ salesOrder.order_number}} </td>
                                    <td> {{salesOrder.product.name}} </td>
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
                                      <div class="sparkbar" data-color="#f39c12" data-height="20">  {{ salesOrder.customer.fname}} {{ salesOrder.customer.lname}} </div>
                                    </td>
                                </tr>
            
                           
                            </tbody>
                        </table>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->

          

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Inventory</span>
                    <span class="info-box-number">{{ stock.total | currency('Ksh') }}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="far fa-heart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Work-in-Progress</span>
                    <span class="info-box-number">{{ wip }}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Blocked</span>
                    <span class="info-box-number">{{ blocked }}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Done</span>
                    <span class="info-box-number">{{ done }}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

              <!-- Left col2 -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Manufacturing Orders</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Order-date</th>
                                    <th>Delivery-date </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="manufacturingOrder in manufacturingOrders" :key="manufacturingOrder.id">

                                    <td>{{ manufacturingOrder.order_number }}</td>
                                    <td>{{ manufacturingOrder.product.name }}</td>
                                    <td>
                                        <span class="badge badge-success">
                                              {{manufacturingOrder.order_date}}
                                            </span>
                                    </td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">{{ manufacturingOrder.production_deadline }} </div>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        </div>

                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->


            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</template>

<script>
    export default {

        data(){

             return {

                production : '0',
                customerOrders : '0',
                customers: "0",
                stock: "0",
                wip: "0",
                blocked: "0",
                done: "0",
                salesOrders: "0",
                manufacturingOrders: '0',
                morderCount: '0'

            }

        },

        methods: {

            loadSalesOrder(){

                  axios.get("api/dashboard/sorder")
                       .then(({ data }) => (this.salesOrders = data.data));
              

            },

            loadManufacturingOrder(){

                    axios.get("api/dashboard/morder")
                         .then(({ data }) => (this.manufacturingOrders = data.data));
            },

            loadCustomerOrder(){

                    axios.get("api/dashboard/corder")
                         .then(({ data }) => (this.customerOrders = data.data));
            },

            loadCustomer(){

                    axios.get("api/dashboard/customer")
                         .then(({ data }) => (this.customers = data.data));
            },

            loadproduction(){

                    axios.get("api/dashboard/production")
                         .then(({ data }) => (this.production = data.data));
            },

            loadWIP(){

                    axios.get("api/dashboard/wip")
                         .then(({ data }) => (this.wip = data.data));
            },

            loadDone(){

                    axios.get("api/dashboard/done")
                         .then(({ data }) => (this.done = data.data));
            },

            loadBlocked(){

                    axios.get("api/dashboard/blocked")
                         .then(({ data }) => (this.blocked = data.data));
            },

            loadStock(){

                    axios.get("api/dashboard/stock")
                         .then(({ data }) => (this.stock = data.data));
            },

             loadMorderCount(){

                    axios.get("api/dashboard/morderCount")
                         .then(({ data }) => (this.morderCount = data.data));
            },




        },

         created() {

            this.$Progress.start();
            this.loadSalesOrder();
            this.loadManufacturingOrder();
            this.loadCustomer();
            this.loadCustomerOrder();
            this.loadproduction();
            this.loadWIP();
            this.loadDone();
            this.loadBlocked();
            this.loadStock();
            this.loadMorderCount();
            this.$Progress.finish();
        },

        computed: {


        },



        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
