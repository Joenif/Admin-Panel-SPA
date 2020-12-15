<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-success btn-lg" @click="newModal">
                    Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Register at</th>
                      <th>Modified</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr :key="user.id" v-for="user in users" >
                      <td>{{user.id}}</td>
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.role | upText}}</td>
                      <td>{{user.created_at | myDate}}</td>
                      <td>
                        <a href="#" @click="editModal(user)">
                          <i class="fas fa-edit blue fa-fw"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(user.id)">
                          <i class="fas fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update User's Info</h5>
                    <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name" placeholder="Name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email" placeholder="Email Address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <textarea v-model="form.bio" name="bio" placeholder="Short bio for user (optional)"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                        <div class="form-group">
                            <select v-model="form.role" type="text" name="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                <option value="">Select User Role</option>
                                <option value="admin" >Admin</option>
                                <option value="user" >Standard User</option>
                                <option value="author" >Author</option>
                            </select>
                            <has-error :form="form" field="role"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" placeholder="Password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                users: {},
                form: new form({
                    id: '',
                    name : '',
                    email : '',
                    password : '',
                    role: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            updateUser(id) {
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    Swal.fire(
                        'Updated',
                        'Information updated',
                        'success'
                    )
                    this.$Progress.finish();

                    Fire.$emit('reload');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(user) {
                this.editmode = true;
                this.form.clear();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id) {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/user/'+id).then(()=> {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('reload');
                        }).catch(()=>{
                            Swal.fire('Failed', 'There was something wrong.', 'warning');
                        });
                    }
                })

            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=> {
                    Fire.$emit('reload');
                    $('#addNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: 'User Created successfully'
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            loadUsers() {
                if(this.$gate.isAdminOrAuthor()) {
                    axios.get('api/user')
                    .then(({ data }) => (this.users = data.data));
                }
            }
        },
        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                axios.get('api/findUser?q='+ query)
                .then(({data}) => {
                    this.users = data.data
                })
                .catch(() => {

                });

            });
            this.loadUsers();
            Fire.$on('reload', () => {
                this.loadUsers();
            });
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
