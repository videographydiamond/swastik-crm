<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="<?php echo base_url();?>admin/plan"> <i class="fa fa-columns" aria-hidden="true"></i> Plan</a>
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
                    
                   <form role="form" id="member_form" action="<?php echo base_url() ?>admin/plan/update" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                     
                                    <!--Plan name-->                             
                                    <div class="form-group">
                                        <label for="name">Plan Name</label>
                                        <input type="text" id="name" name ="name" class="form-control" required="required" placeholder="Enter Name" value="<?php echo $edit_data->name;?>"  >
                                    </div>
                                  
                                    <!-- Price-->
                                    <div class="form-group">
                                         <label for="text">Plan Price</label>
                                        <input type="text" id="price" name ="price" class="form-control" required="required"  placeholder="Enter Price Exmp: $100/m" value="<?php echo $edit_data->price;?>" >
                                    </div> 
									 <!-- Service 1-->
                                    <div class="form-group">
                                         <label for="service1">Service1</label>
                                        <input type="text" id="service1" name ="service1" class="form-control" placeholder="Enter Service Examp: Support for 2 PC" value="<?php echo $edit_data->service1;?>" required>
                                    </div>
									<!-- Service 2-->
                                    <div class="form-group">
                                         <label for="service2">Service2</label>
                                        <input type="text" id="service2" name ="service2" class="form-control" placeholder="Enter Service 2nd Examp: 1 Incident" value="<?php echo $edit_data->service2;?>"  required >
                                    </div>
                                </div>
                                <div class="col-md-6">     
                                   
                                    <!-- address-->
                                    <div class="form-group">
                                        <label for="desc">Description </label>
                                        <textarea rows="8" id="desc" name ="desc" class="form-control" placeholder="About Plan (Optional)"><?php echo $edit_data->desc;?></textarea>
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
