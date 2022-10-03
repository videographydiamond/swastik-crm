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
      .remove-item img,.add-item img{width: 25px;}

</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <form   method="GET"  onsubmit="return false">
                  <div class="card-body  ">
                     <div class="row">
                        <div class="col-xl-6  col-md-12  col-md-12">
                           <div class="hstack gap-3">
                              <label for="customer_id" class="  text-right">Farmer&nbsp;ID:</label>
                              <input class="form-control form-control-sm  numberAndDot" id="customer_id" name="customer_id" type="text"  value="<?php echo @$edit_data->farmer_id?>"  >
                              <label for="mobile" class=" text-right">Mobile&nbsp;No.:</label>
                              <input class="form-control form-control-sm numberAndDot" id="mobile" name="mobile" type="text"    >
                              <label for="booking_no" class=" text-right numberAndDot ">Booking&nbsp;No.:</label>
                              <input class="form-control form-control-sm  " id="booking_no" name="booking_no" type="text"    >
                              <button type="button" class="btn btn-info btn-sm float-end" id="search"><i class="fa fa-search"></i></button>
                               
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <input name="form_type" type="hidden" value="search">
               </form>
            </div>
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
         </div>
      </div>
      <div class="col-xl-12">
         <div class="card">
            <h5 class="card-header bg-success text-white border-bottom p-1">Edit Sales Invoice </h5>
            <div class="card card-body">
               <form autocomplete="off" action="<?php echo base_url() ?>admin/sales/update" method="post" role="form" enctype="multipart/form-data" id="sales_form" class="sales_form custom-validation">
                  <div class="row">
                     <div class="col-sm-4">
                        <input type="hidden" name="farmer_id" id="farmer_id" value="<?php echo @$edit_data->farmer_id?>">
                        <input type="hidden" name="contactid" id="contactid" value="">
                        <input type="hidden" name="booking_id" id="booking_id">
                        <div class="row">
                           <label for="customer_mobile" class="col-sm-4 col-form-label">Reg Mob No<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" maxlength="12" class="form-control form-control-sm numberAndDot" id="customer_mobile"  name="customer_mobile" readonly placeholder="Customer Mobile*"  value="<?php echo @$edit_data->customer_mobile?>" required />
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_alter_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm numberAndDot" readonly id="customer_alter_mobile" placeholder="ALT Mobile" name="customer_alter_mobile" value="<?php echo @$edit_data->customer_alter_mobile?>"  >
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" readonly id="customer_name" name="customer_name"  value="<?php echo @$edit_data->customer_name?>" placeholder="Farmers Name*" required  />
                           </div>
                        </div>
                         
                        <div class="row">
                           <label for="booking_date" class="col-sm-4 col-form-label">Invoice Date</label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="booking_date" name="booking_date"  value="<?php echo @$edit_data->booking_date?>" />
                           </div>
                        </div>
                         

                     </div>
                     <div class="col-sm-4">
                        <div class="row">
                           <label for="state" class="col-sm-4 col-form-label"> State</label>
                           <div class="col-sm-8">
                              <select class=" form-control select2 " id="state" name="state" aria-label="Floating label select example"  >
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
                           </div>
                        </div>
                        <div class="row">
                           <label for="city" class="col-sm-4 col-form-label">District</label>
                           <div class="col-sm-8">
                              <select class=" form-control select2 " id="district" name="district" aria-label="Floating label select example" onchange="districtChange()">
                                 <option value="" selected>Choose District</option>
                                 
                              </select>
                               
                           </div>
                        </div>
                        <div class="row">
                           <label for="city" class="col-sm-4 col-form-label">Tehsil</label>
                           <div class="col-sm-8">
                              <select class=" form-control  select2 " id="city" name="city" aria-label="Floating label select example"  onchange="cityChange()">
                                 <option value="" selected>Choose Tehsil</option>
                                  
                              </select>
                               
                           </div>
                        </div>
                        <div class="row">
                           <label for="reverse_charge" class="col-sm-4 col-form-label">Reverse Charges</label>
                           <div class="col-sm-8">
                              <select class="form-control form-control-sm" name="reverse_charge"  id="reverse_charge" >
                                 <option value="no" <?php if(isset($edit_data->reverse_charge) && $edit_data->reverse_charge == 'no'){echo "selected";}?> >No</option>
                                 <option value="yes" <?php if(isset($edit_data->reverse_charge) && $edit_data->reverse_charge == 'yes'){echo "selected";}?> >Yes</option>
                              </select>
                           </div>
                        </div>
                         
                        <div class="row">
                           <label for="supply_date" class="col-sm-4 col-form-label">Date Of Supply</label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="supply_date" name="supply_date"  value="<?php echo @$edit_data->supply_date?>"  />
                           </div>
                        </div>
                         
                     </div>
                     <div class="col-sm-4">
                         
                        <div class="row">
                           <label for="supply_address" class="col-sm-4 col-form-label">Place of Supply</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="supply_address" name="supply_address"  value="<?php echo @$edit_data->supply_address?>"  />
                           </div>
                        </div>
                        <div class="row">
                           <label for="vehicle_no" class="col-sm-4 col-form-label">Vehicle No.</label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" id="vehicle_no" name="vehicle_no" placeholder="Vehicle No"  value="<?php echo @$edit_data->vehicle_no?>"  />
                           </div>
                        </div>
                        <div class="row">
                           <label for="agent_id" class="col-sm-4 col-form-label">Transportation</label>
                           <div class="col-sm-8">
                              <select class="form-control form-control-sm" id="transportation" name="transport_type">
                                 <option value="road" <?php if(isset($edit_data->transport_type) && $edit_data->transport_type == 'road'){echo "selected";}?> >By Road</option>
                                 <option value="air" <?php if(isset($edit_data->transport_type) && $edit_data->transport_type == 'air'){echo "selected";}?> >By Air</option>
                                 <option value="train" <?php if(isset($edit_data->transport_type) && $edit_data->transport_type == 'train'){echo "selected";}?>  >By Train</option>
                                 <option value="post" <?php if(isset($edit_data->transport_type) && $edit_data->transport_type == 'post'){echo "selected";}?>  >By Post</option>
                                 <option value="online" <?php if(isset($edit_data->transport_type) && $edit_data->transport_type == 'online'){echo "selected";}?> >Online</option>
                              </select>

                               
                           </div>
                        </div>
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
                              <input type="checkbox" name="same_billing" id="same_billing" value="yes"
                                 <?php 
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
                              <textarea name="delivery_address" <?php echo $delivery_address_readonly;?>  class="form-control form-control-sm" id="delivery_address" cols="50"><?php echo  @ $deliver_address;?></textarea>
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
                                    <th class="align-middle bg-success text-white" >Action</th>
                                 </tr>
                              </thead>
                              <tbody id="card_body" class="cart-body">
                                 <tr  >
                                    <td>
                                        
                                       <select class="form-control form-control-sm select2" id="product" name="product" aria-label="Floating label select example"  required >
                                          <option value="" selected>Choose Product</option>
                                          <?php
                                             $prodct = array();
                                             if(!empty($all_products))
                                             {

                                                      


                                                 foreach ($all_products as $all_product) 
                                                 {
                                                  
                                                    $prodct[$all_product->id]= $all_product->title; 
                                                     
                                                     ?>
                                          <option value="<?php echo $all_product->id;?>" ><?php echo $all_product->title;?></option>
                                          <?php
                                             }
                                             }
                                             ?>
                                       </select>


                                      
                                    </td>
                                    <td>
                                       <input type="text" class="form-control form-control-sm" id="uom" name="uom" readonly>
                                    </td>
                                    <td>
                                       <input type="number" class="form-control form-control-sm" id="price" name="price" >
                                    </td>
                                    <td>
                                       <input type="number" class="form-control form-control-sm" id="quantity" name="quantity"  >
                                    </td>
                                    <td>
                                       <span id="cgst">0.00 (0%)</span>
                                       <br>
                                       <input type="hidden" name="cgst_rate" id="cgst_rate" value="0">
                                       <br>
                                       <input type="hidden" name="cgst_amount" id="cgst_amount" value="0">
                                    </td>
                                    <td>
                                       <span id="sgst">0.00 (0%)</span>
                                       <br>
                                       <input type="hidden" name="sgst_rate" id="sgst_rate" value="0">
                                       <br>
                                       <input type="hidden" name="sgst_amount" id="sgst_amount" value="0">
                                    </td>
                                    <td>
                                       <span id="igst">0.00 (0%)</span>
                                       <br>
                                       <input type="hidden" name="igst_rate" id="igst_rate" value="0">
                                       <br>
                                       <input type="hidden" name="igst_amount" id="igst_amount" value="0">
                                    </td>
                                    <td>
                                       <input type="number" class="form-control form-control-sm" id="discount" name="discount" >
                                    </td>
                                    <td>
                                       <div class="totalCart">0.00</div>
                                    </td>
                                    <td>
                                        action
                                    </td>
                                 </tr>
                              </tbody>
                              <tfoot class="table-light">
                                 <tr>
                                    <td colspan="7"></td>
                                    <td>
                                       <div class="pull-right">Total</div>
                                    </td>
                                    <td>
                                       <span class="totalCart">00</span>
                                       <input type="hidden" name="total" id="total" value="0">
                                    </td>
                                    <td>
                                        
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="7"></td>
                                    <td>
                                       <div class="pull-right">Total Paid </div>
                                    </td>
                                    <td>
                                          <input hidden type="text" class=" numberAndDot form-control form-control-sm" id="advance" name="advance" readonly value="<?php echo  @($edit_data->total_paid_amount+0)?>" >

                                       <span   class="advance" id="total_paid"><?php echo  @($edit_data->total_paid_amount+0)?></span></td>
                                    <td>
                                        
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="7"></td>
                                    <?php
                                      
                                       $pending_balance =  $edit_data->outstanding_amount;
                                       ?>
                                    <td>
                                       <div class="pull-right text-danger">Pending Balance</div>
                                    </td>
                                    <td><span class="text-danger pendingBill" id="pending_amount"><?php echo $pending_balance;?></span></td>
                                    <td>
                                        
                                    </td>
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
                                    <td>
                                        
                                    </td>
                                 </tr>
                                 <?php
                                    }
                                    ?>
                              </tfoot>
                           </table>
                              

                        </div>
                     </div>
                  </div>
                    
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="comment" class="col-form-label">Comment</label>
                         
                         <textarea class="form-control form-control-sm" name="comment" id="comment"><?php echo @$edit_data->comment?></textarea>
                         
                     </div>
                     <div class="col-sm-6">
                        <label for="trans_desctription" class="col-form-label">Transaction Description</label>
                         
                         <textarea class="form-control form-control-sm" name="trans_desctription" id="trans_desctription"><?php echo @$edit_data->trans_desctription?></textarea>
                         
                     </div>
                      
                  </div>
                  <br>
                  <div class="row" hidden   >
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="balance" class="col-sm-4 col-form-label">Balance</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="balance" name="balance" readonly >
                           </div>
                        </div>
                     </div>
                      
                  </div>
                   
                  <div class="row justify-content-end">
                     <div class="col-sm-3">
                        <div class=" ">
                           <div class="  ">
                              <input id="pending_bill" name="pending_bill" type="hidden" value="0">
                              <a  href="<?php echo base_url()?>admin/sales" class="btn my-primary w-md  btn-sm ">Cancel</a>
                              <a  href="<?php echo base_url()?>admin/sales/invoice/<?php echo $edit_data->id;?>" class="btn my-primary btn-sm mr-2  "> Generate Invoice</a>
                              
                              <button type="submit" class="btn btn-info btn-sm w-md  mr-1">Save Details</button>
                              <input type="hidden" name="sale_id" value="<?php if(isset($edit_data->id)){echo $edit_data->id;} ?>"/>
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
                                             <a class="dropdown-item editpayment" data-userid="<?php echo $value['id'] ?>" data-action_src="<?php echo base_url()?>admin/sales/<?php echo $value['id'] ?>/edit_payment" href="javascript:void(0)"><i class="fa fa-pen" aria-hidden="true"></i> Edit Transaction</a>
                                             <a class="dropdown-item text-danger delete_booking_payment" data-action_src="<?php echo base_url()?>admin/sales/<?php echo $value['id'] ?>/delete_payment/<?php echo $edit_data->id;?>" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i> Delete Transaction</a>
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
      <form class="add_booking_payment" method="post" id="add_booking_payment" action="<?php echo base_url();?>admin/sales/<?php echo $edit_data->id;?>/add_payment">
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
      <form class="add_booking_refund" method="post" id="add_booking_refund" action="<?php echo base_url();?>admin/sales/<?php echo $edit_data->id;?>/add_refund">
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
               <input type="hidden" id="custID"   name="custID" value="<?php echo @$edit_data->farmer_id?>"  >
            </div>
         </div>
      </form>
   </div>
