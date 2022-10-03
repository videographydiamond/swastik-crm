<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <a href="<?php echo base_url();?>admin/email_template"> <i class="fa fa-envelope" aria-hidden="true"></i> Email Template</a>
        <small>Add New Email Template</small>
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
                        <h3 class="box-title">Add New Email Template</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="member_form" action="<?php echo base_url() ?>admin/email_template/insertnow" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Name *</label>
                                        <input type="text"   required="required" class="form-control required" id="name" name="name" maxlength="228">
                                    </div>

                                </div>                                 
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Subject *</label>
                                        <input type="text"   required="required" class="form-control required" id="subject" name="subject" maxlength="228">
                                    </div>                                    
                                </div>                                 
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Message</label>
                                        <textarea class="form-control required text-description" id="message"  name="message" ></textarea>
                                        <small>Please write a HTML message.</small>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Hint *</label>
                                        <input type="text"   required="required" class="form-control required" id="hint" name="hint" maxlength="228">
                                    </div>                                    
                                </div> 
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Status</label>
                                        <select name="status" id="status" class="selectpicker form-control" >
                                            <option value="1">Active</option>
                                            <option value="0">InActive</option>
                                        </select>
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

<script src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>  
<!-- editor-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/rich_jq_editor/src/richtext.min.css">
<script src="<?php echo base_url() ?>assets/plugins/rich_jq_editor/src/jquery.richtext.js"></script>

<!-- editor-->
<script>
    $(document).ready(function () {
        $('.text-description').richText({
            // title
            heading: false,
            // colors
            fontColor: true,
            // uploads
            imageUpload: false,
            fileUpload: false,
            // link
            urls: false,
            // tables
            table: true,
            // code
            removeStyles: false,
            code: false,
            // colors
            colors: [],
            // dropdowns
            fileHTML: '',
            imageHTML: ''
        });
        $('.richText .richText-editor').css('height', '130px');
    });
</script>
