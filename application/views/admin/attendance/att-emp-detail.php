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
                             <?php echo $user_data->title;?>
                           </div>
                           <div class="col-sm-9 ">
                            <div class="row">
                              <div class="col-sm-12">
                                 
                               </div>
                            </div>
                          </div>
                         </div>
                       </h5>
                      <div class="card-body">
                        
                        <div class="table-responsive  ">
                             
                                  <?php


                                    /*echo (@$action_requred->edit=='edit') ? ('edit') : ('not edit');die;*/
                                    if(!empty($attendance))
                                    {
                                      
                                      foreach ($attendance as $key => $value) {
                                       


                                         $get_employees  = get_employees_att_check_inOutBydate($value['att_date'],$value['user_id']);

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
                                                <th>Punch Time </th>                                            
                                                <th>Status</th>                                            
                                                
                                                <th class="text-center" style="width: 60px;">Actions</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                $inc =0;

                                                  foreach ($get_employees as $key => $values) {
                                                     $inc++;
                                                    ?>
                                                      <tr>
                                                        <?php
                                                            $edit_btn = (@$action_requred->edit=='edit')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/attendance/edit/'.$values['id'].'/'.$values['user_id'].'" title="Edit"><i class="fa fa-pen"></i></a>&nbsp;':"";
                                                            $delete_btn = (@$action_requred->delete=='delete')?'<button class="btn btn-sm btn-danger deletebtn " data-userid="'.$values['id'].'"  data-att_id="'.$values['att_id'].'" data-state="'.$values['state'].'"  title="Delete" ><i class="fa fa-trash"></i></button>&nbsp;':"";
                                                            
                                                        ?>
                                                               
                                                             
                                                          <td><?php echo $inc;?></td>
                                                          <td><?php echo date("h:i:s A", strtotime($values['time']))?></td>
                                                          <td><?php echo ($values['state']==1)?'IN':'OUT';?></td>
                                                           
                                                          <td><?php echo  $edit_btn." ".$delete_btn;?></td>
                                                        </tr>
                                                    <?php
                                                  }
                                                ?>
                                               

                                            </tbody>
                                            <tfoot>
                                              <th>
                                                <td colspan="100"><strong>You Spent <?php echo $value['worked_hour'];?>  Hours out of Working hours</strong></td>
                                              </th>
                                            </tfoot>
                                             
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


                    
               </div>
            </div>
         </div>
         <div class="row">
          <div class="col-xl-12">
            
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                    
 
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

          var userId = $(this).data("userid");
          var att_id = $(this).data("att_id");
          var state = $(this).data("state");
          var hitURL = "<?php echo base_url() ?>admin/attendance/trash_attendence";
          var currentRow = $(this);
          
          var confirmation = confirm("Are you sure to delete this?");
          
          if(confirmation)
          {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : userId,att_id : att_id,state : state, } 
            }).done(function(data){           
              
              if(data.status = true) { 
                currentRow.parents('tr').remove();
                toastr.success("successfully deleted"); 
                window.location.reload();
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








