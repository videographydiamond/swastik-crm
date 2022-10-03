<link href="<?php echo base_url(); ?>assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
   table.dataTable td, table.dataTable th {
    padding: 1px 2px !important;
}

   .table>:not(caption)>*>* {
   padding: 3px 3px;
   font-size: 10px;
   color: #000;
   }
   .mytablestyle {
   max-height: 455px;
   }
</style>
<?php
        $role_id = $this->session->userdata('role_id');
        $action_requred = get_module_role($module_id['id'],$role_id);
?>
<div class="page-content">
  
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
                  <div class="card">
                   

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-3">
                            Employee Attendance List
                           </div>
                           
                           <div class="col-sm-9 ">
                            <div class="row">
                              <div class="col-sm-12">
                                
                                     <div class="float-end">
                                       <a class="btn btn-info   btn-sm"  href="<?php echo base_url(); ?>admin/attendance/addnew"><i class="fa fa-plus"></i> Attendance Form</a>
                                     
                                    <a class="btn btn-info btn-sm ml-2 mr-2 btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#exportAttendanceModal" ><i class="bx bx-file"></i> Export Attendance</a>
                                     </div>
                                  
                              </div>
                            </div>

                          
                         
                          

                            </div>
                         </div>
                       </h5>
                      

                       <div class="card-body">
                        
                        <form class="date-between-filter" action="<?php echo base_url()?>admin/attendance/datebetween_attendance" method="get">
                          <div class="row">
                              <div class="col-sm-2">
                                 <div class="row">
                                    <label for="name" class= "col-form-label">Employe Name <span class="text-danger">*</span></label>
                                    <div class=""> 

                                      <?php
                                        if($this->session->userdata('role')==1)
                                        {
                                          ?>
                                             <select class=" form-control form-control-sm " id="uid" name="uid" aria-label="Floating label select example" >
                                              <option value="">Select</option>>
                                               <?php
                                                  if(!empty($all_agents))
                                                  {
                                                     $userid = $this->session->userdata('userId');
                                                      foreach ($all_agents as $all_agent) {
                                                         
                                                            ?>
                                                        
                                               <option value="<?php echo $all_agent->id;?>" <?php echo ($all_agent->id==@$_GET['uid'])?'selected':'';?> > <?php echo ( ($all_agent->id)?$all_agent->id:'')." ".$all_agent->title;?></option>
                                               <?php
                                                         
                                                          
                                                  }
                                                  }
                                                  ?>

                                            </select>
                                          <?php
                                        }else
                                        {
                                          ?>
                                          <input type="text" class="form-control form-control-sm" placeholder="Crop Type Name*" value="<?php echo $this->session->userdata('name')?>" readonly >
                                          <?php
                                        }
                                      ?>
                                       
                                       
                                    </div>
                                 </div>
                              </div> 
                              <div class="col-sm-2">
                                 <div class="row">
                                    <label for="name" class= "col-form-label">From :<span class="text-danger">*</span></label>
                                    <div class=" "> 
  <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" required="" value="<?php echo (isset($_GET['start_date']))?(@$_GET['start_date']):date('Y-m-d');?>">
                                    </div>
                                 </div>
                              </div> 
                              <div class="col-sm-2">
                                 <div class="row">
                                    <label for="name" class= "col-form-label">To :<span class="text-danger">*</span></label>
                                    <div class=" "> 
                                       <input type="date" class="form-control form-control-sm" id="end_date" name="end_date"  required="" value="<?php echo (isset($_GET['end_date']))?(@$_GET['end_date']):date('Y-m-d');?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-2">
                                 <div class="row">
                                     <label for="name" class= "col-form-label">&nbsp;</label>
                                    <div class=" "> 
                                        <input type="submit" name="search" class="btn btn-sm btn-primary" value="Search" />
                                    </div>
                                 </div>
                              </div>
                              
                           </div>
                        </form>
                       
                        
                      </div>
                        <!-- end table-responsive -->
                     </div>
                     
                  </div>


                    
               </div>
            </div>
         </div>
         <div class="row">
          <div class="col-xl-12">
            
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                    

                       <div class="card-body">
                        
                        <div class="table-responsive mytablestyle">
                             <table class="display table table-striped align-middle table-nowrap mb-0" cellspacing="0" width="100%" id="example">
                                  <thead>
                                    <tr class=" bg-success text-white text-center">
                                      <th colspan="7">
                                        <h3 class="text-white">
                                          <?php echo @$username->title;?>
                                        </h3>
                                      </th>
                                    </tr>
                                  <tr class=" bg-success">
                                    <th style="width: 60px;">S.No.</th>
                                    <th>Date</th>                                            
                                    <th>Check In</th>                                            
                                    <th>Last Check In</th>                                            
                                    <th>Last Check Out</th>                                            
                                    <th>Worked Hour</th>                                            
                                    <th class="text-center" style="width: 60px;">Actions</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                   $total_hours_worked =0;
                                   $totalhour=[];
                                    /*echo (@$action_requred->edit=='edit') ? ('edit') : ('not edit');die;*/
                                    if(!empty($attendance))
                                    {
                                      $inc =0;
                                     
                                      foreach ($attendance as $key => $value) {
                                       
                                        $inc++;


                                         
                                         
                                        ?>
                                 <tr>
                                  <?php
                                      $view_btn = (@$action_requred->view=='view')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/attendance/view/'.$value['id'].'/'.$value['att_date'].'/'.$value['user_id'].'" title="View" ><i class="fa fa-eye"></i> Details</a>&nbsp;':"";
                                  ?>
                                         
                                       
                                    <td><?php echo $inc;?></td>
                                    <td><?php echo date('d M Y',strtotime($value['att_date']));?></td>
                                    <td><?php echo (isset($value['checkin']) && $value['checkin'] !== null)?date("h:i:s A", strtotime($value['checkin'])):'_:_:_ XX';?></td>
                                    <td><?php echo (isset($value['last_checkin']) && $value['last_checkin'] !== null)?date("h:i:s A", strtotime($value['last_checkin'])):'_:_:_ XX';?></td>
                                    <td><?php echo (isset($value['last_checkout']) && $value['last_checkout'] !== null)?date("h:i:s A", strtotime($value['last_checkout'])):'_:_:_ XX';?></td>
                                     
                                    <td><?php echo  $value['worked_hour'];?></td>
                                    <td><?php echo  $view_btn;
                                     $totalhour[$inc] = $value['worked_hour'];

                                    ?></td>
                                  </tr>
                                 <?php
                                    }
                                    
                                    }else{
                                    
                                    ?>
                                 <tr>
                                    <td colspan="100"><span class="text-damger">Not Record Found !</span></td>
                                 </tr>
                                 <?php
                                    }
                                  ?>
                                  <tr>
                                    <th colspan="5"><span class="float-end">Working Hours Summary</span></th>
                                    <th>
                                      <?php 

                                          $seconds = 0;
                                          foreach($totalhour as $t)
                                          {
                                          $timeArr = array_reverse(explode(":", $t));

                                          foreach ($timeArr as $key => $value)
                                          {
                                              if ($key > 2) break;
                                              $seconds += pow(60, $key) * $value;
                                          }

                                          }

                                          $hours = floor($seconds / 3600);
                                          $mins = floor(($seconds - ($hours*3600)) / 60);
                                          $secs = floor($seconds % 60);

                                          echo $hours.':'.$mins.':'.$secs;
                                          ?>
                  
                                    </th>
                                    <th></th>
                                  </tr>

                                  </tbody>
                                </table>
                           
                        </div>
                        
                      </div>
                        <!-- end table-responsive -->
                     </div>
                     
                  </div>


                    <div class="row">
                  <div class="col-sm-2">
                     <ul class="pagination  justify-content-left float-start mt-4"  >
                        <li class="">
                           <p><?php echo @$pagination_total_count; ?> Attendance. </p>
                        </li>
                     </ul>
                  </div>
                  <div class="col-sm-10">
                     <?php echo $this->pagination->create_links(); ?>  
                  </div>
               </div>
               </div>
            </div>
         </div>
      </div>
    </div>
