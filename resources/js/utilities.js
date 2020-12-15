
import { Form, HasError, AlertError } from 'vform'
import moment from 'moment'
import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar'


window.Swal = Swal;
window.Toast = Swal;
window.form = Form;

window.Fire = new Vue();

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})



Vue.filter('upText', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
  });

Vue.filter('myDate', function(created) {
    return moment(created).format('MMMM Do YYYY');
});
