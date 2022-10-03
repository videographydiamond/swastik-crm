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
                                  <a class="btn btn-info   btn-sm"  href="<?php echo base_url(); ?>admin/attendance/addnew"><i class="bx bx-plus"></i> Attendance Form</a>
                                  <a class="btn btn-info btn-sm ml-2 mr-2 btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#importAttendanceModal" ><i class="bx bx-time"></i> Bulk Check In</a>
                                  <a class="btn btn-info btn-sm ml-2 mr-2 btn-outline-secondary"  data-bs-toggle="modal" data-bs-target="#exportAttendanceModal" ><i class="bx bx-file"></i> Export Attendance</a>
                                </div>
                               </div>
                            </div>
                          </div>
                         </div>
                       </h5>
                      

                       <div class="card-body">
                        
                        <form class="date-between-filter" action="<?php echo base_url()?>admin/attendance/<?php echo ($this->session->userdata('role')==1)?'datebetween_attendance':'index'?>" method="get">
                          <div class="row">
                              <div class="col-sm-2">
                                 <div class="row">
                                    <label for="name" class= "col-form-label">Employee Name</label>
                                    <div class=""> 

                                      <?php
                                        if($this->session->userdata('role')==1)
                                        {
                                          ?>
                                             <select class=" form-control form-control-sm " id="uid" name="uid" aria-label="Floating label select example" required="" >
                                              <option value="">Select</option>>
                                               <?php
                                                  if(!empty($all_agents))
                                                  {
                                                     $userid = $this->session->userdata('userId');
                                                      foreach ($all_agents as $all_agent) {
                                                         
                                                            ?>
                                                        
                                               <option value="<?php echo $all_agent->id;?>"  > <?php echo ( ($all_agent->id)?$all_agent->id:'')." ".$all_agent->title;?></option>
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
                                       <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" required="" value="<?php echo date('Y-m-d');?>" required=""  >
                                    </div>
                                 </div>
                              </div> 
                              <div class="col-sm-2">
                                 <div class="row">
                                    <label for="name" class= "col-form-label">To :<span class="text-danger">*</span></label>
                                    <div class=" "> 
                                       <input type="date" class="form-control form-control-sm" id="end_date" name="end_date"  required="" value="<?php echo date('Y-m-d');?>" required="" >
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
                        
                        <div class="table-responsive  ">
                             
                                  <?php
                                    /*echo (@$action_requred->edit=='edit') ? ('edit') : ('not edit');die;*/
                                    if(!empty($attendance))
                                    {
                                      
                                      foreach ($attendance as $key => $value) {
                                       


                                         $get_employees  = get_employees_att_by_monthyear($value['att_date']);

                                         if(!empty($get_employees))
                                         {
                                          ?>
                                          <table class="display table table-striped align-middle table-nowrap mb-0" cellspacing="0" width="100%" id="example">
                                              <thead>
                                              <tr class=" bg-success">
                                                <th colspan="7">
                                                  <div class="text-center">
                                                    <span class=" text-white">
                                                      Attendance History of <?php echo date('M d, Y',strtotime($value['att_date']));?>
                                                    </span>
                                                  </div>
                                                  
                                                </th>
                                              </tr>
                                              <tr class=" bg-success">
                                                <th style="width: 60px;">S.No.</th>
                                                <th>Employee Name</th>                                            
                                                <th>Check In</th>                                            
                                                <th>Last Check In</th>                                            
                                                <th>Last Check Out</th>                                            
                                                <th>Worked Hour</th>                                            
                                                <th class="text-center" style="width: 60px;">Actions</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                $inc =0;

                                                  foreach ($get_employees as $key => $value) {
                                                     $inc++;
                                                    ?>
                                                      <tr>
                                                        <?php
                                                            $view_btn = (@$action_requred->view=='view')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/attendance/att_emp_detail/'.$value['user_id'].'" title="View" ><i class="fa fa-eye"></i> Details</a>&nbsp;':"";
                                                            $view_name = (@$action_requred->view=='view')?'<a  href="'.base_url().'admin/attendance/att_emp_detail/'.$value['user_id'].'" title="View" >'.$value['username'].'</a>&nbsp;':"";
                                                        ?>
                                                               
                                                             
                                                          <td><?php echo $inc;?></td>
                                                          <td><?php echo   $view_name;?></td>
                                                          <td><?php echo date("h:i:s A", strtotime($value['checkin']))?></td>
                                                          <td><?php echo (isset($value['last_checkin']) && $value['last_checkin'] !== null)?date("h:i:s A", strtotime($value['last_checkin'])):'_:_:_ XX';?></td>
                                                          <td><?php if(isset($value['last_checkout'])){ echo date("h:i:s A", strtotime($value['last_checkout'])); }else{ echo '_:_:_ XX';} ?></td>
                                                          <td><?php echo  $value['worked_hour'];?></td>
                                                          <td><?php echo  $view_btn;?></td>
                                                        </tr>
                                                    <?php
                                                  }
                                                ?>
                                               


                                            </tbody>
                                          </table>
                                          <?php
                                         }
                                         
                                        ?>
                                
                                 <?php
                                    }
                                    
                                    }else{
                                    
                                    ?>
                                  
                                    <span class="text-damger">Not Record Found !</span>
                                 
                                 <?php
                                    }
                                  ?>
                                  
                           
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
<!--  export Export Attendance form modelfor excel file -->
<div class="modal fade" id="importAttendanceModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="importAttendanceModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="add_booking_payment" method="post" id="add_booking_payment" action="<?php echo base_url();?>admin/attendance/insert_csv_attendance" enctype='multipart/form-data' >
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="importAttendanceModalLabel">Bulk Import Attendance</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Download Sample File</label>
                  <div class="col-md-7">
                      <a class="btn btn-info btn-sm " href="<?php echo base_url()?>uploads/admin/document/attendance-export-formate.csv" target="_blank"> <i class="bx bxs-download"></i> Download Sample File</a>
                  </div>
               </div>
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Choose File</label>
                  <div class="col-md-7">
                     <input type="file" class="form-control form-control-sm"  name="upload_data_csv" required id="upload_data_csv" />
                     <span class="text-danger"><small><span id="upload_error"></span></small></span>
                     <br/>
                     <span class="text-danger"><small><b>Please Upload CSV File Only With Formated</b></small></span>
                  </div>
               </div>
                
               
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm" name="upload_data_btn" id="upload_data_btn" >Upload</button>
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
<script>
 
    $(document).ready(function(){
        $("#upload_data_csv").change(function(){
            $('#upload_error').html('');
           var id = "upload_data_csv";
            var max_size = 20000000;
            file_validation(id,max_size);

            var file_data = $('#upload_data_csv').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
                                          
            $.ajax({
                url : "<?php echo base_url()?>admin/attendance/insert_csv_temp",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'POST',
                success: function(data){
                     console.log(data);
                      if(data.error >0)
                      {
                         $('#upload_data_btn').prop( "disabled", true );
                        
                        $('#upload_error').html(data.message);
                       
                      }else{
                         $('#upload_data_btn').prop( "disabled", false );
                      }
                }
             });
        }); 

    });
    
  </script>
  <script>
   // Function file Validation

    function file_validation(id,max_size)
    {
        var fuData = document.getElementById(id);
        var FileUploadPath = fuData.value;
        

        if (FileUploadPath == ''){

            alert("Please upload Attachment");
        } 
        else {
            var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "csv") {

                    if (fuData.files && fuData.files[0]) {
                        var size = fuData.files[0].size;
                        
                        if(size > max_size){   
                            alert("Maximum file size 20 MB");
                            $("#"+id).val('');
                            return false;
                        }
                    }
                } 
            else 
            {
                alert("document only allows with file types of csv");
                $("#"+id).val('');
                return false;
            }
        }   
    }

    $(document).ready(function(){

    });

  </script>








