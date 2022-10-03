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
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <h5 class="card-header text-white border-bottom p-0">
                  <div class="row ">
                     <div class="col-sm-12">
                        <div class="d-flex flex-wrap gap-2 table-responsive">
                           <div class="btn-group" role="group" aria-label="Basic example">
                               <?php 
                              $add_btn = (@$action_requred->create=='create')?'<a class="btn my-primary px-4 " href="'.base_url().'admin/bookings/create"><i class="fa fa-plus"></i> Add Booking</a>':"";
                              echo $add_btn;
                            ?>
                              <a  class="btn my-primary px-4" href="<?php echo base_url()?>admin/bookings/export?<?php echo $_SERVER['QUERY_STRING'];?>">Export Booking</a>
                              <a  class="btn my-primary px-4" href="<?php echo base_url()?>admin/bookings/advance" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"><i class="fa fa-filter" aria-hidden="true"></i>Advance Search</a> 
                           </div>
                        </div>
                     </div>
                  </div>
               </h5>
            </div>
         </div>
      </div>
   </div>
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
      <div class="row">
         <div class="col-xl-12">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <h5 class="card-header bg-success text-white border-bottom ">
                        <div class="row ">
                           <div class="col-sm-9">
                              Booking Status
                           </div>
                           <div class="col-sm-3">
                              <a href="<?php echo base_url()?>admin/bookings" class="btn btn-info btn-sm">Clear</a> 
                              <button id="daterange" class="btn btn-info btn-sm">
                              <i class="fa fa-calendar"></i>
                              <span>July 12, 2020 - July 12, 2020</span> <i class="fas fa-caret-down"></i>
                              </button>
                              <input name="form_type" type="hidden" value="inquiry">
                           </div>
                        </div>
                     </h5>
                     <div class="card mb-0">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-12 ">
                                 <div class="d-flex flex-wrap gap-2 table-responsive">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                       <?php
                                          if(!empty($filter_bookings_status))
                                          {
                                            
                                                  foreach ($filter_bookings_status as $filter_booking_status) 
                                                  {
                                                    $active = "";
                                                    
                                                   if(isset($_GET['booking_status']) && $_GET['booking_status'] ==$filter_booking_status['slug'])
                                                   {
                                                     $active = "active";
                                          
                                          
                                                   }
                                          
                                          
                                          
                                                      ?>
                                       <a class="btn my-primary <?php echo $active ;?>" href="<?php echo base_url()?>admin/bookings?booking_status=<?php echo $filter_booking_status['slug']?>"> <span class="badge bg-warning text-white"><?php echo $filter_booking_status['count_booking']?> </span> <?php echo $filter_booking_status['title']?>
                                       </a>
                                       <?php
                                          }
                                          }
                                          ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card-body pb-0">
                        <div class="table-responsive mytablestyle">
                           <form method="GET" action="<?php echo base_url()?>admin/bookings" id="booking_filter">
                              <input type="text" name="start_date"  id="start_date" hidden >
                              <input type="text" name="end_date"  id="end_date"  hidden  >
                              <table class="table table-striped align-middle table-nowrap mb-0" id="example">
                                 <thead class="table-light">
                                    <tr>
                                       <th class="align-middle bg-success text-white">Action</th>
                                       <th class="align-middle bg-success text-white">Stage</th>
                                       <th class="align-middle bg-success text-white">Booking No.</th>
                                       <th class="align-middle bg-success text-white">Booking Date.</th>
                                       <th class="align-middle bg-success text-white">Order Status</th>
                                       <th class="align-middle bg-success text-white">Crop Status</th>
                                       <th class="align-middle bg-success text-white">Farmer ID</th>
                                       <th class="align-middle bg-success text-white">Name</th>
                                       <th class="align-middle bg-success text-white">Executive</th>
                                       <th class="align-middle bg-success text-white">Choose Product</th>
                                       <th class="align-middle bg-success text-white">Primary Number</th>
                                       <th class="align-middle bg-success text-white">Number</th>
                                       <th class="align-middle bg-success text-white">Billing Address</th>
                                       <th class="align-middle bg-success text-white">Choose State</th>
                                       <th class="align-middle bg-success text-white">Choose District</th>
                                       <th class="align-middle bg-success text-white">Choose Tehsil</th>
                                       <th class="align-middle bg-success text-white">Pin Code</th>
                                       <th class="align-middle bg-success text-white">Payment Mode</th>
                                       <th class="align-middle bg-success text-white">Bank Trxn ID</th>
                                       <th class="align-middle bg-success text-white">Crates</th>
                                       <th class="align-middle bg-success text-white">Plant Booked</th>
                                       <th class="align-middle bg-success text-white">Plant Rate</th>
                                       <th class="align-middle bg-success text-white">Total Billed Amount</th>
                                       <th class="align-middle bg-success text-white">Discrount Amount</th>
                                       <th class="align-middle bg-success text-white">Recieved Amount</th>
                                       <th class="align-middle bg-success text-white">Out standing Amount</th>
                                       <th class="align-middle bg-success text-white">Expected Delivery Date </th>
                                       <th class="align-middle bg-success text-white">Actual Delivery Date</th>
                                       <th class="align-middle bg-success text-white">Vehicle No.</th>
                                       <th class="align-middle bg-success text-white">Contract Status</th>
                                       <th class="align-middle bg-success text-white">Productive Plants</th>
                                       <th class="align-middle bg-success text-white">Document</th>
                                       <th class="align-middle bg-success text-white">Assigned To</th>
                                       <th class="align-middle bg-success text-white">Entry made by</th>
                                       <th class="align-middle bg-success text-white">Entry Date</th>
                                    </tr>
                                    <tr>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="booking_no" id="booking_no" placeholder="Booking Number"  style="width: 70px;">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="date" name="booking_date" id="booking_date" placeholder="Booking Date"  style="width: 70px;" >
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="booking_status" name="booking_status" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Booking Status</option>
                                             <?php
                                                if(!empty($bookings_status))
                                                {
                                                        foreach ($bookings_status as $booking_status) {
                                                            ?>
                                             <option value="<?php echo $booking_status->slug;?>"><?php echo $booking_status->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control form-control-sm " id="crop_status" name="crop_status" aria-label="Floating label select example" style="width: 150px;" >
                                             <option value="" selected>Crop Status</option>
                                             <?php
                                                if(!empty($crops_status))
                                                {
                                                        foreach ($crops_status as $crop_status) {
                                                            ?>
                                             <option value="<?php echo $crop_status->slug;?>"><?php echo $crop_status->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="farmer_id" id="farmer_id" placeholder="Farmer ID">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="customer_name" id="customer_name" placeholder="Customer Name">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class="form-control form-control-sm "  name="agent_id" id="agent_id" aria-label="Floating label select example" style="width: 150px;"  >
                                             <option value="" selected >Choose Executive</option>
                                             <?php
                                                if(!empty($all_agents))
                                                {
                                                        foreach ($all_agents as $executive) {
                                                            ?>
                                             <option value="<?php echo $executive->id;?>"><?php echo ( ($executive->id)?$executive->id:'')." ".$executive->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                           </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class="form-control form-control-sm select2 " name="product_id" id="product_id" aria-label="Floating label select example" style="width: 150px;"  >
                                             <option value="" selected >Choose Product</option>
                                             <?php
                                                if(!empty($all_products))
                                                {
                                                        foreach ($all_products as $all_product) {
                                                            ?>
                                             <option value="<?php echo $all_product->id;?>"><?php echo $all_product->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="customer_mobile" id="customer_mobile" placeholder="Primary Phone">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="customer_alter_mobile" id="customer_alter_mobile" placeholder="Number">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="address" id="address" placeholder="Address" style="width:400px;">
                                       </th>
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
                                          <input class="form-control-sm" type="text" name="pincode" id="pincode" placeholder="Pincode">
                                       </th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="quantity" id="quantity" placeholder="Plant Booked">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="unit_price" id="unit_price" placeholder="Plant Rate">
                                       </th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="discount" id="discount" placeholder="Discount">
                                       </th>
                                       <th class="align-middle bg-success text-white"></th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="outstanding_amount" id="outstanding_amount" placeholder="Outstanding Amount">
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="req_delivery_date" id="req_delivery_date" hidden  >
                                          <input class="form-control-sm" type="text" name="req_delivery_date_label" id="req_delivery_date_label"  >
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="date" name="delivery_date" id="delivery_date"  >
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <input class="form-control-sm" type="text" name="vehicle_no" id="vehicle_no"  >
                                       </th>
                                       <th class="align-middle bg-success text-white">
                                          <select class=" form-control  form-control-sm" id="contract" name="contract" aria-label="Floating label select example"  style="width: 115px;"  >
                                             <option value="">Contract Status</option>
                                             <?php
                                                if(!empty($contracts_status))
                                                {
                                                    foreach ($contracts_status as $contract_status ) {
                                                        ?>
                                             <option value="<?php echo $contract_status->slug;?>"><?php echo $contract_status->title;?></option>
                                             <?php
                                                }
                                                }
                                                ?>
                                          </select>
                                       </th>
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
                                                   if(@$action_requred->edit =='edit'){
                                                      ?>
                                                         <a class="dropdown-item btn changestatusbtn" data-bs-toggle="modal" data-bs-target="#exampleModal"  data-userid="<?php echo $bookings['id']; ?>"  data-farmer_id="<?php echo $bookings['farmer_id']; ?>" data-status_title="<?php echo $bookings['booked_status'];?>"  ><i class="fa fa-wrench" aria-hidden="true"></i> Change Status</a>
                                                          <a class="dropdown-item btn" href="<?php echo base_url()?>admin/bookings/<?php echo $bookings['id']; ?>/edit" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Order</a>
                                                      <?php
                                                   } 
                                                    if(@$action_requred->view =='view'){
                                                      ?>
                                                          <a class="dropdown-item btn historybooking" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-history" aria-hidden="true"></i> View History</a>

                                                         <a class="dropdown-item btn" target="_BLANK" href="<?php echo base_url()?>admin/bookings/receipt/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> Generate Receipt</a>
                                                         <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/view/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View Order Details</a>
                                                         <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/agreement/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-file-excel" aria-hidden="true"></i> Generate Agreement</a>
                                                      <?php
                                                   }
                                                   if(@$action_requred->delete =='delete'){
                                                      ?>
                                                         <a class="dropdown-item text-danger deletebtn" href="#" data-userid="<?php echo $bookings['id']; ?>">Delete</a>
                                                      <?php
                                                   } 
                                                ?>
                                                
                                                
                                             </div>
                                          </div>
                                       </td>
                                       <td>
                                          <span class="badge bg-<?php echo (isset($bookings['stage']) && $bookings['stage']=='Created')?'primary':'warning';?> text-white"><?php echo $bookings['stage'];?></span>
                                       </td>
                                       <td><?php echo $bookings['id'];?></td>
                                       <td><?php echo ($bookings['booking_date']!=='0000-00-00')? date('d M Y',strtotime($bookings['booking_date'])) :'';?></td>
                                       <td><span class="badge bg-<?php echo $bookings['booked_badges'];?> "><?php echo $bookings['booked_status'];?></span></td>
                                       <td><?php echo $bookings['cropstatusname'];?></td>
                                       <td><?php echo $bookings['farmer_id'];?></td>
                                       <td><?php echo $bookings['customername'];?></td>
                                       <td><?php echo $bookings['executive'];?></td>
                                       <td><?php echo $bookings['productname'];?></td>
                                       <td><?php echo $bookings['customermobile'];?></td>
                                       <td><?php echo $bookings['customeraltmobile'];?></td>
                                       <td><?php echo $bookings['billing_address'];?></td>
                                       <td><?php echo (isset($bookings['other_state']) && !empty($bookings['other_state']))?($bookings['other_state']):($bookings['state']);?></td>
                                       <td><?php echo (isset($bookings['other_district']) && !empty($bookings['other_district']))?($bookings['other_district']):($bookings['district']);?></td>
                                       <td><?php echo (isset($bookings['other_city']) && !empty($bookings['other_city']))?($bookings['other_city']):($bookings['city']);?></td>
                                       <td><?php echo $bookings['pincode'];?></td>
                                       <td><?php echo $bookings['paymentmodename'];?></td>
                                       <td><?php echo $bookings['bank_trans_id'];?></td>
                                       <td><?php echo $bookings['crates'];?></td>
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
                                       <td><?php echo $bookings['contractstatusname'];?></td>
                                       <td><?php echo $bookings['productive_plants'];?></td>
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
                           </form>
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
                     <div class="row p-4">
                        <div class="col-sm-2">
                           <button class="btn my-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShowSummary" aria-expanded="true" aria-controls="ShowSummary"><i class="bx bx-plus-medical"></i> Show Summary</button>
                        </div>
                        <div class="col-sm-10">
                        </div>
                     </div>
                     <?php 
                        /*echo "<pre>";
                        print_r($show_summary);
                        echo "</pre>"; */ 
                        ?>
                     <!-- end table-responsive -->
                     <div class="collapse" id="ShowSummary" style="">
                        <div class="card ">
                           <div class="card-body p-0">
                              <div class="row">
                                 <?php 
                                    if(isset($show_summary['total_summary']))
                                    {
                                       ?>
                                 <div class="col-sm-4  mt-2">
                                    <div class="card m-0">
                                       <div class="card-body bg-success p-1 text-center text-white">
                                          <p class="text-white m-0" style="font-size: 10px;">Total Summary</p>
                                       </div>
                                       <div class="card-body p-0">
                                          <div class="table-responsive">
                                             <table class="table table-nowrap table-hover mb-0">
                                                <thead>
                                                   <tr>
                                                      <th>Booking Status</th>
                                                      <th>No. of booking</th>
                                                      <th>No. of plant</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      foreach ($show_summary['total_summary'] as $value)
                                                      {
                                                         $var = $value['name'];
                                                         ?>
                                                   <tr>
                                                      <td><span class="float-start" ><?php echo ucfirst($value['name']) ?></span></td>
                                                      <td><?php echo ($value[$var.'_booking']) ?></td>
                                                      <td><?php echo ($value[$var.'_plant']) ?></td>
                                                   </tr>
                                                   <?php    
                                                      }
                                                      ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <?php
                                    }
                                    ?>
                                 <?php
                                    if(isset($show_summary['products']) && !empty($show_summary['products']))
                                    {
                                    
                                       $inc = 0;
                                       foreach ($show_summary['products'] as  $product) {
                                    
                                           
                                          ?>
                                 <div class="col-sm-2  mt-2">
                                    <div class="card  m-0">
                                       <div class="card-body bg-success p-1 text-center text-white">
                                          <p class="text-white m-0" style="font-size: 10px;"><?php 
                                             echo @$show_summary['productname'][$inc];$inc++?></p>
                                       </div>
                                    </div>
                                    <div class="card-body p-0">
                                       <div class="table-responsive">
                                          <table class="table table-nowrap table-hover mb-0">
                                             <thead>
                                                <tr>
                                                   <th>No. of booking</th>
                                                   <th>No. of plant</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   foreach ($product as $value)
                                                   {
                                                     $var = $value['name'];
                                                     ?>
                                                <tr>
                                                   <td><?php echo ($value[$var.'_booking']) ?></td>
                                                   <td><?php echo ($value[$var.'_plant']) ?></td>
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
                                 <?php
                                    }
                                    ?>
                                 <?php
                                    if(isset($show_summary['total_summary_current_month']) && !empty($show_summary['total_summary_current_month']))
                                    {
                                       ?>
                                 <div class="col-sm-2  mt-2">
                                    <div class="card  m-0">
                                       <div class="card-body bg-success p-1 text-center text-white">
                                          <p class="text-white m-0" style="font-size: 10px;">Current Month</p>
                                       </div>
                                    </div>
                                    <div class="card-body p-0">
                                       <div class="table-responsive">
                                          <table class="table table-nowrap table-hover mb-0">
                                             <thead>
                                                <tr>
                                                   <th>No. of booking</th>
                                                   <th>No. of plant</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                   <?php
                                                      foreach ($show_summary['total_summary_current_month'] as $value)
                                                      {
                                                        $var = $value['name'];
                                                        ?>
                                                <tr>
                                                   <td><?php echo ($value[$var.'_booking']) ?></td>
                                                   <td><?php echo ($value[$var.'_plant']) ?></td>
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
                                 <?php
                                    if(isset($show_summary['total_summary_previous_month']) && !empty($show_summary['total_summary_previous_month']))
                                    {
                                       ?>
                                 <div class="col-sm-2  mt-2">
                                    <div class="card m-0">
                                       <div class="card-body bg-success p-1 text-center text-white">
                                          <p class="text-white m-0" style="font-size: 10px;">Previous Month</p>
                                       </div>
                                    </div>
                                    <div class="card-body p-0">
                                       <div class="table-responsive">
                                          <table class="table table-nowrap table-hover mb-0">
                                             <thead>
                                                <tr>
                                                   <th>No. of booking</th>
                                                   <th>No. of plant</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   foreach ($show_summary['total_summary_previous_month'] as $value)
                                                   {
                                                     $var = $value['name'];
                                                     ?>
                                                <tr>
                                                   <td><?php echo ($value[$var.'_booking']) ?></td>
                                                   <td><?php echo ($value[$var.'_plant']) ?></td>
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
                     <!-- end table-responsive -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="advanceFilterModal" role="dialog" data-bs-backdrop="static"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content border-success">
         <div class="modal-header bg-success">
            <h5 class="modal-title text-white" id="myLargeModalLabel">Advance Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="<?php echo base_url()?>admin/bookings" method="get" enctype="data/form">
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-6">
                     <div class=" row">
                        <label for="advance_booking_status" class="col-md-5 col-form-label">Booking Status: </label>
                        <div class="col-md-7">
                           <select class=" form-control form-control-sm select2"  multiple="multiple"  id="advance_booking_status">
                              <?php
                                 if(!empty($bookings_status))
                                 {
                                         foreach ($bookings_status as $booking_status) {
                                             ?>
                              <option value="<?php echo $booking_status->slug;?>"><?php echo $booking_status->title;?></option>
                              <?php
                                 }
                                 }
                                 ?>
                              <input type="hidden" name="advance_booking_status_value"  id="advance_booking_status_value" >
                           </select>
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_crop_status" class="col-md-5 col-form-label">Crop Status:</label>
                        <div class="col-md-7">
                           <select class=" form-control form-control-sm  select2" id="advance_crop_status" multiple="multiple">
                              <?php
                                 if(!empty($crops_status))
                                 {
                                         foreach ($crops_status as $crop_status) {
                                             ?>
                              <option value="<?php echo $crop_status->slug;?>"><?php echo $crop_status->title;?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                           <input type="hidden" name="advance_crop_status_value"  id="advance_crop_status_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_agent_id" class="col-md-5 col-form-label">Executive:</label>
                        <div class="col-md-7">
                           <select class="form-control form-control-sm select2"  multiple="multiple" name="advance_agent_id[]" id="advance_agent_id">
                              <?php
                                 if(!empty($all_agents))
                                 {
                                         foreach ($all_agents as $executive) {
                                             ?>
                              <option value="<?php echo $executive->id;?>"><?php echo $executive->title;?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                           <input type="hidden" name="advance_agent_id_value"  id="advance_agent_id_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_product_id" class="col-md-5 col-form-label">Products:</label>
                        <div class="col-md-7">
                           <select class="form-control form-control-sm select2"  multiple="multiple" name="advance_product_id[]" id="advance_product_id">
                              <?php
                                 if(!empty($all_products))
                                 {
                                    foreach ($all_products as $all_product){
                                    ?>
                              <option value="<?php echo $all_product->id;?>"><?php echo $all_product->title;?></option>
                              <?php
                                 }
                                 }
                                 ?>
                           </select>
                           <input type="hidden" name="advance_product_id_value"  id="advance_product_id_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="plant_rate_amount" class="col-md-5 col-form-label">Plant Rate:</label>
                        <div class="col-md-7">
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="form-control form-control-sm" name="advance_plan_rate" id="advance_plan_rate">
                                    <option value="<">is less than</option>
                                    <option value=">">is greater than</option>
                                    <option value="=">is equal to</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input type="number" name="plant_rate_amount" id="plant_rate_amount" class="form-control form-control-sm" placeholder="Amount" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_plant_quantity_amount" class="col-md-5 col-form-label">Plant Quantity</label>
                        <div class="col-md-7">
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="form-control form-control-sm" name="advance_plan_quantiry" id="advance_plan_quantiry">
                                    <option value="<">is less than</option>
                                    <option value=">">is greater than</option>
                                    <option value="=">is equal to</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input type="number" name="advance_plant_quantity_amount" id="advance_plant_quantity_amount" class="form-control form-control-sm" placeholder="Amount" />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class=" row">
                        <label for="advance_state" class="col-md-5 col-form-label">State: </label>
                        <div class="col-md-7">
                           <select class=" form-control form-control-sm select2" name="advance_state[]" multiple="multiple"  id="advance_state"   aria-label="Floating label select example" placeholder="Select"  >
                              <?php
                                 /*if(!empty($states))
                                 {
                                    foreach ($states as $state) {
                                       ?>
                              <option value="<?php echo $state->id;?>"><?php echo $state->name;?></option>
                              <?php
                                 }
                                 }*/
                                 ?>
                           </select>
                           <input type="hidden" name="advance_state_value"  id="advance_state_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_district" class="col-md-5 col-form-label">District:</label>
                        <div class="col-md-7">
                           <select class=" form-control form-control-sm  select2" id="advance_district" name="advance_district[]"  multiple="multiple" aria-label="Floating label select example"  >
                              <?php
                                 /* if(!empty($districts))
                                  {
                                     foreach ($districts as $district)
                                     {
                                        ?>
                              <option value="<?php echo $district->id;?>"><?php echo $district->name;?></option>
                              <?php
                                 }
                                 }*/
                                 ?>
                           </select>
                           <input type="hidden" name="advance_district_value"  id="advance_district_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_city" class="col-md-5 col-form-label">Tehsil:</label>
                        <div class="col-md-7">
                           <select class="form-control form-control-sm select2"  multiple="multiple" name="advance_city[]" id="advance_city" aria-label="Floating label select example"   >
                              <?php
                                 /*if(!empty($cities))
                                 {
                                    foreach ($cities as $city) {
                                       ?>
                              <option value="<?php echo $city->id;?>"><?php echo $city->city;?></option>
                              <?php
                                 }
                                 }*/
                                 ?>
                           </select>
                           <input type="hidden" name="advance_city_value"  id="advance_city_value" >
                        </div>
                     </div>
                     <div class=" row">
                        <label for="oustanding_amount" class="col-md-5 col-form-label">Outstanding:</label>
                        <div class="col-md-7">
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="form-control form-control-sm" name="advance_oustanding" id="advance_oustanding">
                                    <option value="<">is less than</option>
                                    <option value=">">is greater than</option>
                                    <option value="=">is equal to</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input type="number" name="oustanding_amount" id="oustanding_amount" class="form-control form-control-sm" placeholder="Amount" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_recieved_amount" class="col-md-5 col-form-label">Received:</label>
                        <div class="col-md-7">
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="form-control form-control-sm" name="advance_recieved" id="advance_recieved">
                                    <option value="<">is less than</option>
                                    <option value=">">is greater than</option>
                                    <option value="=">is equal to</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input type="number" name="advance_recieved_amount" id="advance_recieved_amount" class="form-control form-control-sm" placeholder="Amount" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=" row">
                        <label for="advance_discount_amount" class="col-md-5 col-form-label">Discount</label>
                        <div class="col-md-7">
                           <div class="row">
                              <div class="col-sm-6">
                                 <select class="form-control form-control-sm" name="advance_discount" id="advance_discount">
                                    <option value="<">is less than</option>
                                    <option value=">">is greater than</option>
                                    <option value="=">is equal to</option>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <input type="number" name="advance_discount_amount" id="advance_discount_amount" class="form-control form-control-sm" placeholder="Amount" />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <input type="hidden" name="search_type" name="search_type" value="Advance"/>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--  Large modal example -->
<div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="myLargeModalLabel">Large modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <p>Cras mattis consectetur purus sit amet fermentum.
               Cras justo odio, dapibus ac facilisis in,
               egestas eget quam. Morbi leo risus, porta ac
               consectetur ac, vestibulum at eros.
            </p>
            <p>Praesent commodo cursus magna, vel scelerisque
               nisl consectetur et. Vivamus sagittis lacus vel
               augue laoreet rutrum faucibus dolor auctor.
            </p>
            <p class="mb-0">Aenean lacinia bibendum nulla sed consectetur.
               Praesent commodo cursus magna, vel scelerisque
               nisl consectetur et. Donec sed odio dui. Donec
               ullamcorper nulla non metus auctor
               fringilla.
            </p>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- sample modal content -->
<div id="exampleModalFullscreen" class="modal fade" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
         <div class="modal-header bg-success">
            <h5 class="modal-title  text-white " id="exampleModalFullscreenLabel">Booking History</h5>
            <button type="button" class="btn-close  text-white" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="table table-responsive">
               <table class="table table-responsive">
                  <thead>
                     <tr>
                        <th class="align-middle bg-success text-white">Stage</th>
                        <th class="align-middle bg-success text-white">Booking&nbsp;No.</th>
                        <th class="align-middle bg-success text-white"  style="min-width: 80px">Booking&nbsp;Date.</th>
                        <th class="align-middle bg-success text-white">Order&nbsp;Status</th>
                        <th class="align-middle bg-success text-white">Crop&nbsp;Status</th>
                        <th class="align-middle bg-success text-white">Farmer&nbsp;ID</th>
                        <th class="align-middle bg-success text-white" style="min-width: 200px;"  >Customer&nbsp;Name</th>
                        <th class="align-middle bg-success text-white" style="min-width: 200px;" >Executive</th>
                        <th class="align-middle bg-success text-white" style="min-width: 200px;" >Choose&nbsp;Product</th>
                        <th class="align-middle bg-success text-white">Primary&nbsp;Number</th>
                        <th class="align-middle bg-success text-white">Number</th>
                        <th class="align-middle bg-success text-white" style="min-width: 300px;" >Billing&nbsp;Address</th>
                        <th class="align-middle bg-success text-white">Choose&nbsp;State</th>
                        <th class="align-middle bg-success text-white">Choose&nbsp;District</th>
                        <th class="align-middle bg-success text-white">Choose&nbsp;Tehsil</th>
                        <th class="align-middle bg-success text-white">Pin&nbsp;Code</th>
                        <th class="align-middle bg-success text-white">Payment&nbsp;Mode</th>
                        <th class="align-middle bg-success text-white">Bank&nbsp;Trxn&nbsp;ID</th>
                        <th class="align-middle bg-success text-white">Crates</th>
                        <th class="align-middle bg-success text-white">Plant&nbsp;Booked</th>
                        <th class="align-middle bg-success text-white">Plant&nbsp;Rate</th>
                        <th class="align-middle bg-success text-white">Total&nbsp;Billed&nbsp;Amount</th>
                        <th class="align-middle bg-success text-white">Discrount&nbsp;Amount</th>
                        <th class="align-middle bg-success text-white">Recieved&nbsp;Amount</th>
                        <th class="align-middle bg-success text-white">Out&nbsp;standing&nbsp;Amount</th>
                        <th class="align-middle bg-success text-white" style="min-width: 170px;">Expected&nbsp;Delivery&nbsp;Date</th>
                        <th class="align-middle bg-success text-white"  style="min-width: 80px">Actual&nbsp;Delivery&nbsp;Date</th>
                        <th class="align-middle bg-success text-white">Vehicle&nbsp;No.</th>
                        <th class="align-middle bg-success text-white">Contract&nbsp;Status</th>
                        <th class="align-middle bg-success text-white">Productive&nbsp;Plants</th>
                        <th class="align-middle bg-success text-white">Document</th>
                        <th class="align-middle bg-success text-white">Assigned&nbsp;To</th>
                        <th class="align-middle bg-success text-white">Entry&nbsp;made&nbsp;by</th>
                        <th class="align-middle bg-success text-white" style="min-width: 80px">Entry&nbsp;Date</th>
                        <th class="align-middle bg-success text-white" style="min-width: 80px">Comment</th>
                     </tr>
                  </thead>
                  <tbody id="booking_history">
                     <tr>
                        <td colspan="100">
                           No record found..
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="cancelBookingModal" tabindex="1"  style="z-index: 1059"data-bs-backdrop="static" aria-labelledby="cancelBookingModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="cancel_booking" method="post" id="cancel_booking" action="">
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
               <div class="row  hidden " hidden  >
                  <label for="payment_type" class="col-md-5 col-form-label">Payment Type</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="payment_type" name="payment_type" aria-label="Floating label select example"  >
                        <?php
                           if(!empty($payments_types))
                           {
                                   foreach ($payments_types as $payments_type) {
                                       ?>
                        <option value="<?php echo $payments_type->slug;?>" <?php if($payments_type->slug=='cancellation-charge'){ echo "selected";}?> ><?php echo $payments_type->title;?></option>
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
                  <label class="col-md-5 col-form-label"></label>
                  <div class="col-md-7">
                  </div>
               </div>
               <div class="row hidden" hidden>
                  <label for="payment_amount" class="col-md-5 col-form-label">Cancellation Charge</label>
                  <div class="col-md-7">
                     <input type="number" class="form-control-sm form-control" name="cancel_charges" id="cancel_charges" value="0" >
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary btn-sm">Submit</button>
               <input type="hidden" id="booking_status"   name="booking_status"  >
               <input type="hidden" id="custID"   name="custID" value="0"  >
               <input type="hidden" id="farmer_id"   name="farmer_id" value="0"  >
            </div>
         </div>
      </form>
   </div>
</div>
<!-- /.modal -->
<!-- status update modal sample modal content -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-modal="true" role="dialog">
   <div class="modal-dialog ">
      <form class="change_booking_status" method="post" id="change_booking_status" action="<?php echo base_url();?>admin/bookings/1212/status">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white" id="exampleModalLabel">Change booking status</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="mb-3 row">
                  <label for="example-text-input" class="col-md-5 col-form-label">Current Status:</label>
                  <div class="col-md-7">
                     <div class="form-control form-control-sm"> <strong id="current_status">Cancel</strong></div>
                  </div>
               </div>
               <div class="mb-3 row">
                  <label for="example-text-input" class="col-md-5 col-form-label">Update Status:*</label>
                  <div class="col-md-7">
                     <select class=" form-control form-control-sm " id="update_booking_status" name="update_booking_status" aria-label="Floating label select example"  >
                        <option value="" selected>Booking Status</option>
                        <?php
                           if(!empty($bookings_status))
                           {
                                   foreach ($bookings_status as $booking_status) {
                                       ?>
                        <option value="<?php echo $booking_status->slug;?>"><?php echo $booking_status->title;?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
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
               
       //Date range as a button
       $('#daterange').daterangepicker({
           ranges: {
               'All time': [moment('1970-01-01'), moment()],
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                   'month')]
           },
           // startDate: moment().subtract(29, 'days'),
           // endDate  : moment()
           startDate: start,
           endDate: end,
           autoUpdateInput: false,
       });
       $('#daterange').on('apply.daterangepicker', function(ev, picker) {
           var start = picker.startDate;
           var end = picker.endDate;
           if (start.format('DD/MM/YYYY') == '01/01/1970') {
               $('#daterange span').html('All time');
           } else {
               $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
           }
           $('#start_date').val(start.format('Y-MM-DD'));
           $('#end_date').val(end.format('Y-MM-DD'));
           if ('' != start.format('Y-MM-DD')) {
               $('#booking_filter').submit();
           }
       });
       cb(start, end);
   
       function cb(start, end) {
           if (start.format('DD/MM/YYYY') == '01/01/1970') {
               $('#daterange span').html('All time');
           } else {
               $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
           }
           // $('#start_date').val(start.format('Y-MM-DD') );
           // $('#end_date').val(end.format('Y-MM-DD') );
       }
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
   
   
   
   
   jQuery(document).ready(function(){
         
           
            getAllState('advance_state');
            getAllDistrict('advance_district');
            getAllCity('advance_city'); 
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
           hitURL = "<?php echo base_url() ?>admin/bookings/delete",
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
             currentRow.parents('tr').remove();
             if(data.status = true) { alert("successfully deleted"); }
             else if(data.status = false) { alert("deletion failed"); }
             else { alert("Access denied..!"); }
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
   
   function getAllState(state) {
      
      
        var html_content = "";           
    var hitURL = "<?php echo base_url() ?>admin/bookings/get_all_state";
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        dataType:'json',
        success: function (response) {
          if(response.status==1)
         {
            
            var data = response.data;
   
            var html_content = "";
            for (var i = 0; i < data.length; i++)
            {
               var content    = data[i];
               var id         = content.id;
               var name       = content.name;
               var html_content= html_content+"<option value='"+id+"'>"+name+"</option>";
   
   
            }
             $("#"+state).empty();
             $("#"+state).append(html_content);
            
            
            
         }
            
            
        },
        error: function (request, status, error) {
             
             
            
             $("#"+state).empty();
        }
    });
   }
    function getAllDistrict(district) {
       
         var html_content = ""; 
          hitURL = "<?php echo base_url() ?>admin/bookings/get_all_district";
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        dataType:'json',
        success: function (response) {
            if(response.status==1)
         {
             
            var data = response.data;
   
            var html_content = "";
            for (var i = 0; i < data.length; i++)
            {
               var content    = data[i];
               var id         = content.id;
               var name       = content.name;
               var html_content= html_content+"<option value='"+id+"'>"+name+"</option>";
   
   
            }
            console.log(html_content);
             $("#"+district).empty();
             $("#"+district).append(html_content);
            
             
            
         }
        },
        error: function (request, status, error) {
             
             
            
            $("#"+district).empty();
        }
    });
   } 
   function getAllCity(city) {
      
      
      var html_content = ""; 
    hitURL = "<?php echo base_url() ?>admin/bookings/get_all_city";
    $.ajax({
        type: 'GET',
        url: hitURL,
        data: {},
        dataType:'json',
        success: function (response) {
             if(response.status==1)
         {
            
            var data = response.data;
   
            var html_content = "";
            for (var i = 0; i < data.length; i++)
            {
               var content    = data[i];
               var id         = content.id;
               var name       = content.city;
               var html_content= html_content+"<option value='"+id+"'>"+name+"</option>";
   
   
            }
            console.log(html_content);
             $("#"+city).empty();
             $("#"+city).append(html_content); 
            
         }
        },
        error: function (request, status, error) {
             
             
            
            $("#"+city).empty();
        }
    });
   }
   
   
</script>
<!-- Get Databse List -->
<script type="text/javascript">
   var table;
    
   $(document).ready(function() {
      
      //$("#advance_agent_id").select2();
    $("#query-pagination li.page-item a").addClass('page-link');
       //datatables
      /* table = $('#example').DataTable({ 
    
           "processing": true, //Feature control the processing indicator.
           "serverSide": true, //Feature control DataTables' server-side processing mode.
           "order": [], //Initial no order.
    
           // Load data for the table's content from an Ajax source
           "ajax": {
               "url": "<?php echo site_url('admin/booking/ajax_list')?>",
               "type": "POST"
           },
    
           //Set column definition initialisation properties.
           "columnDefs": [
           { 
               "targets": [ 0 ], //first column / numbering column
               "orderable": false, //set not orderable
           },
           ],
    
       });
    */
   });
</script>
<!-- Status Change -->
<script type="text/javascript">
   jQuery(document).ready(function(){
   $("#chkall_booking").click(function(){
        if($("#chkall_booking").is(':checked')){
            $("#filter_booking_status > option").prop("selected", "selected");
            $("#filter_booking_status").trigger("change");
        } else {
            $("#filter_booking_status > option").removeAttr("selected");
            $("#filter_booking_status").trigger("change");
        }
    });
   
   
      $('#booking_date, #booking_status, #crop_status, #delivery_status, #contract, #agent_id, #product_id, #req_delivery_date, #delivery_date').on(
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
   
       $('#booking_filter').submit();
     }
   }
   
</script>