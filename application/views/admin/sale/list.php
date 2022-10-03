<?php
        $role_id = $this->session->userdata('role_id');
        $action_requred = get_module_role($module_id['id'],$role_id);

        
?> 
<style type="text/css">
   .table>:not(caption)>*>* {
   border: 1px solid #3a863e;
   padding: 1px 1px;
   font-size: 10px;
   color: #000;
   }
   .mytablestyle{
   min-height: 500px;
   }
   .modal#advanceFilterModal .select2-dropdown{
   z-index:1056 !important;
   width: 200px !important;
   }
   .modal#advanceFilterModal .select2-container{
   width: 200px !important;
   }
   .modal#advanceFilterModal
   {
   z-index: 1051;
   }
   tbody tr td{
   text-align: center;
   }
</style>
<!-- Latest compiled and minified CSS -->
<div class="page-content">
   <?php include APPPATH.'views/admin/menu-strive.php';?>
   <div class="container-fluid">
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
       <form method="GET" action="<?php echo base_url()?>admin/sales" id="booking_filter">
      <div class="row">
         <div class="col-xl-12">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <h5 class="card-header bg-success text-white border-bottom ">
                        <div class="row ">
                           <div class="col-sm-9">
                              Sales
                           </div>
                           <div class="col-sm-3">
                               <?php 
                                 $add_btn = (@$action_requred->create=='create')?'<a class="btn btn-primary p-1" href="'.base_url().'admin/sales/create"><i class="fa fa-plus"></i> Add Sales</a>':"";
                                 echo $add_btn;
                               ?>
                              <a  class="btn btn-info p-1" href="<?php echo base_url()?>admin/sales/export?<?php echo $_SERVER['QUERY_STRING'];?>"><i class="fa fa-file" aria-hidden="true"></i> Export Sales</a>
                              <a href="<?php echo base_url()?>admin/sales" class="btn btn-info btn-sm">Clear</a>
                              <button type="submit"  class="btn btn-info btn-sm">Submit Filter</button>
                               
                           </div>
                        </div>
                     </h5>
                      
                     <div class="card-body pb-0">
                        <div class="table-responsive mytablestyle">
                           
                              <table class="table table-striped align-middle table-nowrap mb-0" id="example">
                                 <thead class="table-light">
                                    <tr>
                                       <th class="align-middle bg-success text-white">Action</th>
                                       <th class="align-middle bg-success text-white">Invoice Date.</th> 
                                       <th class="align-middle bg-success text-white">Invoice No.</th>
                                       <th class="align-middle bg-success text-white">Farmer ID</th>
                                       <th class="align-middle bg-success text-white">Farmer Name</th>
                                       <th class="align-middle bg-success text-white">Phone Number</th>
                                       <th class="align-middle bg-success text-white">Status</th>
                                       <th class="align-middle bg-success text-white">Choose State</th>
                                       <th class="align-middle bg-success text-white">Choose District</th>
                                       <th class="align-middle bg-success text-white">Payment Mode</th>
                                       <th class="align-middle bg-success text-white">Bank Trxn ID</th>
                                       <th class="align-middle bg-success text-white">GST Amount</th>
                                       <th class="align-middle bg-success text-white">Total Amount</th>
                                       <th class="align-middle bg-success text-white">Recieved Amount</th>
                                       <th class="align-middle bg-success text-white">Outstanding Amount</th>
                                       <th class="align-middle bg-success text-white">Transaction Description </th>
                                       <th class="align-middle bg-success text-white">Comment</th>
                                       <th class="align-middle bg-success text-white">Entry made by</th>
                                       <th class="align-middle bg-success text-white">Entry Date</th>
                                    </tr>
                                    <tr>
                                       <th class="align-middle bg-success text-white"></th>
                                        
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="date" name="invoice_date" id="invoice_date" placeholder="Invoice Date"  style="width: 120px;">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="invoice_no" id="invoice_no" placeholder="Invoice No"  style="width: 120px;">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="farmer_id" id="farmer_id" placeholder="Farmer ID">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="customer_name" id="customer_name" placeholder="Customer Name">
                                       </th>
                                       
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="customer_mobile" id="customer_mobile" placeholder="Primary Phone">
                                       </th>
                                        
                                       <th class="align-middle bg-success text-white">
                                          
                                          <select class=" form-control form-control-sm" id="status1" name="status1" style="width: 150px;" >
                                             <option selected="selected" value="">Status</option>
                                             <option value="completed">Completed</option>
                                             <option value="returned">Returned</option>
                                          </select>
                                          
                                       </th>
                                        
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm select2 " id="state2" name="state2" aria-label="Floating label select example" style="width: 150px;" onchange="stateChange2()">
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
                                          
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm select2 " id="district2" name="district2" aria-label="Floating label select example"   style="width: 150px;" onchange="districtChange2()">
                                             <option value="" selected>Choose District</option>
                                          </select>
                                        </th>
                                        
                                        
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                       <th class="align-middle bg-success text-white" ></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       /*   echo "<pre>";
                                       
                                          print_r($_SESSION);
                                          echo "</pre>";*/
                                       
                                       
                                         if(!empty($bookings)){
                                           foreach($bookings as $bookings){ ?>
                                    <tr>
                                       <td>
                                          <div class="btn-group">
                                             <span class="badge bg-primary dropdown-toggle text-white dropdown-toggle" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                             Action<i class="mdi mdi-chevron-down"></i>
                                             </span>
                                             <div class="dropdown-menu" style="">
                                                <?php 
                                 $edit_btn = (@$action_requred->edit=='edit')?'<a class="dropdown-item btn" href="'.base_url().'admin/sales/'.$bookings['id'].'/edit" data-userid="'.$bookings['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>':"";
                                 echo $edit_btn;
                               
                                 $view_invoice_btn = (@$action_requred->view=='view')?'<a class="dropdown-item btn" target="_BLANK" href="'.base_url().'admin/sales/invoice/'.$bookings['id'].'" data-userid="'.$bookings['id'].'"><i class="fa fa-eye" aria-hidden="true"></i> Generate Invoice</a>':"";
                                 echo $view_invoice_btn;
                                  $transaction_invoice_btn = (@$action_requred->view=='view')?'<a class="dropdown-item btn"  target="_BLANK" href="'.base_url().'admin/sales/view/'.$bookings['id'].'" data-userid="'.$bookings['id'].'"><i class="fa fa-eye" aria-hidden="true"></i> View Transaction Details</a>':"";
                                 echo $transaction_invoice_btn;

                                 $dlete_btn = (@$action_requred->delete=='delete')?'<a class="dropdown-item text-danger deletebtn" href="#" data-userid="'.$bookings['id'].'">Delete</a>':"";
                                 echo $dlete_btn;

                                 $edit_btn2 = (@$action_requred->edit=='edit')?'<a href="'.base_url().'admin/sales/'.$bookings['id'].'/edit">'.$bookings['id'].'</a>':$bookings['id'];
                                 
                                 ?>
                                             </div>
                                          </div>
                                       </td>
                                        
                                       
                                       <td><?php echo ($bookings['create_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['create_date'])) :'';?></td>
                                       <td><?php echo $edit_btn2;?></td>
                                       <td><?php echo $bookings['farmer_id'];?></td>
                                       <td><?php echo $bookings['customer_name'];?></td>
                                       <td><?php echo $bookings['customer_mobile'];?></td>
                                       <td><span class="badge bg-<?php echo (($bookings['booking_status']=='returned')?'danger':'success');?> "><?php echo ucwords($bookings['booking_status']);?></span></td>
                                       
                                       
                                       
                                       
                                       <td><?php echo ( $bookings['state']);?></td>
                                       <td><?php echo ($bookings['district']);?></td>
                                       <td><?php echo $bookings['paymentmodename'];?></td>
                                       <td><?php echo $bookings['bank_trans_id'];?></td>
                                       <td><?php echo $bookings['gst_amount'];?></td>
                                       <td><?php echo $bookings['total'];?></td>
                                       <td><?php echo $bookings['total_paid_amount'];?></td>
                                       <td><span class='<?php if($bookings['outstanding_amount'] <0){ echo "text-danger";}?>'><?php echo $bookings['outstanding_amount'];?></span></td>
                                       <td><?php echo $bookings['trans_desctription'];?></td>
                                       <td><?php echo $bookings['comment'];?></td>
                                       <td><?php echo $bookings['createdby'];?></td>
                                       <td><?php echo ($bookings['date_at']!=='0000-00-00')? date('d M Y',strtotime($bookings['date_at'])) :'-/-/-';?> </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr>
                                       <td colspan="100">customers (s) not found...
                                       <td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           
                        </div>
                        <div class="row">
                           <div class="col-sm-3">
                              <ul class="pagination  justify-content-left mt-4"  >
                                 <li class="">
                                    <p>Total <?php echo @$pagination_total_count; ?> Bookings</p>
                                 </li>
                              </ul>
                           </div>
                           <div class="col-sm-9">
                              <?php echo @$pagination; ?>  
                           </div>
                        </div>
                     </div>
                     <!-- end table-responsive -->
                  </div>
               </div>
            </div>
         </div>

         </form>
      </div>
   </div>
</div>
</div>
 
 
 
 
 
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.js"></script>
<!--  Large modal example -->
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
   var start = moment('01/01/1970');
       var end = moment();
               
      
      
   
   
   
   jQuery(document).ready(function(){
         
           
            
            $(".select2").select2(); 
         
            $("#advance_booking_status").on('change',function(){
               $("#advance_booking_status_value").val($(this).val());
            });
   
           $("#advance_crop_status").on('change',function(){
               $("#advance_crop_status_value").val($(this).val());
           });
           $("#advance_agent_id").on('change',function(){
               $("#advance_agent_id_value").val($(this).val());
           });
           $("#advance_product_id").on('change',function(){
               $("#advance_product_id_value").val($(this).val());
           });
           $("#advance_state").on('change',function(){
               $("#advance_state_value").val($(this).val());
           }); 
           $("#advance_district").on('change',function(){
               $("#advance_district_value").val($(this).val());
           });
           $("#advance_city").on('change',function(){
               $("#advance_city_value").val($(this).val());
           });
   
           $(".select2").select2();
   
   
        jQuery(document).on("click", ".deletebtn", function(){
   
         var userId = $(this).data("userid"),
           hitURL = "<?php echo base_url() ?>admin/sales/delete",
           currentRow = $(this);
         
         var confirmation = confirm("Are you sure to delete this?");
         
         if(confirmation)
         {
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId } 
           }).done(function(data){           
             
             if(data.status= true)
                {
                  currentRow.parents('tr').remove();
   
                      toastr.success(data.message);
                     window.location.reload(true);
   
                
                }else{
   
                  toastr.error(data.message);
   
                }
              
           });
         }
   });
   
        // change status steps start
        jQuery(document).on("click", ".changestatusbtn", function(){
   
         var userId  = $(this).data("userid");
         var farmer_id  = $(this).data("farmer_id");
         var status_title  = $(this).data("status_title");
         var form_action      = "<?php echo base_url() ?>admin/bookings/"+userId+"/status";
         var cancel_form_action      = "<?php echo base_url() ?>admin/bookings/"+userId+"/cancel_status";
         var hitURL = "<?php echo base_url() ?>admin/bookings/single/"+userId;
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
             
             $('#change_booking_status').attr('action', form_action);
             $('#cancel_booking').attr('action', cancel_form_action);
             $('#cancel_booking #farmer_id').val(farmer_id);
             $('#exampleModal').modal('show');
             $('#update_booking_status').val(data.booking_status);
             $('#current_status').text(status_title);
   
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
   
   
         jQuery("#change_booking_status").on('submit',function(e){
            e.preventDefault();
              
               if($('#update_booking_status').val()=='cancelled')
               {
                  $('#cancelBookingModal').modal('show');   
                  $('#cancelBookingModal #booking_status').val($('#update_booking_status').val());   
                   return false;  
               }
             
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
                 
   
                 $('#exampleModal').modal('hide');
                 toastr.success(data.message);
                    window.location.reload(true);
   
               
               }else{
   
                 toastr.error(data.message);
   
               }
             });
          
       });
   
   
   
   
   
        $("#exampleModal").on('hide.bs.modal', function(){
         $('#change_booking_status').attr('action','');
         $('#update_booking_status').val('');
          $('#current_status').text('');
       });
   
   
   
        // change status steps end
   
   
   
   
   //get history  start
        jQuery(document).on("click", ".historybooking", function(){
   
         var userId  = $(this).data("userid");
          var hitURL      = "<?php echo base_url() ?>admin/bookings/"+userId+"/logs";
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
             var html_content = '';
             console.log(response);
             for (var i = 0; i < data.length; i++)
             {
               content = data[i];
                 html_content+= '<tr>';
                 html_content+="<td><span class='badge bg-"+((content.stage=='Update')?'warning':'primary')+"'>"+content.stage+"</span></td>";
                 html_content+="<td>"+content.booking_id+"</td>"; 
                 html_content+="<td>"+content.booking_date+"</td>"; 
                 html_content+="<td><span class='badge bg-"+content.booked_badges+"'>"+content.booked_status+"</span></td>"; 
                 html_content+="<td><span class='badge bg-success'>"+content.cropstatusname+"</span></td>"; 
                 html_content+="<td>"+content.farmer_id+"</td>"; 
                 html_content+="<td>"+content.customer_name+"</td>"; 
                 html_content+="<td>"+content.executive+"</td>"; 
                 html_content+="<td>"+content.productname+"</td>"; 
                 html_content+="<td>"+content.customer_mobile+"</td>"; 
                 html_content+="<td>"+content.customer_alter_mobile+"</td>"; 
                 html_content+="<td>"+content.billing_address+"</td>"; 
                 html_content+="<td>"+((content.state=='Other') ? (content.other_state) : (content.state))+"</td>"; 
                 html_content+="<td>"+((content.district=='Other') ? (content.other_district) : (content.district))+"</td>"; 
                 html_content+="<td>"+((content.city=='Other') ? (content.other_city) : (content.city))+"</td>"; 
                 html_content+="<td>"+content.pincode+"</td>";
                 html_content+="<td>"+content.payment_mode+"</td>";
                 html_content+="<td>"+content.bank_trans_id+"</td>";
                 html_content+="<td>"+content.crates+"</td>";
                 html_content+="<td>"+content.quantity+"</td>";
                 html_content+="<td>"+content.price+"</td>";
                 html_content+="<td>"+content.total+"</td>";
                 html_content+="<td>"+content.discount+"</td>";
                 html_content+="<td>"+content.total_paid_amount+"</td>";
                 html_content+="<td>"+content.outstanding_amount+"</td>";
                 html_content+="<td>"+((content.delivery_expect_start_date !=='' && content.delivery_expect_end_date !=='') ? (content.delivery_expect_start_date+" To "+content.delivery_expect_end_date) :'NA') +"</td>";
                 html_content+="<td>"+content.delivery_date+"</td>";
                 html_content+="<td>"+content.vehicle_no+"</td>";
                 html_content+="<td>"+content.contractstatusname+"</td>";
                 html_content+="<td>"+content.productive_plants+"</td>";
                 html_content+="<td>"+content.document+"</td>";
                 html_content+="<td>"+content.assignedto+"</td>";
                 html_content+="<td>"+content.createdby+"</td>";
                 html_content+="<td>"+content.create_date+"</td>";
                 html_content+="<td>"+content.cancellation_reason+"</td>";
                 html_content+= '</tr>';
                
             }
             $('#booking_history').html(html_content);
             
             /*alert(data.length);
             console.log(data);*/
   
           }
         });
   
         
   
          
          
        
   });
   
   
   });
   
   function stateChange2(state_code = '',selected_district = '') {
     
   var stateCode = state_code ? state_code : $('#state2').val();
   var selectedDistrict = selected_district ? selected_district : $('#district2').val();
   hitURL = "<?php echo base_url() ?>admin/customer/state_change/"+ stateCode+"/"+ selectedDistrict;
   $.ajax({
       type: 'GET',
       url: hitURL,
       data: {},
       success: function (response) {
            var check_state = $('#state2 option:selected').text();
            if(check_state =='Other')
         {
             $('#other_state2').val('');
            $('#other_state2').css('display', 'block');
   
         }else
         {
            
            $('#other_state2').val('');
            $('#other_state2').css('display', 'none');
          }
           $("#district2").empty().append(response);
           $(".select2").select2();
       },
       error: function (request, status, error) {
            
            
           
           $("#district2").empty();
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
            
   
              var check_district = $('#district2 option:selected').text();
           if(check_district =='Other')
           {
             $('#other_district2').val('');
             $('#other_district2').css('display', 'block');
   
           }else
           {
              
              $('#other_district2').val('');
              $('#other_district2').css('display', 'none');
            }
   
   
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
   
   function cityChange2(district_code = '',selected_city = '') {
     
    var check_city = $('#city2 option:selected').text();
           if(check_city =='Other')
           {
             $('#other_city2').val('');
             $('#other_city2').css('display', 'block');
   
           }else
           {
              
              $('#other_city2').val('');
              $('#other_city2').css('display', 'none');
            }
   }
   
    
     
   
   
</script>
<!-- Get Databse List -->
<script type="text/javascript">
   var table;
    
   $(document).ready(function() {
      
      
    $("#query-pagination li.page-item a").addClass('page-link');
       
   });
</script>
<!-- Status Change -->
<script type="text/javascript">
   jQuery(document).ready(function(){
    
   
   
      $('#invoice_date,#status').on(
           'change',
           function() {
               $('#booking_filter').submit();
           });
   
   
        jQuery(document).on("change", ".statusBtn", function(){
   
         var userId = $(this).attr("data-id");
         var value  = $(this).val();
   
           hitURL = "<?php echo base_url() ?>admin/booking/statusChange",
           currentRow = $(this);
         
           jQuery.ajax({
           type : "POST",
           dataType : "json",
           url : hitURL,
           data : { id : userId, status : value } 
           }).done(function(data){           
             //currentRow.parents('tr').remove();
             if(data.status = true) { alert("successfully status changed"); }
             else if(data.status = false) { alert("status failed failed"); }
             else { alert("Access denied..!"); }
           });
         
   });
   });
   
   
   window.addEventListener("keydown", checkKeyPressed, false);
   
   function checkKeyPressed(e)
   {
     if (e.keyCode == "13")
     {
   
        e.preventDefault();
     }
   }
   
</script>