
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Login | Customer Support</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/favicon.ico">
  <!-- Bootstrap Css -->
  <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="<?php echo base_url(); ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <style>
    .logo-adjust
    {
      background-color: #fff !important;
    }
  </style>
</head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                             
                            <div class="card-body pt-0" style="background: #dae3cb;">


                                <div class="auth-logo">
                                    <a href="<?php echo base_url(); ?>" class="auth-logo-light">
                                        <div class="  mb-4 pt-5">
                                            <span class="avatar-title" style="background-color: #556ee600">
                                                <img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt="" height="200">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="<?php echo base_url(); ?>" class="auth-logo-dark">
                                        <div class="  mb-4 pt-5">
                                            <span class="avatar-title"  style="background-color: #556ee600" >
                                                <img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt=""  height="200">
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
                                    <form class="form-horizontal custom-validation" action="<?php echo base_url(); ?>admin/login/loginMe" method="post" autocomplete="off" novalidate >
        
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>

                                            <div class="row">
                                              <div class="col-sm-12">
                                                <input type="email" name="email" required  class="form-control" parsley-type="email" required  id="email" placeholder="Enter Email" autocomplete="off" value="<?php echo set_value('email',$this->session->userdata('login_email'));?>">
                                              </div>
                                              
                                            </div>
                                        </div>
                
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            
                                            <div class="row">
                                              <div class="col-sm-10 col-10 ">
                                                <input type="password" class="form-control" required placeholder="Enter password" name="password" id="password" aria-label="Password" aria-describedby="password-addon" autocomplete="off" value="<?php echo set_value('password',$this->session->userdata('login_password'));?>">
                                              </div>
                                              <div class="col-sm-2 col-2 ">
                                                <div class="input-group auth-pass-inputgroup">
                                                <button class="btn btn-light "  onclick="password_toggle('password','login_eye')"  type="button"  ><i id="login_eye" class="fas fa-eye"></i></button>
                                               </div>    
                                              </div>
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
        <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/libs/parsleyjs/parsley.min.js"></script>
         

        <!-- App js -->
        <script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>
        <script type="text/javascript">
          function password_toggle(inputpass,togglepass)
          {
            const togglePassword = document.querySelector('#'+togglepass);
            const password = document.querySelector('#'+inputpass);

             
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            togglePassword.classList.toggle('fa-eye-slash');
             
          }
          $(document).ready(function(){
            $(".custom-validation").parsley()
          });
        </script>
    </body>

<!-- Mirrored from themesbrand.com/skote/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 11 May 2022 07:54:15 GMT -->
</html>