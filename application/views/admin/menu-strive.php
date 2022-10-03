<?php
   
   $role_id = $this->session->userdata('role_id');
   $getEnquiryModule = get_module_byurl('admin/customer/addnew');
   $actionEnquiryRequred = get_module_role($getEnquiryModule['id'],$role_id);

   $getBookingModule = get_module_byurl('admin/bookings');
   $actionBookingRequred = get_module_role($getBookingModule['id'],$role_id);

   $getFarmerModule = get_module_byurl('admin/farmers');
   $actionFarmerRequred = get_module_role($getFarmerModule['id'],$role_id);
   
   $getSalesModule = get_module_byurl('admin/sales');
   $actionSalesRequred = get_module_role($getSalesModule['id'],$role_id);
   
   $getHarvestModule = get_module_byurl('admin/harvesting_management');
   $actionHarvestRequred = get_module_role($getHarvestModule['id'],$role_id);
   
   $getConsultantsModule = get_module_byurl('admin/consultants');
   $actionConsultantsRequred = get_module_role($getConsultantsModule['id'],$role_id);
   
   $getDeliveryModule = get_module_byurl('admin/delivery_management');
   $actionDeliveryRequred = get_module_role($getDeliveryModule['id'],$role_id);
   
   $getPremCustModule = get_module_byurl('admin/farmers?is_premium=1');
   $actionPremCustRequred = get_module_role($getPremCustModule['id'],$role_id);
   
   
   
   /* $action_requred = get_module_role($module_id['id'],$role_id);*/
 
                                 
                              ?>

<div class="container-fluid">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <h5 class="card-header  text-white border-bottom p-0">
                  <div class="row ">
                     <div class="col-sm-12">
                        <div class="d-flex flex-wrap gap-2 table-responsive">
                           <div class="btn-group" role="group" aria-label="Basic example">
                               
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionEnquiryRequred))?base_url().'admin/customer/addnew':'javascript:void();'?>">Enquiry</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionBookingRequred))?base_url().'admin/bookings':'javascript:void();'?>">Booking</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionFarmerRequred))?base_url().'admin/farmers':'javascript:void();'?>">Farmers</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionSalesRequred))?base_url().'admin/sales':'javascript:void();'?>">Sales</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionConsultantsRequred))?base_url().'admin/consultants':'javascript:void();'?>">Consultation</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionHarvestRequred))?base_url().'admin/harvesting_management':'javascript:void();'?>">Harvesting Management</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionDeliveryRequred))?base_url().'admin/delivery_management':'javascript:void();'?>">Delivery Management</a>
                              <a  class="btn my-primary px-4" href="<?php echo (!empty($actionPremCustRequred))?base_url().'admin/farmers?is_premium=1':'javascript:void();'?>">Premium Customer</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </h5>
            </div>
         </div>
      </div>
   </div>