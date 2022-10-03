<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css"> 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <a href="<?php echo base_url();?>admin/email"><i class="fa fa-file-video-o" aria-hidden="true"></i> Email</a>
        <small>Compose New Mail</small>
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
                        <h3 class="box-title">Compose Mail</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="mail_form" action="<?php echo base_url() ?>admin/email/insertnow" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="services">To : Select Services</label>
                                        <select class="form-control" name="services" id="services" required="required">
                                            <option value="" >-- Select Services--</option>
                                            <?php foreach($service_list as $Services){?>
                                            <option value="<?php echo $Services->id; ?>" >T<?php echo $Services->service_name; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="services_status">Select Status</label>
                                        <select class="form-control" name="services_status" id="services_status" required="required">
                                            <option value="" >-- Select Status--</option>
                                            <option value="1" >Actice</option>
                                            <option value="0" >Inactice</option>
                                            <option value="less_than_7day" >Inactive Within (7Days)</option>
                                            <option value="more_than_7day" >Inactive More Than (7Days)</option>
                                         </select>
                                    </div>
                                </div>
                                <div class="col-md-12">     
                                    <!-- Subject-->
                                    <div class="form-group">
                                        <label for="subject">Subject </label>
                                        <input type="text" class="form-control" name="subject" id="subject" required="required">
                                    </div> 
                                    <!-- Short Desc-->
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea rows="8" id="message" name ="message" class="form-control"  required="required" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="attachment_file">Attachment file</label>
                                        <input type="file" id="attachment_file" name ="attachment_file" class="form-control" ><!--required="required"-->
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
<script>
    // Document Validataion
    $(document).ready(function(){
        $("#attachment_file").change(function(){
           var id = "attachment_file";
            var max_size = 5000000;
            file_validation(id,max_size);
        });

        // Form submit
        $("#mail_form").submit(function(){
        
            var form_id = '#mail_form';
            var status = form_validation(form_id);
            if (status == 0)
            {
                return false;
            }
        });

    });
    
  </script>
  <script>
    // Function file Validation

    function file_validation(id,max_size)
    {
        var fuData = document.getElementById(id);
        var FileUploadPath = fuData.value;
        

        if (FileUploadPath == ''){
            alert("Please upload Attachment");
        } 
        else {
            var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "pdf" || Extension == "xlsx" || Extension == "zip"|| Extension == "docx"|| Extension == "jpg"|| Extension == "jpg"|| Extension == "png") {

                    if (fuData.files && fuData.files[0]) {
                        var size = fuData.files[0].size;
                        
                        if(size > max_size){   //1000000 = 1 mb
                            alert("Maximum file size 5 MB");
                            $("#"+id).val('');
                            return;
                        }
                    }

            } 
            else 
            {
                alert("document only allows file types of pdf, xlsx, docx, jpg, jpg , png");
                $("#"+id).val('');
            }
        }   
    }   

    // Function Form Validation
        function form_validation(form_id){
            var status = 1;
            $(form_id+" input").each(function(){
                    var type = $(this).attr('type');
                    var value = $(this).val();
                    var required = $(this).attr("required");
                    if(required == 'required')
                    {
                        if(type == 'text')
                        {
                            if(value == '')
                            {
                                $(this).css('border','1px solid red');
                                status = 0;
                            }
                            else
                            {
                                $(this).css('border','1px solid #d2d6de');
                            }
                        }
                        else if(type == 'email')
                        {
                            
                            var atpos = value.indexOf("@");
                            var dotpos = value.lastIndexOf(".");
                            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=value.length) {
                                $(this).css('border','1px solid red');
                                status = 0;
                            }
                            else
                            {
                                $(this).css('border','1px solid #d2d6de');
                            }
                        }
                    }    
                });
                // Select Box Testing 
                 $(form_id+" select").each(function(){
                  
                    var value = $(this).val();
                    var required = $(this).attr("required");
                    if(required == 'required')
                    {
                        if(value == '')
                        {
                            $(this).css('border','1px solid red');
                            status = 0;
                        }
                        else
                        {
                            $(this).css('border','1px solid #d2d6de');
                        }
                    }    
                    
                 }); 

                 // Textarea Testing 
                 $(form_id+" textarea").each(function(){
                  
                    var value = $(this).val();
                    var required = $(this).attr("required");
                    if(required == 'required')
                    {
                        if(value == '')
                        {
                            $(this).css('border','1px solid red');
                            status = 0;
                        }
                        else
                        {
                            $(this).css('border','1px solid #d2d6de');
                        }
                    }    
                    
                 });
          return status;
        }

  </script>

