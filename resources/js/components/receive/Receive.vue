<template>

<section class="content">

  <div class="container-fluid">

    <div class="row" >

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">


                    <h3 class="card-title">Receiving</h3>

                     <div class="card-tools">
                  
                    
                    </div>

                </div> <!-- /.card-header -->

                

                     <div class="card-body m-4 p-0">
                         


                      <form @submit.prevent= "createReceive()">

                        

                        <div class="form-group row mt-20 ">

                                <div class="card">

                                    <div class="table-responsive">

                                        <table class="table table-stripped table-bordered"  id="add-product">
                                            <thead>
                                                <tr>
                                                  
                                                  <th style = "width: 25em;" > Item Description </th>
                                                  <th> Quantity </th>
                                                  <th> UnitPrice </th>
                                                  <th> Total </th>
                                                  <th> </th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="panel panel-default" v-for="(receivedItem, index) in form.receivedItems" :key="index">
                                                    
                                                    <!--<td><input type="text"  name="material_name" v-model="receiveItem.material_name"></td>  -->
                                                    <td >
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
                                                    <td><input class="form-control"  type="number" name="quantity"   v-model.number= "receivedItem.quantity" ></td>
                                                    <td><input class="form-control"  type="number" name="price"      v-model= "receivedItem.price" @keyup=" priceFormat" ></td>
                                                    <td> {{ total[index] | currency('Ksh') }} </td>


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
                                            <label for="receiveDate" class="col-5 col-form-label">Date <span>*</span> </label>
                                            <div class="col-7">
                                                <div class="input-group">
                                                    <input class="form-control" placeholder="dd-mm-yyyy" type= "date" name="receiveDate" v-model= "form.receiveDate" >
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                 <div class="col-md-6 px-3">

                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Payment</legend>
                                        <div class="form-group row">
                                            <label for="grandTotal" class="col-5 col-form-label">Grand Total</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control " name="grandTotal" v-model.number= "  grandTotal " readonly>
                                            </div>
                                        </div>

                                      

                                    

                                    </fieldset>
                                </div> 

                                    <div class="form-group row">
                                           <div class="col-md-6 px-3">
                                             
                                              <button type="submit" class="btn btn-primary ">Receive</button>
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
              quantity: '1',
              price: '0.00',
              total: '0.00',
              
            }],
          
            supplier_id: '',
            purchaseOrder: '',
            receiveDate: moment().format('YYYY-MM-DD').toString(),
            user_id: document.head.querySelector('meta[name="user_id"]').getAttribute('content'),
            grandTotal: '0.00',
           


        }),


    }

},

methods:{
...mapActions(["fetchMaterials", "fetchSuppliers"]),


  currencyFormat(value)
    {
        if (typeof value !== "number") {
        return value;
        }
     const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'KSH',
      minimumFractionDigits: 0
    });
    return formatter.format(value);
    },


    priceFormat(){

      this.receivedItem.price = this.currencyFormat(this.receivedItem.price);
    },
 
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
        quantity: "1",
        price: "0.00",
        total: "0.00",
       
        
      });
    },

    deleteItem(index) {
      this.form.receivedItems.splice(index, 1);
    },

    createReceive(){

              this.$Progress.start();

              this.form.post('api/receive/material')
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
    ...mapGetters(["allMaterials","allSuppliers", "allPaymentTypes"]),

     total() {
      return this.form.receivedItems.map((item) => {
        return Number(item.quantity * item.price)
      });
    },


    grandTotal() {

      let totalArray = this.form.receivedItems.map((item) => {
        return Number(item.quantity * item.price)
      });

        return totalArray.reduce(( previousValue, currentValue ) => previousValue + currentValue, 0 )
     
    },

    

    },

    watch:{
/*
      'receivedItem.price': function(val){
        this.receivedItem.price = this.currencyFormat(val);
      },
*/

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

