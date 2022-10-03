<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Document Category</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url()?>admin/document_category">Document Category List</a></li>
                     <li class="breadcrumb-item active">Add New Document Category</li>
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
                  <form  action="<?php echo base_url() ?>admin/document_category/update" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Add Document Category 
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                               <div class="col-sm-3">
                                 <label for="crop_id" class=" col-form-label">Crop<span class="text-danger">*</span></label>
                                 <select class="form-control form-control-sm" id="crop_id" name="crop_id" required >
                                    <?php
                                       if(!empty($crop_lists))
                                       {
                                         foreach($crop_lists as $k=>$v)
                                         { 
                                           ?>
                                    <option value="<?php echo $v->id;?>" <?php if( $edit_data->crop_id ==$v->id){ echo 'selected';}?>><?php echo $v->title;?></option>
                                    <?php 
                                       }   
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                 
                                    <label for="name" class="  col-form-label">Category<span class="text-danger">*</span></label>
                                    
                                       <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter Category Name"  required="" value="<?php echo $edit_data->name; ?>" required>
                                    
                                  
                              </div>
                              <div class="col-sm-3">
                                 
                                    <label for="description" class="  col-form-label">Description</label>
                                   
                                       <textarea class="form-control form-control-sm" id="description" name="description" placeholder="About Category" ><?php echo $edit_data->description; ?></textarea>
                                     
                                  
                              </div>
                              <div class="col-sm-3">
                                  
                                    <label for="status1" class=" col-form-label">Status</label>
                                    <select class="form-control form-control-sm" id="status1" name="status1"  >
                                            <option value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
                                            <option value="0" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
                                       </select>
                                    
                                  
                              </div>
                           </div>
                           <div class="col-sm-12">
                           </div>
                        </div>
                        <div class="card-footer">
                           <div class="float-end">
                              <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                              <input type="hidden" name="id" value="<?php echo $edit_data->id; ?>"/>
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