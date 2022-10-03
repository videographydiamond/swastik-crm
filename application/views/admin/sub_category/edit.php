<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <a href="<?php echo base_url();?>admin/sub_category"> <i class="fa fa-sitemap" aria-hidden="true"></i> SubCategory</a>
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
                    
                   <form role="form" id="member_form" action="<?php echo base_url() ?>admin/sub_category/update" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                             <div class="col-md-6">
									<!--Status-->
                                    <div class="form-group">
                                         <label for="category_id">Select Category</label>
                                         <select class ="form-control" name="category_id" id="category_id">
											<?php foreach($category_list as $k=>$v){?>
											<option value="<?php echo $v->id;?>" <?php echo ($edit_data->category_id == $v->id)?'selected':''; ?>  ><?php echo $v->name;?></option>
											<?php } ?>
											
										</select>	
                                    </div> 
                                    <!--name-->                             
                                    <div class="form-group">
                                        <label for="name">Sub Category Name</label>
                                        <input type="text" id="name" name ="name" class="form-control" required="required" placeholder="Enter Category Name"  value="<?php echo $edit_data->name; ?>" >
                                    </div> 
									<!--Category Icon-->                             
                                    <div class="form-group">
                                        <label for="image">Icon Image</label>
                                        <input type="file" id="image" name ="image" class="form-control"  placeholder="Choose Sub Category Image"  >
										
										<!-- image check-->
										<?php if(!empty($edit_data->image)){ ?>
											<span id="old_img_con" >Icon Is : <?php echo $edit_data->image; ?>&nbsp;&nbsp;&nbsp;<i class="text-danger fa fa-trash pinter delete_old_image"></i></span>
										<?php } ?>
										<input type="hidden" name="old_image" id="old_image" value="<?php echo $edit_data->image; ?>"/>
										
                                    </div>
                                   <!--Status-->
                                    <div class="form-group">
                                         <label for="status">Status</label>
                                         <select class ="form-control" name="status" id="status">
											<option value="1" <?php echo ($edit_data->status == 1)?'selected':''; ?> >Active</option>
											<option value="0" <?php echo ($edit_data->status == 0)?'selected':''; ?> >Inactive</option>
										</select>	
                                    </div> 
                                 </div> 
                                    
                                <div class="col-md-6">     
                                    <!-- About  -->
                                    <div class="form-group">
                                         <label for="about">About Sub Category</label>
                                        <textarea  rows="8" id="about" name ="about" class="form-control" placeholder="About Sub Category" ><?php echo $edit_data->about; ?></textarea>
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

<script>
	$(".delete_old_image").click(function(){
		$("#old_img_con").addClass('hidden');
		$("#old_image").val('');
	});
</script>
