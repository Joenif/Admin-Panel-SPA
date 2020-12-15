<template>
  <div id="app">
    <Header v-if="! $route.meta.guest" />
    <GHeader v-if="$route.meta.guest" />
    <!-- Admin Page for loggedin users -->
    <div v-if="$route.meta.guest == false || $route.meta.guest==null" class="content-wrapper">
        <!-- Main content -->
        <div class="content">
        <div class="container-fluid">
            <div class="row">
            <router-view></router-view>
            <!-- set progressbar -->
            <vue-progress-bar></vue-progress-bar>
            
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <div v-else-if="$route.meta.guest">
        <router-view />
    </div>
    <!-- /.content-wrapper -->
    <Footer v-if=" ! $route.meta.guest" />

  </div>
</template>

<script>
import Header from './components/layouts/Header';
import GHeader from './components/layouts/Guest Header';
import Footer from "./components/layouts/Footer";
import GFooter from "./components/layouts/Guest Footer";
export default {
  components: {
      Header,
      Footer,
      GHeader,
      GFooter
  },
    name: 'App',
    data() {
        return {
            isLoggedin: Boolean,
        }
    },
    created() {
        
    }
}
</script>

<style>

</style>