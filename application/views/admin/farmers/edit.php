<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Farmers</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/farmers">Farmers List</a></li>
                     <li class="breadcrumb-item active">Edit Farmers</li>
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
                  <form  action="<?php echo base_url() ?>admin/farmers/update" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Edit Farmers 
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="source" class="col-sm-4 col-form-label">Farmer Type<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class=" form-control form-control-sm" id="farmer_type" name="farmer_type" aria-label="Floating label select example" required >
                                          <?php
                                             if(!empty($farmertypes))
                                             {
                                                 foreach ($farmertypes as $farmertype) {
                                                     ?>
                                          <option value="<?php echo $farmertype->id;?>" <?php if($edit_data->farmer_type==$farmertype->id){echo 'selected';} ?>  ><?php echo $farmertype->title;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="name" class="col-sm-4 col-form-label">Farmers Name*</label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Farmers Name*" value="<?php echo $edit_data->name;?>" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="mobile" class="col-sm-4 col-form-label">Mobile*</label>
                                    <div class="col-sm-8"> 
                                       <input type="text" maxlength="12" class="form-control form-control-sm" id="mobile"  name="mobile"  placeholder="Customer Mobile*" value="<?php echo $edit_data->mobile;?>"  />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="alt_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="alt_mobile" placeholder="ALT Mobile" name="alt_mobile" value="<?php echo $edit_data->alt_mobile;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="father_name" class="col-sm-4 col-form-label">Father</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="father_name" placeholder="Father Name" name="father_name" value="<?php echo $edit_data->father_name;?>" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="state" class="col-sm-4 col-form-label">State</label>
                                    <div class="col-sm-8">
                                       <select class=" form-control select2 " id="state" name="state" aria-label="Floating label select example" onchange="stateChange()">
                                          <option value="" selected>Choose State</option>
                                          <?php
                                             if(!empty($states))
                                             {
                                                 foreach ($states as $state) {
                                                     ?>
                                          <option value="<?php echo $state->id;?>" <?php if( $edit_data->state_id==$state->id){echo 'selected';}?>  ><?php echo $state->name;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>
                                       <input type="text" name="other_state" id="other_state"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name"  value="<?php echo $edit_data->other_state;?>"/>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="city" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                       <select class=" form-control select2 " id="district" name="district" aria-label="Floating label select example" onchange="districtChange()">
                                          <option value="" selected>Choose District</option>
                                       </select>
                                       <input type="text" name="other_district" id="other_district"  value="<?php echo $edit_data->other_district;?>" style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="city" class="col-sm-4 col-form-label">Tehsil</label>
                                    <div class="col-sm-8">
                                       <select class=" form-control  select2 " id="city" name="city" aria-label="Floating label select example"  onchange="cityChange()">
                                          <option value="" selected>Choose Tehsil</option>
                                       </select>
                                       <input type="text" name="other_city" id="other_city" value="<?php echo $edit_data->other_district;?>" style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="pincode" class="col-sm-4 col-form-label">Pincode</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="pincode" placeholder="Pincode" name="pincode" value="<?php echo $edit_data->pincode;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="village" class="col-sm-4 col-form-label">Village</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control form-control-sm" id="village" placeholder="Village" name="village" ><?php echo $edit_data->village;?></textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="address" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control form-control-sm" id="address" placeholder="Address" name="address"><?php echo $edit_data->address;?></textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="source" class="col-sm-4 col-form-label">Source</label>
                                    <div class="col-sm-8">
                                       <select class=" form-control  select2 " id="source" name="source" aria-label="Floating label select example">
                                          <option value="" selected>Choose Source</option>
                                          <?php
                                             if(!empty($lead_sources))
                                             {
                                                 foreach ($lead_sources as $lead_source) {
                                                     ?>
                                          <option value="<?php echo $lead_source->slug;?>" <?php if( $edit_data->source==$lead_source->slug){echo 'selected';} ?>  ><?php echo $lead_source->title;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="status1" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                          <option value="1" <?php if($edit_data->status==1){echo 'selected';} ?> >Active</option>
                                          <option value="0" <?php if($edit_data->status==0){echo 'selected';} ?>>Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="whatsapp" class="col-sm-4 col-form-label">WhatsApp</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="whatsapp" placeholder="WhatsApp" name="whatsapp" value="<?php echo $edit_data->whatsapp?>" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label  class="col-sm-4 col-form-label"> </label>
                                    <div class="col-sm-8">
                                       <div class="form-check form-check-primary mb-3">
                                          <input class="form-check-input" type="checkbox" id="is_premium" name="is_premium" <?php if($edit_data->is_premium ==1){ ?> checked="true" <?php } ?> value="1"  >
                                          <label class="form-check-label" for="is_premium"  >
                                          Is Premium
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                 <div class="float-end">
                                    <a href="<?php echo base_url()?>admin/farmers" class="btn-sm btn my-primary">Back</a>
                                     <input type="submit" class="btn btn-info btn-sm" value="Submit" />
                                      <input type="hidden"  name="id" id="id"  value="<?php echo $edit_data->id?>" />
                                  </div>
                              </div>
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
   
    
       
      stateChange('<?php echo @$edit_data->state_id;?>','<?php echo @$edit_data->district_id ?>');
      districtChange('<?php echo @$edit_data->district_id;?>','<?php echo @$edit_data->city_id;?>');
   });
</script>
<?php
   }
   ?>