</div>
<!--  export Export Attendance form modelfor excel file -->
<div class="modal fade" id="exportAttendanceModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exportAttendanceModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="add_booking_payment" method="post" id="add_booking_payment" action="<?php echo base_url();?>admin/attendance/exportattn">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="exportAttendanceModalLabel">Export Attendance</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Start Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="start_date" id="start_date" value="<?php echo date('Y-m-d');?>" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">End Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="end_date" id="end_date" value="<?php echo date('Y-m-d');?>" >
                  </div>
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Download</button>
             </div>
         </div>
      </form>
   </div>
</div>



 
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
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
<!-- Delete Script-->
  <script type="text/javascript">
    jQuery(document).ready(function(){
        //$('#example').DataTable();

         jQuery(document).on("click", ".deletebtn", function(){

          var userId = $(this).data("userid"),
            hitURL = "<?php echo base_url() ?>admin/attendance/delete",
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
              if(data.status = true) { 
                toastr.success("successfully deleted"); 
              }
              else if(data.status = false) {
              toastr.error("deletion failed"); 
              }
              else { 
                 toastr.error("Access denied..!");
                 }
            });
          }
    });
    });
   
</script>
 
  <script type="text/javascript">
    jQuery(document).ready(function(){
      $("#query-pagination li.page-item a").addClass('page-link');

         jQuery(document).on("change", ".statusBtn", function(){

          var userId = $(this).attr("data-id");
          var value  = $(this).val();

            hitURL = "<?php echo base_url() ?>admin/attendance/statusChange",
            currentRow = $(this);
          
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : userId, status : value } 
            }).done(function(data){           
               
              if(data.status == true) { 
                toastr.success("successfully status changed");
                
                 }
              else if(data.status = false) {
                toastr.error("status failed failed");
                 }
              else { 
                toastr.error("Access denied..!");
              }
            });
          
    });
    });
   
</script>








