<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product List</h3>

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
                      <th>Name</th>
                      <th>ItemCode</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Availability</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(product, index ) in products.data" :key="product.id">

                      <td>{{index + 1}}</td>
                      <td>{{product.name}}</td>
                      <td>{{product.code}}</td>
                      <td>{{product.description | truncate(30, '...')}}</td>
                      <td>{{product.category.name}}</td>
                      <td>{{product.price | currency('Ksh')}}</td>
                      <td> <span :class= "{
                                              'badge badge-success': product.stock_availability.name === 'In stock',
                                              'badge badge-danger': product.stock_availability.name === 'Not available',
                                              'badge badge-warning': product.stock_availability.name === 'Expected',
                                              'badge badge-info': product.stock_availability.name === 'Sold',
                                         }"
                            >
                         
                         {{product.stock_availability.name}} 
                         
                        </span> 
                      </td>

                      <!-- <td><img v-bind:src="'/' + product.photo" width="100" alt="product"></td> -->
                      <td>
                        
                        <a href="#" @click="editModal(product)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteProduct(product.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="products" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Create New Product</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateProduct() : createProduct()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model= "form.name" type="text" name= "name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form= "form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label>ItemCode</label>
                            <input v-model= "form.code" type="text" name="code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                            <has-error :form= "form" field="code"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input v-model= "form.description" type="text" name="description"
                                class="form-control" :class= "{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form= "form" field="description"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input v-model= "form.price" type="text" name="price"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                            <has-error :form= "form" field="price"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Availability</label>
                            <select class="form-control" v-model= "form.stock_availability_id">
                              <option 
                                  v-for= "(cat,index) in availability" :key= "index"
                                  :value= "index"
                                  :selected= "index == form.stock_availability_id" > {{ cat }} </option>
                            </select>
                            <has-error :form= "form" field="stock_availability_id" ></has-error>
                        </div>


                        <div class="form-group">

                            <label>Category</label>
                            <select class="form-control" v-model= "form.category_id">
                              <option 
                                  v-for= "(cat,index) in categories" :key= "index"
                                  :value= "index"
                                  :selected= "index == form.category_id">{{ cat }}</option>
                            </select>
                            <has-error :form= "form" field= "category_id"></has-error>
                        </div>
                        
                    </div>
                    <div class= "modal-footer">
                        <button type= "button" class= "btn btn-secondary" data-dismiss= "modal">Close</button>
                        <button v-show= "editmode" type="submit" class= "btn btn-success">Update</button>
                        <button v-show= "!editmode" type="submit" class= "btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
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
                editmode: false,
                products : {},
                form: new Form({
                    id : '',
                    category : '',
                    name: '',
                    code:'',
                    description: '',
                    photo: '',
                    category_id: '',
                    price: '',
                    stock_availability_id:'',
                    photoUrl: '',
                }),
                categories: [],
                availability:[],
               
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/product?page=' + page).then(({ data }) => (this.products = data.data));

              this.$Progress.finish();
          },

          loadProducts()
          {
              axios.get("api/product").then(({ data }) => (this.products = data.data));
           
          },

          loadCategories()
          {
              axios.get("/api/category/list").then(({ data }) => (this.categories = data.data));
          },

           loadAvailabilitys()
           {
              axios.get("/api/availability/list").then(({ data }) => (this.availability = data.data));
           },

        
          editModal(product)
          {
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(product);
          },

          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createProduct(){
              this.$Progress.start();

              this.form.post('api/product')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadProducts();

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
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updateProduct(){
              this.$Progress.start();
              this.form.put('api/product/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadProducts();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteProduct(id){
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
                              this.form.delete('api/product/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadProducts();
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
            this.loadProducts();
            this.loadCategories();
            this.loadAvailabilitys();
            this.$Progress.finish();
        },
       
        computed: {
         
        },
    }
</script>
