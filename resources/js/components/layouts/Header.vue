<template>
<div>
    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" v-model='search' type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <!-- @keyup="searchit"
        @click="searchit" -->
          <button class="btn btn-navbar">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="../../../../public/img/logo.png" alt="Lara Vue Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../../../public/img/profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{$store.state.user.name}}
            <p>Admin</p>
        </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>

          <!-- For Admin -->
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog green"></i>
                <p>
                    Management
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Users</p>
                    </router-link>
                </li>
                </ul>
            </li>

            <li class="nav-item">
                <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Developer
                </p>
                </router-link>
            </li>
          <!-- End for Admin -->

          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" @click="logout">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                    Logout
                </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</div>
</template>
<script>
export default {
  name: 'Header',
  data() {
    return {
      search: ''
    }
  },
  methods: {
    logout() {
      axios.get('api/logout').then(response => {
        console.log(response.data.message);
        this.$store.remove();
        // delete axios.defaults.headers.common['Authorization'];
        this.$router.go('/login');
      }).catch(error => {
          window.location.reload();
      });
    }
  }  
}
</script>