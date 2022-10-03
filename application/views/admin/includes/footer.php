<!-- end modal -->
<footer class="footer">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-6">
            <script>document.write(new Date().getFullYear())</script> © Anil.
         </div>
         <div class="col-sm-6">
            <div class="text-sm-end d-none d-sm-block">
               Design & Develop by Megatask
            </div>
         </div>
      </div>
   </div>
</footer>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<div id="loader"></div>
<!-- JAVASCRIPT -->
 <script src="<?php echo base_url(); ?>assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/select2/js/select2.min.js"></script>
<!-- Required datatable js -->
<script src="<?php echo base_url()?>assets/admin/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- apexcharts -->
<!-- dashboard init -->
<script src="<?php echo base_url(); ?>assets/admin/js/pages/dashboard.init.js"></script>
<!-- App js -->
<script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>
<script type="text/javascript">
   function show_loader()
   {
       $("#loader").css("display","block");
   }
   function hide_loader()
   {
    $("#loader").css("display","none");   
   }
</script>
</body>
</html>