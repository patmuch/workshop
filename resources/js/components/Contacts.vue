<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Contact List</h3>

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
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="contact in contacts.data" :key="contact.id">

                      <td>{{contact.id}}</td>
                      <td>{{contact.fname}}</td>
                      <td>{{contact.lname}}</td>
                      <td>{{contact.email}}</td>
                      <td>{{contact.phone}}</td>
                      <td>{{contact.contact_type.name}}</td>
                      <td>
                        <a href="#" @click="editModal(contact)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteContact(contact.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="contacts" @pagination-change-page="getResults"></pagination>
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
                    <h5 class="modal-title" v-show="!editmode">Create New Contact</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateContact() : createContact()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name</label>
                            <input v-model="form.fname" type="text" name="fname"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('fname') }">
                            <has-error :form="form" field="fname"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input v-model="form.lname" type="text" name="lname"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('lname') }">
                            <has-error :form="form" field="lname"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>


                        <div class="form-group">
                            <label>Phone</label>
                            <input v-model="form.phone" type="text" name="phone"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group">

                            <label>Type</label>
                            <select class="form-control" v-model="form.contact_type_id">
                              <option 
                                  v-for="(cat,index) in contact_types" :key="index"
                                  :value="index"
                                  :selected="index == form.contact_type_id">{{ cat }}</option>
                            </select>
                            <has-error :form="form" field="contact_type_id"></has-error>
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
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
                editmode: false,
                contacts : {},
                form: new Form({
                    id : '',
                    contact_type : '',
                    fname: '',
                    lname: '',
                    email: '',
                    phone: '',
                    contact_type_id: '',
                    
                }),
                contact_types: [],

                autocompleteItems: [],
            }
        },
        methods: {

          getResults(page = 1) {

              this.$Progress.start();
              
              axios.get('api/contact?page=' + page).then(({ data }) => (this.contacts = data.data));

              this.$Progress.finish();
          },
          loadContacts(){

            // if(this.$gate.isAdmin()){
              axios.get("api/contact").then(({ data }) => (this.contacts = data.data));
            // }
          },
          loadTypes(){
              axios.get("/api/contactType/list").then(({ data }) => (this.contact_types = data.data));
          },
          

          editModal(contact){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(contact);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createContact(){
              this.$Progress.start();

              this.form.post('api/contact')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadContacts();

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
          updateContact(){
              this.$Progress.start();
              this.form.put('api/contact/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadContacts();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteContact(id){
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
                              this.form.delete('api/contact/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadContacts();
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
            this.loadContacts();
            this.loadTypes();
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
