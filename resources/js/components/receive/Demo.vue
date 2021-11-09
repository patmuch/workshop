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


                        <div class="form-group row">

                        <div class="col-md-3 col-form-label">
                            <label class="form-control-label" for="material">Select Material to receive </label> 

                        </div>

                                <div class="col-md-6">

                                        <!--    
                                            <select class="form-control"  name="selectedMaterialId"  v-model="selectedMaterialId" @change="setRecord"  >
                                                 <option 
                                                          v-for="(cat,index) in materials" :key="index"
                                                          :value="index"
                                                          :selected="index == selectedMaterialId">{{ cat }}</option>
                                            </select>
                                            
                                            <MaterialAutocomplete />

                                            -->

                                            <dropdown />

                                            
                                </div>

                                <div>
                                         <select-table />

                                </div>




                        </div>
          <!--  from here
                        <div class="form-group row">

                                <div class="col-sm-12">

                                    <div class="table-responsive">

                                        <table class="table table-sm table-bordered"  id="add-product">
                                            <thead>
                                                <tr>
                                                  <th>ItemCode</th>
                                                  <th>Name</th>
                                                  <th>Quantity</th>
                                                  <th>Unit Price</th>
                                                  <th>Total</th>
                                                  <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="panel panel-default" v-for="(receiveItem, key) in form.receiveItems" :key="key">
                                                       
                                                    <td><input type="text" readonly name="material_code" v-model="receiveItem.material_code"></td>
                                                    <td><input type="text"  name="material_name" v-model="receiveItem.material_name"></td>
                                                    <td><input type="number" name="quantity_received" v-model="receiveItem.quantity_received"></td>
                                                    <td><input type="number"  name="unitPrice" v-model="receiveItem.unitPrice"></td>
                                                    <td><input type="text"  name="total" v-model="receiveItem.total" readonly></td>
                                                    <td><button  class="btn btn-danger btn-sm">x</button></td> 
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
                                                <select class="form-control"  name="supplier_id" v-model="form.supplier_id"  required>
                                                    <option value="" selected disabled>Select supplier</option>
                                                     <option 
                                                          v-for="(cat,index) in suppliers" :key="index"
                                                          :value="index"
                                                          :selected="index == form.supplier_id">{{ cat }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="orderDate" class="col-5 col-form-label">Date <span>*</span> </label>
                                            <div class="col-7">
                                                <div class="input-group">
                                                    <input class="form-control" placeholder="dd-mm-yyyy" type= "date" name="orderDate" v-model="form.orderDate" >
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                 <div class="col-md-6 px-3">

                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Payment</legend>
                                        <div class="form-group row">
                                            <label for="subTotal" class="col-5 col-form-label">Sub Total</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control form-control-sm" name="subTotal" v-model="form.subTotal" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="discount" class="col-5 col-form-label">Discount</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control form-control-sm" name="discount" v-model="form.discount">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vat" class="col-5 col-form-label">Vat</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control form-control-sm" name="vat" v-model="form.vat">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="grandTotal" class="col-5 col-form-label">Grand Total</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control form-control-sm" name="grandTotal" v-model="form.grandTotal" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="paidAmount" class="col-5 form-control-label">Paid Amount <span>*</span></label>
                                            <div class="col-7">
                                                <input class="form-control form-control-sm" type="number" name="paidAmount" v-model="form.paidAmount"  required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="due" class="col-5 form-control-label">Due</label>
                                            <div class="col-7">
                                                <input class="form-control form-control-sm" type="text" name="due" v-model="form.due"  readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="paymentType_id" class="col-5 form-control-label">Payment Type <span>*</span></label>
                                            <div class="col-7">
                                                <select class="form-control" type="text"  name="payment_type_id" v-model="form.payment_type_id" required>
                                                    <option value=""> Please Select </option>
                                                    <option 
                                                          v-for="(cat,index) in paymentType" :key="index"
                                                          :value="index"
                                                          :selected="index == form.payment_type_id">{{ cat }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                              <button type="submit" class="btn btn-primary ">Add Material</button>

                                        </div>

                                    </fieldset>
                                </div> 
      
                            </div> 
        -->
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
import moment from 'moment'
import Dropdown from './Dropdown.vue'
import MaterialAutocomplete from './MaterialAutocomplete.vue'
import SearchAutocomplete from './SearchAutocomplete.vue'
import SelectTable from './SelectTable.vue'
export default {

components: {
          Dropdown,
          MaterialAutocomplete,
          SearchAutocomplete,
          SelectTable
        },
        
data(){

    return{
        moment:moment,
        editmode: false,
        materials:{},
        suppliers:{},
        paymentType:{},
        selectedMaterialId: false,

        form: new Form({
            id: [], 
            receiveItems: [{
              id:'',
              material_code: '',
              material_name: '',
              quantity_received: 1,
              unitPrice: 0,
              total: 0,
            }],
            supplier_id: '',
            purchaseOrder: '',
            orderDate:moment().format('YYYY-MM-DD').toString(),
            subtotal: '',
            discount: '',
            vat: '',
            grandTotal: '',
            paidAmount: '',
            due: '',
            payment_type_id: ''


        }),

         autocompleteItems: [],

    }

},

methods:{

       loadMaterials(){

              axios.get("api/material/list").then(({ data }) => (this.materials = data.data));
           
          },


     loadSuppliers(){

              axios.get("api/supplier/list").then(({ data }) => (this.suppliers = data.data));
           
          },

     loadPaymentTypes()
     {
          axios.get("api/paymentType/list").then(({data}) => (this.paymentType = data.data));
     },

     setRecord: function(e)
     {

        axios.get("api/materialFetch/"+ this.selectedMaterialId)
        .then(({data})  => (this.form.receiveItems = data))
        .catch(error => {
          console.log(error.response);
        });

     },

},
mounted(){
    
},

created(){
            this.$Progress.start();
            this.loadSuppliers();
            this.loadMaterials();
            this.loadPaymentTypes();
            this.$Progress.finish();
},
}
</script>