</div>
<div class="modal fade" id="editPaymentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editPaymentModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="edit_booking_payment" method="post" id="edit_booking_payment" action="<?php echo base_url();?>admin/sales/<?php echo $edit_data->id;?>/edit_payment">
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
      <form class="cancel_booking" method="post" id="cancel_booking" action="<?php echo base_url();?>admin/sales/<?php echo $edit_data->id;?>/cancel_status">
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
   function selectDropDown(items, value = '') {
       
    items = JSON.parse(items);

    var options = '<option value="">Choose One</option>';
    for (item in items) {

        var selected = (item == value) ? 'selected="selected"' : '';
        options += '<option ' + selected + ' value="' + item + '">' + items[item] + '</option>';
    }
    return options;
}
</script>
<script src="<?php echo base_url(); ?>assets/admin/js/sales-cart.js"></script>
<script type="text/javascript">
 
   var jsproduct           = '<?php echo json_encode($prodct)?>';
   var order_roduct_dtl    = '<?php echo json_encode($edit_order_dtail_data)?>';
   var addImg              = "<?php echo base_url()?>assets/admin/images/plus-button-icon.png";
   var removeImg           = "<?php echo base_url()?>assets/admin/images/cross-button-icon.png";
   var centerState         = '<?php echo $company_data->state?>';



