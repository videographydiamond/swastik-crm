
<style type="text/css">

    .invoice
    {
            background: #fff;
            border: 1px solid rgba(0,0,0,.125);
            position: relative;
    }
    .col-md-12
    {
        padding: 0px;
    }
    .row {
      --bs-gutter-x: unset;
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
    .pl-2 {
        padding-left: 5px !important;
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
.pl-2 {
    padding-left: 5px !important;
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
                    <div class="col-sm-6"><p >Sales Invoice</p></div>
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
        <div class="card-body  " >
            <div id="booking_receipt" class="section-to-print invoice  p-4" style="max-width: 920px; border: 1px solid #ccc; ">
                <div class='' style="  border: 1px solid #ccc; ">
                    <div class="row">
                        <div class="col-md-12 text-center mt-5">
                            <h1 class="text-danger fw-bold"><?php echo strtoupper(@$company_details['title']);?></h1>
                            <p>
                                 <?php echo  @$company_details['office_address'];?>
                                <br>Phone: <?php echo  @$company_details['phone'];?>, Email: <?php echo  @$company_details['email'];?>, Website:
                                <?php echo  @$company_details['website'];?>
                                 <?php 
                                 if(!empty($company_details['social_url']))
                                 {
                                     $jsondecodes = json_decode($company_details['social_url']);
                                     if(!empty($jsondecodes))
                                     {
                                         foreach ($jsondecodes as $key  ) {
                                              echo $key->title." : "."<a target='_BLANK' href='".$key->url."'>".$key->url."</a>,";
                                         }
                                     }
                                 }
                                 ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <table class="w-100">
                                <tbody>
                                    <tr class="border-dark border-top border-bottom">
                                        <td class="pl-2" >GSTIN : <?php echo  @$company_details['gst_no'];?></td>
                                        <td  >TAX INVOICE</td>
                                        <td  >PAN:<?php echo  @$company_details['pan_no'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-12 pl-2">

                            <div style="max-width: 100%; margin-left:auto;margin-right:auto;">
                                <div class="row">
                                    <div class="col" style="border-right: 1px solid #ccc;">
                                        <div class="row">
                                            <div class="col-4 pl-2">Reverse Charges</div>
                                            <div class="col-8  "><?php echo ucwords($receipt_dtl['reverse_charge']);?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 pl-2">Invoice No</div>
                                            <div class="col-8  "><?php $booking_number =  str_pad((@$receipt_dtl['id']), 8, '0', STR_PAD_LEFT);?><?php echo $booking_number;?></div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-4 pl-2"  >Invoice Date</div>
                                            <div class="col-8  "><?php echo ($receipt_dtl['create_date']=='0000-00-00' || $receipt_dtl['create_date']==null)?'': date('d M Y',strtotime($receipt_dtl['create_date'])); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 pl-2"  >
                                                State
                                            </div>
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col"><?php echo ucwords($company_details['state']);?></div>
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">StateCode</div>
                                                            <div class="col"><div class="border border-secondary pl-2">
                                                                    <?php echo (@$company_details['statecode']);?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                          <div class="row">
                                            <div class="col-4 pl-2"  >Transportation</div>
                                            <div class="col-8">By <?php echo ucwords($receipt_dtl['transport_type']);?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 pl-2"  >Vehicle no</div>
                                            <div class="col-8"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 pl-2"  >Date of Supply</div>
                                            <div class="col-8"><?php echo ($receipt_dtl['supply_date']=='0000-00-00' || $receipt_dtl['supply_date']==null)?'': date('d M Y',strtotime($receipt_dtl['supply_date'])); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 pl-2"  >Place of Supply</div>
                                            <div class="col-8"><?php echo ucwords($receipt_dtl['supply_address']);?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="w-100">
                                <tbody>
                                    <tr class="border-dark border-top border-bottom">
                                        <td  class="w-50 text-center" >Details of Receiver (Billed To)</td>
                                        <td   class="w-50  text-center" >Details of Consignee (Shipped To)</td>
                                         
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div style="max-width: 100%; margin-left:auto;margin-right:auto;">
                                
                               
                                <div class="row" style="border-bottom: 1px solid #000;">
                                    <div class="col" style="border-right: 1px solid #000;">
                                        
                                         
                                        <div class="row p-1">
                                            <div class="col-2">Name</div>
                                            <div class="col-10"><?php echo  @$receipt_dtl['customer_name'];?></div>
                                            
                                            <div class="col-2"></div>
                                            <div class="col-10">
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
                                              <?php
                                                
                                                
                                                
                                                echo  $bill_address;
                                              ?>
                                             

                                                                                                 
                                            </div>
                                            <div class="col-2">Phone</div>
                                            <div class="col-10"><?php echo  @$receipt_dtl['customer_mobile'].",".@$receipt_dtl['customer_alter_mobile'];?></div>
                                            <div class="col-2">GSTIN No.</div>
                                            <div class="col-10">URP</div>
                                            <div class="col-2">State</div>
                                            <div class="col-10">
                                               <div class="row">
                                                    <div class="col">
                                                    <?php echo  @$receipt_dtl['state'];?>
                                                </div>
                                                <div class="col">StateCode</div>
                                                <div class="col">
                                                    <div class="border border-secondary">
                                                        <?php echo ($receipt_dtl['statecode']);?>
                                                    </div>
                                                     
                                                </div>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col"  >
                                        
                                         
                                        <div class="row p-1">
                                            <div class="col-2">Name</div>
                                            <div class="col-10"><?php echo  @$receipt_dtl['customer_name'];?></div>
                                            
                                            <div class="col-2"></div>
                                            <div class="col-10">
                                              <?php
                                                 
                                                echo  $shiping_addres;
                                              ?>
                                             

                                                                                                 
                                            </div>
                                            <div class="col-2">Phone</div>
                                            <div class="col-10"><?php echo  @$receipt_dtl['customer_mobile'].",".@$receipt_dtl['customer_alter_mobile'];?></div>
                                            <div class="col-2">GSTIN No.</div>
                                            <div class="col-10">URP</div>
                                            <div class="col-2">State</div>
                                            <div class="col-10">
                                               <div class="row">
                                                    <div class="col">
                                                    <?php echo  @$receipt_dtl['state'];?>
                                                </div>
                                                <div class="col">
                                                   StateCode
                                                </div>
                                                <div class="col">
                                                     <div class="border border-secondary">
                                                                <?php echo ($receipt_dtl['statecode']);?>
                                                            </div>
                                                    
                                                </div>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                     
                                </div>

                                <div class="row ">
                                    <div class="col-md-12">
                                        <p class="text-center"><strong>Product Details:</strong></p>
                                        <table class="w-100 mtable">
                                            <thead>
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Description of Goods </th>
                                                    <th>Qty</th>
                                                    <th>GST</th>
                                                    <th class="text-center">Rate</th>
                                                    <th class="text-center">Discount</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if(!empty($invoice_dtls))
                                                    {
                                                        $incvv = 1;
                                                        foreach($invoice_dtls as $invoice_dtl)
                                                        {
                                                            ?>
                                                              <tr>
                                                                    <td class="text-center" style="width: 50px;"><?php echo  $incvv; $incvv++; ?></td>
                                                                    <td class="pl-2">
                                                                        <?php echo $invoice_dtl['productname'];?></td>
                                                                    <td class="pl-2 text-right">
                                                                          <?php echo $invoice_dtl['quantity'];?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                          <?php echo $invoice_dtl['tax_amount'];?>
                                                                    </td>
                                                                    <td class="pl-2 text-right">
                                                                         <?php echo number_format($invoice_dtl['price'],2);?>
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
                                                 <tr>
                                                    <th colspan="3" class="pl-2 text-right"></th>
                                                    <th class="pl-2 text-right">
                                                        <?php echo number_format($receipt_dtl['gst_amount'],2);?> 
                                                    </th>
                                                    <th   class="pl-2 text-right"></th>
                                                    <th  class="pl-2 text-right">
                                                         <?php echo number_format($receipt_dtl['discount_amount'],2);?> 
                                                    </th>
                                                     <th   class="pl-2 text-right"></th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">Total</td>
                                                    <td class="pl-2 text-right">
                                                        <?php echo number_format($receipt_dtl['total'],2);?> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">GST</td>
                                                    <td class="pl-2 text-right">
                                                        <?php echo number_format($receipt_dtl['gst_amount'],2);?> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">Discount</td>
                                                    <td class="pl-2 text-right">
                                                        <span class="text-danger">-<?php echo number_format($receipt_dtl['discount_amount'],2);?> </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">Total</td>
                                                    <td class="pl-2 text-right">
                                                       <?php echo number_format($receipt_dtl['total'],2);?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">Amount Received </td>
                                                    <td class="pl-2 text-right"><?php echo number_format($receipt_dtl['total_paid_amount'],2);?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="pl-2 text-right">Outstanding Amount </td>
                                                    <td class="pl-2 text-right"><?php echo number_format($receipt_dtl['outstanding_amount'],2);?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-8">
                                       
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

