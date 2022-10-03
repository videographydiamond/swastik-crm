<link href="<?php echo base_url(); ?>assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
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
                  <div class="card">
                     <h5 class="card-header bg-success text-white border-bottom ">
                        <div class="row ">
                           <div class="col-sm-9">
                              Farmers List
                           </div>
                           <div class="col-sm-3 ">
                            <?php 
                              $add_btn = (@$action_requred->create=='create')?'<a class="btn btn-primary  float-end btn-sm" href="'.base_url().'admin/farmers/addnew"><i class="fa fa-plus"></i> Add New</a>':"";
                              echo $add_btn;
                            ?>
                            </div>
                        </div>
                     </h5>
                     <form>
                        <div class="card card m-0">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                          
                            </div>
                            <div class="col-sm-6">
                                <div class="float-end  mr-0">
                                  <a class="btn btn-default btn-sm mr-2" href="<?php echo base_url()?>admin/farmers"> Clear</a>

                                  <button type="submit" class="btn btn-primary btn-sm submit-filter"><i class="fa fa-search"></i> Submit
                                  Filter</button>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                       <div class="card-body">
                        <div class="table-responsive mytablestyle">
                           <table class="table table-striped align-middle table-nowrap mb-0" cellspacing="0" width="100%" id="example">
                              <thead>
                                 <tr class=" bg-success">
                                  <th  >
                                       <input class="form-control-sm" type="text" name="farmer_id" id="farmer_id" placeholder="Farmer ID"  style="width: 78px;">
                                    </th>
                                   <th style="width: 60px;">Is Premium</th>
                                    <th style="width: 100px;">Status</th>
                                    
                                    <th class="text-center"  style="width: 60px;">Actions</th>
                                    
                                    <th> <input class="form-control-sm" type="text" name="name" id="name" placeholder="Name" ></th>
                                    <th><input class="form-control-sm" type="text" name="mobile" id="mobile" placeholder="Mobile" ></th>
                                    <th><input class="form-control-sm" type="text" name="father_name" id="father_name" placeholder="Father Name" ></th>
                                    <th><input class="form-control-sm" type="text" name="alt_mobile" id="alt_mobile" placeholder="ALT Mobile" ></th>
                                    <th><input class="form-control-sm" type="text" name="whatsapp" id="whatsapp" placeholder="WhatsApp" ></th>
                                       <th class="align-middle bg-success text-white">
                                      <select class=" form-control  form-control-sm" id="farmer_type" name="farmer_type" aria-label="Floating label select example"  style="width: 75px;"  >
                                     <option value="">FarmerType</option>
                                    <?php
                                       if(!empty($farmertypes))
                                       {
                                           foreach ($farmertypes as $farmertype) {
                                               ?>
                                    <option value="<?php echo $farmertype->id;?>" ><?php echo $farmertype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                               </th>
                                    <th>Village</th>
                                    <th>Address</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>City</th>
                                    <th>Pincode</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                     
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                     
                                      
                                   

                                   /*echo (@$action_requred->edit=='edit') ? ('edit') : ('not edit');die;*/
                                    if(!empty($farmers))
                                    {
                                      
                                      foreach ($farmers as $key => $value) {
                                         $edit_btn_name = (@$action_requred->edit=='edit')?('<a class="" href="'.base_url().'admin/farmers/edit/'.$value['id'].'" title="Edit" >'.$value['name'].'</a>&nbsp;'):($value['name']);

                                          $edit_btn_farmerid = (@$action_requred->edit=='edit')?('<a class="" href="'.base_url().'admin/farmers/edit/'.$value['id'].'" title="Edit" >'.$value['id'].'</a>&nbsp;'):($value['id']);
                                        
                                        $isdisabled_prem = (@$action_requred->edit=='edit')?(''):('disabled');  
                                        ?>
                                 <tr>
                                  <td><?php echo $edit_btn_farmerid;?></td'>
                                  <td>

                                       <div class="form-check form-check-primary mb-3">

                                          <input class="form-check-input is_premium" <?php echo $isdisabled_prem; ?> data-userid="<?php echo $value['id'];?>" type="checkbox"   <?php if($value['is_premium'] ==1){ ?> checked="true" <?php } ?> value="1"  >
                                           
                                       </div>
                                    </td>
                                    <td>
                                      <?php 
                                          $actives = ($value['status'] == 1)?" selected ":"";
                                          $inactives = ($value['status'] == 0)?" selected ":"";
                                          $btn = '<select class="form-control form-control-sm statusBtn" name="statusBtn" style="width: 65px;" data-id="'.$value['id'].'">';
                                          $btn .= '<option value="1" '.$actives.' >Active</option>';
                                          $btn .= '<option value="0" '.$inactives.' >Inactive</option>';
                                          $btn .= '</select>';

                                           $btn = (@$action_requred->edit=='edit')?($btn):('');
                                          echo $btn;
                                      ?>

                                      <?php 
                                      
                                      /*echo (isset($value['status']) && $value['status']==1)?('<span class="badge bg-success">Active</span>'):'<span class="badge bg-danger">In-active</span>';*/

                                      ?></td>
                                    <td> <?php


                                    $delete_btn = (@$action_requred->delete=='delete')?'<a class="btn btn-sm btn-danger deletebtn" href="#" data-userid="'.$value['id'].'"><i class="fa fa-trash"></i></a>':"";
                                    $edit_btn = (@$action_requred->edit=='edit')?'<a class="btn btn-sm btn-info" href="'.base_url().'admin/farmers/edit/'.$value['id'].'" title="Edit" ><i class="fa fa-pen"></i></a>&nbsp;':"";

                                    echo $edit_btn." ".$delete_btn;
                                       ?></td>
                                    
                                    <td><?php echo $edit_btn_name;?></td>
                                    <td><?php echo $value['mobile'];?></td>
                                    <td><?php echo $value['father_name'];?></td>
                                    <td><?php echo $value['alt_mobile'];?></td>
                                    <td><?php echo $value['whatsapp'];?></td>
                                    <td><?php echo $value['farmertype'];?></td>
                                    <td><?php echo $value['village'];?></td>
                                    <td><?php echo $value['address'];?></td>
                                    <td><?php echo $value['state'];?></td>
                                    <td><?php echo $value['district'];?></td>
                                    <td><?php echo $value['city'];?></td>
                                    <td><?php echo $value['pincode'];?></td>
                                    <td><?php echo $value['source'];?></td>
                                    <td><?php echo date('d M Y',strtotime($value['date_at']));?></td>
                                    
                                 </tr>
                                 <?php
                                    }
                                    
                                    }else{
                                    
                                    ?>
                                 <tr>
                                    <td><span class="text-damger">Not Record Found !</span></td>
                                 </tr>
                                 <?php
                                    }
                                    ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     </form>
                     <!-- end table-responsive -->
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-3">
                     <ul class="pagination  justify-content-left mt-4"  >
                        <li class="">
                           <p><?php echo @$pagination_total_count; ?> Farmers. </p>
                        </li>
                     </ul>
                  </div>
                  <div class="col-sm-9">
                     <?php echo $this->pagination->create_links(); ?>  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
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
           hitURL = "<?php echo base_url() ?>admin/farmers/delete",
           currentRow = $(this);
         
         var confirmation = confirm("Are you sure to delete this Farmer ?");
         
         if(confirmation)
         {
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId },

            beforeSend: function(){
               show_loader();
            },
            complete: function(){
               hide_loader();
            } 
           }).done(function(data){           
             currentRow.parents('tr').remove();
             if(data.status = true) { alert("successfully deleted"); 
             window.location.reload(true);
           }
             else if(data.status = false) { alert("deletion failed"); }
             else { alert("Access denied..!"); }
           });
         }
   });
   });
   
