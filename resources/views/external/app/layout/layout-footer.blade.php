<footer class="page-footer font-small blue pt-4"><!-- Footer -->


    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 copy"> Todos los Derechos Reservados  © {{date("Y")}} Copyright: WIN TECNOLOGIES INC S.A.</div>
  </footer><!-- End Footer -->
  <script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')     }}"></script>
  <script src="{{ asset('/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('/dist/js/demo.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>

  @yield('script')
  </body>
</html>
