<style type="text/css">
   .invoice
   {
   background: #fff;
   border: 1px solid rgba(0,0,0,.125);
   position: relative;
   }
   tbody, td, tfoot, th, thead, tr {
   border: 1px solid #ccc;
   }     
   @media print {
   body * {
   visibility: hidden;
   }
   tbody, td, tfoot, th, thead, tr {
   border: 1px solid #ccc;
   }
   .cart-table th,
   .table th,
   .cart-table td,
   .table td {
   /* border-color: #000; */
   color: #000;
   padding: 2px;
   font-size: 10px;
   }
   .section-to-print,
   .section-to-print * {
   visibility: visible;
   }
   .section-to-print p
   {
   margin: 0;
   }
   .section-to-print {
   position: absolute;
   left: 0;
   top: 0;
   right: 0;
   }
   .row>* {
   position: unset;
   }
   strong,.text-muted{
   font-size: 11px;
   }
   a[href]:after {
   content: none !important;
   }
   }
   strong,.text-muted{
   font-size: 11px;
   }
   @media print {
   @page {
   margin-bottom: 0;
   }
   body {
   padding-top: 72px;
   padding-bottom: 72px ;
   }
   .productname
   {
   width: 400px;
   }
   }
   .productname
   {
   width: 400px;
   }
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-12">
            <div>
               <!-- /.card-header -->
               <div class="card-body " style='border: 1px solid #ccc; '>
                  <div id="booking_receipt" class="section-to-print">
                     <h3 class="mt-2 d d-print-block text-center"><?php echo (@$company_details['title']);?></h3>
                     <p class="mt-2 d d-print-block text-center"><?php echo (@$company_details['office_address']);?></p>
                     <h3 class="mt-2 d-print text-center">Booking Order Details</h3>
                     <div class="card">
                        <div class="card-body p-2">
                           <table class=""  style="width: 100%">
                              <tr>
                                 <td colspan="6">
                                    <h3 class="card-title">Order Details</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td> <strong>Booking Order No.</strong></td>
                                 <td>Booking&nbsp;Date</td>
                                 <td>Booking&nbsp;Status</td>
                                 <td>Req.&nbsp;Delivery&nbsp;Date</td>
                                 <td>Transportation&nbsp;by</td>
                                 <td>Vehicle&nbsp;No.</td>
                              </tr>
                              <tr>
                                 <td> <?php 
                                    $booking_number =  str_pad((@$receipt_dtl['id']), 8, '0', STR_PAD_LEFT);
                                    
                                    echo (@$booking_number);?></td>
                                 <td> <?php echo ($receipt_dtl['booking_date']=='0000-00-00' || $receipt_dtl['booking_date']==null)?'': date('d M Y',strtotime($receipt_dtl['booking_date'])); ?></td>
                                 <td><?php echo (@$receipt_dtl['booked_status']);?></td>
                                 <td><?php echo ($receipt_dtl['delivery_expect_start_date']=='0000-00-00' || $receipt_dtl['delivery_expect_start_date']==null)?'': date('d M Y',strtotime($receipt_dtl['delivery_expect_start_date'])); ?></td>
                                 <td> </td>
                                 <td><?php echo (@$receipt_dtl['vehicle_no']);?></td>
                              </tr>
                              <tr>
                                 <td><strong>Delivery&nbsp;Date</strong></td>
                                 <td><strong>Driver&nbsp;Name</strong></td>
                                 <td><strong>Agent&nbsp;Name</strong></td>
                                 <td><strong>Entered&nbsp;by</strong></td>
                                 <td><strong>Entry&nbsp;date&nbsp;and&nbsp;Time</strong></td>
                                 <td> </td>
                              </tr>
                              <tr>
                                 <td><?php echo ($receipt_dtl['delivery_date']=='0000-00-00' || $receipt_dtl['delivery_date']==null)?'': date('d M Y',strtotime($receipt_dtl['delivery_date'])); ?></td>
                                 <td><?php echo (@$receipt_dtl['driver_name']);?></td>
                                 <td><?php echo (@$receipt_dtl['executive']);?></td>
                                 <td><?php echo (@$receipt_dtl['createdby']);?></td>
                                 <td><?php echo date('d/m/Y h:i a',strtotime($receipt_dtl['date_at']));?></td>
                                 <td></td>
                              </tr>
                           </table>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-body p-2">
                           <table class=""  style="width: 100%">
                              <tr>
                                 <td colspan="6">
                                    <h3 class="card-title">Farmer Details</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="width: 20%;"> <strong>Farmer Id</strong></td>
                                 <td style="width: 20%;" > <strong>Farmer Name</strong></td>
                                 <?php
                                    $bill_address = '';
                                    /*if(isset($receipt_dtl['village']) && $receipt_dtl['village'] !=='')
                                    {
                                      $bill_address.= "Village - ".$receipt_dtl['village'].",";  
                                    }
                                     
                                    if(isset($receipt_dtl['city']) && $receipt_dtl['city'] !=='')
                                    {
                                         
                                          $bill_address.=" Tehsil - ".(($receipt_dtl['city']=='Other')?$receipt_dtl['other_city']:$receipt_dtl['city']).",";  
                                        
                                      
                                    }
                                    
                                    if(isset($receipt_dtl['district']) && $receipt_dtl['district'] !=='')
                                    {
                                       
                                          $bill_address.=" District - ".(($receipt_dtl['district']=='Other')?$receipt_dtl['other_district']:$receipt_dtl['district']).","; 
                                    } 
                                     
                                    if(isset($receipt_dtl['state']) && $receipt_dtl['state'] !=='')
                                    {
                                       
                                          $bill_address.=" State - ".(($receipt_dtl['state']=='Other')?$receipt_dtl['other_state']:$receipt_dtl['state']).","; 
                                    }
                                     
                                    if(isset($receipt_dtl['pincode']) && $receipt_dtl['pincode'] !=='')
                                    {
                                       
                                          $bill_address.=" Pincode - ".($receipt_dtl['pincode']).","; 
                                    }*/
                                    
                                    
                                    ?>
                                 <?php   
                                 $bill_address = @$receipt_dtl['billing_address'];
                                    if(@$receipt_dtl['same_billing']=='yes')
                                    {
                                        $shiping_addres = $bill_address;
                                    }else
                                    {
                                        $shiping_addres =  @$receipt_dtl['delivery_address'];
                                    }
                                    ?>
                                 <td colspan="2" style="width: 30%;"> <strong>Billing Address</strong></td>
                                 <td colspan="2" style="width: 30%;"> <strong>Delivery Address</strong></td>
                              </tr>
                              <tr>
                                 <td> <?php echo (@$receipt_dtl['farmer_id']);?></td>
                                 <td> <?php echo  @$receipt_dtl['customername']; ?></td>
                                 <td colspan="2" rowspan="3"><?php echo (@$bill_address);?></td>
                                 <td  colspan="2" rowspan="3"><?php  echo $shiping_addres; ?></td>
                              </tr>
                              <tr>
                                 <td><strong>Contact Details</strong></td>
                                 <td><strong> </strong></td>
                              </tr>
                              <tr>
                                 <td><?php echo  @$receipt_dtl['customermobile'];?></td>
                                 <td></td>
                              </tr>
                           </table>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-header p-2">
                           <h3 class="card-title">Product Details</h3>
                        </div>
                        <div class="card-body p-2">
                           <div class="overlay-wrapper item-data">
                              <table id="cart_table" class="cart-table w-100">
                                 <thead>
                                    <tr class="bg-success text-white">
                                       <th class="text-center productname">Crop (Product)</th>
                                       <th class="text-center" style="width: 100px;">UOM</th>
                                       <th class="text-center" style="width: 100px;">Rate</th>
                                       <th class="text-center" style="width: 100px;">Quantity</th>
                                       <th class="text-center" style="width: 100px;">CGST</th>
                                       <th class="text-center" style="width: 100px;">SGST</th>
                                       <th class="text-center" style="width: 100px;">IGST</th>
                                       <th class="text-center" style="width: 100px;">Discount</th>
                                       <th class="text-center" style="width: 100px;">Total</th>
                                    </tr>
                                 </thead>
                                 <tbody class="cart-body">
                                    <tr>
                                       <td>
                                          <div><?php echo @$receipt_dtl['productname'];?></div>
                                       </td>
                                       <td>
                                          <div><?php echo @$receipt_dtl['uom'];?></div>
                                       </td>
                                       <td class="text-right">
                                          <div><?php echo  number_format($receipt_dtl['price'],2);?></div>
                                       </td>
                                       <td>
                                          <div><?php echo @$receipt_dtl['quantity'];?></div>
                                       </td>
                                       <td class="text-right">
                                          <span id="cgst"><?php echo number_format($receipt_dtl['cgst_amount'],2);?></span>
                                       </td>
                                       <td class="text-right">
                                          <span id="sgst"><?php echo  number_format($receipt_dtl['sgst_amount'],2);?></span>
                                       </td>
                                       <td class="text-right">
                                          <span id="igst"><?php echo number_format($receipt_dtl['igst_amount'],2);?></span>
                                       </td>
                                       <td>
                                          <div><?php echo number_format($receipt_dtl['discount'],2);?></div>
                                       </td>
                                       <td class="text-right">
                                          <div class="totalCart">
                                             <?php echo number_format($receipt_dtl['total'],2);?>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                                 <tfoot>
                                    <tr>
                                       <td class="text-right" colspan="8">
                                          <div class="float-end">Total :</div>
                                       </td>
                                       <td class="text-right">
                                          <div class="totalCart">
                                             <?php echo number_format($receipt_dtl['total'],2);?>
                                          </div>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="text-right" colspan="8">
                                          <div class="float-end">Total Paid :</div>
                                       </td>
                                       <td class="text-right">
                                          <div class="paidAmount"><?php echo number_format($receipt_dtl['total_paid_amount'],2);?></div>
                                       </td>
                                    </tr>
                                    <tr class="text-danger">
                                       <td class="text-right" colspan="8">
                                          <div class="float-end">Pending Balance :</div>
                                       </td>
                                       <td class="text-right">
                                          <div id="pending_amount"><?php echo number_format($receipt_dtl['outstanding_amount'],2);?></div>
                                       </td>
                                    </tr>
                                    <?php 
                                        if($receipt_dtl['refunded_amount'] >0)
                                        {
                                            ?>
                                            <tr class="text-danger">
                                               <td class="text-right" colspan="8">
                                                  <div class="float-end">Refunded Amount :</div>
                                               </td>
                                               <td class="text-right">
                                                  <div id="pending_amount"><?php echo number_format($receipt_dtl['refunded_amount'],2);?></div>
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
                     <?php
                        if(!empty($payment_details))
                                       {
                                           ?>
                     <div class="card">
                        <div class="order-payments">
                           <div class="card-header p-2">
                              <h3 class="card-title" >Payment Details</h3>
                           </div>
                           <div class="card-body p-2">
                              <table class="table table-striped table-bordered table-sm">
                                 <thead>
                                    <tr class="bg-success text-white">
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Amount</th>
                                       <th>Mode</th>
                                       <th>Bank Trxn Id</th>
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
                                       <td><?php echo  date('d M Y',strtotime($value['payment_date']))?></td>
                                       <td><span class="badge <?php echo $badged ?>"><?php echo $value['paynmenttype']?></span></td>
                                       <td><?php echo number_format($value['amount'],2)?></td>
                                       <td><?php echo $value['paynmentmode']?></td>
                                       <td><?php echo $value['bank_transaction_id']?></td>
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
               <div class="card-footer clearfix pl-1 pb-1 mt-3">
                  <button type="button" id="print_receipt" class="btn btn-primary btn-sm mr-2"><i class="fas fa-print"></i>
                  Print</button>
                  <a class="btn btn-default btn-sm" href="<?php echo base_url()?>admin/bookings">Cancel</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script>
   $('#print_without_seal').on('click', function() {
       $('#print_without_seal').addClass('active');
       $('#print_with_seal').removeClass('active');
       $('.seal-img').addClass('hidden-print d-none');
       $('.seal-img').removeClass('d-print-block d-block');
   });
   $('#print_with_seal').on('click', function() {
       $('#print_with_seal').addClass('active');
       $('#print_without_seal').removeClass('active');
       $('.seal-img').removeClass('hidden-print d-none');
       $('.seal-img').addClass('d-print-block d-block');
   });
   $('#print_receipt').on('click', function() {
   
   
        window.print();
   });
   
    
</script>