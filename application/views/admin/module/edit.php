<div class="page-content">
  
   <div class="container-fluid">
    <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                     <h4 class="mb-sm-0 font-size-18">Module</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/modules">Module List</a></li>
                                            <li class="breadcrumb-item active">Update Module</li>
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
                 <form  action="<?php echo base_url() ?>admin/modules/update" method="post" role="form" enctype="multipart/form-data"  >
                  <div class="card">
                   

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-9">
                            Edit Module 
                           </div>
                           
                            
                         </div>
                       </h5>
                      

                         <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="name" class="col-sm-4 col-form-label">Parent Module </label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm select2" name="parent_id" id="parent_id"   >
                                          <option value="0" >Select Module</option>
                                          <?php 
                                             if(!empty($module_list))
                                             {
                                               foreach($module_list as $k=>$v)
                                               { ?>
                                          <option value="<?php echo $v->id;?>" <?php if(isset($edit_data->parent_id) && $edit_data->parent_id ==$v->id){echo "selected";}?>    ><?php echo $v->module_name;?></option>
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
                                    <label for="module_name" class="col-sm-4 col-form-label">Module Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="module_name" name="module_name" placeholder="Enter Module Name"  required="" value="<?php echo @$edit_data->module_name;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="row">
                                    <label for="module_url" class="col-sm-2 col-form-label">Module URL <span class="text-danger">*</span></label>
                                    <div class="col-sm-10"> 
                                       <input type="text" class="form-control form-control-sm" id="module_url" name="module_url" placeholder="Module URL"  required="" value="<?php echo @$edit_data->module_url;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="usage_unit" class="col-sm-4 col-form-label">Order Number  <span class="text-danger">*</span> </label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="orders_with" name="orders_with" placeholder="Enter Order Number"  required="" value="<?php echo @$edit_data->orders_with;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="icon_name" class="col-sm-4 col-form-label">Icon Class Name</label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="icon_name" name="icon_name" placeholder="Enter Icon Class Name" value="<?php echo @$edit_data->icon_name;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="target" class="col-sm-4 col-form-label">Target </label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="target"   name="target" placeholder="Enter Target "  value="<?php echo @$edit_data->target;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                <div class="row">
                                  <label for="status1" class="col-sm-4 col-form-label">Status</label>
                                  <div class="col-sm-8"> 
                                    <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                      <option value="1" <?php echo (@$edit_data->status == 1)?'selected':''; ?> >Active</option>
                                      <option value="0" <?php echo (@$edit_data->status == 0)?'selected':''; ?> >Inactive</option>
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