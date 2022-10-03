<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <a href="<?php echo base_url();?>admin/plan"> <i class="fa fa-columns" aria-hidden="true"></i> Plan</a>
        <small>Add New Plan</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add New Admin Plan</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="member_form" action="<?php echo base_url() ?>admin/plan/insertnow" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                     
                                    <!--Plan name-->                             
                                    <div class="form-group">
                                        <label for="name">Plan Name</label>
                                        <input type="text" id="name" name ="name" class="form-control" required="required" placeholder="Enter Name" >
                                    </div>
                                  
                                    <!-- Price-->
                                    <div class="form-group">
                                         <label for="text">Plan Price</label>
                                        <input type="text" id="price" name ="price" class="form-control" required="required"  placeholder="Enter Price Exmp: $100/m" >
                                    </div> 
									 <!-- Service 1-->
                                    <div class="form-group">
                                         <label for="service1">Service</label>
                                        <input type="text" id="service1" name ="service1" class="form-control" placeholder="Enter Service Examp: Support for 2 PC" required>
                                    </div>
									<!-- Service 2-->
                                    <div class="form-group">
                                         <label for="service2">Service</label>
                                        <input type="text" id="service2" name ="service2" class="form-control" placeholder="Enter Service 2nd Examp: 1 Incident"  required >
                                    </div>
                                </div>
                                <div class="col-md-6">     
                                   
                                    <!-- address-->
                                    <div class="form-group">
                                        <label for="desc">Description </label>
                                        <textarea rows="8" id="desc" name ="desc" class="form-control" placeholder="About Plan (Optional)"></textarea>
                                    </div>
                                   
                                </div>
                             </div>
                             
                             
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>

