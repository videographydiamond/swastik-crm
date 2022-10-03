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
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-6">
            <div class="card">
               <form   method="GET"  onsubmit="return false">
                  <div class="card-body  ">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label for="customer_id" class="col-sm-4 col-form-label text-right">Farmer ID:</label>
                              <div class="col-sm-8">
                                 <div class="input-group input-group-sm">
                                    <input class="form-control form-control-sm  " id="customer_id" name="customer_id" type="text" onkeypress="return onlyNumberKey(event)">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5">
                           <div class="form-group row">
                              <label for="mobile" class="col-sm-4 col-form-label text-right">Mobile No.:</label>
                              <div class="col-sm-8">
                                 <div class="input-group input-group-sm">
                                    <input class="form-control form-control-sm  " id="mobile" name="mobile" type="text"  onkeypress="return onlyNumberKey(event)" >
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
                  <input name="form_type" type="hidden" value="search">
            </div>
            </form>
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
         </div>
      </div>
      <div class="col-xl-12">
         <div class="card">
            <h5 class="card-header bg-success text-white border-bottom p-1">Add New Booking</h5>
            <div class="card card-body">
               <form action="<?php echo base_url() ?>admin/bookings/update" method="post" role="form" enctype="multipart/form-data" id="booking_form" class="custom-validation" novalidate >

                  <input type="hidden" name="farmer_id" id="farmer_id" value="<?php echo @$edit_data->farmer_id?>">
                         
                  <div class="row">
                     <div class="col-sm-3">
                        <input type="hidden" name="contactid" id="contactid" value="">
                        <div class="row">
                           <label for="customer_mobile" class="col-sm-4 col-form-label">Reg Mob No<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" maxlength="12" class="form-control form-control-sm" id="customer_mobile"  name="customer_mobile"  placeholder="Customer Mobile*"  value="<?php echo @$edit_data->customer_mobile?>" required readonly onkeypress="return onlyNumberKey(event)"/>
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_alter_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control customer_alter_mobile-control-sm" id="customer_alter_mobile" placeholder="ALT Mobile" name="customer_alter_mobile" value="<?php echo @$edit_data->customer_alter_mobile?>" onkeypress="return onlyNumberKey(event)" >
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" id="customer_name" name="customer_name" placeholder="Farmers Name*" required value="<?php echo @$edit_data->customer_name?>" readonly/>
                           </div>
                        </div>
                        <div class="row">
                           <label for="father_name" class="col-sm-4 col-form-label">Father Name</label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" id="father_name" name="father_name" placeholder="Father Name" value="<?php echo @$edit_data->father_name?>" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="booking_date" class="col-sm-4 col-form-label">Booking Date</label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="booking_date" name="booking_date"  value="<?php echo @$edit_data->booking_date?>" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="booking_status" class="col-sm-4 col-form-label">Booking Status</label>
                           <div class="col-sm-8">
                              <select class=" form-control select2 " id="booking_status" name="booking_status" aria-label="Floating label select example" >
                                 <?php
                                    if(!empty($bookings_status))
                                    {
                                        foreach ($bookings_status as $booking_status) {
                                            ?>
                                 <option value="<?php echo $booking_status->slug;?>" <?php if(isset($edit_data->booking_status) && $edit_data->booking_status == $booking_status->slug){echo "selected";}?> ><?php echo $booking_status->title;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                              </select>
                           </div>
                        </div>
                        <div class="row">
                           <label for="document_file" class="col-sm-4 col-form-label">Document
                           <?php
                              if(isset($edit_data->document) && $edit_data->document !=='')
                              {
                                 ?>
                           <a target="_blank" class="badge bg-primary text-white" href="<?php echo base_url()?>uploads/admin/document/<?php echo $edit_data->document;?>" download >View</a>
                           <?php      
                              }
                              ?>
                           </label> 
                           <div class="col-sm-8"> 
                              <input type="file" class="form-control form-control-sm" id="document_file" name="document_file"    />
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="state" class="col-sm-4 col-form-label"> State <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <select class=" form-control select2 " id="state" name="state" aria-label="Floating label select example" onchange="stateChange()"  required>
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
                              <input type="text" name="other_state" id="other_state"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter State Name" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="city" class="col-sm-4 col-form-label">District <span class="text-danger">*</span> </label>
                           <div class="col-sm-8">
                              <select class=" form-control select2 " id="district" name="district" aria-label="Floating label select example" onchange="districtChange()"  required>
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
                              <input type="text" name="other_district" id="other_district"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter District Name" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="city" class="col-sm-4 col-form-label">Tehsil <span class="text-danger">*</span> </label>
                           <div class="col-sm-8">
                              <select class=" form-control  select2 " id="city" name="city" aria-label="Floating label select example"  onchange="cityChange()"  required >
                                 <option value="" selected>Choose Tehsil</option>
                                 <?php
                                    /* if(!empty($cities))
                                     {
                                         foreach ($cities as $city) {
                                             ?>
                                 <option value="<?php echo $city->id;?>"  <?php if(isset($edit_data->city) && $edit_data->city ==$city->id){ echo "selected";}?>><?php echo $city->city;?></option>
                                 <?php
                                    }
                                    }*/
                                    ?>
                              </select>
                              <input type="text" name="other_city" id="other_city"  style="display: none;" class="form-control form-control-sm mb-2" placeholder="Please Enter Tehsil Name" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="village" class="col-sm-4 col-form-label">Village <span class="text-danger">*</span> </label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="village" name="village" placeholder="Village"   value="<?php echo @$edit_data->village?>"  required>
                           </div>
                        </div>
                        <div class="row">
                           <label for="pincode" class="col-sm-4 col-form-label">Pincode <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="pincode" name="pincode" placeholder="Pincode"   value="<?php echo @$edit_data->pincode?>" onkeypress="return onlyNumberKey(event)" required>
                           </div>
                        </div>
                        <div class="row">
                           <label for="crop_status" class="col-sm-4 col-form-label">Crop Status</label>
                           <div class="col-sm-8">
                              <select class=" form-control form-control-sm " id="crop_status" name="crop_status" aria-label="Floating label select example" >
                                 <?php
                                    if(!empty($crops_status))
                                    {
                                        foreach ($crops_status as $crop_status) {
                                            ?>
                                 <option value="<?php echo $crop_status->slug;?>"  <?php if(isset($edit_data->crop_status) && $edit_data->crop_status ==$crop_status->slug){ echo "selected";}?>><?php echo $crop_status->title;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                              </select>
                           </div>
                        </div>
                        <div class="row">
                           <label for="req_delivery_date" class="col-sm-4 col-form-label">Requested Delivery Date</label>
                           <div class="col-sm-8"> 
                              <input type="text" hidden id="req_delivery_date" name="req_delivery_date" value="<?php echo date('Y-m-d',strtotime($edit_data->delivery_expect_start_date)).":".date('Y-m-d',strtotime($edit_data->delivery_expect_end_date));?> "/>
                              <input type="text" class="form-control form-control-sm" id="req_delivery_date_label" name="req_delivery_date_label"  placeholder="mm/dd/yy" value="<?php echo date('m/d/Y',strtotime($edit_data->delivery_expect_start_date))." - ".date('m/d/Y',strtotime($edit_data->delivery_expect_end_date));?>"/>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="delivery_date" class="col-sm-4 col-form-label">Delivery Date </label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="delivery_date" name="delivery_date"  value="<?php echo date('Y-m-d',strtotime(@$edit_data->delivery_date))?>"    />
                           </div>
                        </div>
                        <div class="row">
                           <label for="supply_address" class="col-sm-4 col-form-label">Place of Supply</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="supply_address" name="supply_address" value="<?php echo  @$edit_data->supply_address?>">
                           </div>
                        </div>
                        <div class="row">
                           <label for="vehicle_no" class="col-sm-4 col-form-label">Vehicle No.</label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" id="vehicle_no" name="vehicle_no" placeholder="Vehicle No"  value="<?php echo  @$edit_data->vehicle_no?>" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="agent_id" class="col-sm-4 col-form-label">Agent Name</label>
                           <div class="col-sm-8">
                              <select class=" form-control form-control-sm " id="agent_id" name="agent_id" aria-label="Floating label select example"  readonly >
                                 <?php
                                    if(!empty($all_agents))
                                    {
                                        foreach ($all_agents as $all_agent) {
                                            ?>
                                 <option value="<?php echo $all_agent->id;?>" <?php if(isset($edit_data->agent_id) && $edit_data->agent_id ==$all_agent->id){ echo "selected";}?>><?php echo ( ($all_agent->id)?$all_agent->id:'')." ".$all_agent->title;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                                    
                              </select>
                           </div>
                        </div>
                        <div class="row">
                           <label for="crates" class="col-sm-4 col-form-label">Crates</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="crates"  name="crates"   value="<?php echo  @$edit_data->crates?>"  >
                           </div>
                        </div>
                        <div class="row">
                           <label for="bank_trans_id" class="col-sm-4 col-form-label">Bank Trxn Id</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="bank_trans_id"  name="bank_trans_id"  value="<?php echo  @$edit_data->bank_trans_id?>">
                           </div>
                        </div>
                        <div class="row">
                           <label for="contract" class="col-sm-4 col-form-label">Contract</label>
                           <div class="col-sm-8">
                              <select class="form-control form-control-sm " id="contract" name="contract" aria-label="Floating label select example" >
                                 <?php
                                    if(!empty($contracts_status))
                                    {
                                        foreach ($contracts_status as $contract_status) {
                                            ?>
                                 <option value="<?php echo $contract_status->slug;?>" <?php if(isset($edit_data->contract) && $edit_data->contract ==$contract_status->slug){ echo "selected";}?> ><?php echo $contract_status->title;?></option>
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
                           <label for="productive_plants" class="col-sm-4 col-form-label">Productive Plants</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="productive_plants" name="productive_plants" value="<?php echo  @$edit_data->productive_plants?>">
                           </div>
                        </div>
                        <div class="row">
                           <label for="driver_name" class="col-sm-4 col-form-label">Driver Name</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="driver_name" name="driver_name" value="<?php echo  @$edit_data->driver_name?>">
                           </div>
                        </div>
                        <?php
                           if($edit_data->booking_status=='cancelled')
                           {
                              ?>
                        <div class="row">
                           <label for="crop_status" class="col-sm-4 col-form-label">Cancel Date</label>
                           <div class="col-sm-8">
                              <p class="text-danger"><?php echo date('d M Y',strtotime($edit_data->cancellation_date));?></p>
                           </div>
                        </div>
                        <?php
                           }
                           ?><?php
                           if($edit_data->booking_status=='cancelled')
                           {
                              ?>
                        <div class="row">
                           <label for="crop_status" class="col-sm-4 col-form-label">Cancellation Reason </label>
                           <div class="col-sm-8">
                              <p class="text-danger"><?php echo $edit_data->cancellation_reason;?></p>
                           </div>
                        </div>
                        <?php
                           }
                           ?>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="card">
                           <h5 class="card-header bg-success text-white border-bottom p-1">Billing address </h5>
                           <div class="card-body p-1">
                              <textarea name="billing_address" class="form-control form-control-sm" id="billing_address" cols="50"><?php echo  @$edit_data->billing_address?></textarea>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="card">
                           <h5 class="card-header bg-success text-white border-bottom p-1">Delivery Address 
                              <input type="checkbox" name="same_billing" id="same_billing" value="yes" <?php 
                                 if(isset($edit_data->same_billing) && $edit_data->same_billing=='yes'){
                                 
                                     $deliver_address = @$edit_data->billing_address;
                                     echo 'checked';
                                     $delivery_address_readonly = 'readonly';
                                 }else{
                                     $deliver_address = @$edit_data->delivery_address;
                                 
                                     $delivery_address_readonly = '';
                                 }
                                 ?>> <small>Same as billing</small>
                           </h5>
                           <div class="card-body p-1">
                              <textarea name="delivery_address" <?php echo $delivery_address_readonly;?> class="form-control form-control-sm" id="delivery_address" cols="50"><?php echo  @ $deliver_address;?></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="table table-responsive">
                           <table class="table align-middle table-nowrap mb-0">
                              <thead class="table-light" >
                                 <tr>
                                    <th class="align-middle bg-success text-white" style="width: 350px;">Crop (Product)<span class="text-danger">*</span></th>
                                    <th class="align-middle bg-success text-white" >UOM</th>
                                    <th class="align-middle bg-success text-white" >Rate</th>
                                    <th class="align-middle bg-success text-white" >Quantity</th>
                                    <th class="align-middle bg-success text-white" >CGST</th>
                                    <th class="align-middle bg-success text-white" >SGST</th>
                                    <th class="align-middle bg-success text-white" >IGST</th>
                                    <th class="align-middle bg-success text-white" >Discount</th>
                                    <th class="align-middle bg-success text-white" >Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr style="height: 200px;vertical-align: top;">
                                    <td>
                                       <select class="form-control form-control-sm select2" id="product_id" name="product_id" aria-label="Floating label select example"  required >
                                          <option value="" selected>Choose Product</option>
                                          <?php
                                             if(!empty($all_products))
                                             {
                                                 foreach ($all_products as $all_product) {
                                                     ?>
                                          <option value="<?php echo $all_product->id;?>" <?php if(isset($edit_data->product_id) && $edit_data->product_id == $all_product->id){ echo "selected"; } ?> ><?php echo $all_product->title;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>
                                    </td>
                                    <td>
                                       <input type="text" class="form-control form-control-sm" id="uom" name="uom" readonly value="<?php echo  @$edit_data->uom?>">
                                    </td>
                                    <td>
                                       <input type="text" class="form-control form-control-sm" id="price" name="price" value="<?php echo  @$edit_data->price?>" >
                                    </td>
                                    <td>
                                       <input type="text" class="form-control form-control-sm" id="quantity" name="quantity"  value="<?php echo  @$edit_data->quantity?>">
                                    </td>
                                    <td>
                                       <span id="cgst"><?php echo  number_format(($edit_data->cgst_amount+0),2)?> (<?php echo  @($edit_data->cgst_rate+0)?>%)</span>
                                       <br>
                                       <input type="hidden" name="cgst_rate" id="cgst_rate" value="<?php echo  @($edit_data->cgst_rate+0)?>">
                                       <br>
                                       <input type="hidden" name="cgst_amount" id="cgst_amount" value="<?php echo  @($edit_data->cgst_amount+0)?>">
                                    </td>
                                    <td>
                                       <span id="sgst"><?php echo  number_format(($edit_data->sgst_amount+0),2)?> (<?php echo  @($edit_data->sgst_rate+0)?>%)</span>
                                       <br>
                                       <input type="hidden" name="sgst_rate" id="sgst_rate" value="<?php echo  @($edit_data->sgst_rate+0)?>">
                                       <br>
                                       <input type="hidden" name="sgst_amount" id="sgst_amount" value="<?php echo  @($edit_data->sgst_amount+0)?>">
                                    </td>
                                    <td>
                                       <span id="igst"><?php echo  number_format(($edit_data->igst_amount+0),2)?> (<?php echo  @($edit_data->igst_rate)?>%)</span>
                                       <br>
                                       <input type="hidden" name="igst_rate" id="igst_rate" value="<?php echo  @($edit_data->igst_rate+0)?>">
                                       <br>
                                       <input type="hidden" name="igst_amount" id="igst_amount" value="<?php echo  @($edit_data->igst_amount+0)?>">
                                    </td>
                                    <td>
                                       <input type="text" class="form-control form-control-sm" id="discount" name="discount" value="<?php echo  @($edit_data->discount+0)?>">
                                    </td>
                                    <td>
                                       <div class="totalCart"><?php echo  @($edit_data->total+0)?></div>
                                    </td>
                                 </tr>
                              </tbody>
                              <tfoot class="table-light">
                                 <tr>
                                    <td colspan="7"></td>
                                    <td>
                                       <div class="pull-right">Total</div>
                                    </td>
                                    <td><span class="totalCart"><?php echo  @($edit_data->total+0)?></span>
                                       <input type="hidden" name="total" id="total" value="<?php echo  @($edit_data->total+0)?>">
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="7"></td>
                                    <td>
                                       <div class="pull-right">Total Paid </div>
                                    </td>
                                    <td><span class="advance"><?php echo  @($edit_data->total_paid_amount+0)?></span></td>
                                 </tr>
                                 <tr>
                                    <td colspan="7"></td>
                                    <?php
                                       /*$total = $edit_data->total;
                                       $advance = $edit_data->total_paid_amount;
                                       $pending_balance = $total-$advance;*/
                                       
                                       /* print_r($edit_data);*/
                                       $pending_balance =  $edit_data->outstanding_amount;
                                       ?>
                                    <td>
                                       <div class="pull-right text-danger">Pending Balance</div>
                                    </td>
                                    <td><span class="text-danger pendingBill"><?php echo $pending_balance;?></span></td>
                                 </tr>
                                 <?php 
                                    if($edit_data->refunded_amount>0){
                                       ?>
                                 <tr>
                                    <td colspan="7"></td>
                                    <?php
                                       $refunded_amount = $edit_data->refunded_amount;
                                       ?>
                                    <td>
                                       <div class="pull-right text-danger">Refunded Amount</div>
                                    </td>
                                    <td><span class="  text-danger"><?php echo @$refunded_amount;?></span></td>
                                 </tr>
                                 <?php
                                    }
                                    ?>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="row">
                     <div class="col-sm-3">
                        <div class="row">
                                 <label for="advance" class="col-sm-4 col-form-label">Advance</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="advance" name="advance" value="<?php echo  @($edit_data->advance+0)?>">
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          <div class="row">
                                 <label for="create_date" class="col-sm-4 col-form-label">Payment Date</label>
                                 <div class="col-sm-8">
                                    <input type="date" class="form-control form-control-sm" id="create_date" name="create_date" value="<?php echo date('Y-m-d',strtotime(@$edit_data->create_date))?>" >
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          <div class="row">
                                 <label for="balance" class="col-sm-4 col-form-label">Balance</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="balance" name="balance" readonly value="<?php echo  @$edit_data->balance?>" >
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          <div class="row">
                                 <label for="payment_mode" class="col-sm-4 col-form-label">Payment Mode</label>
                                 <div class="col-sm-8">
                                      <select class="form-control form-control-sm" id="payment_mode" name="payment_mode" aria-label="Floating label select example" >
                                        
                                       <?php
                        if(!empty($payments_mode))
                        {
                            foreach ($payments_mode as $payment_mode) {
                                ?>
                                       <option value="<?php echo $payment_mode->slug;?>" <?php if(isset($edit_data->payment_mode) && $edit_data->payment_mode ==$payment_mode->slug){ echo "selected";}?>   ><?php echo $payment_mode->title;?></option>
                                       <?php
                        }
                        }
                        ?>
                                    </select>
                                 </div>
                              </div>
                     </div>
                     </div> -->
                  <!--    <div class="row cheque-field" <?php if($edit_data->payment_mode=='cheque'){ }else{ ?>style="display: none;"<?php } ?> >
                     <div class="col-sm-3">
                        <div class="row">
                                 <label for="cheque_no" class="col-sm-4 col-form-label">Chq No</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no" value="<?php echo  @$edit_data->cheque_no?>">
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          <div class="row">
                                 <label for="bank_name" class="col-sm-4 col-form-label">Bank</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name" value="<?php echo  @$edit_data->bank_name?>">
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          <div class="row">
                                 <label for="bank_branch" class="col-sm-4 col-form-label">Branch</label>
                                 <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="bank_branch" name="bank_branch"  value="<?php echo  @$edit_data->bank_branch?>" >
                                 </div>
                              </div>
                     </div>
                     <div class="col-sm-3">
                          
                     </div>
                     </div> -->
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                           <div class="card-body p-0">
                              <input type="hidden" name="id" value="<?php if(isset($edit_data->id)){echo $edit_data->id;} ?>"/>
                              <input id="pending_bill" name="pending_bill" type="hidden" value="0">
                              <input id="gst" name="gst" type="hidden"  value="<?php if(isset($edit_data->tax_rate)){echo $edit_data->tax_rate;} ?>" >
                              <button type="submit" class="  btn-sm  btn btn-primary w-md">Save Details</button>
                              <a class="btn btn-info btn-sm mr-2" target="_blank" href="<?php echo base_url()?>admin/bookings/receipt/<?php echo $edit_data->id;?>"><i class="fa fa-file-invoice"></i> Receipt</a>
                              <a class="btn btn-warning btn-sm"   href="<?php echo base_url()?>admin/bookings"> Go Back</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="card">
               <div class="card-body">
                  <div class="row mb-2">
                     <div class="col-sm-2">
                        Payment Details
                     </div>
                     <div class="col-sm-10">
                        <div class="d-flex flex-wrap gap-2 float-end">
                           <div class="btn-group" role="group" aria-label="Basic example">
                              <a href="javascript:void(0);" class="btn btn-outline-success btn-sm paymentbtn addpayment" aria-current="page">Add Payment</a>
                              <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm paymentbtn addrefunc">Add Refund</a>
                           </div>
                        </div>
                     </div>
                  </div>

                  
                                 <?php
                                    /*echo "<pre>";
                                    print_r($payment_details);
                                    echo "</pre>";*/  
                                       if(!empty($payment_details))
                                       {

                                          ?>
                                             <div class="row">
                                                <div class="col-sm-12">
                                                   <div class="table table-responsive">
                                                      <table class="table table-responsive table-striped" style="min-height: 200px;">
                                                         <thead class="table-light" >
                                                            <tr class="p-0">
                                                               <th class="align-middle bg-success text-white p-1">Date</th>
                                                               <th class="align-middle bg-success text-white p-1">Type</th>
                                                               <th class="align-middle bg-success text-white p-1">Amount</th>
                                                               <th class="align-middle bg-success text-white p-1">Mode</th>
                                                               <th class="align-middle bg-success text-white p-1">Bank Trxn Id</th>
                                                               <th class="align-middle bg-success text-white p-1">Action</th>
                                                            </tr>
                                                         </thead>
                                                         <tbody>
                                          <?php
                                          foreach ($payment_details as $key => $value) 
                                          {
                                             $badged = 'bg-primary';
                                             if($value['payment_type']=='refund')
                                             {
                                    
                                             $badged = 'bg-danger';
                                             }else if($value['payment_type']=='cancellation-charge')
                                             {
                                    
                                                $badged = 'bg-warning';
                                             }
                                    
                                              ?>
                                 <tr>
                                    <td class="p-1"><?php echo  date('d M Y',strtotime($value['payment_date']))?></td>
                                    <td class="p-1"><span class="badge <?php echo $badged ?>"><?php echo $value['paynmenttype']?></span></td>
                                    <td class="p-1"><?php echo number_format($value['amount'],2)?></td>
                                    <td class="p-1"><?php echo $value['paynmentmode']?></td>
                                    <td class="p-1"><?php echo $value['bank_transaction_id']?></td>
                                    <td class="p-1">
                                       <div class="btn-group">
                                          <button class="btn btn-info dropdown-toggle btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="true">
                                          Action <i class="mdi mdi-chevron-down"></i>
                                          </button>
                                          <div class="dropdown-menu " data-popper-placement="bottom-start" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 30px);">
                                             <a class="dropdown-item editpayment" data-userid="<?php echo $value['id'] ?>" data-action_src="<?php echo base_url()?>admin/bookings/<?php echo $value['id'] ?>/edit_payment" href="javascript:void(0)"><i class="fa fa-pen" aria-hidden="true"></i> Edit Transaction</a>
                                             <a class="dropdown-item text-danger delete_booking_payment" data-action_src="<?php echo base_url()?>admin/bookings/<?php echo $value['id'] ?>/delete_payment/<?php echo $edit_data->id;?>" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i> Delete Transaction</a>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                                 <?php
                                    }
                                    ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                                    <?php
                                    }
                                    ?>
                             

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<!-- status update modal sample modal content -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addPaymentModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="add_booking_payment" method="post" id="add_booking_payment" action="<?php echo base_url();?>admin/bookings/<?php echo $edit_data->id;?>/add_payment">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="addPaymentModalLabel">Add Payment</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Payment Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="payment_create_date" id="payment_create_date" value="<?php echo date('Y-m-d');?>" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_amount" class="col-md-5 col-form-label">Amount</label>
                  <div class="col-md-7">
                     <input type="number" class="form-control-sm form-control payment_amount" name="payment_amount" id="payment_amount" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_bank_transaction_id" class="col-md-5 col-form-label">Bank Trxn Id</label>
                  <div class="col-md-7">
                     <input type="text" class="form-control-sm form-control payment_bank_transaction_id" name="payment_bank_transaction_id" id="payment_bank_transaction_id" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_mode" class="col-md-5 col-form-label">Payment Mode</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_mode" name="payment_mode" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_modes))
                           {
                                   foreach ($payments_modes as $payments_mode) {
                                       ?>
                        <option value="<?php echo $payments_mode->slug;?>"><?php echo $payments_mode->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="row cheque-field" style="display: none;" >
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="cheque_no" class="col-md-5 col-form-label">Chq No</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_name" class="col-md-5 col-form-label">Bank</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_branch" class="col-md-5 col-form-label">Branch</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_branch" name="bank_branch"   >
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
               <input type="hidden" id="custID"   name="custID" value="<?php echo @$edit_data->customer_id?>"  >
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="addRefundModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addRefundModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="add_booking_refund" method="post" id="add_booking_refund" action="<?php echo base_url();?>admin/bookings/<?php echo $edit_data->id;?>/add_refund">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="addRefundModalLabel">Add Refund</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Payment Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="payment_create_date" id="payment_create_date" value="<?php echo date('Y-m-d');?>" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_amount" class="col-md-5 col-form-label">Amount</label>
                  <div class="col-md-7">
                     <input type="number" class="form-control-sm form-control payment_amount" name="payment_amount" id="payment_amount" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_bank_transaction_id" class="col-md-5 col-form-label">Bank Trxn Id</label>
                  <div class="col-md-7">
                     <input type="text" class="form-control-sm form-control payment_bank_transaction_id" name="payment_bank_transaction_id" id="payment_bank_transaction_id" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_mode" class="col-md-5 col-form-label">Payment Mode</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_mode" name="payment_mode" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_modes))
                           {
                                   foreach ($payments_modes as $payments_mode) {
                                       ?>
                        <option value="<?php echo $payments_mode->slug;?>"><?php echo $payments_mode->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="row cheque-field" style="display: none;" >
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="cheque_no" class="col-md-5 col-form-label">Chq No</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_name" class="col-md-5 col-form-label">Bank</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_branch" class="col-md-5 col-form-label">Branch</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_branch" name="bank_branch"   >
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
               <input type="hidden" id="custID"   name="custID" value="<?php echo @$edit_data->customer_id?>"  >
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="editPaymentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editPaymentModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="edit_booking_payment" method="post" id="edit_booking_payment" action="<?php echo base_url();?>admin/bookings/<?php echo $edit_data->id;?>/edit_payment">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="editPaymentModalLabel">Edit Payment</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="payment_create_date" id="payment_create_date"  >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_type" class="col-md-5 col-form-label">Payment Type</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_type" name="payment_type" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_types))
                           {
                                   foreach ($payments_types as $payments_type) {
                                       ?>
                        <option value="<?php echo $payments_type->slug;?>"><?php echo $payments_type->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <label for="payment_amount" class="col-md-5 col-form-label">Amount</label>
                  <div class="col-md-7">
                     <input type="number" class="form-control-sm form-control payment_amount" name="payment_amount" id="payment_amount" >
                     <input type="hidden" class="form-control-sm form-control" name="x_payment_amount" id="x_payment_amount" >
                     <input type="hidden" class="form-control-sm form-control" name="id" id="id" >
                     <input type="hidden" class="form-control-sm form-control" name="booking_id" id="booking_id" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_bank_transaction_id" class="col-md-5 col-form-label">Bank Trxn Id</label>
                  <div class="col-md-7">
                     <input type="text" class="form-control-sm form-control payment_bank_transaction_id" name="payment_bank_transaction_id" id="payment_bank_transaction_id" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_mode" class="col-md-5 col-form-label">Payment Mode</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_mode" name="payment_mode" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_modes))
                           {
                                   foreach ($payments_modes as $payments_mode) {
                                       ?>
                        <option value="<?php echo $payments_mode->slug;?>"><?php echo $payments_mode->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="row cheque-field" style="display: none;" >
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="cheque_no" class="col-md-5 col-form-label">Chq No</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_name" class="col-md-5 col-form-label">Bank</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name">
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="row">
                        <label for="bank_branch" class="col-md-5 col-form-label">Branch</label>
                        <div class="col-md-7">
                           <input type="text" class="form-control form-control-sm" id="bank_branch" name="bank_branch"   >
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
               <input type="hidden" id="custID"   name="custID" value="<?php echo @$edit_data->customer_id?>"  >
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="cancelBookingModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="cancelBookingModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="cancel_booking" method="post" id="cancel_booking" action="<?php echo base_url();?>admin/bookings/<?php echo $edit_data->id;?>/cancel_status">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="cancelBookingLabel">Booking Cancellation</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label for="payment_create_date" class="col-md-5 col-form-label">Cancelation Date</label>
                  <div class="col-md-7">
                     <input type="date" class="form-control form-control-sm" name="payment_create_date" id="payment_create_date"  value="<?php echo date('Y-m-d');?>">
                  </div>
               </div>
               <div class="row hidden" hidden>
                  <label for="payment_type" class="col-md-5 col-form-label">Payment Type</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_type" name="payment_type" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_types))
                           {
                                   foreach ($payments_types as $payments_type) {
                                       ?>
                        <option value="<?php echo $payments_type->slug;?>" <?php if($payments_type->slug=='cancellation-charge'){ echo "selected";}?>><?php echo $payments_type->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <label for="payment_amount" class="col-md-5 col-form-label">Cancellation Reason</label>
                  <div class="col-md-7">
                     <input type="text" class="form-control-sm form-control" name="cancel_reason" id="cancel_reason" >
                  </div>
               </div>
               <div class="row">
                  <label for="payment_amount" class="col-md-5 col-form-label">Cancellation Charge</label>
                  <div class="col-md-7">
                     <input type="number" class="form-control-sm form-control" name="cancel_charges" id="cancel_charges" >
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
               <input type="hidden" id="booking_status"   name="booking_status"  >
               <input type="hidden" id="custID"   name="custID" value="<?php echo @$edit_data->customer_id?>"  >
               <input type="hidden" id="farmer_id"   name="farmer_id" value="<?php echo @$edit_data->farmer_id?>"  >
            </div>
         </div>
      </form>
   </div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/parsleyjs/parsley.min.js"></script>

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
   var deliveryStart = moment();
           var deliveryEnd = moment();
           var dateOptions = {
               autoUpdateInput: false,
               startDate: deliveryStart,
               endDate: deliveryEnd,
           };
            var dateFormat = 'MM/DD/YYYY';
           $('#req_delivery_date_label').daterangepicker(dateOptions);
           $('#req_delivery_date_label').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat));
               $('#req_delivery_date').val(picker.startDate.format('YYYY-MM-DD') + ':' + picker.endDate.format(
                   'YYYY-MM-DD'));
           });
           $('#req_delivery_date_label').on('cancel.daterangepicker', function(ev, picker) {
               $(this).val('');
           });
   
   
   
   
     var centerState  = <?php echo $company_data->state?>;
   
   
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
      
           $(".custom-validation").parsley();
          
            jQuery(document).on("click", ".side_modal", function(){
                var userId = $(this).data("userid");
                $("#addPaymentModalScrollable").modal('show');
                single_cutomer_call_detail(userId);
      
            });
            jQuery(document).on("click", ".editbtn", function(){
               var userId = $(this).data("userid"),
               hitURL = "<?php echo base_url() ?>admin/customer/edit/"+userId
               window.location.replace(hitURL);
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
                 currentRow.parents('tr').remove();
                 if(data.status = true) { alert("successfully deleted"); }
                 else if(data.status = false) { alert("deletion failed"); }
                 else { alert("Access denied..!"); }
               });
             }
       });
   
   
       });
       
</script>
<?php
   if(!empty($edit_data->id))
   {
     ?>
<script type="text/javascript">
   $(document).ready(function() {
   
    var state = parseInt(<?=$edit_data->state?>);
    var district = parseInt(<?=$edit_data->district?>);
    var city = parseInt(<?=$edit_data->city?>);
     
      
      stateChange(state, district);
      districtChange(district ,city);
   });
</script>
<?php
   }
   ?>
<script type="text/javascript">
   var table;
   
   
     
   
    $(document).ready(function() {
   
   
   
   
          jQuery("#add_booking_payment").on('submit',function(e){
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
                  
   
                  $('#addPaymentModal').modal('hide');
                  toastr.success(data.message);
                  window.location.reload(1);
                     
                     //window.location.reload(true);
   
                
                }else{
   
                  toastr.error(data.message);
   
                }
              });
           
        });
         jQuery("#add_booking_refund").on('submit',function(e){
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
                  
   
                  $('#addRefundModal').modal('hide');
                  toastr.success(data.message);
                  window.location.reload(1);
   
                }else{
   
                  toastr.error(data.message);
   
                }
              });
           
        });
   
         jQuery(".delete_booking_payment").on('click',function(e){
              
               
              
              var form = $(this);
              var hitURL = form.data('action_src');
             
                var make_confirm = confirm('Are You Sure Want To Delete !');
               if(make_confirm)
               {
                      show_loader();
           
                          jQuery.ajax({
                            type : "POST",
                            dataType : "json",
                            url : hitURL,
                            data : {} 
                          }).done(function(data){
                            hide_loader();
                            if(data.status==1)
                            {
                              toastr.success(data.message);
                              window.location.reload(1);
   
                            }else{
   
                              toastr.error(data.message);
   
                            }
                          });
               }
             
           
        });
   
   
   
        jQuery(document).on("click", ".addpayment", function(){
             $('#addPaymentModal').modal('show');
             $('.paymentbtn').removeClass('active');
             $('.addpayment').addClass('active');
        });
         jQuery(document).on("click", ".addrefunc", function(){
             $('#addRefundModal').modal('show');
             $('.paymentbtn').removeClass('active');
             $('.addrefunc').addClass('active');
        });
         jQuery(document).on("click", ".editpayment", function(){
   
   
   
            var userId  = $(this).data("userid");
           var form_action  = $(this).data('action_src');
           var hitURL = "<?php echo base_url() ?>admin/booking_payment/single/"+userId;
          show_loader();
   
          jQuery.ajax({
            type      : "POST",
            dataType  : "json",
            url       : hitURL,
            data      : { id : userId } 
          }).done(function(response){
            hide_loader();
   
            if(response)
            {
              var data = response;
              console.log(data);
              $('#edit_booking_payment').attr('action', form_action);
              $('#editPaymentModal').modal('show');
              var dated = data.payment_date;
                
              $('#editPaymentModal #payment_create_date').val(dated);
              $('#editPaymentModal #payment_type').val(data.payment_type);
              $('#editPaymentModal #payment_amount').val(data.amount);
              $('#editPaymentModal #x_payment_amount').val(data.amount);
              $('#editPaymentModal #payment_mode').val(data.payment_mode);
              $('#editPaymentModal #id').val(data.id);
              $('#editPaymentModal #booking_id').val(data.booking_id);
               
   
            }
          });
   
   
   
              
             
              
        });
   
   
          jQuery("#edit_booking_payment").on('submit',function(e){
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
                  
   
                  $('#editPaymentModal').modal('hide');
                     toastr.success(data.message);
                     window.location.reload(true);
   
                
                }else{
   
                  toastr.error(data.message);
   
                }
              });
           
        });
            jQuery("#cancel_booking").on('submit',function(e){
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
                  
   
                  $('#cancelBookingModal').modal('hide');
                     toastr.success(data.message);
                     window.location.reload(true);
   
                
                }else{
   
                  toastr.error(data.message);
   
                }
              });
           
        });
   
   
   
   
     
   
   
   
    $("#booking_status").change(function(){
   
      if($(this).val()=='cancelled')
      {
         $('#cancelBookingModal').modal('show');   
         $('#cancelBookingModal #booking_status').val($(this).val());   
            
      }
      
   });
    $("#product_id").change(function(){
        var product_id = $(this).val();
        if(product_id)
        {
                    hitURL = "<?php echo base_url() ?>admin/product/single/"+product_id;
   
          show_loader();
           $.ajax({
         type: 'GET',
         url: hitURL,
         data: {},
         dataType:'json',
         success: function (response) {
              hide_loader();
                if(response)
                {
                    var data = response;
                    $('#uom').val(data.usage_unit);
                    $('#price').val(data.price);
                    $('#quantity').val(1);
                    $('#gst').val(data.tax_rate);
                    
                    $('#discount').val(data.discount);
                     renderCart(centerState);
                }
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
       
        }
        
    
        
    });
    $("#search").on('click',function(){
        var customer_id = $("#customer_id").val();
        var mobile = $("#mobile").val();
        $('#contactid').val('');
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
                     console.log(data);
                    $('#customer_mobile').val(data.mobile);
                  $('#customer_alter_mobile').val(data.alt_mobile);
                  $('#customer_name').val(data.name);
                  $('#state').val(data.state_id);
                  $('#contactid').val(data.id);
                  $('#farmer_id').val(data.id);
                  $('#pincode').val(data.pincode);
                  $('#village').val(data.village);
                  $('#father_name').val(data.father_name);
                  var stateCode = data.state_id;
                  var districtCode = data.district_id;
                  var cityCode = data.city_id;
                  stateChange(stateCode,districtCode);
                  districtChange(districtCode,cityCode);
                  renderCart(centerState);
                     
                }else
                {
                   $('#contactid').val('');
                }
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
       
        }
        
    
        
    });
   
     $(".select2").select2();
    
     $('#booking_form #same_billing').on('change', function () {
   
       
        if ($(this).prop("checked") == true) {
            $('#delivery_address').val($('#billing_address').val());
            $('#delivery_address').attr('readonly', 'readonly');
        } else {
            $('#delivery_address').val('');
            $('#delivery_address').removeAttr('readonly');
        }
    });
   
   
   
   
     $('#quantity').on('change', function() {
             
            renderCart(centerState);
        });
        $('#discount').on('change', function() {
            renderCart(centerState);
        });
        $('#price').on('change', function() {
            renderCart(centerState);
        });
   
        $('#advance').on('change', function() {
            renderCart(centerState);
        });
        $('#add_booking_refund #payment_mode').on('change', function() {
            renderChequeField('#add_booking_refund');
        });
        $('#add_booking_payment #payment_mode').on('change', function() {
            renderChequeField('#add_booking_payment');
        });
        $('#edit_booking_payment #payment_mode').on('change', function() {
            renderChequeField('#edit_booking_payment');
        });
    
   });
    function salesCopyBillingToShipping(isSameBilling = false) {
    var billingAddress = $('#billing_address').val();
    if (isSameBilling) {
        $('#delivery_address').val(billingAddress);
        $('#delivery_address').attr('readonly', 'readonly');
    }
    $('#booking_form #same_billing').on('change', function () {
        if ($(this).prop("checked") == true) {
            $('#delivery_address').val($('#billing_address').val());
            $('#delivery_address').attr('readonly', 'readonly');
        } else {
            $('#delivery_address').val('');
            $('#delivery_address').removeAttr('readonly');
        }
    });
   }
   
   function renderChequeField(parent) {
    var paymentMode = $(parent+' #payment_mode').val();
    if (paymentMode == 'cheque') {
        $(parent+' .cheque-field').show();
    } else {
        $(parent+' .cheque-field').hide();
        $(parent+' #cheque_no').val('');
        $(parent+' #bank_name').val('');
        $(parent+' #bank_branch').val('');
   
    }
    if (paymentMode == 'cash') {
        $(parent+' .cash-field').show();
    } else {
        $(parent+' .cash-field').hide();
    }
    if (paymentMode == 'online-transfer') {
        $(parent+' .online-field').show();
    } else {
        $(parent+' .online-field').hide();
    }
    if (paymentMode == 'other') {
        $(parent+' .other-field').show();
    } else {
        $(parent+' .other-field').hide();
    }
   }
   
   
    function stateChange( state_code = 0, selected_district = 0) {
       
    var stateCode = state_code ? state_code : $('#state').val();
    var selectedDistrict = selected_district ? selected_district : $('#district').val();
    hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        success: function (response) {
           renderCart(centerState);
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
      console.log(district_code,selected_city);
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
   
   
   function getPercentOfNumberVal(number, percent, gst)
   {
   return (number * percent) / (100 + gst);
   }
   
   function getPercentOfNumber (number, percent) {
        
        return (number * percent) / (percent + 100);
    }
   
   function renderTax(centerState) {
    var quantity = Number($('#quantity').val());
    var gst = Number($('#gst').val());
    var state = Number($('#state').val());
    var price = Number($('#price').val());
   
    var cgst = 0;
    var sgst = 0;
    var igst = 0;
    var cgstVal = 0;
    var sgstVal = 0;
     /*alert(typeof(centerState));
    alert(typeof(state));*/ 
      
    console.log(centerState, state);
    if (centerState == state) {
        cgst = gst / 2;
        sgst = gst / 2;
        igst = 0;
        cgstVal =  getPercentOfNumberVal(price, cgst, gst);
        sgstVal =  getPercentOfNumberVal(price, sgst, gst);
    } else {
        cgst = 0;
        sgst = 0;
        igst = gst;
    }
   
    var igstVal = getPercentOfNumber(price, igst);
    var cgst_amount = (cgstVal * quantity).toFixed(2);
    var sgst_amount = (sgstVal * quantity).toFixed(2);
    var igst_amount = (igstVal * quantity).toFixed(2);
    $('#cgst').text(cgst_amount + ' (' + cgst + '%)');
    $('#sgst').text(sgst_amount + ' (' + sgst + '%)');
    $('#igst').text(igst_amount + ' (' + igst + '%)');
    $('#cgst_amount').val(cgst_amount);
    $('#sgst_amount').val(sgst_amount);
    $('#igst_amount').val(igst_amount);
   
   }
   
   
   function renderCart(centerState) {
     renderTax(centerState);
    var quantity = Number($('#quantity').val());
    var discount = Number($('#discount').val());
    var price = Number($('#price').val());
   
    // var totalCart = shoppingCart.itemTotal(price, cgst, sgst, igst, quantity, discount);
    var advance = Number($('.advance').text());
     var totalCart = (price * quantity) - discount;
/*    var pendingBill = Number($('.pendingBill').val());
*/   
    
    $('#total').val(totalCart.toFixed(2));
    $('.totalCart').text(totalCart.toFixed(2));
    var balance = (totalCart - advance);
    $('.pendingBill').text(balance.toFixed(2));
   
    
    $('#balance').val(Number(balance).toFixed(2)); 
   }
   renderCart(centerState);
   
   
   function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
         
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
   
   
</script>