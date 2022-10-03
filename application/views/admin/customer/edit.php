<!-- <pre>
<?php
    print_r($edit_data);
?>
</pre> -->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Update Farmers</h4>
               <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>admin/customer">Dashboards</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>admin/customer/addnew">Inquiry</a></li>
                        <li class="breadcrumb-item active">Blog</li>
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
            <?php
             }

               $success = $this->session->flashdata('success');
               if($success)
               {
                   ?>
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
               <?php echo $success; ?> 
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-6">
          <form action="<?php echo base_url() ?>admin/customer/update" method="post" role="form" enctype="multipart/form-data" >
               <div class="row">
                   <div class="col-sm-6">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Farmers Detail</h5>
                        <div class="card-body">
                           <div class="row">
                              <label for="customer_id" class="col-sm-4 col-form-label">Farmer ID</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="customer_id" name="customer_id" placeholder="Customer ID" readonly value="<?php if(isset($edit_data->id) && $edit_data->id !==''){echo $edit_data->id;} ?>">
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_name" class="col-sm-4 col-form-label">Farmers Name</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" placeholder="Farmers Name" value="<?php if(isset($edit_data->customer_name) && $edit_data->customer_name !==''){echo $edit_data->customer_name;}?>" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile</label>
                              <div class="col-sm-8">
                                 <input type="text" maxlength="12" class="form-control form-control-sm" id="customer_mobile"  name="customer_mobile"  placeholder="Customer Mobile"  value="<?php if(isset($edit_data->customer_mobile) && $edit_data->customer_mobile !==''){echo $edit_data->customer_mobile;}?>"   />
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_alter_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="customer_alter_mobile" placeholder="ALT Mobile" name="customer_alter_mobile" value="<?php if(isset($edit_data->customer_alter_mobile) && $edit_data->customer_alter_mobile !==''){echo $edit_data->customer_alter_mobile;}?>" >
                              </div>
                           </div>
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
                                    <option value="<?php echo $state->id;?>" <?php if(isset($edit_data->state) && $edit_data->state ==$state->id){ echo "selected";}?>><?php echo $state->name;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>

                                 <input type="text" name="other_state" id="other_state" <?php if($edit_data->other_state !==''){?> <?php }else{ ?> style="display: none;"<?php } ?>class="form-control form-control-sm mb-2" placeholder="Please Enter State Name" value="<?php echo $edit_data->other_state;?>" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">District</label>
                              <div class="col-sm-8">
                                 <select class=" form-control select2" id="district" name="district" aria-label="Floating label select example" onchange="districtChange()">
                                    <option value="" selected>Choose District</option>
                                   
                                 </select>
                                 <input type="text" name="other_district" id="other_district" <?php if($edit_data->other_district !==''){?> <?php }else{ ?> style="display: none;"<?php } ?> class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" value="<?php echo $edit_data->other_district;?>" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">Tehsil</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  select2 " id="city" name="city" aria-label="Floating label select example">
                                    <option value="" selected>Choose Tehsil</option>
                                    
                                 </select>
                                  <input type="text" name="other_city" id="other_city" <?php if($edit_data->other_city !==''){?> <?php }else{ ?> style="display: none;"<?php } ?> class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" value="<?php echo $edit_data->other_city;?>" />
                                   
                              </div>
                           </div>
                        </div>
                        <!-- end card body -->
                     </div>
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Call Details</h5>
                        <div class="card-body">
                            
                           <div class="row">
                              <label for="call_type" class="col-sm-4 col-form-label">Call Type</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm" id="call_type" name="call_type" onchange="select_calltype()"  aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($calltypes))
                                       {
                                           foreach ($calltypes as $calltype) {
                                               ?>
                                    <option value="<?php echo $calltype->id;?>" <?php if(isset($edit_data->last_call_type) && $edit_data->last_call_type ==$calltype->id){ echo "selected";}?> ><?php echo $calltype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="assign_to" class="col-sm-4 col-form-label">Assign To</label>
                              <div class="col-sm-8">
                                 <select class=" form-control select2 " id="assign_to" name="assign_to" aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($all_users))
                                       {
                                           foreach ($all_users as $user) {
                                               ?>
                                    <option value="<?php echo $user->id;?>" <?php if(isset($edit_data->assigned_to) && $edit_data->assigned_to ==$user->id){ echo "selected";}?>  ><?php echo $user->id;?> <?php echo $user->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_back_date" class="col-sm-4 col-form-label">Call Back Date</label>
                              <div class="col-sm-8">
                                 <input type="date" class="form-control form-control  form-control-sm" id="call_back_date" name="call_back_date" placeholder="Call Back Date" value="<?php echo date('Y-m-d',strtotime($edit_data->last_follow_date))?>">
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_direction" class="col-sm-4 col-form-label">Call Direction</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm" id="call_direction" name="call_direction" aria-label="Floating label select example">
                                    
                                    <?php
                                       if(!empty($calldirections))
                                       {
                                           foreach ($calldirections as $calldirection) {
                                               ?>last_call_direction
                                    <option value="<?php echo $calldirection->id;?>" <?php if(isset($edit_data->last_call_direction) && $edit_data->last_call_direction ==$calldirection->id){ echo "selected";}?> ><?php echo $calldirection->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Current Conversation</h5>
                        <div class="card-body">
                           <div class="row ">
                              <div class="col-sm-12">
                                 <textarea   class="form-control form-control-sm" id="current_conversation" name="current_conversation" placeholder="Current Conversation"  ></textarea>
                              </div>
                           </div>
                        </div>
                     </div> 
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body ">
                           <button type="submit" class="btn btn-primary w-md float-end">Save</button>
                           <input type="hidden" name="id" value="<?php if(isset($edit_data->id)){echo $edit_data->id;} ?>"/>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <!-- end card -->
         </div>
         <!-- end col -->
         <div class="col-xl-6">
            <div class="card">
               <div class="card-body">
                 
                  <div class="row">
                         <div class="col-sm-12">
                            <div class="row">
                               <div class="col-lg-12">
                                  <div class="card">
                                     <div class="card-body">
                                        <h4 class="card-title mb-5">Previous Conversation</h4>
                                         <div  id="example23">
                                            
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                       </div>
               </div>
            </div>
            <!-- end card body -->
         </div>
         <!-- end card -->
      </div>
      <!-- end col -->
    </div>
</div>

  <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
 
<script type="text/javascript">
function select_calltype()
  {
     $('#call_back_date').attr('readonly', false);
    var call_type =  $('#call_type').val();
   
    if(call_type==2)
    {
      $('#call_back_date').val(''); 
      $('#call_back_date').attr('readonly', true);

    }

    
  }

  function get_cutomer_call_detail(id,div_id)
  {
     
      var userId = id,
           hitURL = "<?php echo base_url() ?>admin/customer/customer_call_detail";
         
          
          
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId } 
           }).done(function(data){ 
               var html_content= '<ul class="verti-timeline list-unstyled">';

             
              
            for (var i = 0; i < data.length; i++) {
              
                
                
 

              html_content+='<li class="event-list">';
              html_content+='<div class="event-timeline-dot"><i class="bx bx-right-arrow-circle"></i></div>';

              html_content+='<div class="d-flex">';
              html_content+='<div class="flex-shrink-0 me-3"><i class="text-primary"></i></div>';

              html_content+='<div class="flex-grow-1"><div><div class="card border border-primary">';
              html_content+='<span class="bg-primary badge badge-primary border-radius-0">'+data[i].date_at+'</span>';

              html_content+='<div class="card-header bg-transparent border-bottom">';
              html_content+=data[i].calltype+' <strong>By</strong> '+data[i].username;
              
              html_content+='</div>';
              html_content+='<div class="card-body"><p class="p-0 m-0"><strong>Call Direction :</strong>'+data[i].calldirection+'<strong> Call Back Date :</strong>'+data[i].call_back_date+'</p><p><strong> Assigned To :</strong>'+data[i].username+'</p><hr class="p-0 m-0"><p>'+data[i].current_conversation+'</p>';


              html_content+='</div></div></div></div></div></li>';

            }
            html_content+='</ul>';

                $('#'+div_id).html(html_content);
                
           });
          
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
             
            // console.log(response);
            // $(".district_wrap").html(response.success);
            $("#district").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#district").empty();
        }
    });
}
function stateChange2(state_code = '',selected_district = '') {
      
    var stateCode = state_code ? state_code : $('#state2').val();
    var selectedDistrict = selected_district ? selected_district : $('#district2').val();
    hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        success: function (response) {
             
            // console.log(response);
            // $(".district_wrap").html(response.success);
            $("#district2").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#district2").empty();
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
             
            // console.log(response);
            // $(".district_wrap").html(response.success);
            $("#city").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#city").empty();
        }
    });
}
function districtChange2(district_code = '',selected_city = '') {
      
    var districtCode = district_code ? district_code : $('#district2').val();
    var selectedCity = selected_city ? selected_city : $('#city2').val();
    hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ districtCode+"/"+ selectedCity;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        success: function (response) {
             
            // console.log(response);
            // $(".district_wrap").html(response.success);
            $("#city2").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#city2").empty();
        }
    });
}

 
    jQuery(document).ready(function(){
        //$('#example').DataTable();

         jQuery(document).on("click", ".deletebtn", function(){

          var userId = $(this).data("userid"),
            hitURL = "<?php echo base_url() ?>admin/customer_call/delete",
            currentRow = $(this);
          
          var confirmation = confirm("Are you sure to delete?");
          
          if(confirmation)
          {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { id : userId } 
            }).done(function(data){           
              currentRow.parents('tr').remove();
              if(data.status = true) { alert("successfully deleted"); }
              else if(data.status = false) { alert("deletion failed"); }
              else { alert("Access denied..!"); }
            });
          }
    });
});
   

   function current_cutomer_call_detail()
  {
    get_cutomer_call_detail('<?php echo @$edit_data->id;?>','example23');
  }
 function single_cutomer_call_detail(id)
  {
    get_cutomer_call_detail(id,'example233');
  }
</script>
 <?php
  
    if(!empty($edit_data->id))
    {
      ?>
      <script type="text/javascript">
         $(document).ready(function() {

          
            current_cutomer_call_detail();
            stateChange('<?php echo @$edit_data->state;?>','<?php echo @$edit_data->district;?>');
            districtChange('<?php echo @$edit_data->district;?>','<?php echo @$edit_data->city;?>');
        });
      </script>
      <?php
    }
?>
<script type="text/javascript">
 



var table;
 
$(document).ready(function() {
 
    $(".select2").select2();

 
    //datatables
    table = $('#example').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/customer_call/ajax_list')?>",
            "type": "POST",
            "data":{customer:"<?php echo @$edit_data->id;?>"}
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
});
</script>