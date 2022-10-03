 <?php
        $role_id = $this->session->userdata('role_id');
        $action_requred = get_module_role($module_id['id'],$role_id);
 ?> 
<style type="text/css">
   .table>:not(caption)>*>* {
   border: 1px solid #3a863e;
   padding: 1px 1px;
   font-size: 10px;
   color: #000;
   }
   .mytablestyle{
   min-height: 500px;
   }
   .modal#advanceFilterModal .select2-dropdown{
   z-index:1056 !important;
   width: 200px !important;
   }
   .modal#advanceFilterModal .select2-container{
   width: 200px !important;
   }
   .modal#advanceFilterModal
   {
   z-index: 1051;
   }
   tbody tr td{
   text-align: center;
   }
</style>
<!-- Latest compiled and minified CSS -->
<div class="page-content">
   <?php include APPPATH.'views/admin/menu-strive.php';?>
   
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <?php $this->load->helper('form'); ?>
            <div class="row">
               <div class="col-md-12">
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show " role="alert" >', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); ?>
               </div>
            </div>
            <?php
               $this->load->helper('form');
               $error = $this->session->flashdata('error');
               if($error)
               {
                   ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <?php echo $error; ?> 
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }
               $success = $this->session->flashdata('success');
               if($success)
               {
                   ?>
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
               <?php echo $success; ?> 
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }
               ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-12">
            <div class="row">
               <div class="col-lg-12">
                  <form method="GET" action="<?php echo base_url()?>admin/consultants" id="booking_filter">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-8">
                                 Consultant
                              </div>
                              <div class="col-sm-2">
                                  <?php 
                              $add_btn = (@$action_requred->create=='create')?'<a class="btn btn-primary p-1" href="'.base_url().'admin/consultants/create"><i class="fa fa-plus"></i> Add New</a>':"";
                              echo $add_btn;
                            ?>
                                  <a href="<?php echo base_url()?>admin/consultants" class="btn btn-info btn-sm">Clear</a> 
                                 <button type="submit" name="submit_filter" id="submit_filter" value="Submit Filter"  class="btn btn-info btn-sm">
                                 <i class="bx bx-search-alt-2"></i> Submit Filter</button>
                                 <input name="form_type" type="hidden" value="inquiry">
                              </div>
                              <div class="col-sm-2">
                                 <div class="input-group">
                                    <span  class="form-control form-control-sm btn btn-sm btn-light waves-effect" for="ticket_status">Ticket Status :</span> 
                                    <select class="form-control form-control-sm" id="ticket_status2" name="ticket_status2">
                                       <option value="" selected>Status</option>
                                       <?php
                                          if(!empty($tickets_status))
                                          {
                                                  foreach ($tickets_status as $ticket_status) {
                                                      ?>
                                       <option value="<?php echo $ticket_status->slug;?>"><?php echo $ticket_status->title;?></option>
                                       <?php
                                          }
                                          }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </h5>
                        <div class="card-body pb-0">
                           <div class="table-responsive mytablestyle">
                              <input type="text" name="start_date"  id="start_date" hidden >
                              <input type="text" name="end_date"  id="end_date"  hidden  >
                              <table class="table table-striped align-middle table-nowrap mb-0" id="example">
                                 <thead class="table-light">
                                    <tr>
                                       <th class="align-middle bg-success text-white">Action</th>
                                       <th class="align-middle bg-success text-white">Ticket ID</th>
                                       <th class="align-middle bg-success text-white">Call Type</th>
                                       <th class="align-middle bg-success text-white">Problem</th>
                                       <th class="align-middle bg-success text-white">Sub Problem</th>
                                       <th class="align-middle bg-success text-white">Farmer ID</th>
                                       <th class="align-middle bg-success text-white">Mobile</th>
                                       <th class="align-middle bg-success text-white">Farmer Name</th>
                                       <th class="align-middle bg-success text-white">Assignee</th>
                                       <th class="align-middle bg-success text-white">Status</th>
                                       <th class="align-middle bg-success text-white">Follow Up Date</th>
                                       <th class="align-middle bg-success text-white">Date</th>
                                       <th class="align-middle bg-success text-white">Entry Made By</th>
                                    </tr>
                                    <tr>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="ticket_id" id="ticket_id" placeholder="TicketId"  style="width: 70px;">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="call_type" name="call_type" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Call Type</option>
                                             <?php
                                                if(!empty($calltypes))
                                                {
                                                        foreach ($calltypes as $calltype) {
                                                            ?>
                                             <option value="<?php echo $calltype->slug;?>"><?php echo $calltype->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="document_category_id" name="document_category_id" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Problem</option>
                                             <?php
                                                if(!empty($documents_category))
                                                {
                                                        foreach ($documents_category as $document_category) {
                                                            ?>
                                             <option value="<?php echo $document_category->id;?>"><?php echo $document_category->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="farmer_id" id="farmer_id" placeholder="Farmer ID">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="farmer_mobile" id="farmer_mobile" placeholder="Mobile">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="farmer_name" id="farmer_name" placeholder="Farmer Name">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="assigned_to" name="assigned_to" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Assignee</option>
                                             <?php
                                                if(!empty($all_agents))
                                                {
                                                        foreach ($all_agents as $all_agent) {
                                                            ?>
                                             <option value="<?php echo $all_agent->id;?>"><?php echo $all_agent->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="tickets_status" name="tickets_status" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Status</option>
                                             <?php
                                                if(!empty($tickets_status))
                                                {
                                                        foreach ($tickets_status as $ticket_status) {
                                                            ?>
                                             <option value="<?php echo $ticket_status->slug;?>"><?php echo $ticket_status->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="date" name="follow_up_date" id="follow_up_date"  >
                                       </th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       /*   echo "<pre>";
                                       
                                          print_r($_SESSION);
                                          echo "</pre>";*/
                                       
                                       
                                         if(!empty($consultants)){
                                           foreach($consultants as $bookings){ ?>
                                    <tr>
                                       <td>
                                          <div class="btn-group">
                                             <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                             Action<i class="mdi mdi-chevron-down"></i>
                                             </span>
                                             <div class="dropdown-menu" style="">
                                                <?php 
                                                   if(@$action_requred->edit=='edit'){
                                                      ?>
                                                      <a class="dropdown-item btn" href="<?php echo base_url()?>admin/consultants/<?php echo $bookings['id']; ?>/edit" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                                      <?php
                                                   }

                                                   if(@$action_requred->delete=='delete')
                                                   {
                                                      ?>
                                                     <a class="dropdown-item text-danger deletebtn" href="#" data-userid="<?php echo $bookings['id']; ?>">Delete</a>
                                                      <?php
                                                   }
                                                ?>
                                                 
                                             </div>
                                          </div>
                                       </td>
                                       <td><?php echo (@$action_requred->edit=='edit')?'<a href="'.base_url().'admin/consultants/'.$bookings['id'].'/edit" >'.$bookings['id'].'</a>':$bookings['id'];?></td>
                                       <td><?php echo $bookings['calltypename'];?></td>
                                       <td><?php echo (@$action_requred->edit=='edit')?'<a href="'.base_url().'admin/consultants/'.$bookings['id'].'/edit" >'.$bookings['documentcategoryname'].'</a>':$bookings['documentcategoryname'];?></td>
                                       <td><?php echo (@$action_requred->edit=='edit')?'<a href="'.base_url().'admin/consultants/'.$bookings['id'].'/edit" >'.$bookings['documentname'].'</a>':$bookings['documentname'];?></td>
                                       
                                       <td><?php echo $bookings['farmer_id'];?></td>
                                       <td><?php echo $bookings['farmer_mobile'];?></td>
                                       <td><?php echo $bookings['farmer_name'];?></td>
                                       <td><?php echo $bookings['assignedto'];?></td>
                                       <td><span class="badge rounded-pill bg-<?php echo $bookings['booked_badge_color'];?>"><?php echo $bookings['booked_status'];?></span></td>
                                       <td><?php echo ($bookings['follow_up_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['follow_up_date'])) :'';?></td>
                                       <td><?php echo ($bookings['date_at']!=='0000-00-00')? date('d M Y',strtotime($bookings['date_at'])) :'';?></td>
                                       <td><?php echo $bookings['createdby'];?></td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr>
                                       <td colspan="100">Consultant (s) not found...
                                       <td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                           <div class="row">
                              <div class="col-sm-3">
                                 <ul class="pagination  justify-content-left mt-4"  >
                                    <li class="">
                                       <p>Total <?php echo @$pagination_total_count; ?> Consultant</p>
                                    </li>
                                 </ul>
                              </div>
                              <div class="col-sm-9">
                                 <?php echo @$pagination; ?>  
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
<!--  Large modal example -->
<script type="text/javascript">
   toastr.options = {
     "closeButton": true,
     "debug": false,
     "newestOnTop": false,
     "progressBar": false,
     "positionClass": "toast-top-right",
     "preventDuplicates": false,
     "onclick": null,
     "showDuration": "300",
     "hideDuration": "10000",
     "timeOut": "5000",
     "extendedTimeOut": "1000",
     "showEasing": "swing",
     "hideEasing": "linear",
     "showMethod": "fadeIn",
     "hideMethod": "fadeOut"
   }
</script>
<script type="text/javascript">
   jQuery(document).ready(function(){
      jQuery(document).on("click", ".deletebtn", function(){
   
         var userId = $(this).data("userid"),
           hitURL = "<?php echo base_url() ?>admin/consultants/delete",
           currentRow = $(this);
         
         var confirmation = confirm("Are you sure to delete this?");
         
         if(confirmation)
         {
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId } 
           }).done(function(data){           
             currentRow.parents('tr').remove();
             if(data.status = true) { alert("successfully deleted"); }
             else if(data.status = false) { alert("deletion failed"); }
             else { alert("Access denied..!"); }
           });
         }
   });
   
        // change status steps start
        jQuery(document).on("click", ".changestatusbtn", function(){
   
         var userId  = $(this).data("userid");
         var farmer_id  = $(this).data("farmer_id");
         var status_title  = $(this).data("status_title");
         var form_action      = "<?php echo base_url() ?>admin/bookings/"+userId+"/status";
         var cancel_form_action      = "<?php echo base_url() ?>admin/bookings/"+userId+"/cancel_status";
         var hitURL = "<?php echo base_url() ?>admin/bookings/single/"+userId;
         show_loader();
   
         jQuery.ajax({
           type      : "POST",
           dataType  : "json",
           url       : hitURL,
           data      : { id : userId } 
         }).done(function(response){
           hide_loader();
   
           if(response)
           {
             var data = response;
             
             $('#change_booking_status').attr('action', form_action);
             $('#cancel_booking').attr('action', cancel_form_action);
             $('#cancel_booking #farmer_id').val(farmer_id);
             $('#exampleModal').modal('show');
             $('#update_booking_status').val(data.booking_status);
             $('#current_status').text(status_title);
   
           }
         });
   });
});
</script>
<!-- Get Databse List -->
<script type="text/javascript">
   var table;
    
   $(document).ready(function() {
      
      
    $("#query-pagination li.page-item a").addClass('page-link');
       
   });
</script>
<!-- Status Change -->
<script type="text/javascript">
   jQuery(document).ready(function(){
   
   
      $('#call_type, #document_category_id, #assigned_to, #tickets_status, #follow_up_date, #ticket_status2').on(
           'change',
           function() {
               $('#booking_filter').submit();
           });
   
   
        jQuery(document).on("change", ".statusBtn", function(){
   
         var userId = $(this).attr("data-id");
         var value  = $(this).val();
   
           hitURL = "<?php echo base_url() ?>admin/booking/statusChange",
           currentRow = $(this);
         
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId, status : value } 
           }).done(function(data){           
             //currentRow.parents('tr').remove();
             if(data.status = true) { alert("successfully status changed"); }
             else if(data.status = false) { alert("status failed failed"); }
             else { alert("Access denied..!"); }
           });
         
   });
   });
   
   
   window.addEventListener("keydown", checkKeyPressed, false);
   
   function checkKeyPressed(e)
   {
     if (e.keyCode == "13")
     {
   
       $('#booking_filter').submit();
     }
   }
   
</script>