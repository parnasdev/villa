require('./bootstrap');
import Bootstrap from './files/bootstrap.min'

import Alpine from 'alpinejs'
import Swal from "sweetalert2";

window.Alpine = Alpine
window.Bootstrap = Bootstrap
Alpine.start()
window.Swal = Swal;
