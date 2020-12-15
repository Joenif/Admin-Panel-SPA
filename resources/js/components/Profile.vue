<style>
.widget-user-header {
    background-position: center center;
    background-size: cover;
    height: 250px!important;
}
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background-image: url('./img/user-cover-img.jpg')">
                        <h3 class="widget-user-username text-left"> {{form.name}} </h3>
                        <h5 class="widget-user-desc text-left">{{form.role}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="loadImage ? loadProfilePhoto() : getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
                                <h3>User Activity details</h3>
                            </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="settings">
                            <form>
                            <div class="form-group">
                                <label for="inputName" class="col-form-label">Name</label>
                                <div class="">
                                <input v-model="form.name" type="text" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-form-label">Email</label>
                                <div class="">
                                <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-form-label">Experience</label>

                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="dp" class="col-form-label">Profile Picture</label>
                                <div class="">
                                <input @change="updateProfile($event)" name="photo" type="file" class="" id="dp" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password (leave empty if not changing</label>
                                <div class="">
                                <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loadImage: false,
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
        mounted() {
            console.log(axios.defaults.headers.common['Authorization']);
        },

        methods: {
            getProfilePhoto() {
                this.loadImage = false;
                return 'img/profile/' + this.form.photo;
            },

            loadProfilePhoto() {
                this.loadImage = true;
                return this.form.photo;
            },

            updateInfo() {
                this.$Progress.start();
                this.form.post('api/profile?_method=PUT')
                .then(() => {
                    Swal.fire(
                        'Updated',
                        'Information updated',
                        'success'
                    );
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    Swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Could not upload your file. Try again!',
                    });
                })
            },

            updateProfile(event) {
                let file = event.target.files[0];
                let reader = new FileReader();

                if (file['size'] < 2111775) {

                    reader.onloadend = (file) => {
                        console.log(reader.result);
                        this.form.photo = reader.result;
                    }

                    Fire.$emit('reload');
                    reader.readAsDataURL(file);

                } else {
                    Swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file.',
                    });
                }
            },
        },

        created() {
            axios.get('api/profile')
            .then(({ data }) => (this.form.fill(data) ));

            Fire.$on('reload', () => {
                this.loadProfilePhoto();
            })
        }
    }
</script>
