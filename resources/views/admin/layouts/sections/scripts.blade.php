<!-- Bootstrap core JavaScript-->
<script src="{{ env('APP_URL') }}/vendor/jquery/jquery.min.js"></script>
<script src="{{ env('APP_URL') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="{{ env('APP_URL') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="{{ env('APP_URL') }}/js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
@if($active != 'buys')
	<script src="{{ env('APP_URL') }}/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="{{ env('APP_URL') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<!-- Page level custom scripts -->
	<script src="{{ env('APP_URL') }}/js/demo/datatables-demo.js"></script>
@endif
