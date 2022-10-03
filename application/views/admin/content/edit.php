<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <a href="<?php echo base_url();?>admin/content"> <i class="fa fa-file-text-o" aria-hidden="true"></i> Page Content</a>
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
                    
                   <form role="form" id="member_form" action="<?php echo base_url() ?>admin/content/update" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                     
                                    <!--Plan name-->                             
                                    <div class="form-group">
                                        <label for="page_url">Page Url</label>
                                        <input type="text" id="page_url" name ="page_url" class="form-control" required="required" placeholder="Exmp: Ale-izba/printers/hp_printer_support " value="<?php echo $edit_data->page_url; ?>" >
                                    </div>
                                    <!--Meta Title -->                             
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" id="meta_title" name ="meta_title" class="form-control" required="required" placeholder="Meta Title" value="<?php echo $edit_data->meta_title; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <!--Meta Keyword -->                             
                                    <div class="form-group">
                                        <label for="meta_keyword">Meta Keyword</label>
                                        <input type="text" id="meta_keyword" name ="meta_keyword" class="form-control" required="required" placeholder="Meta Keyword"  value="<?php echo $edit_data->meta_keyword; ?>" >
                                    </div>
                                     <!--Meta Description -->                             
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <input type="text" id="meta_description" name ="meta_description" class="form-control" required="required" placeholder="Meta Description" value="<?php echo $edit_data->meta_description; ?>"  >
                                    </div>
                                </div>

                                <div class="col-md-12">  
                                    <!-- Content-->
                                    <div class="form-group">
                                        <label for="content">Write Content </label>
                                        <textarea rows="20" id="content" name ="content" class="form-control content_textarea" placeholder="Write There Page Content"><?php echo $edit_data->content; ?></textarea>
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
 
 
<!-- editor-->

<script src="<?php echo base_url();?>assets/jQueryUI/jquery-ui-1.10.3.min.js"></script>  

<link rel="stylesheet" href="<?php echo base_url();?>assets/rich_jq_editor/src/richtext.min.css">
<script src="<?php echo base_url();?>assets/rich_jq_editor/src/jquery.richtext.js"></script>
<script>
$(document).ready(function() {
    $('.content_textarea').richText();
});
</script>

