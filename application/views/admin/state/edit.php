<div class="page-content">
  
   <div class="container-fluid">
    <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                     <h4 class="mb-sm-0 font-size-18">State</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/state">State List</a></li>
                                            <li class="breadcrumb-item active">Add New State</li>
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
                 <form  action="<?php echo base_url() ?>admin/state/update" method="post" role="form" enctype="multipart/form-data"   >
                  <div class="card">
                   

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-9">
                            Edit State 
                           </div>
                           
                            
                         </div>
                       </h5>
                      

                       <div class="card-body">
                         
                      
                             <div class="row">
                  <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
<select class="form-control form-control-sm select2" name="country_id" id="country_id" required >
                                            <option value="0" >Select Country</option>
                                            <?php foreach($countryList as $k=>$v){ ?>
                                            <option value="<?php echo $v->id;?>"  <?php echo ($edit_data->country_id == $v->id)?"selected":''; ?> ><?php echo $v->name;?></option>
                                             <?php } ?>
                                        </select>                              </div>

                                
                           </div>
                       </div> 

                       <div class="col-sm-3">
                    
                            <div class="row">
                              <label for="name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text"  class="form-control form-control-sm" id="name" name="name" placeholder="Enter State Name*" value="<?php echo $edit_data->name; ?>" required="">
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
<script  >
     $(document).ready(function() {
    
    $(".select2").select2();

});
</script>

 