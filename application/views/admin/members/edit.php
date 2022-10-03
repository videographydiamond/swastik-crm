<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="<?php echo base_url();?>admin/members"> <i class="fa fa-users" aria-hidden="true"></i> Member</a>
        <small>Edit</small>
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
                       
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                   <form role="form" id="member_form" action="<?php echo base_url() ?>admin/members/update" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- user type-->
                                    <div class="form-group">
                                        <label for="admin_type">Admin Type</label>
                                         <select class=" form-control" id="admin_type" name="admin_type" placeholder="Select Admint Type" required="required">
                                            <option value="1" value="1" <?php echo ($edit_data->admin_type == 1)?'selected':''; ?> >Administrator</option>
                                            <option value="0" value="1" <?php echo ($edit_data->admin_type == 0)?'selected':''; ?> >Sub Admin</option>
                                               
                                        </select> 
                                    </div>       
                                    <!--first name-->                             
                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input type="text" id="name" name ="name" class="form-control" required="required" placeholder="Enter Name" value="<?php echo $edit_data->name; ?>" >
                                    </div>
                                  
                                    <!-- email-->
                                    <div class="form-group">
                                         <label for="email">Email</label>
                                        <input type="email" id="email" name ="email" class="form-control" required="required"  placeholder="Enter Email" value="<?php echo $edit_data->email; ?>" >
                                    </div> 
									 <!-- phone-->
                                    <div class="form-group">
                                         <label for="phone">Phone</label>
                                        <input type="text" id="phone" name ="phone" class="form-control" placeholder="Enter Phone Number" maxlength="10" value="<?php echo $edit_data->phone; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">     
                                   
                                    <!-- address-->
                                    <div class="form-group">
                                         <label for="address">Address</label>
                                        <input type="text" id="address" name ="address" class="form-control" placeholder="Enter Address" value="<?php echo $edit_data->address; ?>">
                                    </div>
                                    <!-- Password-->
                                    <div class="form-group">
                                         <label for="password">Set Password</label>
                                        <input type="text" id="password" name ="password" class="form-control" required="required" placeholder="Set Password" value="<?php echo $edit_data->password; ?>" >
                                    </div>
									 <!--Status-->
                                    <div class="form-group">
                                         <label for="status">Status</label>
                                         <select class ="form-control" name="status" id="status">
											<option value="1" value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
											<option value="0" value="1" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
										</select>	
                                    </div> 
                                </div>
                             </div>
                             
                             
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?php echo $edit_data->id; ?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
</div>
 
<script src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>  
