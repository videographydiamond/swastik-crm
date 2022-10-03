<style type="text/css">
  .input-file
   {
      display: none;
   }
   .upload label {
    color: #5f626a;
    cursor: pointer;
    width: 163px;
    height: 125px;
    position: relative;
    display: block;
    border-radius: 4px;
    overflow: hidden;
    transition: background ease 0.5s;
     margin-bottom: 5px;
    margin-right: 5px;
}
#pictureresult .remove {
    position: relative;
    top: -18px;
    right: -152px;
    font-size: 25px;
    top: -147px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/libs/magnific-popup/magnific-popup.css')?>"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/libs/summernote/summernote-lite.min.css')?>"> 
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Kdocument</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/kdocuments">Kdocument List</a></li>
                     <li class="breadcrumb-item active">Edit Kdocument</li>
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
                  <form  action="<?php echo base_url() ?>admin/kdocuments/update" method="post" role="form" enctype="multipart/form-data"  >
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Add Kdocument 
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <label for="status1" class=" col-form-label">Crop<span class="text-danger">*</span></label>
                                 <select class="form-control form-control-sm" id="crop_id" name="crop_id" required >
                                    <?php
                                       if(!empty($crop_lists))
                                       {
                                         foreach($crop_lists as $k=>$v)
                                         { 
                                           ?>
                                    <option value="<?php echo $v->id;?>" <?php if(  $edit_data->crop_id==$v->id){ echo 'selected';}?>><?php echo $v->title;?></option>
                                    <?php 
                                       }   
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                 <label for="document_cat_id" class="col-form-label">Problem (Category)<span class="text-danger">*</span></label>
                                 <select class="form-control form-control-sm select2" name="document_cat_id" id="document_cat_id" required >
                                    <option value="" >Select Category</option>
                                    <?php
                                       if(!empty($category_lists))
                                       {
                                         foreach($category_lists as $k=>$v)
                                         { 
                                           ?>
                                    <option value="<?php echo $v->id;?>"  <?php if( $edit_data->document_cat_id==$v->id){ echo 'selected';}?>  ><?php echo $v->name;?></option>
                                    <?php 
                                       }   
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                 <label for="name" class=" col-form-label">Sub-Problem<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter Sub-Problem"  required="" value="<?php  echo  $edit_data->name;?>">
                              </div>
                              <div class="col-sm-3">
                                 <label for="status1" class=" col-form-label">Status</label>
                                 <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                    <option value="1" <?php if($edit_data->status==1){ echo 'selected';}?> >Active</option>
                                    <option value="0" <?php if($edit_data->status==0){ echo 'selected';}?>>Inactive</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                             <div class="col-sm-12">
                              <br>
                               <label class="form-label"  for="images">Photos of sub problem</label>
                                           
                                              <div class="row" id="pictureresult">
                                             <?php

                                                $all_images = json_decode($edit_data->images);
                                                if(!empty($all_images))
                                                {
                                                   for ($i=0; $i < count($all_images); $i++) { 
                                                       ?>

                                                       <div class="zoom-gallery upload col-md-2">
                                                           <label for="files<?php echo $i;?>">
                                                               <input type="hidden" name="exist_file[]" value="<?php echo $all_images[$i];?>">
                                                               <a href="<?php echo base_url('uploads/admin/document/problem/').$all_images[$i]?>" title="images gallery" data-source="<?php echo base_url('uploads/admin/document/problem/').$all_images[$i]?>">
                                                                  <img id="files<?php echo $i;?>_src" class="already_exit_pic" data-name="<?php echo $all_images[$i];?>" alt title="images gallery" src="<?php echo base_url('uploads/admin/document/problem/').$all_images[$i]?>" style="height:100%;width:100%;">
                                                               </a>
                                                           </label>
                                                           <span class="remove removeDiv" style="cursor:pointer;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                                       </div>
                                                          
                                                       <?php
                                                   }
                                                }
                                             ?>
                                             
                                          </div>
                                           <br>
                                            <button type="button" id="add_more" class="btn btn-sm btn-success rounded" value="Add More Files">Add More</button>
                                            
                            </div>
                           </div>

                           <div class="row">
                               <div class="col-sm-12">
                                 <label for="root_cause" class=" col-form-label">Root cause of sub problem</label>
                                  
                                 <textarea class="form-control form-control-sm" id="root_cause" name="root_cause" placeholder="Enter Root cause of sub problem"><?php  echo ($edit_data->root_cause);?></textarea>
                              </div>
                              <div class="col-sm-12">
                                 <label for="treatment" class=" col-form-label">Treatment of sub problem</label>
                                 <textarea class="form-control form-control-sm" id="treatment" name="treatment" placeholder="Enter Treatment of sub problem"><?php  echo  ($edit_data->treatment);?></textarea>
                              </div>
                           </div>
                        </div>
                        <div class="card-footer">
                           <div class="float-end">
                              <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                              <input type="hidden" name="id" value="<?php echo $edit_data->id?>" id="id" />
                              <input type="reset" class="btn btn-default btn-sm" value="Reset" />
                              <a  class="btn btn-warning btn-sm" href="<?php echo base_url()?>admin/kdocuments">Cancel</a>
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
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/pages/lightbox.init.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/summernote/summernote-lite.min.js"></script>
 
<!--  Large modal example -->

<script>
     $('#treatment').summernote({
       height: 200,
         toolbar: [
         // [groupName, [list of button]]
         ['style', ['bold', 'italic', 'underline', 'clear']],
         ['color', ['color']],
         ['para', ['ul', 'ol', 'paragraph']],
         ['height', ['height']]
         ]
         });
    </script>
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
<script type="text/javascript">
   function file_validation(id,max_size)
   {
       var fuData = document.getElementById(id);
       var FileUploadPath = fuData.value;
       
   
       if (FileUploadPath == ''){
          toastr.error("Please upload Attachment");
            
       } 
       else {
           var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
           if (Extension == "jpg" || Extension == "jpeg" || Extension == "png" || Extension == "webp" ) {
   
                   if (fuData.files && fuData.files[0]) {
                       var size = fuData.files[0].size;
                       
                       if(size > max_size){   //1000000 = 1 mb
                            toastr.error("Maximum file size "+max_size/1000000+" MB");
                           
                         
                           $("#"+id).val('');
                           return false;
                            
                       }
                   }
   
           } 
           else 
           {
                
               $("#"+id).val('');
                toastr.error('document only allows file types of  jpg , png  , jpeg , webp');

                
                           $("#"+id).val('');
                           return false;
           }
       }   
   }  

$(document).on('click','.removeDiv', function(){
         $(this).parent().remove();
      });
function readURL(input) {
      var id = $(input).attr('id');
       var max_size = 2000000;
           file_validation(id,max_size);

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
               var id=input.id;
               $('#'+id+'_src').attr('src', e.target.result);
          }
            reader.readAsDataURL(input.files[0]);
            
        }
    }

$(document).on('click','#add_more', function(){
         if($('.upload').length>=15){
            

                 toastr.error('You can upload maximum 15 pictures');
                return false;
         }
         var id= $('.upload').length+1;
         $("#pictureresult").append('\
                <div class="upload col-md-2">\
                    <input type="file" id="files'+id+'" name="upload_files[]" class="input-file" onchange="readURL(this)" >\
                    <label for="files'+id+'" class="p-0">\
                        <img id="files'+id+'_src" src="<?php echo base_url('assets/admin/images/addmedia-upload.png')?>" style="height:100%;width:100%;">\
                    </label>\
                    <span class="remove removeDiv" style="cursor:pointer;"><i class="fa fa-times" aria-hidden="true"></i></span>\
                    <span class="invalid-feedback files'+id+'"></span>\
                </div>');
      });



   $(document).ready(function() {
   
   $(".select2").select2();
   
   });
</script>