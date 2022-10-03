 
<div class="page-content">
  
   <div class="container-fluid">
    <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                     <h4 class="mb-sm-0 font-size-18">District</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/district">District List</a></li>
                                            <li class="breadcrumb-item active">Add New District</li>
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
                 <form  action="<?php echo base_url() ?>admin/district/update" method="post" role="form" enctype="multipart/form-data"  >
                  <div class="card">
                   

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-9">
                            Update District 
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
                                            <option value="<?php echo $v->id;?>"  <?php if($v->id==@$edit_data->country_id){ echo "selected";}?>><?php echo $v->name;?></option>
                                             <?php }
                                              }
                                             ?>
                                        </select>                              </div>

                                
                           </div>
                       </div>    <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="state_id" class="col-sm-4 col-form-label">State<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
<select class="form-control form-control-sm select2" name="state_id" id="state_id" required >
                                            <option value="0" >Select State</option>
                                            <?php 
                                              if(!empty($stateList))
                                              {
                                                  foreach($stateList as $k=>$v){ ?>
                                            <option value="<?php echo $v->id;?>" <?php if($v->id==@$edit_data->state_id){ echo "selected";}?> ><?php echo $v->name;?></option>
                                             <?php }
                                              }
                                             ?>
                                        </select>                              </div>

                                
                           </div>
                       </div> 
                      
                       <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="name" class="col-sm-4 col-form-label">District Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter State Name*" value="<?php echo @$edit_data->name;?>" required="">
                              </div>
                           </div>
                       </div>
                 
                  <div class="col-sm-3">
                     

                             
                            <div class="row">
                              <label for="status1" class="col-sm-4 col-form-label">Status</label>
                              <div class="col-sm-8"> 
                                   <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                      
                                                                        <option value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
                                            <option value="0" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
                                                                         
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
                          <input type="hidden" name="id" value="<?php echo $edit_data->id; ?>"/>
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
    var selectedState = selected_state ? selected_state : $('#state_id').val();

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

$(document).ready(function() {
    
    $(".select2").select2();

});
</script>
<?php 

/*if(!empty($edit_data->id)){?>
  <script>
  countryChange('<?php echo $edit_data->country_id;?>','<?php echo $edit_data->state_id;?>');
</script>
<?php }*/ ?>










 