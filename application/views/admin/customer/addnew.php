 <?php
        $role_id = $this->session->userdata('role_id');
        $action_requred = get_module_role($module_id['id'],$role_id);
 ?> 

<style type="text/css">
  .mytablestyle {
    min-height: 455px;
    max-height: 455px;

}
 .row label {font-size: 11px;}


.table-nowrap td, .table-nowrap th {
    
    border: 1px solid #39823b;
    padding: 3px;
}
</style>
<style type="text/css">
  .table>:not(caption)>*>* {
  padding: 2px 2px;
  font-size: 10px;
  color: #000;
  }
</style>
<div class="page-content">
  <?php include APPPATH.'views/admin/menu-strive.php';?>

  
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-6">
            <div class="card">
              <form   method="GET"  >
                  <h5 class="card-header bg-success text-white border-bottom ">Search Customer</h5>
                   <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="farmer_id" class="col-sm-4 col-form-label text-right">Farmer ID:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-sm  " id="farmer_id" name="farmer_id" type="text" value="<?php if(isset($_GET['farmer_id']) && $_GET['farmer_id'] !==''){ echo $_GET['farmer_id'];}?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label text-right">Mobile No.:</label>
                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-sm  " id="mobile" name="mobile" type="text" value="<?php if(isset($_GET['mobile']) && $_GET['mobile'] !==''){ echo $_GET['mobile'];}?>" >
                                        <div class="input-group-append input-group-btn">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input name="form_type" type="hidden" value="search">
                   </div>
                    
              </form>
               
            </div>

            <?php
             /* print_r($edit_data);          
print_r($customer_call_dtl);  */  
       
        ?>
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
            <form action="<?php echo base_url() ?>admin/customer/insertnow" method="post" role="form" enctype="multipart/form-data"  id='add_inquiry'>
                <div class="row">
                  <div class="col-sm-12">
                    <h5>Add New inquiry</h5>
                  </div>
                </div>
               <div class="row">
                <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo base_url()."admin/customer/addnew?".$_SERVER['QUERY_STRING'];?>">
                  <div class="col-sm-6">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Farmers Detail</h5>
                        <div class="card-body">
                           <div class="row">
                              <label for="farmser_id2" class="col-sm-4 col-form-label">Farmer ID</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="farmser_id2" name="farmser_id2" placeholder="Farmer ID" readonly value="<?php if(isset($edit_data->id) && $edit_data->id !==''){echo $edit_data->id;} ?>">
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_name" class="col-sm-4 col-form-label">Farmers Name<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" placeholder="Farmers Name*" value="<?php if(isset($edit_data->name) && $edit_data->name !==''){echo $edit_data->name;}?>" required/>
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile<span class="text-danger">*</span></label>
                              <div class="col-sm-8"> 
                                 <input type="text" maxlength="12" class="form-control form-control-sm" id="customer_mobile"  name="customer_mobile"  placeholder="Customer Mobile*"  value="<?php if(isset($edit_data->mobile) && $edit_data->mobile !==''){echo $edit_data->mobile;}?>"  onkeypress="return onlyNumberKey(event)" required/>
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_alter_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="customer_alter_mobile" placeholder="ALT Mobile" name="customer_alter_mobile" value="<?php if(isset($edit_data->alt_mobile) && $edit_data->alt_mobile !==''){echo $edit_data->alt_mobile;}?>"  onkeypress="return onlyNumberKey(event)">
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
                                          <option value="<?php echo $state->id;?>" <?php if(isset($edit_data->state_id) && $edit_data->state_id ==$state->id){ echo "selected";}?>><?php echo $state->name;?></option>
                                          <?php
                                        }
                                      }
                                    ?>
                                 </select>
                                 <input type="text" name="other_state" id="other_state"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">District</label>
                              <div class="col-sm-8">
                                 <select class=" form-control select2 " id="district" name="district" aria-label="Floating label select example" onchange="districtChange()">
                                    <option value="" selected>Choose District</option>
                                  </select>
                                 <input type="text" name="other_district" id="other_district"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">Tehsil</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  select2 " id="city" name="city" aria-label="Floating label select example"  onchange="cityChange()">
                                    <option value="" selected>Choose Tehsil</option>
                                    
                                 </select>
                                <input type="text" name="other_city" id="other_city"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />

                              </div>
                           </div>

                           <div class="row">
                              <label for="farmer_type" class="col-sm-4 col-form-label">Farmer Type</label>
                              <div class="col-sm-8">
                                <select class="form-control form-control-sm select2" id="farmer_type" name="farmer_type" aria-label="Floating label select example">
                                  <option value="">Choose Farmer Type</option>
                                    <?php
                                       if(!empty($farmertypes))
                                       {
                                           foreach ($farmertypes as $farmertype) {
                                               ?>
                                    <option value="<?php echo $farmertype->id;?>" <?php if(isset($edit_data->farmer_type) && $edit_data->farmer_type ==$farmertype->id){ echo "selected";}?> ><?php echo $farmertype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                    
                                </select>
                              </div>
                           </div>
                          <div class="row">
                              <label for="farmer_type" class="col-sm-4 col-form-label">Crop</label>
                              <div class="col-sm-8">
                                <select class="form-control form-control-sm select2" id="crop_id" name="crop_id" aria-label="Floating label select example">
                                  <option value="">Choose Crop</option>
                                    <?php
                                       if(!empty($crop_lists))
                                       {
                                           foreach ($crop_lists as $crop_list) {
                                               ?>
                                    <option value="<?php echo $crop_list->id;?>" <?php if(isset($edit_data->crop_id) && $edit_data->crop_id ==$crop_list->id){ echo "selected";}?> ><?php echo $crop_list->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                    
                                </select>
                              </div>
                           </div>
                        </div>
                        <!-- end card body -->
                      </div>
                    </div>
                  <div class="col-sm-6">
                      <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Call Details</h5>
                        <div class="card-body">
                          <div class="row">
                              <label for="call_type" class="col-sm-4 col-form-label">Call Type<span class="text-danger">*</span></label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm select2" id="call_type" name="call_type"  onchange="select_calltype('add_inquiry')" aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($calltypes))
                                       {
                                           foreach ($calltypes as $calltype) {
                                               ?>
                                    <option value="<?php echo $calltype->id;?>"><?php echo $calltype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="assign_to" class="col-sm-4 col-form-label">Assign To<span class="text-danger">*</span></label>
                              <div class="col-sm-8">
                                 <select class=" form-control select2 " id="assign_to" name="assign_to" aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($all_users))
                                       {
                                           foreach ($all_users as $user) 
                                           {
                                            if( $user->status !=='0')
                                            {
                                              ?>
                                    <option value="<?php echo $user->id;?>" <?php if( $this->session->userdata('userId')==$user->id){echo "selected";}?> ><?php echo $user->id;?> <?php echo $user->title;?></option>
                                    <?php
                                            }
                                               
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_back_date" class="col-sm-4 col-form-label">Call Back Date<span class="text-danger">*</span></label>
                              <div class="col-sm-8">
                                 <input type="date" class="form-control form-control  form-control-sm" id="call_back_date" name="call_back_date"  placeholder="Call Back Date" value="<?php echo date("Y-m-d");?>" required >
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_direction" class="col-sm-4 col-form-label">Call Direction<span class="text-danger">*</span></label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm select2" id="call_direction" name="call_direction" aria-label="Floating label select example">
                                    
                                    <?php
                                       if(!empty($calldirections))
                                       {
                                           foreach ($calldirections as $calldirection) {
                                               ?>
                                    <option value="<?php echo $calldirection->id;?>"><?php echo $calldirection->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Current Conversation*</h5>
                        <div class="card-body">
                           <div class="row ">
                              <div class="col-sm-12">
                                 <textarea   class="form-control form-control-sm" id="current_conversation" name="current_conversation" placeholder="Current Conversation" required></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-body">
                           <div class="row ">
                              <div class="col-sm-12">
                                  <button type="submit" class="btn btn-info w-md float-end">Save</button>
                                  <input type="hidden" name="id" value="<?php if(isset($edit_data->id)){echo $edit_data->id;} ?>"/>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
                
            </form>

            <div class="row">
               <div class="col-sm-6">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="card">
                          <h4 class="card-header bg-success text-white">Previous Conversation</h4>
                           <div class="card-body">
                              
                               <div  id="example23">
                                  <p class="text-danger">Not found ...</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4"></div>
               <div class="col-sm-4"></div>
            </div>
         </div>
         <div class="col-xl-6">
            <div class="card">
               <form action='' method="get">
                  <h5 class="card-header bg-success text-white border-bottom ">
                   <div class="row ">
                     <div class="col-sm-4">
                      Inquiry Stat
                     </div>
                     <div class="col-sm-6">
                          <div class="input-group input-group-sm">
                               <select class="form-control form-control-sm " id="uid" name="uid" aria-label="Floating label select example">
                           
                          <?php

                          if(isset($_GET['uid']) && $_GET['uid'] !=='')
                                {
                                  $userid = $_GET['uid'];
                                }else
                                {
                                  $userid = $this->session->userdata('userId');
                                }

                             if(!empty($all_users))
                             {
                              foreach ($all_users as $user) 
                              {

                                
                                     ?>
                          <option value="<?php echo $user->id;?>" <?php if( isset($userid) && $userid==$user->id){echo "selected";}?> ><?php echo $user->id;?> <?php echo $user->title;?></option>
                          <?php
                             }
                             }
                             ?>
                           <option value="all" <?php if( isset($userid) && $userid=='all'){echo "selected";}?> >All Users</option>   
                       </select>
                        <input type="date" class="form-control form-control-sm "  name="last_follow_date" id="last_follow_date" value="<?php echo ((isset($_GET['last_follow_date']))?($_GET['last_follow_date']):(date('Y-m-d')))?>">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-info btn-sm ">Filter</button>                                    
                          </div>
                          <div class="input-group-append">
                              <a href="<?php echo base_url()?>admin/customer/addnew" class="btn btn-info btn-sm ">Reset</a>                                    
                          </div>
                      </div>
                     </div>
                     <div class="col-sm-2">
                      <button type="button" class="btn btn-info btn-sm exportbtn"> <i class="fa fa-file-export"></i>Export</button>  
                     </div>
                   </div>
                 </h5>
               </form>
               
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="card card-body pt-0">
                           <h4 class="card-title bg-success text-white p-1 ">Call Summary:</h4>
                           <?php

                           if(!empty($count_call_summary))
                              {
                                 

                                $uuid = "&uid=".((isset($_GET['uid']))?($_GET['uid']):$this->session->userdata('userId'))."&last_follow_date=".((isset($_GET['last_follow_date']))?($_GET['last_follow_date']):(date('Y-m-d')));
                                 foreach ($count_call_summary as $key => $value) 
                                {
                                     ?>
                                     <div class="flex-grow-1">
                                        <a href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=call_type2&call_type2=<?php echo $value['id'].$uuid?>">
                                          <div class="float-end">
                                           <p class="text-primary mb-0"><?php echo $value['total_count_call'];?></p>
                                        </div>
                                        <p class="text-primary mb-0"><?php echo $value['title'];?></p>
                                        </a>
                                     </div>
                                     <?php
                                }
                              }

 
                              ?>
                               <div class="flex-grow-1">
                                        <a href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=all<?=$uuid?>">
                                          <div class="float-end">
                                          <p class="text-primary mb-0"><?php echo @$total_customer+0;?></p>
                                          </div>
                                        <p class="text-primary mb-0">Total Customer</p>
                                        </a>
                                     </div> 
                                     <div class="flex-grow-1">
                                        <a href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=allcall<?=$uuid?>">
                                          <div class="float-end">
                                          <p class="text-primary mb-0"><?php echo @$total_calls+0;?></p>
                                          </div>
                                        <p class="text-primary mb-0">Total Calls</p>
                                        </a>
                                     </div>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="card card-body pt-0">
                           <h4 class="card-title bg-success text-white  p-1 ">Follow up Summary</h4>
                           <div class="flex-grow-1">
                              <a style="font-weight: 600;" href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=yesterday<?php echo $uuid?>">
                              <div class="float-end">
                              <p class="text-primary mb-0"><?php echo $follow_up_missed;?></p>
                              </div>
                              <p class="text-primary mb-0">Missed followup</p>
                              </a>
                              <?php 
                                if(!empty($follow_up_missed_sub))
                                {
                                  ?>
                                    <ul class="mb-0">
                                      
                                    
                                  <?php
                                   foreach ($follow_up_missed_sub as $key => $value)
                                  {
                                    if($value['total_count_call'] >0)
                                    {
                                        ?>
                                          <li>
                                             
                                            <a  style="font-size: 10px;" href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=yesterday&call_type2=<?php echo $value['id'];?><?php echo $uuid?>">
                                              <div class="float-end">
                                              <p class="text-primary mb-0"><?php echo $value['total_count_call'];?></p>
                                              </div>
                                              <p class="text-primary mb-0"><?php echo $value['title'];?></p>
                                            </a>
                                          </li>
                                        <?php
                                    }
                                       
                                  }
                                  ?>
                                    </ul>
                                  <?php
                                }
                              ?>
                              
                           </div>
                           <div class="flex-grow-1">
                               <a style="font-weight: 600;" href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=today<?php echo $uuid?>">
                                <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo $follow_up_due_today;?></p>
                              </div>
                              <p class="text-primary mb-0">Due Today</p>
                                </a>
                              <?php 
                                if(!empty($follow_up_due_today_sub))
                                {
                                  ?>
                                    <ul class="mb-0">
                                      
                                    
                                  <?php
                                   foreach ($follow_up_due_today_sub as $key => $value)
                                  {
                                    if($value['total_count_call'] >0)
                                    {
                                        ?>
                                          <li>
                                             
                                            <a style="font-size: 10px;" href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=today&call_type2=<?php echo $value['id'];?><?php echo $uuid?>">
                                              <div class="float-end">
                                              <p class="text-primary mb-0"><?php echo $value['total_count_call'];?></p>
                                              </div>
                                              <p class="text-primary mb-0"><?php echo $value['title'];?></p>
                                            </a>
                                          </li>
                                        <?php
                                    }
                                       
                                  }
                                  ?>
                                    </ul>
                                  <?php
                                }
                              ?>
                           </div>
                           <div class="flex-grow-1">
                               <a style="font-weight: 600;"  href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=tomorrow<?php echo $uuid?>">
                                <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo $follow_up_due_tomorrow;?></p>
                              </div>
                              <p class="text-primary mb-0">Due Tomorrow</p>
                                </a>
                               <?php 
                                if(!empty($follow_up_due_tomorrow_sub))
                                {
                                  ?>
                                    <ul class="mb-0">
                                      
                                    
                                  <?php
                                   foreach ($follow_up_due_tomorrow_sub as $key => $value)
                                  {
                                    if($value['total_count_call'])
                                    {
                                        ?>
                                          <li>
                                             
                                            <a style="font-size: 10px;" href="<?php echo base_url()?>admin/customer/addnew?section=statsdata&form_type=inquiry&stat_type=followup&followup_type=tomorrow&call_type2=<?php echo $value['id'];?><?php echo $uuid?>">
                                              <div class="float-end">
                                              <p class="text-primary mb-0"><?php echo $value['total_count_call'];?></p>
                                              </div>
                                              <p class="text-primary mb-0"><?php echo $value['title'];?></p>
                                            </a>
                                          </li>
                                        <?php
                                    }
                                       
                                  }
                                  ?>
                                    </ul>
                                  <?php
                                }
                              ?>
                           </div>
                            
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="card card-body pt-0">
                           <h4 class="card-title    p-1  bg-success text-white">Booking Summary:</h4>

                            <div class="flex-grow-1">
                              <a href="<?php echo base_url()?>admin/customer/addnew?section=booking&booking_type=today<?php echo $uuid?>">
                                <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo @$today_booking;?></p>
                              </div>
                              <p class="text-primary mb-0">Today's Booking</p>
                              </a>
                           </div>
                           <div class="flex-grow-1">

                            <a href="<?php echo base_url()?>admin/customer/addnew?section=booking&booking_type=week<?php echo $uuid?>">
                              <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo @$week_booking;?></p>
                              </div>
                              <p class="text-primary mb-0">Last 7 Days</p>
                            </a>
                           </div>
                           <div class="flex-grow-1">
                            <a href="<?php echo base_url()?>admin/customer/addnew?section=booking&booking_type=month<?php echo $uuid?>">
                              <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo @$this_month_booking;?></p>
                              </div>
                              <p class="text-primary mb-0">This Month</p>
                            </a>
                           </div>
                           <div class="flex-grow-1">
                              <a href="<?php echo base_url()?>admin/customer/addnew?section=booking&booking_type=previous_month<?php echo $uuid?>">
                              <div class="float-end">
                                 <p class="text-primary mb-0"><?php echo @$previous_month_booking;?></p>
                              </div>
                              <p class="text-primary mb-0">Previous Month</p>
                            </a>
                           </div>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
              

              if(@$section=='booking'){
                ?>
                  <div class="row">
               <div class="col-lg-12">
                  <div class="card">
 
                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-6">
                            Booking
                           </div>
                           
                           <div class="col-sm-6">
                            <div class="float-end">
                                <a href="<?php echo base_url()?>admin/customer/addnew" class="btn btn-info btn-sm">Clear</a> 
                            </div>
                         </div>
                       </h5>

 
                     
                       <div class="card-body">
                        
                        <div class="table-responsive mytablestyle">
                          
                           <table class="table align-middle table-nowrap mb-0 table-striped" id="example">
                              <thead class="table-light">
                                 <tr>
                                    <th class="align-middle bg-success text-white">Action</th>
                                    <th class="align-middle bg-success text-white">Booking No.</th>
                                    <th class="align-middle bg-success text-white">Booking Status</th>
                                    <th class="align-middle bg-success text-white">Crop Status</th>
                                    <th class="align-middle bg-success text-white">Customer Id</th>
                                    <th class="align-middle bg-success text-white">Customer Name </th>
                                    <th class="align-middle bg-success text-white">Executive</th>
                                    <th class="align-middle bg-success text-white">Choose Product</th>
                                    <th class="align-middle bg-success text-white">Primary number</th>
                                    <th class="align-middle bg-success text-white">Number</th>
                                    <th class="align-middle bg-success text-white">Village</th>
                                    <th class="align-middle bg-success text-white">Pincode</th>
                                    <th class="align-middle bg-success text-white">Choose State</th>
                                    <th class="align-middle bg-success text-white">Choose District</th>
                                    <th class="align-middle bg-success text-white">Choose Tehsil</th>
                                    <th class="align-middle bg-success text-white">Booking Date</th>
                                    <th class="align-middle bg-success text-white">Payment Mode</th>
                                    <th class="align-middle bg-success text-white">Plants Booked</th>
                                    <th class="align-middle bg-success text-white">Plant Rate</th>
                                    <th class="align-middle bg-success text-white">Total Billed Amount</th>
                                    <th class="align-middle bg-success text-white">Discount Amount</th>
                                    <th class="align-middle bg-success text-white">Received Amount</th>
                                    <th class="align-middle bg-success text-white">Outstanding Amount</th>
                                    <th class="align-middle bg-success text-white">Expected Delivery Date</th>
                                    <th class="align-middle bg-success text-white">Actual Delivery Date</th>
                                    <th class="align-middle bg-success text-white">Vehicle No.</th>
                                    <th class="align-middle bg-success text-white">Delivery Status</th>
                                    <th class="align-middle bg-success text-white">Contract Status</th>
                                    <th class="align-middle bg-success text-white">Document</th>
                                    <th class="align-middle bg-success text-white">Assigned To</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                <?php
                                    if(!empty($bookings)){
                                           foreach($bookings as $bookings){ ?>
                                    <tr>
                                       <td>
                                          <div class="btn-group">
                                             <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                             Action<i class="mdi mdi-chevron-down"></i>
                                             </span>
                                             <div class="dropdown-menu" style="">
                                                <a class="dropdown-item btn" target="_BLANK" href="<?php echo base_url()?>admin/bookings/receipt/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> Generate Receipt</a>
                                                <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/view/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View Order Details</a>
                                                <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/agreement/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-file-excel" aria-hidden="true"></i> Generate Agreement</a>
                                                  
                                                 
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                        <a class="" href="<?php echo base_url()?>admin/bookings/<?php echo $bookings['id']; ?>/edit" data-userid="<?php echo $bookings['id']; ?>"><?php echo $bookings['id'];?></a>
                                        </td>
                                         <td><span class="badge bg-<?php echo $bookings['booked_badges'];?> "><?php echo $bookings['booked_status'];?></span></td>
                                         <td><?php echo $bookings['cropstatusname'];?></td>

                                         <td><?php echo $bookings['farmer_id'];?></td>
                                         <td><?php echo $bookings['customer_name'];?></td>
                                         <td><?php echo $bookings['executive'];?></td>
                                         <td><?php echo $bookings['productname'];?></td>
                                          <td><?php echo $bookings['customer_mobile'];?></td>
                                       <td><?php echo $bookings['customer_alter_mobile'];?></td>
                                        <td><?php echo $bookings['billing_address'];?></td>
                                       <td><?php echo ($bookings['state']);?></td>
                                       <td><?php echo  ($bookings['district']);?></td>
                                       <td><?php echo  ($bookings['city']);?></td>
                                       <td><?php echo $bookings['pincode'];?></td>
                                       <td><?php echo ($bookings['booking_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['booking_date'])) :'';?></td>
                                       <td><?php echo $bookings['paymentmodename'];?></td>

                                        <td><?php echo $bookings['quantity'];?></td>
                                       <td><?php echo $bookings['price'];?></td>
                                       <td><?php echo $bookings['total'];?></td>
                                       <td><?php echo $bookings['discount'];?></td>
                                       <td><?php echo $bookings['total_paid_amount'];?></td>
                                       <td><span class='<?php if($bookings['outstanding_amount'] <0){ echo "text-danger";}?>'><?php echo $bookings['outstanding_amount'];?></span></td>
                                       <td>
                                          <?php 
                                             if(isset($bookings['delivery_expect_start_date']) && isset($bookings['delivery_expect_end_date']))
                                             {
                                               echo ($bookings['delivery_expect_start_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['delivery_expect_start_date'])) :'';?> To <?php 
                                             echo ($bookings['delivery_expect_end_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['delivery_expect_end_date'])) :''; 
                                             }
                                             ?>
                                       </td>
                                       <td><?php echo ($bookings['delivery_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['delivery_date'])) :'';?> </td>
                                       <td><?php echo $bookings['vehicle_no'];?></td>
                                       <td></td>
                                       <td><?php echo $bookings['contractstatusname'];?></td>
                                        
                                       <td>
                                          <?php 
                                             if($bookings['document'] !=='')
                                             {
                                               ?>
                                          <a target="_BLANK" download class="text-primary"  href="<?php echo base_url()?>uploads/admin/document/<?php echo $bookings['document'];?>">Download <i class="fa fa-download" aria-hidden="true"></i><a>
                                          <?php
                                             }
                                             ?>
                                       </td>
                                       <td><?php echo $bookings['assignedto'];?></td>
                                         


                                    </tr>
                                    <?php } }else{ ?>
                                    <tr>
                                       <td colspan="100">customers (s) not found...
                                       <td>
                                    </tr>
                                    <?php }

                                     ?>
                             
                              </tbody>
                           </table>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                              <ul class="pagination  justify-content-left mt-4"  >
                                 <li class="">
                                    <p><?php echo @$pagination_total_count; ?> Bookings. </p>
                                 </li>
                              </ul>
                          </div>
                          <div class="col-sm-9">
                            <?php echo $this->pagination->create_links(); ?>  
                          </div>
                        </div>
                      </div>
                     
                  </div>
                </div>
              </div>
                <?php
              }else
              {
                ?>
                   <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                    <form method="GET" action="<?php echo base_url()?>admin/customer/addnew">

                      <h5 class="card-header bg-success text-white border-bottom ">
                         <div class="row ">
                           <div class="col-sm-6">
                            Inquiries
                           </div>
                           
                           <div class="col-sm-6">
                            <div class="float-end">
                               
                                <a href="<?php echo base_url()?>admin/customer/export_stat?<?php echo $_SERVER['QUERY_STRING']?>" class="btn btn-info btn-sm">Export</a> 
                               
                            
                            <a href="<?php echo base_url()?>admin/customer/addnew" class="btn btn-info btn-sm">Clear</a> 
                            <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-search"></i> Submit Filter</button>
                            <input name="form_type" type="hidden" value="inquiry">
                            </div>
                           </div>
                         </div>
                       </h5>

 
                     
                       <div class="card-body">
                        
                        <div class="table-responsive mytablestyle">
                          
                           <table class="table align-middle table-nowrap mb-0 table-striped" id="example">
                              <thead class="table-light">
                                 <tr>
                                    <th class="align-middle bg-success text-white">Action</th>
                                    <th class="align-middle bg-success text-white">Date</th>
                                    <th class="align-middle bg-success text-white"><input class="form-control-sm" type="text" name="search_customer_id" id="search_customer_id" placeholder="Farmer ID"  style="width: 70px;"  ></th>
                                    <th class="align-middle bg-success text-white"><input class="form-control-sm" type="text" name="search_name" id="search_name" placeholder="Name"  style="width: 60px;" ></th>
                                    <th class="align-middle bg-success text-white"><input class="form-control-sm" type="text" name="search_mobile" id="search_mobile" placeholder="Mobile"  style="width: 60px;" ></th>
                                    <th class="align-middle bg-success text-white"><input class="form-control-sm" type="text" name="search_alt_mobile" id="search_alt_mobile" placeholder="ALT Mobile"  style="width: 60px;" ></th>
                                    <th class="align-middle bg-success text-white">
                                      <select class=" form-control select2 " id="state2" name="state2" aria-label="Floating label select example" style="width: 150px;" onchange="stateChange2()">
                                        <option value="" selected>Choose State</option>
                                          <?php
                                             if(!empty($states))
                                             {
                                                     foreach ($states as $state) {
                                                         ?>
                                              <option value="<?php echo $state->id;?>"><?php echo $state->name;?></option>
                                              <?php
                                                 }
                                             }
                                             ?>
                                      </select>

                                      <input type="text" name="other_state2" id="other_state2"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name" />
                                    </th>
                                    <th class="align-middle bg-success text-white">
                                      <select class=" form-control select2 " id="district2" name="district2" aria-label="Floating label select example"   style="width: 150px;" onchange="districtChange2()">
                                      <option value="" selected>Choose District</option>

                                      </select>
                                      <input type="text" name="other_district2" id="other_district2"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
                                    </th>
                                    <th class="align-middle bg-success text-white">
                                      <select class=" form-control  select2 " id="city2" name="city2" aria-label="Floating label select example" style="width: 150px;"   onchange="cityChange2()">
                                        <option value="" selected>Choose Tehsil</option>
                                      </select>
                                      <input type="text" name="other_city2" id="other_city2"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />
                                    </th>
                                    <th class="align-middle bg-success text-white">
                                      <select class=" form-control  form-control-sm select2" id="farmer_type2" name="farmer_type2" aria-label="Floating label select example"  style="width: 150px;"  >
                                     <option value="">FarmerType</option>
                                    <?php
                                       if(!empty($farmertypes))
                                       {
                                           foreach ($farmertypes as $farmertype) {
                                               ?>
                                    <option value="<?php echo $farmertype->id;?>" ><?php echo $farmertype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                               </th>
                               <th class="align-middle bg-success text-white">
                                      <select class=" form-control  form-control-sm select2" id="crop_id2" name="crop_id2" aria-label="Floating label select example"  style="width: 150px;" >
                                     <option value="">Crop</option>
                                    <?php
                                       if(!empty($crop_lists))
                                       {
                                           foreach ($crop_lists as $crop_list) {
                                               ?>
                                    <option value="<?php echo $crop_list->id;?>" ><?php echo $crop_list->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                               </th>
                               <th class="align-middle bg-success text-white">
                                      <select class=" form-control  form-control-sm select2" id="call_direction2" name="call_direction2" aria-label="Floating label select example"  style="width: 75px;"  >
                                     <option value="">CallDirection</option>
                                    <?php
                                       if(!empty($calldirections))
                                       {
                                           foreach ($calldirections as $calldirection) {
                                               ?>
                                    <option value="<?php echo $calldirection->id;?>"><?php echo $calldirection->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                               </th>
                                    <th class="align-middle bg-success text-white">
                                      <select class=" form-control  form-control-sm select2" id="call_type2" name="call_type2" aria-label="Floating label select example"  style="width: 75px;" >
                                         <option value="">CallType</option>
                                        <?php
                                           if(!empty($calltypes))
                                           {
                                               foreach ($calltypes as $calltype) {
                                                   ?>
                                        <option value="<?php echo $calltype->id;?>"><?php echo $calltype->title;?></option>
                                        <?php
                                           }
                                           }
                                           ?>
                                      </select>
                                    </th>
                                      <th class="align-middle bg-success text-white" >Followup date</th>
                                      <th class="align-middle bg-success text-white" >Assigned to</th>
                                      <th class="align-middle bg-success text-white" >Entry made by</th>
                                      <th class="align-middle bg-success text-white" >Entry Date</th>
                                      <th class="align-middle bg-success text-white" >Last Follower</th>
                                      <th class="align-middle bg-success text-white" >Last Call Type</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                <?php
                                    if(!empty($customers)){ foreach($customers as $customer){ 
                                      ?>
                                      <tr>
                                        <td>
                                          <div class="btn-group">
                                            <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                            Action<i class="mdi mdi-chevron-down"></i>
                                            </span>
                                            <div class="dropdown-menu" style="">

                                            <?php
                                              if(@$action_requred->view=='view')
                                              {
                                              ?>
                                                <a class="dropdown-item btn side_modal" data-userid="<?php echo $customer['id']; ?>">View</a>
                                              <?php  
                                              }
                                              if(@$action_requred->delete=='delete')
                                              {
                                              ?>
                                               <a class="dropdown-item text-danger deletebtn" href="#" data-userid="<?php echo $customer['id']; ?>">Delete</a>
                                              <?php  
                                              }
                                             
  $view_btn =(@$action_requred->view=='view')?'<a class="side_modal"  data-userid="'.$customer['id'].'" href="javascript:void(0)">'.$customer['farmername'].'</a>':$customer['farmername'];
                                               
                                            ?>
                                            
                                          </div>
                                          </div></td>
                                        <td><?php echo date('d M Y',strtotime($customer['last_follow_date']));?></td>
                                        <td><?php echo $customer['farmer_id'];?></td>
                                        <td><?php echo $view_btn;?><?php if($customer['premium']==1){ ?> <span class="badge bg-danger" title="Premium Customer" style="line-height: 1;">Premium</span><?php } ?></td>
                                        <td><?php echo $customer['farmermobile'];?></td>
                                        <td><?php echo $customer['farmeraltmobile'];?></td>
                                        <td><?php echo  ($customer['state']);?></td>
                                        <td><?php echo  ($customer['district']);?></td>
                                        <td><?php echo  ($customer['city']);?></td>
                                        <td><?php echo $customer['farmertype'];?></td>
                                        <td><?php echo $customer['cropname'];?></td>
                                        <td><?php echo $customer['calldir'];?></td>
                                        <td><?php echo $customer['calltype'];?></td>
                                        <td><?php if($customer['last_call_back_date'] !=='0000-00-00'){echo date('d M Y',strtotime($customer['last_call_back_date']));}?></td>
                                        <td><?php echo $customer['assignedto'];?></td>
                                        <td><?php echo $customer['createdby'];?></td>
                                        <td><?php echo date('d M Y',strtotime($customer['last_follow_date']));?></td>
                                        <td><?php echo $customer['lastfollower'];?></td>
                                        <td><?php echo $customer['lastcalltype'];?></td>
                                      </tr>
                              <?php } }else{ ?>
                                   <tr>
                                  <td colspan="100">customers (s) not found...<td>
                                </tr>
                                   
                              <?php } ?>
                             
                              </tbody>
                           </table>
                        </div>
                        
                        <div class="row">
                           
                          <div class="col-sm-12">
                            <?php echo $this->pagination->create_links(); ?>  
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                              <ul class="pagination table table-responsive justify-content-left mt-4"  >
                                 <li class="">
                                    <p><?php echo @$pagination_total_count; ?> Inquiries. </p>
                                 </li>
                              </ul>
                          </div>
                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
                <?php
              }

            ?>

            </div>


         </div>
      </div>

      <!-- end col -->
     
            
        
      
   </div>
</div>
<div class="modal fade show" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Previous Conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <div id="example233"></div>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exportModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="change_booking_status" method="post" id="change_booking_status" action="<?php echo base_url();?>admin/customer/export">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="exportModalLabel">Export enquiry data</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
               <div class=" row">
                  <label for="example-text-input" class="col-md-5 col-form-label">Select Agent</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="assigned_to" name="assigned_to" aria-label="Floating label select example"  >
                        <option value="" selected>All</option>
                        <?php
                             
                              if(!empty($all_users))
                                       {
                                           foreach ($all_users as $user) {
                                               ?>
                                    <option value="<?php echo $user->id;?>" <?php if( $this->session->userdata('userId')==$user->id){echo "selected";}?> ><?php echo $user->id;?> <?php echo $user->title;?></option>
                                    <?php
                                       }
                                       }
                           ?>
                     </select>
                  </div>
               </div> 
               <div class="row">
                  <label for="example-text-input" class="col-md-5 col-form-label">Call Type</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="call_type" name="call_type" aria-label="Floating label select example"  >
                      <option value="" selected>All</option>
                         <?php
                                       if(!empty($calltypes))
                                       {
                                           foreach ($calltypes as $calltype) {
                                               ?>
                                    <option value="<?php echo $calltype->id;?>"><?php echo $calltype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <label for="from_date" class="col-md-5 col-form-label">Fron Date</label>
                  <div class="col-md-7">
                    <input  class="form-control form-control-sm"  type="date" name="from_date" id="from_date"  >
                   </div>
               </div>
               <div class=" row">
                  <label for="to_date" class="col-md-5 col-form-label">To Date</label>
                  <div class="col-md-7">
                    <input class="form-control form-control-sm" type="date" name="to_date" id="to_date"  >
                   </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade bs-example-modal-xl show" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-modal="true" role="dialog" >
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content border-success">
                                                        <div class="modal-header bg-success ">
                                                            <h5 class="modal-title text-white" id="myExtraLargeModalLabel">Edit Inquiries Information</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> 
                                                            <form action="<?php echo base_url();?>admin/customer/update_enquiry" id="update_inquiry">
                                                              <div class="row">
                <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo base_url()."admin/customer/update?".$_SERVER['QUERY_STRING'];?>">
                  <div class="col-sm-6">
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Farmers Detail</h5>
                        <div class="card-body">
                           <div class="row">
                              <label for="farmser_id_update" class="col-sm-4 col-form-label">Farmer ID</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="farmser_id_update" name="farmser_id_update" placeholder="Farmer ID" readonly value="">
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_name_update" class="col-sm-4 col-form-label">Farmers Name*</label>
                              <div class="col-sm-8"> 
                                 <input type="text" class="form-control form-control-sm" id="customer_name_update" name="customer_name_update" placeholder="Farmers Name*" value="" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_mobile_update" class="col-sm-4 col-form-label">Mobile*</label>
                              <div class="col-sm-8"> 
                                 <input type="text" maxlength="12" class="form-control form-control-sm" readonly id="customer_mobile_update"  name="customer_mobile_update"  placeholder="Customer Mobile*"  value=""  onkeypress="return onlyNumberKey(event)" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="customer_alter_mobile_update" class="col-sm-4 col-form-label">ALT Mobile</label>
                              <div class="col-sm-8">
                                 <input type="text" class="form-control form-control-sm" id="customer_alter_mobile_update" placeholder="ALT Mobile" name="customer_alter_mobile_update" value="" onkeypress="return onlyNumberKey(event)" >
                              </div>
                           </div>
                           <div class="row">
                              <label for="state_update" class="col-sm-4 col-form-label">State</label>
                              <div class="col-sm-8">
                                 <select class=" form-control form-control-sm" id="state_update" name="state_update" aria-label="Floating label select example" onchange="stateChangeUpdate()">
                                    <option value="" selected>Choose State</option>
                                    <?php
                                       if(!empty($states))
                                       {
                                           foreach ($states as $state) {
                                               ?>
                                    <option value="<?php echo $state->id;?>" ><?php echo $state->name;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                                 <input type="text" name="other_state_update" id="other_state_update"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">District</label>
                              <div class="col-sm-8">
                                 <select class=" form-control form-control-sm" id="district_update" name="district_update" aria-label="Floating label select example" onchange="districtChangeUpdate()">
                                    <option value="" selected>Choose District</option>
                                    <?php
                                      /* if(!empty($districts))
                                       {
                                           foreach ($districts as $district) {
                                               ?>
                                    <option value="<?php echo $district->id;?>"  <?php if(isset($edit_data->district) && $edit_data->district ==$district->id){ echo "selected";}?>><?php echo $district->name;?></option>
                                    <?php
                                       }
                                       }*/
                                       ?>
                                 </select>
                                 <input type="text" name="other_district_update" id="other_district_update"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
                              </div>
                           </div>
                           <div class="row">
                              <label for="city" class="col-sm-4 col-form-label">Tehsil</label>
                              <div class="col-sm-8">
                                 <select class=" form-control form-control-sm" id="city_update" name="city_update" aria-label="Floating label select example"  onchange="cityChangeUpdate()">
                                    <option value="" selected>Choose Tehsil</option>
                                    
                                 </select>
                                <input type="text" name="other_city_update" id="other_city_update"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />

                              </div>
                           </div>
                        </div>
                        <!-- end card body -->
                     </div>
                     <div class="card">
                        <h5 class="card-header bg-success text-white border-bottom ">Call Details</h5>
                        <div class="card-body">
                           
                           <div class="row">
                              <label for="call_type_update" class="col-sm-4 col-form-label">Call Type*</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm" id="call_type_update" name="call_type_update"  onchange="select_calltype('update_inquiry')" aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($calltypes))
                                       {
                                           foreach ($calltypes as $calltype) {
                                               ?>
                                    <option value="<?php echo $calltype->id;?>"><?php echo $calltype->title;?></option>
                                    <?php
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="assign_to_update" class="col-sm-4 col-form-label">Assign To*</label>
                              <div class="col-sm-8">
                                 <select class=" form-control form-control-sm" id="assign_to_update" name="assign_to_update" aria-label="Floating label select example">
                                     
                                    <?php
                                       if(!empty($all_users))
                                       {
                                           foreach ($all_users as $user) {
                                            if($user->status !=0)
                                            {
                                               ?>
                                    <option value="<?php echo $user->id;?>"  ><?php echo $user->id;?> <?php echo $user->title;?></option>
                                    <?php
                                            }
                                              
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_back_date_update" class="col-sm-4 col-form-label">Call Back Date*</label>
                              <div class="col-sm-8">
                                 <input type="date" class="form-control form-control  form-control-sm" id="call_back_date_update" name="call_back_date_update"  placeholder="Call Back Date" value="<?php echo date("Y-m-d");?>">
                              </div>
                           </div>
                           <div class="row">
                              <label for="call_direction_update" class="col-sm-4 col-form-label">Call Direction*</label>
                              <div class="col-sm-8">
                                 <select class=" form-control  form-control-sm" id="call_direction_update" name="call_direction_update" aria-label="Floating label select example">
                                    
                                    <?php
                                       if(!empty($calldirections))
                                       {
                                           foreach ($calldirections as $calldirection) {
                                               ?>
                                    <option value="<?php echo $calldirection->id;?>"><?php echo $calldirection->title;?></option>
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
                           <div class="row">
                              <div class="col-sm-12">
                                 <textarea   class="form-control form-control-sm" id="current_conversation_update" name="current_conversation_update" placeholder="Current Conversation"  ></textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card">
                         
                        <div class="card-body">
                           <div class="row ">
                              <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary w-md float-end">Save</button>
                                  <input type="hidden" name="enquiry_id_update" id="enquiry_id_update" value=""/>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
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
  function select_calltype(formid)
  {
    if(formid=='update_inquiry')
    {

       $('#'+formid+' #call_back_date_update').attr('readonly', false);
       $('#'+formid+' #call_back_date_update').attr('required', true);
      var call_type =  $('#'+formid+'  #call_type_update').val();
     
      if(call_type==2)
      {
        $('#'+formid+' #call_back_date_update').val(''); 
        $('#'+formid+' #call_back_date_update').attr('readonly', true);
        $('#'+formid+' #call_back_date_update').attr('required', false);

      }
    }else
    {
       $('#'+formid+' #call_back_date').attr('readonly', false);
       $('#'+formid+' #call_back_date').attr('required', true);
      var call_type =  $('#'+formid+'  #call_type').val();
     
      if(call_type==2)
      {
        $('#'+formid+' #call_back_date').val(''); 
        $('#'+formid+' #call_back_date').attr('readonly', true);
        $('#'+formid+' #call_back_date').attr('required', false);

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
        beforeSend: function(){
          if(state_code=='')
          {
            show_loader();    
          }
        
       },
       complete: function(){
        if(state_code=='')
          {
            hide_loader();    
          } 
       },
        success: function (response) {
          var check_state = $('#state option:selected').text();
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
         beforeSend: function(){
            if(state_code=='')
            {
              show_loader();    
            }
          
         },
         complete: function(){
          if(state_code=='')
            {
              hide_loader();    
            } 
         },
        success: function (response) {
             var check_state = $('#state2 option:selected').text();
             
            $("#district2").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#district2").empty();
        }
    });
} 
function stateChangeUpdate(state_code = '',selected_district = '') {
      
    var stateCode = state_code ? state_code : $('#state_update').val();
    var selectedDistrict = selected_district ? selected_district : $('#district_update').val();
    hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
         beforeSend: function(){
            if(state_code=='')
            {
              show_loader();    
            }
          
         },
         complete: function(){
          if(state_code=='')
            {
              hide_loader();    
            } 
         },
        success: function (response) {
             var check_state = $('#state_update option:selected').text();
           
            $("#district_update").empty().append(response);
            
        },
        error: function (request, status, error) {
             
             
            
            $("#district_update").empty();
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
          beforeSend: function(){
            if(district_code=='')
            {
              show_loader();    
            }
          
         },
         complete: function(){
          if(district_code=='')
            {
              hide_loader();    
            } 
         },
        success: function (response) {
             
            var check_district = $('#district option:selected').text();
             
          
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
          
}
function cityChange2(district_code = '',selected_city = '') {
      
     var check_city = $('#city2 option:selected').text();
             
}
function cityChangeUpdate(district_code = '',selected_city = '') {
      
     var check_city = $('#city_update option:selected').text();
           
}
function districtChange2(district_code = '',selected_city = '') {
      
    var districtCode = district_code ? district_code : $('#district2').val();
    var selectedCity = selected_city ? selected_city : $('#city2').val();
    hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ districtCode+"/"+ selectedCity;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        beforeSend: function(){
            if(district_code=='')
            {
              show_loader();    
            }
          
         },
         complete: function(){
          if(district_code=='')
            {
              hide_loader();    
            } 
         },
        success: function (response) {
             

               var check_district = $('#district2 option:selected').text();
           
            $("#city2").empty().append(response);
            $(".select2").select2();
        },
        error: function (request, status, error) {
             
             
            
            $("#city2").empty();
        }
    });
}
function districtChangeUpdate(district_code = '',selected_city = '') {
      
    var districtCode = district_code ? district_code : $('#district_update').val();
    var selectedCity = selected_city ? selected_city : $('#city_update').val();
    hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ districtCode+"/"+ selectedCity;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
         beforeSend: function(){
            if(district_code=='')
            {
              show_loader();    
            }
          
         },
         complete: function(){
          if(district_code=='')
            {
              hide_loader();    
            } 
         },
        success: function (response) {
          var check_district = $('#district_update option:selected').text();
           
            $("#city_update").empty().append(response);
         },
        error: function (request, status, error) {
             
             
            
            $("#city_update").empty();
        }
    });
}
  
   jQuery("#update_inquiry").on('submit',function(e){
            e.preventDefault();
              
             
             var form = $(this);
             var hitURL = form.attr('action');
              var formValues= $(this).serialize();
             show_loader();
          
             jQuery.ajax({
               type : "POST",
               dataType : "json",
               url : hitURL,
               data : formValues 
             }).done(function(data){
               hide_loader();
               if(data.status==1)
               {
                /*console.log(data);
                 return false;*/
   
                 $('.bs-example-modal-xl').modal('hide');
                 toastr.success(data.message);
                  window.location.reload(true);
   
               
               }else{
   
                 toastr.error(data.message);
   
               }
             });
          
       });
   jQuery(document).ready(function(){
         $(".bs-example-modal-xl").on('hide.bs.modal', function(){
          $('#update_inquiry').attr('action','');
          $('#update_inquiry')[0].reset();
           
       });
   

       $('#exampleModalScrollable').on("hidden.bs.modal",function(){
          
           $('#example233').html('');
       });
       //$('#example').DataTable();
   
        jQuery(document).on("click", ".side_modal", function(){
            var userId = $(this).data("userid");
            $("#exampleModalScrollable").modal('show');
            
            single_cutomer_call_detail(userId);

        });
        jQuery(document).on("click", ".editbtn", function(){
           var userId = $(this).data("userid")
           
             single_cutomer_detail(userId);
            
        });
        jQuery(document).on("click", ".exportbtn", function(){
             
            $("#exportModal").modal('show'); 
             
        });
        jQuery(document).on("click", ".deletebtn", function(){
   
         var userId = $(this).data("userid"),
           hitURL = "<?php echo base_url() ?>admin/customer/delete",
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
             
             if(data.status = true) {
                currentRow.parents('tr').remove();
              alert("successfully deleted"); 
              window.location.reload(true);
            }
             else if(data.status = false) { alert("deletion failed"); }
             else { alert("Access denied..!"); }
           });
         }
   });
   });
   
</script>
<script type="text/javascript">


  


  function single_cutomer_detail(id)
  {
     $(".bs-example-modal-xl").modal('show');
        var userId = id,
           hitURL = "<?php echo base_url() ?>admin/customer/single/"+id;
           action_url = "<?php echo base_url() ?>admin/customer/update_enquiry";
           $("#update_inquiry").attr("action",action_url);

           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : {} 
           }).done(function(data){ 
            console.log(data);
            response = data;
            $("#farmser_id_update").val(response.farmer_id);
            $("#enquiry_id_update").val(response.id);
            $("#customer_name_update").val(response.customer_name);
            $("#customer_mobile_update").val(response.customer_mobile);
            $("#customer_alter_mobile_update").val(response.customer_alter_mobile);
            var state_id    = response.state;
             $("#other_state_update").val(response.other_state);
             $("#state_update").val(state_id);
            var district_id = response.district;
            $("#other_district_update").val(response.other_district);
            var city_id = response.city;
            stateChangeUpdate(state_id,district_id);
            districtChangeUpdate(district_id,city_id);
 
            $("#other_city_update").val(response.other_city);
            $("#assign_to_update").val(response.assigned_to);
            $("#call_back_date_update").val(response.last_call_back_date);
            $("#call_direction_update").val(response.last_call_direction);
            $("#current_conversation_update").val(response.current_conversation);
            $("#call_type_update").val(response.last_call_type);
            select_calltype('update_inquiry'); 

           });
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
              html_content+='<div class="event-timeline-dot "><i class=" display-6 bx text-white bxs-chat rounded-circle bg-success"></i></div>';

              html_content+='<div class="d-flex">';
              html_content+='<div class="flex-shrink-0 me-3"><i class="text-primary"></i></div>';

              html_content+='<div class="flex-grow-1"><div><div class="card border border-primary">';
              html_content+='<span class="my-primary badge badge-primary border-radius-0">'+data[i].date_at+'</span>';

              html_content+='<div class="card-header bg-transparent border-bottom">';
              html_content+=data[i].calltype+' <strong>By</strong> '+data[i].user_createdby;
              
              html_content+='</div>';
               if(data[i].call_back_date.length >0)
              {
                var callbackdate = '<strong> Call Back Date :</strong>'+data[i].call_back_date;  
              }else
              {
                var callbackdate = '';
              }
              
              html_content+='<div class="card-body"><p class="p-0 m-0"><strong>Call Direction :</strong>'+data[i].calldirection+callbackdate+'</p><p><strong> Assigned To :</strong>'+data[i].assigned+'</p><hr class="p-0 m-0"><p>'+data[i].current_conversation+'</p>';


              html_content+='</div></div></div></div></div></li>';

            }
            html_content+='</ul>';

                $('#'+div_id).html(html_content);
                
           });
          
  }
  function current_cutomer_call_detail()
  {
    get_cutomer_call_detail('<?php echo @$enquiry_id;?>','example23');
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
            stateChange('<?php echo @$edit_data->state_id;?>','<?php echo @$edit_data->district_id;?>');
            districtChange('<?php echo @$edit_data->district_id;?>','<?php echo @$edit_data->city_id;?>');
        });
      </script>
      <?php
    }
?>

<script type="text/javascript">
   var table;

   $(document).ready(function() {
     $("#add_inquiry").on("submit", function(){
        show_loader();
    });//submit

  

   $("#query-pagination li.page-item a").addClass('page-link');
    $(".select2").select2();
    
       //datatables
 /*      table = $('#example').DataTable({ 
    
           "processing": true, //Feature control the processing indicator.
           "serverSide": true, //Feature control DataTables' server-side processing mode.
           "order": [], //Initial no order.
    
           // Load data for the table's content from an Ajax source
           "ajax": {
               "url": "<?php echo site_url('admin/customer/ajax_list')?>",
               "type": "POST"
           },
    
           //Set column definition initialisation properties.
           "columnDefs": [
           { 
               "targets": [ 0 ], //first column / numbering column
               "orderable": false, //set not orderable
           },
           ],
    
       });*/
    
   });

      function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
         
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
   
</script>