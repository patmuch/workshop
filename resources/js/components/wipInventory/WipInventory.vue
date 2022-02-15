<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Work-in-progress Inventory </h3>

              
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                  

                            <!-- begin select box -->

                        <div class="form-group row p-2">

                        <div class= col-md-3 col-form-label>

                           <label class="control-label" for="order"> Select Order </label> 

                        </div>

                                <div class="col-md-6">
 
                                            <select class="form-control"  name="order" v-model= "selectedOrder"  @change= "getMaterials" >
                                                 <option 
                                                 v-for= "order in orders" :key= "order.id"
                                                 :value= "order.id"
                                                 :selected= "order.id == selectedOrder" 
                                                 >
                                                   {{ order.buildable_id }}
                                                        
                                                 </option>

                                            </select>
                                                                                        
                                </div>

                        </div>

                        <!-- end select box -->


                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>ItemName</th>
                      <th>ItemCode</th>
                      <th>Quantity</th>
                     
                      
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(buildMaterial, index) in buildMaterials.data" :key="index">
                      <td> {{index + 1}} </td>
                      <td> {{buildMaterial.material_name}} </td>
                      <td> {{buildMaterial.material_code}} </td>
                      <td> {{buildMaterial.pivot.quantity}} </td>
                  
                    </tr>
                  </tbody>
                </table>
              
              </div>
              <!-- /.card-body -->
              <div class= "card-footer">
                  
              </div>
            </div>
            <!-- /.card -->
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
               
                materials : {},
                materialCategories: [],
                uoms:[],
                orders:[],
                buildMaterials: [],
                selectedOrder: '',

              


            }
        },
        methods: {

          getResults(page = 1)
          {

              this.$Progress.start();
              
              axios.get('api/material?page=' + page).then(({ data }) => (this.materials = data.data));

              this.$Progress.finish();
          },

          loadOrders()
          {
           axios.get("api/build/order")
                .then(({data}) => (this.orders = data.data));
          },


          loadMaterials()
          {
              axios.get("api/material").then(({ data }) => (this.materials = data.data));
          },

          loadCategories()
          {
              axios.get("/api/materialCategory/list").then(({ data }) => (this.materialCategories = data.data));
          },

          loadUoms()
          {
              axios.get("/api/uom/list").then(({ data }) => (this.uoms = data.data));
          },


          getMaterials: function()
          {
            axios.get("/api/wip/material/" + this.selectedOrder)
                 .then( function(response) {this.buildMaterials = response.data; }.bind(this))
                 .catch((error) => {  console.log(error.data) });
          },
        
        },

        mounted()
        {
            
        },

        created()
        {
            this.$Progress.start();
            this.loadOrders();
            this.loadMaterials();
            this.loadCategories();
            this.loadUoms();
            this.$Progress.finish();
        },
        
        computed: {
        
        },
    }
</script>