</script>
<!-- Get Databse List -->
 <script type="text/javascript">
    jQuery(document).ready(function(){
        //$('#example').DataTable();

         jQuery(document).on("click", ".is_premium", function(){

          var userId = $(this).data("userid");
          
          var value  = ($(this).is(':checked'))?(1):0;
          var hitURL = "<?php echo base_url() ?>admin/farmers/isPremium";
              
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : userId,is_premium : value },
             beforeSend: function(){
               show_loader();
            },
            complete: function(){
               hide_loader();
            },

             success: function (data) {
               
               if(data.status == true) { 
                 
                 toastr.success("Premium set successfully.");
              }
              else if(data.status == false) 
                {
                toastr.error("Failed To Update Premium.");
                 
            }
              else {
               
               toastr.error("Access denied..!");
             }
                
             },
            error: function (request, status, error) {
               
            }


            });
           
    });
    });
   
</script>
<!-- Status Change -->
<script type="text/javascript">
   jQuery(document).ready(function(){
        $("#query-pagination li.page-item a").addClass('page-link');
   
   
        jQuery(document).on("change", ".statusBtn", function(){
   
         var userId = $(this).attr("data-id");
         var value  = $(this).val();
   
           hitURL = "<?php echo base_url() ?>admin/farmers/statusChange",
           currentRow = $(this);
         
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId, status : value },
            beforeSend: function(){
               show_loader();
            },
            complete: function(){
               hide_loader();
            },
           success: function(data){
              if(data.status == true) { 
                 
                 toastr.success("Status Change successfully.");
              }
              else if(data.status == false) 
                {
                toastr.error("Failed To Change Status Change.");
                 
            }
              else {
               
               toastr.error("Access denied..!");
             }
           }

           });
   });
   });
   
</script>