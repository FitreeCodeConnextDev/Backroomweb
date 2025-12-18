import './bootstrap';
import 'flowbite';
import '../fonts/Anuphan[wght].woff2';
import ApexCharts from 'apexcharts';
import TomSelect from 'tom-select';
import $ from 'jquery';
import 'jquery-validation';
import 'jquery-validation/dist/additional-methods';
import Swal from 'sweetalert2';
import {
    DataTable
} from "simple-datatables";


window.$ = $;
window.jQuery = $;
window.DataTable = DataTable;
window.ApexCharts = ApexCharts;
window.TomSelect = TomSelect;


window.Swal = Swal;
// Provide common global aliases for code that expects different swal globals
window.swal = Swal;
window.sweetAlert = Swal;
window.SweetAlert2 = Swal;