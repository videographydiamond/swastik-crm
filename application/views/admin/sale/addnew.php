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
                              <input class="form-control form-control-sm  numberAndDot" id="customer_id" name="customer_id" type="text"   >
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
            <h5 class="card-header bg-success text-white border-bottom p-1">Add New Sales</h5>
            <div class="card card-body">
               <form autocomplete="off" action="<?php echo base_url() ?>admin/sales/insertnow" method="post" role="form" enctype="multipart/form-data" id="sales_form" class="sales_form custom-validation">
                  <div class="row">
                     <div class="col-sm-4">
                        <input type="hidden" name="farmer_id" id="farmer_id" value="">
                        <input type="hidden" name="contactid" id="contactid" value="">
                        <input type="hidden" name="booking_id" id="booking_id">
                        <div class="row">
                           <label for="customer_mobile" class="col-sm-4 col-form-label">Reg Mob No<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" maxlength="12" class="form-control form-control-sm numberAndDot" id="customer_mobile"  name="customer_mobile" readonly placeholder="Customer Mobile*"  value="" required />
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_alter_mobile" class="col-sm-4 col-form-label">ALT Mobile</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm numberAndDot" readonly id="customer_alter_mobile" placeholder="ALT Mobile" name="customer_alter_mobile" value=""  >
                           </div>
                        </div>
                        <div class="row">
                           <label for="customer_name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" readonly id="customer_name" name="customer_name" placeholder="Farmers Name*" required  />
                           </div>
                        </div>
                         
                        <div class="row">
                           <label for="booking_date" class="col-sm-4 col-form-label">Invoice Date</label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="booking_date" name="booking_date"  value="<?php echo date("Y-m-d");?>" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="bank_trans_id" class="col-sm-4 col-form-label">Bank Trxn Id</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="bank_trans_id"  name="bank_trans_id"  >
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
                                 <option value="no">No</option>
                                 <option value="yes">Yes</option>
                              </select>
                           </div>
                        </div>
                         
                        <div class="row">
                           <label for="supply_date" class="col-sm-4 col-form-label">Date Of Supply</label>
                           <div class="col-sm-8"> 
                              <input type="date" class="form-control form-control-sm" id="supply_date" name="supply_date"  value="<?php echo date("Y-m-d");?>" />
                           </div>
                        </div>
                         
                     </div>
                     <div class="col-sm-4">
                         
                        <div class="row">
                           <label for="supply_address" class="col-sm-4 col-form-label">Place of Supply</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="supply_address" name="supply_address">
                           </div>
                        </div>
                        <div class="row">
                           <label for="vehicle_no" class="col-sm-4 col-form-label">Vehicle No.</label>
                           <div class="col-sm-8"> 
                              <input type="text" class="form-control form-control-sm" id="vehicle_no" name="vehicle_no" placeholder="Vehicle No" value="" />
                           </div>
                        </div>
                        <div class="row">
                           <label for="agent_id" class="col-sm-4 col-form-label">Transportation</label>
                           <div class="col-sm-8">
                              <select class="form-control form-control-sm" id="transportation" name="transport_type">
                                 <option value="road">By Road</option>
                                 <option value="air">By Air</option>
                                 <option value="train">By Train</option>
                                 <option value="post">By Post</option>
                                 <option value="online">Online</option>
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
                              <textarea name="billing_address" class="form-control form-control-sm" id="billing_address" cols="50"></textarea>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="card">
                           <h5 class="card-header bg-success text-white border-bottom p-1">Delivery Address 
                              <input type="checkbox" name="same_billing" id="same_billing" value="yes"> <small>Same as billing</small>
                           </h5>
                           <div class="card-body p-1">
                              <textarea name="delivery_address" class="form-control form-control-sm" id="delivery_address" cols="50"></textarea>
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
                              </tfoot>
                           </table>
                              

                        </div>
                     </div>
                  </div>
                    
                  <div class="row">
                     <div class="col-sm-6">
                        <label for="comment" class="col-form-label">Comment</label>
                         
                         <textarea class="form-control form-control-sm" name="comment" id="comment"></textarea>
                         
                     </div>
                     <div class="col-sm-6">
                        <label for="trans_desctription" class="col-form-label">Transaction Description</label>
                         
                         <textarea class="form-control form-control-sm" name="trans_desctription" id="trans_desctription"></textarea>
                         
                     </div>
                      
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="advance" class="col-sm-4 col-form-label">Advance</label>
                           <div class="col-sm-8">
                              <input type="text" class=" numberAndDot form-control form-control-sm" id="advance" name="advance" >
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="create_date" class="col-sm-4 col-form-label">Payment Date</label>
                           <div class="col-sm-8">
                              <input type="date" class="form-control form-control-sm" id="create_date" name="create_date">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="balance" class="col-sm-4 col-form-label">Balance</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="balance" name="balance" readonly >
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
                                 <option value="<?php echo $payment_mode->slug;?>" ><?php echo $payment_mode->title;?></option>
                                 <?php
                                    }
                                    }
                                    ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row cheque-field" style="display: none;" >
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="cheque_no" class="col-sm-4 col-form-label">Chq No</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="cheque_no" name="cheque_no">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="bank_name" class="col-sm-4 col-form-label">Bank</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="bank_name" name="bank_name">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="row">
                           <label for="bank_branch" class="col-sm-4 col-form-label">Branch</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="bank_branch" name="bank_branch"   >
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                           <div class="card-body ">
                              <input id="pending_bill" name="pending_bill" type="hidden" value="0">
                               
                              
                              <button type="submit" class="btn btn-info w-md float-end mr-1">Save Details</button>
                              <a  href="<?php echo base_url()?>admin/sales" class="btn my-primary w-md float-end">Cancel</a>
                           </div>
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

   var jsproduct  = '<?php echo json_encode($prodct)?>';
   var jsonp_order_roduct  = '<?php echo json_encode($prodct)?>';
   var addImg     = "<?php echo base_url()?>assets/admin/images/plus-button-icon.png";
   var removeImg  = "<?php echo base_url()?>assets/admin/images/cross-button-icon.png";
   var centerState  = '<?php echo $company_data->state?>';

