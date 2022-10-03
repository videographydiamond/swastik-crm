
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Login | Customer Support</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="assets/user/images/favicon.ico">
  <!-- Bootstrap Css -->
  <link href="<?php echo base_url(); ?>assets/user/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="<?php echo base_url(); ?>assets/user/css/icons.min.css" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="<?php echo base_url(); ?>assets/user/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Customer Support</h5>
                                            <p>Sign in to continue to Skote.</p>
                                            
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="<?php echo base_url(); ?>assets/user/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">


                                <div class="auth-logo">
                                    <a href="<?php echo base_url(); ?>" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="<?php echo base_url(); ?>assets/user/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="<?php echo base_url(); ?>" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="<?php echo base_url(); ?>assets/user/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
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
                                               
                                          <?php } ?>
                                <div class="p-2">
                                    <form class="form-horizontal" action="<?php echo base_url(); ?>user/login/loginMe" method="post" >
        
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="email" required  class="form-control" id="email" placeholder="Enter Email">
                                        </div>
                
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control" placeholder="Enter password" name="password" id="password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light "   type="button"  ><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                      </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                                 
                                <p>© <script>document.write(new Date().getFullYear())</script> Anil. Crafted with <i class="mdi mdi-heart text-danger"></i> by Megatask</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url(); ?>assets/user/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/user/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/user/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/user/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/user/libs/node-waves/waves.min.js"></script>
        
        <!-- App js -->
        <script src="<?php echo base_url(); ?>assetsadmin/admin/js/app.js"></script>
    </body>

<!-- Mirrored from themesbrand.com/skote/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 11 May 2022 07:54:15 GMT -->
</html>