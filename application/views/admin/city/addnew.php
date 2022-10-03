<div class="page-content">
  
   <div class="container-fluid">
    <div class="row">
      <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                     <h4 class="mb-sm-0 font-size-18">Tehsil</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/city">Tehsil List</a></li>
                                            <li class="breadcrumb-item active">Add New Tehsil</li>
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
                 <form  action="<?php echo base_url() ?>admin/city/insertnow" method="post" role="form" enctype="multipart/form-data"  >
                  <div class="card">
                   

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-9">
                            Add Tehsil 
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
                                        </select>                              </div>

                                
                           </div>
                       </div>    <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="state_id" class="col-sm-4 col-form-label">State<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
<select class="form-control form-control-sm select2" name="state_id" id="state_id" required  onchange="stateChange()">
                                            <option value="" >Select State</option>
                                            <?php 
                                              if(!empty($stateList))
                                              {
                                                  foreach($stateList as $k=>$v){ ?>
                                            <option value="<?php echo $v->id;?>" ><?php echo $v->name;?></option>
                                             <?php }
                                              }
                                             ?>
                                        </select>                              </div>

                                
                           </div>
                       </div> 
                       <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="district_id" class="col-sm-4 col-form-label">District<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
<select class="form-control form-control-sm select2" name="district_id" id="district_id" required >
                                            <option value="" >Select District</option>
                                            <?php 
                                              if(!empty($districtList))
                                              {
                                                  foreach($districtList as $k=>$v){ ?>
                                            <option value="<?php echo $v->id;?>" ><?php echo $v->name;?></option>
                                             <?php }
                                              }
                                             ?>
                                        </select>                              </div>

                                
                           </div>
                       </div> 
                      
                       <div class="col-sm-3">
                    
                             
                       </div>
                       <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="name" class="col-sm-4 col-form-label">Tehsil Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter Tehsil Name*" value="" required="">
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
     $(document).ready(function() {
    
    $(".select2").select2();

});
</script>