shoppingCart.onOrderLoad(order_roduct_dtl,centerState);


shoppingCart.addImg = addImg;
shoppingCart.removeImg = removeImg;
shoppingCart.products = jsproduct;
shoppingCart.centerState = centerState;
//shoppingCart.addItemToCart(shoppingCart.addItem);
shoppingCart.displayCart();
 shoppingCart.outstanding();



   
   $('#card_body').on('change','.product', function() {
       var productId = this.value;
       var state = $("#state").val();
      if(productId.length >0  && state.length >0)
      {

         var row = $(this).data('row');
         shoppingCart.onProductChange('<?php echo base_url()?>admin/product/single/',productId,row,centerState);
         $(".select2").select2();     
      }else
      {
         if(state.length ==0)
         {
            toastr.error("Please State First.");
         }
      }
    
});
   //Add item in cart event
$('#card_body').on("click", ".add-item", function (event) {
      var row = $(this).data('row');
      var product = $("#product"+row).val();
        
      if(product.length >0)
      {
         shoppingCart.updateTax(centerState) ;    
         shoppingCart.addItem.row = row+1;    
         shoppingCart.addItemToCart(shoppingCart.addItem);
         shoppingCart.displayCart();
         $(".select2").select2();
      }else{
         toastr.error("Please Select One Items.");
      }
      

      
});
//Quantity change event
$('#card_body').on("change", ".quantity", function (event) {
      shoppingCart.updateTax(centerState) ;    
    var row = $(this).data('row');
    var rowField = $('.row-' + row);
    var pid = rowField.find('.pid'); 
    var quantity = $(this).val();
    shoppingCart.setCountForItem(row, quantity);
    shoppingCart.calculateCart(centerState,row);
    $(".select2").select2();
});
//Discount change event
$('#card_body').on("change", ".discount", function (event) {
   shoppingCart.updateTax(centerState) ;    
    var row = $(this).data('row');
    var rowField = $('.row-' + row);
    var discount = $(this).val();
    shoppingCart.setDiscountForItem(row, discount);
    shoppingCart.calculateCart(centerState,row);  
    $(".select2").select2();
});

