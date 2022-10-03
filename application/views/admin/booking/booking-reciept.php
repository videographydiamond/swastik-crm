
<style type="text/css">

    .invoice
    {
            background: #fff;
            border: 1px solid rgba(0,0,0,.125);
            position: relative;
    }

     

    @media print {
 
    

      body * {
        visibility: hidden;
    }

    .cart-table th,
    .table th,
    .cart-table td,
    .table td {
        /* border-color: #000; */
        color: #000;
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
 } 
  .mtable {
    width: 100%;
    margin-bottom: 0;
    color: #212529;
    background-color: transparent;
}

.mtable td,
.mtable th {
    padding: 0;
    border: 1px solid #212529;
}

.mtable .noborder td,
.mtable .noborder th {
    border: 0;
    padding: 0;
}


 
 @page  {
            size: auto;
            /* auto is the initial value */
            margin: 0;
            border: 1px solid #666;
        }

        @media  print {

            html,
            body,
            div,
            span,
            applet,
            object,
            iframe,
            p,
            blockquote,
            pre,
            a,
            abbr,
            acronym,
            address,
            big,
            cite,
            code,
            del,
            dfn,
            em,
            font,
            ins,
            kbd,
            q,
            s,
            samp,
            small,
            strike,
            strong,
            sub,
            sup,
            tt,
            var,
            dl,
            dt,
            dd,
            ol,
            ul,
            li,
            fieldset,
            form,
            label,
            legend,
            table,
            caption,
            tbody,
            tfoot,
            thead,
            tr,
            th,
            td {
                font-size: 14px !important;
            }

        }

</style>
<div class="page-content">
  <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12">
          
              


<div>
        <div class="card-header ">
             <div class="row ">
                    <div class="col-sm-6"><p >Booking Receipt</p></div>
                    <div class="col-sm-6">
                      <div class="d-flex flex-wrap gap-2 float-end">
                                                    

                          <div class="btn-group" role="group" aria-label="Basic example">
                              <a href="javascript:void(0);" class="btn btn-sm  btn-outline-primary active" id="print_with_seal" aria-current="page">With Seal</a>
                               <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="print_without_seal">Without Seal</a>
                          </div>
                      </div>
                    </div>
                    
                </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body " style='border: 1px solid #ccc; '>
            <div id="booking_receipt" class="section-to-print invoice " style="max-width: 920px;">
                <div>
                    <div class="row">
                        <div class="col-md-12 text-center mt-5">
                            <h1 class="text-danger fw-bold"><?php echo strtoupper(@$company_details['title']);?></h1>
                            <p>
                                 <?php echo  @$company_details['office_address'];?>
                                <br>Phone: <?php echo  @$company_details['phone'];?>, Email: <?php echo  @$company_details['email'];?>, Website:
                                <?php echo  @$company_details['website'];?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <table class="w-100">
                                <tbody><tr class="border-dark border-top border-bottom">
                                    <td style="width: 163px;"></td>
                                    <td style="width: 55px;">GSTIN :</td>
                                    <td style="width: 141px;"><?php echo  @$company_details['gst_no'];?></td>
                                    <td style="width: 127px;"></td>
                                    <td style="width: 36px;">PAN:</td>
                                    <td style="width: 200px;"><?php echo  @$company_details['pan_no'];?></td>
                                </tr>
                            </tbody></table>
                        </div>
                        <div class="col-md-12">
                            <div style="margin-top: 25px;margin-bottom:25px;" class="text-center">
                                <h2>RECEIPT</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="max-width: 90%; margin-left:auto;margin-right:auto;">
                                <div class="row">
                                    <div class="col">
                                        <?php
                                                     
                                                    $booking_number =  str_pad((@$receipt_dtl['id']), 8, '0', STR_PAD_LEFT);
                                        ?>
                                        <p>Booking No: <?php echo $booking_number;?></p>
                                    </div>
                                    <div class="col">
                                        
                                        <p class="text-right">Booking Date: <?php echo ($receipt_dtl['booking_date']=='0000-00-00' || $receipt_dtl['booking_date']==null)?'': date('d M Y',strtotime($receipt_dtl['booking_date'])); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col" style="border-right: 1px solid #ccc;">
                                        
                                        <p class="text-center"><strong>Billing Address</strong></p>
                                        <div class="row">
                                            <div class="col-2">Name</div>
                                            <div class="col-10"><?php echo  @$receipt_dtl['customername'];?></div>
                                            <div class="col-2">Address</div>
                                            <div class="col-10">
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
                                                
                                                 $bill_address = @$receipt_dtl['billing_address'];
                                                 if(@$receipt_dtl['same_billing']=='yes')
                                                {
                                                    $shiping_addres = $bill_address;
                                                }else
                                                {
                                                    $shiping_addres =  @$receipt_dtl['delivery_address'];
                                                }
                                                echo  $bill_address;
                                              ?>
                                             

                                                                                                 
                                            </div>
                                            <div class="col-2">Mobile</div>
                                            <div class="col-10"><?php echo $receipt_dtl['customermobile'];?></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="text-center"><strong>Delivery Address</strong></p>
                                        <div  >
                                            <div class="row">
                                                <div class="col-2">Name</div>
                                                <div class="col-10"><?php echo  @$receipt_dtl['customername'];?></div>
                                                <div class="col-2">Address</div>
                                                <div class="col-10">
                                                    <?php   echo  $shiping_addres;?>
                                                    
                                                </div>
                                                <div class="col-2">Mobile</div>
                                                <div class="col-10"><?php echo $receipt_dtl['customeraltmobile'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <p class="text-center"><strong>Booking Details:</strong></p>
                                        <table class="w-100 mtable">
                                            <tbody><tr>
                                                <th>S.No.</th>
                                                <th>Description of Goods </th>
                                                <th>Qty</th>
                                                <th class="text-center">Rate</th>
                                                <th>Total</th>
                                            </tr>
                                            <tr>
                                                <td class="text-center" style="width: 50px; padding-bottom:80px;">1</td>
                                                <td class="pl-2" style="padding-bottom:80px;">
                                                    <?php echo $receipt_dtl['productname'];?></td>
                                                <td class="pr-2 text-right" style="padding-bottom:80px;">
                                                      <?php echo $receipt_dtl['quantity'];?>
                                                </td>
                                                <td style="padding-bottom:80px;" class="pr-2 text-right">
                                                     <?php echo number_format($receipt_dtl['price'],2);?>
                                                </td>
                                                <td style="padding-bottom:80px;" class="pr-2 text-right">
                                                   <?php echo number_format(($receipt_dtl['price']*$receipt_dtl['quantity']),2);?>  </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="pr-2 text-right">Sub Total</td>
                                                <td class="pr-2 text-right">
                                                    <?php echo number_format(($receipt_dtl['price']*$receipt_dtl['quantity']),2);?> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="pr-2 text-right">Discount</td>
                                                <td class="pr-2 text-right">
                                                    <span class="text-danger">-<?php echo number_format($receipt_dtl['discount'],2);?> </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="pr-2 text-right">Total</td>
                                                <td class="pr-2 text-right">
                                                   <?php echo number_format($receipt_dtl['total'],2);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="pr-2 text-right">Amount Received </td>
                                                <td class="pr-2 text-right"><?php echo number_format($receipt_dtl['total_paid_amount'],2);?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="pr-2 text-right">Outstanding Amount </td>
                                                <td class="pr-2 text-right"><?php echo number_format($receipt_dtl['outstanding_amount'],2);?></td>
                                            </tr>
                                        </tbody></table>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-8">
                                        <ul class="mt-3">
                                            <?php 
                                                if(isset($receipt_dtl['delivery_expect_start_date']) && isset($receipt_dtl['delivery_expect_end_date']) && $receipt_dtl['delivery_expect_start_date'] !=='0000-00-00' && $receipt_dtl['delivery_expect_end_date'] !=='0000-00-00')
                                                {
                                                 ?>
                                                    <li>Delivery Date:  
                                                        <?php echo date('d M Y',strtotime($receipt_dtl['delivery_expect_start_date']));?>
                                                        To 
                                                        <?php echo date('d M Y',strtotime($receipt_dtl['delivery_expect_end_date']));?>
                                                    
                                                        </li>
                                                                                            <?php   
                                                }

                                                
                                            ?>
                                            


                                            
                                             <?php 
                                                if(!empty($receipt_dtl['paymentmodename'])){
                                                    ?><li> Mode of payment:  
                                                        <?php echo @$receipt_dtl['paymentmodename'];?>
                                                       </li> 
                                                    <?php
                                                } 
                                            ?> 
                                            <li>Outstanding amount must be cleared before 15 Days of Delivery</li>
                                            <li><strong>Bank Details:</strong><br> <strong>Bank:</strong> <?php echo  @$company_details['bank_name'];?><br>
                                                <strong>Account Number :</strong> <?php echo  @$company_details['bank_account_number'];?><br>
                                                <strong>Account Holder's name :</strong> <?php echo  @$company_details['bank_holder_name'];?><br>
                                                <strong>Ifsc Code :</strong> <?php echo  @$company_details['bank_ifsc_code'];?><br>
                                                <strong>Branch :</strong> <?php echo  @$company_details['bank_branch_address'];?>
                                            </li>
                                        </ul>
                                        <p class="mb-0"><strong>Cancellation &amp; Refund:</strong></p>
                                        <ol class="receipt-note">
                                            <li>5% of total amount will be deducted if booking cancelled before 15 days of
                                                delivery date</li>
                                            <li>No amount will be refunded if booking cancelled in last 15 days of delivery
                                                or
                                                Unable to take delivery or Not responded during delivery.</li>
                                        </ol>
                                    </div>
                                    <div class="col-4">
                                        <div class="seal-section" style="margin-top: 20px;">
                                            <div class="text-center float-right" style="width: 224px;">
                                                <div>For <?php echo strtoupper(@$company_details['title']);?></div>
                                                <div style="min-height: 130px">
                                                    <img class="seal-img d-print-block d-block" style="max-width: 206px;" src="<?php echo base_url()?>assets/admin/images/<?php echo @$company_details['seal_logo'];?>" alt="seal-logo">
                                                </div>
                                                <p style="margin-top: 20px;">Authorised Signatory</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

