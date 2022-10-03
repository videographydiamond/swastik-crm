<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Village</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/village_pin">Village List</a></li>
                     <li class="breadcrumb-item active">Add New Village</li>
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
                  <form  action="<?php echo base_url() ?>admin/village_pin/insertnow" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Add Village 
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="country_id" class="col-sm-4 col-form-label">Country<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm select2" name="country_id" id="country_id" required  onchange="countryChange()">
                                          <option value="" >Select Country</option>
                                          <?php 
                                             if(!empty($countryList))
                                             {
                                                 foreach($countryList as $k=>$v){ ?>
                                          <option value="<?php echo $v->id;?>"  <?php if($v->id==105){ echo "selected";}?>><?php echo $v->name;?></option>
                                          <?php }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
 
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="state_id" class="col-sm-4 col-form-label">State<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm select2" name="state_id" id="state_id" required  onchange="stateChange()">
                                          <option value="" >Select State</option>
                                          <?php 
                                             if(!empty($stateList))
                                             {
                                                 foreach($stateList as $k=>$v){ ?>
                                          <option value="<?php echo $v->id;?>"  <?php echo ($v->id==$this->session->userdata('leatest_state_id'))?'selected':'';?>><?php echo $v->name;?></option>
                                          <?php }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="district_id" class="col-sm-4 col-form-label">District<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm select2" name="district_id" id="district_id" required   onchange="districtChange()">
                                          <option value="" >Select District</option>
                                          <?php 
                                             if(!empty($districtList))
                                             {
                                                 foreach($districtList as $k=>$v){ ?>
                                          <option value="<?php echo $v->id;?>"   <?php echo ($v->id==$this->session->userdata('leatest_district_id'))?'selected':'';?> ><?php echo $v->name;?></option>
                                          <?php }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="city_id" class="col-sm-4 col-form-label">Tehsil<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm select2" name="city_id" id="city_id" required >
                                          <option value="" >Select Tehsil</option>
                                          <?php 
                                             if(!empty($cityList))
                                             {
                                                 foreach($cityList as $k=>$v){ ?>
                                          <option value="<?php echo $v->id;?>"  <?php echo ($v->id==$this->session->userdata('leatest_city_id'))?'selected':'';?> ><?php echo $v->city;?></option>
                                          <?php }
                                             }
                                             ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="name" class="col-sm-4 col-form-label">Village Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter Tehsil Name*" value="" required="" style="text-transform: capitalize;">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="pincode" class="col-sm-4 col-form-label">Pincode<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text" maxlength="6" class="form-control form-control-sm" id="pincode" name="pincode" placeholder="Enter Pincode*" value="" required=""  onkeypress="return onlyNumberKey(event)" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="status1" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                          <option value="1" >Active</option>
                                          <option value="0">Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-12">
                           </div>
                        </div>
                        <div class="card-footer">
                           <div class="float-end">
                              <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                              <input type="reset" class="btn btn-default btn-sm" value="Reset" />
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

     function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
         
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
   function countryChange(country_code = '',selected_state = '') {
       
     var country_code = country_code ? country_code : $('#country_id').val();
     var selectedState = selectedState ? selectedState : $('#state_id').val();
   
     hitURL = "<?php echo base_url() ?>admin/customer/country_change/"+ country_code+"/"+ selectedState;
     $.ajax({
         type: 'GET',
         url: hitURL,
         data: {},
         success: function (response) {
             
             $("#state_id").empty().append(response);
             $(".select2").select2();
         },
         error: function (request, status, error) {
              
              
             
             $("#state_id").empty();
         }
     });
   }   
   
   function stateChange(state_code = '',selected_district = '') {
       
     var stateCode = state_code ? state_code : $('#state_id').val();
     var selectedDistrict = selected_district ? selected_district : $('#district_id').val();
   console.log(stateCode ,selectedDistrict);
     hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
     $.ajax({
         type: 'GET',
         url: hitURL,
         data: {},
         success: function (response) {
             
             $("#district_id").empty().append(response);
             $(".select2").select2();
         },
         error: function (request, status, error) {
              
              
             
             $("#district_id").empty();
         }
     });
   }
   function districtChange(state_code='',districe_code = '',selected_city= '') {
    var stateCode = state_code ? state_code : $('#state_id').val();
     var selectedDistrict = districe_code ? districe_code : $('#district_id').val();
     var selectedCity     = selected_city ? selected_city : $('#city_id').val();
   
     hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ stateCode+"/"+ selectedDistrict+"/"+ selectedCity;
     $.ajax({
         type: 'GET',
         url: hitURL,
         data: {},
         success: function (response) {
             
             $("#city_id").empty().append(response);
             $(".select2").select2();
         },
         error: function (request, status, error) {
              
              
             
             $("#city_id").empty();
         }
     });
   }  
      $(document).ready(function() {
     
     $(".select2").select2();
   
   });
</script>