shoppingCart.addImg = addImg;
shoppingCart.removeImg = removeImg;
shoppingCart.products = jsproduct;
shoppingCart.centerState = centerState;
shoppingCart.addItemToCart(shoppingCart.addItem);
shoppingCart.displayCart();

   
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
       
      function districtChange(district_code = '',selected_city = '') {
          
        var districtCode = district_code ? district_code : $('#district').val();
        var selectedCity = selected_city ? selected_city : $('#city').val();
        hitURL = "<?php echo base_url() ?>admin/customer/district_change/"+ districtCode+"/"+ selectedCity;
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
<script type="text/javascript">
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
                  if(btn=='searchBtnBooking')
                  {

                  }else
                  {
                     $('#billing_address').val(data.village);   
                  }
                  
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
                  console.log(response);
                    var data = response;
                  $("#customer_id").val(data.farmer_id);
                  $("#booking_id").val(data.id);
                   var productId = data.product_id
                  var price = data.price
                  var discount = data.discount
                  var quantity = data.quantity
                  $('#billing_address').val(data.billing_address); 
                  $('#delivery_address').val(data.delivery_address); 
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


                  customerSearchForSale('searchBtnBooking',"<?php echo base_url() ?>admin/farmers/single");
                  
                  //renderCart(centerState);
                     
                } 
                
         },
         error: function (request, status, error) {
              
              
              hide_loader();
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

      $('.numberAndDot').keypress(function (event) {
            return isNumber(event, this)
        });
   
     /* $("#sales_form").submit(function (e){
             e.preventDefault();
             $("#booking_error").html('');
             var message = '';
             var validation = true;
             var customer_mobile = $("#customer_mobile").val();
             var customer_name = $("#customer_name").val();
             var product_id = $("#product_id").val();
             if(customer_mobile.length >0)
             {
   
             }else
             {
              validation =false;
                message+='<p class="text-danger">Reg Mob No Is Required</p>';
             }  
             if(customer_name.length >0)
             {
   
             }else
             {
              validation =false;
                message+='<p  class="text-danger">Name* Is Required</p>';
             }
   
             if(product_id.length >0)
             {
   
             }else
             {
              validation =false;
                message+='<p  class="text-danger">Select Product one</p>';
             }
   
             $("#booking_error").html(message);
   
   
             if(validation)
             {
              $("#sales_form").submit();
             }
   
              
      });*/
   
   
   
   
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
                     //renderCart(centerState);
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
        $('#farmer_id').val('');



         var searchBtn = $(this);
         var booking_no = $('#booking_no').val();
         if(booking_no && booking_no !=''){
            bookingSearchForSale(searchBtn, "<?php echo base_url() ?>admin/bookings/forsale");
         }else{
            customerSearchForSale(searchBtn,"<?php echo base_url() ?>admin/farmers/single");
         }



         /*if(customer_id || mobile)
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
       
        }*/
        
    
        
    });
   
    $(".select2").select2();
    
     $('#sales_form #same_billing').on('change', function () {
   
       checkSameBilling();
        
    });
   
   
   
   
     /*$('#quantity').on('change', function() {
             
            renderCart(centerState);
        });*/
        $('#discount').on('change', function() {
            //renderCart(centerState);
        });
        $('#price').on('change', function() {
            //renderCart(centerState);
        });
   
        $('#sales_form #advance').on('change', function() {
            //renderCart(centerState);
              var advanceval = $('#sales_form #advance').val();
              if(advanceval>0)
              {
               $('#sales_form #create_date').attr('required', true);
               $('#sales_form #bank_trans_id').attr('required', true);
              }else{
               $('#sales_form #create_date').attr('required', false);
               $('#sales_form #bank_trans_id').attr('required', false);
              }
        });
        $('#payment_mode').on('change', function() {
            renderChequeField();
        });
    
   });
    function salesCopyBillingToShipping(isSameBilling = false) {
    var billingAddress = $('#billing_address').val();
    if (isSameBilling) {
        $('#delivery_address').val(billingAddress);
        $('#delivery_address').attr('readonly', 'readonly');
    }
    $('#sales_form #same_billing').on('change', function () {
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
        }else
        {
         $('#delivery_address').removeAttr('readonly');
        }
   }
   function renderChequeField() {
    var paymentMode = $('#payment_mode').val();
    if (paymentMode == 'cheque') {
        $('.cheque-field').show();
    } else {
        $('.cheque-field').hide();
        $('#cheque_no').val('');
        $('#bank_name').val('');
        $('#bank_branch').val('');
   
    }
    if (paymentMode == 'cash') {
        $('.cash-field').show();
    } else {
        $('.cash-field').hide();
    }
    if (paymentMode == 'online-transfer') {
        $('.online-field').show();
    } else {
        $('.online-field').hide();
    }
    if (paymentMode == 'other') {
        $('.other-field').show();
    } else {
        $('.other-field').hide();
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
        beforeSend: function(){
               show_loader();
         },
         complete: function(){
            hide_loader();
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
   
   
   /*function getPercentOfNumberVal(number, percent, gst)
   {
   return (number * percent) / (100 + gst);
   }
   
   function getPercentOfNumber (number, percent) {
        
        return (number * percent) / (percent + 100);
    }*/
   
   /*function renderTax(centerState) {
    var quantity = Number($('#quantity').val());
    var gst = Number($('#gst').val());
    var state = $('#state').val();
    var price = Number($('#price').val());
   
    var cgst = 0;
    var sgst = 0;
    var igst = 0;
    var cgstVal = 0;
    var sgstVal = 0;
   
    // console.log(centerState, state);
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
   
   }*/
   
   
   /*function renderCart(centerState) {
     renderTax(centerState);
    var quantity = Number($('#quantity').val());
    var discount = Number($('#discount').val());
    var price = Number($('#price').val());
   
     var advance = Number($('#advance').val());
    var totalCart = (price * quantity) - discount;
    var pendingBill = Number($('#pending_bill').val());
   
    $('#total').val(totalCart.toFixed(2));
    $('.totalCart').text(totalCart.toFixed(2));
   
    var balance = (totalCart - advance) + pendingBill;
    $('#balance').val(Number(balance).toFixed(2));
    }*/
   
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
   
 

</script>