<?php
    $role_id = $this->session->userdata('role_id');

    $getKDocModule = get_module_byurl('admin/kdocuments');
    $actionKDocRequred = get_module_role($getKDocModule['id'],$role_id);

    $getProdcutModule = get_module_byurl('admin/product');
    $actionProdcutRequred = get_module_role($getProdcutModule['id'],$role_id);

    $getAgentModule = get_module_byurl('admin/agents');
    $actionAgentRequred = get_module_role($getAgentModule['id'],$role_id);

    $getCountryModule = get_module_byurl('admin/country');
    $actionCountryRequred = get_module_role($getCountryModule['id'],$role_id);

    $getStateModule = get_module_byurl('admin/state');
    $actionStateRequred = get_module_role($getStateModule['id'],$role_id);

    $getCompanyModule = get_module_byurl('admin/company');
    $actionCompanyRequred = get_module_role($getCompanyModule['id'],$role_id);

    $getCityModule = get_module_byurl('admin/city');
    $actionCityRequred = get_module_role($getCityModule['id'],$role_id);

    $getDistrictModule = get_module_byurl('admin/district');
    $actionDistrictRequred = get_module_role($getDistrictModule['id'],$role_id);

//actionCompanyRequred actionCityRequred actionDistrictRequred
?>
<style type="text/css">
   .card-body .rounded-circle
    {
        height: 120px;
    width: 120px;
    }
    .card-body .bx
    {
        line-height: 120px;
    }
 .card-body .display-2 {
    font-size: 3.5rem;
}
</style>
<div class="page-content">
    <?php include APPPATH.'views/admin/menu-strive.php';?>
    <div class="container-fluid">
        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                     

                                </div>
                            </div>
                        </div>
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
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#cssModal">
                                                <div class="my-card-body icon-box ">
                                                    <div class="text-center">
                                                        <div class="mini-stat-icon  rounded-circle1 bg-primary mb-2">
                                                            <i class="bx bxs-tree text-white display-2"></i>
                                                        </div>
                                                        <h6>CSS</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            
                                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#salesModal">
                                                <div class="my-card-body icon-box ">
                                                    <div class="text-center">
                                                        <div class=" mini-stat-icon  rounded-circle2 bg-success mb-2">
                                                            <i class="bx bx-cart text-white display-2"></i>
                                                        </div>
                                                        <h6>SALES</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <div class="my-card-body icon-box ">
                                                <div class="text-center">
                                                    <div class=" mini-stat-icon  rounded-circle3 bg-info mb-2">
                                                        <i class="bx bxs-shopping-bag text-white display-2"></i>
                                                    </div>
                                                    <h6>PURCHASE</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#productModal">
                                                <div class="my-card-body icon-box ">
                                                    <div class="text-center">
                                                        <div class=" mini-stat-icon  rounded-circle4 bg-success mb-2">
                                                            <i class="bx bxl-product-hunt text-white display-2"></i>
                                                        </div>
                                                        <h6>PRODUCT</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <div class="my-card-body icon-box ">
                                                <div class="text-center">
                                                    <div class=" mini-stat-icon  rounded-circle5 bg-warning mb-2">
                                                        <i class="bx bx-dock-top text-white display-2"></i>
                                                    </div>
                                                    <h6>PO</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     
                                     
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#settingModal">
                                                <div class="my-card-body icon-box ">
                                                    <div class="text-center">
                                                        <div class="mini-stat-icon  rounded-circle6 bg-primary mb-2">
                                                            <i class="bx bx-cog text-white display-2"></i>
                                                        </div>
                                                        <h6>Setting</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card mini-stats-wid">
                                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#otherModal">
                                                <div class="my-card-body icon-box ">
                                                    <div class="text-center">
                                                        <div class="mini-stat-icon  rounded-circle7 bg-primary mb-2">
                                                            <i class="bx bx-plus text-white display-2"></i>
                                                        </div>
                                                        <h6>Other</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card">
                                    <h4 class="card-header bg-success text-white border-bottom ">About Center</h4>
                                    <div class="card-body">
                                     <p class="text-muted mb-4">Hi I'm <?php echo $admin->title;?></p>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row"><strong><i class="fa fa-key"></i> Logged in</strong>
                                                            
                                                        </th>
                                                        <td><p><?php echo $admin->title;?></p></td>
                                                         
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">  <i class="fa fa-phone"></i>  Mobile :</th>
                                                        <td><?php echo $admin->phone;?> </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"> <i class="fa fa-envelope"></i> E-mail</th>
                                                        <td><?php echo $admin->email;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"><strong><i class="fa fa-map-marker-alt"></i> Center</strong></th>
                                                        <td><p><?php echo wordwrap($admin->address,50,"<br>\n");?></p></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"><strong><i class="fa fa-calendar-alt"></i> Date Of Join</strong></th>
                                                        <td><p><?php echo date('d M Y',strtotime($admin->date_join));?></p></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                         
                        <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                 
                <?php $role = $this->session->userdata('role');?>
                <!-- end modal -->
                <!-- start css modal -->
                <div class="modal hide" id="cssModal" tabindex="-1" data-bs-backdrop="static"  aria-labelledby="cssModalLabel" aria-modal="true" role="dialog" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bordered border-success">
                                                        <div class="modal-header bg-success mb-2">
                                                            <h5 class="modal-title text-white" id="cssModalLabel">CSS</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <!---->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionEnquiryRequred))?base_url().'admin/customer/addnew':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle1 bg-primary mb-2">
                                                                                                <i class="bx bx-phone-call text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Inquiry</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div> <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionConsultantsRequred))?base_url().'admin/consultants':'javascript:void();'?>"  >
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle2 bg-success">
                                                                                                <i class="bx bxs-user-voice text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Consultation</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionKDocRequred))?base_url().'admin/kdocuments':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle3 bg-warning">
                                                                                                <i class="bx bxs-file-doc text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>K Document</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>     
                                                                    </div>     
                                                                </div>     
                                                            </div>     
                                                           <!---->     
                                                        </div>
                                                        <div class="modal-footer">
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- start css modal -->
                                    <div class="modal hide" id="salesModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="salesModalLabel" aria-modal="true" role="dialog" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bordered border-success">
                                                        <div class="modal-header bg-success mb-2">
                                                            <h5 class="modal-title text-white" id="salesModalLabel">Sales</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <!---->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionSalesRequred))?base_url().'admin/sales':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle1 bg-primary mb-2">
                                                                                                <i class="bx bx-cart text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Sales</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionBookingRequred))?base_url().'admin/bookings':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle3 bg-success mb-2">
                                                                                                <i class="bx bx-book-bookmark text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Booking</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionKDocRequred))?base_url().'admin/kdocuments':'javascript:void();'?>" >
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle2 bg-warning">
                                                                                                <i class="bx bxs-file-doc text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>K Document</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>  
                                                                    </div>     
                                                                </div>     
                                                            </div>     
                                                           <!---->     
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal hide" id="productModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="productModalLabel" aria-modal="true" role="dialog" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bordered border-success">
                                                        <div class="modal-header bg-success mb-2">
                                                            <h5 class="modal-title text-white" id="productModalLabel">Product</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <!---->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                               <a href="<?php echo (!empty($actionProdcutRequred))?base_url().'admin/product':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon rounded-circle1 bg-primary mb-2">
                                                                                                <i class="bx bxl-product-hunt text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Product</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionSalesRequred))?base_url().'admin/sales':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle2 bg-primary mb-2">
                                                                                                <i class="bx bxs-cart text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Sales</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionFarmerRequred))?base_url().'admin/farmers':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle3 bg-primary mb-2">
                                                                                                <i class="bx bx-group text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Farmer</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                             
                                                                    </div>     
                                                                </div>     
                                                            </div>     
                                                           <!---->     
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal hide" id="settingModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="settingModalLabel" aria-modal="true" role="dialog" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bordered border-success">
                                                        <div class="modal-header bg-success mb-2">
                                                            <h5 class="modal-title text-white" id="settingModalLabel">Settings</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <!---->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                               <a href="<?php echo (!empty($actionAgentRequred))?base_url().'admin/agents':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon rounded-circle1 bg-primary mb-2">
                                                                                                <i class="bx bxs-user-rectangle text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Agents</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionCountryRequred))?base_url().'admin/country':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle2 bg-primary mb-2">
                                                                                                <i class="bx bx-flag text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Country</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionStateRequred))?base_url().'admin/state':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle3 bg-primary mb-2">
                                                                                                <i class="bx bx-grid-vertical text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>State</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionDistrictRequred))?base_url().'admin/district':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle4 bg-primary mb-2">
                                                                                                <i class="bx bx-grid-horizontal text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>District</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionCityRequred))?base_url().'admin/city':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle5 bg-primary mb-2">
                                                                                                <i class="bx bx-dialpad  text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Tehsil</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionCompanyRequred))?base_url().'admin/company':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle6 bg-primary mb-2">
                                                                                                <i class="bx bxs-bank text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Company</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div> 
                                                                             
                                                                    </div>     
                                                                </div>     
                                                            </div>     
                                                           <!---->     
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal hide" id="otherModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="otherModalLabel" aria-modal="true" role="dialog" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bordered border-success">
                                                        <div class="modal-header bg-success mb-2">
                                                            <h5 class="modal-title text-white" id="otherModalLabel">Other</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                           <!---->
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                               <a href="<?php echo (!empty($actionHarvestRequred))?base_url().'admin/harvesting_management':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon rounded-circle1 bg-primary mb-2">
                                                                                                <i class="bx bxs-user-rectangle text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Harvesting Management</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                <a href="<?php echo (!empty($actionDeliveryRequred))?base_url().'admin/delivery_management':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle3 bg-primary mb-2">
                                                                                                <i class="bx bx-flag text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Delivery Management</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="card mini-stats-wid">
                                                                                
                                                                                <a href="<?php echo (!empty($actionPremCustRequred))?base_url().'admin/farmers?is_premium=1':'javascript:void();'?>">
                                                                                    <div class="my-card-body">
                                                                                        <div class="text-center">
                                                                                            <div class="mini-stat-icon  rounded-circle2 bg-primary mb-2">
                                                                                                <i class="bx bx-grid-vertical text-white display-2"></i>
                                                                                            </div>
                                                                                            <h6>Premium Customer</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>     
                                                                </div>     
                                                            </div>     
                                                           <!---->     
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                <!-- end css modal -->

<script type="text/javascript">
    function open_css()
    {
        alert('sss');
    }
</script>