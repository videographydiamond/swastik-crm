<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Change Password</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item active">Change Password</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
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
                  <form  action="<?php echo base_url() ?>admin/profile/update_change_passowrd" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Change Password
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              
                              <div class="col-sm-4">
                                 <div class="row">
                                    <label for="password" class="col-sm-4 col-form-label">Password<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" name="password"  value="" required="">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="row">
                                    <label for="new_password" class="col-sm-4 col-form-label">New Password<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" id="new_password" placeholder="New Password" name="new_password"  value="" required="">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="row">
                                    <label for="confirm_password" class="col-sm-4 col-form-label">Confirm Password<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" id="confirm_password" placeholder="Confirm Password" name="confirm_password"  value="" required="">
                                    </div>
                                 </div>
                              </div>
                            </div>
                        </div>
                    </div>
                     <div class="card-footer">
                        <div class="float-end">
                           <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                           <input type="reset" class="btn btn-default btn-sm" value="Reset" />
                           <input type="text" hidden="" name="id" value="<?php echo $edit_data->id;?>">
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
<script >
   function stateChange(state_code = '',selected_district = '') {
     
   var stateCode = state_code ? state_code : $('#state').val();
   var selectedDistrict = selected_district ? selected_district : $('#district').val();
   hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
   $.ajax({
       type: 'GET',
       url: hitURL,
       data: {},
       success: function (response) {
         var check_state = $('#state option:selected').text();
         if(check_state =='Other')
         {
           $('#other_state').val('');
           $('#other_state').css('display', 'block');
           $('#other_state').prop('required',true);
   
         }else
         {
            
            $('#other_state').val('');
            $('#other_state').css('display', 'none');
            $('#other_state').prop('required',false);
         }
         
           $("#district").empty().append(response);
           $(".select2").select2();
       },
       error: function (request, status, error) {
            
            
           
           $("#district").empty();
       }
   });
   }
   
   function districtChange(district_code = '',selected_city = '') {
     
   var districtCode = district_code ? district_code : $('#district').val();
   var selectedCity = selected_city ? selected_city : $('#city').val();
   hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ districtCode+"/"+ selectedCity;
   $.ajax({
       type: 'GET',
       url: hitURL,
       data: {},
       success: function (response) {
            
           var check_district = $('#district option:selected').text();
           if(check_district =='Other')
           {
             $('#other_district').val('');
             $('#other_district').css('display', 'block');
             $('#other_district').prop('required',true);
   
           }else
           {
              
              $('#other_district').val('');
              $('#other_district').css('display', 'none');
              $('#other_district').prop('required',false);
           }
         
           $("#city").empty().append(response);
           $(".select2").select2();
       },
       error: function (request, status, error) {
            
            
           
           $("#city").empty();
       }
   });
   }
   function cityChange(district_code = '',selected_city = '') {
     
    var check_district = $('#city option:selected').text();
           if(check_district =='Other')
           {
             $('#other_city').val('');
             $('#other_city').css('display', 'block');
             $('#other_city').prop('required',true);
   
           }else
           {
              
              $('#other_city').val('');
              $('#other_city').css('display', 'none');
              $('#other_city').prop('required',false);
           }
   }
    $(document).ready(function() {
   
   $(".select2").select2();
   
   });
</script>
<?php
   if(!empty($edit_data->state_id))
   {
     ?>
<script type="text/javascript">
   $(document).ready(function() {
   
    
       
      stateChange('<?php echo $edit_data->state_id;?>','<?php echo $edit_data->district_id;?>');
      districtChange('<?php echo $edit_data->district_id;?>','<?php echo $edit_data->city_id;?>');
   });
</script>
<?php
   }
   ?>