//Price change event
$('#card_body').on("change", ".price", function (event) {
   shoppingCart.updateTax(centerState) ;    
    var row = $(this).data('row');
    var rowField = $('.row-' + row);
    var pid = rowField.find('.pid'); 
    var price = $(this).val();
    shoppingCart.setPriceForItem(row, price);
    shoppingCart.calculateCart(centerState,row);
    $(".select2").select2();
});
$('#advance, #shipping_charge').on('change', function() {
    shoppingCart.outstanding();
});
//Remove item from cart event
$('#card_body').on("click", ".remove-item", function (event) {

   if($(".product").length >1)
   {
        shoppingCart.updateTax(centerState) ;    
       var pid = $(this).data('pid'); 
       var row = $(this).data('row');
       shoppingCart.removeItemFromCart(pid);
       shoppingCart.displayCart();
       shoppingCart.calculateCart(centerState,row);
       $(".select2").select2();
   }else
   {
       toastr.error("You Can Not Remove Last Of Items !");
   }
 
    return false;
});
//update taxt rate on state change event
$('#sales_form').on("change", "#state", function (event) {
    
     var stateCode = $(this).val();
     if(stateCode.length >0)
     {

         hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode;
         
        $.ajax({
         
            type: 'GET',
            url: hitURL,
            data: {},
            beforeSend: function(){
               show_loader();
            },
            complete: function(){
               hide_loader();
            },
            success: function (response) {
               
               shoppingCart.updateTax(centerState) ; 
               shoppingCart.displayCart();
               $("#district").empty().append(response);
               $(".select2").select2();
             },
            error: function (request, status, error) {
               $("#district").empty();
            }
        });

     }
         

     
    return false;
});

 $('#sales_form #same_billing').on('change', function () {
   
       checkSameBilling();
        
    });


   
   
      

     var centerState  = <?php echo $company_data->state?>;
   
   
     
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
   
      $('.numberAndDot').keypress(function (event) {
            return isNumber(event, this)
        });
   
   
   
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
    
   $("#search").on('click',function(){
        var customer_id = $("#customer_id").val();
        var mobile = $("#mobile").val();
        $('#contactid').val('');
        $('#farmer_id').val('');



         var searchBtn = $(this);
         var booking_no = $('#booking_no').val();
         if(booking_no && booking_no !=''){
            bookingSearchForSale(searchBtn, "<?php echo base_url() ?>admin/sales/forsale");
         }else{
            customerSearchForSale(searchBtn,"<?php echo base_url() ?>admin/farmers/single");
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
   
   
   
   
     /*$('#quantity').on('change', function() {
             
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
        });*/
        $('#sales_form #payment_mode').on('change', function() {
            renderChequeField('#sales_form');
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

 function stateChange(state_code = '',selected_district = '') 
 {
          
              var stateCode = state_code ? state_code : $('#state').val();
              var selectedDistrict = selected_district ? selected_district : $('#district').val();
              hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
              $.ajax({
                  type: 'GET',
                  url: hitURL,
                  data: {},
                  success: function (response) {
                    var check_state = $('#state option:selected').text();
                   
                        shoppingCart.updateTax(centerState) ; 
                        shoppingCart.displayCart();
                      $("#district").empty().append(response);
                      $(".select2").select2();
                  },
                  error: function (request, status, error) {
                       
                       
                      
                      $("#district").empty();
                  }
              });
}

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
   
      function checkSameBilling()
   {
      
      if ($("#same_billing").prop("checked") == true) {
            $('#delivery_address').val($('#billing_address').val());
            $('#delivery_address').attr('readonly', 'readonly');
        } else {
            $('#delivery_address').val('');
            $('#delivery_address').removeAttr('readonly');
        }
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
   
   
   function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
         
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

     function customerSearchForSale(btn,url)
 {
      hitURL = url

      var customer_id   = $("#customer_id").val();
      var mobile        = $("#mobile").val();
   
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
   
                  $('#customer_mobile').val(data.mobile);
                  $('#customer_alter_mobile').val(data.alt_mobile);
                  $('#customer_name').val(data.name);
                  $('#state').val(data.state_id);
                  $('#contactid').val(data.id);
                  $('#farmer_id').val(data.id);
                  $('#pincode').val(data.pincode);
                  $('#billing_address').val(data.village);
                  checkSameBilling();
                  var stateCode = data.state_id;
                  var districtCode = data.district_id;
                  var cityCode = data.city_id;
                  stateChange(stateCode,districtCode);
                  districtChange(districtCode,cityCode);
                  //renderCart(centerState);
                     
                }else
                {
                   $('#contactid').val('');
                   $('#farmer_id').val('');
                }
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
 }
 function bookingSearchForSale(btn,url)
 {
      hitURL = url

      var booking_no = $('#booking_no').val();
   
          show_loader();
           $.ajax({
         type: 'GET',
         url: hitURL,
         data: {
          booking_no:booking_no
         },
         dataType:'json',
         success: function (response) {
              hide_loader();
                if(response)
                {
                    var data = response;
                  $("#customer_id").val(data.farmer_id);
                  $("#booking_id").val(data.id);
                   var productId = data.product_id
                  var price = data.price
                  var discount = data.discount
                  var quantity = data.quantity
                  var same_billing = data.same_billing
                  var row = 1;
                  var centerState  = '<?php echo $company_data->state?>';

                  if(same_billing=='yes')
                     {
                        $("#same_billing").prop("checked",true);
                     }
                  $('#advance').val(data.advance ? data.advance : '');
                  $('#create_date').val(response.create_date ? response.create_date : null);
                  $('#payment_mode').val(response.payment_mode ? response.payment_mode : '');

                  $('#cheque_no').val(response.cheque_no ? response.cheque_no : '');
                  $('#bank_name').val(response.bank_name ? response.bank_name : '');
                  $('#bank_branch').val(response.bank_name ? response.bank_name : '');
                  renderChequeField();
                  shoppingCart.onProductOfBookingChange('<?php echo base_url()?>admin/product/single/',productId,row,centerState,price,discount,quantity);
                  
                  $(".select2").select2();     


                  customerSearchForSale('searchBtn',"<?php echo base_url() ?>admin/farmers/single");
                  
                  //renderCart(centerState);
                     
                } 
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
          }
     });
 }

 function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
   

   
   
</script>