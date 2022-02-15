<template>

<section class="content">

  <div class="container-fluid">

    <div class="row" >

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">


                    <h3 class="card-title">Order Recipe</h3>

                   

                </div> <!-- /.card-header -->

                

                     <div class="card-body m-4 p-0">
                         


                      <form @submit.prevent= "createOrderRecipe()">

                        <!-- begin select box -->

                        <div class="form-group row">

                        <div class="col-md-3 col-form-label">

                            <label class="form-control-label" for="selectedOrder"> Select Order  </label> 

                        </div>

                                <div class="col-md-3">
 
                                            <select class="form-control"  name="selectedOrder"  v-model= "form.selectedOrder"  >
                                                 <option 
                                                          v-for= "order in orders" :key= "order.id"
                                                          :value= "order.id"
                                                          :selected= "order.id == form.selectedOrder" >{{ order.buildable_id }}
                                                </option>
                                            </select>
                                                                                        
                                </div>

                        </div>

                        <!-- end select box -->

                        <div class="form-group row mt-20 ">

                                <div class="card">

                                    <div class="table-responsive">

                                        <table class="table table-stripped table-bordered"  id="add-product">
                                            <thead>
                                                <tr>
                                                  
                                                  <th style = "width: 25em;" > Item Description </th>
                                                  <th> Quantity </th>
                                                  <th> </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="panel panel-default" v-for= "(buildItem, index) in form.buildItems" :key= "index">
                                                    
                                                    <!--<td><input type="text"  name="material_name" v-model="buildItem.material_name"></td>  -->
                                                    <td >
                                                     <v-select
                                                                                                        
                                                         label= "material_name"
                                                         placeholder= "--select Items--"
                                                         :options = "materialArray"
                                                         :clearable = "true"
                                                         :searchable= "true"
                                                         :closeOnSelect= "true"
                                                         v-model = "buildItem.material_id"
                                                         :reduce = "material_name => material_name.id "
                                                         > 
                                         
                                                      </v-select>

                                                    </td>
                                                    <td><input class="form-control"  type="number" name="quantity"   v-model.number= "buildItem.quantity" ></td>
                                                    <td><button  class="btn btn-danger btn-sm" @click.prevent="deleteItem(index)">x</button></td> 
                                                    </tr>
                                                    <tr>
                                                       <td colspan="5">
                                                            <button class="btn btn-sm btn-primary" @click.prevent="addRow">Add Item</button>
                                                      </td>
                                                    </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>


                              <div class="form-group row mt-20">
                  
                                    <div class="form-group row">
                                           <div class="col-md-6 px-3">
                                             
                                              <button type="submit" class="btn btn-primary ">Allocate</button>
                                           </div>
                                    </div>
                             
                            </div> <!--end of row -->

    
                       </form>
                     </div>  <!--end card-body -->
                    
                     <div class="card-footer">
                
                     </div>

            </div> <!--end card -->

        </div> <!-- end col-lg-12 -->

    </div> <!-- end row   -->

  </div> <!-- end container-fluid -->

 </section> <!-- end section  -->

</template>

<script>
import moment from 'moment';
import { mapGetters, mapActions } from "vuex";

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';




export default {

components: {

        vSelect
        
        },
        
data(){

    return{
        moment:moment,
        editmode: false,
        materialArray:[],
      
        orders:[],

       
        form: new Form({
           
            buildItems: [{
              material_id:'',
              quantity: '1',
            }],
          
            selectedOrder: '',

        }),


    }

},

methods:{

    loadOrders(){
       axios.get("api/build/order")
            .then(({data}) => (this.orders = data.data));
    },

    loadMaterials(){
         
              axios.get("api/material/all")
                   .then(({ data }) => (this.materialArray = data.data));
              
          },

    addRow() {
      this.form.buildItems.push({
        material_id: "",
        quantity: "1",   
      });
    },

    deleteItem(index) {
      this.form.buildItems.splice(index, 1);
    },

    createOrderRecipe(){

              this.$Progress.start();

              this.form.post('api/build/material')
              .then((data)=>{
                if(data.data.success){
                 
                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.form.reset();

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
          }

    
},

mounted(){

  
    
},

computed: {
  

    },

 

created(){

            this.$Progress.start();
            this.loadMaterials();
            this.loadOrders();
            this.$Progress.finish();
  },

}
</script>

<style  scoped>

</style>

