<template>

<section class="content">

  <div class="container-fluid">

    <div class="row" >

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">


                    <h3 class="card-title">Receive Raw Materials</h3>

                     <div class="card-tools">
                  
                     <button type="button" class="btn btn-sm btn-primary" >
                      <i class="fa fa-plus-square"></i>
                      Check Material 
                     </button>
                    </div>

                </div> <!-- /.card-header -->

                

                     <div class="card-body m-4 p-0">
                         


                      <form @submit.prevent="editmode ? updateReceive() : createReceive()">

                        <div class="form-group row mt-20">
                           <div class="col-md-6">
                           <!--    <v-select
                                                                                                        
                                                        :value="form.receivedItems" 
                                                         label= "material_name"
                                                         placeholder="--select products--"
                                                         :options = "materialArray"
                                                         :clearable = "true"
                                                         :searchable= "true"
                                                         :closeOnSelect= "true"
                                                         @input="updateSelectedItems(receivedItems)" > 
                                         
                               </v-select>  -->
                           </div>
                        </div>                              

                        <div class="form-group row mt-20 ">

                                <div class="col-sm-12">

                                    <div class="table-responsive">

                                        <table class="table table-sm table-stripped table-bordered"  id="add-product">
                                            <thead>
                                                <tr>
                                                  
                                                  <th style="width: 40%;">Item</th>
                                                  <th style="width: 12%;">Quantity</th>
                                                  <th style="width: 20%;">UnitPrice</th>
                                                  <th style="width: 20%;">Total</th>
                                                  <th style="width: 8%;"></th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="panel panel-default" v-for="(receivedItem, index) in form.receivedItems" :key="index">
                                                    
                                                    <!--<td><input type="text"  name="material_name" v-model="receiveItem.material_name"></td>  -->
                                                    <td>
                                                     <v-select
                                                                                                        
                                                      
                                                         label= "material_name"
                                                         placeholder= "--select Items--"
                                                         :options = "materialArray"
                                                         :clearable = "true"
                                                         :searchable= "true"
                                                         :closeOnSelect= "true"
                                                         v-model = "receivedItem.id"
                                                         :reduce = "material_name => material_name.id "
                                                         > 
                                         
                                                    </v-select>
                                                    </td>
                                                    <td><input type="number" name="qty_received"   v-model.number= "receivedItem.qty_received" ></td>
                                                    <td><input type="number" name="unitPrice"      v-model.number= "receivedItem.unitPrice" ></td>
                                                    <td><input type="text"   name="total" readonly v-model.number= "total[index]" ></td>


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


                              <div class="row">

                                <div class="col-md-6 px-3">

                                    <fieldset class="scheduler-border">

                                        <legend class="scheduler-border">Supplier</legend>

                                        <div class="form-group row">
                                            <label for="purchaseOrder" class="col-5 col-form-label">Purchase order</label>
                                            <div class="col-7">
                                                 <input class="form-control" type="text" v-model="form.purchaseOrder" name="purchaseOrder" > 
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="supplier_id" class="col-5 form-control-label">Supplier <span>*</span></label>
                                            <div class="col-7">

                                                <v-select
                                                                                                        
                                                       
                                                         label= "fname"
                                                         placeholder= "Select Supplier"
                                                         :options = "suppliers"
                                                         :clearable = "true"
                                                         :searchable= "true"
                                                         :closeOnSelect= "true"
                                                         v-model = "form.supplier_id"
                                                         :reduce = "fname => fname.id "
                                                         > 

                                                         <template v-slot:option="supplier">
                                                         {{ supplier.fname }}   {{ supplier.lname }} 
                                                        </template>
                                                        <template slot="selected-option" slot-scope="supplier">
                                                      
                                                         {{ supplier.fname }}   {{ supplier.lname }} 
                                                        </template>

                                         
                                                    </v-select>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="orderDate" class="col-5 col-form-label">Date <span>*</span> </label>
                                            <div class="col-7">
                                                <div class="input-group">
                                                    <input class="form-control" placeholder="dd-mm-yyyy" type= "date" name="orderDate" v-model= "form.orderDate" >
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                 <div class="col-md-6 px-3">

                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Payment</legend>
                                        <div class="form-group row">
                                            <label for="subTotal" class="col-5 col-form-label">Grand Total</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control form-control-sm" name="grandTotal" v-model.number= "``grandTotal" readonly>
                                            </div>
                                        </div>

                                      

                                    

                                    </fieldset>
                                </div> 

                                    <div class="form-group row">
                                           <div class="col-md-6 px-3">
                                              <button type="submit" class="btn btn-primary ">Submit</button>
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
name: "receive",
components: {
        vSelect
        },
        
data(){

    return{
        moment:moment,
        editmode: false,
        materialArray:[],
        suppliers:[],
       
        form: new Form({
           
            receivedItems: [{
              id:'',
              qty_received: '1',
              unitPrice: '0',
              total: '0',
              
            }],
          
            supplier_id: '',
            purchaseOrder: '',
            orderDate:moment().format('YYYY-MM-DD').toString(),
            grandTotal: '0',
           


        }),


    }

},

methods:{
...mapActions(["fetchMaterials", "fetchSuppliers"]),
 
    loadMaterials(){
         
              axios.get("api/material/all")
                   .then(({ data }) => (this.materialArray = data.data));
              
          },

   loadSuppliers(){

              axios.get("api/supplier/all").then(({ data }) => (this.suppliers = data.data));
           
          },

    addRow() {
      this.form.receivedItems.push({
        id: "",
        qty_received: "1",
        unitPrice: "0",
        total: "0",
       
        
      });
    },

    deleteItem(index) {
      this.form.receivedItems.splice(index, 1);
    },

    
},

mounted(){

  
    
},

computed: {
    ...mapGetters(["allMaterials","allSuppliers", "allPaymentTypes"]),

     total() {
      return this.form.receivedItems.map((item) => {
        return Number(item.qty_received * item.unitPrice)
      });
    },


    grandTotal() {

      let totalArray = this.form.receivedItems.map((item) => {
        return Number(item.qty_received * item.unitPrice)
      });

        return totalArray.reduce(( previousValue, currentValue ) => previousValue + currentValue, 0 )
     
    },

    

    },
 

created(){

            this.$Progress.start();
            this.fetchMaterials();
            this.fetchSuppliers();
            this.loadMaterials();
            this.loadSuppliers();
            this.$Progress.finish();
},
}
</script>

<style  scoped>

</style>

