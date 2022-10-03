<?php
        $role_id = $this->session->userdata('role_id');
        $action_requred = get_module_role($module_id['id'],$role_id);
?>


<style>
   #socialresult .remove {
   position: relative;
   right: -15px;
   font-size: 20px;
   top: -55px;
   float: right;
   }
   .social
   {
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
   }
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Company</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a  href="<?php echo base_url()?>admin">Dashboard</a></li>
                     <li class="breadcrumb-item"><a   href="<?php echo base_url()?>admin/company">Company List</a></li>
                     <li class="breadcrumb-item active">Edit Company</li>
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
                <form  action="<?php echo base_url() ?>admin/company/update" method="post" role="form" enctype="multipart/form-data"  >
                  <div class="col-lg-12">
                 
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Edit Company Details
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Comapny Name*" value="<?php echo $edit_data->name; ?>" required />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="phone" class="col-sm-4 col-form-label">Mobile<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="text" maxlength="12" class="form-control form-control-sm" id="phone"  name="phone"  placeholder="Company Mobile*" value="<?php echo $edit_data->phone; ?>" required />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="email" class="col-sm-4 col-form-label">email<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="email" placeholder="Email" name="email" value="<?php echo $edit_data->email; ?>" required>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="website" class="col-sm-4 col-form-label">Website</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="website" placeholder="Website" name="website" value="<?php echo $edit_data->website; ?>">
                                    </div>
                                 </div>
                              </div>
                               
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="state" class="col-sm-4 col-form-label">State<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       <select class=" form-control select2 " id="state" name="state" aria-label="Floating label select example" required onchange="stateChange()">
                                          <option value="" selected>Choose State</option>
                                          <?php
                                             if(!empty($states))
                                             {
                                                 foreach ($states as $state) {
                                                     ?>
                                          <option value="<?php echo $state->id;?>" <?php if($edit_data->state==$state->id){echo 'selected';}?>  ><?php echo $state->name;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>
                                       <input type="text" name="other_state" id="other_state"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name"  value="<?php echo set_value('other_state'); ?>"/>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="district" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                       <select class=" form-control select2 " id="district" name="district" aria-label="Floating label select example" onchange="districtChange()">
                                          <option value="" selected>Choose District</option>
                                       </select>
                                       <input type="text" name="other_district" id="other_district"  value="<?php echo set_value('other_district'); ?>" style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
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
                                       <input type="text" name="other_city" id="other_city" value="<?php echo set_value('other_city'); ?>" style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                   <div class="row">
                                    <label for="gst_no" class="col-sm-4 col-form-label">GSTIN</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="gst_no" placeholder="GST IN" name="gst_no" value="<?php echo $edit_data->gst_no; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row mb-1">
                                    <label for="nursury_address" class="col-sm-4 col-form-label">Nursury  Address</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control form-control-sm" id="nursury_address" placeholder="Nursury  Address" name="nursury_address"><?php echo $edit_data->nursury_address; ?></textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row mb-1">
                                    <label for="office_address" class="col-sm-4 col-form-label">Office Address</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control form-control-sm" id="office_address" placeholder="Office Address" name="office_address"><?php echo $edit_data->office_address; ?></textarea>
                                    </div>
                                 </div>
                              </div>
                                <div class="col-sm-3">
                                 <div class="row mb-1">
                                    <label for="bank_name" class="col-sm-4 col-form-label">Bank Name</label>
                                    <div class="col-sm-8">
                                       <textarea class="form-control form-control-sm" id="bank_name" placeholder="Bank Name" name="bank_name"><?php echo $edit_data->bank_name; ?></textarea>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-sm-3">
                                <div class="row mb-1">
                                    <label for="bank_branch_address" class="col-sm-4 col-form-label">Branch Address</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="bank_branch_address" placeholder="Branch Address" name="bank_branch_address"><?php echo $edit_data->bank_branch_address; ?></textarea>
                                    </div>
                                 </div>
                              </div>
                              
                              
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="bank_account_number" class="col-sm-4 col-form-label">Bank Acc.No</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="bank_account_number" placeholder="Bank Acc.No" name="bank_account_number" value="<?php echo $edit_data->bank_account_number; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="bank_holder_name" class="col-sm-4 col-form-label">Acc.Hold.Name</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="bank_holder_name" placeholder="Acc.Holder Name" name="bank_holder_name" value="<?php echo $edit_data->bank_holder_name; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="bank_ifsc_code" class="col-sm-4 col-form-label">IFSC Code</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="bank_ifsc_code" placeholder="IFSC Code" name="bank_ifsc_code" value="<?php echo $edit_data->bank_ifsc_code; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="pan_no" class="col-sm-4 col-form-label">PAN No</label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control form-control-sm" id="pan_no" placeholder="PAN No" name="pan_no" value="<?php echo $edit_data->pan_no; ?>">
                                    </div>
                                 </div>
                              </div>
                               
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="status1" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                       <select class="form-control form-control-sm" id="status1" name="status1" style="display: block!important">
                                          <option value="1" <?php if( $edit_data->status==1){echo 'selected';} ?>>Active</option>
                                          <option value="0" <?php if($edit_data->status==0){echo 'selected';} ?>>Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-12">
                        </div>
                     </div>
                      
               </div>
               <div class="col-lg-12">
                  <div class="card">
                   <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Add  Images
                              </div>
                           </div>
                        </h5>
                        <?php
                          $img_path = base_url()."assets/admin/images/";

                          $seal_logo_src  = '';
                          
                            if(isset($edit_data->seal_logo))
                            {
                                $seal_logo_src =  $img_path.$edit_data->seal_logo;
                            } 

                             $logo_src  = '';
                          
                            if(isset($edit_data->logo))
                            {
                                 $logo_src  =  $img_path.$edit_data->logo;
                            } 

                        ?>
                         <div class="card-body">
                           <div class="row">
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="logo" class="col-sm-4 col-form-label">Logo<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="file" class="form-control form-control-sm" id="logo" onchange="readURL(this)"  name="logo" placeholder="Comapny Name*"   />
                                       <img id="logo_src" class="img-thumbnail"  src="<?php echo $logo_src;?>" />
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-3">
                                 <div class="row">
                                    <label for="seal_logo" class="col-sm-4 col-form-label">Seal Logo<span class="text-danger">*</span></label>
                                    <div class="col-sm-8"> 
                                       <input type="file" class="form-control form-control-sm" id="seal_logo" onchange="readURL(this)"   name="seal_logo" placeholder="Seal Logo"   />
                                      <img id="seal_logo_src" class="img-thumbnail"  src="<?php echo $seal_logo_src;?>"/>

                                    </div>
                                 </div>
                              </div>
                           </div>
                          </div>
                </div>
               </div>

                  <div class="col-lg-12">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">
                           <div class="row ">
                              <div class="col-sm-9">
                                 Add  Social
                              </div>
                           </div>
                        </h5>
                        <div class="card-body">
                           <div class="row" id="socialresult">
                              <?php 
                                 $socialurls = $edit_data->social_url;
                                 $socialurls = json_decode($socialurls);
                                 if(!empty($socialurls))
                                 {
                                    $incss = 1;
                                    foreach ($socialurls as $key => $value) {
                                        
                                   
                                    ?>
                                    <div class="socials col-md-3">
                                       <?php echo $value->title?>
                                       <div class="row">
                                          <label for="socials<?php echo $incss;?>"  class="col-sm-4"> 
                                          <input type="text" value = '<?php echo $value->title?>' class="form-control form-control-sm" id="socials_key<?php echo $incss;?>" name="socials_keys[]" placeholder="Key Title "> 
                                          </label> 
                                          <div class="col-sm-8"> 
                                             <input type="text"   value = '<?php echo $value->url;?>' class="form-control form-control-sm" id="socials_value<?php echo $incss;?>" name="link_socials_value[]"  placeholder="URL Eg:www.facebook.com" > 
                                          </div>
                                       </div>
                                       <span class="remove removeDiv" style="cursor:pointer;"><i class="fa fa-times" aria-hidden="true"></i></span>
                     <span class="invalid-feedback socials<?php echo $incss;?> "></span>
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
                  </div>
                <div class="row">
                    <div class="col-sm-12">
                      <div class="float-end">
                           <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                           <input type="hidden" name="id" id='id' value="<?php echo $edit_data->id; ?>" hidden >
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

   
  $(document).on('click','#add_more', function(){
          
         var id= $('.socials').length+1;
         $("form #socialresult").append('\
                <div class="socials col-md-3">\
                Add Social '+id+'\
                <div class="row">\
                     <label for="socials'+id+'"  class="col-sm-4">\
                        <input type="text" value ="" class="form-control form-control-sm" id="socials_key'+id+'" name="socials_keys[]" placeholder="Key Title ">\
                     </label>\
                     <div class="col-sm-8">\
                        <input type="text" value ="" class="form-control form-control-sm" id="socials_value'+id+'" name="link_socials_value[]"  placeholder="URL Eg:www.facebook.com" >\
                     </div>\
                     </div>\
                     <span class="remove removeDiv" style="cursor:pointer;"><i class="fa fa-times" aria-hidden="true"></i></span>\
                     <span class="invalid-feedback socials'+id+'"></span>\
                </div>');
      });
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
  function file_validation(id,max_size)
   {
       var fuData = document.getElementById(id);
       var FileUploadPath = fuData.value;
       
   
       if (FileUploadPath == ''){
           alert("Please upload Attachment");
       } 
       else {
           var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
           if (Extension == "jpg" || Extension == "jpeg" || Extension == "png" || Extension == "webp" ) {
   
                   if (fuData.files && fuData.files[0]) {
                       var size = fuData.files[0].size;
                       
                       if(size > max_size){   
                       /*1000000 = 1 mb*/
                          alert("Maximum file size "+max_size/1000000+" MB");
                          $("#"+id).val('');
                          return false;
                            
                       }
                   }
   
           } 
           else 
           {
                
              $("#"+id).val('');
              alert("document only allows file types of  jpg , png  , jpeg , webp ");
              $("#"+id).val('');
              return false;
           }
       }   
   }   
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
   if(!empty($edit_data->id))
   {
     ?>
<script type="text/javascript">
   $(document).ready(function() {
   
    
       
      stateChange('<?php echo @$edit_data->state;?>','<?php echo @$edit_data->district;?>');
      districtChange('<?php echo @$edit_data->district;?>','<?php echo @$edit_data->city;?>');
   });
</script>
<?php
   }
   ?>