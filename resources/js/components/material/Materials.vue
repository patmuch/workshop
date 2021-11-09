<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Material List</h3>

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
                      <th>ID</th>
                      <th>Name</th>
                      <th>ItemCode</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>UOM</th>
                      <th>Costprice </th>
                      <th>Quantity</th>
                      <th>Reorder</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="material in materials.data" :key="material.id">
                      <td>{{material.id}}</td>
                      <td>{{material.material_name}}</td>
                      <td>{{material.material_code}}</td>
                      <td>{{material.description | truncate(30, '...')}}</td>
                      <td>{{material.material_category.name}}</td>
                      <td>{{material.uom.name}}</td>
                      <td>{{material.costprice}}</td>
                      <td>{{material.quantity}}</td>
                      <td>{{material.reorder_level}}</td>
                      <!-- <td><img v-bind:src="'/' + material.photo" width="100" alt="material"></td> -->
                      <td>
                        
                        <a href="#" @click="editModal(material)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteMaterial(material.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="materials" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Create New material</h5>
                    <h5 class="modal-title" v-show="editmode">Edit material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateMaterial() : createMaterial()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.material_name" type="text" name="material_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('material_name') }">
                            <has-error :form="form" field="material_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Code</label>
                            <input v-model="form.material_code" type="text" name="material_code"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('material_code') }">
                            <has-error :form="form" field="material_code"></has-error>
                        </div>

                      
                        <div class="form-group">
                            <label>Description</label>
                            <input v-model="form.description" type="text" name="description"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                        </div>

                         <div class="form-group">

                            <label>Category</label>
                            <select class="form-control" v-model="form.material_category_id">
                              <option 
                                  v-for="(cat,index) in materialCategories" :key="index"
                                  :value="index"
                                  :selected="index == form.material_category_id">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="material_category_id"></has-error>
                        </div>
                        
                          <div class="form-group">

                            <label>Unit of Measure</label>
                            <select class="form-control" v-model="form.uom_id">
                              <option 
                                  v-for="(cat,index) in uoms" :key="index"
                                  :value="index"
                                  :selected="index == form.uom_id">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="uom_id"></has-error>
                        </div>
                        

                        <div class="form-group">
                            <label>Costprice</label>
                            <input v-model="form.costprice" type="text" name="costprice"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('costprice') }">
                            <has-error :form="form" field="costprice"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <input v-model="form.quantity" type="text" name="quantity"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                            <has-error :form="form" field="quantity"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Reorder Level</label>
                            <input v-model="form.reorder_level" type="text" name="reorder_level"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('reorder_level') }">
                            <has-error :form="form" field="reorder_level"></has-error>
                        </div>

                        <input v-model="form.movement_id"  type="hidden" name="movement_id" value="">  
                   
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
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                materials : {},
                form: new Form({
                    id : '',
                    materialCategory : '',
                    material_name: '',
                    material_code: '',
                    description: '',
                    material_category_id: '',
                    uom_id: '',
                    reorder_level: '',
                    costprice:'',
                    quantity:'',
                    movement_id:'1'
                   
                }),
                materialCategories: [],
                uoms:[],
             
                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/material?page=' + page).then(({ data }) => (this.materials = data.data));

              this.$Progress.finish();
          },
          loadMaterials(){

            // if(this.$gate.isAdmin()){
              axios.get("api/material").then(({ data }) => (this.materials = data.data));
            // }
          },
          loadCategories(){
              axios.get("/api/materialCategory/list").then(({ data }) => (this.materialCategories = data.data));
          },
           loadUoms(){
              axios.get("/api/uom/list").then(({ data }) => (this.uoms = data.data));
          },
       
          editModal(material){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(material);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createMaterial(){
              this.$Progress.start();

              this.form.post('api/material')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadMaterials();

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
          },
          updateMaterial(){
              this.$Progress.start();
              this.form.put('api/materialUpdate/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadMaterials();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteMaterial(id){
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
                              this.form.delete('api/materialDel/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadMaterials();
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

            this.loadMaterials();
            this.loadCategories();
            this.loadUoms();
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
