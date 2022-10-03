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
   .verti-timeline .event-list .event-timeline-dot {
   z-index: 1;
   }
</style>
<!-- Latest compiled and minified CSS -->
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <h5 class="card-header text-white border-bottom p-0">
                  &nbsp;
                  <div class="row ">
                     <div class="col-sm-12">
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
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show " role="alert" >', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></newt_button(left, top, text)></div>'); ?>
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
                              Delivery Management Year Of <?php echo date('Y', strtotime($current_date));?>
                           </div>
                        </div>
                     </h5>
                     <div class="card-body pb-0">
                        <div class="row">
                           <div class="col-sm-2">
                              <ul class="verti-timeline list-unstyled">
                                 <?php
                                    $ince = 0;
                                    $active_start_date = '';
                                    $active_end_date = '';
                                    
                                       foreach ($list_date_ranges as $key => $value)
                                       {
                                           foreach ($value as $key => $values)
                                             {
                                    
                                                $ince++;
                                                if($this->input->get('start_date'))
                                                {
                                                    $active_start_date   = $this->input->get('start_date');
                                                    $active_end_date   = $this->input->get('end_date'); 
                                                }
                                                else if($ince==1)
                                                {
                                                   $active_start_date   = $values['start_date'];
                                                   $active_end_date     = $values['end_date'];
                                                }
                                                  
                                                  $datarange_betw = array();
                                                  $datarange_betw['start_date']   = $values['start_date'];
                                                  $datarange_betw['end_date']     = $values['end_date'];

                                                $get_count_booking_of_date            = get_booking_date_between($datarange_betw);
                                                $get_count_booking_of_date_delivered  = get_booking_date_between($datarange_betw,'delivered');

                                                ?>
                                 <li class="event-list" style="padding: 0 0 5px 30px;">
                                    <div class="event-timeline-dot">
                                       <i class="bx  font-size-18 <?php echo ($active_start_date==$values['start_date'])?'bx-fade-right bxs-right-arrow-circle':'bx-right-arrow-circle';?>"></i>
                                    </div>
                                    <div class="d-flex " >
                                       <div class="flex-shrink-0 me-3">
                                          <h5 class="font-size-13  ">
                                             <a href="<?php echo base_url()?>admin/delivery_management?date_tab=1&start_date=<?php echo $values['start_date'];?>&end_date=<?php echo $values['end_date'];?>"><?php echo date('d M',strtotime($values['start_date']));?> To <?php echo date('d M',strtotime($values['end_date']));?> <?php echo date('Y',strtotime($values['start_date']));?></a>
                                             &nbsp;<?php if($get_count_booking_of_date_delivered >0) { ?><span class="badge rounded-pill bg-success"><?php echo @$get_count_booking_of_date_delivered;?></span> <?php }  if($get_count_booking_of_date>0){?><span class="badge rounded-pill bg-warning"><?php echo @$get_count_booking_of_date;?></span><?php } ?>
                                          </h5>

                                       </div>
                                    </div>
                                 </li>
                                 <?php   
                                    }
                                    
                                    
                                    }
                                    ?>
                              </ul>
                           </div>
                           <div class="col-sm-10">
                              <?php 
                                 $get_booking_root = get_booking_root();
                                 $active_root_id = 0;
                                 if(!empty($get_booking_root))
                                 {
                                    ?>
                              <ul class="nav nav-tabs" role="tablist">
                                 <?php
                                    $menu_inc = 0;
                                    
                                    foreach ($get_booking_root as $key => $value) 
                                    {
                                         $menu_inc++;
                                         if($this->input->get('active_root_id'))
                                         {
                                             $active_root_id = $this->input->get('active_root_id');
                                         }else if($menu_inc==1)
                                         {
                                             $active_root_id = $value['id'];
                                         }
                                    
                                    
                                    
                                        ?>
                                 <li class="nav-item">
                                    <a class="nav-link <?php echo ($active_root_id==$value['id'])?'active':'';?>"   href="<?php echo base_url()?>admin/delivery_management?date_tab=<?php echo $this->input->get('date_tab');?>&start_date=<?php echo $this->input->get('start_date');?>&end_date=<?php echo $this->input->get('end_date');?>&active_root_id=<?php echo $value['id'];?>" role="tab" data-userid="<?php echo $value['id'];?>"  data-active_start_date="<?php echo $active_start_date;?>"  data-active_end_date="<?php echo $active_end_date;?>">
                                    <span  ><?php echo $value['name']; ?></span>    
                                    </a>
                                 </li>
                                 <?php
                                    }
                                    ?>
                              </ul>
                              <?php
                                 }
                                 
                                 
                                 
                                 ?>
                              <div class="tab-content p-3 text-muted">
                                 <div class="tab-pane active"   role="tabpanel">
                                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                       <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                          <table class="table table-striped align-middle table-nowrap mb-0" id="example">
                                             <thead class="table-light">
                                                <tr>
                                                   <th>City Name</th>
                                                   <th>Total (Booking To Be Deliver)</th>
                                                   <th>Total (Booking Delivered)</th>
                                                 </tr>
                                             </thead>
                                             <tbody id="delivery_list">
                                              <?php 
                                                $booking_roots = booking_roots($active_root_id);
                                                
                                                if(!empty($booking_roots))
                                                {
                                                  foreach ($booking_roots as $key => $value) 
                                                {

 
                                                  ?>
                                                    <tr>
                                                       <td><?php 
                                                       switch ($value['edge']) {
                                                         case 'start':
                                                           ?><span class="badge rounded-pill bg-success float-start">S</span><?php
                                                           break;
                                                         case 'end':
                                                           ?><span class="badge rounded-pill bg-danger  float-start">E</span><?php
                                                           break;
                                                         
                                                         default:
                                                           ?><span class="badge rounded-pill bg-primary  float-start">P</span><?php
                                                           break;
                                                       }
                                                       ?>
                                                       <a href="<?php echo base_url()?>admin/delivery_management?date_tab=<?php echo $this->input->get('date_tab');?>&start_date=<?php echo $this->input->get('start_date');?>&end_date=<?php echo $this->input->get('end_date');?>&active_root_id=<?php echo $active_root_id;?>&section=booking&city=<?php echo $value['city_id'];?>"><?php echo $value['root_point'];?></a>

                                                       <?php
                                                        
                                                 
                                                       $to_be_deliver = to_be_deliver($value['route_id'],$value['city_id'],$active_start_date,$active_end_date,'');
                                                       $delivered = to_be_deliver($value['route_id'],$value['city_id'],$active_start_date,$active_end_date,'delivered');


                                                       ?></td>
                                                       <td>
                                                        <a href="<?php echo base_url()?>admin/delivery_management?date_tab=<?php echo $this->input->get('date_tab');?>&start_date=<?php echo $this->input->get('start_date');?>&end_date=<?php echo $this->input->get('end_date');?>&active_root_id=<?php echo $active_root_id;?>&section=booking&city=<?php echo $value['city_id'];?>"><span class="badge rounded-pill bg-success"><?php echo count($to_be_deliver);?></span></a>
                                                       </td>

                                                       <td>
                                                        <a href="<?php echo base_url()?>admin/delivery_management?date_tab=<?php echo $this->input->get('date_tab');?>&start_date=<?php echo $this->input->get('start_date');?>&end_date=<?php echo $this->input->get('end_date');?>&active_root_id=<?php echo $active_root_id;?>&section=booking&status=delivered&city=<?php echo $value['city_id'];?>"><span class="badge rounded-pill bg-success"><?php echo count($delivered);?></span></a>

                                                        </td>
                                                     </tr>
                                                  <?php
                                                }  
                                                }else
                                                {
                                                  ?>
                                                    <tr>
                                                       <td colspan="100">
                                                          No record found..
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
                              </div>
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

                                       <th class="align-middle bg-success text-white">Expected Delivery Date </th>
                                       <th class="align-middle bg-success text-white">Actual Delivery Date</th>
                                       <th class="align-middle bg-success text-white">Vehicle No.</th>
                                       <th class="align-middle bg-success text-white">Choose State</th>
                                       <th class="align-middle bg-success text-white">Choose District</th>
                                       <th class="align-middle bg-success text-white">Choose Tehsil</th>
                                       <th class="align-middle bg-success text-white">Pin Code</th>


                                       <th class="align-middle bg-success text-white">Order Status</th>
                                       <th class="align-middle bg-success text-white">Crop Status</th>
                                       <th class="align-middle bg-success text-white">Farmer ID</th>
                                       <th class="align-middle bg-success text-white">Name</th>
                                       <th class="align-middle bg-success text-white">Executive</th>
                                       <th class="align-middle bg-success text-white">Choose Product</th>
                                       <th class="align-middle bg-success text-white">Primary Number</th>
                                       <th class="align-middle bg-success text-white">Number</th>
                                       <th class="align-middle bg-success text-white">Billing Address</th>

                                       

                                       <th class="align-middle bg-success text-white">Payment Mode</th>
                                       <th class="align-middle bg-success text-white">Bank Trxn ID</th>
                                       <th class="align-middle bg-success text-white">Crates</th>
                                       <th class="align-middle bg-success text-white">Plant Booked</th>
                                       <th class="align-middle bg-success text-white">Plant Rate</th>
                                       <th class="align-middle bg-success text-white">Total Billed Amount</th>
                                       <th class="align-middle bg-success text-white">Discrount Amount</th>
                                       <th class="align-middle bg-success text-white">Recieved Amount</th>
                                       <th class="align-middle bg-success text-white">Out standing Amount</th>
                                       
                                       <th class="align-middle bg-success text-white">Contract Status</th>
                                       <th class="align-middle bg-success text-white">Productive Plants</th>
                                       <th class="align-middle bg-success text-white">Document</th>
                                       <th class="align-middle bg-success text-white">Assigned To</th>
                                       <th class="align-middle bg-success text-white">Entry made by</th>
                                       <th class="align-middle bg-success text-white">Entry Date</th>
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
                                                    
                                                    if(@$action_requred->view =='view'){
                                                      ?>
                                                           

                                                         <a class="dropdown-item btn" target="_BLANK" href="<?php echo base_url()?>admin/bookings/receipt/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> Generate Receipt</a>
                                                         <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/view/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View Order Details</a>
                                                         <a class="dropdown-item btn"  target="_BLANK" href="<?php echo base_url()?>admin/bookings/agreement/<?php echo $bookings['id']; ?>" data-userid="<?php echo $bookings['id']; ?>"><i class="fa fa-file-excel" aria-hidden="true"></i> Generate Agreement</a>
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
                                       <td><?php echo (isset($bookings['other_state']) && !empty($bookings['other_state']))?($bookings['other_state']):($bookings['state']);?></td>
                                       <td><?php echo (isset($bookings['other_district']) && !empty($bookings['other_district']))?($bookings['other_district']):($bookings['district']);?></td>
                                       <td><?php echo (isset($bookings['other_city']) && !empty($bookings['other_city']))?($bookings['other_city']):($bookings['city']);?></td>
                                       <td><?php echo $bookings['pincode'];?></td>


                                       <td><span class="badge bg-<?php echo $bookings['booked_badges'];?> "><?php echo $bookings['booked_status'];?></span></td>
                                       <td><?php echo $bookings['cropstatusname'];?></td>
                                       <td><?php echo $bookings['farmer_id'];?></td>
                                       <td><?php echo $bookings['customername'];?></td>
                                       <td><?php echo $bookings['executive'];?></td>
                                       <td><?php echo $bookings['productname'];?></td>
                                       <td><?php echo $bookings['customermobile'];?></td>
                                       <td><?php echo $bookings['customeraltmobile'];?></td>
                                       <td><?php echo $bookings['billing_address'];?></td>
                                       
                                       <td><?php echo $bookings['paymentmodename'];?></td>
                                       <td><?php echo $bookings['bank_trans_id'];?></td>
                                       <td><?php echo $bookings['crates'];?></td>
                                       <td><?php echo $bookings['quantity'];?></td>
                                       <td><?php echo $bookings['price'];?></td>
                                       <td><?php echo $bookings['total'];?></td>
                                       <td><?php echo $bookings['discount'];?></td>
                                       <td><?php echo $bookings['total_paid_amount'];?></td>
                                       <td><span class='<?php if($bookings['outstanding_amount'] <0){ echo "text-danger";}?>'><?php echo $bookings['outstanding_amount'];?></span></td>
                                       
                                       
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
                                       <td colspan="100">Bookings (s) not found...
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
<script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.js"></script>
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