<style type="text/css">
   .mytablestyle {
   min-height: 455px;
   }
   .row label {font-size: 11px;}
   tbody, td, tfoot, th, thead, tr {
   border-color: #000;
   border-style: solid;
   border-width: 1px;
   }
    
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
#booking_form a img
{
   width: 163px;
    height: 125px;
}

</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/libs/summernote/summernote-lite.min.css')?>"> 
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-6">
            <div class="card">
               <form  id="add_cunsultant" method="GET" onsubmit="return false">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label for="customer_id" class="col-sm-4 col-form-label text-right">Farmer ID:</label>
                              <div class="col-sm-8">
                                 <div class="input-group input-group-sm">
                                    <input class="form-control form-control-sm" id="customer_id" name="customer_id" type="text"   />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label for="mobile" class="col-sm-4 col-form-label text-right">Mobile No.:</label>
                              <div class="col-sm-8">
                                 <div class="input-group input-group-sm">
                                    <input class="form-control form-control-sm" id="mobile" name="mobile" type="text"   />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-2">
                           <div class="form-group row">
                              <div class="col-sm-12">
                                 <button type="button" class="btn btn-info btn-sm float-end" id="search"><i class="fa fa-search"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input name="form_type" type="hidden" value="search" />
               </form>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <span id="booking_error"></span>
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
            <div class="col-12">
               <h5>Add New Consultant</h5>
            </div>
         </div>
         <div class="col-xl-12">
            <form autocomplete="off" action="<?php echo base_url() ?>admin/consultants/insertnow" method="post" role="form" enctype="multipart/form-data" id="booking_form" class="custom-validation">
               <div class="card">
                  <h5 class="card-header bg-success text-white border-bottom p-1"></h5>
                  <div class="card card-body">
                      <div class="row">
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="farmer_id" class="col-sm-4 col-form-label">Farmer Id<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input class="form-control form-control-sm disabled"  type="text" name="farmer_id" id="farmer_id" value="" readonly="">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="farmer_name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="farmer_name" name="farmer_name" placeholder="Farmers Name*"  required=""  readonly=""  />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="farmer_name" class="col-sm-4 col-form-label">Mobile<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="farmer_mobile" name="farmer_mobile" placeholder="Farmers  Mobile*" required=""  readonly="" />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="address" class="col-sm-4 col-form-label">Address </label>
                              <div class="col-sm-8"> 
                                 <textarea name="address" id="address" class="form-control  form-control-sm" placeholder="Address" readonly ></textarea>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="crop_id" class="col-sm-4 col-form-label">Crop</label>
                              <div class="col-sm-8">
                                 <select class="form-control  form-control-sm" id="crop_id" name="crop_id">
                                     <?php
                                       if(!empty($crop_lists))
                                       {
                                         foreach($crop_lists as $k=>$v)
                                         { 
                                           ?>
                                    <option value="<?php echo $v->id;?>" <?php if(!empty(set_value('crop_id')) && set_value('crop_id')==$v->id){ echo 'selected';}?>><?php echo $v->title;?></option>
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
                              <label for="crop_status" class="col-sm-4 col-form-label">Crop Status</label>
                              <div class="col-sm-8">
                                 Active
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="crop_area" class="col-sm-4 col-form-label">Crop Area</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="crop_area" name="crop_area" placeholder="Crop Area"    />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="agent_id" class="col-sm-4 col-form-label"></label>
                              <div class="col-sm-8">
                                  
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="no_of_plant" class="col-sm-4 col-form-label">No. of live plants</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="no_of_plant" name="no_of_plant" placeholder="No. of live plants"    />
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="row">
                              <label for="no_of_plant_booked" class="col-sm-4 col-form-label">No of plant booked</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="no_of_plant_booked" name="no_of_plant_booked" placeholder="No of plant booked"    />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="card">
                              <h5 class="card-header bg-success text-white border-bottom p-1"></h5>
                              <div class="card-body p-1">
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="mb-3 ">
                                          <label class="form-label"  for="ticket_title">Ticket Title</label>
                                          <input type="text" class="form-control form-control-sm" id="ticket_title" name="ticket_title" placeholder="Ticket Title"/>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="mb-3">
                                          <label class="form-label"  for="ticket_status">Ticket Status</label>
                                          <select class="form-control form-control-sm" id="ticket_status" name="ticket_status">
                                             <?php
                                                if(!empty($tickets_status))
                                                {
                                                        foreach ($tickets_status as $ticket_status) {
                                                            ?>
                                             <option value="<?php echo $ticket_status->slug;?>"><?php echo $ticket_status->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="row">
                                          <label for="call_type" class="col-sm-4 col-form-label">Call Type</label>
                                          <div class="col-sm-8">
                                             <select class="form-control form-control-sm" id="call_type" name="call_type">
                                                <?php
                                                   if(!empty($calltypes))
                                                   {
                                                           foreach ($calltypes as $calltype) {
                                                               ?>
                                                <option value="<?php echo $calltype->slug;?>"><?php echo $calltype->title;?></option>
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
                                          <label for="follow_up_date" class="col-sm-4 col-form-label">Followup</label>
                                          <div class="col-sm-8">
                                             <input type="date" name="follow_up_date" id="follow_up_date" value="" class="form-control form-control-sm" />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="row">
                                          <label for="document_category_id" class="col-sm-4 col-form-label">Problem<span class="text-danger">*</span></label>
                                          <div class="col-sm-8">
                                             <select class="form-control form-control-sm" id="document_category_id" name="document_category_id" onchange="getSubProblem(this.value)" required="">
                                                <option value="">Choose</option>
                                                <?php
                                                   if(!empty($documents_category))
                                                   {
                                                           foreach ($documents_category as $document_category) {
                                                               ?>
                                                <option value="<?php echo $document_category->id;?>"><?php echo $document_category->title;?></option>
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
                                          <label for="document_id" class="col-sm-4 col-form-label">Sub Problem <span class="text-danger">*</span></label>
                                          <div class="col-sm-8">
                                             <select class="form-control form-control-sm" id="document_id" name="document_id" onchange="getProblem(this.value)" required >
                                                <option value="">Choose</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class="gallery">
                                          <label class="form-label"  for="images">Photos
                                             <div class="  ">
                                                <img id="files1_src" src="<?php echo base_url('assets/admin/images/addmedia-upload.png')?>"  >
                                             </div>
                                          </label>
                                          <input type="file" multiple id="images" name="upload_files[]"  class="input-file">
                                             
                                           
                                          <div class="row uploads">
                                                
                                          </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class=" ">
                                          <label class="form-label"  for="root_cause">Root Cause</label>
                                          <textarea class="form-control " id="root_cause" rows="2" name="root_cause" cols="50"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class=" ">
                                          <label class="form-label" for="recommendation">Recommendation</label>
                                          <textarea class="form-control " id="recommendation" name="recommendation" rows="2"  cols="50"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class="row">
                                          <label class="form-label"  for="screenshot">Screenshot</label>
                                           <div class="upload col-md-2 ">
                                                    <input type="file" id="screenshot" name="screenshot" class="input-file" onchange="readURL(this)" accept='image/*'>
                                                    <label for="screenshot" class="p-0">

                                                        <img id="screenshot_src" src="<?php echo base_url('assets/admin/images/addmedia-upload.png')?>" style="height:100%;width:100%;">
                                                    </label>
                                                    <span class="invalid-feedback screenshot"></span>
                                                </div>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="card-footer">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class=" float-end">
                                          <a  href="<?php echo base_url()?>admin/consultants" class="btn btn-sm my-primary w-md  mr-1">Cancel</a>
                                          <button  name="Submit" id="submit"  type="submit" class="btn btn-sm btn-info w-md  mr-1">Save Details</button>
                                       </div>
                                    </div>
                                 </div>
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
 <script src="<?php echo base_url(); ?>assets/admin/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/pages/lightbox.init.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/summernote/summernote-lite.min.js"></script>
 
<!--  Large modal example -->

<script>
   $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;
            html_content = '';
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
              /*    <a href="<?php echo base_url('uploads/admin/document/images/').$all_images[$i]?>" title="images gallery" data-source="<?php echo base_url('uploads/admin/document/images/').$all_images[$i]?>">
                                                                  <img id="files<?php echo $i;?>_src" class="already_exit_pic" data-name="<?php echo $all_images[$i];?>" alt title="images gallery" src="<?php echo base_url('uploads/admin/document/images/').$all_images[$i]?>" style="height:100%;width:100%;">
                                                               </a>*/


                     var html_content = '\
                     <div class="zoom-gallery upload col-md-2"><a href="'+event.target.result+'" title="image gallery" data-source="'+event.target.result+'"> \
                     <img  class="already_exit_pic" alt title="images gallery " src="'+event.target.result+'"/  ></div>';
                     $(html_content).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#images').on('change', function() {
      $('div.uploads').empty();
        imagesPreview(this, 'div.uploads');
    });
});
     $('#recommendation').summernote({
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


   function getSubProblem (value='',selected='')
   {
       if(value.length >0)
      {
   
          hitURL = "<?php echo base_url() ?>admin/consultants/documentCategoryChange";
   
          show_loader();
           $.ajax({
            method:'POST',
         type: 'GET',
         url: hitURL,
         data: {
          id:value,
          selected:selected
        }, 
         success: function (response) {
               hide_loader();
                if(response)
                {
                   $("#document_id").empty().append(response);
                 }else
                {
                   $('#document_id').empty();
                }
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
      }
   }
   function getProblem (value='')
   {
       if(value.length >0)
      {
         var id = value;
   
          hitURL = "<?php echo base_url() ?>admin/kdocuments/single/"+id;
   
          show_loader();
           $.ajax({
            method:'POST',
         type: 'GET',
         url: hitURL,
         data: {
           
        }, 
        dataType : "json",
         success: function (response) {
               hide_loader(); 
                if(response)
                {
                  var data = response;
                   
                  var treatmentss =  (response.treatment);
                   
                  var root_causesss =  (response.root_cause);
                  
                   $("#root_cause").val(root_causesss);
                   $("#recommendation").val(treatmentss);
                   $("#recommendation").summernote("code", treatmentss);
                 }else
                {
                   $('#root_cause').empty();
                   $('#recommendation').empty();
                }
                
                 
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
      }
   }
   
   
    
       
</script>
<script type="text/javascript"></script>
<script type="text/javascript">
   var table;
    $(document).ready(function() {
      
    
    $("#search").on('click',function(){
        var customer_id = $("#customer_id").val();
        var mobile = $("#mobile").val();
        $('#contactid').val('');
        $('#farmer_id').val('');
         if(customer_id || mobile)
        {
        
          hitURL = "<?php echo base_url() ?>admin/farmers/single";
   
          show_loader();
           $.ajax({
         type: 'GET',
         url: hitURL,
         data: {
          customer_id:customer_id,
          mobile:mobile
        },
         dataType:'json',
         success: function (response) {
              hide_loader();
                if(response)
                {
                    var data = response;
                  $('#farmer_name').val(data.name);
                  $('#farmer_id').val(data.id);
                  $('#address').val(data.address);
                  $('#farmer_mobile').val(data.mobile);
                  
                  
                     
                }else
                {
                   $('#farmer_name').val('');
                  $('#farmer_id').val('');
                  $('#address').val('');
                  $('#farmer_mobile').val('');
                }
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
       
        }
        
    
        
    });
   
   $("#query-pagination li.page-item a").addClass('page-link');
    $(".select2").select2();
    $("#add_cunsultant").on("submit", function(){
        show_loader();
    });
      
   
   
   
    
    
   });
    
    

   
   
</script>