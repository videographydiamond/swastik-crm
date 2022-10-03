<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Swastik | <?php echo $pageTitle; ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content=" Admin & Dashboard Template" name="description" />
      <meta content="Themesbrand" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico">
      <!-- Bootstrap Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/admin/libs/daterange/daterangepicker.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/admin/libs/toastr/build/toastr.min.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
      <style type="text/css">
         #loader {
         display: none;
         position: fixed;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         width: 100%;
         background: rgba(0,0,0,0.75) url(<?php echo base_url()?>assets/admin/images/loading.gif) no-repeat center center;
         z-index: 10000;
         }
      </style>
   </head>
   <body data-sidebar="dark"  class="sidebar-enable vertical-collpsed">
      <div id="layout-wrapper">
      <header id="page-topbar">
         <div class="navbar-header">
            <div class="d-flex">
               <!-- LOGO -->
               <div class="navbar-brand-box" style="padding: 0">
                  <a href="<?php echo base_url(); ?>admin" class="logo logo-dark">
                  <span class="logo-sm">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo.svg" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo-dark.png" alt="" height="17">
                  </span>
                  </a>
                  <a href="<?php echo base_url(); ?>admin" class="logo logo-light">
                  <span class="logo-sm">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo-light.png" alt="" height="40">
                  </span>
                  <span class="logo-lg">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo-light.png" alt="" height="80">
                  </span>
                  </a>
               </div>
               <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
               <i class="fa fa-fw fa-bars"></i>
               </button>
               <div class="dropdown d-none d-lg-inline-block  d-sm-inline-block ms-1">
                            <button type="button" onclick="javascript:window.location.href='<?php echo base_url()?>admin/dashboard'" class="btn header-item "  >
                                <div class="text-info fs-1">HostBooks</div>
                            </button>
                        </div>
              
                
                
            </div>
            <div class="d-flex">
               <div class="dropdown d-inline-block d-lg-none ms-2">
                  <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-magnify"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-search-dropdown">
                     <form class="p-3">
                        <div class="form-group m-0">
                           <div class="input-group">
                              <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                              <div class="input-group-append">
                                 <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="dropdown d-none d-lg-inline-block ms-1">
                  <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                  <i class="bx bx-fullscreen"></i>
                  </button>
               </div>
               <div class="dropdown d-inline-block">
                  <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-bell bx-tada"></i>
                  <span class="badge bg-danger rounded-pill">0</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                     <div class="p-3">
                        <div class="row align-items-center">
                           <div class="col">
                              <h6 class="m-0" key="t-notifications"> Notifications </h6>
                           </div>
                           <div class="col-auto">
                              <a href="#!" class="small" key="t-view-all"> View All</a>
                           </div>
                        </div>
                     </div>
                     <div data-simplebar style="max-height: 230px;">
                         
                     </div>
                     <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span> 
                        </a>
                     </div>
                  </div>
               </div>
               <div class="dropdown d-inline-block">
                  <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="rounded-circle header-profile-user" src="<?php echo base_url(); ?>assets/admin/images/users/avatar-1.jpg"
                     alt="Header Avatar">
                  <span class="d-none d-xl-inline-block ms-1" key="t-henry">
                  <?php echo @$this->session->userdata('name')?>
                  </span>
                  <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                     <!-- item-->
                     <a class="dropdown-item" href="<?php echo base_url()?>admin/dashboard"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                     <a class="dropdown-item" href="<?php echo base_url()?>admin/profile/edit"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Edit Profile</span></a>
                     <a class="dropdown-item d-block" href="<?php echo base_url()?>admin/profile/change_passowrd"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Change Password</span></a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item text-danger" href="<?php echo base_url()?>admin/login/logout"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- ========== Left Sidebar Start ========== -->
      <div class="vertical-menu">
         <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
               <!-- Left Menu Start -->
               <ul class="metismenu list-unstyled" id="side-menu">

                  <?php

                        $userid = $this->session->userdata('userId');

                        $menu_data =  menu_with_auth(0,$userid );
                        $maped_manu =  array();

                        if(!empty($menu_data))
                        {
                            $i = 0;
                            foreach ($menu_data as $key) 
                            {
                              $menu_data2 =  menu_with_auth($key['moduleid'],$userid );
 
                                ?>
                                 <li>
                                       <a  href="<?php echo ($key['menu_url'] !=="#") ? (base_url()."".$key['menu_url']) : ('javascript: void(0);');?>"   <?php if(!empty($menu_data2)){ ?> class="has-arrow waves-effect"   <?php } ?> >
                                          <?php echo ((strlen($key['icon_class'])>0) ? ('<i class="'.$key['icon_class'].'"></i>') : (''));?>
                                          <span key="t-ecommerce"><?php echo $key['menu_title']; ?></span>
                                       </a>
                                       <?php 
                                          if(!empty($menu_data2))
                                            {

                                             ?>
                                             <ul class="sub-menu" aria-expanded="false">
                                             <?php
                                                $j= 0;
                                               
                                                foreach ($menu_data2 as $key2) 
                                                {
                                                   $menu_data3 =  menu_with_auth($key2['moduleid'],$userid );
                                                   ?>

                                                         <li>
                                                             <a  href="<?php echo ($key2['menu_url'] !=="#") ? (base_url()."".$key2['menu_url']) : ('javascript: void(0);');?>"  key="t-products" <?php if(!empty($menu_data3)){ ?> class="has-arrow"  <?php } ?> >
                                                               <?php echo (strlen($key2['icon_class']) >0) ? ('<i class="'.$key2['icon_class'].'"></i>') : ('');?>
                                                                <?php echo $key2['menu_title']; ?> 
                                                            </a>

                                                            <?php

                                                               if(!empty($menu_data3))
                                                                 {

                                                                  ?>
                                                                  <ul class="sub-menu" aria-expanded="false">
                                                                  <?php
                                                                     $j= 0;
                                                                    
                                                                     foreach ($menu_data3 as $key3) 
                                                                     {
                                                                         
                                                                        ?>

                                                                              <li>
                                                                                  <a  href="<?php echo ($key3['menu_url'] !=="#") ? (base_url()."".$key3['menu_url']) : ('javascript: void(0);');?>"  key="t-products"  >
                                                                                    <?php echo (strlen($key3['icon_class']) >0 ) ? ('<i class="'.$key3['icon_class'].'"></i>') : ('');?>
                                                                                     <?php echo $key3['menu_title']; ?> 
                                                                                 </a>


                                                                              </li>
                                                                              
                                                                           
                                                                        <?php
                                                                     }

                                                                     ?>
                                                                        </ul>
                                                                     <?php
                                                                      
                                                                 }

                                                             ?>
                                                         </li>
                                                         
                                                      
                                                   <?php
                                                }

                                                ?>
                                                   </ul>
                                                <?php
                                                 
                                            }
                                       ?>
                                    </li>
                                <?php
                                 
                                 
                                 
                                
                            }
                        }
                          
                      

                  ?>
                  <!-- <li>
                     <a  href="<?php echo base_url()?>admin/dashboard"   class="waves-effect">
                     <i class="bx bx-home-circle"></i>
                     <span key="t-dashboards"> Dashboard</span>
                     </a>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-support"></i>
                     <span key="t-ecommerce">Customer Support</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a  href="<?php echo base_url()?>admin/bookings" key="t-products">Booking</a></li>
                        <li><a  href="#" key="t-products">Delivery Management</a></li>
                        <li><a  href="<?php echo base_url()?>admin/consultants" key="t-products">Consultation</a></li>
                        <li><a  href="#" key="t-products">Harvesting Management</a></li>
                        <li><a  href="<?php echo base_url()?>admin/farmers?is_premium=1"  key="t-products">Premium Customer</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-cart"></i>
                     <span key="t-ecommerce">Sales</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a   href="<?php echo base_url('admin/sales');?>" key="t-products">Sales</a></li>
                        <li><a   href="#" key="t-products">RazorPay Sales</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-shopping-bag"></i>
                     <span key="t-ecommerce">Purchase</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a   href="#" key="t-products">Add New Purchase</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-group"></i>
                        <span key="t-ecommerce">Farmers</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo base_url('admin/customer/addnew');?>" key="t-products">Add New Farmers</a></li>
                        <li><a href="<?php echo base_url('admin/farmers');?>" key="t-products">Farmers</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                     <i class="bx bxs-file-doc"></i>
                     <span key="t-ecommerce">Documents</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li><a   href="<?php echo base_url('admin/kdocuments');?>" key="t-products">K Documents</a></li>
                        <li><a   href="#" key="t-products">SOP</a></li>
                        <li><a   href="#" key="t-products">Manuals</a></li>
                     </ul>
                  </li>
                  <?php 
                     $role = $this->session->userdata('role');
                     
                     if($role==1)
                     {
                     
                     
                      ?>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        
                     <span key="t-ecommerce">Settings</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li>
                           <a   href="javascript: void(0);" key="t-products"  class="has-arrow" >Access Mgt</a>
                           <ul class="sub-menu" aria-expanded="true" style="">
                              <li><a href="<?php echo base_url('admin/modules');?>" >Manage Modeule</a></li>
                              <li><a href="<?php echo base_url('admin/roles');?>" >Manage Role</a></li>
                              <li><a href="<?php echo base_url('admin/user_role');?>" >Manage User Role</a></li>
                           </ul>
                        </li>
                        <li><a   href="<?php echo base_url('admin/company');?>" key="t-products">Company</a></li>
                        <li><a   href="<?php echo base_url('admin/category');?>" key="t-products">Category</a></li>
                        <li><a   href="<?php echo base_url('admin/product');?>" key="t-products">Product</a></li>
                        <li><a   href="<?php echo base_url('admin/agents');?>" key="t-products">Agents Mgt</a></li>
                        <li><a   href="<?php echo base_url('admin/country');?>" key="t-products">Country</a></li>
                        <li><a   href="<?php echo base_url('admin/state');?>" key="t-products">State</a></li>
                        <li><a   href="<?php echo base_url('admin/district');?>" key="t-products">District</a></li>
                        <li><a   href="<?php echo base_url('admin/city');?>" key="t-products">Tehsil</a></li>
                        <li><a   href="<?php echo base_url('admin/document_category');?>" key="t-products">K Documents Category</a></li>
                         
                     </ul>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                     <span key="t-ecommerce">Type</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        
                        <li><a   href="<?php echo base_url('admin/farmer_type');?>" key="t-products">Farmer Type</a></li>
                        <li><a   href="<?php echo base_url('admin/call_type');?>" key="t-products">Call Type</a></li>
                        <li><a   href="<?php echo base_url('admin/crop_type');?>" key="t-products">Crop Type</a></li>
                     </ul>
                  </li>
                  <?php
                     }
                     ?>
                  <li  >
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                     <i class="bx bx-user"></i>
                     <span key="t-ecommerce">Profile</span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false"  >
                        <li><a href="<?php echo base_url('admin/profile/edit');?>" key="t-products">Edit Profile</a></li>
                        <li><a href="<?php echo base_url('admin/profile/change_passowrd');?>" key="t-products">Change Password</a></li>
                     </ul>
                  </li> -->
               </ul>
            </div>
            <!-- Sidebar -->
         </div>
      </div>
      <!-- Left Sidebar End -->
      <div class="main-content">
      <div class="row" hidden>
         <div class="col-sm-12">
            <?php
               include 'menu.php';
               ?>  
         </div>
      </div>