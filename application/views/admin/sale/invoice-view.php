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

    .pl-2 {
        padding-left: 5px !important;
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
                     <h3 class="mt-2 d-print text-center">Tax Invoice Details</h3>
                     <div class="card">
                        <div class="card-body p-2">
                           <table class=""  style="width: 100%">
                              <tr>
                                 <td colspan="6">
                                    <h3 class="card-title">Order Details</h3>
                                 </td>
                              </tr>
                              <tr>
                                 <td> <strong>Invoice No</strong></td>
                                 <td><strong>Invoice&nbsp;Date</strong></td>
                                 <td><strong>Reverse&nbsp;Charges</strong></td>
                                 <td><strong>State</strong></td>
                                 <td><strong>StateCode</strong></td>
                                 <td><strong>Transportation</strong></td>
                              </tr>
                              <tr>
                                 <td> <?php 
                                    $booking_number =  str_pad((@$receipt_dtl['id']), 8, '0', STR_PAD_LEFT);
                                    
                                    echo (@$booking_number);?></td>
                                 <td> <?php echo ($receipt_dtl['booking_date']=='0000-00-00' || $receipt_dtl['booking_date']==null)?'': date('d M Y',strtotime($receipt_dtl['booking_date'])); ?></td>
                                 <td><?php echo ucwords($receipt_dtl['reverse_charge']);?></td>
                                 <td><?php echo ucwords($company_details['state']);?> </td>
                                 <td> <?php echo (@$company_details['statecode']);?></td>
                                 <td> By <?php echo ucwords($receipt_dtl['transport_type']);?></td>
                              </tr>
                              <tr>
                                 <td><strong>Vehicle&nbsp;No.</strong></td>
                                 <td><strong>Date&nbsp;of&nbsp;Supply</strong></td>
                                 <td><strong>Place&nbsp;of&nbsp;Supply</strong></td>
                                  
                                 <td><strong>Entered&nbsp;by</strong></td>
                                 <td><strong>Entry&nbsp;date&nbsp;and&nbsp;Time</strong></td>
                                 <td></td>
                              </tr>
                              <tr>
                                 <td><?php echo (@$receipt_dtl['vehicle_no']);?></td>
                                
                                 <td><?php echo ($receipt_dtl['supply_date']=='0000-00-00' || $receipt_dtl['supply_date']==null)?'': date('d M Y',strtotime($receipt_dtl['supply_date'])); ?></td>
                                 <td><?php echo ucwords($receipt_dtl['supply_address']);?></td>
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
                                      $bill_address =$receipt_dtl['billing_address'] ;
                                    
                                     
                                    if(@$receipt_dtl['same_billing']=='yes')
                                    {
                                        $shiping_addres =$bill_address;
                                    }else
                                    {
                                        $shiping_addres =  @$receipt_dtl['delivery_address'];
                                    }
                                    ?>
                                 <td colspan="2" style="width: 30%;"> <strong>Details of Receiver (Billed To)</strong></td>
                                 <td colspan="2" style="width: 30%;"> <strong>Details of Consignee (Shipped To)</strong></td>
                              </tr>
                              <tr>
                                 <td> <?php echo (@$receipt_dtl['farmer_id']);?></td>
                                 <td> <?php echo  @$receipt_dtl['customer_name']; ?></td>
                                 <td colspan="2" rowspan="3">
                                    <?php //echo (@$bill_address);?>
                                        <div class="row p-1">
                                             
                                             <div class="col-12">
                                              <?php
                                               
                                                
                                                echo  $bill_address;
                                              ?>
                                             

                                                                                                 
                                            </div>
                                            <div class="row">
                                                <div class="col">State</div>
                                                <div class="col"><?php echo  @$receipt_dtl['state'];?></div>
                                            </div>
                                            <div class="row">
                                               <div class="col">StateCode</div>
                                                <div class="col">
                                                    <span class="border border-secondary">
                                                        <?php echo ($receipt_dtl['statecode']);?>
                                                    </span>
                                                     
                                                </div>
                                            </div>
                                            
                                        </div>


                                    </td>
                                 <td  colspan="2" rowspan="3">
                                    <?php  //echo $shiping_addres; ?>
                                       <div class="row p-1">
                                             
                                             <div class="col-12">
                                              <?php
                                              
                                                
                                                echo  $shiping_addres;
                                              ?>
                                             

                                                                                                 
                                            </div>
                                            <div class="row">
                                                <div class="col">State</div>
                                                <div class="col"><?php echo  @$receipt_dtl['state'];?></div>
                                            </div>
                                            <div class="row">
                                               <div class="col">StateCode</div>
                                                <div class="col">
                                                    <span class="border border-secondary">
                                                        <?php echo ($receipt_dtl['statecode']);?>
                                                    </span>
                                                     
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </td>
                              </tr>
                              <tr>
                                 <td><strong>Contact Details</strong></td>
                                 <td><strong> </strong></td>
                              </tr>
                              <tr>
                                 <td><?php echo  @$receipt_dtl['customer_mobile'].','.@$receipt_dtl['customer_alter_mobile'];?></td>
                                 <td></td>
                              </tr>
                              <tr>
                                 <td colspan="2"><strong>Comment</strong></td>
                                 <td colspan="4"><strong>Transaction Description</strong></td>
                              </tr>
                              <tr>
                                 <td colspan="2">&nbsp;<?php echo  @$receipt_dtl['comment']?></td>
                                 <td colspan="4"><?php echo  @$receipt_dtl['trans_desctription']?></td>
                                 
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
                                    
                                    <?php 
                                                    if(!empty($invoice_dtls))
                                                    {
                                                        $incvv = 1;
                                                        foreach($invoice_dtls as $invoice_dtl)
                                                        {
                                                            ?>
                                                              <tr>
                                                                     
                                                                    <td class="pl-2">
                                                                        <?php echo $invoice_dtl['productname'];?>
                                                                           
                                                                        </td>
                                                                        <td class="pl-2 text-right">
                                                                          <?php echo $invoice_dtl['uoms'];?>
                                                                    </td> 
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['price'],2);?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                          <?php echo $invoice_dtl['quantity'];?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['cgst_amount'],2);?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['sgst_amount'],2);?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['igst_amount'],2);?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['discount'],2);?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                       <?php echo number_format($invoice_dtl['sub_total_amount'],2);?> </td>
                                                                </tr>  
                                                            <?php
                                                        }
                                                    }
                                                ?>
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
                  <a class="btn btn-default btn-sm" href="<?php echo base_url()?>admin/sales">Cancel</a>
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